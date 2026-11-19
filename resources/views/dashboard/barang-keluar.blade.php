<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transaksi Barang Keluar — Astro Inventory</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { brand: { DEFAULT: '#2563eb', dark: '#1d4ed8', 50: '#eff6ff', 100: '#dbeafe', 600: '#2563eb', 700: '#1d4ed8' } },
                    fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                },
            },
        };
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root { --brand: #2563eb; --brand-dark: #1d4ed8; --bg: #f5f7fb; --line: #e7ebf2; }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif; }

        .nav-link { transition: all 0.16s ease; }
        .nav-link:hover { background: #f1f5f9; color: #172033; transform: translateX(3px); }
        .nav-link.active { background: var(--brand); color: #fff; font-weight: 600; box-shadow: 0 6px 14px -6px rgba(37, 99, 235, 0.55); }
        .nav-link.active:hover { transform: none; background: var(--brand); }

        .reveal { animation: rise-in .4s cubic-bezier(.2,.8,.2,1) both; }
        @keyframes rise-in { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

        @media (min-width: 768px) { main { zoom: 1.1; } }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; }
        }
    </style>
</head>

<body class="bg-gray-50">
@include('components.navbar')

<div class="flex min-h-screen bg-[#f5f7fc] text-[#17243b] antialiased">
    @include('components.sidebar')

    <main class="flex-1 p-4 lg:p-6 overflow-x-hidden">
        @php
            $outboundTransactions = [
                ['do' => 'DO-2025-0819', 'req' => 'REQ-2025-1038', 'time' => '10:15 WIB', 'dept' => 'Departemen Operasional', 'pic' => 'Ahmad Fauzi', 'item' => 'Bubble Wrap Tebal 50m', 'sku' => 'SKU-PKG-BW50', 'qty' => '5 Roll', 'courier' => 'Kurir Internal DC (Pick-Up #02)', 'status' => 'selesai'],
                ['do' => 'DO-2025-0820', 'req' => 'REQ-2025-1045', 'time' => '11:30 WIB', 'dept' => 'Cabang Regional Surabaya', 'pic' => 'Hendra Pratama', 'item' => 'Barcode Scanner Bluetooth', 'sku' => 'SKU-SCN-BT01', 'qty' => '20 Unit', 'courier' => 'Kurir Internal DC (JNE882910399)', 'status' => 'picking'],
                ['do' => 'DO-2025-0892', 'req' => 'REQ-2025-0892', 'time' => '12:15 WIB', 'dept' => 'Retail Store Mal Kelapa Gading', 'pic' => 'Store Outlet ASTRO #14', 'item' => '80 unit iWatch Gen 4', 'sku' => 'SKU: IW-G4-GRY', 'qty' => '80 Unit', 'courier' => 'Kurir Internal DC', 'status' => 'picking'],
            ];
            $totalCount = count($outboundTransactions);
            $menungguCount = collect($outboundTransactions)->where('status', 'menunggu')->count();
            $pickingCount = collect($outboundTransactions)->where('status', 'picking')->count();
            $selesaiCount = collect($outboundTransactions)->where('status', 'selesai')->count();
        @endphp

        {{-- 1. ROLE AUDITOR: Tampilan Khusus Audit & Kepatuhan Outbound --}}
        @if(auth()->user()->isAuditor())
            {{-- ============ AUDITOR VIEW: Audit Barang Keluar ============ --}}
            <div class="w-full">
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

                <!-- Table Section -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-5">
                    <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <h2 class="text-[15px] font-extrabold text-slate-800">Daftar Barang dalam Surat Jalan</h2>
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">4 Item SKU Terdaftar</span>
                        </div>
                        <button onclick="toast('Reset hitungan audit berhasil','info')" class="inline-flex items-center gap-1.5 text-[13px] font-bold text-blue-600 hover:text-blue-700">
                            <i class="fas fa-rotate-ccw"></i> Reset Hitungan
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr class="bg-slate-50/70 border-b border-slate-100 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                    <th class="py-3 px-4 w-10"><input type="checkbox" checked class="rounded border-slate-300 accent-blue-600"></th>
                                    <th class="py-3 px-4">SKU & Nama Barang</th>
                                    <th class="py-3 px-4">QTY PO / SJ</th>
                                    <th class="py-3 px-4">QTY Aktual Keluar</th>
                                    <th class="py-3 px-4">Status Selisih</th>
                                    <th class="py-3 px-4">Kondisi / QC</th>
                                    <th class="py-3 px-4">Rekomendasi Rak (Picking)</th>
                                    <th class="py-3 px-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3.5 px-4"><input type="checkbox" checked class="rounded border-slate-300 accent-blue-600"></td>
                                    <td class="py-3.5 px-4 font-bold text-slate-900">
                                        SKU-PKG-BW50
                                        <div class="text-[10px] text-slate-400 font-normal">Bubble Wrap Tebal 50m</div>
                                    </td>
                                    <td class="py-3.5 px-4 font-semibold text-slate-800">5 Roll</td>
                                    <td class="py-3.5 px-4 font-semibold text-emerald-700">5 Roll</td>
                                    <td class="py-3.5 px-4"><span class="px-2 py-1 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700">Sesuai (0 Discrepancy)</span></td>
                                    <td class="py-3.5 px-4"><span class="px-2 py-1 rounded-full text-[10px] font-semibold bg-blue-50 text-blue-700">Lolos QC Gate</span></td>
                                    <td class="py-3.5 px-4 text-slate-600">Dock 1 Utama (Rak A-01)</td>
                                    <td class="py-3.5 px-4 text-right">
                                        <button onclick="toast('Memeriksa audit detail SKU-PKG-BW50','success')" class="p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 rounded-lg transition-colors" title="Detail Audit">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3.5 px-4"><input type="checkbox" checked class="rounded border-slate-300 accent-blue-600"></td>
                                    <td class="py-3.5 px-4 font-bold text-slate-900">
                                        SKU-SCN-BT01
                                        <div class="text-[10px] text-slate-400 font-normal">Barcode Scanner Bluetooth</div>
                                    </td>
                                    <td class="py-3.5 px-4 font-semibold text-slate-800">20 Unit</td>
                                    <td class="py-3.5 px-4 font-semibold text-emerald-700">20 Unit</td>
                                    <td class="py-3.5 px-4"><span class="px-2 py-1 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700">Sesuai (0 Discrepancy)</span></td>
                                    <td class="py-3.5 px-4"><span class="px-2 py-1 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-700">Picking / Segel Box</span></td>
                                    <td class="py-3.5 px-4 text-slate-600">Rak B-04-02</td>
                                    <td class="py-3.5 px-4 text-right">
                                        <button onclick="toast('Memeriksa audit detail SKU-SCN-BT01','success')" class="p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 rounded-lg transition-colors" title="Detail Audit">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3.5 px-4"><input type="checkbox" checked class="rounded border-slate-300 accent-blue-600"></td>
                                    <td class="py-3.5 px-4 font-bold text-slate-900">
                                        IW-G4-GRY
                                        <div class="text-[10px] text-slate-400 font-normal">80 unit iWatch Gen 4</div>
                                    </td>
                                    <td class="py-3.5 px-4 font-semibold text-slate-800">80 Unit</td>
                                    <td class="py-3.5 px-4 font-semibold text-amber-700">78 Unit</td>
                                    <td class="py-3.5 px-4"><span class="px-2 py-1 rounded-full text-[10px] font-semibold bg-red-50 text-red-700">Selisih -2 Unit (Tertahan)</span></td>
                                    <td class="py-3.5 px-4"><span class="px-2 py-1 rounded-full text-[10px] font-semibold bg-red-50 text-red-700">Deviasi Barcode</span></td>
                                    <td class="py-3.5 px-4 text-slate-600">Rak C-02 (High Value)</td>
                                    <td class="py-3.5 px-4 text-right">
                                        <button onclick="toast('Membuka berita acara deviasi barang high-value','warning')" class="p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 rounded-lg transition-colors" title="Detail Audit">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @elseif(auth()->user()->isSuperAdmin() || auth()->user()->isKepalaGudang() || auth()->user()->isPegawai())
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
        
        {{-- 2. ROLE OPERASIONAL (SuperAdmin, KepalaGudang, Pegawai): Manajemen Outbound --}}
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
                        <button onclick="filterOutbound('semua', this)" class="px-3.5 py-1.5 rounded-lg bg-blue-600 text-white text-xs font-semibold shadow-sm transition-all">Semua (<span id="count-semua">{{ $totalCount }}</span>)</button>
                        <button onclick="filterOutbound('menunggu', this)" class="px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-all">Menunggu (<span id="count-menunggu">{{ $menungguCount }}</span>)</button>
                        <button onclick="filterOutbound('picking', this)" class="px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-all">Picking (<span id="count-picking">{{ $pickingCount }}</span>)</button>
                        <button onclick="filterOutbound('selesai', this)" class="px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-all">Selesai (<span id="count-selesai">{{ $selesaiCount }}</span>)</button>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="relative flex-1 sm:w-64">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-search text-xs"></i>
                            </span>
                            <input type="text" id="outboundSearchInput" oninput="searchOutboundTable()" placeholder="Cari No DO / Departemen / SKU..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                        </div>
                        <div class="relative">
                            <select id="deptFilterSelect" onchange="searchOutboundTable()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                                <option value="">Semua Departemen</option>
                                <option value="Operasional">Operasional</option>
                                <option value="Surabaya">Surabaya</option>
                                <option value="Kelapa Gading">Kelapa Gading</option>
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

<div id="addOutboundModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-sm hidden">
    <div class="bg-white rounded-2xl w-full max-w-lg mx-4 overflow-hidden shadow-2xl border border-slate-200 animate-fade-up">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-sm font-bold text-slate-900">Catat Barang Keluar (Outbound)</h3>
            <button onclick="closeModal('addOutboundModal')" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        <form id="addOutboundForm" onsubmit="handleOutboundSubmit(event)" class="p-6 space-y-4">
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
    function openDetail(id) {
        openModal('detailOutboundModal');
    }
    function toast(msg, type = 'success') {
        let t = document.getElementById('toast');
        if (!t) {
            t = document.createElement('div');
            t.id = 'toast';
            t.className = 'fixed bottom-4 right-4 z-[80] rounded-lg bg-slate-900 px-4 py-3 text-[12px] text-white shadow-lg transition-all duration-300';
            document.body.appendChild(t);
        }
        t.textContent = msg;
        t.classList.remove('hidden');
        setTimeout(() => t.classList.add('hidden'), 2500);
    }
    function handleOutboundSubmit(e) {
        e.preventDefault();
        const form = document.getElementById('addOutboundForm');
        const doVal = form.querySelector('input[placeholder*="DO-2025"]').value || 'DO-2025-' + Math.floor(1000 + Math.random() * 9000);
        const reqVal = form.querySelectorAll('input')[1].value || 'REQ-2025-' + Math.floor(1000 + Math.random() * 9000);
        const deptVal = form.querySelector('select').selectedOptions[0]?.text || 'Departemen Operasional';
        const qtyVal = form.querySelector('input[type="number"]').value || '1';
        
        const tbody = document.querySelector('table tbody');
        if (tbody) {
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-slate-50/60 transition-colors outbound-row';
            tr.setAttribute('data-status', 'menunggu');
            tr.innerHTML = `
                <td class="py-3.5 px-4 font-bold text-slate-900">
                    ${doVal}
                    <div class="text-[10px] text-slate-400 font-normal">${reqVal}</div>
                </td>
                <td class="py-3.5 px-4 text-slate-600">Baru saja <span class="block text-[10px] text-slate-400">Hari ini</span></td>
                <td class="py-3.5 px-4 font-semibold text-slate-800">${deptVal}<br>PIC: Super Admin</td>
                <td class="py-3.5 px-4">Barang Keluar Baru<br>SKU-OUT-NEW</td>
                <td class="py-3.5 px-4 text-center">${qtyVal} Unit</td>
                <td class="py-3.5 px-4">Kurir Internal DC<br>Armada Pick-Up</td>
                <td class="py-3.5 px-4"><span class="px-2 py-1 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-700">Menunggu Approval</span></td>
                <td class="py-3.5 px-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <button onclick="openDetail('${doVal}')" class="p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 rounded-lg transition-colors" title="Detail Transaksi">
                            <i class="fas fa-eye text-xs"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.prepend(tr);
        }
        closeModal('addOutboundModal');
        form.reset();
        toast('Catatan pengeluaran barang berhasil disimpan dan ditambahkan ke tabel!', 'success');
    }
    function filterOutbound(status, btn) {
        document.querySelectorAll('.flex.items-center.gap-2.overflow-x-auto button').forEach(b => {
            b.className = 'px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-all';
        });
        btn.className = 'px-3.5 py-1.5 rounded-lg bg-blue-600 text-white text-xs font-semibold shadow-sm transition-all';
        window.currentOutboundStatusFilter = status;
        applyOutboundFilters();
    }

    function searchOutboundTable() {
        applyOutboundFilters();
    }

    function applyOutboundFilters() {
        const query = (document.getElementById('outboundSearchInput')?.value || '').toLowerCase();
        const dept = (document.getElementById('deptFilterSelect')?.value || '').toLowerCase();
        const status = window.currentOutboundStatusFilter || 'semua';

        const rows = document.querySelectorAll('table tbody tr');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            const statusCell = row.querySelectorAll('td')[6];
            const statusText = statusCell ? statusCell.innerText.toLowerCase() : '';

            let matchStatus = true;
            if (status === 'menunggu') {
                matchStatus = statusText.includes('menunggu');
            } else if (status === 'picking') {
                matchStatus = statusText.includes('packing') || statusText.includes('picking') || statusText.includes('tahan');
            } else if (status === 'selesai') {
                matchStatus = statusText.includes('selesai');
            }

            const matchQuery = !query || text.includes(query);
            const matchDept = !dept || text.includes(dept);

            if (matchStatus && matchQuery && matchDept) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
</body>
</html>