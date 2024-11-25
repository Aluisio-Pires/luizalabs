<?php

use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FeeController;
use App\Http\Controllers\API\SubledgerController;
use App\Http\Controllers\API\TransactionController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

Route::controller(AuthController::class)->name('api.')->group(function (): void {
    Route::post('/login', 'login')->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
});

Route::middleware([EnsureFrontendRequestsAreStateful::class, 'auth:sanctum'])->name('api.')->group(function (): void {
    Route::post('/user', [AuthController::class, 'user'])->name('auth.user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::apiResource('/transactions', TransactionController::class)->except(['destroy']);
    Route::apiResource('/accounts', AccountController::class)->except(['update', 'destroy']);
    Route::apiResource('/fees', FeeController::class);
    Route::apiResource('/subledgers', SubledgerController::class)->except('store', 'destroy');

});
