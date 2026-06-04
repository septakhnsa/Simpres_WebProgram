@extends('layouts.web-app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <!-- Left Column (Profile & Rekap) -->
    <div class="lg:col-span-4 space-y-8">
        
        <!-- Profile Card -->
        <div class="bg-white rounded-[30px] p-8 border-4 border-[#14532D] shadow-[-8px_8px_0_0_#14532D] relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-24 bg-[#7E9D68] border-b-4 border-[#14532D]"></div>
            
            <div class="relative z-10 flex flex-col items-center mt-6">
                <div class="w-28 h-28 rounded-full border-4 border-white overflow-hidden shadow-lg bg-gray-300 mb-4">
                    <img src="{{ Auth::user()->photo ?? 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=200&auto=format&fit=crop' }}" alt="Profile" class="w-full h-full object-cover">
                </div>
                <h2 class="text-2xl font-black text-[#14532D] text-center leading-tight">{{ Auth::user()->name }}</h2>
                <p class="text-gray-500 font-bold mt-1">{{ Auth::user()->nim ?? 'STI202303888' }}</p>
                <div class="mt-4 bg-[#14532D]/10 text-[#14532D] px-4 py-1.5 rounded-full font-bold text-sm">
                    Mahasiswa Aktif
                </div>
            </div>
        </div>

        <!-- Rekap Kehadiran -->
        <div class="bg-[#FFD54F] rounded-[30px] p-6 md:p-8 border-4 border-[#14532D] shadow-[-8px_8px_0_0_#14532D]">
            <h3 class="text-[#14532D] text-lg font-black mb-4 md:mb-6 border-b-2 border-[#14532D]/20 pb-2">Rekap Bulan Ini</h3>
            <div class="grid grid-cols-3 gap-2 md:gap-4">
                <div class="bg-white rounded-2xl py-3 md:py-4 flex flex-col items-center border-2 border-[#14532D] shadow-[-3px_3px_0_0_#14532D] md:shadow-[-4px_4px_0_0_#14532D]">
                    <span class="text-[#14532D] text-lg md:text-2xl font-black">84%</span>
                    <span class="text-gray-600 text-[10px] md:text-xs font-bold mt-1">Hadir</span>
                </div>
                <div class="bg-white rounded-2xl py-3 md:py-4 flex flex-col items-center border-2 border-blue-900 shadow-[-3px_3px_0_0_#1e3a8a] md:shadow-[-4px_4px_0_0_#1e3a8a]">
                    <span class="text-blue-800 text-lg md:text-2xl font-black">17</span>
                    <span class="text-gray-600 text-[10px] md:text-xs font-bold mt-1">Sesi</span>
                </div>
                <div class="bg-white rounded-2xl py-3 md:py-4 flex flex-col items-center border-2 border-red-900 shadow-[-3px_3px_0_0_#7f1d1d] md:shadow-[-4px_4px_0_0_#7f1d1d]">
                    <span class="text-red-800 text-lg md:text-2xl font-black">2</span>
                    <span class="text-gray-600 text-[10px] md:text-xs font-bold mt-1">Absen</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Right Column (Schedules) -->
    <div class="lg:col-span-8">
        <div class="bg-white rounded-[30px] p-6 md:p-10 border-4 border-[#14532D] shadow-[-8px_8px_0_0_#14532D] h-full">
            
            <div class="flex justify-between items-center mb-6 md:mb-8 border-b-4 border-gray-100 pb-4">
                <h2 class="text-2xl md:text-3xl font-black text-[#14532D] flex items-center gap-2">
                    <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Jadwal Hari Ini
                </h2>
                <div class="flex flex-col items-end gap-0.5">
                    <span id="realtime-date" class="text-sm md:text-base font-black text-[#14532D] tabular-nums"></span>
                    <span id="realtime-clock" class="text-xs font-black text-gray-400 tabular-nums">--:--:--</span>
                </div>
            </div>

            @if(count($jadwalList) > 0)
                <div class="space-y-6">
                    @foreach($jadwalList as $jadwal)
                        @php
                            $isHadir = $jadwal->status === 'Hadir';
                        @endphp
                        
                        <div class="bg-gray-50 border-2 border-gray-200 rounded-2xl p-6 hover:border-[#7E9D68] transition-colors flex flex-col md:flex-row justify-between md:items-center gap-4">
                            <div>
                                <h4 class="text-xl font-bold text-gray-800">{{ $jadwal->mata_kuliah }}</h4>
                                <div class="text-sm font-bold text-gray-500 mt-1 mb-2">{{ $jadwal->dosen }}</div>
                                <div class="flex items-center gap-4 mt-2">
                                    <div class="flex items-center text-[#14532D] font-black bg-[#14532D]/10 px-3 py-1 rounded-lg">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                    </div>
                                    <div class="flex items-center text-gray-600 font-bold">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ $jadwal->ruangan }}
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                @if($isHadir)
                                    <div class="bg-[#DCFCE7] text-[#14532D] px-5 py-2.5 rounded-xl font-black text-sm border-2 border-[#14532D] flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        SUDAH HADIR
                                    </div>
                                @else
                                    <a href="{{ route('presensi.web', $jadwal->id) }}" class="inline-block w-full md:w-auto bg-[#FFD54F] text-[#14532D] px-6 py-3 rounded-xl font-black text-sm border-2 border-[#14532D] shadow-[-4px_4px_0_0_#14532D] hover:translate-y-[2px] hover:translate-x-[-2px] hover:shadow-[-2px_2px_0_0_#14532D] transition-all text-center">
                                        <div class="flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            LAKUKAN PRESENSI
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-12 flex flex-col items-center justify-center text-gray-400">
                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-lg font-bold">Tidak ada jadwal hari ini.</p>
                </div>
            @endif

        </div>
    </div>
</div>

{{-- Toast Sukses Presensi --}}
@if(session('success'))
<div id="success-toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 bg-[#14532D] text-white px-6 py-4 rounded-2xl border-4 border-[#092A13] shadow-[-4px_4px_0_0_#092A13] flex items-center gap-3 font-bold text-sm transition-all">
    <svg class="w-6 h-6 text-[#FFD54F] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    <span>{{ session('success') }}</span>
</div>
@endif

<script>
    const hariList = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

    function updateClock() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        const d = String(now.getDate()).padStart(2, '0');
        const mo = String(now.getMonth() + 1).padStart(2, '0');
        const y = now.getFullYear();
        const hari = hariList[now.getDay()];

        const clockEl = document.getElementById('realtime-clock');
        const dateEl = document.getElementById('realtime-date');
        if (clockEl) clockEl.innerText = `${h}:${m}:${s} WIB`;
        if (dateEl) dateEl.innerText = `${hari}, ${d}/${mo}/${y}`;
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Auto-hide success toast after 4 seconds
    const toast = document.getElementById('success-toast');
    if (toast) {
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(-50%) translateY(20px)';
            setTimeout(() => toast.remove(), 500);
        }, 4000);
    }
</script>
@endsection