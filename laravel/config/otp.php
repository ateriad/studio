<?php

return [
    'targets' => [
        'sms' => [
            'ttl' => env('OTP_SMS_TTL', 60),
        ],
        'email' => [
            'ttl' => env('OTP_EMAIL_TTL', 180),
        ],
    ],

    'driver' => 'redis',

    'drivers' => [
        'redis' => [
            'ttl' => env('OTP_REDIS_TTL', 180),
        ]
    ],
];
