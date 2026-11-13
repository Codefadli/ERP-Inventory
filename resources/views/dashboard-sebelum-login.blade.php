@extends('layouts.app')

@section('title', 'ASTRO INVENTORY - Sistem Inventaris Terpadu')

@section('styles')
<style>
    /* Animations */
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideInLeft { from { opacity: 0; transform: translateX(-50px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes slideInRight { from { opacity: 0; transform: translateX(50px); } to { opacity: 1; transform: translateX(0); } }
    @keyframes scaleIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
    @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    @keyframes progressFill { from { width: 0%; } }

    /* Animation Classes */
    .animate-fade-in-down { animation: fadeInDown 0.8s ease-out; }
    .animate-fade-in-up { animation: fadeInUp 0.8s ease-out; }
    .animate-fade-in { animation: fadeIn 1s ease-out; }
    .animate-slide-in-left { animation: slideInLeft 0.8s ease-out; }
    .animate-slide-in-right { animation: slideInRight 0.8s ease-out; }
    .animate-scale-in { animation: scaleIn 0.6s ease-out; }
    .pulse-animation { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    .float-animation { animation: float 3s ease-in-out infinite; }

    /* Navbar Scroll Effect */
    .navbar-scrolled { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }

    /* Card Hover Effects */
    .stat-card, .role-card, .dc-card, .feature-card { transition: all 0.3s ease; }
    .stat-card:hover { transform: translateY(-8px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15); }
    .role-card:hover { transform: translateY(-5px) scale(1.02); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
    .dc-card:hover { transform: translateX(5px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
    .feature-card:hover { transform: scale(1.03); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2); }

    /* Button Effects */
    .btn-primary { transition: all 0.3s ease; position: relative; overflow: hidden; }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.5); }
    .btn-primary:active { transform: translateY(0); }

    /* Progress Bar */
    .progress-bar { animation: progressFill 2s ease-out forwards; }

    /* Stagger Animation */
    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    .stagger-3 { animation-delay: 0.3s; }
    .stagger-4 { animation-delay: 0.4s; }
    .stagger-5 { animation-delay: 0.5s; }

    /* Smooth Scroll */
    html { scroll-behavior: smooth; }
</style>
@endsection

@section('content')
    <!-- Navbar -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3 animate-fade-in-down">
                    <div class="w-10 h-10 bg-blue-600 rounded flex items-center justify-center">
                        <i class="fas fa-cube text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-900">ASTRO INVENTORY</h1>
                        <p class="text-xs text-gray-500">SISTEM INVENTARIS TERPADU</p>
                    </div>
                </div>

                <!-- Menu -->
                <div class="hidden md:flex items-center space-x-8 animate-fade-in-down stagger-1">
                    <a href="#beranda" class="text-blue-600 font-semibold hover:text-blue-700 transition-colors">Beranda</a>
                    <a href="#status-server" class="text-gray-700 hover:text-blue-600 transition-colors">Status Server</a>
                    <a href="#dokumentasi" class="text-gray-700 hover:text-blue-600 transition-colors">Dokumentasi & Bantuan</a>
                </div>

                <!-- CTA Button -->
                <a href="{{ route('login') }}" class="btn-primary bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold animate-fade-in-down stagger-2">
                    Masuk ke Portal
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="max-w-6xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 animate-fade-in-up">
                Pusat Kendali Inventaris & Distribusi Pergudangan Terintegrasi Multi-Hub
            </h1>
            <p class="text-lg text-gray-600 mb-8 max-w-4xl mx-auto animate-fade-in-up stagger-1">
                Platform manajemen pergudangan lengkap untuk <strong>Super Admin, Kepala Gudang, HR Approver, Pegawai, dan Auditor</strong>. 
                Pantau mutasi antar-DC secara real-time, kelola buffer ROP otomatis, dan jalankan approval workflow dengan standar enkripsi 256-bit 
                serta audit trail lengkap sesuai ISO 27001.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in-up stagger-2">
                <a href="{{ route('login') }}" class="btn-primary bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold text-lg flex items-center space-x-2">
                    <span>Masuk ke Sistem ASTRO</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                <button class="px-8 py-3 border-2 border-blue-600 text-blue-600 rounded-lg font-semibold text-lg hover:bg-blue-50 transition-all flex items-center space-x-2">
                    <i class="fas fa-shield-alt"></i>
                    <span>Pelajari Modul & Hak Akses Role</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Statistics Cards -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="stat-card bg-white border border-gray-200 rounded-xl p-6 shadow-sm animate-scale-in stagger-1">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">5 Role Inti</h3>
                    <p class="text-sm font-semibold text-gray-900 mb-1">AKSES TERKENDALI</p>
                    <p class="text-xs text-gray-500">Super Admin s/d Auditor Eksternal</p>
                </div>

                <!-- Card 2 -->
                <div class="stat-card bg-white border border-gray-200 rounded-xl p-6 shadow-sm animate-scale-in stagger-2">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-clipboard-list text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2"><span class="counter" data-target="8650">0</span>+ SKU</h3>
                    <p class="text-sm font-semibold text-gray-900 mb-1">KATALOG LOGISTIK</p>
                    <p class="text-xs text-gray-500">Terpantau aktif di 4 Hub Logistik</p>
                </div>

                <!-- Card 3 -->
                <div class="stat-card bg-white border border-gray-200 rounded-xl p-6 shadow-sm animate-scale-in stagger-3">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-check-circle text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">100% SOP</h3>
                    <p class="text-sm font-semibold text-gray-900 mb-1">AUDIT TRAIL</p>
                    <p class="text-xs text-gray-500">Pencatatan lengkap digital tanpa celah</p>
                </div>

                <!-- Card 4 -->
                <div class="stat-card bg-white border border-gray-200 rounded-xl p-6 shadow-sm animate-scale-in stagger-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-clock text-orange-600 text-xl"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">&lt; 4 Jam</h3>
                    <p class="text-sm font-semibold text-gray-900 mb-1">SLA KEPUTUSAN</p>
                    <p class="text-xs text-gray-500">Rerata validasi approval mutasi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Role Operasional Section -->
    <section id="status-server" class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12 animate-fade-in-up">
                <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">SEGREGASI WEWENANG (SSO)</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-4 mb-3">5 Matriks Role Operasional Sistem</h2>
                <p class="text-gray-600 mb-4">Hierarki wewenang berbasis RBAC untuk memisahkan tanggung jawab operasional gudang dan otorisasi mutasi stok.</p>
                <span class="inline-flex items-center bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">
                    <i class="fas fa-lock mr-2"></i>
                    Enkripsi Role-Based Access Control (RBAC) Aktif
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Level 0: Super Admin -->
                <div class="role-card bg-white border-2 border-blue-500 rounded-xl p-6 shadow-md animate-slide-in-left stagger-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-terminal text-white text-2xl"></i>
                        </div>
                        <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-bold">Level 0: Root</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Super Admin</h3>
                    <p class="text-sm text-gray-600 mb-4">Kontrol penuh API logistik, parameter sistem, pengelolaan user, dan konfigurasi master data gudang.</p>
                    <div class="space-y-2">
                        <div class="flex items-center text-xs text-gray-700">
                            <i class="fas fa-check text-blue-600 mr-2"></i>
                            <span>Wewenang Master Data</span>
                        </div>
                        <div class="flex items-center text-xs text-gray-700">
                            <i class="fas fa-check text-blue-600 mr-2"></i>
                            <span>Akses Penuh / C-R-U-D</span>
                        </div>
                    </div>
                </div>

                <!-- Level 1: Kepala Gudang -->
                <div class="role-card bg-white border-2 border-green-500 rounded-xl p-6 shadow-md animate-slide-in-left stagger-2">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-green-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-warehouse text-white text-2xl"></i>
                        </div>
                        <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-bold">Level 1: DC Ops</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Kepala Gudang</h3>
                    <p class="text-sm text-gray-600 mb-4">Manajemen gudang wilayah, penerimaan barang, reorder point monitoring, dan laporan distribusi.</p>
                    <div class="space-y-2">
                        <div class="flex items-center text-xs text-gray-700">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            <span>Cakupan Wilayah</span>
                        </div>
                        <div class="flex items-center text-xs text-gray-700">
                            <i class="fas fa-check text-green-600 mr-2"></i>
                            <span>Tingkat Distribution Center</span>
                        </div>
                    </div>
                </div>

                <!-- Level 2: HR & Otorisasi -->
                <div class="role-card bg-white border-2 border-purple-500 rounded-xl p-6 shadow-md animate-slide-in-left stagger-3">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-signature text-white text-2xl"></i>
                        </div>
                        <span class="bg-purple-600 text-white px-3 py-1 rounded-full text-xs font-bold">Level 2: Approval</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">HR & Otorisasi Pergudangan</h3>
                    <p class="text-sm text-gray-600 mb-4">Persetujuan mutasi stok antar-DC, write-off barang rusak, dan validasi kepatuhan SLA.</p>
                    <div class="space-y-2">
                        <div class="flex items-center text-xs text-gray-700">
                            <i class="fas fa-check text-purple-600 mr-2"></i>
                            <span>Kontrol Otorisasi</span>
                        </div>
                        <div class="flex items-center text-xs text-gray-700">
                            <i class="fas fa-check text-purple-600 mr-2"></i>
                            <span>Multi-Sign Workflow</span>
                        </div>
                    </div>
                </div>

                <!-- Level 3: Petugas Gudang -->
                <div class="role-card bg-white border-2 border-orange-500 rounded-xl p-6 shadow-md animate-slide-in-right stagger-4">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-orange-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-hard-hat text-white text-2xl"></i>
                        </div>
                        <span class="bg-orange-600 text-white px-3 py-1 rounded-full text-xs font-bold">Level 3: Eksekusi Lapangan</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Petugas/Pegawai Gudang</h3>
                    <p class="text-sm text-gray-600 mb-4">Tugas masuk/keluar barang, scanning barcode, stock opname fisik, dan input data harian.</p>
                    <div class="space-y-2">
                        <div class="flex items-center text-xs text-gray-700">
                            <i class="fas fa-check text-orange-600 mr-2"></i>
                            <span>Alat Kerja Utama</span>
                        </div>
                        <div class="flex items-center text-xs text-gray-700">
                            <i class="fas fa-check text-orange-600 mr-2"></i>
                            <span>Barcode Mobile Terminal</span>
                        </div>
                    </div>
                </div>

                <!-- Level 4: Auditor -->
                <div class="role-card bg-white border-2 border-gray-500 rounded-xl p-6 shadow-md animate-slide-in-right stagger-5 md:col-span-2 lg:col-span-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-gray-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-contract text-white text-2xl"></i>
                        </div>
                        <span class="bg-gray-600 text-white px-3 py-1 rounded-full text-xs font-bold">Level 4: Inspeksi Independen</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Auditor Sistem</h3>
                    <p class="text-sm text-gray-600 mb-4">Akses strictly Read-Only audit trail, tanpa kemampuan modifikasi data operasional.</p>
                    <div class="space-y-2">
                        <div class="flex items-center text-xs text-gray-700">
                            <i class="fas fa-check text-gray-600 mr-2"></i>
                            <span>Integritas Log</span>
                        </div>
                        <div class="flex items-center text-xs text-gray-700">
                            <i class="fas fa-check text-gray-600 mr-2"></i>
                            <span>Tersertifikasi ISO 27001 Ready</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Distribution Hub Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12 animate-fade-in-up">
                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold">INFRASTRUKTUR PERGUDANGAN</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-4 mb-3">Distribusi Hub Aktif Nasional</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- DC-01 Cakung -->
                <div class="dc-card bg-white border border-gray-200 rounded-xl p-6 shadow-sm animate-fade-in stagger-1">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900">DC-01 Cakung (Pusat)</h3>
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Optimal</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">Kawasan Industri Pulogadung, Jakarta Timur</p>
                    <div class="space-y-3">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Kapasitas Rak Terisi</span>
                                <span class="font-bold text-blue-600">84.2%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="progress-bar bg-blue-600 h-2 rounded-full" style="width: 84.2%"></div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Inbound Hari Ini</p>
                                <p class="font-bold text-gray-900"><span class="counter" data-target="1432">0</span> SKU</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Latensi</p>
                                <p class="font-bold text-green-600">13ms</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DC-02 Rungkut -->
                <div class="dc-card bg-white border border-gray-200 rounded-xl p-6 shadow-sm animate-fade-in stagger-2">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900">DC-02 Rungkut</h3>
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Optimal</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">Delta Industri Sidoarjo, Surabaya, Jawa Timur</p>
                    <div class="space-y-3">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Kapasitas Rak Terisi</span>
                                <span class="font-bold text-blue-600">69.8%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="progress-bar bg-blue-600 h-2 rounded-full" style="width: 69.8%"></div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Inbound Hari Ini</p>
                                <p class="font-bold text-gray-900"><span class="counter" data-target="890">0</span> SKU</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Latensi</p>
                                <p class="font-bold text-green-600">18ms</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DC-03 Gedebage -->
                <div class="dc-card bg-white border border-gray-200 rounded-xl p-6 shadow-sm animate-fade-in stagger-3">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900">DC-03 Gedebage</h3>
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Optimal</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">Gedebage Logistic Park, Bandung, Jawa Barat</p>
                    <div class="space-y-3">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Kapasitas Rak Terisi</span>
                                <span class="font-bold text-blue-600">61.4%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="progress-bar bg-blue-600 h-2 rounded-full" style="width: 61.4%"></div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Inbound Hari Ini</p>
                                <p class="font-bold text-gray-900"><span class="counter" data-target="540">0</span> SKU</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Latensi</p>
                                <p class="font-bold text-green-600">14ms</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DC-04 Belawan -->
                <div class="dc-card bg-white border border-gray-200 rounded-xl p-6 shadow-sm animate-fade-in stagger-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900">DC-04 Belawan</h3>
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold">Buffer Sync</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">Dipo Pelabuhan, Medan, Sumatera Utara</p>
                    <div class="space-y-3">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Kapasitas Rak Terisi</span>
                                <span class="font-bold text-blue-600">52.0%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="progress-bar bg-blue-600 h-2 rounded-full" style="width: 52.0%"></div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Inbound Hari Ini</p>
                                <p class="font-bold text-gray-900"><span class="counter" data-target="380">0</span> SKU</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Latensi</p>
                                <p class="font-bold text-yellow-600">28ms</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6 animate-fade-in-up stagger-5">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-sync-alt text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-blue-900 mb-2">Sinkronisasi Reorder Point Antar-DC</h4>
                        <p class="text-sm text-blue-800">
                            Setiap hub mengirim notifikasi safety stock secara paralel ke pusat kendali Jakarta saat threshold ROP tercapai, 
                            memastikan tidak ada stok yang melewati ambang kritis tanpa eskalasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Security Protocol Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12 animate-fade-in-up">
                <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-bold flex items-center justify-center w-fit mx-auto">
                    <i class="fas fa-shield-alt mr-2"></i>
                    PROTOKOL KEAMANAN SISTEM & KEPATUHAN
                </span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-4">Standar Perlindungan Data Operasional</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white border border-gray-200 rounded-xl p-6 text-center shadow-sm animate-scale-in stagger-1">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-clock text-blue-600 text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Auto Idle Session Timeout</h4>
                    <p class="text-sm text-gray-600">Otomatis logout setelah 30 menit tanpa aktivitas keyboard/mouse</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-6 text-center shadow-sm animate-scale-in stagger-2">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-ban text-red-600 text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Brute-Force Account Lockout</h4>
                    <p class="text-sm text-gray-600">Blokir permanen setelah 5 kali kesalahan input password berturut-turut</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-6 text-center shadow-sm animate-scale-in stagger-3">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-lock text-green-600 text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Delivery Mutasi AES-256</h4>
                    <p class="text-sm text-gray-600">Enkripsi end-to-end seluruh payload mutasi stok antar-DC</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-6 text-center shadow-sm animate-scale-in stagger-4">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users-cog text-purple-600 text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">Segregation of Duties (SOD)</h4>
                    <p class="text-sm text-gray-600">Tidak ada user yang bisa approve permintaan diri sendiri</p>
                </div>
            </div>

            <div class="bg-blue-600 text-white rounded-xl p-6 text-center animate-fade-in-up stagger-5">
                <p class="text-lg font-semibold">
                    <i class="fas fa-certificate mr-2"></i>
                    Sertifikasi Infrastruktur: ISO 27001 • SOC 2 Type II Compliant
                </p>
            </div>
        </div>
    </section>

    <!-- Operations Section -->
    <section id="dokumentasi" class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12 animate-fade-in-up">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Operasi Logistik Cepat, Akurat & Terkalibrasi</h2>
                <p class="text-lg text-gray-600">Mengintegrasikan perangkat keras scanner, RFID, dan telemetri gudang real-time</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="feature-card bg-white rounded-xl overflow-hidden shadow-lg animate-scale-in stagger-1">
                    <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                        <i class="fas fa-warehouse text-white text-6xl"></i>
                    </div>
                    <div class="p-6">
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">LORONG RACKING OTOMATIS</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-3 mb-2">Pemetaan Rak Dinamis DC Cakung</h3>
                        <p class="text-sm text-gray-600">Sistem WMS terintegrasi dengan koordinat rak 3D untuk optimasi picking route.</p>
                    </div>
                </div>

                <div class="feature-card bg-white rounded-xl overflow-hidden shadow-lg animate-scale-in stagger-2">
                    <div class="h-48 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                        <i class="fas fa-barcode text-white text-6xl"></i>
                    </div>
                    <div class="p-6">
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">SCANNING HANDHELD</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-3 mb-2">Scan Barcode & RFID Inbound</h3>
                        <p class="text-sm text-gray-600">Perangkat Zebra TC52x untuk capture data masuk gudang dengan akurasi tinggi.</p>
                    </div>
                </div>

                <div class="feature-card bg-white rounded-xl overflow-hidden shadow-lg animate-scale-in stagger-3">
                    <div class="h-48 bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                        <i class="fas fa-tv text-white text-6xl"></i>
                    </div>
                    <div class="p-6">
                        <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold">KONTROL PENGAWAS PUSAT</span>
                        <h3 class="text-xl font-bold text-gray-900 mt-3 mb-2">Telemetri Distribusi 24/7</h3>
                        <p class="text-sm text-gray-600">Dashboard real-time untuk monitoring seluruh aktivitas 4 hub secara bersamaan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Navbar Scroll Effect
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    });

    // Counter Animation
    function animateCounter(element) {
        const target = parseInt(element.getAttribute('data-target'));
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;

        const updateCounter = () => {
            current += increment;
            if (current < target) {
                element.textContent = Math.floor(current).toLocaleString('id-ID');
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target.toLocaleString('id-ID');
            }
        };

        updateCounter();
    }

    // Intersection Observer for Scroll Animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Animate counters
                const counters = entry.target.querySelectorAll('.counter');
                counters.forEach(counter => {
                    if (!counter.classList.contains('animated')) {
                        animateCounter(counter);
                        counter.classList.add('animated');
                    }
                });
            }
        });
    }, observerOptions);

    // Observe all sections
    document.querySelectorAll('section').forEach(section => {
        observer.observe(section);
    });

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
</script>
@endsection
