<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Presensi - Lupa Password</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col p-8 md:p-10 relative text-center">
        
        <!-- Padlock Icon -->
        <div class="mx-auto w-24 h-24 bg-[#14532D] rounded-[2rem] flex items-center justify-center mb-6 shadow-lg shadow-green-900/20">
            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>

        <h1 class="text-2xl font-black text-gray-800 mb-2">Lupa Password?</h1>
        <p class="text-gray-500 text-sm font-semibold mb-8">
            Masukkan email aktif Anda. Kami akan kirimkan link reset password untuk verifikasi.
        </p>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6 text-left">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-5 py-3.5 bg-white border-2 border-gray-300 rounded-full focus:outline-none focus:border-[#14532D] focus:ring-0 transition-colors text-gray-800 font-semibold text-sm placeholder-gray-400" 
                       placeholder="email@kampus.ac.id">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 font-semibold text-sm" />
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-[#14532D] hover:bg-[#092A13] text-white text-base font-bold py-3.5 px-6 rounded-full transition-colors shadow-md">
                    Kirim Link Reset Password
                </button>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-gray-500 hover:text-[#14532D] text-sm font-bold transition-colors">
                    ← Kembali ke Login
                </a>
            </div>
        </form>

    </div>
</body>
</html>
