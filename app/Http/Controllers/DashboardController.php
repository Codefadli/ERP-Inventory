<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Category;
use App\Models\City;
use App\Models\Division;
use App\Models\Hub;
use App\Models\Item;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use App\Models\UserSession;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Dashboard. Modul tanpa tabel pendukung dikirim sebagai daftar
     * "belum tersedia" (empty state jujur, tanpa simulasi).
     */
    public function index()
    {
        $user = auth()->user();
        $hub = $user->selectedHub;

        // Metrik pengguna (pengguna aktif, pengguna sistem, akun pegawai,
        // pengguna baru, sesi aktif, daftar pengguna terbaru) dihitung per
        // hub distribusi yang sedang dipilih. Antar hub tidak dicampur.
        // Jika akun belum ditugaskan ke hub mana pun, metrik memakai
        // cakupan seluruh hub dan UI memberi label "Semua hub".
        $hubScoped = $hub !== null;

        $hubUsers = User::query()
            ->when($hubScoped, fn ($query) => $query->where('selected_hub_id', $hub->id));

        $totalUsers = (clone $hubUsers)->count();
        $activeUsers = (clone $hubUsers)->where('status', 'active')->count();
        $inactiveUsers = (clone $hubUsers)->where('status', '!=', 'active')->count();
        $newUsersThisMonth = (clone $hubUsers)
            ->where('created_at', '>=', now()->startOfMonth())
            ->count();

        $usersByRole = Role::query()
            ->withCount(['users' => function ($query) use ($hubScoped, $hub) {
                if ($hubScoped) {
                    $query->where('selected_hub_id', $hub->id);
                }
            }])
            ->orderBy('name')
            ->get();

        $activeSessions = UserSession::query()
            ->where('status', 'active')
            ->where('last_activity_at', '>=', now()->subMinutes(30))
            ->when($hubScoped, fn ($query) => $query->whereIn('user_id', (clone $hubUsers)->select('id')))
            ->count();

        $data = [
            'hub' => $hub,
            'user' => $user,
            'hubScoped' => $hubScoped,
            'hubScopeLabel' => $hub?->name ?? 'Semua hub',
            'hubScopeCode' => $hub?->code,
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'inactiveUsers' => $inactiveUsers,
            'newUsersThisMonth' => $newUsersThisMonth,
            'usersByRole' => $usersByRole,
            'totalItems' => Item::count(),
            'totalCategories' => Category::count(),
            'totalSuppliers' => Supplier::count(),
            'totalDivisions' => Division::count(),
            'totalHubs' => Hub::count(),
            'totalCities' => City::count(),
            'activeSessions' => $activeSessions,
            'recentAuditLogs' => AuditLog::with('user.role')->latest()->limit(8)->get(),
            'auditLogsTotal' => AuditLog::count(),
            'recentUsers' => (clone $hubUsers)
                ->with(['role', 'division', 'selectedHub'])
                ->latest()->limit(6)->get(),
            'latestItems' => Item::with(['category', 'unit', 'supplier'])
                ->latest()->limit(6)->get(),
            'hubsByOccupancy' => Hub::with('city')
                ->orderByDesc('occupancy')->limit(6)->get(),
            'itemsByCategory' => Category::withCount('items')
                ->orderByDesc('items_count')->limit(6)->get(),
            'divisions' => Division::orderBy('nama')->limit(6)->get(),
        ];

        $data['unavailableModules'] = $this->unavailableModules($user);

        return view('dashboard.index', $data);
    }

    /**
     * Daftar modul yang tidak dapat dihitung karena belum ada tabel/domain
     * pendukung pada database. Ditampilkan sebagai pemberitahuan eksplisit.
     *
     * @return array<int, string>
     */
    private function unavailableModules(User $user): array
    {
        $common = [
            'Transaksi barang masuk/keluar',
            'Persetujuan (approval) mutasi',
            'Stock opname & selisih fisik',
            'Temuan audit & valuasi risiko',
        ];

        if ($user->isSuperAdmin() || $user->isKepalaGudang()) {
            $common[] = 'Stok per SKU & reorder point';
            $common[] = 'Throughput / arus barang harian';
        }

        if ($user->isPegawai()) {
            $common[] = 'Penugasan picking/packing & jadwal opname';
        }

        return array_values(array_unique($common));
    }
}
