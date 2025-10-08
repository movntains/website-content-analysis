<?php

declare(strict_types=1);

use App\Http\Controllers\ScanController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn () => Inertia::render('welcome'))->name('home');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('dashboard', fn () => Inertia::render('dashboard'))->name('dashboard');

    // Scans
    Route::group([
        'prefix' => 'scans',
        'as' => 'scans.',
    ], function (): void {
        Route::get('/', [ScanController::class, 'index'])->name('index');
        Route::get('/create', [ScanController::class, 'create'])->name('create');
        Route::post('/', [ScanController::class, 'store'])->name('store');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
