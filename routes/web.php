<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Guest Routes (hanya bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // -------------------------------------------------------
    // Surat Masuk — admin_tu: CRUD | kepala_sekolah: view
    // -------------------------------------------------------
    Route::resource('surat-masuk', SuratMasukController::class)->names('surat-masuk');
    Route::get('surat-masuk/{id}/download', [SuratMasukController::class, 'download'])
        ->name('surat-masuk.download');

    // -------------------------------------------------------
    // Surat Keluar — admin_tu: CRUD only
    // -------------------------------------------------------
    Route::middleware('role:admin_tu')->group(function () {
        Route::resource('surat-keluar', SuratKeluarController::class)->names('surat-keluar');
        Route::get('surat-keluar/{id}/download', [SuratKeluarController::class, 'download'])
            ->name('surat-keluar.download');
    });

    // -------------------------------------------------------
    // Disposisi — kepala_sekolah: create | keduanya: view
    // -------------------------------------------------------
    Route::resource('disposisi', DisposisiController::class)
        ->only(['index', 'show', 'store', 'destroy'])
        ->names('disposisi');
    Route::patch('disposisi/{id}/status', [DisposisiController::class, 'updateStatus'])
        ->name('disposisi.update-status');

    // -------------------------------------------------------
    // Arsip Digital — semua role
    // -------------------------------------------------------
    Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip.index');
    Route::get('/arsip/{type}/{id}', [ArsipController::class, 'show'])->name('arsip.show');
    Route::get('/arsip/{type}/{id}/download', [ArsipController::class, 'download'])
        ->name('arsip.download');

    // -------------------------------------------------------
    // Kelola User — admin_tu only
    // -------------------------------------------------------
    Route::middleware('role:admin_tu')->group(function () {
        Route::resource('users', UserController::class)
            ->except(['show'])
            ->names('users');
    });

    // -------------------------------------------------------
    // Kelola Laporan — kepala_sekolah only
    // -------------------------------------------------------
    Route::middleware('role:kepala_sekolah')->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
    });
});
