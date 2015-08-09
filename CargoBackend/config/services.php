<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 8/9/15 - 9:19 PM
 */
return [
    'service_manager' => array(
        'factories' => array(
            'cargo_booking_service'   => Codeliner\CargoBackend\API\Booking\Service\BookingServiceFactory,
            'cargo_repository'  => 'CargoBackend\Infrastructure\Persistence\Service\CargoRepositoryFactory',
            'cargo_transaction_manager' => 'CargoBackend\Infrastructure\Persistence\Service\TransactionManagerFactory',
            'cargo_routing_service'     => 'CargoBackend\Infrastructure\Routing\Service\ExternalRoutingServiceFactory'
        ),
    ),
    'doctrine' => array(
        'configuration' => array(
            'orm_default' => array(
                //Define custom doctrine types to map the ddd value objects
                'types' => array(
                    'cargo_itinerary_legs'    => 'CargoBackend\Infrastructure\Persistence\Doctrine\Type\LegsDoctrineType',
                ),
            ),
        ),
        'driver' => array(
            'cargo_backend_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'cache' => 'array',
                'paths' => array(
                    dirname(__DIR__) . '/src/CargoBackend/Infrastructure/Persistence/Doctrine/ORM'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    'CargoBackend' => 'cargo_backend_driver',
                )
            )
        )
    ),
];