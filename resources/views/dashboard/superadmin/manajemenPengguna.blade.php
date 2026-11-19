<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Pengguna &amp; Hak Akses (RBAC) - Astro Inventory</title>

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
           Astro Inventory — Design System (inlined dari file sumber)
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

        /* Badges & pills */
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

        /* Modal */
        .ai-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 9998;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(3px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.22s ease;
        }
        .ai-modal-overlay.ai-open { opacity: 1; }
        .ai-modal {
            background: #fff;
            border-radius: 18px;
            width: 100%;
            max-width: 560px;
            box-shadow: 0 30px 70px -20px rgba(15, 23, 42, 0.4);
            transform: translateY(22px) scale(0.97);
            transition: transform 0.28s cubic-bezier(0.22, 1, 0.36, 1);
            max-height: 88vh;
            overflow: auto;
        }
        .ai-modal-overlay.ai-open .ai-modal { transform: translateY(0) scale(1); }

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
    <main class="flex-1 p-4 lg:p-6 overflow-x-hidden">

        {{-- ================= SUPER ADMIN ================= --}}
        @if(auth()->user()->isSuperAdmin())

        <nav class="flex items-center gap-1.5 text-[11px] tracking-[0.04em] uppercase mb-2 anim-fade-in">
        <span class="text-slate-400 font-semibold">MANAJEMEN SISTEM</span>
        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
        <span class="text-blue-600 font-bold">MANAJEMEN PENGGUNA &amp; HAK AKSES</span>
    </nav>

        <!-- ============ FLASH MESSAGE ============ -->
        @if(session('success'))
          <div class="mb-4 ai-card p-4 border-l-4 border-emerald-500 bg-emerald-50 text-[13px] text-emerald-800">{{ session('success') }}</div>
        @endif
        @if(session('error'))
          <div class="mb-4 ai-card p-4 border-l-4 border-red-500 bg-red-50 text-[13px] text-red-800">{{ session('error') }}</div>
        @endif
        @if($errors->any())
          <div class="mb-4 ai-card p-4 border-l-4 border-red-500 bg-red-50">
            <div class="text-[13px] font-bold text-red-800 mb-1">Data pengguna tidak dapat disimpan:</div>
            <ul class="list-disc pl-5 text-[12.5px] text-red-700 space-y-0.5">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <!-- ============ HEADER ============ -->
        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4 mb-6 ai-reveal" data-delay="0">
          <div class="max-w-2xl">
            <h1 class="text-[25px] md:text-[29px] font-extrabold text-slate-900 leading-tight">Manajemen Pengguna &amp;<br>Hak Akses (RBAC)</h1>
            <p class="text-[13px] text-slate-500 mt-2 leading-relaxed">Kelola akun pengguna, penetapan peran (role-based access control), hak otorisasi gudang, dan pemantauan status keaktifan staf sistem inventaris {{ auth()->user()->selectedHub->name ?? 'multi-hub' }}.</p>
          </div>
          <div class="flex flex-wrap items-center gap-2.5 flex-none">
            <a href="{{ route('admin.pengguna.export', request()->only(['q','role','status','hub','division','sort','dir'])) }}" class="ai-btn ai-btn-secondary">
              <i data-lucide="download" class="w-4 h-4"></i> Export Data User (CSV)
            </a>
            <button type="button" class="ai-btn ai-btn-secondary opacity-60 cursor-not-allowed" title="Halaman konfigurasi role belum memiliki view/endpoint terpisah." disabled>
              <i data-lucide="shield" class="w-4 h-4"></i> Konfigurasi Peran &amp; Role
            </button>
            <button class="ai-btn ai-btn-primary" data-modal-open="modalTambahUser">
              <i data-lucide="user-plus" class="w-4 h-4"></i> + Tambah Pengguna Baru
            </button>
          </div>
        </div>

        <!-- ============ 4 KARTU STATISTIK ============ -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-5">
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="0">
            <div class="flex items-start justify-between mb-4">
              <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center">
                <i data-lucide="user-plus" class="w-5 h-5 text-blue-600"></i>
              </div>
              <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100">+{{ $stats['new_this_month'] }} Bulan Ini</span>
            </div>
            <div class="flex items-baseline gap-1.5">
              <span class="text-[30px] font-extrabold text-slate-900 leading-none">{{ number_format($stats['total'], 0, ',', '.') }}</span>
              <span class="text-[13px] font-bold text-slate-400">Akun</span>
            </div>
            <div class="text-[13px] font-bold text-slate-700 mt-1.5">Total Pengguna Terdaftar</div>
            <div class="text-[11.5px] text-slate-500 mt-0.5">Tersebar di {{ $divisions->count() }} divisi &amp; {{ $hubs->count() }} hub</div>
          </div>

          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="80">
            <div class="flex items-start justify-between mb-4">
              <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center">
                <i data-lucide="activity" class="w-5 h-5 text-blue-600"></i>
              </div>
              <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100">30 Menit Terakhir</span>
            </div>
            <div class="flex items-baseline gap-1.5">
              <span class="text-[30px] font-extrabold text-slate-900 leading-none">{{ $stats['online'] }}</span>
              <span class="text-[13px] font-bold text-slate-400">Staf</span>
            </div>
            <div class="text-[13px] font-bold text-slate-700 mt-1.5">Pengguna Online</div>
            <div class="text-[11.5px] text-slate-500 mt-0.5">Berdasarkan registry user_sessions</div>
          </div>

          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="160">
            <div class="flex items-start justify-between mb-4">
              <div class="w-11 h-11 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center">
                <i data-lucide="lock" class="w-5 h-5 text-amber-500"></i>
              </div>
              <span class="ai-badge bg-slate-100 text-slate-600 border border-slate-200">2FA Belum Tersedia</span>
            </div>
            <div class="flex items-baseline gap-1.5">
              <span class="text-[30px] font-extrabold text-slate-900 leading-none">—</span>
              <span class="text-[13px] font-bold text-slate-400">Akun</span>
            </div>
            <div class="text-[13px] font-bold text-slate-700 mt-1.5">Menunggu Verifikasi / 2FA</div>
            <div class="text-[11.5px] text-slate-500 mt-0.5">Infrastruktur 2FA belum tersedia</div>
          </div>

          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="240">
            <div class="flex items-start justify-between mb-4">
              <div class="w-11 h-11 rounded-xl bg-red-50 border border-red-100 flex items-center justify-center">
                <i data-lucide="user-x" class="w-5 h-5 text-red-500"></i>
              </div>
              <span class="ai-badge bg-red-50 text-red-600 border border-red-100">Nonaktif</span>
            </div>
            <div class="flex items-baseline gap-1.5">
              <span class="text-[30px] font-extrabold text-slate-900 leading-none">{{ $stats['inactive'] }}</span>
              <span class="text-[13px] font-bold text-slate-400">Akun</span>
            </div>
            <div class="text-[13px] font-bold text-slate-700 mt-1.5">Akun Nonaktif / Ditangguhkan</div>
            <div class="text-[11.5px] text-slate-500 mt-0.5">{{ $stats['active'] }} akun aktif saat ini</div>
          </div>
        </div>

        <!-- ============ PILL PERAN ============ -->
        <div class="flex flex-wrap gap-2 mb-4 ai-reveal" data-delay="120">
          @php
            $filterQuery = request()->except(['role', 'page']);
          @endphp
          <a href="{{ route('admin.pengguna', $filterQuery) }}" class="ai-pill {{ !request('role') ? 'ai-pill-active' : '' }}">Semua Peran ({{ $stats['total'] }})</a>
          @foreach($roles as $role)
            <a href="{{ route('admin.pengguna', array_merge($filterQuery, ['role' => $role->code])) }}"
               class="ai-pill {{ request('role') === $role->code ? 'ai-pill-active' : '' }}">
              {{ $role->name }} ({{ $role->users_count }})
            </a>
          @endforeach
        </div>

        <!-- ============ SEARCH + FILTER ============ -->
        <form method="GET" action="{{ route('admin.pengguna') }}" class="ai-card p-3.5 mb-4 ai-reveal" data-delay="160">
          <div class="flex flex-col lg:flex-row items-stretch lg:items-center gap-2.5">
            <div class="relative flex-1">
              <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
              <input id="cariUser" name="q" value="{{ request('q') }}" class="ai-input !pl-10" placeholder="Cari nama pengguna, username, NIP, atau email" />
            </div>
            <div class="flex flex-wrap items-center gap-2">
              <select name="division" class="ai-input !w-auto !py-2 !text-[12px]">
                <option value="">Semua Divisi</option>
                @foreach($divisions as $division)
                  <option value="{{ $division->id }}" @selected((string) request('division') === (string) $division->id)>{{ $division->nama }}</option>
                @endforeach
              </select>
              <select name="status" class="ai-input !w-auto !py-2 !text-[12px]">
                <option value="">Semua Status</option>
                <option value="active" @selected(request('status') === 'active')>Aktif</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
              </select>
              <select name="hub" class="ai-input !w-auto !py-2 !text-[12px]">
                <option value="">Semua Hub</option>
                @foreach($hubs as $hub)
                  <option value="{{ $hub->id }}" @selected((string) request('hub') === (string) $hub->id)>{{ $hub->name }}</option>
                @endforeach
              </select>
              <input type="hidden" name="sort" value="{{ request('sort', 'created_at') }}">
              <input type="hidden" name="dir" value="{{ request('dir', 'desc') }}">
              <button type="submit" class="ai-btn ai-btn-soft !text-[12px]"><i data-lucide="filter" class="w-3.5 h-3.5"></i> Terapkan</button>
              <a href="{{ route('admin.pengguna') }}" class="ai-btn ai-btn-secondary !text-[12px]"><i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> Reset Filter</a>
            </div>
          </div>
        </form>

        <form id="bulkForm" method="POST" action="{{ route('admin.pengguna.bulk') }}">
          @csrf
          <input type="hidden" name="action" id="bulkAction" value="activate">
        </form>
        <div class="flex flex-wrap items-center gap-2 mb-3">
          <span class="text-[12px] font-bold text-slate-500">Tindakan massal:</span>
          <button type="button" class="ai-btn ai-btn-secondary !py-1.5 !text-[11.5px]" data-bulk="activate"><i class="fas fa-user-check"></i> Aktifkan</button>
          <button type="button" class="ai-btn ai-btn-secondary !py-1.5 !text-[11.5px]" data-bulk="deactivate"><i class="fas fa-user-slash"></i> Nonaktifkan</button>
          <button type="button" class="ai-btn ai-btn-secondary !py-1.5 !text-[11.5px] !text-red-600" data-bulk="delete"><i class="fas fa-trash"></i> Hapus</button>
          <span class="text-[11px] text-slate-400">Centang baris terlebih dahulu.</span>
        </div>

        <!-- ============ TABEL PENGGUNA ============ -->
        <div class="ai-card overflow-hidden mb-5 ai-reveal" data-delay="200">
          <div class="overflow-x-auto">
            <table class="w-full ai-table min-w-[1150px]">
              <thead>
                <tr>
                  <th class="w-10"><input type="checkbox" class="w-4 h-4 rounded border-slate-300 accent-blue-600" /></th>
                  <th>Nama &amp; Identitas Pengguna</th>
                  <th>Peran &amp; Hak Akses</th>
                  <th>Divisi &amp; Penugasan<br>Hub</th>
                  <th>Status 2FA &amp;<br>Keamanan</th>
                  <th>Aktivitas Terakhir</th>
                  <th>Status Akun</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="tabelUser">
                @forelse($users as $u)
                  @php
                    $initials = strtoupper(mb_substr($u->nama_lengkap, 0, 1) . mb_substr((string) strtok((string) $u->nama_lengkap, ' '), 0, 0));
                    $parts = preg_split('/\s+/', trim($u->nama_lengkap));
                    if (count($parts) > 1) { $initials = strtoupper(mb_substr($parts[0], 0, 1) . mb_substr($parts[1], 0, 1)); }
                    $roleColor = match($u->role?->code) {
                      'super_admin' => 'bg-purple-50 text-purple-700 border-purple-100',
                      'kepala_gudang' => 'bg-blue-50 text-blue-700 border-blue-100',
                      'hr' => 'bg-teal-50 text-teal-700 border-teal-100',
                      'pegawai' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                      default => 'bg-amber-50 text-amber-700 border-amber-100',
                    };
                  @endphp
                  <tr data-peran="{{ $u->role?->code }}">
                    <td><input type="checkbox" form="bulkForm" name="user_ids[]" value="{{ $u->id }}" class="w-4 h-4 rounded border-slate-300 accent-blue-600" /></td>
                    <td>
                      <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-600 text-white text-[12px] font-bold flex items-center justify-center flex-none shadow-md shadow-blue-600/25">{{ $initials }}</div>
                        <div class="min-w-0">
                          <div class="text-[13px] font-bold text-slate-800">{{ $u->nama_lengkap }}</div>
                          <div class="text-[11px] text-slate-500 mt-0.5">NIP: {{ $u->nip ?: '-' }}</div>
                          <div class="text-[11px] text-slate-500 truncate max-w-[210px]">{{ $u->email }}</div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="ai-badge border {{ $roleColor }}"><i data-lucide="shield" class="w-3 h-3"></i> {{ $u->role?->name ?? 'Tanpa peran' }}</span>
                    </td>
                    <td class="min-w-[150px]">
                      <div class="text-[12.5px] font-semibold text-slate-700">{{ $u->division?->nama ?? 'Belum ditetapkan' }}</div>
                      <div class="text-[11px] text-slate-500 mt-0.5">{{ $u->selectedHub?->name ?? 'Belum memilih hub' }}</div>
                    </td>
                    <td>
                      <span class="ai-badge bg-slate-100 text-slate-600 border border-slate-200"><i data-lucide="lock" class="w-3 h-3"></i> Belum tersedia</span>
                    </td>
                    <td class="min-w-[130px]">
                      @if($u->last_login_at)
                        <div class="text-[12.5px] font-semibold text-slate-700">{{ $u->last_login_at->diffForHumans() }}</div>
                        <div class="text-[11px] text-slate-500 mt-0.5">{{ $u->last_login_at->format('d M Y H:i') }}</div>
                      @else
                        <div class="text-[12.5px] font-semibold text-slate-500">Belum pernah login</div>
                      @endif
                    </td>
                    <td>
                      @if($u->status === 'active')
                        <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif</span>
                      @else
                        <span class="ai-badge bg-slate-100 text-slate-600 border border-slate-200"><span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Nonaktif</span>
                      @endif
                    </td>
                    <td>
                      <div class="flex items-center gap-0.5 text-slate-400">
                        <button type="button" class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center"
                          data-edit-user="{{ $u->id }}"
                          data-update-url="{{ route('admin.pengguna.update', $u) }}"
                          data-nama="{{ $u->nama_lengkap }}"
                          data-username="{{ $u->username }}"
                          data-email="{{ $u->email }}"
                          data-nip="{{ $u->nip }}"
                          data-phone="{{ $u->phone }}"
                          data-role="{{ $u->role_id }}"
                          data-division="{{ $u->division_id }}"
                          data-hub="{{ $u->selected_hub_id }}"
                          data-status="{{ $u->status }}"
                          title="Ubah data pengguna"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                        <button type="button" class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center"
                          data-history-url="{{ route('admin.pengguna.activity', $u) }}" title="Riwayat aktivitas"><i data-lucide="history" class="w-4 h-4"></i></button>
                        <form method="POST" action="{{ route('admin.pengguna.toggle-status', $u) }}" class="inline">
                          @csrf
                          <button type="submit" class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center" title="{{ $u->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}"><i data-lucide="power" class="w-4 h-4"></i></button>
                        </form>
                        <form method="POST" action="{{ route('admin.pengguna.destroy', $u) }}" class="inline" onsubmit="return confirm('Hapus akun {{ $u->nama_lengkap }}?')">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="w-8 h-8 rounded-lg hover:bg-red-50 hover:text-red-600 flex items-center justify-center" title="Hapus"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8" class="text-center py-10">
                      <div class="flex flex-col items-center gap-2">
                        <i data-lucide="users" class="w-8 h-8 text-slate-300"></i>
                        <div class="text-[13px] font-bold text-slate-500">Tidak ada pengguna yang cocok</div>
                        <div class="text-[11.5px] text-slate-400">Coba ubah kata kunci pencarian atau filter peran.</div>
                      </div>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="flex flex-col md:flex-row items-center justify-between gap-3 px-4 py-3.5 bg-slate-50/80 border-t border-slate-100">
            <div class="flex flex-wrap items-center gap-3 text-[12px] text-slate-500 font-medium">
              <span>Menampilkan {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} dari <span class="font-bold text-slate-700">{{ $users->total() }}</span> Pengguna</span>
              <form method="GET" action="{{ route('admin.pengguna') }}" class="flex items-center gap-2">
                @foreach(request()->except('per_page', 'page') as $key => $value)
                  <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <span>Baris:</span>
                <select name="per_page" class="ai-input !w-auto !py-1.5 !px-2.5 !text-[12px]" onchange="this.form.submit()">
                  @foreach([10, 25, 50] as $size)
                    <option value="{{ $size }}" @selected((int) request('per_page', 10) === $size)>{{ $size }} per halaman</option>
                  @endforeach
                </select>
              </form>
            </div>
            <div class="flex items-center gap-1.5">
              {{ $users->links() }}
            </div>
          </div>
        </div>

        <!-- ============ 3 KARTU INFO ============ -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="0">
            <div class="flex items-center gap-2.5 mb-2.5">
              <i data-lucide="shield-check" class="w-5 h-5 text-blue-600"></i>
              <h3 class="text-[14.5px] font-extrabold text-slate-900">Role-Based Access Control (RBAC)</h3>
            </div>
            <p class="text-[12.5px] text-slate-500 leading-relaxed">Hierarki izin hak akses membatasi tindakan otorisasi pengeluaran, penyesuaian stok opname, dan master data sesuai tingkatan jabatan untuk mencegah kecurangan data inventaris.</p>
            <a href="{{ route('admin.pengaturan') }}" class="text-[12.5px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1 mt-3.5">
              Buka Pengaturan Sistem <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
          </div>

          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="80">
            <div class="flex items-center gap-2.5 mb-2.5">
              <i data-lucide="lock" class="w-5 h-5 text-blue-600"></i>
              <h3 class="text-[14.5px] font-extrabold text-slate-900">Kebijakan Autentikasi 2FA &amp; Password</h3>
            </div>
            <p class="text-[12.5px] text-slate-500 leading-relaxed">Wajib mengaktifkan autentikasi dua faktor (2FA) untuk seluruh akun berpangkat Supervisor ke atas. Rotasi password berkala setiap 90 hari sesuai standar audit ISO 27001.</p>
            <a href="{{ route('admin.pengaturan') }}" class="text-[12.5px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1 mt-3.5">
              Buka Pengaturan Keamanan <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
          </div>

          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="160">
            <div class="flex items-center gap-2.5 mb-2.5">
              <i data-lucide="history" class="w-5 h-5 text-blue-600"></i>
              <h3 class="text-[14.5px] font-extrabold text-slate-900">Audit Log Jejak Digital Staf</h3>
            </div>
            <p class="text-[12.5px] text-slate-500 leading-relaxed">Setiap perubahan status akun, login tidak lazim, reset password, dan pemberian privilege admin dicatat secara permanen dalam Log Aktivitas Forensik sistem.</p>
            <a href="{{ route('admin.log-aktivitas') }}" class="text-[12.5px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1 mt-3.5">
              Buka Log Audit Pengguna <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
          </div>
        </div>

        @endif

    </main>
</div>

<!-- ============ MODAL: TAMBAH PENGGUNA BARU ============ -->
<div id="modalTambahUser" class="ai-modal-overlay" style="display:none">
  <div class="ai-modal">
    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
      <div class="flex items-center gap-2.5">
        <div class="w-9 h-9 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i data-lucide="user-plus" class="w-[18px] h-[18px] text-blue-600"></i></div>
        <div>
          <div class="text-[15px] font-extrabold text-slate-900">Tambah Pengguna Baru</div>
          <div class="text-[11.5px] text-slate-500">Registrasi akun staf &amp; penetapan peran RBAC</div>
        </div>
      </div>
      <button data-modal-close class="w-9 h-9 rounded-xl hover:bg-slate-100 flex items-center justify-center text-slate-500"><i data-lucide="x" class="w-[18px] h-[18px]"></i></button>
    </div>
    <form id="formUser" method="POST" action="{{ route('admin.pengguna.store') }}">
      @csrf
      <input type="hidden" name="_method" id="formUserMethod" value="POST" disabled>
      <div class="px-6 py-5 space-y-3.5">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="text-[12px] font-bold text-slate-600 block mb-1.5">Nama Lengkap</label>
            <input name="nama_lengkap" id="inputNama" value="{{ old('nama_lengkap') }}" class="ai-input" placeholder="cth: Rian Hidayat" required />
          </div>
          <div>
            <label class="text-[12px] font-bold text-slate-600 block mb-1.5">NIP / ID Staf</label>
            <input name="nip" id="inputNip" value="{{ old('nip') }}" class="ai-input" placeholder="AST-2026-xxx" required />
          </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="text-[12px] font-bold text-slate-600 block mb-1.5">Username</label>
            <input name="username" id="inputUsername" value="{{ old('username') }}" class="ai-input" placeholder="rian.hidayat" required />
          </div>
          <div>
            <label class="text-[12px] font-bold text-slate-600 block mb-1.5">Nomor Telepon</label>
            <input name="phone" id="inputPhone" value="{{ old('phone') }}" class="ai-input" placeholder="0812xxxxxxx" />
          </div>
        </div>
        <div>
          <label class="text-[12px] font-bold text-slate-600 block mb-1.5">Email Korporat</label>
          <input type="email" name="email" id="inputEmail" value="{{ old('email') }}" class="ai-input" placeholder="nama@astroinventory.com" required />
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="text-[12px] font-bold text-slate-600 block mb-1.5">Peran &amp; Hak Akses</label>
            <select name="role_id" id="selectRole" class="ai-input" required>
              <option value="">Pilih peran</option>
              @foreach($roles as $role)
                <option value="{{ $role->id }}" @selected((string) old('role_id') === (string) $role->id)>{{ $role->name }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="text-[12px] font-bold text-slate-600 block mb-1.5">Divisi</label>
            <select name="division_id" id="selectDivision" class="ai-input">
              <option value="">Belum ditetapkan</option>
              @foreach($divisions as $division)
                <option value="{{ $division->id }}" @selected((string) old('division_id') === (string) $division->id)>{{ $division->nama }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="text-[12px] font-bold text-slate-600 block mb-1.5">Hub Penugasan</label>
            <select name="selected_hub_id" id="selectHub" class="ai-input">
              <option value="">Belum memilih hub</option>
              @foreach($hubs as $hub)
                <option value="{{ $hub->id }}" @selected((string) old('selected_hub_id') === (string) $hub->id)>{{ $hub->name }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="text-[12px] font-bold text-slate-600 block mb-1.5">Status Akun</label>
            <select name="status" id="selectStatus" class="ai-input" required>
              <option value="active" @selected(old('status') === 'active')>Aktif</option>
              <option value="inactive" @selected(old('status') === 'inactive')>Nonaktif</option>
            </select>
          </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="text-[12px] font-bold text-slate-600 block mb-1.5">Password <span id="passwordHint" class="font-normal text-slate-400">(wajib)</span></label>
            <input type="password" name="password" id="inputPassword" class="ai-input" autocomplete="new-password" />
          </div>
          <div>
            <label class="text-[12px] font-bold text-slate-600 block mb-1.5">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="inputPasswordConfirm" class="ai-input" autocomplete="new-password" />
          </div>
        </div>
        <div class="bg-amber-50 border border-amber-100 rounded-xl px-3.5 py-2.5 text-[11.5px] text-amber-700">
          <i class="fas fa-triangle-exclamation mr-1"></i>
          Verifikasi 2FA belum tersedia pada sistem ini dan tidak dapat diaktifkan dari form ini.
        </div>
      </div>
      <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-2">
        <button type="button" class="ai-btn ai-btn-secondary" data-modal-close>Batal</button>
        <button type="submit" class="ai-btn ai-btn-primary" id="btnSimpanUser"><i data-lucide="check" class="w-4 h-4"></i> <span id="btnSimpanUserLabel">Buat Akun</span></button>
      </div>
    </form>
  </div>
</div>


<script>
/* ============================================================
   Astro Inventory — interaction layer halaman (toast, modal, tabs,
   ripple, reveal, count-up, ikon Lucide).
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

    /* ---------------- Tutup modal saat klik backdrop ---------------- */
    function initModalBackdrop() {
        document.querySelectorAll(".ai-modal-overlay").forEach(function (m) {
            m.addEventListener("click", function (e) {
                if (e.target !== m) return;
                m.classList.remove("ai-open");
                setTimeout(function () { m.style.display = "none"; }, 250);
            });
        });
    }

    /* ---------------- Boot ---------------- */
    function boot() {
        bindDataToast();
        bindRipple();
        initTabs();
        initCounts();
        initReveal();
        initModalBackdrop();
        loadLucide(function () { window.aiIcons(); });
    }

    if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", boot);
    else boot();

    /* re-init untuk konten dinamis */
    window.aiRefresh = function () {
        bindDataToast(); bindRipple(); initTabs(); initCounts(); initReveal(); initModalBackdrop();
        window.aiIcons();
    };
})();
</script>



<!-- ============ MODAL: RIWAYAT AKTIVITAS ============ -->
<div id="modalRiwayat" class="ai-modal-overlay" style="display:none">
  <div class="ai-modal">
    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
      <div>
        <div class="text-[15px] font-extrabold text-slate-900" id="riwayatTitle">Riwayat Aktivitas Pengguna</div>
        <div class="text-[11.5px] text-slate-500">Sumber: audit_logs &amp; user_sessions</div>
      </div>
      <button type="button" data-modal-close class="w-9 h-9 rounded-xl hover:bg-slate-100 flex items-center justify-center text-slate-500"><i data-lucide="x" class="w-[18px] h-[18px]"></i></button>
    </div>
    <div id="riwayatContent" class="px-6 py-5 text-[12.5px] text-slate-500">Memuat...</div>
  </div>
</div>

<script>
    (function () {
      "use strict";
      /* ---------- Modal Tambah / Ubah Pengguna ---------- */
      var modal = document.getElementById('modalTambahUser');
      var form = document.getElementById('formUser');
      var methodField = document.getElementById('formUserMethod');
      var createAction = form.getAttribute('action');
      var titleEl = modal.querySelector('.text-\\[15px\\].font-extrabold');
      var subtitleEl = modal.querySelector('.text-\\[11\\.5px\\]');
      var passwordHint = document.getElementById('passwordHint');
      var saveLabel = document.getElementById('btnSimpanUserLabel');

      function openModal(m) {
        m.style.display = 'flex';
        requestAnimationFrame(function () { m.classList.add('ai-open'); });
      }
      function closeModal(m) {
        m.classList.remove('ai-open');
        setTimeout(function () { m.style.display = 'none'; }, 250);
      }

      document.querySelectorAll('[data-modal-open]').forEach(function (b) {
        b.addEventListener('click', function () {
          resetCreateForm();
          openModal(modal);
        });
      });
      document.querySelectorAll('[data-modal-close]').forEach(function (b) {
        b.addEventListener('click', function () {
          var m = b.closest('.ai-modal-overlay');
          if (m) closeModal(m);
        });
      });
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
          document.querySelectorAll('.ai-modal-overlay').forEach(function (m) { closeModal(m); });
        }
      });

      function resetCreateForm() {
        form.reset();
        form.setAttribute('action', createAction);
        methodField.value = 'POST';
        methodField.disabled = true;
        titleEl.textContent = 'Tambah Pengguna Baru';
        subtitleEl.textContent = 'Registrasi akun staf & penetapan peran RBAC';
        passwordHint.textContent = '(wajib)';
        saveLabel.textContent = 'Buat Akun';
        document.getElementById('inputPassword').required = true;
      }

      document.querySelectorAll('[data-edit-user]').forEach(function (button) {
        button.addEventListener('click', function () {
          var d = button.dataset;
          form.setAttribute('action', d.updateUrl);
          methodField.value = 'PUT';
          methodField.disabled = false;
          document.getElementById('inputNama').value = d.nama || '';
          document.getElementById('inputUsername').value = d.username || '';
          document.getElementById('inputEmail').value = d.email || '';
          document.getElementById('inputNip').value = d.nip || '';
          document.getElementById('inputPhone').value = d.phone || '';
          document.getElementById('selectRole').value = d.role || '';
          document.getElementById('selectDivision').value = d.division || '';
          document.getElementById('selectHub').value = d.hub || '';
          document.getElementById('selectStatus').value = d.status || 'active';
          document.getElementById('inputPassword').value = '';
          document.getElementById('inputPasswordConfirm').value = '';
          document.getElementById('inputPassword').required = false;
          titleEl.textContent = 'Ubah Data Pengguna';
          subtitleEl.textContent = 'Perbarui identitas, peran, penugasan, atau status akun';
          passwordHint.textContent = '(kosongkan bila tidak diubah)';
          saveLabel.textContent = 'Simpan Perubahan';
          openModal(modal);
        });
      });

      /* ---------- Riwayat aktivitas ---------- */
      var riwayatModal = document.getElementById('modalRiwayat');
      function esc(value) {
        return String(value == null ? '' : value).replace(/[&<>"']/g, function (c) {
          return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
      }
      document.querySelectorAll('[data-history-url]').forEach(function (button) {
        button.addEventListener('click', function () {
          var content = document.getElementById('riwayatContent');
          content.innerHTML = 'Memuat...';
          openModal(riwayatModal);
          fetch(button.dataset.historyUrl, { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.json(); })
            .then(function (payload) {
              document.getElementById('riwayatTitle').textContent = 'Riwayat Aktivitas: ' + (payload.user ? payload.user.nama_lengkap : '');
              var logs = (payload.audit_logs || []).map(function (log) {
                return '<div class="border border-slate-100 rounded-xl p-3 mb-2"><div class="flex items-center justify-between gap-2"><div class="font-bold text-slate-800">' + esc(log.description || log.action) + '</div><span class="text-[11px] text-slate-400">' + esc(log.created_at || '') + '</span></div><div class="text-[11px] text-slate-500 mt-1">Aksi: ' + esc(log.action) + ' • Hasil: ' + esc(log.result) + '</div></div>';
              }).join('');
              var sessions = (payload.sessions || []).map(function (s) {
                return '<div class="border border-slate-100 rounded-xl p-3 mb-2"><div class="font-bold text-slate-800">' + esc(s.device_name || 'Perangkat') + ' • ' + esc(s.browser || '-') + '</div><div class="text-[11px] text-slate-500 mt-1">' + esc(s.platform || '-') + ' • IP ' + esc(s.ip_address || '-') + ' • ' + esc(s.status || '-') + ' • ' + esc(s.last_activity_at || '-') + '</div></div>';
              }).join('');
              content.innerHTML = '<div class="text-[12px] font-extrabold text-slate-700 mb-2">Jejak Audit</div>' + (logs || '<div class="text-slate-400 mb-4">Belum ada jejak audit.</div>') + '<div class="text-[12px] font-extrabold text-slate-700 mt-4 mb-2">Sesi Perangkat</div>' + (sessions || '<div class="text-slate-400">Belum ada sesi tercatat.</div>');
            })
            .catch(function () { content.innerHTML = '<div class="text-red-600">Gagal memuat riwayat aktivitas.</div>'; });
        });
      });

      /* ---------- Tindakan massal ---------- */
      document.querySelectorAll('[data-bulk]').forEach(function (button) {
        button.addEventListener('click', function () {
          var action = button.dataset.bulk;
          var checked = document.querySelectorAll('#tabelUser input[name="user_ids[]"]:checked');
          if (!checked.length) { window.aiToast('Centang minimal satu pengguna terlebih dahulu.', 'warn'); return; }
          var labels = { activate: 'mengaktifkan', deactivate: 'menonaktifkan', delete: 'menghapus' };
          if (!confirm('Yakin ' + labels[action] + ' ' + checked.length + ' pengguna terpilih?')) return;
          document.getElementById('bulkAction').value = action;
          document.getElementById('bulkForm').submit();
        });
      });

      /* Buka modal otomatis saat validasi gagal */
      @if($errors->any())
        resetCreateForm();
        openModal(modal);
      @endif
    })();
</script>


</body>
</html>
