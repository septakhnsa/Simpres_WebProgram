@extends('layouts.web-app')

@section('content')
<div class="bg-white rounded-[30px] p-8 md:p-10 border-4 border-[#14532D] shadow-[-8px_8px_0_0_#14532D] relative overflow-hidden">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between md:items-end mb-8 border-b-4 border-gray-100 pb-6 gap-4">
        <div>
            <h2 class="text-3xl font-black text-[#14532D] flex items-center gap-2">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Riwayat Presensi
            </h2>
            <p class="text-gray-500 font-bold mt-2">Daftar kehadiran Anda di semua mata kuliah.</p>
        </div>
        
        <div class="flex gap-2">
            <button class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl font-bold text-sm border-2 border-gray-300 hover:bg-gray-200 transition-colors">
                Bulan Ini
            </button>
            <button class="bg-[#14532D] text-[#FFD54F] px-4 py-2 rounded-xl font-bold text-sm border-2 border-[#14532D] shadow-[-2px_2px_0_0_#092A13]">
                Semua
            </button>
        </div>
    </div>

    <!-- History List -->
    <div class="space-y-4">
        @if(count($historyList) > 0)
            @foreach($historyList as $history)
                <div class="bg-gray-50 border-2 border-gray-200 rounded-2xl p-5 hover:border-[#7E9D68] transition-colors flex flex-col md:flex-row justify-between md:items-center gap-4">
                    
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 bg-[#7E9D68]/20 rounded-xl flex items-center justify-center border-2 border-[#7E9D68]">
                            <svg class="w-6 h-6 text-[#7E9D68]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">{{ $history->mataKuliah }}</h4>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-sm font-bold text-gray-500">{{ $history->tanggal }}</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                <span class="text-sm font-black text-[#14532D]">{{ $history->jamAbsen }} WIB</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="bg-[#DCFCE7] text-[#14532D] px-4 py-2 rounded-xl font-black text-xs border-2 border-[#14532D]">
                            {{ strtoupper($history->status) }}
                        </div>
                        <button onclick="showDetailModal('{{ asset('storage/' . $history->photo_path) }}', '{{ $history->latitude }}', '{{ $history->longitude }}')" class="w-10 h-10 bg-white border-2 border-gray-300 rounded-xl flex items-center justify-center text-gray-500 hover:text-[#14532D] hover:border-[#14532D] transition-colors" title="Lihat Bukti">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            <div class="py-16 flex flex-col items-center justify-center text-gray-400">
                <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-lg font-bold">Belum ada riwayat presensi.</p>
            </div>
        @endif
    </div>

</div>

<!-- Modal Detail Presensi -->
<div id="detailModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-[30px] border-4 border-[#14532D] shadow-[-8px_8px_0_0_#14532D] w-full max-w-sm overflow-hidden flex flex-col">
        <div class="bg-[#14532D] p-4 flex justify-between items-center">
            <h3 class="text-white font-black text-lg">Bukti Kehadiran</h3>
            <button onclick="closeDetailModal()" class="text-white/80 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6 flex flex-col items-center">
            <img id="modalPhoto" src="" alt="Bukti Foto" class="w-full h-48 object-cover rounded-xl border-4 border-gray-200 mb-4 bg-gray-100">
            <div class="w-full bg-gray-50 p-4 rounded-xl border-2 border-gray-200">
                <p class="text-xs text-gray-500 font-bold mb-1">Koordinat GPS:</p>
                <p id="modalLocation" class="text-sm font-black text-gray-800 break-all"></p>
                <a id="modalMapLink" href="#" target="_blank" class="text-xs text-blue-600 font-bold mt-2 inline-block hover:underline">Buka di Google Maps ↗</a>
            </div>
        </div>
    </div>
</div>

<script>
    function showDetailModal(photoUrl, lat, lng) {
        document.getElementById('modalPhoto').src = photoUrl;
        document.getElementById('modalLocation').innerText = `${lat}, ${lng}`;
        document.getElementById('modalMapLink').href = `https://www.google.com/maps/search/?api=1&query=${lat},${lng}`;
        
        const modal = document.getElementById('detailModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function closeDetailModal() {
        const modal = document.getElementById('detailModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection
