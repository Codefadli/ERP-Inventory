<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Log Aktivitas &amp; Audit Trail Forensik - Astro Inventory</title>

    <!-- Tailwind CSS CDN + brand tokens -->
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ============================================================
           Astro Inventory — Design System
           ============================================================ */
        :root {
            --brand: #2563eb;
            --brand-dark: #1d4ed8;
            --bg: #f5f7fb;
            --line: #e7ebf2;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif;
            background: var(--bg);
            color: #172033;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 9px; height: 9px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cdd6e4; border-radius: 99px; border: 2px solid #f5f7fb; }
        ::-webkit-scrollbar-thumb:hover { background: #aab8cf; }

        /* Nav links (komponen sidebar) */
        .nav-link { transition: all 0.16s ease; }
        .nav-link:hover { background: #f1f5f9; color: #172033; transform: translateX(3px); }
        .nav-link.active { background: var(--brand); color: #fff; font-weight: 600; box-shadow: 0 6px 14px -6px rgba(37, 99, 235, 0.55); }
        .nav-link.active:hover { transform: none; background: var(--brand); }

        /* Cards */
        .ai-card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.05);
            transition: transform 0.25s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.25s;
        }
        .ai-card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px -12px rgba(37, 99, 235, 0.22), 0 4px 10px rgba(15, 23, 42, 0.06);
        }

        /* Buttons */
        .ai-btn {
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 600;
            font-size: 13px;
            border-radius: 10px;
            padding: 10px 16px;
            transition: all 0.18s ease;
            cursor: pointer;
            white-space: nowrap;
        }
        .ai-btn:active { transform: scale(0.97); }
        .ai-btn-primary { background: var(--brand); color: #fff; box-shadow: 0 4px 12px -4px rgba(37, 99, 235, 0.5); }
        .ai-btn-primary:hover { background: var(--brand-dark); box-shadow: 0 8px 18px -6px rgba(37, 99, 235, 0.55); transform: translateY(-1px); }
        .ai-btn-secondary { background: #fff; color: #334155; border: 1px solid #dbe2ec; }
        .ai-btn-secondary:hover { background: #f8fafc; border-color: #c3cfe0; transform: translateY(-1px); }
        .ai-btn-soft { background: #eff6ff; color: var(--brand-dark); }
        .ai-btn-soft:hover { background: #dbeafe; }
        .ai-btn-danger { background: #fef2f2; color: #dc2626; }
        .ai-btn-danger:hover { background: #fee2e2; }

        /* Ripple */
        .ai-ripple {
            position: absolute;
            border-radius: 9999px;
            transform: scale(0);
            animation: ai-ripple 0.6s ease-out;
            background: rgba(255, 255, 255, 0.45);
            pointer-events: none;
        }
        .ai-btn-secondary .ai-ripple,
        .ai-btn-soft .ai-ripple,
        .ai-btn-danger .ai-ripple { background: rgba(37, 99, 235, 0.18); }
        @keyframes ai-ripple { to { transform: scale(2.6); opacity: 0; } }

        /* Entrance animations */
        .ai-reveal { opacity: 0; transform: translateY(14px); }
        .ai-reveal.ai-revealed { animation: ai-fade-up 0.55s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
        @keyframes ai-fade-up { to { opacity: 1; transform: translateY(0); } }

        .anim-fade-in { animation: fadeIn .5s ease-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        /* Badges */
        .ai-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border-radius: 999px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* Live dot (badge STREAM: ACTIVE & tombol Live Stream Feed) */
        .ai-live-dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: #16a34a;
            position: relative;
            flex: none;
        }
        .ai-live-dot::after {
            content: "";
            position: absolute;
            inset: -4px;
            border-radius: 999px;
            background: rgba(22, 163, 74, 0.35);
            animation: ai-pulse 1.8s ease-out infinite;
        }
        @keyframes ai-pulse {
            0% { transform: scale(0.5); opacity: 1; }
            100% { transform: scale(1.6); opacity: 0; }
        }

        /* Live feed: baris terbaru berkedip halus */
        @keyframes ai-live-row {
            0%, 100% { background-color: transparent; }
            50% { background-color: rgba(37, 99, 235, 0.06); }
        }
        .ai-live-row { animation: ai-live-row 2.4s ease-in-out infinite; }
        @keyframes ai-blink-soft {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.45; }
        }
        .ai-blink-soft { animation: ai-blink-soft 1.8s ease-in-out infinite; }

        /* Toast */
        #ai-toast-root { position: fixed; z-index: 9999; right: 20px; bottom: 20px; display: flex; flex-direction: column; gap: 10px; }
        .ai-toast {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            border: 1px solid var(--line);
            border-left: 4px solid var(--brand);
            border-radius: 12px;
            box-shadow: 0 14px 34px -12px rgba(15, 23, 42, 0.28);
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 600;
            color: #243044;
            min-width: 260px;
            max-width: 380px;
            animation: ai-toast-in 0.35s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .ai-toast.ai-toast-success { border-left-color: #16a34a; }
        .ai-toast.ai-toast-danger { border-left-color: #dc2626; }
        .ai-toast.ai-toast-warn { border-left-color: #d97706; }
        .ai-toast.ai-toast-out { animation: ai-toast-out 0.3s ease forwards; }
        @keyframes ai-toast-in { from { opacity: 0; transform: translateX(40px) scale(0.95); } }
        @keyframes ai-toast-out { to { opacity: 0; transform: translateX(40px) scale(0.95); } }

        /* Tables */
        .ai-table th {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #64748b;
            background: #f8fafc;
            padding: 12px 14px;
            white-space: nowrap;
        }
        .ai-table td { padding: 13px 14px; font-size: 13px; vertical-align: middle; }
        .ai-table tbody tr { transition: background 0.15s; }
        .ai-table tbody tr:hover { background: #f6f9ff; }

        /* Tabs / pills */
        .ai-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            border-radius: 999px;
            padding: 8px 15px;
            font-size: 12.5px;
            font-weight: 600;
            color: #475569;
            background: #fff;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.18s ease;
            white-space: nowrap;
        }
        .ai-pill:hover { border-color: #93c5fd; color: var(--brand-dark); transform: translateY(-1px); }
        .ai-pill.ai-pill-active {
            background: var(--brand);
            border-color: var(--brand);
            color: #fff;
            box-shadow: 0 6px 14px -6px rgba(37, 99, 235, 0.5);
        }

        /* Inputs */
        .ai-input {
            width: 100%;
            border: 1px solid #dbe2ec;
            border-radius: 10px;
            padding: 10px 13px;
            background: #fff;
            color: #243044;
            outline: none;
            font-size: 13px;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .ai-input:focus { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.13); }
        .ai-input::placeholder { color: #94a3b8; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; }
        }
    </style>
</head>
<body class="bg-gray-50">

@include('components.navbar')

<div class="flex min-h-screen">
    @include('components.sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-4 lg:p-6 overflow-x-hidden space-y-5">

        {{-- ================= SUPER ADMIN ================= --}}
        @if(auth()->user()->isSuperAdmin())

        <!-- ===== Breadcrumb strip ===== -->
        <div class="flex flex-wrap items-center justify-between gap-3">
          <div class="flex items-center gap-3">
            <nav class="flex items-center gap-1.5 text-[11px] tracking-[0.04em] uppercase">
                <span class="text-slate-400 font-semibold">MANAJEMEN SISTEM</span>
                <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                <span class="text-blue-600 font-bold">LOG AKTIVITAS SISTEM</span>
            </nav>
            <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100"><span class="ai-live-dot" style="background:#2563eb"></span>AUDIT AKTIF</span>
          </div>
          <div class="hidden lg:flex items-center gap-1.5 text-[11.5px] font-semibold text-slate-500">
            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
            Audit Trail Forensik &bull; Hub: {{ $hubScopeLabel }}{{ $hubScopeCode ? ' (' . $hubScopeCode . ')' : '' }}
          </div>
        </div>

        <!-- ===== Header card ===== -->
        <section class="ai-card ai-card-hover ai-reveal p-6">
          <div class="flex flex-col gap-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
              <div class="flex flex-wrap items-center gap-x-3 gap-y-2 min-w-0">
                <h1 class="text-[22px] sm:text-[25px] 2xl:text-[28px] font-extrabold text-slate-800 leading-tight tracking-tight">Log Aktivitas &amp; Audit Trail Forensik</h1>
                <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>DATA REAL</span>
              </div>
              <div class="flex flex-wrap items-center gap-2.5 ml-auto">
                <button class="ai-btn ai-btn-secondary opacity-60 cursor-not-allowed" disabled title="Filter hub & kategori tersedia di panel bawah">
                  <i data-lucide="sliders-horizontal" class="w-4 h-4"></i>Filter Audit Lanjutan
                </button>
                <button class="ai-btn ai-btn-secondary opacity-60 cursor-not-allowed" disabled title="Ekspor log (JSON/CSV) belum tersedia">
                  <i data-lucide="download" class="w-4 h-4"></i>Export Log (JSON/CSV)
                </button>
                <button class="ai-btn ai-btn-primary opacity-60 cursor-not-allowed" disabled title="Live stream feed belum terintegrasi">
                  <span class="w-2 h-2 rounded-full bg-white ai-live-dot" style="background:#fff"></span>Live Stream Feed
                  <span class="text-[10px] font-bold bg-white/20 rounded px-1.5 py-0.5">LIVE</span>
                </button>
              </div>
            </div>
            <p class="text-[13px] lg:text-[13.5px] text-slate-500 leading-relaxed">Rekam jejak forensik seluruh aktivitas pengguna, perubahan data master, dan keamanan sistem secara realtime di {{ $hubScopeLabel }}{{ $hubScopeCode ? ' (' . $hubScopeCode . ')' : '' }}.</p>
          </div>
        </section>

        <!-- ===== Statistik ===== -->
        <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
          <div class="ai-card ai-card-hover ai-reveal p-5" data-delay="0">
            <div class="flex items-start justify-between">
              <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center"><i data-lucide="history" class="w-5 h-5 text-blue-600"></i></div>
              <span class="ai-badge bg-emerald-50 text-emerald-700"><i data-lucide="trending-up" class="w-3 h-3"></i>Live</span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
              <span class="text-[34px] font-extrabold text-slate-800 leading-none" data-count="{{ $stats['total'] }}">0</span>
              <span class="text-[13px] text-slate-500 font-medium">Event</span>
            </div>
            <div class="mt-2 text-[13.5px] font-bold text-slate-700">Total Aktivitas Tercatat</div>
            <div class="mt-1.5 flex items-center gap-1.5 text-[11.5px] text-slate-500"><span class="w-1.5 h-1.5 rounded-full bg-blue-500 flex-none"></span>{{ $stats['today'] }} aktivitas hari ini</div>
          </div>

          <div class="ai-card ai-card-hover ai-reveal p-5" data-delay="80">
            <div class="flex items-start justify-between">
              <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center"><i data-lucide="badge-check" class="w-5 h-5 text-blue-600"></i></div>
              <span class="ai-badge bg-blue-50 text-blue-700"><i data-lucide="key-round" class="w-3 h-3"></i>Kritis</span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
              <span class="text-[34px] font-extrabold text-slate-800 leading-none" data-count="{{ $stats['kritis'] }}">0</span>
              <span class="text-[13px] text-slate-500 font-medium">Aksi</span>
            </div>
            <div class="mt-2 text-[13.5px] font-bold text-slate-700">Aktivitas Kritis &amp; Gagal</div>
            <div class="mt-1.5 flex items-center gap-1.5 text-[11.5px] text-slate-500"><span class="w-1.5 h-1.5 rounded-full bg-blue-500 flex-none"></span>Hapus, nonaktifkan, cabut sesi, atau failure</div>
          </div>

          <div class="ai-card ai-card-hover ai-reveal p-5" data-delay="160">
            <div class="flex items-start justify-between">
              <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center"><i data-lucide="clipboard-list" class="w-5 h-5 text-blue-600"></i></div>
              <span class="ai-badge bg-slate-100 text-slate-600"><i data-lucide="pen-line" class="w-3 h-3"></i>Master</span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
              <span class="text-[34px] font-extrabold text-slate-800 leading-none" data-count="{{ $stats['master'] }}">0</span>
              <span class="text-[13px] text-slate-500 font-medium">Modifikasi</span>
            </div>
            <div class="mt-2 text-[13.5px] font-bold text-slate-700">Perubahan Data (Create/Update/Delete)</div>
            <div class="mt-1.5 flex items-center gap-1.5 text-[11.5px] text-slate-500"><span class="w-1.5 h-1.5 rounded-full bg-blue-500 flex-none"></span>Perubahan master &amp; pengaturan</div>
          </div>

          <div class="ai-card ai-card-hover ai-reveal p-5" data-delay="240">
            <div class="flex items-start justify-between">
              <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center"><i data-lucide="shield" class="w-5 h-5 text-emerald-600"></i></div>
              <span class="ai-badge bg-emerald-50 text-emerald-700"><i data-lucide="lock" class="w-3 h-3"></i>Audit Trail</span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
              <span class="text-[34px] font-extrabold text-emerald-600 leading-none" data-count="{{ $stats['insiden'] }}">0</span>
              <span class="text-[13px] text-slate-500 font-medium">Insiden</span>
            </div>
            <div class="mt-2 text-[13.5px] font-bold text-slate-700">Insiden Keamanan / Failure</div>
            <div class="mt-1.5 flex items-center gap-1.5 text-[11.5px] text-slate-500"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 flex-none"></span>Login gagal &amp; operasi gagal tercatat</div>
          </div>
        </section>

        <!-- ===== Pill filter (kategori) ===== -->
        <section class="ai-card ai-reveal p-4" data-delay="100">
          <div class="flex gap-2 overflow-x-auto pb-1">
            @php
                $pills = [
                    'semua'    => ['Semua Log', $stats['total']],
                    'master'   => ['Modifikasi Data', $stats['master']],
                    'akses'    => ['Akses & Keamanan Login', $stats['akses']],
                    'otorisasi'=> ['Otorisasi & Approval', $stats['otorisasi']],
                    'transaksi'=> ['Transaksi Inventaris', $stats['transaksi']],
                ];
            @endphp
            @foreach($pills as $key => [$label, $count])
            <a href="{{ route($routeName, array_filter(['cat' => $key === 'semua' ? null : $key, 'q' => $q ?: null, 'result' => $result ?: null, 'hub' => $selectedHubId === 'all' ? null : $selectedHubId])) }}"
               class="ai-pill {{ ($cat ?? 'semua') === $key ? 'ai-pill-active' : '' }}">
                {{ $label }}
                <span class="text-[10.5px] font-bold {{ ($cat ?? 'semua') === $key ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }} rounded-full px-2 py-0.5">{{ number_format($count) }}</span>
            </a>
            @endforeach
          </div>
        </section>

        <!-- ===== Search + filter + tabel ===== -->
        <section class="ai-card ai-reveal p-4 md:p-5" data-delay="150">
          <form method="GET" action="{{ route($routeName) }}" class="grid grid-cols-1 lg:grid-cols-12 gap-3">
            <input type="hidden" name="hub" value="{{ $selectedHubId }}">
            <input type="hidden" name="cat" value="{{ $cat ?? 'semua' }}">
            <div class="lg:col-span-4 relative">
              <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
              <input name="q" value="{{ $q }}" class="ai-input pl-10" placeholder="Cari nama, NIP, IP Address, entitas, atau aksi..." />
            </div>
            <select name="hub" class="ai-input lg:col-span-3 text-slate-600">
              <option value="all" {{ $selectedHubId === 'all' ? 'selected' : '' }}>Semua Hub</option>
              @foreach($hubs as $hubOpt)
                <option value="{{ $hubOpt->id }}" {{ (string) $hubOpt->id === (string) $selectedHubId ? 'selected' : '' }}>
                    {{ $hubOpt->name }} ({{ $hubOpt->code }})
                </option>
              @endforeach
            </select>
            <select name="result" class="ai-input lg:col-span-2 text-slate-600">
              <option value="">Semua Hasil</option>
              <option value="success" {{ $result === 'success' ? 'selected' : '' }}>Sukses</option>
              <option value="failure" {{ $result === 'failure' ? 'selected' : '' }}>Gagal / Insiden</option>
            </select>
            <div class="lg:col-span-3 flex gap-2">
              <button type="submit" class="ai-btn ai-btn-primary w-full"><i data-lucide="search" class="w-4 h-4"></i>Terapkan</button>
              <a href="{{ route($routeName) }}" class="ai-btn ai-btn-secondary flex-none w-11 px-0" title="Reset"><i data-lucide="rotate-ccw" class="w-4 h-4"></i></a>
            </div>
          </form>

          <div class="mt-4 overflow-x-auto">
            <table class="w-full ai-table min-w-[1150px]">
              <thead>
                <tr>
                  <th>Timestamp &amp; Waktu</th>
                  <th>Aktor / Identitas User</th>
                  <th>Kategori &amp; Modul</th>
                  <th>Tindakan / Deskripsi Event</th>
                  <th>Target / Entitas</th>
                  <th>Metadata Teknis</th>
                  <th>Status &amp; Integritas</th>
                  <th class="text-right">Aksi</th>
                </tr>
              </thead>
              <tbody id="logBody">
                @php
                    // Mapping aksi -> label, warna badge, dan kategori
                    $actionMeta = [
                        'create'        => ['Membuat Data', 'bg-emerald-50 text-emerald-700', 'master'],
                        'update'        => ['Memperbarui Data', 'bg-indigo-50 text-indigo-700', 'master'],
                        'delete'        => ['Menghapus Data', 'bg-red-50 text-red-700', 'master'],
                        'activate'      => ['Mengaktifkan Akun', 'bg-emerald-50 text-emerald-700', 'akses'],
                        'deactivate'    => ['Menonaktifkan Akun', 'bg-amber-50 text-amber-700', 'akses'],
                        'login'         => ['Login', 'bg-blue-50 text-blue-700', 'akses'],
                        'logout'        => ['Logout', 'bg-slate-100 text-slate-600', 'akses'],
                        'revoke_session'=> ['Cabut Sesi', 'bg-red-50 text-red-700', 'akses'],
                        'approve'       => ['Persetujuan', 'bg-green-50 text-green-700', 'otorisasi'],
                        'reject'        => ['Penolakan', 'bg-red-50 text-red-700', 'otorisasi'],
                        'approval'      => ['Approval', 'bg-green-50 text-green-700', 'otorisasi'],
                        'export'        => ['Ekspor Data', 'bg-cyan-50 text-cyan-700', 'master'],
                        'reset'         => ['Reset Konfigurasi', 'bg-orange-50 text-orange-700', 'master'],
                        'barang_masuk'  => ['Barang Masuk', 'bg-emerald-50 text-emerald-700', 'transaksi'],
                        'barang_keluar' => ['Barang Keluar', 'bg-blue-50 text-blue-700', 'transaksi'],
                        'mutasi'        => ['Mutasi Barang', 'bg-violet-50 text-violet-700', 'transaksi'],
                    ];
                    $entityLabels = [
                        'App\\Models\\User' => 'Pengguna',
                        'App\\Models\\Setting' => 'Pengaturan',
                        'App\\Models\\Category' => 'Kategori',
                        'App\\Models\\Unit' => 'Satuan',
                        'App\\Models\\Location' => 'Lokasi',
                        'App\\Models\\Supplier' => 'Supplier',
                        'App\\Models\\Division' => 'Divisi',
                        'App\\Models\\Item' => 'Barang',
                        'App\\Models\\Hub' => 'Hub',
                    ];
                    $initialsOf = fn ($name) => ($name === 'Sistem' ? 'SY'
                        : (collect(preg_split('/\s+/', $name))->take(2)->map(fn($w) => strtoupper(mb_substr($w, 0, 1)))->join('') ?: '?'));
                @endphp

                @forelse($logs as $log)
                @php
                    $meta = $actionMeta[$log->action] ?? [ucwords(str_replace('_', ' ', $log->action)), 'bg-slate-100 text-slate-600', 'master'];
                    $actorName = $log->user?->nama_lengkap ?? 'Sistem';
                    $actorRole = $log->user?->role?->name ?? 'Otomatis';
                    $actorNip  = $log->user?->nip;
                    $entityLabel = $entityLabels[$log->entity_type] ?? ($log->entity_type ? class_basename($log->entity_type) : 'Entitas');
                    $changesJson = json_encode($log->changes, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                @endphp
                <tr class="ai-live-row" data-cat="{{ $meta[2] }}" data-text="{{ strtolower($log->created_at->format('d M Y H:i:s') . ' ' . $actorName . ' ' . ($actorNip ?? '') . ' ' . $log->action . ' ' . ($log->entity_type ?? '') . ' ' . ($log->ip_address ?? '') . ' ' . $log->result) }}">
                  <td>
                    <div class="font-bold text-slate-700 whitespace-nowrap">{{ $log->created_at->format('d M Y') }} &bull; {{ $log->created_at->format('H:i:s') }}</div>
                    <div class="mt-1 flex items-center gap-1.5"><span class="ai-badge bg-blue-50 text-blue-600 ai-blink-soft">{{ $log->created_at->diffForHumans() }}</span></div>
                    <div class="text-[10.5px] text-slate-400 mt-0.5">WIB (GMT+7)</div>
                  </td>
                  <td>
                    <div class="flex items-center gap-2.5">
                      <div class="w-9 h-9 rounded-full bg-blue-600 text-white text-[11px] font-bold flex items-center justify-center flex-none">{{ $initialsOf($actorName) }}</div>
                      <div>
                        <div class="font-bold text-slate-700">{{ $actorName }}</div>
                        <div class="text-[11px] text-slate-500">{{ $actorRole }}{{ $actorNip ? ' &bull; NIP ' . $actorNip : '' }}</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="ai-badge {{ $meta[1] }}">{{ $meta[0] }}</span>
                    <div class="text-[11px] text-slate-500 mt-1.5">{{ $entityLabel }}</div>
                  </td>
                  <td class="max-w-[240px]">
                    <div class="font-bold text-slate-700 leading-snug">{{ $log->description ?: 'Tidak ada deskripsi.' }}</div>
                    @if(!empty($log->changes) && is_array($log->changes))
                    <div class="text-[11.5px] text-slate-500 mt-1 leading-snug">Perubahan: {{ implode(', ', array_keys($log->changes)) }}</div>
                    @endif
                  </td>
                  <td>
                    <div class="font-bold text-blue-600">{{ $entityLabel }}</div>
                    <div class="font-semibold text-blue-600 text-[12px] mt-0.5">#{{ $log->entity_id ?? '-' }}</div>
                  </td>
                  <td>
                    <div class="font-semibold text-slate-600">{{ $log->ip_address ?? '-' }}</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">{{ $log->user_agent ? \Illuminate\Support\Str::limit($log->user_agent, 40) : 'Tanpa user agent' }}</div>
                  </td>
                  <td>
                    <span class="ai-badge {{ $log->result === 'failure' ? 'bg-red-50 text-red-700' : 'bg-emerald-50 text-emerald-700' }}">
                        <i data-lucide="{{ $log->result === 'failure' ? 'alert-triangle' : 'shield-check' }}" class="w-3 h-3"></i>
                        {{ $log->result === 'failure' ? 'Gagal / Insiden' : 'Sukses' }}
                    </span>
                    <div class="text-[11px] font-semibold text-blue-400 mt-1.5">#{{ $log->id }}</div>
                  </td>
                  <td class="text-right">
                    <button type="button" class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors"
                            onclick="showLogJson('{{ addslashes($actorName) }}', '{{ addslashes($meta[0]) }}', {{ addslashes($changesJson ?: '{}') }})" title="Lihat JSON">
                        <i data-lucide="braces" class="w-4 h-4"></i>
                    </button>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="8" class="py-10 text-center">
                    <i data-lucide="search-x" class="w-8 h-8 text-slate-300 mx-auto"></i>
                    <div class="mt-2 text-[13px] font-semibold text-slate-500">Belum ada log aktivitas yang cocok dengan filter pada hub ini.</div>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          {{-- Empty state: data kosong sudah ditangani forelse di tbody --}}

          <!-- Pagination -->
          <div class="mt-4 flex flex-wrap items-center justify-between gap-3 pt-4 border-t border-slate-100">
            <div class="text-[12px] text-slate-500 font-medium">
                Menampilkan {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }} dari {{ number_format($logs->total()) }} Log Aktivitas &bull; Halaman {{ $logs->currentPage() }} dari {{ $logs->lastPage() }}
            </div>
            <div class="flex items-center gap-1.5">
              @if($logs->onFirstPage())
                <button class="ai-btn ai-btn-secondary opacity-50 cursor-not-allowed" disabled>Sebelumnya</button>
              @else
                <a href="{{ $logs->previousPageUrl() }}" class="ai-btn ai-btn-secondary">Sebelumnya</a>
              @endif
              @foreach($logs->getUrlRange(max(1, $logs->currentPage() - 2), min($logs->lastPage(), $logs->currentPage() + 2)) as $page => $url)
                <a href="{{ $url }}" class="w-9 h-9 rounded-lg text-[12.5px] font-semibold {{ $page === $logs->currentPage() ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-600 hover:bg-slate-100' }} flex items-center justify-center">{{ $page }}</a>
              @endforeach
              @if($logs->hasMorePages())
                <a href="{{ $logs->nextPageUrl() }}" class="ai-btn ai-btn-secondary">Berikutnya</a>
              @else
                <button class="ai-btn ai-btn-secondary opacity-50 cursor-not-allowed" disabled>Berikutnya</button>
              @endif
            </div>
          </div>
        </section>

        <!-- ===== Info cards ===== -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="ai-card ai-card-hover ai-reveal p-6" data-delay="0">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center"><i data-lucide="lock" class="w-5 h-5 text-blue-600"></i></div>
            <h3 class="mt-3.5 text-[15px] font-bold text-slate-800">Penyimpanan Log Anti-Tamper (WORM)</h3>
            <p class="mt-2 text-[12.5px] text-slate-500 leading-relaxed">Standar keamanan kepatuhan audit Write-Once-Read-Many, memastikan rekaman log tidak dapat dimanipulasi atau dihapus oleh siapapun termasuk super admin. Dilengkapi cryptographic hashing per blok event.</p>
            <button class="mt-3.5 text-[12.5px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1 opacity-60 cursor-not-allowed" disabled title="Dokumentasi arsitektur belum tersedia">Pelajari Arsitektur Log WORM <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></button>
          </div>
          <div class="ai-card ai-card-hover ai-reveal p-6" data-delay="80">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center"><i data-lucide="brain-circuit" class="w-5 h-5 text-indigo-600"></i></div>
            <h3 class="mt-3.5 text-[15px] font-bold text-slate-800">Deteksi Anomali Berbasis AI</h3>
            <p class="mt-2 text-[12.5px] text-slate-500 leading-relaxed">Pemantauan otomatis perilaku transaksi tidak wajar, lonjakan penyesuaian stok di luar jam kerja, atau login dari perangkat tidak dikenal dengan notifikasi push instan ke Security Officer.</p>
            <button class="mt-3.5 text-[12.5px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1 opacity-60 cursor-not-allowed" disabled title="Konfigurasi alert belum tersedia">Konfigurasi Alert Keamanan AI <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></button>
          </div>
          <div class="ai-card ai-card-hover ai-reveal p-6" data-delay="160">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center"><i data-lucide="shield-check" class="w-5 h-5 text-emerald-600"></i></div>
            <h3 class="mt-3.5 text-[15px] font-bold text-slate-800">Arsip &amp; Kebijakan Ekspor Forensik</h3>
            <p class="mt-2 text-[12.5px] text-slate-500 leading-relaxed">Ekspor data log terenkripsi dengan stempel waktu tersertifikasi digital (Digital Timestamp RFC 3161) untuk kebutuhan kepatuhan audit internal dan audit eksternal standar sertifikasi ISO 27001.</p>
            <button class="mt-3.5 text-[12.5px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1 opacity-60 cursor-not-allowed" disabled title="Ekspor berkas audit belum tersedia">
              Unduh Berkas Audit Resmi <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></button>
          </div>
        </section>

        @endif

    </main>
</div>

<script>
/* ============================================================
   Astro Inventory — interaction layer halaman (toast, tabs, ripple,
   reveal, count-up, ikon Lucide).
   Shell sidebar/topbar pada file sumber dibuang: digantikan
   komponen Blade components.navbar & components.sidebar.
   ============================================================ */
(function () {
    "use strict";

    /* ---------------- Google Fonts + Lucide icons ---------------- */
    function addLink(id, href) {
        if (document.getElementById(id)) return;
        var l = document.createElement("link");
        l.id = id; l.rel = "stylesheet"; l.href = href;
        document.head.appendChild(l);
    }
    addLink("ai-font", "https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap");

    window.aiIcons = function () {
        if (window.lucide && window.lucide.createIcons) window.lucide.createIcons();
    };
    function loadLucide(cb) {
        if (window.lucide) { cb(); return; }
        var s = document.createElement("script");
        s.src = "https://unpkg.com/lucide@latest/dist/umd/lucide.min.js";
        s.onload = cb;
        document.head.appendChild(s);
    }

    function el(html) {
        var t = document.createElement("template");
        t.innerHTML = html.trim();
        return t.content.firstElementChild;
    }

    /* ---------------- Toast ---------------- */
    function toastRoot() {
        var root = document.getElementById("ai-toast-root");
        if (!root) {
            root = el('<div id="ai-toast-root"></div>');
            document.body.appendChild(root);
        }
        return root;
    }
    window.aiToast = function (msg, type, icon) {
        var icons = { success: "check-circle-2", danger: "alert-triangle", warn: "alert-circle", info: "info" };
        var colors = { success: "text-emerald-600", danger: "text-red-600", warn: "text-amber-600", info: "text-blue-600" };
        var t = el(
            '<div class="ai-toast ' + (type ? "ai-toast-" + type : "") + '">' +
            '<i data-lucide="' + (icons[type] || icons.info) + '" class="w-[18px] h-[18px] flex-none ' + (colors[type] || colors.info) + '"></i>' +
            "<span>" + msg + "</span></div>"
        );
        toastRoot().appendChild(t);
        window.aiIcons();
        setTimeout(function () {
            t.classList.add("ai-toast-out");
            setTimeout(function () { t.remove(); }, 320);
        }, 3200);
    };

    /* ---------------- Count-up ---------------- */
    function animateCount(elm) {
        var target = parseFloat((elm.getAttribute("data-count") || "0").replace(/\./g, "").replace(",", "."));
        var decimals = parseInt(elm.getAttribute("data-decimals") || "0", 10);
        var duration = parseInt(elm.getAttribute("data-duration") || "1200", 10);
        var start = null;
        function fmt(v) {
            var s = v.toFixed(decimals);
            var parts = s.split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return parts.join(",");
        }
        function step(ts) {
            if (!start) start = ts;
            var p = Math.min((ts - start) / duration, 1);
            var eased = 1 - Math.pow(1 - p, 3);
            elm.textContent = fmt(target * eased);
            if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    /* ---------------- Ripple ---------------- */
    function addRipple(e) {
        var btn = e.currentTarget;
        var r = btn.getBoundingClientRect();
        var d = Math.max(r.width, r.height);
        var s = document.createElement("span");
        s.className = "ai-ripple";
        s.style.width = s.style.height = d + "px";
        s.style.left = (e.clientX - r.left - d / 2) + "px";
        s.style.top = (e.clientY - r.top - d / 2) + "px";
        btn.appendChild(s);
        setTimeout(function () { s.remove(); }, 650);
    }

    /* ---------------- Reveal on scroll ---------------- */
    function initReveal() {
        var els = document.querySelectorAll(".ai-reveal:not(.ai-revealed)");
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) {
                    var delay = parseInt(en.target.getAttribute("data-delay") || "0", 10);
                    setTimeout(function () { en.target.classList.add("ai-revealed"); }, delay);
                    io.unobserve(en.target);
                }
            });
        }, { threshold: 0.08 });
        els.forEach(function (e) { io.observe(e); });
    }

    /* ---------------- Tabs (pills) ---------------- */
    function initTabs(root) {
        (root || document).querySelectorAll("[data-tabs]").forEach(function (group) {
            var pills = group.querySelectorAll("[data-tab]");
            pills.forEach(function (pill) {
                if (pill.__aiTab) return;
                pill.__aiTab = true;
                pill.addEventListener("click", function () {
                    pills.forEach(function (p) { p.classList.remove("ai-pill-active"); });
                    pill.classList.add("ai-pill-active");
                    var name = pill.getAttribute("data-tab");
                    document.querySelectorAll('[data-tabpanel="' + group.getAttribute("data-tabs") + '"]').forEach(function (panel) {
                        var match = panel.getAttribute("data-panel-name") === name;
                        panel.style.display = match ? "" : "none";
                        if (match) { panel.classList.remove("ai-revealed"); panel.classList.add("ai-revealed"); }
                    });
                    group.dispatchEvent(new CustomEvent("ai:tabchange", { detail: { tab: name }, bubbles: true }));
                });
            });
        });
    }

    /* ---------------- Toast untuk elemen ber-atribut data-toast ---------------- */
    function bindDataToast(root) {
        (root || document).querySelectorAll("[data-toast]").forEach(function (b) {
            if (b.__aiToast) return;
            b.__aiToast = true;
            b.addEventListener("click", function () {
                window.aiToast(b.getAttribute("data-toast"), b.getAttribute("data-toast-type") || "success");
            });
        });
    }

    /* ---------------- Ripple pada tombol ---------------- */
    function bindRipple(root) {
        (root || document).querySelectorAll(".ai-btn, button").forEach(function (b) {
            if (b.__aiRipple) return;
            b.__aiRipple = true;
            b.addEventListener("click", addRipple);
        });
    }

    /* ---------------- Count-up saat elemen terlihat ---------------- */
    function initCounts() {
        document.querySelectorAll("[data-count]").forEach(function (c) {
            if (c.__aiCount) return;
            c.__aiCount = true;
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (en) {
                    if (en.isIntersecting) { animateCount(en.target); io.unobserve(en.target); }
                });
            }, { threshold: 0.4 });
            io.observe(c);
        });
    }

    /* ---------------- Boot ---------------- */
    function boot() {
        bindDataToast();
        bindRipple();
        initTabs();
        initCounts();
        initReveal();
        loadLucide(function () { window.aiIcons(); });
    }

    if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", boot);
    else boot();

    /* re-init untuk konten dinamis (dipakai script halaman) */
    window.aiRefresh = function () {
        bindDataToast(); bindRipple(); initTabs(); initCounts(); initReveal();
        window.aiIcons();
    };
})();
</script>

<script>
/* ============================================================
   Log Aktivitas — modal JSON perubahan data
   ============================================================ */
    (function () {
      var modalRoot = null;

      function ensureModal() {
        if (modalRoot) return modalRoot;
        modalRoot = document.createElement('div');
        modalRoot.className = 'fixed inset-0 z-[9999] hidden items-center justify-center p-4';
        modalRoot.id = 'logJsonModal';
        modalRoot.innerHTML =
          '<div class="absolute inset-0 bg-slate-900/45 backdrop-blur-[2px]" data-close></div>' +
          '<div class="ai-card relative w-full max-w-xl max-h-[80vh] overflow-auto p-5">' +
          '<div class="flex items-start justify-between gap-3 mb-3">' +
          '<div><div class="text-[16px] font-extrabold text-slate-800" id="logJsonTitle">Detail Log</div>' +
          '<div class="text-[12px] text-slate-500 mt-0.5" id="logJsonActor"></div></div>' +
          '<button type="button" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-500" data-close><i data-lucide="x" class="w-4 h-4"></i></button>' +
          '</div>' +
          '<pre id="logJsonBody" class="bg-slate-50 border border-slate-200 rounded-lg p-3 text-[11.5px] font-mono text-slate-700 overflow-auto max-h-[50vh]"></pre>' +
          '</div>';
        document.body.appendChild(modalRoot);
        modalRoot.addEventListener('click', function (e) {
          if (e.target.closest('[data-close]')) close();
        });
        document.addEventListener('keydown', function (e) {
          if (e.key === 'Escape' && !modalRoot.classList.contains('hidden')) close();
        });
        return modalRoot;
      }

      function open() { var m = ensureModal(); m.classList.remove('hidden'); m.classList.add('flex'); }
      function close() { var m = ensureModal(); m.classList.add('hidden'); m.classList.remove('flex'); }

      window.showLogJson = function (actor, action, changesJson) {
        var m = ensureModal();
        document.getElementById('logJsonTitle').textContent = 'Detail Log — ' + action;
        document.getElementById('logJsonActor').textContent = 'Oleh: ' + actor;
        var body = document.getElementById('logJsonBody');
        try {
          var parsed = JSON.parse(changesJson || '{}');
          body.textContent = JSON.stringify(parsed, null, 2);
        } catch (err) {
          body.textContent = changesJson || '{}';
        }
        open();
        if (window.aiIcons) window.aiIcons();
      };
    })();
</script>

</body>
</html>
