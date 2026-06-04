<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (Illuminate\Http\Request $request) {
    // 1. Tentukan Hari Ini (Bypass ke Jumat jika Sabtu/Minggu agar presentasi selalu ada isinya)
    $hariIni = \Carbon\Carbon::now()->locale('id')->isoFormat('dddd');
    if (in_array($hariIni, ['Sabtu', 'Minggu'])) {
        $hariIni = 'Jumat';
    }

    // 2. Ambil jadwal dari Database (HeidiSQL)
    $jadwalList = \App\Models\Schedule::where('hari', $hariIni)->get();

    // 3. Terapkan status dari tabel attendances untuk user saat ini
    foreach ($jadwalList as $jadwal) {
        $attendance = \App\Models\Attendance::where('user_id', Auth::id())
                        ->where('schedule_id', $jadwal->id)
                        ->first();
        $jadwal->status = $attendance ? $attendance->status : 'Belum Absen';
    }
    
    return view('dashboard', compact('jadwalList', 'hariIni'));
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Riwayat (History)
    Route::get('/riwayat', function() {
        $historyList = \App\Models\Attendance::with('schedule')
                        ->where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get()
                        ->map(function($att) {
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
    
    // Presensi Web (Kamera) GET
    Route::get('/presensi-web/{id}', function($id) {
        $jadwal = \App\Models\Schedule::findOrFail($id);
        return view('presensi', compact('jadwal'));
    })->name('presensi.web');

    // Presensi Web (Kamera) POST
    Route::post('/presensi-web/{id}', function(Illuminate\Http\Request $request, $id) {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'photo' => 'required'
        ]);

        $jadwal = \App\Models\Schedule::findOrFail($id);

        // Proses gambar base64
        $image_parts = explode(";base64,", $request->photo);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        
        $fileName = 'attendances/' . uniqid() . '.' . $image_type;
        \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $image_base64);

        \App\Models\Attendance::updateOrCreate(
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

        return redirect()->route('dashboard')->with('success', 'Presensi berhasil dicatat!');
    })->name('presensi.web.submit');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/attendance/{schedule_id}', [AdminController::class, 'attendance'])->name('admin.attendance');
    Route::get('/report', [AdminController::class, 'report'])->name('admin.report');
});

require __DIR__.'/auth.php';