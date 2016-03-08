<?php

return array(
	//! @todo Move the routes to the db?
	'router' => array(
		'routes' => array(
			'home' => array(
				'type'    => 'Literal',
				'options' => array(
					'route'	=> '/',
					'defaults' => array(
						'controller' => 'Core\Index',
						'action'     => 'index',
					),
				),
			),
			'register' => array(
				'type'    => 'Literal',
				'options' => array(
					'route'    => '/register',
					'defaults' => array(
						'controller'    => 'Core\Auth',
						'action'        => 'register',
					),
				),
			),
			'login' => array(
				'type'    => 'Literal',
				'options' => array(
					'route'    => '/login',
					'defaults' => array(
						'controller'    => 'Core\Auth',
						'action'        => 'login',
					),
				),
			),
			'logout' => array(
				'type'    => 'Literal',
				'options' => array(
					'route'    => '/logout',
					'defaults' => array(
						'controller'    => 'Core\Auth',
						'action'        => 'logout',
					),
				),
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Core\Index' => 'Core\Controller\IndexController',
            'Core\Auth'  => 'Core\Controller\AuthController',	
		),
	),
	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions'       => true,
		'doctype'                  => 'HTML5',
		'not_found_template'       => 'error/404',
		'exception_template'       => 'error/exception',
		'template_map' => array(
			'layout/layout'           => __DIR__ . '/../../styles/default/wrapper.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../../styles/default',
		),
	),
    'service_manager' => array(
        'factories' => array(
			'primary' => 'Core\Navigation\Service\PrimaryNavigationFactory',
			'secondary' => 'Core\Navigation\Service\SecondaryNavigationFactory',
			'footer' => 'Core\Navigation\Service\FooterNavigationFactory',
			'user' => 'Core\Navigation\Service\UserNavigationFactory',
        ),
		'aliases' => array(
			'Zend\Authentication\AuthenticationService' => 'AuthService',
		),
		'invokables' => array(
			'AuthService' => 'Zend\Authentication\AuthenticationService',
		),
    ),
);
