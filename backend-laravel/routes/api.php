<?php

use App\Http\Controllers\CryptoMonnaieController;
use App\Http\Controllers\MonnaieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/markets/{pages}', [CryptoMonnaieController::class, 'getMarkets']);
Route::get('/coin/{id}', [CryptoMonnaieController::class, 'getCoin']);
Route::get('/past-month/{id}', [CryptoMonnaieController::class, 'getPastMonth']);

Route::get('/coin-history/{id}/{date}', [CryptoMonnaieController::class, 'getCoinHistory']);
Route::get('/list', [CryptoMonnaieController::class, 'getList']);

Route::get('/from-usd-to/{monnaie}/{amount}', [MonnaieController::class, 'fromUSDTo']);