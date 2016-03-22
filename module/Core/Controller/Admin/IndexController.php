<?php

namespace Core\Controller\Admin;

use Zend\View\Model\ViewModel;

class IndexController extends AbstractAdminActionController
{
	public function indexAction()
	{
		$view = new ViewModel();
		$view->setTemplate('index');

		return $view;
	}

	
	
	
	
	
	
	
	//! @todo Move everything below this to their own files
	public function usersAction()
	{
		if (!$this->hasPermission('admin/users', 'view')) {
			return $this->permissionDenied();
		}

		$view = new ViewModel();
		$view->setTemplate('mockups/users');

		return $view;
	}
	
	public function routesAction()
	{
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
