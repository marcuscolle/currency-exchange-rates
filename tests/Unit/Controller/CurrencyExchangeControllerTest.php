<?php

namespace Tests\Unit\Controller;

use App\Models\Currency;
use App\Models\CurrencyExchange;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CurrencyExchangeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_exchange_rates_for_a_given_date()
    {

        $currency = Currency::create([
            'uuid' => Str::uuid(),
            'name' => 'United States Dollar',
            'code' => 'USD',
        ]);


        CurrencyExchange::create([
            'uuid' => Str::uuid(),
            'currency_id' => $currency->id,
            'code' => 'AED',
            'name' => 'United Arab Emirates Dirham',
            'rate' => 3.673,
            'date' => '2024-07-28',
        ]);


        $response = $this->post(route('front.currency-rates'), ['date' => '2024-07-28']);


        $response->assertStatus(200);
        $response->assertViewHas('rates');
        $response->assertViewHas('date', '2024-07-28');

        $rates = $response->viewData('rates');
        $this->assertNotEmpty($rates);
        $this->assertEquals('AED', $rates->first()->code);
    }

}
