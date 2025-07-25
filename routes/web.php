<?php

use App\Http\Controllers\PresentationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Main presentation on home page
Route::controller(PresentationController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::post('/presentation/complete', 'store')->name('presentation.complete');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
