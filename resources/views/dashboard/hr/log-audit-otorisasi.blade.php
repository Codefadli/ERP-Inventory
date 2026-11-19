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

            {{-- Info Hub --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-6 flex items-start gap-3">
                <i class="fas fa-building text-blue-600 mt-0.5"></i>
                <p class="text-xs text-blue-800">
                    <strong>Hub terpilih:</strong> {{ $hubScopeLabel }}{{ $hubScopeCode ? ' (' . $hubScopeCode . ')' : '' }}
                    &mdash; menampilkan {{ number_format($stats['total']) }} rekaman audit dari tabel <code>audit_logs</code>.
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
                    <p class="text-xs text-gray-500 mt-3">Pencatatan audit berjalan realtime</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm animate-audit">
                    <div class="flex items-center gap-2">
                        <div class="w-9 h-9 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-line text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">
                                <span class="count-up" data-target="{{ $stats['today'] }}">0</span>
                                <span class="text-xs text-gray-500 ml-1">hari ini</span>
                            </p>
                            <p class="text-xs text-gray-500">Aktivitas tercatat</p>
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
                                <span class="count-up" data-target="{{ $stats['insiden'] }}">0</span>
                            </span>
                        </div>
                        <span class="bg-pink-100 text-pink-700 px-2 py-1 rounded text-xs font-semibold">
                            Insiden
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-3">Aktivitas gagal / perlu review</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm animate-audit">
                    <div class="flex items-center gap-2">
                        <div class="w-9 h-9 bg-cyan-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-double text-cyan-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Zero Conflict</p>
                            <p class="text-xs text-gray-500 mt-1">Kepatuhan pemisahan tugas</p>
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
                        <span class="count-up" data-target="{{ $stats['total'] }}">0</span>
                    </h3>
                    <p class="text-sm text-gray-600 mb-2">Total Entri Audit</p>
                    <p class="text-xs text-gray-500">Seluruh rekaman pada hub terpilih</p>
                </div>

                <div class="metric-card bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-3">
                        <i class="fas fa-database text-blue-600"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900">
                        <span class="count-up" data-target="{{ $stats['master'] }}">0</span>
                    </h3>
                    <p class="text-sm text-gray-600 mb-2">Modifikasi Data</p>
                    <p class="text-xs text-gray-500">Create / Update / Delete</p>
                </div>

                <div class="metric-card bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mb-3">
                        <i class="fas fa-exclamation-circle text-orange-600"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900">
                        <span class="count-up" data-target="{{ $stats['kritis'] }}">0</span>
                    </h3>
                    <p class="text-sm text-gray-600 mb-2">Aktivitas Kritis</p>
                    <p class="text-xs text-gray-500">Hapus, nonaktifkan, cabut sesi, failure</p>
                </div>

                <div class="metric-card bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mb-3">
                        <i class="fas fa-user-shield text-purple-600"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900">
                        <span class="count-up" data-target="{{ $stats['akses'] }}">0</span>
                    </h3>
                    <p class="text-sm text-gray-600 mb-2">Akses & Keamanan</p>
                    <p class="text-xs text-gray-500">Login, logout, aktivasi, cabut sesi</p>
                </div>

            </section>

            {{-- Ringkasan Audit --}}
            <section class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg p-4 mb-6 shadow-lg">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">

                    <div class="flex items-start gap-3 flex-1 min-w-0">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-lock text-white"></i>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap mb-2">
                                <p class="text-white font-bold text-sm">
                                    AUDIT TRAIL &bull; {{ $hubScopeLabel }}{{ $hubScopeCode ? ' (' . $hubScopeCode . ')' : '' }}
                                </p>
                                <span class="bg-green-500 text-white px-2 py-1 rounded text-xs font-semibold">
                                    Realtime
                                </span>
                            </div>

                            <div id="auditHash"
                                class="hash-display bg-white/10 rounded px-3 py-2 text-xs text-white break-all">
                                {{ number_format($stats['total']) }} rekaman audit tercatat &bull; {{ $stats['today'] }} hari ini
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 no-print">
                        <button type="button" id="copyHash"
                            class="btn-primary bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg flex items-center gap-2 text-sm">
                            <i class="fas fa-copy"></i>
                            <span>Salin Ringkasan</span>
                        </button>
                    </div>

                </div>
            </section>

            {{-- Filter Section --}}
            <form method="GET" action="{{ route('hr.log-audit-otorisasi') }}" class="bg-white border border-gray-200 rounded-lg p-4 mb-6 shadow-sm">

                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

                    <div class="flex flex-wrap items-center gap-2">

                        <select name="hub" id="filterHub"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                            <option value="all" {{ $selectedHubId === 'all' ? 'selected' : '' }}>Semua Hub</option>
                            @foreach($hubs as $hubOpt)
                                <option value="{{ $hubOpt->id }}" {{ (string) $hubOpt->id === (string) $selectedHubId ? 'selected' : '' }}>
                                    {{ $hubOpt->name }} ({{ $hubOpt->code }})
                                </option>
                            @endforeach
                        </select>

                        <select name="result" id="filterResult"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Hasil</option>
                            <option value="success" {{ $result === 'success' ? 'selected' : '' }}>Sukses</option>
                            <option value="failure" {{ $result === 'failure' ? 'selected' : '' }}>Gagal / Insiden</option>
                        </select>

                        <div class="relative">
                            <i class="fas fa-search text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 text-xs"></i>
                            <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama, NIP, aksi, entitas..."
                                class="pl-9 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 w-52">
                        </div>

                    </div>

                    <div class="flex flex-wrap gap-2 no-print">
                        <button type="submit"
                            class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                            <i class="fas fa-filter mr-1"></i>Terapkan
                        </button>

                        <a href="{{ route('hr.log-audit-otorisasi') }}"
                            class="px-3 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">
                            <i class="fas fa-sync-alt mr-1"></i>Reset
                        </a>
                    </div>

                </div>

                <div class="flex flex-wrap items-center gap-2 mt-4">
                    <span class="text-xs text-gray-500">Filter aktif:</span>

                    <span id="activeFilter"
                        class="bg-blue-100 text-blue-700 px-3 py-1.5 rounded-full text-xs">
                        {{ $hubScopeLabel }} &bull; {{ $result === 'failure' ? 'Gagal / Insiden' : ($result === 'success' ? 'Sukses' : 'Semua Hasil') }} &bull; {{ $q ?: 'Tanpa pencarian' }}
                    </span>
                </div>

            </form>

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
                                Rekaman audit realtime dari tabel audit_logs pada hub terpilih.
                            </p>
                        </div>
                    </div>

                    <p class="text-sm text-blue-700">
                        Menampilkan
                        <span id="visibleCount" class="font-bold">{{ $logs->count() }}</span>
                        dari {{ number_format($logs->total()) }} log
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
                                    Event ID &amp; Entitas
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Pelaku / Aktor
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Tipe Operasi
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Hasil
                                </th>
                            </tr>
                        </thead>

                        <tbody id="auditTableBody">
                            @php
                                $actionLabels = [
                                    'create' => 'Membuat Data', 'update' => 'Memperbarui Data', 'delete' => 'Menghapus Data',
                                    'activate' => 'Mengaktifkan Akun', 'deactivate' => 'Menonaktifkan Akun',
                                    'login' => 'Login', 'logout' => 'Logout', 'revoke_session' => 'Cabut Sesi',
                                    'approve' => 'Approval', 'reject' => 'Penolakan', 'approval' => 'Approval',
                                    'export' => 'Ekspor Data', 'reset' => 'Reset Konfigurasi',
                                ];
                                $entityLabels = [
                                    'App\\Models\\User' => 'Pengguna', 'App\\Models\\Setting' => 'Pengaturan',
                                    'App\\Models\\Category' => 'Kategori', 'App\\Models\\Unit' => 'Satuan',
                                    'App\\Models\\Location' => 'Lokasi', 'App\\Models\\Supplier' => 'Supplier',
                                    'App\\Models\\Division' => 'Divisi', 'App\\Models\\Item' => 'Barang',
                                    'App\\Models\\Hub' => 'Hub',
                                ];
                            @endphp
                            @forelse($logs as $log)
                            @php
                                $actorName = $log->user?->nama_lengkap ?? 'Sistem';
                                $actorRole = $log->user?->role?->name ?? 'Otomatis';
                                $entityLabel = $entityLabels[$log->entity_type] ?? ($log->entity_type ? class_basename($log->entity_type) : 'Entitas');
                            @endphp
                            <tr class="table-row border-b border-gray-100">
                                <td class="px-4 py-4">
                                    <p class="text-sm font-semibold text-gray-900">{{ $log->created_at->format('d M Y, H:i:s') }}</p>
                                    <p class="text-xs text-gray-500">{{ $log->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm font-semibold text-blue-600">#{{ $log->id }}</p>
                                    <p class="text-xs text-gray-500">{{ $entityLabel }} &bull; ID {{ $log->entity_id ?? '-' }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0 {{ $log->user ? 'bg-blue-600' : 'bg-gray-500' }}">
                                            {{ $actorName === 'Sistem' ? 'SY' : collect(preg_split('/\s+/', $actorName))->take(2)->map(fn($w) => strtoupper(mb_substr($w, 0, 1)))->join('') }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $actorName }}</p>
                                            <p class="text-xs text-gray-500">{{ $actorRole }}{{ $log->user?->nip ? ' &bull; NIP ' . $log->user->nip : '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="{{ $log->result === 'failure' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }} px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ $actionLabels[$log->action] ?? ucwords(str_replace('_', ' ', $log->action)) }}
                                    </span>
                                    @if($log->description)
                                    <p class="text-xs text-gray-500 mt-1.5">{{ \Illuminate\Support\Str::limit($log->description, 90) }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <span class="{{ $log->result === 'failure' ? 'bg-red-50 text-red-700' : 'bg-emerald-50 text-emerald-700' }} px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ $log->result === 'failure' ? 'Gagal / Insiden' : 'Sukses' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center">
                                    <i class="fas fa-search text-3xl text-gray-300 mb-3"></i>
                                    <p class="text-sm font-semibold text-gray-600">Belum ada log pada hub ini</p>
                                    <p class="text-xs text-gray-500 mt-1">Silakan ubah hub atau filter pencarian.</p>
                                </td>
                            </tr>
                            @endforelse
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
                        Menampilkan <span id="tableCount" class="font-semibold">{{ $logs->count() }}</span> dari {{ number_format($logs->total()) }} rekaman
                    </p>
                    <p class="text-xs text-gray-500">
                        Halaman {{ $logs->currentPage() }} dari {{ $logs->lastPage() }}
                    </p>
                    <div class="flex items-center gap-1">
                        @if($logs->onFirstPage())
                            <span class="px-2 py-1 border border-gray-300 rounded text-sm text-gray-300">◄◄</span>
                            <span class="px-2 py-1 border border-gray-300 rounded text-sm text-gray-300">◄</span>
                        @else
                            <a href="{{ $logs->url(1) }}" class="px-2 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">◄◄</a>
                            <a href="{{ $logs->previousPageUrl() }}" class="px-2 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">◄</a>
                        @endif
                        @foreach($logs->getUrlRange(max(1, $logs->currentPage() - 2), min($logs->lastPage(), $logs->currentPage() + 2)) as $page => $url)
                            <a href="{{ $url }}" class="px-3 py-1 rounded text-sm {{ $page === $logs->currentPage() ? 'bg-blue-600 text-white' : 'border border-gray-300 hover:bg-gray-50' }}">{{ $page }}</a>
                        @endforeach
                        @if($logs->hasMorePages())
                            <a href="{{ $logs->nextPageUrl() }}" class="px-2 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">►</a>
                            <a href="{{ $logs->url($logs->lastPage()) }}" class="px-2 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50">►►</a>
                        @else
                            <span class="px-2 py-1 border border-gray-300 rounded text-sm text-gray-300">►</span>
                            <span class="px-2 py-1 border border-gray-300 rounded text-sm text-gray-300">►►</span>
                        @endif
                    </div>
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

        // Filter: ganti hub langsung submit form (server-side)
        const filterForm = page.querySelector('form[action*="log-audit-otorisasi"]');
        $('#filterHub')?.addEventListener('change', () => {
            if (filterForm) filterForm.submit();
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
                ['Timestamp WIB', 'Event ID', 'Entitas', 'Pelaku / Aktor', 'Tipe Operasi', 'Hasil']
            ];

            rows.forEach((row) => {
                const cells = row.querySelectorAll('td');

                csvRows.push([
                    cells[0]?.querySelector('p')?.textContent.trim() || '',
                    cells[1]?.querySelector('p')?.textContent.trim() || '',
                    cells[1]?.querySelectorAll('p')[1]?.textContent.trim() || '',
                    cells[2]?.querySelectorAll('p')[0]?.textContent.trim() || '',
                    cells[3]?.querySelector('span')?.textContent.trim() || '',
                    cells[4]?.querySelector('span')?.textContent.trim() || ''
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

    })();
</script>
@endsection
