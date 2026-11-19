@extends('layouts.app')

@section('title', 'Transaksi Barang Masuk — Astro Inventory')

@section('content')
@include('components.navbar')

<div class="flex min-h-screen bg-[#f5f7fc] text-[#17243b] antialiased">
    @include('components.sidebar')

    <main class="flex-1 p-4 lg:p-6 overflow-x-hidden">
            <section class="reveal mb-4 flex flex-wrap items-end justify-between gap-3 rounded-xl border border-slate-100 bg-white p-4 shadow-sm">
                <div class="max-w-2xl">
                    <p class="mb-1 text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Operasional & Transaksi <span class="text-blue-700">&gt; Transaksi Barang Masuk (Inbound DC)</span></p>
                    <h1 class="text-[24px] font-bold leading-tight tracking-tight text-slate-800">Transaksi Barang Masuk (Inbound DC)</h1>
                    <p class="mt-1.5 text-[10.5px] leading-relaxed text-slate-500">Monitoring penerimaan logistik dari mitra pemasok/supplier, validasi Purchase Order (PO), inspeksi Quality Control (QC), penerbitan Berita Acara Serah Terima, dan alokasi rak parah Hub Cabang DC-01.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="hidden rounded-full bg-blue-50 px-3 py-1 text-[10.5px] font-semibold text-blue-700 xl:inline-flex"><i class="fas fa-truck mr-1"></i>4 Antrean Dock Aktif</span>
                    <button id="export-inbound" class="soft-button flex h-10 items-center gap-2 rounded-md border border-slate-200 bg-white px-4 text-[12px] font-semibold text-slate-700 shadow-sm"><i class="fas fa-download text-blue-600"></i>Ekspor Data Inbound</button>
                    <button id="schedule-dock" class="soft-button flex h-10 items-center gap-2 rounded-md border border-slate-200 bg-white px-4 text-[12px] font-semibold text-slate-700 shadow-sm"><i class="fas fa-calendar-alt text-blue-600"></i>Jadwal Kedatangan Dock</button>
                    <button id="add-inbound" class="soft-button flex h-10 items-center gap-2 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white shadow-sm hover:bg-blue-700"><i class="fas fa-plus"></i>Catat Penerimaan Barang Masuk</button>
                </div>
            </section>

            <section aria-label="Ringkasan inbound" class="reveal delay-1 mb-4 grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
                <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                    <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Total Masuk Hari Ini</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight text-slate-800">1.420 <span class="text-[10.5px] font-medium text-slate-500">Unit</span></p><p class="mt-2.5 text-[10.5px] font-semibold text-blue-700">✓ 8 SKU terverifikasi lengkap</p></div>
                    <span class="flex h-8 w-8 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i class="fas fa-box-check"></i></span>
                </article>
                <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                    <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">PO Dalam Proses Inbound</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight text-slate-800">14 <span class="text-[10.5px] font-medium text-slate-500">Berkas PO</span></p><p class="mt-2.5 text-[10.5px] text-slate-500">8 Selesai &nbsp;·&nbsp; 6 Sedang Bongkar</p></div>
                    <span class="flex h-8 w-8 items-center justify-center rounded-md bg-emerald-50 text-emerald-700"><i class="fas fa-clipboard-list"></i></span>
                </article>
                <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                    <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Lolos Uji Quality Control</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight text-slate-800">99.4% <span class="text-[10.5px] font-medium text-slate-500">AQL 1.5</span></p><p class="mt-2.5 text-[10.5px] text-slate-500">1.412 Diterima &nbsp;·&nbsp; 8 Karantina / Defect</p></div>
                    <span class="flex h-8 w-8 items-center justify-center rounded-md bg-emerald-50 text-emerald-700"><i class="fas fa-badge-check"></i></span>
                </article>
                <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                    <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Menunggu Putaway / Staging</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight text-slate-800">320 <span class="text-[10.5px] font-medium text-slate-500">Unit / Pallet</span></p><p class="mt-2.5 text-[10.5px] text-slate-500">Area Transit Inbound Dock 01-03</p></div>
                    <span class="flex h-8 w-8 items-center justify-center rounded-md bg-indigo-50 text-indigo-700"><i class="fas fa-warehouse"></i></span>
                </article>
            </section>

            <section class="reveal delay-2 mb-4 rounded-xl border border-slate-100 bg-white p-3 shadow-sm">
                <div class="mb-3 flex flex-wrap items-center justify-between gap-2">
                    <div><h2 class="flex items-center gap-2 text-[12px] font-semibold text-slate-800"><i class="fas fa-truck text-blue-600"></i>Status Slot Loading Dock & Antrean Truk Pemasok</h2><p class="ml-6 text-[10.5px] text-slate-500">Hub Cabang DC-01 · 4 Loading Bays Tersedia dengan Sistem Sensor Pallet</p></div>
                    <button id="dock-cctv" class="text-[10.5px] font-semibold text-blue-600 hover:text-blue-800">Lihat Kamera CCTV & Jadwal Dock Lengkap →</button>
                </div>
                <div id="dock-cards" class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4"></div>
            </section>

            <section class="reveal delay-2 mb-4 rounded-xl border border-slate-100 bg-white p-3 shadow-sm">
                <div class="flex flex-wrap items-center gap-2">
                    <label class="flex h-10 min-w-[220px] flex-1 items-center gap-2 rounded-md bg-blue-50/80 px-3 text-slate-400 xl:max-w-[430px]"><i class="fas fa-search"></i><input id="inbound-search" type="search" placeholder="Cari nomor PO, surat jalan, nama supplier, atau SKU barang..." class="w-full bg-transparent text-[12px] text-slate-700 outline-none placeholder:text-slate-400"><i class="fas fa-barcode text-blue-500"></i></label>
                    <select id="supplier-filter" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none"><option value="">Semua Supplier (Semua DC)</option></select>
                    <select id="status-filter" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none"><option value="">Status Penerimaan (Semua)</option><option value="Selesai Putaway">Selesai & Diterima</option><option value="Sedang QC">Sedang Proses Bongkar</option><option value="Proses Bongkar">Proses Bongkar</option><option value="Menunggu Putaway">Menunggu Putaway</option><option value="Retur / Masalah">Retur / Masalah</option></select>
                    <select id="dock-filter" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none"><option value="">Metode QC: Semua (AQL/Full)</option><option value="AQL">Sampling AQL</option><option value="Full">Full Inspection</option></select>
                    <button id="advanced-filter" class="flex h-10 items-center gap-2 rounded-md bg-blue-50 px-3 text-[12px] text-slate-700"><i class="fas fa-filter"></i>Filter Lanjutan</button>
                    <button id="reset-filters" class="flex h-10 w-10 items-center justify-center rounded-md bg-blue-50 text-slate-600" aria-label="Reset filter"><i class="fas fa-rotate"></i></button>
                </div>
                <div class="mt-3 flex flex-wrap items-center gap-2 text-[10.5px]">
                    <span class="mr-1 font-semibold uppercase text-slate-600">FILTER CEPAT:</span>
                    <button data-quick-filter="all" class="rounded-full bg-blue-600 px-3 py-1 text-[10.5px] font-semibold text-white">Semua Inbound (14)</button>
                    <button data-quick-filter="Selesai Putaway" class="rounded-full bg-slate-100 px-3 py-1 text-[10.5px] font-semibold text-slate-600">Selesai & Diterima (8)</button>
                    <button data-quick-filter="Proses Bongkar" class="rounded-full bg-slate-100 px-3 py-1 text-[10.5px] font-semibold text-slate-600">Sedang Proses Bongkar (2)</button>
                    <button data-quick-filter="Sedang QC" class="rounded-full bg-slate-100 px-3 py-1 text-[10.5px] font-semibold text-slate-600">Inspeksi Karantina / QC (2)</button>
                    <button data-quick-filter="Retur / Masalah" class="rounded-full bg-red-50 px-3 py-1 text-[10.5px] font-semibold text-red-600">Retur / Masalah (1)</button>
                </div>
            </section>

            <section class="reveal delay-3 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between gap-2 px-3 pb-2 pt-3">
                    <h2 class="text-[12px] font-semibold text-slate-800">Daftar Transaksi Inbound Terjadwal Hari Ini <span id="transaction-total" class="ml-1 rounded bg-blue-50 px-2 py-1 text-[10.5px] font-semibold text-blue-700">14 TRANSAKSI</span></h2>
                    <div class="flex items-center gap-1"><button id="refresh-list" class="rounded p-1 text-slate-500 hover:bg-slate-100" aria-label="Segarkan daftar"><i class="fas fa-rotate"></i></button><button id="compact-toggle" class="rounded p-1 text-slate-500 hover:bg-slate-100" aria-label="Ubah kerapatan tabel"><i class="fas fa-list"></i></button></div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[1300px] table-fixed border-collapse text-left">
                        <thead class="h-11 whitespace-nowrap bg-[#f0f4fc] text-[9.5px] font-semibold uppercase tracking-wide text-slate-600">
                            <tr>
                                <th class="w-[48px] px-2"><input id="select-all" type="checkbox" aria-label="Pilih semua transaksi" class="h-4 w-4 accent-blue-600"></th>
                                <th class="w-[145px] px-2">No. PO & Surat Jalan</th>
                                <th class="w-[220px] px-2">Supplier & PIC Ekspedisi</th>
                                <th class="w-[210px] px-2">Detail Komoditas / Barang</th>
                                <th class="w-[150px] px-2">Total Qty & Kemasan</th>
                                <th class="w-[175px] px-2">Lokasi Staging / Rak Tujuan</th>
                                <th class="w-[220px] px-2">Hasil QC & Status Inbound</th>
                                <th class="w-[100px] px-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="inbound-rows" class="divide-y divide-slate-100 text-[12px]"></tbody>
                    </table>
                </div>
                <footer class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 px-4 py-3 text-[12px] text-slate-600">
                    <div class="flex items-center gap-2"><span id="row-count" aria-live="polite"></span><span>Baris per halaman:</span><select id="page-size" class="h-8 rounded bg-blue-50 px-2 text-[12px]"><option value="7">7</option><option value="10">10</option><option value="25">25</option></select></div>
                    <div class="flex items-center gap-1.5"><button id="previous-page" class="h-8 min-w-8 rounded bg-blue-50 px-2 text-[12px] disabled:opacity-40">‹</button><div id="pagination" class="flex items-center gap-1"></div><button id="next-page" class="h-8 min-w-8 rounded bg-blue-50 px-2 text-[12px] disabled:opacity-40">›</button></div>
                </footer>
            </section>

            <section class="reveal delay-3 mt-4 grid grid-cols-1 gap-3 lg:grid-cols-3">
                <article class="flex min-h-[60px] flex-col justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                    <div class="flex gap-3"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i class="fas fa-barcode"></i></span><div><h2 class="text-[12px] font-semibold text-slate-800">Pindai Barcode Surat Jalan (ASN)</h2><p class="mt-1 text-[10.5px] leading-relaxed text-slate-500">Pemindaian QR Code dokumen jalan supplier secara presisi untuk sinkronisasi dengan integrasi scanner nirkabel Zebra DS2208 & kamera terminal handheld.</p></div></div>
                    <div class="mt-3 flex items-center justify-between text-[10.5px]"><span class="font-semibold text-emerald-700">● Scanner Nirkabel Terhubung</span><button data-action="scanner" class="font-semibold text-blue-600 hover:text-blue-800">Buka Scanner →</button></div>
                </article>
                <article class="flex min-h-[60px] flex-col justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                    <div class="flex gap-3"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-emerald-50 text-emerald-700"><i class="fas fa-shield-check"></i></span><div><h2 class="text-[12px] font-semibold text-slate-800">Standar Prosedur QC Inbound</h2><p class="mt-1 text-[10.5px] leading-relaxed text-slate-500">Protokol uji sampling fisik (AQL Level 1.5), verifikasi barcode SKU, label kemasan, dan uji kecocokan spesifikasi sebelum alokasi putaway.</p></div></div>
                    <div class="mt-3 flex items-center justify-between text-[10.5px]"><span class="text-slate-500">SOP Revisi 4.2 (2025)</span><button data-action="checklist" class="font-semibold text-blue-600 hover:text-blue-800">Unduh Checklist QC →</button></div>
                </article>
                <article class="flex min-h-[60px] flex-col justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                    <div class="flex gap-3"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-700"><i class="fas fa-file-invoice"></i></span><div><h2 class="text-[12px] font-semibold text-slate-800">Integrasi Surat Jalan Elektronik (e-DO)</h2><p class="mt-1 text-[10.5px] leading-relaxed text-slate-500">Otomatisasi pengiriman Berita Acara Penerimaan Barang (BAPB) digital dan tanda tangan elektronik tersertifikasi ke portal vendor supplier.</p></div></div>
                    <div class="mt-3 flex items-center justify-between text-[10.5px]"><span class="font-semibold text-emerald-700">● Sync API Vendor Aktif</span><button data-action="edo" class="font-semibold text-blue-600 hover:text-blue-800">Log Integrasi e-DO →</button></div>
                </article>
            </section>
        </main>
    </div>

    <div id="inbound-modal" class="fixed inset-0 z-[70] hidden items-center justify-center bg-slate-950/40 p-4">
        <form id="inbound-form" class="max-h-[90vh] w-full max-w-[540px] overflow-y-auto rounded-xl bg-white p-4 shadow-xl">
            <div class="mb-4 flex items-start justify-between"><div><h2 class="text-[12px] font-bold text-slate-800">Catat Penerimaan Barang Masuk</h2><p class="mt-1 text-[10.5px] text-slate-500">Daftarkan kedatangan PO dan mulai proses inspeksi inbound.</p></div><button type="button" id="close-modal" class="rounded p-1 text-slate-400 hover:bg-slate-100" aria-label="Tutup"><i class="fas fa-times"></i></button></div>
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <label class="text-[12px] font-medium text-slate-700">Nomor PO<input name="po" required maxlength="24" pattern="([A-Za-z0-9]+-)*[A-Za-z0-9]+" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] uppercase outline-none focus:border-blue-500" placeholder="PO-2025-0898"></label>
                <label class="text-[12px] font-medium text-slate-700">Surat jalan<input name="delivery" required maxlength="30" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="SJ-01829-DC"></label>
                <label class="text-[12px] font-medium text-slate-700 sm:col-span-2">Supplier<input name="supplier" required maxlength="80" list="supplier-options" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="Nama perusahaan supplier"><datalist id="supplier-options"></datalist></label>
                <label class="text-[12px] font-medium text-slate-700 sm:col-span-2">Nama barang / komoditas<input name="product" required maxlength="100" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="Nama barang yang diterima"></label>
                <label class="text-[12px] font-medium text-slate-700">Jumlah & kemasan<input name="quantity" required maxlength="50" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="120 Unit"></label>
                <label class="text-[12px] font-medium text-slate-700">Lokasi tujuan<input name="location" required maxlength="40" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="WH01-ZA-RA01"></label>
                <label class="text-[12px] font-medium text-slate-700">Dock penerimaan<select name="dock" required class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500"><option value="">Pilih dock</option><option>DOCK 01</option><option>DOCK 02</option><option>DOCK 03</option><option>DOCK 04</option></select></label>
                <label class="text-[12px] font-medium text-slate-700">Metode QC<select name="method" required class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500"><option value="AQL">Sampling AQL</option><option value="Full">Full Inspection</option></select></label>
            </div>
            <div class="mt-5 flex justify-end gap-2"><button type="button" id="cancel-modal" class="h-10 rounded-md border border-slate-200 px-4 text-[12px] font-medium text-slate-600 hover:bg-slate-50">Batal</button><button type="submit" class="h-10 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white hover:bg-blue-700">Simpan & Mulai QC</button></div>
        </form>
    </div>
    <div id="toast" role="status" class="fixed bottom-4 right-4 z-[80] hidden rounded-lg bg-slate-900 px-4 py-3 text-[12px] text-white shadow-lg"></div>
