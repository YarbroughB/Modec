<?php 
 return array(
	'controllers' => array(
		'invokables' => array(
			'Blog\View'   => 'Blog\Controller\ViewController',
			'Blog\Write'  => 'Blog\Controller\WriteController',
			'Blog\Delete' => 'Blog\Controller\DeleteController',
		),
	),
	'router' => array(
		'routes' => array(
			'blog' => array(
				'type'    => 'literal',
				'options' => array(
					'route'    => '/blog',
					'defaults' => array(
						'controller' => 'Blog\View',
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
								'controller' => 'Blog\Write',
								'action'     => 'add',
							),
						),
					),
					'edit' => array(
						'type' => 'segment',
						'options' => array(
							'route'    => '/edit/[:id]-[:title]',
							'defaults' => array(
								'controller' => 'Blog\Write',
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
								'controller' => 'Blog\Delete',
								'action'     => 'delete',
							),
							'constraints' => array(
								'id'    => '[1-9]\d*',
								'title' => '[a-z0-9_-]*',
							),
						),
					),
				),
			),
		),
	),
);
