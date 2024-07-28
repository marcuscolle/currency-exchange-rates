<?php

return [

    'exchange' => [
        'key' => env('OPEN_EXCHANGE_API_KEY'),
        'base' => env('BASE_CURRENCY', 'USD'),
        'ssl_cert_path' => env('SSL_CERT_PATH', 'C:\laragon\etc\ssl\cacert.pem'),


    //        'url' => 'https://openexchangerates.org/api/',
    //        'endpoints' => [
    //            'latest' => 'latest.json',
    //            'historical' => 'historical/{date}.json'
    //        ]

    ]

];
