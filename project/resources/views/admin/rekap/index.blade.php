{{-- FILE: resources/views/admin/rekap/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Rekap Presensi')

@section('content')
<div class="space-y-6">
    <h1 class="text-xl font-bold text-gray-800 flex items-center gap-2">
        <i class="fas fa-table text-blue-500"></i> Rekap Presensi Mahasiswa
    </h1>

    {{-- Filter --}}
    <div class="bg-white rounded-xl shadow p-4">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                       class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Status</label>
                <select name="status" class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
                    <option value="">Semua Status</option>
                    <option value="hadir"     {{ request('status') === 'hadir'     ? 'selected' : '' }}>Hadir</option>
                    <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    <option value="alfa"      {{ request('status') === 'alfa'      ? 'selected' : '' }}>Alfa</option>
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Mahasiswa</label>
                <select name="user_id" class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
                    <option value="">Semua Mahasiswa</option>
                    @foreach($mahasiswa as $m)
                    <option value="{{ $m->id }}" {{ request('user_id') == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition flex items-center gap-1">
                <i class="fas fa-filter"></i> Filter
            </button>
            <a href="{{ route('admin.rekap.index') }}"
               class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
                Reset
            </a>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-[#1A3557] text-white text-xs">
                    <th class="px-4 py-3 text-left">Mahasiswa</th>
                    <th class="px-4 py-3 text-left">NIM</th>
                    <th class="px-4 py-3 text-left">Mata Kuliah</th>
                    <th class="px-4 py-3 text-left">Lokasi</th>
                    <th class="px-4 py-3 text-left">Check In</th>
                    <th class="px-4 py-3 text-left">Check Out</th>
                    <th class="px-4 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($rekap as $r)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $r->user->name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $r->user->nim ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $r->jadwal->mata_kuliah ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ $r->lokasi->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $r->check_in?->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $r->check_out?->format('H:i') ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                            {{ $r->status === 'hadir' ? 'bg-green-100 text-green-700' :
                               ($r->status === 'terlambat' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                            {{ ucfirst($r->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">Tidak ada data presensi.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $rekap->links() }}</div>
    </div>
</div>
@endsection
