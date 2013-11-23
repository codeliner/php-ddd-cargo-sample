<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 * 
 */
return array(
    'service_manager' => array(
        'invokables' => array(
            'Doctrine\ORM\Mapping\UnderscoreNamingStrategy' => 'Doctrine\ORM\Mapping\UnderscoreNamingStrategy',
        ),
        'aliases' => array(
            'entitymanager' => 'doctrine.entitymanager.orm_default',
        ),
    ),
    'doctrine' => array(
        'configuration' => array(
            'orm_default' => array(
                'naming_strategy' => 'Doctrine\ORM\Mapping\UnderscoreNamingStrategy'
            ),
        ),
    ),
);
