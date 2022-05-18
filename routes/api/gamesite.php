<?php

use App\Http\Controllers\Api\Gamesite\AuthController as GamesiteAuthController;
use App\Http\Controllers\Api\Gamesite\GameController;
use App\Http\Controllers\Api\Gamesite\GameSettingController;
use App\Http\Controllers\Api\Gamesite\MarketController;
use App\Http\Controllers\Api\Gamesite\MarketResultController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Gamesite API Routes
|--------------------------------------------------------------------------
*/
Route::name('gamesite.')->prefix('gamesite')->group(function () {
    /**
     * Authentication
     */
    Route::prefix('auth')->group(function () {
        Route::get('login', [GamesiteAuthController::class, 'login']);
        Route::post('login', [GamesiteAuthController::class, 'login']);
        Route::post('token_for_dev', [GamesiteAuthController::class, 'getTokenForDev']);

        Route::group(['middleware' => 'auth:members'], function() {
            Route::post('logout', [GamesiteAuthController::class, 'logout']);
            Route::get('me', [GamesiteAuthController::class, 'me']);
        });
    });

    /**
     * Publicly-accessible Gamesite API
     */
    Route::get('market_results', MarketResultController::class)->name('market_results.index');

    /**
     * Authenticated Gamesite API
     */
    Route::middleware(['auth:members'])->group(function () {
        Route::apiResource('markets', MarketController::class)->only(['index', 'show']);
        Route::apiResource('games', GameController::class)->only(['index', 'show']);
        Route::get('game_settings', GameSettingController::class);
    });
});
