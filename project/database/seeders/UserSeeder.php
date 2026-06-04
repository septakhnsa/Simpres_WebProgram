<?php
// FILE: database/seeders/UserSeeder.php  (buat file baru)

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1 ADMIN ────────────────────────────────────────────
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@stmik.ac.id',
            'password' => bcrypt('admin123'),
            'role'     => 'admin',
            'jurusan'  => null,
        ]);

        // ── 20 MAHASISWA DUMMY ─────────────────────────────────
        // Password semua: mahasiswa123
        $mahasiswa = [
            ['name' => 'Septa Khoerun Nisa',    'nim' => '2021001'],
            ['name' => 'Anissa Balqis',          'nim' => '2021002'],
            ['name' => 'Aina Muratia',           'nim' => '2021003'],
            ['name' => 'Dela Nur Asia',          'nim' => '2021004'],
            ['name' => 'Rizky Firmansyah',       'nim' => '2021005'],
            ['name' => 'Siti Nurhaliza',         'nim' => '2021006'],
            ['name' => 'Bagas Prasetyo',         'nim' => '2021007'],
            ['name' => 'Dewi Anggraini',         'nim' => '2021008'],
            ['name' => 'Fajar Ramadhan',         'nim' => '2021009'],
            ['name' => 'Nadia Putri',            'nim' => '2021010'],
            ['name' => 'Andi Kurniawan',         'nim' => '2021011'],
            ['name' => 'Putri Rahayu',           'nim' => '2021012'],
            ['name' => 'Dimas Saputra',          'nim' => '2021013'],
            ['name' => 'Fitri Handayani',        'nim' => '2021014'],
            ['name' => 'Gilang Pratama',         'nim' => '2021015'],
            ['name' => 'Hana Safitri',           'nim' => '2021016'],
            ['name' => 'Irfan Hakim',            'nim' => '2021017'],
            ['name' => 'Jihan Aulia',            'nim' => '2021018'],
            ['name' => 'Kevin Santoso',          'nim' => '2021019'],
            ['name' => 'Laila Nurul Fajri',      'nim' => '2021020'],
        ];

        $jurusan = ['Teknik Informatika', 'Sistem Informasi', 'Manajemen Informatika'];

        foreach ($mahasiswa as $i => $m) {
            $namaDepan = strtolower(explode(' ', $m['name'])[0]);
            User::create([
                'name'     => $m['name'],
                'nim'      => $m['nim'],
                'email'    => $namaDepan . $m['nim'] . '@stmik.ac.id',
                'password' => bcrypt('mahasiswa123'),
                'role'     => 'mahasiswa',
                'jurusan'  => $jurusan[$i % 3],
            ]);
        }
    }
}
