<?php

namespace Core\Controller;

use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
	public function indexAction()
	{
		$view = new ViewModel();
		$view->setTemplate('index');

		return $view;
	}
}
