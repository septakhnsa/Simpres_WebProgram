<?php
// FILE: app/Http/Controllers/API/AuthApiController.php
// Buat folder API di dalam Controllers, lalu buat file ini

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    // ── POST /api/login ──────────────────────────────────────
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        if ($user->role !== 'mahasiswa') {
            return response()->json([
                'success' => false,
                'message' => 'Akses API hanya untuk mahasiswa.',
            ], 403);
        }

        // Hapus token lama, buat token baru
        $user->tokens()->delete();
        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data'    => [
                'token' => $token,
                'user'  => [
                    'id'      => $user->id,
                    'name'    => $user->name,
                    'nim'     => $user->nim,
                    'email'   => $user->email,
                    'jurusan' => $user->jurusan,
                ],
            ],
        ], 200);
    }

    // ── POST /api/logout ─────────────────────────────────────
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ]);
    }

    // ── GET /api/me ──────────────────────────────────────────
    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'data'    => $request->user(),
        ]);
    }
}
