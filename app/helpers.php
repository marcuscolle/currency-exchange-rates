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

        //TODO: if time contruct the full url to be dynamic based on the config file.
        return Http::get("https://openexchangerates.org/api/latest.json?app_id={$apiKey}&base={$baseCurrency}");
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

        return Http::get("https://openexchangerates.org/api/historical/{$date}.json?app_id={$apiKey}&base={$baseCurrency}");
    }
}
