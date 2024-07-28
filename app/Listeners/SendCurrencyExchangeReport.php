<?php

namespace App\Listeners;

use App\Events\CurrencyExchangeEvent;
use App\Mail\CurrencyRatesReportMail;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendCurrencyExchangeReport
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CurrencyExchangeEvent $event): void
    {
        try {
            $filePath = $this->generateCsv($event->currencyRates);
            $this->sendEmail($filePath);
        } catch (Exception $e) {
            // Log any errors related to CSV generation or email sending
            Log::error('Failed to generate or send CSV report.', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Generate a CSV file with exchange rates.
     *
     * @param array $currencyRates
     * @return string
     */
    protected function generateCsv(array $currencyRates): string
    {
        $filename = 'currency_rates_' . now()->format('Y_m_d') . '.csv';
        $filePath = storage_path('app/public/' . $filename);

        $handle = fopen($filePath, 'w');
        fputcsv($handle, ['Base Currency', 'Code', 'Name', 'Rate', 'Date']);

        foreach ($currencyRates as $rate) {
            fputcsv($handle, [ $rate['base_currency'], $rate['code'], $rate['name'], $rate['rate'], $rate['date']]);
        }

        fclose($handle);

        return $filePath;
    }

    /**
     * Send an email with the CSV file attached.
     *
     * @param string $filePath
     * @return void
     */
    protected function sendEmail(string $filePath): void
    {
        $email = new CurrencyRatesReportMail($filePath);
        Mail::to('currencyExchangeRates@hotmail.com')->send($email);

        // Clean the generated CSV file
        Storage::delete($filePath);
    }
}
