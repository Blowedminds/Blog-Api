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
    'allowedOrigins' => explode(', ', env('APP_URLS', [])),
    'allowedOriginsPatterns' => [],
    'allowedHeaders' => ['Content-Type', 'x-xsrf-token', 'X-Requested-With', 'enctype', 'x-socket-id'],
    'allowedMethods' => ['GET', 'POST', 'OPTIONS', 'PUT', 'DELETE'],
    'exposedHeaders' => [],
    'maxAge' => 0,

];
