<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\{
    RatesController,
    ParkingAreaController,
    TransactionController
};

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
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('rates', RatesController::class)->middleware('role:admin');  // Hanya Admin
    Route::resource('parking_areas', ParkingAreaController::class)->middleware('role:admin');  // Hanya Admin
    Route::resource('transactions', TransactionController::class, ['only' => ['index', 'edit', 'update']])->middleware('role:petugas');  // Hanya Operator
});
