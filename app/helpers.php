<?php

use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


if (!function_exists('latestData')) {
    /**
     * @return Response
     */
    function latestData(): Response
    {
        $apiKey = config('api.exchange.key');
        $baseCurrency = config('api.exchange.base');
        $sslCertPath = config('api.exchange.ssl_cert_path');
        $symbols = config('api.exchange.symbols');

        //TODO: if time construct the full url to be dynamic based on the config file.

        //Path to the url without the verification of the ssl certificate
//        return Http::get("https://openexchangerates.org/api/latest.json?app_id={$apiKey}&base={$baseCurrency}");

        return Http::withOptions(['verify' => $sslCertPath])
            ->get("https://openexchangerates.org/api/latest.json?app_id={$apiKey}&base={$baseCurrency}&symbols={$symbols}");
    }
}

if(!function_exists('historicalData')) {
    /**
     * @param $date
     * @return Response
     */
    function historicalData($date): Response
    {
        $apiKey = config('api.exchange.key');
        $baseCurrency = config('api.exchange.base');
        $sslCertPath = config('api.exchange.ssl_cert_path');
        $symbols = config('api.exchange.symbols');

        //Path to the url without the verification of the ssl certificate
//        return Http::get("https://openexchangerates.org/api/historical/{$date}.json?app_id={$apiKey}&base={$baseCurrency}");

        return Http::withOptions(['verify' => $sslCertPath])
            ->get("https://openexchangerates.org/api/latest.json?app_id={$apiKey}&base={$baseCurrency}&symbols={$symbols}");
    }
}

if(!function_exists('currencyName')) {
    /**
     * @return Response
     */
    function currencyName(): Response
    {
        $apiKey = config('api.exchange.key');
        $sslCertPath = config('api.exchange.ssl_cert_path');

//        return Http::get("https://openexchangerates.org/api/currencies.json?app_id={$apiKey}");

        return Http::withOptions(['verify' => $sslCertPath])
            ->get("https://openexchangerates.org/api/currencies.json?app_id={$apiKey}");
    }
}
