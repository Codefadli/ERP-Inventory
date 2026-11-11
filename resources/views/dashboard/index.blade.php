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

<!-- Header -->
<header class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="w-full px-4 lg:px-6 py-3 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-cube text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-base lg:text-lg font-bold text-gray-900">Astro Inventory</h1>
                <p class="text-xs text-gray-500">Sistem Inventaris Terpadu</p>
            </div>
            @if(auth()->user()->selectedHub)
            <div class="hidden lg:flex items-center gap-2 ml-4 bg-blue-50 text-blue-700 px-3 py-1.5 rounded-full text-xs font-medium">
                <i class="fas fa-building"></i>
                <span>{{ auth()->user()->selectedHub->name }}</span>
            </div>
            @endif
            <span class="hidden lg:inline-flex items-center gap-1 bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-semibold">
                <i class="fas fa-circle text-[5px]"></i> Operasional Normal
            </span>
        </div>
        <div class="flex items-center gap-3">
            <button class="relative p-2.5 text-gray-600 hover:bg-gray-100 rounded-lg">
                <i class="fas fa-bell text-lg"></i>
                <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
            </button>
            <div class="flex items-center gap-2 pl-3 border-l border-gray-200">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->nama_lengkap }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->role->name }}</p>
                </div>
                <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 2)) }}
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="ml-2">
                @csrf
                <button type="submit" class="text-sm text-gray-600 hover:text-red-600 px-3 py-2 rounded-lg hover:bg-red-50">
                    <i class="fas fa-sign-out-alt mr-1"></i> Keluar
                </button>
            </form>
        </div>
    </div>
</header>

