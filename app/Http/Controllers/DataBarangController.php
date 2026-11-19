<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Models\Category;
use App\Models\Division;
use App\Models\Hub;
use App\Models\Item;
use App\Models\Location;
use App\Models\Supplier;
use App\Models\Unit;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Halaman Data Barang / Katalog SKU.
 *
 * Tampilan tersedia untuk role yang memiliki prototype di FolderHTML:
 * - Super Admin   -> admin.data-barang        (master.view)
 * - Kepala Gudang -> kepalagudang.data-barang (master.view)
 * - Pegawai       -> pegawai.data-barang      (master.view)
 * - Auditor       -> audit.data-barang        (audit.view, read-only)
 *
 * Data diambil dari tabel items (bukan simulasi). Filter server-side:
 * hub (default hub terpilih user; opsi "Semua Hub"), pencarian SKU/
 * barcode/nama/lokasi, filter kategori, filter status, paginasi.
 */
class DataBarangController extends Controller
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

        $query = Item::query()
            ->with(['category', 'unit', 'location', 'supplier', 'division', 'hub'])
            ->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId));

        // Pencarian: SKU, barcode, nama, kode/nama lokasi
        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('sku', 'like', "%{$q}%")
                    ->orWhere('barcode', 'like', "%{$q}%")
                    ->orWhere('nama', 'like', "%{$q}%")
                    ->orWhereHas('location', function ($l) use ($q) {
                        $l->where('kode', 'like', "%{$q}%")
                            ->orWhere('nama', 'like', "%{$q}%")
                            ->orWhere('nama_rak', 'like', "%{$q}%");
                    });
            });
        }

        // Filter kategori
        if ($categoryId = $request->query('category')) {
            $query->where('category_id', $categoryId);
        }

        // Filter status
        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $items = $query->latest('created_at')->paginate(10)->withQueryString();

        $stats = [
            'total'   => Item::query()->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId))->count(),
            'aktif'   => Item::query()->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId))->where('status', 'Aktif')->count(),
            'kritis'  => Item::query()->when($hubId !== 'all', fn ($q) => $q->where('hub_id', $hubId))->where('status', 'Stok Kritis')->count(),
            'kategori'=> Category::count(),
        ];

        $selectedHub = $hubId === 'all' ? null : Hub::find((int) $hubId);
        $hubScopeLabel = $selectedHub?->name ?? 'Semua Hub';
        $hubScopeCode = $selectedHub?->code;

        $routeName = match (true) {
            $user->isSuperAdmin()   => 'admin.data-barang',
            $user->isKepalaGudang() => 'kepalagudang.data-barang',
            $user->isPegawai()      => 'pegawai.data-barang',
            default                 => 'audit.data-barang',
        };

        return view('dashboard.dataBarang', [
            'user'          => $user,
            'routeName'     => $routeName,
            'items'         => $items,
            'stats'         => $stats,
            'hubs'          => Hub::orderBy('name')->get(),
            'categories'    => Category::orderBy('nama')->get(),
            'units'         => Unit::orderBy('nama')->get(),
            'locations'     => Location::orderBy('kode')->get(),
            'suppliers'     => Supplier::orderBy('nama')->get(),
            'divisions'     => Division::orderBy('nama')->get(),
            'selectedHub'   => $selectedHub,
            'selectedHubId' => $hubId,
            'hubScopeLabel' => $hubScopeLabel,
            'hubScopeCode'  => $hubScopeCode,
            'q'             => $request->query('q', ''),
            'category'      => $categoryId ?? '',
            'status'        => $status ?? '',
        ]);
    }

    /**
     * Menyimpan barang baru (tambah data barang).
     * Hanya role dengan permission product.manage / master.manage.
     */
    public function store(StoreItemRequest $request)
    {
        $user = auth()->user();

        // Otorisasi ganda: FormRequest authorize + guard di sini
        if (!($user->isSuperAdmin()
            || $user->hasPermission('product.manage')
            || $user->hasPermission('master.manage'))) {
            abort(403, 'Anda tidak memiliki izin untuk menambah barang.');
        }

        $data = $request->validated();

        // Default hub: jika kosong, pakai hub terpilih user
        if (empty($data['hub_id']) && $user->selectedHub) {
            $data['hub_id'] = $user->selectedHub->id;
        }

        $item = DB::transaction(function () use ($data, $user) {
            $item = Item::create($data);

            AuditLogger::log(
                $user,
                'create',
                Item::class,
                $item->id,
                ['nama' => $item->nama, 'sku' => $item->sku, 'hub_id' => $item->hub_id],
                'success',
                'Menambahkan barang baru: ' . $item->nama . ' (' . $item->sku . ')'
            );

            return $item;
        });

        return redirect()
            ->route($user->isSuperAdmin() ? 'admin.data-barang' : 'kepalagudang.data-barang')
            ->with('success', 'Barang ' . $item->nama . ' berhasil ditambahkan.');
    }
}
