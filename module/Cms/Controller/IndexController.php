<?php

namespace Cms\Controller;

use Zend\View\Model\ViewModel;

use Core\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
	public function indexAction()
	{
		$view = new ViewModel();
		$view->setTemplate('cms/index');

		return $view;
	}
}
