<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */
   
    'supportsCredentials' => false,
    'allowedOrigins' => [
        env('APP_PUBLIC_URL', 'http://localhost'),
        env('APP_ADMIN_URL', 'http://localhost'),
        env('APP_DISCUSS_URL', 'http://localhost')
    ],
    'allowedOriginsPatterns' => [],
    'allowedHeaders' => ['Content-Type', 'x-xsrf-token', 'X-Requested-With', 'enctype', 'x-socket-id'],
    'allowedMethods' => ['GET', 'POST', 'OPTIONS', 'PUT', 'DELETE'],
    'exposedHeaders' => [],
    'maxAge' => 0,

];
