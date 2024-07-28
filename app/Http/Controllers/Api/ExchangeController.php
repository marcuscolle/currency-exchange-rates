<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\ExchangeApi;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    public function index()
    {
        $api = new ExchangeApi();
        $response = $api->getLatestData();

        dd($response);
    }
}
