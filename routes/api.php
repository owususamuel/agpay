<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DisplayCountryController;
use App\Http\Controllers\DisplayCurrencyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/upload-country-content',[CountryController::class, 'uploadContent'])->name('import.countrycontent');
Route::post('/upload-currency-content',[CurrencyController::class, 'uploadContent'])->name('import.currencycontent');

Route::get('/display-country-content',[DisplayCountryController::class, 'index'])->name('display.countrycontent');

Route::get('/display-currency-content',[DisplayCurrencyController::class, 'index'])->name('display.currencycontent');
