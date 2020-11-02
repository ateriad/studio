<?php

return [
    'type' => env('TOKEN_TYPE', 'jwt'),

    'types' => [
        'jwt' => [
            'key' => env('JWT_KEY', base64_decode(substr(env('APP_KEY'), strlen('base64:')))),
            'ttl' => env('JWT_TTL', 60 * 60 * 24 * 30),
        ],
    ],
];
