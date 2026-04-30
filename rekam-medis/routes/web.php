<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\RekamMedisController;

// ================================
// PUBLIK (tanpa login)
// ================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// ================================
// PRIVATE (harus login)
// ================================
Route::middleware('auth.session')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pasien
    Route::get('/pasien/tambah', [PasienController::class, 'create'])->name('pasien.create');
    Route::post('/pasien/tambah', [PasienController::class, 'store'])->name('pasien.store');
    Route::get('/pasien/{id}', [PasienController::class, 'show'])->name('pasien.show');
    Route::get('/pasien/{id}/edit', [PasienController::class, 'edit'])->name('pasien.edit');
    Route::put('/pasien/{id}/edit', [PasienController::class, 'update'])->name('pasien.update');
    Route::delete('/pasien/{id}/hapus', [PasienController::class, 'destroy'])->name('pasien.destroy');

    // Rekam Medis
    Route::get('/rekam-medis/{pasienId}/tambah', [RekamMedisController::class, 'create'])->name('rekam-medis.create');
    Route::post('/rekam-medis/{pasienId}/tambah', [RekamMedisController::class, 'store'])->name('rekam-medis.store');
    Route::get('/rekam-medis/{id}/detail', [RekamMedisController::class, 'show'])->name('rekam-medis.show');
    Route::get('/rekam-medis/{id}/edit', [RekamMedisController::class, 'edit'])->name('rekam-medis.edit');
    Route::put('/rekam-medis/{id}/edit', [RekamMedisController::class, 'update'])->name('rekam-medis.update');
    Route::delete('/rekam-medis/{id}/hapus', [RekamMedisController::class, 'destroy'])->name('rekam-medis.destroy');
});
