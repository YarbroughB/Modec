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

	
	
	
	
	
	
	
	// All the ones below this should be their own files, but for now this will do
	public function usersAction()
	{
		$view = new ViewModel();
		$view->setTemplate('mockups\users');

		return $view;
	}
	
	public function routesAction()
	{
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
