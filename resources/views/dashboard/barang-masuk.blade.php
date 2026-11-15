@extends('layouts.app')

@section('title', 'Barang Masuk - Astro Inventory')

@section('content')
<div class=\"space-y-6 animate-fade-in\">
    <!-- Header Section -->
    <div class=\"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4\">
        <div>
            <h1 class=\"text-2xl font-bold text-slate-900\">Manajemen Barang Masuk</h1>
            <p class=\"text-sm text-slate-500 mt-1\">Kelola dan pantau penerimaan barang masuk (inbound) dari supplier atau transfer gudang.</p>
        </div>
        <div class=\"flex items-center gap-3\">
            @if(auth()->user()->isSuperAdmin() || auth()->user()->isKepalaGudang() || auth()->user()->isPegawai())
            <button onclick=\"openModal('addInboundModal')\" class=\"inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors\">
                <i class=\"fas fa-plus text-xs\"></i>
                <span>Catat Barang Masuk</span>
            </button>
            @endif
            <button onclick=\"window.print()\" class=\"inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-xl border border-slate-200 shadow-sm transition-colors\">
                <i class=\"fas fa-print text-xs\"></i>
                <span>Cetak Laporan</span>
            </button>
        </div>
    </div>

    <!-- Stats Overview Cards -->
    <div class=\"grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4\">
        <div class=\"bg-white p-5 rounded-2xl border border-slate-200 shadow-sm\">
            <div class=\"flex items-center justify-between\">
                <div>
                    <p class=\"text-xs font-semibold text-slate-500 uppercase tracking-wider\">Total Masuk Hari Ini</p>
                    <h3 class=\"text-2xl font-extrabold text-slate-900 mt-1\">24 Transaksi</h3>
                </div>
                <div class=\"w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg\">
                    <i class=\"fas fa-arrow-down-left\"></i>
                </div>
            </div>
            <div class=\"flex items-center gap-1.5 text-xs text-emerald-600 font-semibold mt-3\">
                <i class=\"fas fa-arrow-up\"></i>
                <span>+12% dari kemarin</span>
            </div>
        </div>

        <div class=\"bg-white p-5 rounded-2xl border border-slate-200 shadow-sm\">
            <div class=\"flex items-center justify-between\">
                <div>
                    <p class=\"text-xs font-semibold text-slate-500 uppercase tracking-wider\">Menunggu QC / Inspeksi</p>
                    <h3 class=\"text-2xl font-extrabold text-slate-900 mt-1\">5 Transaksi</h3>
                </div>
                <div class=\"w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg\">
                    <i class=\"fas fa-clipboard-check\"></i>
                </div>
            </div>
            <div class=\"flex items-center gap-1.5 text-xs text-amber-600 font-semibold mt-3\">
                <i class=\"fas fa-clock\"></i>
                <span>Perlu tindakan QC</span>
            </div>
        </div>

        <div class=\"bg-white p-5 rounded-2xl border border-slate-200 shadow-sm\">
            <div class=\"flex items-center justify-between\">
                <div>
                    <p class=\"text-xs font-semibold text-slate-500 uppercase tracking-wider\">Selesai Putaway</p>
                    <h3 class=\"text-2xl font-extrabold text-slate-900 mt-1\">18 Transaksi</h3>
                </div>
                <div class=\"w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg\">
                    <i class=\"fas fa-check-circle\"></i>
                </div>
            </div>
            <div class=\"flex items-center gap-1.5 text-xs text-emerald-600 font-semibold mt-3\">
                <i class=\"fas fa-shield-alt\"></i>
                <span>Tersimpan di rak</span>
            </div>
        </div>

        <div class=\"bg-white p-5 rounded-2xl border border-slate-200 shadow-sm\">
            <div class=\"flex items-center justify-between\">
                <div>
                    <p class=\"text-xs font-semibold text-slate-500 uppercase tracking-wider\">Kendala / Retur</p>
                    <h3 class=\"text-2xl font-extrabold text-slate-900 mt-1\">1 Transaksi</h3>
                </div>
                <div class=\"w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-lg\">
                    <i class=\"fas fa-exclamation-triangle\"></i>
                </div>
            </div>
            <div class=\"flex items-center gap-1.5 text-xs text-red-600 font-semibold mt-3\">
                <i class=\"fas fa-redo\"></i>
                <span>Menunggu investigasi</span>
            </div>
        </div>
    </div>

    <!-- Main Table Section -->
    <div class=\"bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden\">
        <!-- Filter and Search Bar -->
        <div class=\"p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4\">
            <div class=\"flex items-center gap-2 overflow-x-auto pb-2 sm:pb-0\">
                <button class=\"px-3.5 py-1.5 rounded-lg bg-blue-600 text-white text-xs font-semibold shadow-sm\">Semua (24)</button>
                <button class=\"px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-colors\">Sedang QC (5)</button>
                <button class=\"px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-colors\">Putaway (18)</button>
                <button class=\"px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-colors\">Retur (1)</button>
            </div>
            <div class=\"flex items-center gap-3\">
                <div class=\"relative flex-1 sm:w-64\">
                    <span class=\"absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400\">
                        <i class=\"fas fa-search text-xs\"></i>
                    </span>
                    <input type=\"text\" placeholder=\"Cari No PO / Supplier / SKU...\" class=\"w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all\">
                </div>
                <div class=\"relative\">
                    <select class=\"px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all\">\n                        <option value=\"\">Semua Gudang / Dock</option>\n                        <option value=\"dock-1\">Dock Utama - DC 01</option>\n                        <option value=\"dock-2\">Dock B - Gudang Elektronik</option>\n                        <option value=\"dock-3\">Dock C - Gudang Umum</option>\n                    </select>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class=\"overflow-x-auto\">
            <table class=\"w-full text-left border-collapse\">\n                <thead>
                    <tr class=\"bg-slate-50/70 border-b border-slate-100 text-[11px] font-bold text-slate-500 uppercase tracking-wider\">\n                        <th class=\"py-3.5 px-4\">No PO / Ref</th>
                        <th class=\"py-3.5 px-4\">Waktu Tiba</th>
                        <th class=\"py-3.5 px-4\">Supplier</th>
                        <th class=\"py-3.5 px-4\">Barang & SKU</th>
                        <th class=\"py-3.5 px-4 text-center\">Jumlah</th>
                        <th class=\"py-3.5 px-4\">Lokasi / Dock</th>
                        <th class=\"py-3.5 px-4\">Status QC</th>
                        <th class=\"py-3.5 px-4 text-right\">Aksi</th>
                    </tr>
                </thead>
                <tbody class=\"divide-y divide-slate-100 text-xs text-slate-700\">\n                    <tr class=\"hover:bg-slate-50/60 transition-colors\">\n                        <td class=\"py-3.5 px-4 font-bold text-slate-900\">\n                            PO-2025-1042\n                            <div class=\"text-[10px] text-slate-400 font-normal\">SJ/2025/VIII/901</div>\n                        </td>\n                        <td class=\"py-3.5 px-4 text-slate-600\">08:30 WIB <span class=\"block text-[10px] text-slate-400\">Hari ini</span></td>\n                        <td class=\"py-3.5 px-4 font-semibold text-slate-800\">\n                            PT Sinar Megah Abadi\n                            <div class=\"text-[10px] text-slate-400 font-normal\">PIC: Budi Santoso</div>\n                        </td>\n                        <td class=\"py-3.5 px-4\">\n                            <span class=\"font-medium text-slate-900\">Kamera DSLR Canon EOS 600D</span>\n                            <div class=\"text-[10px] text-slate-500 font-mono\">SKU-CAM-600D</div>\n                        </td>\n                        <td class=\"py-3.5 px-4 text-center\">\n                            <span class=\"font-bold text-slate-900\">150 Unit</span>\n                            <div class=\"text-[10px] text-slate-400\">Karton Box</div>\n                        </td>\n                        <td class=\"py-3.5 px-4\">\n                            <span class=\"px-2.5 py-1 bg-blue-50 text-blue-700 font-semibold rounded-md text-[11px]\">Rak A-01-04</span>\n                            <div class=\"text-[10px] text-slate-400 mt-0.5\">Dock 1 Utama</div>\n                        </td>\n                        <td class=\"py-3.5 px-4\">\n                            <span class=\"inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-200/50\">\n                                <span class=\"w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse\"></span> Sedang QC\n                            </span>\n                        </td>\n                        <td class=\"py-3.5 px-4 text-right\">\n                            <div class=\"flex items-center justify-end gap-2\">\n                                <button onclick=\"openModal('detailInboundModal')\" class=\"p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 rounded-lg transition-colors\" title=\"Detail Transaksi\">\n                                    <i class=\"fas fa-eye text-xs\"></i>\n                                </button>\n                                @if(auth()->user()->isSuperAdmin() || auth()->user()->isKepalaGudang())\n                                <button class=\"p-1.5 bg-slate-100 hover:bg-emerald-50 hover:text-emerald-600 text-slate-600 rounded-lg transition-colors\" title=\"Selesaikan QC / Putaway\">\n                                    <i class=\"fas fa-check text-xs\"></i>\n                                </button>\n                                @endif\n                            </div>\n                        </td>\n                    </tr>\n\n                    <tr class=\"hover:bg-slate-50/60 transition-colors\">\n                        <td class=\"py-3.5 px-4 font-bold text-slate-900\">\n                            PO-2025-1041\n                            <div class=\"text-[10px] text-slate-400 font-normal\">SJ/2025/VIII/889</div>\n                        </td>\n                        <td class=\"py-3.5 px-4 text-slate-600\">09:15 WIB <span class=\"block text-[10px] text-slate-400\">Kemarin</span></td>\n                        <td class=\"py-3.5 px-4 font-semibold text-slate-800\">\n                            CV Mitra Perkasa\n                            <div class=\"text-[10px] text-slate-400 font-normal\">PIC: Rahmat Hidayat</div>\n                        </td>\n                        <td class=\"py-3.5 px-4\">\n                            <span class=\"font-medium text-slate-900\">Laptop Dell Latitude 3420</span>\n                            <div class=\"text-[10px] text-slate-500 font-mono\">SKU-LAP-3420</div>\n                        </td>\n                        <td class=\"py-3.5 px-4 text-center\">\n                            <span class=\"font-bold text-slate-900\">75 Unit</span>\n                            <div class=\"text-[10px] text-slate-400\">Pallet Kayu</div>\n                        </td>\n                        <td class=\"py-3.5 px-4\">\n                            <span class=\"px-2.5 py-1 bg-blue-50 text-blue-700 font-semibold rounded-md text-[11px]\">Rak B-02-11</span>\n                            <div class=\"text-[10px] text-slate-400 mt-0.5\">Dock B Elektronik</div>\n                        </td>\n                        <td class=\"py-3.5 px-4\">\n                            <span class=\"inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/50\">\n                                <span class=\"w-1.5 h-1.5 rounded-full bg-emerald-500\"></span> Selesai Putaway\n                            </span>\n                        </td>\n                        <td class=\"py-3.5 px-4 text-right\">\n                            <div class=\"flex items-center justify-end gap-2\">\n                                <button onclick=\"openModal('detailInboundModal')\" class=\"p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 rounded-lg transition-colors\" title=\"Detail Transaksi\">\n                                    <i class=\"fas fa-eye text-xs\"></i>\n                                </button>\n                            </div>\n                        </td>\n                    </tr>\n                </tbody>\n            </table>\n        </div>\n\n        <!-- Pagination -->\n        <div class=\"p-4 sm:p-5 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4\">\n            <p class=\"text-xs text-slate-500\">Menampilkan <span class=\"font-bold text-slate-700\">1-2</span> dari <span class=\"font-bold text-slate-700\">24</span> transaksi</p>\n            <div class=\"flex items-center gap-1.5\">\n                <button class=\"px-3 py-1.5 border border-slate-200 rounded-lg text-xs font-semibold text-slate-400 bg-slate-50 cursor-not-allowed\" disabled>Sebelumnya</button>\n                <button class=\"px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-semibold\">1</button>\n                <button class=\"px-3 py-1.5 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-lg text-xs font-semibold transition-colors\">2</button>\n                <button class=\"px-3 py-1.5 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-lg text-xs font-semibold transition-colors\">3</button>\n                <button class=\"px-3 py-1.5 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-lg text-xs font-semibold transition-colors\">Berikutnya</button>\n            </div>\n        </div>\n    </div>\n</div>\n\n<!-- Add Inbound Modal -->\n<div id=\"addInboundModal\" class=\"fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-sm hidden\">\n    <div class=\"bg-white rounded-2xl w-full max-w-lg mx-4 overflow-hidden shadow-2xl border border-slate-200 animate-fade-up\">\n        <div class=\"px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50\">\n            <h3 class=\"text-sm font-bold text-slate-900\">Catat Barang Masuk (Inbound)</h3>\n            <button onclick=\"closeModal('addInboundModal')\" class=\"w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors\">\n                <i class=\"fas fa-times text-xs\"></i>\n            </button>\n        </div>\n        <form action=\"#\" method=\"POST\" class=\"p-6 space-y-4\">\n            @csrf\n            <div class=\"grid grid-cols-1 sm:grid-cols-2 gap-4\">\n                <div>\n                    <label class=\"block text-xs font-semibold text-slate-700 mb-1\">Nomor PO / Referensi</label>\n                    <input type=\"text\" placeholder=\"Contoh: PO-2025-1043\" class=\"w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600\">\n                </div>\n                <div>\n                    <label class=\"block text-xs font-semibold text-slate-700 mb-1\">Nomor Surat Jalan</label>\n                    <input type=\"text\" placeholder=\"Contoh: SJ/2025/VIII/902\" class=\"w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600\">\n                </div>\n            </div>\n            <div>\n                <label class=\"block text-xs font-semibold text-slate-700 mb-1\">Supplier</label>\n                <select class=\"w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600\">\n                    <option value=\"\">Pilih Supplier</option>\n                    <option value=\"pt-sinar\">PT Sinar Megah Abadi</option>\n                    <option value=\"cv-mitra\">CV Mitra Perkasa</option>\n                    <option value=\"pt-global\">PT Global Elektronik Nusantara</option>\n                </select>\n            </div>\n            <div class=\"grid grid-cols-1 sm:grid-cols-2 gap-4\">\n                <div>\n                    <label class=\"block text-xs font-semibold text-slate-700 mb-1\">Pilih Barang (SKU)</label>\n                    <select class=\"w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600\">\n                        <option value=\"\">Pilih SKU Barang</option>\n                        <option value=\"sku-cam\">SKU-CAM-600D - Canon EOS 600D</option>\n                        <option value=\"sku-lap\">SKU-LAP-3420 - Dell Latitude 3420</option>\n                    </select>\n                </div>\n                <div>\n                    <label class=\"block text-xs font-semibold text-slate-700 mb-1\">Jumlah Masuk</label>\n                    <input type=\"number\" placeholder=\"0\" class=\"w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600\">\n                </div>\n            </div>\n            <div class=\"grid grid-cols-1 sm:grid-cols-2 gap-4\">\n                <div>\n                    <label class=\"block text-xs font-semibold text-slate-700 mb-1\">Lokasi Rak Tujuan</label>\n                    <select class=\"w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600\">\n                        <option value=\"\">Pilih Rak</option>\n                        <option value=\"a-01\">Rak A-01-04 (Utama)</option>\n                        <option value=\"b-02\">Rak B-02-11 (Elektronik)</option>\n                    </select>\n                </div>\n                <div>\n                    <label class=\"block text-xs font-semibold text-slate-700 mb-1\">Dock / Pintu Bongkar</label>\n                    <select class=\"w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600\">\n                        <option value=\"dock-1\">Dock 1 Utama</option>\n                        <option value=\"dock-2\">Dock B Elektronik</option>\n                    </select>\n                </div>\n            </div>\n            <div>\n                <label class=\"block text-xs font-semibold text-slate-700 mb-1\">Catatan / Catatan QC</label>\n                <textarea rows=\"2\" placeholder=\"Catatan kondisi fisik kemasan atau hasil pemeriksaan awal...\" class=\"w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600\"></textarea>\n            </div>\n            <div class=\"flex items-center justify-end gap-3 pt-3 border-t border-slate-100\">\n                <button type=\"button\" onclick=\"closeModal('addInboundModal')\" class=\"px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors\">Batal</button>\n                <button type=\"submit\" class=\"px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm\">Simpan & Masuk QC</button>\n            </div>\n        </form>\n    </div>\n</div>\n\n<!-- Detail Inbound Modal -->\n<div id=\"detailInboundModal\" class=\"fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-sm hidden\">\n    <div class=\"bg-white rounded-2xl w-full max-w-lg mx-4 overflow-hidden shadow-2xl border border-slate-200 animate-fade-up\">\n        <div class=\"px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50\">\n            <h3 class=\"text-sm font-bold text-slate-900\">Detail Transaksi Barang Masuk</h3>\n            <button onclick=\"closeModal('detailInboundModal')\" class=\"w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors\">\n                <i class=\"fas fa-times text-xs\"></i>\n            </button>\n        </div>\n        <div class=\"p-6 space-y-4\">\n            <div class=\"flex items-center justify-between p-3 bg-slate-50 rounded-xl\">\n                <div>\n                    <span class=\"text-[10px] font-bold text-slate-400 uppercase\">Nomor PO</span>\n                    <h4 class=\"text-sm font-extrabold text-slate-900\">PO-2025-1042</h4>\n                </div>\n                <span class=\"px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200\">Sedang QC</span>\n            </div>\n            <div class=\"grid grid-cols-2 gap-4 text-xs\">\n                <div>\n                    <span class=\"text-slate-400\">Surat Jalan:</span>\n                    <p class=\"font-semibold text-slate-800 mt-0.5\">SJ/2025/VIII/901</p>\n                </div>\n                <div>\n                    <span class=\"text-slate-400\">Waktu Tiba:</span>\n                    <p class=\"font-semibold text-slate-800 mt-0.5\">Hari ini, 08:30 WIB</p>\n                </div>\n                <div>\n                    <span class=\"text-slate-400\">Supplier:</span>\n                    <p class=\"font-semibold text-slate-800 mt-0.5\">PT Sinar Megah Abadi</p>\n                </div>\n                <div>\n                    <span class=\"text-slate-400\">PIC Ekspedisi:</span>\n                    <p class=\"font-semibold text-slate-800 mt-0.5\">Budi Santoso</p>\n                </div>\n                <div>\n                    <span class=\"text-slate-400\">Barang & SKU:</span>\n                    <p class=\"font-semibold text-slate-800 mt-0.5\">Kamera DSLR Canon EOS 600D (SKU-CAM-600D)</p>\n                </div>\n                <div>\n                    <span class=\"text-slate-400\">Jumlah Diterima:</span>\n                    <p class=\"font-semibold text-slate-800 mt-0.5\">150 Unit (Karton Box)</p>\n                </div>\n                <div>\n                    <span class=\"text-slate-400\">Lokasi Putaway:</span>\n                    <p class=\"font-semibold text-blue-600 mt-0.5\">Rak A-01-04 (Dock 1 Utama)</p>\n                </div>\n                <div>\n                    <span class=\"text-slate-400\">Metode QC:</span>\n                    <p class=\"font-semibold text-slate-800 mt-0.5\">Inspeksi Fisik & Barcode Scan</p>\n                </div>\n            </div>\n            <div class=\"pt-3 border-t border-slate-100 flex items-center justify-end gap-3\">\n                <button onclick=\"closeModal('detailInboundModal')\" class=\"px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors\">Tutup</button>\n                <button onclick=\"window.print()\" class=\"px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm\">Cetak Dokumen</button>\n            </div>\n        </div>\n    </div>\n</div>\n\n<script>\n    function openModal(modalId) {\n        document.getElementById(modalId).classList.remove('hidden');\n    }\n    function closeModal(modalId) {\n        document.getElementById(modalId).classList.add('hidden');\n    }\n</script>\n@endsection\n