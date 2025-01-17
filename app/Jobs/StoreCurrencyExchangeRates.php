<?php

namespace App\Jobs;

use App\Events\CurrencyExchangeEvent;
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

                /** @var Currency $currency */
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
                $date = date('Y-m-d', $response['timestamp']);
                $currencyRates = [];

                foreach ($rates as $code => $rate) {
                    $name = $this->exchangeApi->getCurrencyName($code);
                    $currency_id = $baseCurrency->id;

                    /** @var CurrencyExchange $currencyExchange */
                    $currencyExchange = CurrencyExchange::query()->create([
                        'uuid' => Str::uuid(),
                        'currency_id' => $currency_id,
                        'code' => $code,
                        'name' => $name,
                        'rate' => $rate,
                        'date' => $date
                    ]);

                    Log::info('Currency Exchange created', ['name' => $currencyExchange->name, 'code' => $currencyExchange->code]);

//                  Build the array for event
                    $currencyRates[] = [
                        'base_currency' => $response['base'],
                        'code' => $code,
                        'name' => $name,
                        'rate' => $rate,
                        'date' => $date
                    ];
                }

                // Dispatch the event with the currencyRates array
                event(new CurrencyExchangeEvent($currencyRates));
            }
        } catch (Exception $e) {
            Log::error('An error occurred while storing currency exchange rates.', ['error' => $e->getMessage()]);
        }
    }


    public function checkCurrencyCode($currencyCode): bool
    {
        return Currency::query()->where('code', $currencyCode)->exists();
    }

    public function checkCurrencyDate($date): bool
    {
        return CurrencyExchange::query()->where('date', date('Y-m-d', $date))->exists();
    }
}
