<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Keputusan & Log Persetujuan HR - Astro Inventory</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] }, colors: { brand: '#0b49d8', ink: '#17243b', canvas: '#f5f7fc', line: '#e8edf5' } } } };
    </script>
    <style>
        /* Astro Inventory Design System (konsisten dgn dashboard lain) */
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

        ::-webkit-scrollbar { width: 9px; height: 9px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cdd6e4; border-radius: 99px; border: 2px solid #f5f7fb; }
        ::-webkit-scrollbar-thumb:hover { background: #aab8cf; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .anim-fade-up { animation: fadeUp 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
        .anim-fade-in { animation: fadeIn 0.5s ease-out; }

        .metric-card { transition: transform 0.25s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.25s; }
        .metric-card:hover { transform: translateY(-3px); box-shadow: 0 12px 28px -12px rgba(37, 99, 235, 0.22), 0 4px 10px rgba(15, 23, 42, 0.06); }

        .nav-link { transition: all 0.16s ease; }
        .nav-link:hover { background: #f1f5f9; color: #172033; transform: translateX(3px); }
        .nav-link.active { background: var(--brand); color: #fff; font-weight: 600; box-shadow: 0 6px 14px -6px rgba(37, 99, 235, 0.55); }
        .nav-link.active:hover { transform: none; background: var(--brand); }

        .panel { box-shadow: 0 1px 2px rgba(15, 23, 42, 0.05); background: #fff; border: 1px solid #e5e7eb; border-radius: 0.5rem; }
        .badge { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 6px; }

        /* ===== Riwayat Persetujuan (HR): animasi & interaksi khusus ===== */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.6s ease-out; }
        .animate-fade-in-up { animation: fadeInUp 0.5s ease-out; }

        .history-card, .table-row-item { transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); }
        .table-row-item:hover { background-color: #F8FAFC; transform: scale(1.002); }
        .btn-primary { transition: all 0.3s ease; }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25); }
        .tab-filter { transition: all 0.2s ease; }
        .tab-filter:hover { background-color: #EFF6FF; transform: translateY(-1px); }
        .tab-filter.active { background-color: #DBEAFE; border-color: #2563EB; color: #1E40AF; }

        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; } }
    </style>
</head>
<body class="bg-gray-50">

@include('components.navbar')

<div class="flex min-h-screen">
    @include('components.sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-4 lg:p-6 overflow-x-hidden">

        {{-- ================= HR ================= --}}
        @if(auth()->user()->isHR())

        <!-- Page Title & Header Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 animate-fade-in-up" style="animation-delay: 0.1s">
            <div>
                <div class="flex items-center space-x-2 mb-1">
                    <h1 class="text-2xl font-bold text-gray-900">Riwayat Keputusan &amp; Log Persetujuan HR</h1>
                    <span class="bg-blue-50 text-blue-700 border border-blue-200 text-[10px] font-bold px-2 py-0.5 rounded-full flex items-center space-x-1">
                        <i class="fas fa-shield-alt"></i>
                        <span>Audit Trail Aktif</span>
                    </span>
                </div>
                <p class="text-xs text-gray-500">
                    Arsip lengkap keputusan otorisasi transaksi inventaris, audit trail persetujuan mutasi, dan verifikasi rekonsiliasi stok opname.
                </p>
            </div>

            <div class="flex items-center space-x-3 flex-shrink-0">
                <button data-toast="Menyiapkan unduhan Rekap Audit (PDF/Excel)..." class="bg-white border border-gray-300 text-gray-700 px-3 py-2 rounded-lg text-xs font-semibold hover:bg-gray-50 flex items-center space-x-2 shadow-sm transition-all">
                    <i class="fas fa-file-pdf text-red-500"></i>
                    <span>Unduh Rekap Audit (PDF/Excel)</span>
                </button>
                <button data-toast="Panel filter lanjutan dibuka." class="btn-primary bg-blue-600 text-white px-4 py-2 rounded-lg text-xs font-semibold hover:bg-blue-700 flex items-center space-x-2 shadow-sm">
                    <i class="fas fa-filter"></i>
                    <span>Filter Lanjutan</span>
                </button>
            </div>
        </div>

        <!-- 4 Top Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 animate-fade-in-up" style="animation-delay: 0.2s">

            <!-- Card 1 -->
            <div class="metric-card history-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm relative">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-database text-sm"></i>
                    </div>
                    <span class="bg-blue-100 text-blue-700 text-[10px] font-semibold px-2 py-0.5 rounded">
                        Bulan Berjalan
                    </span>
                </div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">TOTAL KEPUTUSAN SELESAI</p>
                <div class="flex items-baseline space-x-1.5 my-1">
                    <h2 class="text-3xl font-extrabold text-gray-900">184</h2>
                    <span class="text-xs text-gray-500 font-medium">Transaksi</span>
                </div>
                <p class="text-xs text-gray-500 font-medium flex items-center space-x-1">
                    <i class="fas fa-check-circle text-blue-500 text-[10px]"></i>
                    <span>100% Tercatat dalam log terdistribusi</span>
                </p>
            </div>

            <!-- Card 2 -->
            <div class="metric-card history-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-green-50 text-green-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                    <span class="text-green-600 text-[10px] font-semibold flex items-center space-x-1">
                        <i class="fas fa-arrow-up"></i>
                        <span>93.5% Rate</span>
                    </span>
                </div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">DISETUJUI (APPROVED)</p>
                <div class="flex items-baseline space-x-1.5 my-1">
                    <h2 class="text-3xl font-extrabold text-gray-900">172</h2>
                    <span class="text-xs text-gray-500 font-medium">Otorisasi SPO Sah</span>
                </div>
                <p class="text-xs text-green-600 font-medium flex items-center space-x-1">
                    <i class="fas fa-check text-[10px]"></i>
                    <span>18 Transaksi tervalidasi hari ini</span>
                </p>
            </div>

            <!-- Card 3 -->
            <div class="metric-card history-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-red-50 text-red-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-times text-sm"></i>
                    </div>
                    <span class="text-red-500 text-[10px] font-semibold">6.5% Reject Rate</span>
                </div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">DITOLAK / DITANGGUHKAN</p>
                <div class="flex items-baseline space-x-1.5 my-1">
                    <h2 class="text-3xl font-extrabold text-gray-900">12</h2>
                    <span class="text-xs text-gray-500 font-medium">Perlu Audit Lanjut</span>
                </div>
                <p class="text-xs text-red-500 font-medium flex items-center space-x-1">
                    <i class="fas fa-exclamation-triangle text-[10px]"></i>
                    <span>Deviasi fisik &amp; kelengkapan SPO</span>
                </p>
            </div>

            <!-- Card 4 -->
            <div class="metric-card history-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-teal-50 text-teal-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-bolt text-sm"></i>
                    </div>
                    <span class="text-teal-600 text-[10px] font-semibold flex items-center space-x-1">
                        <i class="fas fa-check"></i>
                        <span>100% On-Time</span>
                    </span>
                </div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">RATA-RATA RESOLUSI SLA</p>
                <div class="flex items-baseline space-x-1.5 my-1">
                    <h2 class="text-3xl font-extrabold text-gray-900">48</h2>
                    <span class="text-base text-gray-600 font-normal">Menit / Request</span>
                </div>
                <p class="text-xs text-teal-600 font-medium flex items-center space-x-1">
                    <i class="fas fa-bullseye text-[10px]"></i>
                    <span>Target standar &lt; 4 Jam (Optimal)</span>
                </p>
            </div>

        </div>

        <!-- Date Range Selector & Quick Search Row -->
        <div class="bg-white border border-gray-200 rounded-xl p-4 mb-4 shadow-sm animate-fade-in-up" style="animation-delay: 0.3s">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <!-- Left Date Pills -->
                <div id="rangePills" class="flex flex-wrap items-center gap-2">
                    <button class="tab-filter px-3 py-1.5 border-2 border-gray-200 rounded-lg text-xs font-semibold text-gray-600">Hari Ini</button>
                    <button class="tab-filter active px-3 py-1.5 border-2 rounded-lg text-xs font-semibold">7 Hari Terakhir</button>
                    <button class="tab-filter px-3 py-1.5 border-2 border-gray-200 rounded-lg text-xs font-semibold text-gray-600">30 Hari</button>
                    <button class="tab-filter px-3 py-1.5 border-2 border-gray-200 rounded-lg text-xs font-semibold text-gray-600 flex items-center space-x-1" data-toast="Pemilih rentang tanggal kustom dibuka.">
                        <i class="fas fa-calendar-alt text-[11px]"></i>
                        <span>Rentang Kustom</span>
                    </button>
                </div>

                <!-- Right Quick Search Input -->
                <div class="relative w-full sm:w-auto">
                    <input id="qRiwayat" type="text" placeholder="Cari ID transaksi, nomor SPO, atau otorisator..."
                           class="w-full sm:w-72 pl-8 pr-3 py-1.5 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-2.5 top-2.5 text-gray-400 text-xs"></i>
                </div>
            </div>
        </div>

        <!-- Sub Filter Dropdowns Row -->
        <div class="bg-white border border-gray-200 rounded-xl p-3 mb-6 shadow-sm flex flex-wrap items-center justify-between gap-3 animate-fade-in-up" style="animation-delay: 0.35s">
            <div class="flex flex-wrap items-center gap-2.5 text-xs">
                <span class="text-gray-500 font-medium">STATUS:</span>
                <select id="fStatus" class="px-3 py-1.5 border border-gray-300 rounded-lg text-gray-700 font-medium bg-gray-50">
                    <option value="">Semua (184)</option>
                    <option value="disetujui">Disetujui (172)</option>
                    <option value="ditolak">Ditolak (12)</option>
                </select>

                <span class="text-gray-500 font-medium ml-2">TIPE:</span>
                <select id="fTipe" class="px-3 py-1.5 border border-gray-300 rounded-lg text-gray-700 font-medium bg-gray-50">
                    <option value="">Semua Permintaan</option>
                    <option value="mutasi">Mutasi Keluar</option>
                    <option value="opname">Koreksi Stok Opname</option>
                </select>

                <span class="text-gray-500 font-medium ml-2">TERMINAL / HUB:</span>
                <select id="fHub" class="px-3 py-1.5 border border-gray-300 rounded-lg text-gray-700 font-medium bg-gray-50">
                    <option value="">Semua Hub (DC-01 s/d DC-05)</option>
                    <option value="dc01">Cakung DC-01 (Utama)</option>
                    <option value="dc02">Halim DC-02</option>
                    <option value="sby">Surabaya DC-01</option>
                </select>
            </div>

            <div class="flex items-center space-x-3 text-xs">
                <button id="resetFilter" class="text-gray-500 hover:text-gray-700 flex items-center space-x-1">
                    <i class="fas fa-undo text-[10px]"></i>
                    <span>Reset Filter</span>
                </button>
                <button data-toast="Menyiapkan ekspor CSV seluruh riwayat keputusan..." class="text-blue-600 font-semibold hover:underline flex items-center space-x-1">
                    <i class="fas fa-file-csv text-sm"></i>
                    <span>Ekspor CSV</span>
                </button>
            </div>
        </div>

        <!-- Table Header Info & Mode View -->
        <div class="flex items-center justify-between mb-3 px-1 animate-fade-in-up" style="animation-delay: 0.38s">
            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-wider">
                Daftar Transaksi Tervalidasi <span id="cntRiwayat" class="text-gray-400 font-normal normal-case ml-1">Menampilkan 1-6 dari 184 entri</span>
            </h3>
            <div id="modeView" class="flex items-center space-x-2 text-xs text-gray-500">
                <span>Mode Tampilan:</span>
                <button data-view="list" class="p-1.5 bg-blue-50 text-blue-600 rounded border border-blue-200"><i class="fas fa-list"></i></button>
                <button data-view="grid" class="p-1.5 bg-white text-gray-400 rounded border border-gray-200 hover:text-gray-600"><i class="fas fa-th-large"></i></button>
            </div>
        </div>

        <!-- Table Container -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden animate-fade-in-up" style="animation-delay: 0.4s">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                            <th class="py-3 px-4">No. Transaksi &amp; Waktu</th>
                            <th class="py-3 px-4">Jenis Permintaan</th>
                            <th class="py-3 px-4">Ringkasan Item &amp; Qty</th>
                            <th class="py-3 px-4">Rute / Lokasi Hub</th>
                            <th class="py-3 px-4">Keputusan &amp; Otorisator</th>
                            <th class="py-3 px-4">Catatan &amp; Alasan Audit</th>
                            <th class="py-3 px-4 text-center">Aksi &amp; Dokumen</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyRiwayat" class="divide-y divide-gray-100 text-xs">

                        <!-- Row 1 -->
                        <tr class="table-row-item" data-status="disetujui" data-tipe="mutasi" data-hub="dc01">
                            <td class="py-4 px-4 whitespace-nowrap">
                                <a href="#" data-toast="Detail transaksi #MUT-2023-0941 dibuka." class="font-bold text-blue-600 hover:underline">#MUT-2023-0941</a>
                                <p class="text-[10px] text-gray-500 mt-0.5">24 Okt 2025, 14:10 WIB</p>
                                <span class="text-[10px] text-gray-400">SLA: 28 Menit</span>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 font-medium rounded-md flex items-center space-x-1.5 w-fit">
                                    <i class="fas fa-exchange-alt text-[10px]"></i>
                                    <span>Mutasi Keluar</span>
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-bold text-gray-900">Canon 6D DSLR Camera Body</p>
                                <p class="text-[10px] text-gray-500 font-mono mt-0.5">SKU-CAM-6000 &bull; <strong class="text-gray-800">150 Unit</strong></p>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-medium text-gray-800">Cakung DC-01 &rarr; Halim DC-02</p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="bg-green-100 text-green-700 font-bold px-2.5 py-1 rounded-md text-[10px] inline-flex items-center space-x-1 mb-1">
                                    <i class="fas fa-check text-[9px]"></i>
                                    <span>DISETUJUI</span>
                                </span>
                                <p class="text-[10px] text-gray-500">Siti Rahmawati (D-R)</p>
                            </td>
                            <td class="py-4 px-4">
                                <p class="text-xs text-gray-600">Dokumen SPO lengkap, kuota buffer pengirim aman dan tervalidasi sistem.</p>
                                <p class="text-[10px] text-gray-400 font-mono mt-0.5">Ref SPO: #SPO-CKG-8821</p>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-2">
                                    <button data-toast="Detail #MUT-2023-0941 (BAP & SPO) dibuka." class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-xs font-semibold transition-all flex items-center space-x-1">
                                        <i class="fas fa-eye text-[10px]"></i>
                                        <span>Detail</span>
                                    </button>
                                    <button data-toast="Dokumen BAST #MUT-2023-0941 disiapkan untuk unduhan." class="px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded text-xs font-semibold transition-all flex items-center space-x-1">
                                        <i class="fas fa-file-invoice text-[10px]"></i>
                                        <span>BAST</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr class="table-row-item" data-status="ditolak" data-tipe="opname" data-hub="dc01">
                            <td class="py-4 px-4 whitespace-nowrap">
                                <a href="#" data-toast="Detail transaksi #SPO-2023-112 dibuka." class="font-bold text-blue-600 hover:underline">#SPO-2023-112</a>
                                <p class="text-[10px] text-gray-500 mt-0.5">24 Okt 2025, 13:45 WIB</p>
                                <span class="text-[10px] text-gray-400">SLA: 42 Menit</span>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 font-medium rounded-md flex items-center space-x-1.5 w-fit">
                                    <i class="fas fa-clipboard-check text-[10px]"></i>
                                    <span>Koreksi Stok Opname</span>
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-bold text-gray-900">iWatch 4th Gen Smartwatch 44mm</p>
                                <p class="text-[10px] text-red-600 font-mono mt-0.5">SKU-WTC-AP40 &bull; <strong class="font-bold">-3 Unit (Discrepancy)</strong></p>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-medium text-gray-800">Rak B-03 (Elektronik)</p>
                                <p class="text-[10px] text-gray-400">Terminal Cakung DC-01</p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="bg-red-100 text-red-700 font-bold px-2.5 py-1 rounded-md text-[10px] inline-flex items-center space-x-1 mb-1">
                                    <i class="fas fa-times text-[9px]"></i>
                                    <span>DITOLAK</span>
                                </span>
                                <p class="text-[10px] text-gray-500">Siti Rahmawati (D-R)</p>
                            </td>
                            <td class="py-4 px-4">
                                <p class="text-xs text-gray-600">Deviasi fisik melebihi ambang toleransi SPO 4.2. Audit ulang diperlukan sebelum penyesuaian stok disetujui.</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Inspektur: Dewi Anggraini</p>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-2">
                                    <button data-toast="Detail #SPO-2023-112 (berita acara) dibuka." class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-xs font-semibold transition-all flex items-center space-x-1">
                                        <i class="fas fa-eye text-[10px]"></i>
                                        <span>Detail</span>
                                    </button>
                                    <button data-toast="Tiket investigasi deviasi #SPO-2023-112 dibuat." class="px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-600 rounded text-xs font-semibold transition-all flex items-center space-x-1">
                                        <i class="fas fa-search text-[10px]"></i>
                                        <span>Investigasi</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr class="table-row-item" data-status="disetujui" data-tipe="mutasi" data-hub="dc01">
                            <td class="py-4 px-4 whitespace-nowrap">
                                <a href="#" data-toast="Detail transaksi #MUT-2023-0938 dibuka." class="font-bold text-blue-600 hover:underline">#MUT-2023-0938</a>
                                <p class="text-[10px] text-gray-500 mt-0.5">24 Okt 2025, 11:20 WIB</p>
                                <span class="text-[10px] text-gray-400">SLA: 35 Menit</span>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 font-medium rounded-md flex items-center space-x-1.5 w-fit">
                                    <i class="fas fa-exchange-alt text-[10px]"></i>
                                    <span>Mutasi Keluar</span>
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-bold text-gray-900">Drone Quadcopter 4K Ultra Pro</p>
                                <p class="text-[10px] text-gray-500 font-mono mt-0.5">SKU-AVH-4420 &bull; <strong class="text-gray-800">80 Unit</strong></p>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-medium text-gray-800">Cakung DC-01 &rarr; Surabaya DC-02</p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="bg-green-100 text-green-700 font-bold px-2.5 py-1 rounded-md text-[10px] inline-flex items-center space-x-1 mb-1">
                                    <i class="fas fa-check text-[9px]"></i>
                                    <span>DISETUJUI</span>
                                </span>
                                <p class="text-[10px] text-gray-500">Siti Rahmawati (D-R)</p>
                            </td>
                            <td class="py-4 px-4">
                                <p class="text-xs text-gray-600">Transfer logistik rutin antarprovinsi telah melalui verifikasi asuransi ekspedisi.</p>
                                <p class="text-[10px] text-gray-400 font-mono mt-0.5">Ref SPO: #SPO-SBY-901</p>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-2">
                                    <button data-toast="Detail #MUT-2023-0938 (BAP & SPO) dibuka." class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-xs font-semibold transition-all flex items-center space-x-1">
                                        <i class="fas fa-eye text-[10px]"></i>
                                        <span>Detail</span>
                                    </button>
                                    <button data-toast="Dokumen BAST #MUT-2023-0938 disiapkan untuk unduhan." class="px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded text-xs font-semibold transition-all flex items-center space-x-1">
                                        <i class="fas fa-file-invoice text-[10px]"></i>
                                        <span>BAST</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 4 -->
                        <tr class="table-row-item" data-status="disetujui" data-tipe="opname" data-hub="dc01">
                            <td class="py-4 px-4 whitespace-nowrap">
                                <a href="#" data-toast="Detail transaksi #SPO-2023-108 dibuka." class="font-bold text-blue-600 hover:underline">#SPO-2023-108</a>
                                <p class="text-[10px] text-gray-500 mt-0.5">23 Okt 2025, 16:30 WIB</p>
                                <span class="text-[10px] text-gray-400">SLA: 54 Menit</span>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 font-medium rounded-md flex items-center space-x-1.5 w-fit">
                                    <i class="fas fa-clipboard-check text-[10px]"></i>
                                    <span>Koreksi Stok Opname</span>
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-bold text-gray-900">Lensa Nikon 70-200mm VR II</p>
                                <p class="text-[10px] text-red-600 font-mono mt-0.5">SKU-OPT-NIK7 &bull; <strong class="font-bold">-1 Unit (Susut Resmi)</strong></p>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-medium text-gray-800">Rak Optik A-01</p>
                                <p class="text-[10px] text-gray-400">Terminal Cakung DC-01</p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="bg-green-100 text-green-700 font-bold px-2.5 py-1 rounded-md text-[10px] inline-flex items-center space-x-1 mb-1">
                                    <i class="fas fa-check text-[9px]"></i>
                                    <span>DISETUJUI</span>
                                </span>
                                <p class="text-[10px] text-gray-500">Siti Rahmawati (D-R)</p>
                            </td>
                            <td class="py-4 px-4">
                                <p class="text-xs text-gray-600">Kerugian akibat susut lensa ditanggung 100% oleh asuransi pengiriman.</p>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-2">
                                    <button data-toast="Detail #SPO-2023-108 (berita acara) dibuka." class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-xs font-semibold transition-all flex items-center space-x-1">
                                        <i class="fas fa-eye text-[10px]"></i>
                                        <span>Detail</span>
                                    </button>
                                    <button data-toast="Dokumen BAST #SPO-2023-108 disiapkan untuk unduhan." class="px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded text-xs font-semibold transition-all flex items-center space-x-1">
                                        <i class="fas fa-file-invoice text-[10px]"></i>
                                        <span>BAST</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 5 -->
                        <tr class="table-row-item" data-status="disetujui" data-tipe="mutasi" data-hub="dc01">
                            <td class="py-4 px-4 whitespace-nowrap">
                                <a href="#" data-toast="Detail transaksi #MUT-2023-0925 dibuka." class="font-bold text-blue-600 hover:underline">#MUT-2023-0925</a>
                                <p class="text-[10px] text-gray-500 mt-0.5">23 Okt 2025, 10:15 WIB</p>
                                <span class="text-[10px] text-gray-400">SLA: 19 Menit</span>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 font-medium rounded-md flex items-center space-x-1.5 w-fit">
                                    <i class="fas fa-exchange-alt text-[10px]"></i>
                                    <span>Mutasi Keluar</span>
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-bold text-gray-900">Barcode Scanner Zebra TC21</p>
                                <p class="text-[10px] text-gray-500 font-mono mt-0.5">SKU-TT-ZTC21 &bull; <strong class="text-gray-800">200 Unit</strong></p>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-medium text-gray-800">Cakung DC-01 &rarr; Medan DC-04</p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="bg-green-100 text-green-700 font-bold px-2.5 py-1 rounded-md text-[10px] inline-flex items-center space-x-1 mb-1">
                                    <i class="fas fa-check text-[9px]"></i>
                                    <span>DISETUJUI</span>
                                </span>
                                <p class="text-[10px] text-gray-500">Siti Rahmawati (D-R)</p>
                            </td>
                            <td class="py-4 px-4">
                                <p class="text-xs text-gray-600">Pengiriman perlengkapan operasional untuk peluncuran terminal regional Medan.</p>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-2">
                                    <button data-toast="Detail #MUT-2023-0925 (BAP & SPO) dibuka." class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-xs font-semibold transition-all flex items-center space-x-1">
                                        <i class="fas fa-eye text-[10px]"></i>
                                        <span>Detail</span>
                                    </button>
                                    <button data-toast="Dokumen BAST #MUT-2023-0925 disiapkan untuk unduhan." class="px-2.5 py-1 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded text-xs font-semibold transition-all flex items-center space-x-1">
                                        <i class="fas fa-file-invoice text-[10px]"></i>
                                        <span>BAST</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 6 -->
                        <tr class="table-row-item" data-status="ditolak" data-tipe="mutasi" data-hub="dc01">
                            <td class="py-4 px-4 whitespace-nowrap">
                                <a href="#" data-toast="Detail transaksi #MUT-2023-0919 dibuka." class="font-bold text-blue-600 hover:underline">#MUT-2023-0919</a>
                                <p class="text-[10px] text-gray-500 mt-0.5">22 Okt 2025, 15:00 WIB</p>
                                <span class="text-[10px] text-gray-400">SLA: 50 Menit</span>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 font-medium rounded-md flex items-center space-x-1.5 w-fit">
                                    <i class="fas fa-exchange-alt text-[10px]"></i>
                                    <span>Mutasi Keluar</span>
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-bold text-gray-900">Fitbit Charge Smartwatch Gen 5</p>
                                <p class="text-[10px] text-gray-500 font-mono mt-0.5">SKU-NTC-FB55 &bull; <strong class="text-gray-800">60 Unit</strong></p>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-medium text-gray-800">Cakung DC-01 &rarr; Semarang DC-05</p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="bg-red-100 text-red-700 font-bold px-2.5 py-1 rounded-md text-[10px] inline-flex items-center space-x-1 mb-1">
                                    <i class="fas fa-times text-[9px]"></i>
                                    <span>DITOLAK</span>
                                </span>
                                <p class="text-[10px] text-gray-500">Siti Rahmawati (D-R)</p>
                            </td>
                            <td class="py-4 px-4">
                                <p class="text-xs text-gray-600">Buffer stok Cakung DC-01 berada di bawah ambang ROP kritis (&lt;20%), sehingga mutasi dibatalkan.</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Regulasi ROP Guard 1.8</p>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-2">
                                    <button data-toast="Detail #MUT-2023-0919 (BAP & SPO) dibuka." class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-xs font-semibold transition-all flex items-center space-x-1">
                                        <i class="fas fa-eye text-[10px]"></i>
                                        <span>Detail</span>
                                    </button>
                                    <button data-toast="Log ROP Guard 1.8 untuk #MUT-2023-0919 dibuka." class="px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-600 rounded text-xs font-semibold transition-all flex items-center space-x-1">
                                        <i class="fas fa-shield-alt text-[10px]"></i>
                                        <span>Log ROP</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- Table Footer / Pagination -->
            <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-500">
                <div class="flex items-center space-x-2">
                    <span>Baris per halaman:</span>
                    <select class="px-2 py-1 border border-gray-300 rounded bg-white text-gray-700">
                        <option>20</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                    <span>Menampilkan 1-6 dari 184 keputusan tercatat</span>
                </div>

                <div class="flex items-center space-x-1">
                    <span class="text-gray-400 cursor-not-allowed px-2">&lt;</span>
                    <button class="px-2.5 py-1 bg-blue-600 text-white font-bold rounded">1</button>
                    <button data-toast="Halaman 2 dimuat dari arsip keputusan." class="px-2.5 py-1 bg-white border border-gray-200 rounded hover:bg-gray-50">2</button>
                    <button data-toast="Halaman 3 dimuat dari arsip keputusan." class="px-2.5 py-1 bg-white border border-gray-200 rounded hover:bg-gray-50">3</button>
                    <span class="px-2 text-gray-400">...</span>
                    <button data-toast="Halaman 31 dimuat dari arsip keputusan." class="px-2.5 py-1 bg-white border border-gray-200 rounded hover:bg-gray-50">31</button>
                    <button data-toast="Halaman berikutnya dimuat dari arsip keputusan." class="px-2.5 py-1 bg-white border border-gray-200 rounded hover:bg-gray-50">&gt;</button>
                </div>
            </div>
        </div>

        <!-- Bottom 3 Info Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 animate-fade-in-up" style="animation-delay: 0.5s">

            <!-- Info 1 -->
            <div class="metric-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex items-start space-x-3">
                <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-xs flex-shrink-0 mt-0.5">
                    <i class="fas fa-fingerprint"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-900 mb-1">Validasi SPO Terenkripsi</h4>
                    <p class="text-[11px] text-gray-600">
                        Setiap persetujuan menghasilkan checksum SHA-256 yang tersimpan pada modul audit log permanen.
                    </p>
                </div>
            </div>

            <!-- Info 2 -->
            <div class="metric-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex items-start space-x-3">
                <div class="w-8 h-8 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-xs flex-shrink-0 mt-0.5">
                    <i class="fas fa-sync-alt"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-900 mb-1">Sinkronisasi ERP &amp; WMS</h4>
                    <p class="text-[11px] text-gray-600">
                        Alokasi stok pada mutasi disetujui langsung memperbarui status bin dan kartu persediaan riil.
                    </p>
                </div>
            </div>

            <!-- Info 3 -->
            <div class="metric-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex items-start space-x-3">
                <div class="w-8 h-8 bg-red-50 text-red-600 rounded-full flex items-center justify-center text-xs flex-shrink-0 mt-0.5">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-900 mb-1">Prosedur Investigasi Deviasi</h4>
                    <p class="text-[11px] text-gray-600">
                        Status ditolak memicu tiket investigasi otomatis ke tim pengawas lapangan dalam tempo 2x24 jam.
                    </p>
                </div>
            </div>

        </div>
        @endif

        {{-- ================= ROLE LAIN (placeholder) ================= --}}
        @if(!auth()->user()->isHR())
        <div class="panel p-10 text-center anim-fade-up">
            <i class="fas fa-history text-4xl text-gray-300 mb-3"></i>
            <h2 class="text-lg font-bold text-gray-900">Riwayat Keputusan &amp; Log Persetujuan HR</h2>
            <p class="text-sm text-gray-500 mt-1 max-w-md mx-auto">Halaman ini hanya tersedia untuk role HR. Silakan gunakan menu Dashboard untuk pemantauan aktivitas.</p>
        </div>
        @endif

    </main>
</div>

<!-- ============ TOAST ============ -->
<div id="toast-container" style="position:fixed;right:1rem;bottom:1rem;z-index:100;display:flex;flex-direction:column;gap:.5rem"></div>

<script>
/* ============================================================
   Riwayat Persetujuan (HR) — toast, filter, tab, mode tampilan
   ============================================================ */
(function () {
    'use strict';

    /* ---------- Toast ---------- */
    function toast(msg, type) {
        var c = document.getElementById('toast-container');
        var t = document.createElement('div');
        t.className = 'toast ' + (type || '');
        t.style.cssText = 'background:#fff;border:1px solid #e5eeff;border-left:4px solid #2563eb;border-radius:.5rem;padding:.75rem 1rem;box-shadow:0 8px 20px -6px rgba(0,0,0,.2);font-size:.875rem;color:#0b1c30;max-width:340px;animation:fadeIn .2s ease';
        if (type === 'success') t.style.borderLeftColor = '#16a34a';
        if (type === 'warn') t.style.borderLeftColor = '#f59e0b';
        t.textContent = msg;
        c.appendChild(t);
        setTimeout(function () { t.style.opacity = '0'; t.style.transition = 'opacity .3s'; setTimeout(function () { t.remove(); }, 300); }, 3200);
    }
    window.toast = toast;

    if (!document.getElementById('tbodyRiwayat')) return; // role lain tidak punya konten ini

    /* ---------- Filter tabel ---------- */
    var q = document.getElementById('qRiwayat');
    var fStatus = document.getElementById('fStatus');
    var fTipe = document.getElementById('fTipe');
    var fHub = document.getElementById('fHub');
    var rows = Array.prototype.slice.call(document.querySelectorAll('#tbodyRiwayat tr'));
    var cnt = document.getElementById('cntRiwayat');

    function apply() {
        var s = (q.value || '').toLowerCase().trim();
        var n = 0;
        rows.forEach(function (r) {
            var ok = true;
            if (ok && s && r.textContent.toLowerCase().indexOf(s) === -1) ok = false;
            if (ok && fStatus.value && r.getAttribute('data-status') !== fStatus.value) ok = false;
            if (ok && fTipe.value && r.getAttribute('data-tipe') !== fTipe.value) ok = false;
            if (ok && fHub.value && r.getAttribute('data-hub') !== fHub.value) ok = false;
            r.style.display = ok ? '' : 'none';
            if (ok) n++;
        });
        cnt.textContent = 'Menampilkan 1-' + n + ' dari 184 entri' + (n === 0 ? ' — tidak ada yang cocok' : '');
    }
    q.addEventListener('input', apply);
    [fStatus, fTipe, fHub].forEach(function (el) { el.addEventListener('change', apply); });
    document.getElementById('resetFilter').addEventListener('click', function () {
        q.value = ''; fStatus.value = ''; fTipe.value = ''; fHub.value = '';
        apply();
        toast('Filter direset — menampilkan seluruh entri terbaru.', 'success');
    });

    /* ---------- Tab rentang tanggal ---------- */
    var pills = document.querySelectorAll('#rangePills .tab-filter');
    pills.forEach(function (p) {
        p.addEventListener('click', function () {
            pills.forEach(function (x) { x.classList.remove('active'); });
            p.classList.add('active');
            if (p.getAttribute('data-toast')) return; // rentang kustom: pakai toast
            toast('Rentang "' + p.textContent.trim() + '" diterapkan ke daftar riwayat.', 'success');
        });
    });

    /* ---------- Mode tampilan ---------- */
    var modes = document.querySelectorAll('#modeView [data-view]');
    modes.forEach(function (m) {
        m.addEventListener('click', function () {
            modes.forEach(function (x) {
                x.classList.remove('bg-blue-50', 'text-blue-600', 'border-blue-200');
                x.classList.add('bg-white', 'text-gray-400', 'border-gray-200');
            });
            m.classList.remove('bg-white', 'text-gray-400', 'border-gray-200');
            m.classList.add('bg-blue-50', 'text-blue-600', 'border-blue-200');
            toast('Mode tampilan "' + (m.getAttribute('data-view') === 'list' ? 'Tabel' : 'Kartu') + '" aktif.', 'info');
        });
    });

    /* ---------- Toast untuk tombol ber-atribut data-toast ---------- */
    document.querySelectorAll('[data-toast]').forEach(function (b) {
        b.addEventListener('click', function () { toast(b.getAttribute('data-toast'), 'success'); });
    });
})();
</script>

</body>
</html>
