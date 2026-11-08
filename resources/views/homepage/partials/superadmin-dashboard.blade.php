<!-- Page Header -->
<div class="mb-6">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Dasbor Operasional Hub & Inventaris</h1>
            <p class="text-sm text-gray-600">Pemantauan multi-hub terpusat, analitik arus barang, status approval, dan peringatan stok kritis secara real-time.</p>
        </div>
        <div class="flex items-center space-x-3">
            <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Unduh Laporan Ringkas
            </button>
            <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Barang Baru
            </button>
        </div>
    </div>
</div>

<!-- KPI Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Pengguna & Admin -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">+12% bln lalu</span>
        </div>
        <p class="text-3xl font-bold text-gray-900">1.420</p>
        <p class="text-sm text-gray-600 mt-1">Total Pengguna & Admin</p>
        <p class="text-xs text-gray-500 mt-2">18 Admin Hub aktif bertugas</p>
    </div>

    <!-- SKU Aktif Tersimpan -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">99.8% Akurasi</span>
        </div>
        <p class="text-3xl font-bold text-gray-900">8.650 <span class="text-lg text-gray-500">SKU</span></p>
        <p class="text-sm text-gray-600 mt-1">SKU Aktif Tersimpan</p>
        <p class="text-xs text-green-600 mt-2">99.2% Stok Tersedia Siap Alokasi</p>
    </div>

    <!-- Barang Masuk Hari Ini -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">+8.4% target</span>
        </div>
        <p class="text-3xl font-bold text-gray-900">1.240 <span class="text-lg text-gray-500">Unit</span></p>
        <p class="text-sm text-gray-600 mt-1">Barang Masuk Hari Ini</p>
        <p class="text-xs text-gray-500 mt-2">12 Surat Jalan (Selesai)</p>
    </div>

    <!-- Barang Keluar Hari Ini -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">100% Siap</span>
        </div>
        <p class="text-3xl font-bold text-gray-900">980 <span class="text-lg text-gray-500">Unit</span></p>
        <p class="text-sm text-gray-600 mt-1">Barang Keluar Hari Ini</p>
        <p class="text-xs text-gray-500 mt-2">94 Batch Pengiriman Siap</p>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column - Chart & Activity -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Chart Section -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Arus Masuk & Keluar Barang Hub</h3>
                    <p class="text-sm text-gray-600 mt-1">Analisis throughput pergerakan stok harian</p>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg">7 Hari Terakhir</button>
                    <button class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">30 Hari</button>
                    <button class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Bulan Ini</button>
                </div>
            </div>

            <!-- Chart Placeholder -->
            <div class="relative h-64 bg-gradient-to-br from-blue-50 to-white rounded-lg p-4 border border-blue-100 flex items-center justify-center">
                <p class="text-gray-400 text-sm">Chart Area - Implementasi dengan Chart.js</p>
            </div>

            <!-- Chart Summary -->
            <div class="grid grid-cols-3 gap-4 mt-6">
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-gray-900">1.202</p>
                    <p class="text-xs text-gray-600 mt-1">Rata-rata Harian</p>
                </div>
                <div class="text-center p-3 bg-blue-50 rounded-lg">
                    <p class="text-2xl font-bold text-blue-700">1.480</p>
                    <p class="text-xs text-gray-600 mt-1">Puncak Throughput</p>
                </div>
                <div class="text-center p-3 bg-green-50 rounded-lg">
                    <p class="text-2xl font-bold text-green-700">98.4%</p>
                    <p class="text-xs text-gray-600 mt-1">Efisiensi Docking</p>
                </div>
            </div>
        </div>

        <!-- Activity Log -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Log Aktivitas Terkini (User & Admin)</h3>
                    <p class="text-sm text-gray-600 mt-1">Real-time activity monitoring</p>
                </div>
            </div>

            <div class="space-y-4">
                <!-- Activity 1 -->
                <div class="flex items-start space-x-4 pb-4 border-b border-gray-100">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-semibold text-blue-700">BS</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-1">
                            <span class="text-sm font-semibold text-gray-900">Budi Santoso</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">Super Admin</span>
                        </div>
                        <p class="text-sm text-gray-700 mb-2">Memproses persetujuan mutasi transfer 150 unit [SKU-CAM-8821] ke Hub Halim DC-02</p>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Mutasi Sukses Disetujui</span>
                            <span class="text-xs text-gray-500">Ref #MUT-2023-0941</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">10 menit yang lalu</p>
                    </div>
                </div>

                <!-- Activity 2 -->
                <div class="flex items-start space-x-4 pb-4 border-b border-gray-100">
                    <div class="flex-shrink-0 w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-semibold text-orange-700">RH</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-1">
                            <span class="text-sm font-semibold text-gray-900">Rian Hidayat</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">Admin Keamanan RBAC</span>
                        </div>
                        <p class="text-sm text-gray-700 mb-2">Memperbarui hak akses role RBAC untuk Warehouse Staff regional</p>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">Perubahan Hak Akses</span>
                            <span class="text-xs text-gray-500">Audit ID #SEC-819</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">35 menit yang lalu</p>
                    </div>
                </div>

                <!-- Activity 3 -->
                <div class="flex items-start space-x-4 pb-4 border-b border-gray-100">
                    <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-semibold text-purple-700">DA</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-1">
                            <span class="text-sm font-semibold text-gray-900">Dewi Anggraini</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">Supervisor Audit</span>
                        </div>
                        <p class="text-sm text-gray-700 mb-2">Menyelesaikan Stok Opname terjadwal di Lorong B3. Ditemukan selisih -3 unit pada SKU Apple Watch</p>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Discrepancy Logged</span>
                            <span class="text-xs text-gray-500">Opname #SO-2023-112</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">1 jam yang lalu</p>
                    </div>
                </div>

                <!-- Activity 4 -->
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-semibold text-green-700">FK</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-1">
                            <span class="text-sm font-semibold text-gray-900">Fajar Kurnia</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Inbound Staff</span>
                        </div>
                        <p class="text-sm text-gray-700 mb-2">Menerima penerimaan fisik PO-774 dari PT Mitra Logistik Nusantara sejumlah 450 unit perlengkapan optik</p>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Penerimaan Selesai</span>
                            <span class="text-xs text-gray-500">Surat Jalan #SJ-90928</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">2 jam yang lalu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Critical Stock & Approvals -->
    <div class="space-y-6">
        <!-- Stok Kritis & Menipis -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
            <div class="flex items-center space-x-2 mb-4">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <h4 class="font-semibold text-gray-900">Stok Kritis & Menipis</h4>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">3 SKU Kritis</span>
            </div>

            <div class="space-y-4">
                <!-- Critical Item 1 -->
                <div class="border border-red-200 rounded-lg p-3 bg-red-50">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="text-xs text-gray-500">SKU-CAM-600D</p>
                            <p class="text-sm font-semibold text-gray-900">Canon 6D DSLR Camera Body</p>
                            <p class="text-xs text-gray-500">Bin: WH01-RACK-A4</p>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-600 text-white">Sisa 4 Unit</span>
                    </div>
                    <div class="mb-2">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>Kapasitas Buffer (ROP: 25)</span>
                            <span class="font-semibold">16% dari buffer</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full" style="width: 16%"></div>
                        </div>
                    </div>
                    <button class="w-full px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        Ajukan Restock
                    </button>
                </div>

                <!-- Critical Item 2 -->
                <div class="border border-red-200 rounded-lg p-3 bg-red-50">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="text-xs text-gray-500">SKU-CAM-NIK8</p>
                            <p class="text-sm font-semibold text-gray-900">Nikon Reel Optical Pro X</p>
                            <p class="text-xs text-gray-500">Bin: WH01-RACK-B2</p>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-600 text-white">Sisa 7 Unit</span>
                    </div>
                    <div class="mb-2">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>Kapasitas Buffer (ROP: 30)</span>
                            <span class="font-semibold">23% dari buffer</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full" style="width: 23%"></div>
                        </div>
                    </div>
                    <button class="w-full px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        Ajukan Restock
                    </button>
                </div>

                <!-- Critical Item 3 -->
                <div class="border border-orange-200 rounded-lg p-3 bg-orange-50">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="text-xs text-gray-500">SKU-WTC-AP48</p>
                            <p class="text-sm font-semibold text-gray-900">iWatch 4th Gen Smartwatch 44mm</p>
                            <p class="text-xs text-gray-500">Bin: WH01-RACK-C1</p>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-orange-600 text-white">Sisa 12 Unit</span>
                    </div>
                    <div class="mb-2">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>Kapasitas Buffer (ROP: 40)</span>
                            <span class="font-semibold">30% dari buffer</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-orange-500 h-2 rounded-full" style="width: 30%"></div>
                        </div>
                    </div>
                    <button class="w-full px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        Ajukan Restock
                    </button>
                </div>
            </div>
        </div>

        <!-- Menunggu Persetujuan -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
            <div class="flex items-center space-x-2 mb-4">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h4 class="font-semibold text-gray-900">Menunggu Persetujuan</h4>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">2 Permintaan</span>
            </div>

            <div class="space-y-4">
                <!-- Approval 1 -->
                <div class="border border-gray-200 rounded-lg p-3">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            <span class="text-sm font-semibold text-gray-900">Mutasi Antar-Hub</span>
                        </div>
                        <span class="text-lg font-bold text-blue-600">150 Unit</span>
                    </div>
                    <p class="text-xs text-gray-600 mb-3">Permintaan alokasi darurat dari Hub Cakung DC-01 menuju Hub Halim DC-02 untuk batch elektronik.</p>
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                        <span>Diajukan: Tim Logistik Timur</span>
                        <span class="text-red-600 font-semibold">Prioritas: Tinggi</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="flex-1 px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            Tolak
                        </button>
                        <button class="flex-1 px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            Setujui
                        </button>
                    </div>
                </div>

                <!-- Approval 2 -->
                <div class="border border-gray-200 rounded-lg p-3">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span class="text-sm font-semibold text-gray-900">Penyesuaian Stok Opname</span>
                        </div>
                        <span class="text-lg font-bold text-red-600">-3 Unit</span>
                    </div>
                    <p class="text-xs text-gray-600 mb-3">Adjustment write-off selisih fisik pemeriksaan berkala rak B3 pada produk Smartwatch serial SN-880.</p>
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                        <span>Auditor: Dewi Anggraini</span>
                        <span class="text-gray-600 font-semibold">Level: Write-Off Minor</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="flex-1 px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            Tolak
                        </button>
                        <button class="flex-1 px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            Setujui
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
