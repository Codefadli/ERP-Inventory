@extends('layouts.master')

@section('title', 'Master Barang')

@section('content')
<div x-data="{ 
    modalAddOpen: false, 
    modalBarcodeOpen: false, 
    selectedItem: null,
    search: '',
    categoryFilter: '',
    statusFilter: ''
}">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
        <div>
            <h1 class="text-lg font-bold text-slate-900">Master Data Barang</h1>
            <p class="text-xs text-slate-500">Kelola daftar item, SKU, satuan, dan penempatan rak.</p>
        </div>

        <div class="flex items-center gap-2">
            <button @click="$dispatch('show-toast', 'Import template')" 
                    class="px-3 py-1.5 bg-white border border-slate-300 rounded text-xs font-medium text-slate-700 hover:bg-slate-50">
                <i class="fa-solid fa-file-import mr-1.5 text-slate-400"></i>Import
            </button>
            <button @click="$dispatch('show-toast', 'Export data')" 
                    class="px-3 py-1.5 bg-white border border-slate-300 rounded text-xs font-medium text-slate-700 hover:bg-slate-50">
                <i class="fa-solid fa-file-export mr-1.5 text-slate-400"></i>Export
            </button>
            <button @click="modalAddOpen = true" 
                    class="px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-medium flex items-center gap-1.5">
                <i class="fa-solid fa-plus text-[10px]"></i>
                <span>Tambah Barang</span>
            </button>
        </div>
    </div>

    <!-- Quick Stats Metric Strip -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">
        <div class="bg-white px-4 py-3 rounded-lg border border-slate-200">
            <span class="text-[11px] font-medium text-slate-500">Total SKU</span>
            <div class="text-lg font-bold text-slate-800 mt-0.5">{{ count($items) }}</div>
        </div>
        <div class="bg-white px-4 py-3 rounded-lg border border-slate-200">
            <span class="text-[11px] font-medium text-slate-500">Stok Menipis</span>
            <div class="text-lg font-bold text-rose-600 mt-0.5">2 <span class="text-xs font-normal text-slate-400">item</span></div>
        </div>
        <div class="bg-white px-4 py-3 rounded-lg border border-slate-200">
            <span class="text-[11px] font-medium text-slate-500">Kategori Aktif</span>
            <div class="text-lg font-bold text-slate-800 mt-0.5">{{ count($categories) }}</div>
        </div>
        <div class="bg-white px-4 py-3 rounded-lg border border-slate-200">
            <span class="text-[11px] font-medium text-slate-500">Estimasi Nilai Aset</span>
            <div class="text-lg font-bold text-slate-800 mt-0.5">Rp 12.450.000</div>
        </div>
    </div>

    <!-- Filter & Table Card -->
    <div class="bg-white rounded-lg border border-slate-200">
        <!-- Filter Toolbar -->
        <div class="p-3 border-b border-slate-200 flex flex-wrap items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-2 flex-1">
                <div class="relative w-64">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" x-model="search" placeholder="Cari nama atau SKU..."
                           class="w-full pl-8 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded text-xs focus:bg-white focus:outline-none focus:border-blue-500">
                </div>

                <select x-model="categoryFilter" class="px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded text-xs text-slate-700 focus:outline-none focus:border-blue-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat['nama'] }}">{{ $cat['nama'] }}</option>
                    @endforeach
                </select>

                <select x-model="statusFilter" class="px-2.5 py-1.5 bg-slate-50 border border-slate-200 rounded text-xs text-slate-700 focus:outline-none focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="Aktif">Stok Normal</option>
                    <option value="Stok Kritis">Stok Kritis</option>
                </select>
            </div>

            <span class="text-xs text-slate-400">{{ count($items) }} item ditemukan</span>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold">
                        <th class="py-2.5 px-4 w-10 text-center">#</th>
                        <th class="py-2.5 px-4">SKU / Barcode</th>
                        <th class="py-2.5 px-4">Nama Barang</th>
                        <th class="py-2.5 px-4">Kategori</th>
                        <th class="py-2.5 px-4">Satuan</th>
                        <th class="py-2.5 px-4">Lokasi Rak</th>
                        <th class="py-2.5 px-4 text-center">Stok</th>
                        <th class="py-2.5 px-4 text-right">Harga Beli</th>
                        <th class="py-2.5 px-4 text-center">Status</th>
                        <th class="py-2.5 px-4 text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @foreach($items as $i => $item)
                    <tr class="hover:bg-slate-50"
                        x-show="(
                            '{{ strtolower($item['nama']) }} {{ strtolower($item['sku']) }} {{ strtolower($item['barcode']) }}'.includes(search.toLowerCase())
                        ) && (
                            categoryFilter === '' || '{{ $item['kategori'] }}' === categoryFilter
                        ) && (
                            statusFilter === '' || '{{ $item['status'] }}' === statusFilter
                        )">
                        <td class="py-2.5 px-4 text-center text-slate-400 font-mono text-[11px]">{{ $i + 1 }}</td>
                        <td class="py-2.5 px-4">
                            <div class="font-mono font-medium text-slate-900">{{ $item['sku'] }}</div>
                            <div class="text-[11px] text-slate-400">{{ $item['barcode'] }}</div>
                        </td>
                        <td class="py-2.5 px-4">
                            <span class="font-medium text-slate-900">{{ $item['nama'] }}</span>
                        </td>
                        <td class="py-2.5 px-4 text-slate-600">{{ $item['kategori'] }}</td>
                        <td class="py-2.5 px-4 text-slate-600">{{ $item['satuan'] }}</td>
                        <td class="py-2.5 px-4">
                            <span class="px-2 py-0.5 rounded bg-slate-100 font-mono text-[11px] text-slate-700">{{ $item['lokasi'] }}</span>
                        </td>
                        <td class="py-2.5 px-4 text-center">
                            <span class="font-semibold {{ $item['stok'] <= $item['min_stok'] ? 'text-rose-600' : 'text-slate-800' }}">
                                {{ $item['stok'] }}
                            </span>
                            <span class="text-[10px] text-slate-400 block">Min: {{ $item['min_stok'] }}</span>
                        </td>
                        <td class="py-2.5 px-4 text-right text-slate-800 font-medium">
                            Rp {{ number_format($item['harga_beli'], 0, ',', '.') }}
                        </td>
                        <td class="py-2.5 px-4 text-center">
                            @if($item['status'] == 'Stok Kritis')
                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-rose-50 text-rose-700 border border-rose-200">
                                    Kritis
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Normal
                                </span>
                            @endif
                        </td>
                        <td class="py-2.5 px-4 text-center">
                            <div class="flex items-center justify-center gap-1.5 text-slate-400">
                                <button @click="selectedItem = {{ json_encode($item) }}; modalBarcodeOpen = true" 
                                        class="hover:text-slate-700 p-1" title="Cetak Barcode">
                                    <i class="fa-solid fa-qrcode"></i>
                                </button>
                                <button @click="$dispatch('show-toast', 'Edit {{ $item['sku'] }}')" 
                                        class="hover:text-blue-600 p-1" title="Edit">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <button @click="$dispatch('show-toast', 'Hapus {{ $item['sku'] }}')" 
                                        class="hover:text-rose-600 p-1" title="Hapus">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer Pagination -->
        <div class="px-4 py-3 border-t border-slate-200 flex items-center justify-between text-xs text-slate-500">
            <span>Menampilkan 1 - {{ count($items) }} dari {{ count($items) }} data</span>
            <div class="flex items-center gap-1">
                <button class="px-2.5 py-1 border border-slate-200 rounded text-slate-400" disabled>Sebelumnya</button>
                <button class="px-2.5 py-1 bg-slate-900 text-white rounded font-medium">1</button>
                <button class="px-2.5 py-1 border border-slate-200 rounded text-slate-600 hover:bg-slate-50">Selanjutnya</button>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH BARANG -->
    <div x-cloak x-show="modalAddOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
        <div @click.away="modalAddOpen = false" class="bg-white rounded-lg shadow-xl max-w-xl w-full border border-slate-200 overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-slate-900">Tambah Data Barang</h3>
                <button @click="modalAddOpen = false" class="text-slate-400 hover:text-slate-600 text-xs"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <form @submit.prevent="modalAddOpen = false; $dispatch('show-toast', 'Barang berhasil disimpan')" class="p-5 space-y-3.5 text-xs">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-medium text-slate-700 mb-1">Kode SKU *</label>
                        <input type="text" value="ELK-0015" required class="w-full px-3 py-1.5 border border-slate-300 rounded font-mono focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block font-medium text-slate-700 mb-1">Barcode / EAN</label>
                        <input type="text" placeholder="Opsional" class="w-full px-3 py-1.5 border border-slate-300 rounded font-mono focus:border-blue-500 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-slate-700 mb-1">Nama Barang *</label>
                    <input type="text" placeholder="Nama item barang" required class="w-full px-3 py-1.5 border border-slate-300 rounded focus:border-blue-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block font-medium text-slate-700 mb-1">Kategori *</label>
                        <select required class="w-full px-2.5 py-1.5 border border-slate-300 rounded focus:border-blue-500 focus:outline-none">
                            <option value="">Pilih...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat['id'] }}">{{ $cat['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium text-slate-700 mb-1">Satuan *</label>
                        <select required class="w-full px-2.5 py-1.5 border border-slate-300 rounded focus:border-blue-500 focus:outline-none">
                            <option value="">Pilih...</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit['kode'] }}">{{ $unit['kode'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium text-slate-700 mb-1">Lokasi Rak *</label>
                        <select required class="w-full px-2.5 py-1.5 border border-slate-300 rounded focus:border-blue-500 focus:outline-none">
                            <option value="">Pilih...</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc['kode'] }}">{{ $loc['kode'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block font-medium text-slate-700 mb-1">Stok Minimum *</label>
                        <input type="number" min="0" value="5" required class="w-full px-3 py-1.5 border border-slate-300 rounded focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block font-medium text-slate-700 mb-1">Harga Beli Acuan</label>
                        <input type="number" min="0" placeholder="Rp" class="w-full px-3 py-1.5 border border-slate-300 rounded focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block font-medium text-slate-700 mb-1">Harga Jual Acuan</label>
                        <input type="number" min="0" placeholder="Rp" class="w-full px-3 py-1.5 border border-slate-300 rounded focus:border-blue-500 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-slate-700 mb-1">Deskripsi / Spesifikasi</label>
                    <textarea rows="2" placeholder="Catatan tambahan..." class="w-full px-3 py-1.5 border border-slate-300 rounded focus:border-blue-500 focus:outline-none"></textarea>
                </div>

                <div class="pt-3 border-t border-slate-200 flex justify-end gap-2">
                    <button type="button" @click="modalAddOpen = false" class="px-3 py-1.5 border border-slate-300 rounded text-slate-700 hover:bg-slate-50 font-medium">Batal</button>
                    <button type="submit" class="px-4 py-1.5 bg-blue-600 text-white rounded font-medium hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL CETAK BARCODE -->
    <div x-cloak x-show="modalBarcodeOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
        <div @click.away="modalBarcodeOpen = false" class="bg-white rounded-lg shadow-xl max-w-sm w-full border border-slate-200 overflow-hidden">
            <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-xs font-semibold text-slate-900">Label Barcode</h3>
                <button @click="modalBarcodeOpen = false" class="text-slate-400 hover:text-slate-600 text-xs"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div class="p-5 text-center" x-show="selectedItem">
                <div class="border border-slate-300 rounded p-4 bg-white mx-auto max-w-xs">
                    <p class="text-[11px] font-semibold text-slate-900 truncate" x-text="selectedItem ? selectedItem.nama : ''"></p>
                    <div class="my-2 font-mono tracking-widest text-2xl font-bold text-slate-800">||||| | |||| | |||</div>
                    <p class="font-mono text-xs text-slate-600" x-text="selectedItem ? selectedItem.sku : ''"></p>
                    <div class="flex justify-between text-[10px] text-slate-500 border-t border-slate-200 pt-1.5 mt-2 font-mono">
                        <span x-text="'Rak: ' + (selectedItem ? selectedItem.lokasi : '')"></span>
                        <span x-text="'UoM: ' + (selectedItem ? selectedItem.satuan : '')"></span>
                    </div>
                </div>

                <div class="mt-4 flex gap-2">
                    <div class="flex-1 text-left">
                        <label class="block text-[11px] text-slate-600 mb-1">Jumlah</label>
                        <input type="number" min="1" value="1" class="w-full px-2.5 py-1.5 border border-slate-300 rounded text-xs">
                    </div>
                    <div class="flex-1 text-left">
                        <label class="block text-[11px] text-slate-600 mb-1">Ukuran</label>
                        <select class="w-full px-2.5 py-1.5 border border-slate-300 rounded text-xs">
                            <option>50 x 30 mm</option>
                            <option>40 x 20 mm</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="px-4 py-2.5 bg-slate-50 border-t border-slate-200 flex justify-end gap-2">
                <button @click="modalBarcodeOpen = false" class="px-3 py-1 border border-slate-300 rounded text-xs text-slate-700 hover:bg-slate-100">Batal</button>
                <button @click="modalBarcodeOpen = false; $dispatch('show-toast', 'Label dicetak')" class="px-3 py-1 bg-slate-900 text-white rounded text-xs hover:bg-slate-800">Cetak</button>
            </div>
        </div>
    </div>

</div>
@endsection
