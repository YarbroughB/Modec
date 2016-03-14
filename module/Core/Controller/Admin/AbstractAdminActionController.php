<?php

namespace Core\Controller\Admin;

use Zend\Mvc\MvcEvent;

use Zend\Mvc\Controller\AbstractActionController;

abstract class AbstractAdminActionController extends AbstractActionController
{
    public function onDispatch(MvcEvent $e)
    {
		// Redirect to login if the user is not logged in
		if (!$this->identity()) {
			return $this->redirect()->toRoute('login');
		}

		// Set the admin template stack path
		$serviceManager = $e->getApplication()->getServiceManager();

		$templatePathResolver = $serviceManager->get('Zend\View\Resolver\TemplatePathStack');
		$templatePathResolver->setPaths(array('styles/admin'));
	
		// Set the admin layout
		$this->layout('wrapper.phtml');
		
		// Run the dispatch
		return parent::onDispatch($e);
    }
}
