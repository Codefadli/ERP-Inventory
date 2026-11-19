<?php

namespace App\Http\Controllers;

use App\Models\Hub;
use App\Models\Inbound;
use App\Models\Outbound;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Mutasi Barang — Kepala Gudang.
 * Menampilkan seluruh pergerakan stok (barang masuk + barang keluar)
 * sebagai satu alur mutasi kronologis. Data nyata dari tabel
 * inbounds & outbounds; filter hub (default hub user; opsi "Semua Hub").
 */
class MutasiBarangController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $hubId = $request->query('hub');
        if ($hubId === null || $hubId === '') {
            $hubId = $user->selectedHub ? (string) $user->selectedHub->id : 'all';
        }

        $in = Inbound::query()
            ->with(['item', 'location', 'hub'])
            ->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId))
            ->get()
            ->map(function ($row) {
                $row->mutasi_tipe = 'Masuk';
                return $row;
            });

        $out = Outbound::query()
            ->with(['item', 'hub'])
            ->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId))
            ->get()
            ->map(function ($row) {
                $row->mutasi_tipe = 'Keluar';
                return $row;
            });

        $q = trim((string) $request->query('q'));
        $mutasis = $in->concat($out)
            ->sortByDesc('created_at')
            ->values()
            ->filter(function ($row) use ($q) {
                if (!$q) return true;
                $text = implode(' ', array_filter([
                    $row->kode ?? '',
                    $row->surat_jalan ?? '',
                    $row->permintaan ?? '',
                    optional($row->item)->sku ?? '',
                    optional($row->item)->nama ?? '',
                    $row->mutasi_tipe,
                ]));
                return stripos($text, $q) !== false;
            })
            ->values();

        $perPage = 10;
        $page = max(1, (int) $request->query('page', 1));
        $slice = $mutasis->slice(($page - 1) * $perPage, $perPage)->values();
        $mutasiPage = new LengthAwarePaginator(
            $slice,
            $mutasis->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $stats = [
            'total'   => $mutasis->count(),
            'masuk'   => $mutasis->where('mutasi_tipe', 'Masuk')->count(),
            'keluar'  => $mutasis->where('mutasi_tipe', 'Keluar')->count(),
            'qty'     => $mutasis->sum('qty'),
        ];

        $selectedHub = $hubId === 'all' ? null : Hub::find((int) $hubId);

        $view = $user->isAuditor() ? 'dashboard.audit.mutasiBarang' : 'dashboard.kepalagudang.mutasiBarang';
        $routeName = $user->isAuditor() ? 'audit.mutasi-barang' : 'kepalagudang.mutasi-barang';

        return view($view, [
            'user'          => $user,
            'routeName'     => $routeName,
            'mutasis'       => $mutasiPage,
            'stats'         => $stats,
            'hubs'          => Hub::orderBy('name')->get(),
            'selectedHubId' => $hubId,
            'hubScopeLabel' => $selectedHub?->name ?? 'Semua Hub',
            'hubScopeCode'  => $selectedHub?->code,
            'q'             => $q,
        ]);
    }
}
