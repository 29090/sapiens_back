<?php

use App\Http\Controllers\User\UserSettingsController;
use Illuminate\Support\Facades\Route;

Route::prefix('user-settings')
    ->middleware('auth:sanctum')
    ->controller(UserSettingsController::class)
    ->group(function() {
        Route::put('/', 'update');
});
