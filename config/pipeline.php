<?php

return function(\Zend\Expressive\Application $app): void {
    $app->pipe(\Zend\Stratigility\Middleware\OriginalMessages::class);
//    $app->pipe(\Zend\Stratigility\Middleware\ErrorHandler::class);
    $app->pipe(\Middlewares\JsonPayload::class);

    $app->pipe(\Zend\Expressive\Router\Middleware\RouteMiddleware::class);

    $app->pipe(\Zend\Expressive\Router\Middleware\ImplicitHeadMiddleware::class);
    $app->pipe(\Zend\Expressive\Router\Middleware\ImplicitOptionsMiddleware::class);

    $app->pipe(\Zend\Expressive\Router\Middleware\DispatchMiddleware::class);

    $app->pipe(\Zend\Expressive\Handler\NotFoundHandler::class);
};
