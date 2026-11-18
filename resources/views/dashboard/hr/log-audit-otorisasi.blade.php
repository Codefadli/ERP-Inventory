<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Audit & Otorisasi - Astro Inventory</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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

        ::-webkit-scrollbar {
            width: 9px;
            height: 9px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 99px;
            border: 2px solid #f5f7fb;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .audit-page {
            min-height: 100vh;
            width: 100%;
        }

        .audit-page .metric-card {
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .audit-page .metric-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px -12px rgba(37, 99, 235, .22),
                0 4px 10px rgba(15, 23, 42, .06);
        }

        .audit-page .panel {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, .04);
        }

        .audit-page .btn-primary {
            transition: all .2s ease;
        }

        .audit-page .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(37, 99, 235, .2);
        }

        .audit-page .filter-pill {
            transition: all .2s ease;
        }

        .audit-page .filter-pill.active {
            background: #dbeafe;
            border-color: #2563eb;
            color: #1d4ed8;
        }

        .audit-page .audit-row {
            transition: background .2s ease;
        }

        .audit-page .audit-row:hover {
            background: #f8fafc;
        }

        .audit-page .hash-text {
            word-break: break-all;
            font-family: 'Courier New', monospace;
        }

        .audit-page .status-dot {
            width: 8px;
            height: 8px;
            display: inline-block;
            border-radius: 50%;
        }

        .audit-page .network-line {
            stroke-dasharray: 5 5;
            animation: dashMove 18s linear infinite;
        }

        @keyframes dashMove {
            to {
                stroke-dashoffset: -200;
            }
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

        .audit-page .fade-up {
            animation: fadeUp .5s ease both;
        }

        .audit-page .delay-1 {
            animation-delay: .08s;
        }

        .audit-page .delay-2 {
            animation-delay: .16s;
        }

        .audit-page .delay-3 {
            animation-delay: .24s;
        }

        .audit-page .delay-4 {
            animation-delay: .32s;
        }

        #auditToastContainer {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 9px;
        }

        .audit-toast {
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

        .audit-toast.success {
            border-left-color: #16a34a;
        }

        .audit-toast.warning {
            border-left-color: #f59e0b;
        }

        .audit-toast.error {
            border-left-color: #dc2626;
        }

        @media (max-width: 768px) {
            .audit-page .page-heading {
                align-items: flex-start;
            }

            .audit-page .table-container {
                overflow-x: auto;
            }

            .audit-page table {
                min-width: 1050px;
            }
        }

        @media print {
            body {
                background: #fff !important;
            }

            #auditToastContainer,
            .no-print,
            aside,
            nav {
                display: none !important;
            }

            .audit-page {
                display: block !important;
            }

            .audit-page main {
                padding: 0 !important;
                width: 100% !important;
            }

            .audit-page .panel,
            .audit-page .metric-card {
                box-shadow: none !important;
                break-inside: avoid;
            }

            .audit-page .table-container {
                overflow: visible !important;
            }

            .audit-page table {
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

    <!-- NAVBAR -->
    @include('components.navbar')

    <div class="audit-page flex min-h-screen">

        <!-- SIDEBAR -->
        @include('components.sidebar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 min-w-0 p-4 lg:p-6 overflow-x-hidden">

            @if(auth()->check() && auth()->user()->isHR())

            <!-- BREADCRUMB -->
            <div class="flex flex-wrap items-center gap-2 text-xs text-gray-400 mb-4">
                <a href="{{ url('/') }}" class="hover:text-blue-600">
                    <i class="fas fa-home mr-1"></i>Beranda
                </a>
                <i class="fas fa-chevron-right text-[9px]"></i>
                <span>Manajemen &amp; Laporan</span>
                <i class="fas fa-chevron-right text-[9px]"></i>
                <span class="text-blue-600 font-semibold">Log Audit &amp; Otorisasi</span>
            </div>

            <!-- PAGE HEADER -->
            <div class="page-heading flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6 fade-up">
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h1 class="text-xl md:text-2xl font-extrabold text-gray-900">
                            Log Audit &amp; Otorisasi
                        </h1>
                        <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 rounded-full px-2.5 py-1 text-[10px] font-bold">
                            <span class="status-dot bg-green-500"></span>
                            AUDIT SYSTEM ACTIVE
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 max-w-2xl leading-relaxed">
                        Pemantauan aktivitas pengguna, riwayat otorisasi, integritas data,
                        dan jejak perubahan sistem inventaris secara terstruktur.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2 no-print">
                    <button id="btnExport"
                        class="bg-white border border-gray-300 text-gray-700 px-3 py-2 rounded-lg text-xs font-semibold hover:bg-gray-50 flex items-center gap-2">
                        <i class="fas fa-file-csv text-green-600"></i>
                        Ekspor CSV
                    </button>

                    <button id="btnPrint"
                        class="btn-primary bg-blue-600 text-white px-4 py-2 rounded-lg text-xs font-semibold hover:bg-blue-700 flex items-center gap-2">
                        <i class="fas fa-print"></i>
                        Cetak Laporan
                    </button>
                </div>
            </div>

            <!-- INFORMATION NOTICE -->
            <div class="panel border-l-4 border-l-amber-400 bg-amber-50 p-3.5 mb-6 fade-up">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-amber-800 mb-1">Informasi Data Audit</h3>
                        <p class="text-[11px] text-amber-700 leading-relaxed">
                            Data aktivitas pada halaman ini merupakan data contoh untuk tampilan
                            antarmuka. Nilai hash dan catatan audit belum terhubung dengan
                            penyimpanan log produksi.
                        </p>
                    </div>
                </div>
            </div>

            <!-- SYSTEM STATUS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

                <div class="metric-card panel p-4 fade-up delay-1">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <span class="text-[10px] font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                            AKTIF
                        </span>
                    </div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Status Sistem Audit</p>
                    <h2 class="text-2xl font-extrabold text-gray-900 mt-1">Aktif</h2>
                    <p class="text-[11px] text-gray-500 mt-1">Pemantauan aktivitas berjalan</p>
                </div>

                <div class="metric-card panel p-4 fade-up delay-2">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <i class="fas fa-list-check"></i>
                        </div>
                        <span class="text-[10px] font-semibold text-indigo-600">Hari ini</span>
                    </div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total Aktivitas</p>
                    <h2 class="text-2xl font-extrabold text-gray-900 mt-1" id="totalActivity">24.810</h2>
                    <p class="text-[11px] text-gray-500 mt-1">Catatan aktivitas tercatat</p>
                </div>

                <div class="metric-card panel p-4 fade-up delay-3">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                            <i class="fas fa-magnifying-glass-chart"></i>
                        </div>
                        <span class="text-[10px] font-semibold text-amber-600">Perlu perhatian</span>
                    </div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Dalam Peninjauan</p>
                    <h2 class="text-2xl font-extrabold text-gray-900 mt-1">02</h2>
                    <p class="text-[11px] text-gray-500 mt-1">Aktivitas menunggu pemeriksaan</p>
                </div>

                <div class="metric-card panel p-4 fade-up delay-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <span class="text-[10px] font-semibold text-green-600">Normal</span>
                    </div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Konflik Otorisasi</p>
                    <h2 class="text-2xl font-extrabold text-gray-900 mt-1">00</h2>
                    <p class="text-[11px] text-gray-500 mt-1">Tidak ada konflik pada data contoh</p>
                </div>

            </div>

            <!-- INTEGRITY METRICS -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">

                <div class="panel p-4 lg:col-span-2">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Integritas Rantai Audit</h3>
                            <p class="text-[11px] text-gray-500 mt-1">Ringkasan validasi integritas data log</p>
                        </div>
                        <span class="text-[10px] bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full font-bold">
                            <i class="fas fa-check-circle mr-1"></i>TERVALIDASI (SIMULASI)
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-slate-50 rounded-lg p-3">
                            <p class="text-[10px] text-gray-500 font-semibold uppercase">Integritas Chain</p>
                            <p class="text-2xl font-extrabold text-blue-600 mt-1">100%</p>
                            <p class="text-[10px] text-gray-400 mt-1">Status contoh</p>
                        </div>
                        <div class="bg-slate-50 rounded-lg p-3">
                            <p class="text-[10px] text-gray-500 font-semibold uppercase">Total Log</p>
                            <p class="text-2xl font-extrabold text-gray-900 mt-1">24.810</p>
                            <p class="text-[10px] text-gray-400 mt-1">Entri tercatat</p>
                        </div>
                        <div class="bg-slate-50 rounded-lg p-3">
                            <p class="text-[10px] text-gray-500 font-semibold uppercase">Penyimpangan</p>
                            <p class="text-2xl font-extrabold text-green-600 mt-1">00</p>
                            <p class="text-[10px] text-gray-400 mt-1">Tidak ditemukan</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="flex justify-between text-[10px] mb-1.5">
                            <span class="text-gray-500 font-semibold">Status pemeriksaan integritas</span>
                            <span class="text-blue-600 font-bold">100%</span>
                        </div>
                        <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-600 rounded-full" style="width:100%"></div>
                        </div>
                    </div>
                </div>

                <div class="panel p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Segregation of Duties</h3>
                            <p class="text-[11px] text-gray-500 mt-1">Pemisahan tugas otorisasi</p>
                        </div>
                        <i class="fas fa-user-lock text-blue-500"></i>
                    </div>

                    <div class="flex items-center justify-center py-3">
                        <div class="relative w-28 h-28 rounded-full flex items-center justify-center"
                            style="background:conic-gradient(#2563eb 0% 100%, #e5e7eb 100% 100%)">
                            <div class="w-20 h-20 bg-white rounded-full flex flex-col items-center justify-center">
                                <span class="text-xl font-extrabold text-gray-900">100%</span>
                                <span class="text-[9px] text-gray-400 font-semibold">SOD</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 text-[11px]">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500"><i class="fas fa-circle text-blue-500 text-[7px] mr-2"></i>Validasi peran</span>
                            <span class="font-bold text-gray-800">Aktif</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500"><i class="fas fa-circle text-green-500 text-[7px] mr-2"></i>Konflik tugas</span>
                            <span class="font-bold text-green-600">0 Konflik</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- HASH PANEL -->
            <div class="panel p-4 mb-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-3">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">
                            <i class="fas fa-fingerprint text-blue-600 mr-2"></i>
                            Root Hash Audit
                        </h3>
                        <p class="text-[11px] text-gray-500 mt-1">
                            Contoh identitas hash untuk demonstrasi validasi SHA-256
                        </p>
                    </div>
                    <div class="flex items-center gap-2 no-print">
                        <button id="copyHash"
                            class="text-xs font-semibold px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 text-gray-600">
                            <i class="fas fa-copy mr-1"></i> Salin Hash
                        </button>
                        <button id="verifyHash"
                            class="text-xs font-semibold px-3 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">
                            <i class="fas fa-shield-check mr-1"></i> Uji SHA-256
                        </button>
                    </div>
                </div>

                <div class="bg-slate-950 rounded-lg p-4">
                    <p class="text-[9px] text-blue-300 font-bold uppercase tracking-widest mb-2">SHA-256 ROOT HASH</p>
                    <p id="rootHash" class="hash-text text-[11px] md:text-xs text-green-300 leading-relaxed">
                        8f14e45fceea167a5a36dedd4bea2543b7f8e2a9c3d4b5e6f708192a3b4c5d6e
                    </p>
                    <div class="flex flex-wrap items-center justify-between gap-2 mt-3 pt-3 border-t border-slate-700">
                        <span class="text-[10px] text-slate-400">
                            <i class="fas fa-clock mr-1"></i> Pemeriksaan terakhir: 18 November 2026
                        </span>
                        <span id="hashStatus" class="text-[10px] text-green-300 font-semibold">
                            <i class="fas fa-check-circle mr-1"></i> Hash contoh tersedia
                        </span>
                    </div>
                </div>
            </div>

            <!-- FILTER -->
            <div class="panel p-4 mb-4 no-print">
                <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">

                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-[10px] text-gray-400 font-bold uppercase mr-1">Periode:</span>

                        <div id="dateFilters" class="flex flex-wrap gap-2">
                            <button type="button" data-days="1" class="filter-pill border border-gray-200 rounded-lg px-3 py-2 text-[11px] font-semibold text-gray-600">
                                Hari Ini
                            </button>
                            <button type="button" data-days="7" class="filter-pill active border border-gray-200 rounded-lg px-3 py-2 text-[11px] font-semibold">
                                7 Hari
                            </button>
                            <button type="button" data-days="30" class="filter-pill border border-gray-200 rounded-lg px-3 py-2 text-[11px] font-semibold text-gray-600">
                                30 Hari
                            </button>
                            <button type="button" data-days="all" class="filter-pill border border-gray-200 rounded-lg px-3 py-2 text-[11px] font-semibold text-gray-600">
                                Semua
                            </button>
                        </div>
                    </div>

                    <div class="relative w-full xl:w-80">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-xs"></i>
                        <input type="text" id="searchAudit"
                            placeholder="Cari ID, pengguna, aktivitas..."
                            class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 text-xs outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500">
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2 mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center gap-2">
                        <label for="filterHub" class="text-[10px] text-gray-500 font-semibold">HUB</label>
                        <select id="filterHub" class="border border-gray-200 rounded-lg px-3 py-2 text-[11px] bg-white text-gray-700 outline-none focus:border-blue-500">
                            <option value="">Semua Hub</option>
                            <option value="DC-01">Cakung DC-01</option>
                            <option value="DC-02">Halim DC-02</option>
                            <option value="DC-03">Surabaya DC-03</option>
                            <option value="DC-04">Medan DC-04</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <label for="filterType" class="text-[10px] text-gray-500 font-semibold">AKTIVITAS</label>
                        <select id="filterType" class="border border-gray-200 rounded-lg px-3 py-2 text-[11px] bg-white text-gray-700 outline-none focus:border-blue-500">
                            <option value="">Semua Aktivitas</option>
                            <option value="approval">Persetujuan</option>
                            <option value="discrepancy">Discrepancy</option>
                            <option value="master">Perubahan Master</option>
                            <option value="rejection">Penolakan</option>
                            <option value="system">Sistem</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <label for="filterStatus" class="text-[10px] text-gray-500 font-semibold">STATUS</label>
                        <select id="filterStatus" class="border border-gray-200 rounded-lg px-3 py-2 text-[11px] bg-white text-gray-700 outline-none focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="success">Berhasil</option>
                            <option value="review">Ditinjau</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>

                    <div class="ml-auto flex items-center gap-3">
                        <button id="resetAudit"
                            class="text-[11px] text-gray-500 hover:text-gray-800 font-semibold">
                            <i class="fas fa-rotate-left mr-1"></i> Reset
                        </button>
                        <button id="refreshAudit"
                            class="text-[11px] text-blue-600 hover:text-blue-800 font-semibold">
                            <i class="fas fa-rotate mr-1"></i> Muat Ulang
                        </button>
                    </div>
                </div>
            </div>

            <!-- TABLE TITLE -->
            <div class="flex flex-wrap items-center justify-between gap-2 mb-3 px-1">
                <div>
                    <h3 class="text-xs font-extrabold text-gray-900 uppercase tracking-wider">
                        Riwayat Aktivitas Audit
                    </h3>
                    <p class="text-[10px] text-gray-400 mt-1" id="resultCount">
                        Menampilkan seluruh aktivitas contoh
                    </p>
                </div>
                <span class="text-[10px] text-gray-400">
                    <i class="fas fa-database mr-1"></i> Audit Log Registry
                </span>
            </div>

            <!-- AUDIT TABLE -->
            <div class="panel overflow-hidden mb-6">
                <div class="table-container overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-gray-200 text-[10px] uppercase tracking-wider text-gray-400">
                                <th class="px-4 py-3 font-bold">ID &amp; Waktu</th>
                                <th class="px-4 py-3 font-bold">Pengguna</th>
                                <th class="px-4 py-3 font-bold">Aktivitas</th>
                                <th class="px-4 py-3 font-bold">Modul</th>
                                <th class="px-4 py-3 font-bold">Hub</th>
                                <th class="px-4 py-3 font-bold">Status</th>
                                <th class="px-4 py-3 font-bold">Hash / Referensi</th>
                                <th class="px-4 py-3 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="auditTableBody" class="divide-y divide-gray-100 text-xs">

                            <tr class="audit-row"
                                data-date="2026-11-18"
                                data-hub="DC-01"
                                data-type="approval"
                                data-status="success">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-bold text-blue-600">EVT-2026-098412</p>
                                    <p class="text-[10px] text-gray-400 mt-1">18 Nov 2026, 14:10 WIB</p>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-semibold text-gray-800">Siti Rahmawati</p>
                                    <p class="text-[10px] text-gray-400">HR Administrator</p>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 rounded-md px-2 py-1 text-[10px] font-bold">
                                        <i class="fas fa-check-circle"></i> Persetujuan
                                    </span>
                                    <p class="text-[10px] text-gray-500 mt-1">Approval mutasi inventaris</p>
                                </td>
                                <td class="px-4 py-4 text-gray-600">Otorisasi Mutasi</td>
                                <td class="px-4 py-4 whitespace-nowrap text-gray-600">Cakung DC-01</td>
                                <td class="px-4 py-4">
                                    <span class="text-green-700 bg-green-50 px-2 py-1 rounded-md text-[10px] font-bold">Berhasil</span>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="font-mono text-[10px] text-gray-500">8f14e45f...c5d6e</p>
                                    <p class="text-[10px] text-gray-400 mt-1">REF-AUD-8412</p>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button class="detail-btn text-blue-600 hover:text-blue-800 font-semibold"
                                        data-id="EVT-2026-098412"
                                        data-user="Siti Rahmawati"
                                        data-action="Approval mutasi inventaris"
                                        data-module="Otorisasi Mutasi"
                                        data-hub="Cakung DC-01"
                                        data-status="Berhasil"
                                        data-time="18 November 2026, 14:10 WIB"
                                        data-description="Permintaan mutasi inventaris telah disetujui oleh HR Administrator.">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>

                            <tr class="audit-row"
                                data-date="2026-11-18"
                                data-hub="DC-02"
                                data-type="discrepancy"
                                data-status="review">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-bold text-blue-600">EVT-2026-098408</p>
                                    <p class="text-[10px] text-gray-400 mt-1">18 Nov 2026, 13:45 WIB</p>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-semibold text-gray-800">Dewi Anggraini</p>
                                    <p class="text-[10px] text-gray-400">Auditor Internal</p>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 rounded-md px-2 py-1 text-[10px] font-bold">
                                        <i class="fas fa-triangle-exclamation"></i> Discrepancy
                                    </span>
                                    <p class="text-[10px] text-gray-500 mt-1">Pemeriksaan selisih stok</p>
                                </td>
                                <td class="px-4 py-4 text-gray-600">Stok Opname</td>
                                <td class="px-4 py-4 whitespace-nowrap text-gray-600">Halim DC-02</td>
                                <td class="px-4 py-4">
                                    <span class="text-amber-700 bg-amber-50 px-2 py-1 rounded-md text-[10px] font-bold">Ditinjau</span>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="font-mono text-[10px] text-gray-500">a3b8c21d...8f219</p>
                                    <p class="text-[10px] text-gray-400 mt-1">REF-AUD-8408</p>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button class="detail-btn text-blue-600 hover:text-blue-800 font-semibold"
                                        data-id="EVT-2026-098408"
                                        data-user="Dewi Anggraini"
                                        data-action="Pemeriksaan selisih stok"
                                        data-module="Stok Opname"
                                        data-hub="Halim DC-02"
                                        data-status="Ditinjau"
                                        data-time="18 November 2026, 13:45 WIB"
                                        data-description="Terdapat perbedaan antara jumlah stok sistem dan hasil pemeriksaan fisik. Aktivitas menunggu peninjauan.">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>

                            <tr class="audit-row"
                                data-date="2026-11-17"
                                data-hub="DC-03"
                                data-type="master"
                                data-status="success">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-bold text-blue-600">EVT-2026-098389</p>
                                    <p class="text-[10px] text-gray-400 mt-1">17 Nov 2026, 16:20 WIB</p>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-semibold text-gray-800">Budi Santoso</p>
                                    <p class="text-[10px] text-gray-400">Inventory Manager</p>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-1.5 bg-indigo-50 text-indigo-700 rounded-md px-2 py-1 text-[10px] font-bold">
                                        <i class="fas fa-pen-to-square"></i> Perubahan Master
                                    </span>
                                    <p class="text-[10px] text-gray-500 mt-1">Pembaruan data barang</p>
                                </td>
                                <td class="px-4 py-4 text-gray-600">Master Barang</td>
                                <td class="px-4 py-4 whitespace-nowrap text-gray-600">Surabaya DC-03</td>
                                <td class="px-4 py-4">
                                    <span class="text-green-700 bg-green-50 px-2 py-1 rounded-md text-[10px] font-bold">Berhasil</span>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="font-mono text-[10px] text-gray-500">b7d91f20...a7812</p>
                                    <p class="text-[10px] text-gray-400 mt-1">REF-AUD-8389</p>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button class="detail-btn text-blue-600 hover:text-blue-800 font-semibold"
                                        data-id="EVT-2026-098389"
                                        data-user="Budi Santoso"
                                        data-action="Pembaruan data barang"
                                        data-module="Master Barang"
                                        data-hub="Surabaya DC-03"
                                        data-status="Berhasil"
                                        data-time="17 November 2026, 16:20 WIB"
                                        data-description="Data master barang diperbarui oleh Inventory Manager.">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>

                            <tr class="audit-row"
                                data-date="2026-11-16"
                                data-hub="DC-01"
                                data-type="rejection"
                                data-status="rejected">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-bold text-blue-600">EVT-2026-098381</p>
                                    <p class="text-[10px] text-gray-400 mt-1">16 Nov 2026, 10:30 WIB</p>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-semibold text-gray-800">Siti Rahmawati</p>
                                    <p class="text-[10px] text-gray-400">HR Administrator</p>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-700 rounded-md px-2 py-1 text-[10px] font-bold">
                                        <i class="fas fa-ban"></i> Penolakan
                                    </span>
                                    <p class="text-[10px] text-gray-500 mt-1">Penolakan permintaan mutasi</p>
                                </td>
                                <td class="px-4 py-4 text-gray-600">Otorisasi Mutasi</td>
                                <td class="px-4 py-4 whitespace-nowrap text-gray-600">Cakung DC-01</td>
                                <td class="px-4 py-4">
                                    <span class="text-red-700 bg-red-50 px-2 py-1 rounded-md text-[10px] font-bold">Ditolak</span>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="font-mono text-[10px] text-gray-500">c4e29a17...d6210</p>
                                    <p class="text-[10px] text-gray-400 mt-1">REF-AUD-8381</p>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button class="detail-btn text-blue-600 hover:text-blue-800 font-semibold"
                                        data-id="EVT-2026-098381"
                                        data-user="Siti Rahmawati"
                                        data-action="Penolakan permintaan mutasi"
                                        data-module="Otorisasi Mutasi"
                                        data-hub="Cakung DC-01"
                                        data-status="Ditolak"
                                        data-time="16 November 2026, 10:30 WIB"
                                        data-description="Permintaan mutasi ditolak karena persyaratan dokumen belum memenuhi ketentuan.">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>

                            <tr class="audit-row"
                                data-date="2026-11-15"
                                data-hub="DC-04"
                                data-type="system"
                                data-status="success">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-bold text-blue-600">EVT-2026-098350</p>
                                    <p class="text-[10px] text-gray-400 mt-1">15 Nov 2026, 08:00 WIB</p>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <p class="font-semibold text-gray-800">Sistem Otomatis</p>
                                    <p class="text-[10px] text-gray-400">System Service</p>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-700 rounded-md px-2 py-1 text-[10px] font-bold">
                                        <i class="fas fa-gear"></i> Sistem
                                    </span>
                                    <p class="text-[10px] text-gray-500 mt-1">Sinkronisasi audit harian</p>
                                </td>
                                <td class="px-4 py-4 text-gray-600">System Monitoring</td>
                                <td class="px-4 py-4 whitespace-nowrap text-gray-600">Medan DC-04</td>
                                <td class="px-4 py-4">
                                    <span class="text-green-700 bg-green-50 px-2 py-1 rounded-md text-[10px] font-bold">Berhasil</span>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="font-mono text-[10px] text-gray-500">d8f102ab...b091c</p>
                                    <p class="text-[10px] text-gray-400 mt-1">REF-AUD-8350</p>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button class="detail-btn text-blue-600 hover:text-blue-800 font-semibold"
                                        data-id="EVT-2026-098350"
                                        data-user="Sistem Otomatis"
                                        data-action="Sinkronisasi audit harian"
                                        data-module="System Monitoring"
                                        data-hub="Medan DC-04"
                                        data-status="Berhasil"
                                        data-time="15 November 2026, 08:00 WIB"
                                        data-description="Sistem menjalankan proses sinkronisasi audit harian secara otomatis.">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-4 py-3 bg-gray-50 border-t border-gray-200">
                    <p class="text-[10px] text-gray-500">
                        Data contoh ditampilkan: <strong id="visibleCount">5</strong> aktivitas
                    </p>
                    <div class="flex items-center gap-1 text-[10px]">
                        <button type="button" class="px-3 py-1.5 rounded border border-gray-200 bg-white text-gray-400 cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" class="px-3 py-1.5 rounded bg-blue-600 text-white font-bold">1</button>
                        <button type="button" class="px-3 py-1.5 rounded border border-gray-200 bg-white text-gray-400 cursor-not-allowed">2</button>
                        <button type="button" class="px-3 py-1.5 rounded border border-gray-200 bg-white text-gray-400 cursor-not-allowed">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- BOTTOM INFORMATION -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">

                <div class="panel p-4">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-fingerprint"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-gray-900 mb-1">Integritas Kriptografis</h4>
                            <p class="text-[11px] text-gray-500 leading-relaxed">
                                Setiap aktivitas dapat memiliki identitas hash untuk membantu
                                pemeriksaan perubahan dan konsistensi catatan audit.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="panel p-4">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-gray-900 mb-1">Kontrol Otorisasi</h4>
                            <p class="text-[11px] text-gray-500 leading-relaxed">
                                Pemisahan peran membantu memastikan aktivitas persetujuan
                                dan perubahan data dilakukan sesuai kewenangan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="panel p-4">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-magnifying-glass"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-gray-900 mb-1">Tindak Lanjut Audit</h4>
                            <p class="text-[11px] text-gray-500 leading-relaxed">
                                Aktivitas yang memerlukan pemeriksaan dapat ditinjau lebih lanjut
                                berdasarkan catatan, pengguna, dan referensi transaksi.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- FOOTER NOTE -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 border-t border-gray-200 pt-4 text-[10px] text-gray-400">
                <p>
                    <i class="fas fa-shield-alt mr-1"></i>
                    Astro Inventory — Audit &amp; Authorization Monitoring
                </p>
                <p>Data contoh antarmuka · 18 November 2026</p>
            </div>

            @else

            <div class="panel p-10 text-center">
                <div class="w-14 h-14 rounded-full bg-red-50 text-red-500 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lock text-2xl"></i>
                </div>
                <h2 class="text-lg font-bold text-gray-900">Akses Tidak Diizinkan</h2>
                <p class="text-sm text-gray-500 mt-2">
                    Halaman Log Audit &amp; Otorisasi hanya dapat diakses oleh pengguna dengan role HR.
                </p>
                <a href="{{ url('/') }}"
                    class="inline-flex mt-5 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-xs font-semibold">
                    Kembali ke Beranda
                </a>
            </div>

            @endif

        </main>
    </div>

    <!-- DETAIL MODAL -->
    <div id="detailModal" class="fixed inset-0 z-[9998] hidden items-center justify-center bg-slate-950/50 p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Detail Aktivitas Audit</h3>
                    <p class="text-[10px] text-gray-400 mt-1">Informasi catatan aktivitas</p>
                </div>
                <button id="closeModal" class="w-8 h-8 rounded-lg hover:bg-gray-100 text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-5">
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 mb-4">
                    <p class="text-[9px] uppercase tracking-wider font-bold text-blue-500">Event ID</p>
                    <p id="modalId" class="text-sm font-extrabold text-blue-700 mt-1"></p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <p class="text-[10px] text-gray-400 mb-1">Pengguna</p>
                        <p id="modalUser" class="font-semibold text-gray-800"></p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 mb-1">Waktu</p>
                        <p id="modalTime" class="font-semibold text-gray-800"></p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 mb-1">Aktivitas</p>
                        <p id="modalAction" class="font-semibold text-gray-800"></p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 mb-1">Modul</p>
                        <p id="modalModule" class="font-semibold text-gray-800"></p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 mb-1">Hub</p>
                        <p id="modalHub" class="font-semibold text-gray-800"></p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 mb-1">Status</p>
                        <p id="modalStatus" class="font-semibold text-gray-800"></p>
                    </div>
                </div>

                <div class="mt-4 bg-gray-50 rounded-lg p-3">
                    <p class="text-[10px] text-gray-400 font-bold mb-1">KETERANGAN AKTIVITAS</p>
                    <p id="modalDescription" class="text-xs text-gray-600 leading-relaxed"></p>
                </div>
            </div>

            <div class="px-5 py-3 border-t border-gray-100 flex justify-end">
                <button id="modalDone" class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 text-xs font-semibold">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- TOAST -->
    <div id="auditToastContainer"></div>

    <script>
        (function() {
            'use strict';

            const tableBody = document.getElementById('auditTableBody');

            // Halaman ini hanya memiliki script audit jika tabel tersedia.
            if (!tableBody) return;

            const rows = Array.from(tableBody.querySelectorAll('.audit-row'));
            const searchInput = document.getElementById('searchAudit');
            const hubFilter = document.getElementById('filterHub');
            const typeFilter = document.getElementById('filterType');
            const statusFilter = document.getElementById('filterStatus');
            const resultCount = document.getElementById('resultCount');
            const visibleCount = document.getElementById('visibleCount');
            const dateButtons = document.querySelectorAll('#dateFilters [data-days]');

            let selectedDays = '7';

            function showToast(message, type = 'success') {
                const container = document.getElementById('auditToastContainer');
                const toast = document.createElement('div');

                toast.className = 'audit-toast ' + type;
                toast.innerHTML = `
                    <div class="flex items-center gap-2">
                        <i class="fas ${
                            type === 'success' ? 'fa-circle-check' :
                            type === 'warning' ? 'fa-triangle-exclamation' :
                            'fa-circle-xmark'
                        }"></i>
                        <span></span>
                    </div>
                `;

                toast.querySelector('span').textContent = message;
                container.appendChild(toast);

                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transition = 'opacity .25s ease';
                    setTimeout(() => toast.remove(), 250);
                }, 3000);
            }

            function applyFilters() {
                const keyword = searchInput.value.trim().toLowerCase();
                const selectedHub = hubFilter.value;
                const selectedType = typeFilter.value;
                const selectedStatus = statusFilter.value;

                const today = new Date();
                today.setHours(0, 0, 0, 0);

                let visible = 0;

                rows.forEach(row => {
                    let matches = true;

                    const rowDate = new Date(row.dataset.date + 'T00:00:00');
                    const rowText = row.textContent.toLowerCase();

                    if (keyword && !rowText.includes(keyword)) {
                        matches = false;
                    }

                    if (selectedHub && row.dataset.hub !== selectedHub) {
                        matches = false;
                    }

                    if (selectedType && row.dataset.type !== selectedType) {
                        matches = false;
                    }

                    if (selectedStatus && row.dataset.status !== selectedStatus) {
                        matches = false;
                    }

                    if (selectedDays !== 'all') {
                        const days = Number(selectedDays);
                        const startDate = new Date(today);
                        startDate.setDate(today.getDate() - (days - 1));

                        if (rowDate < startDate || rowDate > today) {
                            matches = false;
                        }
                    }

                    row.style.display = matches ? '' : 'none';

                    if (matches) visible++;
                });

                visibleCount.textContent = visible;
                resultCount.textContent = `Menampilkan ${visible} dari ${rows.length} aktivitas contoh`;

                if (visible === 0) {
                    resultCount.textContent = 'Tidak ada aktivitas yang sesuai dengan filter.';
                }
            }

            // Filter pencarian dan dropdown.
            searchInput.addEventListener('input', applyFilters);
            hubFilter.addEventListener('change', applyFilters);
            typeFilter.addEventListener('change', applyFilters);
            statusFilter.addEventListener('change', applyFilters);

            // Filter rentang waktu.
            dateButtons.forEach(button => {
                button.addEventListener('click', function() {
                    dateButtons.forEach(item => item.classList.remove('active'));
                    this.classList.add('active');

                    selectedDays = this.dataset.days;
                    applyFilters();

                    showToast('Filter periode ' + this.textContent.trim() + ' diterapkan.');
                });
            });

            // Reset filter.
            document.getElementById('resetAudit').addEventListener('click', function() {
                searchInput.value = '';
                hubFilter.value = '';
                typeFilter.value = '';
                statusFilter.value = '';
                selectedDays = 'all';

                dateButtons.forEach(item => item.classList.remove('active'));
                document.querySelector('#dateFilters [data-days="all"]').classList.add('active');

                applyFilters();
                showToast('Semua filter berhasil direset.');
            });

            // Refresh tampilan.
            document.getElementById('refreshAudit').addEventListener('click', function() {
                applyFilters();
                showToast('Tampilan audit berhasil diperbarui.');
            });

            // Ekspor CSV berdasarkan baris yang sedang terlihat.
            document.getElementById('btnExport').addEventListener('click', function() {
                const visibleRows = rows.filter(row => row.style.display !== 'none');

                if (visibleRows.length === 0) {
                    showToast('Tidak ada data untuk diekspor.', 'warning');
                    return;
                }

                const csvRows = [
                    ['ID Audit', 'Tanggal', 'Pengguna', 'Aktivitas', 'Modul', 'Hub', 'Status']
                ];

                visibleRows.forEach(row => {
                    const cells = row.querySelectorAll('td');

                    csvRows.push([
                        cells[0].innerText.trim().replace(/\n/g, ' '),
                        row.dataset.date,
                        cells[1].innerText.trim().replace(/\n/g, ' '),
                        cells[2].innerText.trim().replace(/\n/g, ' '),
                        cells[3].innerText.trim(),
                        row.dataset.hub,
                        row.dataset.status
                    ]);
                });

                const csv = csvRows.map(row =>
                    row.map(value => '"' + String(value).replace(/"/g, '""') + '"').join(',')
                ).join('\n');

                const blob = new Blob(['\uFEFF' + csv], {
                    type: 'text/csv;charset=utf-8;'
                });

                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');

                link.href = url;
                link.download = 'log-audit-astro-inventory.csv';
                document.body.appendChild(link);
                link.click();
                link.remove();

                URL.revokeObjectURL(url);
                showToast('File CSV berhasil disiapkan.');
            });

            // Cetak laporan.
            document.getElementById('btnPrint').addEventListener('click', function() {
                window.print();
            });

            // Salin hash.
            document.getElementById('copyHash').addEventListener('click', async function() {
                const hash = document.getElementById('rootHash').textContent.trim();

                try {
                    await navigator.clipboard.writeText(hash);
                    showToast('Hash berhasil disalin.');
                } catch (error) {
                    const textarea = document.createElement('textarea');
                    textarea.value = hash;
                    document.body.appendChild(textarea);
                    textarea.select();

                    const copied = document.execCommand('copy');
                    textarea.remove();

                    showToast(
                        copied ? 'Hash berhasil disalin.' : 'Hash gagal disalin.',
                        copied ? 'success' : 'error'
                    );
                }
            });

            // Uji SHA-256 pada browser.
            document.getElementById('verifyHash').addEventListener('click', async function() {
                const status = document.getElementById('hashStatus');
                const hashText = document.getElementById('rootHash').textContent.trim();

                if (!window.crypto || !window.crypto.subtle) {
                    status.textContent = 'Browser tidak mendukung Web Crypto API.';
                    showToast('Fitur SHA-256 tidak tersedia pada browser ini.', 'warning');
                    return;
                }

                try {
                    const bytes = new TextEncoder().encode(hashText);
                    const digest = await crypto.subtle.digest('SHA-256', bytes);

                    const result = Array.from(new Uint8Array(digest))
                        .map(byte => byte.toString(16).padStart(2, '0'))
                        .join('');

                    status.textContent = 'SHA-256 berhasil dihitung: ' + result.substring(0, 16) + '...';
                    showToast('Perhitungan SHA-256 berhasil. Ini bukan validasi database.', 'success');
                } catch (error) {
                    status.textContent = 'Pemeriksaan gagal dilakukan.';
                    showToast('Terjadi kesalahan saat menghitung SHA-256.', 'error');
                }
            });

            // Modal detail aktivitas.
            const modal = document.getElementById('detailModal');

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            document.querySelectorAll('.detail-btn').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('modalId').textContent = this.dataset.id;
                    document.getElementById('modalUser').textContent = this.dataset.user;
                    document.getElementById('modalTime').textContent = this.dataset.time;
                    document.getElementById('modalAction').textContent = this.dataset.action;
                    document.getElementById('modalModule').textContent = this.dataset.module;
                    document.getElementById('modalHub').textContent = this.dataset.hub;
                    document.getElementById('modalStatus').textContent = this.dataset.status;
                    document.getElementById('modalDescription').textContent = this.dataset.description;

                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
            });

            document.getElementById('closeModal').addEventListener('click', closeModal);
            document.getElementById('modalDone').addEventListener('click', closeModal);

            modal.addEventListener('click', function(event) {
                if (event.target === modal) closeModal();
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') closeModal();
            });

            // Inisialisasi.
            applyFilters();

        })();
    </script>

</body>

</html>
