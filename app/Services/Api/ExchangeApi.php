<?php

namespace App\Services\Api;

use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class ExchangeApi
{
    public function __construct()
    {
    }

    public function getLatestData(): JsonResponse
    {

        $response = latestData();

        if(!$response->successful()) {
            return response()->json(['error' => 'Failed to connect to the API'], 500);
        }

        return response()->json($response->json());
    }



    public function getHistoricalData($date): JsonResponse
    {

        $response = historicalData($date);

        if(!$response->successful()) {
            return response()->json(['error' => 'Failed to connect to the API'], 500);
        }

        return response()->json($response->json());
    }


}
