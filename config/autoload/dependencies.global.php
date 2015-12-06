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
            \Codeliner\CargoBackend\Application\Action\GetLocations::class => \Codeliner\CargoBackend\Container\Application\Action\GetLocationsFactory::class,
            \Codeliner\CargoBackend\Application\Action\CreateCargo::class => \Codeliner\CargoBackend\Container\Application\Action\CreateCargoFactory::class,
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
        ],
        'aliases' => [
            'configuration' => 'config'
        ],
    ]
];
