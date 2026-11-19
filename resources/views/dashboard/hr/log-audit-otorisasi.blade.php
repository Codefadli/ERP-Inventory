<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Log Audit & Otorisasi | Astro Inventory</title>

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
        :root { --brand: #2563eb; --brand-dark: #1d4ed8; }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif; }

        .nav-link { transition: all 0.16s ease; }
        .nav-link:hover { background: #f1f5f9; color: #172033; transform: translateX(3px); }
        .nav-link.active { background: var(--brand); color: #fff; font-weight: 600; box-shadow: 0 6px 14px -6px rgba(37, 99, 235, 0.55); }
        .nav-link.active:hover { transform: none; background: var(--brand); }

        .reveal { animation: rise-in .4s cubic-bezier(.2,.8,.2,1) both; }
        .reveal-delay-1 { animation-delay: 50ms; }
        .reveal-delay-2 { animation-delay: 100ms; }
        .reveal-delay-3 { animation-delay: 150ms; }
        @keyframes rise-in { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

        .hash-display { font-family: "Courier New", monospace; overflow-wrap: anywhere; }
        .toast-message { transform: translateY(20px); opacity: 0; pointer-events: none; transition: all .25s ease; }
        .toast-message.show { transform: translateY(0); opacity: 1; }

        @media (min-width: 768px) { main { zoom: 1.1; } }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; }
        }
    </style>
</head>

<body class="bg-gray-50">

@include('components.navbar')

<div class="flex min-h-screen">
    @include('components.sidebar')

    <main class="flex-1 p-4 lg:p-6 overflow-x-hidden">

        <section class="reveal mb-4 flex flex-wrap items-end justify-between gap-3">
            <div>
                <p class="mb-1 text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Manajemen & Laporan <span class="text-blue-700">&gt; Log Audit &amp; Otorisasi</span></p>
                <h1 class="text-[24px] font-bold leading-tight tracking-tight text-slate-800">Log Audit, Integritas &amp; Otorisasi</h1>
                <p class="mt-1.5 max-w-[620px] text-[12px] leading-relaxed text-slate-500">Rekam jejak aktivitas pengguna, perubahan data, persetujuan transaksi, dan otorisasi —</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <span class="rounded-full bg-emerald-50 px-3 py-1.5 text-[11px] font-semibold text-emerald-700"><i class="fas fa-shield-alt mr-1"></i>AUDIT AKTIF</span>
                <span class="rounded-full bg-blue-50 px-3 py-1.5 text-[11px] font-semibold text-blue-700">Hub: {{ $hubScopeLabel }}{{ $hubScopeCode ? ' (' . $hubScopeCode . ')' : '' }}</span>
            </div>
        </section>

        @if(session('success'))
        <div class="reveal mb-4 flex items-center gap-2 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-[12px] text-emerald-800">
            <i data-lucide="check-circle-2" class="h-4 w-4"></i>{{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="reveal mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-[12px] text-red-700">
            <p class="mb-1 font-semibold"><i data-lucide="triangle-alert" class="inline h-4 w-4"></i> Periksa kembali isian form:</p>
            <ul class="ml-4 list-disc space-y-0.5">
                @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
            </ul>
        </div>
        @endif

        {{-- Status & metrik --}}
        <section aria-label="Status audit" class="reveal reveal-delay-1 mb-4 grid grid-cols-2 gap-2.5 md:grid-cols-4">
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-slate-100 bg-white px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-slate-500">Status Audit</p><p class="mt-0.5 text-[13px] font-bold leading-tight text-emerald-700">DATA REAL</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-emerald-50 text-emerald-700"><i data-lucide="shield-check" class="h-3.5 w-3.5"></i></span>
            </article>
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-slate-100 bg-white px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-slate-500">Aktivitas Hari Ini</p><p class="mt-0.5 text-[20px] font-bold leading-tight count-up" data-target="{{ $stats['today'] }}">0</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="activity" class="h-3.5 w-3.5"></i></span>
            </article>
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-pink-100 bg-pink-50/40 px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-pink-600">Insiden</p><p class="mt-0.5 text-[20px] font-bold leading-tight text-pink-700 count-up" data-target="{{ $stats['insiden'] }}">0</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-pink-100 text-pink-700"><i data-lucide="triangle-alert" class="h-3.5 w-3.5"></i></span>
            </article>
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-slate-100 bg-white px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-slate-500">Total Rekaman</p><p class="mt-0.5 text-[20px] font-bold leading-tight count-up" data-target="{{ $stats['total'] }}">0</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-cyan-50 text-cyan-700"><i data-lucide="database" class="h-3.5 w-3.5"></i></span>
            </article>
        </section>

        {{-- Metrik kategori --}}
        <section aria-label="Metrik audit" class="reveal reveal-delay-2 mb-4 grid grid-cols-2 gap-2.5 md:grid-cols-4">
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-slate-100 bg-white px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-slate-500">Modifikasi Data</p><p class="mt-0.5 text-[20px] font-bold leading-tight count-up" data-target="{{ $stats['master'] }}">0</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-green-50 text-green-700"><i data-lucide="link" class="h-3.5 w-3.5"></i></span>
            </article>
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-slate-100 bg-white px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-slate-500">Aktivitas Kritis</p><p class="mt-0.5 text-[20px] font-bold leading-tight text-orange-600 count-up" data-target="{{ $stats['kritis'] }}">0</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-orange-50 text-orange-600"><i data-lucide="alert-octagon" class="h-3.5 w-3.5"></i></span>
            </article>
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-slate-100 bg-white px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-slate-500">Akses &amp; Keamanan</p><p class="mt-0.5 text-[20px] font-bold leading-tight count-up" data-target="{{ $stats['akses'] }}">0</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-purple-50 text-purple-700"><i data-lucide="user-shield" class="h-3.5 w-3.5"></i></span>
            </article>
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-slate-100 bg-white px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-slate-500">Otorisasi / Transaksi</p><p class="mt-0.5 text-[20px] font-bold leading-tight text-blue-700 count-up" data-target="{{ $stats['otorisasi'] + $stats['transaksi'] }}">0</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-blue-50 text-blue-700"><i data-lucide="stamp" class="h-3.5 w-3.5"></i></span>
            </article>
        </section>

                <section class="reveal reveal-delay-2 mb-4 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 p-4 shadow-lg">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex min-w-0 items-center gap-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/20 text-white"><i data-lucide="lock" class="h-4 w-4"></i></span>
                    <div class="min-w-0">
                        <p class="text-[12px] font-bold text-white">AUDIT TRAIL &bull; {{ $hubScopeLabel }}{{ $hubScopeCode ? ' (' . $hubScopeCode . ')' : '' }}</p>
                        <p id="auditHash" class="hash-display mt-1 truncate rounded bg-white/10 px-3 py-1.5 text-[11px] text-white">{{ number_format($stats['total']) }} rekaman audit tercatat &bull; {{ $stats['today'] }} hari ini</p>
                    </div>
                </div>
                <button type="button" id="copyHash" class="flex h-9 items-center gap-2 rounded-lg bg-white/20 px-3 text-[12px] font-semibold text-white hover:bg-white/30" title="Salin ringkasan"><i data-lucide="copy" class="h-4 w-4"></i>Salin Ringkasan</button>
            </div>
        </section>

                <section class="reveal reveal-delay-2 mb-4 rounded-xl border border-slate-100 bg-white p-3 shadow-sm">
            <form method="GET" action="{{ route($routeName) }}" class="flex flex-wrap items-center gap-2">
                <label class="flex h-10 min-w-[220px] flex-1 items-center gap-2 rounded-md bg-blue-50/80 px-3 text-slate-400 md:max-w-[400px]">
                    <i data-lucide="search" class="h-4 w-4"></i>
                    <input name="q" value="{{ $q }}" type="search" placeholder="Cari nama, NIP, aksi, entitas..." class="w-full bg-transparent text-[12px] text-slate-700 outline-none placeholder:text-slate-400" />
                </label>
                <select name="hub" id="filterHub" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none">
                    <option value="all" {{ $selectedHubId === 'all' ? 'selected' : '' }}>Semua Hub</option>
                    @foreach($hubs as $hubOpt)
                        <option value="{{ $hubOpt->id }}" {{ (string) $hubOpt->id === (string) $selectedHubId ? 'selected' : '' }}>{{ $hubOpt->name }} ({{ $hubOpt->code }})</option>
                    @endforeach
                </select>
                <select name="result" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none">
                    <option value="">Semua Hasil</option>
                    <option value="success" {{ $result === 'success' ? 'selected' : '' }}>Sukses</option>
                    <option value="failure" {{ $result === 'failure' ? 'selected' : '' }}>Gagal / Insiden</option>
                </select>
                <button type="submit" class="flex h-10 items-center gap-2 rounded-md bg-blue-600 px-3 text-[12px] font-semibold text-white hover:bg-blue-700"><i data-lucide="list-filter" class="h-4 w-4"></i>Terapkan</button>
                <a href="{{ route($routeName) }}" class="flex h-10 w-10 items-center justify-center rounded-md bg-blue-50 text-slate-600" aria-label="Reset filter" title="Reset filter"><i data-lucide="rotate-cw" class="h-4 w-4"></i></a>
                <span class="ml-auto rounded-full bg-blue-50 px-3 py-1.5 text-[10.5px] text-slate-600">{{ $hubScopeLabel }} &bull; {{ $result === 'failure' ? 'Gagal / Insiden' : ($result === 'success' ? 'Sukses' : 'Semua Hasil') }} &bull; {{ $q ?: 'Tanpa pencarian' }}</span>
            </form>
        </section>

        {{-- Tabel log --}}
        <section class="reveal reveal-delay-3 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 px-4 py-3">
                <div>
                    <h2 class="text-[13px] font-bold text-slate-800">Riwayat Log Audit</h2>
                    <p class="text-[10.5px] text-slate-500">Detail waktu, pelaku, jenis operasi, dan hasil.</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[10.5px] text-slate-500">Zona waktu: WIB</span>
                    <button type="button" id="exportAudit" class="flex h-8 items-center gap-1.5 rounded-md bg-blue-600 px-2.5 text-[10.5px] font-semibold text-white hover:bg-blue-700" title="Ekspor CSV"><i data-lucide="download" class="h-3.5 w-3.5"></i>Ekspor</button>
                    <button type="button" id="printAudit" class="flex h-8 items-center gap-1.5 rounded-md bg-blue-50 px-2.5 text-[10.5px] font-semibold text-slate-600 hover:bg-blue-100" title="Cetak"><i data-lucide="printer" class="h-3.5 w-3.5"></i>Cetak</button>
                </div>
            </div>

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

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1000px] table-fixed border-collapse text-left">
                    <thead class="h-10 bg-[#f0f4fc] text-[9px] font-semibold uppercase tracking-wide text-slate-600">
                        <tr>
                            <th class="w-[160px] whitespace-nowrap px-2">Timestamp (WIB)</th>
                            <th class="w-[150px] whitespace-nowrap px-2">Event ID &amp; Entitas</th>
                            <th class="w-[220px] whitespace-nowrap px-2">Pelaku / Aktor</th>
                            <th class="w-[280px] whitespace-nowrap px-2">Tipe Operasi</th>
                            <th class="w-[110px] whitespace-nowrap px-2">Hasil</th>
                        </tr>
                    </thead>
                    <tbody id="auditTableBody" class="divide-y divide-slate-100 text-[12px]">
                        @forelse($logs as $log)
                        @php
                            $actorName = $log->user?->nama_lengkap ?? 'Sistem';
                            $actorRole = $log->user?->role?->name ?? 'Otomatis';
                            $entityLabel = $entityLabels[$log->entity_type] ?? ($log->entity_type ? class_basename($log->entity_type) : 'Entitas');
                            $initials = $actorName === 'Sistem' ? 'SY' : collect(preg_split('/\s+/', $actorName))->take(2)->map(fn($w) => strtoupper(mb_substr($w, 0, 1)))->join('');
                        @endphp
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-2 py-3">
                                <p class="text-[12px] font-semibold text-slate-800">{{ $log->created_at->format('d M Y, H:i:s') }}</p>
                                <p class="text-[10.5px] text-slate-500">{{ $log->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="px-2 py-3">
                                <p class="text-[12px] font-semibold text-blue-700">#{{ $log->id }}</p>
                                <p class="text-[10.5px] text-slate-500">{{ $entityLabel }} &bull; ID {{ $log->entity_id ?? '-' }}</p>
                            </td>
                            <td class="px-2 py-3">
                                <div class="flex items-center gap-2.5">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-[10px] font-bold text-white {{ $log->user ? 'bg-blue-600' : 'bg-gray-400' }}">{{ $initials }}</span>
                                    <div class="min-w-0">
                                        <p class="truncate text-[12px] font-semibold text-slate-800">{{ $actorName }}</p>
                                        <p class="truncate text-[10.5px] text-slate-500">{{ $actorRole }}{{ $log->user?->nip ? ' &bull; NIP ' . $log->user->nip : '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-2 py-3">
                                <span class="rounded-full px-2.5 py-1 text-[10.5px] font-semibold {{ $log->result === 'failure' ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-800' }}">{{ $actionLabels[$log->action] ?? ucwords(str_replace('_', ' ', $log->action)) }}</span>
                                @if($log->description)
                                <p class="mt-1 truncate text-[10.5px] text-slate-500" title="{{ $log->description }}">{{ \Illuminate\Support\Str::limit($log->description, 90) }}</p>
                                @endif
                            </td>
                            <td class="px-2 py-3">
                                <span class="rounded-full px-2.5 py-1 text-[10.5px] font-semibold {{ $log->result === 'failure' ? 'bg-red-50 text-red-700' : 'bg-emerald-50 text-emerald-700' }}">{{ $log->result === 'failure' ? 'Gagal / Insiden' : 'Sukses' }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center">
                                <i data-lucide="search-x" class="h-8 w-8 text-slate-300 mx-auto"></i>
                                <p class="mt-2 text-[12.5px] font-semibold text-slate-500">Belum ada log pada hub ini.</p>
                                <p class="text-[11px] text-slate-400">Silakan ubah hub atau filter pencarian.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <footer class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 px-4 py-3 text-[12px] text-slate-600">
                <span>Menampilkan {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }} dari {{ number_format($logs->total()) }} rekaman &bull; Hub: {{ $hubScopeLabel }}</span>
                <div class="flex items-center gap-1">
                    @if($logs->onFirstPage())
                        <span class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-400">‹ Sebelumnya</span>
                    @else
                        <a href="{{ $logs->previousPageUrl() }}" class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">‹ Sebelumnya</a>
                    @endif
                    @foreach($logs->getUrlRange(max(1, $logs->currentPage() - 2), min($logs->lastPage(), $logs->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}" class="h-8 min-w-8 rounded px-2 text-[12px] {{ $page === $logs->currentPage() ? 'bg-blue-600 px-2 font-semibold text-white' : 'text-slate-600' }}">{{ $page }}</a>
                    @endforeach
                    @if($logs->hasMorePages())
                        <a href="{{ $logs->nextPageUrl() }}" class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">Selanjutnya ›</a>
                    @else
                        <span class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-400">Selanjutnya ›</span>
                    @endif
                </div>
            </footer>
        </section>

        
        <section class="reveal reveal-delay-3 mt-4 grid grid-cols-1 gap-4 lg:grid-cols-3">
            <article class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm">
                <div class="mb-3 flex items-center justify-between">
                    <h3 class="text-[12px] font-bold text-slate-800">Matriks Segregation of Duties</h3>
                    <span class="rounded bg-emerald-50 px-2 py-1 text-[10px] font-semibold text-emerald-700">SoD</span>
                </div>
                <p class="mb-3 text-[11px] leading-relaxed text-slate-500">Pemisahan tugas agar satu pengguna tidak memiliki seluruh kewenangan dalam satu proses transaksi.</p>
                <ul class="space-y-2 text-[11px] text-slate-600">
                    <li class="flex items-start gap-2"><i data-lucide="check-circle-2" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-emerald-600"></i>Petugas opname berbeda dengan approver HR.</li>
                    <li class="flex items-start gap-2"><i data-lucide="check-circle-2" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-emerald-600"></i>Petugas opname berbeda dengan pengelola master SKU.</li>
                    <li class="flex items-start gap-2"><i data-lucide="check-circle-2" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-emerald-600"></i>Persetujuan transaksi dilakukan sesuai hak akses.</li>
                </ul>
            </article>

            <article class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm">
                <div class="mb-3 flex items-center justify-between">
                    <h3 class="text-[12px] font-bold text-slate-800">Uji Mandiri SHA-256</h3>
                    <span class="rounded bg-blue-50 px-2 py-1 text-[10px] font-semibold text-blue-700">Alat Bantu</span>
                </div>
                <p class="mb-3 text-[11px] leading-relaxed text-slate-500">Hitung hash SHA-256 di browser. Fitur alat bantu, bukan verifikasi ledger database.</p>
                <input id="hashInput" type="text" placeholder="Masukkan teks untuk diuji..." class="mb-2.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500">
                <button type="button" id="testHash" class="flex h-10 w-full items-center justify-center gap-2 rounded-md bg-blue-600 text-[12px] font-semibold text-white hover:bg-blue-700"><i data-lucide="fingerprint" class="h-4 w-4"></i>Hitung Hash SHA-256</button>
                <div id="hashResult" class="mt-3 hidden">
                    <p class="mb-1 text-[10.5px] font-semibold text-slate-700">Hasil Hash:</p>
                    <div id="hashOutput" class="hash-display rounded-lg bg-slate-50 p-3 text-[11px] text-slate-700"></div>
                </div>
            </article>

            <article class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm">
                <div class="mb-3 flex items-center justify-between">
                    <h3 class="text-[12px] font-bold text-slate-800">Kebijakan Otorisasi</h3>
                    <span class="rounded bg-blue-50 px-2 py-1 text-[10px] font-semibold text-blue-700">Modul HR</span>
                </div>
                <p class="mb-3 text-[11px] leading-relaxed text-slate-500">Monitoring aktivitas dan pemisahan hak akses pengguna pada lingkup hub terpilih.</p>
                <div class="space-y-2 text-[11px] text-slate-600">
                    <div class="flex items-center gap-2 rounded-lg bg-slate-50 px-3 py-2"><i data-lucide="building" class="h-3.5 w-3.5 text-blue-600"></i>{{ $hubScopeLabel }}{{ $hubScopeCode ? ' (' . $hubScopeCode . ')' : '' }}</div>
                    <div class="flex items-center gap-2 rounded-lg bg-slate-50 px-3 py-2"><i data-lucide="database" class="h-3.5 w-3.5 text-blue-600"></i>{{ number_format($stats['total']) }} rekaman audit</div>
                    <div class="flex items-center gap-2 rounded-lg bg-slate-50 px-3 py-2"><i data-lucide="activity" class="h-3.5 w-3.5 text-blue-600"></i>{{ $stats['today'] }} aktivitas hari ini</div>
                </div>
            </article>
        </section>

    </main>
</div>

<div id="auditToast" class="toast-message fixed bottom-5 right-5 z-[100] rounded-lg bg-gray-900 px-5 py-3 text-white shadow-xl">
    <div class="flex items-center gap-2">
        <i data-lucide="check-circle-2" class="h-4 w-4 text-green-400"></i>
        <span id="auditToastText" class="text-[12px]">Berhasil.</span>
    </div>
</div>

<script>
    lucide.createIcons();
    const page = document;
    const $ = (selector) => page.querySelector(selector);
    const $$ = (selector) => page.querySelectorAll(selector);

    let toastTimer;
    function showToast(message) {
        const toast = $('#auditToast');
        const text = $('#auditToastText');
        if (!toast || !text) return;
        text.textContent = message;
        toast.classList.add('show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => toast.classList.remove('show'), 3000);
    }

    function animateCounters() {
        $$('.count-up').forEach((counter) => {
            const target = Number(counter.dataset.target || 0);
            const duration = 800;
            const startTime = performance.now();
            function update(now) {
                const progress = Math.min((now - startTime) / duration, 1);
                counter.textContent = Math.floor(target * progress).toLocaleString('id-ID');
                if (progress < 1) requestAnimationFrame(update);
            }
            requestAnimationFrame(update);
        });
    }

    $('#copyHash')?.addEventListener('click', async () => {
        const hash = $('#auditHash')?.textContent.trim();
        if (!hash) return;
        try {
            await navigator.clipboard.writeText(hash);
            showToast('Ringkasan berhasil disalin.');
        } catch (error) {
            const temp = document.createElement('textarea');
            temp.value = hash;
            document.body.appendChild(temp);
            temp.select();
            const copied = document.execCommand('copy');
            temp.remove();
            showToast(copied ? 'Ringkasan berhasil disalin.' : 'Gagal menyalin ringkasan.');
        }
    });

    // Filter hub langsung submit (server-side)
    $('#filterHub')?.addEventListener('change', () => {
        const form = document.querySelector('form[method="GET"]');
        if (form) form.submit();
    });

    // Ekspor CSV (baris tampil)
    $('#exportAudit')?.addEventListener('click', () => {
        const rows = [...$$('#auditTableBody tr')].filter(row => !row.classList.contains('hidden'));
        if (!rows.length) { showToast('Tidak ada data untuk diekspor.'); return; }
        const csvRows = [['Timestamp WIB', 'Event ID', 'Entitas', 'Pelaku / Aktor', 'Tipe Operasi', 'Hasil']];
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
        const escapeCSV = value => `"${String(value).replace(/"/g, '""')}"`;
        const csv = csvRows.map(row => row.map(escapeCSV).join(',')).join('\r\n');
        const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
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

    $('#printAudit')?.addEventListener('click', () => window.print());

    $('#testHash')?.addEventListener('click', async () => {
        const input = $('#hashInput').value.trim();
        if (!input) { showToast('Masukkan teks terlebih dahulu.'); $('#hashInput').focus(); return; }
        if (!window.crypto?.subtle) { showToast('SHA-256 memerlukan browser dengan Web Crypto API.'); return; }
        try {
            const encoder = new TextEncoder();
            const digest = await crypto.subtle.digest('SHA-256', encoder.encode(input));
            $('#hashOutput').textContent = Array.from(new Uint8Array(digest)).map(b => b.toString(16).padStart(2, '0')).join('');
            $('#hashResult').classList.remove('hidden');
            showToast('Hash SHA-256 berhasil dihitung.');
        } catch (error) { showToast('Gagal menghitung hash.'); }
    });

    animateCounters();
</script>
</body>
</html>
