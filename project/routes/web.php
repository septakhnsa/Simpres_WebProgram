<?php
// FILE: routes/web.php
// GANTI SELURUH ISI file routes/web.php dengan ini

use App\Http\Controllers\Web\AdminController;
use Illuminate\Support\Facades\Route;

// Root → redirect ke login
Route::get('/', fn() => redirect()->route('login'));

// Auth routes bawaan Breeze
require __DIR__ . '/auth.php';

// ── Redirect setelah login sesuai role ───────────────────────────────────
Route::middleware('auth')->get('/redirect', function () {
    return auth()->user()->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect('/');   // mahasiswa tidak punya halaman web
})->name('redirect');

// ── Admin Routes (session-based, role: admin) ─────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Manajemen Mahasiswa
        Route::get('/mahasiswa',             [AdminController::class, 'mahasiswaIndex'])->name('mahasiswa.index');
        Route::post('/mahasiswa',            [AdminController::class, 'mahasiswaStore'])->name('mahasiswa.store');
        Route::delete('/mahasiswa/{user}',   [AdminController::class, 'mahasiswaDestroy'])->name('mahasiswa.destroy');

        // Manajemen Lokasi
        Route::get('/lokasi',                [AdminController::class, 'lokasiIndex'])->name('lokasi.index');
        Route::post('/lokasi',               [AdminController::class, 'lokasiStore'])->name('lokasi.store');
        Route::delete('/lokasi/{lokasi}',    [AdminController::class, 'lokasiDestroy'])->name('lokasi.destroy');

        // Manajemen Jadwal
        Route::get('/jadwal',                [AdminController::class, 'jadwalIndex'])->name('jadwal.index');
        Route::post('/jadwal',               [AdminController::class, 'jadwalStore'])->name('jadwal.store');
        Route::delete('/jadwal/{jadwal}',    [AdminController::class, 'jadwalDestroy'])->name('jadwal.destroy');

        // Rekap Presensi
        Route::get('/rekap',                 [AdminController::class, 'rekapIndex'])->name('rekap.index');
    });
