<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Antrean Persetujuan HR - Astro Inventory</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] }, colors: { brand: '#0b49d8', ink: '#17243b', canvas: '#f5f7fc', line: '#e8edf5' } } } };
    </script>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            overflow-x: hidden;
        }

        /* Keyframe Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .animate-fade-in { animation: fadeIn 0.6s ease-out; }
        .animate-fade-in-up { animation: fadeInUp 0.5s ease-out; }
        .animate-fade-in-left { animation: fadeInLeft 0.6s ease-out; }
        .animate-fade-in-right { animation: fadeInRight 0.6s ease-out; }
        .animate-slide-in { animation: slideIn 0.5s ease-out; }
        .pulse-animation { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }

        /* Interactive Elements */
        .queue-card, .table-row-item {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .table-row-item:hover {
            background-color: #F8FAFC;
            transform: scale(1.002);
        }

        .btn-primary {
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .tab-filter {
            transition: all 0.2s ease;
        }

        .tab-filter:hover {
            background-color: #EFF6FF;
            transform: translateY(-1px);
        }

        .tab-filter.active {
            background-color: #DBEAFE;
            border-color: #2563EB;
            color: #1E40AF;
        }

        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; } }
        /* Sidebar nav-link (sama seperti di halaman riwayat-persetujuan) */
