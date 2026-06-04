{{-- FILE: resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-[#1A3557] to-[#2563EB] rounded-xl p-6 text-white shadow">
        <h1 class="text-2xl font-bold">Dashboard Admin</h1>
        <p class="text-blue-200 text-sm mt-1">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
        $cards = [
            ['label' => 'Total Mahasiswa',   'value' => $stats['total_mahasiswa'],    'icon' => 'fa-users',         'color' => 'blue'],
            ['label' => 'Hadir Hari Ini',    'value' => $stats['hadir_hari_ini'],     'icon' => 'fa-check-circle',  'color' => 'green'],
            ['label' => 'Terlambat',         'value' => $stats['terlambat_hari_ini'], 'icon' => 'fa-clock',         'color' => 'yellow'],
            ['label' => 'Jadwal Hari Ini',   'value' => $stats['total_jadwal'],       'icon' => 'fa-calendar-day',  'color' => 'purple'],
        ];
        @endphp
        @foreach($cards as $c)
        <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
            <div class="bg-{{ $c['color'] }}-100 rounded-xl p-3">
                <i class="fas {{ $c['icon'] }} text-{{ $c['color'] }}-500 text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-800">{{ $c['value'] }}</p>
                <p class="text-xs text-gray-500">{{ $c['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Jadwal hari ini + Presensi terbaru --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Jadwal hari ini --}}
        <div class="bg-white rounded-xl shadow p-5">
            <h2 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-calendar-day text-blue-500"></i> Jadwal Hari Ini
            </h2>
            @forelse($jadwalHariIni as $j)
            <div class="border border-gray-100 rounded-lg p-3 mb-2 hover:bg-gray-50 transition">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">{{ $j->mata_kuliah }}</p>
                        <p class="text-xs text-gray-500">{{ $j->kelas }} | {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</p>
                        <p class="text-xs text-gray-400"><i class="fas fa-map-marker-alt mr-1"></i>{{ $j->lokasi->name }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-lg font-bold text-blue-600">{{ $j->presensis->count() }}</span>
                        <p class="text-xs text-gray-400">hadir</p>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-gray-400 text-sm text-center py-6"><i class="fas fa-calendar-times text-2xl mb-2 block"></i>Tidak ada jadwal hari ini.</p>
            @endforelse
        </div>

        {{-- Presensi terbaru --}}
        <div class="bg-white rounded-xl shadow p-5">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-history text-blue-500"></i> Presensi Terbaru
                </h2>
                <a href="{{ route('admin.rekap.index') }}" class="text-xs text-blue-600 hover:underline">Lihat semua →</a>
            </div>
            <div class="space-y-2">
                @forelse($presensiTerbaru as $p)
                <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $p->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $p->jadwal->mata_kuliah ?? '-' }} · {{ $p->check_in?->format('H:i') }}</p>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                        {{ $p->status === 'hadir' ? 'bg-green-100 text-green-700' :
                           ($p->status === 'terlambat' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                        {{ ucfirst($p->status) }}
                    </span>
                </div>
                @empty
                <p class="text-gray-400 text-sm text-center py-6">Belum ada presensi hari ini.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
