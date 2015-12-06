<?php

return [
    'dependencies' => [
        'factories' => [
            \Zend\Expressive\Application::class => \Zend\Expressive\Container\ApplicationFactory::class,

            //Cargo UI
            \Codeliner\CargoUI\Main::class => \Codeliner\CargoUI\Container\MainFactory::class,
            \Codeliner\CargoUI\RiotCompiler::class => \Zend\ServiceManager\Factory\InvokableFactory::class,

            //Doctrine
            'doctrine.entity_manager.orm_default' => \Codeliner\CargoBackend\Container\Infrastructure\DoctrineEntityManagerFactory::class,
            \Doctrine\ORM\Mapping\UnderscoreNamingStrategy::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
        ],
        'aliases' => [
            'configuration' => 'config'
        ],
    ]
];
