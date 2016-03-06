<?php

namespace Core\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;

use Core\Model\User;
use Core\Model\UsersTable;

class AuthController extends AbstractActionController
{
	public function registerAction()
	{
		$auth = new AuthenticationService();

		if ($auth->hasIdentity()) {
			$this->flashMessenger()->addErrorMessage("You are logged in");
			return $this->redirect()->toRoute('home');
		}

		$form = new \Core\Form\RegistrationForm();
		$request = $this->getRequest();

        if ($request->isPost()) {
			$form->setData($request->getPost());
			$form->setInputFilter(
				new \Core\Form\RegistrationFilter($this->getServiceLocator())
			);

			if ($form->isValid()) {
				$data = $form->getData();

				$data['password_salt'] = '';
				
				for ($i = 0; $i < 32; $i++) {
					$data['password_salt'] .= chr(rand(33, 126));
				}

				$data['password'] = md5($data['password'] . $data['password_salt']);

				$user = new User();
				$user->exchangeArray($data);

				$sm = $this->getServiceLocator();
				$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');

				$resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();
				$resultSetPrototype->setArrayObjectPrototype(new User());

				$tableGateway = new \Zend\Db\TableGateway\TableGateway(
					'users', $dbAdapter, null, $resultSetPrototype
				);

				$usersTable = new UsersTable($tableGateway);
				$usersTable->saveUser($user);
			
				$this->flashMessenger()->addSuccessMessage("Registered");

				return $this->redirect()->toRoute('login');
			}
		}

		$view = new ViewModel(array(
			'form' => $form
		));
		
		$view->setTemplate('auth/register');

		return $view;
	}

    public function loginAction()
	{
		$auth = new AuthenticationService();

		if ($auth->hasIdentity()) {
			$this->flashMessenger()->addErrorMessage("You are already logged in");
			return $this->redirect()->toRoute('home');
		}		
		
		$form = new \Core\Form\LoginForm();
		$request = $this->getRequest();

        if ($request->isPost()) {
			$form->setData($request->getPost());
			$form->setInputFilter(
				new \Core\Form\LoginFilter($this->getServiceLocator())
			);

			if ($form->isValid()) {
				$data = $form->getData();

				$sm = $this->getServiceLocator();
				$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
				$authAdapter = new \Zend\Authentication\Adapter\DbTable(
					$dbAdapter, 'users', 'username', 'password', "MD5(CONCAT(?, password_salt))"
				);

				$authAdapter->setIdentity($data['username']);
				$authAdapter->setCredential($data['password']);

				$result = $auth->authenticate($authAdapter);

				switch ($result->getCode()) {
					case Result::FAILURE_IDENTITY_NOT_FOUND:
						// do stuff for nonexistent identity
						$this->flashMessenger()->addErrorMessage("FAILURE_IDENTITY_NOT_FOUND");
						break;
					case Result::FAILURE_CREDENTIAL_INVALID:
						// do stuff for invalid credential
						$this->flashMessenger()->addErrorMessage("FAILURE_CREDENTIAL_INVALID");
						break;
					case Result::SUCCESS:
						$storage = $auth->getStorage();
						$storage->write($authAdapter->getResultRowObject(
							null,
							'password'
						));

						if ($data['rememberme']) {
							$sessionManager = new \Zend\Session\SessionManager();
							$sessionManager->rememberMe(1209600); // 14 days
						}

						$this->flashMessenger()->addSuccessMessage("You were logged in");

						return $this->redirect()->toRoute('home');
					default:
						// do stuff for other failure
						$this->flashMessenger()->addErrorMessage("OTHER_FAILURE");
						break;
				}
			}
		}

		$view = new ViewModel(array(
			'form' => $form
		));
		
		$view->setTemplate('auth/login');

		return $view;
	}
	
	public function logoutAction()
	{
		$auth = new AuthenticationService();

		if ($auth->hasIdentity()) {
			$auth->clearIdentity();

			$sessionManager = new \Zend\Session\SessionManager();
			$sessionManager->forgetMe();

			$this->flashMessenger()->addSuccessMessage("You were logged out");
		} else {
			$this->flashMessenger()->addErrorMessage("You were not logged in");
		}

		return $this->redirect()->toRoute('home');
	}	
}