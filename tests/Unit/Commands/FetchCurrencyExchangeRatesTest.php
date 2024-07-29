<?php

namespace Tests\Unit\Commands;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class FetchCurrencyExchangeRatesTest extends TestCase
{
    public function testFetchExchangeRatesJobDispatched(): void
    {
        Artisan::call('fetch:currency'); // Replace with your command name

        $result = Artisan::output();

        $this->assertStringContainsString('FetchExchangeRatesJob dispatched.', $result);
    }
}

