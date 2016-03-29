<?php 
 return array(
	 'service_manager' => array(
         'factories' => array(
             'Blog\Mapper\PostMapperInterface'   => 'Blog\Factory\ZendDbSqlMapperFactory',
			 'Blog\Service\PostServiceInterface' => 'Blog\Factory\PostServiceFactory'
         )
     ),
	 'view_manager' => array(
         'template_path_stack' => array(
             'blog' => __DIR__ . '/../view',
         ),
     ),
	 'controllers' => array(
         'factories' => array(
             'Blog\Controller\List' => 'Blog\Factory\ListControllerFactory',
			 'Blog\Controller\Write' => 'Blog\Factory\WriteControllerFactory',
			 'Blog\Controller\Delete' => 'Blog\Factory\DeleteControllerFactory'
         ),
     ),
     'router' => array(
         'routes' => array(
             'blog' => array(
                 'type' => 'literal',
                 'options' => array(
                     'route'    => '/blog',
                     'defaults' => array(
                         'controller' => 'Blog\Controller\List',
                         'action'     => 'index',
                     ),
                 ),
                 'may_terminate' => true,
                 'child_routes'  => array(
                     'postbyid' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/:blogid',
                             'defaults' => array(
                                 'action' => 'postbyid'
                             ),
                             'constraints' => array(
                                 'blogid' => '[1-9]\d*'
                             ),
                         ),
                     ),
					 'addpost' => array(
                         'type' => 'literal',
                         'options' => array(
                             'route'    => '/addpost',
                             'defaults' => array(
                                 'controller' => 'Blog\Controller\Write',
                                 'action'     => 'addpost'
                             ),
                         ),
                     ),
					 'editpost' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/editpost/:idForBlog',
                             'defaults' => array(
                                 'controller' => 'Blog\Controller\Write',
                                 'action'     => 'editpost'
                             ),
                             'constraints' => array(
                                 'idForBlog' => '\d+'
                             )
                         )
                     ),
					 'deletepost' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '/deletepost/:blogid',
                             'defaults' => array(
                                 'controller' => 'Blog\Controller\Delete',
                                 'action'     => 'deletepost'
                             ),
                             'constraints' => array(
                                 'blogid' => '\d+'
                             )
                         )
                     ),
                 ),
             ),
         ),
     ),
 );
?> 