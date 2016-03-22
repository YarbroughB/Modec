<?php

namespace Cms\Controller;

use Zend\View\Model\ViewModel;

use Core\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
	public function indexAction()
	{
		if (!$this->hasPermission('cms', 'view')) {
			return $this->permissionDenied();
		}

		$view = new ViewModel();
		$view->setTemplate('cms/index');

		return $view;
	}
}
