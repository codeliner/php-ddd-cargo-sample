<?php
/**
 * Expressive programmatic pipeline configuration
 */

use Zend\Expressive\Container\ErrorHandlerFactory;
use Zend\Expressive\Container\ErrorResponseGeneratorFactory;
use Zend\Expressive\Container\NotFoundHandlerFactory;
use Zend\Expressive\Handler\NotFoundHandler;
use Zend\Expressive\Middleware\ErrorResponseGenerator;
use Zend\Expressive\Router\Middleware\ImplicitHeadMiddleware;
use Zend\Expressive\Router\Middleware\ImplicitHeadMiddlewareFactory;
use Zend\Expressive\Router\Middleware\ImplicitOptionsMiddleware;
use Zend\Expressive\Router\Middleware\ImplicitOptionsMiddlewareFactory;
use Zend\Stratigility\Middleware\ErrorHandler;
use Zend\Stratigility\Middleware\OriginalMessages;

return [
    'dependencies' => [
        'invokables' => [
            OriginalMessages::class => OriginalMessages::class,
        ],
        'factories' => [
            ErrorHandler::class => ErrorHandlerFactory::class,
            ImplicitHeadMiddleware::class => ImplicitHeadMiddlewareFactory::class,
            ImplicitOptionsMiddleware::class => ImplicitOptionsMiddlewareFactory::class,
            // Override the following in a local config file to use
            // Zend\Expressive\Container\WhoopsErrorResponseGeneratorFactory
            // in order to use Whoops for development error handling.
            ErrorResponseGenerator::class => ErrorResponseGeneratorFactory::class,
            // Override the following to use an alternate "not found" delegate.
            NotFoundHandler::class => NotFoundHandlerFactory::class,
        ],
    ],
];
