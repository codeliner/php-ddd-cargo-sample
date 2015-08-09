<?php
return [
    'routes' => [
        [
            'path' => '/',
            'middleware' => 'cargo.ui',
            'allowed_methods' => [ 'GET' ],
        ],
        [
            'path' => '/api',
            'middleware' => 'cargo.backend',
        ],
    ],
    'view' => [
        'layout' => __DIR__ . '/../CargoUI/view/layout/layout.phtml',
        'cache' => false,
    ]
];