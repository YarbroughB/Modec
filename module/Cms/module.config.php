<?php

return array(
	'router' => array(
		'routes' => array(
			/* Overwrite the home so the index will now be the
			   cms instead of the default splash. */
			'home' => array(
				'type'     => 'Literal',
				'priority' => 1000,
				'options'  => array(
					'route'    => '/',
					'defaults' => array(
						'controller' => 'Cms\Index',
						'action'     => 'index',
					),
				),
			),
			/* Regular CMS route for links that should take you to
			   cms instead of the home page incase the cms ever gets
			   moved to not being the homepage anymore. */
			'cms' => array(
				'type'     => 'Literal',
				'priority' => 100,
				'options'  => array(
					'route'    => '/',
					'defaults' => array(
						'controller' => 'Cms\Index',
						'action'     => 'index',
					),
				),
			),
			/* Catchall route for the CMS. */
			'cmsPage' => array(
				'type'     => 'Segment',
				'priority' => -1000, //! @note Given very low priority to not conflict with other routes!
				'options'  => array(
					'route'       => '/:page',
					'constraints' => array(
						'page' => '.*'
					),
					'defaults'    => array(
						'controller' => 'Cms\Index',
						'action'     => 'page',
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
