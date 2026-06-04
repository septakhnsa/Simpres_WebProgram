<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIMPRES</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #0d2118; /* Dark green background */
            color: #e2e8f0;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .glass-card:hover {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -10px rgba(0,0,0,0.5);
        }
        .transition-all-300 { transition: all 0.3s ease; }
        
        /* Custom scrollbar for dark theme */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: rgba(0,0,0,0.2); }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.3); }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased">

{{-- TOP NAVIGATION --}}
<nav class="sticky top-0 z-50 bg-[#0a1811]/90 backdrop-blur-md border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <div class="flex items-center justify-between h-16 md:h-20">
            <!-- Brand -->
            <div class="flex items-center gap-3 md:gap-4">
                <div class="bg-emerald-500/20 p-2 md:p-2.5 rounded-xl border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.2)]">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-white font-bold text-lg md:text-xl tracking-tight">SIMPRESENSI<span class="text-emerald-500">.</span></h1>
                    <p class="text-emerald-200/60 text-[10px] md:text-xs hidden sm:block uppercase tracking-wider font-semibold">Admin Command Center</p>
                </div>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-4 md:gap-6">
                <!-- Clock hidden on mobile -->
                <div class="hidden lg:flex items-center gap-2 text-sm font-medium text-emerald-100/70 border-r border-white/10 pr-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span id="nav-clock">Loading...</span>
                </div>
                
                <!-- User Profile -->
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-white font-semibold text-sm">{{ auth()->user()->name }}</p>
                        <p class="text-emerald-400/80 text-xs">Administrator</p>
                    </div>
                    <div class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-gradient-to-tr from-emerald-600 to-teal-400 p-[2px] shadow-[0_0_10px_rgba(16,185,129,0.3)]">
                        <div class="w-full h-full rounded-full bg-[#0a1811] flex items-center justify-center">
                            <span class="text-emerald-400 font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="ml-1 md:ml-2">
                    @csrf
                    <button type="submit" class="p-2 md:px-4 md:py-2 rounded-xl bg-white/5 hover:bg-red-500/20 text-gray-300 hover:text-red-400 border border-transparent hover:border-red-500/30 transition-all-300 group flex items-center gap-2">
                        <svg class="w-5 h-5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="hidden md:block text-sm font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

{{-- SUB NAVIGATION TABS --}}
<div class="bg-[#0a1811] border-b border-white/5">
    <div class="max-w-7xl mx-auto px-4 md:px-6 flex gap-6 md:gap-8 overflow-x-auto no-scrollbar">
        <a href="{{ route('admin.dashboard') }}" class="py-4 text-emerald-400 text-sm font-semibold border-b-2 border-emerald-500 flex items-center gap-2 whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            Live Dashboard
        </a>
        <a href="{{ route('admin.report') }}" class="py-4 text-gray-400 hover:text-white text-sm font-medium transition-colors flex items-center gap-2 whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Laporan & Rekap
        </a>
    </div>
</div>

