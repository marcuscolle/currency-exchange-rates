<?php

namespace App\Console\Commands;

use App\Jobs\StoreCurrencyExchangeRates;
use App\Services\Api\ExchangeApi;
use Illuminate\Console\Command;

class FetchCurrencyExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:currency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command fetches the latest currency exchange rates from the API and stores them in the database.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //command created to dispatch the job manually from the console for dev test or debugging and trigger the job on task schedule.

        StoreCurrencyExchangeRates::dispatch(new ExchangeApi());
        $this->info('FetchExchangeRatesJob dispatched.');
    }
}
