<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\SubledgerController;
use App\Http\Controllers\TransactionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function (): void {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('accounts/{account}/transactions/create', [AccountController::class, 'createTransaction'])->name('accounts.createTransaction');
    Route::resource('accounts', AccountController::class)->only('index', 'create', 'store', 'show');
    Route::resource('transactions', TransactionController::class)->only('create', 'store');
    Route::resource('subledgers', SubledgerController::class)->only('show');
    Route::resource('fees', FeeController::class)->except('show');
});
