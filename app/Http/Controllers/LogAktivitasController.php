<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Hub;
use Illuminate\Http\Request;

/**
 * Halaman Log Aktivitas & Audit Trail.
 *
 * Tampilan hanya tersedia untuk role yang memiliki prototype di FolderHTML:
 * - Super Admin  -> dashboard.superadmin.logAktivitas
 * - HR           -> dashboard.hr.log-audit-otorisasi
 *
 * Data diambil dari tabel audit_logs (bukan simulasi). Pencarian, filter
 * kategori, dan paginasi berjalan server-side. Data di-scope berdasarkan
 * pilihan hub (default: hub terpilih user; opsi "Semua Hub" tersedia).
 */
class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $hub = $user->selectedHub;

        // Pilihan hub: query param 'hub' => 'all' | id. Default hub terpilih user.
        $hubId = $request->query('hub');
        if ($hubId === null || $hubId === '') {
            $hubId = $hub ? (string) $hub->id : 'all';
        }

        $scoped = fn ($query) => $query->whereHas('user', fn ($u) => $u->where('selected_hub_id', $hubId));

        // ------------------------- Query utama -------------------------
        $query = AuditLog::query()
            ->with(['user.role', 'user.selectedHub'])
            ->when($hubId !== 'all', $scoped);

        // Pencarian: nama/NIP/username, deskripsi, aksi, entitas, IP
        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('description', 'like', "%{$q}%")
                    ->orWhere('action', 'like', "%{$q}%")
                    ->orWhere('entity_type', 'like', "%{$q}%")
                    ->orWhere('ip_address', 'like', "%{$q}%")
                    ->orWhereHas('user', function ($u) use ($q) {
                        $u->where('nama_lengkap', 'like', "%{$q}%")
                            ->orWhere('nip', 'like', "%{$q}%")
                            ->orWhere('username', 'like', "%{$q}%");
                    });
            });
        }

        // Filter kategori (pill pada tampilan)
        $cat = $request->query('cat');
        if ($cat && $cat !== 'semua') {
            $query->whereIn('action', match ($cat) {
                'master'   => ['create', 'update', 'delete'],
                'akses'    => ['login', 'logout', 'activate', 'deactivate', 'revoke_session'],
                'otorisasi'=> ['approve', 'reject', 'approval'],
                'transaksi'=> ['barang_masuk', 'barang_keluar', 'mutasi', 'receipt', 'issue'],
                default    => [],
            });
        }

        // Filter status hasil
        if ($result = $request->query('result')) {
            $query->where('result', $result);
        }

        $logs = $query->latest('created_at')->paginate(15)->withQueryString();

        // ------------------------- Statistik (scope hub sama) -------------------------
        $base = AuditLog::query()->when($hubId !== 'all', $scoped);

        $masterActions = ['create', 'update', 'delete'];
        $accessActions = ['login', 'logout', 'activate', 'deactivate', 'revoke_session'];
        $criticalActions = ['delete', 'deactivate', 'revoke_session'];

        $stats = [
            'total'     => (clone $base)->count(),
            'today'     => (clone $base)->whereDate('created_at', today())->count(),
            'kritis'    => (clone $base)->where(function ($q) use ($criticalActions) {
                $q->whereIn('action', $criticalActions)->orWhere('result', 'failure');
            })->count(),
            'master'    => (clone $base)->whereIn('action', $masterActions)->count(),
            'akses'     => (clone $base)->whereIn('action', $accessActions)->count(),
            'otorisasi' => (clone $base)->whereIn('action', ['approve', 'reject', 'approval'])->count(),
            'transaksi' => (clone $base)->whereIn('action', ['barang_masuk', 'barang_keluar', 'mutasi', 'receipt', 'issue'])->count(),
            'insiden'   => (clone $base)->where('result', 'failure')->count(),
        ];

        // Hub terpilih (untuk label di header)
        $selectedHub = $hubId === 'all' ? null : Hub::find((int) $hubId);
        $hubScopeLabel = $selectedHub?->name ?? 'Semua Hub';
        $hubScopeCode = $selectedHub?->code;

        $view = $user->isSuperAdmin()
            ? 'dashboard.superadmin.logAktivitas'
            : 'dashboard.hr.log-audit-otorisasi';

        $routeName = $user->isSuperAdmin() ? 'admin.log-aktivitas' : 'hr.log-audit-otorisasi';

        return view($view, [
            'user'           => $user,
            'routeName'      => $routeName,
            'logs'           => $logs,
            'stats'          => $stats,
            'hubs'           => Hub::orderBy('name')->get(),
            'selectedHub'    => $selectedHub,
            'selectedHubId'  => $hubId,
            'hubScopeLabel'  => $hubScopeLabel,
            'hubScopeCode'   => $hubScopeCode,
            'q'              => $request->query('q', ''),
            'cat'            => $cat ?? 'semua',
            'result'         => $result ?? '',
        ]);
    }
}