</div>

<script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      if (sidebar) sidebar.classList.toggle('open');
    }

    const records = [
      { po: 'PO-2025-0891', delivery: 'SJ-01829-DC', time: '07:45 WIB', supplier: 'PT Surya Elektronik', pic: 'Hendra W. (PT. Citra Trans)', product: 'Canon 60D Body & Nikon Optical Kit', category: 'Kamera & Optik', sku: '2 SKU', quantity: '350 Unit', package: '25 Master Carton', location: 'WH01-ZA-RA31', destination: 'Rak Tier 2 - ZA', dock: 'DOCK 01', qc: 'Selesai Putaway', qcDetail: 'Lolos QC 100% (Sampel Baik)', status: 'Selesai Putaway', method: 'AQL' },
      { po: 'PO-2025-0892', delivery: 'SJ-01830-DC', time: '08:10 WIB', supplier: 'CV Digital Mandiri', pic: 'Bambang H. (CV Mandiri)', product: 'Macbook Pro M1 & Workstation', category: 'Komputer & Laptop', sku: '3 SKU', quantity: '120 Unit', package: '10 Box Anti-Static', location: 'WH01-ZA-RA32', destination: 'High-Security Cage B-01', dock: 'DOCK 02', qc: 'Selesai Putaway', qcDetail: 'Lolos QC 100% (High Value)', status: 'Selesai Putaway', method: 'Full' },
      { po: 'PO-2025-0893', delivery: 'SJ-01831-DC', time: '08:25 WIB', supplier: 'PT Bintang Audio Prima', pic: 'Hendra K. (PT. Sagara Cargo)', product: 'Sony WH-1000XM4 & Studio Mic', category: 'Audio & Sound', sku: '2 SKU', quantity: '280 Unit', package: '14 Koli Karton', location: 'WH01-ZB-RB02', destination: 'Rak Heavy-Duty ZB', dock: 'DOCK 03', qc: 'Sedang QC', qcDetail: 'Sampling QC 1.280 Unit AQL 1.5%', status: 'Sedang QC', method: 'AQL' },
      { po: 'PO-2025-0894', delivery: 'SJ-01832-DC', time: '08:55 WIB', supplier: 'PT Global Storage Solusindo', pic: 'Dedi S. (Global Express)', product: 'Sandisk SSD NVMe 1TB & HDD 4TB', category: 'Storage & Barcode', sku: '2 SKU', quantity: '500 Unit', package: '20 Master Carton', location: 'WH02-ZC-RC01', destination: 'Rak Data & Storage', dock: 'DOCK 01', qc: 'Proses Bongkar', qcDetail: 'Dock 01 (Unloading 75%)', status: 'Proses Bongkar', method: 'AQL' },
      { po: 'PO-2025-0895', delivery: 'SJ-01833-DC', time: '09:15 WIB', supplier: 'CV Jaya Optik Instruments', pic: 'Bambang S. (Jaya Optik)', product: 'Tripod Studio & Lighting Kit', category: 'Aksesoris & Studio', sku: '3 SKU', quantity: '95 Unit', package: '12 Dus Pallet', location: 'WH01-ZA-RA31', destination: 'Rak Tier 2 - ZA', dock: 'DOCK 04', qc: 'Menunggu Putaway', qcDetail: 'QC Lolos · Pindah Rak', status: 'Menunggu Putaway', method: 'Full' },
      { po: 'PO-2025-0896', delivery: 'SJ-01834-DC', time: '09:40 WIB', supplier: 'PT Mega Periferal Indonesia', pic: 'Kusnadi (Mega Periferal)', product: 'Mechanical Keyboard RGB Switch', category: 'Komputer & Aksesoris', sku: '4 SKU', quantity: '410 Unit', package: '22 Box Karton', location: 'WH01-ZB-RB01', destination: 'Rak Tier 1 - ZB', dock: 'DOCK 02', qc: 'Selesai Putaway', qcDetail: 'Lolos QC 100% (Batch Pass)', status: 'Selesai Putaway', method: 'AQL' },
      { po: 'PO-2025-0897', delivery: 'SJ-01835-DC', time: '10:00 WIB', supplier: 'CV Logistik Pack Sentosa', pic: 'Eko P. (Pack Sentosa)', product: 'Bubble Wrap Roll & Dus Karton A3', category: 'Packaging', sku: '2 SKU', quantity: '800 Roll', package: 'Bulk Packaging', location: 'WH02-ZD-STG01', destination: 'Staging Dock 03', dock: 'DOCK 03', qc: 'Selesai Putaway', qcDetail: 'Fisik Sesuai PO & Timbangan', status: 'Selesai Putaway', method: 'Full' },
      { po: 'PO-2025-0898', delivery: 'SJ-01836-DC', time: '10:15 WIB', supplier: 'PT Solusi Komputasi Terpadu', pic: 'Nadia P. (Solusi Komputasi)', product: 'RAM DDR5 & Mainboard ATX', category: 'Komputer & Laptop', sku: '4 SKU', quantity: '220 Unit', package: '18 Box Anti-Static', location: 'WH01-ZA-RA33', destination: 'Rak Tier 3 - ZA', dock: 'DOCK 01', qc: 'Proses Bongkar', qcDetail: 'Dock 01 (Menunggu QC)', status: 'Proses Bongkar', method: 'AQL' },
      { po: 'PO-2025-0899', delivery: 'SJ-01837-DC', time: '10:30 WIB', supplier: 'PT Lensa Citra Abadi', pic: 'Dimas S. (Lensa Citra)', product: 'Lensa Mirrorless & Filter Kit', category: 'Kamera & Optik', sku: '3 SKU', quantity: '75 Unit', package: '8 Hard Case', location: 'WH01-ZA-RA35', destination: 'Rak Lensa High-Value', dock: 'DOCK 04', qc: 'Sedang QC', qcDetail: '2 Unit Karantina (Scratch)', status: 'Sedang QC', method: 'Full' },
      { po: 'PO-2025-0900', delivery: 'SJ-01838-DC', time: '10:45 WIB', supplier: 'CV Karya Office Digital', pic: 'Sari W. (Karya Office)', product: 'Tinta Printer & Label Thermal', category: 'Packaging', sku: '3 SKU', quantity: '340 Unit', package: '16 Dus Karton', location: 'WH02-ZD-RD02', destination: 'Rak ATK & Supplies', dock: 'DOCK 02', qc: 'Selesai Putaway', qcDetail: 'Lolos QC 100% (Batch Pass)', status: 'Selesai Putaway', method: 'AQL' },
      { po: 'PO-2025-0901', delivery: 'SJ-01839-DC', time: '11:00 WIB', supplier: 'PT Prima Jaringan Digital', pic: 'Rizky A. (Prima Jaringan)', product: 'Router WiFi 6 & Switch 24-Port', category: 'Jaringan & Komunikasi', sku: '2 SKU', quantity: '160 Unit', package: '10 Box Anti-Static', location: 'WH01-ZC-RC04', destination: 'Rak Network & Server', dock: 'DOCK 03', qc: 'Selesai Putaway', qcDetail: 'Lolos QC 100% (Sampel Baik)', status: 'Selesai Putaway', method: 'AQL' },
      { po: 'PO-2025-0902', delivery: 'SJ-01840-DC', time: '11:20 WIB', supplier: 'PT Global Storage Solusindo', pic: 'Dian K. (Global Express)', product: 'SSD NVMe Enterprise 2TB', category: 'Storage & Barcode', sku: '1 SKU', quantity: '90 Unit', package: '5 Master Carton', location: 'WH02-ZC-RC03', destination: 'Rak Data & Storage', dock: 'DOCK 04', qc: 'Selesai Putaway', qcDetail: 'Lolos QC 100% (Batch Pass)', status: 'Selesai Putaway', method: 'Full' },
      { po: 'PO-2025-0903', delivery: 'SJ-01841-DC', time: '11:45 WIB', supplier: 'PT Bintang Audio Prima', pic: 'Ricky P. (Bintang Audio)', product: 'Microphone Wireless Set', category: 'Audio & Sound', sku: '2 SKU', quantity: '110 Unit', package: '8 Koli Karton', location: 'WH01-ZB-RB04', destination: 'Rak Audio & Studio', dock: 'DOCK 02', qc: 'Selesai Putaway', qcDetail: 'Lolos QC 100% (Sampel Baik)', status: 'Selesai Putaway', method: 'AQL' },
      { po: 'PO-2025-0904', delivery: 'SJ-01842-DC', time: '12:00 WIB', supplier: 'CV Jaya Optik Instruments', pic: 'Bambang S. (Jaya Optik)', product: 'Studio Light Stand Set', category: 'Aksesoris & Studio', sku: '1 SKU', quantity: '24 Unit', package: '4 Hard Case', location: 'WH01-ZA-RA38', destination: 'Rak Tier 3 - ZA', dock: 'DOCK 03', qc: 'Retur / Masalah', qcDetail: 'Kemasan rusak · 2 unit retur', status: 'Retur / Masalah', method: 'Full' }
    ];

    const docks = [
      { name: 'DOCK 01', supplier: 'PT Surya Elektronik', detail: 'PO-2025-0898 · Kamera & Lensa', volume: 'Volume: 450 Box (Palletized)', status: 'Proses Bongkar', progress: 75, tone: 'bg-blue-600 text-white', bar: 'bg-blue-600' },
      { name: 'DOCK 02', supplier: 'CV Digital Mandiri', detail: 'PO-2025-0892 · Laptop & PC S1', volume: 'Volume: 200 Unit High-Value', status: 'Jadwal 09.30', progress: 90, tone: 'bg-emerald-600 text-white', bar: 'bg-emerald-600' },
      { name: 'DOCK 03', supplier: 'PT Logistik Pack', detail: 'PO-2025-0825 · Dus & Bubble Wrap', volume: 'Volume: 1.200 Kg Material', status: 'Masuk Rak', progress: 40, tone: 'bg-slate-600 text-white', bar: 'bg-blue-600' },
      { name: 'DOCK 04', supplier: 'PT Bintang Audio', detail: 'PO-2025-0820 · Audio & Headset', volume: 'Volume: 180 Unit Master Pack', status: 'Menunggu Giliran', progress: 0, tone: 'bg-slate-200 text-slate-700', bar: 'bg-slate-300' }
    ];
    const dockCards = document.getElementById('dock-cards');
    if (dockCards) {
      dockCards.innerHTML = docks.map((dock) => `<article class="rounded-lg border border-slate-100 bg-[#f6f8fe] p-3">
        <div class="flex items-center justify-between gap-2"><b class="rounded bg-white px-2 py-1 text-[10.5px] text-slate-600">${dock.name}</b><span class="rounded-full ${dock.tone} px-2.5 py-1 text-[10.5px] font-semibold">${dock.status}</span></div>
        <h3 class="mt-2 truncate text-[12px] font-semibold text-slate-800">${dock.supplier}</h3><p class="truncate text-[10.5px] text-slate-500">${dock.detail}</p><p class="mt-1 text-[10.5px] text-slate-500">${dock.volume}</p>
        <div class="mt-2 flex items-center justify-between text-[10.5px]"><span class="text-slate-500">Bongkar Muat</span><b class="text-blue-700">${dock.progress ? `${dock.progress}%` : '10:15 WIB'}</b></div><div class="mt-1 h-1 rounded-full bg-blue-100"><div class="h-full rounded-full ${dock.bar}" style="width:${dock.progress}%"></div></div>
      </article>`).join('');
    }

    const rowsHost = document.getElementById('inbound-rows');
    const searchInput = document.getElementById('inbound-search');
    const globalSearch = document.getElementById('global-search');
    const supplierFilter = document.getElementById('supplier-filter');
    const statusFilter = document.getElementById('status-filter');
    const dockFilter = document.getElementById('dock-filter');
    const pageSizeInput = document.getElementById('page-size');
    const totalTransactions = 14;
    let activeQuickFilter = 'all';
    let filteredRecords = [...records];
    let currentPage = 1;
    let toastTimer;
    let compactRows = false;

    const escapeHtml = (value) => String(value).replace(/[&<>\"']/g, (char) => ({
      '&': '&amp;', '<': '&lt;', '>': '&gt;', '\"': '&quot;', "\'": '&#39;'
    })[char]);

    function renderPagination() {
      const host = document.getElementById('pagination');
      if (!host) return;
      const totalPages = Math.max(1, Math.ceil(filteredRecords.length / Number(pageSizeInput.value)));
      host.innerHTML = '';
      for (let page = 1; page <= totalPages; page++) {
        const button = document.createElement('button');
        button.type = 'button';
        button.textContent = String(page);
        button.setAttribute('aria-label', `Halaman ${page}`);
        button.className = `h-8 min-w-8 rounded px-2 text-[12px] ${page === currentPage ? 'bg-blue-600 font-semibold text-white' : 'text-slate-600 hover:bg-blue-50'}`;
        button.addEventListener('click', () => { currentPage = page; renderRows(); });
        host.append(button);
      }
      document.getElementById('previous-page').disabled = currentPage <= 1;
      document.getElementById('next-page').disabled = currentPage >= totalPages;
    }

    function renderRows() {
      if (!rowsHost) return;
      const size = Number(pageSizeInput.value);
      const start = (currentPage - 1) * size;
      const pageItems = filteredRecords.slice(start, start + size);
      rowsHost.innerHTML = pageItems.map((record, index) => {
        const safe = Object.fromEntries(Object.entries(record).map(([key, value]) => [key, typeof value === 'string' ? escapeHtml(value) : value]));
        const statusTone = safe.status === 'Selesai Putaway' ? 'bg-emerald-50 text-emerald-700'
          : safe.status === 'Retur / Masalah' ? 'bg-red-50 text-red-700'
          : safe.status === 'Proses Bongkar' ? 'bg-blue-600 text-white'
          : safe.status === 'Menunggu Putaway' ? 'bg-slate-100 text-slate-700'
          : 'bg-indigo-50 text-indigo-700';
        const rowHeight = compactRows ? 'h-[48px]' : 'h-[60px]';
        return `<tr class="inbound-row ${rowHeight} hover:bg-slate-50/70" style="animation-delay:${Math.min(index * 20, 140)}ms" data-po="${safe.po}">
          <td class="px-2"><input type="checkbox" class="inbound-checkbox h-4 w-4 accent-blue-600" aria-label="Pilih ${safe.po}"></td>
          <td class="px-2"><a href="#" class="font-semibold text-blue-700">${safe.po}</a><span class="mt-1 block truncate text-[10.5px] text-slate-500">${safe.delivery}</span><span class="block text-[10.5px] text-slate-500">Tiba: ${safe.time}</span></td>
          <td class="px-2"><div class="flex items-center gap-2"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-50 text-[9.5px] font-bold text-blue-700">${safe.supplier.split(' ').map((word) => word[0]).slice(0, 2).join('')}</span><span class="min-w-0"><b class="block truncate text-[12px] font-semibold text-slate-800">${safe.supplier}</b><span class="block truncate text-[10.5px] text-slate-500">${safe.pic}</span></span></div></td>
          <td class="px-2"><b class="block text-[12px] font-medium leading-tight text-slate-800">${safe.product}</b><span class="mt-1 inline-block rounded bg-slate-100 px-2 py-1 text-[10.5px] text-slate-600">${safe.category}</span><span class="ml-1 text-[10.5px] text-slate-500">· ${safe.sku}</span></td>
          <td class="px-2"><b class="block text-[12px] text-slate-700">${safe.quantity}</b><span class="mt-1 block text-[10.5px] text-slate-500">${safe.package}</span></td>
          <td class="px-2"><span class="inline-flex max-w-full items-center gap-1 rounded bg-blue-50 px-2 py-1 text-[10.5px] font-semibold text-blue-700"><i class="fas fa-map-pin h-3.5 w-3.5 shrink-0"></i><span class="truncate">${safe.location}</span></span><span class="mt-1 block truncate text-[10.5px] text-slate-500">${safe.destination}</span></td>
          <td class="px-2"><span class="inline-flex items-center gap-1 rounded-full ${statusTone} px-2.5 py-1 text-[10.5px] font-semibold"><i class="fas ${safe.status === 'Selesai Putaway' ? 'fa-circle-check' : safe.status === 'Retur / Masalah' ? 'fa-triangle-exclamation' : safe.status === 'Sedang QC' ? 'fa-barcode' : 'fa-clock'}" class="h-3.5 w-3.5"></i>${safe.qc}</span><span class="mt-1 block text-[10.5px] ${safe.status === 'Retur / Masalah' ? 'text-red-600' : 'text-slate-500'}">${safe.qcDetail}</span></td>
          <td class="px-2"><div class="flex items-center justify-center gap-1 text-slate-500"><button data-row-action="view" aria-label="Lihat ${safe.po}" class="rounded p-1.5 hover:bg-slate-100 hover:text-blue-600"><i class="fas fa-eye h-4 w-4"></i></button><button data-row-action="print" aria-label="Cetak ${safe.po}" class="rounded p-1.5 hover:bg-slate-100 hover:text-blue-600"><i class="fas fa-print h-4 w-4"></i></button><button data-row-action="qc" aria-label="Proses QC ${safe.po}" class="rounded p-1.5 hover:bg-slate-100 hover:text-blue-600"><i class="fas fa-clipboard-check h-4 w-4"></i></button></div></td>
        </tr>`;
      }).join('');
      const end = Math.min(start + size, filteredRecords.length);
      const rowCountEl = document.getElementById('row-count');
      if (rowCountEl) {
        rowCountEl.textContent = filteredRecords.length
          ? `Menampilkan ${start + 1} - ${end} dari ${filteredRecords.length} transaksi${filteredRecords.length === records.length ? ` · ${totalTransactions} inbound hari ini` : ' sesuai filter'}`
          : 'Tidak ada transaksi yang sesuai dengan filter';
      }
      renderPagination();
    }

    function applyFilters() {
      const qVal = searchInput ? searchInput.value : '';
      const gVal = globalSearch ? globalSearch.value : '';
      const query = `${qVal} ${gVal}`.trim().toLowerCase();
      filteredRecords = records.filter((record) => {
        const matchesSearch = !query || Object.values(record).join(' ').toLowerCase().includes(query);
        const matchesSupplier = !supplierFilter || !supplierFilter.value || record.supplier === supplierFilter.value;
        const matchesStatus = !statusFilter || !statusFilter.value || record.status === statusFilter.value;
        const matchesMethod = !dockFilter || !dockFilter.value || record.method === dockFilter.value;
        const matchesQuick = activeQuickFilter === 'all' || record.status === activeQuickFilter;
        return matchesSearch && matchesSupplier && matchesStatus && matchesMethod && matchesQuick;
      });
      currentPage = 1;
      renderRows();
    }

    if (supplierFilter) {
      [...new Set(records.map((record) => record.supplier))].sort().forEach((supplier) => {
        const option = document.createElement('option');
        option.value = supplier;
        option.textContent = supplier;
        supplierFilter.append(option);
      });
    }
    document.querySelectorAll('#supplier-options').forEach((list) => {
      [...new Set(records.map((record) => record.supplier))].sort().forEach((supplier) => {
        const option = document.createElement('option');
        option.value = supplier;
        list.append(option);
      });
    });

    [searchInput, globalSearch].forEach((input) => { if (input) input.addEventListener('input', applyFilters); });
    [supplierFilter, statusFilter, dockFilter].forEach((select) => { if (select) select.addEventListener('change', applyFilters); });
    if (pageSizeInput) pageSizeInput.addEventListener('change', () => { currentPage = 1; renderRows(); });
    
    const prevPageBtn = document.getElementById('previous-page');
    if (prevPageBtn) prevPageBtn.addEventListener('click', () => { if (currentPage > 1) { currentPage--; renderRows(); } });
    
    const nextPageBtn = document.getElementById('next-page');
    if (nextPageBtn) nextPageBtn.addEventListener('click', () => {
      if (currentPage < Math.ceil(filteredRecords.length / Number(pageSizeInput.value))) { currentPage++; renderRows(); }
    });

    document.querySelectorAll('[data-quick-filter]').forEach((button) => button.addEventListener('click', () => {
      activeQuickFilter = button.dataset.quickFilter;
      if (searchInput) searchInput.value = '';
      if (globalSearch) globalSearch.value = '';
      if (supplierFilter) supplierFilter.value = '';
      if (statusFilter) statusFilter.value = '';
      if (dockFilter) dockFilter.value = '';
      document.querySelectorAll('[data-quick-filter]').forEach((item) => item.className = item === button
        ? 'rounded-full bg-blue-600 px-3 py-1 text-[10.5px] font-semibold text-white'
        : 'rounded-full bg-slate-100 px-3 py-1 text-[10.5px] font-semibold text-slate-600');
      applyFilters();
    }));

    const resetFiltersBtn = document.getElementById('reset-filters');
    if (resetFiltersBtn) resetFiltersBtn.addEventListener('click', () => {
      if (searchInput) searchInput.value = '';
      if (globalSearch) globalSearch.value = '';
      if (supplierFilter) supplierFilter.value = '';
      if (statusFilter) statusFilter.value = '';
      if (dockFilter) dockFilter.value = '';
      activeQuickFilter = 'all';
      document.querySelectorAll('[data-quick-filter]').forEach((item, index) => item.className = index === 0
        ? 'rounded-full bg-blue-600 px-3 py-1 text-[10.5px] font-semibold text-white'
        : 'rounded-full bg-slate-100 px-3 py-1 text-[10.5px] font-semibold text-slate-600');
      applyFilters();
    });

    const selectAllCb = document.getElementById('select-all');
    if (selectAllCb) selectAllCb.addEventListener('change', (event) => {
      document.querySelectorAll('.inbound-checkbox').forEach((checkbox) => { checkbox.checked = event.target.checked; });
    });

    if (rowsHost) rowsHost.addEventListener('change', (event) => {
      if (event.target.matches('.inbound-checkbox') && !event.target.checked) {
        const sa = document.getElementById('select-all');
        if (sa) sa.checked = false;
      }
    });

    function showToast(message) {
      const toast = document.getElementById('toast');
      if (!toast) return;
      toast.textContent = message;
      toast.classList.remove('hidden');
      clearTimeout(toastTimer);
      toastTimer = setTimeout(() => toast.classList.add('hidden'), 2800);
    }

    const modal = document.getElementById('inbound-modal');
    const form = document.getElementById('inbound-form');
    function closeModal() {
      if (!modal) return;
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      document.body.classList.remove('overflow-hidden');
    }
    
    const addInboundBtn = document.getElementById('add-inbound');
    if (addInboundBtn) addInboundBtn.addEventListener('click', () => {
      if (!modal) return;
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      document.body.classList.add('overflow-hidden');
      if (form && form.elements.po) form.elements.po.focus();
    });

    ['close-modal', 'cancel-modal'].forEach((id) => {
      const el = document.getElementById(id);
      if (el) el.addEventListener('click', closeModal);
    });

    if (modal) modal.addEventListener('click', (event) => { if (event.target === modal) closeModal(); });
    document.addEventListener('keydown', (event) => { if (event.key === 'Escape' && modal && !modal.classList.contains('hidden')) closeModal(); });
    
    if (form) form.addEventListener('submit', (event) => {
      event.preventDefault();
      if (!form.reportValidity()) return;
      const values = new FormData(form);
      const supplier = String(values.get('supplier')).trim();
      const record = {
        po: String(values.get('po')).trim().toUpperCase(),
        delivery: String(values.get('delivery')).trim(),
        time: new Intl.DateTimeFormat('id-ID', { hour: '2-digit', minute: '2-digit', timeZone: 'Asia/Jakarta' }).format(new Date()) + ' WIB',
        supplier,
        pic: 'PIC ekspedisi belum dicatat',
        product: String(values.get('product')).trim(),
        category: 'Penerimaan Baru',
        sku: '1 SKU',
        quantity: String(values.get('quantity')).trim(),
        package: 'Kemasan belum diverifikasi',
        location: String(values.get('location')).trim().toUpperCase(),
        destination: `${String(values.get('dock'))} · Area staging`,
        dock: String(values.get('dock')),
        qc: 'Menunggu QC',
        qcDetail: `${String(values.get('method'))} · Inspeksi belum dimulai`,
        status: 'Sedang QC',
        method: String(values.get('method'))
      };
      records.unshift(record);
      if (supplierFilter && ![...supplierFilter.options].some((option) => option.value === supplier)) {
        const option = document.createElement('option');
        option.value = supplier;
        option.textContent = supplier;
        supplierFilter.append(option);
        const datalistOption = document.createElement('option');
        datalistOption.value = supplier;
        const supOpt = document.getElementById('supplier-options');
        if (supOpt) supOpt.append(datalistOption);
      }
      form.reset();
      closeModal();
      activeQuickFilter = 'all';
      document.querySelectorAll('[data-quick-filter]').forEach((item, index) => item.className = index === 0
        ? 'rounded-full bg-blue-600 px-3 py-1 text-[10.5px] font-semibold text-white'
        : 'rounded-full bg-slate-100 px-3 py-1 text-[10.5px] font-semibold text-slate-600');
      if (statusFilter) statusFilter.value = '';
      if (supplierFilter) supplierFilter.value = '';
      if (dockFilter) dockFilter.value = '';
      if (searchInput) searchInput.value = '';
      if (globalSearch) globalSearch.value = '';
      const txTotal = document.getElementById('transaction-total');
      if (txTotal) txTotal.textContent = `${totalTransactions + 1} TRANSAKSI`;
      applyFilters();
      showToast('Penerimaan dicatat dan masuk antrean inspeksi QC.');
    });

    const exportInbBtn = document.getElementById('export-inbound');
    if (exportInbBtn) exportInbBtn.addEventListener('click', () => {
      const headers = ['Nomor PO', 'Surat Jalan', 'Waktu Tiba', 'Supplier', 'PIC Ekspedisi', 'Barang', 'Kategori', 'SKU', 'Jumlah', 'Kemasan', 'Lokasi Tujuan', 'Dock', 'Hasil QC', 'Status', 'Metode QC'];
      const csvCell = (value) => `"${String(value).replace(/\"/g, '\"\"')}"`;
      const csv = [headers, ...filteredRecords.map((record) => [
        record.po, record.delivery, record.time, record.supplier, record.pic, record.product,
        record.category, record.sku, record.quantity, record.package, record.location, record.dock,
        record.qc, record.status, record.method
      ])].map((row) => row.map(csvCell).join(',')).join('\r\n');
      const blob = new Blob(['\uFEFF', csv], { type: 'text/csv;charset=utf-8' });
      const url = URL.createObjectURL(blob);
      const link = document.createElement('a');
      link.href = url;
      link.download = 'transaksi-barang-masuk.csv';
      link.click();
      URL.revokeObjectURL(url);
    });

    const schedDock = document.getElementById('schedule-dock');
    if (schedDock) schedDock.addEventListener('click', () => showToast('Jadwal kedatangan dock: 4 antrean aktif hari ini.'));
    
    const dockCctv = document.getElementById('dock-cctv');
    if (dockCctv) dockCctv.addEventListener('click', () => showToast('Ringkasan CCTV dan jadwal loading dock Hub DC-01.'));
    
    const advFilter = document.getElementById('advanced-filter');
    if (advFilter) advFilter.addEventListener('click', () => {
      if (dockFilter) dockFilter.focus();
      showToast('Pilih metode inspeksi QC untuk menyaring transaksi.');
    });

    const refreshList = document.getElementById('refresh-list');
    if (refreshList) refreshList.addEventListener('click', () => { applyFilters(); showToast('Daftar transaksi inbound diperbarui.'); });

    const compactToggle = document.getElementById('compact-toggle');
    if (compactToggle) compactToggle.addEventListener('click', () => {
      compactRows = !compactRows;
      renderRows();
      showToast(compactRows ? 'Tampilan tabel ringkas aktif.' : 'Tampilan tabel standar aktif.');
    });

    if (rowsHost) rowsHost.addEventListener('click', (event) => {
      const button = event.target.closest('[data-row-action]');
      if (!button) return;
      const row = button.closest('tr');
      const record = records.find((item) => item.po === row.dataset.po);
      if (!record) return;
      const action = button.dataset.rowAction;
      if (action === 'qc' && record.status === 'Sedang QC') {
        record.status = 'Selesai Putaway';
        record.qc = 'Selesai Putaway';
        record.qcDetail = 'QC lulus · Siap dialokasikan';
        renderRows();
        showToast(`QC ${record.po} ditandai selesai.`);
        return;
      }
      if (action === 'print') {
        showToast(`Dokumen penerimaan ${record.po} siap dicetak.`);
        return;
      }
      showToast(`Detail transaksi ${record.po} · ${record.supplier}`);
    });

    document.querySelectorAll('[data-action]').forEach((button) => button.addEventListener('click', () => {
      const messages = {
        scanner: 'Scanner nirkabel terhubung. Pemindaian ASN siap digunakan.',
        checklist: 'Checklist standar prosedur QC inbound.',
        edo: 'Log integrasi e-DO dan Berita Acara Penerimaan Barang.'
      };
      showToast(messages[button.dataset.action]);
    }));

    renderRows();
