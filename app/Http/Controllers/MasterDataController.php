<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Location;
use App\Models\Supplier;
use App\Models\Division;
use App\Models\Item;
use App\Http\Requests\MasterData\StoreCategoryRequest;
use App\Http\Requests\MasterData\UpdateCategoryRequest;
use App\Http\Requests\MasterData\StoreUnitRequest;
use App\Http\Requests\MasterData\UpdateUnitRequest;
use App\Http\Requests\MasterData\StoreLocationRequest;
use App\Http\Requests\MasterData\UpdateLocationRequest;
use App\Http\Requests\MasterData\StoreSupplierRequest;
use App\Http\Requests\MasterData\UpdateSupplierRequest;
use App\Http\Requests\MasterData\StoreDivisionRequest;
use App\Http\Requests\MasterData\UpdateDivisionRequest;
use App\Http\Requests\MasterData\StoreItemRequest;
use App\Http\Requests\MasterData\UpdateItemRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:master.view')->only('index');
        $this->middleware('permission:master.manage')->only(['store', 'update', 'activate', 'deactivate']);
    }

    // =========================================================================
    // CATEGORIES
    // =========================================================================

    public function kategori()
    {
        $categories = Category::when(request('q'), function ($q) {
            $q->where('nama', 'like', '%' . request('q') . '%')
              ->orWhere('kode', 'like', '%' . request('q') . '%');
        })
            ->where('status', true)
            ->latest('created_at')
            ->paginate(20);

        return view('master-data.kategori', [
            'categories' => $categories,
            'active_sub' => 'kategori',
            'search' => request('q'),
        ]);
    }

    public function getCategories(Request $request)
    {
        $categories = Category::when($request->q, function ($q) {
            $q->where('nama', 'like', '%' . $request->q . '%')
              ->orWhere('kode', 'like', '%' . $request->q . '%');
        })
            ->where('status', true)
            ->latest('created_at')
            ->get(['id', 'kode', 'nama', 'status']);

        return response()->json($categories);
    }

    public function activateCategory(Category $category)
    {
        $category->status = true;
        $category->save();

        return redirect()->back()
            ->with('success', 'Kategori "'.$category->nama.'" diaktifkan.');
    }

    public function deactivateCategory(Category $category)
    {
        $category->status = false;
        $category->save();

        return redirect()->back()
            ->with('success', 'Kategori "'.$category->nama.'" dinonaktifkan.');
    }

    // =========================================================================
    // UNITS (SATUAN)
    // =========================================================================

    public function satuan()
    {
        $units = Unit::when(request('q'), function ($q) {
            $q->where('nama', 'like', '%' . request('q') . '%')
              ->orWhere('kode', 'like', '%' . request('q') . '%');
        })
            ->where('status', true)
            ->latest('created_at')
            ->paginate(20);

        return view('master-data.satuan', [
            'units' => $units,
            'active_sub' => 'satuan',
            'search' => request('q'),
        ]);
    }

    public function getUnits(Request $request)
    {
        $units = Unit::when($request->q, function ($q) {
            $q->where('nama', 'like', '%' . $request->q . '%')
              ->orWhere('kode', 'like', '%' . $request->q . '%');
        })
            ->where('status', true)
            ->latest('created_at')
            ->get(['id', 'kode', 'nama', 'status']);

        return response()->json($units);
    }

    public function activateUnit(Unit $unit)
    {
        $unit->status = true;
        $unit->save();

        return redirect()->back()
            ->with('success', 'Satuan "'.$unit->nama.'" diaktifkan.');
    }

    public function deactivateUnit(Unit $unit)
    {
        $unit->status = false;
        $unit->save();

        return redirect()->back()
            ->with('success', 'Satuan "'.$unit->nama.'" dinonaktifkan.');
    }

    // =========================================================================
    // LOCATIONS (LOKASI / RAK)
    // =========================================================================

    public function lokasi()
    {
        $locations = Location::when(request('q'), function ($q) {
            $q->where('nama', 'like', '%' . request('q') . '%')
              ->orWhere('kode', 'like', '%' . request('q') . '%');
        })
            ->where('status', true)
            ->latest('created_at')
            ->paginate(20);

        return view('master-data.lokasi', [
            'locations' => $locations,
            'active_sub' => 'lokasi',
            'search' => request('q'),
        ]);
    }

    public function getLocations(Request $request)
    {
        $locations = Location::when($request->q, function ($q) {
            $q->where('nama', 'like', '%' . $request->q . '%')
              ->orWhere('kode', 'like', '%' . $request->q . '%');
        })
            ->where('status', true)
            ->latest('created_at')
            ->get(['id', 'kode', 'nama', 'status', 'gudang']);

        return response()->json($locations);
    }

    public function activateLocation(Location $location)
    {
        $location->status = true;
        $location->save();

        return redirect()->back()
            ->with('success', 'Lokasi diaktifkan.');
    }

    public function deactivateLocation(Location $location)
        {
            $location->status = false;
            $location->save();

            return redirect()->back()
                ->with('success', 'Lokasi nonaktif.');
        }

    // =========================================================================
    // SUPPLIER
    // =========================================================================

    public function supplier()
    {
        $suppliers = Supplier::when(request('q'), function ($q) {
            $q->where('nama', 'like', '%' . request('q') . '%')
              ->orWhere('kode', 'like', '%' . request('q') . '%');
        })
            ->where('status', true)
            ->latest('created_at')
            ->paginate(20);

        return view('master-data.supplier', [
            'suppliers' => $suppliers,
            'active_sub' => 'supplier',
            'search' => request('q'),
        ]);
    }

    public function getSuppliers(Request $request)
    {
        $suppliers = Supplier::when($request->q, function ($q) {
            $q->where('nama', 'like', '%' . $request->q . '%')
              ->orWhere('kode', 'like', '%' . $request->q . '%');
        })
            ->where('status', true)
            ->latest('created_at')
            ->get(['id', 'kode', 'nama', 'status']);

        return response()->json($suppliers);
    }

    public function activateSupplier(Supplier $supplier)
    {
        $supplier->status = true;
        $supplier->save();

        return redirect()->back()
            ->with('success', 'Supplier "'.$supplier->nama.'\" diaktifkan.');
    }

    public function deactivateSupplier(Supplier $supplier)
    {
        $supplier->status = false;
        $supplier->save();

        return redirect()->back()
            ->with('success', 'Supplier "'.$supplier->nama.'\" dinonaktifkan.');
    }

    // =========================================================================
    // DIVISIONS (DIVISI)
    // =========================================================================

    public function divisi()
    {
        $divisions = Division::when(request('q'), function ($q) {
            $q->where('nama', 'like', '%' . request('q') . '%')
              ->orWhere('kode', 'like', '%' . request('q') . '%');
        })
            ->where('status', true)
            ->latest('created_at')
            ->paginate(20);

        return view('master-data.divisi', [
            'divisions' => $divisions,
            'active_sub' => 'divisi',
            'search' => request('q'),
        ]);
    }

    public function getDivisions(Request $request)
    {
        $divisions = Division::when($request->q, function ($q) {
            $q->where('nama', 'like', '%' . $request->q . '%')
              ->orWhere('kode', 'like', '%' . $request->q . '%');
        })
            ->where('status', true)
            ->latest('created_at')
            ->get(['id', 'kode', 'nama', 'status']);

        return response()->json($divisions);
    }

    public function activateDivision(Division $division)
    {
        $division->status = true;
        $division->save();

        return redirect()->back()
            ->with('success', 'Divisi "'.$division->nama.'\" diaktifkan.');
    }

    public function deactivateDivision(Division $division)
    {
        $division->status = false;
        $division->save();

        return redirect()->back()
            ->with('success', 'Divisi "'.$division->nama.'\" dinonaktifkan.');
    }

    // =========================================================================
    // ITEMS (BARANG) - CRUD FULL
    // =========================================================================

    public function barang()
    {
        $items = Item::when(request('search'), function ($q) {
            $q->where('sku', 'like', '%' . request('search') . '%')
              ->orWhere('nama', 'like', '%' . request('search') . '%')
              ->orWhere('barcode', 'like', '%' . request('search') . '%');
        })
            ->when(request('category_id'), function ($q) {
                $q->where('category_id', request('category_id'));
            })
            ->when(request('unit_id'), function ($q) {
                $q->where('unit_id', request('unit_id'));
            })
            ->when(request('location_id'), function ($q) {
                $q->where('location_id', request('location_id'));
            })
            ->when(request('supplier_id'), function ($q) {
                $q->where('supplier_id', request('supplier_id'));
            })
            ->when(request('division_id'), function ($q) {
                $q->where('division_id', request('division_id'));
            })
            ->when(request('status'), function ($q) {
                $q->where('status', request('status'));
            })
            ->latest('created_at')
            ->paginate(20);

        $categories = Category::where('status', true)->get();
        $units = Unit::where('status', true)->get();
        $locations = Location::where('status', true)->get();
        $suppliers = Supplier::where('status', true)->get();
        $divisions = Division::where('status', true)->get();

        return view('master-data.barang', [
            'items' => $items,
            'categories' => $categories,
            'units' => $units,
            'locations' => $locations,
            'suppliers' => $suppliers,
            'divisions' => $divisions,
            'active_sub' => 'barang',
            'search' => request('search'),
        ]);
    }

    public function getItems(Request $request)
    {
        $items = Item::when($request->search, function ($q) {
            $q->where('sku', 'like', '%' . $request->search . '%')
              ->orWhere('nama', 'like', '%' . $request->search . '%')
              ->orWhere('barcode', 'like', '%' . $request->search . '%');
        })
            ->when($request->category_id, function ($q) {
                $q->where('category_id', $request->category_id);
            })
            ->when($request->unit_id, function ($q) {
                $q->where('unit_id', $request->unit_id);
            })
            ->when($request->location_id, function ($q) {
                $q->where('location_id', $request->location_id);
            })
            ->when($request->supplier_id, function ($q) {
                $q->where('supplier_id', $request->supplier_id);
            })
            ->when($request->division_id, function ($q) {
                $q->where('division_id', $request->division_id);
            })
            ->when($request->status, function ($q) {
                $q->where('status', $request->status);
            })
            ->latest('created_at')
            ->paginate(20);

        return response()->json($items);
    }

    public function createItem()
    {
        return response()->view('master-data.create-item', [
            'categories' => Category::where('status', true)->get(),
            'units' => Unit::where('status', true)->get(),
            'locations' => Location::where('status', true)->get(),
            'suppliers' => Supplier::where('status', true)->get(),
            'divisions' => Division::where('status', true)->get(),
        ]);
    }

    public function storeItem(StoreItemRequest $request)
    {
        $validated = $request->validated();

        $validated['status'] = $validated['status'] ?? 'Aktif';

        $item = Item::create($validated);

        // Audit trail
        if (auth()->check()) {
            \Log::info('Item created', [
                'user_id' => auth()->id(),
                'item_id' => $item->id,
                'sku' => $item->sku,
                'action' => 'create',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Barang "' . $item->nama . '" berhasil dibuat.',
            'item' => $item,
        ]);
    }

    public function showItem(Item $item)
    {
        return response()->json($item);
    }

    public function editItem(Item $item)
    {
        return response()->view('master-data.edit-item', [
            'item' => $item,
            'categories' => Category::where('status', true)->get(),
            'units' => Unit::where('status', true)->get(),
            'locations' => Location::where('status', true)->get(),
            'suppliers' => Supplier::where('status', true)->get(),
            'divisions' => Division::where('status', true)->get(),
        ]);
    }

    public function updateItem(UpdateItemRequest $request, Item $item)
    {
        $validated = $request->validated();

        $item->update($validated);

        // Audit trail
        if (auth()->check()) {
            \Log::info('Item updated', [
                'user_id' => auth()->id(),
                'item_id' => $item->id,
                'sku' => $item->sku,
                'action' => 'update',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Barang "' . $item->nama . '" berhasil diperbarui.',
            'item' => $item,
        ]);
    }

    public function activateItem(Item $item)
    {
        $item->status = 'Aktif';
        $item->save();

        return redirect()->back()
            ->with('success', 'Barang "'.$item->sku.'" diaktifkan.');
    }

    public function deactivateItem(Item $item)
    {
        $item->status = 'Nonaktif';
        $item->save();

        return redirect()->back()
            ->with('success', 'Barang "'.$item->sku.'\" dinonaktifkan.');
    }

    // =========================================================================
    // ROUTE METHOD FILTER
    // =========================================================================

    public function __call($method, $parameters)
    {
        // Handle method not found gracefully
        abort(404, 'Method '.$method.' tidak ditemukan.');
    }
}