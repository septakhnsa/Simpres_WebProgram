<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Attendance;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    // 0. Endpoint Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|unique:users,nim',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'nim' => $request->nim,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi berhasil! Silakan login.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'nim' => $user->nim,
            ]
        ], 201);
    }

    // 1. Endpoint Login
    public function login(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('nim', $request->nim)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'NIM atau Password salah!'
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'nim' => $user->nim,
                'photo' => $user->photo,
                'role' => $user->role,
            ]
        ]);
    }

    public function getAttendance($schedule_id)
{
    $schedule = Schedule::findOrFail($schedule_id);
    $mahasiswa = User::where('role', 'student')->get();

    $data = $mahasiswa->map(function ($mhs) use ($schedule) {
        $attendance = Attendance::where('user_id', $mhs->id)
            ->where('schedule_id', $schedule->id)
            ->first();
        return [
            'mahasiswa' => $mhs,
            'status' => $attendance ? $attendance->status : 'Belum',
            'latitude' => $attendance ? $attendance->latitude : null,
            'longitude' => $attendance ? $attendance->longitude : null,
            'photo_path' => $attendance ? $attendance->photo_path : null,
        ];
    });

    return response()->json([
        'status' => 'success',
        'data' => $data
    ]);
}

    // 2. Endpoint Get Jadwal & Status Presensi
    public function getSchedules(Request $request)
    {
        $userId = $request->query('user_id');
        
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'user_id diperlukan'], 400);
        }

        $schedules = Schedule::all();
        $result = [];

        foreach ($schedules as $schedule) {
            $attendance = Attendance::where('user_id', $userId)
                                  ->where('schedule_id', $schedule->id)
                                  ->first();

            $result[] = [
                'id' => $schedule->id,
                'class_name' => $schedule->class_name,
                'time' => $schedule->time,
                'room' => $schedule->room,
                'status' => $attendance ? $attendance->status : 'Belum',
                'photo_path' => $attendance && $attendance->photo_path ? asset('storage/' . $attendance->photo_path) : null,
            ];
        }

        return response()->json([
            'status' => 'success',
            'data' => $result
        ]);
    }

    // 3. Endpoint Submit Presensi
    public function submitAttendance(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'schedule_id' => 'required|exists:schedules,id',
            'latitude' => 'required',
            'longitude' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        // Simpan foto
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('attendances', 'public');
        }

        // Simpan atau update presensi
        $attendance = Attendance::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'schedule_id' => $request->schedule_id,
            ],
            [
                'status' => 'Hadir',
                'photo_path' => $photoPath,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Presensi berhasil dicatat!',
            'data' => $attendance
        ]);
    }
}
