<?php

use App\Http\Controllers\Auth\AchievoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ==================== HALAMAN UTAMA (LANDING) ====================
Route::get('/', [AchievoController::class, 'landing'])->name('welcome');

// ==================== ROLE SWITCHER (DEVELOPMENT / DEMO) ====================
Route::get('/switch-role/{role}', [AchievoController::class, 'switchRole'])
    ->middleware('auth')
    ->name('switch.role');
Route::get('/rankings', function () {
    $rankings = \App\Models\User::withSum([
        'achievements as total_points' => function ($query) {
            $query->where('verification_status', 'approved');
        },
    ], 'points')
        ->orderByDesc('total_points')
        ->get();

    return view('rankings', compact('rankings'));
})->name('rankings');

// ==================== RUTE SISWA / TERAUTENTIKASI ====================
Route::middleware(['auth'])->group(function () {

    // Dashboard Siswa
    Route::get('/dashboard', [AchievoController::class, 'dashboard'])->name('dashboard');

    // Manajemen Prestasi Siswa (CRUD)
    Route::get('/achievements', [AchievoController::class, 'index'])->name('achievements.index');
    Route::get('/achievements/create', [AchievoController::class, 'create'])->name('achievements.create');
    Route::post('/achievements', [AchievoController::class, 'store'])->name('achievements.store');
    Route::delete('/achievements/{id}', [AchievoController::class, 'destroy'])->name('achievements.destroy');

    // Ranking & Profil Siswa
    Route::get('/ranking', [AchievoController::class, 'ranking'])->name('ranking');
    Route::get('/u/{username}', [AchievoController::class, 'publicProfile'])->name('profile.public');

    // Pengaturan Akun Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==================== RUTE ADMIN PANEL ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/verifications', [AdminController::class, 'verifications'])->name('verifications');
    Route::post('/verifications/{id}', [AdminController::class, 'verify'])->name('verify');
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');
    Route::get('/points', [AdminController::class, 'points'])->name('points');
    Route::post('/points', [AdminController::class, 'updatePoints'])->name('points.update');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
});

// Include Authentication Routes
require __DIR__.'/auth.php';
