<?php

namespace Core\Controller\Admin;

use Zend\Mvc\MvcEvent;

use Core\Controller\AbstractActionController;

abstract class AbstractAdminActionController extends AbstractActionController
{
	public function onDispatch(MvcEvent $event)
	{
		// Redirect to login if the user is not logged in
		$user = $this->identity();

		if (!$user) {
			return $this->redirect()->toRoute('login');
		}
		
		// Check that the user is allowed to access the admin cp
		if ($user->usergroup->type != 'ADMIN') {
			$actionResponse = $this->permissionDenied();
			$event->setResult($actionResponse);
			return $actionResponse;
		}

		// Set the admin template stack path
		$serviceManager = $event->getApplication()->getServiceManager();

		$templatePathResolver = $serviceManager->get('Zend\View\Resolver\TemplatePathStack');
		$templatePathResolver->setPaths(array('styles/admin'));
	
		// Set the admin layout
		$this->layout('wrapper.phtml');

		// Run the parent dispatch
		return parent::onDispatch($event);
	}
}
