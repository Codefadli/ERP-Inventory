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

        <!-- ============ HEADER ============ -->
        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4 mb-6 ai-reveal" data-delay="0">
          <div class="max-w-2xl">
            <h1 class="text-[25px] md:text-[29px] font-extrabold text-slate-900 leading-tight">Manajemen Pengguna &amp;<br>Hak Akses (RBAC)</h1>
            <p class="text-[13px] text-slate-500 mt-2 leading-relaxed">Kelola akun pengguna, penetapan peran (role-based access control), hak otorisasi gudang, dan pemantauan status keaktifan staf sistem inventaris Hub Cakung DC-01.</p>
          </div>
          <div class="flex flex-wrap items-center gap-2.5 flex-none">
            <button class="ai-btn ai-btn-secondary" data-toast="Data user diekspor ke Excel (demo).">
              <i data-lucide="download" class="w-4 h-4"></i> Export Data User
            </button>
            <button class="ai-btn ai-btn-secondary" data-toast="Membuka Konfigurasi Peran & Role...">
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
              <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100">+4 Akun Baru (Bulan Ini)</span>
            </div>
            <div class="flex items-baseline gap-1.5">
              <span class="text-[30px] font-extrabold text-slate-900 leading-none"><span data-count="48">0</span></span>
              <span class="text-[13px] font-bold text-slate-400">Akun</span>
            </div>
            <div class="text-[13px] font-bold text-slate-700 mt-1.5">Total Pengguna Terdaftar</div>
            <div class="text-[11.5px] text-slate-500 mt-0.5">Tersebar di 6 divisi operasional &amp; gudang</div>
          </div>

          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="80">
            <div class="flex items-start justify-between mb-4">
              <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center">
                <i data-lucide="activity" class="w-5 h-5 text-blue-600"></i>
              </div>
              <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100">Shift Pagi Berjalan</span>
            </div>
            <div class="flex items-baseline gap-1.5">
              <span class="text-[30px] font-extrabold text-slate-900 leading-none"><span data-count="18">0</span></span>
              <span class="text-[13px] font-bold text-slate-400">Staf</span>
            </div>
            <div class="text-[13px] font-bold text-slate-700 mt-1.5">Pengguna Aktif (Online)</div>
            <div class="text-[11.5px] text-slate-500 mt-0.5">Hub Cakung DC-01 &amp; Head Office</div>
          </div>

          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="160">
            <div class="flex items-start justify-between mb-4">
              <div class="w-11 h-11 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center">
                <i data-lucide="lock" class="w-5 h-5 text-amber-500"></i>
              </div>
              <span class="ai-badge bg-amber-50 text-amber-700 border border-amber-100">Perlu Otorisasi Admin</span>
            </div>
            <div class="flex items-baseline gap-1.5">
              <span class="text-[30px] font-extrabold text-slate-900 leading-none"><span data-count="3">0</span></span>
              <span class="text-[13px] font-bold text-slate-400">Akun</span>
            </div>
            <div class="text-[13px] font-bold text-slate-700 mt-1.5">Menunggu Verifikasi / 2FA</div>
            <div class="text-[11.5px] text-slate-500 mt-0.5">Staf baru rotasi divisi inbound/outbound</div>
          </div>

          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="240">
            <div class="flex items-start justify-between mb-4">
              <div class="w-11 h-11 rounded-xl bg-red-50 border border-red-100 flex items-center justify-center">
                <i data-lucide="user-x" class="w-5 h-5 text-red-500"></i>
              </div>
              <span class="ai-badge bg-red-50 text-red-600 border border-red-100">Audit Keamanan Berkala</span>
            </div>
            <div class="flex items-baseline gap-1.5">
              <span class="text-[30px] font-extrabold text-slate-900 leading-none"><span data-count="2">0</span></span>
              <span class="text-[13px] font-bold text-slate-400">Akun</span>
            </div>
            <div class="text-[13px] font-bold text-slate-700 mt-1.5">Akun Nonaktif / Ditangguhkan</div>
            <div class="text-[11.5px] text-slate-500 mt-0.5">1 mutasi luar kota, 1 masa cuti</div>
          </div>
        </div>

        <!-- ============ PILL PERAN ============ -->
        <div data-tabs="peran" class="flex flex-wrap gap-2 mb-4 ai-reveal" data-delay="120">
          <button class="ai-pill ai-pill-active" data-tab="semua">Semua Peran (48)</button>
          <button class="ai-pill" data-tab="superadmin">Super Admin (3)</button>
          <button class="ai-pill" data-tab="kepala">Kepala Gudang / DC Manager (5)</button>
          <button class="ai-pill" data-tab="supervisor">Supervisor Logistik (8)</button>
          <button class="ai-pill" data-tab="admin">Admin Purchasing &amp; Inbound (12)</button>
          <button class="ai-pill" data-tab="picker">Picker &amp; Checker Outbound (14)</button>
          <button class="ai-pill" data-tab="auditor">Internal Auditor &amp; Finance (3)</button>
        </div>

        <!-- ============ SEARCH + FILTER ============ -->
        <div class="ai-card p-3.5 mb-4 ai-reveal" data-delay="160">
          <div class="flex flex-col lg:flex-row items-stretch lg:items-center gap-2.5">
            <div class="relative flex-1">
              <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
              <input id="cariUser" class="ai-input !pl-10" placeholder="Cari nama pengguna, NIK/ID staf, email," />
            </div>
            <div class="flex flex-wrap items-center gap-2">
              <button class="ai-btn ai-btn-secondary !text-[12px]" data-toast="Filter Divisi dibuka: Semua Divisi.">Divisi: <span class="font-extrabold">Semua Divisi</span> <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i></button>
              <button class="ai-btn ai-btn-secondary !text-[12px]" data-toast="Filter Status dibuka: Semua Status.">Status: <span class="font-extrabold">Semua Status</span> <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i></button>
              <button class="ai-btn ai-btn-secondary !text-[12px]" data-toast="Filter Akses Hub: Cakung DC-01.">Akses Hub: <span class="font-extrabold">Cakung DC-01</span> <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i></button>
              <button class="ai-btn ai-btn-secondary !text-[12px]" id="btnResetFilter"><i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i> Reset Filter</button>
              <button class="ai-btn ai-btn-soft !text-[12px]" data-toast="Menu Tindakan Massal dibuka."><i data-lucide="list-checks" class="w-3.5 h-3.5"></i> Tindakan Massal</button>
            </div>
          </div>
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
                <!-- Budi Santoso -->
                <tr data-peran="superadmin">
                  <td><input type="checkbox" class="w-4 h-4 rounded border-slate-300 accent-blue-600" /></td>
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 rounded-full bg-blue-600 text-white text-[12px] font-bold flex items-center justify-center flex-none shadow-md shadow-blue-600/25">BS</div>
                      <div class="min-w-0">
                        <div class="text-[13px] font-bold text-slate-800">Budi Santoso, S.T.</div>
                        <div class="text-[11px] text-slate-500 mt-0.5">NIK: AST-2021-001</div>
                        <div class="text-[11px] text-slate-500 truncate max-w-[210px]">budi.santoso@astroinventory.co</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="ai-badge bg-purple-50 text-purple-700 border border-purple-100"><i data-lucide="shield" class="w-3 h-3"></i> Super Admin</span>
                  </td>
                  <td class="min-w-[150px]">
                    <div class="text-[12.5px] font-semibold text-slate-700">IT &amp; Sistem Operasional</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Hub Cakung DC-01 &amp; Nasional</div>
                  </td>
                  <td>
                    <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100"><i data-lucide="key-round" class="w-3 h-3"></i> Hardware Key / OTP</span>
                  </td>
                  <td class="min-w-[130px]">
                    <div class="flex items-center gap-1.5 text-[12.5px] font-bold text-emerald-600"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 flex-none"></span> Sedang Aktif Sekarang</div>
                  </td>
                  <td><span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif</span></td>
                  <td>
                    <div class="flex items-center gap-0.5 text-slate-400">
                      <button class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center" data-toast="Mode edit profil Budi Santoso dibuka."><i data-lucide="pencil" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center" data-toast="Riwayat aktivitas Budi Santoso dibuka."><i data-lucide="history" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center" data-toast="Menu aksi tambahan dibuka."><i data-lucide="more-horizontal" class="w-4 h-4"></i></button>
                    </div>
                  </td>
                </tr>

                <!-- Ir. Bambang Sugiarto -->
                <tr data-peran="kepala">
                  <td><input type="checkbox" class="w-4 h-4 rounded border-slate-300 accent-blue-600" /></td>
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 rounded-full bg-sky-100 text-sky-700 text-[12px] font-bold flex items-center justify-center flex-none">BS</div>
                      <div class="min-w-0">
                        <div class="text-[13px] font-bold text-slate-800">Ir. Bambang Sugiarto</div>
                        <div class="text-[11px] text-slate-500 mt-0.5">NIK: AST-2019-014</div>
                        <div class="text-[11px] text-slate-500 truncate max-w-[210px]">bambang.s@astroinventory.cor</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100"><i data-lucide="warehouse" class="w-3 h-3"></i> Kepala Gudang DC</span>
                  </td>
                  <td class="min-w-[150px]">
                    <div class="text-[12.5px] font-semibold text-slate-700">Operasional &amp; Pergudangan</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Hub Cakung DC-01</div>
                  </td>
                  <td>
                    <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100"><i data-lucide="smartphone" class="w-3 h-3"></i> Google Authenticator</span>
                  </td>
                  <td class="min-w-[130px]">
                    <div class="text-[12.5px] font-semibold text-slate-700">12 menit yang lalu</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Verifikasi Inbound #IN-889</div>
                  </td>
                  <td><span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif</span></td>
                  <td>
                    <div class="flex items-center gap-0.5 text-slate-400">
                      <button class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center" data-toast="Mode edit profil Ir. Bambang Sugiarto dibuka."><i data-lucide="pencil" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center" data-toast="Riwayat aktivitas Ir. Bambang Sugiarto dibuka."><i data-lucide="history" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center" data-toast="Menu aksi tambahan dibuka."><i data-lucide="more-horizontal" class="w-4 h-4"></i></button>
                    </div>
                  </td>
                </tr>

                <!-- Maya Anggraini -->
                <tr data-peran="auditor">
                  <td><input type="checkbox" class="w-4 h-4 rounded border-slate-300 accent-blue-600" /></td>
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-700 text-[12px] font-bold flex items-center justify-center flex-none">MA</div>
                      <div class="min-w-0">
                        <div class="text-[13px] font-bold text-slate-800">Maya Anggraini, S.E.</div>
                        <div class="text-[11px] text-slate-500 mt-0.5">NIK: AST-2022-045</div>
                        <div class="text-[11px] text-slate-500 truncate max-w-[210px]">maya.anggraini@astroinventory.</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="ai-badge bg-amber-50 text-amber-700 border border-amber-100"><i data-lucide="badge-check" class="w-3 h-3"></i> Internal Auditor &amp; Finance</span>
                  </td>
                  <td class="min-w-[150px]">
                    <div class="text-[12.5px] font-semibold text-slate-700">Finance, Asset &amp; Compliance</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Head Office &amp; Multi-Hub</div>
                  </td>
                  <td>
                    <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100"><i data-lucide="shield-check" class="w-3 h-3"></i> 2FA Aktif (Authenticator)</span>
                  </td>
                  <td class="min-w-[130px]">
                    <div class="text-[12.5px] font-semibold text-slate-700">45 menit yang lalu</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Review Stok Opname Q3</div>
                  </td>
                  <td><span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif</span></td>
                  <td>
                    <div class="flex items-center gap-0.5 text-slate-400">
                      <button class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center" data-toast="Mode edit profil Maya Anggraini dibuka."><i data-lucide="pencil" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center" data-toast="Riwayat aktivitas Maya Anggraini dibuka."><i data-lucide="history" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center" data-toast="Menu aksi tambahan dibuka."><i data-lucide="more-horizontal" class="w-4 h-4"></i></button>
                    </div>
                  </td>
                </tr>

                <!-- Adrian Pratama -->
                <tr data-peran="supervisor">
                  <td><input type="checkbox" class="w-4 h-4 rounded border-slate-300 accent-blue-600" /></td>
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 text-[12px] font-bold flex items-center justify-center flex-none">AP</div>
                      <div class="min-w-0">
                        <div class="text-[13px] font-bold text-slate-800">Adrian Pratama</div>
                        <div class="text-[11px] text-slate-500 mt-0.5">NIK: AST-2023-089</div>
                        <div class="text-[11px] text-slate-500 truncate max-w-[210px]">adrian.p@astroinventory.com</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100"><i data-lucide="send" class="w-3 h-3"></i> Supervisor Logistik</span>
                  </td>
                  <td class="min-w-[150px]">
                    <div class="text-[12.5px] font-semibold text-slate-700">Outbound &amp; Dispatching</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Hub Cakung DC-01</div>
                  </td>
                  <td>
                    <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100"><i data-lucide="shield-check" class="w-3 h-3"></i> 2FA Aktif (Authenticator)</span>
                  </td>
                  <td class="min-w-[130px]">
                    <div class="text-[12.5px] font-semibold text-slate-700">1 jam yang lalu</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Approval Surat Jalan DO-402</div>
                  </td>
                  <td><span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif</span></td>
                  <td>
                    <div class="flex items-center gap-0.5 text-slate-400">
                      <button class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center" data-toast="Mode edit profil Adrian Pratama dibuka."><i data-lucide="pencil" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center" data-toast="Riwayat aktivitas Adrian Pratama dibuka."><i data-lucide="history" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center" data-toast="Menu aksi tambahan dibuka."><i data-lucide="more-horizontal" class="w-4 h-4"></i></button>
                    </div>
                  </td>
                </tr>

                <!-- Dedi Kurniawan -->
                <tr data-peran="admin">
                  <td><input type="checkbox" class="w-4 h-4 rounded border-slate-300 accent-blue-600" /></td>
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 text-[12px] font-bold flex items-center justify-center flex-none">DK</div>
                      <div class="min-w-0">
                        <div class="text-[13px] font-bold text-slate-800">Dedi Kurniawan</div>
                        <div class="text-[11px] text-slate-500 mt-0.5">NIK: AST-2024-112</div>
                        <div class="text-[11px] text-slate-500 truncate max-w-[210px]">dedi.kurniawan@astroinventory.</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100"><i data-lucide="clipboard-check" class="w-3 h-3"></i> Admin Inbound &amp; QC</span>
                  </td>
                  <td class="min-w-[150px]">
                    <div class="text-[12.5px] font-semibold text-slate-700">Penerimaan &amp; Receiving</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Hub Cakung DC-01</div>
                  </td>
                  <td>
                    <span class="ai-badge bg-amber-50 text-amber-700 border border-amber-100"><i data-lucide="clock" class="w-3 h-3"></i> Menunggu Aktivasi</span>
                  </td>
                  <td class="min-w-[130px]">
                    <div class="text-[12.5px] font-semibold text-slate-700">Hari ini, 08:30 WIB</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Login Pertama Kali (Setup Akun)</div>
                  </td>
                  <td><span class="ai-badge bg-slate-100 text-slate-600 border border-slate-200"><span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Menunggu Verifikasi</span></td>
                  <td>
                    <div class="flex items-center gap-0.5 text-slate-400">
                      <button class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center" data-toast="Email aktivasi dikirim ulang ke Dedi Kurniawan."><i data-lucide="mail" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center" data-toast="Mode edit profil Dedi Kurniawan dibuka."><i data-lucide="pencil" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center" data-toast="Menu aksi tambahan dibuka."><i data-lucide="more-horizontal" class="w-4 h-4"></i></button>
                    </div>
                  </td>
                </tr>

                <!-- Hendra Kusuma -->
                <tr data-peran="picker">
                  <td><input type="checkbox" class="w-4 h-4 rounded border-slate-300 accent-blue-600" /></td>
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-600 text-[12px] font-bold flex items-center justify-center flex-none">HK</div>
                      <div class="min-w-0">
                        <div class="text-[13px] font-bold text-slate-800">Hendra Kusuma</div>
                        <div class="text-[11px] text-slate-500 mt-0.5">NIK: AST-2020-038</div>
                        <div class="text-[11px] text-slate-500 truncate max-w-[210px]">hendra.kusuma@astroinventory</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="ai-badge bg-slate-100 text-slate-600 border border-slate-200"><i data-lucide="shield" class="w-3 h-3"></i> Safety Officer &amp; Checker</span>
                  </td>
                  <td class="min-w-[150px]">
                    <div class="text-[12.5px] font-semibold text-slate-700">HSE &amp; Pengawasan Gudang</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Hub Cakung DC-01</div>
                  </td>
                  <td>
                    <span class="ai-badge bg-slate-100 text-slate-600 border border-slate-200"><i data-lucide="lock" class="w-3 h-3"></i> Dinonaktifkan Sementara</span>
                  </td>
                  <td class="min-w-[130px]">
                    <div class="text-[12.5px] font-semibold text-slate-700">3 hari yang lalu</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Login Terakhir via Web Mobile</div>
                  </td>
                  <td><span class="ai-badge bg-slate-100 text-slate-600 border border-slate-200"><span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Ditangguhkan (Cuti)</span></td>
                  <td>
                    <div class="flex items-center gap-0.5 text-slate-400">
                      <button class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center" data-toast="Status keaktifan Hendra Kusuma diperbarui."><i data-lucide="power" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center" data-toast="Mode edit profil Hendra Kusuma dibuka."><i data-lucide="pencil" class="w-4 h-4"></i></button>
                      <button class="w-8 h-8 rounded-lg hover:bg-slate-100 hover:text-blue-600 flex items-center justify-center" data-toast="Menu aksi tambahan dibuka."><i data-lucide="more-horizontal" class="w-4 h-4"></i></button>
                    </div>
                  </td>
                </tr>

                <!-- Empty state -->
                <tr id="barisKosongUser" style="display:none">
                  <td colspan="8" class="text-center py-10">
                    <div class="flex flex-col items-center gap-2">
                      <i data-lucide="users" class="w-8 h-8 text-slate-300"></i>
                      <div class="text-[13px] font-bold text-slate-500">Tidak ada pengguna yang cocok</div>
                      <div class="text-[11.5px] text-slate-400">Coba ubah kata kunci pencarian atau filter peran.</div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="flex flex-col md:flex-row items-center justify-between gap-3 px-4 py-3.5 bg-slate-50/80 border-t border-slate-100">
            <div class="flex flex-wrap items-center gap-3 text-[12px] text-slate-500 font-medium">
              <span>Menampilkan 1-6 dari <span class="font-bold text-slate-700">48</span> Pengguna</span>
              <span class="flex items-center gap-2">Baris:
                <select class="ai-input !w-auto !py-1.5 !px-2.5 !text-[12px]"><option>10 per halaman</option><option>25 per halaman</option><option>50 per halaman</option></select>
              </span>
            </div>
            <div class="flex items-center gap-1.5">
              <button class="ai-btn ai-btn-secondary !py-1.5 !px-3 !text-[12px] opacity-50" data-toast="Halaman sebelumnya"><i data-lucide="chevron-left" class="w-3.5 h-3.5"></i> Sebelumnya</button>
              <button class="w-8 h-8 rounded-lg bg-blue-600 text-white text-[12.5px] font-bold flex items-center justify-center">1</button>
              <button class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-600 text-[12.5px] font-semibold flex items-center justify-center hover:bg-slate-100" data-toast="Halaman 2">2</button>
              <button class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-600 text-[12.5px] font-semibold flex items-center justify-center hover:bg-slate-100" data-toast="Halaman 3">3</button>
              <button class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-600 text-[12.5px] font-semibold flex items-center justify-center hover:bg-slate-100" data-toast="Halaman 4">4</button>
              <button class="ai-btn ai-btn-secondary !py-1.5 !px-3 !text-[12px]" data-toast="Halaman berikutnya">Berikutnya <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i></button>
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
            <button class="text-[12.5px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1 mt-3.5" data-toast="Membuka Matriks Peran & Wewenang...">
              Lihat Matriks Peran &amp; Wewenang <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </button>
          </div>

          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="80">
            <div class="flex items-center gap-2.5 mb-2.5">
              <i data-lucide="lock" class="w-5 h-5 text-blue-600"></i>
              <h3 class="text-[14.5px] font-extrabold text-slate-900">Kebijakan Autentikasi 2FA &amp; Password</h3>
            </div>
            <p class="text-[12.5px] text-slate-500 leading-relaxed">Wajib mengaktifkan autentikasi dua faktor (2FA) untuk seluruh akun berpangkat Supervisor ke atas. Rotasi password berkala setiap 90 hari sesuai standar audit ISO 27001.</p>
            <button class="text-[12.5px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1 mt-3.5" data-toast="Membuka Kelola Kebijakan Sandi...">
              Kelola Kebijakan Sandi <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </button>
          </div>

          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="160">
            <div class="flex items-center gap-2.5 mb-2.5">
              <i data-lucide="history" class="w-5 h-5 text-blue-600"></i>
              <h3 class="text-[14.5px] font-extrabold text-slate-900">Audit Log Jejak Digital Staf</h3>
            </div>
            <p class="text-[12.5px] text-slate-500 leading-relaxed">Setiap perubahan status akun, login tidak lazim, reset password, dan pemberian privilege admin dicatat secara permanen dalam Log Aktivitas Forensik sistem.</p>
            <button class="text-[12.5px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1 mt-3.5" data-toast="Membuka Log Audit Pengguna...">
              Buka Log Audit Pengguna <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </button>
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
    <div class="px-6 py-5 space-y-3.5">
      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="text-[12px] font-bold text-slate-600 block mb-1.5">Nama Lengkap</label>
          <input class="ai-input" placeholder="cth: Rian Hidayat" />
        </div>
        <div>
          <label class="text-[12px] font-bold text-slate-600 block mb-1.5">NIK / ID Staf</label>
          <input class="ai-input" placeholder="AST-2026-xxx" />
        </div>
      </div>
      <div>
        <label class="text-[12px] font-bold text-slate-600 block mb-1.5">Email Korporat</label>
        <input type="email" class="ai-input" placeholder="nama@astroinventory.com" />
      </div>
      <div class="grid grid-cols-2 gap-3">
        <div>
          <label class="text-[12px] font-bold text-slate-600 block mb-1.5">Peran &amp; Hak Akses</label>
          <select class="ai-input">
            <option>Admin Inbound &amp; QC</option>
            <option>Supervisor Logistik</option>
            <option>Kepala Gudang DC</option>
            <option>Admin Purchasing &amp; Inbound</option>
            <option>Picker &amp; Checker Outbound</option>
            <option>Internal Auditor &amp; Finance</option>
            <option>Super Admin</option>
          </select>
        </div>
        <div>
          <label class="text-[12px] font-bold text-slate-600 block mb-1.5">Divisi &amp; Penugasan</label>
          <select class="ai-input">
            <option>Penerimaan &amp; Receiving — Hub Cakung DC-01</option>
            <option>Outbound &amp; Dispatching — Hub Cakung DC-01</option>
            <option>Operasional &amp; Pergudangan — Hub Cakung DC-01</option>
            <option>IT &amp; Sistem Operasional — Nasional</option>
            <option>Finance, Asset &amp; Compliance — Head Office</option>
          </select>
        </div>
      </div>
      <div>
        <label class="text-[12px] font-bold text-slate-600 block mb-1.5">Metode 2FA Awal</label>
        <div class="flex flex-wrap gap-2">
          <button class="ai-pill ai-pill-active !py-1.5 !px-4 !text-[12px]">Google Authenticator</button>
          <button class="ai-pill !py-1.5 !px-4 !text-[12px]">Hardware Key / OTP</button>
          <button class="ai-pill !py-1.5 !px-4 !text-[12px]">Aktivasi Nanti</button>
        </div>
      </div>
    </div>
    <div class="px-6 py-4 border-t border-slate-100 flex justify-end gap-2">
      <button class="ai-btn ai-btn-secondary" data-modal-close>Batal</button>
      <button class="ai-btn ai-btn-primary" id="btnSimpanUser"><i data-lucide="check" class="w-4 h-4"></i> Buat Akun &amp; Kirim Undangan</button>
    </div>
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



