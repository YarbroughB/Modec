<?php

namespace Core\Controller;

use Zend\View\Model\ViewModel;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;

use Core\Model\User;
use Core\Db\UsersTable;

class AuthController extends AbstractActionController
{
	public function registerAction()
	{
		// Fetch the authentication service
		$auth = new AuthenticationService();

		// Check if the user is logged in
		if ($auth->hasIdentity()) {
			$this->flashMessenger()->addSuccessMessage("You are already registered!");
			return $this->redirect()->toRoute('home');
		}

		// Create the form
		$form = new \Core\Form\RegistrationForm();
		$form->setAttribute('action', $this->url()->fromRoute('register'));
		
		// Process POST requests
		$request = $this->getRequest();

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

				// Set the default usergroup
				$data['usergroup'] = 2;  // Registered Users
				//! @todo This should come from a setting of some kind!

				// Create the user
				$user = new User();
				$user->exchangeArray($data);

				// Add the user to the database
				$usersTable = $this->getServiceLocator()->get('UsersTable');
				$usersTable->addUser($user);

				// Update the user and redirect
				$this->flashMessenger()->addSuccessMessage("You have successfully registered!");

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
		$form->setAttribute('action', $this->url()->fromRoute('login'));
		
		// Set the referer in the form
		$request = $this->getRequest();
		$referer = $request->getHeader('Referer');
		
		if ($referer) {
			$host = $request->getUri()->getHost();
			
			if ($host == $referer->uri()->getHost()) {
				$form->setData(array(
					'referer' => $referer->uri()->getPath()
				));
			}
		}

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
				$dbAdapter = $serviceLocator->get('DbAdapter');
				
				// Create the authentication adapter
				$authAdapter = new \Zend\Authentication\Adapter\DbTable(
					$dbAdapter, 'users', 'username', 'password', "MD5(CONCAT(?, passwordSalt))"
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
							array('password', 'passwordSalt')
						)));

						if ($data['rememberme']) {
							$sessionManager = new \Zend\Session\SessionManager();
							$sessionManager->rememberMe(1209600); // 14 days
						}

						$this->flashMessenger()->addSuccessMessage("You have successfully logged in!");

						if (!empty($data['referer'])) {
							return $this->redirect()->toUrl($data['referer']);
						}

						return $this->redirect()->toRoute('home');
					case Result::FAILURE_IDENTITY_NOT_FOUND:
					case Result::FAILURE_CREDENTIAL_INVALID:
						$error = "Invalid Username and/or Password!";
						break;
					default:
						$error = "An unknown error occurred.";
						break;
				}
			} else {
				$error = "Username and Password are both required!";
			}
		}

		// Display the form
		$view = new ViewModel(array(
			'form' => $form,
			'error' => $error
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