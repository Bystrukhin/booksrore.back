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
    'allowedOrigins' => ['*'],
    'allowedOriginsPatterns' => [],
    'allowedHeaders' => ['Content-Type', 'X-Requested-With', 'Accept', 'Origin'],
    'allowedMethods' => ['GET, POST, PUT, PATCH, DELETE, OPTIONS'],
    'exposedHeaders' => [],
    'maxAge' => 0,

];
