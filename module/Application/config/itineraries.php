<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 01.03.14 - 21:36
 */
return array(
    array(
        'origin' => 'DEHAM',
        'destination' => 'CNHKG',
        'duration' => 14,
        'stops' => array(
            'NLRTM' => 1,
            'USNYC' => 7
        )
    ),
    array(
        'origin' => 'DEHAM',
        'destination' => 'USNYC',
        'duration' => 7,
        'stops' => array()
    ),
    array(
        'origin' => 'DEHAM',
        'destination' => 'USNYC',
        'duration' => 10,
        'stops' => array(
            'NLRTM' => 1,
            'SESTO' => 2
        )
    ),
    array(
        'origin' => 'DEHAM',
        'destination' => 'NLRTM',
        'duration' => 1,
        'stops' => array()
    ),
    array(
        'origin' => 'DEHAM',
        'destination' => 'SESTO',
        'duration' => 1,
        'stops' => array()
    ),
    array(
        'origin' => 'CNHKG',
        'destination' => 'DEHAM',
        'duration' => 14,
        'stops' => array(
            'USNYC' => 6,
            'SESTO' => 7
        )
    ),
    array(
        'origin' => 'CNHKG',
        'destination' => 'NLRTM',
        'duration' => 14,
        'stops' => array(
            'USNYC' => 6,
            'DEHAM' => 7
        )
    ),
    array(
        'origin' => 'CNHKG',
        'destination' => 'SESTO',
        'duration' => 13,
        'stops' => array(
            'USNYC' => 6,
        )
    ),
    array(
        'origin' => 'CNHKG',
        'destination' => 'USNYC',
        'duration' => 6,
        'stops' => array()
    ),
    array(
        'origin' => 'USNYC',
        'destination' => 'CNHKG',
        'duration' => 6,
        'stops' => array()
    ),
    array(
        'origin' => 'USNYC',
        'destination' => 'SESTO',
        'duration' => 7,
        'stops' => array()
    ),
    array(
        'origin' => 'USNYC',
        'destination' => 'NLRTM',
        'duration' => 7,
        'stops' => array()
    ),
    array(
        'origin' => 'USNYC',
        'destination' => 'DEHAM',
        'duration' => 7,
        'stops' => array()
    ),
    array(
        'origin' => 'USNYC',
        'destination' => 'DEHAM',
        'duration' => 8,
        'stops' => array(
            'NLRTM' => 1
        )
    ),
    array(
        'origin' => 'NLRTM',
        'destination' => 'DEHAM',
        'duration' => 1,
        'stops' => array()
    ),
    array(
        'origin' => 'NLRTM',
        'destination' => 'USNYC',
        'duration' => 7,
        'stops' => array()
    ),
    array(
        'origin' => 'NLRTM',
        'destination' => 'CNHKG',
        'duration' => 14,
        'stops' => array(
            'USNYC' => 7
        )
    ),
    array(
        'origin' => 'NLRTM',
        'destination' => 'SESTO',
        'duration' => 2,
        'stops' => array(
            'DEHAM' => 1
        )
    ),
    array(
        'origin' => 'SESTO',
        'destination' => 'NLRTM',
        'duration' => 2,
        'stops' => array(
            'DEHAM' => 1
        )
    ),
    array(
        'origin' => 'SESTO',
        'destination' => 'CNHKG',
        'duration' => 14,
        'stops' => array(
            'USNYC' => 7
        )
    ),
    array(
        'origin' => 'SESTO',
        'destination' => 'USNYC',
        'duration' => 7,
        'stops' => array()
    ),
    array(
        'origin' => 'SESTO',
        'destination' => 'DEHAM',
        'duration' => 1,
        'stops' => array()
    )
);