<script>
    (function () {
      "use strict";

      /* ---------- Modal Tambah Pengguna ---------- */
      document.querySelectorAll('[data-modal-open]').forEach(function (b) {
        b.addEventListener('click', function () {
          var m = document.getElementById(b.getAttribute('data-modal-open'));
          m.style.display = 'flex';
          requestAnimationFrame(function () { m.classList.add('ai-open'); });
        });
      });
      document.querySelectorAll('[data-modal-close]').forEach(function (b) {
        b.addEventListener('click', function () {
          var m = b.closest('.ai-modal-overlay');
          m.classList.remove('ai-open');
          setTimeout(function () { m.style.display = 'none'; }, 250);
        });
      });
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
          document.querySelectorAll('.ai-modal-overlay').forEach(function (m) {
            m.classList.remove('ai-open'); m.style.display = 'none';
          });
        }
      });

      var btnUser = document.getElementById('btnSimpanUser');
      if (btnUser) btnUser.addEventListener('click', function () {
        var m = document.getElementById('modalTambahUser');
        m.classList.remove('ai-open'); setTimeout(function () { m.style.display = 'none'; }, 250);
        window.aiToast('Akun pengguna dibuat & undangan setup terkirim via email.', 'success');
      });

      /* ---------- Filter pill peran + search ---------- */
      var tbody = document.getElementById('tabelUser');
      var cari = document.getElementById('cariUser');
      var kosong = document.getElementById('barisKosongUser');
      var peranAktif = 'semua';

      function terapkanFilter() {
        var kata = cari ? cari.value.trim().toLowerCase() : '';
        var tampil = 0;
        tbody.querySelectorAll('tr[data-peran]').forEach(function (r) {
          var cocokPeran = peranAktif === 'semua' || r.getAttribute('data-peran') === peranAktif;
          var cocokCari = !kata || r.textContent.toLowerCase().indexOf(kata) > -1;
          var ok = cocokPeran && cocokCari;
          r.style.display = ok ? '' : 'none';
          if (ok) tampil++;
        });
        if (kosong) kosong.style.display = tampil ? 'none' : '';
      }

      document.querySelectorAll('[data-tabs="peran"] [data-tab]').forEach(function (pill) {
        pill.addEventListener('click', function () {
          peranAktif = pill.getAttribute('data-tab');
          terapkanFilter();
        });
      });
      if (cari) cari.addEventListener('input', terapkanFilter);

      var btnReset = document.getElementById('btnResetFilter');
      if (btnReset) btnReset.addEventListener('click', function () {
        peranAktif = 'semua';
        if (cari) cari.value = '';
        document.querySelectorAll('[data-tabs="peran"] [data-tab]').forEach(function (p) {
          p.classList.toggle('ai-pill-active', p.getAttribute('data-tab') === 'semua');
        });
        terapkanFilter();
        window.aiToast('Filter telah direset ke pengaturan awal.', 'info');
      });
    })();
</script>


</body>
</html>
