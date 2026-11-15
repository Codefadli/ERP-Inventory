@extends('layouts.app')

@section('title', 'Dokumentasi & Bantuan - ASTRO INVENTORY')

@section('styles')
<style>
    /* Animations */
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .animate-fade-in-down {
        animation: fadeInDown 0.6s ease-out;
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    .animate-fade-in {
        animation: fadeIn 0.8s ease-out;
    }

    .animate-scale-in {
        animation: scaleIn 0.5s ease-out;
    }

    .animate-slide-in-left {
        animation: slideInLeft 0.6s ease-out;
    }

    .animate-slide-in-right {
        animation: slideInRight 0.6s ease-out;
    }

    .float-animation {
        animation: float 3s ease-in-out infinite;
    }

    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    .stagger-3 { animation-delay: 0.3s; }
    .stagger-4 { animation-delay: 0.4s; }
    .stagger-5 { animation-delay: 0.5s; }
    .stagger-6 { animation-delay: 0.6s; }

    /* Card Hover Effects */
    .hover-lift {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
    }

    .role-card {
        transition: all 0.3s ease;
    }

    .role-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.2);
    }

    /* Search Bar */
    .search-container {
        transition: all 0.3s ease;
    }

    .search-container:focus-within {
        transform: scale(1.02);
        box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.3);
    }

    /* Accordion */
    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-out, opacity 0.3s ease-out;
        opacity: 0;
    }

    .accordion-content.active {
        max-height: 500px;
        opacity: 1;
    }

    /* Tag Hover */
    .tag-pill {
        transition: all 0.2s ease;
    }

    .tag-pill:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Smooth Scroll */
    html {
        scroll-behavior: smooth;
    }

    /* Button Ripple Effect */
    .btn-ripple {
        position: relative;
        overflow: hidden;
    }

    .btn-ripple::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-ripple:active::after {
        width: 300px;
        height: 300px;
    }
</style>
@endsection

@section('content')

