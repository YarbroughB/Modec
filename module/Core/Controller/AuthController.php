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
		// Fetch the authentication service
		$auth = new AuthenticationService();

		// Check if the user is logged in
		if ($auth->hasIdentity()) {
			$this->flashMessenger()->addErrorMessage("You are logged in!");
			return $this->redirect()->toRoute('home');
		}

		// Create the form
		$form = new \Core\Form\RegistrationForm();
		$request = $this->getRequest();

		// Process POST requests
        if ($request->isPost()) {
			// Setup the form data and input filter
			$form->setData($request->getPost());
			$form->setInputFilter(
				new \Core\Form\RegistrationFilter($this->getServiceLocator())
			);

			// Check if the form is valid
			if ($form->isValid()) {
				// Get the data from the form
				$data = $form->getData();

				// Create the password salt
				$data['password_salt'] = '';
				
				for ($i = 0; $i < 32; $i++) {
					$data['password_salt'] .= chr(rand(33, 126));
				}

				// Encrypt the password
				$data['password'] = md5($data['password'] . $data['password_salt']);

				// Create the user
				$user = new User();
				$user->exchangeArray($data);

				// Add the user to the database
				$usersTable = $this->getServiceLocator()->get('Core\Model\UsersTable');
				$usersTable->saveUser($user);

				// Update the user and redirect
				$this->flashMessenger()->addSuccessMessage("Registered");

				return $this->redirect()->toRoute('login');
			}
		}

		// Display the form
		$view = new ViewModel(array(
			'form' => $form
		));
		
		$view->setTemplate('auth/register');

		return $view;
	}

    public function loginAction()
	{
		// Fetch the authentication service
		$auth = new AuthenticationService();

		// Check if the user is logged in
		if ($auth->hasIdentity()) {
			$this->flashMessenger()->addErrorMessage("You are already logged in!");
			return $this->redirect()->toRoute('home');
		}

		// Create the form		
		$form = new \Core\Form\LoginForm();
		$request = $this->getRequest();

		// Process POST requests
        if ($request->isPost()) {
			// Setup the form data and input filter
			$form->setData($request->getPost());
			$form->setInputFilter(
				new \Core\Form\LoginFilter($this->getServiceLocator())
			);

			// Check if the form is valid
			if ($form->isValid()) {
				// Get the data from the form
				$data = $form->getData();

				// Fetch the db adapter
				$serviceLocator = $this->getServiceLocator();
				$dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
				
				// Create the authentication adapter
				$authAdapter = new \Zend\Authentication\Adapter\DbTable(
					$dbAdapter, 'users', 'username', 'password', "MD5(CONCAT(?, password_salt))"
				);

				// Setup the authentication adapter
				$authAdapter->setIdentity($data['username']);
				$authAdapter->setCredential($data['password']);

				// Retrieve the result of the authentication
				$result = $auth->authenticate($authAdapter);

				// Process the result of the authentication
				switch ($result->getCode()) {
					case Result::SUCCESS:
						$storage = $auth->getStorage();
						$storage->write(new User($authAdapter->getResultRowObject(
							null,
							array('password', 'password_salt')
						)));

						if ($data['rememberme']) {
							$sessionManager = new \Zend\Session\SessionManager();
							$sessionManager->rememberMe(1209600); // 14 days
						}

						$this->flashMessenger()->addSuccessMessage("You have successfully logged in!");

						return $this->redirect()->toRoute('home');
					case Result::FAILURE_IDENTITY_NOT_FOUND:
					case Result::FAILURE_CREDENTIAL_INVALID:
						$this->flashMessenger()->addErrorMessage("Invalid Username and/or Password!");
						break;
					default:
						$this->flashMessenger()->addErrorMessage("An unknown error occurred.");
						break;
				}
			}
		}

		// Display the form
		$view = new ViewModel(array(
			'form' => $form
		));
		
		$view->setTemplate('auth/login');

		return $view;
	}
	
	public function logoutAction()
	{
		// Fetch the authentication service
		$auth = new AuthenticationService();

		// Check if the user is logged in
		if ($auth->hasIdentity()) {
			$auth->clearIdentity();

			$sessionManager = new \Zend\Session\SessionManager();
			$sessionManager->forgetMe();

			$this->flashMessenger()->addSuccessMessage("You were logged out!");
		} else {
			$this->flashMessenger()->addErrorMessage("You are not logged in!");
		}

		return $this->redirect()->toRoute('home');
	}	
}