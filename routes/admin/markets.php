<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('markets', App\Http\Controllers\Api\Admin\MarketController::class)->only(['index', 'show']);
