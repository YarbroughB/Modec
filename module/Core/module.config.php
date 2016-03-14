<?php

return array(
	//! @todo Move the routes to the db?
	'router' => array(
		'routes' => array(
			'home' => array(
				'type'    => 'literal',
				'options' => array(
					'route'	=> '/',
					'defaults' => array(
						'controller' => 'Core\Index',
						'action'     => 'index',
					),
				),
			),
			'register' => array(
				'type'    => 'literal',
				'options' => array(
					'route'    => '/register',
					'defaults' => array(
						'controller'    => 'Core\Auth',
						'action'        => 'register',
					),
				),
			),
			'login' => array(
				'type'    => 'literal',
				'options' => array(
					'route'    => '/login',
					'defaults' => array(
						'controller'    => 'Core\Auth',
						'action'        => 'login',
					),
				),
			),
			'logout' => array(
				'type'    => 'literal',
				'options' => array(
					'route'    => '/logout',
					'defaults' => array(
						'controller'    => 'Core\Auth',
						'action'        => 'logout',
					),
				),
			),
			'admin' => array(
				'type'    => 'literal',
				'options' => array(
					'route'    => '/admin',
					'defaults' => array(
						'controller'    => 'Core\Admin\Index',
						'action'        => 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'users' => array(
						'type'    => 'segment',
						'options' => array(
							'route'       => '/users[/:action]',
							'constraints' => array(
								'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
							),
							'defaults'    => array(
								'controller'    => 'Core\Admin\Index',
								'action'        => 'users',
							),
						),
					),
					'routes' => array(
						'type'    => 'literal',
						'options' => array(
							'route'       => '/routes',
							'defaults'    => array(
								'controller'    => 'Core\Admin\Index',
								'action'        => 'routes',
							),
						),
					),
					'settings' => array(
						'type'    => 'literal',
						'options' => array(
							'route'       => '/settings',
							'defaults'    => array(
								'controller'    => 'Core\Admin\Index',
								'action'        => 'settings',
							),
						),
					),
					'resources' => array(
						'type'    => 'literal',
						'options' => array(
							'route'       => '/resources',
							'defaults'    => array(
								'controller'    => 'Core\Admin\Index',
								'action'        => 'resources',
							),
						),
					),
					'links' => array(
						'type'    => 'literal',
						'options' => array(
							'route'       => '/links',
							'defaults'    => array(
								'controller'    => 'Core\Admin\Index',
								'action'        => 'links',
							),
						),
					),
				),
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Core\Index'       => 'Core\Controller\IndexController',
			'Core\Auth'        => 'Core\Controller\AuthController',
			'Core\Admin\Index' => 'Core\Controller\Admin\IndexController',
		),
	),
	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions'       => true,
		'doctype'                  => 'HTML5',
		'not_found_template'       => 'error/404',
		'exception_template'       => 'error/exception',
		'template_map' => array(
			'layout/layout'        => 'styles/default/wrapper.phtml',
		),
		'template_path_stack' => array(
			'styles/default',
		),
	),
	'view_helpers' => array(
		'invokables'=> array(
			'FormHasErrors' => 'Core\Form\View\Helper\FormHasErrors',
		)
	),
    'service_manager' => array(
        'factories' => array(
			'Primary'   => 'Core\Navigation\Service\PrimaryNavigationFactory',
			'Secondary' => 'Core\Navigation\Service\SecondaryNavigationFactory',
			'Footer'    => 'Core\Navigation\Service\FooterNavigationFactory',
			'User'      => 'Core\Navigation\Service\UserNavigationFactory',
			'Admin'     => 'Core\Navigation\Service\AdminNavigationFactory',
        ),
		'aliases' => array(
			'Zend\Authentication\AuthenticationService' => 'AuthService',
		),
		'invokables' => array(
			'AuthService' => 'Zend\Authentication\AuthenticationService',
		),
    ),
	'navigation' => array(
		'admin' => array(
			array(
				'label' => 'Dashboard',
				'route' => 'admin',
				'order' => 100,
			),
			array(
				'label' => 'Users',
				'route' => 'admin/users',
				'order' => 200,
			),
			array(
				'label' => 'Routes',
				'route' => 'admin/routes',
				'order' => 300,
			),
			array(
				'label' => 'Settings',
				'route' => 'admin/settings',
				'order' => 400,
			),
			array(
				'label' => 'Resources',
				'route' => 'admin/resources',
				'order' => 500,
			),
			array(
				'label' => 'Links',
				'route' => 'admin/links',
				'order' => 600,
			),
		),
	),
);