<main class="flex-1 w-full max-w-7xl mx-auto px-4 md:px-6 py-6 md:py-8 space-y-6 md:space-y-8">
    
    {{-- STATISTIC WIDGETS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
        <!-- Widget 1: Users -->
        <div class="glass-card rounded-2xl p-5 md:p-6 transition-all-300 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl -mr-10 -mt-10 group-hover:bg-blue-500/20 transition-all"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div>
                    <p class="text-gray-400 text-xs md:text-sm font-semibold uppercase tracking-wider mb-1">Total Mahasiswa</p>
                    <h3 class="text-3xl md:text-4xl font-bold text-white">{{ $totalMahasiswa }}<span class="text-blue-400 text-lg ml-1">Akun</span></h3>
                </div>
                <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center border border-blue-500/30">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
            <div class="w-full bg-white/5 rounded-full h-1.5 mt-2">
                <div class="bg-blue-500 h-1.5 rounded-full" style="width: 100%"></div>
            </div>
        </div>

        <!-- Widget 2: Schedules -->
        <div class="glass-card rounded-2xl p-5 md:p-6 transition-all-300 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-3xl -mr-10 -mt-10 group-hover:bg-purple-500/20 transition-all"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div>
                    <p class="text-gray-400 text-xs md:text-sm font-semibold uppercase tracking-wider mb-1">Mata Kuliah</p>
                    <h3 class="text-3xl md:text-4xl font-bold text-white">{{ $totalJadwal }}<span class="text-purple-400 text-lg ml-1">Kelas</span></h3>
                </div>
                <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center border border-purple-500/30">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
            </div>
            <div class="w-full bg-white/5 rounded-full h-1.5 mt-2">
                <div class="bg-purple-500 h-1.5 rounded-full" style="width: 100%"></div>
            </div>
        </div>

        <!-- Widget 3: Live Attendance -->
        <div class="glass-card rounded-2xl p-5 md:p-6 transition-all-300 relative overflow-hidden group border-emerald-500/30">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl -mr-10 -mt-10 group-hover:bg-emerald-500/20 transition-all"></div>
            <div class="absolute top-4 right-4 flex items-center gap-1.5 px-2 py-1 bg-emerald-500/20 border border-emerald-500/30 rounded-md">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider">Live</span>
            </div>
            <div class="flex items-center justify-between mb-4 relative z-10 mt-2">
                <div>
                    <p class="text-gray-400 text-xs md:text-sm font-semibold uppercase tracking-wider mb-1">Presensi Masuk</p>
                    <h3 class="text-3xl md:text-4xl font-bold text-white">{{ $totalHadir }}<span class="text-emerald-400 text-lg ml-1">Data</span></h3>
                </div>
            </div>
            <div class="w-full bg-white/5 rounded-full h-1.5 mt-2 overflow-hidden">
                @php
                    $percentage = ($totalMahasiswa > 0 && $totalJadwal > 0) ? number_format(($totalHadir / ($totalMahasiswa * $totalJadwal)) * 100, 2) : 0;
                @endphp
                <div class="bg-emerald-500 h-1.5 rounded-full relative" @style(['width: ' . $percentage . '%'])>
                    <div class="absolute top-0 right-0 bottom-0 left-0 bg-white/20 animate-pulse"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT GRID --}}
    <div class="grid grid-cols-1 gap-6 md:gap-8">
        
        <!-- Live Schedule Table -->
        <div class="glass-card rounded-3xl overflow-hidden flex flex-col">
            <!-- Header -->
            <div class="p-5 md:p-6 border-b border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white/[0.02]">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/5 rounded-lg border border-white/10">
                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    </div>
                    <div>
                        <h2 class="text-white font-bold text-lg">Manajemen Sesi Mata Kuliah</h2>
                        <p class="text-gray-400 text-xs mt-0.5">Pantau data kehadiran mahasiswa secara real-time</p>
                    </div>
                </div>
                <div class="text-sm font-medium text-emerald-400 bg-emerald-400/10 px-3 py-1.5 rounded-lg border border-emerald-400/20 inline-block w-fit">
                    Total {{ $schedules->count() }} Jadwal Aktif
                </div>
            </div>

            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-black/20 text-xs uppercase tracking-wider text-gray-400 font-semibold border-b border-white/5">
                            <th class="py-4 px-6 w-16 text-center">ID</th>
                            <th class="py-4 px-6">Informasi Mata Kuliah</th>
                            <th class="py-4 px-6">Jadwal & Ruangan</th>
                            <th class="py-4 px-6 text-right">Status Presensi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm">
                        @foreach($schedules as $index => $schedule)
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="py-4 px-6 text-center">
                                <span class="text-gray-500 font-mono">#{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-white font-semibold text-base mb-0.5 group-hover:text-emerald-400 transition-colors">{{ $schedule->mata_kuliah }}</p>
                                <div class="flex items-center gap-1.5 text-gray-400 text-xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    {{ $schedule->dosen }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-col gap-1.5">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-white/5 text-gray-300 w-fit text-xs font-medium border border-white/10">
                                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ $schedule->hari }}, {{ $schedule->jam_mulai }} - {{ $schedule->jam_selesai }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-white/5 text-gray-300 w-fit text-xs font-medium border border-white/10">
                                        <svg class="w-3.5 h-3.5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        Ruang {{ $schedule->ruangan }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center justify-end gap-3 opacity-80 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.attendance', $schedule->id) }}" class="px-4 py-2 bg-emerald-500/20 hover:bg-emerald-500 border border-emerald-500/30 hover:border-emerald-500 text-emerald-400 hover:text-white rounded-lg text-xs font-semibold transition-all-300 flex items-center gap-2 shadow-[0_0_15px_rgba(16,185,129,0.1)] hover:shadow-[0_0_20px_rgba(16,185,129,0.3)]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Pantau Live
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile List View -->
            <div class="md:hidden divide-y divide-white/10">
                @foreach($schedules as $schedule)
                <div class="p-4 flex flex-col gap-3 relative overflow-hidden">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-white text-base">{{ $schedule->mata_kuliah }}</h3>
                            <p class="text-gray-400 text-xs mt-0.5">{{ $schedule->dosen }}</p>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-white/5 border border-white/10 text-[11px] text-gray-300 font-medium">
                            <svg class="w-3 h-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $schedule->hari }}, {{ $schedule->jam_mulai }}
                        </span>
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded bg-white/5 border border-white/10 text-[11px] text-gray-300 font-medium">
                            <svg class="w-3 h-3 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Ruang {{ $schedule->ruangan }}
                        </span>
                    </div>

                    <a href="{{ route('admin.attendance', $schedule->id) }}" class="mt-2 w-full py-2.5 bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 text-center rounded-lg text-xs font-semibold flex items-center justify-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Pantau Data Presensi
                    </a>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</main>

<script>
    function updateClock() {
        const now = new Date();
        const opts = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute:'2-digit', second:'2-digit', timeZoneName: 'short' };
        const el = document.getElementById('nav-clock');
        if (el) el.textContent = now.toLocaleDateString('id-ID', opts);
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>

</body>
</html>