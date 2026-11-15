@extends('layouts.app')

@section('title', 'Laporan Inventaris HR | ASTRO Inventory')

@section('styles')
<style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: Inter, sans-serif;
        overflow-x: hidden;
    }

    .card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .05);
    }

    .ctl {
        height: 40px;
        border-radius: 6px;
        background: #eff6ff;
        padding: 0 12px;
        font-size: 12px;
        color: #334155;
        outline: none;
        border: 0;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border-radius: 6px;
        padding: 7px 12px;
        font-size: 11px;
        font-weight: 600;
        line-height: 1.25;
        text-align: center;
        transition: background .15s ease;
        cursor: pointer;
    }

    .btn-p {
        background: #2563eb;
        color: #fff;
    }

    .btn-p:hover {
        background: #1d4ed8;
    }

    .btn-s {
        background: #fff;
        color: #334155;
        border: 1px solid #e2e8f0;
    }

    .btn-s:hover {
        background: #f8fafc;
    }

    .reveal {
        animation: rise-in .4s cubic-bezier(.2, .8, .2, 1) both;
    }

    .d1 {
        animation-delay: 50ms;
    }

    .d2 {
        animation-delay: 100ms;
    }

    .d3 {
        animation-delay: 150ms;
    }

    @keyframes rise-in {
        from {
            opacity: 0;
            transform: translateY(8px);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }

    :focus-visible {
        outline: 2px solid #0b49d8;
        outline-offset: 2px;
    }

    #advancedFilters[hidden] {
        display: none;
    }

    #rows tr[hidden] {
        display: none;
    }

    .pagination-btn {
        min-width: 32px;
        height: 32px;
        padding: 0 9px;
        border-radius: 5px;
        font-size: 12px;
    }

    .pagination-btn.active {
        background: #2563eb;
        color: #fff;
        font-weight: 700;
    }

    .pagination-btn:not(.active):not(:disabled):hover {
        background: #eff6ff;
    }

    @media print {
        body {
            background: #fff !important;
            overflow: visible !important;
        }

        #sidebar,
        #sidebar-backdrop,
        #advancedFilters,
        #advancedFilterBtn,
        #exportCsv,
        #printReport,
        #resetChips,
        #toasts,
        #main-area>header,
        .no-print,
        footer.pagination-footer {
            display: none !important;
        }

        #main-area {
            margin: 0 !important;
            width: 100% !important;
        }

        main {
            padding: 0 !important;
            overflow: visible !important;
        }

        .card {
            box-shadow: none !important;
            break-inside: avoid;
        }

        .overflow-x-auto {
            overflow: visible !important;
        }

        table {
            min-width: 100% !important;
            font-size: 9px !important;
        }

        th,
        td {
            padding: 6px !important;
        }

        .reveal {
            animation: none !important;
        }

        canvas {
            max-height: 240px !important;
        }
    }

    @media (prefers-reduced-motion: reduce) {

        *,
        *::before,
        *::after {
            animation-duration: .01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: .01ms !important;
        }
    }
</style>
@endsection

@section('content')

