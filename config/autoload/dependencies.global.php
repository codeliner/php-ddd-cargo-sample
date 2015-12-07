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
            \Codeliner\CargoBackend\Application\Action\GetLocations::class => \Codeliner\CargoBackend\Container\Application\Action\BookingActionFactory::class,
            \Codeliner\CargoBackend\Application\Action\GetRouteCandidates::class => \Codeliner\CargoBackend\Container\Application\Action\BookingActionFactory::class,
            \Codeliner\CargoBackend\Application\Action\CreateCargo::class => \Codeliner\CargoBackend\Container\Application\Action\BookingActionFactory::class,
            \Codeliner\CargoBackend\Application\Action\GetCargos::class => \Codeliner\CargoBackend\Container\Application\Action\BookingActionFactory::class,
            \Codeliner\CargoBackend\Application\Action\GetCargo::class => \Codeliner\CargoBackend\Container\Application\Action\BookingActionFactory::class,
            \Codeliner\CargoBackend\Application\Action\UpdateCargo::class => \Codeliner\CargoBackend\Container\Application\Action\BookingActionFactory::class,

              //Action Helper middleware
            \Psr7Middlewares\Middleware\Payload::class => \Codeliner\CargoBackend\Container\Application\Action\PayloadParserFactory::class,

              //Application
            \Codeliner\CargoBackend\Application\Booking\BookingService::class => \Codeliner\CargoBackend\Container\Application\Booking\BookingServiceFactory::class,

              //Model
            \Codeliner\CargoBackend\Model\Cargo\CargoRepositoryInterface::class => \Codeliner\CargoBackend\Container\Infrastructure\DoctrineCargoRepositoryFactory::class,
            \Codeliner\CargoBackend\Model\Routing\RoutingServiceInterface::class => \Codeliner\CargoBackend\Container\Infrastructure\ExternalRoutingServiceFactory::class,

              //Infrastructure
            'doctrine.entitymanager.orm_default' => \Codeliner\CargoBackend\Container\Infrastructure\DoctrineEntityManagerFactory::class,
            \Doctrine\ORM\Mapping\UnderscoreNamingStrategy::class => \Zend\ServiceManager\Factory\InvokableFactory::class,
            \Codeliner\CargoBackend\Infrastructure\Persistence\Transaction\TransactionManager::class => \Codeliner\CargoBackend\Container\Infrastructure\TransactionManagerFactory::class,

            //GraphTraversalBackend
            \Codeliner\GraphTraversalBackend\GraphTraversalServiceInterface::class => \Codeliner\GraphTraversalBackend\GraphTraversalServiceFactory::class,
        ],
        'aliases' => [
            'configuration' => 'config'
        ],
    ]
];
