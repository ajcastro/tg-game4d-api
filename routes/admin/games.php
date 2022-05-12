<?php

use App\Http\Controllers\Api\Admin\GameController;
use Illuminate\Support\Facades\Route;

Route::post('games/{game}/game_edits/{game_edit}/approve', [GameController::class, 'approveGameEdit'])->name('games.approve_game_edit');
Route::apiResource('games', GameController::class)->only(['index', 'show', 'update']);
