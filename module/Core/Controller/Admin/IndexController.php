<?php

namespace Core\Controller\Admin;

use Zend\View\Model\ViewModel;

class IndexController extends AbstractAdminActionController
{
	public function indexAction()
	{
		// Get the service locator
		$serviceLocator = $this->getServiceLocator();
		
		// Get a list of all the modules that are loaded
		$moduleManager = $serviceLocator->get('ModuleManager');
		$modules = array_keys($moduleManager->getLoadedModules());

		// Render the output
		$view = new ViewModel(array(
			'modules' => $modules
		));

		$view->setTemplate('index');

		return $view;
	}

	
	
	
	
	
	
	
	//! @todo Move everything below this to their own files
	public function usersAction()
	{
		// Check if the user has permission to this action
		if (!$this->hasPermission('admin/users', 'view')) {
			return $this->permissionDenied();
		}

		$view = new ViewModel();
		$view->setTemplate('mockups/users');

		return $view;
	}
	
	public function routesAction()
	{
		// Check if the user has permission to this action
		if (!$this->hasPermission('admin/routes', 'view')) {
			return $this->permissionDenied();
		}

		$view = new ViewModel();
		$view->setTemplate('mockups/routes');

		return $view;
	}
	
	public function settingsAction()
	{
		$view = new ViewModel();
		$view->setTemplate('mockups/settings');

		return $view;
	}
	
	public function resourcesAction()
	{
		$view = new ViewModel();
		$view->setTemplate('mockups/resources');

		return $view;
	}
	
	public function linksAction()
	{
		$view = new ViewModel();
		$view->setTemplate('mockups/links');

		return $view;
	}
}