<!-- Navbar -->
<nav class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center space-x-3 animate-fade-in-down">
                <div class="w-10 h-10 bg-blue-600 rounded flex items-center justify-center">
                    <i class="fas fa-cube text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-900">ASTRO INVENTORY</h1>
                    <p class="text-xs text-gray-500">WMS Enterprise Edition</p>
                </div>
            </div>

            <!-- Menu -->
            <div class="hidden md:flex items-center space-x-8 animate-fade-in-down stagger-1">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 transition-colors">Beranda</a>
                <a href="#status-server" class="text-gray-700 hover:text-blue-600 transition-colors">Status Server</a>
                <a href="{{ route('documentation') }}" class="text-blue-600 font-semibold">Dokumentasi & Bantuan</a>
            </div>

            <!-- CTA Button -->
            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-all animate-fade-in-down stagger-2">
                Masuk ke Portal
            </a>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="pt-20 pb-12">

    <!-- Breadcrumb -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <div class="flex items-center justify-between bg-blue-50 border border-blue-200 rounded-lg p-4 animate-fade-in-down">
            <div class="flex items-center space-x-2 text-sm">
                <i class="fas fa-home text-blue-600"></i>
                <span class="text-gray-600">Beranda</span>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-900 font-semibold">Pusat Dokumentasi & Bantuan</span>
            </div>
            <div class="flex items-center space-x-2 text-sm text-blue-700">
                <i class="fas fa-clock"></i>
                <span class="font-medium">Pembaruan Terakhir: 14 Okt 2026, 06:30 WIB</span>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <div class="text-center animate-fade-in-up">
            <span class="inline-block bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                ENTERPRISE KNOWLEDGE ENGINE ASTRO WMS
            </span>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Pusat Bantuan, Dokumentasi SOP & Panduan Operasional ASTRO
            </h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Panduan lengkap kerja inventaris terintegrasi mulai dari konfigurasi master data, pemindaian RFID dan barcode, 
                hingga approval workflow mutasi stok antar-DC dengan standar kepatuhan ISO 27001.
            </p>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        <div class="search-container bg-white rounded-xl shadow-lg p-2 border border-gray-200 animate-scale-in">
            <div class="flex items-center">
                <i class="fas fa-search text-gray-400 text-xl ml-4"></i>
                <input 
                    type="text" 
                    placeholder="Cari panduan, SOP mutasi, kode error scanner, atau regulasi RBAC..."
                    class="flex-1 px-4 py-4 text-lg outline-none"
                >
                <button class="btn-ripple bg-blue-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-blue-700 transition-all flex items-center space-x-2">
                    <span>Cari</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- Quick Filter Tags -->
        <div class="mt-6 text-center animate-fade-in-up stagger-1">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-3">PENCARIAN POPULER</p>
            <div class="flex flex-wrap items-center justify-center gap-3">
                <button class="tag-pill bg-white border border-gray-300 px-4 py-2 rounded-full text-sm font-medium text-gray-700 hover:border-blue-500 hover:text-blue-600 flex items-center space-x-2">
                    <i class="fas fa-user"></i>
                    <span>Alur Approval HR</span>
                </button>
                <button class="tag-pill bg-white border border-gray-300 px-4 py-2 rounded-full text-sm font-medium text-gray-700 hover:border-blue-500 hover:text-blue-600 flex items-center space-x-2">
                    <i class="fas fa-barcode"></i>
                    <span>Transaksi Scanner Handheld</span>
                </button>
                <button class="tag-pill bg-white border border-gray-300 px-4 py-2 rounded-full text-sm font-medium text-gray-700 hover:border-blue-500 hover:text-blue-600 flex items-center space-x-2">
                    <i class="fas fa-file-alt"></i>
                    <span>Format Input SKU</span>
                </button>
                <button class="tag-pill bg-white border border-gray-300 px-4 py-2 rounded-full text-sm font-medium text-gray-700 hover:border-blue-500 hover:text-blue-600 flex items-center space-x-2">
                    <i class="fas fa-box"></i>
                    <span>Stock Opname Fisik</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="hover-lift bg-white rounded-xl p-6 shadow-md border border-gray-200 animate-scale-in stagger-1">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-book text-blue-600 text-xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-1">148</h3>
                <p class="text-sm text-gray-600">Modul Dokumentasi</p>
                <p class="text-xs text-gray-500 mt-1">PDF, PowerPoint dan Wiki</p>
            </div>

            <div class="hover-lift bg-white rounded-xl p-6 shadow-md border border-gray-200 animate-scale-in stagger-2">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-clock text-green-600 text-xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-1">≤ 3.2 Menit</h3>
                <p class="text-sm text-gray-600">Rata-rata Waktu Baca</p>
                <p class="text-xs text-gray-500 mt-1">Per dokumen SOP</p>
            </div>

            <div class="hover-lift bg-white rounded-xl p-6 shadow-md border border-gray-200 animate-scale-in stagger-3">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-shield-alt text-purple-600 text-xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-1">5 Role</h3>
                <p class="text-sm text-gray-600">RBAC Hak Akses</p>
                <p class="text-xs text-gray-500 mt-1">Peran di sistem</p>
            </div>

            <div class="hover-lift bg-white rounded-xl p-6 shadow-md border border-gray-200 animate-scale-in stagger-4">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-server text-orange-600 text-xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-1">4 DC Hub</h3>
                <p class="text-sm text-gray-600">Distribusi Konten</p>
                <p class="text-xs text-gray-500 mt-1">Terpusat nasional</p>
            </div>

        </div>
    </div>

    <!-- Panduan Berdasarkan Role -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="text-center mb-10 animate-fade-in-up">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Panduan Cepat Berdasarkan Role</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Akses panduan spesifik sesuai peran operasional Anda di sistem ASTRO untuk efisiensi kerja maksimal.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Role 1: Super Admin -->
            <div class="role-card bg-white rounded-xl p-6 shadow-md border-2 border-blue-500 animate-slide-in-left stagger-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-shield text-white text-2xl"></i>
                    </div>
                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">Fase 1</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Super Admin</h3>
                <p class="text-sm text-gray-600 mb-4">Pengelolaan arsitektur sistem dan konfigurasi master</p>
                <ul class="space-y-2 mb-4">
                    <li class="flex items-start text-sm text-gray-700">
                        <i class="fas fa-check text-blue-600 mr-2 mt-1"></i>
                        <span>Konfigurasi Matrix RBAC</span>
                    </li>
                    <li class="flex items-start text-sm text-gray-700">
                        <i class="fas fa-check text-blue-600 mr-2 mt-1"></i>
                        <span>Integrasi Oracle ERP</span>
                    </li>
                    <li class="flex items-start text-sm text-gray-700">
                        <i class="fas fa-check text-blue-600 mr-2 mt-1"></i>
                        <span>Audit Trail Sys (Dev)</span>
                    </li>
                </ul>
                <a href="#" class="text-blue-600 hover:text-blue-700 font-semibold text-sm flex items-center space-x-2">
                    <span>Buka Modul Admin</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <!-- Role 2: Kepala Gudang -->
            <div class="role-card bg-white rounded-xl p-6 shadow-md border-2 border-green-500 animate-slide-in-left stagger-2">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-briefcase text-white text-2xl"></i>
                    </div>
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Fase 2</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Kepala Gudang</h3>
                <p class="text-sm text-gray-600 mb-4">Keputusan operasional dan kontrol stok gudang</p>
                <ul class="space-y-2 mb-4">
                    <li class="flex items-start text-sm text-gray-700">
                        <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                        <span>Set Reorder Point (SOP)</span>
                    </li>
                    <li class="flex items-start text-sm text-gray-700">
                        <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                        <span>Otorisasi Mutasi Stok DC</span>
                    </li>
                    <li class="flex items-start text-sm text-gray-700">
                        <i class="fas fa-check text-green-600 mr-2 mt-1"></i>
                        <span>Laporan & Tutup Stok Bulanan</span>
                    </li>
                </ul>
                <a href="#" class="text-green-600 hover:text-green-700 font-semibold text-sm flex items-center space-x-2">
                    <span>Buka Panduan Manajer</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <!-- Role 3: HR / Approver -->
            <div class="role-card bg-white rounded-xl p-6 shadow-md border-2 border-purple-500 animate-slide-in-left stagger-3">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-signature text-white text-2xl"></i>
                    </div>
                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold">Fase 3</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">HR / Approver</h3>
                <p class="text-sm text-gray-600 mb-4">Verifikasi mutasi dan persetujuan workflow</p>
                <ul class="space-y-2 mb-4">
                    <li class="flex items-start text-sm text-gray-700">
                        <i class="fas fa-check text-purple-600 mr-2 mt-1"></i>
                        <span>Validasi Tanda Pengiriman</span>
                    </li>
                    <li class="flex items-start text-sm text-gray-700">
                        <i class="fas fa-check text-purple-600 mr-2 mt-1"></i>
                        <span>Persetujuan Alokasi</span>
                    </li>
                    <li class="flex items-start text-sm text-gray-700">
                        <i class="fas fa-check text-purple-600 mr-2 mt-1"></i>
                        <span>Tracking Approval Period (SoD)</span>
                    </li>
                </ul>
                <a href="#" class="text-purple-600 hover:text-purple-700 font-semibold text-sm flex items-center space-x-2">
                    <span>Buka Portal Approval</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <!-- Role 4: Petugas Gudang -->
            <div class="role-card bg-white rounded-xl p-6 shadow-md border-2 border-orange-500 animate-slide-in-right stagger-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-orange-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-dolly text-white text-2xl"></i>
                    </div>
                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold">Fase 4</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Petugas Gudang</h3>
                <p class="text-sm text-gray-600 mb-4">Administrasi operasional harian gudang</p>
                <ul class="space-y-2 mb-4">
                    <li class="flex items-start text-sm text-gray-700">
                        <i class="fas fa-check text-orange-600 mr-2 mt-1"></i>
                        <span>Form RFQ Inbound</span>
                    </li>
                    <li class="flex items-start text-sm text-gray-700">
                        <i class="fas fa-check text-orange-600 mr-2 mt-1"></i>
                        <span>Persetujuan Inbound Vendor</span>
                    </li>
                    <li class="flex items-start text-sm text-gray-700">
                        <i class="fas fa-check text-orange-600 mr-2 mt-1"></i>
                        <span>Picking & Packing Outbound</span>
                    </li>
                </ul>
                <a href="#" class="text-orange-600 hover:text-orange-700 font-semibold text-sm flex items-center space-x-2">
                    <span>Buka Panduan Checklist</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <!-- Role 5: Auditor Logistik -->
            <div class="role-card bg-white rounded-xl p-6 shadow-md border-2 border-gray-500 animate-slide-in-right stagger-5 md:col-span-2 lg:col-span-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gray-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clipboard-check text-white text-2xl"></i>
                    </div>
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">Auditor</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Auditor Logistik</h3>
                <p class="text-sm text-gray-600 mb-4">Pemeriksaan kepatuhan dan laporan audit</p>
                <ul class="space-y-2 mb-4">
                    <li class="flex items-start text-sm text-gray-700">
                        <i class="fas fa-check text-gray-600 mr-2 mt-1"></i>
                        <span>Manifest Cross-Dock</span>
                    </li>
                    <li class="flex items-start text-sm text-gray-700">
                        <i class="fas fa-check text-gray-600 mr-2 mt-1"></i>
                        <span>Integrasi Master Antar DC</span>
                    </li>
                    <li class="flex items-start text-sm text-gray-700">
                        <i class="fas fa-check text-gray-600 mr-2 mt-1"></i>
                        <span>Rekonsiliasi Log Berkala</span>
                    </li>
                </ul>
                <a href="#" class="text-gray-600 hover:text-gray-700 font-semibold text-sm flex items-center space-x-2">
                    <span>Buka Modul Audit</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

        </div>
    </div>

    <!-- Kategori Dokumentasi -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="text-center mb-10 animate-fade-in-up">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Kategori Dokumentasi & SOP Unggulan</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Panduan pengembangan fitur, troubleshooting, dan best practice operasional pergudangan.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Kategori 1: SOP Gudang -->
            <div class="hover-lift bg-white rounded-xl p-6 shadow-md border border-gray-200 animate-scale-in stagger-1">
                <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-file-contract text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">SOP Gudang & Material</h3>
                <p class="text-sm text-gray-600 mb-6">Prosedur standar inbound, outbound, dan stock opname fisik</p>
                
                <div class="space-y-4">
                    <div class="border-l-4 border-blue-500 pl-4">
                        <h4 class="font-semibold text-gray-900 text-sm mb-1">Prosedur 4.1: Penerimaan Inbound Vendor (Surat Jalan & PO)</h4>
                        <p class="text-xs text-gray-600">35+ Dokumen</p>
                    </div>
                    <div class="border-l-4 border-blue-300 pl-4">
                        <h4 class="font-semibold text-gray-900 text-sm mb-1">WMS-WHB-017: Outbound & Surat Jalan Operasional</h4>
                        <p class="text-xs text-gray-600">8 Artikel</p>
                    </div>
                    <div class="border-l-4 border-blue-200 pl-4">
                        <h4 class="font-semibold text-gray-900 text-sm mb-1">SOP-INBD-027: Alur Re-verifikasi Barang Rusak & Adv</h4>
                        <p class="text-xs text-gray-600">Keselamatan</p>
                    </div>
                </div>

                <a href="#" class="mt-6 text-blue-600 hover:text-blue-700 font-semibold text-sm flex items-center space-x-2">
                    <span>Lihat Serie SOP</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <!-- Kategori 2: Hardware & Handheld -->
            <div class="hover-lift bg-white rounded-xl p-6 shadow-md border border-gray-200 animate-scale-in stagger-2">
                <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-barcode text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Integrasi Hardware & Handheld</h3>
                <p class="text-sm text-gray-600 mb-6">Panduan konfigurasi perangkat scanner, printer, dan jaringan</p>
                
                <div class="space-y-4">
                    <div class="border-l-4 border-green-500 pl-4">
                        <h4 class="font-semibold text-gray-900 text-sm mb-1">HW-SCAN-164: Konfigurasi Handheld Scanner 2D & RFID</h4>
                        <p class="text-xs text-gray-600">54+ Artikel, 12k+ Views</p>
                    </div>
                    <div class="border-l-4 border-green-300 pl-4">
                        <h4 class="font-semibold text-gray-900 text-sm mb-1">NET-WIFI-009: Setting Wi-Fi Lorong Racking & Gateway</h4>
                        <p class="text-xs text-gray-600">Khusus DC-01</p>
                    </div>
                    <div class="border-l-4 border-green-200 pl-4">
                        <h4 class="font-semibold text-gray-900 text-sm mb-1">HW-Printer-001: Kalibrasi Printer Barcode Zebra & Postek</h4>
                        <p class="text-xs text-gray-600">18k+ Users</p>
                    </div>
                </div>

                <a href="#" class="mt-6 text-green-600 hover:text-green-700 font-semibold text-sm flex items-center space-x-2">
                    <span>Pusat Hardware</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <!-- Kategori 3: Keamanan & Kepatuhan -->
            <div class="hover-lift bg-white rounded-xl p-6 shadow-md border border-gray-200 animate-scale-in stagger-3">
                <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-shield-alt text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Keamanan & Kepatuhan Akses</h3>
                <p class="text-sm text-gray-600 mb-6">Otentikasi LDAP, SSO, backup, dan compliance audit</p>
                
                <div class="space-y-4">
                    <div class="border-l-4 border-red-500 pl-4">
                        <h4 class="font-semibold text-gray-900 text-sm mb-1">SEC-POL-001: Kebijakan Brute-Force Lockout (5x Gagal)</h4>
                        <p class="text-xs text-gray-600">Data Lockdown</p>
                    </div>
                    <div class="border-l-4 border-red-300 pl-4">
                        <h4 class="font-semibold text-gray-900 text-sm mb-1">SEC-SSO-004: Penggunaan Kredensial & Reset 2FA</h4>
                        <p class="text-xs text-gray-600">SSO / Google Auth</p>
                    </div>
                    <div class="border-l-4 border-red-200 pl-4">
                        <h4 class="font-semibold text-gray-900 text-sm mb-1">SEC-SOD-002: Hak Akses & Pemisahan Tugas</h4>
                        <p class="text-xs text-gray-600">Segregation of Duties</p>
                    </div>
                </div>

                <a href="#" class="mt-6 text-red-600 hover:text-red-700 font-semibold text-sm flex items-center space-x-2">
                    <span>SI Regulasi ISO [27001]</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

        </div>
    </div>

    <!-- Alur Penyelesaian Kendala -->
    <div class="bg-gradient-to-br from-blue-600 to-blue-700 py-16 mb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10 animate-fade-in-up">
                <h2 class="text-3xl font-bold text-white mb-3">Alur Penyelesaian Kendala Operasional Gudang</h2>
                <p class="text-blue-100 max-w-2xl mx-auto">
                    Panduan troubleshooting cepat dalam 10 menit untuk mengatasi masalah harian di lapangan
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-6 border border-white border-opacity-20 hover:bg-opacity-20 transition-all animate-scale-in stagger-1">
                    <div class="w-14 h-14 bg-white rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-clipboard-list text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">1. Identifikasi Awal Gejala</h3>
                    <p class="text-sm text-blue-100">Catat kode error yang tertera di layar atau sistem</p>
                </div>

                <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-6 border border-white border-opacity-20 hover:bg-opacity-20 transition-all animate-scale-in stagger-2">
                    <div class="w-14 h-14 bg-white rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-search text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">2. Via Knowledge Base</h3>
                    <p class="text-sm text-blue-100">Gunakan kotak pencarian untuk akses dokumentasi relevan</p>
                </div>

                <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-6 border border-white border-opacity-20 hover:bg-opacity-20 transition-all animate-scale-in stagger-3">
                    <div class="w-14 h-14 bg-white rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-ticket-alt text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">3. Buka Tiket Cepat</h3>
                    <p class="text-sm text-blue-100">Bila solusi kendala belum ditemukan di dokumentasi</p>
                </div>

                <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-6 border border-white border-opacity-20 hover:bg-opacity-20 transition-all animate-scale-in stagger-4">
                    <div class="w-14 h-14 bg-white rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-tools text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">4. Implementasi On-Site</h3>
                    <p class="text-sm text-blue-100">Tim IT Field Engineer turun ke lokasi DC</p>
                </div>

            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="text-center mb-10 animate-fade-in-up">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-question-circle text-blue-600 text-2xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Frequently Asked Questions (FAQ)</h2>
            <p class="text-gray-600">Jawaban langsung untuk kendala harian yang sering muncul di lapangan</p>
        </div>

        <div class="space-y-4">
            
            <!-- FAQ 1 -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm animate-fade-in stagger-1">
                <button onclick="toggleFaq('faq1')" class="w-full flex items-center justify-between p-6 text-left hover:bg-gray-50 transition-colors">
                    <span class="font-semibold text-gray-900 pr-8">Bagaimana jika scanner handheld tidak dapat mengirim data ke DC-01 Cakung?</span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform flex-shrink-0" id="icon-faq1"></i>
                </button>
                <div id="faq1" class="accordion-content">
                    <div class="px-6 pb-6 text-gray-600">
                        <p class="mb-3">Lakukan langkah-langkah berikut secara berurutan:</p>
                        <ol class="list-decimal list-inside space-y-2 text-sm">
                            <li>Periksa koneksi Wi-Fi pada scanner - pastikan terhubung ke SSID "ASTRO-DC01-OPS"</li>
                            <li>Restart perangkat dengan menekan tombol power selama 10 detik</li>
                            <li>Verifikasi konfigurasi gateway di Settings → Network → Gateway IP (seharusnya 192.168.10.1)</li>
                            <li>Jika masih gagal, hubungi IT Helpdesk Ext. 104 dengan menyebutkan error code yang muncul</li>
                        </ol>
                        <p class="mt-3 text-xs text-blue-600">
                            <i class="fas fa-book mr-1"></i>
                            Lihat panduan lengkap: <a href="#" class="underline">HW-SCAN-164: Troubleshooting Scanner Zebra TC52x</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm animate-fade-in stagger-2">
                <button onclick="toggleFaq('faq2')" class="w-full flex items-center justify-between p-6 text-left hover:bg-gray-50 transition-colors">
                    <span class="font-semibold text-gray-900 pr-8">Apa syarat dokumen untuk pengajuan mutasi antar-hub agar cepat disetujui HR/Approver?</span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform flex-shrink-0" id="icon-faq2"></i>
                </button>
                <div id="faq2" class="accordion-content">
                    <div class="px-6 pb-6 text-gray-600">
                        <p class="mb-3">Dokumen wajib yang harus dilampirkan:</p>
                        <ul class="list-disc list-inside space-y-2 text-sm">
                            <li>Form Pengajuan Mutasi (formulir ASTRO-MUT-001) yang sudah diisi lengkap</li>
                            <li>Persetujuan Kepala Gudang asal (signature digital atau stamp)</li>
                            <li>Surat Jalan rangkap 2 dengan nomor referensi tracking</li>
                            <li>Foto kondisi barang sebelum dipacking (minimal 3 angle)</li>
                            <li>Dokumen pendukung lain sesuai kategori barang (MSDS untuk bahan kimia, dll)</li>
                        </ul>
                        <p class="mt-3 text-xs bg-yellow-50 border-l-4 border-yellow-500 p-3">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mr-1"></i>
                            <strong>Catatan:</strong> Mutasi yang tidak lengkap dokumennya akan otomatis ditolak sistem dalam 24 jam.
                        </p>
                    </div>
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm animate-fade-in stagger-3">
                <button onclick="toggleFaq('faq3')" class="w-full flex items-center justify-between p-6 text-left hover:bg-gray-50 transition-colors">
                    <span class="font-semibold text-gray-900 pr-8">Berapa lama akun terkunci setelah salah memasukkan kata sandi 5 kali?</span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform flex-shrink-0" id="icon-faq3"></i>
                </button>
                <div id="faq3" class="accordion-content">
                    <div class="px-6 pb-6 text-gray-600">
                        <p class="mb-3">Berdasarkan kebijakan keamanan SEC-POL-001:</p>
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-3">
                            <p class="font-semibold text-red-900 mb-2">Akun akan terkunci PERMANEN</p>
                            <p class="text-sm text-red-800">Setelah 5 kali kesalahan input password berturut-turut, akun akan dikunci secara otomatis dan hanya bisa dibuka oleh Super Admin atau IT Security Officer.</p>
                        </div>
                        <p class="text-sm mb-2"><strong>Cara membuka kembali akun:</strong></p>
                        <ol class="list-decimal list-inside space-y-1 text-sm">
                            <li>Hubungi IT Helpdesk Ext. 104 atau email ke helpdesk-wms@astro-internal.id</li>
                            <li>Verifikasi identitas dengan menyebutkan NIP dan nama lengkap</li>
                            <li>Admin akan melakukan reset password dan mengirim kredensial baru via email resmi</li>
                        </ol>
                        <p class="mt-3 text-xs text-gray-500">
                            <i class="fas fa-shield-alt mr-1"></i>
                            Kebijakan ini diterapkan untuk mencegah brute-force attack sesuai standar ISO 27001.
                        </p>
                    </div>
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm animate-fade-in stagger-4">
                <button onclick="toggleFaq('faq4')" class="w-full flex items-center justify-between p-6 text-left hover:bg-gray-50 transition-colors">
                    <span class="font-semibold text-gray-900 pr-8">Bagaimana cara menambahkan SKU baru secara manual via Excel/CSV?</span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform flex-shrink-0" id="icon-faq4"></i>
                </button>
                <div id="faq4" class="accordion-content">
                    <div class="px-6 pb-6 text-gray-600">
                        <p class="mb-3">Langkah-langkah upload bulk SKU:</p>
                        <ol class="list-decimal list-inside space-y-2 text-sm">
                            <li>Download template Excel dari menu Master Data → SKU → "Download Template"</li>
                            <li>Isi data SKU sesuai format:
                                <ul class="list-disc list-inside ml-6 mt-1 text-xs">
                                    <li>SKU Code (wajib, format: XXX-YYYY-ZZZZ)</li>
                                    <li>Nama Barang, Kategori, Unit, Harga Modal</li>
                                    <li>Reorder Point (ROP), Safety Stock</li>
                                </ul>
                            </li>
                            <li>Save file dengan format .xlsx atau .csv (max 5MB, max 1000 rows)</li>
                            <li>Upload via menu Master Data → SKU → "Import Excel"</li>
                            <li>Sistem akan validasi otomatis dan tampilkan preview</li>
                            <li>Klik "Confirm Import" untuk finalisasi</li>
                        </ol>
                        <p class="mt-3 text-xs bg-blue-50 border-l-4 border-blue-500 p-3">
                            <i class="fas fa-info-circle text-blue-600 mr-1"></i>
                            <strong>Tips:</strong> Jika ada error saat import, download "Error Log" untuk melihat baris mana yang bermasalah.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Support Section -->
    <div class="bg-gray-100 py-16 mb-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <!-- Left Content -->
                <div class="animate-slide-in-left">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Butuh Dukungan Teknis Langsung?</h2>
                    <p class="text-gray-600 mb-6">
                        Tim IT Field Engineers dan Network Operation Center kami siap membantu Anda 24/7 untuk kendala operasional, 
                        konfigurasi hardware, atau troubleshooting sistem ASTRO WMS.
                    </p>
                    <a href="#" class="btn-ripple bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-all shadow-lg flex items-center space-x-2">
                        <i class="fas fa-ticket-alt"></i>
                        <span>Buka Tiket Kendala Baru</span>
                    </a>
                </div>

                <!-- Right: Contact Cards -->
                <div class="animate-slide-in-right">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Bantuan Cepat Satu Sentuhan</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <div class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg transition-shadow">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-3">
                                <i class="fas fa-phone text-blue-600 text-xl"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 mb-1">Call Center ASTRO DC</h4>
                            <p class="text-2xl font-bold text-blue-600 mb-1">Ext. 104</p>
                            <p class="text-xs text-gray-600">Operasional 24/7, Helpdesk DC-01</p>
                        </div>

                        <div class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg transition-shadow">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mb-3">
                                <i class="fas fa-envelope text-gray-600 text-xl"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 mb-1">Email Support Teknis</h4>
                            <p class="text-sm font-semibold text-gray-700 mb-1">helpdesk-wms@astro-internal.id</p>
                            <p class="text-xs text-gray-600">Respon dalam 1 hari kerja</p>
                        </div>

                        <div class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg transition-shadow">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-3">
                                <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 mb-1">Join ASTRO Community</h4>
                            <p class="text-sm font-semibold text-gray-700 mb-1">+62 [XXX] XXX-XXXX</p>
                            <p class="text-xs text-gray-600">Komunitas Pengguna dan IT Staff</p>
                        </div>

                        <div class="bg-white rounded-xl p-5 shadow-md hover:shadow-lg transition-shadow">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-3">
                                <i class="fas fa-book text-blue-600 text-xl"></i>
                            </div>
                            <h4 class="font-bold text-gray-900 mb-1">Download Dokumentasi</h4>
                            <p class="text-sm font-semibold text-blue-600 mb-1">
                                <i class="fas fa-download mr-1"></i>
                                Manual Book PDF (v2.4.0)
                            </p>
                            <p class="text-xs text-gray-600">Backup offline dokumentasi lengkap</p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</main>