</script>
@endsection

@section('title', 'Transaksi Barang Masuk — Astro Inventory')

@section('content')
<div class="space-y-6 animate-fade-in">
    {{-- Header Section --}}
    @include('components.navbar')

    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Main Content Area --}}
    <div class="min-h-screen md:ml-[220px] px-4 lg:px-6 pt-6 pb-6 animate-fade-in">

        {{-- 1. ROLE AUDITOR: Tampilan Khusus Audit & Kepatuhan Inbound --}}
        @if(auth()->user()->isAuditor())
            {{-- ============ AUDITOR VIEW: Audit Barang Masuk ============ --}}
            <div class="w-full">
                <div class="mb-6">
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wide text-slate-500">
                            <span>Kepatuhan &amp; Audit</span>
                            <i class="fas fa-chevron-right text-[8px]"></i>
                            <span>Pemeriksaan &amp; Inventaris</span>
                            <i class="fas fa-chevron-right text-[8px]"></i>
                            <span class="text-blue-700">Audit Barang Masuk</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
                    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-5">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                <span class="text-[11px] font-bold uppercase tracking-[0.12em] text-blue-600">Warehouse Management System</span>
                            </div>
                            <h1 class="text-[25px] font-bold leading-tight tracking-tight text-slate-800 lg:text-[28px]">Pemeriksaan &amp; Audit Barang Masuk</h1>
                            <p class="mt-2 text-[13px] leading-[1.8] text-slate-500">
                                Audit kesesuaian penerimaan barang inbound terhadap delivery order (DO), verifikasi nomor segel, pemeriksaan keseluruhan bukti fisik, serta validasi kepatuhan pengadaan sesuai SOP.
                            </p>
                        </div>

                        <div class="flex flex-col gap-3">
                            <div class="flex flex-wrap items-center gap-2">
                                <div class="inline-flex h-9 items-center gap-2 rounded-lg border border-blue-100 bg-blue-50/70 px-3">
                                    <i class="fas fa-map-marker-alt text-blue-600"></i>
                                    <div>
                                        <span class="text-[10px] font-medium text-blue-500">Lokasi Pos</span>
                                        <p class="text-[11px] font-semibold text-blue-800">Dock Receiving 01 - Cakung DC</p>
                                    </div>
                                </div>
                                <div class="inline-flex h-9 items-center gap-2 rounded-lg border border-indigo-100 bg-indigo-50/70 px-3">
                                    <i class="fas fa-file-contract text-indigo-600"></i>
                                    <div>
                                        <span class="text-[10px] font-medium text-indigo-500">Standar Prosedur</span>
                                        <p class="text-[11px] font-semibold text-indigo-800">SOP-WMS-V4</p>
                                    </div>
                                </div>
                                <div class="inline-flex h-9 items-center gap-2 rounded-lg border border-slate-200 bg-white px-3">
                                    <i class="fas fa-sync-alt text-emerald-600"></i>
                                    <div>
                                        <span class="text-[10px] font-medium text-slate-400">Last Sync</span>
                                        <p class="text-[11px] font-semibold text-slate-700">14:02:44 WIB</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-start xl:justify-end">
                                <button onclick="toast('Menyiapkan ekspor Log Audit Inbound (PDF/CSV)...','success')" class="group inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 text-[12px] font-semibold text-white shadow-sm shadow-blue-600/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-blue-700 hover:shadow-md hover:shadow-blue-600/20 active:translate-y-0">
                                    <i class="fas fa-file-export text-[13px] transition-transform group-hover:scale-110"></i>
                                    Ekspor Log Audit Inbound
                                    <i class="fas fa-arrow-down-left text-[11px] opacity-70"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 h-px bg-gradient-to-r from-slate-200 via-slate-200/70 to-transparent"></div>
                </div>

                <!-- Stat cards -->
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4 mb-4">
                    <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm">
                        <p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Total Terima Hari Ini</p>
                        <div class="mt-2 flex flex-wrap items-baseline justify-between gap-2">
                            <h3 class="text-[24px] font-bold leading-tight tracking-tight text-slate-900">18 PO</h3>
                            <span class="inline-flex whitespace-nowrap rounded-full bg-emerald-50 px-2.5 py-1 text-[10.5px] font-semibold text-emerald-700">+12,4%</span>
                        </div>
                        <p class="mt-1 text-[10.5px] leading-relaxed text-slate-500">Volume terima vs hari lalu</p>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm">
                        <p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Tingkat Presisi Bukti Fisik Inbound</p>
                        <div class="mt-2 flex flex-wrap items-baseline justify-between gap-2">
                            <h3 class="text-[24px] font-bold leading-tight tracking-tight text-slate-900">98,6%</h3>
                            <span class="inline-flex whitespace-nowrap rounded-full bg-emerald-50 px-2.5 py-1 text-[10.5px] font-semibold text-emerald-700">Memenuhi SOP</span>
                        </div>
                        <p class="mt-1 text-[10.5px] leading-relaxed text-slate-500">Perbandingan jumlah terima vs jumlah tervalidasi</p>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm">
                        <p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Deviasi / Selisih Barang Masuk</p>
                        <div class="mt-2 flex flex-wrap items-baseline justify-between gap-2">
                            <h3 class="text-[24px] font-bold leading-tight tracking-tight text-slate-900">2</h3>
                            <span class="inline-flex whitespace-nowrap rounded-full bg-amber-50 px-2.5 py-1 text-[10.5px] font-semibold text-amber-700">Koreksi Aktif</span>
                        </div>
                        <p class="mt-1 text-[10.5px] leading-relaxed text-slate-500">1 Selisih vendor &middot; 1 Kekurangan segel</p>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm">
                        <p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">FTL SLA Waktu Dock ke Rak</p>
                        <div class="mt-2 flex flex-wrap items-baseline justify-between gap-2">
                            <h3 class="text-[24px] font-bold leading-tight tracking-tight text-slate-900">42</h3>
                            <span class="inline-flex whitespace-nowrap rounded-full bg-emerald-50 px-2.5 py-1 text-[10.5px] font-semibold text-emerald-700">-8 Menit</span>
                        </div>
                        <p class="mt-1 text-[10.5px] leading-relaxed text-slate-500">Rata-rata proses dock ke rak (Target 45 Menit)</p>
                    </div>
                </div>

                <!-- Filter bar -->
                <div class="bg-white p-3 sm:p-4 rounded-xl border border-slate-100 shadow-sm mb-4">
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 xl:grid-cols-4">
                        <div class="relative flex h-10 min-w-0 items-center gap-2 rounded-md bg-blue-50/80 px-3 text-slate-400 sm:col-span-2 xl:col-span-1">
                            <i class="fas fa-search h-4 w-4 shrink-0 text-slate-400"></i>
                            <input type="text" placeholder="Cari nomor PO, nomor DO, supplier, SKU..." class="w-full min-w-0 bg-transparent text-[12px] text-slate-700 outline-none placeholder:text-slate-400">
                        </div>
                        <select class="h-10 w-full min-w-0 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none">
                            <option value="">STATUS: Semua Status</option>
                            <option value="lolos">Lolos Audit &amp; Segel Terverifikasi</option>
                            <option value="tertahan">Tertahan / Deviasi</option>
                            <option value="selesai">Selesai Tervalidasi</option>
                        </select>
                        <select class="h-10 w-full min-w-0 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none">
                            <option value="">RISIKO: Semua Kategori</option>
                            <option value="tier1">Tier-1 High-Value (&gt; Rp 100 Jt)</option>
                            <option value="tier3">Tier-3 Reguler</option>
                        </select>
                        <select class="h-10 w-full min-w-0 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none">
                            <option value="">TIPE: Semua Pengadaan</option>
                            <option value="vendor">Pengadaan Vendor</option>
                            <option value="transfer">Transfer Antar-Gudang</option>
                        </select>
                    </div>
                </div>

                <!-- Table -->
                <div class="bg-white overflow-hidden rounded-xl border border-slate-100 shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[1280px] text-[12px]">
                            <thead>
                                <tr class="h-11 bg-[#f0f4fc]">
                                    <th class="whitespace-nowrap px-3 text-left text-[9.5px] font-semibold uppercase tracking-wide text-slate-600">No. PO / Surat Jalan</th>
                                    <th class="whitespace-nowrap px-3 text-left text-[9.5px] font-semibold uppercase tracking-wide text-slate-600">Supplier / Vendor</th>
                                    <th class="whitespace-nowrap px-3 text-left text-[9.5px] font-semibold uppercase tracking-wide text-slate-600">Tanggal Terima</th>
                                    <th class="whitespace-nowrap px-3 text-left text-[9.5px] font-semibold uppercase tracking-wide text-slate-600">Item &amp; Valuasi Muatan</th>
                                    <th class="whitespace-nowrap px-3 text-left text-[9.5px] font-semibold uppercase tracking-wide text-slate-600">Audit Segel Inbound</th>
                                    <th class="whitespace-nowrap px-3 text-left text-[9.5px] font-semibold uppercase tracking-wide text-slate-600">Status Audit</th>
                                    <th class="whitespace-nowrap px-3 text-left text-[9.5px] font-semibold uppercase tracking-wide text-slate-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-slate-100 hover:bg-slate-50/70" data-gate="lolos" data-risiko="tier1" data-tipe="vendor" data-po="po-2025-1042">
                                    <td class="px-3 py-3.5 align-top" data-label="No. PO / Surat Jalan">
                                        <a href="#" onclick="openDetail('PO-2025-1042');return false;" class="text-blue-600 font-bold hover:underline text-[12px]">#PO-2025-1042</a>
                                        <p class="text-[10.5px] text-slate-500 mt-1">SJ/SCH-88219 &middot; Terverifikasi</p>
                                        <p class="text-[10.5px] text-slate-500">Inbound: 08:30 WIB</p>
                                    </td>
                                    <td class="px-3 py-3.5 align-top" data-label="Supplier / Vendor">
                                        <p class="text-[12px] font-medium text-slate-900">PT Sinar Megah Abadi</p>
                                        <p class="text-[10.5px] text-slate-500 mt-1">PIC: Budi Santoso</p>
                                        <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full px-2.5 py-1 text-[10.5px] font-semibold bg-blue-50 text-blue-700 mt-1">Pengadaan Vendor</span>
                                    </td>
                                    <td class="px-3 py-3.5 align-top" data-label="Tanggal Terima">
                                        <p class="text-[12px] font-medium text-slate-900">Hari ini</p>
                                        <p class="text-[10.5px] text-slate-500 mt-1">08:30 WIB</p>
                                    </td>
                                    <td class="px-3 py-3.5 align-top" data-label="Item &amp; Valuasi Muatan">
                                        <p class="text-[12px] font-semibold text-slate-900">150 unit Kamera DSLR Canon EOS 600D</p>
                                        <p class="text-[10.5px] text-slate-500">SKU: CAM-600D (10 Master Ctn)</p>
                                        <p class="text-[12px] text-emerald-600 mt-1">Rp 1.875.000.000</p>
                                    </td>
                                    <td class="px-3 py-3.5 align-top" data-label="Audit Segel Inbound">
                                        <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full px-2.5 py-1 text-[10.5px] font-semibold bg-emerald-50 text-emerald-700"><i class="fas fa-circle-check"></i>Lolos Audit Segel</span>
                                        <p class="text-[10.5px] text-slate-500 mt-1">Segel kontainer terenkripsi terverifikasi</p>
                                    </td>
                                    <td class="px-3 py-3.5 align-top" data-label="Status Audit">
                                        <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full px-2.5 py-1 text-[10.5px] font-semibold bg-emerald-50 text-emerald-700"><i class="fas fa-circle-check"></i>Lolos Audit &amp; Segel Terverifikasi</span>
                                        <p class="text-[10.5px] text-slate-500 mt-1">Double-Check Valid</p>
                                    </td>
                                    <td class="px-3 py-3.5 align-top whitespace-nowrap" data-label="Aksi">
                                        <button onclick="openDetail('PO-2025-1042')" class="inline-flex h-8 items-center gap-1.5 whitespace-nowrap rounded-md px-2.5 text-[10.5px] font-semibold text-blue-600 hover:bg-blue-50"><i class="fas fa-eye"></i> Detail</button>
                                        <button onclick="toast('Ekspor baris PO-2025-1042 (PDF)...','success')" class="inline-flex h-8 w-8 items-center justify-center whitespace-nowrap rounded-md text-slate-600 hover:bg-slate-100"><i class="fas fa-file-export"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- High-value audit + sampling stats -->
                <div class="mt-4 grid grid-cols-1 gap-3 2xl:grid-cols-2">
                    <div class="rounded-lg border border-slate-100 bg-white p-4 shadow-sm">
                        <div class="mb-3 grid grid-cols-[16px_minmax(0,1fr)] items-start gap-x-2 gap-y-2 sm:flex sm:items-center">
                            <i class="mt-0.5 fas fa-gem text-blue-600"></i>
                            <h3 class="min-w-0 text-[12px] font-bold text-slate-900">Ketentuan Audit Barang Masuk Bernilai Tinggi</h3>
                            <span class="col-span-2 inline-flex w-fit items-center whitespace-nowrap rounded-full bg-red-50 px-2.5 py-1 text-[10.5px] font-semibold text-red-700 sm:ml-auto">TIER-1 &gt; Rp 100.000.000</span>
                        </div>
                        <p class="text-[10.5px] text-slate-600 mb-3">Berdasarkan SK Direksi Logistik No. 44/ASTRO-DIR/2024, setiap transaksi inbound muatan Tier-1 wajib mematuhi protokol kepatuhan berikut sebelum barang ditempatkan ke rak:</p>
                        <div class="space-y-3">
                            <div class="flex gap-3">
                                <i class="fas fa-pen-line text-blue-600 mt-0.5"></i>
                                <div>
                                    <p class="text-[12px] font-semibold text-slate-900">Penerimaan Ganda / Double-Check Wajib</p>
                                    <p class="text-[10.5px] text-slate-600">Wajib diverifikasi secara fisik oleh staf operasional serta auditor internal yang bertugas.</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <i class="fas fa-video text-blue-600 mt-0.5"></i>
                                <div>
                                    <p class="text-[12px] font-semibold text-slate-900">Perekaman CCTV Loading Bay (1080p 60fps)</p>
                                    <p class="text-[10.5px] text-slate-600">Proses pemuatan harus tercakup kamera CCTV arsip DVR-CKG-04 tanpa blind-spot.</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <i class="fas fa-fingerprint text-blue-600 mt-0.5"></i>
                                <div>
                                    <p class="text-[12px] font-semibold text-slate-900">Pemeriksaan Segel Keamanan Biometrik / RFID</p>
                                    <p class="text-[10.5px] text-slate-600">Nomor segel diverifikasi scanner barcode terenkripsi sebelum pallet dikirim ke rak.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 whitespace-nowrap rounded-full px-2.5 py-1 text-[10.5px] font-semibold bg-indigo-50 text-indigo-700"><i class="fas fa-shield-check"></i>Status SOP Berlaku AKU (ISO 27001)</span>
                            <button onclick="toast('Membuka dokumen prosedur SOP-WMS-V4 (read-only)...','success')" class="ml-auto text-[10.5px] text-blue-600 hover:underline"><i class="fas fa-book-open mr-1"></i>Baca Dokumen Prosedur</button>
                        </div>
                    </div>

                    <div class="rounded-lg border border-slate-100 bg-white p-4 shadow-sm">
                        <div class="mb-3 grid grid-cols-[16px_minmax(0,1fr)] items-start gap-x-2 gap-y-2 sm:flex sm:items-center">
                            <i class="mt-0.5 fas fa-clipboard-check text-blue-600"></i>
                            <h3 class="min-w-0 text-[12px] font-bold text-slate-900">Statistik Uji Petik Gate Inbound Hari Ini</h3>
                            <span class="col-span-2 inline-flex w-fit items-center whitespace-nowrap rounded-full bg-blue-50 px-2.5 py-1 text-[10.5px] font-semibold text-blue-700 sm:ml-auto">Audit Random Sampling Shift 12:40</span>
                        </div>
                        <div class="mb-4 grid grid-cols-1 gap-3 sm:grid-cols-3">
                            <div class="text-center border border-blue-100 rounded-lg p-3 bg-blue-50">
                                <p class="text-[24px] font-bold text-slate-900">28</p>
                                <p class="text-[10px] text-slate-500">Total Truk Diperiksa</p>
                            </div>
                            <div class="text-center border border-blue-100 rounded-lg p-3 bg-blue-50">
                                <p class="text-[24px] font-bold text-emerald-600">27</p>
                                <p class="text-[10px] text-slate-500">Lolos Tanpa Catatan</p>
                            </div>
                            <div class="text-center border border-blue-100 rounded-lg p-3 bg-blue-50">
                                <p class="text-[24px] font-bold text-amber-600">1</p>
                                <p class="text-[10px] text-slate-500">Penahanan Sementara</p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="flex justify-between text-[10.5px] text-slate-500 mb-1">
                                <span>Rasio Verifikasi Bukti Fisik</span>
                                <span class="font-semibold text-slate-900">96,4% (27/28)</span>
                            </div>
                            <div class="h-1 w-full rounded-full bg-slate-200">
                                <div class="h-1 rounded-full bg-blue-600" style="width: 96.4%"></div>
                            </div>
                        </div>
                        <div class="border-l-2 border-amber-500 pl-3 mb-3">
                            <p class="text-[10px] text-slate-400">Catatan Insiden Uji Petik #AUD-RND-091 &middot; 12:40 WIB</p>
                            <p class="text-[12px] text-slate-700">Ditemukan ketidakcocokan jumlah box dalam shipment pada 1 unit shipment. Muatan ditahan sementara untuk verifikasi ulang.</p>
                        </div>
                        <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                            <p class="text-[10px] text-slate-500">Auditor Pemeriksa: <strong class="text-slate-900">Dewi Anggraini, S.Ak</strong></p>
                            <button onclick="toast('Membuka log lengkap uji petik inbound...','success')" class="inline-flex min-h-8 items-center whitespace-nowrap text-[10.5px] text-blue-600 hover:underline">Lihat Log Lengkap Uji Petik &gt;</button>
                        </div>
                    </div>
                </div>
            </div>
        {{-- 2. ROLE OPERASIONAL (SuperAdmin, KepalaGudang, Pegawai): Manajemen Inbound --}}
        @elseif(auth()->user()->isSuperAdmin() || auth()->user()->isKepalaGudang() || auth()->user()->isPegawai())
            {{-- ============ OPERASIONAL VIEW: Manajemen Barang Masuk ============ --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Manajemen Barang Masuk</h1>
                    <p class="text-sm text-slate-500 mt-1">Kelola dan pantau penerimaan barang masuk (inbound) dari supplier atau transfer gudang.</p>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="openModal('addInboundModal')" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
                        <i class="fas fa-plus text-xs"></i>
                        <span>Catat Barang Masuk</span>
                    </button>
                    <button onclick="window.print()" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-xl border border-slate-200 shadow-sm transition-colors">
                        <i class="fas fa-print text-xs"></i>
                        <span>Cetak Laporan</span>
                    </button>
                </div>
            </div>

            <!-- Stats Overview Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Masuk Hari Ini</p>
                            <h3 class="text-2xl font-extrabold text-slate-900 mt-1">24 Transaksi</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                            <i class="fas fa-arrow-down-left"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 text-xs text-emerald-600 font-semibold mt-3">
                        <i class="fas fa-arrow-up"></i>
                        <span>+12% dari kemarin</span>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Menunggu QC / Inspeksi</p>
                            <h3 class="text-2xl font-extrabold text-slate-900 mt-1">5 Transaksi</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 text-xs text-amber-600 font-semibold mt-3">
                        <i class="fas fa-clock"></i>
                        <span>Perlu tindakan QC</span>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Selesai Putaway</p>
                            <h3 class="text-2xl font-extrabold text-slate-900 mt-1">18 Transaksi</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 text-xs text-emerald-600 font-semibold mt-3">
                        <i class="fas fa-shield-alt"></i>
                        <span>Tersimpan di rak</span>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kendala / Retur</p>
                            <h3 class="text-2xl font-extrabold text-slate-900 mt-1">1 Transaksi</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-lg">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 text-xs text-red-600 font-semibold mt-3">
                        <i class="fas fa-redo"></i>
                        <span>Menunggu investigasi</span>
                    </div>
                </div>
            </div>

            <!-- Main Table Section -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center gap-2 overflow-x-auto pb-2 sm:pb-0">
                        <button class="px-3.5 py-1.5 rounded-lg bg-blue-600 text-white text-xs font-semibold shadow-sm">Semua (24)</button>
                        <button class="px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-colors">Sedang QC (5)</button>
                        <button class="px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-colors">Putaway (18)</button>
                        <button class="px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-colors">Retur (1)</button>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="relative flex-1 sm:w-64">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-search text-xs"></i>
                            </span>
                            <input type="text" placeholder="Cari No PO / Supplier / SKU..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                        </div>
                        <div class="relative">
                            <select class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all">
                                <option value="">Semua Gudang / Dock</option>
                                <option value="dock-1">Dock Utama - DC 01</option>
                                <option value="dock-2">Dock B - Gudang Elektronik</option>
                                <option value="dock-3">Dock C - Gudang Umum</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/70 border-b border-slate-100 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                <th class="py-3.5 px-4">No PO / Ref</th>
                                <th class="py-3.5 px-4">Waktu Tiba</th>
                                <th class="py-3.5 px-4">Supplier</th>
                                <th class="py-3.5 px-4">Barang &amp; SKU</th>
                                <th class="py-3.5 px-4 text-center">Jumlah</th>
                                <th class="py-3.5 px-4">Lokasi / Dock</th>
                                <th class="py-3.5 px-4">Status QC</th>
                                <th class="py-3.5 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                    PO-2025-1042
                                    <div class="text-[10px] text-slate-400 font-normal">SJ/2025/VIII/901</div>
                                </td>
                                <td class="py-3.5 px-4 text-slate-600">08:30 WIB <span class="block text-[10px] text-slate-400">Hari ini</span></td>
                                <td class="py-3.5 px-4 font-semibold text-slate-800">
                                    PT Sinar Megah Abadi
                                    <div class="text-[10px] text-slate-400 font-normal">PIC: Budi Santoso</div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-medium text-slate-900">Kamera DSLR Canon EOS 600D</span>
                                    <div class="text-[10px] text-slate-500 font-mono">SKU-CAM-600D</div>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="font-bold text-slate-900">150 Unit</span>
                                    <div class="text-[10px] text-slate-400">Karton Box</div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 font-semibold rounded-md text-[11px]">Rak A-01-04</span>
                                    <div class="text-[10px] text-slate-400 mt-0.5">Dock 1 Utama</div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-200/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Sedang QC
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="openModal('detailInboundModal')" class="p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 rounded-lg transition-colors" title="Detail Transaksi">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                        @if(auth()->user()->isSuperAdmin() || auth()->user()->isKepalaGudang())
                                        <button class="p-1.5 bg-slate-100 hover:bg-emerald-50 hover:text-emerald-600 text-slate-600 rounded-lg transition-colors" title="Selesaikan QC / Putaway">
                                            <i class="fas fa-check text-xs"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                    PO-2025-1041
                                    <div class="text-[10px] text-slate-400 font-normal">SJ/2025/VIII/889</div>
                                </td>
                                <td class="py-3.5 px-4 text-slate-600">09:15 WIB <span class="block text-[10px] text-slate-400">Kemarin</span></td>
                                <td class="py-3.5 px-4 font-semibold text-slate-800">
                                    CV Mitra Perkasa
                                    <div class="text-[10px] text-slate-400 font-normal">PIC: Rahmat Hidayat</div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-medium text-slate-900">Laptop Dell Latitude 3420</span>
                                    <div class="text-[10px] text-slate-500 font-mono">SKU-LAP-3420</div>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="font-bold text-slate-900">75 Unit</span>
                                    <div class="text-[10px] text-slate-400">Pallet Kayu</div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 font-semibold rounded-md text-[11px]">Rak B-02-11</span>
                                    <div class="text-[10px] text-slate-400 mt-0.5">Dock B Elektronik</div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai Putaway
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="openModal('detailInboundModal')" class="p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 rounded-lg transition-colors" title="Detail Transaksi">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="p-4 sm:p-5 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-xs text-slate-500">Menampilkan <span class="font-bold text-slate-700">1-2</span> dari <span class="font-bold text-slate-700">24</span> transaksi</p>
                    <div class="flex items-center gap-1.5">
                        <button class="px-3 py-1.5 border border-slate-200 rounded-lg text-xs font-semibold text-slate-400 bg-slate-50 cursor-not-allowed" disabled>Sebelumnya</button>
                        <button class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-semibold">1</button>
                        <button class="px-3 py-1.5 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-lg text-xs font-semibold transition-colors">2</button>
                        <button class="px-3 py-1.5 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-lg text-xs font-semibold transition-colors">Berikutnya</button>
                    </div>
                </div>
            </div>
        @else
            {{-- ============ HR & OTHER: Access Denied ============ --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                <i class="fas fa-shield-alt text-5xl text-slate-300 mb-4"></i>
                <h2 class="text-xl font-bold text-slate-900 mb-2">Akses Tidak Tersedia</h2>
                <p class="text-slate-500">Role Anda tidak memiliki akses ke modul Barang Masuk.</p>
            </div>
        @endif
    </div>
</div>

{{-- Add Inbound Modal --}}
@if(auth()->user()->isSuperAdmin() || auth()->user()->isKepalaGudang() || auth()->user()->isPegawai() || auth()->user()->isAuditor())
<div id="addInboundModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-sm hidden">
    <div class="bg-white rounded-2xl w-full max-w-lg mx-4 overflow-hidden shadow-2xl border border-slate-200 animate-fade-up">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-sm font-bold text-slate-900">Catat Barang Masuk (Inbound)</h3>
            <button onclick="closeModal('addInboundModal')" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        <form id="addInboundForm" onsubmit="handleInboundSubmit(event)" class="p-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor PO / Referensi</label>
                    <input type="text" placeholder="Contoh: PO-2025-1043" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Surat Jalan</label>
                    <input type="text" placeholder="Contoh: SJ/2025/VIII/902" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Supplier</label>
                <select class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                    <option value="">Pilih Supplier</option>
                    <option value="pt-sinar">PT Sinar Megah Abadi</option>
                    <option value="cv-mitra">CV Mitra Perkasa</option>
                    <option value="pt-global">PT Global Elektronik Nusantara</option>
                </select>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Barang (SKU)</label>
                    <select class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                        <option value="">Pilih SKU Barang</option>
                        <option value="sku-cam">SKU-CAM-600D - Canon EOS 600D</option>
                        <option value="sku-lap">SKU-LAP-3420 - Dell Latitude 3420</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah Masuk</label>
                    <input type="number" placeholder="0" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Lokasi Rak Tujuan</label>
                    <select class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                        <option value="">Pilih Rak</option>
                        <option value="a-01">Rak A-01-04 (Utama)</option>
                        <option value="b-02">Rak B-02-11 (Elektronik)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Dock / Pintu Bongkar</label>
                    <select class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                        <option value="">Dock / Pintu Bongkar</option>
                        <option value="dock-1">Dock 1 Utama</option>
                        <option value="dock-2">Dock B Elektronik</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan / Catatan QC</label>
                <textarea rows="2" placeholder="Catatan kondisi fisik kemasan atau hasil pemeriksaan awal..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600"></textarea>
            </div>
            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModal('addInboundModal')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm">Simpan &amp; Masuk QC</button>
            </div>
        </form>
    </div>
</div>
<div id="detailInboundModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-sm hidden">
    <div class="bg-white rounded-2xl w-full max-w-lg mx-4 overflow-hidden shadow-2xl border border-slate-200 animate-fade-up">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-sm font-bold text-slate-900">Detail Transaksi Barang Masuk</h3>
            <button onclick="closeModal('detailInboundModal')" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Nomor PO</span>
                    <h4 class="text-sm font-extrabold text-slate-900">PO-2025-1042</h4>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">Sedang QC</span>
            </div>
            <div class="grid grid-cols-2 gap-4 text-xs">
                <div>
                    <span class="text-slate-400">Surat Jalan:</span>
                    <p class="font-semibold text-slate-800 mt-0.5">SJ/2025/VIII/901</p>
                </div>
                <div>
                    <span class="text-slate-400">Waktu Tiba:</span>
                    <p class="font-semibold text-slate-800 mt-0.5">Hari ini, 08:30 WIB</p>
                </div>
                <div>
                    <span class="text-slate-400">Supplier:</span>
                    <p class="font-semibold text-slate-800 mt-0.5">PT Sinar Megah Abadi</p>
                </div>
                <div>
                    <span class="text-slate-400">PIC Ekspedisi:</span>
                    <p class="font-semibold text-slate-800 mt-0.5">Budi Santoso</p>
                </div>
                <div>
                    <span class="text-slate-400">Barang &amp; SKU:</span>
                    <p class="font-semibold text-slate-800 mt-0.5">Kamera DSLR Canon EOS 600D (SKU-CAM-600D)</p>
                </div>
                <div>
                    <span class="text-slate-400">Jumlah Diterima:</span>
                    <p class="font-semibold text-slate-800 mt-0.5">150 Unit (Karton Box)</p>
                </div>
                <div>
                    <span class="text-slate-400">Lokasi Putaway:</span>
                    <p class="font-semibold text-blue-600 mt-0.5">Rak A-01-04 (Dock 1 Utama)</p>
                </div>
                <div>
                    <span class="text-slate-400">Metode QC:</span>
                    <p class="font-semibold text-slate-800 mt-0.5">Inspeksi Fisik &amp; Barcode Scan</p>
                </div>
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                <button onclick="closeModal('detailInboundModal')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors">Tutup</button>
                <button onclick="window.print()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm">Cetak Dokumen</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    function openDetail(id) {
        openModal('detailInboundModal');
    }
    function toast(msg, type = 'success') {
        let t = document.getElementById('toast');
        if (!t) {
            t = document.createElement('div');
            t.id = 'toast';
            t.className = 'fixed bottom-4 right-4 z-[80] rounded-lg bg-slate-900 px-4 py-3 text-[12px] text-white shadow-lg transition-all duration-300';
            document.body.appendChild(t);
        }
        t.textContent = msg;
        t.classList.remove('hidden');
        setTimeout(() => t.classList.add('hidden'), 2500);
    }
    function handleInboundSubmit(e) {
        e.preventDefault();
        const form = document.getElementById('addInboundForm');
        const poVal = form.querySelector('input').value || 'PO-2025-' + Math.floor(1000 + Math.random() * 9000);
        const sjVal = form.querySelectorAll('input')[1].value || 'SJ/2025/' + Math.floor(100 + Math.random() * 900);
        const supVal = form.querySelector('select').selectedOptions[0]?.text || 'PT Sinar Megah Abadi';
        const qtyVal = form.querySelector('input[type="number"]').value || '10';

        const tbody = document.querySelector('.overflow-x-auto table tbody');
        if (tbody) {
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-slate-50/60 transition-colors';
            tr.innerHTML = `
                <td class="py-3.5 px-4 font-bold text-slate-900">
                    ${poVal}
                    <div class="text-[10px] text-slate-400 font-normal">${sjVal}</div>
                </td>
                <td class="py-3.5 px-4 text-slate-600">Baru saja <span class="block text-[10px] text-slate-400">Hari ini</span></td>
                <td class="py-3.5 px-4 font-semibold text-slate-800">${supVal}<br>PIC Inbound: Kepala Gudang</td>
                <td class="py-3.5 px-4">Barang Masuk Inbound<br>SKU-IN-NEW</td>
                <td class="py-3.5 px-4 text-center">${qtyVal} Unit</td>
                <td class="py-3.5 px-4">Dock 1 Utama<br>Rak A-01-04</td>
                <td class="py-3.5 px-4"><span class="px-2 py-1 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-700">Menunggu QC</span></td>
                <td class="py-3.5 px-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <button onclick="openDetail('${poVal}')" class="p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 rounded-lg transition-colors" title="Detail Transaksi">
                            <i class="fas fa-eye text-xs"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.prepend(tr);
        }
        closeModal('addInboundModal');
        form.reset();
        toast('Penerimaan barang masuk berhasil dicatat dan masuk antrean QC!', 'success');
    }
</script>
@endif
@endsection