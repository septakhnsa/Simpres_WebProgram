<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Attendance;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak');
        }

        $totalMahasiswa = User::where('role', 'student')->count();
        $totalJadwal = Schedule::count();
        $totalHadir = Attendance::where('status', 'Hadir')->count();
        $schedules = Schedule::all();

        return view('admin.dashboard', compact(
            'totalMahasiswa', 'totalJadwal', 'totalHadir', 'schedules'
        ));
    }

    public function attendance($schedule_id)
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak');
        }

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

        return view('admin.attendance', compact('schedule', 'data'));
    }

    public function report()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak');
        }

        $schedules = Schedule::all();
        $mahasiswa = User::where('role', 'student')->get();

        $report = $mahasiswa->map(function ($mhs) use ($schedules) {
            $detail = $schedules->map(function ($schedule) use ($mhs) {
                $attendance = Attendance::where('user_id', $mhs->id)
                    ->where('schedule_id', $schedule->id)
                    ->first();
                return [
                    'class_name' => $schedule->mata_kuliah,
                    'status' => $attendance ? $attendance->status : 'Belum',
                ];
            });

            $totalHadir = $detail->where('status', 'Hadir')->count();

            return [
                'mahasiswa' => $mhs,
                'detail' => $detail,
                'total_hadir' => $totalHadir,
                'total_jadwal' => $schedules->count(),
            ];
        });

        return view('admin.report', compact('schedules', 'report'));
    }
}