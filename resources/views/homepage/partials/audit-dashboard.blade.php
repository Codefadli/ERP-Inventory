<!-- Page Header -->
<div class="mb-6">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 mb-3">
                KEPATUHAN & AUDIT
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Dasbor Kepatuhan & Pusat Pemeriksaan Audit</h1>
            <p class="text-sm text-gray-600">Pemantauan integritas buku inventaris, deviasi stok fisik vs sistem, transparansi mutasi logistik, dan rekam jejak kepatuhan ISO/IEC 27001 Hub Cakung DC-01.</p>
        </div>
        <div class="flex items-center space-x-3">
            <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Ekspor Audit Trail (PDF/CSV)
            </button>
            <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Mulai Uji Petik Mandiri
            </button>
        </div>
    </div>
</div>

<!-- Metrics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Integritas Buku -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 relative overflow-hidden">
        <div class="flex items-start justify-between mb-4">
            <span class="text-sm text-gray-600 font-medium">Tingkat Integritas Buku</span>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                Selaras
            </span>
        </div>
        <p class="text-4xl font-bold text-gray-900 mb-2">99.82%</p>
        <div class="flex items-center text-xs text-gray-500">
            <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            Deviasi 0.18% di bawah toleransi 0.50%
        </div>
        <div class="absolute bottom-0 right-0 w-24 h-24 bg-green-500 opacity-5 rounded-full transform translate-x-8 translate-y-8"></div>
    </div>

    <!-- Temuan Discrepancy -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 relative overflow-hidden">
        <div class="flex items-start justify-between mb-4">
            <span class="text-sm text-gray-600 font-medium">Temuan Discrepancy Terbuka</span>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                2 Kritis
            </span>
        </div>
        <p class="text-4xl font-bold text-gray-900 mb-2">4 <span class="text-lg text-gray-500 font-normal">Temuan</span></p>
        <div class="flex items-center text-xs text-gray-500">
            2 Selisih opname, 1 mutasi, 1 fisik rusak
        </div>
        <div class="absolute bottom-0 right-0 w-24 h-24 bg-red-500 opacity-5 rounded-full transform translate-x-8 translate-y-8"></div>
    </div>

    <!-- SKU Diaudit -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 relative overflow-hidden">
        <div class="flex items-start justify-between mb-4">
            <span class="text-sm text-gray-600 font-medium">SKU Telah Diaudit (Q1)</span>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                79.1%
            </span>
        </div>
        <p class="text-3xl font-bold text-gray-900 mb-2">6,840 <span class="text-base text-gray-500 font-normal">/ 8,650 SKU</span></p>
        <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
            <div class="bg-blue-600 h-2 rounded-full" style="width: 79.1%"></div>
        </div>
        <div class="flex items-center text-xs text-gray-500">
            Sampling acak mingguan di 6 Zona DC
        </div>
    </div>

    <!-- Valuasi Risiko -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 relative overflow-hidden">
        <div class="flex items-start justify-between mb-4">
            <span class="text-sm text-gray-600 font-medium">Valuasi Potensi Risiko</span>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                Dalam Verifikasi
            </span>
        </div>
        <p class="text-3xl font-bold text-gray-900 mb-2">Rp 18,450,000</p>
        <div class="flex items-center text-xs text-gray-500">
            0.038% dari total aset Rp 48.2 Miliar
        </div>
        <div class="absolute bottom-0 right-0 w-24 h-24 bg-gray-500 opacity-5 rounded-full transform translate-x-8 translate-y-8"></div>
    </div>
</div>