.nav-link { transition: all 0.16s ease; }
.nav-link:hover { background: #f1f5f9; color: #172033; transform: translateX(3px); }
.nav-link.active { background: #2563eb; color: #fff; font-weight: 600; box-shadow: 0 6px 14px -6px rgba(37, 99, 235, 0.55); }
.nav-link.active:hover { transform: none; background: #2563eb; }
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

        <!-- Breadcrumb & Realtime Sync Indicator -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 animate-fade-in-up">
            <div class="flex items-center space-x-2 text-xs text-gray-500">
                <a href="#" class="hover:text-blue-600">Beranda</a>
                <i class="fas fa-chevron-right text-[10px]"></i>
                <a href="#" class="hover:text-blue-600">Operasional & Persetujuan</a>
                <i class="fas fa-chevron-right text-[10px]"></i>
                <span class="text-gray-800 font-medium">Antrean Persetujuan</span>
            </div>

            <div class="flex items-center space-x-4 text-xs">
                <span class="text-gray-500 flex items-center space-x-1.5">
                    <i class="fas fa-circle text-green-500 pulse-animation text-[8px]"></i>
                    <span>Sinkronisasi Realtime Terhubung</span>
                </span>
                <span class="text-gray-400">|</span>
                <span class="text-gray-500">Update terakhir: 14:35 WIB</span>
            </div>
        </div>

        <!-- Page Title & Header Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 animate-fade-in-up" style="animation-delay: 0.1s">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Daftar Antrean Persetujuan HR</h1>
                <p class="text-xs text-gray-500 mt-1">
                    Tinjau dan proses otorisasi mutasi barang keluar, penyesuaian stok opname, dan alokasi transfer antar-hub logistik.
                </p>
            </div>

            <div class="flex items-center space-x-3 flex-shrink-0">
                <button class="bg-white border border-gray-300 text-gray-700 px-3 py-2 rounded-lg text-xs font-semibold hover:bg-gray-50 flex items-center space-x-2 shadow-sm transition-all">
                    <i class="fas fa-file-export"></i>
                    <span>Ekspor Data Antrean</span>
                </button>
                <button class="btn-primary bg-blue-600 text-white px-4 py-2 rounded-lg text-xs font-semibold hover:bg-blue-700 flex items-center space-x-2 shadow-sm">
                    <i class="fas fa-check-double"></i>
                    <span>Setujui Terpilih (Batch)</span>
                </button>
            </div>
        </div>

        <!-- 4 Top Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 animate-fade-in-up" style="animation-delay: 0.2s">

            <!-- Card 1 -->
            <div class="queue-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm relative">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-sm"></i>
                    </div>
                    <span class="bg-red-50 text-red-600 text-[10px] font-semibold px-2 py-0.5 rounded-full">
                        3 Butuh Review Segera
                    </span>
                </div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">MENUNGGU PERSETUJUAN</p>
                <div class="flex items-baseline space-x-1.5 my-1">
                    <h2 class="text-3xl font-extrabold text-gray-900">5</h2>
                    <span class="text-xs text-gray-500 font-medium">Permintaan</span>
                </div>
                <p class="text-xs text-red-500 font-medium flex items-center space-x-1">
                    <i class="fas fa-exclamation-circle text-[10px]"></i>
                    <span>3 Transaksi Kritis (&lt; 2 Jam ROP / SLA)</span>
                </p>
            </div>

            <!-- Card 2 -->
            <div class="queue-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-exchange-alt text-sm"></i>
                    </div>
                    <span class="text-indigo-600 text-[10px] font-semibold">Transfer Hub</span>
                </div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">MUTASI KELUAR ANTAR-HUB</p>
                <div class="flex items-baseline space-x-1.5 my-1">
                    <h2 class="text-3xl font-extrabold text-gray-900">3</h2>
                    <span class="text-xs text-gray-500 font-medium">Permintaan</span>
                </div>
                <p class="text-xs text-gray-500 font-medium flex items-center space-x-1">
                    <i class="fas fa-info-circle text-[10px]"></i>
                    <span>Alokasi darurat logistik DC-02 Halim & DC-03</span>
                </p>
            </div>

            <!-- Card 3 -->
            <div class="queue-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-clipboard-check text-sm"></i>
                    </div>
                    <span class="text-amber-600 text-[10px] font-semibold">Audit Fisik</span>
                </div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">PENYESUAIAN STOK (OPNAME)</p>
                <div class="flex items-baseline space-x-1.5 my-1">
                    <h2 class="text-3xl font-extrabold text-gray-900">2</h2>
                    <span class="text-xs text-gray-500 font-medium">Permintaan</span>
                </div>
                <p class="text-xs text-amber-600 font-medium flex items-center space-x-1">
                    <i class="fas fa-exclamation-triangle text-[10px]"></i>
                    <span>Discrepancy audit fisik vs sistem SAP</span>
                </p>
            </div>

            <!-- Card 4 -->
            <div class="queue-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-green-50 text-green-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-bolt text-sm"></i>
                    </div>
                    <span class="text-green-600 text-[10px] font-semibold flex items-center space-x-1">
                        <i class="fas fa-check"></i>
                        <span>98.4% On-Schedule</span>
                    </span>
                </div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">RATA-RATA WAKTU TUNGGU</p>
                <div class="flex items-baseline space-x-1.5 my-1">
                    <h2 class="text-3xl font-extrabold text-gray-900">32</h2>
                    <span class="text-base text-gray-600 font-normal">Menit</span>
                </div>
                <p class="text-xs text-green-600 font-medium flex items-center space-x-1">
                    <i class="fas fa-bullseye text-[10px]"></i>
                    <span>Sesuai target SLA HR Management (&lt; 2 Jam)</span>
                </p>
            </div>

        </div>

        <!-- Filter Tabs & Quick Search Row -->
        <div class="bg-white border border-gray-200 rounded-xl p-4 mb-6 shadow-sm animate-fade-in-up" style="animation-delay: 0.3s">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <!-- Left Filter Tabs -->
                <div class="flex flex-wrap items-center gap-2">
                    <button class="tab-filter active px-3.5 py-2 border-2 rounded-lg text-xs font-semibold flex items-center space-x-2">
                        <span>Semua</span>
                        <span class="bg-blue-600 text-white px-2 py-0.5 rounded-full text-[10px]">5</span>
                    </button>
                    <button class="tab-filter px-3.5 py-2 border-2 border-gray-200 rounded-lg text-xs font-semibold flex items-center space-x-2 text-gray-600">
                        <span>Mutasi Antar-Hub</span>
                        <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full text-[10px]">3</span>
                    </button>
                    <button class="tab-filter px-3.5 py-2 border-2 border-gray-200 rounded-lg text-xs font-semibold flex items-center space-x-2 text-gray-600">
                        <span>Penyesuaian Stok</span>
                        <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full text-[10px]">2</span>
                    </button>
                    <button class="tab-filter px-3.5 py-2 border-2 border-gray-200 rounded-lg text-xs font-semibold flex items-center space-x-2 text-gray-600">
                        <i class="fas fa-fire text-red-500"></i>
                        <span>Prioritas Tinggi</span>
                        <span class="bg-red-100 text-red-600 px-2 py-0.5 rounded-full text-[10px]">2</span>
                    </button>
                </div>

                <!-- Right Search & Dropdowns -->
                <div class="flex flex-wrap items-center gap-2">
                    <div class="relative">
                        <input type="text" placeholder="Cari tiket, SKU, pemohon..."
                               class="w-48 lg:w-56 pl-8 pr-3 py-1.5 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-search absolute left-2.5 top-2.5 text-gray-400 text-xs"></i>
                    </div>
                    <select class="px-3 py-1.5 border border-gray-300 rounded-lg text-xs text-gray-600">
                        <option>Semua Hub Tujuan</option>
                        <option>Hub Halim DC-02</option>
                        <option>Hub Surabaya DC-01</option>
                        <option>Hub Gedebage DC-03</option>
                    </select>
                    <select class="px-3 py-1.5 border border-gray-300 rounded-lg text-xs text-gray-600">
                        <option>Semua Urgensi</option>
                        <option>Kritis</option>
                        <option>Tinggi</option>
                        <option>Normal</option>
                        <option>Rendah</option>
                    </select>
                    <button class="p-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 text-xs">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden animate-fade-in-up" style="animation-delay: 0.4s">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                            <th class="py-3 px-4 w-10">
                                <input type="checkbox" class="w-4 h-4 text-blue-600 rounded">
                            </th>
                            <th class="py-3 px-4">No. Tiket & Tanggal</th>
                            <th class="py-3 px-4">Jenis Permintaan</th>
                            <th class="py-3 px-4">Detail Barang & SKU</th>
                            <th class="py-3 px-4">Alur Transfer / Lokasi</th>
                            <th class="py-3 px-4">Diajukan Oleh</th>
                            <th class="py-3 px-4">Urgensi & SLA</th>
                            <th class="py-3 px-4 text-center">Aksi Cepat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">

                        <!-- Row 1 -->
                        <tr class="table-row-item">
                            <td class="py-4 px-4">
                                <input type="checkbox" class="w-4 h-4 text-blue-600 rounded">
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <a href="#" class="font-bold text-blue-600 hover:underline">#TRX-2025-0891</a>
                                <p class="text-[10px] text-gray-400 mt-0.5">14:20 WIB<br><span class="text-red-500 font-medium">(Hari ini)</span></p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 font-medium rounded-md flex items-center space-x-1.5 w-fit">
                                    <i class="fas fa-exchange-alt text-[10px]"></i>
                                    <span>Mutasi Antar-Hub</span>
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-bold text-gray-900">150 Unit Canon 6D DSLR Body</p>
                                <p class="text-[10px] text-gray-500 font-mono mt-0.5">SKU-CAM-6000 • Bin: WH01-RACK-A4</p>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-medium text-gray-800">Hub Cakung DC-01 &rarr; Hub Halim DC-02</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Alokasi Darurat Ekspedisi</p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <p class="font-bold text-gray-900">Rian Hidayat</p>
                                <p class="text-[10px] text-gray-500">RH Picker / Checker</p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="bg-red-500 text-white font-bold px-2.5 py-1 rounded-md text-[10px] inline-block">
                                    Kritis (Sisa 25 Mnt)
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-2">
                                    <button class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-xs font-semibold transition-all">Tolak</button>
                                    <button class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-semibold shadow-xs transition-all flex items-center space-x-1">
                                        <i class="fas fa-check text-[10px]"></i>
                                        <span>Setujui</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr class="table-row-item">
                            <td class="py-4 px-4">
                                <input type="checkbox" class="w-4 h-4 text-blue-600 rounded">
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <a href="#" class="font-bold text-blue-600 hover:underline">#TRX-2025-0889</a>
                                <p class="text-[10px] text-gray-400 mt-0.5">11:05 WIB<br><span class="text-red-500 font-medium">(Hari ini)</span></p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 font-medium rounded-md flex items-center space-x-1.5 w-fit">
                                    <i class="fas fa-clipboard-check text-[10px]"></i>
                                    <span>Penyesuaian Stok</span>
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-bold text-gray-900">-3 Unit Sandisk SSD 1TB Extreme</p>
                                <p class="text-[10px] text-gray-500 font-mono mt-0.5">#LWIL02918 • Serial Discrepancy</p>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-medium text-gray-800">Rak C-02 (DC-01 Cakung)</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Audit Rutin Fisik Triwulan</p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <p class="font-bold text-gray-900">Dewi Anggraini</p>
                                <p class="text-[10px] text-gray-500">DA Supervisor Audit</p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="bg-amber-500 text-white font-bold px-2.5 py-1 rounded-md text-[10px] inline-block">
                                    Tinggi (Sisa 1 Jam)
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-2">
                                    <button class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-xs font-semibold transition-all">Tolak</button>
                                    <button class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-semibold shadow-xs transition-all flex items-center space-x-1">
                                        <i class="fas fa-check text-[10px]"></i>
                                        <span>Setujui</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr class="table-row-item">
                            <td class="py-4 px-4">
                                <input type="checkbox" class="w-4 h-4 text-blue-600 rounded">
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <a href="#" class="font-bold text-blue-600 hover:underline">#TRX-2025-0885</a>
                                <p class="text-[10px] text-gray-400 mt-0.5">09:30 WIB<br><span class="text-red-500 font-medium">(Hari ini)</span></p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 font-medium rounded-md flex items-center space-x-1.5 w-fit">
                                    <i class="fas fa-exchange-alt text-[10px]"></i>
                                    <span>Mutasi Antar-Hub</span>
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-bold text-gray-900">45 Unit Sony Alpha A7 IV</p>
                                <p class="text-[10px] text-gray-500 font-mono mt-0.5">SKU-CAM-A7 • High Value Goods</p>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-medium text-gray-800">Hub Cakung DC-01 &rarr; Hub Surabaya DC-02</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Jadwal Restock Mingguan</p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <p class="font-bold text-gray-900">Dimas Anggara</p>
                                <p class="text-[10px] text-gray-500">DA Logistik Antar-Hub</p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="bg-blue-100 text-blue-700 font-bold px-2.5 py-1 rounded-md text-[10px] inline-block">
                                    Normal (Sisa 2.5 Jam)
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-2">
                                    <button class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-xs font-semibold transition-all">Tolak</button>
                                    <button class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-semibold shadow-xs transition-all flex items-center space-x-1">
                                        <i class="fas fa-check text-[10px]"></i>
                                        <span>Setujui</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 4 -->
                        <tr class="table-row-item">
                            <td class="py-4 px-4">
                                <input type="checkbox" class="w-4 h-4 text-blue-600 rounded">
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <a href="#" class="font-bold text-blue-600 hover:underline">#TRX-2025-0882</a>
                                <p class="text-[10px] text-gray-400 mt-0.5">08:15 WIB<br><span class="text-red-500 font-medium">(Hari ini)</span></p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 font-medium rounded-md flex items-center space-x-1.5 w-fit">
                                    <i class="fas fa-clipboard-check text-[10px]"></i>
                                    <span>Penyesuaian Stok</span>
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-bold text-gray-900">-1 Unit Nikon Reel Optical Pro X</p>
                                <p class="text-[10px] text-gray-500 font-mono mt-0.5">SKU-CAM-NIK8 • Kemasan Rusak Inbound</p>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-medium text-gray-800">Rak B-05 (DC-01 Cakung)</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Damage Staging Quarantined</p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <p class="font-bold text-gray-900">Budi Setiadi</p>
                                <p class="text-[10px] text-gray-500">BS Checker Inbound</p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="bg-gray-100 text-gray-600 font-bold px-2.5 py-1 rounded-md text-[10px] inline-block">
                                    Rendah (&gt; 4 Jam)
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-2">
                                    <button class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-xs font-semibold transition-all">Tolak</button>
                                    <button class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-semibold shadow-xs transition-all flex items-center space-x-1">
                                        <i class="fas fa-check text-[10px]"></i>
                                        <span>Setujui</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 5 -->
                        <tr class="table-row-item">
                            <td class="py-4 px-4">
                                <input type="checkbox" class="w-4 h-4 text-blue-600 rounded">
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <a href="#" class="font-bold text-blue-600 hover:underline">#TRX-2025-0878</a>
                                <p class="text-[10px] text-gray-400 mt-0.5">Kemarin<br>17:40 WIB</p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 font-medium rounded-md flex items-center space-x-1.5 w-fit">
                                    <i class="fas fa-exchange-alt text-[10px]"></i>
                                    <span>Mutasi Antar-Hub</span>
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-bold text-gray-900">80 Unit iWatch 4th Gen 44mm</p>
                                <p class="text-[10px] text-gray-500 font-mono mt-0.5">SKU-WTC-AP40 • Batch Fast Moving</p>
                            </td>
                            <td class="py-4 px-4">
                                <p class="font-medium text-gray-800">Hub Cakung DC-01 &rarr; Hub Gedebage DC-03</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Alokasi Wilayah Jabar</p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <p class="font-bold text-gray-900">Anita Larasati</p>
                                <p class="text-[10px] text-gray-500">AL Forklift Op / Stager</p>
                            </td>
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="bg-amber-500 text-white font-bold px-2.5 py-1 rounded-md text-[10px] inline-block">
                                    Tinggi (Tersisa 45 Mnt)
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-2">
                                    <button class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-xs font-semibold transition-all">Tolak</button>
                                    <button class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-semibold shadow-xs transition-all flex items-center space-x-1">
                                        <i class="fas fa-check text-[10px]"></i>
                                        <span>Setujui</span>
                                    </button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- Table Footer / Pagination -->
            <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-500">
                <p>Menampilkan 1-5 dari 5 permintaan aktif • Halaman 1 dari 1</p>
                <div class="flex items-center space-x-2">
                    <span class="text-gray-400 cursor-not-allowed">&lt; Sebelumnya</span>
                    <span class="px-3 py-1 bg-blue-600 text-white font-bold rounded">1</span>
                    <span class="text-gray-400 cursor-not-allowed">Selanjutnya &gt;</span>
                </div>
            </div>
        </div>

        <!-- Bottom Standard Notice Banner -->
        <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg flex items-center justify-between shadow-xs animate-fade-in-up" style="animation-delay: 0.5s">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-info text-xs"></i>
                </div>
                <p class="text-xs text-blue-900">
                    <strong>Standar Operasional HR & Dispatcher:</strong> Setiap tiket berstatus <span class="text-red-600 font-bold">Kritis</span> wajib diproses dalam tempo &lt; 30 menit untuk mencegah kendala antrean forklift di dock loading utama Terminal Cakung.
                </p>
            </div>
            <a href="#" class="text-xs font-bold text-blue-600 hover:underline whitespace-nowrap ml-4">Buku Pedoman Otorisasi &gt;</a>
        </div>

        @endif

        {{-- ================= ROLE LAIN (placeholder) ================= --}}
        @if(!auth()->user()->isHR())
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-10 text-center animate-fade-in-up">
            <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
            <h2 class="text-lg font-bold text-gray-900">Daftar Antrean Persetujuan HR</h2>
            <p class="text-sm text-gray-500 mt-1 max-w-md mx-auto">Halaman ini hanya tersedia untuk role HR. Silakan gunakan menu Dashboard untuk pemantauan aktivitas.</p>
        </div>
        @endif

    </main>
</div>

</body>
</html>
