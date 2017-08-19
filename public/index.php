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
require 'vendor/autoload.php';

$container = require 'config/container.php';

$app = new \Zend\Stratigility\MiddlewarePipe();

$app->raiseThrowables();

//CargoUI route
$app->pipe(
    '/',
    function(\Psr\Http\Message\ServerRequestInterface $request,
             \Psr\Http\Message\ResponseInterface $response,
             callable $next = null) use ($container) {
        if ($request->getUri()->getPath() === "/") {
            /** @var $cargoUi \Codeliner\CargoUI\Main::class */
            $cargoUi = $container->get(\Codeliner\CargoUI\Main::class);

            return $cargoUi($request, $response, $next);
        }

        return $next($request, $response);
    }
);

$cargoBackend = $container->get('Codeliner\CargoBackend');

$app->pipe('/api', $cargoBackend);

$server = \Zend\Diactoros\Server::createServer($app,
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);
$server->listen(new \Zend\Stratigility\NoopFinalHandler());