<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Astro Inventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Astro Inventory Design System */
        :root {
            --brand: #2563eb;
            --brand-dark: #1d4ed8;
            --bg: #f5f7fb;
            --line: #e7ebf2;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif;
            background: var(--bg);
            color: #172033;
            -webkit-font-smoothing: antialiased;
        }

        /* Scrollbar */
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

        /* Entrance Animations */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .anim-fade-up {
            animation: fadeUp 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        .anim-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .anim-slide-in {
            animation: slideIn 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        }

        /* Delay classes */
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }

        /* Cards */
        .metric-card {
            transition: transform 0.25s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.25s;
        }
        .metric-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px -12px rgba(37, 99, 235, 0.22), 0 4px 10px rgba(15, 23, 42, 0.06);
        }

        /* Nav links */
        .nav-link {
            transition: all 0.16s ease;
        }
        .nav-link:hover {
            background: #f1f5f9;
            color: #172033;
            transform: translateX(3px);
        }
        .nav-link.active {
            background: var(--brand);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 6px 14px -6px rgba(37, 99, 235, 0.55);
        }
        .nav-link.active:hover {
            transform: none;
            background: var(--brand);
        }

        /* Pulse animation */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        .badge-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Progress bar */
        @keyframes progressFill {
            from { width: 0; }
        }
        .progress-bar div {
            animation: progressFill 1s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        /* Button ripple */
        @keyframes ripple {
            from {
                opacity: 1;
                transform: scale(0);
            }
            to {
                opacity: 0;
                transform: scale(2);
            }
        }

        /* Panel */
        .panel {
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.05);
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
        }

        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 6px;
        }
    </style>
</head>
<body class="bg-gray-50">

@include('components.navbar')

