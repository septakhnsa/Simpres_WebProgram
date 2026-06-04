<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Kehadiran - SIMPRESENSI</title>
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

{{-- TOP NAVIGATION --}}
<nav class="sticky top-0 z-50 bg-[#0a1811]/90 backdrop-blur-md border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <div class="flex items-center justify-between h-16 md:h-20">
            <div class="flex items-center gap-3 md:gap-4">
                <div class="bg-emerald-500/20 p-2 md:p-2.5 rounded-xl border border-emerald-500/30">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <h1 class="text-white font-bold text-lg md:text-xl tracking-tight">Laporan Rekap<span class="text-emerald-500">.</span></h1>
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
    
    <!-- Data Table -->
    <div class="glass-card rounded-2xl overflow-hidden flex flex-col relative border-emerald-500/20">
        <div class="absolute top-0 left-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl -ml-20 -mt-20 pointer-events-none"></div>
        
        <div class="p-5 md:p-6 border-b border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white/[0.02] relative z-10">
            <div>
                <h2 class="text-white font-bold text-lg">Matriks Kehadiran Global</h2>
                <p class="text-gray-400 text-xs mt-0.5">Ringkasan total kehadiran seluruh mahasiswa di semua mata kuliah aktif.</p>
            </div>
            <div class="text-sm font-medium text-emerald-400 bg-emerald-400/10 px-4 py-2 rounded-lg border border-emerald-400/20 inline-block w-fit whitespace-nowrap shadow-[0_0_15px_rgba(16,185,129,0.1)]">
                Live Data Report
            </div>
        </div>

        <div class="overflow-x-auto relative z-10">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-black/20 text-[11px] uppercase tracking-wider text-gray-400 font-bold border-b border-white/5">
                        <th class="py-4 px-6 sticky left-0 bg-[#0d2118]/90 backdrop-blur-sm z-10 border-r border-white/5 shadow-[4px_0_15px_rgba(0,0,0,0.2)]">Mahasiswa</th>
                        @foreach($schedules as $schedule)
                            <th class="py-4 px-4 text-center border-r border-white/5 w-32">
                                <span class="block truncate max-w-[120px]" title="{{ $schedule->mata_kuliah }}">{{ $schedule->mata_kuliah }}</span>
                            </th>
                        @endforeach
                        <th class="py-4 px-6 text-center w-32 bg-white/5">Total Skor</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-sm">
                    @foreach($report as $item)
                    <tr class="hover:bg-white/5 transition-colors group">
                        <td class="py-4 px-6 sticky left-0 bg-[#0d2118] group-hover:bg-[#12281e] transition-colors z-10 border-r border-white/5 shadow-[4px_0_15px_rgba(0,0,0,0.2)]">
                            <p class="text-white font-semibold text-sm mb-0.5 whitespace-nowrap">{{ $item['mahasiswa']->name }}</p>
                            <p class="text-emerald-400/80 font-mono text-xs whitespace-nowrap">{{ $item['mahasiswa']->nim }}</p>
                        </td>
                        @foreach($item['detail'] as $d)
                            <td class="py-4 px-4 text-center border-r border-white/5">
                                @if($d['status'] === 'Hadir')
                                    <div class="w-8 h-8 mx-auto rounded-full bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center shadow-[0_0_10px_rgba(16,185,129,0.2)]">
                                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                @else
                                    <div class="w-8 h-8 mx-auto rounded-full bg-white/5 border border-white/10 flex items-center justify-center">
                                        <span class="w-2 h-2 rounded-full bg-gray-600"></span>
                                    </div>
                                @endif
                            </td>
                        @endforeach
                        <td class="py-4 px-6 text-center bg-white/5">
                            <div class="inline-flex items-center justify-center min-w-[3.5rem] px-3 py-1.5 bg-blue-500/20 border border-blue-500/30 rounded-lg text-blue-400 font-bold font-mono shadow-[0_0_10px_rgba(59,130,246,0.15)]">
                                {{ $item['total_hadir'] }} <span class="text-gray-500 mx-1">/</span> {{ $item['total_jadwal'] }}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="p-4 bg-black/20 border-t border-white/5 text-center sm:text-left">
            <p class="text-xs text-gray-500 font-medium">© {{ now()->year }} SIMPRESENSI Command Center — Data dikalkulasi secara realtime.</p>
        </div>
    </div>
</main>

</body>
</html>