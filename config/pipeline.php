<?php

return function(\Zend\Expressive\Application $app) {
    $app->pipe(\Zend\Stratigility\Middleware\OriginalMessages::class);
    $app->pipe(\Zend\Stratigility\Middleware\ErrorHandler::class);
    $app->pipe(\Psr7Middlewares\Middleware\Payload::class);

    $app->pipeRoutingMiddleware();

    $app->pipe(\Zend\Expressive\Middleware\ImplicitHeadMiddleware::class);
    $app->pipe(\Zend\Expressive\Middleware\ImplicitOptionsMiddleware::class);

    $app->pipeDispatchMiddleware();

    $app->pipe(\Zend\Expressive\Middleware\NotFoundHandler::class);
};
