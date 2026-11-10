@extends('layouts.master')

@section('title', 'Master Satuan')

@section('content')
<div x-data="{ modalAddOpen: false, search: '' }">
    <!-- Header -->
    <div class="flex items-center justify-between mb-5">
        <div>
            <h1 class="text-lg font-bold text-slate-900">Satuan Barang (UoM)</h1>
            <p class="text-xs text-slate-500">Daftar satuan unit hitung untuk pencatatan kuantitas stok.</p>
        </div>
        <button @click="modalAddOpen = true" class="px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-medium flex items-center gap-1.5">
            <i class="fa-solid fa-plus text-[10px]"></i>
            <span>Tambah Satuan</span>
        </button>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-lg border border-slate-200">
        <div class="p-3 border-b border-slate-200 flex items-center justify-between">
            <div class="relative w-64">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" x-model="search" placeholder="Cari satuan..."
                       class="w-full pl-8 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded text-xs focus:bg-white focus:outline-none focus:border-blue-500">
            </div>
            <span class="text-xs text-slate-400">{{ count($units) }} total</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold">
                        <th class="py-2.5 px-4 w-10 text-center">#</th>
                        <th class="py-2.5 px-4">Kode (UoM)</th>
                        <th class="py-2.5 px-4">Nama Satuan</th>
                        <th class="py-2.5 px-4">Keterangan</th>
                        <th class="py-2.5 px-4 text-center">Status</th>
                        <th class="py-2.5 px-4 text-center w-20">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @foreach($units as $i => $unit)
                    <tr class="hover:bg-slate-50" x-show="'{{ strtolower($unit['nama']) }} {{ strtolower($unit['kode']) }}'.includes(search.toLowerCase())">
                        <td class="py-2.5 px-4 text-center text-slate-400 font-mono text-[11px]">{{ $i + 1 }}</td>
                        <td class="py-2.5 px-4 font-mono font-semibold text-slate-900">{{ $unit['kode'] }}</td>
                        <td class="py-2.5 px-4 font-medium text-slate-900">{{ $unit['nama'] }}</td>
                        <td class="py-2.5 px-4 text-slate-500">{{ $unit['keterangan'] }}</td>
                        <td class="py-2.5 px-4 text-center">
                            <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">{{ $unit['status'] }}</span>
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
                <h3 class="text-sm font-semibold text-slate-900">Tambah Satuan</h3>
                <button @click="modalAddOpen = false" class="text-slate-400 hover:text-slate-600 text-xs"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form @submit.prevent="modalAddOpen = false; $dispatch('show-toast', 'Satuan disimpan')" class="p-5 space-y-3 text-xs">
                <div>
                    <label class="block font-medium text-slate-700 mb-1">Kode UoM *</label>
                    <input type="text" placeholder="Contoh: DUS, PAIR, MTR" required class="w-full px-3 py-1.5 border border-slate-300 rounded font-mono uppercase focus:border-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block font-medium text-slate-700 mb-1">Nama Satuan *</label>
                    <input type="text" placeholder="Contoh: Dus / Pasang" required class="w-full px-3 py-1.5 border border-slate-300 rounded focus:border-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block font-medium text-slate-700 mb-1">Keterangan</label>
                    <input type="text" placeholder="Catatan opsional..." class="w-full px-3 py-1.5 border border-slate-300 rounded focus:border-blue-500 focus:outline-none">
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
