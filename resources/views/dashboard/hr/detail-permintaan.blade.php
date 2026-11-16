@extends('layouts.app')

@section('title', 'Detail Permintaan #TRX-2025-0891 - Astro Inventory')

@section('content')
<div class="space-y-6 animate-fade-in">

    {{-- Header Section --}}
    @include('components.navbar')

    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Main Content Area --}}
    <div class="ml-64 lg:ml-264 min-h-[calc(100vh-56px)] pt-6 pb-6 animate-fade-in overflow-x-hidden">

        {{-- Top Header & Breadcrumbs --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 animate-fade-in-up">
            <div class="flex items-center space-x-2 text-xs text-gray-500 overflow-x-auto whitespace-nowrap">
                <a href="#" class="hover:text-blue-600">Beranda</a>
                <i class="fas fa-chevron-right text-[10px]"></i>
                <a href="#" class="hover:text-blue-600">Operasional & Persetujuan</a>
                <i class="fas fa-chevron-right text-[10px]"></i>
                <a href="#" class="hover:text-blue-600">Antrean Persetujuan</a>
                <i class="fas fa-chevron-right text-[10px]"></i>
                <span class="text-gray-800 font-medium">Detail Permintaan #TRX-2025-0891</span>
            </div>

            <a href="#" class="text-xs font-semibold text-gray-600 hover:text-blue-600 flex items-center space-x-1.5 self-start sm:self-auto">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali ke Antrean</span>
            </a>
        </div>

        {{-- Header Action Title & Status Badges --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5 mb-6 shadow-sm animate-fade-in-up" style="animation-delay: 0.1s">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h1 class="text-xl lg:text-2xl font-bold text-gray-900 flex items-center space-x-2">
                            <i class="fas fa-exchange-alt text-blue-600"></i>
                            <span>Permintaan #TRX-2025-0891</span>
                        </h1>
                        <span class="bg-blue-50 text-blue-700 border border-blue-200 text-xs font-bold px-2.5 py-0.5 rounded-full flex items-center space-x-1">
                            <i class="fas fa-circle text-[6px]"></i>
                            <span>Menunggu Persetujuan HR</span>
                        </span>
                        <span class="bg-red-50 text-red-600 border border-red-200 text-xs font-bold px-2.5 py-0.5 rounded-full flex items-center space-x-1">
                            <i class="fas fa-clock text-xs"></i>
                            <span>Prioritas Tinggi (SLA 25 Menit)</span>
                        </span>
                    </div>
                    <p class="text-xs text-gray-500">
                        Dibuat 24 Okt 2025, 14:20 WIB &bull; Otorisasi Segregation of Duties (SoD) Level 2
                    </p>
                </div>

                {{-- Action Bar Buttons --}}
                <div class="flex flex-wrap items-center gap-2">
                    <button class="btn-danger border border-red-300 text-red-600 hover:bg-red-50 px-3.5 py-2 rounded-lg text-xs font-semibold flex items-center space-x-1.5">
                        <i class="fas fa-times"></i>
                        <span>Tolak Permintaan</span>
                    </button>
                    <button class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-3.5 py-2 rounded-lg text-xs font-semibold flex items-center space-x-1.5 shadow-xs">
                        <i class="fas fa-question-circle"></i>
                        <span>Minta Klarifikasi Checker</span>
                    </button>
                    <button class="btn-primary bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-lg text-xs font-semibold flex items-center space-x-1.5 shadow-sm">
                        <i class="fas fa-check-circle"></i>
                        <span>Setujui Permintaan Sekarang</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Two Column Main Layout Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left 2 Columns: Detailed Specifications & Compliance --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Card 1: Spesifikasi Mutasi Antar-Hub --}}
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm animate-fade-in-left" style="animation-delay: 0.2s">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                        <h3 class="text-sm font-bold text-gray-900 flex items-center space-x-2">
                            <i class="fas fa-truck-loading text-blue-600"></i>
                            <span>Spesifikasi Mutasi Antar-Hub</span>
                        </h3>
                        <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-0.5 rounded flex items-center space-x-1">
                            <i class="fas fa-circle text-[6px]"></i>
                            <span>Rute Logistik Siap</span>
                        </span>
                    </div>

                    {{-- Origin to Destination Visual Card --}}
                    <div class="bg-blue-50/60 border border-blue-100 rounded-lg p-4 mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-7 gap-3 items-center text-center md:text-left">
                            <div class="md:col-span-3 bg-white p-3 rounded-lg border border-blue-100 shadow-2xs">
                                <p class="text-[10px] font-bold text-blue-600 uppercase tracking-wider mb-1">HUB PENGIRIM (ORIGIN)</p>
                                <h4 class="text-sm font-bold text-gray-900 flex items-center space-x-2">
                                    <i class="fas fa-warehouse text-blue-500"></i>
                                    <span>Cakung DC-01 (Utama)</span>
                                </h4>
                                <p class="text-[10px] text-gray-500 mt-0.5">Zona Elektrik A4 &bull; Jakarta Timur</p>
                            </div>

                            <div class="md:col-span-1 flex flex-col items-center justify-center py-1">
                                <i class="fas fa-arrow-right text-blue-500 text-lg hidden md:block"></i>
                                <i class="fas fa-arrow-down text-blue-500 text-lg md:hidden"></i>
                                <span class="text-[10px] font-bold text-gray-400 mt-1">18 KM</span>
                            </div>

                            <div class="md:col-span-3 bg-white p-3 rounded-lg border border-blue-100 shadow-2xs">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">HUB TUJUAN (DESTINATION)</p>
                                <h4 class="text-sm font-bold text-gray-900 flex items-center space-x-2">
                                    <i class="fas fa-warehouse text-gray-500"></i>
                                    <span>Halim DC-02</span>
                                </h4>
                                <p class="text-[10px] text-gray-500 mt-0.5">Staging Bay B1 &bull; Jakarta Timur</p>
                            </div>
                        </div>
                    </div>

                    {{-- Spec Metadata Cards --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
                        <div class="border border-gray-100 bg-gray-50 p-3 rounded-lg flex items-start space-x-2.5">
                            <div class="w-7 h-7 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">
                                RH
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-semibold">PEMOHON / PENGAJU</p>
                                <p class="text-xs font-bold text-gray-900">Rian Hidayat</p>
                                <p class="text-[10px] text-gray-500">NIP: AST-88129 (Staf Picker)</p>
                            </div>
                        </div>

                        <div class="border border-gray-100 bg-gray-50 p-3 rounded-lg">
                            <p class="text-[10px] text-gray-400 uppercase font-semibold">TIPE OTORISASI LOGISTIK</p>
                            <p class="text-xs font-bold text-gray-900">Mutasi Antar-Hub</p>
                            <p class="text-[10px] text-gray-500">Prioritas: Batch Korporat Khusus</p>
                        </div>

                        <div class="border border-gray-100 bg-gray-50 p-3 rounded-lg">
                            <p class="text-[10px] text-gray-400 uppercase font-semibold">VALIDASI FISIK LAPANGAN</p>
                            <p class="text-xs font-bold text-green-700 flex items-center space-x-1">
                                <i class="fas fa-check-circle"></i>
                                <span>Tervalidasi Ka. Gudang</span>
                            </p>
                            <p class="text-[10px] text-gray-500">Budi Santoso &bull; 14:15 WIB</p>
                        </div>
                    </div>

                    {{-- Justification Note --}}
                    <div class="bg-gray-50 border-l-4 border-blue-500 p-3.5 rounded-r-lg">
                        <p class="text-[11px] font-bold text-gray-700 flex items-center space-x-1.5 mb-1">
                            <i class="fas fa-quote-left text-blue-500"></i>
                            <span>Catatan Justifikasi Permintaan:</span>
                        </p>
                        <p class="text-xs text-gray-600 italic">
                            "Permintaan alokasi darurat dari Hub Cakung DC-01 menuju Hub Halim DC-02 untuk pemenuhan batch order elektronik korporat. Telah diverifikasi fisik oleh tim logistik timur dan armada truk C-04 telah stand by di staging bay."
                        </p>
                    </div>
                </div>

                {{-- Card 2: Rincian Item & Dampak Stok Buffer --}}
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm animate-fade-in-left" style="animation-delay: 0.3s">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                        <h3 class="text-sm font-bold text-gray-900 flex items-center space-x-2">
                            <i class="fas fa-boxes text-blue-600"></i>
                            <span>Rincian Item &amp; Dampak Stok Buffer</span>
                        </h3>
                        <span class="text-xs text-gray-500 font-medium">1 SKU Terkait</span>
                    </div>

                    {{-- Product Row Specs --}}
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between border border-gray-100 p-3 rounded-lg bg-gray-50/50 mb-5 gap-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500 flex-shrink-0">
                                <i class="fas fa-camera text-xl"></i>
                            </div>
                            <div>
                                <div class="flex items-center space-x-2 mb-0.5">
                                    <span class="text-[10px] text-gray-400 font-mono">SKU - CAM - 6000</span>
                                    <span class="bg-teal-100 text-teal-800 text-[10px] font-bold px-1.5 py-0.2 rounded">Kategori: Audio Visual Pro</span>
                                </div>
                                <h4 class="text-sm font-bold text-gray-900">Canon 6D DSLR Camera Body</h4>
                                <p class="text-[10px] text-gray-500">
                                    Bin Lokasi Rak: <strong class="text-gray-700">WH01-RACK-A4</strong> &bull; Serial Tracked: Ya (Barcode Manifest Terlampir)
                                </p>
                            </div>
                        </div>

                        <div class="text-left sm:text-right border-t sm:border-t-0 border-gray-200 pt-2 sm:pt-0 w-full sm:w-auto">
                            <p class="text-[10px] text-gray-400 uppercase font-semibold">Estimasi Nilai Total</p>
                            <p class="text-sm font-extrabold text-blue-700">Rp 1.875.000.000</p>
                            <p class="text-[10px] text-gray-400">@ Rp 12.500.000 / unit</p>
                        </div>
                    </div>

                    {{-- 4 Buffer Stats Box --}}
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-5">
                        <div class="border border-gray-200 bg-white p-3 rounded-lg">
                            <p class="text-[10px] text-gray-400 font-bold uppercase">STOK SAAT INI (BIN A4)</p>
                            <p class="text-xl font-extrabold text-gray-900 my-0.5">240 <span class="text-xs font-normal text-gray-500">Unit</span></p>
                            <p class="text-[10px] text-gray-400">Kapasitas Maks: 300 Unit</p>
                        </div>

                        <div class="border border-blue-200 bg-blue-50/50 p-3 rounded-lg">
                            <p class="text-[10px] text-blue-600 font-bold uppercase">JUMLAH DIMINTA</p>
                            <p class="text-xl font-extrabold text-blue-700 my-0.5">150 <span class="text-xs font-normal text-blue-500">Unit</span></p>
                            <p class="text-[10px] text-blue-600 font-medium">62.5% dari stok bin</p>
                        </div>

                        <div class="border border-teal-200 bg-teal-50/50 p-3 rounded-lg">
                            <p class="text-[10px] text-teal-700 font-bold uppercase">SISA BUFFER PASCA MUTASI</p>
                            <p class="text-xl font-extrabold text-teal-800 my-0.5">90 <span class="text-xs font-normal text-teal-600">Unit</span></p>
                            <p class="text-[10px] text-teal-700 font-semibold flex items-center space-x-1">
                                <i class="fas fa-shield-alt text-[9px]"></i>
                                <span>Aman di atas ROP</span>
                            </p>
                        </div>

                        <div class="border border-gray-200 bg-white p-3 rounded-lg">
                            <p class="text-[10px] text-gray-400 font-bold uppercase">AMBANG REORDER (ROP)</p>
                            <p class="text-xl font-extrabold text-gray-900 my-0.5">25 <span class="text-xs font-normal text-gray-500">Unit</span></p>
                            <p class="text-[10px] text-green-600 font-medium">Buffer keselamatan aman (+65)</p>
                        </div>
                    </div>

                    {{-- Progress Bar Simulation --}}
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <div class="flex justify-between items-center text-xs font-bold text-gray-800 mb-2">
                            <span>Simulasi Ketersediaan Bin Pasca Transfer</span>
                            <span class="text-green-600 font-semibold">37.5% Buffer Cadangan Tetap Terjaga</span>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-3 flex overflow-hidden mb-2">
                            <div class="progress-bar-fill bg-blue-600 h-3" style="width: 62.5%" title="Mutasi Keluar (150 Unit)"></div>
                            <div class="progress-bar-fill bg-green-500 h-3" style="width: 27.1%" title="Buffer Tersisa (65 Unit)"></div>
                            <div class="progress-bar-fill bg-red-500 h-3" style="width: 10.4%" title="Titik Minimum ROP (25 Unit)"></div>
                        </div>

                        <div class="flex flex-wrap items-center justify-between text-[10px] text-gray-500 gap-2">
                            <span class="flex items-center space-x-1">
                                <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                                <span>Mutasi Keluar (150 Unit)</span>
                            </span>
                            <span class="flex items-center space-x-1">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                <span>Buffer Tersisa (65 Unit)</span>
                            </span>
                            <span class="flex items-center space-x-1">
                                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                <span>Titik Minimum ROP (25 Unit)</span>
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Verifikasi Kepatuhan Regulasi Logistik & HR --}}
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm animate-fade-in-left" style="animation-delay: 0.4s">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                        <h3 class="text-sm font-bold text-gray-900 flex items-center space-x-2">
                            <i class="fas fa-clipboard-check text-blue-600"></i>
                            <span>Verifikasi Kepatuhan Regulasi Logistik &amp; HR</span>
                        </h3>
                        <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded">3 dari 4 Terpenuhi</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        {{-- Check 1 --}}
                        <div class="border border-green-200 bg-green-50/40 p-3 rounded-lg flex items-start space-x-2.5">
                            <div class="w-6 h-6 bg-green-500 text-white rounded-full flex items-center justify-center text-xs flex-shrink-0 mt-0.5">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900">Otorisasi Kepala Gudang Cakung</h4>
                                <p class="text-[10px] text-gray-600 mt-0.5">Diverifikasi oleh Budi Santoso (NIP AST-0021). Tandatangan digital valid.</p>
                            </div>
                        </div>

                        {{-- Check 2 --}}
                        <div class="border border-green-200 bg-green-50/40 p-3 rounded-lg flex items-start space-x-2.5">
                            <div class="w-6 h-6 bg-green-500 text-white rounded-full flex items-center justify-center text-xs flex-shrink-0 mt-0.5">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900">Manifest Surat Jalan SPO-WMS-019</h4>
                                <p class="text-[10px] text-gray-600 mt-0.5">Dokumen jalan elektronik terbit dengan nomor registrasi unik barcode terpasang.</p>
                            </div>
                        </div>

                        {{-- Check 3 --}}
                        <div class="border border-green-200 bg-green-50/40 p-3 rounded-lg flex items-start space-x-2.5">
                            <div class="w-6 h-6 bg-green-500 text-white rounded-full flex items-center justify-center text-xs flex-shrink-0 mt-0.5">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900">Kapasitas Armada Ekspedisi DC-02</h4>
                                <p class="text-[10px] text-gray-600 mt-0.5">Truk Box C-04 kapasitas muat 1.2 Ton tersedia & siap di docking area Cakung.</p>
                            </div>
                        </div>

                        {{-- Check 4 (Pending) --}}
                        <div class="border border-blue-200 bg-blue-50/40 p-3 rounded-lg flex items-start space-x-2.5">
                            <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs flex-shrink-0 mt-0.5 pulse-animation">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-blue-900">Otorisasi Segregation of Duties (SoD) HR</h4>
                                <p class="text-[10px] text-blue-700 mt-0.5">Menunggu konfirmasi final persetujuan dari Manager HR / Budi Santoso.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right Column: Approval Action Panel & Tracking Widgets --}}
            <div class="space-y-6">

                {{-- HR Action Box --}}
                <div class="bg-white border-2 border-blue-600 rounded-xl p-5 shadow-md animate-fade-in-right" style="animation-delay: 0.2s">
                    <h3 class="text-sm font-bold text-gray-900 flex items-center space-x-2 mb-3">
                        <i class="fas fa-user-shield text-blue-600"></i>
                        <span>Tindakan Otorisasi HR</span>
                    </h3>

                    <form class="space-y-3">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-1">Catatan Otorisator / Alasan (Opsional)</label>
                            <textarea rows="3"
                                      placeholder="Masukkan instruksi khusus serah terima barang atau catatan otorisasi..."
                                      class="w-full text-xs p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                        </div>

                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded">
                            <span class="text-xs text-gray-600">Kirim salinan notifikasi instan ke PIC Gudang &amp; Koordinator Transport via Telegram Bot</span>
                        </label>

                        <button type="button" class="w-full btn-primary bg-blue-600 text-white font-bold py-2.5 rounded-lg text-xs hover:bg-blue-700 flex items-center justify-center space-x-2 shadow-sm">
                            <i class="fas fa-check-double"></i>
                            <span>Konfirmasi &amp; Setujui Tiket</span>
                        </button>

                        <div class="grid grid-cols-2 gap-2 pt-1">
                            <button type="button" class="py-2 border border-gray-300 rounded-lg text-xs font-semibold text-gray-700 hover:bg-gray-50">Minta Revisi</button>
                            <button type="button" class="py-2 bg-red-50 text-red-600 border border-red-200 rounded-lg text-xs font-semibold hover:bg-red-100">Tolak Permanen</button>
                        </div>
                    </form>
                </div>

                {{-- SLA Timeline Widget --}}
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm animate-fade-in-right" style="animation-delay: 0.3s">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                        <h3 class="text-sm font-bold text-gray-900 flex items-center space-x-2">
                            <i class="fas fa-history text-blue-600"></i>
                            <span>Alur Persetujuan &amp; SLA</span>
                        </h3>
                        <span class="bg-red-100 text-red-600 text-[10px] font-bold px-2 py-0.5 rounded pulse-animation">
                            Sisa 25 Menit
                        </span>
                    </div>

                    {{-- Vertical Step Timeline --}}
                    <div class="relative border-l-2 border-blue-500 ml-3 space-y-5">

                        {{-- Step 1 --}}
                        <div class="relative pl-5">
                            <div class="absolute -left-[9px] top-0.5 w-4 h-4 bg-green-500 rounded-full flex items-center justify-center text-white text-[9px]">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="flex justify-between items-start">
                                <h4 class="text-xs font-bold text-gray-900">Draft Tiket Dibuat</h4>
                                <span class="text-[10px] text-gray-400">14:05 WIB</span>
                            </div>
                            <p class="text-[10px] text-gray-500">Oleh Checker Lapangan (Rian Hidayat)</p>
                        </div>

                        {{-- Step 2 --}}
                        <div class="relative pl-5">
                            <div class="absolute -left-[9px] top-0.5 w-4 h-4 bg-green-500 rounded-full flex items-center justify-center text-white text-[9px]">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="flex justify-between items-start">
                                <h4 class="text-xs font-bold text-gray-900">Validasi Fisik &amp; Scan Barcode</h4>
                                <span class="text-[10px] text-gray-400">14:15 WIB</span>
                            </div>
                            <p class="text-[10px] text-gray-500">Budi Santoso (Ka. Gudang Cakung DC-01)</p>
                        </div>

                        {{-- Step 3 (Current Active Step) --}}
                        <div class="relative pl-5">
                            <div class="absolute -left-[9px] top-0.5 w-4 h-4 bg-blue-600 rounded-full flex items-center justify-center text-white text-[9px] pulse-animation">
                                <i class="fas fa-user-clock"></i>
                            </div>
                            <div class="flex justify-between items-start">
                                <h4 class="text-xs font-bold text-blue-900">Otorisasi HR &amp; Mutasi Aset</h4>
                                <span class="text-[10px] font-bold text-blue-600">Tahap Ini</span>
                            </div>
                            <p class="text-[10px] text-blue-700 font-medium">Menunggu persetujuan Anda (Batas SLA: 15:00 WIB)</p>
                        </div>

                        {{-- Step 4 (Future Step) --}}
                        <div class="relative pl-5 opacity-60">
                            <div class="absolute -left-[9px] top-0.5 w-4 h-4 bg-gray-300 rounded-full flex items-center justify-center text-white text-[9px]">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="flex justify-between items-start">
                                <h4 class="text-xs font-bold text-gray-700">Dispatch Truk Box C-04</h4>
                                <span class="text-[10px] text-gray-400">Est. 15:15 WIB</span>
                            </div>
                            <p class="text-[10px] text-gray-500">Perjalanan menuju Halim DC-02</p>
                        </div>

                    </div>
                </div>

                {{-- Kuota Mutasi Harian Cakung --}}
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm animate-fade-in-right" style="animation-delay: 0.4s">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-3">
                        <h3 class="text-sm font-bold text-gray-900 flex items-center space-x-2">
                            <i class="fas fa-chart-pie text-blue-600"></i>
                            <span>Kuota Mutasi Harian Cakung</span>
                        </h3>
                        <span class="text-[10px] text-gray-400 font-medium">Limit 2.000 / Hari</span>
                    </div>

                    {{-- Progress Circle Stat Simulation --}}
                    <div class="flex items-center space-x-4 bg-blue-50/50 p-3 rounded-lg border border-blue-100">
                        <div class="relative w-14 h-14 flex items-center justify-center flex-shrink-0">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <path class="text-gray-200" stroke-width="3.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                <path class="text-blue-600" stroke-dasharray="82, 100" stroke-width="3.5" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            </svg>
                            <span class="absolute text-xs font-extrabold text-blue-900">82%</span>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold text-gray-900">1.640 / 2.000 Unit</h4>
                            <p class="text-[10px] text-gray-600 mt-0.5">
                                Sisa alokasi kuota mutasi hari ini: <strong class="text-gray-900">360 Unit</strong>. Pengajuan 150 unit memenuhi toleransi regulasi.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-[10px] text-gray-500 mt-3">
                        <span>Status Buffer Hub Pengirim</span>
                        <span class="text-green-600 font-bold flex items-center space-x-1">
                            <i class="fas fa-check-circle"></i>
                            <span>Optimal (Normal)</span>
                        </span>
                    </div>
                </div>

                {{-- Dokumen Lampiran Otorisasi --}}
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm animate-fade-in-right" style="animation-delay: 0.5s">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">DOKUMEN LAMPIRAN OTORISASI</h3>

                    <div class="space-y-2">
                        <a href="#" class="flex items-center justify-between p-2.5 border border-gray-200 rounded-lg hover:bg-blue-50/50 hover:border-blue-300 transition-all text-xs">
                            <div class="flex items-center space-x-2.5">
                                <i class="fas fa-file-pdf text-red-500 text-base"></i>
                                <div>
                                    <p class="font-bold text-gray-800">SPO-WMS-019-HalimTransfer.pdf</p>
                                    <p class="text-[10px] text-gray-400">Surat Jalan Resmi &bull; 245 KB</p>
                                </div>
                            </div>
                            <i class="fas fa-download text-gray-400 hover:text-blue-600"></i>
                        </a>

                        <a href="#" class="flex items-center justify-between p-2.5 border border-gray-200 rounded-lg hover:bg-blue-50/50 hover:border-blue-300 transition-all text-xs">
                            <div class="flex items-center space-x-2.5">
                                <i class="fas fa-file-csv text-green-600 text-base"></i>
                                <div>
                                    <p class="font-bold text-gray-800">Manifest_Barcode_150Unit.csv</p>
                                    <p class="text-[10px] text-gray-400">Daftar Serial Number &bull; 118 KB</p>
                                </div>
                            </div>
                            <i class="fas fa-download text-gray-400 hover:text-blue-600"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>

        {{-- Toast / Bottom System Notification Popup Banner --}}
        <div class="mt-6 bg-teal-50 border border-teal-200 rounded-lg p-3.5 flex items-center justify-between shadow-xs animate-fade-in-up" style="animation-delay: 0.6s">
            <div class="flex items-center space-x-3">
                <div class="w-7 h-7 bg-teal-500 text-white rounded-full flex items-center justify-center text-xs flex-shrink-0">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-teal-900">Sistem Siap Otorisasi</h4>
                    <p class="text-[11px] text-teal-800">Tiket #TRX-2025-0891 siap dieksekusi tanpa hambatan keterbatasan buffer stok.</p>
                </div>
            </div>
            <button class="text-gray-400 hover:text-gray-600 text-xs">
                <i class="fas fa-times"></i>
            </button>
        </div>

    </div>
