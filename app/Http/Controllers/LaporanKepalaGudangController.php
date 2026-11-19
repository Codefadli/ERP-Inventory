<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Hub;
use App\Models\Inbound;
use App\Models\Item;
use App\Models\Outbound;
use Illuminate\Http\Request;

// Laporan & analitik: katalog, pergerakan stok, distribusi kategori.
class LaporanKepalaGudangController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $hubId = $request->query('hub');
        if ($hubId === null || $hubId === '') {
            $hubId = $user->selectedHub ? (string) $user->selectedHub->id : 'all';
        }

        $itemQuery = Item::query()
            ->with(['category', 'hub'])
            ->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));

        $q = trim((string) $request->query('q'));
        if ($q) {
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

        $inboundBase = Inbound::query()->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));
        $outboundBase = Outbound::query()->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));
        $stats['masuk'] = (clone $inboundBase)->count();
        $stats['keluar'] = (clone $outboundBase)->count();
        $stats['qty_masuk'] = (clone $inboundBase)->sum('qty');
        $stats['qty_keluar'] = (clone $outboundBase)->sum('qty');

        // Distribusi per kategori (untuk analitik sederhana).
        $kategoriData = Category::query()
            ->withCount(['items' => fn ($q) => $q->when($hubId !== 'all', fn ($w) => $w->where('hub_id', $hubId))])
            ->orderByDesc('items_count')
            ->get()
            ->map(fn ($c) => [
                'nama' => $c->nama,
                'kode' => $c->kode,
                'total' => $c->items_count,
            ]);

        $selectedHub = $hubId === 'all' ? null : Hub::find((int) $hubId);

        return view('dashboard.kepalagudang.laporanAnalitik', [
            'user'          => $user,
            'routeName'     => 'kepalagudang.laporan',
            'items'         => $items,
            'stats'         => $stats,
            'kategoriData'  => $kategoriData,
            'hubs'          => Hub::orderBy('name')->get(),
            'selectedHubId' => $hubId,
            'hubScopeLabel' => $selectedHub?->name ?? 'Semua Hub',
            'hubScopeCode'  => $selectedHub?->code,
            'q'             => $request->query('q', ''),
        ]);
    }
}