<div class="flex min-h-screen">
    @include('components.sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-4 lg:p-6 overflow-x-hidden">

        @if(auth()->user()->isSuperAdmin())
        <!-- Super Admin Header -->
        <div class="flex items-center gap-2 text-xs text-gray-500 mb-3 anim-fade-in">
            <span>Beranda</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span class="text-blue-600 font-semibold">Dashboard Admin (Overview)</span>
        </div>

        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-6 anim-fade-up">
            <div class="flex-1">
                <h1 class="text-xl lg:text-2xl font-bold text-gray-900 mb-1">Dasbor Operasional Hub & Inventaris</h1>
                <p class="text-sm text-gray-600">Pemantauan multi-hub terpusat, analitik arus barang, status approval, dan peringatan stok kritis secara real-time.</p>
            </div>
            <div class="flex flex-wrap items-start gap-2">
                <button class="px-3.5 py-2 border border-gray-300 bg-white rounded-lg hover:bg-gray-50 text-sm flex items-center gap-2 transition">
                    <i class="fas fa-download text-blue-600"></i>Unduh Laporan Ringkas
                </button>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm flex items-center gap-2 transition shadow-sm">
                    <i class="fas fa-plus"></i>+ Tambah Barang Baru
                </button>
            </div>
        </div>
        @endif

        @if(auth()->user()->isKepalaGudang())
        <!-- Kepala Gudang Breadcrumb -->
        <div class="flex items-center gap-2 text-xs text-gray-500 mb-3 anim-fade-in">
            <span>Beranda</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span class="text-blue-600 font-semibold">Dashboard Kepala Gudang (Overview)</span>
        </div>

        <!-- Kepala Gudang Header -->
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-6 anim-fade-up">
            <div class="flex-1">
                <h1 class="text-xl lg:text-2xl font-bold text-gray-900 mb-1">Dasbor Operasional Hub & Inventaris</h1>
                <p class="text-sm text-gray-600">Pemantauan multi-hub terpusat, analitik arus barang, status approval, dan peringatan stok kritis secara real-time.</p>
            </div>
            <div class="flex flex-wrap items-start gap-2">
                <button class="px-3.5 py-2 border border-gray-300 bg-white rounded-lg hover:bg-gray-50 text-sm flex items-center gap-2 transition">
                    <i class="fas fa-download text-blue-600"></i>Unduh Laporan Ringkas
                </button>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm flex items-center gap-2 transition shadow-sm">
                    <i class="fas fa-plus"></i>+ Tambah Barang Baru
                </button>
            </div>
        </div>
        @endif

        @if(auth()->user()->isHR())
        <!-- HR Header -->
        <div class="flex items-center space-x-2 text-xs text-gray-500 mb-2 anim-fade-in">
            <a href="#" class="hover:text-blue-600">Beranda</a>
            <i class="fas fa-chevron-right text-[10px]"></i>
            <span class="text-gray-800 font-medium">Dashboard HR (Overview)</span>
        </div>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 anim-fade-up">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Pusat Otorisasi & Dasbor Operasional HR</h1>
                <p class="text-xs text-gray-500 mt-1">
                    Pemantauan antrean persetujuan mutasi, verifikasi selisih stok opname, dan kepatuhan regulasi logistik real-time.
                </p>
            </div>
            <div class="flex items-center space-x-3 flex-shrink-0">
                <button class="bg-white border border-gray-300 text-gray-700 px-3 py-2 rounded-lg text-xs font-semibold hover:bg-gray-50 flex items-center space-x-2 shadow-sm transition-all">
                    <i class="fas fa-download"></i>
                    <span>Unduh Laporan Ringkas</span>
                </button>
                <button class="btn-primary bg-blue-600 text-white px-4 py-2 rounded-lg text-xs font-semibold hover:bg-blue-700 flex items-center space-x-2 shadow-sm">
                    <i class="fas fa-plus"></i>
                    <span>Proses Antrean Tercepat</span>
                </button>
            </div>
        </div>
        @endif

        @if(auth()->user()->isPegawai())
        <!-- Pegawai Breadcrumb -->
        <nav class="flex items-center gap-1.5 text-[11px] tracking-[0.04em] uppercase mb-2 anim-fade-in">
            <span class="text-slate-400 font-semibold">PORTAL OPERASIONAL PEGAWAI</span>
            <i class="fas fa-chevron-right text-[9px] text-slate-300"></i>
            <span class="text-slate-400 font-semibold">DASHBOARD KERJA HARIAN</span>
            <i class="fas fa-chevron-right text-[9px] text-slate-300"></i>
            <span class="text-blue-600 font-bold">HUB-CKG-01</span>
        </nav>

        <!-- Pegawai Header -->
        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4 mb-6 anim-fade-up">
            <div>
                <h1 class="text-[26px] md:text-[30px] font-extrabold text-slate-900 leading-tight">Dashboard Operasional Pegawai</h1>
                <p class="text-[13.5px] text-slate-500 mt-1.5 max-w-3xl">Selamat datang kembali, {{ auth()->user()->nama_lengkap }} (NIK: {{ auth()->user()->nik ?? 'STF-90214' }}). Kelola penanganan fisik barang masuk, barang keluar, pemindaian barcode rak, dan verifikasi stok harian Hub Cakung DC-01.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5 flex-none">
                <button class="inline-flex items-center gap-2 px-4 py-2.5 text-[12.5px] font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all shadow-md shadow-blue-600/30">
                    <i class="fas fa-barcode"></i> Scan Barcode Cepat
                </button>
                <button class="inline-flex items-center gap-2 px-4 py-2.5 text-[12.5px] font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">
                    <i class="fas fa-arrow-down"></i> Input Barang Masuk Baru
                </button>
                <button class="inline-flex items-center gap-2 px-4 py-2.5 text-[12.5px] font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">
                    <i class="fas fa-arrow-up"></i> Permintaan Pengeluaran
                </button>
            </div>
        </div>
        @endif

        @if(auth()->user()->isAuditor())
        <!-- Auditor Breadcrumb -->
        <nav class="flex items-center gap-1.5 text-[11px] tracking-[0.04em] uppercase mb-2 anim-fade-in">
            <span class="text-slate-400 font-semibold">KEPATUHAN & AUDIT</span>
            <i class="fas fa-chevron-right text-[9px] text-slate-300"></i>
            <span class="text-blue-600 font-bold">DASHBOARD AUDIT (OVERVIEW)</span>
        </nav>

        <!-- Auditor Header -->
        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4 mb-6 anim-fade-up">
            <div>
                <h1 class="text-[26px] md:text-[30px] font-extrabold text-slate-900 leading-tight">Dasbor Kepatuhan & Pusat Pemeriksaan Audit</h1>
                <p class="text-[13.5px] text-slate-500 mt-1.5 max-w-3xl">Pemantauan integritas buku inventaris, deviasi stok fisik vs sistem, transparansi mutasi logistik, dan rekam jejak kepatuhan ISO/IEC 27001 Hub Cakung DC-01.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5 flex-none">
                <button class="inline-flex items-center gap-2 px-4 py-2.5 text-[12px] font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all">
                    <i class="fas fa-download"></i> Ekspor Audit Trail (PDF/CSV)
                </button>
                <button class="inline-flex items-center gap-2 px-4 py-2.5 text-[12px] font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all shadow-md shadow-blue-600/30">
                    <i class="fas fa-flask"></i> Mulai Uji Petik Mandiri (Sample Test)
                </button>
            </div>
        </div>
        @endif

        <!-- Metrics Grid -->
        @if(auth()->user()->isSuperAdmin())
        <!-- Super Admin Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6 anim-fade-up">
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-users-gear text-blue-600"></i></div>
                    <span class="badge bg-emerald-50 text-emerald-700"><i class="fas fa-arrow-trend-up"></i>+12% bln lalu</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">TOTAL PENGGUNA & ADMIN</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">1.420</p>
                <p class="text-xs text-gray-500 mt-1"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full inline-block mr-1"></span>18 Admin Hub aktif bertugas</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-box-archive text-blue-600"></i></div>
                    <span class="badge bg-blue-50 text-blue-700"><i class="fas fa-bullseye"></i>99.8% Akurasi</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">SKU AKTIF TERSIMPAN</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">8.650 <span class="text-sm font-semibold text-gray-500">SKU</span></p>
                <p class="text-xs text-emerald-600 mt-1"><i class="fas fa-circle-check"></i> 99.2% Stok Tersedia Siap Alokasi</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center"><i class="fas fa-circle-check text-emerald-600"></i></div>
                    <span class="badge bg-emerald-50 text-emerald-700"><i class="fas fa-arrow-up"></i>+8.4% target</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">BARANG MASUK HARI INI</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">1.240 <span class="text-sm font-semibold text-gray-500">Unit</span></p>
                <p class="text-xs text-gray-500 mt-1"><i class="fas fa-file-lines mr-1"></i>12 Surat Jalan (Surat Jalan Selesai)</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-arrow-up-from-bracket text-blue-600"></i></div>
                    <span class="badge bg-emerald-50 text-emerald-700"><i class="fas fa-rocket"></i>100% Siap</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">BARANG KELUAR HARI INI</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">980 <span class="text-sm font-semibold text-gray-500">Unit</span></p>
                <p class="text-xs text-gray-500 mt-1"><i class="fas fa-truck-fast mr-1"></i>94 Batch Pengiriman Siap Dispatch</p>
            </div>
        </div>

        <!-- Main Content Grid for Super Admin -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-6 anim-fade-up delay-2">
            <!-- LEFT 2 Columns -->
            <div class="xl:col-span-2 space-y-5">
                <!-- Chart Card -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-chart-line text-blue-600 mt-1"></i>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm lg:text-base">Arus Masuk & Keluar Barang Hub</h3>
                                <p class="text-xs text-gray-500">Analisis throughput pergerakan stok harian dalam satuan unit</p>
                            </div>
                        </div>
                        <div class="flex items-center bg-gray-100 rounded-lg p-0.5 text-xs">
                            <button class="px-3 py-1.5 rounded-md font-semibold bg-blue-600 text-white transition">7 Hari Terakhir</button>
                            <button class="px-3 py-1.5 rounded-md font-semibold text-gray-600 hover:text-blue-700 transition">30 Hari</button>
                            <button class="px-3 py-1.5 rounded-md font-semibold text-gray-600 hover:text-blue-700 transition">Bulan Ini</button>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                        <div class="flex items-center gap-4 text-xs">
                            <span class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-blue-600 inline-block"></span>
                                <b>Inbound (Masuk)</b> <span class="text-gray-500">8,420 unit</span>
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-gray-800 inline-block"></span>
                                <b>Outbound (Keluar)</b> <span class="text-gray-500">6,850 unit</span>
                            </span>
                        </div>
                    </div>

                    <!-- Chart Placeholder -->
                    <div class="bg-gray-50 rounded-lg p-8 text-center h-64 flex items-center justify-center">
                        <div>
                            <i class="fas fa-chart-area text-4xl text-gray-300 mb-3"></i>
                            <p class="text-sm text-gray-500">Chart Area - Analisis Throughput</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-4">
                        <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center hover:bg-blue-50 transition cursor-default">
                            <p class="text-[11px] text-gray-500">Rata-rata Harian</p>
                            <p class="font-bold text-gray-900 mt-0.5">1,202 <span class="text-xs font-semibold text-gray-500">Unit/Hari</span></p>
                        </div>
                        <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center hover:bg-blue-50 transition cursor-default">
                            <p class="text-[11px] text-gray-500">Puncak Throughput</p>
                            <p class="font-bold text-blue-600 mt-0.5">Sabtu (1,480 Unit)</p>
                        </div>
                        <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center hover:bg-blue-50 transition cursor-default">
                            <p class="text-[11px] text-gray-500">Efisiensi Docking</p>
                            <p class="font-bold text-emerald-600 mt-0.5">98.4% On-Schedule</p>
                        </div>
                    </div>
                </div>

                <!-- Log Aktivitas -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock-rotate-left text-blue-600"></i>
                            <h3 class="font-bold text-gray-900 text-sm lg:text-base">Log Aktivitas Terkini (User & Admin)</h3>
                        </div>
                        <button class="text-sm font-semibold text-blue-600 hover:text-blue-800 hover:underline transition">
                            Lihat Semua Log <i class="fas fa-arrow-right-long"></i>
                        </button>
                    </div>

                    <div class="space-y-3">
                        <!-- Log Item 1 -->
                        <div class="flex items-start gap-3 p-3 bg-gray-50 border border-gray-100 rounded-xl hover:border-blue-200 hover:bg-blue-50/40 transition">
                            <div class="w-9 h-9 bg-blue-600 rounded-full flex items-center justify-center text-white text-[11px] font-bold flex-shrink-0">BS</div>
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <b class="text-sm text-gray-900">Budi Santoso</b>
                                    <span class="bg-blue-100 text-blue-700 text-[10px] px-2 py-0.5 rounded-full font-semibold">Super Admin</span>
                                    <span class="ml-auto text-[11px] text-gray-400">10 menit yang lalu</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-0.5">
                                    Memproses persetujuan Mutasi Keluar 150 unit <b>[SKU-CAM-8821]</b> menuju <a class="text-blue-600 font-semibold hover:underline" href="#">Hub Halim DC-02</a>.
                                </p>
                                <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                    <span class="bg-emerald-50 text-emerald-700 text-[10px] px-2 py-0.5 rounded-full font-semibold">
                                        <i class="fas fa-check"></i> Mutasi Sukses Disetujui
                                    </span>
                                    <span class="text-[11px] text-blue-600 font-semibold hover:underline cursor-pointer">Ref #MUT-2023-0941</span>
                                </div>
                            </div>
                        </div>

                        <!-- Log Item 2 -->
                        <div class="flex items-start gap-3 p-3 bg-gray-50 border border-gray-100 rounded-xl hover:border-blue-200 hover:bg-blue-50/40 transition">
                            <div class="w-9 h-9 bg-gray-400 rounded-full flex items-center justify-center text-white text-[11px] font-bold flex-shrink-0">RH</div>
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <b class="text-sm text-gray-900">Rian Hidayat</b>
                                    <span class="bg-gray-200 text-gray-700 text-[10px] px-2 py-0.5 rounded-full font-semibold">Admin Keamanan RBAC</span>
                                    <span class="ml-auto text-[11px] text-gray-400">35 menit yang lalu</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-0.5">
                                    Memperbarui hak akses RBAC peran Staf Gudang Lapangan: penambahan modul cetak label QR & barcode scanner.
                                </p>
                                <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                    <span class="bg-slate-100 text-slate-600 text-[10px] px-2 py-0.5 rounded-full font-semibold">Perubahan Hak Akses</span>
                                    <span class="text-[11px] text-gray-500">Audit ID <b class="text-gray-700">#SEC-819</b></span>
                                </div>
                            </div>
                        </div>

                        <!-- Log Item 3 -->
                        <div class="flex items-start gap-3 p-3 bg-gray-50 border border-gray-100 rounded-xl hover:border-blue-200 hover:bg-blue-50/40 transition">
                            <div class="w-9 h-9 bg-indigo-500 rounded-full flex items-center justify-center text-white text-[11px] font-bold flex-shrink-0">DA</div>
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <b class="text-sm text-gray-900">Dewi Anggraini</b>
                                    <span class="bg-indigo-100 text-indigo-700 text-[10px] px-2 py-0.5 rounded-full font-semibold">Supervisor Audit</span>
                                    <span class="ml-auto text-[11px] text-gray-400">1 jam yang lalu</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-0.5">
                                    Menyelesaikan Stok Opname terjadwal di Lorong B3 (Rak Elektronik). Ditemukan selisih -3 unit pada SKU Apple Watch.
                                </p>
                                <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                    <span class="bg-red-100 text-red-700 text-[10px] px-2 py-0.5 rounded-full font-semibold">Discrepancy Logged</span>
                                    <span class="text-[11px] text-gray-500">Opname <b class="text-gray-700">#SO-2023-112</b></span>
                                </div>
                            </div>
                        </div>

                        <!-- Log Item 4 -->
                        <div class="flex items-start gap-3 p-3 bg-gray-50 border border-gray-100 rounded-xl hover:border-blue-200 hover:bg-blue-50/40 transition">
                            <div class="w-9 h-9 bg-orange-400 rounded-full flex items-center justify-center text-white text-[11px] font-bold flex-shrink-0">FK</div>
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <b class="text-sm text-gray-900">Fajar Kurnia</b>
                                    <span class="bg-orange-100 text-orange-700 text-[10px] px-2 py-0.5 rounded-full font-semibold">Inbound Staff</span>
                                    <span class="ml-auto text-[11px] text-gray-400">2 jam yang lalu</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-0.5">
                                    Menerima penerimaan fisik PO-774 dari PT Mitra Logistik Nusantara sejumlah 450 unit perlengkapan optik.
                                </p>
                                <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                    <span class="bg-amber-100 text-amber-700 text-[10px] px-2 py-0.5 rounded-full font-semibold">
                                        <i class="fas fa-box"></i> Penerimaan Selesai
                                    </span>
                                    <span class="text-[11px] text-gray-500">Surat Jalan <b class="text-gray-700">#SJ-90928</b></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT Column -->
            <div class="space-y-5">
                <!-- Stok Kritis -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-2 mb-4">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-triangle-exclamation text-red-500 mt-1"></i>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm lg:text-base">Stok Kritis & Menipis</h3>
                                <p class="text-xs text-gray-500">Stok di bawah Reorder Point (ROP)</p>
                            </div>
                        </div>
                        <span class="bg-red-600 text-white text-[10px] px-2 py-0.5 rounded-full font-semibold">3 Kritis</span>
                    </div>

                    <div class="space-y-4">
                        <!-- Item 1 -->
                        <div>
                            <div class="flex items-start justify-between mb-1">
                                <span class="text-[11px] font-bold text-gray-500 tracking-wide">SKU-CAM-600D</span>
                                <span class="bg-red-100 text-red-700 text-[10px] px-2 py-0.5 rounded-full font-semibold">Sisa 4 Unit</span>
                            </div>
                            <div class="border border-red-100 bg-red-50/40 rounded-xl p-3.5 hover:border-red-300 transition">
                                <p class="font-bold text-gray-900 text-sm">Canon 6D DSLR Camera Body</p>
                                <p class="text-xs text-gray-500 mb-2">Bin: <b class="text-gray-700">WH01-RACK-A4</b></p>
                                <div class="flex items-center justify-between text-[11px] mb-1">
                                    <span class="text-gray-600 font-semibold">Kapasitas Buffer (ROP: 25)</span>
                                    <span class="font-bold text-red-600">16% dari buffer</span>
                                </div>
                                <div class="bg-gray-200 rounded-full h-1.5 w-full">
                                    <div class="h-1.5 bg-red-600 rounded-full" style="width:16%"></div>
                                </div>
                                <button class="mt-3 w-full px-3 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 transition">
                                    <i class="fas fa-warehouse mr-1"></i>Ajukan Restock
                                </button>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div>
                            <div class="flex items-start justify-between mb-1">
                                <span class="text-[11px] font-bold text-gray-500 tracking-wide">SKU-CAM-NIK8</span>
                                <span class="bg-red-100 text-red-700 text-[10px] px-2 py-0.5 rounded-full font-semibold">Sisa 7 Unit</span>
                            </div>
                            <div class="border border-red-100 bg-red-50/40 rounded-xl p-3.5 hover:border-red-300 transition">
                                <p class="font-bold text-gray-900 text-sm">Nikon Reel Optical Pro X</p>
                                <p class="text-xs text-gray-500 mb-2">Bin: <b class="text-gray-700">WH01-RACK-B2</b></p>
                                <div class="flex items-center justify-between text-[11px] mb-1">
                                    <span class="text-gray-600 font-semibold">Kapasitas Buffer (ROP: 30)</span>
                                    <span class="font-bold text-red-600">23% dari buffer</span>
                                </div>
                                <div class="bg-gray-200 rounded-full h-1.5 w-full">
                                    <div class="h-1.5 bg-red-600 rounded-full" style="width:23%"></div>
                                </div>
                                <button class="mt-3 w-full px-3 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 transition">
                                    <i class="fas fa-warehouse mr-1"></i>Ajukan Restock
                                </button>
                            </div>
                        </div>

                        <!-- Item 3 -->
                        <div>
                            <div class="flex items-start justify-between mb-1">
                                <span class="text-[11px] font-bold text-gray-500 tracking-wide">SKU-WTC-AP46</span>
                                <span class="bg-red-100 text-red-700 text-[10px] px-2 py-0.5 rounded-full font-semibold">Sisa 12 Unit</span>
                            </div>
                            <div class="border border-amber-100 bg-amber-50/40 rounded-xl p-3.5 hover:border-amber-300 transition">
                                <p class="font-bold text-gray-900 text-sm leading-snug">iWatch 4th Gen Smartwatch 44mm</p>
                                <p class="text-xs text-gray-500 mb-2">Bin: <b class="text-gray-700">WH01-RACK-C1</b></p>
                                <div class="flex items-center justify-between text-[11px] mb-1">
                                    <span class="text-gray-600 font-semibold">Kapasitas Buffer (ROP: 40)</span>
                                    <span class="font-bold text-amber-600">30% dari buffer</span>
                                </div>
                                <div class="bg-gray-200 rounded-full h-1.5 w-full">
                                    <div class="h-1.5 bg-amber-500 rounded-full" style="width:30%"></div>
                                </div>
                                <button class="mt-3 w-full px-3 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 transition">
                                    <i class="fas fa-warehouse mr-1"></i>Ajukan Restock
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menunggu Persetujuan -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-hourglass-half text-blue-600"></i>
                            <h3 class="font-bold text-gray-900 text-sm lg:text-base">Menunggu Persetujuan</h3>
                        </div>
                        <span class="bg-blue-600 text-white text-[10px] px-2 py-0.5 rounded-full font-semibold">2 Permintaan</span>
                    </div>

                    <div class="space-y-3">
                        <!-- Request 1 -->
                        <div class="border border-blue-100 bg-blue-50/30 rounded-xl p-4">
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <p class="font-bold text-gray-900 text-sm">
                                    <i class="fas fa-right-left text-blue-600 mr-1"></i>Mutasi Antar-Hub
                                </p>
                                <span class="bg-blue-100 text-blue-700 text-[10px] px-2 py-0.5 rounded-full font-semibold">150 Unit</span>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed">
                                Permintaan alokasi darurat dari Hub Cakung DC-01 menuju <b class="text-blue-700">Hub Halim DC-02</b> untuk batch elektronik.
                            </p>
                            <div class="flex items-center justify-between text-[11px] text-gray-500 mt-2">
                                <span>Diajukan: <b class="text-gray-700">Tim Logistik Timur</b></span>
                                <span>Prioritas: <b class="text-red-600">Tinggi</b></span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-3">
                                <button class="px-3 py-2 border border-gray-300 bg-white rounded-lg text-xs font-bold hover:bg-gray-50 transition">Tolak</button>
                                <button class="px-3 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 transition">Setujui</button>
                            </div>
                        </div>

                        <!-- Request 2 -->
                        <div class="border border-blue-100 bg-blue-50/30 rounded-xl p-4">
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <p class="font-bold text-gray-900 text-sm">
                                    <i class="fas fa-file-pen text-blue-600 mr-1"></i>Penyesuaian Stok Opname
                                </p>
                                <span class="bg-red-100 text-red-700 text-[10px] px-2 py-0.5 rounded-full font-semibold">-3 Unit</span>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed">
                                Adjustment write-off selisih fisik pemeriksaan berkala rak B3 pada produk Smartwatch serial SN-880.
                            </p>
                            <div class="flex items-center justify-between text-[11px] text-gray-500 mt-2">
                                <span>Auditor: <b class="text-gray-700">Dewi Anggraini</b></span>
                                <span>Level: <b class="text-gray-700">Write-Off Minor</b></span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-3">
                                <button class="px-3 py-2 border border-gray-300 bg-white rounded-lg text-xs font-bold hover:bg-gray-50 transition">Tolak</button>
                                <button class="px-3 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 transition">Setujui</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(auth()->user()->isKepalaGudang())
        <!-- KPI cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6 anim-fade-up">
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-users-gear text-blue-600"></i></div>
                    <span class="badge bg-emerald-50 text-emerald-700"><i class="fas fa-arrow-trend-up"></i>+12% bln lalu</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">TOTAL PENGGUNA & ADMIN</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">1.420</p>
                <p class="text-xs text-gray-500 mt-1"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full inline-block mr-1"></span>18 Admin Hub aktif bertugas</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-box-archive text-blue-600"></i></div>
                    <span class="badge bg-blue-50 text-blue-700"><i class="fas fa-bullseye"></i>99.8% Akurasi</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">SKU AKTIF TERSIMPAN</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">8.650 <span class="text-sm font-semibold text-gray-500">SKU</span></p>
                <p class="text-xs text-emerald-600 mt-1"><i class="fas fa-circle-check"></i> 99.2% Stok Tersedia Siap Alokasi</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center"><i class="fas fa-circle-check text-emerald-600"></i></div>
                    <span class="badge bg-emerald-50 text-emerald-700"><i class="fas fa-arrow-up"></i>+8.4% target</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">BARANG MASUK HARI INI</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">1.240 <span class="text-sm font-semibold text-gray-500">Unit</span></p>
                <p class="text-xs text-gray-500 mt-1"><i class="fas fa-file-lines mr-1"></i>12 Surat Jalan (Surat Jalan Selesai)</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-arrow-up-from-bracket text-blue-600"></i></div>
                    <span class="badge bg-emerald-50 text-emerald-700"><i class="fas fa-rocket"></i>100% Siap</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">BARANG KELUAR HARI INI</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">980 <span class="text-sm font-semibold text-gray-500">Unit</span></p>
                <p class="text-xs text-gray-500 mt-1"><i class="fas fa-truck-fast mr-1"></i>94 Batch Pengiriman Siap Dispatch</p>
            </div>
        </div>
        @endif

        @if(auth()->user()->isHR())
        <!-- HR Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 anim-fade-up delay-1">
            <!-- Card 1: Menunggu Persetujuan -->
            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm metric-card">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-sm"></i>
                    </div>
                    <span class="bg-red-50 text-red-600 text-[11px] font-semibold px-2 py-0.5 rounded-full flex items-center space-x-1">
                        <i class="fas fa-circle text-[6px]"></i>
                        <span>3 Butuh Review</span>
                    </span>
                </div>
                <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider">MENUNGGU PERSETUJUAN</p>
                <h2 class="text-3xl font-extrabold text-gray-900 my-1">5</h2>
                <p class="text-xs text-red-500 font-medium flex items-center space-x-1">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>3 Kritis (< 2 Jam ROP / SLA)</span>
                </p>
            </div>

            <!-- Card 2: Disetujui Hari Ini -->
            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm metric-card">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-green-50 text-green-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-sm"></i>
                    </div>
                    <span class="text-green-600 text-[11px] font-semibold flex items-center space-x-1">
                        <i class="fas fa-arrow-up"></i>
                        <span>+12% bln lalu</span>
                    </span>
                </div>
                <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider">DISETUJUI HARI INI</p>
                <h2 class="text-3xl font-extrabold text-gray-900 my-1">18</h2>
                <p class="text-xs text-green-600 font-medium flex items-center space-x-1">
                    <i class="fas fa-check"></i>
                    <span>18 Transaksi Tervalidasi SPO</span>
                </p>
            </div>

            <!-- Card 3: Ditolak / Validasi -->
            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm metric-card">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-sm"></i>
                    </div>
                    <span class="text-gray-400 text-[11px]">99.8% Akurasi</span>
                </div>
                <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider">DITOLAK / VALIDASI</p>
                <h2 class="text-3xl font-extrabold text-gray-900 my-1">2</h2>
                <p class="text-xs text-amber-600 font-medium flex items-center space-x-1">
                    <i class="fas fa-info-circle"></i>
                    <span>Deviasi Fisik SPO Dilaporkan</span>
                </p>
            </div>

            <!-- Card 4: Rata-rata SLA Respon -->
            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm metric-card">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-bolt text-sm"></i>
                    </div>
                    <span class="text-green-600 text-[11px] font-semibold flex items-center space-x-1">
                        <i class="fas fa-check"></i>
                        <span>100% Siap</span>
                    </span>
                </div>
                <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider">RATA-RATA SLA RESPON</p>
                <h2 class="text-3xl font-extrabold text-gray-900 my-1">48 <span class="text-base font-normal text-gray-600">Menit</span></h2>
                <p class="text-xs text-teal-600 font-medium flex items-center space-x-1">
                    <i class="fas fa-bullseye"></i>
                    <span>Target < 4 Jam (Kinerja Optimal)</span>
                </p>
            </div>
        </div>

        <!-- HR Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6 anim-fade-up delay-2">
            <!-- Left 2 Columns -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Chart Card -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                        <div>
                            <h3 class="text-base font-bold text-gray-900 flex items-center space-x-2">
                                <i class="fas fa-chart-line text-blue-600"></i>
                                <span>Arus Persetujuan & Mutasi Barang Hub</span>
                            </h3>
                            <p class="text-xs text-gray-500">Analisis throughput pergerakan stok harian dalam satuan unit</p>
                        </div>
                        <!-- Toggle Buttons -->
                        <div class="flex items-center space-x-3 text-xs">
                            <div class="flex items-center space-x-3 border border-gray-200 rounded-lg p-1 bg-gray-50">
                                <button class="px-2.5 py-1 bg-white text-blue-600 font-bold rounded shadow-sm">7 Hari Terakhir</button>
                                <button class="px-2.5 py-1 text-gray-600 hover:text-gray-900">30 Hari</button>
                                <button class="px-2.5 py-1 text-gray-600 hover:text-gray-900">Bulan Ini</button>
                            </div>
                        </div>
                    </div>

                    <!-- Legends -->
                    <div class="flex items-center space-x-6 text-xs mb-4">
                        <span class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 bg-blue-600 rounded-full"></span>
                            <span class="text-gray-700 font-medium">Inbound (Masuk) <strong class="text-gray-900">8.420 unit</strong></span>
                        </span>
                        <span class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 bg-gray-300 rounded-full"></span>
                            <span class="text-gray-700 font-medium">Outbound (Keluar) <strong class="text-gray-900">6.850 unit</strong></span>
                        </span>
                    </div>

                    <!-- Chart Placeholder -->
                    <div class="relative w-full h-56 bg-gradient-to-br from-blue-50/30 to-white rounded-lg border border-gray-100 flex items-center justify-center">
                        <div class="text-center text-gray-400">
                            <i class="fas fa-chart-area text-3xl mb-2"></i>
                            <p class="text-sm">Chart Area - Data Visualization</p>
                        </div>
                    </div>

                    <!-- Bottom Stats -->
                    <div class="grid grid-cols-3 gap-4 border-t border-gray-100 pt-4 mt-4 text-center">
                        <div>
                            <p class="text-[11px] text-gray-400">Rata-rata Harian</p>
                            <p class="text-sm font-bold text-gray-900">1.202 Unit/Hari</p>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-400">Puncak Throughput</p>
                            <p class="text-sm font-bold text-blue-600">Sabtu (1.480 Unit)</p>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-400">Efisiensi Otorisasi</p>
                            <p class="text-sm font-bold text-green-600">98.4% On-Schedule</p>
                        </div>
                    </div>
                </div>

                <!-- Log Aktivitas Terkini -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-gray-900 flex items-center space-x-2">
                            <i class="fas fa-history text-blue-600"></i>
                            <span>Log Aktivitas Terkini (Otorisasi & Mutasi)</span>
                        </h3>
                        <a href="#" class="text-xs text-blue-600 font-semibold hover:underline">Lihat Semua Log &gt;</a>
                    </div>

                    <div class="space-y-4">
                        <!-- Item 1 -->
                        <div class="flex items-start justify-between border-b border-gray-100 pb-3">
                            <div class="flex items-start space-x-3">
                                <div class="w-9 h-9 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold">BS</div>
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs font-bold text-gray-900">Budi Santoso</span>
                                        <span class="bg-blue-100 text-blue-700 text-[10px] px-1.5 py-0.2 rounded font-medium">Super Admin</span>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-0.5">
                                        Memproses persetujuan Mutasi Keluar 150 unit <span class="font-mono text-gray-800">[SKU-CAM-8821]</span> menuju <span class="font-medium text-gray-800">Hub Halim DC-02</span>.
                                    </p>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded font-semibold">Mutasi Sukses Disetujui</span>
                                        <span class="text-[10px] text-gray-400">Ref #MUT-2023-0941</span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-[11px] text-gray-400 whitespace-nowrap">10 menit yang lalu</span>
                        </div>

                        <!-- Item 2 -->
                        <div class="flex items-start justify-between border-b border-gray-100 pb-3">
                            <div class="flex items-start space-x-3">
                                <div class="w-9 h-9 bg-gray-700 rounded-full flex items-center justify-center text-white text-xs font-bold">RH</div>
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs font-bold text-gray-900">Rian Hidayat</span>
                                        <span class="bg-gray-100 text-gray-700 text-[10px] px-1.5 py-0.2 rounded font-medium">Admin Keamanan RBAC</span>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-0.5">
                                        Memperbarui hak akses RBAC peran Staf Gudang Lapangan: penambahan modul cetak label QR & barcode scanner.
                                    </p>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="bg-gray-100 text-gray-700 text-[10px] px-2 py-0.5 rounded font-semibold">Perubahan Hak Akses</span>
                                        <span class="text-[10px] text-gray-400">Audit ID #SEC-819</span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-[11px] text-gray-400 whitespace-nowrap">35 menit yang lalu</span>
                        </div>

                        <!-- Item 3 -->
                        <div class="flex items-start justify-between border-b border-gray-100 pb-3">
                            <div class="flex items-start space-x-3">
                                <div class="w-9 h-9 bg-teal-600 rounded-full flex items-center justify-center text-white text-xs font-bold">DA</div>
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs font-bold text-gray-900">Dewi Anggraini</span>
                                        <span class="bg-teal-100 text-teal-700 text-[10px] px-1.5 py-0.2 rounded font-medium">Supervisor Audit</span>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-0.5">
                                        Menyelesaikan Stok Opname terjadwal di Lorong B3 (Rak Elektronik). Ditemukan selisih -3 unit pada SKU Apple Watch.
                                    </p>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="bg-red-100 text-red-700 text-[10px] px-2 py-0.5 rounded font-semibold">Discrepancy Logged</span>
                                        <span class="text-[10px] text-gray-400">Opname #SO-2023-112</span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-[11px] text-gray-400 whitespace-nowrap">1 jam yang lalu</span>
                        </div>

                        <!-- Item 4 -->
                        <div class="flex items-start justify-between">
                            <div class="flex items-start space-x-3">
                                <div class="w-9 h-9 bg-slate-800 rounded-full flex items-center justify-center text-white text-xs font-bold">FK</div>
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs font-bold text-gray-900">Fajar Kurnia</span>
                                        <span class="bg-gray-100 text-gray-600 text-[10px] px-1.5 py-0.2 rounded font-medium">Inbound Staff</span>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-0.5">
                                        Menerima penerimaan fisik PO-774 dari PT Mitra Logistik Nusantara sejumlah 450 unit perlengkapan optik.
                                    </p>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="bg-blue-100 text-blue-700 text-[10px] px-2 py-0.5 rounded font-semibold">Penerimaan Selesai</span>
                                        <span class="text-[10px] text-gray-400">Surat Jalan #SJ-90928</span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-[11px] text-gray-400 whitespace-nowrap">2 jam yang lalu</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Stok Kritis & Menipis -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 flex items-center space-x-2">
                                <i class="fas fa-exclamation-triangle text-amber-500"></i>
                                <span>Stok Kritis & Menipis</span>
                            </h3>
                            <p class="text-[11px] text-gray-400">Stok di bawah Reorder Point (ROP)</p>
                        </div>
                        <span class="bg-red-100 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded">3 SKU Kritis</span>
                    </div>

                    <div class="space-y-4">
                        <!-- Item 1 -->
                        <div class="border border-gray-100 bg-gray-50/50 rounded-lg p-3">
                            <div class="flex justify-between items-start mb-1">
                                <div>
                                    <span class="text-[10px] text-gray-400 font-mono">SKU - CAM - 6000</span>
                                    <h4 class="text-xs font-bold text-gray-900">Canon 6D DSLR Camera Body</h4>
                                    <p class="text-[10px] text-gray-400">Bin: WH01-RACK-A4</p>
                                </div>
                                <span class="bg-red-100 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded">Sisa 4 Unit</span>
                            </div>
                            <div class="mt-2">
                                <div class="flex justify-between text-[10px] text-gray-500 mb-1">
                                    <span>Kapasitas Buffer (ROP: 25)</span>
                                    <span class="text-red-500 font-bold">16% dari buffer</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 progress-bar">
                                    <div class="bg-red-500 h-1.5 rounded-full" style="width: 16%"></div>
                                </div>
                            </div>
                            <button class="w-full mt-3 py-1.5 border border-blue-200 text-blue-600 bg-blue-50/50 rounded text-xs font-semibold hover:bg-blue-100 transition-all flex items-center justify-center space-x-1">
                                <i class="fas fa-share text-[10px]"></i>
                                <span>Ajukan Restock</span>
                            </button>
                        </div>

                        <!-- Item 2 -->
                        <div class="border border-gray-100 bg-gray-50/50 rounded-lg p-3">
                            <div class="flex justify-between items-start mb-1">
                                <div>
                                    <span class="text-[10px] text-gray-400 font-mono">SKU - CAM - NIK8</span>
                                    <h4 class="text-xs font-bold text-gray-900">Nikon Reel Optical Pro X</h4>
                                    <p class="text-[10px] text-gray-400">Bin: WH01-RACK-B2</p>
                                </div>
                                <span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2 py-0.5 rounded">Sisa 7 Unit</span>
                            </div>
                            <div class="mt-2">
                                <div class="flex justify-between text-[10px] text-gray-500 mb-1">
                                    <span>Kapasitas Buffer (ROP: 30)</span>
                                    <span class="text-amber-600 font-bold">23% dari buffer</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 progress-bar">
                                    <div class="bg-amber-500 h-1.5 rounded-full" style="width: 23%"></div>
                                </div>
                            </div>
                            <button class="w-full mt-3 py-1.5 border border-blue-200 text-blue-600 bg-blue-50/50 rounded text-xs font-semibold hover:bg-blue-100 transition-all flex items-center justify-center space-x-1">
                                <i class="fas fa-share text-[10px]"></i>
                                <span>Ajukan Restock</span>
                            </button>
                        </div>

                        <!-- Item 3 -->
                        <div class="border border-gray-100 bg-gray-50/50 rounded-lg p-3">
                            <div class="flex justify-between items-start mb-1">
                                <div>
                                    <span class="text-[10px] text-gray-400 font-mono">SKU - WAT - APL4</span>
                                    <h4 class="text-xs font-bold text-gray-900">iWatch 4th Gen (Series 4)</h4>
                                    <p class="text-[10px] text-gray-400">Bin: WH02-RACK-C1</p>
                                </div>
                                <span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2 py-0.5 rounded">Sisa 12 Unit</span>
                            </div>
                            <div class="mt-2">
                                <div class="flex justify-between text-[10px] text-gray-500 mb-1">
                                    <span>Kapasitas Buffer (ROP: 40)</span>
                                    <span class="text-amber-600 font-bold">30% dari buffer</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 progress-bar">
                                    <div class="bg-amber-500 h-1.5 rounded-full" style="width: 30%"></div>
                                </div>
                            </div>
                            <button class="w-full mt-3 py-1.5 border border-blue-200 text-blue-600 bg-blue-50/50 rounded text-xs font-semibold hover:bg-blue-100 transition-all flex items-center justify-center space-x-1">
                                <i class="fas fa-share text-[10px]"></i>
                                <span>Ajukan Restock</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menunggu Persetujuan -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-gray-900 flex items-center space-x-2">
                            <i class="fas fa-clipboard-check text-blue-600"></i>
                            <span>Menunggu Persetujuan</span>
                        </h3>
                        <span class="bg-orange-100 text-orange-600 text-[10px] font-bold px-2 py-0.5 rounded badge-pulse">2 Permintaan</span>
                    </div>

                    <div class="space-y-3">
                        <!-- Request 1 -->
                        <div class="border border-blue-100 bg-blue-50/30 rounded-lg p-3">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <span class="bg-blue-600 text-white text-[9px] font-bold px-2 py-0.5 rounded">MUTASI ANTAR-HUB</span>
                                    <h4 class="text-xs font-bold text-gray-900 mt-1">Mutasi 150 Unit ke Hub Halim DC-02</h4>
                                    <p class="text-[10px] text-gray-500 mt-0.5">Pemindahan stok Canon EOS 6D untuk pemenuhan demand wilayah</p>
                                </div>
                                <span class="bg-red-100 text-red-600 text-[9px] font-bold px-1.5 py-0.5 rounded">Prioritas Tinggi</span>
                            </div>
                            <div class="flex items-center justify-between pt-2 border-t border-blue-100">
                                <span class="text-[10px] text-gray-400">Diajukan 45 menit lalu</span>
                                <div class="flex items-center space-x-2">
                                    <button class="px-2 py-1 text-[10px] font-semibold text-red-600 border border-red-200 rounded hover:bg-red-50">Tolak</button>
                                    <button class="px-2 py-1 text-[10px] font-semibold text-white bg-blue-600 rounded hover:bg-blue-700">Setujui</button>
                                </div>
                            </div>
                        </div>

                        <!-- Request 2 -->
                        <div class="border border-amber-100 bg-amber-50/30 rounded-lg p-3">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <span class="bg-amber-600 text-white text-[9px] font-bold px-2 py-0.5 rounded">PENYESUAIAN STOK OPNAME</span>
                                    <h4 class="text-xs font-bold text-gray-900 mt-1">Write-off Selisih -3 Unit Apple Watch</h4>
                                    <p class="text-[10px] text-gray-500 mt-0.5">Auditor: Dewi Anggraini | Ref: #SO-2023-112</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-2 border-t border-amber-100">
                                <span class="text-[10px] text-gray-400">Diajukan 1 jam lalu</span>
                                <div class="flex items-center space-x-2">
                                    <button class="px-2 py-1 text-[10px] font-semibold text-red-600 border border-red-200 rounded hover:bg-red-50">Tolak</button>
                                    <button class="px-2 py-1 text-[10px] font-semibold text-white bg-blue-600 rounded hover:bg-blue-700">Setujui</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(auth()->user()->isKepalaGudang())
        <!-- Kepala Gudang Main Content Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-6">
            <!-- Left 2 Columns -->
            <div class="xl:col-span-2 space-y-5">
                <!-- Chart Card -->
                <div class="panel p-4 lg:p-6 anim-fade-up">
                    <div class="flex flex-wrap items-start justify-between gap-3 mb-1">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-chart-line text-blue-600 mt-1"></i>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm lg:text-base">Arus Masuk & Keluar Barang Hub</h3>
                                <p class="text-xs text-gray-500">Analisis throughput pergerakan stok harian dalam satuan unit</p>
                            </div>
                        </div>
                        <div class="flex items-center bg-gray-100 rounded-lg p-0.5 text-xs">
                            <button class="px-3 py-1.5 rounded-md font-semibold bg-blue-600 text-white transition">7 Hari Terakhir</button>
                            <button class="px-3 py-1.5 rounded-md font-semibold text-gray-600 hover:text-blue-700 transition">30 Hari</button>
                            <button class="px-3 py-1.5 rounded-md font-semibold text-gray-600 hover:text-blue-700 transition">Bulan Ini</button>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-2 mt-2 mb-3">
                        <div class="flex items-center gap-4 text-xs">
                            <span class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-blue-600 inline-block"></span>
                                <b>Inbound (Masuk)</b> <span class="text-gray-500">8.420 unit</span>
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-gray-800 inline-block"></span>
                                <b>Outbound (Keluar)</b> <span class="text-gray-500">6.850 unit</span>
                            </span>
                        </div>
                        <button class="badge bg-slate-100 text-slate-600 border border-slate-200">
                            <i class="fas fa-sliders"></i>Semua Zona DC
                        </button>
                    </div>

                    <!-- Chart Placeholder -->
                    <div class="relative w-full" style="height:300px">
                        <div class="w-full h-full bg-gradient-to-br from-blue-50/30 to-white rounded-lg border border-gray-100 flex items-center justify-center">
                            <div class="text-center text-gray-400">
                                <i class="fas fa-chart-area text-4xl mb-2"></i>
                                <p class="text-sm">Chart Visualization Area</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Stats -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-4">
                        <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center hover:bg-blue-50 transition cursor-default">
                            <p class="text-[11px] text-gray-500">Rata-rata Harian</p>
                            <p class="font-bold text-gray-900 mt-0.5">1.202 <span class="text-xs font-semibold text-gray-500">Unit/Hari</span></p>
                        </div>
                        <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center hover:bg-blue-50 transition cursor-default">
                            <p class="text-[11px] text-gray-500">Puncak Throughput</p>
                            <p class="font-bold text-blue-600 mt-0.5">Sabtu (1.480 Unit)</p>
                        </div>
                        <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center hover:bg-blue-50 transition cursor-default">
                            <p class="text-[11px] text-gray-500">Efisiensi Docking</p>
                            <p class="font-bold text-emerald-600 mt-0.5">98.4% On-Schedule</p>
                        </div>
                    </div>
                </div>

                <!-- Log Aktivitas -->
                <div class="panel p-4 lg:p-6 anim-fade-up">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock-rotate-left text-blue-600"></i>
                            <h3 class="font-bold text-gray-900 text-sm lg:text-base">Log Aktivitas Terkini (User & Admin)</h3>
                        </div>
                        <button class="text-sm font-semibold text-blue-600 hover:text-blue-800 hover:underline transition">
                            Lihat Semua Log <i class="fas fa-arrow-right-long"></i>
                        </button>
                    </div>

                    <div class="space-y-3">
                        <!-- Item 1 -->
                        <div class="flex items-start gap-3 p-3 bg-gray-50 border border-gray-100 rounded-xl hover:border-blue-200 hover:bg-blue-50/40 transition">
                            <div class="w-9 h-9 bg-blue-600 rounded-full flex items-center justify-center text-white text-[11px] font-bold flex-shrink-0">BS</div>
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <b class="text-sm text-gray-900">Budi Santoso</b>
                                    <span class="badge bg-blue-100 text-blue-700 text-[10px]">Super Admin</span>
                                    <span class="ml-auto text-[11px] text-gray-400">10 menit yang lalu</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-0.5">
                                    Memproses persetujuan Mutasi Keluar 150 unit <b>[SKU-CAM-8821]</b> menuju Hub Halim DC-02.
                                </p>
                                <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                    <span class="badge bg-emerald-50 text-emerald-700 text-[10px]"><i class="fas fa-check"></i> Mutasi Sukses Disetujui</span>
                                    <span class="text-[11px] text-blue-600 font-semibold">Ref #MUT-2023-0941</span>
                                </div>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div class="flex items-start gap-3 p-3 bg-gray-50 border border-gray-100 rounded-xl hover:border-blue-200 hover:bg-blue-50/40 transition">
                            <div class="w-9 h-9 bg-gray-400 rounded-full flex items-center justify-center text-white text-[11px] font-bold flex-shrink-0">RH</div>
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <b class="text-sm text-gray-900">Rian Hidayat</b>
                                    <span class="badge bg-gray-200 text-gray-700 text-[10px]">Admin Keamanan RBAC</span>
                                    <span class="ml-auto text-[11px] text-gray-400">35 menit yang lalu</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-0.5">
                                    Memperbarui hak akses RBAC peran Staf Gudang Lapangan: penambahan modul cetak label QR & barcode scanner.
                                </p>
                                <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                    <span class="badge bg-slate-100 text-slate-600 text-[10px]">Perubahan Hak Akses</span>
                                    <span class="text-[11px] text-gray-500">Audit ID <b class="text-gray-700">#SEC-819</b></span>
                                </div>
                            </div>
                        </div>

                        <!-- Item 3 -->
                        <div class="flex items-start gap-3 p-3 bg-gray-50 border border-gray-100 rounded-xl hover:border-blue-200 hover:bg-blue-50/40 transition">
                            <div class="w-9 h-9 bg-indigo-500 rounded-full flex items-center justify-center text-white text-[11px] font-bold flex-shrink-0">DA</div>
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <b class="text-sm text-gray-900">Dewi Anggraini</b>
                                    <span class="badge bg-indigo-100 text-indigo-700 text-[10px]">Supervisor Audit</span>
                                    <span class="ml-auto text-[11px] text-gray-400">1 jam yang lalu</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-0.5">
                                    Menyelesaikan Stok Opname terjadwal di Lorong B3 (Rak Elektronik). Ditemukan selisih -3 unit pada SKU Apple Watch.
                                </p>
                                <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                    <span class="badge bg-red-100 text-red-700 text-[10px]">Discrepancy Logged</span>
                                    <span class="text-[11px] text-gray-500">Opname <b class="text-gray-700">#SO-2023-112</b></span>
                                </div>
                            </div>
                        </div>

                        <!-- Item 4 -->
                        <div class="flex items-start gap-3 p-3 bg-gray-50 border border-gray-100 rounded-xl hover:border-blue-200 hover:bg-blue-50/40 transition">
                            <div class="w-9 h-9 bg-orange-400 rounded-full flex items-center justify-center text-white text-[11px] font-bold flex-shrink-0">FK</div>
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <b class="text-sm text-gray-900">Fajar Kurnia</b>
                                    <span class="badge bg-orange-100 text-orange-700 text-[10px]">Inbound Staff</span>
                                    <span class="ml-auto text-[11px] text-gray-400">2 jam yang lalu</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-0.5">
                                    Menerima penerimaan fisik PO-774 dari PT Mitra Logistik Nusantara sejumlah 450 unit perlengkapan optik.
                                </p>
                                <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                    <span class="badge bg-amber-100 text-amber-700 text-[10px]"><i class="fas fa-box"></i> Penerimaan Selesai</span>
                                    <span class="text-[11px] text-gray-500">Surat Jalan <b class="text-gray-700">#SJ-90928</b></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-5">
                <!-- Stok Kritis -->
                <div class="panel p-4 lg:p-5 anim-fade-up">
                    <div class="flex items-start justify-between gap-2 mb-4">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-triangle-exclamation text-red-500 mt-1"></i>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm lg:text-base">Stok Kritis & Menipis</h3>
                                <p class="text-xs text-gray-500">Stok di bawah Reorder Point (ROP)</p>
                            </div>
                        </div>
                        <span class="badge bg-red-600 text-white text-[10px]">3 SKU Kritis</span>
                    </div>

                    <div class="space-y-2">
                        <!-- Item 1 -->
                        <div class="flex items-start justify-between mb-1">
                            <span class="text-[11px] font-bold text-gray-500 tracking-wide">SKU-CAM-600D</span>
                            <span class="badge bg-red-100 text-red-700 text-[10px]">Sisa 4 Unit</span>
                        </div>
                        <div class="border border-red-100 bg-red-50/40 rounded-xl p-3.5 hover:border-red-300 transition">
                            <p class="font-bold text-gray-900 text-sm">Canon 6D DSLR Camera Body</p>
                            <p class="text-xs text-gray-500 mb-2">Bin: <b class="text-gray-700">WH01-RACK-A4</b></p>
                            <div class="flex items-center justify-between text-[11px] mb-1">
                                <span class="text-gray-600 font-semibold">Kapasitas Buffer (ROP: 25)</span>
                                <span class="font-bold text-red-600">16% dari buffer</span>
                            </div>
                            <div class="progress-bar bg-gray-200 rounded-full h-1.5 w-full">
                                <div class="h-1.5 bg-red-600 rounded-full" style="width: 16%"></div>
                            </div>
                            <button class="mt-3 w-full px-3 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 transition">
                                <i class="fas fa-warehouse mr-1"></i>Ajukan Restock
                            </button>
                        </div>

                        <!-- Item 2 -->
                        <div class="flex items-start justify-between mb-1 mt-4">
                            <span class="text-[11px] font-bold text-gray-500 tracking-wide">SKU-CAM-NIK8</span>
                            <span class="badge bg-red-100 text-red-700 text-[10px]">Sisa 7 Unit</span>
                        </div>
                        <div class="border border-red-100 bg-red-50/40 rounded-xl p-3.5 hover:border-red-300 transition">
                            <p class="font-bold text-gray-900 text-sm">Nikon Reel Optical Pro X</p>
                            <p class="text-xs text-gray-500 mb-2">Bin: <b class="text-gray-700">WH01-RACK-B2</b></p>
                            <div class="flex items-center justify-between text-[11px] mb-1">
                                <span class="text-gray-600 font-semibold">Kapasitas Buffer (ROP: 30)</span>
                                <span class="font-bold text-red-600">23% dari buffer</span>
                            </div>
                            <div class="progress-bar bg-gray-200 rounded-full h-1.5 w-full">
                                <div class="h-1.5 bg-red-600 rounded-full" style="width: 23%"></div>
                            </div>
                            <button class="mt-3 w-full px-3 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 transition">
                                <i class="fas fa-warehouse mr-1"></i>Ajukan Restock
                            </button>
                        </div>

                        <!-- Item 3 -->
                        <div class="flex items-start justify-between mb-1 mt-4">
                            <span class="text-[11px] font-bold text-gray-500 tracking-wide">SKU-WTC-AP46</span>
                            <span class="badge bg-red-100 text-red-700 text-[10px]">Sisa 12 Unit</span>
                        </div>
                        <div class="border border-amber-100 bg-amber-50/40 rounded-xl p-3.5 hover:border-amber-300 transition">
                            <p class="font-bold text-gray-900 text-sm leading-snug">iWatch 4th Gen Smartwatch 44mm</p>
                            <p class="text-xs text-gray-500 mb-2">Bin: <b class="text-gray-700">WH01-RACK-C1</b></p>
                            <div class="flex items-center justify-between text-[11px] mb-1">
                                <span class="text-gray-600 font-semibold">Kapasitas Buffer (ROP: 40)</span>
                                <span class="font-bold text-amber-600">30% dari buffer</span>
                            </div>
                            <div class="progress-bar bg-gray-200 rounded-full h-1.5 w-full">
                                <div class="h-1.5 bg-amber-500 rounded-full" style="width: 30%"></div>
                            </div>
                            <button class="mt-3 w-full px-3 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 transition">
                                <i class="fas fa-warehouse mr-1"></i>Ajukan Restock
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menunggu Persetujuan -->
                <div class="panel p-4 lg:p-5 anim-fade-up">
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-hourglass-half text-blue-600"></i>
                            <h3 class="font-bold text-gray-900 text-sm lg:text-base">Menunggu Persetujuan</h3>
                        </div>
                        <span class="badge bg-blue-600 text-white text-[10px]">2 Permintaan</span>
                    </div>

                    <div class="space-y-3">
                        <!-- Request 1 -->
                        <div class="border border-blue-100 bg-blue-50/30 rounded-xl p-4">
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <p class="font-bold text-gray-900 text-sm">
                                    <i class="fas fa-right-left text-blue-600 mr-1"></i>Mutasi Antar-Hub
                                </p>
                                <span class="badge bg-blue-100 text-blue-700 text-[10px]">150 Unit</span>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed">
                                Permintaan alokasi darurat dari Hub Cakung DC-01 menuju <b class="text-blue-700">Hub Halim DC-02</b> untuk batch elektronik.
                            </p>
                            <div class="flex items-center justify-between text-[11px] text-gray-500 mt-2">
                                <span>Diajukan: <b class="text-gray-700">Tim Logistik Timur</b></span>
                                <span>Prioritas: <b class="text-red-600">Tinggi</b></span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-3">
                                <button class="px-3 py-2 border border-gray-300 bg-white rounded-lg text-xs font-bold hover:bg-gray-50 transition">Tolak</button>
                                <button class="px-3 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 transition">Setujui</button>
                            </div>
                        </div>

                        <!-- Request 2 -->
                        <div class="border border-blue-100 bg-blue-50/30 rounded-xl p-4">
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <p class="font-bold text-gray-900 text-sm">
                                    <i class="fas fa-file-pen text-blue-600 mr-1"></i>Penyesuaian Stok Opname
                                </p>
                                <span class="badge bg-red-100 text-red-700 text-[10px]">-3 Unit</span>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed">
                                Adjustment write-off selisih fisik pemeriksaan berkala rak B3 pada produk Smartwatch serial SN-880.
                            </p>
                            <div class="flex items-center justify-between text-[11px] text-gray-500 mt-2">
                                <span>Auditor: <b class="text-gray-700">Dewi Anggraini</b></span>
                                <span>Level: <b class="text-gray-700">Write-Off Minor</b></span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 mt-3">
                                <button class="px-3 py-2 border border-gray-300 bg-white rounded-lg text-xs font-bold hover:bg-gray-50 transition">Tolak</button>
                                <button class="px-3 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 transition">Setujui</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(auth()->user()->isPegawai())
        <!-- Pegawai Metrics (4 Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6 anim-fade-up">
            <div class="metric-card panel p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-9 h-9 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center">
                        <i class="fas fa-clipboard-check text-blue-600"></i>
                    </div>
                    <span class="badge bg-blue-50 text-blue-600 border border-blue-100 uppercase !text-[9.5px]">SHIFT BERJALAN</span>
                </div>
                <div class="text-[10.5px] font-bold tracking-[0.07em] text-slate-400 uppercase">TUGAS MASUK HARI INI</div>
                <div class="mt-1 flex items-baseline gap-1.5">
                    <span class="text-[32px] font-extrabold text-slate-900 leading-none">18</span>
                    <span class="text-[13px] font-bold text-slate-400">Surat Jalan</span>
                </div>
                <div class="mt-3 flex items-center gap-1.5 text-[11px] text-slate-500 font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400 flex-none"></span> 14 Selesai di-Staging, 4 Menunggu QC
                </div>
            </div>

            <div class="metric-card panel p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-9 h-9 rounded-lg bg-emerald-50 border border-emerald-100 flex items-center justify-center">
                        <i class="fas fa-truck text-emerald-600"></i>
                    </div>
                    <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase !text-[9.5px]">PRIORITAS HUB</span>
                </div>
                <div class="text-[10.5px] font-bold tracking-[0.07em] text-slate-400 uppercase">TUGAS KELUAR HARI INI</div>
                <div class="mt-1 flex items-baseline gap-1.5">
                    <span class="text-[32px] font-extrabold text-slate-900 leading-none">26</span>
                    <span class="text-[13px] font-bold text-slate-400">Order Dispatch</span>
                </div>
                <div class="mt-3 flex items-center gap-1.5 text-[11px] text-slate-500 font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 flex-none"></span> 21 Siap Muat Armada, 5 Picking
                </div>
            </div>

            <div class="metric-card panel p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-9 h-9 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-indigo-600"></i>
                    </div>
                    <span class="badge bg-red-50 text-red-600 border border-red-100 uppercase !text-[9.5px]">2 JAM TERSISA</span>
                </div>
                <div class="text-[10.5px] font-bold tracking-[0.07em] text-slate-400 uppercase">JADWAL STOK OPNAME FISIK</div>
                <div class="mt-1 flex items-baseline gap-1.5">
                    <span class="text-[32px] font-extrabold text-slate-900 leading-none">3</span>
                    <span class="text-[13px] font-bold text-slate-400">Rak Audit</span>
                </div>
                <div class="mt-3 flex items-center gap-1.5 text-[11px] text-slate-500 font-medium">
                    <i class="fas fa-check-circle text-slate-400"></i> Rak A-04, B-12, C-02 • 15:30 WIB
                </div>
            </div>

            <div class="metric-card panel p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-9 h-9 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center">
                        <i class="fas fa-clock text-blue-600"></i>
                    </div>
                    <span class="badge bg-slate-100 text-slate-600 border border-slate-200 uppercase !text-[9.5px]">DALAM REVIEW</span>
                </div>
                <div class="text-[10.5px] font-bold tracking-[0.07em] text-slate-400 uppercase">PERMINTAAN MENUNGGU OTORISASI</div>
                <div class="mt-1 flex items-baseline gap-1.5">
                    <span class="text-[32px] font-extrabold text-slate-900 leading-none">2</span>
                    <span class="text-[13px] font-bold text-slate-400">Permintaan</span>
                </div>
                <div class="mt-3 flex items-center gap-1.5 text-[11px] text-slate-500 font-medium">
                    <i class="fas fa-hourglass text-blue-500"></i> Menunggu persetujuan Kepala Gudang
                </div>
            </div>
        </div>

        <!-- Scanner Banner -->
        <div class="bg-blue-50/40 border border-blue-100 rounded-xl p-5 mb-6 anim-fade-up">
            <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-5">
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-1.5">
                        <div class="w-8 h-8 rounded bg-blue-600 text-white flex items-center justify-center">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <h2 class="text-[16px] font-extrabold text-slate-900">Hub Pemindaian Barcode & Terminal Handheld</h2>
                        <span class="badge bg-emerald-500 text-white !text-[9.5px] !py-0.5">
                            <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span> Zebra TC21 Terhubung
                        </span>
                    </div>
                    <p class="text-[12px] text-slate-500 ml-10">Pindai kode GS1-128, QR Code palet, atau masukkan nomor dokumen secara instan untuk verifikasi lokasi rak dan koli.</p>
                </div>

                <div class="flex items-center gap-4 text-[11.5px] font-semibold text-slate-600 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
                    <span class="flex items-center gap-1.5"><i class="fas fa-battery-three-quarters text-slate-400"></i> Batt: 88%</span>
                    <span class="w-px h-4 bg-slate-200"></span>
                    <span class="flex items-center gap-1.5"><i class="fas fa-wifi text-blue-500"></i> WiFi: HubCakung-5G</span>
                </div>
            </div>

            <div class="mt-5 bg-white p-2 rounded-xl border border-blue-200 shadow-sm flex flex-col sm:flex-row items-center gap-2">
                <div class="relative flex-1 w-full">
                    <i class="fas fa-barcode absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" class="w-full bg-transparent outline-none pl-11 pr-24 py-2.5 text-[14px] text-slate-800 placeholder-slate-400" placeholder="Arahkan scanner handheld atau ketik SKU / Serial / No. DO / Lokasi Rak..." autofocus>
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-1 rounded">AUTO-SCAN</span>
                </div>
                <button class="inline-flex items-center gap-2 w-full sm:w-auto px-6 py-2.5 text-[12.5px] font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all shadow-md shadow-blue-600/30">
                    <i class="fas fa-search"></i> Cari & Validasi
                </button>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-4">
                <button class="bg-white border border-slate-200 hover:border-blue-400 hover:shadow-md hover:text-blue-600 transition-all rounded-xl p-3 flex flex-col items-center justify-center gap-1 text-slate-600 group">
                    <i class="fas fa-arrow-down text-blue-600 group-hover:text-blue-600"></i>
                    <span class="text-[12.5px] font-bold">1. Inbound Cepat</span>
                    <span class="text-[10px] text-slate-400 font-medium">Check-In PO</span>
                </button>
                <button class="bg-white border border-slate-200 hover:border-blue-400 hover:shadow-md hover:text-blue-600 transition-all rounded-xl p-3 flex flex-col items-center justify-center gap-1 text-slate-600 group">
                    <i class="fas fa-box text-blue-600 group-hover:text-blue-600"></i>
                    <span class="text-[12.5px] font-bold">2. Outbound Cepat</span>
                    <span class="text-[10px] text-slate-400 font-medium">Packing List</span>
                </button>
                <button class="bg-white border border-slate-200 hover:border-blue-400 hover:shadow-md hover:text-blue-600 transition-all rounded-xl p-3 flex flex-col items-center justify-center gap-1 text-slate-600 group">
                    <i class="fas fa-search text-blue-600 group-hover:text-blue-600"></i>
                    <span class="text-[12.5px] font-bold">3. Cek Lokasi Rak</span>
                    <span class="text-[10px] text-slate-400 font-medium">Bin Locator</span>
                </button>
                <button class="bg-white border border-slate-200 hover:border-blue-400 hover:shadow-md hover:text-blue-600 transition-all rounded-xl p-3 flex flex-col items-center justify-center gap-1 text-slate-600 group">
                    <i class="fas fa-clipboard text-blue-600 group-hover:text-blue-600"></i>
                    <span class="text-[12.5px] font-bold">4. Hitung Fisik</span>
                    <span class="text-[10px] text-slate-400 font-medium">Stock Count</span>
                </button>
            </div>
        </div>
        @endif

        @if(auth()->user()->isAuditor())
        <!-- Auditor Metrics (4 Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-5 anim-fade-up">
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center"><i class="fas fa-shield-check text-emerald-600"></i></div>
                    <span class="badge bg-emerald-50 text-emerald-700"><i class="fas fa-circle"></i>Selaras</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">TINGKAT INTEGRITAS BUKU</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">99.82%</p>
                <p class="text-xs text-emerald-600 mt-1"><i class="fas fa-check-circle mr-1"></i>Deviasi 0.18% di bawah toleransi 0.50%</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center"><i class="fas fa-exclamation-triangle text-red-600"></i></div>
                    <span class="badge bg-red-50 text-red-600">2 Kritis</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">TEMUAN DISCREPANCY TERBUKA</p>
                <p class="text-3xl font-extrabold text-red-600 mt-1">4 <span class="text-sm font-semibold text-gray-500">Temuan</span></p>
                <p class="text-xs text-gray-500 mt-1">2 Selisih opname, 1 mutasi, 1 fisik rusak</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-clipboard-check text-blue-600"></i></div>
                    <span class="badge bg-blue-50 text-blue-700">79.1%</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">SKU TELAH DIAUDIT (Q1)</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">6.840 <span class="text-sm font-semibold text-gray-500">/ 8.650 SKU</span></p>
                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                    <div class="bg-blue-600 h-full rounded-full" style="width: 79.1%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">Sampling acak mingguan di 6 Zona DC</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center"><i class="fas fa-coins text-amber-600"></i></div>
                    <span class="badge bg-gray-50 text-gray-600">Dalam Verifikasi</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">VALUASI POTENSI RISIKO</p>
                <p class="text-2xl font-extrabold text-gray-900 mt-1">Rp 18.450.000</p>
                <p class="text-xs text-gray-500 mt-1">0.038% dari total aset Rp 46,2 Miliar</p>
            </div>
        </div>

        <!-- Zero Tampering Banner -->
        <div class="bg-slate-800 rounded-xl p-4 flex flex-wrap gap-4 items-center justify-between text-white mb-5 shadow-lg shadow-slate-900/10 anim-fade-up">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-slate-700 rounded-xl border border-slate-600">
                    <i class="fas fa-shield-alt text-emerald-400"></i>
                </div>
                <div>
                    <div class="text-[12px] font-bold text-slate-100 flex items-center gap-2">
                        ZERO TAMPERING DETECTED <span class="text-slate-500">•</span> Blok Audit: #AUDIT-2023-W12
                    </div>
                    <div class="text-[10.5px] text-slate-400 mt-1 tracking-wide font-mono">
                        SHA256: 8f9b4c2c61e87d0c345fb16928ace7c93601dd79815bbd5c317c24d9c0ff5981
                    </div>
                </div>
            </div>
            <button class="px-4 py-2 bg-slate-700 border border-slate-600 text-white hover:bg-slate-600 text-[11.5px] font-semibold rounded-xl transition-colors flex items-center gap-2">
                <i class="fas fa-check-circle text-emerald-400"></i> Validasi Hash
            </button>
        </div>
        @endif

        @if(auth()->user()->isAuditor())
        <!-- Auditor Main Content Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-6 anim-fade-up">
            <!-- Left 2 Columns -->
            <div class="xl:col-span-2 space-y-5">
                <!-- Chart Card -->
                <div class="bg-white border border-slate-200 rounded-xl p-5 md:p-6 shadow-sm">
                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-3 mb-6">
                        <div>
                            <h2 class="text-[16px] font-extrabold text-slate-900">Tren Temuan & Akurasi Rekonsiliasi</h2>
                            <p class="text-[12px] text-slate-500 mt-1">Korelasi antara volume uji petik harian terhadap stabilitas persediaan</p>
                        </div>
                        <div class="flex gap-1.5 bg-slate-50 border border-slate-200 rounded-xl p-1 flex-none">
                            <button class="px-3 py-1.5 rounded-md font-semibold bg-blue-600 text-white transition text-[11.5px]">7 Hari</button>
                            <button class="px-3 py-1.5 rounded-md font-semibold text-slate-600 hover:text-blue-700 transition text-[11.5px]">14 Hari</button>
                            <button class="px-3 py-1.5 rounded-md font-semibold text-slate-600 hover:text-blue-700 transition text-[11.5px]">30 Hari</button>
                        </div>
                    </div>
                    <div class="relative w-full h-[260px] flex items-center justify-center bg-slate-50 rounded-lg">
                        <p class="text-slate-400 text-sm">Chart placeholder - Tren Temuan & Akurasi</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-6 text-[11.5px] font-semibold text-slate-600 mt-4">
                        <span class="flex items-center gap-2"><span class="w-3 h-1 rounded-full bg-blue-600"></span> Tingkat Akurasi Buku (Avg 99.8%)</span>
                        <span class="flex items-center gap-2"><span class="w-3 h-1 rounded-full bg-red-600"></span> Temuan Selisih Fisik (0-3 Qty)</span>
                    </div>
                </div>

                <!-- Temuan Prioritas Tinggi -->
                <div class="bg-white border border-slate-200 rounded-xl p-5 md:p-6 shadow-sm">
                    <div class="flex flex-wrap items-center justify-between mb-5 gap-3">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-exclamation-circle text-red-600"></i>
                            <h2 class="text-[15px] md:text-[16.5px] font-extrabold text-slate-900">Temuan Prioritas Tinggi (Butuh Tindak Lanjut Segera)</h2>
                        </div>
                        <span class="text-[11.5px] font-bold text-slate-500">2 Menunggu Tanggapan</span>
                    </div>

                    <div class="space-y-4">
                        <!-- Item 1 -->
                        <div class="border-l-[3px] border-red-600 bg-slate-50 rounded-r-xl p-4 md:p-5 border-y border-r border-slate-100 shadow-sm">
                            <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm">KRITIS</span>
                                    <span class="text-[13.5px] font-bold text-slate-800">#AUD-2025-041: Selisih Fisik Barang High-Value</span>
                                </div>
                                <span class="text-[11px] font-medium text-slate-500">Ditemukan: 13 Mar 2025, 14:10 WIB</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <div class="text-[10.5px] font-semibold text-slate-400 uppercase tracking-wide">SKU & Deskripsi</div>
                                    <div class="text-[12px] font-medium text-slate-700 mt-1">SD-EXT-1TB (Sandisk Extreme SSD)</div>
                                </div>
                                <div>
                                    <div class="text-[10.5px] font-semibold text-slate-400 uppercase tracking-wide">Lokasi Penyimpanan</div>
                                    <div class="text-[12px] font-medium text-slate-700 mt-1">Lorong Rak C-02 (Level 3 / Bin 14)</div>
                                </div>
                                <div>
                                    <div class="text-[10.5px] font-semibold text-slate-400 uppercase tracking-wide">Deviasi & Valuasi</div>
                                    <div class="text-[12px] font-bold text-red-600 mt-1">-3 Unit (Rp 3.750.000)</div>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-slate-100">
                                <div class="flex items-center gap-2 text-[12px] font-medium text-slate-600">
                                    <i class="fas fa-clock"></i> Status: Menunggu Penjelasan Ka. Gudang (Budi Hartono)
                                </div>
                                <div class="flex gap-2 w-full md:w-auto">
                                    <button class="flex-1 md:flex-none px-3 py-1.5 text-[11.5px] font-semibold text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition">Investigasi Detail</button>
                                    <button class="flex-1 md:flex-none px-3 py-1.5 text-[11.5px] font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition">Rekomendasi Penyesuaian</button>
                                </div>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div class="border-l-[3px] border-blue-500 bg-slate-50 rounded-r-xl p-4 md:p-5 border-y border-r border-slate-100 shadow-sm">
                            <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                                <div class="flex items-center gap-2">
                                    <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded">PERINGATAN</span>
                                    <span class="text-[13.5px] font-bold text-slate-800">#AUD-2025-039: Ketidaksesuaian Segel Kontainer Inbound</span>
                                </div>
                                <span class="text-[11px] font-medium text-slate-500">Ditemukan: 12 Mar 2025, 08:35 WIB</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <div class="text-[10.5px] font-semibold text-slate-400 uppercase tracking-wide">Dokumen Acuan</div>
                                    <div class="text-[12px] font-medium text-slate-700 mt-1">PO-774 / Surat Jalan #SJ-8891</div>
                                </div>
                                <div>
                                    <div class="text-[10.5px] font-semibold text-slate-400 uppercase tracking-wide">Vendor / Pengirim</div>
                                    <div class="text-[12px] font-medium text-slate-700 mt-1">PT Mitra Logistik Cakrawala</div>
                                </div>
                                <div>
                                    <div class="text-[10.5px] font-semibold text-slate-400 uppercase tracking-wide">Status Pemeriksaan</div>
                                    <div class="text-[12px] font-medium text-slate-700 mt-1">Investigasi Vendor & CCTV Dock 4</div>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-slate-100">
                                <div class="flex items-center gap-2 text-[12px] font-medium text-slate-600">
                                    <i class="fas fa-shield-alt text-amber-500"></i> Barang ditahan di Staging Area Karantina (Hold 48 Jam)
                                </div>
                                <div class="flex gap-2">
                                    <button class="text-[12px] font-bold text-blue-600 hover:text-blue-700 transition-colors">Buka Berita Acara</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-5">
                <!-- Hub Card -->
                <div class="bg-white border border-slate-200 rounded-xl p-4 relative overflow-hidden h-[130px] flex flex-col justify-between shadow-sm">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-800 opacity-90"></div>
                    <div class="relative z-10 flex justify-between">
                        <span class="bg-slate-900/70 backdrop-blur-md text-white border border-white/10 text-[10.5px] font-bold px-2 py-1 rounded shadow-sm">Hub Cakung DC-01</span>
                    </div>
                    <div class="relative z-10 flex items-end justify-between">
                        <div class="text-white">
                            <div class="text-[13.5px] font-bold leading-tight">Audit Fisik Lapangan</div>
                            <div class="text-[11px] text-slate-200 mt-0.5 font-medium">Siklus Verifikasi Q1-2025</div>
                        </div>
                        <div class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-400 bg-slate-900/70 backdrop-blur-md border border-white/10 px-2 py-1 rounded">
                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span> Aktif
                        </div>
                    </div>
                </div>

                <!-- Jadwal Opname -->
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-[14.5px] font-extrabold text-slate-900">Jadwal Opname & Uji Petik</h2>
                        <i class="fas fa-calendar text-slate-400"></i>
                    </div>
                    <div class="space-y-3">
                        <div class="p-3 bg-emerald-50/50 rounded-xl border border-emerald-100">
                            <div class="flex justify-between items-center mb-1">
                                <div class="text-[12px] font-bold text-slate-800">Zona B (Elektronik & High-Value)</div>
                                <div class="text-[11px] font-bold text-emerald-600">100% Selesai</div>
                            </div>
                            <div class="text-[11px] text-slate-500">Verifikasi rekonsiliasi telah valid & ditandatangani.</div>
                        </div>
                        <div class="p-3 bg-blue-50/60 rounded-xl border border-blue-100">
                            <div class="flex justify-between items-center mb-1">
                                <div class="text-[12px] font-bold text-slate-800">Zona C (Gadget & Storage)</div>
                                <div class="text-[11px] font-bold text-blue-600">88% Berjalan</div>
                            </div>
                            <div class="text-[11px] text-slate-500">Sampling acak 420 SKU sedang berlangsung oleh Tim B.</div>
                        </div>
                        <div class="p-3 bg-slate-50/80 rounded-xl border border-slate-100">
                            <div class="flex justify-between items-center mb-1">
                                <div class="text-[12px] font-bold text-slate-800">Zona D (Perangkat Jaringan)</div>
                                <div class="text-[11px] font-bold text-slate-500">Terjadwal</div>
                            </div>
                            <div class="text-[11px] text-slate-500">Dijadwalkan Besok, 09:00 WIB (Pemeriksa: Dewi A.)</div>
                        </div>
                    </div>
                </div>

                <!-- Distribusi Temuan -->
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <h2 class="text-[14.5px] font-extrabold text-slate-900 mb-4">Distribusi Temuan per Kategori</h2>
                    <div class="flex h-2.5 w-full rounded-full overflow-hidden mb-5">
                        <div class="bg-blue-600 w-[50%]"></div>
                        <div class="bg-red-600 w-[25%]"></div>
                        <div class="bg-slate-400 w-[25%]"></div>
                    </div>
                    <div class="space-y-2.5">
                        <div class="flex justify-between items-center text-[11.5px]">
                            <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span> <span class="font-medium text-slate-700">Selisih Kuantitas Stok</span></div>
                            <div class="font-semibold text-slate-800">50% <span class="font-medium text-slate-400">(2 Temuan)</span></div>
                        </div>
                        <div class="flex justify-between items-center text-[11.5px]">
                            <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-red-600"></span> <span class="font-medium text-slate-700">Kerusakan Fisik Kemasan</span></div>
                            <div class="font-semibold text-slate-800">25% <span class="font-medium text-slate-400">(1 Temuan)</span></div>
                        </div>
                        <div class="flex justify-between items-center text-[11.5px]">
                            <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span> <span class="font-medium text-slate-700">Keterlambatan Dokumen Admin</span></div>
                            <div class="font-semibold text-slate-800">25% <span class="font-medium text-slate-400">(1 Temuan)</span></div>
                        </div>
                    </div>
                </div>

                <!-- Log Aktivitas -->
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-[14.5px] font-extrabold text-slate-900">Log Aktivitas Audit Terkini</h2>
                        <div class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Live Feed
                        </div>
                    </div>
                    <div class="space-y-4 relative">
                        <div class="relative flex items-start gap-3.5 pb-4 border-b border-slate-100 last:border-0 last:pb-0">
                            <div class="w-[24px] h-[24px] rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-none">
                                <i class="fas fa-file-alt text-[10px]"></i>
                            </div>
                            <div>
                                <div class="text-[12.5px] text-slate-700 leading-tight"><span class="font-bold">Dewi Anggraini</span> menerbitkan Berita Acara Temuan</div>
                                <div class="text-[11px] text-slate-500 mt-1">Dokumen Berita Acara #AUD-2025-041 terlampir ke Ka. Gudang.</div>
                                <div class="text-[10px] text-slate-400 mt-1 font-medium">15 menit lalu</div>
                            </div>
                        </div>
                        <div class="relative flex items-start gap-3.5 pb-4 border-b border-slate-100 last:border-0 last:pb-0">
                            <div class="w-[24px] h-[24px] rounded-full bg-red-100 text-red-600 flex items-center justify-center flex-none">
                                <i class="fas fa-exclamation-triangle text-[10px]"></i>
                            </div>
                            <div>
                                <div class="text-[12.5px] text-slate-700 font-bold leading-tight">Deviasi Berat Inbound Terdeteksi</div>
                                <div class="text-[11px] text-slate-500 mt-1">Timbangan otomatis Dock 2 menandai selisih bobot 4.2 kg pada PO-9081.</div>
                                <div class="text-[10px] text-slate-400 mt-1 font-medium">1 jam lalu</div>
                            </div>
                        </div>
                        <div class="relative flex items-start gap-3.5">
                            <div class="w-[24px] h-[24px] rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-none">
                                <i class="fas fa-shield-alt text-[10px]"></i>
                            </div>
                            <div>
                                <div class="text-[12.5px] text-slate-700 font-bold leading-tight">Pengesahan Blok Ledger Mingguan</div>
                                <div class="text-[11px] text-slate-500 mt-1">Blok #AUDIT-2025-W12 ditandatangani secara kriptografis oleh Kepatuhan.</div>
                                <div class="text-[10px] text-slate-400 mt-1 font-medium">3 jam lalu</div>
                            </div>
                        </div>
                    </div>
                    <button class="w-full mt-5 py-2.5 bg-slate-50 hover:bg-slate-100 text-slate-600 text-[11.5px] font-bold rounded-xl transition-colors border border-slate-200">Lihat Riwayat Lengkap Seluruh Log</button>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Aktivitas Terkini</h3>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                @if(auth()->user()->isSuperAdmin())
                <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user-plus text-blue-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">User baru ditambahkan</p>
                        <p class="text-xs text-gray-500">Ahmad Fauzi - Pegawai Gudang</p>
                        <p class="text-xs text-gray-400 mt-1">10 menit yang lalu</p>
                    </div>
                </div>
                @endif
                @if(auth()->user()->isKepalaGudang())
                <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-arrow-down text-green-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">PO Diterima</p>
                        <p class="text-xs text-gray-500">PO-2025-1042 - 150 unit SKU-CAM-600D</p>
                        <p class="text-xs text-gray-400 mt-1">5 menit yang lalu</p>
                    </div>
                </div>
                @endif
                @if(auth()->user()->isHR())
                <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-clock text-red-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Permintaan Persetujuan Baru</p>
                        <p class="text-xs text-gray-500">REQ-2025-1042 - Hardware Scanner Rusak (DARURAT)</p>
                        <p class="text-xs text-gray-400 mt-1">2 menit yang lalu</p>
                    </div>
                </div>
                @endif
                @if(auth()->user()->isPegawai())
                <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-check text-green-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Pengajuan Disetujui</p>
                        <p class="text-xs text-gray-500">REQ-2025-1038 - 5 Roll Bubble Wrap</p>
                        <p class="text-xs text-gray-400 mt-1">15 menit yang lalu</p>
                    </div>
                </div>
                @endif
                @if(auth()->user()->isAuditor())
                <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-amber-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Temuan Audit Baru</p>
                        <p class="text-xs text-gray-500">AUDIT-2025-042 - Discrepancy 12 unit SKU-LAP-X1</p>
                        <p class="text-xs text-gray-400 mt-1">30 menit yang lalu</p>
                    </div>
                </div>
                @endif

                <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-sync text-purple-600"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Sistem Diperbarui</p>
                        <p class="text-xs text-gray-500">Astro Inventory v2.5.1 - Bug fixes & performance improvement</p>
                        <p class="text-xs text-gray-400 mt-1">1 jam yang lalu</p>
                    </div>
                </div>
            </div>
        </div>

    </main>
</div>
</body>
</html>
