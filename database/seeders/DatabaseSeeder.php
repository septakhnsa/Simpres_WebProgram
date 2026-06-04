<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Schedule;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Dummy Student
        User::create([
            'name' => 'Argena Faqila Hasta',
            'nim' => 'STI202303888',
            'email' => 'argena@student.com',
            'password' => Hash::make('password123'),
            'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=200&auto=format&fit=crop',
            'role' => 'student',
        ]);

        // Dummy Admin
        User::create([
            'name' => 'Dosen Admin',
            'nim' => 'ADMIN001',
            'email' => 'admin@kampus.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Data Jadwal Real Semester 6
        $schedules = [
            ['mata_kuliah' => 'Metopen', 'dosen' => 'Bu Lutvi', 'ruangan' => 'K.B. R2.1', 'hari' => 'Senin', 'jam_mulai' => '08:30', 'jam_selesai' => '09:30'],
            ['mata_kuliah' => 'Komputasi Awan', 'dosen' => 'Pak Joko', 'ruangan' => 'K.B. R2.1', 'hari' => 'Senin', 'jam_mulai' => '11:00', 'jam_selesai' => '13:00'],
            ['mata_kuliah' => 'RPL', 'dosen' => 'Bu Rini', 'ruangan' => 'K.S. R1.2', 'hari' => 'Selasa', 'jam_mulai' => '08:30', 'jam_selesai' => '10:00'],
            ['mata_kuliah' => 'MobPro Lanjut', 'dosen' => 'Pak Aryo', 'ruangan' => 'K.B. R2.3', 'hari' => 'Rabu', 'jam_mulai' => '10:00', 'jam_selesai' => '12:00'],
            ['mata_kuliah' => 'Kecerdasan Buatan', 'dosen' => 'Bu Siti Delimasari', 'ruangan' => 'Lab Komputer 1', 'hari' => 'Kamis', 'jam_mulai' => '09:00', 'jam_selesai' => '10:30'],
            ['mata_kuliah' => 'WebPro Lanjut', 'dosen' => 'Pak Bayu', 'ruangan' => 'K.B. Lab 2', 'hari' => 'Jumat', 'jam_mulai' => '09:30', 'jam_selesai' => '11:30'],
        ];

        foreach ($schedules as $jadwal) {
            Schedule::create($jadwal);
        }
    }
}
