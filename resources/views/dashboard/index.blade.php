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
                <button type="button" disabled title="Belum tersedia: belum ada generator laporan ringkas" class="px-3.5 py-2 border border-gray-200 bg-gray-50 text-gray-400 rounded-lg text-sm flex items-center gap-2 cursor-not-allowed">
                    <i class="fas fa-download"></i>Unduh Laporan Ringkas
                </button>
                <a href="{{ route('admin.data-barang') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm flex items-center gap-2 transition shadow-sm">
                    <i class="fas fa-plus"></i>+ Tambah Barang Baru
                </a>
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
                <a href="{{ route('kepalagudang.laporan') }}" class="px-3.5 py-2 border border-gray-300 bg-white rounded-lg hover:bg-gray-50 text-sm flex items-center gap-2 transition">
                    <i class="fas fa-download text-blue-600"></i>Unduh Laporan Ringkas
                </a>
                <a href="{{ route('kepalagudang.data-barang') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm flex items-center gap-2 transition shadow-sm">
                    <i class="fas fa-plus"></i>+ Tambah Barang Baru
                </a>
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
                <button type="button" disabled title="Belum tersedia: belum ada data transaksi/persetujuan" class="bg-gray-50 border border-gray-200 text-gray-400 px-3 py-2 rounded-lg text-xs font-semibold flex items-center space-x-2 cursor-not-allowed">
                    <i class="fas fa-download"></i>
                    <span>Unduh Laporan Ringkas</span>
                </button>
                <button type="button" disabled title="Belum tersedia: tabel persetujuan belum ada" class="bg-gray-300 text-white px-4 py-2 rounded-lg text-xs font-semibold flex items-center space-x-2 cursor-not-allowed">
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
            <span class="text-blue-600 font-bold">{{ auth()->user()->selectedHub->code ?? 'HUB BELUM DIPILIH' }}</span>
        </nav>

        <!-- Pegawai Header -->
        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4 mb-6 anim-fade-up">
            <div>
                <h1 class="text-[26px] md:text-[30px] font-extrabold text-slate-900 leading-tight">Dashboard Operasional Pegawai</h1>
                <p class="text-[13.5px] text-slate-500 mt-1.5 max-w-3xl">Selamat datang kembali, {{ auth()->user()->nama_lengkap }} (NIP: {{ auth()->user()->nip ?? '-' }}). Kelola penanganan fisik barang masuk, barang keluar, pemindaian barcode rak, dan verifikasi stok harian {{ auth()->user()->selectedHub->name ?? 'hub operasional' }}.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5 flex-none">
                <button type="button" disabled title="Belum tersedia: integrasi scanner belum ada" class="inline-flex items-center gap-2 px-4 py-2.5 text-[12.5px] font-semibold text-white bg-slate-300 rounded-xl cursor-not-allowed">
                    <i class="fas fa-barcode"></i> Scan Barcode Cepat
                </button>
                <button type="button" disabled title="Belum tersedia: modul penerimaan belum ada" class="inline-flex items-center gap-2 px-4 py-2.5 text-[12.5px] font-semibold text-slate-400 bg-gray-50 border border-slate-200 rounded-xl cursor-not-allowed">
                    <i class="fas fa-arrow-down"></i> Input Barang Masuk Baru
                </button>
                <button type="button" disabled title="Belum tersedia: modul pengeluaran belum ada" class="inline-flex items-center gap-2 px-4 py-2.5 text-[12.5px] font-semibold text-slate-400 bg-gray-50 border border-slate-200 rounded-xl cursor-not-allowed">
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
                <p class="text-[13.5px] text-slate-500 mt-1.5 max-w-3xl">Pemantauan integritas buku inventaris, deviasi stok fisik vs sistem, transparansi mutasi logistik, dan rekam jejak kepatuhan ISO/IEC 27001 {{ auth()->user()->selectedHub->name ?? 'hub operasional' }}.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5 flex-none">
                <button type="button" disabled title="Belum tersedia: belum ada endpoint ekspor audit trail" class="inline-flex items-center gap-2 px-4 py-2.5 text-[12px] font-semibold text-slate-400 bg-gray-50 border border-slate-200 rounded-xl cursor-not-allowed">
                    <i class="fas fa-download"></i> Ekspor Audit Trail (PDF/CSV)
                </button>
                <button type="button" disabled title="Belum tersedia: modul uji petik/opname belum ada" class="inline-flex items-center gap-2 px-4 py-2.5 text-[12px] font-semibold text-white bg-slate-300 rounded-xl cursor-not-allowed">
                    <i class="fas fa-flask"></i> Mulai Uji Petik Mandiri (Sample Test)
                </button>
            </div>
        </div>
        @endif

        <!-- Modul yang belum memiliki tabel/domain pendukung -->
        @if(!empty($unavailableModules))
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-5 anim-fade-up">
            <div class="flex items-start gap-2.5">
                <i class="fas fa-triangle-exclamation text-amber-500 mt-0.5"></i>
                <div>
                    <div class="text-[12.5px] font-bold text-amber-800">Modul berikut belum tersedia pada database dan tidak ditampilkan dengan data contoh:</div>
                    <div class="text-[11.5px] text-amber-700 mt-1">{{ implode(' • ', $unavailableModules) }}</div>
                </div>
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
                    <span class="badge bg-emerald-50 text-emerald-700"><i class="fas fa-arrow-trend-up"></i>+{{ $newUsersThisMonth }} bulan ini</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">TOTAL PENGGUNA &amp; ADMIN</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ number_format($totalUsers, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-1"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full inline-block mr-1"></span>{{ $activeUsers }} akun aktif &bull; {{ $hubScopeCode ?? 'Semua hub' }}</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-box-archive text-blue-600"></i></div>
                    <span class="badge bg-blue-50 text-blue-700"><i class="fas fa-layer-group"></i>{{ $totalCategories }} Kategori</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">SKU TERDAFTAR</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ number_format($totalItems, 0, ',', '.') }} <span class="text-sm font-semibold text-gray-500">SKU</span></p>
                <p class="text-xs text-emerald-600 mt-1"><i class="fas fa-circle-check"></i> {{ $totalSuppliers }} supplier terdaftar</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center"><i class="fas fa-warehouse text-emerald-600"></i></div>
                    <span class="badge bg-emerald-50 text-emerald-700"><i class="fas fa-city"></i>{{ $totalCities }} Kota</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">HUB DISTRIBUSI</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalHubs }} <span class="text-sm font-semibold text-gray-500">Hub</span></p>
                <p class="text-xs text-gray-500 mt-1"><i class="fas fa-location-dot mr-1"></i>{{ $hubsByOccupancy->avg('occupancy') ? round($hubsByOccupancy->avg('occupancy'), 1) : 0 }}% rata-rata okupansi</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-sitemap text-blue-600"></i></div>
                    <span class="badge bg-blue-50 text-blue-700"><i class="fas fa-users"></i>{{ $activeSessions }} sesi aktif</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">DIVISI OPERASIONAL</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalDivisions }} <span class="text-sm font-semibold text-gray-500">Divisi</span></p>
                <p class="text-xs text-gray-500 mt-1"><i class="fas fa-list-check mr-1"></i>{{ $totalCategories }} kategori barang</p>
            </div>
        </div>
        <!-- Main Content Grid for Super Admin -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-6 anim-fade-up delay-2">
            <!-- LEFT 2 Columns -->
            <div class="xl:col-span-2 space-y-5">
                <!-- Chart Card: komposisi kategori (data nyata) -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-chart-pie text-blue-600 mt-1"></i>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm lg:text-base">Komposisi Inventaris per Kategori</h3>
                                <p class="text-xs text-gray-500">Dihitung langsung dari tabel items &amp; categories</p>
                            </div>
                        </div>
                        <span class="badge bg-blue-50 text-blue-700">{{ $totalItems }} SKU</span>
                    </div>
                    <div class="space-y-4">
                        @forelse($itemsByCategory as $category)
                            @php $percent = $totalItems > 0 ? round($category->items_count / $totalItems * 100, 1) : 0; @endphp
                            <div>
                                <div class="flex items-center justify-between text-[12px] mb-1">
                                    <span class="font-semibold text-gray-700">{{ $category->nama }}</span>
                                    <span class="font-bold text-gray-900">{{ $category->items_count }} SKU ({{ $percent }}%)</span>
                                </div>
                                <div class="bg-gray-100 rounded-full h-2 w-full">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <i class="fas fa-chart-pie text-3xl text-slate-300"></i>
                                <div class="text-[12.5px] font-bold text-slate-500 mt-2">Belum ada data kategori/barang</div>
                                <div class="text-[11px] text-slate-400">Tambahkan master data untuk melihat komposisi inventaris.</div>
                            </div>
                        @endforelse
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-5">
                        <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center"><p class="text-[11px] text-gray-500">Kategori</p><p class="font-bold text-gray-900 mt-0.5">{{ $totalCategories }}</p></div>
                        <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center"><p class="text-[11px] text-gray-500">Supplier</p><p class="font-bold text-gray-900 mt-0.5">{{ $totalSuppliers }}</p></div>
                        <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center"><p class="text-[11px] text-gray-500">Hub / Kota</p><p class="font-bold text-gray-900 mt-0.5">{{ $totalHubs }} / {{ $totalCities }}</p></div>
                    </div>
                </div>
                <!-- Log Aktivitas (audit_logs) -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock-rotate-left text-blue-600"></i>
                            <h3 class="font-bold text-gray-900 text-sm lg:text-base">Log Aktivitas Terkini</h3>
                        </div>
                        <span class="text-[11px] font-semibold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full">Sumber: audit_logs</span>
                    </div>
                    <div class="space-y-3">
                        @forelse($recentAuditLogs as $log)
                            @php
                                $initial = strtoupper(mb_substr($log->user?->nama_lengkap ?? 'S', 0, 2));
                                $palette = ['bg-blue-600', 'bg-emerald-500', 'bg-indigo-500', 'bg-amber-500', 'bg-slate-500'];
                                $avatarBg = $palette[$log->id % count($palette)];
                            @endphp
                            <div class="flex items-start gap-3 p-3 bg-gray-50 border border-gray-100 rounded-xl">
                                <div class="w-9 h-9 {{ $avatarBg }} rounded-full flex items-center justify-center text-white text-[11px] font-bold flex-shrink-0">{{ $initial }}</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <b class="text-sm text-gray-900">{{ $log->user?->nama_lengkap ?? 'Sistem' }}</b>
                                        <span class="bg-blue-100 text-blue-700 text-[10px] px-2 py-0.5 rounded-full font-semibold">{{ $log->user?->role?->name ?? 'Sistem' }}</span>
                                        <span class="ml-auto text-[11px] text-gray-400">{{ $log->created_at?->diffForHumans() ?? '-' }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-0.5">{{ $log->description ?: ucfirst($log->action).' pada '.$log->entity_type }}</p>
                                    <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                        <span class="text-[10px] px-2 py-0.5 rounded-full font-semibold {{ $log->result === 'success' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ ucfirst($log->action) }} &bull; {{ $log->result }}</span>
                                        <span class="text-[11px] text-gray-500">{{ $log->entity_type }}@if($log->entity_id) #{{ $log->entity_id }}@endif</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <i class="fas fa-clock-rotate-left text-3xl text-slate-300"></i>
                                <div class="text-[12.5px] font-bold text-slate-500 mt-2">Belum ada log audit</div>
                                <div class="text-[11px] text-slate-400">Log terisi otomatis saat pengguna atau konfigurasi diubah.</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

                        <!-- RIGHT Column -->
            <div class="space-y-5">
                <!-- Item Terbaru -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-2 mb-4">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-box-archive text-blue-600 mt-1"></i>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm lg:text-base">Item Terbaru</h3>
                                <p class="text-xs text-gray-500">Data master barang dari database</p>
                            </div>
                        </div>
                        <span class="bg-blue-600 text-white text-[10px] px-2 py-0.5 rounded-full font-semibold">{{ $totalItems }} SKU</span>
                    </div>

                    <div class="space-y-3">
                        @forelse($latestItems as $item)
                            <div class="border border-slate-100 rounded-xl p-3.5 hover:border-blue-200 transition">
                                <div class="flex items-start justify-between gap-2 mb-1">
                                    <span class="text-[11px] font-bold text-gray-500 tracking-wide">{{ $item->sku }}</span>
                                    <span class="bg-emerald-50 text-emerald-700 text-[10px] px-2 py-0.5 rounded-full font-semibold">{{ $item->status ?: 'Aktif' }}</span>
                                </div>
                                <p class="font-bold text-gray-900 text-sm">{{ $item->nama }}</p>
                                <p class="text-xs text-gray-500">Kategori: <b class="text-gray-700">{{ $item->category?->nama ?? '-' }}</b> • Satuan: {{ $item->unit?->nama ?? '-' }}</p>
                                <p class="text-[11px] text-gray-400 mt-1">Supplier: {{ $item->supplier?->nama ?? 'Belum ditetapkan' }}</p>
                            </div>
                        @empty
                            <div class="text-center py-6">
                                <i class="fas fa-box-open text-2xl text-slate-300"></i>
                                <div class="text-[12px] font-bold text-slate-500 mt-2">Belum ada item pada master data</div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pengguna Terbaru -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user-plus text-blue-600"></i>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm lg:text-base">Pengguna Terbaru</h3>
                                <p class="text-[11px] text-gray-500">{{ $hubScoped ? 'Hub '.$hubScopeCode : 'Semua hub' }}</p>
                            </div>
                        </div>
                        <span class="bg-blue-600 text-white text-[10px] px-2 py-0.5 rounded-full font-semibold">{{ $totalUsers }} Akun</span>
                    </div>

                    <div class="space-y-3">
                        @forelse($recentUsers as $recentUser)
                            <div class="border border-slate-100 rounded-xl p-3.5 flex items-center justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="font-bold text-gray-900 text-sm truncate">{{ $recentUser->nama_lengkap }}</p>
                                    <p class="text-[11px] text-gray-500 truncate">{{ $recentUser->role?->name ?? 'Tanpa peran' }} • {{ $recentUser->division?->nama ?? 'Belum ada divisi' }}</p>
                                </div>
                                <span class="text-[10px] px-2 py-0.5 rounded-full font-semibold {{ $recentUser->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ ucfirst($recentUser->status) }}</span>
                            </div>
                        @empty
                            <div class="text-center py-6 text-[12px] text-slate-400">Belum ada pengguna.</div>
                        @endforelse
                        <div class="bg-amber-50 border border-amber-100 rounded-xl p-3 text-[11px] text-amber-700">
                            <i class="fas fa-triangle-exclamation mr-1"></i> Modul persetujuan mutasi belum tersedia karena belum ada tabel transaksi.
                        </div>
                    </div>
                </div>            </div>
        </div>
        @endif

        @if(auth()->user()->isKepalaGudang())
        <!-- KPI cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6 anim-fade-up">
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-box-archive text-blue-600"></i></div>
                    <span class="badge bg-blue-50 text-blue-700"><i class="fas fa-layer-group"></i>{{ $totalCategories }} Kategori</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">SKU DI HUB</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ number_format($totalItems, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-1"><i class="fas fa-boxes-stacked mr-1"></i>Master barang terdaftar</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center"><i class="fas fa-warehouse text-emerald-600"></i></div>
                    <span class="badge bg-emerald-50 text-emerald-700"><i class="fas fa-location-dot"></i>{{ $hub->area ?? '-' }}</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">HUB OPERASIONAL</p>
                <p class="text-[15px] font-extrabold text-gray-900 mt-2 leading-tight">{{ $hub->name ?? 'Belum dipilih' }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $hub->code ?? '-' }}</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center"><i class="fas fa-people-group text-amber-600"></i></div>
                    <span class="badge bg-amber-50 text-amber-700"><i class="fas fa-user-check"></i>{{ $activeUsers }} aktif</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">PENGGUNA SISTEM</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalUsers }}</p>
                <p class="text-xs text-gray-500 mt-1"><i class="fas fa-clock mr-1"></i>{{ $activeSessions }} sesi aktif &bull; {{ $hubScopeCode ?? 'Semua hub' }}</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-truck-field text-blue-600"></i></div>
                    <span class="badge bg-slate-100 text-slate-600"><i class="fas fa-circle-info"></i>Belum tersedia</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">ARUS BARANG HARI INI</p>
                <p class="text-3xl font-extrabold text-gray-400 mt-1">-</p>
                <p class="text-xs text-gray-500 mt-1">Tabel transaksi masuk/keluar belum ada</p>
            </div>
        </div>
        <!-- Kepala Gudang Main Content Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-6">
            <!-- Left 2 Columns -->
            <div class="xl:col-span-2 space-y-5">
                <!-- Chart Card: komposisi kategori (data nyata) -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-chart-pie text-blue-600 mt-1"></i>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm lg:text-base">Komposisi Inventaris per Kategori</h3>
                                <p class="text-xs text-gray-500">Dihitung langsung dari tabel items &amp; categories</p>
                            </div>
                        </div>
                        <span class="badge bg-blue-50 text-blue-700">{{ $totalItems }} SKU</span>
                    </div>
                    <div class="space-y-4">
                        @forelse($itemsByCategory as $category)
                            @php $percent = $totalItems > 0 ? round($category->items_count / $totalItems * 100, 1) : 0; @endphp
                            <div>
                                <div class="flex items-center justify-between text-[12px] mb-1">
                                    <span class="font-semibold text-gray-700">{{ $category->nama }}</span>
                                    <span class="font-bold text-gray-900">{{ $category->items_count }} SKU ({{ $percent }}%)</span>
                                </div>
                                <div class="bg-gray-100 rounded-full h-2 w-full">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <i class="fas fa-chart-pie text-3xl text-slate-300"></i>
                                <div class="text-[12.5px] font-bold text-slate-500 mt-2">Belum ada data kategori/barang</div>
                                <div class="text-[11px] text-slate-400">Tambahkan master data untuk melihat komposisi inventaris.</div>
                            </div>
                        @endforelse
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-5">
                        <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center"><p class="text-[11px] text-gray-500">Kategori</p><p class="font-bold text-gray-900 mt-0.5">{{ $totalCategories }}</p></div>
                        <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center"><p class="text-[11px] text-gray-500">Supplier</p><p class="font-bold text-gray-900 mt-0.5">{{ $totalSuppliers }}</p></div>
                        <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center"><p class="text-[11px] text-gray-500">Hub / Kota</p><p class="font-bold text-gray-900 mt-0.5">{{ $totalHubs }} / {{ $totalCities }}</p></div>
                    </div>
                </div>
                <!-- Log Aktivitas (audit_logs) -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock-rotate-left text-blue-600"></i>
                            <h3 class="font-bold text-gray-900 text-sm lg:text-base">Log Aktivitas Terkini</h3>
                        </div>
                        <span class="text-[11px] font-semibold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full">Sumber: audit_logs</span>
                    </div>
                    <div class="space-y-3">
                        @forelse($recentAuditLogs as $log)
                            @php
                                $initial = strtoupper(mb_substr($log->user?->nama_lengkap ?? 'S', 0, 2));
                                $palette = ['bg-blue-600', 'bg-emerald-500', 'bg-indigo-500', 'bg-amber-500', 'bg-slate-500'];
                                $avatarBg = $palette[$log->id % count($palette)];
                            @endphp
                            <div class="flex items-start gap-3 p-3 bg-gray-50 border border-gray-100 rounded-xl">
                                <div class="w-9 h-9 {{ $avatarBg }} rounded-full flex items-center justify-center text-white text-[11px] font-bold flex-shrink-0">{{ $initial }}</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <b class="text-sm text-gray-900">{{ $log->user?->nama_lengkap ?? 'Sistem' }}</b>
                                        <span class="bg-blue-100 text-blue-700 text-[10px] px-2 py-0.5 rounded-full font-semibold">{{ $log->user?->role?->name ?? 'Sistem' }}</span>
                                        <span class="ml-auto text-[11px] text-gray-400">{{ $log->created_at?->diffForHumans() ?? '-' }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-0.5">{{ $log->description ?: ucfirst($log->action).' pada '.$log->entity_type }}</p>
                                    <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                        <span class="text-[10px] px-2 py-0.5 rounded-full font-semibold {{ $log->result === 'success' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ ucfirst($log->action) }} &bull; {{ $log->result }}</span>
                                        <span class="text-[11px] text-gray-500">{{ $log->entity_type }}@if($log->entity_id) #{{ $log->entity_id }}@endif</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <i class="fas fa-clock-rotate-left text-3xl text-slate-300"></i>
                                <div class="text-[12.5px] font-bold text-slate-500 mt-2">Belum ada log audit</div>
                                <div class="text-[11px] text-slate-400">Log terisi otomatis saat pengguna atau konfigurasi diubah.</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

                        <!-- Right Column -->
            <div class="space-y-5">
                <!-- Item Terbaru -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-2 mb-4">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-box-archive text-blue-600 mt-1"></i>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm lg:text-base">Item Terbaru</h3>
                                <p class="text-xs text-gray-500">Data master barang dari database</p>
                            </div>
                        </div>
                        <span class="bg-blue-600 text-white text-[10px] px-2 py-0.5 rounded-full font-semibold">{{ $totalItems }} SKU</span>
                    </div>
                    <div class="space-y-3">
                        @forelse($latestItems as $item)
                            <div class="border border-slate-100 rounded-xl p-3.5">
                                <div class="flex items-start justify-between gap-2 mb-1">
                                    <span class="text-[11px] font-bold text-gray-500 tracking-wide">{{ $item->sku }}</span>
                                    <span class="bg-emerald-50 text-emerald-700 text-[10px] px-2 py-0.5 rounded-full font-semibold">{{ $item->status ?: 'Aktif' }}</span>
                                </div>
                                <p class="font-bold text-gray-900 text-sm">{{ $item->nama }}</p>
                                <p class="text-xs text-gray-500">Kategori: <b class="text-gray-700">{{ $item->category?->nama ?? '-' }}</b></p>
                            </div>
                        @empty
                            <div class="text-center py-6"><i class="fas fa-box-open text-2xl text-slate-300"></i><div class="text-[12px] font-bold text-slate-500 mt-2">Belum ada item</div></div>
                        @endforelse
                    </div>
                </div>

                <!-- Pengguna Terbaru -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <div class="flex items-center gap-2"><i class="fas fa-user-plus text-blue-600"></i><div><h3 class="font-bold text-gray-900 text-sm lg:text-base">Pengguna Terbaru</h3><p class="text-[11px] text-gray-500">{{ $hubScoped ? 'Hub '.$hubScopeCode : 'Semua hub' }}</p></div></div>
                        <span class="bg-blue-600 text-white text-[10px] px-2 py-0.5 rounded-full font-semibold">{{ $totalUsers }} Akun</span>
                    </div>
                    <div class="space-y-3">
                        @forelse($recentUsers as $recentUser)
                            <div class="border border-slate-100 rounded-xl p-3.5 flex items-center justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="font-bold text-gray-900 text-sm truncate">{{ $recentUser->nama_lengkap }}</p>
                                    <p class="text-[11px] text-gray-500 truncate">{{ $recentUser->role?->name ?? 'Tanpa peran' }}</p>
                                </div>
                                <span class="text-[10px] px-2 py-0.5 rounded-full font-semibold {{ $recentUser->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ ucfirst($recentUser->status) }}</span>
                            </div>
                        @empty
                            <div class="text-center py-6 text-[12px] text-slate-400">Belum ada pengguna.</div>
                        @endforelse
                        <div class="bg-amber-50 border border-amber-100 rounded-xl p-3 text-[11px] text-amber-700"><i class="fas fa-triangle-exclamation mr-1"></i> Modul stok kritis &amp; persetujuan belum tersedia (tabel stok/transaksi tidak ada).</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(auth()->user()->isHR())
        <!-- HR Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 anim-fade-up delay-1">
            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm metric-card">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center"><i class="fas fa-users text-sm"></i></div>
                    <span class="bg-blue-50 text-blue-600 text-[11px] font-semibold px-2 py-0.5 rounded-full">{{ $usersByRole->count() }} peran</span>
                </div>
                <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider">AKUN PEGAWAI</p>
                <h2 class="text-3xl font-extrabold text-gray-900 my-1">{{ $usersByRole->firstWhere('code', 'pegawai')->users_count ?? 0 }}</h2>
                <p class="text-xs text-blue-500 font-medium"><i class="fas fa-circle-info"></i> {{ $totalUsers }} akun di {{ $hubScopeCode ?? 'semua hub' }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm metric-card">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-green-50 text-green-600 rounded-full flex items-center justify-center"><i class="fas fa-check-circle text-sm"></i></div>
                    <span class="text-green-600 text-[11px] font-semibold">{{ $totalUsers > 0 ? round($activeUsers / $totalUsers * 100) : 0 }}%</span>
                </div>
                <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider">PENGGUNA AKTIF</p>
                <h2 class="text-3xl font-extrabold text-gray-900 my-1">{{ $activeUsers }}</h2>
                <p class="text-xs text-green-600 font-medium"><i class="fas fa-check"></i> Akun berstatus aktif &bull; {{ $hubScopeCode ?? 'Semua hub' }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm metric-card">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center"><i class="fas fa-user-slash text-sm"></i></div>
                    <span class="text-gray-400 text-[11px]">Perlu tinjauan</span>
                </div>
                <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider">AKUN NONAKTIF</p>
                <h2 class="text-3xl font-extrabold text-gray-900 my-1">{{ $inactiveUsers }}</h2>
                <p class="text-xs text-amber-600 font-medium"><i class="fas fa-info-circle"></i> {{ $hubScopeCode ?? 'Semua hub' }} &bull; dapat diaktifkan Super Admin</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm metric-card">
                <div class="flex items-center justify-between mb-2">
                    <div class="w-8 h-8 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center"><i class="fas fa-bolt text-sm"></i></div>
                    <span class="text-green-600 text-[11px] font-semibold"><i class="fas fa-arrow-up"></i>Bulan berjalan</span>
                </div>
                <p class="text-[11px] text-gray-400 font-semibold uppercase tracking-wider">PENGGUNA BARU</p>
                <h2 class="text-3xl font-extrabold text-gray-900 my-1">{{ $newUsersThisMonth }} <span class="text-base font-normal text-gray-600">Akun</span></h2>
                <p class="text-xs text-teal-600 font-medium"><i class="fas fa-calendar"></i> {{ $hubScopeCode ?? 'Semua hub' }} &bull; sejak {{ now()->startOfMonth()->format('d M Y') }}</p>
            </div>
        </div>
        @endif

        @if(auth()->user()->isPegawai())
        <!-- Pegawai Metrics (4 Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6 anim-fade-up">
            <div class="metric-card panel p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-9 h-9 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-box-archive text-blue-600"></i></div>
                    <span class="badge bg-blue-50 text-blue-600 border border-blue-100 uppercase !text-[9.5px]">MASTER DATA</span>
                </div>
                <div class="text-[10.5px] font-bold tracking-[0.07em] text-slate-400 uppercase">TOTAL SKU TERDAFTAR</div>
                <div class="mt-1 flex items-baseline gap-1.5">
                    <span class="text-[32px] font-extrabold text-slate-900 leading-none">{{ number_format($totalItems, 0, ',', '.') }}</span>
                    <span class="text-[13px] font-bold text-slate-400">SKU</span>
                </div>
                <div class="mt-3 flex items-center gap-1.5 text-[11px] text-slate-500 font-medium"><span class="w-1.5 h-1.5 rounded-full bg-slate-400 flex-none"></span> {{ $totalCategories }} kategori barang</div>
            </div>

            <div class="metric-card panel p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-9 h-9 rounded-lg bg-emerald-50 border border-emerald-100 flex items-center justify-center"><i class="fas fa-warehouse text-emerald-600"></i></div>
                    <span class="badge bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase !text-[9.5px]">PENUGASAN</span>
                </div>
                <div class="text-[10.5px] font-bold tracking-[0.07em] text-slate-400 uppercase">HUB ANDA</div>
                <div class="mt-2 text-[15px] font-extrabold text-slate-900 leading-tight">{{ $hub->name ?? 'Belum memilih hub' }}</div>
                <div class="mt-3 flex items-center gap-1.5 text-[11px] text-slate-500 font-medium"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 flex-none"></span> {{ $hub->code ?? 'Pilih hub pada menu hub selection' }}</div>
            </div>

            <div class="metric-card panel p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-9 h-9 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center"><i class="fas fa-sitemap text-indigo-600"></i></div>
                    <span class="badge bg-indigo-50 text-indigo-600 border border-indigo-100 uppercase !text-[9.5px]">PROFIL</span>
                </div>
                <div class="text-[10.5px] font-bold tracking-[0.07em] text-slate-400 uppercase">DIVISI ANDA</div>
                <div class="mt-2 text-[15px] font-extrabold text-slate-900 leading-tight">{{ $user->division?->nama ?? 'Belum ditetapkan' }}</div>
                <div class="mt-3 flex items-center gap-1.5 text-[11px] text-slate-500 font-medium"><i class="fas fa-id-badge text-slate-400"></i> NIP {{ $user->nip ?: '-' }}</div>
            </div>

            <div class="metric-card panel p-5">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-9 h-9 rounded-lg bg-amber-50 border border-amber-100 flex items-center justify-center"><i class="fas fa-list-check text-amber-600"></i></div>
                    <span class="badge bg-slate-100 text-slate-600 border border-slate-200 uppercase !text-[9.5px]">BELUM TERSEDIA</span>
                </div>
                <div class="text-[10.5px] font-bold tracking-[0.07em] text-slate-400 uppercase">TUGAS &amp; OPNAME</div>
                <div class="mt-1 flex items-baseline gap-1.5">
                    <span class="text-[32px] font-extrabold text-slate-400 leading-none">-</span>
                    <span class="text-[13px] font-bold text-slate-400">Tugas</span>
                </div>
                <div class="mt-3 flex items-center gap-1.5 text-[11px] text-slate-500 font-medium"><i class="fas fa-circle-info text-amber-500"></i> Tabel tugas/opname belum ada</div>
            </div>
        </div>
        <!-- Scanner Banner (belum terintegrasi) -->
        <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 mb-6 anim-fade-up">
            <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-5">
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-1.5">
                        <div class="w-8 h-8 rounded bg-slate-400 text-white flex items-center justify-center">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <h2 class="text-[16px] font-extrabold text-slate-700">Hub Pemindaian Barcode &amp; Terminal Handheld</h2>
                        <span class="badge bg-slate-200 text-slate-600 !text-[9.5px] !py-0.5">
                            <i class="fas fa-circle-info"></i> Belum terintegrasi
                        </span>
                    </div>
                    <p class="text-[12px] text-slate-500 ml-10">Integrasi perangkat scanner dan validasi barcode belum tersedia pada backend ini (tidak ada endpoint maupun tabel pemindaian).</p>
                </div>

                <div class="flex items-center gap-4 text-[11.5px] font-semibold text-slate-400 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
                    <span class="flex items-center gap-1.5"><i class="fas fa-battery-three-quarters"></i> Status perangkat: tidak diketahui</span>
                </div>
            </div>

            <div class="mt-5 bg-white p-2 rounded-xl border border-slate-200 flex flex-col sm:flex-row items-center gap-2">
                <div class="relative flex-1 w-full">
                    <i class="fas fa-barcode absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                    <input type="text" disabled class="w-full bg-transparent outline-none pl-11 pr-24 py-2.5 text-[14px] text-slate-400 placeholder-slate-300 cursor-not-allowed" placeholder="Pemindaian barcode belum tersedia">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 bg-slate-100 text-slate-400 text-[10px] font-bold px-2 py-1 rounded">NONAKTIF</span>
                </div>
                <button type="button" disabled class="inline-flex items-center gap-2 w-full sm:w-auto px-6 py-2.5 text-[12.5px] font-semibold text-white bg-slate-300 rounded-xl cursor-not-allowed">
                    <i class="fas fa-search"></i> Cari &amp; Validasi
                </button>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-4">
                <div class="bg-white border border-slate-200 rounded-xl p-3 flex flex-col items-center justify-center gap-1 text-slate-400 opacity-70">
                    <i class="fas fa-arrow-down"></i>
                    <span class="text-[12.5px] font-bold">1. Inbound Cepat</span>
                    <span class="text-[10px] font-medium">Belum tersedia</span>
                </div>
                <div class="bg-white border border-slate-200 rounded-xl p-3 flex flex-col items-center justify-center gap-1 text-slate-400 opacity-70">
                    <i class="fas fa-box"></i>
                    <span class="text-[12.5px] font-bold">2. Outbound Cepat</span>
                    <span class="text-[10px] font-medium">Belum tersedia</span>
                </div>
                <div class="bg-white border border-slate-200 rounded-xl p-3 flex flex-col items-center justify-center gap-1 text-slate-400 opacity-70">
                    <i class="fas fa-search"></i>
                    <span class="text-[12.5px] font-bold">3. Cek Lokasi Rak</span>
                    <span class="text-[10px] font-medium">Belum tersedia</span>
                </div>
                <div class="bg-white border border-slate-200 rounded-xl p-3 flex flex-col items-center justify-center gap-1 text-slate-400 opacity-70">
                    <i class="fas fa-clipboard"></i>
                    <span class="text-[12.5px] font-bold">4. Hitung Fisik</span>
                    <span class="text-[10px] font-medium">Belum tersedia</span>
                </div>
            </div>
        </div>
        @endif

        @if(auth()->user()->isAuditor())
        <!-- Auditor Metrics (4 Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-5 anim-fade-up">
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center"><i class="fas fa-shield-halved text-emerald-600"></i></div>
                    <span class="badge bg-emerald-50 text-emerald-700"><i class="fas fa-database"></i>Tersimpan</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">JEJAK AUDIT TERCATAT</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ number_format($auditLogsTotal, 0, ',', '.') }}</p>
                <p class="text-xs text-emerald-600 mt-1"><i class="fas fa-check-circle mr-1"></i>Bersumber dari tabel audit_logs</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center"><i class="fas fa-triangle-exclamation text-red-600"></i></div>
                    <span class="badge bg-slate-100 text-slate-600">Belum tersedia</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">TEMUAN DISCREPANCY</p>
                <p class="text-3xl font-extrabold text-gray-400 mt-1">-</p>
                <p class="text-xs text-gray-500 mt-1">Tabel temuan/opname belum tersedia</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-users text-blue-600"></i></div>
                    <span class="badge bg-blue-50 text-blue-700">{{ $activeSessions }} sesi aktif</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">PENGGUNA TERDAFTAR</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalUsers }}</p>
                <p class="text-xs text-gray-500 mt-2">{{ $activeUsers }} aktif &bull; {{ $inactiveUsers }} nonaktif &bull; {{ $hubScopeCode ?? 'Semua hub' }}</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center"><i class="fas fa-box-archive text-amber-600"></i></div>
                    <span class="badge bg-gray-50 text-gray-600">Master Data</span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">SKU &amp; KATEGORI</p>
                <p class="text-2xl font-extrabold text-gray-900 mt-1">{{ $totalItems }} <span class="text-sm font-semibold text-gray-500">/ {{ $totalCategories }} kategori</span></p>
                <p class="text-xs text-gray-500 mt-1">{{ $totalSuppliers }} supplier terdaftar</p>
            </div>
        </div>
        <!-- Audit trail info -->
        <div class="bg-slate-800 rounded-xl p-4 flex flex-wrap gap-4 items-center justify-between text-white mb-5 shadow-lg shadow-slate-900/10 anim-fade-up">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-slate-700 rounded-xl border border-slate-600"><i class="fas fa-shield-alt text-emerald-400"></i></div>
                <div>
                    <div class="text-[12px] font-bold text-slate-100">JEJAK AUDIT AKTIF • {{ $auditLogsTotal }} entri</div>
                    <div class="text-[10.5px] text-slate-400 mt-1">Setiap perubahan pengguna dan konfigurasi dicatat pada tabel audit_logs beserta pelaku dan waktunya.</div>
                </div>
            </div>
            <span class="px-4 py-2 bg-slate-700 border border-slate-600 text-slate-300 text-[11.5px] font-semibold rounded-xl">Hash chain &amp; validasi kriptografis belum tersedia</span>
        </div>
        @endif

        @if(auth()->user()->isAuditor())
        <!-- Auditor Main Content Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-6 anim-fade-up">
            <!-- Left 2 Columns -->
            <div class="xl:col-span-2 space-y-5">
                <!-- Chart Card: komposisi kategori (data nyata) -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-chart-pie text-blue-600 mt-1"></i>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm lg:text-base">Komposisi Inventaris per Kategori</h3>
                                <p class="text-xs text-gray-500">Dihitung langsung dari tabel items &amp; categories</p>
                            </div>
                        </div>
                        <span class="badge bg-blue-50 text-blue-700">{{ $totalItems }} SKU</span>
                    </div>
                    <div class="space-y-4">
                        @forelse($itemsByCategory as $category)
                            @php $percent = $totalItems > 0 ? round($category->items_count / $totalItems * 100, 1) : 0; @endphp
                            <div>
                                <div class="flex items-center justify-between text-[12px] mb-1">
                                    <span class="font-semibold text-gray-700">{{ $category->nama }}</span>
                                    <span class="font-bold text-gray-900">{{ $category->items_count }} SKU ({{ $percent }}%)</span>
                                </div>
                                <div class="bg-gray-100 rounded-full h-2 w-full">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <i class="fas fa-chart-pie text-3xl text-slate-300"></i>
                                <div class="text-[12.5px] font-bold text-slate-500 mt-2">Belum ada data kategori/barang</div>
                                <div class="text-[11px] text-slate-400">Tambahkan master data untuk melihat komposisi inventaris.</div>
                            </div>
                        @endforelse
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-5">
                        <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center"><p class="text-[11px] text-gray-500">Kategori</p><p class="font-bold text-gray-900 mt-0.5">{{ $totalCategories }}</p></div>
                        <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center"><p class="text-[11px] text-gray-500">Supplier</p><p class="font-bold text-gray-900 mt-0.5">{{ $totalSuppliers }}</p></div>
                        <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center"><p class="text-[11px] text-gray-500">Hub / Kota</p><p class="font-bold text-gray-900 mt-0.5">{{ $totalHubs }} / {{ $totalCities }}</p></div>
                    </div>
                </div>
                <!-- Log Aktivitas Audit (audit_logs) -->
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="text-[14.5px] font-extrabold text-slate-900">Log Aktivitas Audit Terkini</h2>
                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">Sumber: audit_logs</span>
                    </div>
                    <div class="space-y-4 relative">
                        @forelse($recentAuditLogs->take(4) as $log)
                            <div class="relative flex items-start gap-3.5 pb-4 border-b border-slate-100 last:border-0 last:pb-0">
                                <div class="w-[24px] h-[24px] rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-none">
                                    <i class="fas fa-file-alt text-[10px]"></i>
                                </div>
                                <div>
                                    <div class="text-[12.5px] text-slate-700 leading-tight"><span class="font-bold">{{ $log->user?->nama_lengkap ?? 'Sistem' }}</span> — {{ $log->description ?: ucfirst($log->action) }}</div>
                                    <div class="text-[11px] text-slate-500 mt-1">{{ $log->entity_type }}@if($log->entity_id) #{{ $log->entity_id }}@endif • hasil: {{ $log->result }}</div>
                                    <div class="text-[10px] text-slate-400 mt-1 font-medium">{{ $log->created_at?->diffForHumans() ?? '-' }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-[12px] text-slate-400">Belum ada log audit tercatat.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Activity (audit_logs) -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900">Aktivitas Terkini</h3>
                <span class="text-[11px] font-semibold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full">{{ $auditLogsTotal }} entri audit</span>
            </div>
            <div class="space-y-3">
                @forelse($recentAuditLogs as $log)
                    <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-clock-rotate-left text-blue-600"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">{{ $log->description ?: ucfirst($log->action).' '.$log->entity_type }}</p>
                            <p class="text-xs text-gray-500">{{ $log->user?->nama_lengkap ?? 'Sistem' }} • {{ $log->entity_type }}@if($log->entity_id) #{{ $log->entity_id }}@endif</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $log->created_at?->diffForHumans() ?? '-' }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-[12px] text-slate-400">Belum ada aktivitas tercatat pada audit_logs.</div>
                @endforelse
            </div>
        </div>

    </main>
</div>
</body>
</html>
