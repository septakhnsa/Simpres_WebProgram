<?php
// FILE: database/seeders/JadwalSeeder.php  (buat file baru)

namespace Database\Seeders;

use App\Models\Jadwal;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        // Mata kuliah & jadwal hariannya
        $mataKuliah = [
            ['nama' => 'Web Programming Lanjutan', 'kelas' => 'TI-3A', 'mulai' => '08:00', 'selesai' => '10:00', 'lokasi_id' => 1],
            ['nama' => 'Basis Data Lanjutan',       'kelas' => 'TI-3A', 'mulai' => '10:00', 'selesai' => '12:00', 'lokasi_id' => 2],
            ['nama' => 'Pemrograman Mobile',        'kelas' => 'SI-3B', 'mulai' => '13:00', 'selesai' => '15:00', 'lokasi_id' => 2],
            ['nama' => 'Keamanan Jaringan',         'kelas' => 'TI-3A', 'mulai' => '15:00', 'selesai' => '17:00', 'lokasi_id' => 1],
        ];

        // Generate jadwal untuk 14 hari terakhir (termasuk hari ini)
        // agar ada data historis yang bisa ditampilkan di rekap
        for ($i = 13; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);

            // Skip hari Minggu
            if ($tanggal->dayOfWeek === Carbon::SUNDAY) continue;

            // Tiap hari cuma 2 mata kuliah (biar tidak terlalu banyak)
            $jadwalHariIni = array_slice($mataKuliah, ($i % 2) * 2, 2);

            foreach ($jadwalHariIni as $mk) {
                Jadwal::create([
                    'mata_kuliah' => $mk['nama'],
                    'kelas'       => $mk['kelas'],
                    'tanggal'     => $tanggal->format('Y-m-d'),
                    'jam_mulai'   => $mk['mulai'] . ':00',
                    'jam_selesai' => $mk['selesai'] . ':00',
                    'lokasi_id'   => $mk['lokasi_id'],
                ]);
            }
        }

        // Pastikan ada jadwal HARI INI untuk testing
        // (cek dulu biar tidak duplikat)
        $sudahAdaHariIni = Jadwal::whereDate('tanggal', today())->exists();
        if (!$sudahAdaHariIni) {
            foreach (array_slice($mataKuliah, 0, 2) as $mk) {
                Jadwal::create([
                    'mata_kuliah' => $mk['nama'],
                    'kelas'       => $mk['kelas'],
                    'tanggal'     => today()->format('Y-m-d'),
                    'jam_mulai'   => $mk['mulai'] . ':00',
                    'jam_selesai' => $mk['selesai'] . ':00',
                    'lokasi_id'   => $mk['lokasi_id'],
                ]);
            }
        }
    }
}
