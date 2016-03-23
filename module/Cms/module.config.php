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
						'controller' => 'Cms\CatchAll',
						'action'     => 'catchAll',
					),
				),
			),
			/* CatchAll route for the CMS. */
			'cms' => array(
				'type'     => 'Segment',
				'priority' => -1000, //! @note Given very low priority to not conflict with other routes!
				'options'  => array(
					'route'       => '/:page',
					'constraints' => array(
						'page' => '.*'
					),
					'defaults'    => array(
						'controller' => 'Cms\CatchAll',
						'action'     => 'catchAll',
					),
				),
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Cms\CatchAll' => 'Cms\Controller\CatchAllController'
		),
	),
);
