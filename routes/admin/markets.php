<?php

use App\Http\Controllers\Api\Admin\MarketController;
use Illuminate\Support\Facades\Route;

Route::get('markets/{market}/market_schedule', [MarketController::class, 'getMarketSchedule'])->name('markets.get_market_schedule');
Route::post('markets/{market}/market_schedule', [MarketController::class, 'setMarketSchedule'])->name('markets.set_market_schedule');
Route::apiResource('markets', MarketController::class)->only(['index', 'show']);
