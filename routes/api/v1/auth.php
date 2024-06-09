<?php

use App\Http\Controllers\api\v1\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('email-verification', [AuthController::class, 'emailVerification']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('session', [AuthController::class, 'session']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
