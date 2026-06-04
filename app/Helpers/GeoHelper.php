<?php

namespace App\Helpers;

class GeoHelper
{
    public static function hitungJarak(
        float $lat1, float $lng1,
        float $lat2, float $lng2
    ): float {
        $R = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2)
           + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
           * sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $R * $c;
    }

    public static function tentukanStatus(string $jamMulai): string
    {
        $mulai        = \Carbon\Carbon::parse(now()->format('Y-m-d') . ' ' . $jamMulai);
        $selisihMenit = $mulai->diffInMinutes(now(), false);

        if ($selisihMenit <= 15) {
            return 'hadir';
        }

        return 'terlambat';
    }
}