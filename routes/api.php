<?php

use App\Http\Controllers\Api\Admin\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

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
