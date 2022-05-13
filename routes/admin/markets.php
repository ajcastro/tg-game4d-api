<?php

use App\Http\Controllers\Api\Admin\MarketController;
use Illuminate\Support\Facades\Route;

Route::get('markets/{market}/market_schedule', [MarketController::class, 'getMarketSchedule'])->name('markets.get_market_schedule');
Route::post('markets/{market}/market_schedule', [MarketController::class, 'setMarketSchedule'])->name('markets.set_market_schedule');
Route::post('markets/{market}/set_online_status', [MarketController::class, 'setOnlineStatus'])->name('markets.set_online_status');
Route::apiResource('markets', MarketController::class)->except(['destroy']);
