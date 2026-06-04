<?php
// FILE: routes/api.php
// GANTI SELURUH ISI file routes/api.php dengan ini

use App\Http\Controllers\API\AuthApiController;
use App\Http\Controllers\API\PresensiApiController;
use Illuminate\Support\Facades\Route;

// ── Public (tanpa token) ──────────────────────────────────────────────────
Route::post('/login', [AuthApiController::class, 'login']);

// ── Protected (wajib pakai Sanctum Bearer Token) ──────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/me',      [AuthApiController::class, 'me']);

    // Jadwal
    Route::get('/jadwal/hari-ini', [PresensiApiController::class, 'jadwalHariIni']);

    // Presensi
    Route::post('/presensi',          [PresensiApiController::class, 'store']);
    Route::post('/presensi/checkout', [PresensiApiController::class, 'checkout']);
    Route::get('/presensi/history',   [PresensiApiController::class, 'history']);
});