<div class="flex min-h-screen">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 hidden lg:block overflow-y-auto">
        <nav class="p-3">
            <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2">Menu Utama</p>
            <a href="{{ route(auth()->user()->isSuperAdmin() ? 'admin.dashboard' : (auth()->user()->isKepalaGudang() ? 'gudang.dashboard' : (auth()->user()->isHR() ? 'hr.dashboard' : (auth()->user()->isPegawai() ? 'pegawai.dashboard' : 'audit.dashboard')))) }}" class="nav-link active flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-1">
                <i class="fas fa-th-large w-4"></i>
                <span>Dashboard</span>
            </a>
            
            @if(auth()->user()->isSuperAdmin())
            <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Manajemen Sistem</p>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-users w-4"></i>
                <span>Manajemen Pengguna</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-user-shield w-4"></i>
                <span>Role & Permission</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-file-alt w-4"></i>
                <span>Log Aktivitas</span>
            </a>
            
            <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Master Data</p>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-boxes w-4"></i>
                <span>Data Barang</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-warehouse w-4"></i>
                <span>Data Gudang & Lokasi</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-building w-4"></i>
                <span>Data Departemen</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-truck w-4"></i>
                <span>Data Supplier</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-tags w-4"></i>
                <span>Kategori Barang</span>
            </a>
            
            <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Operasional</p>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-arrow-down w-4"></i>
                <span>Barang Masuk</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-arrow-up w-4"></i>
                <span>Barang Keluar</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-exchange-alt w-4"></i>
                <span>Mutasi Barang</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-clipboard-check w-4"></i>
                <span>Stok Opname</span>
            </a>
            
            <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Laporan & Analitik</p>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-chart-bar w-4"></i>
                <span>Laporan & Analitik</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-history w-4"></i>
                <span>Laporan & Riwayat</span>
            </a>
            
            <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Persetujuan</p>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-file-contract w-4"></i>
                <span>Persetujuan Barang</span>
            </a>
            @endif
            
            @if(auth()->user()->isKepalaGudang())
            <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Master Data & Inventaris</p>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-boxes w-4"></i>
                <span>Data Barang</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-warehouse w-4"></i>
                <span>Data Gudang & Lokasi</span>
            </a>
            
            <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Operasional & Transaksi</p>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-truck-loading w-4"></i>
                <span>Barang Masuk</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-truck w-4"></i>
                <span>Barang Keluar</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-exchange-alt w-4"></i>
                <span>Mutasi Barang</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-clipboard-check w-4"></i>
                <span>Stok Opname</span>
            </a>
            <a href="#" class="nav-link flex items-center justify-between gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <div class="flex items-center gap-3">
                    <i class="fas fa-file-contract w-4"></i>
                    <span>Persetujuan Barang</span>
                </div>
                <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">5</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-chart-bar w-4"></i>
                <span>Laporan & Analitik</span>
            </a>
            @endif
            
            @if(auth()->user()->isHR())
            <!-- HR Menu -->
            <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Operasional & Persetujuan</p>
            <a href="#" class="nav-link flex items-center justify-between gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <div class="flex items-center gap-3">
                    <i class="fas fa-clock w-4"></i>
                    <span>Antrean Persetujuan</span>
                </div>
                <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">5</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-file-alt w-4"></i>
                <span>Detail Permintaan</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-history w-4"></i>
                <span>Riwayat Persetujuan</span>
            </a>
            
            <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Manajemen & Laporan</p>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-chart-line w-4"></i>
                <span>Laporan Inventaris</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-shield-alt w-4"></i>
                <span>Log Audit & Otorisasi</span>
            </a>
            @endif
            
            @if(auth()->user()->isPegawai())
            <!-- Pegawai Menu -->
            <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Operasional Gudang</p>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-arrow-down w-4"></i>
                <span>Barang Masuk</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-arrow-up w-4"></i>
                <span>Barang Keluar</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-clipboard-check w-4"></i>
                <span>Stok Opname</span>
            </a>
            
            <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Monitoring & Laporan</p>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-history w-4"></i>
                <span>Riwayat Transaksi</span>
            </a>
            <a href="#" class="nav-link flex items-center justify-between gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <div class="flex items-center gap-3">
                    <i class="fas fa-tasks w-4"></i>
                    <span>Status Permintaan</span>
                </div>
                <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">2</span>
            </a>
            @endif
            
            @if(auth()->user()->isAuditor())
            <!-- Auditor Menu -->
            <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Audit & Pemeriksaan</p>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-arrow-down w-4"></i>
                <span>Barang Masuk</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-arrow-up w-4"></i>
                <span>Barang Keluar</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-exchange-alt w-4"></i>
                <span>Mutasi Barang</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-boxes w-4"></i>
                <span>Data Barang</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-warehouse w-4"></i>
                <span>Data Gudang & Lokasi</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-clipboard-check w-4"></i>
                <span>Stok Opname</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-exclamation-triangle w-4"></i>
                <span>Temuan Audit</span>
            </a>
            @endif
            
            <!-- Common Menu for All Roles -->
            <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Pengaturan & Akun</p>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-bell w-4"></i>
                <span>Notifikasi</span>
            </a>
            <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-cog w-4"></i>
                <span>Pengaturan</span>
            </a>
            <a href="{{ route('profile.show') }}" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
                <i class="fas fa-user w-4"></i>
                <span>Profil Saya</span>
            </a>
        </nav>
        
        <!-- Sidebar Footer Info (for Pegawai & Kepala Gudang) -->
        @if(auth()->user()->isPegawai() || auth()->user()->isKepalaGudang())
        <div class="m-3 p-3 bg-blue-50 border border-blue-100 rounded-lg">
            <p class="text-[11px] font-bold text-blue-700 mb-1">
                <i class="fas fa-headset mr-1"></i>Bantuan {{ auth()->user()->selectedHub ? auth()->user()->selectedHub->name : 'DC-01' }}
            </p>
            <p class="text-[10px] text-blue-700/70 mb-2">Hotline Logistik & Tim WMS aktif 24/7.</p>
            <button class="w-full text-[11px] py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Hubungi
            </button>
        </div>
        @endif
    </aside>

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
        <!-- Pegawai Header -->
        <div class="mb-4 flex flex-wrap items-end justify-between gap-3">
            <div>
                <p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">
                    Portal Operasional Pegawai / Monitoring & Laporan / 
                    <span class="text-blue-700">Status & Pelacakan Permintaan Operasional</span>
                </p>
                <h1 class="mt-1 text-[24px] font-bold leading-tight tracking-tight">Status Permintaan Staf & Logistik</h1>
                <p class="mt-1.5 max-w-3xl text-[12px] leading-relaxed text-slate-500">
                    Pantau status pengajuan izin barang keluar darurat, penggantian alat scanner rusak, penambahan pallet/box, dan pengadaan perlengkapan operasional shift.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button class="flex h-10 items-center rounded-md border border-slate-100 bg-white px-4 text-[12px] font-semibold text-slate-700 shadow-sm">
                    Riwayat Tiket Selesai
                </button>
                <button class="flex h-10 items-center gap-2 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white shadow-sm hover:bg-blue-700">
                    <i class="fas fa-plus"></i>Buat Pengajuan / Permintaan Baru
                </button>
            </div>
        </div>
        @endif
        
        @if(auth()->user()->isAuditor())
        <!-- Auditor Header -->
        <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
            <span>Beranda</span>
            <i class="fas fa-chevron-right text-[9px]"></i>
            <span class="text-blue-600 font-semibold">Dashboard Auditor</span>
        </div>
        
        <div class="mb-6">
            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 mb-1">Dashboard Audit & Pemeriksaan</h1>
            <p class="text-sm text-gray-600">Monitoring audit inventory, temuan critical, dan compliance rate sistem inventaris.</p>
        </div>
        @endif

        <!-- Metrics Grid -->
        @if(auth()->user()->isSuperAdmin())
        <!-- Super Admin Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6 anim-fade-up delay-1">
            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users-gear text-blue-600"></i>
                    </div>
                    <span class="bg-emerald-50 text-emerald-700 text-[11px] font-semibold px-2 py-0.5 rounded-full flex items-center gap-1">
                        <i class="fas fa-arrow-trend-up"></i>+12% bln lalu
                    </span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">TOTAL PENGGUNA & ADMIN</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">1,420</p>
                <p class="text-xs text-gray-500 mt-1">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full inline-block mr-1"></span>18 Admin Hub aktif bertugas
                </p>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box-archive text-blue-600"></i>
                    </div>
                    <span class="bg-blue-50 text-blue-700 text-[11px] font-semibold px-2 py-0.5 rounded-full flex items-center gap-1">
                        <i class="fas fa-bullseye"></i>99.8% Akurasi
                    </span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">SKU AKTIF TERSIMPAN</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">8,650 <span class="text-sm font-semibold text-gray-500">SKU</span></p>
                <p class="text-xs text-emerald-600 mt-1">
                    <i class="fas fa-circle-check"></i> 99.2% Stok Tersedia Siap Alokasi
                </p>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-circle-check text-emerald-600"></i>
                    </div>
                    <span class="bg-emerald-50 text-emerald-700 text-[11px] font-semibold px-2 py-0.5 rounded-full flex items-center gap-1">
                        <i class="fas fa-arrow-up"></i>+8.4% target
                    </span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">BARANG MASUK HARI INI</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">1,240 <span class="text-sm font-semibold text-gray-500">Unit</span></p>
                <p class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-file-lines mr-1"></i>12 Surat Jalan Selesai
                </p>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                <div class="flex items-start justify-between mb-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-arrow-up-from-bracket text-blue-600"></i>
                    </div>
                    <span class="bg-emerald-50 text-emerald-700 text-[11px] font-semibold px-2 py-0.5 rounded-full flex items-center gap-1">
                        <i class="fas fa-rocket"></i>100% Siap
                    </span>
                </div>
                <p class="text-[11px] font-bold text-gray-500 tracking-wide mt-2">BARANG KELUAR HARI INI</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">980 <span class="text-sm font-semibold text-gray-500">Unit</span></p>
                <p class="text-xs text-gray-500 mt-1">
                    <i class="fas fa-truck-fast mr-1"></i>94 Batch Pengiriman Siap Dispatch
                </p>
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
        <!-- Pegawai Metrics -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-4">
                        <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center hover:bg-blue-50 transition">
                            <p class="text-[11px] text-gray-500">Rata-rata Harian</p>
                            <p class="font-bold text-gray-900 mt-0.5">1.202 <span class="text-xs font-semibold text-gray-500">Unit/Hari</span></p>
                        </div>
                        <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center hover:bg-blue-50 transition">
                            <p class="text-[11px] text-gray-500">Puncak Throughput</p>
                            <p class="font-bold text-blue-600 mt-0.5">Sabtu (1.480 Unit)</p>
                        </div>
                        <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-3 text-center hover:bg-blue-50 transition">
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
                            <h3 class="font-bold text-gray-900 text-base">Log Aktivitas Terkini (User & Admin)</h3>
                        </div>
                        <button class="text-sm font-semibold text-blue-600 hover:text-blue-800 hover:underline">
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
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-2 mb-4">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-triangle-exclamation text-red-500 mt-1"></i>
                            <div>
                                <h3 class="font-bold text-gray-900 text-base">Stok Kritis & Menipis</h3>
                                <p class="text-xs text-gray-500">Stok di bawah Reorder Point (ROP)</p>
                            </div>
                        </div>
                        <span class="badge bg-red-600 text-white text-[10px]">3 SKU Kritis</span>
                    </div>

                    <div class="space-y-4">
                        <!-- Item 1 -->
                        <div>
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
                        </div>

                        <!-- Item 2 -->
                        <div>
                            <div class="flex items-start justify-between mb-1">
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
                        </div>

                        <!-- Item 3 -->
                        <div>
                            <div class="flex items-start justify-between mb-1">
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
                </div>

                <!-- Menunggu Persetujuan -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-hourglass-half text-blue-600"></i>
                            <h3 class="font-bold text-gray-900 text-base">Menunggu Persetujuan</h3>
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
        <!-- Pegawai Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3 mb-4">
            <div class="min-h-[112px] rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                <p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Total Pengajuan Shift Ini</p>
                <b class="mt-1.5 block text-[24px] font-bold leading-tight tracking-tight">8 Permintaan</b>
                <span class="mt-2.5 inline-block rounded bg-blue-50 px-1.5 py-0.5 text-[10.5px] font-semibold text-blue-700">+2 hari ini</span>
                <small class="ml-1 text-[10.5px] text-slate-500">Shift Aktif Pagi</small>
            </div>
            
            <div class="min-h-[112px] rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                <p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Menunggu Otorisasi</p>
                <b class="mt-1.5 block text-[24px] font-bold leading-tight tracking-tight">2 Tiket</b>
                <span class="mt-2.5 inline-block rounded bg-amber-50 px-1.5 py-0.5 text-[10.5px] font-semibold text-amber-700">Perlu Review</span>
            </div>
            
            <div class="min-h-[112px] rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                <p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Disetujui & Siap Diambil</p>
                <b class="mt-1.5 block text-[24px] font-bold leading-tight tracking-tight">5 Tiket</b>
                <span class="mt-2.5 inline-block rounded bg-emerald-50 px-1.5 py-0.5 text-[10.5px] font-semibold text-emerald-700">Siap Dispatch</span>
            </div>
            
            <div class="min-h-[112px] rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                <p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Ditolak / Dibatalkan</p>
                <b class="mt-1.5 block text-[24px] font-bold leading-tight tracking-tight">1 Tiket</b>
                <span class="mt-2.5 inline-block rounded bg-red-50 px-1.5 py-0.5 text-[10.5px] font-semibold text-red-700">Kuota Habis</span>
            </div>
        </div>
        
        <!-- Info Banner -->
        <div class="mb-4 flex flex-wrap items-center justify-between gap-3 rounded-lg border border-blue-100 bg-blue-50/70 p-4 text-[10.5px]">
            <div class="flex items-center gap-3">
                <i class="fas fa-info-circle text-blue-600"></i>
                <div>
                    <b class="text-[12px]">Prioritas Pemrosesan Permintaan Darurat Aktif</b>
                    <p class="mt-0.5 text-slate-600">
                        Ticket kategori <b class="text-red-600">DARURAT</b> (Hardware/Alat Kerja) akan langsung dikirim ke notifikasi prioritas Kepala Gudang (SLA response time < 30 menit).
                    </p>
                </div>
            </div>
            <span class="rounded bg-white px-3 py-1.5 text-[10.5px] text-slate-500">Antrean Live: #REQ-2025-1042</span>
        </div>
        @endif

        @if(auth()->user()->isAuditor())
        <!-- Auditor Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="metric-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Bulan Ini</span>
                </div>
                <h3 class="text-sm font-medium text-gray-600 mb-1">Total Audit</h3>
                <p class="text-2xl font-bold text-gray-900">18</p>
                <p class="text-xs text-gray-500 mt-1">5 audit selesai</p>
            </div>

            <div class="metric-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-red-600 bg-red-50 px-2 py-1 rounded-full">Critical</span>
                </div>
                <h3 class="text-sm font-medium text-gray-600 mb-1">Temuan Critical</h3>
                <p class="text-2xl font-bold text-gray-900">3</p>
                <p class="text-xs text-gray-500 mt-1">Perlu tindakan segera</p>
            </div>

            <div class="metric-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-amber-600 text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Open</span>
                </div>
                <h3 class="text-sm font-medium text-gray-600 mb-1">Temuan Terbuka</h3>
                <p class="text-2xl font-bold text-gray-900">12</p>
                <p class="text-xs text-gray-500 mt-1">Dalam follow-up</p>
            </div>

            <div class="metric-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">Closed</span>
                </div>
                <h3 class="text-sm font-medium text-gray-600 mb-1">Compliance Rate</h3>
                <p class="text-2xl font-bold text-gray-900">94.2%</p>
                <p class="text-xs text-gray-500 mt-1">Target: 95%</p>
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
