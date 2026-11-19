<?php

namespace App\Http\Controllers;

use App\Models\Hub;
use App\Models\Inbound;
use App\Models\Item;
use App\Models\Location;
use App\Models\Outbound;
use App\Models\Supplier;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TransaksiBarangController extends Controller
{
    /** Halaman barang masuk. */
    public function masuk(Request $request)
    {
        $user = auth()->user();
        $hubId = $this->resolveHubId($request, $user);

        $query = Inbound::query()
            ->with(['supplier', 'item', 'location', 'hub'])
            ->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('kode', 'like', "%{$q}%")
                    ->orWhere('surat_jalan', 'like', "%{$q}%")
                    ->orWhereHas('item', fn ($i) => $i->where('sku', 'like', "%{$q}%")->orWhere('nama', 'like', "%{$q}%"))
                    ->orWhereHas('supplier', fn ($s) => $s->where('nama', 'like', "%{$q}%"));
            });
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $inbounds = $query->latest('created_at')->paginate(10)->withQueryString();

        $base = Inbound::query()->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));
        $stats = [
            'total'   => (clone $base)->count(),
            'qty'     => (clone $base)->sum('qty'),
            'selesai' => (clone $base)->where('status', 'Selesai')->count(),
            'qc'      => (clone $base)->where('status', 'Menunggu QC')->count(),
            'karantina' => (clone $base)->where('status', 'Karantina')->count(),
        ];

        $selectedHub = $hubId === 'all' ? null : Hub::find((int) $hubId);

        return view('dashboard.transaksiBarangMasuk', [
            'user'          => $user,
            'routeName'     => $this->routeNameFor('barang-masuk', $user),
            'inbounds'      => $inbounds,
            'stats'         => $stats,
            'hubs'          => Hub::orderBy('name')->get(),
            'suppliers'     => Supplier::orderBy('nama')->get(['id', 'kode', 'nama']),
            'items'         => Item::orderBy('sku')->get(['id', 'sku', 'nama']),
            'locations'     => Location::orderBy('kode')->get(['id', 'kode', 'nama']),
            'selectedHubId' => $hubId,
            'hubScopeLabel' => $selectedHub?->name ?? 'Semua Hub',
            'hubScopeCode'  => $selectedHub?->code,
            'q'             => $request->query('q', ''),
            'status'        => $request->query('status', ''),
        ]);
    }

    /** Simpan barang masuk. */
    public function storeMasuk(Request $request)
    {
        $user = auth()->user();
        if (!($user->isSuperAdmin() || $user->hasPermission('master.manage'))) {
            abort(403, 'Anda tidak memiliki izin untuk mencatat barang masuk.');
        }

        $validated = $request->validate([
            'kode' => 'required|string|max:30|unique:inbounds,kode',
            'surat_jalan' => 'nullable|string|max:40',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'item_id' => 'nullable|exists:items,id',
            'qty' => 'required|integer|min:1',
            'satuan' => 'nullable|string|max:20',
            'location_id' => 'nullable|exists:locations,id',
            'dock' => 'nullable|string|max:30',
            'status' => 'required|in:Menunggu QC,Lolos QC,Karantina,Selesai',
            'hub_id' => 'nullable|exists:hubs,id',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $hubId = $validated['hub_id'] ?? ($user->selectedHub?->id ?? null);

        $inbound = DB::transaction(function () use ($validated, $hubId, $user) {
            $row = Inbound::create(array_merge($validated, [
                'user_id' => $user->id,
                'hub_id' => $hubId,
            ]));

            AuditLogger::log(
                $user,
                'create',
                Inbound::class,
                $row->id,
                ['kode' => $row->kode, 'qty' => $row->qty, 'hub_id' => $hubId],
                'success',
                'Mencatat barang masuk: ' . $row->kode
            );

            return $row;
        });

        return redirect()->route($this->routeNameFor('barang-masuk', $user))
            ->with('success', 'Barang masuk ' . $inbound->kode . ' berhasil dicatat.');
    }

    /** Halaman barang keluar. */
    public function keluar(Request $request)
    {
        $user = auth()->user();
        $hubId = $this->resolveHubId($request, $user);

        $query = Outbound::query()
            ->with(['item', 'hub'])
            ->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('kode', 'like', "%{$q}%")
                    ->orWhere('permintaan', 'like', "%{$q}%")
                    ->orWhere('departemen', 'like', "%{$q}%")
                    ->orWhere('pic', 'like', "%{$q}%")
                    ->orWhereHas('item', fn ($i) => $i->where('sku', 'like', "%{$q}%")->orWhere('nama', 'like', "%{$q}%"));
            });
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $outbounds = $query->latest('created_at')->paginate(10)->withQueryString();

        $base = Outbound::query()->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));
        $stats = [
            'total'   => (clone $base)->count(),
            'qty'     => (clone $base)->sum('qty'),
            'selesai' => (clone $base)->where('status', 'Selesai')->count(),
            'picking' => (clone $base)->where('status', 'Picking')->count(),
            'menunggu'=> (clone $base)->where('status', 'Menunggu')->count(),
        ];

        $selectedHub = $hubId === 'all' ? null : Hub::find((int) $hubId);

        return view('dashboard.transaksiBarangKeluar', [
            'user'          => $user,
            'routeName'     => $this->routeNameFor('barang-keluar', $user),
            'outbounds'     => $outbounds,
            'stats'         => $stats,
            'hubs'          => Hub::orderBy('name')->get(),
            'items'         => Item::orderBy('sku')->get(['id', 'sku', 'nama']),
            'selectedHubId' => $hubId,
            'hubScopeLabel' => $selectedHub?->name ?? 'Semua Hub',
            'hubScopeCode'  => $selectedHub?->code,
            'q'             => $request->query('q', ''),
            'status'        => $request->query('status', ''),
        ]);
    }

    /** Simpan barang keluar. */
    public function storeKeluar(Request $request)
    {
        $user = auth()->user();
        if (!($user->isSuperAdmin() || $user->hasPermission('master.manage'))) {
            abort(403, 'Anda tidak memiliki izin untuk mencatat barang keluar.');
        }

        $validated = $request->validate([
            'kode' => 'required|string|max:30|unique:outbounds,kode',
            'permintaan' => 'nullable|string|max:30',
            'item_id' => 'nullable|exists:items,id',
            'departemen' => 'nullable|string|max:100',
            'pic' => 'nullable|string|max:100',
            'qty' => 'required|integer|min:1',
            'satuan' => 'nullable|string|max:20',
            'tujuan' => 'nullable|string|max:150',
            'status' => 'required|in:Menunggu,Picking,Selesai',
            'hub_id' => 'nullable|exists:hubs,id',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $hubId = $validated['hub_id'] ?? ($user->selectedHub?->id ?? null);

        $outbound = DB::transaction(function () use ($validated, $hubId, $user) {
            $row = Outbound::create(array_merge($validated, [
                'user_id' => $user->id,
                'hub_id' => $hubId,
            ]));

            AuditLogger::log(
                $user,
                'create',
                Outbound::class,
                $row->id,
                ['kode' => $row->kode, 'qty' => $row->qty, 'hub_id' => $hubId],
                'success',
                'Mencatat barang keluar: ' . $row->kode
            );

            return $row;
        });

        return redirect()->route($this->routeNameFor('barang-keluar', $user))
            ->with('success', 'Barang keluar ' . $outbound->kode . ' berhasil dicatat.');
    }

    private function resolveHubId(Request $request, $user): string
    {
        $hubId = $request->query('hub');
        if ($hubId === null || $hubId === '') {
            $hubId = $user->selectedHub ? (string) $user->selectedHub->id : 'all';
        }
        return $hubId;
    }

    private function routeNameFor(string $page, $user): string
    {
        $prefix = match (true) {
            $user->isSuperAdmin()   => 'admin',
            $user->isKepalaGudang() => 'kepalagudang',
            $user->isHR()           => 'hr',
            $user->isPegawai()      => 'pegawai',
            default                 => 'audit',
        };
        return $prefix . '.' . $page;
    }
}
