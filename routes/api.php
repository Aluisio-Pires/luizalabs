<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

Route::controller(AuthController::class)->name('api.')->group(function (): void {
    Route::post('/login', 'login')->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
});

Route::middleware([EnsureFrontendRequestsAreStateful::class, 'auth:sanctum'])->name('api.')->group(function (): void {
    Route::post('/user', [AuthController::class, 'user'])->name('auth.user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::apiResource('/transactions', App\Http\Controllers\API\TransactionController::class);
});
