<?php

namespace Tests\Unit\Jobs;

use App\Services\Api\ExchangeApi;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\StoreCurrencyExchangeRates;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreCurrencyExchangeRatesTest extends TestCase
{
    use RefreshDatabase; // Use this trait if your job interacts with the database

    /** @test */
    public function it_stores_currency_exchange_rates()
    {

        $api = new ExchangeApi();
        (new StoreCurrencyExchangeRates($api))->handle();

        $this->assertDatabaseHas('currency_exchanges', [
            'code' => 'AED',
        ]);
    }
}

