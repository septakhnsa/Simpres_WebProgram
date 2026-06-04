<?php
// FILE: app/Models/Jadwal.php  (buat file baru)

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'mata_kuliah', 'kelas', 'tanggal', 'jam_mulai', 'jam_selesai', 'lokasi_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // ── Relasi ───────────────────────────────────────────────
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function presensis()
    {
        return $this->hasMany(Presensi::class);
    }

    // ── Helper ───────────────────────────────────────────────
    public function isAktif(): bool
    {
        $now = now();
        return $this->tanggal->isToday()
            && $now->format('H:i:s') >= $this->jam_mulai
            && $now->format('H:i:s') <= $this->jam_selesai;
    }
}
