@extends('layouts.web-app')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('dashboard') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center border-2 border-gray-300 hover:bg-gray-50 transition-colors shadow-sm">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div>
            <h2 class="text-3xl font-black text-[#14532D] flex items-center gap-2">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Profil Saya
            </h2>
            <p class="text-gray-500 font-bold mt-2">Kelola informasi akun dan keamanan Anda.</p>
        </div>
    </div>

    <!-- Profile Avatar Card -->
    <div class="bg-[#7E9D68] rounded-[30px] p-8 border-4 border-[#14532D] shadow-[-8px_8px_0_0_#14532D] flex flex-col md:flex-row items-center gap-8">
        <div class="w-32 h-32 rounded-full border-4 border-white overflow-hidden shadow-lg bg-gray-300 shrink-0">
            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=200&auto=format&fit=crop" alt="Profile" class="w-full h-full object-cover">
        </div>
        <div class="text-center md:text-left">
            <h3 class="text-white text-2xl font-black">{{ Auth::user()->name }}</h3>
            <p class="text-white/80 font-bold mt-1">{{ Auth::user()->email }}</p>
            <div class="mt-3 bg-white/20 text-white px-4 py-1.5 rounded-full font-bold text-sm inline-block">
                Mahasiswa Aktif
            </div>
        </div>
    </div>

    <!-- Update Info Form -->
    <div class="bg-white rounded-[30px] p-8 md:p-10 border-4 border-[#14532D] shadow-[-8px_8px_0_0_#14532D]">
        <h3 class="text-xl font-black text-[#14532D] mb-6 border-b-4 border-gray-100 pb-4">Informasi Profil</h3>

        <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
            @csrf
            @method('patch')

            <div>
                <label for="name" class="block text-[#14532D] text-sm font-bold mb-2">Nama Lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name', Auth::user()->name) }}" required
                       class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl focus:outline-none focus:border-[#14532D] transition-colors text-gray-800 font-semibold">
                @error('name') <p class="mt-2 text-red-600 font-semibold text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-[#14532D] text-sm font-bold mb-2">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', Auth::user()->email) }}" required
                       class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl focus:outline-none focus:border-[#14532D] transition-colors text-gray-800 font-semibold">
                @error('email') <p class="mt-2 text-red-600 font-semibold text-sm">{{ $message }}</p> @enderror
            </div>

            @if (session('status') === 'profile-updated')
                <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4 text-green-800 font-bold text-sm">
                    Profil berhasil diperbarui!
                </div>
            @endif

            <div class="pt-2">
                <button type="submit" class="bg-[#FFD54F] text-[#14532D] font-black py-4 px-8 rounded-2xl shadow-[-6px_6px_0_0_#14532D] hover:translate-y-[2px] hover:translate-x-[-2px] hover:shadow-[-4px_4px_0_0_#14532D] transition-all border-4 border-[#14532D]">
                    SIMPAN PERUBAHAN
                </button>
            </div>
        </form>
    </div>

    <!-- Update Password Form -->
    <div class="bg-white rounded-[30px] p-8 md:p-10 border-4 border-[#14532D] shadow-[-8px_8px_0_0_#14532D]">
        <h3 class="text-xl font-black text-[#14532D] mb-6 border-b-4 border-gray-100 pb-4">Ubah Password</h3>

        <form method="post" action="{{ route('password.update') }}" class="space-y-5">
            @csrf
            @method('put')

            <div>
                <label for="current_password" class="block text-[#14532D] text-sm font-bold mb-2">Password Saat Ini</label>
                <input id="current_password" name="current_password" type="password"
                       class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl focus:outline-none focus:border-[#14532D] transition-colors text-gray-800 font-semibold"
                       placeholder="••••••••">
                @error('current_password', 'updatePassword') <p class="mt-2 text-red-600 font-semibold text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-[#14532D] text-sm font-bold mb-2">Password Baru</label>
                <input id="password" name="password" type="password"
                       class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl focus:outline-none focus:border-[#14532D] transition-colors text-gray-800 font-semibold"
                       placeholder="Minimal 8 karakter">
                @error('password', 'updatePassword') <p class="mt-2 text-red-600 font-semibold text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-[#14532D] text-sm font-bold mb-2">Konfirmasi Password Baru</label>
                <input id="password_confirmation" name="password_confirmation" type="password"
                       class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl focus:outline-none focus:border-[#14532D] transition-colors text-gray-800 font-semibold"
                       placeholder="Ulangi password baru">
            </div>

            @if (session('status') === 'password-updated')
                <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4 text-green-800 font-bold text-sm">
                    Password berhasil diubah!
                </div>
            @endif

            <div class="pt-2">
                <button type="submit" class="bg-[#14532D] text-white font-black py-4 px-8 rounded-2xl shadow-[-6px_6px_0_0_#092A13] hover:translate-y-[2px] hover:translate-x-[-2px] hover:shadow-[-4px_4px_0_0_#092A13] transition-all border-4 border-[#092A13]">
                    UBAH PASSWORD
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
