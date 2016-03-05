<?php

return array(
	'modules' => array(
		'Application',
	),
	'module_listener_options' => array(
		'module_paths' => array(
			'./module'
		),
		'config_glob_paths' => array(
			'config/autoload/{{,*.}global,{,*.}local}.php',
		),
	),
);
