{{-- FILE: resources/views/admin/lokasi/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Manajemen Lokasi')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-map-marker-alt text-blue-500"></i> Manajemen Lokasi Presensi
        </h1>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition">
            <i class="fas fa-plus"></i> Tambah Lokasi
        </button>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-[#1A3557] text-white text-xs">
                    <th class="px-4 py-3 text-left">Nama Lokasi</th>
                    <th class="px-4 py-3 text-left">Latitude</th>
                    <th class="px-4 py-3 text-left">Longitude</th>
                    <th class="px-4 py-3 text-left">Radius</th>
                    <th class="px-4 py-3 text-left">Total Presensi</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($lokasi as $l)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $l->name }}</td>
                    <td class="px-4 py-3 text-gray-600 font-mono text-xs">{{ $l->latitude }}</td>
                    <td class="px-4 py-3 text-gray-600 font-mono text-xs">{{ $l->longitude }}</td>
                    <td class="px-4 py-3">
                        <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs">{{ $l->radius_meter }}m</span>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $l->presensis_count }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $l->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $l->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <form method="POST" action="{{ route('admin.lokasi.destroy', $l) }}"
                              onsubmit="return confirm('Hapus lokasi {{ $l->name }}?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-700 text-xs flex items-center gap-1">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">Belum ada lokasi terdaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $lokasi->links() }}</div>
    </div>
</div>

{{-- Modal Tambah Lokasi --}}
<div id="modalTambah" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-bold text-gray-800 text-lg">Tambah Lokasi Presensi</h2>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.lokasi.store') }}" class="space-y-3">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lokasi</label>
                <input type="text" name="name" required placeholder="cth: Gedung A STMIK"
                       class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                    <input type="number" name="latitude" step="0.0000001" required placeholder="-6.9147119"
                           class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                    <input type="number" name="longitude" step="0.0000001" required placeholder="107.6098106"
                           class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Radius (meter)</label>
                <input type="number" name="radius_meter" value="100" min="10" required
                       class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
                <p class="text-xs text-gray-400 mt-1">Area valid presensi dari titik lokasi ini</p>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm font-medium transition">Simpan</button>
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 rounded-lg text-sm font-medium transition">Batal</button>
            </div>
        </form>
    </div>
</div>
@endsection
