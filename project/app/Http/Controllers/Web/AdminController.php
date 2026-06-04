<?php
// FILE: app/Http/Controllers/Web/AdminController.php
// Buat folder Web di dalam Controllers, lalu buat file ini

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Lokasi;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ── GET /admin/dashboard ─────────────────────────────────
    public function dashboard()
    {
        $stats = [
            'total_mahasiswa'    => User::where('role', 'mahasiswa')->count(),
            'hadir_hari_ini'     => Presensi::whereDate('check_in', today())->where('status', 'hadir')->count(),
            'terlambat_hari_ini' => Presensi::whereDate('check_in', today())->where('status', 'terlambat')->count(),
            'total_jadwal'       => Jadwal::whereDate('tanggal', today())->count(),
        ];

        $jadwalHariIni   = Jadwal::with(['lokasi', 'presensis'])->whereDate('tanggal', today())->get();
        $presensiTerbaru = Presensi::with(['user', 'jadwal', 'lokasi'])
            ->orderByDesc('check_in')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'jadwalHariIni', 'presensiTerbaru'));
    }

    // ── MAHASISWA ─────────────────────────────────────────────

    public function mahasiswaIndex()
    {
        $mahasiswa = User::where('role', 'mahasiswa')
            ->withCount('presensis')
            ->paginate(15);
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function mahasiswaStore(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'nim'      => 'required|string|unique:users',
            'email'    => 'required|email|unique:users',
            'jurusan'  => 'nullable|string',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'nim'      => $request->nim,
            'email'    => $request->email,
            'jurusan'  => $request->jurusan,
            'password' => bcrypt($request->password),
            'role'     => 'mahasiswa',
        ]);

        return back()->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function mahasiswaDestroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Data mahasiswa dihapus.');
    }

    // ── LOKASI ────────────────────────────────────────────────

    public function lokasiIndex()
    {
        $lokasi = Lokasi::withCount('presensis')->paginate(10);
        return view('admin.lokasi.index', compact('lokasi'));
    }

    public function lokasiStore(Request $request)
    {
        $request->validate([
            'name'         => 'required|string',
            'latitude'     => 'required|numeric',
            'longitude'    => 'required|numeric',
            'radius_meter' => 'required|integer|min:10',
        ]);

        Lokasi::create($request->only('name', 'latitude', 'longitude', 'radius_meter'));
        return back()->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function lokasiDestroy(Lokasi $lokasi)
    {
        $lokasi->delete();
        return back()->with('success', 'Lokasi dihapus.');
    }

    // ── JADWAL ────────────────────────────────────────────────

    public function jadwalIndex()
    {
        $jadwals = Jadwal::with('lokasi')->orderByDesc('tanggal')->paginate(10);
        $lokasis = Lokasi::where('is_active', true)->get();
        return view('admin.jadwal.index', compact('jadwals', 'lokasis'));
    }

    public function jadwalStore(Request $request)
    {
        $request->validate([
            'mata_kuliah' => 'required|string',
            'kelas'       => 'required|string',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
            'lokasi_id'   => 'required|exists:lokasis,id',
        ]);

        Jadwal::create($request->only('mata_kuliah', 'kelas', 'tanggal', 'jam_mulai', 'jam_selesai', 'lokasi_id'));
        return back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function jadwalDestroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return back()->with('success', 'Jadwal dihapus.');
    }

    // ── REKAP PRESENSI ────────────────────────────────────────

    public function rekapIndex(Request $request)
    {
        $query = Presensi::with(['user', 'jadwal', 'lokasi']);

        if ($request->tanggal) {
            $query->whereDate('check_in', $request->tanggal);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $rekap     = $query->orderByDesc('check_in')->paginate(20)->withQueryString();
        $mahasiswa = User::where('role', 'mahasiswa')->get();

        return view('admin.rekap.index', compact('rekap', 'mahasiswa'));
    }
}
