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
            <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100"><span class="ai-live-dot" style="background:#2563eb"></span>STREAM: ACTIVE</span>
          </div>
          <div class="hidden lg:flex items-center gap-1.5 text-[11.5px] font-semibold text-slate-500">
            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
            Audit Trail ISO 27001 Certified &bull; Node Cakung-DC01-PROD
          </div>
        </div>

        <!-- ===== Header card ===== -->
        <section class="ai-card ai-card-hover ai-reveal p-6">
          <div class="flex flex-col gap-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
              <div class="flex flex-wrap items-center gap-x-3 gap-y-2 min-w-0">
                <h1 class="text-[22px] sm:text-[25px] 2xl:text-[28px] font-extrabold text-slate-800 leading-tight tracking-tight">Log Aktivitas &amp; Audit Trail Forensik</h1>
                <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>REALTIME 10ms</span>
              </div>
              <div class="flex flex-wrap items-center gap-2.5 ml-auto">
                <button class="ai-btn ai-btn-secondary" data-toast="Rentang waktu diubah: Hari Ini (2 Mar 2025)" data-toast-type="info">
                  <i data-lucide="calendar" class="w-4 h-4"></i>Hari Ini (2 Mar 2025)<i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400"></i>
                </button>
                <button class="ai-btn ai-btn-secondary" data-toast="Panel Filter Audit Lanjutan dibuka" data-toast-type="info">
                  <i data-lucide="sliders-horizontal" class="w-4 h-4"></i>Filter Audit Lanjutan
                </button>
                <button class="ai-btn ai-btn-secondary" data-toast="Export log dimulai: format JSON/CSV">
                  <i data-lucide="download" class="w-4 h-4"></i>Export Log (JSON/CSV)
                </button>
                <button class="ai-btn ai-btn-primary" data-toast="Live Stream Feed terhubung — latensi 10ms">
                  <span class="w-2 h-2 rounded-full bg-white ai-live-dot" style="background:#fff"></span>Live Stream Feed
                  <span class="text-[10px] font-bold bg-white/20 rounded px-1.5 py-0.5">LIVE</span>
                </button>
              </div>
            </div>
            <p class="text-[13px] lg:text-[13.5px] text-slate-500 leading-relaxed">Rekam jejak forensik seluruh aktivitas pengguna, perubahan data master, transaksi inventaris, otorisasi approval, dan keamanan sistem secara realtime di Hub Cakung DC-01.</p>
          </div>
        </section>

        <!-- ===== Statistik ===== -->
        <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
          <div class="ai-card ai-card-hover ai-reveal p-5" data-delay="0">
            <div class="flex items-start justify-between">
              <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center"><i data-lucide="history" class="w-5 h-5 text-blue-600"></i></div>
              <span class="ai-badge bg-emerald-50 text-emerald-700"><i data-lucide="trending-up" class="w-3 h-3"></i>+8.5% normal</span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
              <span class="text-[34px] font-extrabold text-slate-800 leading-none" data-count="1428">0</span>
              <span class="text-[13px] text-slate-500 font-medium">Event</span>
            </div>
            <div class="mt-2 text-[13.5px] font-bold text-slate-700">Total Aktivitas Hari Ini</div>
            <div class="mt-1.5 flex items-center gap-1.5 text-[11.5px] text-slate-500"><span class="w-1.5 h-1.5 rounded-full bg-blue-500 flex-none"></span>Pencatatan realtime tanpa latensi</div>
          </div>

          <div class="ai-card ai-card-hover ai-reveal p-5" data-delay="80">
            <div class="flex items-start justify-between">
              <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center"><i data-lucide="badge-check" class="w-5 h-5 text-blue-600"></i></div>
              <span class="ai-badge bg-blue-50 text-blue-700"><i data-lucide="key-round" class="w-3 h-3"></i>100% 2FA Valid</span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
              <span class="text-[34px] font-extrabold text-slate-800 leading-none" data-count="84">0</span>
              <span class="text-[13px] text-slate-500 font-medium">Aksi</span>
            </div>
            <div class="mt-2 text-[13.5px] font-bold text-slate-700">Aktivitas Kritis &amp; Approval</div>
            <div class="mt-1.5 flex items-center gap-1.5 text-[11.5px] text-slate-500"><span class="w-1.5 h-1.5 rounded-full bg-blue-500 flex-none"></span>Otorisasi pengeluaran &amp; mutasi stok</div>
          </div>

          <div class="ai-card ai-card-hover ai-reveal p-5" data-delay="160">
            <div class="flex items-start justify-between">
              <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center"><i data-lucide="clipboard-list" class="w-5 h-5 text-blue-600"></i></div>
              <span class="ai-badge bg-slate-100 text-slate-600"><i data-lucide="pen-line" class="w-3 h-3"></i>Perlu Review</span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
              <span class="text-[34px] font-extrabold text-slate-800 leading-none" data-count="19">0</span>
              <span class="text-[13px] text-slate-500 font-medium">Modifikasi</span>
            </div>
            <div class="mt-2 text-[13.5px] font-bold text-slate-700">Perubahan Master Data</div>
            <div class="mt-1.5 flex items-center gap-1.5 text-[11.5px] text-slate-500"><span class="w-1.5 h-1.5 rounded-full bg-blue-500 flex-none"></span>Update SKU, harga acuan &amp; batas kuota</div>
          </div>

          <div class="ai-card ai-card-hover ai-reveal p-5" data-delay="240">
            <div class="flex items-start justify-between">
              <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center"><i data-lucide="shield" class="w-5 h-5 text-emerald-600"></i></div>
              <span class="ai-badge bg-emerald-50 text-emerald-700"><i data-lucide="lock" class="w-3 h-3"></i>SHA-256 Integritas</span>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
              <span class="text-[34px] font-extrabold text-emerald-600 leading-none" data-count="0">0</span>
              <span class="text-[13px] text-slate-500 font-medium">Ancaman</span>
            </div>
            <div class="mt-2 text-[13.5px] font-bold text-slate-700">Insiden Keamanan / Flag</div>
            <div class="mt-1.5 flex items-center gap-1.5 text-[11.5px] text-slate-500"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 flex-none"></span>Gagal login 3x teratasi, 0 anomali IP</div>
          </div>
        </section>

        <!-- ===== Pill filter ===== -->
        <section class="ai-card ai-reveal p-4" data-delay="100">
          <div data-tabs="log" class="flex gap-2 overflow-x-auto pb-1">
            <button class="ai-pill ai-pill-active" data-tab="semua">Semua Log <span class="text-[10.5px] font-bold bg-blue-100 text-blue-700 rounded-full px-2 py-0.5">1.428</span></button>
            <button class="ai-pill" data-tab="transaksi">Transaksi Inventaris <span class="text-[10.5px] font-bold bg-slate-100 text-slate-600 rounded-full px-2 py-0.5">812</span></button>
            <button class="ai-pill" data-tab="otorisasi">Otorisasi &amp; Approval <span class="text-[10.5px] font-bold bg-slate-100 text-slate-600 rounded-full px-2 py-0.5">84</span></button>
            <button class="ai-pill" data-tab="master">Modifikasi Master Data <span class="text-[10.5px] font-bold bg-slate-100 text-slate-600 rounded-full px-2 py-0.5">19</span></button>
            <button class="ai-pill" data-tab="akses">Akses &amp; Keamanan Login <span class="text-[10.5px] font-bold bg-slate-100 text-slate-600 rounded-full px-2 py-0.5">513</span></button>
          </div>
        </section>

        <!-- ===== Search + filter + tabel ===== -->
        <section class="ai-card ai-reveal p-4 md:p-5" data-delay="150">
          <div class="grid grid-cols-1 lg:grid-cols-12 gap-3">
            <div class="lg:col-span-4 relative">
              <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
              <input id="logSearch" class="ai-input pl-10" placeholder="Cari NIK, Nama Staf, IP Address, No. Dokumen, atau Aksi..." />
            </div>
            <select id="fUrgensi" class="ai-input lg:col-span-2 text-slate-600">
              <option value="semua">Semua Urgensi</option>
              <option value="normal">Normal</option>
              <option value="kritis">Kritis</option>
            </select>
            <select id="fModul" class="ai-input lg:col-span-2 text-slate-600">
              <option value="semua">Semua Modul</option>
              <option value="outbound">Outbound Delivery</option>
              <option value="inbound">Inbound / Cross-Dock</option>
              <option value="opname">Stok Opname</option>
              <option value="master">Master Data</option>
              <option value="auth">Akses &amp; Auth</option>
            </select>
            <select id="fPeran" class="ai-input lg:col-span-2 text-slate-600">
              <option value="semua">Semua Peran</option>
              <option value="superadmin">Super Admin</option>
              <option value="supervisor">Supervisor</option>
              <option value="staf">Staf</option>
            </select>
            <div class="lg:col-span-2 flex gap-2">
              <button id="btnReset" class="ai-btn ai-btn-secondary w-full"><i data-lucide="rotate-ccw" class="w-4 h-4"></i>Reset Filter</button>
              <button class="ai-btn ai-btn-soft flex-none w-11 px-0" data-toast="Feed log dimuat ulang" data-toast-type="info" title="Refresh"><i data-lucide="refresh-cw" class="w-4 h-4"></i></button>
            </div>
          </div>

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
                <!-- Row 1 -->
                <tr class="ai-live-row" data-cat="otorisasi" data-urgensi="kritis" data-modul="outbound" data-peran="superadmin"
                    data-text="02 mar 2025 14:48:12 budi santoso nik-88201 persetujuan outbound delivery req-2025-0381 do-out-2025-0941 103.28.14.90 sukses 2fa macbook">
                  <td>
                    <div class="font-bold text-slate-700 whitespace-nowrap">02 Mar 2025 &bull; 14:48:12</div>
                    <div class="mt-1 flex items-center gap-1.5"><span class="ai-badge bg-blue-50 text-blue-600 ai-blink-soft">12 detik lalu</span></div>
                    <div class="text-[10.5px] text-slate-400 mt-0.5">WIB (GMT+7)</div>
                  </td>
                  <td>
                    <div class="flex items-center gap-2.5">
                      <div class="w-9 h-9 rounded-full bg-blue-600 text-white text-[11px] font-bold flex items-center justify-center flex-none">BS</div>
                      <div>
                        <div class="font-bold text-slate-700">Budi Santoso</div>
                        <div class="text-[11px] text-slate-500">Super Admin &bull; NIK-88201</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="ai-badge bg-blue-50 text-blue-700"><i data-lucide="check-circle-2" class="w-3 h-3"></i>Persetujuan</span>
                    <div class="text-[11px] text-slate-500 mt-1.5">Outbound Delivery</div>
                  </td>
                  <td class="max-w-[240px]">
                    <div class="font-bold text-slate-700 leading-snug">Menyetujui permohonan pengeluaran inventaris kategori high-value</div>
                    <div class="text-[11.5px] text-slate-500 mt-1 leading-snug">Disetujui untuk transfer 15 unit MacBook Pro 14" M3 Max ke Hub Surabaya DC-02</div>
                  </td>
                  <td>
                    <div class="font-bold text-blue-600">REQ-2025-0381</div>
                    <div class="font-semibold text-blue-600 text-[12px] mt-0.5">DO-OUT-2025-0941</div>
                  </td>
                  <td>
                    <div class="font-semibold text-slate-600">103.28.14.90</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Chrome 122 (macOS) &bull; DC-01 LAN</div>
                  </td>
                  <td>
                    <span class="ai-badge bg-emerald-50 text-emerald-700"><i data-lucide="shield-check" class="w-3 h-3"></i>Sukses / 2FA</span>
                    <div class="text-[11px] font-semibold text-blue-400 mt-1.5">#a9e4d1f2b</div>
                  </td>
                  <td class="text-right"><button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Detail event log REQ-2025-0381 dibuka" data-toast-type="info" title="Lihat JSON"><i data-lucide="braces" class="w-4 h-4"></i></button></td>
                </tr>

                <!-- Row 2 -->
                <tr data-cat="transaksi" data-urgensi="normal" data-modul="inbound" data-peran="staf"
                    data-text="02 mar 2025 14:41:05 rian hidayat nik-88412 barang masuk cross-dock bay 04 po-in-2025-0814 sku-mon-9920 192.168.10.42 verified sha-256 samsung">
                  <td>
                    <div class="font-bold text-slate-700 whitespace-nowrap">02 Mar 2025 &bull; 14:41:05</div>
                    <div class="text-[10.5px] text-slate-400 mt-1">7 menit lalu &bull; WIB (GMT+7)</div>
                  </td>
                  <td>
                    <div class="flex items-center gap-2.5">
                      <div class="w-9 h-9 rounded-full bg-emerald-600 text-white text-[11px] font-bold flex items-center justify-center flex-none">RH</div>
                      <div>
                        <div class="font-bold text-slate-700">Rian Hidayat</div>
                        <div class="text-[11px] text-slate-500">Staf Checker Inbound &bull; NIK-88412</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="ai-badge bg-emerald-50 text-emerald-700"><i data-lucide="corner-down-left" class="w-3 h-3"></i>Barang Masuk</span>
                    <div class="text-[11px] text-slate-500 mt-1.5">Cross-Dock Bay 04</div>
                  </td>
                  <td class="max-w-[240px]">
                    <div class="font-bold text-slate-700 leading-snug">Penerimaan fisik barang &amp; validasi Barcode PO-IN-2025-0814</div>
                    <div class="text-[11.5px] text-slate-500 mt-1 leading-snug">Berhasil verifikasi 250 karton 'Samsung Odyssey Neo G9' dari PT Elektronik Mega Sentosa</div>
                  </td>
                  <td>
                    <div class="font-bold text-blue-600">PO-IN-2025-0814</div>
                    <div class="font-semibold text-blue-600 text-[12px] mt-0.5">SKU-MON-9920</div>
                  </td>
                  <td>
                    <div class="font-semibold text-slate-600">192.168.10.42</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Zebra TC57 Scanner &bull; Android 11</div>
                  </td>
                  <td>
                    <span class="ai-badge bg-emerald-50 text-emerald-700"><i data-lucide="fingerprint" class="w-3 h-3"></i>Verified / SHA-256</span>
                    <div class="text-[11px] font-semibold text-blue-400 mt-1.5">#77c8e90a1</div>
                  </td>
                  <td class="text-right"><button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Detail event log PO-IN-2025-0814 dibuka" data-toast-type="info" title="Lihat JSON"><i data-lucide="braces" class="w-4 h-4"></i></button></td>
                </tr>

                <!-- Row 3 -->
                <tr data-cat="transaksi" data-urgensi="kritis" data-modul="opname" data-peran="supervisor"
                    data-text="02 mar 2025 14:15:30 dewi anggraini nik-88195 stok opname audit rak b-04-12 sku-pkg-0112 opn-2025-0043 discrepancy karantina">
                  <td>
                    <div class="font-bold text-slate-700 whitespace-nowrap">02 Mar 2025 &bull; 14:15:30</div>
                    <div class="text-[10.5px] text-slate-400 mt-1">33 menit lalu &bull; WIB (GMT+7)</div>
                  </td>
                  <td>
                    <div class="flex items-center gap-2.5">
                      <div class="w-9 h-9 rounded-full bg-slate-400 text-white text-[11px] font-bold flex items-center justify-center flex-none">DA</div>
                      <div>
                        <div class="font-bold text-slate-700">Dewi Anggraini</div>
                        <div class="text-[11px] text-slate-500">Supervisor Inventory &bull; NIK-88195</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="ai-badge bg-slate-100 text-slate-600"><i data-lucide="clipboard-check" class="w-3 h-3"></i>Stok Opname</span>
                    <div class="text-[11px] text-slate-500 mt-1.5">Audit Rak B-04-12</div>
                  </td>
                  <td class="max-w-[240px]">
                    <div class="font-bold text-slate-700 leading-snug">Penyesuaian stok on-hand SKU-PKG-0112 (Discrepancy -2 unit)</div>
                    <div class="text-[11.5px] text-slate-500 mt-1 leading-snug">Alasan: Kerusakan kemasan saat pemindahan tier forklift. Dipindahkan ke karantina WH-Q01</div>
                  </td>
                  <td>
                    <div class="font-bold text-blue-600">SKU-PKG-0112</div>
                    <div class="font-semibold text-blue-600 text-[12px] mt-0.5">OPN-2025-0043</div>
                  </td>
                  <td>
                    <div class="font-semibold text-slate-600">103.28.14.92</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Firefox 123 (Windows 11) &bull; Desk Supv</div>
                  </td>
                  <td>
                    <span class="ai-badge bg-slate-100 text-slate-600"><i data-lucide="archive" class="w-3 h-3"></i>Audit Disimpan</span>
                    <div class="text-[11px] font-semibold text-blue-400 mt-1.5">#45b1f08bc</div>
                  </td>
                  <td class="text-right"><button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Detail event log OPN-2025-0043 dibuka" data-toast-type="info" title="Lihat JSON"><i data-lucide="braces" class="w-4 h-4"></i></button></td>
                </tr>

                <!-- Row 4 -->
                <tr data-cat="master" data-urgensi="normal" data-modul="master" data-peran="superadmin"
                    data-text="02 mar 2025 13:50:18 budi santoso nik-88201 master data katalog minimum reorder sku-srv-2041 kategori it enterprise threshold safety stock">
                  <td>
                    <div class="font-bold text-slate-700 whitespace-nowrap">02 Mar 2025 &bull; 13:50:18</div>
                    <div class="text-[10.5px] text-slate-400 mt-1">58 menit lalu &bull; WIB (GMT+7)</div>
                  </td>
                  <td>
                    <div class="flex items-center gap-2.5">
                      <div class="w-9 h-9 rounded-full bg-blue-600 text-white text-[11px] font-bold flex items-center justify-center flex-none">BS</div>
                      <div>
                        <div class="font-bold text-slate-700">Budi Santoso</div>
                        <div class="text-[11px] text-slate-500">Super Admin &bull; NIK-88201</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="ai-badge bg-indigo-50 text-indigo-700"><i data-lucide="database" class="w-3 h-3"></i>Master Data</span>
                    <div class="text-[11px] text-slate-500 mt-1.5">Katalog &amp; Minimum Reorder</div>
                  </td>
                  <td class="max-w-[240px]">
                    <div class="font-bold text-slate-700 leading-snug">Pembaruan threshold minimum reorder &amp; lokasi bin primer</div>
                    <div class="text-[11.5px] text-slate-500 mt-1 leading-snug">SKU-SRV-2041: Safety stock dinaikkan dari 50 unit menjadi 80 unit untuk mitigasi peak season</div>
                  </td>
                  <td>
                    <div class="font-bold text-blue-600">SKU-SRV-2041</div>
                    <div class="font-semibold text-blue-600 text-[12px] mt-0.5">Kategori IT Enterprise</div>
                  </td>
                  <td>
                    <div class="font-semibold text-slate-600">103.28.14.90</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Chrome 122 (macOS) &bull; Admin Console</div>
                  </td>
                  <td>
                    <span class="ai-badge bg-emerald-50 text-emerald-700"><i data-lucide="save" class="w-3 h-3"></i>Tersimpan</span>
                    <div class="text-[11px] font-semibold text-blue-400 mt-1.5">#12df6a87</div>
                  </td>
                  <td class="text-right"><button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Detail event log SKU-SRV-2041 dibuka" data-toast-type="info" title="Lihat JSON"><i data-lucide="braces" class="w-4 h-4"></i></button></td>
                </tr>

                <!-- Row 5 -->
                <tr data-cat="akses" data-urgensi="kritis" data-modul="auth" data-peran="staf"
                    data-text="02 mar 2025 13:02:44 wahyu kusuma nik-88004 akses auth fido2 hardware key usr-ses-9941 yubikey otp biometrik login">
                  <td>
                    <div class="font-bold text-slate-700 whitespace-nowrap">02 Mar 2025 &bull; 13:02:44</div>
                    <div class="text-[10.5px] text-slate-400 mt-1">1 jam 46 menit lalu &bull; WIB (GMT+7)</div>
                  </td>
                  <td>
                    <div class="flex items-center gap-2.5">
                      <div class="w-9 h-9 rounded-full bg-slate-500 text-white text-[11px] font-bold flex items-center justify-center flex-none">WK</div>
                      <div>
                        <div class="font-bold text-slate-700">Wahyu Kusuma</div>
                        <div class="text-[11px] text-slate-500">Kepala Gudang DC-01 &bull; NIK-88004</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="ai-badge bg-violet-50 text-violet-700"><i data-lucide="lock" class="w-3 h-3"></i>Akses &amp; Auth</span>
                    <div class="text-[11px] text-slate-500 mt-1.5">FIDO2 Hardware Key</div>
                  </td>
                  <td class="max-w-[240px]">
                    <div class="font-bold text-slate-700 leading-snug">Login berhasil via Hardware YubiKey OTP + Biometrik</div>
                    <div class="text-[11.5px] text-slate-500 mt-1 leading-snug">Otentikasi ganda berhasil diverifikasi pada workstation terminal DC-01 Command Desk</div>
                  </td>
                  <td>
                    <div class="font-bold text-blue-600">USR-SES-9941</div>
                    <div class="font-semibold text-blue-600 text-[12px] mt-0.5">Tervalidasi FIDO2</div>
                  </td>
                  <td>
                    <div class="font-semibold text-slate-600">103.28.14.88</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Edge 122 (Windows 11) &bull; IP Whitelisted</div>
                  </td>
                  <td>
                    <span class="ai-badge bg-emerald-50 text-emerald-700"><i data-lucide="key-round" class="w-3 h-3"></i>Otentikasi Sah</span>
                    <div class="text-[11px] font-semibold text-blue-400 mt-1.5">#e3290fb4</div>
                  </td>
                  <td class="text-right"><button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Detail event log USR-SES-9941 dibuka" data-toast-type="info" title="Lihat JSON"><i data-lucide="braces" class="w-4 h-4"></i></button></td>
                </tr>

                <!-- Row 6 -->
                <tr data-cat="transaksi" data-urgensi="normal" data-modul="outbound" data-peran="staf"
                    data-text="02 mar 2025 12:20:11 agus prasetyo nik-88339 barang keluar staging area gate 02 do-out-2025-0941 surat jalan label segel armada 40 pallet">
                  <td>
                    <div class="font-bold text-slate-700 whitespace-nowrap">02 Mar 2025 &bull; 12:20:11</div>
                    <div class="text-[10.5px] text-slate-400 mt-1">2 jam 28 menit lalu &bull; WIB (GMT+7)</div>
                  </td>
                  <td>
                    <div class="flex items-center gap-2.5">
                      <div class="w-9 h-9 rounded-full bg-slate-800 text-white text-[11px] font-bold flex items-center justify-center flex-none">AP</div>
                      <div>
                        <div class="font-bold text-slate-700">Agus Prasetyo</div>
                        <div class="text-[11px] text-slate-500">Staf Dispatch Outbound &bull; NIK-88339</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="ai-badge bg-blue-50 text-blue-700"><i data-lucide="send" class="w-3 h-3"></i>Barang Keluar</span>
                    <div class="text-[11px] text-slate-500 mt-1.5">Staging Area Gate 02</div>
                  </td>
                  <td class="max-w-[240px]">
                    <div class="font-bold text-slate-700 leading-snug">Membuat Surat Jalan DO-OUT-2025-0941 &amp; Cetak Label Segel Armada</div>
                    <div class="text-[11.5px] text-slate-500 mt-1 leading-snug">Pelepasan armada box truck B 9421 KDC membawa 40 pallet logistik ritel</div>
                  </td>
                  <td>
                    <div class="font-bold text-blue-600">DO-OUT-2025-0941</div>
                    <div class="font-semibold text-blue-600 text-[12px] mt-0.5">40 Palet Dispatch</div>
                  </td>
                  <td>
                    <div class="font-semibold text-slate-600">192.168.10.65</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Zebra Thermal Print Engine &bull; Gate 02</div>
                  </td>
                  <td>
                    <span class="ai-badge bg-emerald-50 text-emerald-700"><i data-lucide="badge-check" class="w-3 h-3"></i>Tervalidasi</span>
                    <div class="text-[11px] font-semibold text-blue-400 mt-1.5">#381ab9210</div>
                  </td>
                  <td class="text-right"><button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors" data-toast="Detail event log DO-OUT-2025-0941 dibuka" data-toast-type="info" title="Lihat JSON"><i data-lucide="braces" class="w-4 h-4"></i></button></td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Empty state -->
          <div id="logEmpty" class="hidden py-10 text-center">
            <i data-lucide="search-x" class="w-8 h-8 text-slate-300 mx-auto"></i>
            <div class="mt-2 text-[13px] font-semibold text-slate-500">Tidak ada log aktivitas yang cocok dengan filter.</div>
          </div>

          <!-- Pagination -->
          <div class="mt-4 flex flex-wrap items-center justify-between gap-3 pt-4 border-t border-slate-100">
            <div class="text-[12px] text-slate-500 font-medium">Menampilkan 1 - 6 dari 1.428 Log Aktivitas &bull; Halaman 1 dari 238</div>
            <div class="flex items-center gap-1.5">
              <button class="ai-btn ai-btn-secondary opacity-50 cursor-not-allowed" disabled>Sebelumnya</button>
              <button class="w-9 h-9 rounded-lg bg-blue-600 text-white text-[12.5px] font-bold shadow-md shadow-blue-600/30">1</button>
              <button class="w-9 h-9 rounded-lg text-[12.5px] font-semibold text-slate-600 hover:bg-slate-100" data-toast="Halaman 2 dimuat" data-toast-type="info">2</button>
              <button class="w-9 h-9 rounded-lg text-[12.5px] font-semibold text-slate-600 hover:bg-slate-100" data-toast="Halaman 3 dimuat" data-toast-type="info">3</button>
              <span class="text-slate-400 px-1">...</span>
              <button class="w-9 h-9 rounded-lg text-[12.5px] font-semibold text-slate-600 hover:bg-slate-100" data-toast="Halaman 238 dimuat" data-toast-type="info">238</button>
              <button class="ai-btn ai-btn-secondary" data-toast="Halaman 2 dimuat" data-toast-type="info">Berikutnya</button>
            </div>
          </div>
        </section>

        <!-- ===== Info cards ===== -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="ai-card ai-card-hover ai-reveal p-6" data-delay="0">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center"><i data-lucide="lock" class="w-5 h-5 text-blue-600"></i></div>
            <h3 class="mt-3.5 text-[15px] font-bold text-slate-800">Penyimpanan Log Anti-Tamper (WORM)</h3>
            <p class="mt-2 text-[12.5px] text-slate-500 leading-relaxed">Standar keamanan kepatuhan audit Write-Once-Read-Many, memastikan rekaman log tidak dapat dimanipulasi atau dihapus oleh siapapun termasuk super admin. Dilengkapi cryptographic hashing per blok event.</p>
            <button class="mt-3.5 text-[12.5px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1" data-toast="Membuka dokumentasi Arsitektur Log WORM" data-toast-type="info">Pelajari Arsitektur Log WORM <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></button>
          </div>
          <div class="ai-card ai-card-hover ai-reveal p-6" data-delay="80">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center"><i data-lucide="brain-circuit" class="w-5 h-5 text-indigo-600"></i></div>
            <h3 class="mt-3.5 text-[15px] font-bold text-slate-800">Deteksi Anomali Berbasis AI</h3>
            <p class="mt-2 text-[12.5px] text-slate-500 leading-relaxed">Pemantauan otomatis perilaku transaksi tidak wajar, lonjakan penyesuaian stok di luar jam kerja, atau login dari perangkat tidak dikenal dengan notifikasi push instan ke Security Officer.</p>
            <button class="mt-3.5 text-[12.5px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1" data-toast="Panel Konfigurasi Alert Keamanan AI dibuka" data-toast-type="info">Konfigurasi Alert Keamanan AI <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i></button>
          </div>
          <div class="ai-card ai-card-hover ai-reveal p-6" data-delay="160">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center"><i data-lucide="shield-check" class="w-5 h-5 text-emerald-600"></i></div>
            <h3 class="mt-3.5 text-[15px] font-bold text-slate-800">Arsip &amp; Kebijakan Ekspor Forensik</h3>
            <p class="mt-2 text-[12.5px] text-slate-500 leading-relaxed">Ekspor data log terenkripsi dengan stempel waktu tersertifikasi digital (Digital Timestamp RFC 3161) untuk kebutuhan kepatuhan audit internal dan audit eksternal standar sertifikasi ISO 27001.</p>
            <button class="mt-3.5 text-[12.5px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1" data-toast="Berkas audit resmi disiapkan untuk diunduh">
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
   Log Aktivitas — filter pill kategori, search, urgensi, modul, peran
   ============================================================ */
    (function () {
      var rows = Array.prototype.slice.call(document.querySelectorAll("#logBody tr"));
      var search = document.getElementById("logSearch");
      var fUrgensi = document.getElementById("fUrgensi");
      var fModul = document.getElementById("fModul");
      var fPeran = document.getElementById("fPeran");
      var empty = document.getElementById("logEmpty");
      var activeCat = "semua";

      function applyFilter() {
        var q = (search.value || "").trim().toLowerCase();
        var shown = 0;
        rows.forEach(function (r) {
          var ok = true;
          if (activeCat !== "semua" && r.getAttribute("data-cat") !== activeCat) ok = false;
          if (ok && fUrgensi.value !== "semua" && r.getAttribute("data-urgensi") !== fUrgensi.value) ok = false;
          if (ok && fModul.value !== "semua" && r.getAttribute("data-modul") !== fModul.value) ok = false;
          if (ok && fPeran.value !== "semua" && r.getAttribute("data-peran") !== fPeran.value) ok = false;
          if (ok && q && (r.getAttribute("data-text") + " " + r.textContent.toLowerCase()).indexOf(q) === -1) ok = false;
          r.style.display = ok ? "" : "none";
          if (ok) shown++;
        });
        empty.classList.toggle("hidden", shown > 0);
      }

      // Sinkron pill (data-tabs) dengan filter kategori
      document.querySelector('[data-tabs="log"]').addEventListener("ai:tabchange", function (e) {
        activeCat = e.detail.tab;
        applyFilter();
        var labels = { semua: "Semua Log", transaksi: "Transaksi Inventaris", otorisasi: "Otorisasi & Approval", master: "Modifikasi Master Data", akses: "Akses & Keamanan Login" };
        window.aiToast("Filter kategori: " + labels[e.detail.tab], "info");
      });

      search.addEventListener("input", applyFilter);
      [fUrgensi, fModul, fPeran].forEach(function (s) { s.addEventListener("change", applyFilter); });

      document.getElementById("btnReset").addEventListener("click", function () {
        search.value = ""; fUrgensi.value = "semua"; fModul.value = "semua"; fPeran.value = "semua";
        activeCat = "semua";
        document.querySelectorAll('[data-tabs="log"] [data-tab]').forEach(function (p) {
          p.classList.toggle("ai-pill-active", p.getAttribute("data-tab") === "semua");
        });
        applyFilter();
        window.aiToast("Semua filter log berhasil direset.", "success");
      });

      applyFilter();
      window.aiRefresh();
    })();
</script>

</body>
</html>
