<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StoreDivisionRequest;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\StoreSupplierRequest;
use App\Models\Category;
use App\Models\Division;
use App\Models\Hub;
use App\Models\Location;
use App\Models\Supplier;
use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MasterDataPageController extends Controller
{
    private function hubScope(Request $request)
    {
        $user = auth()->user();
        $hub = $user->selectedHub;

        $hubId = $request->query('hub');
        if ($hubId === null || $hubId === '') {
            $hubId = $hub ? (string) $hub->id : 'all';
        }

        $selectedHub = $hubId === 'all' ? null : Hub::find((int) $hubId);

        return [
            'hubId'          => $hubId,
            'selectedHub'    => $selectedHub,
            'hubScopeLabel'  => $selectedHub?->name ?? 'Semua Hub',
            'hubScopeCode'   => $selectedHub?->code,
        ];
    }

    /** Data gudang & lokasi rak (satu view bersama 3 role). */
    public function lokasi(Request $request)
    {
        $user = auth()->user();
        $hub = $this->hubScope($request);

        $query = Location::query()
            ->with('hub')
            ->when($hub['hubId'] !== 'all', fn ($q) => $q->where('hub_id', $hub['hubId']));

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('kode', 'like', "%{$q}%")
                    ->orWhere('nama', 'like', "%{$q}%")
                    ->orWhere('gudang', 'like', "%{$q}%")
                    ->orWhere('nama_rak', 'like', "%{$q}%");
            });
        }

        if ($building = $request->query('gudang')) {
            $query->where('gudang', $building);
        }

        $locations = $query->latest('created_at')->paginate(10)->withQueryString();

        $base = Location::query()->when($hub['hubId'] !== 'all', fn ($q) => $q->where('hub_id', $hub['hubId']));
        $stats = [
            'total'    => (clone $base)->count(),
            'kapasitas'=> (clone $base)->sum('kapasitas'),
            'terisi'   => (clone $base)->sum('terisi'),
            'aktif'    => (clone $base)->where('status', true)->count(),
        ];
        $stats['persen'] = $stats['kapasitas'] > 0
            ? round(($stats['terisi'] / $stats['kapasitas']) * 100)
            : 0;

        $routeName = match (true) {
            $user->isSuperAdmin()   => 'admin.data-gudang-lokasi',
            $user->isKepalaGudang() => 'kepalagudang.data-gudang-lokasi',
            default                 => 'audit.data-gudang-lokasi',
        };

        return view('dashboard.dataGudangLokasi', [
            'user'          => $user,
            'routeName'     => $routeName,
            'canManage'     => $user->isSuperAdmin() || $user->hasPermission('master.manage'),
            'locations'     => $locations,
            'stats'         => $stats,
            'hubs'          => Hub::orderBy('name')->get(),
            'buildings'     => Location::query()
                ->when($hub['hubId'] !== 'all', fn ($q) => $q->where('hub_id', $hub['hubId']))
                ->distinct()->pluck('gudang')->sort()->values(),
            'hubScopeLabel' => $hub['hubScopeLabel'],
            'hubScopeCode'  => $hub['hubScopeCode'],
            'selectedHubId' => $hub['hubId'],
            'q'             => $request->query('q', ''),
            'gudang'        => $request->query('gudang', ''),
        ]);
    }

    /** Data departemen. */
    public function departemen(Request $request)
    {
        $user = auth()->user();
        $hub = $this->hubScope($request);

        $query = Division::query()
            ->with('hub')
            ->when($hub['hubId'] !== 'all', fn ($q) => $q->where('hub_id', $hub['hubId']));

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('kode', 'like', "%{$q}%")
                    ->orWhere('nama', 'like', "%{$q}%")
                    ->orWhere('kepala', 'like', "%{$q}%");
            });
        }

        $divisions = $query->latest('created_at')->paginate(10)->withQueryString();

        $base = Division::query()->when($hub['hubId'] !== 'all', fn ($q) => $q->where('hub_id', $hub['hubId']));
        $stats = [
            'total'  => (clone $base)->count(),
            'aktif'  => (clone $base)->where('status', true)->count(),
        ];

        return view('dashboard.superadmin.dataDepartemen', [
            'user'          => $user,
            'routeName'     => 'admin.data-departemen',
            'canManage'     => $user->isSuperAdmin() || $user->hasPermission('master.manage'),
            'divisions'     => $divisions,
            'stats'         => $stats,
            'hubs'          => Hub::orderBy('name')->get(),
            'hubScopeLabel' => $hub['hubScopeLabel'],
            'hubScopeCode'  => $hub['hubScopeCode'],
            'selectedHubId' => $hub['hubId'],
            'q'             => $request->query('q', ''),
        ]);
    }

    /** Data supplier. */
    public function supplier(Request $request)
    {
        $user = auth()->user();
        $hub = $this->hubScope($request);

        $query = Supplier::query()
            ->with('hub')
            ->when($hub['hubId'] !== 'all', fn ($q) => $q->where('hub_id', $hub['hubId']));

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('kode', 'like', "%{$q}%")
                    ->orWhere('nama', 'like', "%{$q}%")
                    ->orWhere('pic', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $suppliers = $query->latest('created_at')->paginate(10)->withQueryString();

        $base = Supplier::query()->when($hub['hubId'] !== 'all', fn ($q) => $q->where('hub_id', $hub['hubId']));
        $stats = [
            'total' => (clone $base)->count(),
            'aktif' => (clone $base)->where('status', true)->count(),
        ];

        return view('dashboard.superadmin.dataSuplier', [
            'user'          => $user,
            'routeName'     => 'admin.data-supplier',
            'canManage'     => $user->isSuperAdmin() || $user->hasPermission('master.manage'),
            'suppliers'     => $suppliers,
            'stats'         => $stats,
            'hubs'          => Hub::orderBy('name')->get(),
            'hubScopeLabel' => $hub['hubScopeLabel'],
            'hubScopeCode'  => $hub['hubScopeCode'],
            'selectedHubId' => $hub['hubId'],
            'q'             => $request->query('q', ''),
        ]);
    }

    /** Kategori barang. */
    public function kategori(Request $request)
    {
        $user = auth()->user();
        $hub = $this->hubScope($request);

        $query = Category::query()
            ->with('hub')
            ->when($hub['hubId'] !== 'all', fn ($q) => $q->where('hub_id', $hub['hubId']));

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('kode', 'like', "%{$q}%")
                    ->orWhere('nama', 'like', "%{$q}%")
                    ->orWhere('deskripsi', 'like', "%{$q}%");
            });
        }

        $categories = $query->latest('created_at')->paginate(10)->withQueryString();

        $base = Category::query()->when($hub['hubId'] !== 'all', fn ($q) => $q->where('hub_id', $hub['hubId']));
        $stats = [
            'total' => (clone $base)->count(),
            'aktif' => (clone $base)->where('status', true)->count(),
        ];

        return view('dashboard.superadmin.kategoriBarang', [
            'user'          => $user,
            'routeName'     => 'admin.kategori-barang',
            'canManage'     => $user->isSuperAdmin() || $user->hasPermission('master.manage'),
            'categories'    => $categories,
            'stats'         => $stats,
            'hubs'          => Hub::orderBy('name')->get(),
            'hubScopeLabel' => $hub['hubScopeLabel'],
            'hubScopeCode'  => $hub['hubScopeCode'],
            'selectedHubId' => $hub['hubId'],
            'q'             => $request->query('q', ''),
        ]);
    }

    /** Simpan lokasi / fasilitas rak baru. */
    public function storeLokasi(StoreLocationRequest $request)
    {
        $user = auth()->user();
        if (!($user->isSuperAdmin() || $user->hasPermission('master.manage'))) {
            abort(403, 'Anda tidak memiliki izin untuk menambah lokasi.');
        }

        $data = $request->validated();
        if (empty($data['hub_id']) && $user->selectedHub) {
            $data['hub_id'] = $user->selectedHub->id;
        }

        $location = DB::transaction(function () use ($data, $user) {
            $loc = Location::create($data);

            AuditLogger::log(
                $user,
                'create',
                Location::class,
                $loc->id,
                ['kode' => $loc->kode, 'nama' => $loc->nama, 'gudang' => $loc->gudang, 'hub_id' => $loc->hub_id],
                'success',
                'Menambahkan lokasi rak: ' . $loc->nama . ' (' . $loc->kode . ')'
            );

            return $loc;
        });

        return redirect()
            ->route($user->isSuperAdmin() ? 'admin.data-gudang-lokasi' : 'kepalagudang.data-gudang-lokasi')
            ->with('success', 'Lokasi ' . $location->nama . ' berhasil ditambahkan.');
    }

    /** Simpan departemen baru. */
    public function storeDepartemen(StoreDivisionRequest $request)
    {
        $user = auth()->user();
        if (!($user->isSuperAdmin() || $user->hasPermission('master.manage'))) {
            abort(403, 'Anda tidak memiliki izin untuk menambah departemen.');
        }

        $data = $request->validated();
        if (empty($data['hub_id']) && $user->selectedHub) {
            $data['hub_id'] = $user->selectedHub->id;
        }

        $division = DB::transaction(function () use ($data, $user) {
            $div = Division::create($data);

            AuditLogger::log(
                $user,
                'create',
                Division::class,
                $div->id,
                ['kode' => $div->kode, 'nama' => $div->nama, 'hub_id' => $div->hub_id],
                'success',
                'Menambahkan departemen: ' . $div->nama . ' (' . $div->kode . ')'
            );

            return $div;
        });

        return redirect()
            ->route('admin.data-departemen')
            ->with('success', 'Departemen ' . $division->nama . ' berhasil ditambahkan.');
    }

    /** Simpan supplier baru. */
    public function storeSupplier(StoreSupplierRequest $request)
    {
        $user = auth()->user();
        if (!($user->isSuperAdmin() || $user->hasPermission('master.manage'))) {
            abort(403, 'Anda tidak memiliki izin untuk menambah supplier.');
        }

        $data = $request->validated();
        if (empty($data['hub_id']) && $user->selectedHub) {
            $data['hub_id'] = $user->selectedHub->id;
        }

        $supplier = DB::transaction(function () use ($data, $user) {
            $sup = Supplier::create($data);

            AuditLogger::log(
                $user,
                'create',
                Supplier::class,
                $sup->id,
                ['kode' => $sup->kode, 'nama' => $sup->nama, 'hub_id' => $sup->hub_id],
                'success',
                'Menambahkan supplier: ' . $sup->nama . ' (' . $sup->kode . ')'
            );

            return $sup;
        });

        return redirect()
            ->route('admin.data-supplier')
            ->with('success', 'Supplier ' . $supplier->nama . ' berhasil ditambahkan.');
    }

    /** Simpan kategori baru. */
    public function storeKategori(StoreCategoryRequest $request)
    {
        $user = auth()->user();
        if (!($user->isSuperAdmin() || $user->hasPermission('master.manage'))) {
            abort(403, 'Anda tidak memiliki izin untuk menambah kategori.');
        }

        $data = $request->validated();
        if (empty($data['hub_id']) && $user->selectedHub) {
            $data['hub_id'] = $user->selectedHub->id;
        }

        $category = DB::transaction(function () use ($data, $user) {
            $cat = Category::create($data);

            AuditLogger::log(
                $user,
                'create',
                Category::class,
                $cat->id,
                ['kode' => $cat->kode, 'nama' => $cat->nama, 'hub_id' => $cat->hub_id],
                'success',
                'Menambahkan kategori: ' . $cat->nama . ' (' . $cat->kode . ')'
            );

            return $cat;
        });

        return redirect()
            ->route('admin.kategori-barang')
            ->with('success', 'Kategori ' . $category->nama . ' berhasil ditambahkan.');
    }
}
