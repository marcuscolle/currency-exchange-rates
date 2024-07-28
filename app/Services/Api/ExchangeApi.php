<?php

namespace App\Services\Api;

use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Expr\Array_;

class ExchangeApi
{
    public function __construct()
    {
    }

    public function getLatestData(): JsonResponse|array
    {
        try{
            $response = latestData();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return $response->json();
    }



    public function getHistoricalData($date): JsonResponse|array
    {
        try{
            $response = historicalData($date);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return $response->json();
    }

    public function getCurrencyName($currencyCode): string
    {

        try{
            $response = currencyName();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        $data = $response->json();

        return $data[$currencyCode];

    }


}
