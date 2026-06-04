<?php
// FILE: app/Http/Controllers/API/PresensiApiController.php

namespace App\Http\Controllers\API;

use App\Helpers\GeoHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PresensiRequest;
use App\Models\Jadwal;
use App\Models\Presensi;
use Illuminate\Http\Request;

class PresensiApiController extends Controller
{
    // ── POST /api/presensi  (Check In) ───────────────────────
    public function store(PresensiRequest $request)
    {
        $user   = $request->user();
        $jadwal = Jadwal::with('lokasi')->findOrFail($request->jadwal_id);

        // 1. Cek jadwal aktif hari ini
        if (!$jadwal->tanggal->isToday()) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak aktif hari ini.',
            ], 422);
        }

        // 2. Cek sudah presensi di jadwal ini
        $sudah = Presensi::where('user_id', $user->id)
                         ->where('jadwal_id', $jadwal->id)
                         ->exists();
        if ($sudah) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu sudah melakukan presensi untuk jadwal ini.',
            ], 409);
        }

        // 3. Validasi lokasi GPS (Haversine)
        $lokasi = $jadwal->lokasi;
        $jarak  = GeoHelper::hitungJarak(
            $lokasi->latitude, $lokasi->longitude,
            $request->latitude, $request->longitude
        );

        if ($jarak > $lokasi->radius_meter) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu berada di luar area presensi.',
                'data'    => [
                    'jarak_anda'  => round($jarak) . ' meter',
                    'radius_izin' => $lokasi->radius_meter . ' meter',
                    'lokasi_nama' => $lokasi->name,
                ],
            ], 422);
        }

        // 4. Tentukan status (hadir / terlambat)
        $status = GeoHelper::tentukanStatus($jadwal->jam_mulai);

        // 5. Simpan presensi
        $presensi = Presensi::create([
            'user_id'     => $user->id,
            'jadwal_id'   => $jadwal->id,
            'lokasi_id'   => $lokasi->id,
            'check_in'    => now(),
            'lat_checkin' => $request->latitude,
            'lng_checkin' => $request->longitude,
            'status'      => $status,
        ]);

        return response()->json([
            'success' => true,
            'message' => "Presensi berhasil! Status: {$status}.",
            'data'    => [
                'id'          => $presensi->id,
                'mata_kuliah' => $jadwal->mata_kuliah,
                'kelas'       => $jadwal->kelas,
                'check_in'    => $presensi->check_in->format('H:i'),
                'status'      => $presensi->status,
                'lokasi'      => $lokasi->name,
            ],
        ], 201);
    }

    // ── POST /api/presensi/checkout  (Check Out) ─────────────
    public function checkout(Request $request)
    {
        $request->validate([
            'presensi_id' => 'required|exists:presensis,id',
            'latitude'    => 'required|numeric|between:-90,90',
            'longitude'   => 'required|numeric|between:-180,180',
        ]);

        $presensi = Presensi::with('lokasi')
            ->where('user_id', $request->user()->id)
            ->findOrFail($request->presensi_id);

        if ($presensi->sudahCheckOut()) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu sudah melakukan check-out.',
            ], 409);
        }

        // Validasi lokasi saat checkout
        $jarak = $presensi->lokasi->hitungJarak($request->latitude, $request->longitude);
        if ($jarak > $presensi->lokasi->radius_meter) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi tidak valid untuk check-out.',
                'data'    => [
                    'jarak_anda'  => round($jarak) . ' meter',
                    'radius_izin' => $presensi->lokasi->radius_meter . ' meter',
                ],
            ], 422);
        }

        $presensi->update([
            'check_out'    => now(),
            'lat_checkout' => $request->latitude,
            'lng_checkout' => $request->longitude,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-out berhasil!',
            'data'    => [
                'check_in'  => $presensi->check_in->format('H:i'),
                'check_out' => $presensi->fresh()->check_out->format('H:i'),
                'status'    => $presensi->status,
            ],
        ]);
    }

    // ── GET /api/presensi/history ────────────────────────────
    public function history(Request $request)
    {
        $history = Presensi::with(['jadwal', 'lokasi'])
            ->where('user_id', $request->user()->id)
            ->orderByDesc('check_in')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data'    => $history,
        ]);
    }

    // ── GET /api/jadwal/hari-ini ─────────────────────────────
    public function jadwalHariIni(Request $request)
    {
        $user    = $request->user();
        $jadwals = Jadwal::with('lokasi')
            ->whereDate('tanggal', today())
            ->orderBy('jam_mulai')
            ->get()
            ->map(function ($j) use ($user) {
                $presensi = Presensi::where('user_id', $user->id)
                    ->where('jadwal_id', $j->id)
                    ->first();
                return [
                    'id'           => $j->id,
                    'mata_kuliah'  => $j->mata_kuliah,
                    'kelas'        => $j->kelas,
                    'jam_mulai'    => $j->jam_mulai,
                    'jam_selesai'  => $j->jam_selesai,
                    'lokasi'       => $j->lokasi->name,
                    'sudah_presensi' => !is_null($presensi),
                    'status_presensi'=> $presensi?->status,
                    'is_aktif'     => $j->isAktif(),
                ];
            });

        return response()->json([
            'success' => true,
            'data'    => $jadwals,
        ]);
    }
}
