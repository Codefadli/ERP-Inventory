<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRevokedSession
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return $next($request);
        }

        $sessionId = $request->session()->getId();

        $revoked = \App\Models\UserSession::where('user_id', $request->user()->id)
            ->where('session_id', $sessionId)
            ->where('status', 'revoked')
            ->exists();

        if ($revoked) {
            // Invalidate the current Laravel session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Sesi telah dicabut. Silakan login kembali.',
                ], 401);
            }

            return redirect()->route('login')
                ->with('error', 'Sesi Anda telah dicabut. Silakan login kembali.');
        }

        return $next($request);
    }
}