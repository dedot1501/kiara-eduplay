<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AdminController; // Tambahkan ini
use App\Http\Controllers\Admin\LevelContentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// 1. Landing Page
Route::get('/', function () {
    return view('welcome');
});

// 2. Area Terautentikasi (User & Member)
Route::middleware(['auth', 'verified'])->group(function () {

    // --- DASHBOARD & UTAMA ---
    Route::get('/dashboard', [GameController::class, 'dashboard'])->name('dashboard');
    Route::get('/leaderboard', [GameController::class, 'leaderboard'])->name('game.leaderboard');

    // --- GAME RACING ---
    Route::get('/game/racing/{difficulty?}', [GameController::class, 'racing'])->name('game.racing');
    Route::post('/game/save-score', [GameController::class, 'saveScore'])->name('game.save-score');

    // --- PREMIUM & PAYMENT ---
    Route::get('/premium/upgrade', [PaymentController::class, 'checkout'])->name('premium.checkout');
    Route::post('/premium/process', [PaymentController::class, 'upgrade'])->name('premium.process'); 
    
    // Bypass Midtrans (Hanya untuk testing/development)
    Route::post('/simulate-upgrade', function () {
        $user = Auth::user();
        $user->is_premium = true;
        $user->save();
        return back()->with('success', 'Selamat! Kamu sekarang adalah Member Premium 💎');
    })->name('simulate-upgrade');

    // --- PROFILE ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 3. Area Admin (Full Control Kiara Eduplay)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Utama Admin (Sekarang pakai AdminController)
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Kelola User (Fitur Premium & Hapus)
    Route::patch('/users/{user}/premium', [AdminController::class, 'togglePremium'])->name('users.premium');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');

    // Kelola Soal & Level (Tetap menggunakan LevelContentController)
    Route::get('/levels', [LevelContentController::class, 'index'])->name('levels.index');
    Route::post('/levels', [LevelContentController::class, 'store'])->name('levels.store');
    Route::delete('/levels/{id}', [LevelContentController::class, 'destroy'])->name('levels.destroy');
});

require __DIR__.'/auth.php';