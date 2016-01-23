<?php

return [
    // This can be used to seed pre- and/or post-routing middleware
    'middleware_pipeline' => [
        'always' => [
            'middleware' => [
                \Psr7Middlewares\Middleware\Payload::class,
            ],
            'priority' => PHP_INT_MAX,

        ],
        'routing' => [
            'middleware' => [
                \Zend\Expressive\Container\ApplicationFactory::ROUTING_MIDDLEWARE,
                \Zend\Expressive\Container\ApplicationFactory::DISPATCH_MIDDLEWARE,
            ],
            'priortiy' => 1
        ]
    ],
];