<!-- Security Banner -->
<div class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-xl p-6 mb-6 flex items-center justify-between">
    <div class="flex items-center space-x-4">
        <div class="bg-green-500 bg-opacity-20 rounded-full p-3">
            <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <div>
            <h3 class="text-lg font-bold text-green-400 mb-1">ZERO TAMPERING DETECTED</h3>
            <p class="text-sm text-gray-300">
                Blok Audit: <span class="text-white font-semibold">#AUDIT-2025-W12</span> · 
                SHA256: <code class="bg-slate-700 px-2 py-0.5 rounded text-xs font-mono">a7f9c2d8e4b3f6a1...</code>
            </p>
        </div>
    </div>
    <button class="px-4 py-2 bg-white bg-opacity-10 hover:bg-opacity-20 text-white rounded-lg text-sm font-medium border border-white border-opacity-20">
        Validasi Hash
    </button>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column - Chart & Findings -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Chart Section -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Tren Temuan & Akurasi Rekonsiliasi</h3>
                    <p class="text-sm text-gray-600 mt-1">Monitoring integritas buku vs temuan harian</p>
                </div>
                <div class="flex items-center space-x-2">
                    <button class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">7 Hari</button>
                    <button class="px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg">14 Hari</button>
                    <button class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">30 Hari</button>
                </div>
            </div>

            <!-- Chart Legend -->
            <div class="flex items-center space-x-6 mb-4">
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-blue-500 rounded"></div>
                    <span class="text-sm text-gray-600">Tingkat Akurasi Buku (99.8%)</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-red-500 rounded"></div>
                    <span class="text-sm text-gray-600">Temuan Selisih Fisik (0-3/hari)</span>
                </div>
            </div>

            <!-- Chart Placeholder -->
            <div class="relative h-64 bg-gradient-to-br from-blue-50 to-white rounded-lg border border-blue-100 flex items-center justify-center">
                <p class="text-gray-400 text-sm">Chart Area - Implementasi dengan Chart.js</p>
            </div>
        </div>

        <!-- Priority Findings -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Temuan Prioritas Tinggi (Butuh Tindak Lanjut Segera)</h3>
                    <p class="text-sm text-gray-600 mt-1">2 temuan menunggu respons</p>
                </div>
            </div>

            <!-- Finding Card 1 - Critical -->
            <div class="border-l-4 border-red-500 bg-red-50 rounded-lg p-4 mb-4">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-red-600 text-white">
                            KRITIS
                        </span>
                        <span class="text-sm font-semibold text-gray-900">#AUD-2025-041: Selisih Fisik Barang High-Value</span>
                    </div>
                </div>
                <div class="space-y-2 text-sm text-gray-700 mb-4">
                    <p><strong>SKU:</strong> SD-EXT-1TB (Sandisk Extreme SSD)</p>
                    <p><strong>Lokasi:</strong> Lorong Rak C-02 (Level 3 / Bin 14)</p>
                    <p><strong>Selisih:</strong> <span class="text-red-700 font-semibold">-3 Unit (Rp 3,750,000)</span></p>
                    <p><strong>Status:</strong> Menunggu pemeriksaan gudang (Ka. Gudang - Budi Hartono)</p>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-500">13 Mar 2025, 14:10 WIB</span>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            Investigasi Detail
                        </button>
                        <button class="px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            Rekomendasi Penyelesaian
                        </button>
                    </div>
                </div>
            </div>

            <!-- Finding Card 2 - Warning -->
            <div class="border-l-4 border-yellow-500 bg-yellow-50 rounded-lg p-4">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-yellow-600 text-white">
                            PERINGATAN
                        </span>
                        <span class="text-sm font-semibold text-gray-900">#AUD-2025-039: Ketidaksesuaian Segel Kontainer Inbound</span>
                    </div>
                </div>
                <div class="space-y-2 text-sm text-gray-700 mb-4">
                    <p><strong>Dokumen:</strong> PO-774 / Surat Jalan #SJ-8891</p>
                    <p><strong>Vendor:</strong> PT Mitra Logistik Sejahtera</p>
                    <p><strong>Status:</strong> Investigasi Vendor & CCTV Dock 4</p>
                    <p><strong>Catatan:</strong> Barang ditahan di Staging Area Karantina (hold 48 Jam)</p>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-500">12 Mar 2025, 08:35 WIB</span>
                    <a href="#" class="text-xs font-medium text-blue-600 hover:text-blue-700">Buka Berita Acara →</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Widgets -->
    <div class="space-y-6">
        <!-- Physical Audit Card -->
        <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-200">
            <div class="h-32 bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center">
                <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="p-4">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="font-semibold text-gray-900">Audit Fisik Lapangan</h4>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                        AKTIF
                    </span>
                </div>
                <p class="text-sm text-gray-600">Verifikasi Q1-2025</p>
            </div>
        </div>

        <!-- Schedule Card -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
            <div class="flex items-center space-x-2 mb-4">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h4 class="font-semibold text-gray-900">Jadwal Opname & Uji Petik</h4>
            </div>

            <div class="space-y-4">
                <!-- Zone B -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-900">Zona B (Elektronik & High-Value)</span>
                        <span class="text-xs text-green-600 font-semibold">100% Selesai</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Rekonsiliasi verifikasi valid & terdokumentasi</p>
                </div>

                <!-- Zone C -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-900">Zona C (Gadget & Storage)</span>
                        <span class="text-xs text-blue-600 font-semibold">68% Berjalan</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 68%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Uji petik 420 SKU berjalan oleh Tim B</p>
                </div>

                <!-- Zone D -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-900">Zona D (Perangkat Jaringan)</span>
                        <span class="text-xs text-gray-500 font-semibold">Terjadwal</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gray-400 h-2 rounded-full" style="width: 0%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Sen, 09:00 WIB (Pemeriksa: Dewi A.)</p>
                </div>
            </div>
        </div>

        <!-- Distribution Card -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
            <h4 class="font-semibold text-gray-900 mb-4">Distribusi Temuan per Kategori</h4>
            
            <div class="space-y-3">
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-blue-500 rounded"></div>
                            <span class="text-sm text-gray-700">Selisih Kuantitas Stok</span>
                        </div>
                        <span class="text-xs text-gray-500">2 Temuan (50%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 50%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-red-500 rounded"></div>
                            <span class="text-sm text-gray-700">Kerusakan Fisik Kemasan</span>
                        </div>
                        <span class="text-xs text-gray-500">1 Temuan (25%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: 25%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-green-500 rounded"></div>
                            <span class="text-sm text-gray-700">Keterlambatan Dokumen Admin</span>
                        </div>
                        <span class="text-xs text-gray-500">1 Temuan (25%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 25%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Log Card -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
            <h4 class="font-semibold text-gray-900 mb-4">Log Aktivitas Audit Terkini</h4>
            
            <div class="space-y-3">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-700">Dewi Anggraini memverifikasi temuan #AUD-2025-041 untuk Ka. Gudang</p>
                        <p class="text-xs text-gray-500 mt-1">18 menit lalu</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-700">Deteksi ketidaksesuaian berat Inbound - otomatis hold Dock 4 pada selisih 4.2 kg di PO-9081</p>
                        <p class="text-xs text-gray-500 mt-1">1 jam lalu</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-700">Pengesahan Blok Ledger Mingguan - Blok #AUDIT-2025-W12 ditandatangani secara kriptografis oleh Kepatuhan</p>
                        <p class="text-xs text-gray-500 mt-1">3 jam lalu</p>
                    </div>
                </div>
            </div>

            <button class="w-full mt-4 text-sm font-medium text-blue-600 hover:text-blue-700">
                Lihat Riwayat Lengkap Seluruh Log →
            </button>
        </div>
    </div>
</div>
