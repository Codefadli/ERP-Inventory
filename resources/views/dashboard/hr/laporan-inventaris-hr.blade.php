<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Inventaris - Astro Inventory</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    colors: {
                        brand: '#2563eb',
                        ink: '#172033',
                        canvas: '#f5f7fb'
                    }
                }
            }
        };
    </script>

    <style>
        :root {
            --brand: #2563eb;
            --brand-dark: #1d4ed8;
            --bg: #f5f7fb;
            --line: #e7ebf2;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: #172033;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        .inventory-page {
            min-height: 100vh;
            width: 100%;
        }

        .inventory-page .metric-card {
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .inventory-page .metric-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px -12px rgba(37, 99, 235, .22),
                0 4px 10px rgba(15, 23, 42, .06);
        }

        .inventory-page .panel {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, .04);
        }

        .inventory-page .btn-primary {
            transition: all .2s ease;
        }

        .inventory-page .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(37, 99, 235, .2);
        }

        .inventory-page .filter-pill {
            transition: all .2s ease;
        }

        .inventory-page .filter-pill.active {
            background: #dbeafe;
            border-color: #2563eb;
            color: #1d4ed8;
        }

        .inventory-page .range-btn {
            border: 0;
            border-radius: 6px;
            padding: 7px 10px;
            font-size: 10px;
            font-weight: 600;
            color: #64748b;
            background: transparent;
            transition: all .2s ease;
        }

        .inventory-page .range-btn:hover {
            color: #2563eb;
            background: #eff6ff;
        }

        .inventory-page .range-btn.active {
            color: #1d4ed8;
            background: #dbeafe;
        }

        .inventory-page .report-row {
            transition: background .2s ease;
        }

        .inventory-page .report-row:hover {
            background: #f8fafc;
        }

        .inventory-page .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border-radius: 20px;
            padding: 5px 9px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .inventory-page .status-good {
            color: #047857;
            background: #d1fae5;
        }

        .inventory-page .status-warning {
            color: #b45309;
            background: #fef3c7;
        }

        .inventory-page .status-danger {
            color: #b91c1c;
            background: #fee2e2;
        }

        .inventory-page .status-dot {
            width: 7px;
            height: 7px;
            display: inline-block;
            border-radius: 50%;
        }

        .inventory-page .chart-container {
            position: relative;
            width: 100%;
            height: 280px;
        }

        .inventory-page .hub-bar {
            height: 8px;
            border-radius: 20px;
            background: #e9eef6;
            overflow: hidden;
        }

        .inventory-page .hub-bar-fill {
            height: 100%;
            border-radius: 20px;
            transition: width .5s ease;
        }

        .inventory-page .hash-text {
            word-break: break-all;
            font-family: 'Courier New', monospace;
        }

        .inventory-page .advanced-filter {
            display: none;
        }

        .inventory-page .advanced-filter.show {
            display: block;
            animation: fadeUp .25s ease;
        }

        .inventory-page .table-container {
            overflow-x: auto;
        }

        .inventory-page table {
            min-width: 1100px;
        }

        .inventory-page .pagination-btn {
            min-width: 30px;
            height: 30px;
            border: 1px solid #e5e7eb;
            border-radius: 7px;
            padding: 0 9px;
            font-size: 11px;
            color: #64748b;
            background: #fff;
        }

        .inventory-page .pagination-btn.active {
            color: #fff;
            background: #2563eb;
            border-color: #2563eb;
        }

        .inventory-page .pagination-btn:disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .inventory-page .fade-up {
            animation: fadeUp .5s ease both;
        }

        .inventory-page .delay-1 {
            animation-delay: .08s;
        }

        .inventory-page .delay-2 {
            animation-delay: .16s;
        }

        .inventory-page .delay-3 {
            animation-delay: .24s;
        }

        .inventory-page .delay-4 {
            animation-delay: .32s;
        }

        #inventoryToastContainer {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 9px;
        }

        .inventory-toast {
            min-width: 250px;
            max-width: 360px;
            padding: 12px 15px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-left: 4px solid #2563eb;
            border-radius: 9px;
            box-shadow: 0 8px 25px rgba(15, 23, 42, .13);
            color: #1e293b;
            font-size: 12px;
            animation: fadeUp .25s ease;
        }

        .inventory-toast.success {
            border-left-color: #16a34a;
        }

        .inventory-toast.warning {
            border-left-color: #f59e0b;
        }

        .inventory-toast.error {
            border-left-color: #dc2626;
        }

        /* =========================================
   CUSTOM SCROLLBAR - ASTRO INVENTORY
========================================= */

        html {
            scroll-behavior: smooth;
        }

        body {
            overflow-x: hidden;
        }

        /* Ukuran scrollbar */
        ::-webkit-scrollbar {
            width: 9px;
            height: 9px;
        }

        /* Background scrollbar */
        ::-webkit-scrollbar-track {
            background: transparent;
        }

        /* Bagian yang digeser */
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 99px;
            border: 2px solid #f5f7fb;
        }

        /* Hover scrollbar */
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Scrollbar tabel */
        .table-container {
            overflow-x: auto;
            max-width: 100%;
        }

        @media (max-width: 768px) {
            .inventory-page .page-heading {
                align-items: flex-start;
            }

            .inventory-page .chart-container {
                height: 230px;
            }
        }

        @media print {
            body {
                background: #fff !important;
            }

            #inventoryToastContainer,
            .no-print,
            aside,
            nav {
                display: none !important;
            }

            .inventory-page {
                display: block !important;
            }

            .inventory-page main {
                padding: 0 !important;
                width: 100% !important;
            }

            .inventory-page .panel,
            .inventory-page .metric-card {
                box-shadow: none !important;
                break-inside: avoid;
            }

            .inventory-page .table-container {
                overflow: visible !important;
            }

            .inventory-page table {
                min-width: 0 !important;
                font-size: 9px !important;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>

<body>

    @include('components.navbar')

    @php
    $user = auth()->user();
    $isHR = $user && $user->isHR();
    $isSuperAdmin = $user && $user->isSuperAdmin();
    $hasReportAccess = $isHR || $isSuperAdmin;

    $reportTitle = $isSuperAdmin
    ? 'Laporan & Analitik Inventaris'
    : 'Laporan & Analitik Inventaris HR';

    $reportDescription = $isSuperAdmin
    ? 'Pantau ringkasan distribusi inventaris, aktivitas mutasi barang, valuasi aset, dan tingkat kepatuhan operasional seluruh hub.'
    : 'Pantau ringkasan distribusi inventaris, aktivitas mutasi barang, valuasi aset, dan tingkat kepatuhan operasional seluruh hub.';

    $reportIdentity = $isSuperAdmin
    ? 'SUPER ADMIN INVENTORY ANALYTICS'
    : 'HR INVENTORY ANALYTICS';

    $accessDescription = 'Halaman Laporan Inventaris hanya dapat diakses oleh pengguna dengan role HR atau Super Admin.';
    @endphp

    <div class="inventory-page flex min-h-screen">

        @include('components.sidebar')

        <main class="flex-1 min-w-0 p-4 lg:p-6 overflow-x-hidden">

            @if($hasReportAccess)

            <!-- BREADCRUMB -->
            <div class="flex flex-wrap items-center gap-2 text-xs text-gray-400 mb-4">
                <a href="{{ url('/') }}" class="hover:text-blue-600">
                    <i class="fas fa-home mr-1"></i>Beranda
                </a>

                <i class="fas fa-chevron-right text-[9px]"></i>
                <span>Manajemen &amp; Laporan</span>

                <i class="fas fa-chevron-right text-[9px]"></i>
                <span class="text-blue-600 font-semibold">Laporan Inventaris</span>
            </div>

            <!-- PAGE HEADER -->
            <div class="page-heading flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6 fade-up">
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h1 class="text-xl md:text-2xl font-extrabold text-gray-900">
                            {{ $reportTitle }}
                        </h1>

                        <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 rounded-full px-2.5 py-1 text-[10px] font-bold">
                            <span class="status-dot bg-green-500"></span>
                            REPORT SYSTEM ACTIVE
                        </span>
                    </div>

                    <p class="text-xs text-gray-500 max-w-2xl leading-relaxed">
                        {{ $reportDescription }}
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2 no-print">
                    <button id="btnAdvancedFilter"
                        type="button"
                        class="bg-white border border-gray-300 text-gray-700 px-3 py-2 rounded-lg text-xs font-semibold hover:bg-gray-50 flex items-center gap-2">
                        <i class="fas fa-sliders"></i>
                        Filter Lanjutan
                    </button>

                    <button id="btnExport"
                        type="button"
                        class="bg-white border border-gray-300 text-gray-700 px-3 py-2 rounded-lg text-xs font-semibold hover:bg-gray-50 flex items-center gap-2">
                        <i class="fas fa-file-csv text-green-600"></i>
                        Unduh Rekap CSV
                    </button>

                    <button id="btnPrint"
                        type="button"
                        class="btn-primary bg-blue-600 text-white px-4 py-2 rounded-lg text-xs font-semibold hover:bg-blue-700 flex items-center gap-2">
                        <i class="fas fa-print"></i>
                        Cetak Laporan
                    </button>
                </div>
            </div>

            <!-- INFORMATION NOTICE -->
            <div class="panel border-l-4 border-l-blue-500 bg-blue-50 p-3.5 mb-6 fade-up">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-chart-line"></i>
                    </div>

                    <div>
                        <h3 class="text-xs font-bold text-blue-800 mb-1">
                            Ringkasan Laporan Inventaris
                        </h3>

                        <p class="text-[11px] text-blue-700 leading-relaxed">
                            Halaman ini menampilkan contoh data analitik inventaris untuk kebutuhan antarmuka.
                            Data statistik, grafik, dan tabel belum terhubung ke database produksi.
                        </p>
                    </div>
                </div>
            </div>

            <!-- FILTER CHIPS -->
            <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-[10px] text-gray-400 font-bold uppercase">
                        Filter aktif:
                    </span>

                    <span id="activeFilterChips" class="flex flex-wrap gap-2">
                        <span class="filter-chip bg-blue-50 text-blue-600 border border-blue-100 rounded-full px-3 py-1 text-[10px] font-semibold">
                            Semua Data
                        </span>
                    </span>
                </div>

                <div class="flex items-center gap-2 text-[10px] text-gray-400">
                    <i class="fas fa-rotate text-green-500"></i>
                    <span>Sinkronisasi tampilan:
                        <strong class="text-gray-600">18 Nov 2026</strong>
                    </span>
                </div>
            </div>

            <!-- ADVANCED FILTER -->
            <div id="advancedFilter" class="advanced-filter panel p-4 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">
                            <i class="fas fa-filter text-blue-600 mr-2"></i>
                            Filter Lanjutan
                        </h3>

                        <p class="text-[10px] text-gray-400 mt-1">
                            Sesuaikan data laporan berdasarkan kategori, hub, dan kepatuhan.
                        </p>
                    </div>

                    <button id="btnCloseFilter" type="button" class="text-gray-400 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="filterCategory" class="block text-[10px] font-bold text-gray-500 mb-2 uppercase">
                            Kategori Inventaris
                        </label>

                        <select id="filterCategory"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-xs bg-white outline-none focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            <option value="Kamera & Optik">Kamera &amp; Optik</option>
                            <option value="Wearable Gadget">Wearable Gadget</option>
                            <option value="Laptop & Komputer">Laptop &amp; Komputer</option>
                            <option value="Aksesoris Komputer">Aksesoris Komputer</option>
                            <option value="Audio & Sound">Audio &amp; Sound</option>
                            <option value="Storage Drive">Storage Drive</option>
                        </select>
                    </div>

                    <div>
                        <label for="filterHub" class="block text-[10px] font-bold text-gray-500 mb-2 uppercase">
                            Lokasi Hub
                        </label>

                        <select id="filterHub"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-xs bg-white outline-none focus:border-blue-500">
                            <option value="">Semua Hub</option>
                            <option value="Cakung DC-01">Cakung DC-01</option>
                            <option value="Rungkut DC-02">Rungkut DC-02</option>
                            <option value="Gedebage DC-03">Gedebage DC-03</option>
                            <option value="Belawan DC-04">Belawan DC-04</option>
                        </select>
                    </div>

                    <div>
                        <label for="filterStatus" class="block text-[10px] font-bold text-gray-500 mb-2 uppercase">
                            Status Kepatuhan
                        </label>

                        <select id="filterStatus"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-xs bg-white outline-none focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="good">Sesuai</option>
                            <option value="warning">Perlu Evaluasi</option>
                            <option value="danger">Tidak Sesuai</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-4 pt-4 border-t border-gray-100">
                    <button id="btnResetFilter" type="button"
                        class="px-4 py-2 rounded-lg border border-gray-200 text-gray-600 text-xs font-semibold hover:bg-gray-50">
                        Reset
                    </button>

                    <button id="btnApplyFilter" type="button"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700">
                        <i class="fas fa-check mr-1"></i>
                        Terapkan Filter
                    </button>
                </div>
            </div>

            <!-- SUMMARY METRICS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
                <div class="metric-card panel p-4 fade-up delay-1">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i class="fas fa-boxes-stacked"></i>
                        </div>

                        <span class="text-[10px] font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                            +14,3%
                        </span>
                    </div>

                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">
                        Total Mutasi Selesai
                    </p>

                    <h2 class="text-2xl font-extrabold text-gray-900 mt-1">1.240</h2>

                    <p class="text-[11px] text-gray-500 mt-1">Unit berhasil diproses</p>
                </div>

                <div class="metric-card panel p-4 fade-up delay-2">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <i class="fas fa-wallet"></i>
                        </div>

                        <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full">
                            VALUASI
                        </span>
                    </div>

                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">
                        Valuasi Distribusi
                    </p>

                    <h2 class="text-2xl font-extrabold text-gray-900 mt-1">Rp 4,85 M</h2>

                    <p class="text-[11px] text-gray-500 mt-1">Nilai distribusi contoh</p>
                </div>

                <div class="metric-card panel p-4 fade-up delay-3">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                            <i class="fas fa-shield-halved"></i>
                        </div>

                        <span class="text-[10px] font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                            OPTIMAL
                        </span>
                    </div>

                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">
                        Kepatuhan SLA
                    </p>

                    <h2 class="text-2xl font-extrabold text-gray-900 mt-1">98,4%</h2>

                    <p class="text-[11px] text-gray-500 mt-1">Tingkat kepatuhan proses</p>
                </div>

                <div class="metric-card panel p-4 fade-up delay-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                            <i class="fas fa-triangle-exclamation"></i>
                        </div>

                        <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">
                            PERHATIAN
                        </span>
                    </div>

                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">
                        Stok Kritis Terlaporkan
                    </p>

                    <h2 class="text-2xl font-extrabold text-gray-900 mt-1">02</h2>

                    <p class="text-[11px] text-gray-500 mt-1">Item membutuhkan evaluasi</p>
                </div>
            </div>

            <!-- CHART SECTION -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 mb-6">

                <div class="panel p-4 xl:col-span-2">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Tren Mutasi Inventaris</h3>
                            <p class="text-[11px] text-gray-500 mt-1">
                                Perbandingan barang masuk dan barang keluar
                            </p>
                        </div>

                        <div class="flex items-center gap-1 bg-gray-50 rounded-lg p-1 no-print">
                            <button type="button" class="range-btn active" data-range="7">7 Hari</button>
                            <button type="button" class="range-btn" data-range="30">30 Hari</button>
                            <button type="button" class="range-btn" data-range="month">Bulanan</button>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 mb-3">
                        <div class="flex items-center gap-2 text-[10px] text-gray-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                            Barang Masuk
                        </div>

                        <div class="flex items-center gap-2 text-[10px] text-gray-500">
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-300"></span>
                            Barang Keluar
                        </div>
                    </div>

                    <div class="chart-container">
                        <canvas id="mutationChart"></canvas>
                        <div id="chartFallback" class="hidden h-full items-center justify-center text-xs text-gray-400">
                            Grafik tidak dapat dimuat. Periksa koneksi internet.
                        </div>
                    </div>
                </div>

                <!-- HUB DISTRIBUTION -->
                <div class="panel p-4">
                    <div class="mb-5">
                        <h3 class="text-sm font-bold text-gray-900">Distribusi Berdasarkan Hub</h3>
                        <p class="text-[11px] text-gray-500 mt-1">
                            Persentase kontribusi distribusi inventaris
                        </p>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <p class="text-xs font-bold text-gray-800">Cakung DC-01</p>
                                    <p class="text-[10px] text-gray-400">Jakarta Timur</p>
                                </div>
                                <span class="text-xs font-extrabold text-blue-600">45%</span>
                            </div>
                            <div class="hub-bar">
                                <div class="hub-bar-fill bg-blue-600" style="width:45%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <p class="text-xs font-bold text-gray-800">Rungkut DC-02</p>
                                    <p class="text-[10px] text-gray-400">Surabaya</p>
                                </div>
                                <span class="text-xs font-extrabold text-indigo-600">25%</span>
                            </div>
                            <div class="hub-bar">
                                <div class="hub-bar-fill bg-indigo-500" style="width:25%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <p class="text-xs font-bold text-gray-800">Gedebage DC-03</p>
                                    <p class="text-[10px] text-gray-400">Bandung</p>
                                </div>
                                <span class="text-xs font-extrabold text-cyan-600">18%</span>
                            </div>
                            <div class="hub-bar">
                                <div class="hub-bar-fill bg-cyan-500" style="width:18%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <p class="text-xs font-bold text-gray-800">Belawan DC-04</p>
                                    <p class="text-[10px] text-gray-400">Medan</p>
                                </div>
                                <span class="text-xs font-extrabold text-amber-600">12%</span>
                            </div>
                            <div class="hub-bar">
                                <div class="hub-bar-fill bg-amber-500" style="width:12%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-[10px] text-gray-500">Total distribusi</span>
                        <span class="text-sm font-extrabold text-gray-900">100%</span>
                    </div>
                </div>
            </div>

            <!-- REPORT TABLE HEADER -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3 px-1">
                <div>
                    <h3 class="text-xs font-extrabold text-gray-900 uppercase tracking-wider">
                        Rekapitulasi Laporan Inventaris
                    </h3>

                    <p class="text-[10px] text-gray-400 mt-1" id="resultCount">
                        Menampilkan seluruh laporan inventaris
                    </p>
                </div>

                <div class="flex items-center gap-2 no-print">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-xs"></i>

                        <input type="text" id="searchReport"
                            placeholder="Cari ID, SKU, kategori..."
                            class="w-full sm:w-64 border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-xs outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- REPORT TABLE -->
            <div class="panel overflow-hidden mb-6">
                <div class="table-container overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-gray-200 text-[10px] uppercase tracking-wider text-gray-400">
                                <th class="px-4 py-3 font-bold">ID Laporan</th>
                                <th class="px-4 py-3 font-bold">Lokasi Hub</th>
                                <th class="px-4 py-3 font-bold">Kategori</th>
                                <th class="px-4 py-3 font-bold">SKU</th>
                                <th class="px-4 py-3 font-bold">Volume</th>
                                <th class="px-4 py-3 font-bold">Valuasi</th>
                                <th class="px-4 py-3 font-bold">Kepatuhan</th>
                                <th class="px-4 py-3 font-bold">Status</th>
                                <th class="px-4 py-3 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="reportTableBody" class="divide-y divide-gray-100 text-xs">

                            <!-- DATA 1 -->
                            <tr class="report-row"
                                data-id="REP-2025-Q3-A1"
                                data-hub="Cakung DC-01"
                                data-category="Kamera & Optik"
                                data-sku="SKU-CAM-600D"
                                data-volume="320"
                                data-value="1250000000"
                                data-compliance="99.2"
                                data-status="good">

                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-bold text-blue-600">REP-2025-Q3-A1</p>
                                    <p class="text-[10px] text-gray-400 mt-1">Laporan inventaris</p>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-semibold text-gray-800">Cakung DC-01</p>
                                    <p class="text-[10px] text-gray-400">Jakarta Timur</p>
                                </td>
                                <td class="px-4 py-4">Kamera &amp; Optik</td>
                                <td class="px-4 py-4 font-mono text-[10px]">SKU-CAM-600D</td>
                                <td class="px-4 py-4 font-bold text-gray-800">320 Unit</td>
                                <td class="px-4 py-4 font-semibold text-gray-800">Rp 1,25 M</td>
                                <td class="px-4 py-4"><span class="font-bold text-green-600">99,2%</span></td>
                                <td class="px-4 py-4">
                                    <span class="status-pill status-good">
                                        <i class="fas fa-check-circle"></i> Sesuai
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button type="button" class="detail-btn text-blue-600 hover:text-blue-800 font-semibold"
                                        data-id="REP-2025-Q3-A1"
                                        data-hub="Cakung DC-01"
                                        data-category="Kamera & Optik"
                                        data-sku="SKU-CAM-600D"
                                        data-volume="320 Unit"
                                        data-value="Rp 1,25 M"
                                        data-compliance="99,2%"
                                        data-status="Sesuai">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>

                            <!-- DATA 2 -->
                            <tr class="report-row"
                                data-id="REP-2025-Q3-B4"
                                data-hub="Rungkut DC-02"
                                data-category="Wearable Gadget"
                                data-sku="SKU-WRG-210"
                                data-volume="245"
                                data-value="850000000"
                                data-compliance="97.8"
                                data-status="good">

                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-bold text-blue-600">REP-2025-Q3-B4</p>
                                    <p class="text-[10px] text-gray-400 mt-1">Laporan inventaris</p>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-semibold text-gray-800">Rungkut DC-02</p>
                                    <p class="text-[10px] text-gray-400">Surabaya</p>
                                </td>
                                <td class="px-4 py-4">Wearable Gadget</td>
                                <td class="px-4 py-4 font-mono text-[10px]">SKU-WRG-210</td>
                                <td class="px-4 py-4 font-bold text-gray-800">245 Unit</td>
                                <td class="px-4 py-4 font-semibold text-gray-800">Rp 850 Jt</td>
                                <td class="px-4 py-4"><span class="font-bold text-green-600">97,8%</span></td>
                                <td class="px-4 py-4">
                                    <span class="status-pill status-good">
                                        <i class="fas fa-check-circle"></i> Sesuai
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button type="button" class="detail-btn text-blue-600 hover:text-blue-800 font-semibold"
                                        data-id="REP-2025-Q3-B4"
                                        data-hub="Rungkut DC-02"
                                        data-category="Wearable Gadget"
                                        data-sku="SKU-WRG-210"
                                        data-volume="245 Unit"
                                        data-value="Rp 850 Jt"
                                        data-compliance="97,8%"
                                        data-status="Sesuai">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>

                            <!-- DATA 3 -->
                            <tr class="report-row"
                                data-id="REP-2025-Q3-C2"
                                data-hub="Gedebage DC-03"
                                data-category="Laptop & Komputer"
                                data-sku="SKU-LPT-450"
                                data-volume="180"
                                data-value="1450000000"
                                data-compliance="91.5"
                                data-status="warning">

                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-bold text-blue-600">REP-2025-Q3-C2</p>
                                    <p class="text-[10px] text-gray-400 mt-1">Laporan inventaris</p>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-semibold text-gray-800">Gedebage DC-03</p>
                                    <p class="text-[10px] text-gray-400">Bandung</p>
                                </td>
                                <td class="px-4 py-4">Laptop &amp; Komputer</td>
                                <td class="px-4 py-4 font-mono text-[10px]">SKU-LPT-450</td>
                                <td class="px-4 py-4 font-bold text-gray-800">180 Unit</td>
                                <td class="px-4 py-4 font-semibold text-gray-800">Rp 1,45 M</td>
                                <td class="px-4 py-4"><span class="font-bold text-amber-600">91,5%</span></td>
                                <td class="px-4 py-4">
                                    <span class="status-pill status-warning">
                                        <i class="fas fa-exclamation-circle"></i> Perlu Evaluasi
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button type="button" class="detail-btn text-blue-600 hover:text-blue-800 font-semibold"
                                        data-id="REP-2025-Q3-C2"
                                        data-hub="Gedebage DC-03"
                                        data-category="Laptop & Komputer"
                                        data-sku="SKU-LPT-450"
                                        data-volume="180 Unit"
                                        data-value="Rp 1,45 M"
                                        data-compliance="91,5%"
                                        data-status="Perlu Evaluasi">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>

                            <!-- DATA 4 -->
                            <tr class="report-row"
                                data-id="REP-2025-Q3-D8"
                                data-hub="Belawan DC-04"
                                data-category="Audio & Sound"
                                data-sku="SKU-AUD-880"
                                data-volume="95"
                                data-value="420000000"
                                data-compliance="84.5"
                                data-status="danger">

                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-bold text-blue-600">REP-2025-Q3-D8</p>
                                    <p class="text-[10px] text-gray-400 mt-1">Laporan inventaris</p>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-semibold text-gray-800">Belawan DC-04</p>
                                    <p class="text-[10px] text-gray-400">Medan</p>
                                </td>
                                <td class="px-4 py-4">Audio &amp; Sound</td>
                                <td class="px-4 py-4 font-mono text-[10px]">SKU-AUD-880</td>
                                <td class="px-4 py-4 font-bold text-gray-800">95 Unit</td>
                                <td class="px-4 py-4 font-semibold text-gray-800">Rp 420 Jt</td>
                                <td class="px-4 py-4"><span class="font-bold text-red-600">84,5%</span></td>
                                <td class="px-4 py-4">
                                    <span class="status-pill status-danger">
                                        <i class="fas fa-times-circle"></i> Tidak Sesuai
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button type="button" class="detail-btn text-blue-600 hover:text-blue-800 font-semibold"
                                        data-id="REP-2025-Q3-D8"
                                        data-hub="Belawan DC-04"
                                        data-category="Audio & Sound"
                                        data-sku="SKU-AUD-880"
                                        data-volume="95 Unit"
                                        data-value="Rp 420 Jt"
                                        data-compliance="84,5%"
                                        data-status="Tidak Sesuai">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>

                            <!-- DATA 5 -->
                            <tr class="report-row"
                                data-id="REP-2025-Q3-E5"
                                data-hub="Cakung DC-01"
                                data-category="Storage Drive"
                                data-sku="SKU-SSD-120"
                                data-volume="400"
                                data-value="880000000"
                                data-compliance="98.7"
                                data-status="good">

                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-bold text-blue-600">REP-2025-Q3-E5</p>
                                    <p class="text-[10px] text-gray-400 mt-1">Laporan inventaris</p>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-semibold text-gray-800">Cakung DC-01</p>
                                    <p class="text-[10px] text-gray-400">Jakarta Timur</p>
                                </td>
                                <td class="px-4 py-4">Storage Drive</td>
                                <td class="px-4 py-4 font-mono text-[10px]">SKU-SSD-120</td>
                                <td class="px-4 py-4 font-bold text-gray-800">400 Unit</td>
                                <td class="px-4 py-4 font-semibold text-gray-800">Rp 880 Jt</td>
                                <td class="px-4 py-4"><span class="font-bold text-green-600">98,7%</span></td>
                                <td class="px-4 py-4">
                                    <span class="status-pill status-good">
                                        <i class="fas fa-check-circle"></i> Sesuai
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button type="button" class="detail-btn text-blue-600 hover:text-blue-800 font-semibold"
                                        data-id="REP-2025-Q3-E5"
                                        data-hub="Cakung DC-01"
                                        data-category="Storage Drive"
                                        data-sku="SKU-SSD-120"
                                        data-volume="400 Unit"
                                        data-value="Rp 880 Jt"
                                        data-compliance="98,7%"
                                        data-status="Sesuai">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-4 py-3 bg-gray-50 border-t border-gray-200">
                    <p class="text-[10px] text-gray-500" id="paginationInfo">
                        Menampilkan 1-5 dari 5 laporan
                    </p>

                    <div class="flex items-center gap-1 no-print">
                        <button id="prevPage" type="button" class="pagination-btn" disabled>
                            <i class="fas fa-chevron-left"></i>
                        </button>

                        <div id="paginationNumbers" class="flex items-center gap-1"></div>

                        <button id="nextPage" type="button" class="pagination-btn" disabled>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- INFORMATION CARDS -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
                <div class="panel p-4">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-chart-pie"></i>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold text-gray-900 mb-1">Analitik Distribusi</h4>
                            <p class="text-[11px] text-gray-500 leading-relaxed">
                                Ringkasan distribusi membantu memantau persebaran inventaris
                                dan aktivitas operasional di setiap hub.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="panel p-4">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-shield-halved"></i>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold text-gray-900 mb-1">Kepatuhan Operasional</h4>
                            <p class="text-[11px] text-gray-500 leading-relaxed">
                                Persentase kepatuhan digunakan untuk mengidentifikasi proses
                                yang sudah sesuai dan yang membutuhkan evaluasi.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="panel p-4">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-file-shield"></i>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold text-gray-900 mb-1">Dokumentasi Laporan</h4>
                            <p class="text-[11px] text-gray-500 leading-relaxed">
                                Rekap laporan dapat diekspor sebagai CSV atau dicetak
                                sebagai dokumen untuk kebutuhan dokumentasi internal.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 border-t border-gray-200 pt-4 text-[10px] text-gray-400">
                <p>
                    <i class="fas fa-shield-alt mr-1"></i>
                    Astro Inventory — {{ $reportIdentity }}
                </p>

                <p>Data contoh antarmuka · 18 November 2026</p>
            </div>

            @else

            <!-- ACCESS DENIED -->
            <div class="panel p-10 text-center">
                <div class="w-14 h-14 rounded-full bg-red-50 text-red-500 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lock text-2xl"></i>
                </div>

                <h2 class="text-lg font-bold text-gray-900">
                    Akses Tidak Diizinkan
                </h2>

                <p class="text-sm text-gray-500 mt-2">
                    {{ $accessDescription }}
                </p>

                <a href="{{ url('/') }}"
                    class="inline-flex mt-5 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs font-semibold">
                    Kembali ke Beranda
                </a>
            </div>

            @endif

        </main>
    </div>

    @if($hasReportAccess)

    <!-- DETAIL MODAL -->
    <div id="reportDetailModal"
        class="fixed inset-0 z-[9998] hidden items-center justify-center bg-slate-950/50 p-4">

        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Detail Laporan Inventaris</h3>
                    <p class="text-[10px] text-gray-400 mt-1">Informasi rekapitulasi inventaris</p>
                </div>

                <button id="closeReportModal" type="button"
                    class="w-8 h-8 rounded-lg hover:bg-gray-100 text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-5">
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 mb-4">
                    <p class="text-[9px] uppercase tracking-wider font-bold text-blue-500">ID Laporan</p>
                    <p id="modalReportId" class="text-sm font-extrabold text-blue-700 mt-1"></p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <p class="text-[10px] text-gray-400 mb-1">Lokasi Hub</p>
                        <p id="modalHub" class="font-semibold text-gray-800"></p>
                    </div>

                    <div>
                        <p class="text-[10px] text-gray-400 mb-1">Kategori</p>
                        <p id="modalCategory" class="font-semibold text-gray-800"></p>
                    </div>

                    <div>
                        <p class="text-[10px] text-gray-400 mb-1">Kode SKU</p>
                        <p id="modalSku" class="font-semibold text-gray-800"></p>
                    </div>

                    <div>
                        <p class="text-[10px] text-gray-400 mb-1">Volume</p>
                        <p id="modalVolume" class="font-semibold text-gray-800"></p>
                    </div>

                    <div>
                        <p class="text-[10px] text-gray-400 mb-1">Valuasi</p>
                        <p id="modalValue" class="font-semibold text-gray-800"></p>
                    </div>

                    <div>
                        <p class="text-[10px] text-gray-400 mb-1">Kepatuhan</p>
                        <p id="modalCompliance" class="font-semibold text-gray-800"></p>
                    </div>
                </div>

                <div class="mt-4 bg-gray-50 rounded-lg p-3">
                    <p class="text-[10px] text-gray-400 font-bold mb-1">STATUS LAPORAN</p>
                    <p id="modalStatus" class="text-xs font-bold text-gray-800"></p>
                </div>
            </div>

            <div class="px-5 py-3 border-t border-gray-100 flex justify-end">
                <button id="modalDone" type="button"
                    class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 text-xs font-semibold">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- TOAST -->
    <div id="inventoryToastContainer"></div>

    <!-- JAVASCRIPT -->
    <script>
        (function() {
            'use strict';

            const reportBody = document.getElementById('reportTableBody');

            if (!reportBody) {
                return;
            }

            const allRows = Array.from(reportBody.querySelectorAll('.report-row'));

            const searchInput = document.getElementById('searchReport');
            const categoryFilter = document.getElementById('filterCategory');
            const hubFilter = document.getElementById('filterHub');
            const statusFilter = document.getElementById('filterStatus');
            const advancedFilter = document.getElementById('advancedFilter');

            const perPage = 5;
            let currentPage = 1;
            let filteredRows = [...allRows];
            let mutationChart = null;

            const element = id => document.getElementById(id);

            /* TOAST */
            function showToast(message, type = 'success') {
                const container = element('inventoryToastContainer');

                if (!container) return;

                const toast = document.createElement('div');
                toast.className = 'inventory-toast ' + type;

                const iconClass = type === 'success' ?
                    'fa-circle-check' :
                    type === 'warning' ?
                    'fa-triangle-exclamation' :
                    'fa-circle-xmark';

                const wrapper = document.createElement('div');
                wrapper.className = 'flex items-center gap-2';

                const icon = document.createElement('i');
                icon.className = 'fas ' + iconClass;

                const text = document.createElement('span');
                text.textContent = message;

                wrapper.appendChild(icon);
                wrapper.appendChild(text);
                toast.appendChild(wrapper);
                container.appendChild(toast);

                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transition = 'opacity .25s ease';

                    setTimeout(() => toast.remove(), 250);
                }, 3000);
            }

            /* FILTER */
            function applyFilters() {
                const keyword = searchInput.value.trim().toLowerCase();
                const category = categoryFilter.value;
                const hub = hubFilter.value;
                const status = statusFilter.value;

                filteredRows = allRows.filter(row => {
                    const matchesKeyword = !keyword ||
                        row.textContent.toLowerCase().includes(keyword);

                    const matchesCategory = !category ||
                        row.dataset.category === category;

                    const matchesHub = !hub ||
                        row.dataset.hub === hub;

                    const matchesStatus = !status ||
                        row.dataset.status === status;

                    return matchesKeyword &&
                        matchesCategory &&
                        matchesHub &&
                        matchesStatus;
                });

                currentPage = 1;
                renderTable();
                updateFilterChips();
            }

            /* TABLE & PAGINATION */
            function renderTable() {
                const total = filteredRows.length;
                const totalPages = Math.max(1, Math.ceil(total / perPage));

                if (currentPage > totalPages) {
                    currentPage = totalPages;
                }

                const start = (currentPage - 1) * perPage;
                const end = Math.min(start + perPage, total);

                allRows.forEach(row => {
                    row.style.display = 'none';
                });

                filteredRows.slice(start, end).forEach(row => {
                    row.style.display = '';
                });

                element('resultCount').textContent =
                    `Menampilkan ${total} dari ${allRows.length} laporan contoh`;

                element('paginationInfo').textContent = total === 0 ?
                    'Tidak ada laporan yang ditemukan' :
                    `Menampilkan ${start + 1}-${end} dari ${total} laporan`;

                renderPagination(totalPages);
            }

            function renderPagination(totalPages) {
                const container = element('paginationNumbers');
                container.innerHTML = '';

                for (let i = 1; i <= totalPages; i++) {
                    const button = document.createElement('button');

                    button.type = 'button';
                    button.className = 'pagination-btn' +
                        (i === currentPage ? ' active' : '');

                    button.textContent = i;

                    button.addEventListener('click', function() {
                        currentPage = i;
                        renderTable();
                    });

                    container.appendChild(button);
                }

                element('prevPage').disabled = currentPage <= 1;
                element('nextPage').disabled = currentPage >= totalPages;
            }

            element('prevPage').addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderTable();
                }
            });

            element('nextPage').addEventListener('click', function() {
                const totalPages = Math.max(
                    1,
                    Math.ceil(filteredRows.length / perPage)
                );

                if (currentPage < totalPages) {
                    currentPage++;
                    renderTable();
                }
            });

            /* FILTER CHIPS */
            function updateFilterChips() {
                const container = element('activeFilterChips');
                container.innerHTML = '';

                const filters = [{
                        label: 'Kategori',
                        value: categoryFilter.value
                    },
                    {
                        label: 'Hub',
                        value: hubFilter.value
                    },
                    {
                        label: 'Status',
                        value: statusFilter.value === 'good' ?
                            'Sesuai' : statusFilter.value === 'warning' ?
                            'Perlu Evaluasi' : statusFilter.value === 'danger' ?
                            'Tidak Sesuai' : ''
                    }
                ];

                const activeFilters = filters.filter(item => item.value);

                if (activeFilters.length === 0) {
                    const chip = document.createElement('span');
                    chip.className = 'filter-chip bg-blue-50 text-blue-600 border border-blue-100 rounded-full px-3 py-1 text-[10px] font-semibold';
                    chip.textContent = 'Semua Data';
                    container.appendChild(chip);
                    return;
                }

                activeFilters.forEach(item => {
                    const chip = document.createElement('span');
                    chip.className = 'filter-chip bg-blue-50 text-blue-600 border border-blue-100 rounded-full px-3 py-1 text-[10px] font-semibold';
                    chip.textContent = item.label + ': ' + item.value;
                    container.appendChild(chip);
                });
            }

            /* ADVANCED FILTER */
            element('btnAdvancedFilter').addEventListener('click', function() {
                advancedFilter.classList.toggle('show');

                if (advancedFilter.classList.contains('show')) {
                    advancedFilter.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });
                }
            });

            element('btnCloseFilter').addEventListener('click', function() {
                advancedFilter.classList.remove('show');
            });

            element('btnApplyFilter').addEventListener('click', function() {
                applyFilters();
                advancedFilter.classList.remove('show');
                showToast('Filter laporan berhasil diterapkan.');
            });

            element('btnResetFilter').addEventListener('click', function() {
                categoryFilter.value = '';
                hubFilter.value = '';
                statusFilter.value = '';
                searchInput.value = '';

                applyFilters();
                showToast('Filter berhasil direset.');
            });

            searchInput.addEventListener('input', applyFilters);

            /* EXPORT CSV */
            element('btnExport').addEventListener('click', function() {
                if (filteredRows.length === 0) {
                    showToast('Tidak ada data untuk diekspor.', 'warning');
                    return;
                }

                const csvRows = [
                    [
                        'ID Laporan',
                        'Lokasi Hub',
                        'Kategori',
                        'SKU',
                        'Volume',
                        'Valuasi',
                        'Kepatuhan',
                        'Status'
                    ]
                ];

                filteredRows.forEach(row => {
                    csvRows.push([
                        row.dataset.id,
                        row.dataset.hub,
                        row.dataset.category,
                        row.dataset.sku,
                        row.dataset.volume,
                        row.dataset.value,
                        row.dataset.compliance + '%',
                        row.dataset.status === 'good' ?
                        'Sesuai' :
                        row.dataset.status === 'warning' ?
                        'Perlu Evaluasi' :
                        'Tidak Sesuai'
                    ]);
                });

                const csv = csvRows.map(row =>
                    row.map(value =>
                        '"' + String(value).replace(/"/g, '""') + '"'
                    ).join(';')
                ).join('\n');

                const blob = new Blob(['\uFEFF' + csv], {
                    type: 'text/csv;charset=utf-8;'
                });

                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');

                link.href = url;
                link.download = 'laporan-inventaris-astro-inventory.csv';

                document.body.appendChild(link);
                link.click();
                link.remove();

                setTimeout(() => URL.revokeObjectURL(url), 1000);

                showToast('Rekap CSV berhasil disiapkan.');
            });

            /* PRINT */
            element('btnPrint').addEventListener('click', function() {
                window.print();
            });

            /* DETAIL MODAL */
            const modal = element('reportDetailModal');

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            document.querySelectorAll('.detail-btn').forEach(button => {
                button.addEventListener('click', function() {
                    element('modalReportId').textContent = this.dataset.id;
                    element('modalHub').textContent = this.dataset.hub;
                    element('modalCategory').textContent = this.dataset.category;
                    element('modalSku').textContent = this.dataset.sku;
                    element('modalVolume').textContent = this.dataset.volume;
                    element('modalValue').textContent = this.dataset.value;
                    element('modalCompliance').textContent = this.dataset.compliance;
                    element('modalStatus').textContent = this.dataset.status;

                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
            });

            element('closeReportModal').addEventListener('click', closeModal);
            element('modalDone').addEventListener('click', closeModal);

            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });

            /* CHART DATA */
            const chartData = {
                '7': {
                    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                    inbound: [120, 180, 145, 210, 175, 240, 170],
                    outbound: [90, 130, 110, 160, 140, 190, 125]
                },

                '30': {
                    labels: ['1-5', '6-10', '11-15', '16-20', '21-25', '26-30'],
                    inbound: [620, 780, 690, 920, 850, 1050],
                    outbound: [480, 610, 560, 720, 680, 810]
                },

                'month': {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    inbound: [1800, 2100, 1950, 2450, 2300, 2800],
                    outbound: [1400, 1700, 1600, 1900, 1850, 2200]
                }
            };

            function createChart(range = '7') {
                const canvas = element('mutationChart');
                const fallback = element('chartFallback');

                if (!canvas || typeof Chart === 'undefined') {
                    if (canvas) canvas.classList.add('hidden');

                    if (fallback) {
                        fallback.classList.remove('hidden');
                        fallback.classList.add('flex');
                    }

                    return;
                }

                const data = chartData[range];

                if (mutationChart) {
                    mutationChart.data.labels = data.labels;
                    mutationChart.data.datasets[0].data = data.inbound;
                    mutationChart.data.datasets[1].data = data.outbound;
                    mutationChart.update();
                    return;
                }

                mutationChart = new Chart(canvas, {
                    type: 'line',

                    data: {
                        labels: data.labels,

                        datasets: [{
                                label: 'Barang Masuk',
                                data: data.inbound,
                                borderColor: '#2563eb',
                                backgroundColor: 'rgba(37, 99, 235, .10)',
                                borderWidth: 2.5,
                                fill: true,
                                tension: .4,
                                pointRadius: 3,
                                pointHoverRadius: 5
                            },
                            {
                                label: 'Barang Keluar',
                                data: data.outbound,
                                borderColor: '#a5b4fc',
                                backgroundColor: 'rgba(165, 180, 252, .08)',
                                borderWidth: 2.5,
                                fill: true,
                                tension: .4,
                                pointRadius: 3,
                                pointHoverRadius: 5
                            }
                        ]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },

                        plugins: {
                            legend: {
                                display: false
                            },

                            tooltip: {
                                backgroundColor: '#172033',
                                padding: 12,
                                titleFont: {
                                    size: 11
                                },
                                bodyFont: {
                                    size: 11
                                }
                            }
                        },

                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#94a3b8',
                                    font: {
                                        size: 10
                                    }
                                },
                                border: {
                                    display: false
                                }
                            },

                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#f1f5f9',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#94a3b8',
                                    font: {
                                        size: 10
                                    }
                                },
                                border: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            /* CHART RANGE BUTTONS */
            document.querySelectorAll('.range-btn').forEach(button => {
                button.addEventListener('click', function() {
                    document.querySelectorAll('.range-btn').forEach(item => {
                        item.classList.remove('active');
                    });

                    this.classList.add('active');
                    createChart(this.dataset.range);
                });
            });

            /* INITIALIZATION */
            applyFilters();
            createChart('7');

        })();
    </script>

    @endif

</body>

</html>
