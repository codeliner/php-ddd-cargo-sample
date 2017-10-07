<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

//we activate full error reporting for our sample, to ease support
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
require __DIR__ .'/../vendor/autoload.php';

(function () {
    /** @var \Interop\Container\ContainerInterface $container */
    $container = (require __DIR__ .'/../config/container.php')(require __DIR__ .'/../config/config.php');
    /** @var \Zend\Expressive\Application $app */
    $app = $container->get(\Zend\Expressive\Application::class);
    // Import programmatic/declarative middleware pipeline and routing
    // configuration statements
    (require __DIR__ .'/../config/pipeline.php')($app);
    (require __DIR__ .'/../config/routes.php')($app);
    $app->run();
})();
