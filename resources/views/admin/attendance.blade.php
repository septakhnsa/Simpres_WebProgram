<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Live - {{ $schedule->mata_kuliah }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #0d2118; 
            color: #e2e8f0;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .transition-all-300 { transition: all 0.3s ease; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: rgba(0,0,0,0.2); }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.3); }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased">

<nav class="sticky top-0 z-50 bg-[#0a1811]/90 backdrop-blur-md border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <div class="flex items-center justify-between h-16 md:h-20">
            <div class="flex items-center gap-3 md:gap-4">
                <div class="bg-emerald-500/20 p-2 md:p-2.5 rounded-xl border border-emerald-500/30">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <div>
                    <h1 class="text-white font-bold text-lg md:text-xl tracking-tight">Presensi Live<span class="text-emerald-500">.</span></h1>
                </div>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 md:px-4 md:py-2 rounded-xl bg-white/5 hover:bg-white/10 text-gray-300 hover:text-white border border-white/10 transition-all-300 flex items-center gap-2 text-xs md:text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span class="hidden sm:inline">Kembali ke Dashboard</span>
            </a>
        </div>
    </div>
</nav>

<main class="flex-1 w-full max-w-7xl mx-auto px-4 md:px-6 py-6 md:py-8 space-y-6">
    
    <!-- Header Info Card -->
    <div class="glass-card rounded-2xl p-5 md:p-8 relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6 border-emerald-500/20">
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-1 bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 text-[10px] font-bold uppercase tracking-widest rounded">Mata Kuliah</span>
                <span class="px-2 py-1 bg-white/5 border border-white/10 text-gray-400 text-[10px] font-bold uppercase tracking-widest rounded">Sesi #{{ $schedule->id }}</span>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">{{ $schedule->mata_kuliah }}</h2>
            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400">
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    {{ $schedule->dosen }}
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ $schedule->hari }}, {{ $schedule->jam_mulai }} - {{ $schedule->jam_selesai }}
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Ruang {{ $schedule->ruangan }}
                </div>
            </div>
        </div>
        
        <div class="relative z-10 flex gap-4 md:flex-col shrink-0 text-center md:text-right">
            <div class="bg-black/30 rounded-xl px-6 py-3 border border-white/5">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Total Hadir</p>
                <p class="text-2xl font-bold text-emerald-400">{{ collect($data)->where('status', 'Hadir')->count() }}<span class="text-sm text-gray-500 ml-1">/ {{ count($data) }}</span></p>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="glass-card rounded-2xl overflow-hidden">
        
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-black/20 text-xs uppercase tracking-wider text-gray-400 font-semibold border-b border-white/5">
                        <th class="py-4 px-6 w-1/4">Mahasiswa</th>
                        <th class="py-4 px-6">Status Presensi</th>
                        <th class="py-4 px-6">Tracking Geolocation</th>
                        <th class="py-4 px-6 text-center">Validasi Kamera</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-sm">
                    @foreach($data as $item)
                    <tr class="hover:bg-white/5 transition-colors group">
                        <td class="py-4 px-6">
                            <p class="text-white font-semibold text-sm mb-0.5">{{ $item['mahasiswa']->name }}</p>
                            <p class="text-emerald-400/80 font-mono text-xs">{{ $item['mahasiswa']->nim }}</p>
                        </td>
                        <td class="py-4 px-6">
                            @if($item['status'] === 'Hadir')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 text-xs font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Terverifikasi
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-white/5 border border-white/10 text-gray-400 text-xs font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Belum Presensi
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @if($item['latitude'])
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $item['latitude'] }},{{ $item['longitude'] }}" target="_blank" class="inline-flex items-center gap-2 group/link">
                                    <div class="p-1.5 bg-blue-500/20 rounded-md group-hover/link:bg-blue-500 transition-colors">
                                        <svg class="w-4 h-4 text-blue-400 group-hover/link:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <div class="font-mono text-[11px] text-gray-400 group-hover/link:text-blue-300">
                                        <p>{{ number_format($item['latitude'], 5) }}</p>
                                        <p>{{ number_format($item['longitude'], 5) }}</p>
                                    </div>
                                </a>
                            @else
                                <span class="text-gray-600 text-xs">-</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 flex justify-center">
                            @if($item['photo_path'])
                    <a href="{{ asset('storage/' . $item['photo_path']) }}"
                    target="_blank"
                    class="relative w-14 h-14 rounded-lg overflow-hidden border border-white/20 group/img cursor-pointer block">
                        <img src="{{ asset('storage/' . $item['photo_path']) }}"
                            class="w-full h-full object-cover group-hover/img:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/img:opacity-100 transition-opacity flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </a>
                    @else
                    <div class="w-14 h-14 rounded-lg bg-black/20 border border-white/5 flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        </svg>
                    </div>
                    @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile View -->
        <div class="md:hidden divide-y divide-white/10">
            @foreach($data as $item)
            <div class="p-4 flex flex-col gap-3">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-bold text-white text-sm">{{ $item['mahasiswa']->name }}</h3>
                        <p class="text-emerald-400/80 font-mono text-xs mt-0.5">{{ $item['mahasiswa']->nim }}</p>
                    </div>
                    @if($item['status'] === 'Hadir')
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 text-[10px] font-bold uppercase tracking-wider shrink-0">
                            Verified
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-white/5 border border-white/10 text-gray-400 text-[10px] font-bold uppercase tracking-wider shrink-0">
                            Pending
                        </span>
                    @endif
                </div>

                <div class="flex items-center justify-between mt-2 pt-3 border-t border-white/5">
                    @if($item['latitude'])
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $item['latitude'] }},{{ $item['longitude'] }}" target="_blank" class="flex items-center gap-2 text-blue-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="font-mono text-[10px] underline underline-offset-2">Buka Peta</span>
                        </a>
                    @else
                        <span class="text-gray-600 text-[10px] uppercase tracking-wider font-bold">No Location Data</span>
                    @endif

                    @if($item['photo_path'])
                        <img src="{{ asset('storage/' . $item['photo_path']) }}" class="w-10 h-10 rounded-md object-cover border border-white/20" onclick="window.open(this.src)">
                    @else
                        <div class="w-10 h-10 rounded-md bg-black/20 border border-white/5 flex items-center justify-center">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>

</body>
</html>