<?php

namespace Core\Navigation\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Navigation\Service\AbstractNavigationFactory as ZendAbstractNavigationFactory;

abstract class AbstractNavigationFactory extends ZendAbstractNavigationFactory
{
	protected function getPages(ServiceLocatorInterface $serviceLocator)
	{
		if (!isset($this->pages)) {
			// Get the loaded modules
			$moduleManager = $serviceLocator->get('ModuleManager');
			$modules = array_keys($moduleManager->getLoadedModules());
		
			// Fetch the navigation items from the db
			$navigationTable = $serviceLocator->get('NavigationTable');
			$navigationItems = $navigationTable->fetchMenu($this->getName(), $modules);

			// Build the navigation config array
			$navigation = array();
			
			foreach ($navigationItems as $element) {			
				$item = isset($navigation[$element->id]) ? $navigation[$element->id] : array();

				$item['label']     = $element->label;
				$item['order']     = $element->order;

				$item['route']     = $element->route;
				$item['params']    = $element->params;
				$item['uri']       = $element->uri;

				$item['resource']  = $element->resource;
				$item['privilege'] = $element->privilege;

				if (!isset($element->parent)) {
					$navigation[$element->id] = $item;
				} else {
					if (!isset($navigation[$element->parent])) {
						$navigation[$element->parent] = array(
							'pages' => array()
						);
					} else if (!isset($navigation[$element->parent]['pages'])) {
						$navigation[$element->parent]['pages'] = array();
					}

					$navigation[$element->parent]['pages'][$element->id] = $item;
				}
			}
			
			// Build the pages
			$application = $serviceLocator->get('Application');
			$routeMatch  = $application->getMvcEvent()->getRouteMatch();
			$router      = $application->getMvcEvent()->getRouter();
			$pages       = $this->getPagesFromConfig($navigation);

			$this->pages = $this->injectComponents($pages, $routeMatch, $router);
		}

		return $this->pages;
	}
}