</div>

@push('scripts')
<script>
    lucide.createIcons();
    (() => {
      const sidebar = document.getElementById('sidebar');
      const backdrop = document.getElementById('sidebar-backdrop');
      const toggleButton = document.querySelector('#main-area header button[aria-label="Buka menu"]');
      if (!sidebar || !toggleButton) return;
      toggleButton.id = 'sidebar-toggle';
      toggleButton.setAttribute('aria-controls', 'sidebar');
      const isMobile = () => window.matchMedia('(max-width: 767px)').matches;
      const sync = () => {
        const open = isMobile() ? sidebar.classList.contains('open') : !document.body.classList.contains('sidebar-collapsed');
        toggleButton.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');
        toggleButton.setAttribute('title', open ? 'Tutup menu' : 'Buka menu');
        toggleButton.setAttribute('aria-expanded', String(open));
        const icon = toggleButton.querySelector('[data-lucide], svg');
        const iconName = open ? 'x' : 'menu';
        if (icon && !icon.classList.contains(`lucide-${iconName}`)) {
          toggleButton.innerHTML = `<i data-lucide="${iconName}" class="h-5 w-5"></i>`;
          lucide.createIcons();
        }
        backdrop.classList.toggle('show', isMobile() && open);
      };
      window.toggleSidebar = (close = false) => {
        if (isMobile()) sidebar.classList.toggle('open', close ? false : !sidebar.classList.contains('open'));
        else document.body.classList.toggle('sidebar-collapsed', close ? true : !document.body.classList.contains('sidebar-collapsed'));
        sync();
      };
      window.addEventListener('resize', sync);
      sync();
    })();
</script>
@endpush
@endsection