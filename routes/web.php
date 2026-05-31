<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\DokterAuthController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\AntriController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\SuperadminController;

// ================================
// PUBLIK (tanpa login)
// ================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/lupa-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/lupa-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
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

    // ANTRIAN PASIEN 
    Route::get('/antrian', [AntriController::class, 'index'])->name('antrian.index');
    Route::get('/antrian/daftar', [AntriController::class, 'create'])->name('antrian.create');
    Route::post('/antrian/daftar', [AntriController::class, 'store'])->name('antrian.store');
    Route::patch('/antrian/{id}/batal', [AntriController::class, 'batal'])->name('antrian.batal');
});


// ================================
// DOKTER
// ================================
Route::get('/dokter/login', [DokterAuthController::class, 'showLogin'])->name('dokter.login');
Route::post('/dokter/login', [DokterAuthController::class, 'login']);

Route::middleware('auth.dokter')->group(function () {
    Route::post('/dokter/logout', [DokterAuthController::class, 'logout'])->name('dokter.logout');
    Route::get('/dokter/antrian/{id}/edit-estimasi', [DokterController::class, 'antrianEditEstimasi'])->name('dokter.antrian.edit-estimasi');
    Route::patch('/dokter/antrian/{id}/edit-estimasi', [DokterController::class, 'antrianUpdateEstimasi'])->name('dokter.antrian.update-estimasi');

    // Dashboard
    Route::get('/dokter/dashboard', [DokterController::class, 'dashboard'])->name('dokter.dashboard');

    // Kelola Pasien
    Route::get('/dokter/pasien', [DokterController::class, 'pasienIndex'])->name('dokter.pasien.index');
    Route::get('/dokter/pasien/{id}', [DokterController::class, 'pasienShow'])->name('dokter.pasien.show');

    // Kelola status akun pasien
    Route::patch('/dokter/pasien/{id}/toggle-status', [DokterController::class, 'toggleStatusPasien'])->name('dokter.pasien.toggle-status');

    // Kelola Rekam Medis
    Route::get('/dokter/pasien/{pasienId}/rekam-medis/tambah', [DokterController::class, 'rekamMedisCreate'])->name('dokter.rekam-medis.create');
    Route::post('/dokter/pasien/{pasienId}/rekam-medis/tambah', [DokterController::class, 'rekamMedisStore'])->name('dokter.rekam-medis.store');
    Route::get('/dokter/rekam-medis/{id}/edit', [DokterController::class, 'rekamMedisEdit'])->name('dokter.rekam-medis.edit');
    Route::put('/dokter/rekam-medis/{id}/edit', [DokterController::class, 'rekamMedisUpdate'])->name('dokter.rekam-medis.update');
    Route::delete('/dokter/rekam-medis/{id}/hapus', [DokterController::class, 'rekamMedisDestroy'])->name('dokter.rekam-medis.destroy');

    // Pengaturan Klinik
    Route::get('/dokter/klinik', [DokterController::class, 'klinikEdit'])->name('dokter.klinik.edit');
    Route::put('/dokter/klinik', [DokterController::class, 'klinikUpdate'])->name('dokter.klinik.update');

    // Kelola Dokter
    Route::get('/dokter/kelola-dokter', [DokterController::class, 'dokterIndex'])->name('dokter.dokter.index');
    Route::get('/dokter/kelola-dokter/tambah', [DokterController::class, 'dokterCreate'])->name('dokter.dokter.create');
    Route::post('/dokter/kelola-dokter/tambah', [DokterController::class, 'dokterStore'])->name('dokter.dokter.store');
    Route::get('/dokter/kelola-dokter/{id}/edit', [DokterController::class, 'dokterEdit'])->name('dokter.dokter.edit');
    Route::put('/dokter/kelola-dokter/{id}/edit', [DokterController::class, 'dokterUpdate'])->name('dokter.dokter.update');
    Route::delete('/dokter/kelola-dokter/{id}/hapus', [DokterController::class, 'dokterDestroy'])->name('dokter.dokter.destroy');

    // ANTRIAN DOKTER
    Route::get('/dokter/antrian', [DokterController::class, 'antrianIndex'])->name('dokter.antrian.index');
    Route::patch('/dokter/antrian/{id}/panggil', [DokterController::class, 'antrianPanggil'])->name('dokter.antrian.panggil');
    Route::patch('/dokter/antrian/{id}/selesai', [DokterController::class, 'antrianSelesai'])->name('dokter.antrian.selesai');
    Route::patch('/dokter/antrian/{id}/batal', [DokterController::class, 'antrianBatal'])->name('dokter.antrian.batal');

    // Badge count 
    Route::get('/dokter/badge-count', function () {
        $antrian = \App\Models\Pendaftaran::where('tanggal_kunjungan', \Carbon\Carbon::today())
            ->where('status_antrian', 'menunggu')
            ->count();
        return response()->json(['antrian' => $antrian]);
    })->middleware('auth.dokter');

    // Pencarian ICD-10
    Route::get('/dokter/icd10/cari', function (\Illuminate\Http\Request $request) {
        $keyword = $request->q;
        $hasil   = \App\Models\Icd10::where('kode', 'like', "%{$keyword}%")
            ->orWhere('nama', 'like', "%{$keyword}%")
            ->limit(10)
            ->get(['kode', 'nama', 'kategori']);
        return response()->json($hasil);
    })->middleware('auth.dokter')->name('dokter.icd10.cari');

    // ================================
    // SUPERADMIN
    // ================================
    Route::middleware(['auth.dokter', 'auth.superadmin'])->prefix('superadmin')->group(function () {
        // Kelola Staff
        Route::get('/staff', [SuperadminController::class, 'staffIndex'])->name('superadmin.staff.index');
        Route::get('/staff/tambah', [SuperadminController::class, 'staffCreate'])->name('superadmin.staff.create');
        Route::post('/staff/tambah', [SuperadminController::class, 'staffStore'])->name('superadmin.staff.store');
        Route::get('/staff/{id}/edit', [SuperadminController::class, 'staffEdit'])->name('superadmin.staff.edit');
        Route::put('/staff/{id}/edit', [SuperadminController::class, 'staffUpdate'])->name('superadmin.staff.update');
        Route::delete('/staff/{id}/hapus', [SuperadminController::class, 'staffDestroy'])->name('superadmin.staff.destroy');

        // History Aktivitas
        Route::get('/history', [SuperadminController::class, 'historyIndex'])->name('superadmin.history.index');
    });

    // History diri sendiri (staff)
    Route::middleware('auth.dokter')->get('/dokter/history', function () {
        $history = \App\Models\ActivityLog::where('user_id', session('user_id'))
            ->latest()
            ->paginate(20);
        return view('dokter.history', compact('history'));
    })->name('dokter.history');
});
