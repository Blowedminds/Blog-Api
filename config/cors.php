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
    'allowedOrigins' => [env('APP_PUBLIC_URL', 'http://localhost'), env('APP_ADMIN_URL', 'http://localhost'), 'http://localhost:4400'],
    'allowedHeaders' => ['Content-Type', 'x-xsrf-token', 'X-Requested-With', 'enctype'],
    'allowedMethods' => ['GET', 'POST', 'OPTIONS', 'PUT', 'DELETE'],
    'exposedHeaders' => [],
    'maxAge' => 0,
];
