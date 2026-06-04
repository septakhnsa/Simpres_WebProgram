<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'mata_kuliah',
        'dosen',
        'ruangan',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
