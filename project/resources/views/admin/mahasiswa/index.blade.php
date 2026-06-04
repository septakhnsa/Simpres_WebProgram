{{-- FILE: resources/views/admin/mahasiswa/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Manajemen Mahasiswa')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-users text-blue-500"></i> Manajemen Mahasiswa
        </h1>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition">
            <i class="fas fa-plus"></i> Tambah Mahasiswa
        </button>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-[#1A3557] text-white text-xs">
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">NIM</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Jurusan</th>
                    <th class="px-4 py-3 text-left">Total Presensi</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($mahasiswa as $i => $m)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-500">{{ $mahasiswa->firstItem() + $i }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $m->name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $m->nim ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $m->email }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $m->jurusan ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs font-semibold">
                            {{ $m->presensis_count }} presensi
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <form method="POST" action="{{ route('admin.mahasiswa.destroy', $m) }}"
                              onsubmit="return confirm('Hapus mahasiswa {{ $m->name }}?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-700 text-xs flex items-center gap-1">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">Belum ada mahasiswa terdaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $mahasiswa->links() }}</div>
    </div>
</div>

{{-- Modal Tambah Mahasiswa --}}
<div id="modalTambah" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-bold text-gray-800 text-lg">Tambah Mahasiswa</h2>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.mahasiswa.store') }}" class="space-y-3">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" required class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                    <input type="text" name="nim" required class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                    <input type="text" name="jurusan" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" required class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 outline-none">
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