<div class="app-shell flex min-h-screen">

    {{-- SIDEBAR BERSAMA --}}
    @include('components.sidebar')

    <div id="main-area" class="min-h-screen min-w-0 flex-1">

        {{-- NAVBAR BERSAMA --}}
        @include('components.navbar')

        <main class="min-h-[calc(100vh-56px)] overflow-x-hidden bg-canvas p-4 lg:p-5">

            {{-- HEADER HALAMAN --}}
            <section class="reveal mb-4 flex flex-wrap items-end justify-between gap-3">
                <div class="min-w-0 max-w-[760px]">
                    <p class="mb-1 text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">
                        Beranda
                        <span class="text-slate-400">&gt;</span>
                        Manajemen & Laporan
                        <span class="text-blue-700">&gt; Laporan Inventaris</span>
                    </p>

                    <h1 class="text-[20px] font-bold leading-tight tracking-tight text-slate-800 sm:text-[24px]">
                        Laporan & Analitik Inventaris HR
                    </h1>

                    <p class="mt-1.5 text-[12px] leading-relaxed text-slate-500">
                        Pantau mutasi stok barang, status buffer per Hub regional, dan kebutuhan alokasi barang operasional.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <button
                        id="advancedFilterBtn"
                        type="button"
                        class="flex h-10 items-center gap-2 rounded-md border border-slate-100 bg-white px-4 text-[12px] font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                        <i data-lucide="list-filter" class="h-4 w-4 text-blue-600"></i>
                        Filter Lanjutan
                    </button>

                    <button
                        id="exportCsv"
                        type="button"
                        class="flex h-10 items-center gap-2 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white shadow-sm hover:bg-blue-700">
                        <i data-lucide="download" class="h-4 w-4"></i>
                        Unduh Rekap CSV
                    </button>
                </div>
            </section>

            {{-- FILTER CHIPS --}}
            <section class="reveal d1 card mb-4 p-3">
                <div id="chips" class="flex flex-wrap items-center gap-2 text-[10.5px]"></div>

                <div class="mt-2.5 flex flex-wrap items-center justify-between gap-2 text-[10.5px] text-slate-500">
                    <span class="inline-flex items-center gap-1.5">
                        <i data-lucide="refresh-cw" class="h-3.5 w-3.5"></i>
                        Sinkronisasi Buku Besar: 4 Menit Lalu
                    </span>

                    <button id="resetChips" type="button" class="font-semibold text-blue-700 hover:underline">
                        Reset Semua
                    </button>
                </div>
            </section>

            {{-- FILTER LANJUTAN --}}
            <section id="advancedFilters" hidden class="card mb-4 p-4">
                <div class="mb-3 flex items-center justify-between">
                    <h2 class="text-[12px] font-bold text-slate-800">
                        Filter Laporan Lanjutan
                    </h2>

                    <button id="closeAdvancedFilter" type="button"
                        class="text-slate-500 hover:text-red-600"
                        aria-label="Tutup filter">
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                    <div>
                        <label for="fKat" class="mb-1 block text-[11px] font-semibold text-slate-600">
                            Kategori Barang
                        </label>
                        <select id="fKat" class="ctl w-full">
                            <option value="">Semua Kategori</option>
                        </select>
                    </div>

                    <div>
                        <label for="fHub" class="mb-1 block text-[11px] font-semibold text-slate-600">
                            Hub Regional
                        </label>
                        <select id="fHub" class="ctl w-full">
                            <option value="">Semua Hub</option>
                        </select>
                    </div>

                    <div>
                        <label for="fStatus" class="mb-1 block text-[11px] font-semibold text-slate-600">
                            Status Kepatuhan
                        </label>
                        <select id="fStatus" class="ctl w-full">
                            <option value="">Semua Status</option>
                            <option value="Sesuai Standar">Sesuai Standar</option>
                            <option value="Audit Selisih">Audit Selisih</option>
                        </select>
                    </div>
                </div>

                <div class="mt-3 flex justify-end gap-2">
                    <button id="clearAdvancedFilter" type="button" class="btn btn-s">
                        Reset Filter
                    </button>

                    <button id="applyAdvancedFilter" type="button" class="btn btn-p">
                        Terapkan Filter
                    </button>
                </div>
            </section>

            {{-- STATISTIK --}}
            <section
                id="stats"
                aria-label="Ringkasan inventaris"
                class="reveal d1 mb-4 grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
            </section>

            {{-- GRAFIK DAN DISTRIBUSI HUB --}}
            <section class="reveal d2 mb-4 grid grid-cols-1 gap-3 xl:grid-cols-3">

                {{-- GRAFIK MUTASI --}}
                <article class="card p-4 xl:col-span-2">
                    <div class="mb-3 flex flex-wrap items-center justify-between gap-2">
                        <h2 class="text-[13px] font-bold text-slate-800">
                            Tren Volume Mutasi & Sensitivitas Mingguan
                        </h2>

                        <div id="range" class="flex flex-wrap gap-1.5 text-[10.5px] font-semibold">
                            <button type="button" data-range="7"
                                class="rounded-md bg-blue-600 px-3 py-1.5 text-white">
                                7 Hari Terakhir
                            </button>

                            <button type="button" data-range="30"
                                class="rounded-md bg-slate-100 px-3 py-1.5 text-slate-600 hover:bg-slate-200">
                                30 Hari
                            </button>

                            <button type="button" data-range="month"
                                class="rounded-md bg-slate-100 px-3 py-1.5 text-slate-600 hover:bg-slate-200">
                                Bulan Ini
                            </button>
                        </div>
                    </div>

                    <div class="mb-3 flex flex-wrap items-center gap-x-5 gap-y-1.5 text-[10.5px]">
                        <span class="inline-flex items-center gap-2 text-slate-700">
                            <i class="h-2.5 w-2.5 rounded-full bg-blue-600"></i>
                            <b>Inbound (Masuk)</b>: 8.420 Unit
                        </span>

                        <span class="inline-flex items-center gap-2 text-slate-700">
                            <i class="h-2.5 w-2.5 rounded-full bg-slate-400"></i>
                            <b>Outbound (Keluar)</b>: 6.850 Unit
                        </span>

                        <span class="inline-flex items-center gap-2 text-red-600">
                            <i class="h-2.5 w-2.5 rounded-full bg-red-500"></i>
                            <b>Penyesuaian Selisih</b>: 14 Unit
                        </span>
                    </div>

                    <div class="relative h-56">
                        <canvas id="mutasiChart"></canvas>
                    </div>

                    <div class="mt-4 grid grid-cols-1 gap-3 border-t border-slate-100 pt-4 sm:grid-cols-3">
                        <div class="sm:text-center">
                            <p class="mb-1 text-[10.5px] text-slate-500">Throughput Rata-rata</p>
                            <p class="text-[16px] font-bold text-slate-800">
                                1.202
                                <span class="text-[10.5px] font-normal text-slate-500">Unit/Hari</span>
                            </p>
                        </div>

                        <div class="sm:border-x sm:border-slate-100 sm:text-center">
                            <p class="mb-1 text-[10.5px] text-slate-500">Akurasi Stok Opname</p>
                            <p class="text-[16px] font-bold text-slate-800">
                                99,8%
                                <span class="text-[10.5px] font-normal text-slate-500">(Fiskal)</span>
                            </p>
                        </div>

                        <div class="sm:text-center">
                            <p class="mb-1 text-[10.5px] text-slate-500">Puncak Throughput</p>
                            <p class="text-[16px] font-bold text-slate-800">
                                Sabtu
                                <span class="text-[10.5px] font-normal text-slate-500">(1.480 Unit)</span>
                            </p>
                        </div>
                    </div>
                </article>

                {{-- DISTRIBUSI HUB --}}
                <article class="card flex flex-col p-4">
                    <div class="mb-1 flex items-center justify-between gap-2">
                        <h2 class="text-[13px] font-bold text-slate-800">
                            Distribusi per Hub Regional
                        </h2>

                        <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[10.5px] font-semibold text-emerald-800">
                            AMIP
                        </span>
                    </div>

                    <p class="mb-3 text-[11px] text-slate-500">
                        Porsi penyaluran dan mutasi barang logistik terverifikasi.
                    </p>

                    <div id="hubs" class="space-y-3.5"></div>

                    <div class="mt-auto flex items-start gap-2 rounded-md bg-blue-50 p-3 text-[11px] leading-relaxed text-blue-800">
                        <i data-lucide="info" class="mt-px h-3.5 w-3.5 shrink-0"></i>
                        <span>
                            Semua transaksi tercatat pada Ledger ASTRO-SKU256 dan terlindungi otorisasi ganda HR.
                        </span>
                    </div>
                </article>
            </section>

            {{-- TABEL LAPORAN --}}
            <section class="reveal d3 card mb-4 overflow-hidden">
                <div class="flex flex-wrap items-start justify-between gap-3 p-4 pb-3">
                    <div class="min-w-0 flex-1">
                        <h2 class="text-[13px] font-bold text-slate-800">
                            Ringkasan Laporan per Kategori SKU & Lokasi
                        </h2>

                        <p class="mt-0.5 text-[11px] text-slate-500">
                            Rincian batch buffer besar mutasi inventaris, valuasi, dan tingkat kepatuhan SPO.
                        </p>
                    </div>

                    <button
                        id="printReport"
                        type="button"
                        class="flex h-10 items-center gap-2 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white shadow-sm hover:bg-blue-700">
                        <i data-lucide="file-text" class="h-4 w-4"></i>
                        Cetak PDF
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[1110px] table-fixed border-collapse text-left">
                        <thead class="h-11 bg-[#f0f4fc] text-[9.5px] font-semibold uppercase tracking-wide text-slate-600">
                            <tr>
                                <th class="w-[150px] whitespace-nowrap px-3">Kode Laporan</th>
                                <th class="w-[330px] whitespace-nowrap px-3">Kategori & SKU Induk</th>
                                <th class="w-[170px] whitespace-nowrap px-3">Volume Mutasi</th>
                                <th class="w-[170px] whitespace-nowrap px-3">Nilai Valuasi</th>
                                <th class="w-[130px] whitespace-nowrap px-3">Rasio Persetujuan</th>
                                <th class="w-[160px] whitespace-nowrap px-3">Status Kepatuhan</th>
                            </tr>
                        </thead>

                        <tbody id="rows" class="divide-y divide-slate-100 text-[12px]"></tbody>
                    </table>
                </div>

                <p id="noRow" hidden
                    class="border-t border-slate-100 px-4 py-6 text-center text-[12px] text-slate-500">
                    Tidak ada laporan yang sesuai filter.
                </p>

                <footer class="pagination-footer flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 px-4 py-3 text-[12px] text-slate-600">
                    <span id="cnt"></span>
                    <div id="pagination" class="flex flex-wrap items-center gap-1"></div>
                </footer>
            </section>

            {{-- INFORMASI KEAMANAN --}}
            <section class="card flex items-start gap-3 bg-slate-50 p-4">
                <i data-lucide="lock" class="mt-0.5 h-4 w-4 shrink-0 text-slate-500"></i>

                <div class="min-w-0 flex-1">
                    <p class="text-[12px] leading-relaxed text-slate-700">
                        Dokumen laporan ini terenkripsi secara digital oleh
                        <b>Budi Santoso (Admin Otorisasi HR)</b>
                        dengan NIP:
                        <b>BK-88219-JKT</b>
                    </p>

                    <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1.5">
                        <span class="text-[10.5px] text-slate-500">
                            SHA-256 : 7F1b...3dd3
                        </span>

                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-2.5 py-1 text-[10.5px] font-semibold text-emerald-800">
                            <i data-lucide="shield-check" class="h-3.5 w-3.5"></i>
                            Tervalidasi ISO-27001
                        </span>
                    </div>
                </div>
            </section>

        </main>
    </div>
