<?php
$globalConfig = include __DIR__ . '/config.php';
$localConfig = (file_exists(__DIR__ . '/local.config.php'))? include __DIR__ . '/local.config.php' : [];

return [
    'services' => [
        'config' => \Zend\Stdlib\ArrayUtils::merge($globalConfig, $localConfig),
    ],
    'aliases' => [
        'configuration' => 'config'
    ],
    'invokables' => [
        'cargo.ui.riot_compiler' => \Codeliner\CargoUI\RiotCompiler::class,
    ],
    'factories' => [
        'Zend\Expressive\Application' => Zend\Expressive\Container\ApplicationFactory::class,
        'cargo.backend' => \Codeliner\CargoBackend\API\Factory\HttpRequestDispatcherFactory::class,
        'cargo.ui' => \Codeliner\CargoUI\Factory\MainFactory::class,
        'cargo_booking_service'     => \Codeliner\CargoBackend\API\Factory\BookingServiceFactory::class,
        'cargo_repository'          => \Codeliner\CargoBackend\Infrastructure\Persistence\Service\CargoRepositoryFactory::class,
        'cargo_transaction_manager' => \Codeliner\CargoBackend\Infrastructure\Persistence\Service\TransactionManagerFactory::class,
        'cargo_routing_service'     => \Codeliner\CargoBackend\Infrastructure\Routing\Service\ExternalRoutingServiceFactory::class,
        'doctrine.entitymanager.orm_default' => \Codeliner\CargoBackend\Infrastructure\Persistence\Service\DoctrineEntityManagerFactory::class,
        'graph_traversal_service'   => \Codeliner\GraphTraversalService\GraphTraversalServiceFactory::class,
    ],
];