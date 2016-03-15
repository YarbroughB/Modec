<?php

namespace Core;

class Module
{
	public function getConfig()
	{	
		return include __DIR__ . '/module.config.php';
	}

	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__,
				),
			),
		);
	}

	public function getServiceConfig()
	{
		return array(
			'factories' => array(
				'NavigationTable' => 'Core\Db\NavigationTableFactory',
				'UsersTable'      => 'Core\Db\UsersTableFactory',
				'UsergroupsTable' => 'Core\Db\UsergroupsTableFactory',
			),
		);
	}
}
