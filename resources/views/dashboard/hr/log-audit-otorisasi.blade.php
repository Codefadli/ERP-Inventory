@extends('layouts.app')

@section('title', 'Log Audit & Otorisasi | ASTRO Inventory')

@section('styles')
<style>
    .audit-page {
        font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        color: #1f2937;
        overflow-x: hidden;
    }

    .audit-page * {
        box-sizing: border-box;
    }

    .audit-page .metric-card {
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .audit-page .metric-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(15, 23, 42, .09);
    }

    .audit-page .table-row {
        transition: background .2s ease;
    }

    .audit-page .table-row:hover {
        background: #f8fafc;
    }

    .audit-page .btn-primary {
        transition: all .2s ease;
    }

    .audit-page .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(37, 99, 235, .2);
    }

    .audit-page .hash-display {
        font-family: "Courier New", monospace;
        overflow-wrap: anywhere;
    }

    .audit-page .network-node {
        transition: transform .2s ease;
    }

    .audit-page .network-node:hover {
        transform: scale(1.15);
    }

    .audit-page .network-line {
        stroke-dasharray: 1000;
        stroke-dashoffset: 1000;
        animation: auditDash 2s linear forwards;
    }

    @keyframes auditDash {
        to {
            stroke-dashoffset: 0;
        }
    }

    @keyframes auditFade {
        from {
            opacity: 0;
            transform: translateY(12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .audit-page .animate-audit {
        animation: auditFade .45s ease-out both;
    }

    .audit-page .badge-glow {
        animation: auditPulse 2s ease-in-out infinite;
    }

    @keyframes auditPulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: .7;
        }
    }

    .audit-page .toast-message {
        transform: translateY(20px);
        opacity: 0;
        pointer-events: none;
        transition: all .25s ease;
    }

    .audit-page .toast-message.show {
        transform: translateY(0);
        opacity: 1;
    }

    @media (max-width: 640px) {
        .audit-page .page-heading {
            font-size: 1.25rem;
        }
    }

    @media print {

        .audit-page .no-print,
        .audit-page aside,
        .audit-page header {
            display: none !important;
        }

        .audit-page main {
            padding: 0 !important;
        }

        .audit-page .metric-card {
            break-inside: avoid;
        }
    }

    @media (prefers-reduced-motion: reduce) {

        .audit-page *,
        .audit-page *::before,
        .audit-page *::after {
            animation-duration: .01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: .01ms !important;
        }
    }
</style>
@endsection

@section('content')
<div class="audit-page flex min-h-screen bg-slate-50">

    {{-- Shared Sidebar --}}
    @include('components.sidebar')

    <div class="min-w-0 flex-1">

        {{-- Shared Navbar --}}
        @include('components.navbar')

        <main class="p-4 lg:p-6 overflow-x-hidden">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-4 overflow-x-auto whitespace-nowrap">
                <a href="#" class="hover:text-blue-600">Beranda</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span>Manajemen & Laporan</span>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="font-medium text-gray-900">Log Audit & Otorisasi</span>
            </div>

            {{-- Page Header --}}
            <section class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-6 animate-audit">
                <div class="flex-1">
                    <div class="flex items-center gap-2 flex-wrap mb-2">
                        <h1 class="page-heading text-xl lg:text-2xl font-bold text-gray-900">
                            Log Audit, Integritas Kriptografis & Otorisasi
                        </h1>

                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fas fa-shield-alt mr-1"></i>
                            Monitoring Audit
                        </span>

                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fas fa-fingerprint mr-1"></i>
                            SHA-256
                        </span>
                    </div>

                    <p class="text-sm text-gray-600 max-w-4xl">
                        Halaman ini digunakan untuk memantau rekam jejak aktivitas pengguna,
                        perubahan data inventaris, persetujuan transaksi, serta aktivitas
                        otorisasi dalam sistem.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2 no-print">
                    <button type="button" id="exportAudit"
                        class="btn-primary px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2 text-sm">
                        <i class="fas fa-download"></i>
                        <span>Ekspor Laporan Audit</span>
                    </button>

                    <button type="button" id="printAudit"
                        class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 flex items-center gap-2 text-sm">
                        <i class="fas fa-print"></i>
                        <span>Cetak</span>
                    </button>
                </div>
            </section>

            {{-- Demo Notice --}}
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mb-6 flex items-start gap-3">
                <i class="fas fa-info-circle text-amber-600 mt-0.5"></i>
                <p class="text-xs text-amber-800">
                    <strong>Informasi:</strong> Data pada halaman ini merupakan data simulasi
                    untuk tampilan antarmuka. Data belum diambil dari database audit atau
                    sistem ledger sebenarnya.
                </p>
            </div>

            {{-- Status Cards --}}
            <section class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm animate-audit">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <div class="w-9 h-9 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">Status Audit</span>
                        </div>
                        <span class="badge-glow bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">
                            AKTIF
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-3">Status simulasi monitoring audit</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm animate-audit">
                    <div class="flex items-center gap-2">
                        <div class="w-9 h-9 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-line text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">
                                <span class="count-up" data-target="4">0</span>
                                <span class="text-green-600 text-xs ml-1">+14,2%</span>
                            </p>
                            <p class="text-xs text-gray-500">Aktivitas bulan ini</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm animate-audit">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <div class="w-9 h-9 bg-pink-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-pink-600"></i>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">
                                <span class="count-up" data-target="2">0</span>
                            </span>
                        </div>
                        <span class="bg-pink-100 text-pink-700 px-2 py-1 rounded text-xs font-semibold">
                            Perlu Review
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-3">Aktivitas yang perlu diperiksa</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm animate-audit">
                    <div class="flex items-center gap-2">
                        <div class="w-9 h-9 bg-cyan-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-double text-cyan-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Zero Conflict</p>
                            <p class="text-xs text-gray-500">Status simulasi: OK</p>
                        </div>
                    </div>
                </div>

            </section>

            {{-- Metric Cards --}}
            <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

                <div class="metric-card bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mb-3">
                        <i class="fas fa-link text-green-600"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900">
                        <span class="count-up" data-target="100">0</span>%
                    </h3>
                    <p class="text-sm text-gray-600 mb-2">Integritas Rantai Audit</p>
                    <p class="text-xs text-gray-500">Indikator integritas data contoh</p>
                </div>

                <div class="metric-card bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-3">
                        <i class="fas fa-database text-blue-600"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900">
                        <span class="count-up" data-target="24810">0</span>
                    </h3>
                    <p class="text-sm text-gray-600 mb-2">Total Entri Audit</p>
                    <p class="text-xs text-gray-500">Angka simulasi jumlah rekaman</p>
                </div>

                <div class="metric-card bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mb-3">
                        <i class="fas fa-exclamation-circle text-orange-600"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900">
                        <span class="count-up" data-target="4">0</span>
                    </h3>
                    <p class="text-sm text-gray-600 mb-2">Intervensi / Deviasi</p>
                    <p class="text-xs text-gray-500">2 deviasi opname dan 2 mutasi ditolak</p>
                </div>

                <div class="metric-card bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mb-3">
                        <i class="fas fa-user-shield text-purple-600"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900">
                        <span class="count-up" data-target="100">0</span>%
                    </h3>
                    <p class="text-sm text-gray-600 mb-2">Kepatuhan SoD</p>
                    <p class="text-xs text-gray-500">Indikator pemisahan tugas pengguna</p>
                </div>

            </section>

            {{-- Merkle Root --}}
            <section class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg p-4 mb-6 shadow-lg">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">

                    <div class="flex items-start gap-3 flex-1 min-w-0">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-lock text-white"></i>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap mb-2">
                                <p class="text-white font-bold text-sm">
                                    CONTOH HASH AUDIT (#BLK-202505-09)
                                </p>
                                <span class="bg-green-500 text-white px-2 py-1 rounded text-xs font-semibold">
                                    Contoh SHA-256
                                </span>
                            </div>

                            <div id="auditHash"
                                class="hash-display bg-white/10 rounded px-3 py-2 text-xs text-white break-all">
                                e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 no-print">
                        <button type="button" id="copyHash"
                            class="btn-primary bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg flex items-center gap-2 text-sm">
                            <i class="fas fa-copy"></i>
                            <span>Salin Hash</span>
                        </button>
                    </div>

                </div>
            </section>

            {{-- Filter Section --}}
            <section class="bg-white border border-gray-200 rounded-lg p-4 mb-6 shadow-sm">

                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

                    <div class="flex flex-wrap items-center gap-2">

                        <select id="filterHub"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Hub</option>
                            <option value="DC-01">Cakung DC-01</option>
                            <option value="DC-02">Rungkut DC-02</option>
                            <option value="DC-03">Gedebage DC-03</option>
                            <option value="DC-04">Belawan DC-04</option>
                        </select>

                        <select id="filterType"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Tipe Event</option>
                            <option value="approval">Approval</option>
                            <option value="discrepancy">Discrepancy</option>
                            <option value="master">Master Data</option>
                            <option value="rejection">Penolakan</option>
                            <option value="system">Sistem</option>
                        </select>

                        <button type="button" data-range="today"
                            class="range-button px-3 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200">
                            Hari Ini
                        </button>

                        <button type="button" data-range="7"
                            class="range-button px-3 py-2 bg-blue-600 text-white rounded-lg text-sm">
                            7 Hari
                        </button>

                        <button type="button" data-range="30"
                            class="range-button px-3 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200">
                            30 Hari
                        </button>

                    </div>

                    <div class="flex flex-wrap gap-2 no-print">
                        <button type="button" id="resetFilter"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">
                            <i class="fas fa-sync-alt mr-1"></i>
                            Reset Filter
                        </button>

                        <button type="button" id="refreshAudit"
                            class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                            <i class="fas fa-redo mr-1"></i>
                            Segarkan
                        </button>
                    </div>

                </div>

                <div class="flex flex-wrap items-center gap-2 mt-4">
                    <span class="text-xs text-gray-500">Filter aktif:</span>

                    <span id="activeFilter"
                        class="bg-blue-100 text-blue-700 px-3 py-1.5 rounded-full text-xs">
                        7 Hari Terakhir • Semua Hub • Semua Event
                    </span>
                </div>

            </section>

            {{-- Summary --}}
            <section class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3">

                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-book text-blue-600"></i>
                        </div>

                        <div>
                            <p class="font-semibold text-blue-900 text-sm">
                                Rincian Log Transaksi & Aktivitas Pengguna
                            </p>
                            <p class="text-xs text-blue-700">
                                Daftar contoh rekaman aktivitas audit sistem inventaris.
                            </p>
                        </div>
                    </div>

                    <p class="text-sm text-blue-700">
                        Menampilkan
                        <span id="visibleCount" class="font-bold">5</span>
                        dari 5 contoh log
                    </p>

                </div>
            </section>

            {{-- Audit Table --}}
            <section class="bg-white border border-gray-200 rounded-lg p-4 lg:p-6 mb-6 shadow-sm">

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                    <div>
                        <h2 class="font-bold text-gray-900 text-lg">Riwayat Log Audit</h2>
                        <p class="text-xs text-gray-500 mt-1">
                            Detail waktu, identitas event, pelaku, dan jenis operasi.
                        </p>
                    </div>

                    <span class="text-xs text-gray-500">
                        <i class="fas fa-clock mr-1"></i>
                        Zona waktu: WIB
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[1000px]">
                        <thead>
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Timestamp (WIB)
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Event ID & Hash
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Pelaku / Aktor
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Tipe Operasi
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Hub
                                </th>
                            </tr>
                        </thead>

                        <tbody id="auditTableBody">

                            <tr class="table-row border-b border-gray-100"
                                data-hub="DC-01" data-type="approval">
                                <td class="px-4 py-4">
                                    <p class="text-sm font-semibold text-gray-900">15 Mei 2025, 14:32:18</p>
                                    <p class="text-xs text-gray-500">10 menit yang lalu</p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm font-semibold text-blue-600">EVT-2025-098412</p>
                                    <p class="text-xs text-gray-500 font-mono">7e8d5ff01...</p>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-pink-500 rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0">
                                            SR
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">Siti Rahmawati</p>
                                            <p class="text-xs text-gray-500">HR Lead Approver</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Approval Mutasi Antar-Hub
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700">DC-01</td>
                            </tr>

                            <tr class="table-row border-b border-gray-100"
                                data-hub="DC-02" data-type="discrepancy">
                                <td class="px-4 py-4">
                                    <p class="text-sm font-semibold text-gray-900">15 Mei 2025, 13:45:02</p>
                                    <p class="text-xs text-gray-500">1 jam yang lalu</p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm font-semibold text-blue-600">EVT-2025-098408</p>
                                    <p class="text-xs text-gray-500 font-mono">19ac32ff09...</p>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0">
                                            DA
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">Dewi Anggraini</p>
                                            <p class="text-xs text-gray-500">Auditor Internal Logistik</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Selisih Opname
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700">DC-02</td>
                            </tr>

                            <tr class="table-row border-b border-gray-100"
                                data-hub="DC-03" data-type="master">
                                <td class="px-4 py-4">
                                    <p class="text-sm font-semibold text-gray-900">15 Mei 2025, 12:11:40</p>
                                    <p class="text-xs text-gray-500">2 jam yang lalu</p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm font-semibold text-blue-600">EVT-2025-098389</p>
                                    <p class="text-xs text-gray-500 font-mono">cc9d216de8...</p>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0">
                                            BS
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">Budi Santoso</p>
                                            <p class="text-xs text-gray-500">Admin Utama</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Penyesuaian Master Bin
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700">DC-03</td>
                            </tr>

                            <tr class="table-row border-b border-gray-100"
                                data-hub="DC-01" data-type="rejection">
                                <td class="px-4 py-4">
                                    <p class="text-sm font-semibold text-gray-900">15 Mei 2025, 10:20:15</p>
                                    <p class="text-xs text-gray-500">4 jam yang lalu</p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm font-semibold text-blue-600">EVT-2025-098381</p>
                                    <p class="text-xs text-gray-500 font-mono">33e1150c89...</p>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-pink-500 rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0">
                                            SR
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">Siti Rahmawati</p>
                                            <p class="text-xs text-gray-500">HR Lead Approver</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Penolakan Mutasi Stok
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700">DC-01</td>
                            </tr>

                            <tr class="table-row"
                                data-hub="DC-04" data-type="system">
                                <td class="px-4 py-4">
                                    <p class="text-sm font-semibold text-gray-900">15 Mei 2025, 08:00:00</p>
                                    <p class="text-xs text-gray-500">6 jam yang lalu</p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm font-semibold text-blue-600">EVT-2025-098350</p>
                                    <p class="text-xs text-gray-500 font-mono">a641f92c64...</p>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gray-500 rounded-full flex items-center justify-center text-white flex-shrink-0">
                                            <i class="fas fa-robot"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">Sistem Otomatis</p>
                                            <p class="text-xs text-gray-500">ASTRO-CORE-AUTORUN</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Snapshot Integritas Harian
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700">DC-04</td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div id="emptyAudit" class="hidden text-center py-10">
                    <i class="fas fa-search text-3xl text-gray-300 mb-3"></i>
                    <p class="text-sm font-semibold text-gray-600">Data tidak ditemukan</p>
                    <p class="text-xs text-gray-500 mt-1">Silakan ubah filter pencarian.</p>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-5 pt-5 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Menampilkan <span id="tableCount" class="font-semibold">5</span> data contoh
                    </p>
                    <p class="text-xs text-gray-500">
                        Halaman 1 dari 1
                    </p>
                </div>

            </section>

            {{-- Bottom Cards --}}
            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

                {{-- SoD Matrix --}}
                <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <h3 class="font-bold text-gray-900">Matriks Segregation of Duties</h3>
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold">
                            SoD
                        </span>
                    </div>

                    <p class="text-sm text-gray-600 mb-4">
                        Pemisahan tugas dilakukan agar satu pengguna tidak memiliki
                        seluruh kewenangan dalam satu proses transaksi.
                    </p>

                    <div class="space-y-3">
                        <div class="flex items-start gap-2 text-sm">
                            <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                            <span class="text-gray-700">Petugas opname berbeda dengan approver HR.</span>
                        </div>

                        <div class="flex items-start gap-2 text-sm">
                            <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                            <span class="text-gray-700">Petugas opname berbeda dengan pengelola master SKU.</span>
                        </div>

                        <div class="flex items-start gap-2 text-sm">
                            <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                            <span class="text-gray-700">Persetujuan transaksi dilakukan sesuai hak akses.</span>
                        </div>
                    </div>
                </div>

                {{-- Network Diagram --}}
                <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <h3 class="font-bold text-gray-900">Distribusi Node Log</h3>
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold">
                            Simulasi
                        </span>
                    </div>

                    <p class="text-sm text-gray-600 mb-3">
                        Ilustrasi hubungan antara node utama dan node pendukung.
                    </p>

                    <svg class="w-full h-40" viewBox="0 0 200 120" role="img" aria-label="Diagram jaringan node audit">
                        <line x1="100" y1="60" x2="100" y2="20" class="network-line stroke-blue-400" stroke-width="2" />
                        <line x1="100" y1="60" x2="160" y2="40" class="network-line stroke-blue-400" stroke-width="2" />
                        <line x1="100" y1="60" x2="160" y2="80" class="network-line stroke-blue-400" stroke-width="2" />
                        <line x1="100" y1="60" x2="100" y2="100" class="network-line stroke-blue-400" stroke-width="2" />
                        <line x1="100" y1="60" x2="40" y2="80" class="network-line stroke-blue-400" stroke-width="2" />
                        <line x1="100" y1="60" x2="40" y2="40" class="network-line stroke-blue-400" stroke-width="2" />

                        <circle cx="100" cy="60" r="12" class="network-node fill-blue-600" />
                        <circle cx="100" cy="20" r="8" class="network-node fill-green-500" />
                        <circle cx="160" cy="40" r="8" class="network-node fill-green-500" />
                        <circle cx="160" cy="80" r="8" class="network-node fill-green-500" />
                        <circle cx="100" cy="100" r="8" class="network-node fill-green-500" />
                        <circle cx="40" cy="80" r="8" class="network-node fill-green-500" />
                        <circle cx="40" cy="40" r="8" class="network-node fill-green-500" />
                    </svg>

                    <div class="flex flex-wrap justify-center gap-4 text-xs text-gray-500">
                        <span><i class="fas fa-circle text-blue-600 mr-1"></i>Node Utama</span>
                        <span><i class="fas fa-circle text-green-500 mr-1"></i>Node Pendukung</span>
                    </div>
                </div>

                {{-- SHA Test --}}
                <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
                    <h3 class="font-bold text-gray-900 mb-3">Uji Mandiri SHA-256</h3>

                    <p class="text-sm text-gray-600 mb-4">
                        Masukkan teks untuk menghasilkan hash SHA-256 menggunakan browser.
                        Fitur ini merupakan simulasi, bukan verifikasi ledger database.
                    </p>

                    <input type="text" id="hashInput"
                        placeholder="Masukkan teks untuk diuji..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 mb-3">

                    <button type="button" id="testHash"
                        class="btn-primary w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 flex items-center justify-center gap-2 text-sm">
                        <i class="fas fa-fingerprint"></i>
                        <span>Hitung Hash SHA-256</span>
                    </button>

                    <div id="hashResult" class="hidden mt-4">
                        <p class="text-xs font-semibold text-gray-700 mb-1">Hasil Hash:</p>
                        <div id="hashOutput"
                            class="bg-gray-50 border border-gray-200 rounded-lg p-3 text-xs font-mono break-all text-gray-700">
                        </div>
                    </div>
                </div>

            </section>

            {{-- Footer --}}
            <section class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                <div>
                    <p class="text-sm font-semibold text-gray-800">Log Audit & Otorisasi</p>
                    <p class="text-xs text-gray-500 mt-1">
                        Monitoring aktivitas dan pemisahan hak akses pengguna.
                    </p>
                </div>

                <p class="text-sm text-gray-600">
                    <i class="fas fa-shield-alt text-blue-600 mr-1"></i>
                    Modul khusus HR
                </p>
            </section>

        </main>
    </div>

    {{-- Toast --}}
    <div id="auditToast"
        class="toast-message fixed bottom-5 right-5 z-[100] bg-gray-900 text-white px-5 py-3 rounded-lg shadow-xl">
        <div class="flex items-center gap-2">
            <i class="fas fa-check-circle text-green-400"></i>
            <span id="auditToastText" class="text-sm">Berhasil.</span>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    (() => {
        'use strict';

        const page = document.querySelector('.audit-page');
        if (!page) return;

        const $ = (selector) => page.querySelector(selector);
        const $$ = (selector) => page.querySelectorAll(selector);

        let toastTimer;

        // Toast notification
        function showToast(message) {
            const toast = $('#auditToast');
            const text = $('#auditToastText');

            if (!toast || !text) return;

            text.textContent = message;
            toast.classList.add('show');

            clearTimeout(toastTimer);

            toastTimer = setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // Count up animation
        function animateCounters() {
            $$('.count-up').forEach((counter) => {
                const target = Number(counter.dataset.target || 0);
                const duration = 1200;
                const startTime = performance.now();

                function update(now) {
                    const progress = Math.min((now - startTime) / duration, 1);
                    const current = Math.floor(target * progress);

                    counter.textContent = current.toLocaleString('id-ID');

                    if (progress < 1) {
                        requestAnimationFrame(update);
                    }
                }

                requestAnimationFrame(update);
            });
        }

        // Copy hash
        $('#copyHash')?.addEventListener('click', async () => {
            const hash = $('#auditHash')?.textContent.trim();

            if (!hash) return;

            try {
                await navigator.clipboard.writeText(hash);
                showToast('Hash berhasil disalin.');
            } catch (error) {
                const temp = document.createElement('textarea');
                temp.value = hash;
                document.body.appendChild(temp);
                temp.select();

                const copied = document.execCommand('copy');
                temp.remove();

                showToast(copied ? 'Hash berhasil disalin.' : 'Gagal menyalin hash.');
            }
        });

        // Filter audit table
        function applyFilters() {
            const hub = $('#filterHub')?.value || '';
            const type = $('#filterType')?.value || '';
            const rows = [...$$('#auditTableBody tr')];

            let visible = 0;

            rows.forEach((row) => {
                const matchesHub = !hub || row.dataset.hub === hub;
                const matchesType = !type || row.dataset.type === type;
                const show = matchesHub && matchesType;

                row.classList.toggle('hidden', !show);

                if (show) visible++;
            });

            $('#visibleCount').textContent = visible;
            $('#tableCount').textContent = visible;
            $('#emptyAudit').classList.toggle('hidden', visible !== 0);

            const hubText = hub || 'Semua Hub';
            const typeText = type ?
                $('#filterType').selectedOptions[0].textContent :
                'Semua Event';

            const rangeButton = $('.range-button.bg-blue-600');
            const rangeText = rangeButton ? rangeButton.textContent.trim() : '7 Hari';

            $('#activeFilter').textContent =
                `${rangeText} • ${hubText} • ${typeText}`;
        }

        $('#filterHub')?.addEventListener('change', applyFilters);
        $('#filterType')?.addEventListener('change', applyFilters);

        // Reset filters
        $('#resetFilter')?.addEventListener('click', () => {
            $('#filterHub').value = '';
            $('#filterType').value = '';

            $$('.range-button').forEach((button) => {
                button.classList.remove('bg-blue-600', 'text-white');
                button.classList.add('bg-gray-100', 'text-gray-700');
            });

            const defaultRange = $('[data-range="7"]');

            defaultRange.classList.add('bg-blue-600', 'text-white');
            defaultRange.classList.remove('bg-gray-100', 'text-gray-700');

            applyFilters();
            showToast('Filter berhasil direset.');
        });

        // Range buttons (visual filter period)
        $$('.range-button').forEach((button) => {
            button.addEventListener('click', () => {
                $$('.range-button').forEach((item) => {
                    item.classList.remove('bg-blue-600', 'text-white');
                    item.classList.add('bg-gray-100', 'text-gray-700');
                });

                button.classList.add('bg-blue-600', 'text-white');
                button.classList.remove('bg-gray-100', 'text-gray-700');

                applyFilters();
                showToast('Rentang tampilan diperbarui.');
            });
        });

        // Refresh demo data
        $('#refreshAudit')?.addEventListener('click', () => {
            applyFilters();
            showToast('Tampilan log diperbarui.');
        });

        // Export visible rows to CSV
        $('#exportAudit')?.addEventListener('click', () => {
            const rows = [...$$('#auditTableBody tr')]
                .filter(row => !row.classList.contains('hidden'));

            if (!rows.length) {
                showToast('Tidak ada data untuk diekspor.');
                return;
            }

            const csvRows = [
                ['Timestamp WIB', 'Event ID', 'Hash', 'Pelaku', 'Tipe Operasi', 'Hub']
            ];

            rows.forEach((row) => {
                const cells = row.querySelectorAll('td');

                csvRows.push([
                    cells[0]?.querySelector('p')?.textContent.trim() || '',
                    cells[1]?.querySelector('p')?.textContent.trim() || '',
                    cells[1]?.querySelectorAll('p')[1]?.textContent.trim() || '',
                    cells[2]?.querySelectorAll('p')[0]?.textContent.trim() || '',
                    cells[3]?.textContent.trim() || '',
                    cells[4]?.textContent.trim() || ''
                ]);
            });

            const escapeCSV = value =>
                `"${String(value).replace(/"/g, '""')}"`;

            const csv = csvRows
                .map(row => row.map(escapeCSV).join(','))
                .join('\r\n');

            const blob = new Blob(['\uFEFF' + csv], {
                type: 'text/csv;charset=utf-8;'
            });

            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');

            link.href = url;
            link.download = 'log-audit-otorisasi.csv';

            document.body.appendChild(link);
            link.click();
            link.remove();

            URL.revokeObjectURL(url);

            showToast('File CSV berhasil dibuat.');
        });

        // Print report
        $('#printAudit')?.addEventListener('click', () => {
            window.print();
        });

        // SHA-256 test
        $('#testHash')?.addEventListener('click', async () => {
            const input = $('#hashInput').value.trim();

            if (!input) {
                showToast('Masukkan teks terlebih dahulu.');
                $('#hashInput').focus();
                return;
            }

            if (!window.crypto?.subtle) {
                showToast('SHA-256 memerlukan browser dengan Web Crypto API.');
                return;
            }

            try {
                const encoder = new TextEncoder();
                const data = encoder.encode(input);
                const digest = await crypto.subtle.digest('SHA-256', data);

                const hash = Array.from(new Uint8Array(digest))
                    .map(byte => byte.toString(16).padStart(2, '0'))
                    .join('');

                $('#hashOutput').textContent = hash;
                $('#hashResult').classList.remove('hidden');

                showToast('Hash SHA-256 berhasil dihitung.');
            } catch (error) {
                showToast('Gagal menghitung hash.');
            }
        });

        // Initialize
        animateCounters();
        applyFilters();

    })();
</script>
@endsection
