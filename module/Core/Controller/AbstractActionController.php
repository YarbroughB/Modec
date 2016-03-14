<?php

namespace Core\Controller;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\AbstractActionController as ZendAbstractActionController;

abstract class AbstractActionController extends ZendAbstractActionController
{
	public function onDispatch(MvcEvent $event)
	{
		// Run the parent dispatch
		parent::onDispatch($event);

		// Check if the user is logged in
		if ($user = $this->identity()) {
			// Grab the user's info from the db to ensure it's fresh
			$usersTable = $this->getServiceLocator()->get('Core\Model\UsersTable');
			$user = $usersTable->getUser($user->userid);

			$auth = new AuthenticationService();
			$storage = $auth->getStorage();
			$storage->write($user);
		}

		// Return the dispatch result
		return $event->getResult($actionResponse);
	}
}
