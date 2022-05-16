<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Gamesite\AuthController as GamesiteAuthController;
use App\Http\Controllers\Api\Gamesite\MarketResultController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin/auth'], function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
        Route::post('change_password', [AuthController::class, 'changePassword']);
    });
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum']], function () {
    require __DIR__.'/admin/users.php';
    require __DIR__.'/admin/markets.php';
    require __DIR__.'/admin/games.php';
});

/*
|--------------------------------------------------------------------------
| Gamesite API Routes
|--------------------------------------------------------------------------
*/
Route::name('gamesite.')->prefix('gamesite/auth')->group(function () {
    Route::get('login', [GamesiteAuthController::class, 'login']);
    Route::post('login', [GamesiteAuthController::class, 'login']);

    Route::group(['middleware' => 'auth:members'], function() {
        Route::post('logout', [GamesiteAuthController::class, 'logout']);
        Route::get('me', [GamesiteAuthController::class, 'me']);
    });
});

Route::name('gamesite.')->prefix('gamesite')->group(function () {
    Route::get('market_results', MarketResultController::class)->name('market_results.index');

    Route::middleware(['auth:members'])->group(function () {
        require __DIR__.'/admin/markets.php';
        require __DIR__.'/admin/games.php';
    });
});
