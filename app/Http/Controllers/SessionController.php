<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SessionController extends Controller
{
    /**
     * Get all active sessions for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $sessions = UserSession::where('user_id', $user->id)
            ->where('status', 'active')
            ->orderByDesc('last_activity_at')
            ->get()
            ->map(function ($session) use ($user, $request) {
                // Determine if this is the current session
                $sessionHash = md5($session->session_id);
                $currentSessionId = md5($request->session()->getId());
                $isCurrent = $sessionHash === $currentSessionId;

                // Determine device name from user agent
                $deviceName = $this->parseDeviceName($session->user_agent, $session->device_name);
                $platform = $this->parsePlatform($session->user_agent, $session->platform);
                $browser = $this->parseBrowser($session->user_agent, $session->browser);

                return [
                    'id' => $session->id,
                    'session_id_hash' => $sessionHash,
                    'device_name' => $deviceName,
                    'platform' => $platform,
                    'browser' => $browser,
                    'ip_address' => $session->ip_address,
                    'last_activity_at' => $session->last_activity_at,
                    'status' => $session->status,
                    'is_current' => $isCurrent,
                ];
            });

        // Also include the current session if not in user_sessions
        if ($sessions->isEmpty()) {
            // Current session via auth (file driver) — still record it
            // We'll store it via login hook; but for safety include current
            $currentHash = md5($request->session()->getId());
            // Check if we have a matching session in DB
            $dbSession = UserSession::where('user_id', $user->id)
                ->where('session_id', $currentHash)
                ->first();

            if ($dbSession) {
                // already included
            }
        }

        // Log the view
        if (auth()->check()) {
            \Log::info('User sessions list accessed', [
                'user_id' => $user->id,
                'action' => 'view',
                'entity_type' => 'UserSession',
            ]);
        }

        return response()->json([
            'sessions' => $sessions,
            'total' => $sessions->count(),
        ]);
    }

    /**
     * Revoke a specific session.
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $session = UserSession::where('user_id', $user->id)
            ->where('id', $id)
            ->first();

        if (!$session) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi tidak ditemukan.',
            ], 404);
        }

        if ($session->status === 'revoked') {
            return response()->json([
                'success' => true,
                'message' => 'Sesi sudah tidak aktif.',
            ]);
        }

        $session->status = 'revoked';
        $session->revoked_at = now();
        $session->save();

        // Delete the actual session file from storage (file driver)
        // Use hash-based identifier to safely delete
        $sessionHash = md5($session->session_id);
        $this->deleteSessionFile($session->session_id);

        return response()->json([
            'success' => true,
            'message' => 'Sesi berhasil dicabut.',
        ]);
    }

    /**
     * Revoke all sessions except current.
     */
    public function destroyAll(Request $request)
    {
        return $this->revokeAllExceptCurrent($request);
    }

    /**
     * Revoke a session (alias for destroy).
     */
    public function revoke(Request $request, $id)
    {
        return $this->destroy($request, $id);
    }

    /**
     * Revoke all sessions except current (logout from all devices).
     */
    public function revokeAll(Request $request)
    {
        return $this->revokeAllExceptCurrent($request);
    }

    /**
     * Logout from all devices except current.
     */
    public function logoutOther(Request $request)
    {
        return $this->revokeAllExceptCurrent($request);
    }

    /**
     * Revoke all sessions except the current session.
     */
    private function revokeAllExceptCurrent(Request $request)
    {
        $user = $request->user();
        $currentSessionHash = md5($request->session()->getId());

        // Find all active sessions for this user
        $sessions = UserSession::where('user_id', $user->id)
            ->where('status', 'active')
            ->get();

        $revokedCount = 0;
        foreach ($sessions as $session) {
            if (md5($session->session_id) === $currentSessionHash) {
                continue; // Skip current session
            }

            $session->status = 'revoked';
            $session->revoked_at = now();
            $session->save();
            $this->deleteSessionFile($session->session_id);
            $revokedCount++;
        }

        // Log audit trail
        if (auth()->check()) {
            \Log::info('User sessions revoked (all except current)', [
                'user_id' => $user->id,
                'action' => 'revoke_session',
                'count' => $revokedCount,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "Berhasil mengakhiri {$revokedCount} sesi lainnya.",
            'revoked_count' => $revokedCount,
        ]);
    }

    /**
     * Delete session file from storage.
     */
    private function deleteSessionFile(string $sessionId): void
    {
        // Delete from Laravel session store
        // For file driver: storage/framework/sessions/{sessionId}.php
        // We use hash-based deletion to be safe
        try {
            $sessionHash = md5($sessionId);
            $path = storage_path('framework/sessions/' . $sessionHash . '.php');
            if (file_exists($path)) {
                @unlink($path);
            }
        } catch (\Throwable $e) {
            // Ignore file system errors
        }
    }

    private function parseDeviceName(?string $ua, ?string $deviceName): string
    {
        if ($deviceName) {
            return $deviceName;
        }
        if (!$ua) {
            return 'Unknown Device';
        }

        if (str_contains($ua, 'iPhone') || str_contains($ua, 'iPad')) {
            return 'iOS Device';
        }
        if (str_contains($ua, 'Android')) {
            return 'Android Device';
        }
        if (str_contains($ua, 'Mac')) {
            return 'Mac';
        }
        if (str_contains($ua, 'Windows')) {
            return 'Windows PC';
        }
        if (str_contains($ua, 'Linux')) {
            return 'Linux';
        }
        return 'Web Browser';
    }

    private function parsePlatform(?string $ua, ?string $platform): string
    {
        if ($platform) {
            return $platform;
        }
        if (!$ua) {
            return 'Unknown';
        }

        if (str_contains($ua, 'iPhone') || str_contains($ua, 'iPad')) {
            return 'iOS';
        }
        if (str_contains($ua, 'Android')) {
            return 'Android';
        }
        if (str_contains($ua, 'Mac')) {
            return 'macOS';
        }
        if (str_contains($ua, 'Windows')) {
            return 'Windows';
        }
        if (str_contains($ua, 'Linux')) {
            return 'Linux';
        }
        return 'Unknown';
    }

    private function parseBrowser(?string $ua, ?string $browser): string
    {
        if ($browser) {
            return $browser;
        }
        if (!$ua) {
            return 'Unknown';
        }

        if (str_contains($ua, 'Edg/')) {
            return 'Edge';
        }
        if (str_contains($ua, 'Chrome/')) {
            return 'Chrome';
        }
        if (str_contains($ua, 'Firefox/')) {
            return 'Firefox';
        }
        if (str_contains($ua, 'Safari/')) {
            return 'Safari';
        }
        return 'Unknown';
    }
}
