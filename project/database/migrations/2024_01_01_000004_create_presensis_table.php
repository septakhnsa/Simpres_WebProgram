<?php
// FILE: database/migrations/2024_01_01_000004_create_presensis_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('jadwal_id')->constrained('jadwals')->onDelete('cascade');
            $table->foreignId('lokasi_id')->constrained('lokasis')->onDelete('cascade');
            $table->dateTime('check_in');
            $table->dateTime('check_out')->nullable();
            $table->decimal('lat_checkin', 10, 7);
            $table->decimal('lng_checkin', 10, 7);
            $table->decimal('lat_checkout', 10, 7)->nullable();
            $table->decimal('lng_checkout', 10, 7)->nullable();
            $table->enum('status', ['hadir', 'terlambat', 'alfa'])->default('alfa');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
