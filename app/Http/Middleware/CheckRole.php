<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     * 
     * Middleware ini memeriksa apakah user memiliki role tertentu.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
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

        // Check apakah user memiliki salah satu role yang diizinkan
        $hasRole = false;
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                $hasRole = true;
                break;
            }
        }

        if (!$hasRole) {
            // Log unauthorized attempt
            \Log::warning('Unauthorized role access attempt', [
                'user_id' => $user->id,
                'username' => $user->username,
                'user_role' => $user->role->code,
                'required_roles' => $roles,
                'route' => $request->path(),
                'ip' => $request->ip(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Forbidden',
                    'message' => 'Role Anda tidak diizinkan mengakses resource ini.'
                ], 403);
            }

            abort(403, 'Role Anda tidak diizinkan mengakses halaman ini.');
        }

        return $next($request);
    }
}
