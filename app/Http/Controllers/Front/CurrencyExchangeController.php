<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyExchangeRequest;
use App\Models\CurrencyExchange;
use Illuminate\Http\Request;

class CurrencyExchangeController extends Controller
{
    public function index(CurrencyExchangeRequest $request)
    {

        $currencyExchange = CurrencyExchange::query()->where('date', $request->validated('date'))->get();

        if (!$currencyExchange->count()) {
            return view('currency-results')->with(['rates' => collect(), 'date' => $request->validated('date')]);
        }

        return view('currency-results')->with(['rates' => $currencyExchange, 'date' => $request->validated('date')]);

    }
}
