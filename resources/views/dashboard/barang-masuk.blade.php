<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transaksi Barang Masuk — Astro Inventory</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { brand: { DEFAULT: '#2563eb', dark: '#1d4ed8', 50: '#eff6ff', 100: '#dbeafe', 600: '#2563eb', 700: '#1d4ed8' } },
                    fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                },
            },
        };
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root { --brand: #2563eb; --brand-dark: #1d4ed8; --bg: #f5f7fb; --line: #e7ebf2; }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif; }

        .nav-link { transition: all 0.16s ease; }
        .nav-link:hover { background: #f1f5f9; color: #172033; transform: translateX(3px); }
        .nav-link.active { background: var(--brand); color: #fff; font-weight: 600; box-shadow: 0 6px 14px -6px rgba(37, 99, 235, 0.55); }
        .nav-link.active:hover { transform: none; background: var(--brand); }

        .reveal { animation: rise-in .4s cubic-bezier(.2,.8,.2,1) both; }
        @keyframes rise-in { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

        @media (min-width: 768px) { main { zoom: 1.1; } }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; }
        }
    </style>
</head>

<body class="bg-gray-50">
@include('components.navbar')

<div class="flex min-h-screen bg-[#f5f7fc] text-[#17243b] antialiased">
    @include('components.sidebar')

    <main class="flex-1 p-4 lg:p-6 overflow-x-hidden">

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
    </main>
</div>

{{-- Add Inbound Modal --}}
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
</body>
</html>