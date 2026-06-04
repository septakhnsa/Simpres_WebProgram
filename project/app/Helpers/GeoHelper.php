<?php
// FILE: app/Helpers/GeoHelper.php  (buat folder Helpers dulu, lalu buat file ini)

namespace App\Helpers;

class GeoHelper
{
    /**
     * Hitung jarak antara dua koordinat GPS dalam meter
     * menggunakan formula Haversine.
     */
    public static function hitungJarak(
        float $lat1, float $lng1,
        float $lat2, float $lng2
    ): float {
        $R = 6371000; // Radius bumi (meter)

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2)
           + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
           * sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $R * $c; // Hasil dalam meter
    }

    /**
     * Tentukan status presensi berdasarkan jam masuk.
     * Toleransi keterlambatan: 15 menit.
     */
    public static function tentukanStatus(string $jamMulai): string
    {
        $mulai           = \Carbon\Carbon::parse(now()->format('Y-m-d') . ' ' . $jamMulai);
        $selisihMenit    = $mulai->diffInMinutes(now(), false);

        // $selisihMenit positif = sudah lewat waktu mulai
        if ($selisihMenit <= 15) {
            return 'hadir';
        }

        return 'terlambat';
    }
}
