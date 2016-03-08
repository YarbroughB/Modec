<?php

return array(
	'router' => array(
		'routes' => array(
			/* Overwrite the home so the index will now be the
			   cms instead of the default splash */
			'home' => array(
				'type' => 'Literal',
				'options' => array(
					'route'	=> '/',
					'defaults' => array(
						'controller' => 'Cms\Index',
						'action'     => 'index',
					),
				),
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Cms\Index' => 'Cms\Controller\IndexController'
		),
	),
);
