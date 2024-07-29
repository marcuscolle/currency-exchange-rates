<?php

namespace Tests\Unit\Mail;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\CurrencyRatesReportMail;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CurrencyRateReportMailTest extends TestCase
{
    use RefreshDatabase; // If your email logic involves database interactions

    /** @test */
    public function it_sends_currency_rates_report_mail_without_attachment()
    {

        Mail::fake();

        $filePath = storage_path('app/public/currency_rates.csv'); // This path is not used in this test
        $recipient = 'currencyExchangeRates@hotmail.com';

        Mail::to($recipient)->send(new CurrencyRatesReportMail($filePath));

        Mail::assertSent(CurrencyRatesReportMail::class, function ($mail) use ($recipient) {

            return $mail->hasTo($recipient);
        });
    }
}





