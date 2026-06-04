<?php
// FILE: app/Http/Middleware/RoleMiddleware.php  (buat file baru)

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check() || auth()->user()->role !== $role) {
            // API request → JSON response
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Role tidak sesuai.',
                ], 403);
            }
            // Web request → redirect
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
