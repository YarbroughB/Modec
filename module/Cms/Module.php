<?php

namespace Cms;

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
}
