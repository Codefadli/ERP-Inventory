<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     * 
     * Middleware ini memeriksa apakah user memiliki permission tertentu.
     * Sesuai dengan FR-ASTRO-006 dan SR-ASTRO-004:
     * - Permission diperiksa di backend
     * - Return 401 jika tidak login
     * - Return 403 jika tidak ada permission
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // Check apakah user sudah login
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Unauthorized',
                    'message' => 'Anda harus login terlebih dahulu.'
                ], 401);
            }

            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = auth()->user();

        // Super Admin bypass semua permission check
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Check permission
        if (!$user->hasPermission($permission)) {
            // Log unauthorized attempt
            \Log::warning('Unauthorized access attempt', [
                'user_id' => $user->id,
                'username' => $user->username,
                'permission' => $permission,
                'route' => $request->path(),
                'ip' => $request->ip(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Forbidden',
                    'message' => 'Anda tidak memiliki izin untuk mengakses resource ini.'
                ], 403);
            }

            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
