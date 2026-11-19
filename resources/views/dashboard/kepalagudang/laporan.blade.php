<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan &amp; Analitik - Astro Inventory</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Chart.js (grafik analitik) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* ============================================================
           Astro Inventory Design System (konsisten dgn dashboard lain)
           ============================================================ */
        :root {
            --brand: #2563eb;
            --brand-dark: #1d4ed8;
            --bg: #f5f7fb;
            --line: #e7ebf2;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif;
            background: var(--bg);
            color: #172033;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 9px; height: 9px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cdd6e4; border-radius: 99px; border: 2px solid #f5f7fb; }
        ::-webkit-scrollbar-thumb:hover { background: #aab8cf; }

        /* Nav links (komponen sidebar) */
        .nav-link { transition: all 0.16s ease; }
        .nav-link:hover { background: #f1f5f9; color: #172033; transform: translateX(3px); }
        .nav-link.active { background: var(--brand); color: #fff; font-weight: 600; box-shadow: 0 6px 14px -6px rgba(37, 99, 235, 0.55); }
        .nav-link.active:hover { transform: none; background: var(--brand); }

        /* Cards */
        .metric-card { transition: transform .25s cubic-bezier(.22, 1, .36, 1), box-shadow .25s; }
        .metric-card:hover { transform: translateY(-3px); box-shadow: 0 12px 28px -12px rgba(37, 99, 235, .22), 0 4px 10px rgba(15, 23, 42, .06); }
        .panel { background: #fff; border: 1px solid #e5eeff; border-radius: .5rem; box-shadow: 0 1px 2px rgba(16, 24, 40, .04); }

        /* Tables */
        .table-row { transition: background-color .15s ease; }
        .table-row:hover { background-color: #f9fafb; }

        /* Filter chips */
        .filter-tag { transition: background-color .15s ease; }
        .filter-tag:hover { background-color: #dbeafe; }

        /* Progress */
        .progress-bar { transition: width .5s ease; }

        /* Tabs */
        .tab-btn { transition: all .15s ease; }
        .tab-btn.active { background: #2563eb; color: #fff; }

        /* Badges */
        .badge { display: inline-flex; align-items: center; gap: .25rem; padding: .125rem .625rem; border-radius: 9999px; font-size: .75rem; font-weight: 600; }

        /* Toast */
        #toast-container { position: fixed; right: 1rem; bottom: 1rem; z-index: 100; display: flex; flex-direction: column; gap: .5rem; }
        .toast { background: #fff; border: 1px solid #e5eeff; border-left: 4px solid #2563eb; border-radius: .5rem; padding: .75rem 1rem; box-shadow: 0 8px 20px -6px rgba(0, 0, 0, .2); font-size: .875rem; color: #0b1c30; animation: toastIn .2s ease; max-width: 340px; }
        .toast.success { border-left-color: #16a34a; }
        .toast.warn { border-left-color: #f59e0b; }
        .toast.error { border-left-color: #dc2626; }
        @keyframes toastIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: none; } }

        /* Animations */
        .anim-fade-up { animation: fadeUp .35s ease both; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: none; } }
        .anim-fade-in { animation: fadeIn .5s ease-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .no-scrollbar::-webkit-scrollbar { display: none; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; }
        }
    </style>
</head>
<body class="bg-gray-50">

@include('components.navbar')

<div class="flex min-h-screen">
    @include('components.sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-4 lg:p-6 overflow-x-hidden">

        {{-- ================= KEPALA GUDANG ================= --}}
        @if(auth()->user()->isKepalaGudang())

        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-4 overflow-x-auto whitespace-nowrap anim-fade-in">
            <span>Manajemen Sistem</span><i class="fas fa-chevron-right text-xs"></i>
            <span>Operasional &amp; Transaksi</span><i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-900 font-medium">Laporan &amp; Analitik</span>
        </div>

        <!-- Page header -->
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-6 anim-fade-up">
            <div class="flex-1">
                <h1 class="text-xl lg:text-2xl font-bold text-gray-900 mb-2">Laporan &amp; Analitik Inventaris (Operations Intelligence)</h1>
                <p class="text-sm lg:text-base text-gray-600">Analisis perputaran persediaan (inventory turnover), pergerakan arus barang inbound/outbound, akurasi stok opname, serta efisiensi kapasitas rak Hub Cakung DC-01.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <span class="badge bg-indigo-100 text-indigo-700"><i class="fas fa-calendar-alt"></i>30 Hari Terakhir (1 Feb – 2 Mar 2025)</span>
                <button onclick="toast('Menyiapkan ekspor Laporan Analitik (XLSX)...','success')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2 text-sm"><i class="fas fa-file-export"></i><span>Export Laporan</span></button>
            </div>
        </div>

        <!-- Stat cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6 anim-fade-up">
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-recycle text-blue-600"></i></div>
                    <span class="badge bg-green-100 text-green-700"><i class="fas fa-arrow-up"></i>Target</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">6,8X</h3>
                <p class="text-sm text-gray-600 mb-2">Inventory Turnover Ratio (ITR)</p>
                <p class="text-xs text-gray-500">Target SLA 6X /Thn (406×424)</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center"><i class="fas fa-coins text-green-600"></i></div>
                    <span class="badge bg-green-100 text-green-700"><i class="fas fa-check"></i>FiFo</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Rp 4,82 <span class="text-sm font-normal text-gray-500">M</span></h3>
                <p class="text-sm text-gray-600 mb-2">Total Valuasi Stok Aktif</p>
                <p class="text-xs text-gray-500">32.450 Fisik + 1.240 SKU</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center"><i class="fas fa-truck text-indigo-600"></i></div>
                    <span class="badge bg-indigo-100 text-indigo-700">Net Outflow</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">14.280</h3>
                <p class="text-sm text-gray-600 mb-2">Throughput Outbound/Bin</p>
                <p class="text-xs text-gray-500">In: 12.410 + Out: 1.870</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center"><i class="fas fa-clipboard-check text-amber-600"></i></div>
                    <span class="badge bg-green-100 text-green-700">Hasil Siklus</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">99,2%</h3>
                <p class="text-sm text-gray-600 mb-2">Akurasi Stok Opname (IRA)</p>
                <p class="text-xs text-gray-500">Salisin &lt; 0,8% · Feb 2025</p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="panel p-2 mb-6 anim-fade-up">
            <div id="tabLaporan" class="flex flex-wrap gap-1">
                <button class="tab-btn active px-3 py-2 rounded-lg text-sm font-medium" data-tab="overview"><i class="fas fa-th-large mr-1"></i>Semua Laporan (Overview)</button>
                <button class="tab-btn px-3 py-2 rounded-lg text-sm font-medium border border-gray-200 hover:bg-gray-50" data-tab="aging"><i class="fas fa-clock mr-1"></i>Perputaran &amp; Aging Stok</button>
                <button class="tab-btn px-3 py-2 rounded-lg text-sm font-medium border border-gray-200 hover:bg-gray-50" data-tab="throughput"><i class="fas fa-truck mr-1"></i>Throughput Inbound/Outbound</button>
                <button class="tab-btn px-3 py-2 rounded-lg text-sm font-medium border border-gray-200 hover:bg-gray-50" data-tab="abc"><i class="fas fa-medal mr-1"></i>Klasifikasi ABC &amp; Fast Moving</button>
                <button class="tab-btn px-3 py-2 rounded-lg text-sm font-medium border border-gray-200 hover:bg-gray-50" data-tab="kapasitas"><i class="fas fa-warehouse mr-1"></i>Kapasitas Rak Gudang</button>
            </div>
        </div>

        <!-- Filter bar -->
        <div class="panel p-4 mb-6 anim-fade-up">
            <div class="flex flex-col lg:flex-row lg:items-center gap-3">
                <select id="fKategori" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option value="">Kategori: Semua Kategori</option>
                    <option value="elektronik it">Elektronik &amp; IT Hardware</option>
                    <option value="alat kerja">Alat Kerja &amp; Mesin</option>
                    <option value="packaging">Packaging &amp; Material</option>
                    <option value="k3">Perlengkapan K3 &amp; Uniform</option>
                    <option value="atk">ATK &amp; Inventaris Kantor</option>
                </select>
                <select id="fLokasi" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option value="">Lokasi: Semua</option>
                    <option value="cakung" selected>Hub Cakung DC-01 (Utama)</option>
                    <option value="halim">Hub Halim DC-02</option>
                </select>
                <select id="fDead" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option value="">Urgensi Dead Stock: Semua</option>
                    <option value="90">&gt; 90 Hari</option>
                    <option value="180">&gt; 180 Hari</option>
                </select>
                <div class="relative flex-1 min-w-[200px]">
                    <input id="searchSku" type="text" placeholder="Cari SKU, Nama Barang, Batch." class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                </div>
            </div>
        </div>

        <!-- ====== TAB PANEL: overview (charts) ====== -->
        <div data-tab-panel="overview">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
                <!-- Bar chart -->
                <div class="panel p-4 lg:p-6 lg:col-span-2">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-chart-bar text-blue-600"></i>
                        <h3 class="font-bold text-gray-900 text-sm lg:text-base">Tren Arus Barang Bulanan (Inbound vs Outbound)</h3>
                        <span class="badge bg-blue-100 text-blue-700 ml-auto">8 Minggu</span>
                    </div>
                    <p class="text-xs text-gray-600 mb-4">Perbandingan volume unit barang masuk dan keluar per minggu dalam 8 minggu terakhir.</p>
                    <div style="height:300px"><canvas id="chartTren"></canvas></div>
                    <div class="grid grid-cols-3 gap-2 mt-4 text-center">
                        <div class="p-2 bg-blue-50 rounded-lg"><p class="text-xs text-gray-500">Rata-rata Inbound</p><p class="text-sm font-bold text-blue-700">3.102 Qty / Minggu</p></div>
                        <div class="p-2 bg-indigo-50 rounded-lg"><p class="text-xs text-gray-500">Rata-rata Outbound</p><p class="text-sm font-bold text-indigo-700">3.570 Qty / Minggu</p></div>
                        <div class="p-2 bg-amber-50 rounded-lg"><p class="text-xs text-gray-500">Peak Dispatch Day</p><p class="text-sm font-bold text-amber-700">Selasa &amp; Kamis</p></div>
                    </div>
                </div>
                <!-- Doughnut chart -->
                <div class="panel p-4 lg:p-6">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-chart-pie text-indigo-600"></i>
                        <h3 class="font-bold text-gray-900 text-sm lg:text-base">Komposisi Valuasi Stok</h3>
                    </div>
                    <p class="text-xs text-gray-600 mb-4">Distribusi nilai aset persediaan yang tersimpan di seluruh zona rak Hub.</p>
                    <div style="height:240px"><canvas id="chartValuasi"></canvas></div>
                    <div class="mt-4 space-y-1.5 text-xs">
                        <div class="flex items-center gap-2"><span class="w-3 h-3 rounded" style="background:#2563eb"></span><span class="flex-1 text-gray-700">Elektronik &amp; IT Hardware</span><span class="font-semibold text-gray-900">Rp 2,02M</span><span class="text-gray-400">42%</span></div>
                        <div class="flex items-center gap-2"><span class="w-3 h-3 rounded" style="background:#6366f1"></span><span class="flex-1 text-gray-700">Alat Kerja &amp; Mesin</span><span class="font-semibold text-gray-900">Rp 1,20M</span><span class="text-gray-400">25%</span></div>
                        <div class="flex items-center gap-2"><span class="w-3 h-3 rounded" style="background:#f59e0b"></span><span class="flex-1 text-gray-700">Packaging &amp; Material</span><span class="font-semibold text-gray-900">Rp 867 Juta</span><span class="text-gray-400">18%</span></div>
                        <div class="flex items-center gap-2"><span class="w-3 h-3 rounded" style="background:#16a34a"></span><span class="flex-1 text-gray-700">Perlengkapan K3 &amp; Uniform</span><span class="font-semibold text-gray-900">Rp 482 Juta</span><span class="text-gray-400">10%</span></div>
                        <div class="flex items-center gap-2"><span class="w-3 h-3 rounded" style="background:#dc2626"></span><span class="flex-1 text-gray-700">ATK &amp; Inventaris Kantor</span><span class="font-semibold text-gray-900">Rp 241 Juta</span><span class="text-gray-400">5%</span></div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-xs font-semibold text-gray-700">TOTAL EVALUATED POOL</span>
                        <span class="badge bg-green-100 text-green-700"><i class="fas fa-check"></i>100% Sesuai SAP ERP</span>
                    </div>
                </div>
            </div>

            <!-- ABC analysis table -->
            <div class="panel p-4 lg:p-6 mb-6">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-medal text-blue-600"></i>
                    <h3 class="font-bold text-gray-900 text-sm lg:text-base">Analisis Performa SKU &amp; Klasifikasi ABC (Top Movers &amp; Aging)</h3>
                </div>
                <p class="text-xs text-gray-600 mb-4">Peringkat kecepatan persediaan, Days on Hand (DOH), serta rekomendasi pengadaan stok otomatis.</p>
                <div class="overflow-x-auto -mx-4 lg:mx-0">
                    <table id="tblAbc" class="w-full min-w-[980px]">
                        <thead>
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase whitespace-nowrap">Kode SKU &amp; Nama Barang</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase whitespace-nowrap">Kategori</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase whitespace-nowrap">Stok On-Hand</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase whitespace-nowrap">Avg Keluar/Bln</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase whitespace-nowrap">DOH</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase whitespace-nowrap">Klasifikasi ABC</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase whitespace-nowrap">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase whitespace-nowrap">Rekomendasi Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-row border-b border-gray-100" data-kategori="elektronik it">
                                <td class="px-4 py-4 align-top">
                                    <p class="font-semibold text-gray-900 text-sm">MacBook Pro 14" M1 Pro</p>
                                    <p class="text-xs text-gray-400 mt-1">SKU-LAP-0821 · Rak E-04</p>
                                </td>
                                <td class="px-4 py-4 align-top"><span class="badge bg-purple-100 text-purple-700"><i class="fas fa-laptop"></i>Elektronik &amp; IT</span></td>
                                <td class="px-4 py-4 align-top whitespace-nowrap"><p class="text-sm font-bold text-gray-900">48 Unit</p></td>
                                <td class="px-4 py-4 align-top whitespace-nowrap"><p class="text-sm text-gray-700">35 Unit/bln</p></td>
                                <td class="px-4 py-4 align-top whitespace-nowrap"><p class="text-sm text-gray-700">41 Hari</p></td>
                                <td class="px-4 py-4 align-top"><span class="badge bg-green-100 text-green-700"><i class="fas fa-medal"></i>Kelas A (High Value)</span></td>
                                <td class="px-4 py-4 align-top"><span class="badge bg-green-100 text-green-700"><i class="fas fa-check-circle"></i>ROP Terjaga (Aman)</span></td>
                                <td class="px-4 py-4 align-top"><button onclick="toast('Buka detail auto-reorder SKU-LAP-0821...','success')" class="text-blue-600 hover:bg-blue-50 px-2 py-1 rounded text-xs"><i class="fas fa-sync"></i> Auto-Reorder</button></td>
                            </tr>
                            <tr class="table-row border-b border-gray-100" data-kategori="alat kerja">
                                <td class="px-4 py-4 align-top">
                                    <p class="font-semibold text-gray-900 text-sm">Zebra TC21 Barcode Scanner</p>
                                    <p class="text-xs text-gray-400 mt-1">SKU-SCN-0055 · Batch B24</p>
                                </td>
                                <td class="px-4 py-4 align-top"><span class="badge bg-blue-100 text-blue-700"><i class="fas fa-barcode"></i>Alat Kerja &amp; Hardware</span></td>
                                <td class="px-4 py-4 align-top whitespace-nowrap"><p class="text-sm font-bold text-gray-900">85 Unit</p></td>
                                <td class="px-4 py-4 align-top whitespace-nowrap"><p class="text-sm text-gray-700">62 Unit/bln</p></td>
                                <td class="px-4 py-4 align-top whitespace-nowrap"><p class="text-sm text-gray-700">38 Hari</p></td>
                                <td class="px-4 py-4 align-top"><span class="badge bg-green-100 text-green-700"><i class="fas fa-medal"></i>Kelas A (High Value)</span></td>
                                <td class="px-4 py-4 align-top"><span class="badge bg-amber-100 text-amber-700"><i class="fas fa-arrow-trend-up"></i>Permintaan Naik +18%</span></td>
                                <td class="px-4 py-4 align-top"><button onclick="toast('Buka detail auto-reorder SKU-SCN-0055...','success')" class="text-blue-600 hover:bg-blue-50 px-2 py-1 rounded text-xs"><i class="fas fa-sync"></i> Auto-Reorder</button></td>
                            </tr>
                            <tr class="table-row border-b border-gray-100" data-kategori="packaging">
                                <td class="px-4 py-4 align-top">
                                    <p class="font-semibold text-gray-900 text-sm">Bubble Wrap Roll 50m Heavy</p>
                                    <p class="text-xs text-gray-400 mt-1">SKU-PKG-0712</p>
                                </td>
                                <td class="px-4 py-4 align-top"><span class="badge bg-orange-100 text-orange-700"><i class="fas fa-box"></i>Packaging</span></td>
                                <td class="px-4 py-4 align-top whitespace-nowrap"><p class="text-sm font-bold text-gray-900">320 Roll</p></td>
                                <td class="px-4 py-4 align-top whitespace-nowrap"><p class="text-sm text-gray-700">410 Roll/bln</p></td>
                                <td class="px-4 py-4 align-top whitespace-nowrap"><p class="text-sm text-gray-700">23 Hari</p></td>
                                <td class="px-4 py-4 align-top"><span class="badge bg-blue-100 text-blue-700"><i class="fas fa-bolt"></i>Kelas B (High Velocity)</span></td>
                                <td class="px-4 py-4 align-top"><span class="badge bg-red-100 text-red-700"><i class="fas fa-exclamation-triangle"></i>Perlu Restock &lt; 5 Hari</span></td>
                                <td class="px-4 py-4 align-top"><button onclick="toast('Membuat PR otomatis Bubble Wrap...','warn')" class="text-red-600 hover:bg-red-50 px-2 py-1 rounded text-xs border border-red-200"><i class="fas fa-shopping-cart"></i> Buat PR</button></td>
                            </tr>
                            <tr class="table-row border-b border-gray-100" data-kategori="k3">
                                <td class="px-4 py-4 align-top">
                                    <p class="font-semibold text-gray-900 text-sm">Sarung Tangan Antistatik ESD</p>
                                    <p class="text-xs text-gray-400 mt-1">SKU-HSE-4421 · Rack D-02</p>
                                </td>
                                <td class="px-4 py-4 align-top"><span class="badge bg-orange-100 text-orange-700"><i class="fas fa-hard-hat"></i>K3 &amp; Keselamatan</span></td>
                                <td class="px-4 py-4 align-top whitespace-nowrap"><p class="text-sm font-bold text-gray-900">210 Box</p></td>
                                <td class="px-4 py-4 align-top whitespace-nowrap"><p class="text-sm text-gray-700">45 Box/bln</p></td>
                                <td class="px-4 py-4 align-top whitespace-nowrap"><p class="text-sm text-gray-700">140 Hari</p></td>
                                <td class="px-4 py-4 align-top"><span class="badge bg-gray-100 text-gray-700"><i class="fas fa-medal"></i>Kelas C (Slow Moving)</span></td>
                                <td class="px-4 py-4 align-top"><span class="badge bg-amber-100 text-amber-700"><i class="fas fa-pause"></i>Review Pembelian / Slow</span></td>
                                <td class="px-4 py-4 align-top"><button onclick="toast('Buka review pembelian SKU-HSE-4421...','success')" class="text-blue-600 hover:bg-blue-50 px-2 py-1 rounded text-xs"><i class="fas fa-search"></i> Review</button></td>
                            </tr>
                            <tr class="table-row" data-kategori="elektronik it">
                                <td class="px-4 py-4 align-top">
                                    <p class="font-semibold text-gray-900 text-sm">Server Rack Mount Shelf 2U</p>
                                    <p class="text-xs text-gray-400 mt-1">SKU-SRV-8802 · Zona Gudang Cadangan</p>
                                </td>
                                <td class="px-4 py-4 align-top"><span class="badge bg-purple-100 text-purple-700"><i class="fas fa-server"></i>Infrastruktur DC</span></td>
                                <td class="px-4 py-4 align-top whitespace-nowrap"><p class="text-sm font-bold text-gray-900">12 Unit</p></td>
                                <td class="px-4 py-4 align-top whitespace-nowrap"><p class="text-sm text-gray-700">1 Unit/bln</p></td>
                                <td class="px-4 py-4 align-top whitespace-nowrap"><p class="text-sm text-gray-700">360 Hari</p></td>
                                <td class="px-4 py-4 align-top"><span class="badge bg-red-100 text-red-700"><i class="fas fa-skull"></i>Dead Stock (180 Hari)</span></td>
                                <td class="px-4 py-4 align-top"><span class="badge bg-red-100 text-red-700"><i class="fas fa-exclamation-circle"></i>Tanpa Pergerakan</span></td>
                                <td class="px-4 py-4 align-top"><button onclick="toast('Buka form relokasi/write-down SKU-SRV-8802...','warn')" class="text-red-600 hover:bg-red-50 px-2 py-1 rounded text-xs border border-red-200"><i class="fas fa-arrows-alt"></i> Relokasi / Write-down</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-4 pt-4 border-t border-gray-100">
                    <span class="text-sm text-gray-500">Menampilkan <span id="abcCount">5</span> dari 1.240 SKU Teranalisis</span>
                    <div id="abcPager" class="flex items-center gap-1">
                        <span class="text-xs text-gray-400 mr-2">Halaman 1 dari 248</span>
                        <button class="px-3 py-1 rounded text-sm bg-blue-600 text-white">1</button>
                        <button onclick="toast('Memuat halaman 2...','success')" class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">2</button>
                        <button onclick="toast('Memuat halaman 3...','success')" class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">3</button>
                        <span class="text-gray-400 px-1">...</span>
                        <button onclick="toast('Memuat halaman 248...','success')" class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">248</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ====== TAB PANEL: aging ====== -->
        <div data-tab-panel="aging" style="display:none">
            <div class="panel p-4 lg:p-6 mb-6">
                <h3 class="font-bold text-gray-900 text-sm lg:text-base mb-3"><i class="fas fa-clock text-blue-600 mr-2"></i>Analisis Aging Stok per Zona Rak</h3>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                    <div class="p-3 border border-gray-200 rounded-lg"><p class="text-xs text-gray-500">Zona A &amp; High-Security</p><p class="text-lg font-bold text-gray-900">482 SKU</p><p class="text-xs text-green-600">Avg DOH 41 Hari</p></div>
                    <div class="p-3 border border-gray-200 rounded-lg"><p class="text-xs text-gray-500">Zona B &amp; Mezzanine</p><p class="text-lg font-bold text-gray-900">310 SKU</p><p class="text-xs text-green-600">Avg DOH 38 Hari</p></div>
                    <div class="p-3 border border-gray-200 rounded-lg"><p class="text-xs text-gray-500">Zona Pallet C-01</p><p class="text-lg font-bold text-gray-900">194 SKU</p><p class="text-xs text-amber-600">Avg DOH 140 Hari</p></div>
                    <div class="p-3 border border-gray-200 rounded-lg"><p class="text-xs text-gray-500">Racking D-02</p><p class="text-lg font-bold text-gray-900">142 SKU</p><p class="text-xs text-red-600">Avg DOH 360 Hari</p></div>
                </div>
            </div>
        </div>

        <!-- ====== TAB PANEL: throughput ====== -->
        <div data-tab-panel="throughput" style="display:none">
            <div class="panel p-4 lg:p-6 mb-6">
                <h3 class="font-bold text-gray-900 text-sm lg:text-base mb-3"><i class="fas fa-truck text-indigo-600 mr-2"></i>Throughput Inbound vs Outbound Harian</h3>
                <div style="height:280px"><canvas id="chartThroughput"></canvas></div>
            </div>
        </div>

        <!-- ====== TAB PANEL: abc ====== -->
        <div data-tab-panel="abc" style="display:none">
            <div class="panel p-4 lg:p-6">
                <p class="text-sm text-gray-600">Tabel klasifikasi ABC tersedia pada panel Overview di atas. Gunakan filter kategori untuk menyaring kelas A/B/C.</p>
            </div>
        </div>

        <!-- ====== TAB PANEL: kapasitas ====== -->
        <div data-tab-panel="kapasitas" style="display:none">
            <div class="panel p-4 lg:p-6">
                <h3 class="font-bold text-gray-900 text-sm lg:text-base mb-3"><i class="fas fa-warehouse text-blue-600 mr-2"></i>Utilisasi Kapasitas Rak per Zona</h3>
                <div class="space-y-3">
                    <div><div class="flex justify-between text-sm mb-1"><span class="text-gray-700">Zona A (Elektronik &amp; Laptop)</span><span class="font-semibold text-gray-900">85%</span></div><div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-amber-500 h-2 rounded-full progress-bar" style="width:85%"></div></div></div>
                    <div><div class="flex justify-between text-sm mb-1"><span class="text-gray-700">Zona B (Audio &amp; Periferal)</span><span class="font-semibold text-gray-900">100%</span></div><div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-red-500 h-2 rounded-full progress-bar" style="width:100%"></div></div></div>
                    <div><div class="flex justify-between text-sm mb-1"><span class="text-gray-700">Zona C (Storage &amp; SSD)</span><span class="font-semibold text-gray-900">40%</span></div><div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-green-500 h-2 rounded-full progress-bar" style="width:40%"></div></div></div>
                    <div><div class="flex justify-between text-sm mb-1"><span class="text-gray-700">Zona D (Kabel &amp; Aksesoris)</span><span class="font-semibold text-gray-900">72%</span></div><div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-blue-500 h-2 rounded-full progress-bar" style="width:72%"></div></div></div>
                </div>
            </div>
        </div>

        <!-- 3 bottom cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6 anim-fade-up">
            <div class="panel p-4 lg:p-5">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-9 h-9 bg-red-100 rounded-lg flex items-center justify-center"><i class="fas fa-exclamation-triangle text-red-600"></i></div>
                    <h3 class="font-bold text-gray-900 text-sm">Peringatan Dead Stock &amp; Aging</h3>
                </div>
                <p class="text-xs text-gray-600 mb-3">Terdapat 8 SKU dengan usia simpan &gt; 180 hari senilai Rp 84,5 Juta tanpa pergerakan mutasi dalam 60 hari terakhir.</p>
                <button onclick="toast('Memuat daftar 8 SKU Dead Stock...','warn')" class="text-blue-600 text-xs font-medium hover:underline">Lihat Daftar SKU Dead Stock <i class="fas fa-arrow-right ml-1"></i></button>
            </div>
            <div class="panel p-4 lg:p-5">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-magic-wand-sparkles text-blue-600"></i></div>
                    <h3 class="font-bold text-gray-900 text-sm">Optimasi ROP &amp; Safety Stock</h3>
                </div>
                <p class="text-xs text-gray-600 mb-3">Algoritma prediktif mendeteksi lonjakan outbound pada 3 SKU kemasan untuk periode menjelang awal bulan operasional Hub.</p>
                <button onclick="toast('Membuka jadwal pembelian ullang...','success')" class="text-blue-600 text-xs font-medium hover:underline">Buka Jadwal Pembelian Ulang <i class="fas fa-arrow-right ml-1"></i></button>
            </div>
            <div class="panel p-4 lg:p-5">
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center"><i class="fas fa-file-invoice-dollar text-green-600"></i></div>
                    <h3 class="font-bold text-gray-900 text-sm">Integrasi Audit &amp; Finansial</h3>
                </div>
                <p class="text-xs text-gray-600 mb-3">Laporan analitik telah diselaraskan dengan standar akuntansi persediaan FIFO &amp; Moving Average untuk laporan audit Q1 2025.</p>
                <button onclick="toast('Menyiapkan Rekap Laporan Keuangan (XLSX)...','success')" class="text-blue-600 text-xs font-medium hover:underline">Unduh Rekap Laporan Keuangan (XLSX) <i class="fas fa-arrow-right ml-1"></i></button>
            </div>
        </div>

        @endif

    </main>
</div>

<script>
/* ============================================================
   ASTRO Inventory — Shared interaction layer (toast, tabs, table filter)
   Vanilla JS, no deps. Tailwind handles layout/visuals.
   ============================================================ */
(function () {
    'use strict';

    /* ---------- Toast ---------- */
    function toast(msg, type) {
        var c = document.getElementById('toast-container');
        if (!c) { c = document.createElement('div'); c.id = 'toast-container'; document.body.appendChild(c); }
        var t = document.createElement('div');
        t.className = 'toast ' + (type || '');
        t.textContent = msg;
        c.appendChild(t);
        setTimeout(function () { t.style.opacity = '0'; t.style.transition = 'opacity .3s'; setTimeout(function () { t.remove(); }, 300); }, 3200);
    }
    window.toast = toast;

    /* ---------- Tabs ---------- */
    window.initTabs = function (container) {
        var root = typeof container === 'string' ? document.getElementById(container) : container;
        if (!root) return;
        var btns = root.querySelectorAll('[data-tab]');
        var panels = document.querySelectorAll('[data-tab-panel]');
        btns.forEach(function (b) {
            b.addEventListener('click', function () {
                var name = b.getAttribute('data-tab');
                btns.forEach(function (x) { x.classList.remove('active'); });
                b.classList.add('active');
                panels.forEach(function (p) {
                    p.style.display = (p.getAttribute('data-tab-panel') === name) ? '' : 'none';
                });
            });
        });
    };

    /* ---------- Table filtering / search ---------- */
    /* Baris tabel membawa data-attribute; select/search memfilter baris. */
    window.initTableFilter = function (opts) {
        var table = document.getElementById(opts.tableId);
        if (!table) return;
        var tbody = table.querySelector('tbody');
        var rows = Array.prototype.slice.call(tbody.querySelectorAll('tr'));
        var search = opts.searchId ? document.getElementById(opts.searchId) : null;
        var selects = (opts.selects || []).map(function (s) {
            return { el: document.getElementById(s.id), attr: s.attr };
        });

        function visible(r) {
            if (search) {
                var q = (search.value || '').toLowerCase().trim();
                if (q && r.textContent.toLowerCase().indexOf(q) === -1) return false;
            }
            for (var i = 0; i < selects.length; i++) {
                var v = selects[i].el ? selects[i].el.value : '';
                if (v && (r.getAttribute('data-' + selects[i].attr) || '').toLowerCase() !== String(v).toLowerCase()) return false;
            }
            return true;
        }
        function apply() {
            var count = 0;
            rows.forEach(function (r) {
                var ok = visible(r);
                r.style.display = ok ? '' : 'none';
                if (ok) count++;
            });
            var info = document.getElementById(opts.countId);
            if (info) info.textContent = count;
        }
        if (search) search.addEventListener('input', apply);
        selects.forEach(function (s) { if (s.el) s.el.addEventListener('change', apply); });
        var reset = opts.resetId ? document.getElementById(opts.resetId) : null;
        if (reset) reset.addEventListener('click', function () {
            if (search) search.value = '';
            selects.forEach(function (s) { if (s.el) s.el.value = ''; });
            apply();
        });
        apply();
        return { reapply: apply };
    };
})();
</script>

<script>
/* ============================================================
   Kepala Gudang — Laporan & Analitik: tabs, chart, filter tabel
   ============================================================ */
document.addEventListener('DOMContentLoaded', function () {
    initTabs('tabLaporan');

    /* Bar chart: Tren Arus Barang 8 minggu */
    var ctxTren = document.getElementById('chartTren');
    if (ctxTren) new Chart(ctxTren.getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['M1', 'M2', 'M3', 'M4', 'M5', 'M6', 'M7', 'M-8 (Kini)'],
            datasets: [
                { label: 'Inbound', data: [2850, 3120, 2950, 3400, 3020, 3180, 3260, 3080], backgroundColor: '#2563eb', borderRadius: 4 },
                { label: 'Outbound', data: [3200, 3450, 3380, 3720, 3580, 3690, 3640, 3720], backgroundColor: '#6366f1', borderRadius: 4 }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'top', labels: { boxWidth: 12, font: { size: 11 } } } },
            scales: { y: { beginAtZero: true, ticks: { font: { size: 10 } } }, x: { ticks: { font: { size: 11 } } } }
        }
    });

    /* Doughnut: Komposisi Valuasi */
    var ctxVal = document.getElementById('chartValuasi');
    if (ctxVal) new Chart(ctxVal.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Elektronik & IT Hardware', 'Alat Kerja & Mesin', 'Packaging & Material', 'Perlengkapan K3 & Uniform', 'ATK & Inventaris Kantor'],
            datasets: [{ data: [2020, 1200, 867, 482, 241], backgroundColor: ['#2563eb', '#6366f1', '#f59e0b', '#16a34a', '#dc2626'], borderWidth: 2, borderColor: '#fff' }]
        },
        options: {
            responsive: true, maintainAspectRatio: false, cutout: '62%',
            plugins: { legend: { display: false }, tooltip: { callbacks: { label: function (c) { return c.label + ': Rp ' + c.raw + ' Juta'; } } } }
        }
    });

    /* Line chart: Throughput harian (tab throughput) */
    var ctxTh = document.getElementById('chartThroughput');
    if (ctxTh) new Chart(ctxTh.getContext('2d'), {
        type: 'line',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
            datasets: [
                { label: 'Inbound', data: [1820, 2140, 1980, 2310, 2090, 1180], borderColor: '#2563eb', backgroundColor: 'rgba(37,99,235,.1)', fill: true, tension: .35 },
                { label: 'Outbound', data: [2100, 2580, 2240, 2640, 2410, 1320], borderColor: '#6366f1', backgroundColor: 'rgba(99,102,241,.1)', fill: true, tension: .35 }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'top' } }, scales: { y: { beginAtZero: true } } }
    });

    /* Wire filter tabel ABC */
    initTableFilter({
        tableId: 'tblAbc', searchId: 'searchSku', countId: 'abcCount',
        selects: [{ id: 'fKategori', attr: 'kategori' }, { id: 'fLokasi', attr: 'lokasi' }, { id: 'fDead', attr: 'dead' }]
    });
});
</script>

</body>
</html>
