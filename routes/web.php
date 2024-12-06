<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\DashboardController;
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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::put('/dashboard/{secretSantaId}', [DashboardController::class, 'update'])->name('secretSanta');
});

Route::prefix('users/{userId}')->group(function () {
  Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');  // View wishlist
  Route::post('/wishlist', [WishlistController::class, 'add'])->name('wishlist.add');  // Add to wishlist
  Route::delete('/wishlist/{wishId}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');  // Remove from wishlist
  Route::put('/wishlist/{wishId}', [WishlistController::class, 'update'])->name('wishlist.update');  // Update wishlist
});

require __DIR__.'/auth.php';
