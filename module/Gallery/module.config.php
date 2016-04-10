<?php

return array(
	'controllers' => array(
		'invokables' => array(
			'Gallery\Gallery'       => 'Gallery\Controller\GalleryController',
		),
	),
	
	//! @todo Move the routes to the db?
	'router' => array(
		'routes' => array(
				'gallery' => array(
					'type'     => 'literal',
					'priority' => 100,
					'type'     => 'segment',
						'priority' => 100,
						'options'  => array(
							'route'       => '/gallery[/:action][/:id]',
							'constraints' => array(
								'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id'     => '[0-9]+',
							),
							'defaults'    => array(
								'controller'    => 'Gallery\Gallery',
								'action'        => 'index',
							),
						),
				),
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
			'style/default',
		),
	),
	
);