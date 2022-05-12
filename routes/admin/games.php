<?php

use App\Http\Controllers\Api\Admin\GameController;
use Illuminate\Support\Facades\Route;

Route::apiResource('games', GameController::class)->only(['index', 'show', 'update']);
