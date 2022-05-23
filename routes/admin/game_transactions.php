<?php

use App\Http\Controllers\Api\Gamesite\GameTransactionController;
use Illuminate\Support\Facades\Route;

Route::apiResource('game_transactions', GameTransactionController::class)->only(['index', 'show']);
