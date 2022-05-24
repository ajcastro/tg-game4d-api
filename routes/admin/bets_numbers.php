<?php

use App\Http\Controllers\Api\Admin\GameBetNumbersController;
use Illuminate\Support\Facades\Route;

Route::get('bets_numbers', [GameBetNumbersController::class, 'index'])->name('bets_numbers.index');
