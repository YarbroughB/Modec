<?php

return array(
	'router' => array(
		'routes' => array(
			/* Overwrite the home so the index will now be the
			   cms instead of the default splash */
			'home' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route'	=> '/',
					'defaults' => array(
						'controller' => 'Cms\Controller\Index',
						'action'     => 'index',
					),
				),
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Cms\Controller\Index' => 'Cms\Controller\IndexController'
		),
	),
);
