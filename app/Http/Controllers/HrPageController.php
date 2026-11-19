<?php

namespace App\Http\Controllers;

use App\Models\Hub;
use App\Models\Item;
use App\Models\RequestBarang;
use App\Support\AuditLogger;
use Illuminate\Http\Request;

// Modul HR: persetujuan, riwayat, detail permintaan, laporan inventaris.
// Sumber data: requests & items. Filter hub + paginasi.
class HrPageController extends Controller
{
    private function resolveHubId(Request $request, $user): string
    {
        $hubId = $request->query('hub');
        if ($hubId === null || $hubId === '') {
            $hubId = $user->selectedHub ? (string) $user->selectedHub->id : 'all';
        }
        return $hubId;
    }

    /** Antrean persetujuan barang. */
    public function persetujuan(Request $request)
    {
        $user = auth()->user();
        $hubId = $this->resolveHubId($request, $user);

        $query = RequestBarang::query()
            ->with(['user', 'hub'])
            ->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId))
            ->whereIn('status', ['Menunggu', 'Disetujui']);

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('tiket', 'like', "%{$q}%")
                    ->orWhere('rincian', 'like', "%{$q}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$q}%"));
            });
        }

        $permintaans = $query->latest('created_at')->paginate(10)->withQueryString();

        $base = RequestBarang::query()->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));
        $stats = [
            'total'     => (clone $base)->count(),
            'menunggu'  => (clone $base)->where('status', 'Menunggu')->count(),
            'disetujui' => (clone $base)->where('status', 'Disetujui')->count(),
            'ditolak'   => (clone $base)->where('status', 'Ditolak')->count(),
        ];

        $selectedHub = $hubId === 'all' ? null : Hub::find((int) $hubId);

        return view('dashboard.hr.persetujuanBarang', [
            'user'          => $user,
            'routeName'     => 'hr.persetujuan-barang',
            'permintaans'   => $permintaans,
            'stats'         => $stats,
            'hubs'          => Hub::orderBy('name')->get(),
            'selectedHubId' => $hubId,
            'hubScopeLabel' => $selectedHub?->name ?? 'Semua Hub',
            'hubScopeCode'  => $selectedHub?->code,
            'q'             => $request->query('q', ''),
        ]);
    }

    /** Proses keputusan antrean (setujui/tolak). */
    public function proses(Request $request, int $id)
    {
        $user = auth()->user();
        if (!($user->isSuperAdmin() || $user->hasPermission('issue.approve') || $user->hasPermission('master.manage'))) {
            abort(403, 'Anda tidak memiliki izin untuk memproses pengajuan.');
        }

        $requestBarang = RequestBarang::findOrFail($id);
        $validated = $request->validate([
            'keputusan' => 'required|in:Disetujui,Ditolak',
        ]);

        $requestBarang->status = $validated['keputusan'];
        $requestBarang->approver = $user->name ?? 'HR Manager';
        $requestBarang->disetujui_at = $validated['keputusan'] === 'Disetujui' ? now() : null;
        $requestBarang->save();

        AuditLogger::log(
            $user,
            'update',
            RequestBarang::class,
            $requestBarang->id,
            ['status' => $requestBarang->status, 'tiket' => $requestBarang->tiket],
            'success',
            'HR memproses pengajuan ' . $requestBarang->tiket . ' -> ' . $requestBarang->status
        );

        return redirect()
            ->route('hr.persetujuan-barang')
            ->with('success', 'Pengajuan ' . $requestBarang->tiket . ' berhasil ' . strtolower($validated['keputusan']) . '.');
    }

    /** Riwayat persetujuan yang sudah diputuskan. */
    public function riwayat(Request $request)
    {
        $user = auth()->user();
        $hubId = $this->resolveHubId($request, $user);

        $query = RequestBarang::query()
            ->with(['user', 'hub'])
            ->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId))
            ->whereIn('status', ['Disetujui', 'Ditolak', 'Selesai']);

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('tiket', 'like', "%{$q}%")
                    ->orWhere('rincian', 'like', "%{$q}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$q}%"));
            });
        }

        $riwayats = $query->latest('disetujui_at')->latest('created_at')->paginate(10)->withQueryString();

        $base = RequestBarang::query()->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));
        $stats = [
            'total'     => (clone $base)->whereIn('status', ['Disetujui', 'Ditolak', 'Selesai'])->count(),
            'disetujui' => (clone $base)->where('status', 'Disetujui')->count(),
            'ditolak'   => (clone $base)->where('status', 'Ditolak')->count(),
            'selesai'   => (clone $base)->where('status', 'Selesai')->count(),
        ];

        $selectedHub = $hubId === 'all' ? null : Hub::find((int) $hubId);

        return view('dashboard.hr.riwayatPersetujuan', [
            'user'          => $user,
            'routeName'     => 'hr.riwayat-persetujuan',
            'riwayats'      => $riwayats,
            'stats'         => $stats,
            'hubs'          => Hub::orderBy('name')->get(),
            'selectedHubId' => $hubId,
            'hubScopeLabel' => $selectedHub?->name ?? 'Semua Hub',
            'hubScopeCode'  => $selectedHub?->code,
            'q'             => $request->query('q', ''),
            'status'        => $request->query('status', ''),
        ]);
    }

    /** Detail satu permintaan. */
    public function detail(Request $request, int $id)
    {
        $user = auth()->user();
        $permintaan = RequestBarang::with(['user', 'hub'])->findOrFail($id);

        return view('dashboard.hr.detailPermintaan', [
            'user'       => $user,
            'permintaan' => $permintaan,
            'backRoute'  => 'hr.persetujuan-barang',
        ]);
    }

    /** Laporan inventaris untuk HR. */
    public function laporan(Request $request)
    {
        $user = auth()->user();
        $hubId = $this->resolveHubId($request, $user);

        $itemQuery = Item::query()
            ->with(['category', 'hub'])
            ->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));

        if ($q = trim((string) $request->query('q'))) {
            $itemQuery->where(function ($w) use ($q) {
                $w->where('sku', 'like', "%{$q}%")
                    ->orWhere('nama', 'like', "%{$q}%")
                    ->orWhereHas('category', fn ($c) => $c->where('nama', 'like', "%{$q}%"));
            });
        }

        $items = $itemQuery->orderBy('sku')->paginate(10)->withQueryString();

        $base = Item::query()->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));
        $stats = [
            'total'  => (clone $base)->count(),
            'aktif'  => (clone $base)->where('status', 'Aktif')->count(),
            'kritis' => (clone $base)->where('status', 'Stok Kritis')->count(),
        ];

        $reqBase = RequestBarang::query()->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));
        $stats['permintaan'] = (clone $reqBase)->count();
        $stats['pending'] = (clone $reqBase)->where('status', 'Menunggu')->count();

        $selectedHub = $hubId === 'all' ? null : Hub::find((int) $hubId);

        return view('dashboard.hr.laporanInventarisHr', [
            'user'          => $user,
            'routeName'     => 'hr.laporan-inventaris',
            'items'         => $items,
            'stats'         => $stats,
            'hubs'          => Hub::orderBy('name')->get(),
            'selectedHubId' => $hubId,
            'hubScopeLabel' => $selectedHub?->name ?? 'Semua Hub',
            'hubScopeCode'  => $selectedHub?->code,
            'q'             => $request->query('q', ''),
        ]);
    }
}
