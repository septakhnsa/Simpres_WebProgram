<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Presensi Web</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-100 antialiased min-h-screen flex flex-col pb-20 md:pb-0">

    <!-- Top Navbar -->
    <nav class="bg-[#14532D] text-white py-3 px-4 md:py-4 md:px-8 flex justify-between items-center shadow-lg border-b-4 border-[#092A13] sticky top-0 z-50">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 md:gap-4">
            <div class="w-8 h-8 md:w-10 md:h-10 bg-white rounded-xl shadow-[-3px_3px_0_0_#FFD54F] md:shadow-[-4px_4px_0_0_#FFD54F] flex items-center justify-center border-2 border-[#14532D]">
                <svg class="w-5 h-5 md:w-6 md:h-6 text-[#14532D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h1 class="text-xl md:text-2xl font-black tracking-wider">PRESENSI<span class="text-[#FFD54F]">WEB</span></h1>
        </a>
        
        <div class="flex items-center gap-4 md:gap-6">
            <div class="hidden md:flex gap-6 font-bold text-sm">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-[#FFD54F] border-b-2 border-[#FFD54F]' : 'text-white/70 hover:text-white' }} pb-1 transition-colors">Dashboard</a>
                <a href="{{ route('history') }}" class="{{ request()->routeIs('history') ? 'text-[#FFD54F] border-b-2 border-[#FFD54F]' : 'text-white/70 hover:text-white' }} pb-1 transition-colors">Riwayat</a>
                <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'text-[#FFD54F] border-b-2 border-[#FFD54F]' : 'text-white/70 hover:text-white' }} pb-1 transition-colors">Profil</a>
            </div>
            
            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-1.5 px-3 md:py-2 md:px-5 rounded-lg border-2 border-[#092A13] shadow-[-3px_3px_0_0_#092A13] hover:translate-y-[2px] hover:translate-x-[-2px] hover:shadow-[-1px_1px_0_0_#092A13] transition-all text-xs md:text-sm">
                    KELUAR
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 p-4 md:p-6 lg:p-10 max-w-7xl mx-auto w-full">
        @yield('content')
    </main>

    <!-- Mobile Bottom Navigation -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t-4 border-[#14532D] shadow-[0_-4px_10px_rgba(0,0,0,0.1)] z-50 flex justify-around items-center h-16">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('dashboard') ? 'text-[#14532D] bg-[#14532D]/10' : 'text-gray-400' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="text-[10px] font-bold">Beranda</span>
        </a>
        <a href="{{ route('history') }}" class="flex flex-col items-center justify-center w-full h-full border-l-2 border-r-2 border-gray-100 {{ request()->routeIs('history') ? 'text-[#14532D] bg-[#14532D]/10' : 'text-gray-400' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-[10px] font-bold">Riwayat</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('profile.edit') ? 'text-[#14532D] bg-[#14532D]/10' : 'text-gray-400' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span class="text-[10px] font-bold">Profil</span>
        </a>
    </div>

</body>
</html>
