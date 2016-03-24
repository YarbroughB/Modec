<?php

require_once './library/Zend/Loader/AutoloaderFactory.php';

Zend\Loader\AutoloaderFactory::factory(array(
	'Zend\Loader\StandardAutoloader' => array(
		'autoregister_zf' => true
	)
));
