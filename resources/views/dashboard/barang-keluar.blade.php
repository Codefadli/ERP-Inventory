@extends('layouts.app')

@section('title', 'Barang Keluar - Astro Inventory')

@section('content')
<div class="space-y-6 animate-fade-in">
    {{-- Header Section --}}
    @include('components.navbar')

    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Main Content Area --}}
    <div class="ml-64 lg:ml-264 min-h-screen pt-6 pb-6 animate-fade-in">

        @if(auth()->user()->isAuditor())
            {{-- ============ AUDITOR VIEW: Audit Barang Keluar ============ --}}
            <div class="max-w-7xl mx-auto">
                <div class="mb-6">
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wide text-slate-500">
                            <span>Kepatuhan & Audit</span>
                            <i class="fas fa-chevron-right text-[8px]"></i>
                            <span>Pemeriksaan & Inventaris</span>
                            <i class="fas fa-chevron-right text-[8px]"></i>
                            <span class="text-blue-700">Audit Barang Keluar</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
                    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-5">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                <span class="text-[11px] font-bold uppercase text-blue-600">Warehouse Management System</span>
                            </div>
                            <h1 class="text-[25px] font-bold leading-tight text-slate-800 lg:text-[28px]">Pemeriksaan & Audit Barang Keluar</h1>
                            <p class="mt-2 text-[13px] leading-[1.8] text-slate-500">
                                Audit kesesuaian Delivery Order (DO/SPO) terhadap fisik muatan, verifikasi nomor segel armada outbound di Gate Keluar, verifikasi otorisasi pengeluaran barang bernilai tinggi, serta pencegahan risiko kehilangan barang (shrinkage).
                            </p>
                        </div>

                        <div class="flex flex-col gap-3">
                            <div class="flex flex-wrap items-center gap-2">
                                <div class="inline-flex h-9 items-center gap-2 rounded-lg border border-blue-100 bg-blue-50/70 px-3">
                                    <i class="fas fa-map-marker-alt text-blue-600"></i>
                                    <div>
                                        <span class="text-[10px] font-medium text-blue-500">Lokasi Pos</span>
                                        <p class="text-[11px] font-semibold text-blue-800">Gate 02 - Cakung DC</p>
                                    </div>
                                </div>
                                <div class="inline-flex h-9 items-center gap-2 rounded-lg border border-indigo-100 bg-indigo-50/70 px-3">
                                    <i class="fas fa-file-contract text-indigo-600"></i>
                                    <div>
                                        <span class="text-[10px] font-medium text-indigo-500">Standar Prosedur</span>
                                        <p class="text-[11px] font-semibold text-indigo-800">SPO-WMS-V4</p>
                                    </div>
                                </div>
                                <div class="inline-flex h-9 items-center gap-2 rounded-lg border border-slate-200 bg-white px-3">
                                    <i class="fas fa-sync-alt text-emerald-600"></i>
                                    <div>
                                        <span class="text-[10px] font-medium text-slate-400">Last Sync</span>
                                        <p class="text-[11px] font-semibold text-slate-700">14:02:44 WIB</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-start xl:justify-end">
                                <button onclick="toast('Menyiapkan ekspor Log Audit Outbound (PDF/CSV)...','success')" class="group inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 text-[12px] font-semibold text-white shadow-sm shadow-blue-600/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-md hover:shadow-blue-600/20 active:translate-y-0">
                                    <i class="fas fa-file-export text-[13px] transition-transform group-hover:scale-110"></i>
                                    Ekspor Log Audit Outbound
                                    <i class="fas fa-arrow-up-right text-[11px] opacity-70"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stat cards -->
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4 mb-4">
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Keluar Hari Ini</p>
                                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">16 Pengiriman</h3>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                                <i class="fas fa-arrow-up-right"></i>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Menunggu Approval</p>
                                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">3 Pengajuan</h3>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5 text-xs text-amber-600 font-semibold mt-3">
                                <i class="fas fa-clock"></i>
                                <span>Verifikasi admin/atasan</span>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Siap Dispatch / Picking</p>
                                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">4 Order</h3>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
                                    <i class="fas fa-dolly"></i>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5 text-xs text-purple-600 font-semibold mt-3">
                                <i class="fas fa-truck-loading"></i>
                                <span>Proses kemas & muat</span>
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Selesai Dikirim</p>
                                    <h3 class="text-2xl font-extrabold text-slate-900 mt-1">9 Transaksi</h3>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                                    <i class="fas fa-check-double"></i>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5 text-xs text-emerald-600 font-semibold mt-3">
                                <i class="fas fa-check-circle"></i>
                                <span>Terkonfirmasi penerima</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
                                <div class="flex items-center gap-2.5 flex-wrap">
                                    <h2 class="text-[15px] font-extrabold text-slate-800">Daftar Barang dalam Surat Jalan</h2>
                                    <span class="ai-badge bg-blue-50 text-blue-700">4 Item SKU Terdaftar</span>
                                </div>
                                <button id="btnResetHitung" class="inline-flex items-center gap-1.5 text-[13px] font-bold text-blue-600 hover:text-blue-700">
                                    <i class="fas fa-rotate-ccw" class="w-4 h-4"></i> Reset Hitungan
                                </button>
                            </div>

                            <div class="overflow-x-auto -mx-5">
                                <div class="px-5">
                                    <table class="w-full ai-table" id="sjTable">
                                        <thead>
                                            <tr class="bg-slate-50/70 border-b border-slate-100 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                                <th class="w-10"><input type="checkbox" id="checkAllSj" class="w-4 h-4 rounded border-slate-300 accent-blue-600" checked /></th>
                                                <th>SKU & Nama Barang</th>
                                                <th>QTY PO / SJ</th>
                                                <th>QTY Aktual Keluar</th>
                                                <th>Status Selisih</th>
                                                <th>Kondisi / QC</th>
                                                <th>Rekomendasi Rak (Picking)</th>
                                                <th>Aksi Cepat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="hover:bg-slate-50/60 transition-colors">
                                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                                    DO-2025-0819
                                                    <div class="text-[10px] text-slate-400 font-normal">REQ-2025-1038</div>
                                                </td>
                                                <td class="py-3.5 px-4 text-slate-600">10:15 WIB <span class="block text-[10px] text-slate-400">Hari ini</span></td>
                                                <td class="py-3.5 px-4 font-semibold text-slate-800">Departemen Operasional<br>Penerima: Ahmad Fauzi</td>
                                                <td class="py-3.5 px-4">Bubble Wrap Tebal 50m<br>SKU-PKG-BW50</td>
                                                <td class="py-3.5 px-4 text-center">5 Roll</td>
                                                <td class="py-3.5 px-4">Kurir Internal DC<br>Armada Pick-Up #02</td>
                                                <td class="py-3.5 px-4">Selesai Terkirim</td>
                                                <td class="py-3.5 px-4 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <button onclick="openDetail('DO-2025-0819')" class="p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 rounded-lg transition-colors" title="Detail Transaksi">
                                                            <i class="fas fa-eye text-xs"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr class="hover:bg-slate-50/60 transition-colors">
                                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                                    DO-2025-0820
                                                    <div class="text-[10px] text-slate-400 font-normal">REQ-2025-1045</div>
                                                </td>
                                                <td class="py-3.5 px-4 text-slate-600">11:30 WIB <span class="block text-[10px] text-slate-400">Hari ini</span></td>
                                                <td class="py-3.5 px-4 font-semibold text-slate-800">Cabang Regional Surabaya<br>PIC: Hendra Pratama</td>
                                                <td class="py-3.5 px-4">Barcode Scanner Bluetooth<br>SKU-SCN-BT01</td>
                                                <td class="py-3.5 px-4 text-center">20 Unit<br>Dus Karton</td>
                                                <td class="py-3.5 px-4">Kurir Internal DC<br>Resi: JNE882910399</td>
                                                <td class="py-3.5 px-4">Sedang Dipacking</td>
                                                <td class="py-3.5 px-4 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <button onclick="openDetail('DO-2025-0820')" class="p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 rounded-lg transition-colors" title="Detail Transaksi">
                                                            <i class="fas fa-eye text-xs"></i>
                                                        </button>
                                                        @if(auth()->user()->isSuperAdmin() || auth()->user()->isKepalaGudang())
                                                        <button class="p-1.5 bg-slate-100 hover:bg-emerald-50 hover:text-emerald-600 text-slate-600 rounded-lg transition-colors" title="Selesaikan Pengiriman">
                                                            <i class="fas fa-check text-xs"></i>
                                                        </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr class="table-row hover:bg-slate-50/70" data-gate="lolos" data-risiko="tier1" data-tujuan="retail" data-tier="tier1" data-spo="spo-2025-0892">
                                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                                    DO-2025-0892
                                                    <div class="text-[10px] text-slate-400 font-normal">REQ-2025-0892</div>
                                                </td>
                                                <td class="py-3.5 px-4 text-slate-600">Tahan Gate 04<br>12:15 WIB</td>
                                                <td class="py-3.5 px-4 font-semibold text-slate-800">Retail Store Mal Kelapa Gading<br>Store Outlet ASTRO #14</td>
                                                <td class="py-3.5 px-4">80 unit iWatch Gen 4<br>SKU: IW-G4-GRY</td>
                                                <td class="py-3.5 px-4 text-center">80 Unit<br>Kemasan Standar</td>
                                                <td class="py-3.5 px-4">Kurir Internal DC<br>Resi: JNE882910399</td>
                                                <td class="py-3.5 px-4">Tertahan / Deviasi Barcode 1 Unit<br>Barcode serial tidak cocok 1 unit</td>
                                                <td class="py-3.5 px-4 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <button onclick="openDetail('DO-2025-0892')" class="p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 rounded-lg transition-colors" title="Detail Transaksi">
                                                            <i class="fas fa-eye text-xs"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr class="table-row hover:bg-slate-50/70" data-gate="lolos" data-risiko="tier1" data-tujuan="inter-dc" data-tier="tier1" data-spo="spo-2025-1018">
                                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                                    DO-2025-1018
                                                    <div class="text-[10px] text-slate-400 font-normal">REQ-2025-1018</div>
                                                </td>
                                                <td class="py-3.5 px-4 text-slate-600">11:30 WIB <span class="block text-[10px] text-slate-400">Hari ini</span></td>
                                                <td class="py-3.5 px-4 font-semibold text-slate-800">Hub Gedebage DC-03<br>Bandung Timur, Jawa Barat</td>
                                                <td class="py-3.5 px-4">240 unit Networking & Switch<br>Enterprise Core Hardware</td>
                                                <td class="py-3.5 px-4 text-center">240 Unit<br>Enterprise Core Hardware</td>
                                                <td class="py-3.5 px-4">Kurir Internal DC<br>Fuso Box (PT Trans Jawa)</td>
                                                <td class="py-3.5 px-4 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <button onclick="openDetail('DO-2025-1018')" class="p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 rounded-lg transition-colors" title="Detail Transaksi">
                                                            <i class="fas fa-eye text-xs"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr class="table-row border-b border-slate-100 hover:bg-slate-50/70" data-gate="selesai" data-risiko="tier3" data-tujuan="ecommerce" data-tier="tier3" data-spo="spo-2025-0870">
                                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                                    DO-2025-0870
                                                    <div class="text-[10px] text-slate-400 font-normal">REQ-2025-0870</div>
                                                </td>
                                                <td class="py-3.5 px-4 text-slate-600">09:20 WIB <span class="block text-[10px] text-slate-400">Hari ini</span></td>
                                                <td class="py-3.5 px-4 font-semibold text-slate-800">E-Commerce Fulfillment Hub<br>Marunda Center Logistics</td>
                                                <td class="py-3.5 px-4">120 unit Aksesoris & Periferal<br>Muatan Reguler Tier-3</td>
                                                <td class="py-3.5 px-4 text-center">120 Unit<br>Muatan Reguler Tier-3</td>
                                                <td class="py-3.5 px-4">Van Reguler Logistik<br>B-1102-OK</td>
                                                <td class="py-3.5 px-4">Selesai Serah Terima<br>POD Fisik Terarsip</td>
                                                <td class="py-3.5 px-4 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <button onclick="openDetail('DO-2025-0870')" class="p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 rounded-lg transition-colors" title="Detail Transaksi">
                                                            <i class="fas fa-eye text-xs"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(auth()->user()->isSuperAdmin() || auth()->user()->isKepalaGudang() || auth()->user()->isPegawai())
            {{-- ============ OPERASIONAL VIEW: Manajemen Barang Keluar ============ --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Manajemen Barang Keluar</h1>
                    <p class="text-sm text-slate-500 mt-1">Pantau pengeluaran inventaris, surat jalan, alokasi permintaan departemen, dan proses dispatching.</p>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="openModal('addOutboundModal')" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                        <i class="fas fa-plus text-xs"></i>
                        <span>Catat Pengeluaran Barang</span>
                    </button>
                    <button onclick="window.print()" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-xl border border-slate-200 shadow-sm transition-colors">
                        <i class="fas fa-print text-xs"></i>
                        <span>Cetak Laporan</span>
                    </button>
                </div>
            </div>

            <!-- Stats Overview Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Keluar Hari Ini</p>
                            <h3 class="text-2xl font-extrabold text-slate-900 mt-1">16 Pengiriman</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                            <i class="fas fa-arrow-up-right"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 text-xs text-blue-600 font-semibold mt-3">
                        <i class="fas fa-boxes"></i>
                        <span>320 Unit total volume</span>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Menunggu Approval</p>
                            <h3 class="text-2xl font-extrabold text-slate-900 mt-1">3 Pengajuan</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 text-xs text-amber-600 font-semibold mt-3">
                        <i class="fas fa-clock"></i>
                        <span>Verifikasi admin/atasan</span>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Siap Dispatch / Picking</p>
                            <h3 class="text-2xl font-extrabold text-slate-900 mt-1">4 Order</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
                            <i class="fas fa-dolly"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 text-xs text-purple-600 font-semibold mt-3">
                        <i class="fas fa-truck-loading"></i>
                        <span>Proses kemas & muat</span>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Selesai Dikirim</p>
                            <h3 class="text-2xl font-extrabold text-slate-900 mt-1">9 Transaksi</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                            <i class="fas fa-check-double"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 text-xs text-emerald-600 font-semibold mt-3">
                        <i class="fas fa-check-circle"></i>
                        <span>Terkonfirmasi penerima</span>
                    </div>
                </div>
            </div>

            <!-- Main Table Section -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-2 overflow-x-auto pb-2 sm:pb-0">
                        <button class="px-3.5 py-1.5 rounded-lg bg-blue-600 text-white text-xs font-semibold shadow-sm">Semua (16)</button>
                        <button class="px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-colors">Menunggu (3)</button>
                        <button class="px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-colors">Picking (4)</button>
                        <button class="px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-colors">Selesai (9)</button>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="relative flex-1 sm:w-64">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-search text-xs"></i>
                            </span>
                            <input type="text" placeholder="Cari No DO / Departemen / SKU..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                        </div>
                        <div class="relative">
                            <select class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                                <option value="">Semua Departemen</option>
                                <option value="ops">Operasional</option>
                                <option value="it">Teknologi Informasi</option>
                                <option value="log">Logistik Wilayah</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/70 border-b border-slate-100 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                <th class="py-3.5 px-4">No DO / Ref</th>
                                <th class="py-3.5 px-4">Waktu Keluar</th>
                                <th class="py-3.5 px-4">Tujuan / Departemen</th>
                                <th class="py-3.5 px-4">Barang & SKU</th>
                                <th class="py-3.5 px-4 text-center">Jumlah</th>
                                <th class="py-3.5 px-4">Kurir / Ekspedisi</th>
                                <th class="py-3.5 px-4">Status Dispatch</th>
                                <th class="py-3.5 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                                    DO-2025-0819
                                                    <div class="text-[10px] text-slate-400 font-normal">REQ-2025-1038</div>
                                                </td>
                                <td class="py-3.5 px-4 text-slate-600">10:15 WIB <span class="block text-[10px] text-slate-400">Hari ini</span></td>
                                <td class="py-3.5 px-4 font-semibold text-slate-800">Departemen Operasional<br>Penerima: Ahmad Fauzi</td>
                                <td class="py-3.5 px-4">Bubble Wrap Tebal 50m<br>SKU-PKG-BW50</td>
                                <td class="py-3.5 px-4 text-center">5 Roll</td>
                                <td class="py-3.5 px-4">Kurir Internal DC<br>Armada Pick-Up #02</td>
                                <td class="py-3.5 px-4">Selesai Terkirim</td>
                                                <td class="py-3.5 px-4 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <button onclick="openDetail('DO-2025-0819')" class="p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 rounded-lg transition-colors" title="Detail Transaksi">
                                                            <i class="fas fa-eye text-xs"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr class="hover:bg-slate-50/60 transition-colors">
                                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                                    DO-2025-0820
                                                    <div class="text-[10px] text-slate-400 font-normal">REQ-2025-1045</div>
                                                </td>
                                                <td class="py-3.5 px-4 text-slate-600">11:30 WIB <span class="block text-[10px] text-slate-400">Hari ini</span></td>
                                                <td class="py-3.5 px-4 font-semibold text-slate-800">Cabang Regional Surabaya<br>PIC: Hendra Pratama</td>
                                                <td class="py-3.5 px-4">Barcode Scanner Bluetooth<br>SKU-SCN-BT01</td>
                                                <td class="py-3.5 px-4 text-center">20 Unit<br>Dus Karton</td>
                                                <td class="py-3.5 px-4">Kurir Internal DC<br>Resi: JNE882910399</td>
                                                <td class="py-3.5 px-4">Sedang Dipacking</td>
                                                <td class="py-3.5 px-4 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <button onclick="openDetail('DO-2025-0820')" class="p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 rounded-lg transition-colors" title="Detail Transaksi">
                                                            <i class="fas fa-eye text-xs"></i>
                                                        </button>
                                                        @if(auth()->user()->isSuperAdmin() || auth()->user()->isKepalaGudang())
                                                        <button class="p-1.5 bg-slate-100 hover:bg-emerald-50 hover:text-emerald-600 text-slate-600 rounded-lg transition-colors" title="Selesaikan Pengiriman">
                                                            <i class="fas fa-check text-xs"></i>
                                                        </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr class="table-row hover:bg-slate-50/70" data-gate="lolos" data-risiko="tier1" data-tujuan="retail" data-tier="tier1" data-spo="spo-2025-0892">
                                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                                    DO-2025-0892
                                                    <div class="text-[10px] text-slate-400 font-normal">REQ-2025-0892</div>
                                                </td>
                                                <td class="py-3.5 px-4 text-slate-600">Tahan Gate 04<br>12:15 WIB</td>
                                                <td class="py-3.5 px-4 font-semibold text-slate-800">Retail Store Mal Kelapa Gading<br>Store Outlet ASTRO #14</td>
                                                <td class="py-3.5 px-4">80 unit iWatch Gen 4<br>SKU: IW-G4-GRY</td>
                                                <td class="py-3.5 px-4 text-center">80 Unit<br>Kemasan Standar</td>
                                                <td class="py-3.5 px-4">Kurir Internal DC<br>Resi: JNE882910399</td>
                                                <td class="py-3.5 px-4">Tertahan / Deviasi Barcode 1 Unit<br>Barcode serial tidak cocok 1 Unit</td>
                                                <td class="py-3.5 px-4 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <button onclick="openDetail('DO-2025-0892')" class="p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 rounded-lg transition-colors" title="Detail Transaksi">
                                                            <i class="fas fa-eye text-xs"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                    </table>
                </div>
            </div>
        @else
            {{-- ============ HR & OTHER: Access Denied ============ --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                <i class="fas fa-shield-alt text-5xl text-slate-300 mb-4"></i>
                <h2 class="text-xl font-bold text-slate-900 mb-2">Akses Tidak Tersedia</h2>
                <p class="text-slate-500">Role Anda tidak memiliki akses ke modul Barang Keluar.</p>
            </div>
        @endif
    </div>
</div>

{{-- Modals --}}
@if(auth()->user()->isSuperAdmin() || auth()->user()->isKepalaGudang() || auth()->user()->isPegawai())
<div id="addOutboundModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-sm hidden">
    <div class="bg-white rounded-2xl w-full max-w-lg mx-4 overflow-hidden shadow-2xl border border-slate-200 animate-fade-up">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-sm font-bold text-slate-900">Catat Barang Keluar (Outbound)</h3>
            <button onclick="closeModal('addOutboundModal')" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        <form action="#" method="POST" class="p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor DO / Surat Jalan</label>
                    <input type="text" placeholder="Contoh: DO-2025-0821" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Referensi Pengajuan / SPB</label>
                    <input type="text" placeholder="Contoh: REQ-2025-1049" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Departemen / Cabang Tujuan</label>
                <select class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                    <option value="">Pilih Departemen / Cabang</option>
                    <option value="ops">Operasional DC</option>
                    <option value="it">Teknologi Informasi</option>
                    <option value="sby">Cabang Regional Surabaya</option>
                    <option value="bdg">Cabang Regional Bandung</option>
                </select>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Barang (SKU)</label>
                    <select class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                        <option value="">Pilih SKU Barang</option>
                        <option value="sku-pkg">SKU-PKG-BW50 - Bubble Wrap</option>
                        <option value="sku-scn">SKU-SCN-BT01 - Scanner Bluetooth</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah Keluar</label>
                    <input type="number" placeholder="0" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('addOutboundModal')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm">Simpan & Proses Keluar</button>
            </div>
        </form>
    </div>
</div>

<div id="detailOutboundModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-sm hidden">
    <div class="bg-white rounded-2xl w-full max-w-lg mx-4 overflow-hidden shadow-2xl border border-slate-200 animate-fade-up">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-sm font-bold text-slate-900">Detail Transaksi Barang Keluar</h3>
            <button onclick="closeModal('detailOutboundModal')" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Nomor DO</span>
                    <h4 class="text-sm font-extrabold text-slate-900">DO-2025-0819</h4>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Selesai Terkirim</span>
            </div>
            <div class="grid grid-cols-2 gap-4 text-xs">
                <div>
                    <span class="text-slate-400">Referensi Pengajuan:</span>
                    <p class="font-semibold text-slate-800 mt-0.5">REQ-2025-1038</p>
                </div>
                <div>
                    <span class="text-slate-400">Waktu Pengeluaran:</span>
                    <p class="font-semibold text-slate-800 mt-0.5">Hari ini, 10:15 WIB</p>
                </div>
                <div>
                    <span class="text-slate-400">Tujuan Pengiriman:</span>
                    <p class="font-semibold text-slate-800 mt-0.5">Departemen Operasional</p>
                </div>
                <div>
                    <span class="text-slate-400">Penerima / PIC:</span>
                    <p class="font-semibold text-slate-800 mt-0.5">Ahmad Fauzi</p>
                </div>
                <div>
                    <span class="text-slate-400">Barang & SKU:</span>
                    <p class="font-semibold text-slate-800 mt-0.5">Bubble Wrap Tebal 50m (SKU-PKG-BW50)</p>
                </div>
                <div>
                    <span class="text-slate-400">Jumlah Dikeluarkan:</span>
                    <p class="font-semibold text-slate-800 mt-0.5">5 Roll</p>
                </div>
                <div>
                    <span class="text-slate-400">Ekspedisi / Armada:</span>
                    <p class="font-semibold text-blue-600 mt-0.5">Kurir Internal DC (Pick-Up #02)</p>
                </div>
                <div>
                    <span class="text-slate-400">Status Dokumen:</span>
                    <p class="font-semibold text-slate-800 mt-0.5">Ditandatangani Digital</p>
                </div>
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                <button onclick="closeModal('detailOutboundModal')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors">Tutup</button>
                <button onclick="window.print()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm">Cetak Surat Jalan</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
</script>
@endsection