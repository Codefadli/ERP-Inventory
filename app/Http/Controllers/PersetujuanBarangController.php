<?php

namespace App\Http\Controllers;

use App\Models\Hub;
use App\Models\RequestBarang;
use App\Support\AuditLogger;
use Illuminate\Http\Request;

/**
 * Persetujuan Barang — Kepala Gudang.
 * Daftar pengajuan (requests) yang harus disetujui/ditolak KG,
 * filter hub (default hub terpilih user; opsi "Semua Hub").
 * Data nyata dari tabel requests.
 */
class PersetujuanBarangController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $hubId = $request->query('hub');
        if ($hubId === null || $hubId === '') {
            $hubId = $user->selectedHub ? (string) $user->selectedHub->id : 'all';
        }

        $query = RequestBarang::query()
            ->with(['user', 'hub'])
            ->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('tiket', 'like', "%{$q}%")
                    ->orWhere('rincian', 'like', "%{$q}%")
                    ->orWhere('approver', 'like', "%{$q}%")
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
            'selesai'   => (clone $base)->where('status', 'Selesai')->count(),
        ];

        $selectedHub = $hubId === 'all' ? null : Hub::find((int) $hubId);

        return view('dashboard.kepalagudang.persetujuanBarang', [
            'user'          => $user,
            'routeName'     => 'kepalagudang.persetujuan-barang',
            'permintaans'   => $permintaans,
            'stats'         => $stats,
            'hubs'          => Hub::orderBy('name')->get(),
            'selectedHubId' => $hubId,
            'hubScopeLabel' => $selectedHub?->name ?? 'Semua Hub',
            'hubScopeCode'  => $selectedHub?->code,
            'q'             => $request->query('q', ''),
            'status'        => $request->query('status', ''),
        ]);
    }

    /**
     * Proses pengajuan: setujui / tolak.
     */
    public function proses(Request $request, int $id)
    {
        $user = auth()->user();
        if (!($user->isSuperAdmin() || $user->hasPermission('master.manage') || $user->hasPermission('issue.approve'))) {
            abort(403, 'Anda tidak memiliki izin untuk memproses pengajuan.');
        }

        $requestBarang = RequestBarang::findOrFail($id);

        $validated = $request->validate([
            'keputusan' => 'required|in:Disetujui,Ditolak',
        ]);

        $requestBarang->status = $validated['keputusan'];
        $requestBarang->approver = $user->name ?? 'Kepala Gudang';
        $requestBarang->disetujui_at = $validated['keputusan'] === 'Disetujui' ? now() : null;
        $requestBarang->save();

        AuditLogger::log(
            $user,
            'update',
            RequestBarang::class,
            $requestBarang->id,
            ['status' => $requestBarang->status, 'tiket' => $requestBarang->tiket],
            'success',
            'Memproses pengajuan ' . $requestBarang->tiket . ' -> ' . $requestBarang->status
        );

        return redirect()
            ->route('kepalagudang.persetujuan-barang')
            ->with('success', 'Pengajuan ' . $requestBarang->tiket . ' berhasil ' . strtolower($validated['keputusan']) . '.');
    }
}
