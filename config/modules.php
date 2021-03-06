<?php
return [

    // API routing
    'routes' => [
        // Middleware to apply to all routes
        // Throttle max 10 requests per minute for guests
        // and 60 per minute for authenticated users
        'middleware' => ['api', 'throttle:60|60,1'],
        // Prefix for all routes
        'prefix' => 'api'
    ],

    // Enabled modules, can override settings here
    'modules' => [
        'auth' => [],
        'base' => [],
        'filtersets' => [],
        'messages' => [],
        'users' => []
    ]

];
