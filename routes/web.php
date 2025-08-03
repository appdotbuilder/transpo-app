<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransportationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Home page - main transportation app
Route::get('/', [TransportationController::class, 'index'])->name('home');

// Dashboard (role-based)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Order management
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);
    Route::get('/order/create', [TransportationController::class, 'create'])->name('order.create');
    Route::post('/order', [TransportationController::class, 'store'])->name('order.store');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
