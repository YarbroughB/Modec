<?php

namespace Core\Controller;

use Zend\Authentication\AuthenticationService;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\AbstractActionController as ZendAbstractActionController;

abstract class AbstractActionController extends ZendAbstractActionController
{
	public function onDispatch(MvcEvent $event)
	{
		// Check that the user is allowed to access the site
		$user = $this->identity();

		if ($user && $user->usergroup->type == 'BANNED') {
			$actionResponse = $this->permissionDenied();
			$event->setResult($actionResponse);
			return $actionResponse;
		}

		// Run the parent dispatch
		return parent::onDispatch($event);
	}

	protected function hasPermission($resource, $privilege = null)
	{
		$acl = $this->event->getViewModel()->acl;
		$user = $this->identity();
		
		if (!$user) {
			// $usergroupsTable = $this->event->getApplication()->getServiceManager()->get('UsergroupsTable');
			// $role = $usergroupsTable->getGuestGroupId();
			$role = 1; // Guest
			//! @todo This should come from a setting of some kind!	
		} else {
			$role = $user->usergroup->id;
		}

		return $acl->isAllowed($role, $resource, $privilege);
	}
	
	protected function permissionDenied()
	{
		$this->response->setStatusCode(403);

		$view = new \Zend\View\Model\ViewModel();
		$view->setTemplate('error/403');

		return $view;
	}
	
	protected function pageNotFound()
	{
		$this->response->setStatusCode(404);
	}
}
