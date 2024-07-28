<?php

namespace App\Jobs;

use App\Models\Currency;
use App\Models\CurrencyExchange;
use App\Services\Api\ExchangeApi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class StoreCurrencyExchangeRates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $exchangeApi;

    /**
     * Create a new job instance.
     *
     * @param ExchangeApi $exchangeApi
     */
    public function __construct(ExchangeApi $exchangeApi)
    {
        $this->exchangeApi = $exchangeApi;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $response = $this->exchangeApi->getLatestData();

            if (!$response || !isset($response['base'], $response['rates'], $response['timestamp'])) {
                Log::error('Failed to fetch data from exchange API or invalid response structure.', ['response' => $response]);
                return;
            }

            Log::info('Fetched exchange data successfully.', ['response' => $response]);

            if (!$this->checkCurrencyCode($response['base'])) {
                $currencyName = $this->exchangeApi->getCurrencyName($response['base']);

                $currency = Currency::query()->firstOrCreate([
                    'uuid' => Str::uuid(),
                    'name' => $currencyName,
                    'code' => $response['base']
                ]);

                Log::info('Currency created', ['name' => $currency->name, 'code' => $currency->code]);
            }

            if (!$this->checkCurrencyDate($response['timestamp'])) {
                $rates = $response['rates'];
                $baseCurrency = Currency::query()->where('code', $response['base'])->first();

                foreach ($rates as $code => $rate) {
                    $name = $this->exchangeApi->getCurrencyName($code);
                    $date = date('Y-m-d', $response['timestamp']);
                    $currency_id = $baseCurrency->id;

                    $currencyExchange = CurrencyExchange::query()->create([
                        'uuid' => Str::uuid(),
                        'currency_id' => $currency_id,
                        'code' => $code,
                        'name' => $name,
                        'rate' => $rate,
                        'date' => $date
                    ]);

                    Log::info('Currency Exchange created', ['name' => $currencyExchange->name, 'code' => $currencyExchange->code]);
                }
            }

        } catch (Exception $e) {
            Log::error('An error occurred while storing currency exchange rates.', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Check if the currency code already exists.
     */
    public function checkCurrencyCode($currencyCode): bool
    {
        return Currency::query()->where('code', $currencyCode)->exists();
    }

    /**
     * Check if exchange rates for the given date already exist.
     */
    public function checkCurrencyDate($date): bool
    {
        return CurrencyExchange::query()->where('date', date('Y-m-d', $date))->exists();
    }
}
