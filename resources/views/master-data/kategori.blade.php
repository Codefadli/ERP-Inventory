@extends('layouts.master')

@section('title', 'Master Kategori')

@section('content')
<div x-data="{ modalAddOpen: false, search: '' }">
    <!-- Header -->
    <div class="flex items-center justify-between mb-5">
        <div>
            <h1 class="text-lg font-bold text-slate-900">Kategori Barang</h1>
            <p class="text-xs text-slate-500">Kelompok kategori untuk pengelompokan item inventaris.</p>
        </div>
        <button @click="modalAddOpen = true" class="px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-medium flex items-center gap-1.5">
            <i class="fa-solid fa-plus text-[10px]"></i>
            <span>Tambah Kategori</span>
        </button>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-lg border border-slate-200">
        <div class="p-3 border-b border-slate-200 flex items-center justify-between">
            <div class="relative w-64">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" x-model="search" placeholder="Cari kategori..."
                       class="w-full pl-8 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded text-xs focus:bg-white focus:outline-none focus:border-blue-500">
            </div>
            <span class="text-xs text-slate-400">{{ count($categories) }} total</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold">
                        <th class="py-2.5 px-4 w-10 text-center">#</th>
                        <th class="py-2.5 px-4">Kode</th>
                        <th class="py-2.5 px-4">Nama Kategori</th>
                        <th class="py-2.5 px-4">Deskripsi</th>
                        <th class="py-2.5 px-4 text-center">Total SKU</th>
                        <th class="py-2.5 px-4 text-center">Status</th>
                        <th class="py-2.5 px-4 text-center w-20">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @foreach($categories as $i => $cat)
                    <tr class="hover:bg-slate-50" x-show="'{{ strtolower($cat['nama']) }} {{ strtolower($cat['kode']) }}'.includes(search.toLowerCase())">
                        <td class="py-2.5 px-4 text-center text-slate-400 font-mono text-[11px]">{{ $i + 1 }}</td>
                        <td class="py-2.5 px-4 font-mono font-medium text-slate-900">{{ $cat['kode'] }}</td>
                        <td class="py-2.5 px-4 font-medium text-slate-900">{{ $cat['nama'] }}</td>
                        <td class="py-2.5 px-4 text-slate-500">{{ $cat['deskripsi'] }}</td>
                        <td class="py-2.5 px-4 text-center font-mono">{{ $cat['total_sku'] }}</td>
                        <td class="py-2.5 px-4 text-center">
                            @if($cat['status'] == 'Aktif')
                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">Aktif</span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600">Nonaktif</span>
                            @endif
                        </td>
                        <td class="py-2.5 px-4 text-center">
                            <div class="flex items-center justify-center gap-2 text-slate-400">
                                <button @click="$dispatch('show-toast', 'Edit')" class="hover:text-blue-600"><i class="fa-regular fa-pen-to-square"></i></button>
                                <button @click="$dispatch('show-toast', 'Hapus')" class="hover:text-rose-600"><i class="fa-regular fa-trash-can"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div x-cloak x-show="modalAddOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
        <div @click.away="modalAddOpen = false" class="bg-white rounded-lg shadow-xl max-w-md w-full border border-slate-200 overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-slate-900">Tambah Kategori</h3>
                <button @click="modalAddOpen = false" class="text-slate-400 hover:text-slate-600 text-xs"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form @submit.prevent="modalAddOpen = false; $dispatch('show-toast', 'Kategori disimpan')" class="p-5 space-y-3 text-xs">
                <div>
                    <label class="block font-medium text-slate-700 mb-1">Kode Kategori *</label>
                    <input type="text" value="KAT-007" required class="w-full px-3 py-1.5 border border-slate-300 rounded font-mono focus:border-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block font-medium text-slate-700 mb-1">Nama Kategori *</label>
                    <input type="text" placeholder="Nama kategori" required class="w-full px-3 py-1.5 border border-slate-300 rounded focus:border-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block font-medium text-slate-700 mb-1">Deskripsi</label>
                    <textarea rows="2" placeholder="Keterangan..." class="w-full px-3 py-1.5 border border-slate-300 rounded focus:border-blue-500 focus:outline-none"></textarea>
                </div>
                <div class="pt-3 border-t border-slate-200 flex justify-end gap-2">
                    <button type="button" @click="modalAddOpen = false" class="px-3 py-1.5 border border-slate-300 rounded text-slate-700 hover:bg-slate-50 font-medium">Batal</button>
                    <button type="submit" class="px-4 py-1.5 bg-blue-600 text-white rounded font-medium hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
