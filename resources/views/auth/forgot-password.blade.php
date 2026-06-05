<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lupa Password - Presensi</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-[#092A13] min-h-screen flex items-center justify-center p-6">

    <!-- CARD -->
    <div class="w-full max-w-md bg-white rounded-[30px] border-4 border-[#14532D] shadow-[-8px_8px_0_0_#14532D] p-8 md:p-10 relative overflow-hidden">

        <!-- HEADER ACCENT -->
        <div class="absolute top-0 left-0 w-full h-20 bg-[#7E9D68] border-b-4 border-[#14532D]"></div>

        <div class="relative z-10 text-center">

            <!-- ICON -->
            <div class="mx-auto w-24 h-24 bg-[#14532D] rounded-2xl flex items-center justify-center mb-6 border-4 border-white shadow-lg">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>

            <!-- TITLE -->
            <h1 class="text-2xl font-black text-[#14532D] mb-2">
                Lupa Password?
            </h1>

            <p class="text-gray-500 font-semibold text-sm mb-8">
                Masukkan email Anda, kami akan kirim link reset password.
            </p>

            <!-- STATUS -->
            <x-auth-session-status class="mb-4 text-sm font-bold text-[#14532D]" :status="session('status')" />

            <!-- FORM -->
            <form method="POST" action="{{ route('password.email') }}" class="space-y-6 text-left">
                @csrf

                <!-- EMAIL -->
                <div>
                    <label for="email" class="block text-sm font-black text-gray-700 mb-2">
                        Email
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        placeholder="email@kampus.ac.id"
                        class="w-full px-5 py-3 bg-white border-2 border-gray-300 rounded-xl font-bold text-sm
                               focus:outline-none focus:border-[#14532D] transition"
                    />

                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 font-bold text-sm" />
                </div>

                <!-- BUTTON -->
                <button type="submit"
                        class="w-full bg-[#FFD54F] text-[#14532D] font-black py-3 rounded-xl border-2 border-[#14532D]
                               shadow-[-4px_4px_0_0_#14532D] hover:translate-y-[2px] hover:shadow-none transition-all">
                    KIRIM LINK RESET PASSWORD
                </button>

                <!-- BACK LINK (NO ICON) -->
                <div class="text-center pt-2">
                    <a href="{{ route('login') }}"
                       class="text-gray-600 hover:text-[#14532D] font-bold text-sm transition">
                        Kembali ke Login
                    </a>
                </div>

            </form>

        </div>
    </div>

</body>
</html>