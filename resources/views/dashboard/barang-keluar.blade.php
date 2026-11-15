@extends('layouts.app')

@section('title', 'Barang Keluar - Astro Inventory')

@section('content')
<div class=\"space-y-6 animate-fade-in\">
    <!-- Header Section -->
    <div class=\"flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4\">
        <div>
            <h1 class=\"text-2xl font-bold text-slate-900\">Manajemen Barang Keluar</h1>
            <p class=\"text-sm text-slate-500 mt-1\">Pantau pengeluaran inventaris, surat jalan, alokasi permintaan departemen, dan proses dispatching.</p>
        </div>
        <div class=\"flex items-center gap-3\">
            @if(auth()->user()->isSuperAdmin() || auth()->user()->isKepalaGudang() || auth()->user()->isPegawai())
            <button onclick=\"openModal('addOutboundModal')\" class=\"inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors\">
                <i class=\"fas fa-plus text-xs\"></i>
                <span>Catat Pengeluaran Barang</span>
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
                    <p class=\"text-xs font-semibold text-slate-500 uppercase tracking-wider\">Total Keluar Hari Ini</p>
                    <h3 class=\"text-2xl font-extrabold text-slate-900 mt-1\">16 Pengiriman</h3>
                </div>
                <div class=\"w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg\">
                    <i class=\"fas fa-arrow-up-right\"></i>
                </div>
            </div>
            <div class=\"flex items-center gap-1.5 text-xs text-blue-600 font-semibold mt-3\">
                <i class=\"fas fa-boxes\"></i>
                <span>320 Unit total volume</span>
            </div>
        </div>

        <div class=\"bg-white p-5 rounded-2xl border border-slate-200 shadow-sm\">
            <div class=\"flex items-center justify-between\">
                <div>
                    <p class=\"text-xs font-semibold text-slate-500 uppercase tracking-wider\">Menunggu Approval</p>
                    <h3 class=\"text-2xl font-extrabold text-slate-900 mt-1\">3 Pengajuan</h3>
                </div>
                <div class=\"w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg\">
                    <i class=\"fas fa-clipboard-list\"></i>
                </div>
            </div>
            <div class=\"flex items-center gap-1.5 text-xs text-amber-600 font-semibold mt-3\">
                <i class=\"fas fa-clock\"></i>
                <span>Verifikasi admin/atasan</span>
            </div>
        </div>

        <div class=\"bg-white p-5 rounded-2xl border border-slate-200 shadow-sm\">
            <div class=\"flex items-center justify-between\">
                <div>
                    <p class=\"text-xs font-semibold text-slate-500 uppercase tracking-wider\">Siap Dispatch / Picking</p>
                    <h3 class=\"text-2xl font-extrabold text-slate-900 mt-1\">4 Order</h3>
                </div>
                <div class=\"w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg\">
                    <i class=\"fas fa-dolly\"></i>
                </div>
            </div>
            <div class=\"flex items-center gap-1.5 text-xs text-purple-600 font-semibold mt-3\">
                <i class=\"fas fa-truck-loading\"></i>
                <span>Proses kemas & muat</span>
            </div>
        </div>

        <div class=\"bg-white p-5 rounded-2xl border border-slate-200 shadow-sm\">
            <div class=\"flex items-center justify-between\">
                <div>
                    <p class=\"text-xs font-semibold text-slate-500 uppercase tracking-wider\">Selesai Dikirim</p>
                    <h3 class=\"text-2xl font-extrabold text-slate-900 mt-1\">9 Transaksi</h3>
                </div>
                <div class=\"w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg\">
                    <i class=\"fas fa-check-double\"></i>
                </div>
            </div>
            <div class=\"flex items-center gap-1.5 text-xs text-emerald-600 font-semibold mt-3\">
                <i class=\"fas fa-check-circle\"></i>
                <span>Terkonfirmasi penerima</span>
            </div>
        </div>
    </div>

    <!-- Main Table Section -->
    <div class=\"bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden\">
        <!-- Filter and Search Bar -->
        <div class=\"p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4\">
            <div class=\"flex items-center gap-2 overflow-x-auto pb-2 sm:pb-0\">
                <button class=\"px-3.5 py-1.5 rounded-lg bg-blue-600 text-white text-xs font-semibold shadow-sm\">Semua (16)</button>
                <button class=\"px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-colors\">Menunggu (3)</button>
                <button class=\"px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-colors\">Picking (4)</button>
                <button class=\"px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition-colors\">Selesai (9)</button>
            </div>
            <div class=\"flex items-center gap-3\">
                <div class=\"relative flex-1 sm:w-64\">
                    <span class=\"absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400\">
                        <i class=\"fas fa-search text-xs\"></i>
                    </span>
                    <input type=\"text\" placeholder=\"Cari No DO / Departemen / SKU...\" class=\"w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all\">
                </div>
                <div class=\"relative\">
                    <select class=\"px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all\">\n                        <option value=\"\">Semua Departemen</option>\n                        <option value=\"ops\">Operasional</option>\n                        <option value=\"it\">Teknologi Informasi</option>\n                        <option value=\"log\">Logistik Wilayah</option>\n                    </select>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class=\"overflow-x-auto\">
            <table class=\"w-full text-left border-collapse\">\n                <thead>
                    <tr class=\"bg-slate-50/70 border-b border-slate-100 text-[11px] font-bold text-slate-500 uppercase tracking-wider\">\n                        <th class=\"py-3.5 px-4\">No DO / Ref</th>
                        <th class=\"py-3.5 px-4\">Waktu Keluar</th>
                        <th class=\"py-3.5 px-4\">Tujuan / Departemen</th>
                        <th class=\"py-3.5 px-4\">Barang & SKU</th>
                        <th class=\"py-3.5 px-4 text-center\">Jumlah</th>
                        <th class=\"py-3.5 px-4\">Kurir / Ekspedisi</th>
                        <th class=\"py-3.5 px-4\">Status Dispatch</th>
                        <th class=\"py-3.5 px-4 text-right\">Aksi</th>
                    </tr>
                </thead>
                <tbody class=\"divide-y divide-slate-100 text-xs text-slate-700\">\n                    <tr class=\"hover:bg-slate-50/60 transition-colors\">\n                        <td class=\"py-3.5 px-4 font-bold text-slate-900\">\n                            DO-2025-0819\n                            <div class=\"text-[10px] text-slate-400 font-normal\">REQ-2025-1038</div>\n                        </td>\n                        <td class=\"py-3.5 px-4 text-slate-600\">10:15 WIB <span class=\"block text-[10px] text-slate-400\">Hari ini</span></td>\n                        <td class=\"py-3.5 px-4 font-semibold text-slate-800\">\n                            Departemen Operasional\n                            <div class=\"text-[10px] text-slate-400 font-normal\">Penerima: Ahmad Fauzi</div>\n                        </td>\n                        <td class=\"py-3.5 px-4\">\n                            <span class=\"font-medium text-slate-900\">Bubble Wrap Tebal 50m</span>\n                            <div class=\"text-[10px] text-slate-500 font-mono\">SKU-PKG-BW50</div>\n                        </td>\n                        <td class=\"py-3.5 px-4 text-center\">\n                            <span class=\"font-bold text-slate-900\">5 Roll</span>\n                            <div class=\"text-[10px] text-slate-400\">Kemasan Standar</div>\n                        </td>\n                        <td class=\"py-3.5 px-4\">\n                            <span class=\"px-2.5 py-1 bg-slate-100 text-slate-700 font-semibold rounded-md text-[11px]\">Kurir Internal DC</span>\n                            <div class=\"text-[10px] text-slate-400 mt-0.5\">Armada Pick-Up #02</div>\n                        </td>\n                        <td class=\"py-3.5 px-4\">\n                            <span class=\"inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/50\">\n                                <span class=\"w-1.5 h-1.5 rounded-full bg-emerald-500\"></span> Selesai Terkirim\n                            </span>\n                        </td>\n                        <td class=\"py-3.5 px-4 text-right\">\n                            <div class=\"flex items-center justify-end gap-2\">\n                                <button onclick=\"openModal('detailOutboundModal')\" class=\"p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 rounded-lg transition-colors\" title=\"Detail Transaksi\">\n                                    <i class=\"fas fa-eye text-xs\"></i>\n                                </button>\n                            </div>\n                        </td>\n                    </tr>\n\n                    <tr class=\"hover:bg-slate-50/60 transition-colors\">\n                        <td class=\"py-3.5 px-4 font-bold text-slate-900\">\n                            DO-2025-0820\n                            <div class=\"text-[10px] text-slate-400 font-normal\">REQ-2025-1045</div>\n                        </td>\n                        <td class=\"py-3.5 px-4 text-slate-600\">11:30 WIB <span class=\"block text-[10px] text-slate-400\">Hari ini</span></td>\n                        <td class=\"py-3.5 px-4 font-semibold text-slate-800\">\n                            Cabang Regional Surabaya\n                            <div class=\"text-[10px] text-slate-400 font-normal\">PIC: Hendra Pratama</div>\n                        </td>\n                        <td class=\"py-3.5 px-4\">\n                            <span class=\"font-medium text-slate-900\">Barcode Scanner Bluetooth</span>\n                            <div class=\"text-[10px] text-slate-500 font-mono\">SKU-SCN-BT01</div>\n                        </td>\n                        <td class=\"py-3.5 px-4 text-center\">\n                            <span class=\"font-bold text-slate-900\">20 Unit</span>\n                            <div class=\"text-[10px] text-slate-400\">Dus Karton</div>\n                        </td>\n                        <td class=\"py-3.5 px-4\">\n                            <span class=\"px-2.5 py-1 bg-purple-50 text-purple-700 font-semibold rounded-md text-[11px]\">Ekspedisi JNE Cargo</span>\n                            <div class=\"text-[10px] text-slate-400 mt-0.5\">Resi: JNE882910399</div>\n                        </td>\n                        <td class=\"py-3.5 px-4\">\n                            <span class=\"inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-purple-50 text-purple-700 border border-purple-200/50\">\n                                <span class=\"w-1.5 h-1.5 rounded-full bg-purple-500 animate-pulse\"></span> Sedang Dipacking\n                            </span>\n                        </td>\n                        <td class=\"py-3.5 px-4 text-right\">\n                            <div class=\"flex items-center justify-end gap-2\">\n                                <button onclick=\"openModal('detailOutboundModal')\" class=\"p-1.5 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-600 rounded-lg transition-colors\" title=\"Detail Transaksi\">\n                                    <i class=\"fas fa-eye text-xs\"></i>\n                                </button>\n                                @if(auth()->user()->isSuperAdmin() || auth()->user()->isKepalaGudang())\n                                <button class=\"p-1.5 bg-slate-100 hover:bg-emerald-50 hover:text-emerald-600 text-slate-600 rounded-lg transition-colors\" title=\"Selesaikan Pengiriman\">\n                                    <i class=\"fas fa-check text-xs\"></i>\n                                </button>\n                                @endif\n                            </div>\n                        </td>\n                    </tr>\n                </tbody>\n            </table>\n        </div>\n\n        <!-- Pagination -->\n        <div class=\"p-4 sm:p-5 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4\">\n            <p class=\"text-xs text-slate-500\">Menampilkan <span class=\"font-bold text-slate-700\">1-2</span> dari <span class=\"font-bold text-slate-700\">16</span> transaksi</p>\n            <div class=\"flex items-center gap-1.5\">\n                <button class=\"px-3 py-1.5 border border-slate-200 rounded-lg text-xs font-semibold text-slate-400 bg-slate-50 cursor-not-allowed\" disabled>Sebelumnya</button>\n                <button class=\"px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-semibold\">1</button>\n                <button class=\"px-3 py-1.5 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-lg text-xs font-semibold transition-colors\">2</button>\n                <button class=\"px-3 py-1.5 border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-lg text-xs font-semibold transition-colors\">Berikutnya</button>\n            </div>\n        </div>\n    </div>\n</div>\n\n<!-- Add Outbound Modal -->\n<div id=\"addOutboundModal\" class=\"fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-sm hidden\">\n    <div class=\"bg-white rounded-2xl w-full max-w-lg mx-4 overflow-hidden shadow-2xl border border-slate-200 animate-fade-up\">\n        <div class=\"px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50\">\n            <h3 class=\"text-sm font-bold text-slate-900\">Catat Barang Keluar (Outbound)</h3>\n            <button onclick=\"closeModal('addOutboundModal')\" class=\"w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors\">\n                <i class=\"fas fa-times text-xs\"></i>\n            </button>\n        </div>\n        <form action=\"#\" method=\"POST\" class=\"p-6 space-y-4\">\n            @csrf\n            <div class=\"grid grid-cols-1 sm:grid-cols-2 gap-4\">\n                <div>\n                    <label class=\"block text-xs font-semibold text-slate-700 mb-1\">Nomor DO / Surat Jalan</label>\n                    <input type=\"text\" placeholder=\"Contoh: DO-2025-0821\" class=\"w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600\">\n                </div>\n                <div>\n                    <label class=\"block text-xs font-semibold text-slate-700 mb-1\">Referensi Pengajuan / SPB</label>\n                    <input type=\"text\" placeholder=\"Contoh: REQ-2025-1049\" class=\"w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600\">\n                </div>\n            </div>\n            <div>\n                <label class=\"block text-xs font-semibold text-slate-700 mb-1\">Departemen / Cabang Tujuan</label>\n                <select class=\"w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600\">\n                    <option value=\"\">Pilih Departemen / Cabang</option>\n                    <option value=\"ops\">Operasional DC</option>\n                    <option value=\"it\">Teknologi Informasi</option>\n                    <option value=\"sby\">Cabang Regional Surabaya</option>\n                    <option value=\"bdg\">Cabang Regional Bandung</option>\n                </select>\n            </div>\n            <div class=\"grid grid-cols-1 sm:grid-cols-2 gap-4\">\n                <div>\n                    <label class=\"block text-xs font-semibold text-slate-700 mb-1\">Pilih Barang (SKU)</label>\n                    <select class=\"w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600\">\n                        <option value=\"\">Pilih SKU Barang</option>\n                        <option value=\"sku-pkg\">SKU-PKG-BW50 - Bubble Wrap</option>\n                        <option value=\"sku-scn\">SKU-SCN-BT01 - Scanner Bluetooth</option>\n                    </select>\n                </div>\n                <div>\n                    <label class=\"block text-xs font-semibold text-slate-700 mb-1\">Jumlah Keluar</label>\n                    <input type=\"number\" placeholder=\"0\" class=\"w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600\">\n                </div>\n            </div>\n            <div class=\"grid grid-cols-1 sm:grid-cols-2 gap-4\">\n                <div>\n                    <label class=\"block text-xs font-semibold text-slate-700 mb-1\">Jasa Ekspedisi / Kurir</label>\n                    <select class=\"w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600\">\n                        <option value=\"internal\">Kurir Internal DC</option>\n                        <option value=\"jne\">JNE Cargo</option>\n                        <option value=\"sicepat\">SiCepat Cargo</option>\n                    </select>\n                </div>\n                <div>\n                    <label class=\"block text-xs font-semibold text-slate-700 mb-1\">Nama Penerima / PIC</label>\n                    <input type=\"text\" placeholder=\"Nama lengkap penerima\" class=\"w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600\">\n                </div>\n            </div>\n            <div class=\"flex items-center justify-end gap-3 pt-3 border-t border-slate-100\">\n                <button type=\"button\" onclick=\"closeModal('addOutboundModal')\" class=\"px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors\">Batal</button>\n                <button type=\"submit\" class=\"px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm\">Simpan & Proses Keluar</button>\n            </div>\n        </form>\n    </div>\n</div>\n\n<!-- Detail Outbound Modal -->\n<div id=\"detailOutboundModal\" class=\"fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 backdrop-blur-sm hidden\">\n    <div class=\"bg-white rounded-2xl w-full max-w-lg mx-4 overflow-hidden shadow-2xl border border-slate-200 animate-fade-up\">\n        <div class=\"px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50\">\n            <h3 class=\"text-sm font-bold text-slate-900\">Detail Transaksi Barang Keluar</h3>\n            <button onclick=\"closeModal('detailOutboundModal')\" class=\"w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors\">\n                <i class=\"fas fa-times text-xs\"></i>\n            </button>\n        </div>\n        <div class=\"p-6 space-y-4\">\n            <div class=\"flex items-center justify-between p-3 bg-slate-50 rounded-xl\">\n                <div>\n                    <span class=\"text-[10px] font-bold text-slate-400 uppercase\">Nomor DO</span>\n                    <h4 class=\"text-sm font-extrabold text-slate-900\">DO-2025-0819</h4>\n                </div>\n                <span class=\"px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200\">Selesai Terkirim</span>\n            </div>\n            <div class=\"grid grid-cols-2 gap-4 text-xs\">\n                <div>\n                    <span class=\"text-slate-400\">Referensi Pengajuan:</span>\n                    <p class=\"font-semibold text-slate-800 mt-0.5\">REQ-2025-1038</p>\n                </div>\n                <div>\n                    <span class=\"text-slate-400\">Waktu Pengeluaran:</span>\n                    <p class=\"font-semibold text-slate-800 mt-0.5\">Hari ini, 10:15 WIB</p>\n                </div>\n                <div>\n                    <span class=\"text-slate-400\">Tujuan Pengiriman:</span>\n                    <p class=\"font-semibold text-slate-800 mt-0.5\">Departemen Operasional</p>\n                </div>\n                <div>\n                    <span class=\"text-slate-400\">Penerima / Pemohon:</span>\n                    <p class=\"font-semibold text-slate-800 mt-0.5\">Ahmad Fauzi</p>\n                </div>\n                <div>\n                    <span class=\"text-slate-400\">Barang & SKU:</span>\n                    <p class=\"font-semibold text-slate-800 mt-0.5\">Bubble Wrap Tebal 50m (SKU-PKG-BW50)</p>\n                </div>\n                <div>\n                    <span class=\"text-slate-400\">Jumlah Dikeluarkan:</span>\n                    <p class=\"font-semibold text-slate-800 mt-0.5\">5 Roll</p>\n                </div>\n                <div>\n                    <span class=\"text-slate-400\">Ekspedisi / Armada:</span>\n                    <p class=\"font-semibold text-blue-600 mt-0.5\">Kurir Internal DC (Pick-Up #02)</p>\n                </div>\n                <div>\n                    <span class=\"text-slate-400\">Status Dokumen:</span>\n                    <p class=\"font-semibold text-slate-800 mt-0.5\">Ditandatangani Digital</p>\n                </div>\n            </div>\n            <div class=\"pt-3 border-t border-slate-100 flex items-center justify-end gap-3\">\n                <button onclick=\"closeModal('detailOutboundModal')\" class=\"px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors\">Tutup</button>\n                <button onclick=\"window.print()\" class=\"px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm\">Cetak Surat Jalan</button>\n            </div>\n        </div>\n    </div>\n</div>\n\n<script>\n    function openModal(modalId) {\n        document.getElementById(modalId).classList.remove('hidden');\n    }\n    function closeModal(modalId) {\n        document.getElementById(modalId).classList.add('hidden');\n    }\n</script>\n@endsection\n