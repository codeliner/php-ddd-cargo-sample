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
    //API Routes
    'routes' => [

    ],
];
