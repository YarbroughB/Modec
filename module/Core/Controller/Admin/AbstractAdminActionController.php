<?php

namespace Core\Controller\Admin;

use Zend\Mvc\MvcEvent;

use Core\Controller\AbstractActionController;

abstract class AbstractAdminActionController extends AbstractActionController
{
	public function onDispatch(MvcEvent $event)
	{
		// Run the parent dispatch
		parent::onDispatch($event);

		// Redirect to login if the user is not logged in
		if (!$this->identity()) {
			return $this->redirect()->toRoute('login');
		}

		// Set the admin template stack path
		$serviceManager = $event->getApplication()->getServiceManager();

		$templatePathResolver = $serviceManager->get('Zend\View\Resolver\TemplatePathStack');
		$templatePathResolver->setPaths(array('styles/admin'));
	
		// Set the admin layout
		$this->layout('wrapper.phtml');
		
		// Return the dispatch result
		return $event->getResult($actionResponse);
	}
}
