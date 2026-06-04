<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

use App\Models\Schedule;
use App\Models\Attendance;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD MAHASISWA
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {

    $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');
    // Ambil jadwal sesuai hari
    $jadwalList = Schedule::where('hari', $hariIni)->get();

    // Fallback kalau kosong (biar aman demo)
    if ($jadwalList->isEmpty()) {
        $jadwalList = Schedule::all();
    }

    // Tambahkan status presensi user login
    foreach ($jadwalList as $jadwal) {
        $attendance = Attendance::where('user_id', Auth::id())
            ->where('schedule_id', $jadwal->id)
            ->first();

        $jadwal->status = $attendance ? $attendance->status : 'Belum Absen';
    }

    return view('dashboard', compact('jadwalList', 'hariIni'));

})->middleware(['auth'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (PROFILE)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | RIWAYAT PRESENSI
    |--------------------------------------------------------------------------
    */
    Route::get('/riwayat', function () {

        $historyList = Attendance::with('schedule')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($att) {
                return (object)[
                    'mataKuliah' => $att->schedule->mata_kuliah ?? 'Unknown',
                    'tanggal' => $att->created_at->locale('id')->isoFormat('dddd, D MMM YYYY'),
                    'jamAbsen' => $att->created_at->format('H:i'),
                    'status' => $att->status,
                    'photo_path' => $att->photo_path,
                    'latitude' => $att->latitude,
                    'longitude' => $att->longitude
                ];
            });

        return view('history', compact('historyList'));

    })->name('history');


    /*
    |--------------------------------------------------------------------------
    | PRESENSI WEB (KAMERA)
    |--------------------------------------------------------------------------
    */

    // GET
    Route::get('/presensi-web/{id}', function ($id) {
        $jadwal = Schedule::findOrFail($id);
        return view('presensi', compact('jadwal'));
    })->name('presensi.web');


    // POST
    Route::post('/presensi-web/{id}', function (Request $request, $id) {

        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'photo' => 'required'
        ]);

        $jadwal = Schedule::findOrFail($id);

        // decode base64 image
        $image_parts = explode(";base64,", $request->photo);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $fileName = 'attendances/' . uniqid() . '.' . $image_type;

        Storage::disk('public')->put($fileName, $image_base64);

        Attendance::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'schedule_id' => $jadwal->id,
            ],
            [
                'status' => 'Hadir',
                'photo_path' => $fileName,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]
        );

        return redirect()->route('dashboard')
            ->with('success', 'Presensi berhasil dicatat!');

    })->name('presensi.web.submit');

});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/attendance/{schedule_id}', [AdminController::class, 'attendance'])->name('admin.attendance');
    Route::get('/report', [AdminController::class, 'report'])->name('admin.report');

});


require __DIR__.'/auth.php';