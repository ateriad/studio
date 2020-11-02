<?php

return [
    'driver' => env('SMS_DRIVER', 'candoo'),

    'drivers' => [
        'candoo' => [
            'wdsl' => env('SMS_CANDOO_WDSL', 'http://my.candoosms.com/services/?wsdl'),
            'username' => env('SMS_CANDOO_USERNAME'),
            'password' => env('SMS_CANDOO_PASSWORD'),
            'source' => env('SMS_CANDOO_SOURCE'),
            'flash' => env('SMS_CANDOO_FLASH', '0'),
        ]
    ],
];
