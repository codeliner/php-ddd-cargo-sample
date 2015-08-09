<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

//we activate full error reporting for our sample, to ease support
error_reporting(E_ALL ^ E_STRICT);
ini_set('display_errors', 1);

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
require 'vendor/autoload.php';

$services = new \Zend\ServiceManager\ServiceManager(new \Zend\ServiceManager\Config(require 'config/services.php'));

$app = $services->get('Zend\Expressive\Application');

$cargoBackend = $services->get('cargo.backend');

$app->pipe('/api', $cargoBackend);

$app->run();