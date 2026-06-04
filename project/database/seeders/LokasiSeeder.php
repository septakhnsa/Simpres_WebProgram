<?php
// FILE: database/seeders/LokasiSeeder.php  (buat file baru)

namespace Database\Seeders;

use App\Models\Lokasi;
use Illuminate\Database\Seeder;

class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        $lokasi = [
            [
                'name'         => 'Gedung A - Ruang Kuliah',
                'latitude'     => -6.9147119,
                'longitude'    => 107.6098106,
                'radius_meter' => 100,
                'is_active'    => true,
            ],
            [
                'name'         => 'Gedung B - Lab Komputer',
                'latitude'     => -6.9150200,
                'longitude'    => 107.6101500,
                'radius_meter' => 80,
                'is_active'    => true,
            ],
            [
                'name'         => 'Aula Utama',
                'latitude'     => -6.9143000,
                'longitude'    => 107.6095000,
                'radius_meter' => 150,
                'is_active'    => true,
            ],
        ];

        foreach ($lokasi as $l) {
            Lokasi::create($l);
        }
    }
}
