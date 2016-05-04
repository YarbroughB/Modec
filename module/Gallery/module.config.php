<?php

return array(
	'controllers' => array(
		'invokables' => array(
			'Gallery\View'   => 'Gallery\Controller\ViewController',
			'Gallery\Write'  => 'Gallery\Controller\WriteController',
			'Gallery\Delete' => 'Gallery\Controller\DeleteController',
		),
	),
	'router' => array(
		'routes' => array(
			'gallery' => array(
				'type'    => 'literal',
				'options' => array(
					'route'    => '/gallery',
					'defaults' => array(
						'controller' => 'Gallery\View',
						'action'     => 'index',
					),
				),
				'may_terminate' => true,
				'child_routes'  => array(
					'view' => array(
						'type' => 'segment',
						'options' => array(
							'route'    => '/[:id]-[:title]',
							'defaults' => array(
								'action' => 'view',
							),
							'constraints' => array(
								'id'    => '[1-9]\d*',
								'title' => '[a-z0-9_-]*',
							),
						),
					),
					'add' => array(
						'type'    => 'literal',
						'options' => array(
							'route'    => '/add',
							'defaults' => array(
								'controller' => 'Gallery\Write',
								'action'     => 'add',
							),
						),
					),
					'edit' => array(
						'type' => 'segment',
						'options' => array(
							'route'    => '/edit/[:id]-[:title]',
							'defaults' => array(
								'controller' => 'Gallery\Write',
								'action'     => 'edit',
							),
							'constraints' => array(
								'id'    => '[1-9]\d*',
								'title' => '[a-z0-9_-]*',
							),
						),
					),
					'delete' => array(
						'type' => 'segment',
						'options' => array(
							'route'    => '/delete/[:id]-[:title]',
							'defaults' => array(
								'controller' => 'Gallery\Delete',
								'action'     => 'delete',
							),
							'constraints' => array(
								'id'    => '[1-9]\d*',
								'title' => '[a-z0-9_-]*',
							),
						),
					),
					'add_comment' => array(
						'type' => 'segment',
						'options' => array(
							'route'    => '/add_comment/:imageid',
							'defaults' => array(
							  'controller' => 'Gallery\Write',
								'action' => 'addComment',
							),
							'constraints' => array(
								'imageid'    => '[1-9]\d*',
							),
						),
					),
				),
			),
		),
	),
);
