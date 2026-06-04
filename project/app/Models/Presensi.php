<?php
// FILE: app/Models/Presensi.php  (buat file baru)

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $fillable = [
        'user_id', 'jadwal_id', 'lokasi_id',
        'check_in', 'check_out',
        'lat_checkin', 'lng_checkin',
        'lat_checkout', 'lng_checkout',
        'status', 'keterangan',
    ];

    protected $casts = [
        'check_in'  => 'datetime',
        'check_out' => 'datetime',
    ];

    // ── Relasi ───────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    // ── Helper ───────────────────────────────────────────────
    public function sudahCheckOut(): bool
    {
        return !is_null($this->check_out);
    }
}
