<?php

namespace App\Http\Controllers;

use App\Models\Hub;
use App\Models\Item;
use App\Models\StockOpname;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Hasil & input stok opname (tabel stock_opnames), per hub.
class StokOpnameController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $hubId = $request->query('hub');
        if ($hubId === null || $hubId === '') {
            $hubId = $user->selectedHub ? (string) $user->selectedHub->id : 'all';
        }

        $query = StockOpname::query()
            ->with(['item', 'user', 'hub'])
            ->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->whereHas('item', function ($i) use ($q) {
                    $i->where('sku', 'like', "%{$q}%")
                        ->orWhere('nama', 'like', "%{$q}%");
                });
            });
        }

        $opnames = $query->latest('created_at')->paginate(10)->withQueryString();

        $base = StockOpname::query()->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));
        $stats = [
            'total'   => (clone $base)->count(),
            'sesuai'  => (clone $base)->where('status', 'Sesuai')->count(),
            'selisih' => (clone $base)->where('status', 'Selisih')->count(),
            'pending' => (clone $base)->where('status', 'Belum Diverifikasi')->count(),
        ];

        $selectedHub = $hubId === 'all' ? null : Hub::find((int) $hubId);

        $sudahDiopname = StockOpname::pluck('item_id')->all();
        $itemsBelum = Item::query()
            ->with('location')
            ->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId))
            ->whereNotIn('id', $sudahDiopname)
            ->orderBy('sku')
            ->get(['id', 'sku', 'nama', 'location_id', 'hub_id']);

        $view = $user->isAuditor() ? 'dashboard.audit.stokOpname' : 'dashboard.kepalagudang.stokOpname';
        $routeName = $user->isAuditor() ? 'audit.stok-opname' : 'kepalagudang.stok-opname';

        return view($view, [
            'user'          => $user,
            'routeName'     => $routeName,
            'opnames'       => $opnames,
            'stats'         => $stats,
            'hubs'          => Hub::orderBy('name')->get(),
            'itemsBelum'    => $itemsBelum,
            'selectedHubId' => $hubId,
            'hubScopeLabel' => $selectedHub?->name ?? 'Semua Hub',
            'hubScopeCode'  => $selectedHub?->code,
            'q'             => $request->query('q', ''),
        ]);
    }

    /** Simpan hasil opname fisik baru. */
    public function store(Request $request)
    {
        $user = auth()->user();
        if (!($user->isSuperAdmin() || $user->hasPermission('master.manage') || $user->hasPermission('opname.count') || $user->hasPermission('opname.manage'))) {
            abort(403, 'Anda tidak memiliki izin untuk mencatat opname.');
        }

        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'qty_fisik' => 'required|integer|min:0',
            'catatan' => 'nullable|string|max:500',
            'hub_id' => 'nullable|exists:hubs,id',
        ]);

        $item = Item::findOrFail($validated['item_id']);
        $qtyFisik = (int) $validated['qty_fisik'];
        $selisih = 0 - $qtyFisik;
        $status = $selisih === 0 ? 'Sesuai' : 'Selisih';

        $hubId = $validated['hub_id'] ?? $item->hub_id ?? ($user->selectedHub?->id ?? null);

        $opname = DB::transaction(function () use ($validated, $item, $qtyFisik, $selisih, $status, $hubId, $user) {
            $so = StockOpname::create([
                'item_id' => $item->id,
                'user_id' => $user->id,
                'hub_id' => $hubId,
                'qty_sistem' => 0,
                'qty_fisik' => $qtyFisik,
                'selisih' => $selisih,
                'status' => $status,
                'catatan' => $validated['catatan'] ?? null,
            ]);

            AuditLogger::log(
                $user,
                'create',
                StockOpname::class,
                $so->id,
                ['sku' => $item->sku, 'qty_fisik' => $qtyFisik, 'status' => $status],
                'success',
                'Mencatat stok opname: ' . $item->sku . ' (qty fisik ' . $qtyFisik . ')'
            );

            return $so;
        });

        return redirect()
            ->route('kepalagudang.stok-opname')
            ->with('success', 'Opname ' . $item->sku . ' tersimpan (' . $opname->status . ').');
    }
}
