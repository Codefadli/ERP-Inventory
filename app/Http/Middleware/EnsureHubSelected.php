<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHubSelected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Jika user tidak login, lanjutkan (akan ditangani oleh auth middleware)
        if (!$user) {
            return $next($request);
        }

        // Jika user perlu pilih hub tapi belum pilih, redirect ke halaman hub selection
        if ($user->needsHubSelection() && !$user->hasSelectedHub()) {
            // Skip redirect jika sudah di halaman hub selection atau logout
            if ($request->routeIs('hub.selection.*') || $request->routeIs('logout')) {
                return $next($request);
            }

            return redirect()->route('hub.selection.show')
                ->with('info', 'Silakan pilih kota dan hub operasional terlebih dahulu.');
        }

        return $next($request);
    }
}
