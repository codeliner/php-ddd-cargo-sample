<?php

return [
    'dependencies' => [
        'factories' => [
            //Cargo UI
            \Codeliner\CargoUI\Main::class => \Codeliner\CargoUI\Container\MainFactory::class,
            \Codeliner\CargoUI\RiotCompiler::class => \Zend\ServiceManager\Factory\InvokableFactory::class,

            //Cargo Backend
            'Codeliner\CargoBackend' => \Zend\Expressive\Container\ApplicationFactory::class,

              //Actions
            \Codeliner\CargoBackend\Http\Action\GetLocations::class => \Codeliner\CargoBackend\Infrastructure\Container\Application\Action\BookingActionFactory::class,
            \Codeliner\CargoBackend\Http\Action\GetRouteCandidates::class => \Codeliner\CargoBackend\Infrastructure\Container\Application\Action\BookingActionFactory::class,
            \Codeliner\CargoBackend\Http\Action\CreateCargo::class => \Codeliner\CargoBackend\Infrastructure\Container\Application\Action\BookingActionFactory::class,
            \Codeliner\CargoBackend\Http\Action\GetCargos::class => \Codeliner\CargoBackend\Infrastructure\Container\Application\Action\BookingActionFactory::class,
            \Codeliner\CargoBackend\Http\Action\GetCargo::class => \Codeliner\CargoBackend\Infrastructure\Container\Application\Action\BookingActionFactory::class,
            \Codeliner\CargoBackend\Http\Action\UpdateCargo::class => \Codeliner\CargoBackend\Infrastructure\Container\Application\Action\BookingActionFactory::class,

              //Action Helper middleware
            \Psr7Middlewares\Middleware\Payload::class => \Codeliner\CargoBackend\Infrastructure\Container\Application\Action\PayloadParserFactory::class,

              //Application
            \Codeliner\CargoBackend\Application\Booking\BookingService::class => \Codeliner\CargoBackend\Infrastructure\Container\Application\Booking\BookingServiceFactory::class,

              //Model
            \Codeliner\CargoBackend\Model\Cargo\CargoRepositoryInterface::class => \Codeliner\CargoBackend\Infrastructure\Container\Infrastructure\DoctrineCargoRepositoryFactory::class,
            \Codeliner\CargoBackend\Model\Routing\RoutingServiceInterface::class => \Codeliner\CargoBackend\Infrastructure\Container\Infrastructure\ExternalRoutingServiceFactory::class,

              //Infrastructure
            'doctrine.entitymanager.orm_default' => \Codeliner\CargoBackend\Infrastructure\Container\Infrastructure\DoctrineEntityManagerFactory::class,
            \Doctrine\ORM\Mapping\UnderscoreNamingStrategy::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            \Codeliner\CargoBackend\Application\TransactionManager::class => \Codeliner\CargoBackend\Infrastructure\Container\Infrastructure\TransactionManagerFactory::class,

            //GraphTraversalBackend
            \Codeliner\GraphTraversalBackend\GraphTraversalServiceInterface::class => \Codeliner\GraphTraversalBackend\GraphTraversalServiceFactory::class,
        ],
        'aliases' => [
            'configuration' => 'config'
        ],
    ]
];
