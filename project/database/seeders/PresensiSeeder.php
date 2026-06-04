<?php
// FILE: database/seeders/PresensiSeeder.php  (buat file baru)

namespace Database\Seeders;

use App\Models\{Jadwal, Presensi, User};
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PresensiSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswa = User::where('role', 'mahasiswa')->get();

        // Koordinat dummy di sekitar lokasi kampus (dalam radius 100m)
        // Sedikit variasi agar terlihat realistis
        $koordinatValid = [
            ['lat' => -6.9147500, 'lng' => 107.6098500],
            ['lat' => -6.9146800, 'lng' => 107.6097900],
            ['lat' => -6.9148000, 'lng' => 107.6099200],
            ['lat' => -6.9147200, 'lng' => 107.6098000],
            ['lat' => -6.9146500, 'lng' => 107.6098800],
        ];

        // Ambil semua jadwal yang sudah lewat (bukan hari ini)
        // untuk diisi data presensi dummy historis
        $jadwalLewat = Jadwal::whereDate('tanggal', '<', today())
                             ->orderBy('tanggal')
                             ->get();

        foreach ($jadwalLewat as $jadwal) {
            foreach ($mahasiswa as $idx => $mhs) {
                // Simulasi: 80% hadir, 10% terlambat, 10% alfa
                $rand = rand(1, 10);

                if ($rand <= 1) {
                    // Alfa — tidak presensi sama sekali, skip
                    continue;
                }

                // Tentukan status & jam check-in
                $jamMulai = Carbon::parse($jadwal->tanggal->format('Y-m-d') . ' ' . $jadwal->jam_mulai);

                if ($rand <= 2) {
                    // Terlambat: 16–45 menit setelah jam mulai
                    $checkIn = $jamMulai->copy()->addMinutes(rand(16, 45));
                    $status  = 'terlambat';
                } else {
                    // Hadir: 0–10 menit sebelum atau sesudah jam mulai (dalam toleransi)
                    $checkIn = $jamMulai->copy()->addMinutes(rand(-10, 14));
                    $status  = 'hadir';
                }

                // Koordinat dummy (rotasi agar variatif)
                $koordinat = $koordinatValid[$idx % count($koordinatValid)];

                // Check-out: 10–30 menit sebelum jam selesai
                $jamSelesai = Carbon::parse($jadwal->tanggal->format('Y-m-d') . ' ' . $jadwal->jam_selesai);
                $checkOut   = $jamSelesai->copy()->subMinutes(rand(5, 20));

                Presensi::create([
                    'user_id'      => $mhs->id,
                    'jadwal_id'    => $jadwal->id,
                    'lokasi_id'    => $jadwal->lokasi_id,
                    'check_in'     => $checkIn,
                    'check_out'    => $checkOut,
                    'lat_checkin'  => $koordinat['lat'],
                    'lng_checkin'  => $koordinat['lng'],
                    'lat_checkout' => $koordinat['lat'],
                    'lng_checkout' => $koordinat['lng'],
                    'status'       => $status,
                ]);
            }
        }
    }
}
