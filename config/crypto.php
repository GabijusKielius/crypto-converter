<?php

return [
    'providers' => [
        'coin_api' => [
            'name' => 'Coin API',
            'url'  => env('COIN_API_URL', 'https://rest.coinapi.io/v1/exchangerate/'),
            'key'  => env('COIN_API_KEY', '')
        ],
        'exchange_rate' => [
            'name' => 'Exchange Rate',
            'url'  => env('EXCHANGE_RATE_URL', 'https://api.exchangerate.host/convert'),
        ],
    ]
];
