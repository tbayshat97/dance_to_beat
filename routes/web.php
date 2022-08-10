<?php

use App\Http\Controllers\API\Customer\HyperpayGatewayController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('lang/{locale}', [LanguageController::class, 'swap']);

Route::get('checkout-page', function () {
    return view('payment.payment_form');
})->name('checkout-page');

Route::get('payement-result', [HyperpayGatewayController::class, 'getPaymentStatus'])->name('payment-result');
Route::get('/', function () {
    echo 'home';
});
