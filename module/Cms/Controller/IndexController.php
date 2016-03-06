<?php

namespace Cms\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
	public function indexAction()
	{
		$view = new ViewModel();
		$view->setTemplate('cms/index');

		return $view;
	}
}