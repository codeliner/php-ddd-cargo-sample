<?php
return [
    'routes' => [
        [
            'path' => '/',
            'middleware' => 'cargo.ui',
            'allowed_methods' => [ 'GET' ],
        ],
    ],
    'view' => [
        'layout' => __DIR__ . '/../CargoUI/view/layout/layout.phtml',
        'cache' => false,
    ],
    'locations' => [
        'DEHAM' => 'Hamburg',
        'CNHKG' => 'Hongkong',
        'USNYC' => 'New York',
        'NLRTM' => 'Rotterdam',
        'SESTO' => 'Stockholm',
    ],
    'itineraries' => [
        [
            'origin' => 'DEHAM',
            'destination' => 'CNHKG',
            'duration' => 14,
            'stops' => [
                'NLRTM' => 1,
                'USNYC' => 7
            ]
        ],
        [
            'origin' => 'DEHAM',
            'destination' => 'USNYC',
            'duration' => 7,
            'stops' => []
        ],
        [
            'origin' => 'DEHAM',
            'destination' => 'USNYC',
            'duration' => 10,
            'stops' => [
                'NLRTM' => 1,
                'SESTO' => 2
            ]
        ],
        [
            'origin' => 'DEHAM',
            'destination' => 'NLRTM',
            'duration' => 1,
            'stops' => []
        ],
        [
            'origin' => 'DEHAM',
            'destination' => 'SESTO',
            'duration' => 1,
            'stops' => []
        ],
        [
            'origin' => 'CNHKG',
            'destination' => 'DEHAM',
            'duration' => 14,
            'stops' => [
                'USNYC' => 6,
                'SESTO' => 7
            ]
        ],
        [
            'origin' => 'CNHKG',
            'destination' => 'NLRTM',
            'duration' => 14,
            'stops' => [
                'USNYC' => 6,
                'DEHAM' => 7
            ]
        ],
        [
            'origin' => 'CNHKG',
            'destination' => 'SESTO',
            'duration' => 13,
            'stops' => [
                'USNYC' => 6,
            ]
        ],
        [
            'origin' => 'CNHKG',
            'destination' => 'USNYC',
            'duration' => 6,
            'stops' => []
        ],
        [
            'origin' => 'USNYC',
            'destination' => 'CNHKG',
            'duration' => 6,
            'stops' => []
        ],
        [
            'origin' => 'USNYC',
            'destination' => 'SESTO',
            'duration' => 7,
            'stops' => []
        ],
        [
            'origin' => 'USNYC',
            'destination' => 'NLRTM',
            'duration' => 7,
            'stops' => []
        ],
        [
            'origin' => 'USNYC',
            'destination' => 'DEHAM',
            'duration' => 7,
            'stops' => []
        ],
        [
            'origin' => 'USNYC',
            'destination' => 'DEHAM',
            'duration' => 8,
            'stops' => [
                'NLRTM' => 1
            ]
        ],
        [
            'origin' => 'NLRTM',
            'destination' => 'DEHAM',
            'duration' => 1,
            'stops' => []
        ],
        [
            'origin' => 'NLRTM',
            'destination' => 'USNYC',
            'duration' => 7,
            'stops' => []
        ],
        [
            'origin' => 'NLRTM',
            'destination' => 'CNHKG',
            'duration' => 14,
            'stops' => [
                'USNYC' => 7
            ]
        ],
        [
            'origin' => 'NLRTM',
            'destination' => 'SESTO',
            'duration' => 2,
            'stops' => [
                'DEHAM' => 1
            ]
        ],
        [
            'origin' => 'SESTO',
            'destination' => 'NLRTM',
            'duration' => 2,
            'stops' => [
                'DEHAM' => 1
            ]
        ],
        [
            'origin' => 'SESTO',
            'destination' => 'CNHKG',
            'duration' => 14,
            'stops' => [
                'USNYC' => 7
            ]
        ],
        [
            'origin' => 'SESTO',
            'destination' => 'USNYC',
            'duration' => 7,
            'stops' => []
        ],
        [
            'origin' => 'SESTO',
            'destination' => 'DEHAM',
            'duration' => 1,
            'stops' => []
        ],
    ],
];