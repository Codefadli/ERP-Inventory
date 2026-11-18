<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok Opname — Kepala Gudang | Astro Inventory</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                        ink: '#17243b',
                        canvas: '#f5f7fc',
                        line: '#e8edf5'
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
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: #172033;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* ================= SCROLLBAR ================= */
        ::-webkit-scrollbar {
            width: 9px;
            height: 9px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cdd6e4;
            border-radius: 99px;
            border: 2px solid #f5f7fb;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #aab8cf;
        }

        /* ================= ANIMASI MASUK HALAMAN ================= */
        @keyframes pageEnter {
            from {
                opacity: 0;
                transform: translateY(22px);
                filter: blur(3px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
                filter: blur(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-enter {
            animation: pageEnter .7s cubic-bezier(.22, 1, .36, 1) both;
        }

        .stagger-item {
            opacity: 0;
            animation: fadeInUp .65s cubic-bezier(.22, 1, .36, 1) forwards;
        }

        .stagger-1 {
            animation-delay: .10s;
        }

        .stagger-2 {
            animation-delay: .20s;
        }

        .stagger-3 {
            animation-delay: .30s;
        }

        .stagger-4 {
            animation-delay: .40s;
        }

        .stagger-5 {
            animation-delay: .50s;
        }

        .stagger-6 {
            animation-delay: .60s;
        }

        .stagger-7 {
            animation-delay: .70s;
        }

        /* ================= KARTU ================= */
        .metric-card,
        .history-card,
        .zone-card,
        .info-card {
            transition: transform .25s cubic-bezier(.22, 1, .36, 1),
                box-shadow .25s ease;
        }

        .metric-card:hover,
        .zone-card:hover,
        .info-card:hover {
            transform: translateY(-3px);
            box-shadow:
                0 12px 28px -12px rgba(37, 99, 235, .22),
                0 4px 10px rgba(15, 23, 42, .06);
        }

        /* ================= PANEL ================= */
        .panel {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 1px 2px rgba(15, 23, 42, .05);
        }

        /* ================= TABEL ================= */
        .table-row-item {
            transition: background-color .2s ease, transform .2s ease;
        }

        .table-row-item:hover {
            background: #f8fafc;
        }

        /* ================= TOMBOL ================= */
        .btn-primary {
            transition: all .25s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, .25);
        }

        /* ================= FILTER ================= */
        .tab-filter {
            transition: all .2s ease;
        }

        .tab-filter:hover {
            background: #eff6ff;
            transform: translateY(-1px);
        }

        .tab-filter.active {
            background: #dbeafe;
            border-color: #2563eb;
            color: #1e40af;
        }

        /* ================= PROGRESS ================= */
        .progress-track {
            height: 7px;
            background: #e5e7eb;
            border-radius: 99px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            border-radius: 99px;
            transition: width .8s ease;
        }

        /* ================= MODAL ================= */
        .modal-overlay {
            animation: fadeIn .2s ease-out;
        }

        .modal-content {
            animation: fadeInUp .3s ease-out;
        }

        /* ================= TOAST ================= */
        .toast-item {
            animation: fadeInUp .25s ease-out;
            transition: opacity .3s ease;
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

            .stagger-item {
                opacity: 1 !important;
            }
        }
    </style>
</head>

<body class="bg-gray-50">

    @include('components.navbar')

    <div class="flex min-h-screen">

        @include('components.sidebar')

        <main class="page-enter flex-1 min-w-0 p-4 lg:p-6 overflow-x-hidden">

            @php
            $zones = [
            [
            'code' => 'WH01-ZA',
            'name' => 'Warehouse 01 - Zone A',
            'description' => 'Elektronik & Komputer',
            'progress' => 96,
            'audited' => 480,
            'total' => 500,
            'color' => 'blue',
            ],
            [
            'code' => 'WH01-ZB',
            'name' => 'Warehouse 01 - Zone B',
            'description' => 'Audio & Accessories',
            'progress' => 100,
            'audited' => 350,
            'total' => 350,
            'color' => 'green',
            ],
            [
            'code' => 'WH02-ZC',
            'name' => 'Warehouse 02 - Zone C',
            'description' => 'Storage & Peripheral',
            'progress' => 40,
            'audited' => 200,
            'total' => 500,
            'color' => 'amber',
            ],
            [
            'code' => 'WH02-ZD',
            'name' => 'Warehouse 02 - Zone D',
            'description' => 'Perangkat Operasional',
            'progress' => 85,
            'audited' => 425,
            'total' => 500,
            'color' => 'indigo',
            ],
            ];

            $opnames = [
            [
            'id' => 'SO-2025-0080',
            'name' => 'Apple MacBook Pro 14" M1 Pro',
            'sku' => 'SKU-LTP-0014',
            'system' => 120,
            'physical' => 118,
            'type' => 'Blind Count',
            'status' => 'Selisih',
            'zone' => 'WH01-ZA',
            'date' => '18 Nov 2026',
            'officer' => 'Andi Pratama',
            'note' => 'Terdapat selisih 2 unit antara stok sistem dan hasil pemeriksaan fisik.',
            ],
            [
            'id' => 'SO-2025-0082',
            'name' => 'SanDisk Extreme Portable SSD 1TB',
            'sku' => 'SKU-SSD-1001',
            'system' => 250,
            'physical' => 250,
            'type' => 'Cycle Count',
            'status' => 'Sesuai',
            'zone' => 'WH02-ZC',
            'date' => '18 Nov 2026',
            'officer' => 'Budi Santoso',
            'note' => 'Jumlah stok fisik sesuai dengan data sistem.',
            ],
            [
            'id' => 'SO-2025-0083',
            'name' => 'Sony WH-1000XM4',
            'sku' => 'SKU-AUD-0044',
            'system' => 64,
            'physical' => 68,
            'type' => 'Blind Count',
            'status' => 'Selisih',
            'zone' => 'WH01-ZB',
            'date' => '18 Nov 2026',
            'officer' => 'Rizky Maulana',
            'note' => 'Ditemukan kelebihan 4 unit pada pemeriksaan fisik.',
            ],
            [
            'id' => 'SO-2025-0084',
            'name' => 'Keychron Q1 Pro',
            'sku' => 'SKU-KBD-0021',
            'system' => 85,
            'physical' => 85,
            'type' => 'Cycle Count',
            'status' => 'Sesuai',
            'zone' => 'WH01-ZB',
            'date' => '18 Nov 2026',
            'officer' => 'Dimas Saputra',
            'note' => 'Stok sesuai dengan pencatatan inventaris.',
            ],
            [
            'id' => 'SO-2025-0085',
            'name' => 'Canon EOS 60D',
            'sku' => 'SKU-CAM-0060',
            'system' => 15,
            'physical' => 14,
            'type' => 'Blind Count',
            'status' => 'Approval',
            'zone' => 'WH01-ZA',
            'date' => '18 Nov 2026',
            'officer' => 'Andi Pratama',
            'note' => 'Menunggu persetujuan koreksi stok dari Kepala Gudang.',
            ],
            [
            'id' => 'SO-2025-0088',
            'name' => 'Zebra TC21',
            'sku' => 'SKU-TC-0021',
            'system' => 40,
            'physical' => 40,
            'type' => 'Cycle Count',
            'status' => 'Sesuai',
            'zone' => 'WH02-ZD',
            'date' => '18 Nov 2026',
            'officer' => 'Fajar Nugraha',
            'note' => 'Pemeriksaan fisik selesai dan tidak ditemukan selisih.',
            ],
            [
            'id' => 'SO-2025-0087',
            'name' => 'Corsair Vengeance DDR5',
            'sku' => 'SKU-RAM-0055',
            'system' => 180,
            'physical' => 180,
            'type' => 'Cycle Count',
            'status' => 'Sesuai',
            'zone' => 'WH02-ZC',
            'date' => '18 Nov 2026',
            'officer' => 'Budi Santoso',
            'note' => 'Hasil penghitungan sesuai dengan stok sistem.',
            ],
            ];

            $detailData = $opnames;
            @endphp

            <!-- ================= HEADER ================= -->
            <div class="stagger-item stagger-1 flex flex-col xl:flex-row xl:items-center justify-between gap-4 mb-6">

                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h1 class="text-2xl font-extrabold text-gray-900">
                            Stok Opname
                        </h1>

                        <span class="bg-blue-50 text-blue-700 border border-blue-200 text-[10px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1">
                            <i class="fas fa-clipboard-check"></i>
                            <span>Inventory Audit</span>
                        </span>
                    </div>

                    <p class="text-xs text-gray-500">
                        Monitoring pemeriksaan stok fisik, rekonsiliasi inventaris, dan validasi selisih barang gudang.
                    </p>

                    <div class="flex items-center gap-2 mt-2 text-[11px] text-gray-400">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                        <i class="fas fa-chevron-right text-[9px]"></i>
                        <span>Inventory</span>
                        <i class="fas fa-chevron-right text-[9px]"></i>
                        <span class="text-blue-600 font-semibold">Stok Opname</span>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <button onclick="showToast('Menyiapkan laporan stok opname...')"
                        class="bg-white border border-gray-300 text-gray-700 px-3 py-2 rounded-lg text-xs font-semibold hover:bg-gray-50 flex items-center gap-2 shadow-sm">
                        <i class="fas fa-file-export text-green-600"></i>
                        Export Laporan
                    </button>

                    <button onclick="openModal('modalTim')"
                        class="btn-primary bg-blue-600 text-white px-4 py-2 rounded-lg text-xs font-semibold hover:bg-blue-700 flex items-center gap-2 shadow-sm">
                        <i class="fas fa-users"></i>
                        Tim Opname
                    </button>
                </div>

            </div>

            <!-- ================= STATISTIK ================= -->
            <div class="stagger-item stagger-2 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

                <div class="metric-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-boxes-stacked"></i>
                        </div>
                        <span class="text-[10px] text-blue-600 bg-blue-50 px-2 py-1 rounded font-semibold">
                            Hari Ini
                        </span>
                    </div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">
                        SKU DIPERIKSA
                    </p>
                    <div class="flex items-baseline gap-2 mt-1">
                        <h2 class="text-3xl font-extrabold text-gray-900">1.845</h2>
                        <span class="text-xs text-gray-500">SKU</span>
                    </div>
                    <p class="text-[11px] text-green-600 mt-2 font-medium">
                        <i class="fas fa-arrow-up mr-1"></i>
                        Aktivitas pemeriksaan berjalan
                    </p>
                </div>

                <div class="metric-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <span class="text-[10px] text-indigo-600 bg-indigo-50 px-2 py-1 rounded font-semibold">
                            Aktif
                        </span>
                    </div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">
                        SESI OPNAME
                    </p>
                    <div class="flex items-baseline gap-2 mt-1">
                        <h2 class="text-3xl font-extrabold text-gray-900">6</h2>
                        <span class="text-xs text-gray-500">Sesi</span>
                    </div>
                    <p class="text-[11px] text-gray-500 mt-2">
                        <i class="fas fa-clock mr-1"></i>
                        Pemeriksaan sedang berlangsung
                    </p>
                </div>

                <div class="metric-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 bg-green-50 text-green-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <span class="text-[10px] text-green-600 bg-green-50 px-2 py-1 rounded font-semibold">
                            Optimal
                        </span>
                    </div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">
                        AKURASI STOK
                    </p>
                    <div class="flex items-baseline gap-2 mt-1">
                        <h2 class="text-3xl font-extrabold text-gray-900">99,2%</h2>
                    </div>
                    <p class="text-[11px] text-green-600 mt-2">
                        <i class="fas fa-check-circle mr-1"></i>
                        Mendekati target 100%
                    </p>
                </div>

                <div class="metric-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 bg-red-50 text-red-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-triangle-exclamation"></i>
                        </div>
                        <span class="text-[10px] text-red-600 bg-red-50 px-2 py-1 rounded font-semibold">
                            Perlu Tindakan
                        </span>
                    </div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">
                        SELISIH STOK
                    </p>
                    <div class="flex items-baseline gap-2 mt-1">
                        <h2 class="text-3xl font-extrabold text-gray-900">5</h2>
                        <span class="text-xs text-gray-500">SKU</span>
                    </div>
                    <p class="text-[11px] text-red-500 mt-2">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Membutuhkan verifikasi
                    </p>
                </div>

            </div>

            <!-- ================= ZONA GUDANG ================= -->
            <div class="stagger-item stagger-3 mb-6">

                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h2 class="text-sm font-bold text-gray-900">
                            Progress Stok Opname per Zona
                        </h2>
                        <p class="text-[11px] text-gray-500 mt-1">
                            Ringkasan penyelesaian pemeriksaan setiap area gudang.
                        </p>
                    </div>

                    <span class="text-[10px] text-gray-400 font-medium">
                        <i class="fas fa-warehouse mr-1"></i>
                        4 Zona Gudang
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

                    @foreach($zones as $zone)
                    @php
                    $progressColor = match($zone['color']) {
                    'green' => 'bg-green-500',
                    'amber' => 'bg-amber-500',
                    'indigo' => 'bg-indigo-500',
                    default => 'bg-blue-600',
                    };

                    $iconColor = match($zone['color']) {
                    'green' => 'bg-green-50 text-green-600',
                    'amber' => 'bg-amber-50 text-amber-600',
                    'indigo' => 'bg-indigo-50 text-indigo-600',
                    default => 'bg-blue-50 text-blue-600',
                    };
                    @endphp

                    <div class="zone-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center {{ $iconColor }}">
                                <i class="fas fa-warehouse"></i>
                            </div>

                            <span class="text-xs font-bold text-gray-800">
                                {{ $zone['progress'] }}%
                            </span>
                        </div>

                        <h3 class="text-xs font-bold text-gray-900">
                            {{ $zone['code'] }}
                        </h3>

                        <p class="text-[10px] text-gray-500 mt-1">
                            {{ $zone['name'] }}
                        </p>

                        <p class="text-[10px] text-gray-400 mt-1">
                            {{ $zone['description'] }}
                        </p>

                        <div class="progress-track mt-4">
                            <div class="progress-bar {{ $progressColor }}"
                                style="width: {{ $zone['progress'] }}%;">
                            </div>
                        </div>

                        <div class="flex justify-between mt-2 text-[10px] text-gray-500">
                            <span>{{ number_format($zone['audited']) }} diperiksa</span>
                            <span>{{ number_format($zone['total']) }} SKU</span>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>

            <!-- ================= FILTER ================= -->
            <div class="stagger-item stagger-4 bg-white border border-gray-200 rounded-xl p-4 mb-4 shadow-sm">

                <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-3">

                    <div class="flex flex-wrap items-center gap-2">

                        <span class="text-[10px] text-gray-500 font-bold">
                            STATUS:
                        </span>

                        <select id="filterStatus"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-xs text-gray-700 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">Semua Status</option>
                            <option value="Sesuai">Sesuai</option>
                            <option value="Selisih">Selisih</option>
                            <option value="Approval">Menunggu Approval</option>
                            <option value="Proses">Dalam Proses Hitung</option>
                        </select>

                        <span class="text-[10px] text-gray-500 font-bold ml-1">
                            TIPE:
                        </span>

                        <select id="filterTipe"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-xs text-gray-700 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">Semua Tipe</option>
                            <option value="Blind Count">Blind Count</option>
                            <option value="Cycle Count">Cycle Count</option>
                        </select>

                        <span class="text-[10px] text-gray-500 font-bold ml-1">
                            ZONA:
                        </span>

                        <select id="filterZona"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-xs text-gray-700 bg-gray-50 focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">Semua Zona</option>
                            @foreach($zones as $zone)
                            <option value="{{ $zone['code'] }}">{{ $zone['code'] }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="flex flex-wrap items-center gap-2">

                        <div class="relative">
                            <input id="searchOpname"
                                type="text"
                                placeholder="Cari ID, SKU, atau nama barang..."
                                class="w-full sm:w-64 pl-9 pr-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                            <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
                        </div>

                        <button id="resetFilter"
                            class="px-3 py-2 text-xs text-gray-500 hover:text-blue-600 font-semibold">
                            <i class="fas fa-undo mr-1"></i>
                            Reset
                        </button>

                    </div>
                </div>

            </div>

            <!-- ================= FILTER CHIPS ================= -->
            <div class="stagger-item stagger-4 flex flex-wrap items-center gap-2 mb-4">

                <button data-chip=""
                    class="tab-filter active border border-blue-200 px-3 py-1.5 rounded-lg text-[11px] font-semibold">
                    Semua Data
                </button>

                <button data-chip="Sesuai"
                    class="tab-filter border border-gray-200 bg-white px-3 py-1.5 rounded-lg text-[11px] font-semibold text-gray-600">
                    <i class="fas fa-check-circle text-green-500 mr-1"></i>
                    Sesuai
                </button>

                <button data-chip="Selisih"
                    class="tab-filter border border-gray-200 bg-white px-3 py-1.5 rounded-lg text-[11px] font-semibold text-gray-600">
                    <i class="fas fa-exclamation-circle text-red-500 mr-1"></i>
                    Selisih
                </button>

                <button data-chip="Proses"
                    class="tab-filter border border-gray-200 bg-white px-3 py-1.5 rounded-lg text-[11px] font-semibold text-gray-600">
                    <i class="fas fa-clock text-amber-500 mr-1"></i>
                    Dalam Proses Hitung
                </button>

                <button data-chip="Approval"
                    class="tab-filter border border-gray-200 bg-white px-3 py-1.5 rounded-lg text-[11px] font-semibold text-gray-600">
                    <i class="fas fa-user-check text-blue-500 mr-1"></i>
                    Menunggu Approval
                </button>

            </div>

            <!-- ================= TABEL ================= -->
            <div class="stagger-item stagger-5 bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 px-4 py-4 border-b border-gray-200">
                    <div>
                        <h2 class="text-sm font-bold text-gray-900">
                            Daftar Pemeriksaan Stok Opname
                        </h2>
                        <p id="resultInfo" class="text-[11px] text-gray-500 mt-1">
                            Menampilkan seluruh data pemeriksaan
                        </p>
                    </div>

                    <span class="text-[10px] text-gray-400">
                        <i class="fas fa-sync-alt mr-1"></i>
                        Data diperbarui secara berkala
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[1050px] text-left border-collapse">

                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-[10px] font-bold text-gray-500 uppercase tracking-wider">
                                <th class="py-3 px-4">ID Opname</th>
                                <th class="py-3 px-4">Informasi Barang</th>
                                <th class="py-3 px-4 text-center">Stok Sistem</th>
                                <th class="py-3 px-4 text-center">Stok Fisik</th>
                                <th class="py-3 px-4">Selisih</th>
                                <th class="py-3 px-4">Tipe Hitung</th>
                                <th class="py-3 px-4">Zona</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="opnameTable" class="divide-y divide-gray-100 text-xs">

                            @foreach($opnames as $item)
                            @php
                            $difference = $item['physical'] - $item['system'];

                            $statusClass = match($item['status']) {
                            'Sesuai' => 'bg-green-100 text-green-700',
                            'Selisih' => 'bg-red-100 text-red-700',
                            'Approval' => 'bg-amber-100 text-amber-700',
                            default => 'bg-blue-100 text-blue-700',
                            };

                            $differenceClass = $difference === 0
                            ? 'text-green-600'
                            : 'text-red-600';
                            @endphp

                            <tr class="table-row-item opname-row"
                                data-id="{{ strtolower($item['id']) }}"
                                data-name="{{ strtolower($item['name']) }}"
                                data-sku="{{ strtolower($item['sku']) }}"
                                data-status="{{ $item['status'] }}"
                                data-type="{{ $item['type'] }}"
                                data-zone="{{ $item['zone'] }}">

                                <td class="py-4 px-4 whitespace-nowrap">
                                    <p class="font-bold text-blue-600">
                                        {{ $item['id'] }}
                                    </p>
                                    <p class="text-[10px] text-gray-400 mt-1">
                                        {{ $item['date'] }}
                                    </p>
                                </td>

                                <td class="py-4 px-4">
                                    <p class="font-bold text-gray-900">
                                        {{ $item['name'] }}
                                    </p>
                                    <p class="text-[10px] text-gray-500 font-mono mt-1">
                                        {{ $item['sku'] }}
                                    </p>
                                </td>

                                <td class="py-4 px-4 text-center font-semibold text-gray-700">
                                    {{ number_format($item['system']) }}
                                </td>

                                <td class="py-4 px-4 text-center font-semibold text-gray-700">
                                    {{ number_format($item['physical']) }}
                                </td>

                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="font-bold {{ $differenceClass }}">
                                        {{ $difference > 0 ? '+' : '' }}{{ $difference }}
                                    </span>
                                    <span class="text-[10px] text-gray-400">Unit</span>
                                </td>

                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-[10px] font-semibold">
                                        {{ $item['type'] }}
                                    </span>
                                </td>

                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="text-gray-700 font-semibold">
                                        {{ $item['zone'] }}
                                    </span>
                                </td>

                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="{{ $statusClass }} px-2.5 py-1 rounded-md text-[10px] font-bold">
                                        {{ $item['status'] === 'Approval' ? 'MENUNGGU APPROVAL' : strtoupper($item['status']) }}
                                    </span>
                                </td>

                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    <button
                                        type="button"
                                        onclick="openDetail('{{ $item['id'] }}')"
                                        class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-[11px] font-semibold transition-all">
                                        <i class="fas fa-eye mr-1"></i>
                                        Detail
                                    </button>
                                </td>

                            </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>

                <!-- PAGINATION -->
                <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">

                    <p id="paginationInfo" class="text-gray-500">
                        Menampilkan data pemeriksaan
                    </p>

                    <div class="flex items-center gap-2">
                        <button id="prevPage"
                            class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </button>

                        <span id="pageNumber" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg font-bold">
                            1
                        </span>

                        <button id="nextPage"
                            class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                </div>

            </div>

            <!-- ================= INFORMASI BAWAH ================= -->
            <div class="stagger-item stagger-6 grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">

                <div class="info-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex items-start gap-3">
                    <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-fingerprint"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-gray-900 mb-1">
                            Audit Trail Tercatat
                        </h3>
                        <p class="text-[11px] text-gray-500 leading-relaxed">
                            Setiap aktivitas pemeriksaan stok dicatat untuk mendukung pelacakan dan pemeriksaan inventaris.
                        </p>
                    </div>
                </div>

                <div class="info-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex items-start gap-3">
                    <div class="w-9 h-9 rounded-full bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-gray-900 mb-1">
                            Rekonsiliasi Persediaan
                        </h3>
                        <p class="text-[11px] text-gray-500 leading-relaxed">
                            Hasil hitung fisik digunakan sebagai dasar pencocokan dengan catatan persediaan sistem.
                        </p>
                    </div>
                </div>

                <div class="info-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex items-start gap-3">
                    <div class="w-9 h-9 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-gray-900 mb-1">
                            Validasi Selisih Stok
                        </h3>
                        <p class="text-[11px] text-gray-500 leading-relaxed">
                            Setiap selisih memerlukan pemeriksaan dan persetujuan sebelum dilakukan koreksi stok.
                        </p>
                    </div>
                </div>

            </div>

            <!-- ================= CATATAN KEBIJAKAN ================= -->
            <div class="stagger-item stagger-7 mt-6 bg-blue-50 border border-blue-100 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-info-circle"></i>
                    </div>

                    <div>
                        <h3 class="text-xs font-bold text-blue-900">
                            Kebijakan Stok Opname
                        </h3>
                        <p class="text-[11px] text-blue-800 mt-1 leading-relaxed">
                            Hasil pemeriksaan fisik yang memiliki perbedaan dengan stok sistem harus melalui proses verifikasi.
                            Koreksi persediaan dilakukan setelah mendapatkan persetujuan dari pihak yang berwenang.
                        </p>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- ================= MODAL TIM ================= -->
    <div id="modalTim"
        class="modal-overlay fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4"
        onclick="if(event.target === this) closeModal('modalTim')">

        <div class="modal-content bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden">

            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Tim Stok Opname</h3>
                    <p class="text-[11px] text-gray-500 mt-1">Personel pemeriksaan inventaris</p>
                </div>

                <button onclick="closeModal('modalTim')"
                    class="text-gray-400 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-5 space-y-3">

                @foreach(['Andi Pratama', 'Budi Santoso', 'Rizky Maulana', 'Dimas Saputra', 'Fajar Nugraha'] as $index => $person)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                            {{ strtoupper(substr($person, 0, 1)) }}
                        </div>

                        <div>
                            <p class="text-xs font-bold text-gray-800">{{ $person }}</p>
                            <p class="text-[10px] text-gray-500">
                                {{ $index === 0 ? 'Koordinator Opname' : 'Petugas Pemeriksa' }}
                            </p>
                        </div>
                    </div>

                    <span class="text-[10px] text-green-600 font-semibold">
                        <i class="fas fa-circle text-[7px] mr-1"></i>
                        Aktif
                    </span>
                </div>
                @endforeach

            </div>

            <div class="px-5 py-3 bg-gray-50 border-t border-gray-200 flex justify-end">
                <button onclick="closeModal('modalTim')"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-semibold hover:bg-blue-700">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <!-- ================= MODAL DETAIL ================= -->
    <div id="modalDetail"
        class="modal-overlay fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4"
        onclick="if(event.target === this) closeModal('modalDetail')">

        <div class="modal-content bg-white rounded-xl shadow-xl w-full max-w-xl overflow-hidden">

            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
                <div>
                    <h3 class="text-sm font-bold text-gray-900">Detail Pemeriksaan Stok</h3>
                    <p class="text-[11px] text-gray-500 mt-1">Informasi hasil stok opname</p>
                </div>

                <button onclick="closeModal('modalDetail')"
                    class="text-gray-400 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div id="detailContent" class="p-5">
                <p class="text-xs text-gray-500">Memuat detail pemeriksaan...</p>
            </div>

            <div class="px-5 py-3 bg-gray-50 border-t border-gray-200 flex justify-end">
                <button onclick="closeModal('modalDetail')"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-xs font-semibold hover:bg-gray-300">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <!-- ================= TOAST ================= -->
    <div id="toast-container"
        class="fixed right-4 bottom-4 z-[100] flex flex-col gap-2">
    </div>

    <script>
        /* ================= DATA DETAIL ================= */
        const SO = @json($detailData);

        /* ================= TOAST ================= */
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');

            const borderColor = type === 'error' ? '#dc2626' :
                type === 'warn' ? '#f59e0b' : '#2563eb';

            toast.className = 'toast-item bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-lg text-xs text-gray-700 max-w-sm';
            toast.style.borderLeft = `4px solid ${borderColor}`;
            toast.textContent = message;

            container.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';

                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);
        }

        window.showToast = showToast;

        /* ================= MODAL ================= */
        function openModal(id) {
            const modal = document.getElementById(id);

            if (!modal) return;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            const modal = document.getElementById(id);

            if (!modal) return;

            modal.classList.add('hidden');
            modal.classList.remove('flex');

            const openedModal = document.querySelector('.modal-overlay.flex');

            if (!openedModal) {
                document.body.style.overflow = '';
            }
        }

        window.openModal = openModal;
        window.closeModal = closeModal;

        /* ================= ESCAPE HTML ================= */
        function escapeHtml(value) {
            return String(value ?? '').replace(/[&<>"']/g, function(char) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                } [char];
            });
        }

        /* ================= DETAIL OPNAME ================= */
        function openDetail(id) {
            const item = SO.find(row => row.id === id);

            if (!item) {
                showToast('Data pemeriksaan tidak ditemukan.', 'error');
                return;
            }

            const difference = Number(item.physical) - Number(item.system);

            const differenceText = difference > 0 ?
                `+${difference} Unit` :
                `${difference} Unit`;

            const statusClass = item.status === 'Sesuai' ?
                'bg-green-100 text-green-700' :
                item.status === 'Selisih' ?
                'bg-red-100 text-red-700' :
                'bg-amber-100 text-amber-700';

            document.getElementById('detailContent').innerHTML = `
                <div class="mb-4">
                    <span class="text-[10px] text-gray-400 font-semibold uppercase">Nomor Pemeriksaan</span>
                    <h3 class="text-lg font-extrabold text-blue-600 mt-1">
                        ${escapeHtml(item.id)}
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-[10px] text-gray-400">Nama Barang</p>
                        <p class="text-xs font-bold text-gray-800 mt-1">
                            ${escapeHtml(item.name)}
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-[10px] text-gray-400">SKU</p>
                        <p class="text-xs font-bold text-gray-800 mt-1">
                            ${escapeHtml(item.sku)}
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-[10px] text-gray-400">Stok Sistem</p>
                        <p class="text-lg font-extrabold text-gray-900 mt-1">
                            ${Number(item.system).toLocaleString('id-ID')}
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-[10px] text-gray-400">Stok Fisik</p>
                        <p class="text-lg font-extrabold text-gray-900 mt-1">
                            ${Number(item.physical).toLocaleString('id-ID')}
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-3 border-y border-gray-100 py-3 mb-4">
                    <div>
                        <p class="text-[10px] text-gray-400">Selisih Stok</p>
                        <p class="text-sm font-extrabold ${difference === 0 ? 'text-green-600' : 'text-red-600'} mt-1">
                            ${escapeHtml(differenceText)}
                        </p>
                    </div>

                    <span class="${statusClass} px-3 py-1.5 rounded-lg text-[10px] font-bold">
                        ${escapeHtml(item.status.toUpperCase())}
                    </span>
                </div>

                <div class="space-y-3">
                    <div>
                        <p class="text-[10px] text-gray-400">Zona Gudang</p>
                        <p class="text-xs font-semibold text-gray-800 mt-1">
                            ${escapeHtml(item.zone)}
                        </p>
                    </div>

                    <div>
                        <p class="text-[10px] text-gray-400">Tipe Pemeriksaan</p>
                        <p class="text-xs font-semibold text-gray-800 mt-1">
                            ${escapeHtml(item.type)}
                        </p>
                    </div>

                    <div>
                        <p class="text-[10px] text-gray-400">Petugas Pemeriksa</p>
                        <p class="text-xs font-semibold text-gray-800 mt-1">
                            ${escapeHtml(item.officer)}
                        </p>
                    </div>

                    <div>
                        <p class="text-[10px] text-gray-400">Catatan Pemeriksaan</p>
                        <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                            ${escapeHtml(item.note)}
                        </p>
                    </div>
                </div>
            `;

            openModal('modalDetail');
        }

        window.openDetail = openDetail;

        /* ================= FILTER DAN PAGINATION ================= */
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchOpname');
            const statusFilter = document.getElementById('filterStatus');
            const typeFilter = document.getElementById('filterTipe');
            const zoneFilter = document.getElementById('filterZona');
            const resetButton = document.getElementById('resetFilter');

            const rows = Array.from(document.querySelectorAll('.opname-row'));
            const chipButtons = document.querySelectorAll('[data-chip]');

            const resultInfo = document.getElementById('resultInfo');
            const paginationInfo = document.getElementById('paginationInfo');
            const pageNumber = document.getElementById('pageNumber');
            const previousButton = document.getElementById('prevPage');
            const nextButton = document.getElementById('nextPage');

            let activeChip = '';
            let currentPage = 1;
            const pageSize = 7;

            function getFilteredRows() {
                const keyword = searchInput.value.toLowerCase().trim();

                return rows.filter(row => {
                    const text = row.textContent.toLowerCase();

                    const matchSearch = !keyword || text.includes(keyword);
                    const matchStatus = !statusFilter.value ||
                        row.dataset.status === statusFilter.value;

                    const matchType = !typeFilter.value ||
                        row.dataset.type === typeFilter.value;

                    const matchZone = !zoneFilter.value ||
                        row.dataset.zone === zoneFilter.value;

                    const matchChip = !activeChip ||
                        row.dataset.status === activeChip;

                    return matchSearch &&
                        matchStatus &&
                        matchType &&
                        matchZone &&
                        matchChip;
                });
            }

            function renderTable() {
                const filteredRows = getFilteredRows();
                const total = filteredRows.length;
                const totalPages = Math.max(1, Math.ceil(total / pageSize));

                if (currentPage > totalPages) {
                    currentPage = totalPages;
                }

                const startIndex = (currentPage - 1) * pageSize;
                const endIndex = Math.min(startIndex + pageSize, total);

                rows.forEach(row => {
                    row.style.display = 'none';
                });

                filteredRows.slice(startIndex, endIndex).forEach(row => {
                    row.style.display = '';
                });

                resultInfo.textContent = total > 0 ?
                    `Menampilkan ${startIndex + 1}-${endIndex} dari ${total} data pemeriksaan` :
                    'Tidak ada data pemeriksaan yang sesuai dengan filter.';

                paginationInfo.textContent = total > 0 ?
                    `Menampilkan ${startIndex + 1}-${endIndex} dari ${total} data` :
                    'Tidak ada data untuk ditampilkan';

                pageNumber.textContent = currentPage;

                previousButton.disabled = currentPage <= 1;
                nextButton.disabled = currentPage >= totalPages || total === 0;
            }

            function resetPageAndRender() {
                currentPage = 1;
                renderTable();
            }

            searchInput.addEventListener('input', resetPageAndRender);
            statusFilter.addEventListener('change', resetPageAndRender);
            typeFilter.addEventListener('change', resetPageAndRender);
            zoneFilter.addEventListener('change', resetPageAndRender);

            chipButtons.forEach(button => {
                button.addEventListener('click', function() {
                    activeChip = this.dataset.chip;

                    chipButtons.forEach(chip => {
                        chip.classList.remove('active');
                        chip.classList.add('bg-white', 'text-gray-600', 'border-gray-200');
                    });

                    this.classList.add('active');
                    this.classList.remove('bg-white', 'text-gray-600', 'border-gray-200');

                    resetPageAndRender();
                });
            });

            resetButton.addEventListener('click', function() {
                searchInput.value = '';
                statusFilter.value = '';
                typeFilter.value = '';
                zoneFilter.value = '';
                activeChip = '';

                chipButtons.forEach(chip => {
                    chip.classList.remove('active');
                    chip.classList.add('bg-white', 'text-gray-600', 'border-gray-200');
                });

                chipButtons[0].classList.add('active');
                chipButtons[0].classList.remove('bg-white', 'text-gray-600', 'border-gray-200');

                currentPage = 1;
                renderTable();

                showToast('Filter berhasil direset.');
            });

            previousButton.addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderTable();
                }
            });

            nextButton.addEventListener('click', function() {
                const totalPages = Math.max(1, Math.ceil(getFilteredRows().length / pageSize));

                if (currentPage < totalPages) {
                    currentPage++;
                    renderTable();
                }
            });

            /* Tutup modal dengan tombol Escape */
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    document.querySelectorAll('.modal-overlay.flex').forEach(modal => {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    });

                    document.body.style.overflow = '';
                }
            });

            renderTable();
        });
    </script>

</body>

</html>