<!-- Footer -->
<footer class="bg-gray-900 text-gray-300 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row items-center justify-between border-t border-gray-800 pt-8">
            <p class="text-sm mb-4 md:mb-0">© ASTRO WMS Enterprise 2026. All rights reserved.</p>
            <div class="flex items-center space-x-6 text-sm">
                <a href="#" class="hover:text-blue-400 transition-colors">Pusat Dukungan</a>
                <a href="#" class="hover:text-blue-400 transition-colors">Infrastruktur Cloud</a>
                <a href="#" class="hover:text-blue-400 transition-colors">Status Realtime Teknologi</a>
            </div>
        </div>
    </div>
</footer>

@endsection

@section('scripts')
<script>
    // FAQ Accordion Toggle
    function toggleFaq(id) {
        const content = document.getElementById(id);
        const icon = document.getElementById('icon-' + id);
        
        // Close all other accordions
        document.querySelectorAll('.accordion-content').forEach(item => {
            if (item.id !== id && item.classList.contains('active')) {
                item.classList.remove('active');
                const otherIcon = document.getElementById('icon-' + item.id);
                if (otherIcon) {
                    otherIcon.classList.remove('fa-chevron-up');
                    otherIcon.classList.add('fa-chevron-down');
                }
            }
        });
        
        // Toggle current accordion
        content.classList.toggle('active');
        icon.classList.toggle('fa-chevron-down');
        icon.classList.toggle('fa-chevron-up');
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Search functionality (placeholder)
    const searchInput = document.querySelector('input[type="text"]');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const query = this.value;
                if (query) {
                    console.log('Searching for:', query);
                    // Implement actual search logic here
                }
            }
        });
    }
</script>
@endsection
