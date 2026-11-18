<?php

namespace App\Support;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * Penulis jejak audit terpusat.
 *
 * Semua aksi sensitif (manajemen pengguna, perubahan konfigurasi) dicatat
 * ke tabel audit_logs agar dapat ditampilkan pada halaman Log Aktivitas
 * dan dashboard Auditor.
 */
class AuditLogger
{
    public static function log(
        ?User $actor,
        string $action,
        ?string $entityType = null,
        ?int $entityId = null,
        ?array $changes = null,
        string $result = 'success',
        ?string $description = null
    ): ?AuditLog {
        try {
            $request = Request::instance();

            return AuditLog::create([
                'user_id' => $actor?->id ?? Auth::id(),
                'action' => $action,
                'entity_type' => $entityType,
                'entity_id' => $entityId,
                'changes' => $changes,
                'ip_address' => $request?->ip(),
                'user_agent' => substr((string) $request?->userAgent(), 0, 255) ?: null,
                'result' => $result,
                'description' => $description,
            ]);
        } catch (\Throwable $e) {
            // Audit tidak boleh menggagalkan operasi bisnis utama.
            report($e);
            return null;
        }
    }
}
