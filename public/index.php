<?php

// Make all paths be realitve to the application root.
chdir(dirname(__DIR__));

// Set the Zend Framework Path in the PHP environment.
putenv('ZF2_PATH=./library/');

// Configure the PHP environment to show errors for development purposes.
ini_set('display_errors', 1);  
error_reporting(E_ALL & ~E_NOTICE);

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
