<?php
// FILE: app/Models/Lokasi.php  (buat file baru)

namespace App\Models;

use App\Helpers\GeoHelper;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $fillable = [
        'name', 'latitude', 'longitude', 'radius_meter', 'is_active',
    ];

    // ── Relasi ───────────────────────────────────────────────
    public function presensis()
    {
        return $this->hasMany(Presensi::class);
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }

    // ── Validasi GPS ─────────────────────────────────────────
    public function dalamRadius(float $lat, float $lng): bool
    {
        return GeoHelper::hitungJarak(
            $this->latitude, $this->longitude, $lat, $lng
        ) <= $this->radius_meter;
    }

    public function hitungJarak(float $lat, float $lng): float
    {
        return GeoHelper::hitungJarak(
            $this->latitude, $this->longitude, $lat, $lng
        );
    }
}
