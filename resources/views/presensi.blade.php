@extends('layouts.web-app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-[30px] p-6 md:p-10 border-4 border-[#14532D] shadow-[-8px_8px_0_0_#14532D]">
        
        <div class="flex items-center gap-4 mb-6 md:mb-8 border-b-4 border-gray-100 pb-4">
            <a href="{{ route('dashboard') }}" class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center border-2 border-gray-300 hover:bg-gray-200 transition-colors shrink-0">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-[#14532D] flex items-center gap-2">
                    <svg class="w-6 h-6 md:w-7 md:h-7 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Konfirmasi Kehadiran
                </h2>
                <p class="text-sm md:text-base text-gray-500 font-bold mt-1">Arahkan wajah Anda ke kamera dan pastikan GPS aktif.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Camera Section -->
            <div class="space-y-4">
                <div class="bg-gray-900 rounded-[24px] aspect-[4/5] border-4 border-[#14532D] shadow-[-6px_6px_0_0_#14532D] overflow-hidden relative flex items-center justify-center group">
                    
                    <!-- Real HTML5 Camera Feed -->
                    <video id="camera-feed" autoplay playsinline class="absolute inset-0 w-full h-full object-cover"></video>
                    
                    <!-- Loading State -->
                    <div id="camera-loading" class="absolute inset-0 bg-gray-800 flex flex-col items-center justify-center text-white/70">
                        <svg class="w-12 h-12 animate-pulse mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        <span class="text-sm font-bold">Meminta akses kamera...</span>
                    </div>
                    
                    <!-- Face Detection Overlay Guide -->
                    <div class="absolute inset-0 border-4 border-dashed border-[#FFD54F]/60 m-8 rounded-[40px] pointer-events-none"></div>
                    
                    <div class="absolute bottom-4 left-0 w-full text-center">
                        <span id="camera-status" class="bg-[#14532D]/80 backdrop-blur text-white text-xs font-bold px-3 py-1.5 rounded-full">Kamera Menunggu</span>
                    </div>
                </div>
            </div>

            <!-- Info Section -->
            <div class="flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4 flex items-start gap-3 transition-colors" id="gps-container">
                        <svg class="w-6 h-6 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <h4 class="font-bold text-blue-900" id="gps-title">Validasi Lokasi (GPS)</h4>
                            <p class="text-sm font-semibold text-blue-700 mt-1" id="gps-status">Sedang mendeteksi lokasi Anda...</p>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 border-2 border-gray-200 rounded-xl p-4">
                        <h4 class="font-bold text-gray-700 mb-2">Detail Jadwal:</h4>
                        <div class="space-y-2 text-sm font-semibold text-gray-600">
                            <!-- In a real app, this would be passed from controller -->
                            <p>Mata Kuliah: <span class="text-gray-900 font-bold">{{ $jadwal->mata_kuliah }}</span></p>
                            <p>Ruangan: <span class="text-gray-900 font-bold">{{ $jadwal->ruangan }}</span></p>
                        </div>
                    </div>
                </div>
                
                <form action="{{ route('presensi.web.submit', $jadwal->id) }}" method="POST" id="presensi-form" class="pt-4">
                    @csrf
                    <input type="hidden" name="latitude" id="input-lat">
                    <input type="hidden" name="longitude" id="input-lng">
                    <input type="hidden" name="photo" id="input-photo">
                    
                    <button type="submit" id="btn-submit" disabled class="w-full bg-gray-300 text-gray-500 cursor-not-allowed px-6 py-4 rounded-2xl font-black text-lg border-4 border-gray-400 shadow-none transition-all flex items-center justify-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        MENUNGGU HARDWARE...
                    </button>
                    <p class="text-center text-xs font-bold text-gray-400 mt-4">Sistem memerlukan akses Kamera & GPS untuk presensi valid.</p>
                </form>
            </div>
        </div>
        
    </div>
</div>

<!-- Hidden Canvas for capturing photo -->
<canvas id="camera-canvas" class="hidden"></canvas>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('camera-feed');
    const canvas = document.getElementById('camera-canvas');
    const cameraLoading = document.getElementById('camera-loading');
    const cameraStatus = document.getElementById('camera-status');
    const gpsStatus = document.getElementById('gps-status');
    const gpsTitle = document.getElementById('gps-title');
    const gpsContainer = document.getElementById('gps-container');
    const btnSubmit = document.getElementById('btn-submit');
    const form = document.getElementById('presensi-form');
    
    const inputLat = document.getElementById('input-lat');
    const inputLng = document.getElementById('input-lng');
    const inputPhoto = document.getElementById('input-photo');
    
    let cameraReady = false;
    let gpsReady = false;

    function checkReady() {
        if (cameraReady && gpsReady) {
            btnSubmit.disabled = false;
            btnSubmit.className = "w-full bg-[#14532D] text-[#FFD54F] px-6 py-4 rounded-2xl font-black text-lg border-4 border-[#092A13] shadow-[-6px_6px_0_0_#092A13] hover:translate-y-[2px] hover:translate-x-[-2px] hover:shadow-[-4px_4px_0_0_#092A13] transition-all flex items-center justify-center";
            btnSubmit.innerHTML = `<svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> AMBIL FOTO & HADIR`;
        }
    }

    // 1. Initialize Camera
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } })
            .then(function(stream) {
                video.srcObject = stream;
                cameraLoading.style.display = 'none';
                cameraStatus.innerText = 'Kamera Aktif';
                cameraStatus.classList.replace('bg-[#14532D]/80', 'bg-green-600/90');
                cameraReady = true;
                checkReady();
            })
            .catch(function(error) {
                cameraLoading.innerHTML = '<span class="text-red-400 font-bold px-4 text-center">Gagal mengakses kamera. Mohon izinkan akses kamera di browser Anda.</span>';
                cameraStatus.innerText = 'Kamera Error';
                cameraStatus.classList.replace('bg-[#14532D]/80', 'bg-red-600/90');
                console.error("Camera error:", error);
            });
    } else {
        cameraLoading.innerHTML = '<span class="text-red-400 font-bold">Browser tidak mendukung API Kamera.</span>';
    }

    // Helper to calculate distance
    function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radius of the earth in km
        const dLat = deg2rad(lat2-lat1);  
        const dLon = deg2rad(lon2-lon1); 
        const a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
            Math.sin(dLon/2) * Math.sin(dLon/2); 
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
        return R * c; // Distance in km
    }

    function deg2rad(deg) {
        return deg * (Math.PI/180);
    }

    // 2. Initialize GPS
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                const campusLat = -7.4449;
                const campusLng = 109.2526;
                const maxRadiusKm = 20; // 20 km radius for demo
                
                const distance = getDistanceFromLatLonInKm(lat, lng, campusLat, campusLng);
                
                inputLat.value = lat.toFixed(6);
                inputLng.value = lng.toFixed(6);
                
                // Clear initial blue styling
                gpsContainer.classList.remove('bg-blue-50', 'border-blue-200');
                gpsContainer.querySelector('svg').classList.remove('text-blue-600');
                gpsTitle.classList.remove('text-blue-900');
                gpsStatus.classList.remove('text-blue-700');

                if (distance <= maxRadiusKm) {
                    // Success styling
                    gpsContainer.classList.add('bg-green-50', 'border-green-400');
                    gpsContainer.querySelector('svg').classList.add('text-green-600');
                    gpsTitle.classList.add('text-green-900');
                    gpsTitle.innerText = "Lokasi Valid (Di Area Kampus)";
                    gpsStatus.classList.add('text-green-700');
                    gpsStatus.innerText = `Titik: ${lat.toFixed(5)}, ${lng.toFixed(5)}\nJarak dari kampus: ${distance.toFixed(2)} km. Terverifikasi aman!`;
                    
                    gpsReady = true;
                } else {
                    // Out of range styling
                    gpsContainer.classList.add('bg-red-50', 'border-red-400');
                    gpsContainer.querySelector('svg').classList.add('text-red-600');
                    gpsTitle.classList.add('text-red-900');
                    gpsTitle.innerText = "Di Luar Jangkauan";
                    gpsStatus.classList.add('text-red-700');
                    gpsStatus.innerText = `Titik: ${lat.toFixed(5)}, ${lng.toFixed(5)}\nJarak dari kampus: ${distance.toFixed(2)} km. Maksimal 20 km.`;
                    
                    gpsReady = false;
                }
                
                checkReady();
            },
            function(error) {
                gpsContainer.classList.replace('bg-blue-50', 'bg-red-50');
                gpsContainer.classList.replace('border-blue-200', 'border-red-400');
                gpsContainer.querySelector('svg').classList.replace('text-blue-600', 'text-red-600');
                gpsTitle.classList.replace('text-blue-900', 'text-red-900');
                gpsTitle.innerText = "Gagal Mendapatkan Lokasi";
                gpsStatus.classList.replace('text-blue-700', 'text-red-700');
                gpsStatus.innerText = "Mohon izinkan akses Lokasi (GPS) pada browser Anda untuk dapat presensi.";
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    } else {
        gpsStatus.innerText = "Browser Anda tidak mendukung Geolokasi.";
    }

    // 3. Handle Form Submit (Capture Photo)
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if(!cameraReady || !gpsReady) return;

        // Draw video frame to canvas
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Convert to base64
        const photoData = canvas.toDataURL('image/jpeg', 0.8);
        inputPhoto.value = photoData;
        
        // Show loading on button
        btnSubmit.innerHTML = `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> MEMPROSES...`;
        btnSubmit.disabled = true;

        // Submit actual form
        form.submit();
    });
});
</script>
@endsection
