<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Presensi - Pendaftaran</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-[#14532D] min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-6xl bg-white rounded-[40px] shadow-[0_20px_0_0_#092A13] overflow-hidden flex flex-col md:flex-row border-4 border-[#092A13]">
        
        <!-- Left Side: Branding -->
        <div class="md:w-5/12 bg-[#7E9D68] p-12 flex flex-col justify-center items-center text-center relative overflow-hidden border-b-4 md:border-b-0 md:border-r-4 border-[#092A13]">
            <div class="absolute -top-20 -left-20 w-64 h-64 bg-[#FFD54F] rounded-full mix-blend-multiply filter blur-xl opacity-70"></div>
            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-[#14532D] rounded-full mix-blend-multiply filter blur-xl opacity-70"></div>
            
            <div class="w-32 h-32 bg-white rounded-3xl shadow-[-8px_8px_0_0_#14532D] flex items-center justify-center mb-10 z-10 border-4 border-[#14532D]">
                <svg class="w-16 h-16 text-[#14532D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            </div>
            
            <h1 class="text-white text-4xl font-black mb-4 z-10 tracking-wide drop-shadow-md">Bergabung Bersama Kami</h1>
            <p class="text-white/90 text-lg font-bold z-10">Daftarkan diri Anda untuk mengakses sistem presensi online.</p>
        </div>

        <!-- Right Side: Register Form -->
        <div class="md:w-7/12 p-8 md:p-16 flex flex-col justify-center">
            
            <div class="mb-8">
                <h2 class="text-3xl font-black text-[#14532D] mb-2">Buat Akun Baru</h2>
                <p class="text-gray-500 font-semibold text-lg">Lengkapi data diri Anda di bawah ini.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-[#14532D] text-sm font-bold mb-1">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                           class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#14532D] focus:ring-0 transition-colors text-gray-800 font-semibold" 
                           placeholder="Nama lengkap Anda">
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600 font-semibold" />
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-[#14532D] text-sm font-bold mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                           class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#14532D] focus:ring-0 transition-colors text-gray-800 font-semibold" 
                           placeholder="Alamat email aktif">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600 font-semibold" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-[#14532D] text-sm font-bold mb-1">Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autocomplete="new-password" 
                               class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#14532D] focus:ring-0 transition-colors text-gray-800 font-semibold pr-12" 
                               placeholder="Minimal 8 karakter">
                        <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#14532D] transition-colors focus:outline-none">
                            <svg id="password-eye" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600 font-semibold" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-[#14532D] text-sm font-bold mb-1">Konfirmasi Password</label>
                    <div class="relative">
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                               class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-[#14532D] focus:ring-0 transition-colors text-gray-800 font-semibold pr-12" 
                               placeholder="Ulangi password">
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#14532D] transition-colors focus:outline-none">
                            <svg id="password_confirmation-eye" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600 font-semibold" />
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full bg-[#FFD54F] text-[#14532D] text-lg font-black py-4 px-6 rounded-2xl shadow-[-6px_6px_0_0_#14532D] hover:translate-y-[2px] hover:translate-x-[-2px] hover:shadow-[-4px_4px_0_0_#14532D] transition-all border-4 border-[#14532D]">
                        DAFTAR
                    </button>
                </div>
            </form>
            
            <div class="mt-8 text-center">
                <p class="text-gray-500 font-semibold">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-[#14532D] font-black underline hover:text-[#7E9D68] transition-colors">Masuk di sini</a>
                </p>
            </div>
            
        </div>
    </div>
    
    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const eyeIcon = document.getElementById(inputId + '-eye');
            
            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
            } else {
                input.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        }
    </script>
</body>
</html>