</div>

{{-- TOAST --}}
<div id="toasts" class="fixed bottom-4 right-4 z-[80] flex flex-col gap-2"></div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/lucide@0.544.0/dist/umd/lucide.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const $ = (selector) => document.querySelector(selector);

        const T = {
            gray: 'bg-slate-100 text-slate-700',
            red: 'bg-red-100 text-red-700',
            green: 'bg-emerald-100 text-emerald-800',
            amber: 'bg-amber-50 text-amber-600',
            purple: 'bg-purple-100 text-purple-700',
            blue: 'bg-blue-50 text-blue-600',
            orange: 'bg-orange-100 text-orange-700',
            pink: 'bg-pink-100 text-pink-700'
        };

        const ic = (name, classes = 'h-3.5 w-3.5') =>
            `<i data-lucide="${name}" class="${classes} shrink-0"></i>`;

        const pill = (text, type, small = false) => `
        <span class="inline-flex items-center rounded-full font-semibold ${
            small ? 'px-2 py-0.5 text-[9.5px]' : 'px-2.5 py-1 text-[10.5px]'
        } ${T[type] || T.gray}">
            ${text}
        </span>
    `;

        function refreshIcons() {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        }

        /* =========================================
           DATA LAPORAN
        ========================================= */

        const STATS = [{
                l: 'Total Mutasi Selesai',
                v: '1.240',
                b: ['+14,3%', 'green'],
                s: 'Sudah 2 Pengiriman Siap Dispatch',
                si: 'circle-check',
                i: 'refresh-cw',
                c: 'bg-blue-50 text-blue-600'
            },
            {
                l: 'Valuasi Distribusi',
                v: 'Rp 4,85 M',
                b: ['Maret 2025', 'gray'],
                s: '+8,9% dari 100% kap SPO & HR Finance',
                i: 'coins',
                c: 'bg-amber-50 text-amber-600'
            },
            {
                l: 'Kepatuhan SLA HR',
                v: '98,4%',
                b: ['Target 95%+', 'green'],
                s: '848+743 transaksi terpenuhi',
                si: 'check-check',
                i: 'check-check',
                c: 'bg-emerald-50 text-emerald-700'
            },
            {
                l: 'Stok Kritis Terlaporkan',
                v: '2',
                b: ['Urgent!', 'red'],
                s: 'Butuh restock PO darurat (< 20% ROP)',
                i: 'triangle-alert',
                c: 'bg-red-50 text-red-600',
                red: 1
            }
        ];

        const HUBS = [
            ['Cakung DC-01', 'Utama Jakarta', 45, '558 Unit Mutasi', '99,2%', 'bg-blue-600', 'text-blue-700', 'text-emerald-700'],
            ['Rungkut DC-02', 'Surabaya', 25, '310 Unit Mutasi', '98,0%', 'bg-blue-600', 'text-blue-700', 'text-emerald-700'],
            ['Gedebage DC-03', 'Bandung', 18, '223 Unit Mutasi', '97,8%', 'bg-blue-600', 'text-blue-700', 'text-emerald-700'],
            ['Belawan DC-04', 'Medan', 12, '149 Unit Mutasi', '95,1%', 'bg-slate-400', 'text-slate-600', 'text-red-600']
        ];

        const R = [{
                kode: 'REP-2025-Q3-A1',
                hub: 'Cakung DC-01',
                kat: ['Kamera & Optik', 'purple', 'camera'],
                sku: '[DSLR Pro] - SONY / Cam 6000 / Canon EG / Mark II',
                vol: '320 Unit',
                vn: ['100% Terverifikasi', 'text-emerald-700'],
                val: 'Rp 1,44 M',
                vl: 'Rp 4,5 M/Unit Avg',
                rs: '99,4% SPO',
                st: ['Sesuai Standar', 'green']
            },
            {
                kode: 'REP-2025-Q3-B4',
                hub: 'Rungkut DC-02',
                kat: ['Gadget & Wearables', 'blue', 'watch'],
                sku: '[XL] - WTC-AR40 / Watch 4th Gen Series',
                vol: '410 Unit',
                vn: ['Selisih Opname -3 Unit', 'text-red-600'],
                val: 'Rp 1,23 M',
                vl: 'Akurasi Terkoreksi',
                rs: '97,1% SPO',
                st: ['Audit Selisih', 'red']
            },
            {
                kode: 'REP-2025-Q3-C2',
                hub: 'Cakung DC-01',
                kat: ['Perangkat Kasir & Scanner QR', 'green', 'scan-barcode'],
                sku: '[SKU HOS-ZR8] / Wireless Bluetooth Scanner',
                vol: '245 Unit',
                vn: ['Buffer Optimal', 'text-emerald-700'],
                val: 'Rp 612,5 Jt',
                vl: 'Logistik Operasional',
                rs: '99,8% SPO',
                st: ['Sesuai Standar', 'green']
            },
            {
                kode: 'REP-2025-Q3-D8',
                hub: 'Gedebage DC-03',
                kat: ['Jaringan & Terminal Transit', 'orange', 'network'],
                sku: '[SWI HET-CB2] / Cisco Switch PoE+ 24 Port',
                vol: '95 Unit',
                vn: ['Alokasi Infrastruktur', 'text-emerald-700'],
                val: 'Rp 855 Jt',
                vl: 'Capex Terdeklarasi',
                rs: '100% SPO',
                st: ['Sesuai Standar', 'green']
            },
            {
                kode: 'REP-2025-Q3-E5',
                hub: 'Belawan DC-04',
                kat: ['Printer Thermal Struk & Barcode', 'pink', 'printer'],
                sku: '[SEU PRN-TM TM-T82X SerIV]',
                vol: '170 Unit',
                vn: ['Permintaan Direct', 'text-emerald-700'],
                val: 'Rp 712,5 Jt',
                vl: 'Pengeluaran Semester 1',
                rs: '96,5% SPO',
                st: ['Sesuai Standar', 'green']
            }
        ];

        /* =========================================
           ELEMEN FILTER DAN STATE
        ========================================= */

        const fk = $('#fKat');
        const fh = $('#fHub');
        const fs = $('#fStatus');

        const rows = $('#rows');
        const pagination = $('#pagination');
        const advancedFilters = $('#advancedFilters');

        let currentPage = 1;
        const perPage = 5;
        let mutasiChart = null;

        /* =========================================
           NOTIFIKASI TOAST
        ========================================= */

        window.toast = function(message, type = 'success') {
            const el = document.createElement('div');

            el.className = `
            max-w-[320px] rounded-md px-3 py-2
            text-[11px] font-medium text-white shadow-lg
            ${type === 'warn' ? 'bg-amber-600' : 'bg-emerald-600'}
        `;

            el.textContent = message;
            $('#toasts').appendChild(el);

            setTimeout(() => el.remove(), 3200);
        };

        /* =========================================
           RENDER KARTU STATISTIK
        ========================================= */

        $('#stats').innerHTML = STATS.map(s => `
        <article class="flex min-h-[112px] items-start justify-between gap-2 rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
            <div class="min-w-0">
                <p class="text-[9.5px] font-semibold uppercase tracking-wide ${
                    s.red ? 'text-red-600' : 'text-slate-500'
                }">
                    ${s.l}
                </p>

                <p class="mt-1.5 flex flex-wrap items-baseline gap-x-1.5 gap-y-1 text-[24px] font-bold leading-tight tracking-tight ${
                    s.red ? 'text-red-600' : 'text-slate-800'
                }">
                    ${s.v}
                    ${pill(s.b[0], s.b[1], true)}
                </p>

                <p class="mt-2.5 flex items-start gap-1.5 text-[10.5px] ${
                    s.red ? 'font-semibold text-red-600' : 'text-slate-500'
                }">
                    ${s.si ? ic(s.si, 'mt-px h-3.5 w-3.5 text-emerald-600') : ''}
                    <span>${s.s}</span>
                </p>
            </div>

            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md ${s.c}">
                ${ic(s.i, 'h-4 w-4')}
            </span>
        </article>
    `).join('');

        /* =========================================
           RENDER DISTRIBUSI HUB
        ========================================= */

        $('#hubs').innerHTML = HUBS.map(h => `
        <div>
            <div class="flex items-baseline justify-between gap-2">
                <p class="text-[12px] font-semibold text-slate-800">
                    ${h[0]}
                    <span class="text-[10.5px] font-normal text-slate-500">(${h[1]})</span>
                </p>

                <b class="text-[12px] ${h[6]}">${h[2]}%</b>
            </div>

            <div class="my-1.5 h-1.5 rounded bg-blue-100">
                <div class="h-full rounded ${h[5]}" style="width:${h[2]}%"></div>
            </div>

            <div class="flex items-center justify-between text-[10.5px]">
                <span class="text-slate-600">${h[3]}</span>
                <span class="font-semibold ${h[7]}">SLA: ${h[4]}</span>
            </div>
        </div>
    `).join('');

        /* =========================================
           ISI PILIHAN FILTER
        ========================================= */

        [...new Set(R.map(r => r.kat[0]))].forEach(value => {
            fk.add(new Option(value, value));
        });

        [...new Set(R.map(r => r.hub))].forEach(value => {
            fh.add(new Option(value, value));
        });

        /* =========================================
           RENDER TABEL
        ========================================= */

        function renderTable() {
            rows.innerHTML = R.map((r, index) => `
            <tr
                data-index="${index}"
                data-kat="${r.kat[0]}"
                data-hub="${r.hub}"
                data-status="${r.st[0]}"
                class="align-top hover:bg-slate-50/70">

                <td class="px-3 py-3">
                    <span class="font-bold text-blue-700">${r.kode}</span>
                    <p class="mt-0.5 text-[10.5px] text-slate-500">${r.hub}</p>
                </td>

                <td class="px-3 py-3">
                    <div class="flex items-start gap-2">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md ${T[r.kat[1]]}">
                            ${ic(r.kat[2], 'h-4 w-4')}
                        </span>

                        <div class="min-w-0">
                            <p class="font-semibold text-slate-800">${r.kat[0]}</p>
                            <p class="mt-0.5 break-words text-[10.5px] text-slate-500">${r.sku}</p>
                        </div>
                    </div>
                </td>

                <td class="px-3 py-3">
                    <p class="font-semibold text-slate-800">${r.vol}</p>
                    <p class="mt-0.5 text-[10.5px] ${r.vn[1]}">${r.vn[0]}</p>
                </td>

                <td class="px-3 py-3">
                    <p class="font-semibold text-slate-800">${r.val}</p>
                    <p class="mt-0.5 text-[10.5px] text-slate-500">${r.vl}</p>
                </td>

                <td class="px-3 py-3">
                    ${pill(r.rs, 'green')}
                </td>

                <td class="px-3 py-3">
                    ${pill('● ' + r.st[0], r.st[1])}
                </td>
            </tr>
        `).join('');
        }

        /* =========================================
           CHIP FILTER
        ========================================= */

        let chips = [];

        function updateChips() {
            chips = [];

            if (fk.value) chips.push(['Kategori:', fk.value, 'kategori']);
            if (fh.value) chips.push(['Hub:', fh.value, 'hub']);
            if (fs.value) chips.push(['Status:', fs.value, 'status']);

            $('#chips').innerHTML = chips.map((chip, index) => `
            <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1.5 text-blue-700">
                <span><b>${chip[0]}</b> ${chip[1]}</span>

                <button
                    type="button"
                    data-chip="${index}"
                    class="rounded-full hover:text-blue-900"
                    aria-label="Hapus filter ${chip[0]}">
                    ${ic('x', 'h-3 w-3')}
                </button>
            </span>
        `).join('') || '<span class="text-slate-500">Tidak ada filter aktif.</span>';

            $('#chips').querySelectorAll('[data-chip]').forEach(button => {
                button.addEventListener('click', () => {
                    const chip = chips[Number(button.dataset.chip)];

                    if (chip[2] === 'kategori') fk.value = '';
                    if (chip[2] === 'hub') fh.value = '';
                    if (chip[2] === 'status') fs.value = '';

                    currentPage = 1;
                    applyFilters();
                });
            });

            refreshIcons();
        }

        /* =========================================
           FILTER DATA DAN PAGINATION
        ========================================= */

        function getFilteredRows() {
            return R.filter(r => {
                const categoryMatch = !fk.value || r.kat[0] === fk.value;
                const hubMatch = !fh.value || r.hub === fh.value;
                const statusMatch = !fs.value || r.st[0] === fs.value;

                return categoryMatch && hubMatch && statusMatch;
            });
        }

        function renderPagination(total) {
            const totalPages = Math.ceil(total / perPage);

            if (totalPages <= 1) {
                pagination.innerHTML = '';
                return;
            }

            let html = `
            <button type="button" data-page="${currentPage - 1}"
                class="pagination-btn border border-slate-200"
                ${currentPage === 1 ? 'disabled' : ''}>
                ‹
            </button>
        `;

            for (let page = 1; page <= totalPages; page++) {
                html += `
                <button type="button" data-page="${page}"
                    class="pagination-btn ${currentPage === page ? 'active' : ''}">
                    ${page}
                </button>
            `;
            }

            html += `
            <button type="button" data-page="${currentPage + 1}"
                class="pagination-btn border border-slate-200"
                ${currentPage === totalPages ? 'disabled' : ''}>
                ›
            </button>
        `;

            pagination.innerHTML = html;

            pagination.querySelectorAll('[data-page]').forEach(button => {
                button.addEventListener('click', () => {
                    const page = Number(button.dataset.page);

                    if (page < 1 || page > totalPages) return;

                    currentPage = page;
                    applyFilters();
                });
            });
        }

        function applyFilters() {
            const filtered = getFilteredRows();
            const total = filtered.length;
            const totalPages = Math.max(1, Math.ceil(total / perPage));

            if (currentPage > totalPages) {
                currentPage = totalPages;
            }

            const start = (currentPage - 1) * perPage;
            const end = Math.min(start + perPage, total);

            document.querySelectorAll('#rows tr').forEach(row => {
                row.hidden = true;
            });

            filtered.slice(start, end).forEach(r => {
                const originalIndex = R.indexOf(r);
                const row = rows.querySelector(`[data-index="${originalIndex}"]`);

                if (row) row.hidden = false;
            });

            $('#noRow').hidden = total !== 0;

            $('#cnt').textContent = total === 0 ?
                'Tidak ada laporan' :
                `Menampilkan ${start + 1} - ${end} dari ${total} laporan`;

            renderPagination(total);
            updateChips();
        }

        function resetFilters() {
            fk.value = '';
            fh.value = '';
            fs.value = '';

            currentPage = 1;
            applyFilters();

            toast('Semua filter berhasil direset.');
        }

        /* =========================================
           TOMBOL FILTER
        ========================================= */

        $('#advancedFilterBtn').addEventListener('click', () => {
            advancedFilters.hidden = !advancedFilters.hidden;
            refreshIcons();
        });

        $('#closeAdvancedFilter').addEventListener('click', () => {
            advancedFilters.hidden = true;
        });

        $('#applyAdvancedFilter').addEventListener('click', () => {
            currentPage = 1;
            applyFilters();

            advancedFilters.hidden = true;
            toast('Filter berhasil diterapkan.');
        });

        $('#clearAdvancedFilter').addEventListener('click', resetFilters);
        $('#resetChips').addEventListener('click', resetFilters);

        /* =========================================
           EKSPOR CSV
        ========================================= */

        $('#exportCsv').addEventListener('click', () => {
            const filtered = getFilteredRows();

            if (filtered.length === 0) {
                toast('Tidak ada data untuk diunduh.', 'warn');
                return;
            }

            const headers = [
                'Kode Laporan',
                'Hub Regional',
                'Kategori',
                'SKU Induk',
                'Volume Mutasi',
                'Keterangan Volume',
                'Nilai Valuasi',
                'Keterangan Valuasi',
                'Rasio Persetujuan',
                'Status Kepatuhan'
            ];

            const csvRows = filtered.map(r => [
                r.kode,
                r.hub,
                r.kat[0],
                r.sku,
                r.vol,
                r.vn[0],
                r.val,
                r.vl,
                r.rs,
                r.st[0]
            ]);

            const escapeCsv = value =>
                '"' + String(value ?? '').replace(/"/g, '""') + '"';

            const csvContent = [
                headers,
                ...csvRows
            ].map(row => row.map(escapeCsv).join(';')).join('\r\n');

            const blob = new Blob(
                ['\uFEFF' + csvContent], {
                    type: 'text/csv;charset=utf-8;'
                }
            );

            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');

            link.href = url;
            link.download = 'laporan-inventaris-hr.csv';

            document.body.appendChild(link);
            link.click();
            link.remove();

            URL.revokeObjectURL(url);

            toast('Rekap CSV berhasil diunduh.');
        });

        /* =========================================
           CETAK PDF
        ========================================= */

        $('#printReport').addEventListener('click', () => {
            window.print();
        });

        /* =========================================
           GRAFIK MUTASI
        ========================================= */

        const chartData = {
            '7': {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                inbound: [920, 1150, 980, 1220, 1100, 1448, 1200],
                outbound: [800, 950, 880, 1020, 980, 1180, 1040]
            },

            '30': {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                inbound: [6200, 7100, 6800, 8420],
                outbound: [5100, 5900, 6200, 6850]
            },

            'month': {
                labels: ['Maret 1', 'Maret 2', 'Maret 3', 'Maret 4'],
                inbound: [5800, 6500, 7300, 8420],
                outbound: [4800, 5500, 6100, 6850]
            }
        };

        function createChart(range = '7') {
            if (!window.Chart) {
                $('#mutasiChart').parentElement.innerHTML = `
                <p class="flex h-full items-center justify-center text-[11px] text-slate-400">
                    Grafik tidak dapat dimuat. Periksa koneksi jaringan.
                </p>
            `;
                return;
            }

            const data = chartData[range];

            if (mutasiChart) {
                mutasiChart.data.labels = data.labels;
                mutasiChart.data.datasets[0].data = data.inbound;
                mutasiChart.data.datasets[1].data = data.outbound;
                mutasiChart.update();
                return;
            }

            Chart.defaults.font.family = 'Inter, sans-serif';
            Chart.defaults.font.size = 11;
            Chart.defaults.color = '#64748b';

            mutasiChart = new Chart($('#mutasiChart'), {
                type: 'line',

                data: {
                    labels: data.labels,

                    datasets: [{
                            label: 'Inbound (Masuk)',
                            data: data.inbound,
                            borderColor: '#2563EB',
                            backgroundColor: 'rgba(37,99,235,.1)',
                            fill: true,
                            tension: .4,
                            pointRadius: 3,
                            pointBackgroundColor: '#2563EB',
                            borderWidth: 2
                        },
                        {
                            label: 'Outbound (Keluar)',
                            data: data.outbound,
                            borderColor: '#9CA3AF',
                            backgroundColor: 'rgba(156,163,175,.05)',
                            borderDash: [5, 5],
                            fill: true,
                            tension: .4,
                            pointRadius: 3,
                            pointBackgroundColor: '#9CA3AF',
                            borderWidth: 2
                        }
                    ]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    interaction: {
                        mode: 'index',
                        intersect: false
                    },

                    plugins: {
                        legend: {
                            display: false
                        },

                        tooltip: {
                            backgroundColor: 'rgba(15,23,42,.9)',
                            padding: 10
                        }
                    },

                    scales: {
                        y: {
                            beginAtZero: false,

                            ticks: {
                                callback: value =>
                                    value >= 1000 ?
                                    (value / 1000) + 'k' :
                                    value
                            },

                            grid: {
                                color: '#f1f5f9'
                            },

                            border: {
                                display: false
                            }
                        },

                        x: {
                            grid: {
                                display: false
                            },

                            border: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        document.querySelectorAll('#range button').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('#range button').forEach(item => {
                    item.className =
                        'rounded-md bg-slate-100 px-3 py-1.5 text-slate-600 hover:bg-slate-200';
                });

                button.className =
                    'rounded-md bg-blue-600 px-3 py-1.5 text-white';

                createChart(button.dataset.range);
            });
        });

        /* =========================================
           INISIALISASI
        ========================================= */

        renderTable();
        applyFilters();
        createChart('7');
        refreshIcons();

    });
</script>

@endsection
