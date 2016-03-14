<?php

namespace Core\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminController extends AbstractActionController
{
	public function indexAction()
	{
		//Dashboard
		$view = new ViewModel();
		$view->setTemplate('admin\index');

		return $view;
	}
	
	public function usersAction()
	{
		$view = new ViewModel();
		$view->setTemplate('admin\users');

		return $view;
	}
	
	public function routesAction()
	{
		$view = new ViewModel();
		$view->setTemplate('admin\routes');

		return $view;
	}
	
	public function settingsAction()
	{
		$view = new ViewModel();
		$view->setTemplate('admin\settings');

		return $view;
	}
	
	public function resourcesAction()
	{
		$view = new ViewModel();
		$view->setTemplate('admin\resources');

		return $view;
	}
	
	public function linksAction()
	{
		$view = new ViewModel();
		$view->setTemplate('admin\links');

		return $view;
	}
}
