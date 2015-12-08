<?php

return [
    'dependencies' => [
        'aliases' => [
            'Zend\Expressive\Whoops' => Whoops\Run::class,
            'Zend\Expressive\WhoopsPageHandler' => Whoops\Handler\PrettyPageHandler::class,
        ],
        'factories' => [
            'Zend\Expressive\FinalHandler' => Zend\Expressive\Container\WhoopsErrorHandlerFactory::class,
            Whoops\Run::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            Whoops\Handler\PrettyPageHandler::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],
    ],
];
