<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
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
            'application_module_driver' => array(
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
);
