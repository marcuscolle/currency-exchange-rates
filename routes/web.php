<?php

use App\Http\Controllers\Front\CurrencyExchangeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('front.index');


Route::post('/currency-rates', [CurrencyExchangeController::class, 'index'])->name('front.currency-rates');
