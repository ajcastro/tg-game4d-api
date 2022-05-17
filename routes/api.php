<?php

use App\Http\Controllers\Api\Admin\AuthController;
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
require __DIR__.'/api/gamesite.php';
