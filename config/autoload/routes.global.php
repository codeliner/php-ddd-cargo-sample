<?php

return [
    'dependencies' => [
        'factories' => [
            Zend\Expressive\Router\AuraRouter::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],
        'aliases' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\AuraRouter::class,
        ],
    ],
    //API Routes, child routes of /api
    'routes' => [
        [
            'path' => '/locations',
            'middleware' => \Codeliner\CargoBackend\Application\Action\GetLocations::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'path' => '/cargos',
            'middleware' => \Codeliner\CargoBackend\Application\Action\CreateCargo::class,
            'allowed_methods' => ['POST'],
        ],
    ],
];
