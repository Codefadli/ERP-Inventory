<?php

namespace App\Http\Controllers;

use App\Models\Hub;
use App\Models\Item;
use App\Models\RequestBarang;
use App\Models\StockOpname;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class PegawaiPageController extends Controller
{
    /** Riwayat transaksi & log aktivitas staf. */
    public function riwayat(Request $request)
    {
        $user = auth()->user();
        $hubId = $this->resolveHubId($request, $user);

        $query = RequestBarang::query()
            ->with(['user', 'hub'])
            ->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('tiket', 'like', "%{$q}%")
                    ->orWhere('tipe', 'like', "%{$q}%")
                    ->orWhere('rincian', 'like', "%{$q}%");
            });
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $riwayats = $query->latest('created_at')->paginate(10)->withQueryString();

        $base = RequestBarang::query()->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));
        $stats = [
            'total' => (clone $base)->count(),
            'selesai' => (clone $base)->where('status', 'Selesai')->count(),
            'pending' => (clone $base)->where('status', 'Menunggu')->count(),
            'ditolak' => (clone $base)->where('status', 'Ditolak')->count(),
        ];

        $selectedHub = $hubId === 'all' ? null : Hub::find((int) $hubId);

        return view('dashboard.pegawai.riwayatTransaksi', [
            'user'          => $user,
            'routeName'     => 'pegawai.riwayat-transaksi',
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

    /** Status permintaan (portal pegawai). */
    public function permintaan(Request $request)
    {
        $user = auth()->user();
        $hubId = $this->resolveHubId($request, $user);

        $query = RequestBarang::query()
            ->with(['user', 'hub'])
            ->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('tiket', 'like', "%{$q}%")
                    ->orWhere('rincian', 'like', "%{$q}%");
            });
        }

        $permintaans = $query->latest('created_at')->paginate(10)->withQueryString();

        $base = RequestBarang::query()->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));
        $stats = [
            'total'    => (clone $base)->count(),
            'menunggu' => (clone $base)->where('status', 'Menunggu')->count(),
            'disetujui'=> (clone $base)->where('status', 'Disetujui')->count(),
            'ditolak'  => (clone $base)->where('status', 'Ditolak')->count(),
            'selesai'  => (clone $base)->where('status', 'Selesai')->count(),
        ];

        $selectedHub = $hubId === 'all' ? null : Hub::find((int) $hubId);

        return view('dashboard.pegawai.statusPermintaan', [
            'user'          => $user,
            'routeName'     => 'pegawai.status-permintaan',
            'permintaans'   => $permintaans,
            'stats'         => $stats,
            'hubs'          => Hub::orderBy('name')->get(),
            'items'         => Item::orderBy('nama')->get(['id', 'sku', 'nama', 'hub_id']),
            'selectedHubId' => $hubId,
            'hubScopeLabel' => $selectedHub?->name ?? 'Semua Hub',
            'hubScopeCode'  => $selectedHub?->code,
            'q'             => $request->query('q', ''),
            'status'        => $request->query('status', ''),
        ]);
    }

    /** Simpan permintaan baru. */
    public function storePermintaan(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'tipe' => 'required|string|max:60',
            'rincian' => 'required|string|max:1000',
            'prioritas' => 'required|in:Normal,Tinggi',
            'item_id' => 'nullable|exists:items,id',
            'hub_id' => 'nullable|exists:hubs,id',
        ]);

        $hubId = $validated['hub_id'] ?? ($user->selectedHub?->id ?? null);
        if (empty($hubId) && $request->query('hub') !== null && $request->query('hub') !== 'all') {
            $hubId = (int) $request->query('hub');
        }

        $requestBarang = DB::transaction(function () use ($validated, $hubId, $user) {
            $tiket = 'REQ-' . now()->format('ymd') . '-' . strtoupper(Str::random(4));
            $rb = RequestBarang::create([
                'tiket' => $tiket,
                'tipe' => $validated['tipe'],
                'rincian' => $validated['rincian'],
                'prioritas' => $validated['prioritas'],
                'approver' => 'Kepala Gudang',
                'status' => 'Menunggu',
                'user_id' => $user->id,
                'hub_id' => $hubId,
            ]);

            AuditLogger::log(
                $user,
                'create',
                RequestBarang::class,
                $rb->id,
                ['tiket' => $tiket, 'tipe' => $rb->tipe, 'hub_id' => $hubId],
                'success',
                'Mengajukan permintaan barang: ' . $tiket
            );

            return $rb;
        });

        return redirect()
            ->route('pegawai.status-permintaan')
            ->with('success', 'Permintaan ' . $requestBarang->tiket . ' berhasil diajukan (status Menunggu).');
    }

    /** Stok opname (hasil hitung fisik). */
    public function opname(Request $request)
    {
        $user = auth()->user();
        $hubId = $this->resolveHubId($request, $user);

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

        // Item yang belum pernah diopname (untuk form input baru).
        $sudahDiopname = StockOpname::pluck('item_id')->all();
        $itemsBelum = Item::query()
            ->with('location')
            ->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId))
            ->whereNotIn('id', $sudahDiopname)
            ->orderBy('sku')
            ->get(['id', 'sku', 'nama', 'location_id', 'hub_id']);

        return view('dashboard.pegawai.stokOpname', [
            'user'          => $user,
            'routeName'     => 'pegawai.stok-opname',
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

    /** Simpan hasil opname fisik. */
    public function storeOpname(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'qty_fisik' => 'required|integer|min:0',
            'catatan' => 'nullable|string|max:500',
            'hub_id' => 'nullable|exists:hubs,id',
        ]);

        $item = Item::findOrFail($validated['item_id']);
        $qtyFisik = (int) $validated['qty_fisik'];
        $qtySistem = 0; // stok sistem belum tercatat di items (tidak ada kolom stok fisik)
        $selisih = $qtySistem - $qtyFisik;
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
            ->route('pegawai.stok-opname')
            ->with('success', 'Opname ' . $item->sku . ' tersimpan (' . $opname->status . ').');
    }

    private function resolveHubId(Request $request, $user): string
    {
        $hubId = $request->query('hub');
        if ($hubId === null || $hubId === '') {
            $hubId = $user->selectedHub ? (string) $user->selectedHub->id : 'all';
        }
        return $hubId;
    }
}
