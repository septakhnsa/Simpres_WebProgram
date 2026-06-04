<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [ApiController::class, 'register']);
Route::post('/login', [ApiController::class, 'login']);
Route::get('/schedules', [ApiController::class, 'getSchedules']);
Route::post('/attendance', [ApiController::class, 'submitAttendance']);
Route::get('/attendance/{schedule_id}', [ApiController::class, 'getAttendance']);