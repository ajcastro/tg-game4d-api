<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('users', App\Http\Controllers\Api\Admin\UserController::class);
Route::post('users/{user}/set_active', [App\Http\Controllers\Api\Admin\UserController::class, 'setActiveStatus'])->name('users.set_active');
Route::get('users/{user}/parent_groups', [App\Http\Controllers\Api\Admin\UserController::class, 'parentGroups'])->name('users.parent_groups');
Route::post('users/{user}/parent_groups', [App\Http\Controllers\Api\Admin\UserController::class, 'syncParentGroups'])->name('users.sync_parent_groups');
