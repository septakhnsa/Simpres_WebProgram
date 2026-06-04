{{-- FILE: resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Sistem Presensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <script>
        tailwind.config = {
            theme: { extend: { colors: {
                primary: { DEFAULT: '#1A3557', med: '#2563EB', pale: '#DBEAFE' }
            }}}
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen">

{{-- ── Navbar ─────────────────────────────────────────────── --}}
<nav class="bg-[#1A3557] text-white shadow-lg fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
        <div class="flex items-center gap-3">
            <div class="bg-blue-500 rounded-lg w-8 h-8 flex items-center justify-center">
                <i class="fas fa-check-double text-white text-sm"></i>
            </div>
            <span class="font-bold text-lg tracking-wide">SistemPresensi</span>
            <span class="text-blue-300 text-xs hidden sm:block">| Admin Panel</span>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                <p class="text-xs text-blue-300">Administrator</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="hidden sm:inline">Logout</span>
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- ── Layout ──────────────────────────────────────────────── --}}
<div class="pt-16 flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-56 bg-white shadow-md fixed left-0 top-16 bottom-0 overflow-y-auto">
        <div class="p-4">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Menu Admin</p>
            <nav class="space-y-1">
                @php
                $menu = [
                    ['route' => 'admin.dashboard',      'icon' => 'fa-home',           'label' => 'Dashboard'],
                    ['route' => 'admin.mahasiswa.index', 'icon' => 'fa-users',          'label' => 'Mahasiswa'],
                    ['route' => 'admin.lokasi.index',    'icon' => 'fa-map-marker-alt', 'label' => 'Lokasi'],
                    ['route' => 'admin.jadwal.index',    'icon' => 'fa-calendar-alt',   'label' => 'Jadwal'],
                    ['route' => 'admin.rekap.index',     'icon' => 'fa-table',          'label' => 'Rekap Presensi'],
                ];
                @endphp
                @foreach($menu as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs($item['route']) ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <i class="fas {{ $item['icon'] }} w-4 text-center"></i>
                    {{ $item['label'] }}
                </a>
                @endforeach
            </nav>
        </div>

        {{-- Info di bawah sidebar --}}
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t bg-gray-50">
            <p class="text-xs text-gray-400 text-center">Kelompok 11 — STMIK</p>
            <p class="text-xs text-gray-400 text-center">Web Programming Lanjutan</p>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="ml-56 flex-1 p-6">

        {{-- Flash messages --}}
        @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2 shadow-sm">
            <i class="fas fa-check-circle text-green-500"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif
        @if(session('error'))
        <div class="mb-4 bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2 shadow-sm">
            <i class="fas fa-exclamation-circle text-red-500"></i>
            <span>{{ session('error') }}</span>
        </div>
        @endif
        @if($errors->any())
        <div class="mb-4 bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg shadow-sm">
            <p class="font-semibold flex items-center gap-2"><i class="fas fa-times-circle text-red-500"></i> Terjadi kesalahan:</p>
            <ul class="list-disc list-inside mt-1 text-sm">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>
