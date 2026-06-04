@extends('layouts.web-app')

@section('content')

@php
    $instansi = 'STMIK Widya Utama Purwokerto';
    $prodi = 'S1 Teknik Informatika';
    $angkatan = '2023';
    $kelas = 'Reguler Pagi A 6.1';

    $semester = '6';
    $ipk = '3.86';
    $sks = '132';
@endphp

<div class="max-w-6xl mx-auto px-4 space-y-8">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-4xl font-black text-[#14532D]">
                Profil Mahasiswa
            </h1>

            <p class="text-gray-500">
                Informasi akun dan data akademik mahasiswa
            </p>
        </div>

    </div>

    <!-- KARTU MAHASISWA -->
    <div class="bg-gradient-to-r from-[#14532D] to-[#1f7a3f] rounded-[35px] p-8 shadow-xl text-white">

        <div class="flex flex-col md:flex-row items-center gap-8">

            <!-- FOTO -->
            <div class="w-24 h-24 md:w-32 md:h-32 rounded-full overflow-hidden border-4 border-white shadow-lg">

                <img
                    src="{{ Auth::user()->photo ?? 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=200&auto=format&fit=crop' }}"
                    alt="Profile"
                    class="w-full h-full object-cover">

            </div>

            <!-- INFO -->
            <div class="flex-1 text-center md:text-left">

                <h2 class="text-2xl md:text-4xl font-black break-words">
                    {{ Auth::user()->name }}
                </h2>

                <p class="text-yellow-300 text-lg md:text-xl font-bold">
                    {{ Auth::user()->nim }}
                </p>

                <p class="mt-2 text-white/90">
                    {{ Auth::user()->email }}
                </p>

            </div>

            <!-- ROLE -->
            <div class="bg-white text-[#14532D] px-6 py-3 rounded-2xl font-black uppercase">

                {{ Auth::user()->role }}

            </div>

        </div>

    </div>

    <!-- STATISTIK AKADEMIK -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

        <div class="bg-white rounded-3xl p-6 shadow-lg text-center">

            <p class="text-gray-500">
                Semester
            </p>

            <h2 class="text-5xl font-black text-[#14532D]">
                {{ $semester }}
            </h2>

        </div>

        <div class="bg-white rounded-3xl p-6 shadow-lg text-center">

            <p class="text-gray-500">
                IPK
            </p>

            <h2 class="text-5xl font-black text-[#14532D]">
                {{ $ipk }}
            </h2>

        </div>

        <div class="bg-white rounded-3xl p-6 shadow-lg text-center col-span-2 md:col-span-1">

            <p class="text-gray-500">
                SKS
            </p>

            <h2 class="text-5xl font-black text-[#14532D]">
                {{ $sks }}
            </h2>

        </div>

    </div>

    <!-- STATISTIK PRESENSI -->
    @isset($totalPresensi)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white rounded-3xl p-6 shadow-lg text-center">

            <p class="text-gray-500 font-bold">
                Total Presensi
            </p>

            <h2 class="text-5xl font-black text-[#14532D] mt-3">
                {{ $totalPresensi }}
            </h2>

        </div>

        <div class="bg-white rounded-3xl p-6 shadow-lg text-center">

            <p class="text-gray-500 font-bold">
                Hadir
            </p>

            <h2 class="text-5xl font-black text-green-600 mt-3">
                {{ $totalHadir }}
            </h2>

        </div>

        <div class="bg-white rounded-3xl p-6 shadow-lg text-center">

            <p class="text-gray-500 font-bold">
                Kehadiran
            </p>

            <h2 class="text-5xl font-black text-[#14532D] mt-3">
                {{ $persentase }}%
            </h2>

        </div>

    </div>
    @endisset

    <!-- DATA MAHASISWA -->
    <div class="bg-white rounded-3xl p-8 shadow-lg">

        <h2 class="text-2xl font-black text-[#14532D] mb-6">
            Data Mahasiswa
        </h2>

        <div class="grid md:grid-cols-2 gap-5">

            <div>
                <p class="text-gray-500">Nama Lengkap</p>
                <p class="font-bold">{{ Auth::user()->name }}</p>
            </div>

            <div>
                <p class="text-gray-500">NIM</p>
                <p class="font-bold">{{ Auth::user()->nim }}</p>
            </div>

            <div>
                <p class="text-gray-500">Instansi</p>
                <p class="font-bold">{{ $instansi }}</p>
            </div>

            <div>
                <p class="text-gray-500">Program Studi</p>
                <p class="font-bold">{{ $prodi }}</p>
            </div>

            <div>
                <p class="text-gray-500">Angkatan</p>
                <p class="font-bold">{{ $angkatan }}</p>
            </div>

            <div>
                <p class="text-gray-500">Kelas</p>
                <p class="font-bold">{{ $kelas }}</p>
            </div>

            <div>
                <p class="text-gray-500">Email</p>
                <p class="font-bold">{{ Auth::user()->email }}</p>
            </div>

            <div>
                <p class="text-gray-500">Status</p>
                <p class="font-bold text-green-600">
                    Mahasiswa Aktif
                </p>
            </div>

        </div>

    </div>

    <!-- RIWAYAT PRESENSI -->
    <div class="bg-white rounded-3xl p-8 shadow-lg">

        <h2 class="text-2xl font-black text-[#14532D] mb-6">
            Presensi Terakhir
        </h2>

        @if(isset($attendances) && $attendances->count())

            <div class="space-y-4">

                @foreach($attendances as $item)

                    <div class="border rounded-2xl p-4">

                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                            <div>

                                <h3 class="font-bold text-[#14532D]">
                                    {{ $item->status }}
                                </h3>

                                <p class="text-sm text-gray-500">
                                    {{ $item->created_at->format('d M Y H:i') }}
                                </p>

                            </div>

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-bold w-fit">
                                {{ $item->status }}
                            </span>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="text-center py-10 text-gray-400">
                Belum ada data presensi.
            </div>

        @endif

    </div>

</div>

@endsection