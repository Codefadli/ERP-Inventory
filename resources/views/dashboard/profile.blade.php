<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Astro Inventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ============================================================
           Astro Inventory — Shared Design System (profil)
           ============================================================ */
        :root {
            --brand: #2563eb;
            --brand-dark: #1d4ed8;
            --bg: #f5f7fb;
            --line: #e7ebf2;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif;
            background: var(--bg);
            color: #172033;
            -webkit-font-smoothing: antialiased;
        }

        /* ---------- Scrollbar ---------- */
        ::-webkit-scrollbar { width: 9px; height: 9px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cdd6e4; border-radius: 99px; border: 2px solid #f5f7fb; }
        ::-webkit-scrollbar-thumb:hover { background: #aab8cf; }

        /* ---------- Entrance animations ---------- */
        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideIn { from { opacity: 0; transform: translateX(-20px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes toastIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: none; } }
        @keyframes modalIn { from { opacity: 0; transform: translateY(12px) scale(.98); } to { opacity: 1; transform: none; } }
        @keyframes rise { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes ai-fade-up { to { opacity: 1; transform: translateY(0); } }
        @keyframes ai-ripple { to { transform: scale(2.6); opacity: 0; } }
        @keyframes ai-pulse { 0% { transform: scale(.5); opacity: 1; } 100% { transform: scale(1.6); opacity: 0; } }

        .anim-fade-up { animation: fadeUp .6s cubic-bezier(.22,1,.36,1) forwards; }
        .anim-fade-in { animation: fadeIn .5s ease-out; }
        .anim-slide-in { animation: slideIn .5s cubic-bezier(.22,1,.36,1); }
        .delay-1 { animation-delay: .1s; }
        .delay-2 { animation-delay: .2s; }
        .delay-3 { animation-delay: .3s; }

        /* ---------- Nav ---------- */
        .nav-link { transition: all .16s ease; }
        .nav-link:hover { background: #f1f5f9; color: #172033; transform: translateX(3px); }
        .nav-link.active { background: var(--brand); color: #fff; font-weight: 600; box-shadow: 0 6px 14px -6px rgba(37,99,235,.55); }
        .nav-link.active:hover { transform: none; background: var(--brand); }

        /* ---------- Cards & badges ---------- */
        .metric-card { transition: transform .25s cubic-bezier(.22,1,.36,1), box-shadow .25s; }
        .metric-card:hover { transform: translateY(-3px); box-shadow: 0 12px 28px -12px rgba(37,99,235,.22), 0 4px 10px rgba(15,23,42,.06); }
        .panel { box-shadow: 0 1px 2px rgba(15,23,42,.05); background: #fff; border: 1px solid #e5e7eb; border-radius: .5rem; }
        .badge { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 6px; }

        /* ---------- Toast ---------- */
        #toast-container { position: fixed; right: 1rem; bottom: 1rem; z-index: 100; display: flex; flex-direction: column; gap: .5rem; }
        .toast { background: #fff; border: 1px solid #e5eeff; border-left: 4px solid #2563eb; border-radius: .5rem; padding: .75rem 1rem; box-shadow: 0 8px 20px -6px rgba(0,0,0,.2); font-size: .875rem; color: #0b1c30; animation: toastIn .2s ease; max-width: 340px; }
        .toast.success { border-left-color: #16a34a; }
        .toast.warn { border-left-color: #f59e0b; }
        .toast.error { border-left-color: #dc2626; }

        /* ---------- Modal ---------- */
        .modal-overlay { position: fixed; inset: 0; background: rgba(11,28,48,.55); display: none; align-items: flex-start; justify-content: center; z-index: 80; padding: 5vh 1rem 1rem; overflow-y: auto; }
        .modal-overlay.open { display: flex; }
        .modal-box { background: #fff; border-radius: .75rem; width: 100%; max-width: 640px; box-shadow: 0 20px 50px -10px rgba(0,0,0,.35); animation: modalIn .18s ease; }

        /* ============================================================
           Pegawai — profil (soft button, reveal, tab, grid)
           ============================================================ */
        .soft-button { transition: transform .16s ease, box-shadow .16s ease; }
        .soft-button:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(15,23,42,.08); }
        .reveal { animation: rise .35s ease both; }
        .row-in { animation: rise .25s ease both; }
        .profile-tab { transition: all .15s ease; }
        .profile-tab.active { background: #0b49d8; color: white; }
        .metrics-grid { display: grid; grid-template-columns: repeat(1, minmax(0, 1fr)); gap: 12px; }
        @media (min-width: 768px) {
            .metrics-grid { grid-template-columns: repeat(4, minmax(0, 1fr)) !important; }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; }
        }

        /* ============================================================
           SuperAdmin — ai design system
           ============================================================ */
        .ai-card { background: #fff; border: 1px solid var(--line); border-radius: 16px; box-shadow: 0 1px 2px rgba(15,23,42,.05); transition: transform .25s cubic-bezier(.22,1,.36,1), box-shadow .25s; }
        .ai-card-hover:hover { transform: translateY(-3px); box-shadow: 0 12px 28px -12px rgba(37,99,235,.22), 0 4px 10px rgba(15,23,42,.06); }
        .ai-btn { position: relative; overflow: hidden; display: inline-flex; align-items: center; justify-content: center; gap: 8px; font-weight: 600; font-size: 13px; border-radius: 10px; padding: 10px 16px; transition: all .18s ease; cursor: pointer; white-space: nowrap; }
        .ai-btn:active { transform: scale(.97); }
        .ai-btn-primary { background: var(--brand); color: #fff; box-shadow: 0 4px 12px -4px rgba(37,99,235,.5); }
        .ai-btn-primary:hover { background: var(--brand-dark); box-shadow: 0 8px 18px -6px rgba(37,99,235,.55); transform: translateY(-1px); }
        .ai-btn-secondary { background: #fff; color: #334155; border: 1px solid #dbe2ec; }
        .ai-btn-secondary:hover { background: #f8fafc; border-color: #c3cfe0; transform: translateY(-1px); }
        .ai-btn-soft { background: #eff6ff; color: var(--brand-dark); }
        .ai-btn-soft:hover { background: #dbeafe; }
        .ai-btn-danger { background: #fef2f2; color: #dc2626; }
        .ai-btn-danger:hover { background: #fee2e2; }
        .ai-ripple { position: absolute; border-radius: 9999px; transform: scale(0); animation: ai-ripple .6s ease-out; background: rgba(255,255,255,.45); pointer-events: none; }
        .ai-btn-secondary .ai-ripple, .ai-btn-soft .ai-ripple, .ai-btn-danger .ai-ripple { background: rgba(37,99,235,.18); }
        .ai-reveal { opacity: 0; transform: translateY(14px); }
        .ai-reveal.ai-revealed { animation: ai-fade-up .55s cubic-bezier(.22,1,.36,1) forwards; }
        .ai-badge { display: inline-flex; align-items: center; gap: 5px; border-radius: 999px; padding: 3px 10px; font-size: 11px; font-weight: 700; white-space: nowrap; }
        .ai-live-dot { width: 8px; height: 8px; border-radius: 999px; background: #16a34a; position: relative; flex: none; }
        .ai-live-dot::after { content: ""; position: absolute; inset: -4px; border-radius: 999px; background: rgba(22,163,74,.35); animation: ai-pulse 1.8s ease-out infinite; }
        .ai-bar { height: 6px; border-radius: 999px; background: #e8edf5; overflow: hidden; }
        .ai-bar > span { display: block; height: 100%; border-radius: 999px; width: 0; transition: width 1.1s cubic-bezier(.22,1,.36,1); }
        .ai-pill { display: inline-flex; align-items: center; gap: 7px; border-radius: 999px; padding: 8px 15px; font-size: 12.5px; font-weight: 600; color: #475569; background: #fff; border: 1px solid #e2e8f0; cursor: pointer; transition: all .18s ease; white-space: nowrap; }
        .ai-pill:hover { border-color: #93c5fd; color: var(--brand-dark); transform: translateY(-1px); }
        .ai-pill.ai-pill-active { background: var(--brand); border-color: var(--brand); color: #fff; box-shadow: 0 6px 14px -6px rgba(37,99,235,.5); }
        .ai-input { width: 100%; border: 1px solid #dbe2ec; border-radius: 10px; padding: 10px 13px; background: #fff; color: #243044; outline: none; font-size: 13px; transition: border-color .15s, box-shadow .15s, background .15s; }
        .ai-input:focus { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(37,99,235,.13); }
        .ai-input::placeholder { color: #94a3b8; }
        .ai-switch { width: 46px; height: 26px; border-radius: 999px; background: #cbd5e1; position: relative; cursor: pointer; transition: background .22s; flex: none; }
        .ai-switch::after { content: ""; position: absolute; top: 3px; left: 3px; width: 20px; height: 20px; border-radius: 999px; background: #fff; box-shadow: 0 1px 4px rgba(15,23,42,.25); transition: transform .22s cubic-bezier(.34,1.56,.64,1); }
        .ai-switch.ai-on { background: var(--brand); }
        .ai-switch.ai-on::after { transform: translateX(20px); }
        .ai-table th { font-size: 10.5px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: #64748b; background: #f8fafc; padding: 12px 14px; white-space: nowrap; }
        .ai-table td { padding: 13px 14px; font-size: 13px; vertical-align: middle; }
        .ai-table tbody tr { transition: background .15s; }
        .ai-table tbody tr:hover { background: #f6f9ff; }
    </style>
</head>
<body class="bg-gray-50">

@include('components.navbar')

<div class="flex min-h-screen">
    @include('components.sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-4 lg:p-6 overflow-x-hidden">

        @if(auth()->user()->isSuperAdmin())
        <!-- ===== Breadcrumb + status + aksi ===== -->
        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-3 mb-4">
          <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2 text-sm text-gray-500 overflow-x-auto whitespace-nowrap anim-fade-in">
              <span>Beranda</span><i class="fas fa-chevron-right text-xs"></i>
              <span>Pengaturan &amp; Akun</span><i class="fas fa-chevron-right text-xs"></i>
              <span class="text-gray-900 font-medium">Profil Saya</span>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
              <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100"><span class="ai-live-dot"></span>STATUS: TERVERIFIKASI AKTIF</span>
              <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100"><i class="fas fa-shield-alt text-sm"></i>SUPER ADMIN</span>
            </div>
          </div>
          <div class="flex flex-wrap items-center gap-2.5 flex-none">
            <button class="ai-btn ai-btn-secondary" id="btnBatal"><i class="fas fa-undo text-base"></i>Batal Perubahan</button>
            <button class="ai-btn ai-btn-secondary" data-toast="Ekspor data akun (GDPR) disiapkan — tautan unduh dikirim ke email resmi Anda." data-toast-type="info"><i class="fas fa-download text-base"></i>Unduh Data Akun (GDPR)</button>
            <button type="submit" form="form-identitas" class="ai-btn ai-btn-primary" id="btnSimpanProfil"><i class="fas fa-save text-base"></i>Simpan Profil</button>
          </div>
        </div>

        <!-- ===== Banner hero profil ===== -->
        <div class="ai-card overflow-hidden mb-5 ai-reveal">
          <div class="relative bg-gradient-to-r from-blue-700 via-blue-800 to-slate-900 px-6 md:px-8 py-7 md:pl-44">
            <!-- Avatar -->
            <div class="absolute left-6 md:left-8 top-1/2 -translate-y-1/2">
              <div class="relative">
                <div class="w-24 h-24 rounded-2xl bg-blue-600 border-4 border-white/25 shadow-2xl shadow-blue-950/40 flex items-center justify-center">
                  <span class="text-white text-3xl font-extrabold tracking-wide">{{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 2)) }}</span>
                </div>
                <span class="absolute -bottom-1.5 -right-1.5 w-8 h-8 rounded-full bg-emerald-500 border-[3px] border-slate-900 flex items-center justify-center">
                  <i class="fas fa-check text-base text-white"></i>
                </span>
              </div>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4">
              <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-2.5">
                  <span class="ai-badge bg-slate-900/50 text-blue-100 border border-white/10 font-mono">KKT 1.7.001 // SECURE SESSION V4.8</span>
                  <h1 class="text-white text-2xl md:text-[27px] font-extrabold leading-tight">{{ auth()->user()->nama_lengkap }}</h1>
                  <span class="ai-badge bg-white/10 text-white border border-white/20 font-mono">{{ auth()->user()->nip }}</span>
                </div>
                <p class="text-blue-100 text-[13.5px] font-semibold mt-1.5">Head of Central Warehouse Operations &amp; IT Logistics</p>
                <div class="flex flex-wrap items-center gap-x-5 gap-y-1.5 mt-3 text-[12px] text-blue-100/90 font-medium">
                  <span class="flex items-center gap-1.5"><i class="fas fa-envelope text-sm"></i>{{ auth()->user()->email }}</span>
                  <span class="flex items-center gap-1.5"><i class="fas fa-warehouse text-sm"></i>{{ optional(auth()->user()->selectedHub)->name ?? 'Hub Cakung DC-01' }}</span>
                  <span class="flex items-center gap-1.5"><i class="fas fa-calendar text-sm"></i>Bergabung: 12 Jan 2021 (4 Tahun Bertugas)</span>
                </div>
              </div>
              <div class="flex lg:flex-col flex-wrap items-start lg:items-end gap-2 flex-none">
                <span class="ai-badge bg-white/10 text-white border border-white/20 backdrop-blur px-3.5 py-2"><i class="fas fa-shield-alt text-sm"></i>Super Admin (Full Access)</span>
                <span class="ai-badge bg-white/10 text-white border border-white/20 backdrop-blur px-3.5 py-2"><i class="fas fa-lock text-sm"></i>2FA Terverifikasi</span>
                <span class="ai-badge bg-white/10 text-white border border-white/20 backdrop-blur px-3.5 py-2"><i class="fas fa-fingerprint text-sm"></i>FIDO2 Enrolled</span>
              </div>
            </div>
          </div>

          <!-- Tab profil -->
          <div class="px-3 py-2.5 border-t border-slate-100 bg-white">
            <div data-tabs="profil" class="flex gap-2 overflow-x-auto">
              <button class="ai-pill ai-pill-active" data-tab="pribadi"><i class="fas fa-user text-base"></i>Informasi Pribadi &amp; Kontak</button>
              <button class="ai-pill" data-tab="keamanan"><i class="fas fa-shield-alt text-base"></i>Keamanan, Password &amp; 2FA</button>
              <button class="ai-pill" data-tab="akses"><i class="fas fa-exchange-alt text-base"></i>Hak Akses &amp; Matriks Perizinan</button>
              <button class="ai-pill" data-tab="sesi"><i class="fas fa-history text-base"></i>Riwayat Login &amp; Sesi Aktif</button>
            </div>
          </div>
        </div>

        <!-- ===== PANEL 1 — INFORMASI PRIBADI & KONTAK ===== -->
        <div data-tabpanel="profil" data-panel-name="pribadi">
          <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

            <!-- Kolom kiri -->
            <div class="xl:col-span-2 space-y-5">

              <!-- Data Identitas -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="80">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
                  <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                      <i class="fas fa-user text-lg text-blue-600"></i>
                    </div>
                    <div>
                      <h2 class="text-[16px] font-bold text-slate-800">Data Identitas Pegawai</h2>
                      <p class="text-[12.5px] text-slate-500 mt-0.5">Informasi akun operasional yang terdaftar pada sistem terpusat Astro Logistics.</p>
                    </div>
                  </div>
                  <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100 font-mono">HRIS SYNCHRONIZED</span>
                </div>

                <form id="form-identitas" method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Nama Lengkap Sesuai KTP / HR</label>
                    <div class="relative">
                      <i class="fas fa-user text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}">
                    </div>
                    @error('nama_lengkap')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                  </div>
                  <div>
                    <div class="flex items-center justify-between mb-1.5">
                      <label class="text-[12px] font-semibold text-slate-600">NIP Karyawan</label>
                      {{-- <span class="text-[10.5px] font-semibold text-slate-400 flex items-center gap-1"><i class="fas fa-lock text-base"></i>Read-only</span> --}}
                    </div>
                    <div class="relative">
                      <i class="fas fa-fingerprint text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9 font-mono bg-slate-50 text-slate-500" value="{{ auth()->user()->nip }}" readonly>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Alamat Email Resmi Perusahaan</label>
                    <div class="relative">
                      <i class="fas fa-envelope text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" name="email" value="{{ old('email', auth()->user()->email) }}">
                    </div>
                    @error('email')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Nomor Handphone / WhatsApp</label>
                    <div class="relative">
                      <i class="fas fa-phone text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                    </div>
                    @error('phone')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                  </div>
                  <div class="md:col-span-2">
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Departemen &amp; Unit Operasional</label>
                    <div class="relative">
                      <i class="fas fa-building text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" value="Head of Central Warehouse Operations & IT Logistics (Supply Chain Directorate)">
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Lokasi Penugasan (Hub DC)</label>
                    <div class="relative">
                      <i class="fas fa-warehouse text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <select class="ai-input pl-9 appearance-none">
                        <option>{{ optional(auth()->user()->selectedHub)->name ?? 'Hub Cakung DC-01' }}</option>
                        <option>Hub Pulogadung DC-02</option>
                        <option>Hub Bekasi DC-03</option>
                      </select>
                      <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Zona Waktu Sistem</label>
                    <div class="relative">
                      <i class="fas fa-globe text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <select class="ai-input pl-9 appearance-none">
                        <option>Asia/Jakarta (WIB UTC+07:00)</option>
                        <option>Asia/Makassar (WITA UTC+08:00)</option>
                        <option>Asia/Jayapura (WIT UTC+09:00)</option>
                      </select>
                      <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Bahasa Sistem</label>
                    <div class="relative">
                      <i class="fas fa-globe text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <select class="ai-input pl-9 appearance-none">
                        <option>Bahasa Indonesia (Standar Operasional)</option>
                        <option>English (US)</option>
                      </select>
                      <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Format Nomor Dokumen SKU</label>
                    <div class="relative">
                      <i class="fas fa-qrcode text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9 font-mono" value="ASTRO-[WH]-[YEAR]-[SEQ]">
                    </div>
                  </div>
                </div>
              </form>
              </div>

              <!-- Kredensial & Keamanan Akun -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="140">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
                  <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center flex-none">
                      <i class="fas fa-lock text-lg text-emerald-600"></i>
                    </div>
                    <div>
                      <h2 class="text-[16px] font-bold text-slate-800">Kredensial &amp; Keamanan Akun</h2>
                      <p class="text-[12.5px] text-slate-500 mt-0.5">Manajemen kata sandi tingkat tinggi, kunci fisik, dan multi-factor token.</p>
                    </div>
                  </div>
                  <span class="ai-badge bg-emerald-100 text-emerald-700 border border-emerald-200"><i class="fas fa-shield-alt text-sm"></i>POSTURE: AMAN</span>
                </div>

<form id="form-password" method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                  <!-- Pembaruan Kata Sandi -->
                  <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 md:p-5">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                      <h3 class="text-[14px] font-bold text-slate-800">Pembaruan Kata Sandi</h3>
                      <span class="text-[11.5px] text-slate-500 font-medium">Terakhir diubah 42 hari lalu</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                      <div>
                        <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kata Sandi Saat Ini</label>
                        <div class="relative">
                          <input id="pwdCurrent" name="current_password" type="password" class="ai-input pr-10 font-mono" placeholder="Kata sandi saat ini">
                          <button type="button" class="pwd-toggle absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" data-target="pwdCurrent"><i class="fas fa-eye text-base"></i></button>
                        </div>
                        @error('current_password')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                      </div>
                      <div>
                        <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kata Sandi Baru</label>
                        <div class="relative">
                          <input id="pwdNew" name="password" type="password" class="ai-input pr-10" placeholder="Minimal 12 karakter">
                          <button type="button" class="pwd-toggle absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" data-target="pwdNew"><i class="fas fa-eye text-base"></i></button>
                        </div>
                        @error('password')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                      </div>
                      <div>
                        <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Konfirmasi Sandi Baru</label>
                        <div class="relative">
                          <input id="pwdConfirm" name="password_confirmation" type="password" class="ai-input pr-10" placeholder="Ulangi kata sandi">
                          <button type="button" class="pwd-toggle absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" data-target="pwdConfirm"><i class="fas fa-eye text-base"></i></button>
                        </div>
                        @error('password_confirmation')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                      </div>
                    </div>
                    <div class="flex flex-wrap items-center justify-between gap-2 mt-5">
                      <span class="text-[12px] font-semibold text-slate-600">Tingkat Kekuatan Sandi:</span>
                      <span id="strengthLabel" class="text-[12px] font-bold text-emerald-600 flex items-center gap-1.5"><i class="fas fa-shield-alt text-base"></i>Sangat Kuat (Entropi 96-bit)</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mt-2">
                      <div id="bar1" class="h-1.5 rounded-full bg-emerald-600 transition-colors duration-300"></div>
                      <div id="bar2" class="h-1.5 rounded-full bg-emerald-600 transition-colors duration-300"></div>
                      <div id="bar3" class="h-1.5 rounded-full bg-emerald-600 transition-colors duration-300"></div>
                    </div>
                    <p class="text-[11.5px] text-slate-500 mt-2.5 leading-relaxed">Wajib mengombinasikan huruf kapital, angka, simbol unik, dan tanpa pengulangan kata kamus.</p>
                    <button type="submit" class="ai-btn ai-btn-primary w-full mt-4"><i class="fas fa-save text-base"></i>Simpan Kata Sandi</button>
                  </div>

                  <!-- TOTP + FIDO2 -->
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                      <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-mobile-alt text-lg text-slate-700"></i></div>
                        <div class="flex-1 min-w-0">
                          <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-[13.5px] font-bold text-slate-800">Authenticator App (TOTP)</span>
                            <span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span>
                          </div>
                          <p class="text-[12px] text-slate-500 mt-1 leading-relaxed">Terhubung ke Google Authenticator / 1Password. Menghasilkan kode 6 digit berkala.</p>
                        </div>
                      </div>
                      <div class="flex items-center justify-between gap-2 mt-4 pt-3 border-t border-slate-200/70">
                        <span class="text-[11.5px] text-slate-500 font-mono">ID: TOTP-ASTRO-8820</span>
                        <button class="text-[12px] font-bold text-blue-600 hover:text-blue-700" data-toast="Panduan konfigurasi ulang 2FA dikirim ke email resmi Anda." data-toast-type="info">Konfigurasi Ulang 2FA</button>
                      </div>
                    </div>
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                      <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-usb text-lg text-slate-700"></i></div>
                        <div class="flex-1 min-w-0">
                          <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-[13.5px] font-bold text-slate-800">Kunci Fisik YubiKey (FIDO2)</span>
                            <span class="ai-badge bg-emerald-100 text-emerald-700">TERDAFTAR</span>
                          </div>
                          <p class="text-[12px] text-slate-500 mt-1 leading-relaxed">YubiKey 5 NFC Hardware Token untuk verifikasi transaksi mutasi bernilai tinggi.</p>
                        </div>
                      </div>
                      <div class="flex items-center justify-between gap-2 mt-4 pt-3 border-t border-slate-200/70">
                        <span class="text-[11.5px] text-slate-500 font-mono">SN: 198420-YK5</span>
                        <button class="text-[12px] font-bold text-blue-600 hover:text-blue-700" id="btnUjiKunci">Uji Sentuh Kunci</button>
                      </div>
                    </div>
                  </div>

                  <!-- Recovery codes -->
                  <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col md:flex-row md:items-center gap-4">
                    <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-vault text-lg text-slate-700"></i></div>
                    <div class="flex-1 min-w-0">
                      <div class="text-[13.5px] font-bold text-slate-800">Kunci Pemulihan Darurat (Emergency Recovery Codes)</div>
                      <p class="text-[12px] text-slate-500 mt-0.5">8 dari 10 kode pemulihan offline masih tersimpan aman.</p>
                    </div>
                    <div class="flex flex-wrap gap-2 flex-none">
                      <button class="ai-btn ai-btn-secondary" data-modal-open="modalKode"><i class="fas fa-eye text-base"></i>Lihat Kode</button>
                      <button class="ai-btn ai-btn-soft" data-toast="10 kode pemulihan baru digenerate — kode lama otomatis tidak berlaku." data-toast-type="warn"><i class="fas fa-undo text-base"></i>Generate Ulang</button>
                    </div>
                  </div>
                </div>
              </form>
              </div>
            </div>

            <!-- Kolom kanan -->
            <div class="space-y-5">

              <!-- Matriks Hak Akses (RBAC) -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="100">
                <div class="flex items-start gap-3 mb-4">
                  <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
                  <div>
                    <h3 class="text-[15px] font-bold text-slate-800">Matriks Hak Akses (RBAC)</h3>
                    <div class="text-[11px] font-extrabold text-blue-600 mt-0.5 tracking-wide">LEVEL 10: ENTERPRISE OVERLORD</div>
                  </div>
                </div>
                <p class="text-[12px] text-slate-500 leading-relaxed mb-4">Perizinan akun ditentukan otomatis oleh peran Super Admin di seluruh cabang DC.</p>
                <div class="space-y-2.5">
                                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Otorisasi Pengeluaran Barang</span>
                <span class="ai-badge bg-emerald-100 text-emerald-700 font-mono">UNLIMITED</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Akses Master Data &amp; SKU</span>
                <span class="ai-badge bg-blue-100 text-blue-700 font-mono">FULL CRUD</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Modifikasi Pengguna &amp; Staff</span>
                <span class="ai-badge bg-emerald-100 text-emerald-700 font-mono">ALL ROLES</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Audit Forensik &amp; Ekspor Data</span>
                <span class="ai-badge bg-slate-100 text-slate-600 font-mono">GRANTED</span>
              </div>
                </div>
                <div class="mt-4 bg-blue-50 border border-blue-100 rounded-xl py-2.5 text-center text-[12px] font-bold text-blue-700">Kebijakan Zero-Trust Enforcement: AKTIF</div>
              </div>

              <!-- Sesi Login Aktif -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="150">
                <div class="flex items-start gap-3 mb-4">
                  <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none"><i class="fas fa-desktop text-lg text-blue-600"></i></div>
                  <div>
                    <h3 class="text-[15px] font-bold text-slate-800">Sesi Login Aktif</h3>
                    <p class="text-[12px] text-slate-500 mt-0.5">2 Perangkat terhubung saat ini</p>
                  </div>
                </div>
                <div class="space-y-2.5">
                                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5">
                <div class="flex items-center justify-between gap-2">
                  <div class="flex items-center gap-2.5 min-w-0">
                    <i class="fas fa-laptop text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13px] font-bold text-slate-800 truncate">MacBook Pro M2 • Chrome 122</span>
                  </div>
                  <span class="ai-live-dot flex-none"></span>
                </div>
                <div class="text-[11.5px] text-slate-500 mt-1 ml-7">Jakarta, Indonesia • IP 182.253.110.42</div>
              </div>
                <div class="text-[10.5px] font-extrabold text-emerald-600 mt-1.5 ml-7 tracking-wide">PERANGKAT INI (AKTIF SEKARANG)</div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5">
                <div class="flex items-center justify-between gap-2">
                  <div class="flex items-center gap-2.5 min-w-0">
                    <i class="fas fa-mobile-alt text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13px] font-bold text-slate-800 truncate">iPhone 15 Pro • Astro App</span>
                  </div>
                  <span class="text-[11px] text-slate-400 font-medium flex-none">45 mnt lalu</span>
                </div>
                <div class="text-[11.5px] text-slate-500 mt-1 ml-7">Hub Cakung Wi-Fi DC-01 • IP 10.240.12.8</div>
              </div>
                </div>
                <button class="ai-btn ai-btn-danger w-full mt-4" data-modal-open="modalLogoutAll"><i class="fas fa-sign-out-alt text-base"></i>Keluar Dari Semua Perangkat Lain</button>
              </div>

              <!-- Aktivitas Operasional Bulan Ini -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="200">
                <h3 class="text-[15px] font-bold text-slate-800">Aktivitas Operasional Bulan Ini</h3>
                <p class="text-[12px] text-slate-500 mt-0.5 mb-4">Performa akuntabilitas &amp; kepatuhan audit internal.</p>
                <div class="space-y-2.5">
                                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-clipboard-check text-lg text-blue-600"></i></div>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Dokumen Keluar Disetujui</span>
                <span class="text-[18px] font-extrabold text-slate-800" data-count="142">0</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-clipboard-list text-lg text-blue-600"></i></div>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Stok Opname Diverifikasi</span>
                <span class="text-[18px] font-extrabold text-slate-800" data-count="28">0</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-balance-scale text-lg text-blue-600"></i></div>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Pelanggaran SOP / SLA</span>
                <span class="text-[18px] font-extrabold text-emerald-600" data-count="0">0</span>
              </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 3 kartu bawah -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
            <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="80">
              <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center mb-4"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
              <h3 class="text-[15px] font-bold text-slate-800">Privasi &amp; Kepatuhan ISO 27001</h3>
              <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Seluruh riwayat klik, approval, dan mutasi barang terenkripsi menggunakan SHA-256 ledger dan dipantau oleh dewan kepatuhan audit internal Astro.</p>
              <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Dokumen regulasi keamanan ISO 27001 dibuka." data-toast-type="info">Baca Regulasi Keamanan <i class="fas fa-arrow-right text-base"></i></button>
            </div>
            <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="140">
              <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center mb-4"><i class="fas fa-rotate text-lg text-blue-600"></i></div>
              <h3 class="text-[15px] font-bold text-slate-800">Siklus Sandi 90 Hari</h3>
              <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Sesuai kebijakan keamanan gudang terpadu, akun diwajibkan melakukan rotasi kredensial setiap 90 hari kalender. Tersisa 48 hari pada siklus ini.</p>
              <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Rotasi kata sandi dijadwalkan — pengingat dikirim ke kalender kerja Anda." data-toast-type="success">Jadwalkan Rotasi Sandi <i class="fas fa-arrow-right text-base"></i></button>
            </div>
            <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="200">
              <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mb-4"><i class="fas fa-headset text-lg text-emerald-600"></i></div>
              <h3 class="text-[15px] font-bold text-slate-800">CSIRT Astro Incident Response</h3>
              <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Jika Anda mendeteksi anomali login, akses token mencurigakan, atau kehilangan token keamanan fisik, segera eskalasikan ke Pusat Tanggap Darurat IT.</p>
              <button class="mt-4 text-[13px] font-bold text-red-600 hover:text-red-700 flex items-center gap-1.5" data-toast="Tiket darurat CSIRT dibuat — tim tanggap menghubungi Anda < 5 menit." data-toast-type="danger">Buka Tiket Darurat CSIRT <i class="fas fa-asterisk text-base"></i></button>
            </div>
          </div>
        </div>

        <!-- ===== PANEL 2 — KEAMANAN, PASSWORD & 2FA ===== -->
        <div data-tabpanel="profil" data-panel-name="keamanan" style="display:none">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <div class="ai-card ai-card-hover p-5">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center"><i class="fas fa-key text-lg text-emerald-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Riwayat Perubahan Kata Sandi</h2>
                  <p class="text-[12px] text-slate-500">Rotasi wajib setiap 90 hari — tersisa 48 hari.</p>
                </div>
              </div>
              <div class="ai-table">
                <table class="w-full">
                  <thead><tr><th class="text-left rounded-tl-lg">Waktu</th><th class="text-left">Perangkat</th><th class="text-left rounded-tr-lg">Metode</th></tr></thead>
                  <tbody>
                                    <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">42 hari lalu</td><td class="py-2.5 text-slate-500">MacBook Pro M2</td><td class="py-2.5"><span class="ai-badge bg-blue-50 text-blue-700">Manual</span></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">132 hari lalu</td><td class="py-2.5 text-slate-500">iPhone 15 Pro</td><td class="py-2.5"><span class="ai-badge bg-blue-50 text-blue-700">Manual</span></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">221 hari lalu</td><td class="py-2.5 text-slate-500">MacBook Pro M2</td><td class="py-2.5"><span class="ai-badge bg-slate-100 text-slate-600">Paksa Sistem</span></td></tr>
                  </tbody>
                </table>
              </div>
              <button class="ai-btn ai-btn-soft w-full mt-4" data-toast="Pengingat rotasi sandi dipercepat ke hari ini." data-toast-type="warn"><i class="fas fa-rotate text-base"></i>Percepat Rotasi Sekarang</button>
            </div>
            <div class="ai-card ai-card-hover p-5">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-fingerprint text-lg text-blue-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Kebijakan Multi-Factor</h2>
                  <p class="text-[12px] text-slate-500">Lapisan verifikasi untuk aksi berisiko tinggi.</p>
                </div>
              </div>
              <div class="space-y-3">
                            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Minta TOTP untuk Approve DO &gt; Rp 50 Juta</div><div class="text-[11.5px] text-slate-500">Verifikasi kedua di setiap transaksi besar.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">YubiKey Wajib untuk Ekspor Data Audit</div><div class="text-[11.5px] text-slate-500">Sentuh kunci fisik sebelum unduh ledger.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Email Alert Saat Login Perangkat Baru</div><div class="text-[11.5px] text-slate-500">Notifikasi instan ke email resmi.</div></div><div class="ai-switch ai-on"></div></div>
                <button class="ai-btn ai-btn-primary w-full" data-toast="Kebijakan multi-factor tersimpan."><i class="fas fa-save text-base"></i>Simpan Kebijakan</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== PANEL 3 — HAK AKSES & MATRIKS PERIZINAN ===== -->
        <div data-tabpanel="profil" data-panel-name="akses" style="display:none">
          <div class="ai-card ai-card-hover p-5">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Matriks Perizinan Detail per Modul</h2>
                  <p class="text-[12px] text-slate-500">Role: Super Admin • LEVEL 10: ENTERPRISE OVERLORD</p>
                </div>
              </div>
              <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100">Zero-Trust: AKTIF</span>
            </div>
            <div class="ai-table overflow-x-auto">
              <table class="w-full min-w-[640px]">
                <thead><tr><th class="text-left rounded-tl-lg">Modul Sistem</th><th class="text-left">Lihat</th><th class="text-left">Buat / Edit</th><th class="text-left">Hapus</th><th class="text-left rounded-tr-lg">Otorisasi</th></tr></thead>
                <tbody>
                  <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Master Data Barang &amp; SKU">Master Data Barang &amp; SKU</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">UNLIMITED</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Transaksi Barang Masuk / Keluar">Transaksi Barang Masuk / Keluar</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-amber-100 text-amber-700">VOID ONLY</span></td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">UNLIMITED</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Manajemen Pengguna &amp; Role">Manajemen Pengguna &amp; Role</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">ALL ROLES</span></td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-blue-100 text-blue-700">FULL CRUD</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Audit Forensik &amp; Log Sistem">Audit Forensik &amp; Log Sistem</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-slate-100 text-slate-500">IMMUTABLE</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-slate-100 text-slate-600">GRANTED</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Konfigurasi Sistem &amp; Backup rounded-bl-lg">Konfigurasi Sistem &amp; Backup</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5 rounded-br-lg"><span class="ai-badge bg-emerald-100 text-emerald-700">UNLIMITED</span></td></tr>
                </tbody>
              </table>
            </div>
            <p class="text-[11.5px] text-slate-500 mt-4 leading-relaxed">Matriks ditentukan otomatis oleh peran dan tidak dapat diubah manual. Setiap upaya akses di luar matriks tercatat pada ledger SHA-256 dan memicu alert Zero-Trust ke CSIRT.</p>
          </div>
        </div>

        <!-- ===== PANEL 4 — RIWAYAT LOGIN & SESI AKTIF ===== -->
        <div data-tabpanel="profil" data-panel-name="sesi" style="display:none">
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="ai-card ai-card-hover p-5 lg:col-span-2">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-history text-lg text-blue-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Riwayat Login 30 Hari Terakhir</h2>
                  <p class="text-[12px] text-slate-500">Semua percobaan autentikasi tercatat forensik.</p>
                </div>
              </div>
              <div class="ai-table overflow-x-auto">
                <table class="w-full min-w-[560px]">
                  <thead><tr><th class="text-left rounded-tl-lg">Waktu</th><th class="text-left">Perangkat</th><th class="text-left">Lokasi / IP</th><th class="text-left rounded-tr-lg">Status</th></tr></thead>
                  <tbody>
                    <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Hari ini, 07:52 WIB</td><td class="py-2.5 text-slate-500">MacBook Pro M2 • Chrome 122</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Jakarta • 182.253.110.42</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">SUKSES</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Hari ini, 07:10 WIB</td><td class="py-2.5 text-slate-500">iPhone 15 Pro • Astro App</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Hub Cakung • 10.240.12.8</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">SUKSES</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Kemarin, 21:44 WIB</td><td class="py-2.5 text-slate-500">Windows PC • Tidak dikenal</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Surabaya • 118.136.44.19</td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DIBLOKIR 2FA</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 rounded-bl-lg">2 hari lalu, 06:58 WIB</td><td class="py-2.5 text-slate-500">MacBook Pro M2 • Chrome 122</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Jakarta • 182.253.110.42</td><td class="py-2.5 rounded-br-lg"><span class="ai-badge bg-emerald-100 text-emerald-700">SUKSES</span></td></tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="ai-card ai-card-hover p-5">
              <h2 class="text-[15px] font-bold text-slate-800 mb-1">Kontrol Sesi</h2>
              <p class="text-[12px] text-slate-500 mb-4">Kelola durasi &amp; perangkat tepercaya.</p>
              <div class="space-y-3">
                <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Timeout Sesi Idle</label><select class="ai-input"><option>30 menit (Rekomendasi)</option><option>15 menit</option><option>60 menit</option></select></div>
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Perangkat Tepercaya 30 Hari</div><div class="text-[11.5px] text-slate-500">Lewati 2FA pada perangkat familiar.</div></div><div class="ai-switch"></div></div>
                <button class="ai-btn ai-btn-danger w-full" data-modal-open="modalLogoutAll"><i class="fas fa-sign-out-alt text-base"></i>Keluar Dari Semua Perangkat Lain</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== Modal Lihat Kode Pemulihan ===== -->
        <div id="modalKode" class="modal-overlay">
          <div class="modal-box p-6">
            <div class="flex items-center justify-between mb-1">
              <h3 class="text-[16px] font-bold text-slate-800 flex items-center gap-2"><i class="fas fa-vault text-lg text-blue-600"></i>Kode Pemulihan Darurat</h3>
              <button data-close-modal class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-500"><i class="fas fa-times text-base"></i></button>
            </div>
            <p class="text-[12.5px] text-slate-500 mb-4">8 dari 10 kode masih tersimpan aman. Simpan di tempat offline — setiap kode hanya bisa dipakai satu kali.</p>
            <div class="grid grid-cols-2 sm:grid-cols-2 gap-2.5">
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">4XK9-P2QM-7TZR<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">B8NV-QLD3-KW5M<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">TR72-MZP4-XQ8C<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">J6WD-K9TN-2FHL<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">M4QP-8XZ2-RT7B<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-400 line-through flex items-center justify-between">C93K-N7FT-VB2M<span class="ai-badge bg-slate-200 text-slate-500">TERPAKAI</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">Z7RT-4KWP-QN6M<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-400 line-through flex items-center justify-between">H2XM-9TQD-L83K<span class="ai-badge bg-slate-200 text-slate-500">TERPAKAI</span></div>
            </div>
            <div class="flex gap-2 mt-5">
              <button class="ai-btn ai-btn-secondary flex-1" data-toast="Daftar kode pemulihan diunduh terenkripsi." data-toast-type="success"><i class="fas fa-download text-base"></i>Unduh Salinan</button>
              <button class="ai-btn ai-btn-primary flex-1" data-close-modal>Selesai</button>
            </div>
          </div>
        </div>

        <!-- ===== Modal Konfirmasi Keluar Semua Perangkat ===== -->
        <div id="modalLogoutAll" class="modal-overlay">
          <div class="modal-box p-6" style="max-width:440px">
            <div class="w-12 h-12 rounded-xl bg-red-50 border border-red-100 flex items-center justify-center mb-4">
              <i class="fas fa-triangle-exclamation text-xl text-red-500"></i>
            </div>
            <h3 class="text-[16px] font-bold text-slate-800">Keluar Dari Semua Perangkat Lain?</h3>
            <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Sesi pada <span class="font-bold text-slate-700">iPhone 15 Pro • Astro App</span> akan diakhiri paksa dan perangkat tersebut harus login ulang dengan 2FA. Perangkat saat ini tetap aktif.</p>
            <div class="flex gap-2 mt-5">
              <button class="ai-btn ai-btn-secondary flex-1" data-close-modal>Batal</button>
              <button class="ai-btn ai-btn-danger flex-1" id="btnConfirmLogoutAll"><i class="fas fa-sign-out-alt text-base"></i>Ya, Keluar Paksa</button>
            </div>
          </div>
        </div>
        @endif

        @if(auth()->user()->isKepalaGudang())
        <!-- ===== Breadcrumb + status + aksi ===== -->
        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-3 mb-4">
          <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2 text-sm text-gray-500 overflow-x-auto whitespace-nowrap anim-fade-in">
              <span>Beranda</span><i class="fas fa-chevron-right text-xs"></i>
              <span>Pengaturan &amp; Akun</span><i class="fas fa-chevron-right text-xs"></i>
              <span class="text-gray-900 font-medium">Profil Saya</span>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
              <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100"><span class="ai-live-dot"></span>STATUS: TERVERIFIKASI AKTIF</span>
              <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100"><i class="fas fa-shield-alt text-sm"></i>KEPALA GUDANG</span>
            </div>
          </div>
          <div class="flex flex-wrap items-center gap-2.5 flex-none">
            <button class="ai-btn ai-btn-secondary" id="btnBatal"><i class="fas fa-undo text-base"></i>Batal Perubahan</button>
            <button class="ai-btn ai-btn-secondary" data-toast="Ekspor data akun (GDPR) disiapkan — tautan unduh dikirim ke email resmi Anda." data-toast-type="info"><i class="fas fa-download text-base"></i>Unduh Data Akun (GDPR)</button>
            <button type="submit" form="form-identitas" class="ai-btn ai-btn-primary" id="btnSimpanProfil"><i class="fas fa-save text-base"></i>Simpan Profil</button>
          </div>
        </div>

        <!-- ===== Banner hero profil ===== -->
        <div class="ai-card overflow-hidden mb-5 ai-reveal">
          <div class="relative bg-gradient-to-r from-blue-700 via-blue-800 to-slate-900 px-6 md:px-8 py-7 md:pl-44">
            <!-- Avatar -->
            <div class="absolute left-6 md:left-8 top-1/2 -translate-y-1/2">
              <div class="relative">
                <div class="w-24 h-24 rounded-2xl bg-blue-600 border-4 border-white/25 shadow-2xl shadow-blue-950/40 flex items-center justify-center">
                  <span class="text-white text-3xl font-extrabold tracking-wide">{{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 2)) }}</span>
                </div>
                <span class="absolute -bottom-1.5 -right-1.5 w-8 h-8 rounded-full bg-emerald-500 border-[3px] border-slate-900 flex items-center justify-center">
                  <i class="fas fa-check text-base text-white"></i>
                </span>
              </div>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4">
              <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-2.5">
                  <span class="ai-badge bg-slate-900/50 text-blue-100 border border-white/10 font-mono">KKT 1.7.001 // SECURE SESSION V4.8</span>
                  <h1 class="text-white text-2xl md:text-[27px] font-extrabold leading-tight">{{ auth()->user()->nama_lengkap }}</h1>
                  <span class="ai-badge bg-white/10 text-white border border-white/20 font-mono">{{ auth()->user()->nip }}</span>
                </div>
                <p class="text-blue-100 text-[13.5px] font-semibold mt-1.5">Kepala Gudang &amp; Approver Operasional</p>
                <div class="flex flex-wrap items-center gap-x-5 gap-y-1.5 mt-3 text-[12px] text-blue-100/90 font-medium">
                  <span class="flex items-center gap-1.5"><i class="fas fa-envelope text-sm"></i>{{ auth()->user()->email }}</span>
                  <span class="flex items-center gap-1.5"><i class="fas fa-warehouse text-sm"></i>{{ optional(auth()->user()->selectedHub)->name ?? 'Hub Cakung DC-01' }}</span>
                  <span class="flex items-center gap-1.5"><i class="fas fa-calendar text-sm"></i>Bergabung: 15 Mar 2019 (5 Tahun Bertugas)</span>
                </div>
              </div>
              <div class="flex lg:flex-col flex-wrap items-start lg:items-end gap-2 flex-none">
                <span class="ai-badge bg-white/10 text-white border border-white/20 backdrop-blur px-3.5 py-2"><i class="fas fa-shield-alt text-sm"></i>Approver - Level 2 (Wewenang Rp 50 Juta)</span>
                <span class="ai-badge bg-white/10 text-white border border-white/20 backdrop-blur px-3.5 py-2"><i class="fas fa-lock text-sm"></i>2FA Terverifikasi</span>
                <span class="ai-badge bg-white/10 text-white border border-white/20 backdrop-blur px-3.5 py-2"><i class="fas fa-fingerprint text-sm"></i>FIDO2 Enrolled</span>
              </div>
            </div>
          </div>

          <!-- Tab profil -->
          <div class="px-3 py-2.5 border-t border-slate-100 bg-white">
            <div data-tabs="profil" class="flex gap-2 overflow-x-auto">
              <button class="ai-pill ai-pill-active" data-tab="pribadi"><i class="fas fa-user text-base"></i>Informasi Pribadi &amp; Kontak</button>
              <button class="ai-pill" data-tab="keamanan"><i class="fas fa-shield-alt text-base"></i>Keamanan, Password &amp; 2FA</button>
              <button class="ai-pill" data-tab="akses"><i class="fas fa-exchange-alt text-base"></i>Hak Akses &amp; Matriks Perizinan</button>
              <button class="ai-pill" data-tab="sesi"><i class="fas fa-history text-base"></i>Riwayat Login &amp; Sesi Aktif</button>
            </div>
          </div>
        </div>

        <!-- ===== PANEL 1 — INFORMASI PRIBADI & KONTAK ===== -->
        <div data-tabpanel="profil" data-panel-name="pribadi">
          <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

            <!-- Kolom kiri -->
            <div class="xl:col-span-2 space-y-5">

              <!-- Data Identitas -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="80">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
                  <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                      <i class="fas fa-user text-lg text-blue-600"></i>
                    </div>
                    <div>
                      <h2 class="text-[16px] font-bold text-slate-800">Data Identitas Pegawai</h2>
                      <p class="text-[12.5px] text-slate-500 mt-0.5">Informasi akun operasional yang terdaftar pada sistem terpusat Astro Logistics.</p>
                    </div>
                  </div>
                  <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100 font-mono">HRIS SYNCHRONIZED</span>
                </div>

                <form id="form-identitas" method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Nama Lengkap Sesuai KTP / HR</label>
                    <div class="relative">
                      <i class="fas fa-user text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}">
                    </div>
                    @error('nama_lengkap')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                  </div>
                  <div>
                    <div class="flex items-center justify-between mb-1.5">
                      <label class="text-[12px] font-semibold text-slate-600">NIP Karyawan</label>
                      {{-- <span class="text-[10.5px] font-semibold text-slate-400 flex items-center gap-1"><i class="fas fa-lock text-base"></i>Read-only</span> --}}
                    </div>
                    <div class="relative">
                      <i class="fas fa-fingerprint text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9 font-mono bg-slate-50 text-slate-500" value="{{ auth()->user()->nip }}" readonly>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Alamat Email Resmi Perusahaan</label>
                    <div class="relative">
                      <i class="fas fa-envelope text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" name="email" value="{{ old('email', auth()->user()->email) }}">
                    </div>
                    @error('email')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Nomor Handphone / WhatsApp</label>
                    <div class="relative">
                      <i class="fas fa-phone text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                    </div>
                    @error('phone')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                  </div>
                  <div class="md:col-span-2">
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Departemen &amp; Unit Operasional</label>
                    <div class="relative">
                      <i class="fas fa-building text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" value="Operasional Gudang &amp; Logistik (Hub Cakung DC-01)">
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Lokasi Penugasan (Hub DC)</label>
                    <div class="relative">
                      <i class="fas fa-warehouse text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <select class="ai-input pl-9 appearance-none">
                        <option>{{ optional(auth()->user()->selectedHub)->name ?? 'Hub Cakung DC-01' }}</option>
                        <option>Hub Pulogadung DC-02</option>
                        <option>Hub Bekasi DC-03</option>
                      </select>
                      <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Zona Waktu Sistem</label>
                    <div class="relative">
                      <i class="fas fa-globe text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <select class="ai-input pl-9 appearance-none">
                        <option>Asia/Jakarta (WIB UTC+07:00)</option>
                        <option>Asia/Makassar (WITA UTC+08:00)</option>
                        <option>Asia/Jayapura (WIT UTC+09:00)</option>
                      </select>
                      <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Bahasa Sistem</label>
                    <div class="relative">
                      <i class="fas fa-globe text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <select class="ai-input pl-9 appearance-none">
                        <option>Bahasa Indonesia (Standar Operasional)</option>
                        <option>English (US)</option>
                      </select>
                      <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Format Nomor Dokumen SKU</label>
                    <div class="relative">
                      <i class="fas fa-qrcode text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9 font-mono" value="ASTRO-[WH]-[YEAR]-[SEQ]">
                    </div>
                  </div>
                </div>
              </form>
              </div>

              <!-- Kredensial & Keamanan Akun -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="140">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
                  <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center flex-none">
                      <i class="fas fa-lock text-lg text-emerald-600"></i>
                    </div>
                    <div>
                      <h2 class="text-[16px] font-bold text-slate-800">Kredensial &amp; Keamanan Akun</h2>
                      <p class="text-[12.5px] text-slate-500 mt-0.5">Manajemen kata sandi tingkat tinggi, kunci fisik, dan multi-factor token.</p>
                    </div>
                  </div>
                  <span class="ai-badge bg-emerald-100 text-emerald-700 border border-emerald-200"><i class="fas fa-shield-alt text-sm"></i>POSTURE: AMAN</span>
                </div>

<form id="form-password" method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                  <!-- Pembaruan Kata Sandi -->
                  <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 md:p-5">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                      <h3 class="text-[14px] font-bold text-slate-800">Pembaruan Kata Sandi</h3>
                      <span class="text-[11.5px] text-slate-500 font-medium">Terakhir diubah 42 hari lalu</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                      <div>
                        <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kata Sandi Saat Ini</label>
                        <div class="relative">
                          <input id="pwdCurrent" name="current_password" type="password" class="ai-input pr-10 font-mono" placeholder="Kata sandi saat ini">
                          <button type="button" class="pwd-toggle absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" data-target="pwdCurrent"><i class="fas fa-eye text-base"></i></button>
                        </div>
                        @error('current_password')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                      </div>
                      <div>
                        <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kata Sandi Baru</label>
                        <div class="relative">
                          <input id="pwdNew" name="password" type="password" class="ai-input pr-10" placeholder="Minimal 12 karakter">
                          <button type="button" class="pwd-toggle absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" data-target="pwdNew"><i class="fas fa-eye text-base"></i></button>
                        </div>
                        @error('password')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                      </div>
                      <div>
                        <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Konfirmasi Sandi Baru</label>
                        <div class="relative">
                          <input id="pwdConfirm" name="password_confirmation" type="password" class="ai-input pr-10" placeholder="Ulangi kata sandi">
                          <button type="button" class="pwd-toggle absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" data-target="pwdConfirm"><i class="fas fa-eye text-base"></i></button>
                        </div>
                        @error('password_confirmation')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                      </div>
                    </div>
                    <div class="flex flex-wrap items-center justify-between gap-2 mt-5">
                      <span class="text-[12px] font-semibold text-slate-600">Tingkat Kekuatan Sandi:</span>
                      <span id="strengthLabel" class="text-[12px] font-bold text-emerald-600 flex items-center gap-1.5"><i class="fas fa-shield-alt text-base"></i>Sangat Kuat (Entropi 96-bit)</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mt-2">
                      <div id="bar1" class="h-1.5 rounded-full bg-emerald-600 transition-colors duration-300"></div>
                      <div id="bar2" class="h-1.5 rounded-full bg-emerald-600 transition-colors duration-300"></div>
                      <div id="bar3" class="h-1.5 rounded-full bg-emerald-600 transition-colors duration-300"></div>
                    </div>
                    <p class="text-[11.5px] text-slate-500 mt-2.5 leading-relaxed">Wajib mengombinasikan huruf kapital, angka, simbol unik, dan tanpa pengulangan kata kamus.</p>
                    <button type="submit" class="ai-btn ai-btn-primary w-full mt-4"><i class="fas fa-save text-base"></i>Simpan Kata Sandi</button>
                  </div>

                  <!-- TOTP + FIDO2 -->
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                      <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-mobile-alt text-lg text-slate-700"></i></div>
                        <div class="flex-1 min-w-0">
                          <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-[13.5px] font-bold text-slate-800">Authenticator App (TOTP)</span>
                            <span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span>
                          </div>
                          <p class="text-[12px] text-slate-500 mt-1 leading-relaxed">Terhubung ke Google Authenticator / 1Password. Menghasilkan kode 6 digit berkala.</p>
                        </div>
                      </div>
                      <div class="flex items-center justify-between gap-2 mt-4 pt-3 border-t border-slate-200/70">
                        <span class="text-[11.5px] text-slate-500 font-mono">ID: TOTP-ASTRO-7740</span>
                        <button class="text-[12px] font-bold text-blue-600 hover:text-blue-700" data-toast="Panduan konfigurasi ulang 2FA dikirim ke email resmi Anda." data-toast-type="info">Konfigurasi Ulang 2FA</button>
                      </div>
                    </div>
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                      <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-usb text-lg text-slate-700"></i></div>
                        <div class="flex-1 min-w-0">
                          <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-[13.5px] font-bold text-slate-800">PIN Terminal Handheld</span>
                            <span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span>
                          </div>
                          <p class="text-[12px] text-slate-500 mt-1 leading-relaxed">PIN 6 digit perangkat scanner untuk otorisasi operasional shift gudang.</p>
                        </div>
                      </div>
                      <div class="flex items-center justify-between gap-2 mt-4 pt-3 border-t border-slate-200/70">
                        <span class="text-[11.5px] text-slate-500 font-mono">SN: ZBR-TC21-042</span>
                        <button class="text-[12px] font-bold text-blue-600 hover:text-blue-700" id="btnUjiKunci">Uji Sentuh Kunci</button>
                      </div>
                    </div>
                  </div>

                  <!-- Recovery codes -->
                  <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col md:flex-row md:items-center gap-4">
                    <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-vault text-lg text-slate-700"></i></div>
                    <div class="flex-1 min-w-0">
                      <div class="text-[13.5px] font-bold text-slate-800">Kunci Pemulihan Darurat (Emergency Recovery Codes)</div>
                      <p class="text-[12px] text-slate-500 mt-0.5">8 dari 10 kode pemulihan offline masih tersimpan aman.</p>
                    </div>
                    <div class="flex flex-wrap gap-2 flex-none">
                      <button class="ai-btn ai-btn-secondary" data-modal-open="modalKode"><i class="fas fa-eye text-base"></i>Lihat Kode</button>
                      <button class="ai-btn ai-btn-soft" data-toast="10 kode pemulihan baru digenerate — kode lama otomatis tidak berlaku." data-toast-type="warn"><i class="fas fa-undo text-base"></i>Generate Ulang</button>
                    </div>
                  </div>
                </div>
              </form>
              </div>
            </div>

            <!-- Kolom kanan -->
            <div class="space-y-5">

              <!-- Matriks Hak Akses (RBAC) -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="100">
                <div class="flex items-start gap-3 mb-4">
                  <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
                  <div>
                    <h3 class="text-[15px] font-bold text-slate-800">Matriks Hak Akses (RBAC)</h3>
                    <div class="text-[11px] font-extrabold text-blue-600 mt-0.5 tracking-wide">LEVEL 7: OPERATIONAL MANAGER</div>
                  </div>
                </div>
                <p class="text-[12px] text-slate-500 leading-relaxed mb-4">Wewenang persetujuan mutasi &amp; write-off dengan dual-approval Supervisor &amp; Head DC.</p>
                <div class="space-y-2.5">
                                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Wewenang Mutasi &amp; Write-Off (Rp 100 Juta)</span>
                <span class="ai-badge bg-indigo-100 text-indigo-700 font-mono">DUAL APPROVAL</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Akses Master Data &amp; SKU</span>
                <span class="ai-badge bg-blue-100 text-blue-700 font-mono">FULL CRUD</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Persetujuan Barang Masuk / Keluar</span>
                <span class="ai-badge bg-blue-100 text-blue-700 font-mono">APPROVE L2</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Laporan &amp; Analitik</span>
                <span class="ai-badge bg-slate-100 text-slate-600 font-mono">VIEW</span>
              </div>
                </div>
                <div class="mt-4 bg-blue-50 border border-blue-100 rounded-xl py-2.5 text-center text-[12px] font-bold text-blue-700">Kebijakan Zero-Trust Enforcement: AKTIF</div>
              </div>

              <!-- Sesi Login Aktif -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="150">
                <div class="flex items-start gap-3 mb-4">
                  <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none"><i class="fas fa-desktop text-lg text-blue-600"></i></div>
                  <div>
                    <h3 class="text-[15px] font-bold text-slate-800">Sesi Login Aktif</h3>
                    <p class="text-[12px] text-slate-500 mt-0.5">2 Perangkat terhubung saat ini</p>
                  </div>
                </div>
                <div class="space-y-2.5">
                                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5">
                <div class="flex items-center justify-between gap-2">
                  <div class="flex items-center gap-2.5 min-w-0">
                    <i class="fas fa-laptop text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13px] font-bold text-slate-800 truncate">MacBook Pro 16&quot; • Chrome 129.0</span>
                  </div>
                  <span class="ai-live-dot flex-none"></span>
                </div>
                <div class="text-[11.5px] text-slate-500 mt-1 ml-7">IP 10.24.10.42 • Terminal Hub Cakung DC-01 (Kabel LAN LAN-04)</div>
              </div>
                <div class="text-[10.5px] font-extrabold text-emerald-600 mt-1.5 ml-7 tracking-wide">PERANGKAT INI (AKTIF SEKARANG)</div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5">
                <div class="flex items-center justify-between gap-2">
                  <div class="flex items-center gap-2.5 min-w-0">
                    <i class="fas fa-mobile-alt text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13px] font-bold text-slate-800 truncate">Zebra TC52x Handheld Scanner Mobile</span>
                  </div>
                  <span class="text-[11px] text-slate-400 font-medium flex-none">2 mnt lalu</span>
                </div>
                <div class="text-[11.5px] text-slate-500 mt-1 ml-7">IP 10.24.12.18 • Zona Lorong B3 (Gudang Elektronik)</div>
              </div>
                </div>
                <button class="ai-btn ai-btn-danger w-full mt-4" data-modal-open="modalLogoutAll"><i class="fas fa-sign-out-alt text-base"></i>Keluar Dari Semua Perangkat Lain</button>
              </div>

              <!-- Aktivitas Operasional Bulan Ini -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="200">
                <h3 class="text-[15px] font-bold text-slate-800">Aktivitas Operasional Bulan Ini</h3>
                <p class="text-[12px] text-slate-500 mt-0.5 mb-4">Performa akuntabilitas &amp; kepatuhan audit internal.</p>
                <div class="space-y-2.5">
                                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-file-contract text-lg text-blue-600"></i></div>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Persetujuan Mutasi Diproses</span>
                <span class="text-[18px] font-extrabold text-slate-800" data-count="118">0</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-clipboard-check text-lg text-blue-600"></i></div>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Stok Opname Diverifikasi</span>
                <span class="text-[18px] font-extrabold text-slate-800" data-count="32">0</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-balance-scale text-lg text-blue-600"></i></div>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Pelanggaran SOP / SLA</span>
                <span class="text-[18px] font-extrabold text-red-600" data-count="2">0</span>
              </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 3 kartu bawah -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
            <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="80">
              <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center mb-4"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
              <h3 class="text-[15px] font-bold text-slate-800">Privasi &amp; Kepatuhan ISO 27001</h3>
              <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Seluruh riwayat klik, approval, dan mutasi barang terenkripsi menggunakan SHA-256 ledger dan dipantau oleh dewan kepatuhan audit internal Astro.</p>
              <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Dokumen regulasi keamanan ISO 27001 dibuka." data-toast-type="info">Baca Regulasi Keamanan <i class="fas fa-arrow-right text-base"></i></button>
            </div>
            <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="140">
              <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center mb-4"><i class="fas fa-rotate text-lg text-blue-600"></i></div>
              <h3 class="text-[15px] font-bold text-slate-800">Siklus Sandi 90 Hari</h3>
              <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Sesuai kebijakan keamanan gudang terpadu, akun diwajibkan melakukan rotasi kredensial setiap 90 hari kalender. Tersisa 48 hari pada siklus ini.</p>
              <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Rotasi kata sandi dijadwalkan — pengingat dikirim ke kalender kerja Anda." data-toast-type="success">Jadwalkan Rotasi Sandi <i class="fas fa-arrow-right text-base"></i></button>
            </div>
            <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="200">
              <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mb-4"><i class="fas fa-headset text-lg text-emerald-600"></i></div>
              <h3 class="text-[15px] font-bold text-slate-800">CSIRT Astro Incident Response</h3>
              <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Jika Anda mendeteksi anomali login, akses token mencurigakan, atau kehilangan token keamanan fisik, segera eskalasikan ke Pusat Tanggap Darurat IT.</p>
              <button class="mt-4 text-[13px] font-bold text-red-600 hover:text-red-700 flex items-center gap-1.5" data-toast="Tiket darurat CSIRT dibuat — tim tanggap menghubungi Anda < 5 menit." data-toast-type="danger">Buka Tiket Darurat CSIRT <i class="fas fa-asterisk text-base"></i></button>
            </div>
          </div>
        </div>

        <!-- ===== PANEL 2 — KEAMANAN, PASSWORD & 2FA ===== -->
        <div data-tabpanel="profil" data-panel-name="keamanan" style="display:none">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <div class="ai-card ai-card-hover p-5">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center"><i class="fas fa-key text-lg text-emerald-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Riwayat Perubahan Kata Sandi</h2>
                  <p class="text-[12px] text-slate-500">Rotasi wajib setiap 90 hari — tersisa 48 hari.</p>
                </div>
              </div>
              <div class="ai-table">
                <table class="w-full">
                  <thead><tr><th class="text-left rounded-tl-lg">Waktu</th><th class="text-left">Perangkat</th><th class="text-left rounded-tr-lg">Metode</th></tr></thead>
                  <tbody>
                                    <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">45 hari lalu</td><td class="py-2.5 text-slate-500">MacBook Pro 16&quot;</td><td class="py-2.5"><span class="ai-badge bg-blue-50 text-blue-700">Manual</span></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">120 hari lalu</td><td class="py-2.5 text-slate-500">Zebra TC52x Handheld</td><td class="py-2.5"><span class="ai-badge bg-blue-50 text-blue-700">PIN Terminal</span></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">210 hari lalu</td><td class="py-2.5 text-slate-500">MacBook Pro 16&quot;</td><td class="py-2.5"><span class="ai-badge bg-slate-100 text-slate-600">Paksa Sistem</span></td></tr>
                  </tbody>
                </table>
              </div>
              <button class="ai-btn ai-btn-soft w-full mt-4" data-toast="Pengingat rotasi sandi dipercepat ke hari ini." data-toast-type="warn"><i class="fas fa-rotate text-base"></i>Percepat Rotasi Sekarang</button>
            </div>
            <div class="ai-card ai-card-hover p-5">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-fingerprint text-lg text-blue-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Kebijakan Multi-Factor</h2>
                  <p class="text-[12px] text-slate-500">Lapisan verifikasi untuk aksi berisiko tinggi.</p>
                </div>
              </div>
              <div class="space-y-3">
                            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Minta TOTP untuk Approve Mutasi &gt; Rp 50 Juta</div><div class="text-[11.5px] text-slate-500">Verifikasi kedua di setiap transaksi besar.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">PIN Terminal Wajib untuk Operasional Shift</div><div class="text-[11.5px] text-slate-500">Setiap buka kunci scanner meminta PIN.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Email Alert Saat Login Perangkat Baru</div><div class="text-[11.5px] text-slate-500">Notifikasi instan ke email resmi.</div></div><div class="ai-switch ai-on"></div></div>
                <button class="ai-btn ai-btn-primary w-full" data-toast="Kebijakan multi-factor tersimpan."><i class="fas fa-save text-base"></i>Simpan Kebijakan</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== PANEL 3 — HAK AKSES & MATRIKS PERIZINAN ===== -->
        <div data-tabpanel="profil" data-panel-name="akses" style="display:none">
          <div class="ai-card ai-card-hover p-5">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Matriks Perizinan Detail per Modul</h2>
                  <p class="text-[12px] text-slate-500">Role: Kepala Gudang • LEVEL 7: OPERATIONAL MANAGER</p>
                </div>
              </div>
              <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100">Zero-Trust: AKTIF</span>
            </div>
            <div class="ai-table overflow-x-auto">
              <table class="w-full min-w-[640px]">
                <thead><tr><th class="text-left rounded-tl-lg">Modul Sistem</th><th class="text-left">Lihat</th><th class="text-left">Buat / Edit</th><th class="text-left">Hapus</th><th class="text-left rounded-tr-lg">Otorisasi</th></tr></thead>
                <tbody>
                  <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Master Data Barang &amp; Lokasi">Master Data Barang &amp; Lokasi</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-blue-100 text-blue-700">APPROVE L2</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Transaksi Barang Masuk / Keluar">Transaksi Barang Masuk / Keluar</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-blue-100 text-blue-700">APPROVE L2</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Manajemen Pengguna &amp; Role">Manajemen Pengguna &amp; Role</td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Persetujuan &amp; Delegasi">Persetujuan &amp; Delegasi</td><td class="py-2.5"><span class="ai-badge bg-slate-100 text-slate-600">VIEW</span></td><td class="py-2.5"><span class="ai-badge bg-blue-100 text-blue-700">APPROVE L2</span></td><td class="py-2.5"><span class="ai-badge bg-amber-100 text-amber-700">VOID ONLY</span></td><td class="py-2.5"><span class="ai-badge bg-blue-100 text-blue-700">APPROVE</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Laporan &amp; Analitik rounded-bl-lg">Laporan &amp; Analitik</td><td class="py-2.5"><span class="ai-badge bg-slate-100 text-slate-600">VIEW</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5 rounded-br-lg"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td></tr>
                </tbody>
              </table>
            </div>
            <p class="text-[11.5px] text-slate-500 mt-4 leading-relaxed">Matriks ditentukan otomatis oleh peran dan tidak dapat diubah manual. Setiap upaya akses di luar matriks tercatat pada ledger SHA-256 dan memicu alert Zero-Trust ke CSIRT.</p>
          </div>
        </div>

        <!-- ===== PANEL 4 — RIWAYAT LOGIN & SESI AKTIF ===== -->
        <div data-tabpanel="profil" data-panel-name="sesi" style="display:none">
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="ai-card ai-card-hover p-5 lg:col-span-2">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-history text-lg text-blue-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Riwayat Login 30 Hari Terakhir</h2>
                  <p class="text-[12px] text-slate-500">Semua percobaan autentikasi tercatat forensik.</p>
                </div>
              </div>
              <div class="ai-table overflow-x-auto">
                <table class="w-full min-w-[560px]">
                  <thead><tr><th class="text-left rounded-tl-lg">Waktu</th><th class="text-left">Perangkat</th><th class="text-left">Lokasi / IP</th><th class="text-left rounded-tr-lg">Status</th></tr></thead>
                  <tbody>
                    <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Hari ini, 07:52 WIB</td><td class="py-2.5 text-slate-500">MacBook Pro 16&quot; • Chrome 129.0</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Jakarta • 10.24.10.42</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">SUKSES</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Hari ini, 07:10 WIB</td><td class="py-2.5 text-slate-500">Zebra TC52x Handheld</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Hub Cakung • 10.24.12.18</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">SUKSES</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Kemarin, 21:44 WIB</td><td class="py-2.5 text-slate-500">Windows PC • Tidak dikenal</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Surabaya • 118.136.44.19</td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DIBLOKIR 2FA</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 rounded-bl-lg">2 hari lalu, 06:58 WIB</td><td class="py-2.5 text-slate-500">MacBook Pro 16&quot; • Chrome 129.0</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Jakarta • 10.24.10.42</td><td class="py-2.5 rounded-br-lg"><span class="ai-badge bg-emerald-100 text-emerald-700">SUKSES</span></td></tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="ai-card ai-card-hover p-5">
              <h2 class="text-[15px] font-bold text-slate-800 mb-1">Kontrol Sesi</h2>
              <p class="text-[12px] text-slate-500 mb-4">Kelola durasi &amp; perangkat tepercaya.</p>
              <div class="space-y-3">
                <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Timeout Sesi Idle</label><select class="ai-input"><option>30 menit (Rekomendasi)</option><option>15 menit</option><option>60 menit</option></select></div>
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Perangkat Tepercaya 30 Hari</div><div class="text-[11.5px] text-slate-500">Lewati 2FA pada perangkat familiar.</div></div><div class="ai-switch"></div></div>
                <button class="ai-btn ai-btn-danger w-full" data-modal-open="modalLogoutAll"><i class="fas fa-sign-out-alt text-base"></i>Keluar Dari Semua Perangkat Lain</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== Modal Lihat Kode Pemulihan ===== -->
        <div id="modalKode" class="modal-overlay">
          <div class="modal-box p-6">
            <div class="flex items-center justify-between mb-1">
              <h3 class="text-[16px] font-bold text-slate-800 flex items-center gap-2"><i class="fas fa-vault text-lg text-blue-600"></i>Kode Pemulihan Darurat</h3>
              <button data-close-modal class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-500"><i class="fas fa-times text-base"></i></button>
            </div>
            <p class="text-[12.5px] text-slate-500 mb-4">8 dari 10 kode masih tersimpan aman. Simpan di tempat offline — setiap kode hanya bisa dipakai satu kali.</p>
            <div class="grid grid-cols-2 sm:grid-cols-2 gap-2.5">
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">4XK9-P2QM-7TZR<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">B8NV-QLD3-KW5M<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">TR72-MZP4-XQ8C<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">J6WD-K9TN-2FHL<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">M4QP-8XZ2-RT7B<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-400 line-through flex items-center justify-between">C93K-N7FT-VB2M<span class="ai-badge bg-slate-200 text-slate-500">TERPAKAI</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">Z7RT-4KWP-QN6M<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-400 line-through flex items-center justify-between">H2XM-9TQD-L83K<span class="ai-badge bg-slate-200 text-slate-500">TERPAKAI</span></div>
            </div>
            <div class="flex gap-2 mt-5">
              <button class="ai-btn ai-btn-secondary flex-1" data-toast="Daftar kode pemulihan diunduh terenkripsi." data-toast-type="success"><i class="fas fa-download text-base"></i>Unduh Salinan</button>
              <button class="ai-btn ai-btn-primary flex-1" data-close-modal>Selesai</button>
            </div>
          </div>
        </div>

        <!-- ===== Modal Konfirmasi Keluar Semua Perangkat ===== -->
        <div id="modalLogoutAll" class="modal-overlay">
          <div class="modal-box p-6" style="max-width:440px">
            <div class="w-12 h-12 rounded-xl bg-red-50 border border-red-100 flex items-center justify-center mb-4">
              <i class="fas fa-triangle-exclamation text-xl text-red-500"></i>
            </div>
            <h3 class="text-[16px] font-bold text-slate-800">Keluar Dari Semua Perangkat Lain?</h3>
            <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Sesi pada <span class="font-bold text-slate-700">Zebra TC52x Handheld Scanner Mobile</span> akan diakhiri paksa dan perangkat tersebut harus login ulang dengan 2FA. Perangkat saat ini tetap aktif.</p>
            <div class="flex gap-2 mt-5">
              <button class="ai-btn ai-btn-secondary flex-1" data-close-modal>Batal</button>
              <button class="ai-btn ai-btn-danger flex-1" id="btnConfirmLogoutAll"><i class="fas fa-sign-out-alt text-base"></i>Ya, Keluar Paksa</button>
            </div>
          </div>
        </div>
        @endif

        @if(auth()->user()->isHR())
        <!-- ===== Breadcrumb + status + aksi ===== -->
        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-3 mb-4">
          <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2 text-sm text-gray-500 overflow-x-auto whitespace-nowrap anim-fade-in">
              <span>Beranda</span><i class="fas fa-chevron-right text-xs"></i>
              <span>Pengaturan &amp; Akun</span><i class="fas fa-chevron-right text-xs"></i>
              <span class="text-gray-900 font-medium">Profil Saya</span>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
              <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100"><span class="ai-live-dot"></span>STATUS: TERVERIFIKASI AKTIF</span>
              <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100"><i class="fas fa-shield-alt text-sm"></i>HR APPROVER</span>
            </div>
          </div>
          <div class="flex flex-wrap items-center gap-2.5 flex-none">
            <button class="ai-btn ai-btn-secondary" id="btnBatal"><i class="fas fa-undo text-base"></i>Batal Perubahan</button>
            <button class="ai-btn ai-btn-secondary" data-toast="Ekspor data akun (GDPR) disiapkan — tautan unduh dikirim ke email resmi Anda." data-toast-type="info"><i class="fas fa-download text-base"></i>Unduh Data Akun (GDPR)</button>
            <button type="submit" form="form-identitas" class="ai-btn ai-btn-primary" id="btnSimpanProfil"><i class="fas fa-save text-base"></i>Simpan Profil</button>
          </div>
        </div>

        <!-- ===== Banner hero profil ===== -->
        <div class="ai-card overflow-hidden mb-5 ai-reveal">
          <div class="relative bg-gradient-to-r from-blue-700 via-blue-800 to-slate-900 px-6 md:px-8 py-7 md:pl-44">
            <!-- Avatar -->
            <div class="absolute left-6 md:left-8 top-1/2 -translate-y-1/2">
              <div class="relative">
                <div class="w-24 h-24 rounded-2xl bg-blue-600 border-4 border-white/25 shadow-2xl shadow-blue-950/40 flex items-center justify-center">
                  <span class="text-white text-3xl font-extrabold tracking-wide">{{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 2)) }}</span>
                </div>
                <span class="absolute -bottom-1.5 -right-1.5 w-8 h-8 rounded-full bg-emerald-500 border-[3px] border-slate-900 flex items-center justify-center">
                  <i class="fas fa-check text-base text-white"></i>
                </span>
              </div>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4">
              <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-2.5">
                  <span class="ai-badge bg-slate-900/50 text-blue-100 border border-white/10 font-mono">KKT 1.7.001 // SECURE SESSION V4.8</span>
                  <h1 class="text-white text-2xl md:text-[27px] font-extrabold leading-tight">{{ auth()->user()->nama_lengkap }}</h1>
                  <span class="ai-badge bg-white/10 text-white border border-white/20 font-mono">{{ auth()->user()->nip }}</span>
                </div>
                <p class="text-blue-100 text-[13.5px] font-semibold mt-1.5">HR Approver &amp; Otorisasi Logistik</p>
                <div class="flex flex-wrap items-center gap-x-5 gap-y-1.5 mt-3 text-[12px] text-blue-100/90 font-medium">
                  <span class="flex items-center gap-1.5"><i class="fas fa-envelope text-sm"></i>{{ auth()->user()->email }}</span>
                  <span class="flex items-center gap-1.5"><i class="fas fa-warehouse text-sm"></i>{{ optional(auth()->user()->selectedHub)->name ?? 'Hub Cakung DC-01' }}</span>
                  <span class="flex items-center gap-1.5"><i class="fas fa-calendar text-sm"></i>Bergabung: 01 Sep 2020 (4 Tahun Bertugas)</span>
                </div>
              </div>
              <div class="flex lg:flex-col flex-wrap items-start lg:items-end gap-2 flex-none">
                <span class="ai-badge bg-white/10 text-white border border-white/20 backdrop-blur px-3.5 py-2"><i class="fas fa-shield-alt text-sm"></i>Approver - Level 3 (Mutasi &amp; Write-Off)</span>
                <span class="ai-badge bg-white/10 text-white border border-white/20 backdrop-blur px-3.5 py-2"><i class="fas fa-lock text-sm"></i>2FA Terverifikasi</span>
                <span class="ai-badge bg-white/10 text-white border border-white/20 backdrop-blur px-3.5 py-2"><i class="fas fa-fingerprint text-sm"></i>FIDO2 Enrolled</span>
              </div>
            </div>
          </div>

          <!-- Tab profil -->
          <div class="px-3 py-2.5 border-t border-slate-100 bg-white">
            <div data-tabs="profil" class="flex gap-2 overflow-x-auto">
              <button class="ai-pill ai-pill-active" data-tab="pribadi"><i class="fas fa-user text-base"></i>Informasi Pribadi &amp; Kontak</button>
              <button class="ai-pill" data-tab="keamanan"><i class="fas fa-shield-alt text-base"></i>Keamanan, Password &amp; 2FA</button>
              <button class="ai-pill" data-tab="akses"><i class="fas fa-exchange-alt text-base"></i>Hak Akses &amp; Matriks Perizinan</button>
              <button class="ai-pill" data-tab="sesi"><i class="fas fa-history text-base"></i>Riwayat Login &amp; Sesi Aktif</button>
            </div>
          </div>
        </div>

        <!-- ===== PANEL 1 — INFORMASI PRIBADI & KONTAK ===== -->
        <div data-tabpanel="profil" data-panel-name="pribadi">
          <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

            <!-- Kolom kiri -->
            <div class="xl:col-span-2 space-y-5">

              <!-- Data Identitas -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="80">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
                  <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                      <i class="fas fa-user text-lg text-blue-600"></i>
                    </div>
                    <div>
                      <h2 class="text-[16px] font-bold text-slate-800">Data Identitas Pegawai</h2>
                      <p class="text-[12.5px] text-slate-500 mt-0.5">Informasi akun operasional yang terdaftar pada sistem terpusat Astro Logistics.</p>
                    </div>
                  </div>
                  <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100 font-mono">HRIS SYNCHRONIZED</span>
                </div>

                <form id="form-identitas" method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Nama Lengkap Sesuai KTP / HR</label>
                    <div class="relative">
                      <i class="fas fa-user text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}">
                    </div>
                    @error('nama_lengkap')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                  </div>
                  <div>
                    <div class="flex items-center justify-between mb-1.5">
                      <label class="text-[12px] font-semibold text-slate-600">NIP Karyawan</label>
                      {{-- <span class="text-[10.5px] font-semibold text-slate-400 flex items-center gap-1"><i class="fas fa-lock text-base"></i>Read-only</span> --}}
                    </div>
                    <div class="relative">
                      <i class="fas fa-fingerprint text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9 font-mono bg-slate-50 text-slate-500" value="{{ auth()->user()->nip }}" readonly>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Alamat Email Resmi Perusahaan</label>
                    <div class="relative">
                      <i class="fas fa-envelope text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" name="email" value="{{ old('email', auth()->user()->email) }}">
                    </div>
                    @error('email')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Nomor Handphone / WhatsApp</label>
                    <div class="relative">
                      <i class="fas fa-phone text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                    </div>
                    @error('phone')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                  </div>
                  <div class="md:col-span-2">
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Departemen &amp; Unit Operasional</label>
                    <div class="relative">
                      <i class="fas fa-building text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" value="Human Resources &amp; Approval (Supply Chain Directorate)">
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Lokasi Penugasan (Hub DC)</label>
                    <div class="relative">
                      <i class="fas fa-warehouse text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <select class="ai-input pl-9 appearance-none">
                        <option>{{ optional(auth()->user()->selectedHub)->name ?? 'Hub Cakung DC-01' }}</option>
                        <option>Hub Pulogadung DC-02</option>
                        <option>Hub Bekasi DC-03</option>
                      </select>
                      <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Zona Waktu Sistem</label>
                    <div class="relative">
                      <i class="fas fa-globe text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <select class="ai-input pl-9 appearance-none">
                        <option>Asia/Jakarta (WIB UTC+07:00)</option>
                        <option>Asia/Makassar (WITA UTC+08:00)</option>
                        <option>Asia/Jayapura (WIT UTC+09:00)</option>
                      </select>
                      <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Bahasa Sistem</label>
                    <div class="relative">
                      <i class="fas fa-globe text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <select class="ai-input pl-9 appearance-none">
                        <option>Bahasa Indonesia (Standar Operasional)</option>
                        <option>English (US)</option>
                      </select>
                      <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Format Nomor Dokumen SKU</label>
                    <div class="relative">
                      <i class="fas fa-qrcode text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9 font-mono" value="ASTRO-[WH]-[YEAR]-[SEQ]">
                    </div>
                  </div>
                </div>
              </form>
              </div>

              <!-- Kredensial & Keamanan Akun -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="140">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
                  <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center flex-none">
                      <i class="fas fa-lock text-lg text-emerald-600"></i>
                    </div>
                    <div>
                      <h2 class="text-[16px] font-bold text-slate-800">Kredensial &amp; Keamanan Akun</h2>
                      <p class="text-[12.5px] text-slate-500 mt-0.5">Manajemen kata sandi tingkat tinggi, kunci fisik, dan multi-factor token.</p>
                    </div>
                  </div>
                  <span class="ai-badge bg-emerald-100 text-emerald-700 border border-emerald-200"><i class="fas fa-shield-alt text-sm"></i>POSTURE: AMAN</span>
                </div>

<form id="form-password" method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                  <!-- Pembaruan Kata Sandi -->
                  <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 md:p-5">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                      <h3 class="text-[14px] font-bold text-slate-800">Pembaruan Kata Sandi</h3>
                      <span class="text-[11.5px] text-slate-500 font-medium">Terakhir diubah 42 hari lalu</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                      <div>
                        <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kata Sandi Saat Ini</label>
                        <div class="relative">
                          <input id="pwdCurrent" name="current_password" type="password" class="ai-input pr-10 font-mono" placeholder="Kata sandi saat ini">
                          <button type="button" class="pwd-toggle absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" data-target="pwdCurrent"><i class="fas fa-eye text-base"></i></button>
                        </div>
                        @error('current_password')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                      </div>
                      <div>
                        <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kata Sandi Baru</label>
                        <div class="relative">
                          <input id="pwdNew" name="password" type="password" class="ai-input pr-10" placeholder="Minimal 12 karakter">
                          <button type="button" class="pwd-toggle absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" data-target="pwdNew"><i class="fas fa-eye text-base"></i></button>
                        </div>
                        @error('password')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                      </div>
                      <div>
                        <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Konfirmasi Sandi Baru</label>
                        <div class="relative">
                          <input id="pwdConfirm" name="password_confirmation" type="password" class="ai-input pr-10" placeholder="Ulangi kata sandi">
                          <button type="button" class="pwd-toggle absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" data-target="pwdConfirm"><i class="fas fa-eye text-base"></i></button>
                        </div>
                        @error('password_confirmation')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                      </div>
                    </div>
                    <div class="flex flex-wrap items-center justify-between gap-2 mt-5">
                      <span class="text-[12px] font-semibold text-slate-600">Tingkat Kekuatan Sandi:</span>
                      <span id="strengthLabel" class="text-[12px] font-bold text-emerald-600 flex items-center gap-1.5"><i class="fas fa-shield-alt text-base"></i>Sangat Kuat (Entropi 96-bit)</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mt-2">
                      <div id="bar1" class="h-1.5 rounded-full bg-emerald-600 transition-colors duration-300"></div>
                      <div id="bar2" class="h-1.5 rounded-full bg-emerald-600 transition-colors duration-300"></div>
                      <div id="bar3" class="h-1.5 rounded-full bg-emerald-600 transition-colors duration-300"></div>
                    </div>
                    <p class="text-[11.5px] text-slate-500 mt-2.5 leading-relaxed">Wajib mengombinasikan huruf kapital, angka, simbol unik, dan tanpa pengulangan kata kamus.</p>
                    <button type="submit" class="ai-btn ai-btn-primary w-full mt-4"><i class="fas fa-save text-base"></i>Simpan Kata Sandi</button>
                  </div>

                  <!-- TOTP + FIDO2 -->
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                      <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-mobile-alt text-lg text-slate-700"></i></div>
                        <div class="flex-1 min-w-0">
                          <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-[13.5px] font-bold text-slate-800">Authenticator App (TOTP)</span>
                            <span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span>
                          </div>
                          <p class="text-[12px] text-slate-500 mt-1 leading-relaxed">Terhubung ke Google Authenticator / 1Password. Menghasilkan kode 6 digit berkala.</p>
                        </div>
                      </div>
                      <div class="flex items-center justify-between gap-2 mt-4 pt-3 border-t border-slate-200/70">
                        <span class="text-[11.5px] text-slate-500 font-mono">ID: TOTP-ASTRO-7784</span>
                        <button class="text-[12px] font-bold text-blue-600 hover:text-blue-700" data-toast="Panduan konfigurasi ulang 2FA dikirim ke email resmi Anda." data-toast-type="info">Konfigurasi Ulang 2FA</button>
                      </div>
                    </div>
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                      <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-usb text-lg text-slate-700"></i></div>
                        <div class="flex-1 min-w-0">
                          <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-[13.5px] font-bold text-slate-800">OTP Perangkat HR</span>
                            <span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span>
                          </div>
                          <p class="text-[12px] text-slate-500 mt-1 leading-relaxed">OTP 6 digit untuk verifikasi persetujuan di atas plafon mandiri.</p>
                        </div>
                      </div>
                      <div class="flex items-center justify-between gap-2 mt-4 pt-3 border-t border-slate-200/70">
                        <span class="text-[11.5px] text-slate-500 font-mono">SN: TOTP-ASTRO-7784</span>
                        <button class="text-[12px] font-bold text-blue-600 hover:text-blue-700" id="btnUjiKunci">Uji Sentuh Kunci</button>
                      </div>
                    </div>
                  </div>

                  <!-- Recovery codes -->
                  <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col md:flex-row md:items-center gap-4">
                    <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-vault text-lg text-slate-700"></i></div>
                    <div class="flex-1 min-w-0">
                      <div class="text-[13.5px] font-bold text-slate-800">Kunci Pemulihan Darurat (Emergency Recovery Codes)</div>
                      <p class="text-[12px] text-slate-500 mt-0.5">8 dari 10 kode pemulihan offline masih tersimpan aman.</p>
                    </div>
                    <div class="flex flex-wrap gap-2 flex-none">
                      <button class="ai-btn ai-btn-secondary" data-modal-open="modalKode"><i class="fas fa-eye text-base"></i>Lihat Kode</button>
                      <button class="ai-btn ai-btn-soft" data-toast="10 kode pemulihan baru digenerate — kode lama otomatis tidak berlaku." data-toast-type="warn"><i class="fas fa-undo text-base"></i>Generate Ulang</button>
                    </div>
                  </div>
                </div>
              </form>
              </div>
            </div>

            <!-- Kolom kanan -->
            <div class="space-y-5">

              <!-- Matriks Hak Akses (RBAC) -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="100">
                <div class="flex items-start gap-3 mb-4">
                  <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
                  <div>
                    <h3 class="text-[15px] font-bold text-slate-800">Matriks Hak Akses (RBAC)</h3>
                    <div class="text-[11px] font-extrabold text-blue-600 mt-0.5 tracking-wide">LEVEL 6: HR APPROVER</div>
                  </div>
                </div>
                <p class="text-[12px] text-slate-500 leading-relaxed mb-4">Otorisasi persetujuan mutasi, hak akses staf, dan kepatuhan audit logistik.</p>
                <div class="space-y-2.5">
                                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Otorisasi Persetujuan Mutasi</span>
                <span class="ai-badge bg-blue-100 text-blue-700 font-mono">APPROVE L3</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Hak Akses Staf &amp; Approval HR</span>
                <span class="ai-badge bg-emerald-100 text-emerald-700 font-mono">FULL</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Log Audit &amp; Otorisasi</span>
                <span class="ai-badge bg-slate-100 text-slate-600 font-mono">VIEW</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Laporan Inventaris</span>
                <span class="ai-badge bg-slate-100 text-slate-600 font-mono">VIEW</span>
              </div>
                </div>
                <div class="mt-4 bg-blue-50 border border-blue-100 rounded-xl py-2.5 text-center text-[12px] font-bold text-blue-700">Kebijakan Zero-Trust Enforcement: AKTIF</div>
              </div>

              <!-- Sesi Login Aktif -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="150">
                <div class="flex items-start gap-3 mb-4">
                  <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none"><i class="fas fa-desktop text-lg text-blue-600"></i></div>
                  <div>
                    <h3 class="text-[15px] font-bold text-slate-800">Sesi Login Aktif</h3>
                    <p class="text-[12px] text-slate-500 mt-0.5">2 Perangkat terhubung saat ini</p>
                  </div>
                </div>
                <div class="space-y-2.5">
                                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5">
                <div class="flex items-center justify-between gap-2">
                  <div class="flex items-center gap-2.5 min-w-0">
                    <i class="fas fa-laptop text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13px] font-bold text-slate-800 truncate">MacBook Pro M2 • Chrome 122</span>
                  </div>
                  <span class="ai-live-dot flex-none"></span>
                </div>
                <div class="text-[11.5px] text-slate-500 mt-1 ml-7">IP 10.24.18.42 • Terminal Hub Cakung DC-01</div>
              </div>
                <div class="text-[10.5px] font-extrabold text-emerald-600 mt-1.5 ml-7 tracking-wide">PERANGKAT INI (AKTIF SEKARANG)</div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5">
                <div class="flex items-center justify-between gap-2">
                  <div class="flex items-center gap-2.5 min-w-0">
                    <i class="fas fa-mobile-alt text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13px] font-bold text-slate-800 truncate">iPhone 15 Pro • Astro App</span>
                  </div>
                  <span class="text-[11px] text-slate-400 font-medium flex-none">35 mnt lalu</span>
                </div>
                <div class="text-[11.5px] text-slate-500 mt-1 ml-7">Hub Cakung Wi-Fi DC-01 • IP 10.240.12.8</div>
              </div>
                </div>
                <button class="ai-btn ai-btn-danger w-full mt-4" data-modal-open="modalLogoutAll"><i class="fas fa-sign-out-alt text-base"></i>Keluar Dari Semua Perangkat Lain</button>
              </div>

              <!-- Aktivitas Operasional Bulan Ini -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="200">
                <h3 class="text-[15px] font-bold text-slate-800">Aktivitas Operasional Bulan Ini</h3>
                <p class="text-[12px] text-slate-500 mt-0.5 mb-4">Performa akuntabilitas &amp; kepatuhan audit internal.</p>
                <div class="space-y-2.5">
                                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-file-contract text-lg text-blue-600"></i></div>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Persetujuan HR Diproses</span>
                <span class="text-[18px] font-extrabold text-slate-800" data-count="96">0</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Log Audit Diverifikasi</span>
                <span class="text-[18px] font-extrabold text-slate-800" data-count="41">0</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-balance-scale text-lg text-blue-600"></i></div>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Pelanggaran SOP / SLA</span>
                <span class="text-[18px] font-extrabold text-amber-600" data-count="1">0</span>
              </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 3 kartu bawah -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
            <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="80">
              <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center mb-4"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
              <h3 class="text-[15px] font-bold text-slate-800">Privasi &amp; Kepatuhan ISO 27001</h3>
              <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Seluruh riwayat klik, approval, dan mutasi barang terenkripsi menggunakan SHA-256 ledger dan dipantau oleh dewan kepatuhan audit internal Astro.</p>
              <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Dokumen regulasi keamanan ISO 27001 dibuka." data-toast-type="info">Baca Regulasi Keamanan <i class="fas fa-arrow-right text-base"></i></button>
            </div>
            <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="140">
              <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center mb-4"><i class="fas fa-rotate text-lg text-blue-600"></i></div>
              <h3 class="text-[15px] font-bold text-slate-800">Siklus Sandi 90 Hari</h3>
              <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Sesuai kebijakan keamanan gudang terpadu, akun diwajibkan melakukan rotasi kredensial setiap 90 hari kalender. Tersisa 48 hari pada siklus ini.</p>
              <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Rotasi kata sandi dijadwalkan — pengingat dikirim ke kalender kerja Anda." data-toast-type="success">Jadwalkan Rotasi Sandi <i class="fas fa-arrow-right text-base"></i></button>
            </div>
            <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="200">
              <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mb-4"><i class="fas fa-headset text-lg text-emerald-600"></i></div>
              <h3 class="text-[15px] font-bold text-slate-800">CSIRT Astro Incident Response</h3>
              <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Jika Anda mendeteksi anomali login, akses token mencurigakan, atau kehilangan token keamanan fisik, segera eskalasikan ke Pusat Tanggap Darurat IT.</p>
              <button class="mt-4 text-[13px] font-bold text-red-600 hover:text-red-700 flex items-center gap-1.5" data-toast="Tiket darurat CSIRT dibuat — tim tanggap menghubungi Anda < 5 menit." data-toast-type="danger">Buka Tiket Darurat CSIRT <i class="fas fa-asterisk text-base"></i></button>
            </div>
          </div>
        </div>

        <!-- ===== PANEL 2 — KEAMANAN, PASSWORD & 2FA ===== -->
        <div data-tabpanel="profil" data-panel-name="keamanan" style="display:none">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <div class="ai-card ai-card-hover p-5">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center"><i class="fas fa-key text-lg text-emerald-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Riwayat Perubahan Kata Sandi</h2>
                  <p class="text-[12px] text-slate-500">Rotasi wajib setiap 90 hari — tersisa 48 hari.</p>
                </div>
              </div>
              <div class="ai-table">
                <table class="w-full">
                  <thead><tr><th class="text-left rounded-tl-lg">Waktu</th><th class="text-left">Perangkat</th><th class="text-left rounded-tr-lg">Metode</th></tr></thead>
                  <tbody>
                                    <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">38 hari lalu</td><td class="py-2.5 text-slate-500">MacBook Pro M2</td><td class="py-2.5"><span class="ai-badge bg-blue-50 text-blue-700">Manual</span></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">130 hari lalu</td><td class="py-2.5 text-slate-500">iPhone 15 Pro</td><td class="py-2.5"><span class="ai-badge bg-blue-50 text-blue-700">Manual</span></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">225 hari lalu</td><td class="py-2.5 text-slate-500">MacBook Pro M2</td><td class="py-2.5"><span class="ai-badge bg-slate-100 text-slate-600">Paksa Sistem</span></td></tr>
                  </tbody>
                </table>
              </div>
              <button class="ai-btn ai-btn-soft w-full mt-4" data-toast="Pengingat rotasi sandi dipercepat ke hari ini." data-toast-type="warn"><i class="fas fa-rotate text-base"></i>Percepat Rotasi Sekarang</button>
            </div>
            <div class="ai-card ai-card-hover p-5">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-fingerprint text-lg text-blue-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Kebijakan Multi-Factor</h2>
                  <p class="text-[12px] text-slate-500">Lapisan verifikasi untuk aksi berisiko tinggi.</p>
                </div>
              </div>
              <div class="space-y-3">
                            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Minta TOTP untuk Approve &gt; Rp 100 Juta</div><div class="text-[11.5px] text-slate-500">Verifikasi kedua di setiap persetujuan besar.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">OTP Wajib untuk Ubah Hak Akses Staf</div><div class="text-[11.5px] text-slate-500">Perubahan otorisasi memerlukan konfirmasi.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Email Alert Saat Login Perangkat Baru</div><div class="text-[11.5px] text-slate-500">Notifikasi instan ke email resmi.</div></div><div class="ai-switch ai-on"></div></div>
                <button class="ai-btn ai-btn-primary w-full" data-toast="Kebijakan multi-factor tersimpan."><i class="fas fa-save text-base"></i>Simpan Kebijakan</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== PANEL 3 — HAK AKSES & MATRIKS PERIZINAN ===== -->
        <div data-tabpanel="profil" data-panel-name="akses" style="display:none">
          <div class="ai-card ai-card-hover p-5">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Matriks Perizinan Detail per Modul</h2>
                  <p class="text-[12px] text-slate-500">Role: HR Approver • LEVEL 6: HR APPROVER</p>
                </div>
              </div>
              <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100">Zero-Trust: AKTIF</span>
            </div>
            <div class="ai-table overflow-x-auto">
              <table class="w-full min-w-[640px]">
                <thead><tr><th class="text-left rounded-tl-lg">Modul Sistem</th><th class="text-left">Lihat</th><th class="text-left">Buat / Edit</th><th class="text-left">Hapus</th><th class="text-left rounded-tr-lg">Otorisasi</th></tr></thead>
                <tbody>
                  <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Antrean Persetujuan Mutasi">Antrean Persetujuan Mutasi</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-blue-100 text-blue-700">APPROVE L3</span></td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-blue-100 text-blue-700">APPROVE</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Hak Akses &amp; Otorisasi Staf">Hak Akses &amp; Otorisasi Staf</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-blue-100 text-blue-700">APPROVE</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Log Audit &amp; Otorisasi">Log Audit &amp; Otorisasi</td><td class="py-2.5"><span class="ai-badge bg-slate-100 text-slate-600">VIEW</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Laporan Inventaris HR">Laporan Inventaris HR</td><td class="py-2.5"><span class="ai-badge bg-slate-100 text-slate-600">VIEW</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Master Data Barang rounded-bl-lg">Master Data Barang</td><td class="py-2.5"><span class="ai-badge bg-slate-100 text-slate-600">VIEW</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5 rounded-br-lg"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td></tr>
                </tbody>
              </table>
            </div>
            <p class="text-[11.5px] text-slate-500 mt-4 leading-relaxed">Matriks ditentukan otomatis oleh peran dan tidak dapat diubah manual. Setiap upaya akses di luar matriks tercatat pada ledger SHA-256 dan memicu alert Zero-Trust ke CSIRT.</p>
          </div>
        </div>

        <!-- ===== PANEL 4 — RIWAYAT LOGIN & SESI AKTIF ===== -->
        <div data-tabpanel="profil" data-panel-name="sesi" style="display:none">
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="ai-card ai-card-hover p-5 lg:col-span-2">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-history text-lg text-blue-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Riwayat Login 30 Hari Terakhir</h2>
                  <p class="text-[12px] text-slate-500">Semua percobaan autentikasi tercatat forensik.</p>
                </div>
              </div>
              <div class="ai-table overflow-x-auto">
                <table class="w-full min-w-[560px]">
                  <thead><tr><th class="text-left rounded-tl-lg">Waktu</th><th class="text-left">Perangkat</th><th class="text-left">Lokasi / IP</th><th class="text-left rounded-tr-lg">Status</th></tr></thead>
                  <tbody>
                    <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Hari ini, 07:52 WIB</td><td class="py-2.5 text-slate-500">MacBook Pro M2 • Chrome 122</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Jakarta • 10.24.18.42</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">SUKSES</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Hari ini, 07:10 WIB</td><td class="py-2.5 text-slate-500">iPhone 15 Pro • Astro App</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Hub Cakung • 10.240.12.8</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">SUKSES</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Kemarin, 21:44 WIB</td><td class="py-2.5 text-slate-500">Windows PC • Tidak dikenal</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Surabaya • 118.136.44.19</td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DIBLOKIR 2FA</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 rounded-bl-lg">2 hari lalu, 06:58 WIB</td><td class="py-2.5 text-slate-500">MacBook Pro M2 • Chrome 122</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Jakarta • 10.24.18.42</td><td class="py-2.5 rounded-br-lg"><span class="ai-badge bg-emerald-100 text-emerald-700">SUKSES</span></td></tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="ai-card ai-card-hover p-5">
              <h2 class="text-[15px] font-bold text-slate-800 mb-1">Kontrol Sesi</h2>
              <p class="text-[12px] text-slate-500 mb-4">Kelola durasi &amp; perangkat tepercaya.</p>
              <div class="space-y-3">
                <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Timeout Sesi Idle</label><select class="ai-input"><option>30 menit (Rekomendasi)</option><option>15 menit</option><option>60 menit</option></select></div>
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Perangkat Tepercaya 30 Hari</div><div class="text-[11.5px] text-slate-500">Lewati 2FA pada perangkat familiar.</div></div><div class="ai-switch"></div></div>
                <button class="ai-btn ai-btn-danger w-full" data-modal-open="modalLogoutAll"><i class="fas fa-sign-out-alt text-base"></i>Keluar Dari Semua Perangkat Lain</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== Modal Lihat Kode Pemulihan ===== -->
        <div id="modalKode" class="modal-overlay">
          <div class="modal-box p-6">
            <div class="flex items-center justify-between mb-1">
              <h3 class="text-[16px] font-bold text-slate-800 flex items-center gap-2"><i class="fas fa-vault text-lg text-blue-600"></i>Kode Pemulihan Darurat</h3>
              <button data-close-modal class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-500"><i class="fas fa-times text-base"></i></button>
            </div>
            <p class="text-[12.5px] text-slate-500 mb-4">8 dari 10 kode masih tersimpan aman. Simpan di tempat offline — setiap kode hanya bisa dipakai satu kali.</p>
            <div class="grid grid-cols-2 sm:grid-cols-2 gap-2.5">
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">4XK9-P2QM-7TZR<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">B8NV-QLD3-KW5M<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">TR72-MZP4-XQ8C<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">J6WD-K9TN-2FHL<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">M4QP-8XZ2-RT7B<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-400 line-through flex items-center justify-between">C93K-N7FT-VB2M<span class="ai-badge bg-slate-200 text-slate-500">TERPAKAI</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">Z7RT-4KWP-QN6M<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-400 line-through flex items-center justify-between">H2XM-9TQD-L83K<span class="ai-badge bg-slate-200 text-slate-500">TERPAKAI</span></div>
            </div>
            <div class="flex gap-2 mt-5">
              <button class="ai-btn ai-btn-secondary flex-1" data-toast="Daftar kode pemulihan diunduh terenkripsi." data-toast-type="success"><i class="fas fa-download text-base"></i>Unduh Salinan</button>
              <button class="ai-btn ai-btn-primary flex-1" data-close-modal>Selesai</button>
            </div>
          </div>
        </div>

        <!-- ===== Modal Konfirmasi Keluar Semua Perangkat ===== -->
        <div id="modalLogoutAll" class="modal-overlay">
          <div class="modal-box p-6" style="max-width:440px">
            <div class="w-12 h-12 rounded-xl bg-red-50 border border-red-100 flex items-center justify-center mb-4">
              <i class="fas fa-triangle-exclamation text-xl text-red-500"></i>
            </div>
            <h3 class="text-[16px] font-bold text-slate-800">Keluar Dari Semua Perangkat Lain?</h3>
            <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Sesi pada <span class="font-bold text-slate-700">iPhone 15 Pro • Astro App</span> akan diakhiri paksa dan perangkat tersebut harus login ulang dengan 2FA. Perangkat saat ini tetap aktif.</p>
            <div class="flex gap-2 mt-5">
              <button class="ai-btn ai-btn-secondary flex-1" data-close-modal>Batal</button>
              <button class="ai-btn ai-btn-danger flex-1" id="btnConfirmLogoutAll"><i class="fas fa-sign-out-alt text-base"></i>Ya, Keluar Paksa</button>
            </div>
          </div>
        </div>
        @endif

        @if(auth()->user()->isPegawai())
        <!-- ===== Breadcrumb + status + aksi ===== -->
        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-3 mb-4">
          <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2 text-sm text-gray-500 overflow-x-auto whitespace-nowrap anim-fade-in">
              <span>Beranda</span><i class="fas fa-chevron-right text-xs"></i>
              <span>Pengaturan &amp; Akun</span><i class="fas fa-chevron-right text-xs"></i>
              <span class="text-gray-900 font-medium">Profil Saya</span>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
              <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100"><span class="ai-live-dot"></span>STATUS: TERVERIFIKASI AKTIF</span>
              <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100"><i class="fas fa-shield-alt text-sm"></i>STAFF OPERASIONAL</span>
            </div>
          </div>
          <div class="flex flex-wrap items-center gap-2.5 flex-none">
            <button class="ai-btn ai-btn-secondary" id="btnBatal"><i class="fas fa-undo text-base"></i>Batal Perubahan</button>
            <button class="ai-btn ai-btn-secondary" data-toast="Ekspor data akun (GDPR) disiapkan — tautan unduh dikirim ke email resmi Anda." data-toast-type="info"><i class="fas fa-download text-base"></i>Unduh Data Akun (GDPR)</button>
            <button type="submit" form="form-identitas" class="ai-btn ai-btn-primary" id="btnSimpanProfil"><i class="fas fa-save text-base"></i>Simpan Profil</button>
          </div>
        </div>

        <!-- ===== Banner hero profil ===== -->
        <div class="ai-card overflow-hidden mb-5 ai-reveal">
          <div class="relative bg-gradient-to-r from-blue-700 via-blue-800 to-slate-900 px-6 md:px-8 py-7 md:pl-44">
            <!-- Avatar -->
            <div class="absolute left-6 md:left-8 top-1/2 -translate-y-1/2">
              <div class="relative">
                <div class="w-24 h-24 rounded-2xl bg-blue-600 border-4 border-white/25 shadow-2xl shadow-blue-950/40 flex items-center justify-center">
                  <span class="text-white text-3xl font-extrabold tracking-wide">{{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 2)) }}</span>
                </div>
                <span class="absolute -bottom-1.5 -right-1.5 w-8 h-8 rounded-full bg-emerald-500 border-[3px] border-slate-900 flex items-center justify-center">
                  <i class="fas fa-check text-base text-white"></i>
                </span>
              </div>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4">
              <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-2.5">
                  <span class="ai-badge bg-slate-900/50 text-blue-100 border border-white/10 font-mono">KKT 1.7.001 // SECURE SESSION V4.8</span>
                  <h1 class="text-white text-2xl md:text-[27px] font-extrabold leading-tight">{{ auth()->user()->nama_lengkap }}</h1>
                  <span class="ai-badge bg-white/10 text-white border border-white/20 font-mono">{{ auth()->user()->nip }}</span>
                </div>
                <p class="text-blue-100 text-[13.5px] font-semibold mt-1.5">Senior Warehouse Operator &amp; Inbound Checker</p>
                <div class="flex flex-wrap items-center gap-x-5 gap-y-1.5 mt-3 text-[12px] text-blue-100/90 font-medium">
                  <span class="flex items-center gap-1.5"><i class="fas fa-envelope text-sm"></i>{{ auth()->user()->email }}</span>
                  <span class="flex items-center gap-1.5"><i class="fas fa-warehouse text-sm"></i>{{ optional(auth()->user()->selectedHub)->name ?? 'Hub Cakung DC-01' }}</span>
                  <span class="flex items-center gap-1.5"><i class="fas fa-calendar text-sm"></i>Bergabung: 03 Feb 2023 (1 Tahun Bertugas)</span>
                </div>
              </div>
              <div class="flex lg:flex-col flex-wrap items-start lg:items-end gap-2 flex-none">
                <span class="ai-badge bg-white/10 text-white border border-white/20 backdrop-blur px-3.5 py-2"><i class="fas fa-shield-alt text-sm"></i>Staf Operasional - Shift Pagi</span>
                <span class="ai-badge bg-white/10 text-white border border-white/20 backdrop-blur px-3.5 py-2"><i class="fas fa-lock text-sm"></i>2FA Terverifikasi</span>
                <span class="ai-badge bg-white/10 text-white border border-white/20 backdrop-blur px-3.5 py-2"><i class="fas fa-fingerprint text-sm"></i>FIDO2 Enrolled</span>
              </div>
            </div>
          </div>

          <!-- Tab profil -->
          <div class="px-3 py-2.5 border-t border-slate-100 bg-white">
            <div data-tabs="profil" class="flex gap-2 overflow-x-auto">
              <button class="ai-pill ai-pill-active" data-tab="pribadi"><i class="fas fa-user text-base"></i>Informasi Pribadi &amp; Kontak</button>
              <button class="ai-pill" data-tab="keamanan"><i class="fas fa-shield-alt text-base"></i>Keamanan, Password &amp; 2FA</button>
              <button class="ai-pill" data-tab="akses"><i class="fas fa-exchange-alt text-base"></i>Hak Akses &amp; Matriks Perizinan</button>
              <button class="ai-pill" data-tab="sesi"><i class="fas fa-history text-base"></i>Riwayat Login &amp; Sesi Aktif</button>
            </div>
          </div>
        </div>

        <!-- ===== PANEL 1 — INFORMASI PRIBADI & KONTAK ===== -->
        <div data-tabpanel="profil" data-panel-name="pribadi">
          <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

            <!-- Kolom kiri -->
            <div class="xl:col-span-2 space-y-5">

              <!-- Data Identitas -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="80">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
                  <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                      <i class="fas fa-user text-lg text-blue-600"></i>
                    </div>
                    <div>
                      <h2 class="text-[16px] font-bold text-slate-800">Data Identitas Pegawai</h2>
                      <p class="text-[12.5px] text-slate-500 mt-0.5">Informasi akun operasional yang terdaftar pada sistem terpusat Astro Logistics.</p>
                    </div>
                  </div>
                  <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100 font-mono">HRIS SYNCHRONIZED</span>
                </div>

                <form id="form-identitas" method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Nama Lengkap Sesuai KTP / HR</label>
                    <div class="relative">
                      <i class="fas fa-user text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}">
                    </div>
                    @error('nama_lengkap')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                  </div>
                  <div>
                    <div class="flex items-center justify-between mb-1.5">
                      <label class="text-[12px] font-semibold text-slate-600">NIP Karyawan</label>
                      {{-- <span class="text-[10.5px] font-semibold text-slate-400 flex items-center gap-1"><i class="fas fa-lock text-base"></i>Read-only</span> --}}
                    </div>
                    <div class="relative">
                      <i class="fas fa-fingerprint text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9 font-mono bg-slate-50 text-slate-500" value="{{ auth()->user()->nip }}" readonly>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Alamat Email Resmi Perusahaan</label>
                    <div class="relative">
                      <i class="fas fa-envelope text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" name="email" value="{{ old('email', auth()->user()->email) }}">
                    </div>
                    @error('email')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Nomor Handphone / WhatsApp</label>
                    <div class="relative">
                      <i class="fas fa-phone text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                    </div>
                    @error('phone')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                  </div>
                  <div class="md:col-span-2">
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Departemen &amp; Unit Operasional</label>
                    <div class="relative">
                      <i class="fas fa-building text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" value="Warehouse Operations - Staf Operasional (Zona A &amp; Staging Inbound)">
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Lokasi Penugasan (Hub DC)</label>
                    <div class="relative">
                      <i class="fas fa-warehouse text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <select class="ai-input pl-9 appearance-none">
                        <option>{{ optional(auth()->user()->selectedHub)->name ?? 'Hub Cakung DC-01' }}</option>
                        <option>Hub Pulogadung DC-02</option>
                        <option>Hub Bekasi DC-03</option>
                      </select>
                      <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Zona Waktu Sistem</label>
                    <div class="relative">
                      <i class="fas fa-globe text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <select class="ai-input pl-9 appearance-none">
                        <option>Asia/Jakarta (WIB UTC+07:00)</option>
                        <option>Asia/Makassar (WITA UTC+08:00)</option>
                        <option>Asia/Jayapura (WIT UTC+09:00)</option>
                      </select>
                      <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Bahasa Sistem</label>
                    <div class="relative">
                      <i class="fas fa-globe text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <select class="ai-input pl-9 appearance-none">
                        <option>Bahasa Indonesia (Standar Operasional)</option>
                        <option>English (US)</option>
                      </select>
                      <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Format Nomor Dokumen SKU</label>
                    <div class="relative">
                      <i class="fas fa-qrcode text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9 font-mono" value="ASTRO-[WH]-[YEAR]-[SEQ]">
                    </div>
                  </div>
                </div>
              </form>
              </div>

              <!-- Kredensial & Keamanan Akun -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="140">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
                  <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center flex-none">
                      <i class="fas fa-lock text-lg text-emerald-600"></i>
                    </div>
                    <div>
                      <h2 class="text-[16px] font-bold text-slate-800">Kredensial &amp; Keamanan Akun</h2>
                      <p class="text-[12.5px] text-slate-500 mt-0.5">Manajemen kata sandi tingkat tinggi, kunci fisik, dan multi-factor token.</p>
                    </div>
                  </div>
                  <span class="ai-badge bg-emerald-100 text-emerald-700 border border-emerald-200"><i class="fas fa-shield-alt text-sm"></i>POSTURE: AMAN</span>
                </div>

<form id="form-password" method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                  <!-- Pembaruan Kata Sandi -->
                  <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 md:p-5">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                      <h3 class="text-[14px] font-bold text-slate-800">Pembaruan Kata Sandi</h3>
                      <span class="text-[11.5px] text-slate-500 font-medium">Terakhir diubah 42 hari lalu</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                      <div>
                        <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kata Sandi Saat Ini</label>
                        <div class="relative">
                          <input id="pwdCurrent" name="current_password" type="password" class="ai-input pr-10 font-mono" placeholder="Kata sandi saat ini">
                          <button type="button" class="pwd-toggle absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" data-target="pwdCurrent"><i class="fas fa-eye text-base"></i></button>
                        </div>
                        @error('current_password')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                      </div>
                      <div>
                        <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kata Sandi Baru</label>
                        <div class="relative">
                          <input id="pwdNew" name="password" type="password" class="ai-input pr-10" placeholder="Minimal 12 karakter">
                          <button type="button" class="pwd-toggle absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" data-target="pwdNew"><i class="fas fa-eye text-base"></i></button>
                        </div>
                        @error('password')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                      </div>
                      <div>
                        <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Konfirmasi Sandi Baru</label>
                        <div class="relative">
                          <input id="pwdConfirm" name="password_confirmation" type="password" class="ai-input pr-10" placeholder="Ulangi kata sandi">
                          <button type="button" class="pwd-toggle absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" data-target="pwdConfirm"><i class="fas fa-eye text-base"></i></button>
                        </div>
                        @error('password_confirmation')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                      </div>
                    </div>
                    <div class="flex flex-wrap items-center justify-between gap-2 mt-5">
                      <span class="text-[12px] font-semibold text-slate-600">Tingkat Kekuatan Sandi:</span>
                      <span id="strengthLabel" class="text-[12px] font-bold text-emerald-600 flex items-center gap-1.5"><i class="fas fa-shield-alt text-base"></i>Sangat Kuat (Entropi 96-bit)</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mt-2">
                      <div id="bar1" class="h-1.5 rounded-full bg-emerald-600 transition-colors duration-300"></div>
                      <div id="bar2" class="h-1.5 rounded-full bg-emerald-600 transition-colors duration-300"></div>
                      <div id="bar3" class="h-1.5 rounded-full bg-emerald-600 transition-colors duration-300"></div>
                    </div>
                    <p class="text-[11.5px] text-slate-500 mt-2.5 leading-relaxed">Wajib mengombinasikan huruf kapital, angka, simbol unik, dan tanpa pengulangan kata kamus.</p>
                    <button type="submit" class="ai-btn ai-btn-primary w-full mt-4"><i class="fas fa-save text-base"></i>Simpan Kata Sandi</button>
                  </div>

                  <!-- TOTP + FIDO2 -->
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                      <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-mobile-alt text-lg text-slate-700"></i></div>
                        <div class="flex-1 min-w-0">
                          <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-[13.5px] font-bold text-slate-800">Authenticator App (TOTP)</span>
                            <span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span>
                          </div>
                          <p class="text-[12px] text-slate-500 mt-1 leading-relaxed">Terhubung ke Google Authenticator / 1Password. Menghasilkan kode 6 digit berkala.</p>
                        </div>
                      </div>
                      <div class="flex items-center justify-between gap-2 mt-4 pt-3 border-t border-slate-200/70">
                        <span class="text-[11.5px] text-slate-500 font-mono">ID: TOTP-ASTRO-9021</span>
                        <button class="text-[12px] font-bold text-blue-600 hover:text-blue-700" data-toast="Panduan konfigurasi ulang 2FA dikirim ke email resmi Anda." data-toast-type="info">Konfigurasi Ulang 2FA</button>
                      </div>
                    </div>
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                      <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-usb text-lg text-slate-700"></i></div>
                        <div class="flex-1 min-w-0">
                          <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-[13.5px] font-bold text-slate-800">PIN Scanner Zebra TC21</span>
                            <span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span>
                          </div>
                          <p class="text-[12px] text-slate-500 mt-1 leading-relaxed">PIN 6 digit terminal handheld untuk buka kunci sesi shift.</p>
                        </div>
                      </div>
                      <div class="flex items-center justify-between gap-2 mt-4 pt-3 border-t border-slate-200/70">
                        <span class="text-[11.5px] text-slate-500 font-mono">SN: ZBR-TC21-042</span>
                        <button class="text-[12px] font-bold text-blue-600 hover:text-blue-700" id="btnUjiKunci">Uji Sentuh Kunci</button>
                      </div>
                    </div>
                  </div>

                  <!-- Recovery codes -->
                  <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col md:flex-row md:items-center gap-4">
                    <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-vault text-lg text-slate-700"></i></div>
                    <div class="flex-1 min-w-0">
                      <div class="text-[13.5px] font-bold text-slate-800">Kunci Pemulihan Darurat (Emergency Recovery Codes)</div>
                      <p class="text-[12px] text-slate-500 mt-0.5">8 dari 10 kode pemulihan offline masih tersimpan aman.</p>
                    </div>
                    <div class="flex flex-wrap gap-2 flex-none">
                      <button class="ai-btn ai-btn-secondary" data-modal-open="modalKode"><i class="fas fa-eye text-base"></i>Lihat Kode</button>
                      <button class="ai-btn ai-btn-soft" data-toast="10 kode pemulihan baru digenerate — kode lama otomatis tidak berlaku." data-toast-type="warn"><i class="fas fa-undo text-base"></i>Generate Ulang</button>
                    </div>
                  </div>
                </div>
              </form>
              </div>
            </div>

            <!-- Kolom kanan -->
            <div class="space-y-5">

              <!-- Matriks Hak Akses (RBAC) -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="100">
                <div class="flex items-start gap-3 mb-4">
                  <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
                  <div>
                    <h3 class="text-[15px] font-bold text-slate-800">Matriks Hak Akses (RBAC)</h3>
                    <div class="text-[11px] font-extrabold text-blue-600 mt-0.5 tracking-wide">LEVEL 3: WAREHOUSE OPERATOR</div>
                  </div>
                </div>
                <p class="text-[12px] text-slate-500 leading-relaxed mb-4">Akses terbatas pada transaksi receiving, issue, dan monitoring status.</p>
                <div class="space-y-2.5">
                                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Input Barang Masuk (Receiving)</span>
                <span class="ai-badge bg-blue-100 text-blue-700 font-mono">CREATE</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Input Barang Keluar (Issue)</span>
                <span class="ai-badge bg-blue-100 text-blue-700 font-mono">CREATE</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Riwayat Transaksi</span>
                <span class="ai-badge bg-slate-100 text-slate-600 font-mono">VIEW</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Status Permintaan</span>
                <span class="ai-badge bg-slate-100 text-slate-600 font-mono">VIEW</span>
              </div>
                </div>
                <div class="mt-4 bg-blue-50 border border-blue-100 rounded-xl py-2.5 text-center text-[12px] font-bold text-blue-700">Kebijakan Zero-Trust Enforcement: AKTIF</div>
              </div>

              <!-- Sesi Login Aktif -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="150">
                <div class="flex items-start gap-3 mb-4">
                  <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none"><i class="fas fa-desktop text-lg text-blue-600"></i></div>
                  <div>
                    <h3 class="text-[15px] font-bold text-slate-800">Sesi Login Aktif</h3>
                    <p class="text-[12px] text-slate-500 mt-0.5">2 Perangkat terhubung saat ini</p>
                  </div>
                </div>
                <div class="space-y-2.5">
                                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5">
                <div class="flex items-center justify-between gap-2">
                  <div class="flex items-center gap-2.5 min-w-0">
                    <i class="fas fa-barcode text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13px] font-bold text-slate-800 truncate">Zebra TC21 Handheld Scanner</span>
                  </div>
                  <span class="ai-live-dot flex-none"></span>
                </div>
                <div class="text-[11.5px] text-slate-500 mt-1 ml-7">Wi-Fi DC-01 • IP 192.168.10.45 • Zona A</div>
              </div>
                <div class="text-[10.5px] font-extrabold text-emerald-600 mt-1.5 ml-7 tracking-wide">PERANGKAT INI (AKTIF SEKARANG)</div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5">
                <div class="flex items-center justify-between gap-2">
                  <div class="flex items-center gap-2.5 min-w-0">
                    <i class="fas fa-desktop text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13px] font-bold text-slate-800 truncate">PC Terminal Staging A</span>
                  </div>
                  <span class="text-[11px] text-slate-400 font-medium flex-none">1 jam lalu</span>
                </div>
                <div class="text-[11.5px] text-slate-500 mt-1 ml-7">IP 10.24.10.45 • Staging Inbound</div>
              </div>
                </div>
                <button class="ai-btn ai-btn-danger w-full mt-4" data-modal-open="modalLogoutAll"><i class="fas fa-sign-out-alt text-base"></i>Keluar Dari Semua Perangkat Lain</button>
              </div>

              <!-- Aktivitas Operasional Bulan Ini -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="200">
                <h3 class="text-[15px] font-bold text-slate-800">Aktivitas Operasional Bulan Ini</h3>
                <p class="text-[12px] text-slate-500 mt-0.5 mb-4">Performa akuntabilitas &amp; kepatuhan audit internal.</p>
                <div class="space-y-2.5">
                                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-tasks text-lg text-blue-600"></i></div>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Transaksi Diproses (Item)</span>
                <span class="text-[18px] font-extrabold text-slate-800" data-count="1420">0</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-clipboard-check text-lg text-blue-600"></i></div>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Inbound PO Selesai SLA</span>
                <span class="text-[18px] font-extrabold text-slate-800" data-count="42">0</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-balance-scale text-lg text-blue-600"></i></div>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Pelanggaran SOP / SLA</span>
                <span class="text-[18px] font-extrabold text-emerald-600" data-count="0">0</span>
              </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 3 kartu bawah -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
            <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="80">
              <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center mb-4"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
              <h3 class="text-[15px] font-bold text-slate-800">Privasi &amp; Kepatuhan ISO 27001</h3>
              <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Seluruh riwayat klik, approval, dan mutasi barang terenkripsi menggunakan SHA-256 ledger dan dipantau oleh dewan kepatuhan audit internal Astro.</p>
              <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Dokumen regulasi keamanan ISO 27001 dibuka." data-toast-type="info">Baca Regulasi Keamanan <i class="fas fa-arrow-right text-base"></i></button>
            </div>
            <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="140">
              <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center mb-4"><i class="fas fa-rotate text-lg text-blue-600"></i></div>
              <h3 class="text-[15px] font-bold text-slate-800">Siklus Sandi 90 Hari</h3>
              <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Sesuai kebijakan keamanan gudang terpadu, akun diwajibkan melakukan rotasi kredensial setiap 90 hari kalender. Tersisa 48 hari pada siklus ini.</p>
              <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Rotasi kata sandi dijadwalkan — pengingat dikirim ke kalender kerja Anda." data-toast-type="success">Jadwalkan Rotasi Sandi <i class="fas fa-arrow-right text-base"></i></button>
            </div>
            <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="200">
              <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mb-4"><i class="fas fa-headset text-lg text-emerald-600"></i></div>
              <h3 class="text-[15px] font-bold text-slate-800">CSIRT Astro Incident Response</h3>
              <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Jika Anda mendeteksi anomali login, akses token mencurigakan, atau kehilangan token keamanan fisik, segera eskalasikan ke Pusat Tanggap Darurat IT.</p>
              <button class="mt-4 text-[13px] font-bold text-red-600 hover:text-red-700 flex items-center gap-1.5" data-toast="Tiket darurat CSIRT dibuat — tim tanggap menghubungi Anda < 5 menit." data-toast-type="danger">Buka Tiket Darurat CSIRT <i class="fas fa-asterisk text-base"></i></button>
            </div>
          </div>
        </div>

        <!-- ===== PANEL 2 — KEAMANAN, PASSWORD & 2FA ===== -->
        <div data-tabpanel="profil" data-panel-name="keamanan" style="display:none">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <div class="ai-card ai-card-hover p-5">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center"><i class="fas fa-key text-lg text-emerald-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Riwayat Perubahan Kata Sandi</h2>
                  <p class="text-[12px] text-slate-500">Rotasi wajib setiap 90 hari — tersisa 48 hari.</p>
                </div>
              </div>
              <div class="ai-table">
                <table class="w-full">
                  <thead><tr><th class="text-left rounded-tl-lg">Waktu</th><th class="text-left">Perangkat</th><th class="text-left rounded-tr-lg">Metode</th></tr></thead>
                  <tbody>
                                    <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">12 hari lalu</td><td class="py-2.5 text-slate-500">Zebra TC21 Handheld</td><td class="py-2.5"><span class="ai-badge bg-blue-50 text-blue-700">PIN Terminal</span></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">90 hari lalu</td><td class="py-2.5 text-slate-500">PC Terminal Staging A</td><td class="py-2.5"><span class="ai-badge bg-blue-50 text-blue-700">Manual</span></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">180 hari lalu</td><td class="py-2.5 text-slate-500">Zebra TC21 Handheld</td><td class="py-2.5"><span class="ai-badge bg-slate-100 text-slate-600">Paksa Sistem</span></td></tr>
                  </tbody>
                </table>
              </div>
              <button class="ai-btn ai-btn-soft w-full mt-4" data-toast="Pengingat rotasi sandi dipercepat ke hari ini." data-toast-type="warn"><i class="fas fa-rotate text-base"></i>Percepat Rotasi Sekarang</button>
            </div>
            <div class="ai-card ai-card-hover p-5">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-fingerprint text-lg text-blue-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Kebijakan Multi-Factor</h2>
                  <p class="text-[12px] text-slate-500">Lapisan verifikasi untuk aksi berisiko tinggi.</p>
                </div>
              </div>
              <div class="space-y-3">
                            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">PIN Scanner Wajib untuk Buka Terminal</div><div class="text-[11.5px] text-slate-500">Setiap sesi shift memerlukan PIN.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Konfirmasi Ulang untuk Input Manual SKU</div><div class="text-[11.5px] text-slate-500">Validasi ganda saat entry manual.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Email Alert Saat Login Perangkat Baru</div><div class="text-[11.5px] text-slate-500">Notifikasi instan ke email resmi.</div></div><div class="ai-switch ai-on"></div></div>
                <button class="ai-btn ai-btn-primary w-full" data-toast="Kebijakan multi-factor tersimpan."><i class="fas fa-save text-base"></i>Simpan Kebijakan</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== PANEL 3 — HAK AKSES & MATRIKS PERIZINAN ===== -->
        <div data-tabpanel="profil" data-panel-name="akses" style="display:none">
          <div class="ai-card ai-card-hover p-5">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Matriks Perizinan Detail per Modul</h2>
                  <p class="text-[12px] text-slate-500">Role: Staf Operasional • LEVEL 3: WAREHOUSE OPERATOR</p>
                </div>
              </div>
              <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100">Zero-Trust: AKTIF</span>
            </div>
            <div class="ai-table overflow-x-auto">
              <table class="w-full min-w-[640px]">
                <thead><tr><th class="text-left rounded-tl-lg">Modul Sistem</th><th class="text-left">Lihat</th><th class="text-left">Buat / Edit</th><th class="text-left">Hapus</th><th class="text-left rounded-tr-lg">Otorisasi</th></tr></thead>
                <tbody>
                  <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Barang Masuk (Receiving)">Barang Masuk (Receiving)</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-blue-100 text-blue-700">CREATE</span></td><td class="py-2.5"><span class="ai-badge bg-blue-100 text-blue-700">CREATE</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Barang Keluar (Issue)">Barang Keluar (Issue)</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-blue-100 text-blue-700">CREATE</span></td><td class="py-2.5"><span class="ai-badge bg-blue-100 text-blue-700">CREATE</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Riwayat Transaksi">Riwayat Transaksi</td><td class="py-2.5"><span class="ai-badge bg-slate-100 text-slate-600">VIEW</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Status Permintaan">Status Permintaan</td><td class="py-2.5"><span class="ai-badge bg-slate-100 text-slate-600">VIEW</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Master Data Barang rounded-bl-lg">Master Data Barang</td><td class="py-2.5"><span class="ai-badge bg-slate-100 text-slate-600">VIEW</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5 rounded-br-lg"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td></tr>
                </tbody>
              </table>
            </div>
            <p class="text-[11.5px] text-slate-500 mt-4 leading-relaxed">Matriks ditentukan otomatis oleh peran dan tidak dapat diubah manual. Setiap upaya akses di luar matriks tercatat pada ledger SHA-256 dan memicu alert Zero-Trust ke CSIRT.</p>
          </div>
        </div>

        <!-- ===== PANEL 4 — RIWAYAT LOGIN & SESI AKTIF ===== -->
        <div data-tabpanel="profil" data-panel-name="sesi" style="display:none">
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="ai-card ai-card-hover p-5 lg:col-span-2">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-history text-lg text-blue-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Riwayat Login 30 Hari Terakhir</h2>
                  <p class="text-[12px] text-slate-500">Semua percobaan autentikasi tercatat forensik.</p>
                </div>
              </div>
              <div class="ai-table overflow-x-auto">
                <table class="w-full min-w-[560px]">
                  <thead><tr><th class="text-left rounded-tl-lg">Waktu</th><th class="text-left">Perangkat</th><th class="text-left">Lokasi / IP</th><th class="text-left rounded-tr-lg">Status</th></tr></thead>
                  <tbody>
                    <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Hari ini, 07:54 WIB</td><td class="py-2.5 text-slate-500">Zebra TC21 Handheld</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Wi-Fi DC-01 • 192.168.10.45</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">SUKSES</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Hari ini, 07:10 WIB</td><td class="py-2.5 text-slate-500">PC Terminal Staging A</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Hub Cakung • 10.24.10.45</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">SUKSES</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Kemarin, 21:44 WIB</td><td class="py-2.5 text-slate-500">Windows PC • Tidak dikenal</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Surabaya • 118.136.44.19</td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DIBLOKIR 2FA</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 rounded-bl-lg">2 hari lalu, 06:58 WIB</td><td class="py-2.5 text-slate-500">Zebra TC21 Handheld</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Wi-Fi DC-01 • 192.168.10.45</td><td class="py-2.5 rounded-br-lg"><span class="ai-badge bg-emerald-100 text-emerald-700">SUKSES</span></td></tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="ai-card ai-card-hover p-5">
              <h2 class="text-[15px] font-bold text-slate-800 mb-1">Kontrol Sesi</h2>
              <p class="text-[12px] text-slate-500 mb-4">Kelola durasi &amp; perangkat tepercaya.</p>
              <div class="space-y-3">
                <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Timeout Sesi Idle</label><select class="ai-input"><option>30 menit (Rekomendasi)</option><option>15 menit</option><option>60 menit</option></select></div>
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Perangkat Tepercaya 30 Hari</div><div class="text-[11.5px] text-slate-500">Lewati 2FA pada perangkat familiar.</div></div><div class="ai-switch"></div></div>
                <button class="ai-btn ai-btn-danger w-full" data-modal-open="modalLogoutAll"><i class="fas fa-sign-out-alt text-base"></i>Keluar Dari Semua Perangkat Lain</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== Modal Lihat Kode Pemulihan ===== -->
        <div id="modalKode" class="modal-overlay">
          <div class="modal-box p-6">
            <div class="flex items-center justify-between mb-1">
              <h3 class="text-[16px] font-bold text-slate-800 flex items-center gap-2"><i class="fas fa-vault text-lg text-blue-600"></i>Kode Pemulihan Darurat</h3>
              <button data-close-modal class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-500"><i class="fas fa-times text-base"></i></button>
            </div>
            <p class="text-[12.5px] text-slate-500 mb-4">8 dari 10 kode masih tersimpan aman. Simpan di tempat offline — setiap kode hanya bisa dipakai satu kali.</p>
            <div class="grid grid-cols-2 sm:grid-cols-2 gap-2.5">
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">4XK9-P2QM-7TZR<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">B8NV-QLD3-KW5M<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">TR72-MZP4-XQ8C<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">J6WD-K9TN-2FHL<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">M4QP-8XZ2-RT7B<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-400 line-through flex items-center justify-between">C93K-N7FT-VB2M<span class="ai-badge bg-slate-200 text-slate-500">TERPAKAI</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">Z7RT-4KWP-QN6M<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-400 line-through flex items-center justify-between">H2XM-9TQD-L83K<span class="ai-badge bg-slate-200 text-slate-500">TERPAKAI</span></div>
            </div>
            <div class="flex gap-2 mt-5">
              <button class="ai-btn ai-btn-secondary flex-1" data-toast="Daftar kode pemulihan diunduh terenkripsi." data-toast-type="success"><i class="fas fa-download text-base"></i>Unduh Salinan</button>
              <button class="ai-btn ai-btn-primary flex-1" data-close-modal>Selesai</button>
            </div>
          </div>
        </div>

        <!-- ===== Modal Konfirmasi Keluar Semua Perangkat ===== -->
        <div id="modalLogoutAll" class="modal-overlay">
          <div class="modal-box p-6" style="max-width:440px">
            <div class="w-12 h-12 rounded-xl bg-red-50 border border-red-100 flex items-center justify-center mb-4">
              <i class="fas fa-triangle-exclamation text-xl text-red-500"></i>
            </div>
            <h3 class="text-[16px] font-bold text-slate-800">Keluar Dari Semua Perangkat Lain?</h3>
            <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Sesi pada <span class="font-bold text-slate-700">PC Terminal Staging A</span> akan diakhiri paksa dan perangkat tersebut harus login ulang dengan 2FA. Perangkat saat ini tetap aktif.</p>
            <div class="flex gap-2 mt-5">
              <button class="ai-btn ai-btn-secondary flex-1" data-close-modal>Batal</button>
              <button class="ai-btn ai-btn-danger flex-1" id="btnConfirmLogoutAll"><i class="fas fa-sign-out-alt text-base"></i>Ya, Keluar Paksa</button>
            </div>
          </div>
        </div>
        @endif

        @if(auth()->user()->isAuditor())
        <!-- ===== Breadcrumb + status + aksi ===== -->
        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-3 mb-4">
          <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2 text-sm text-gray-500 overflow-x-auto whitespace-nowrap anim-fade-in">
              <span>Beranda</span><i class="fas fa-chevron-right text-xs"></i>
              <span>Pengaturan &amp; Akun</span><i class="fas fa-chevron-right text-xs"></i>
              <span class="text-gray-900 font-medium">Profil Saya</span>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
              <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100"><span class="ai-live-dot"></span>STATUS: TERVERIFIKASI AKTIF</span>
              <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100"><i class="fas fa-shield-alt text-sm"></i>AUDITOR</span>
            </div>
          </div>
          <div class="flex flex-wrap items-center gap-2.5 flex-none">
            <button class="ai-btn ai-btn-secondary" id="btnBatal"><i class="fas fa-undo text-base"></i>Batal Perubahan</button>
            <button class="ai-btn ai-btn-secondary" data-toast="Ekspor data akun (GDPR) disiapkan — tautan unduh dikirim ke email resmi Anda." data-toast-type="info"><i class="fas fa-download text-base"></i>Unduh Data Akun (GDPR)</button>
            <button type="submit" form="form-identitas" class="ai-btn ai-btn-primary" id="btnSimpanProfil"><i class="fas fa-save text-base"></i>Simpan Profil</button>
          </div>
        </div>

        <!-- ===== Banner hero profil ===== -->
        <div class="ai-card overflow-hidden mb-5 ai-reveal">
          <div class="relative bg-gradient-to-r from-blue-700 via-blue-800 to-slate-900 px-6 md:px-8 py-7 md:pl-44">
            <!-- Avatar -->
            <div class="absolute left-6 md:left-8 top-1/2 -translate-y-1/2">
              <div class="relative">
                <div class="w-24 h-24 rounded-2xl bg-blue-600 border-4 border-white/25 shadow-2xl shadow-blue-950/40 flex items-center justify-center">
                  <span class="text-white text-3xl font-extrabold tracking-wide">{{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 2)) }}</span>
                </div>
                <span class="absolute -bottom-1.5 -right-1.5 w-8 h-8 rounded-full bg-emerald-500 border-[3px] border-slate-900 flex items-center justify-center">
                  <i class="fas fa-check text-base text-white"></i>
                </span>
              </div>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4">
              <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-2.5">
                  <span class="ai-badge bg-slate-900/50 text-blue-100 border border-white/10 font-mono">KKT 1.7.001 // SECURE SESSION V4.8</span>
                  <h1 class="text-white text-2xl md:text-[27px] font-extrabold leading-tight">{{ auth()->user()->nama_lengkap }}</h1>
                  <span class="ai-badge bg-white/10 text-white border border-white/20 font-mono">{{ auth()->user()->nip }}</span>
                </div>
                <p class="text-blue-100 text-[13.5px] font-semibold mt-1.5">Auditor Internal &amp; Kepatuhan</p>
                <div class="flex flex-wrap items-center gap-x-5 gap-y-1.5 mt-3 text-[12px] text-blue-100/90 font-medium">
                  <span class="flex items-center gap-1.5"><i class="fas fa-envelope text-sm"></i>{{ auth()->user()->email }}</span>
                  <span class="flex items-center gap-1.5"><i class="fas fa-warehouse text-sm"></i>{{ optional(auth()->user()->selectedHub)->name ?? 'Hub Cakung DC-01' }}</span>
                  <span class="flex items-center gap-1.5"><i class="fas fa-calendar text-sm"></i>Bergabung: 10 Jun 2021 (3 Tahun Bertugas)</span>
                </div>
              </div>
              <div class="flex lg:flex-col flex-wrap items-start lg:items-end gap-2 flex-none">
                <span class="ai-badge bg-white/10 text-white border border-white/20 backdrop-blur px-3.5 py-2"><i class="fas fa-shield-alt text-sm"></i>Auditor - Read Only + Verifikasi</span>
                <span class="ai-badge bg-white/10 text-white border border-white/20 backdrop-blur px-3.5 py-2"><i class="fas fa-lock text-sm"></i>2FA Terverifikasi</span>
                <span class="ai-badge bg-white/10 text-white border border-white/20 backdrop-blur px-3.5 py-2"><i class="fas fa-fingerprint text-sm"></i>FIDO2 Enrolled</span>
              </div>
            </div>
          </div>

          <!-- Tab profil -->
          <div class="px-3 py-2.5 border-t border-slate-100 bg-white">
            <div data-tabs="profil" class="flex gap-2 overflow-x-auto">
              <button class="ai-pill ai-pill-active" data-tab="pribadi"><i class="fas fa-user text-base"></i>Informasi Pribadi &amp; Kontak</button>
              <button class="ai-pill" data-tab="keamanan"><i class="fas fa-shield-alt text-base"></i>Keamanan, Password &amp; 2FA</button>
              <button class="ai-pill" data-tab="akses"><i class="fas fa-exchange-alt text-base"></i>Hak Akses &amp; Matriks Perizinan</button>
              <button class="ai-pill" data-tab="sesi"><i class="fas fa-history text-base"></i>Riwayat Login &amp; Sesi Aktif</button>
            </div>
          </div>
        </div>

        <!-- ===== PANEL 1 — INFORMASI PRIBADI & KONTAK ===== -->
        <div data-tabpanel="profil" data-panel-name="pribadi">
          <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

            <!-- Kolom kiri -->
            <div class="xl:col-span-2 space-y-5">

              <!-- Data Identitas -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="80">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
                  <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                      <i class="fas fa-user text-lg text-blue-600"></i>
                    </div>
                    <div>
                      <h2 class="text-[16px] font-bold text-slate-800">Data Identitas Pegawai</h2>
                      <p class="text-[12.5px] text-slate-500 mt-0.5">Informasi akun operasional yang terdaftar pada sistem terpusat Astro Logistics.</p>
                    </div>
                  </div>
                  <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100 font-mono">HRIS SYNCHRONIZED</span>
                </div>

                <form id="form-identitas" method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Nama Lengkap Sesuai KTP / HR</label>
                    <div class="relative">
                      <i class="fas fa-user text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}">
                    </div>
                    @error('nama_lengkap')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                  </div>
                  <div>
                    <div class="flex items-center justify-between mb-1.5">
                      <label class="text-[12px] font-semibold text-slate-600">NIP Karyawan</label>
                      {{-- <span class="text-[10.5px] font-semibold text-slate-400 flex items-center gap-1"><i class="fas fa-lock text-base"></i>Read-only</span> --}}
                    </div>
                    <div class="relative">
                      <i class="fas fa-fingerprint text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9 font-mono bg-slate-50 text-slate-500" value="{{ auth()->user()->nip }}" readonly>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Alamat Email Resmi Perusahaan</label>
                    <div class="relative">
                      <i class="fas fa-envelope text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" name="email" value="{{ old('email', auth()->user()->email) }}">
                    </div>
                    @error('email')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Nomor Handphone / WhatsApp</label>
                    <div class="relative">
                      <i class="fas fa-phone text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                    </div>
                    @error('phone')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                  </div>
                  <div class="md:col-span-2">
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Departemen &amp; Unit Operasional</label>
                    <div class="relative">
                      <i class="fas fa-building text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9" value="Audit Internal &amp; Kepatuhan (Compliance Division)">
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Lokasi Penugasan (Hub DC)</label>
                    <div class="relative">
                      <i class="fas fa-warehouse text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <select class="ai-input pl-9 appearance-none">
                        <option>{{ optional(auth()->user()->selectedHub)->name ?? 'Hub Cakung DC-01' }}</option>
                        <option>Hub Pulogadung DC-02</option>
                        <option>Hub Bekasi DC-03</option>
                      </select>
                      <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Zona Waktu Sistem</label>
                    <div class="relative">
                      <i class="fas fa-globe text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <select class="ai-input pl-9 appearance-none">
                        <option>Asia/Jakarta (WIB UTC+07:00)</option>
                        <option>Asia/Makassar (WITA UTC+08:00)</option>
                        <option>Asia/Jayapura (WIT UTC+09:00)</option>
                      </select>
                      <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Bahasa Sistem</label>
                    <div class="relative">
                      <i class="fas fa-globe text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <select class="ai-input pl-9 appearance-none">
                        <option>Bahasa Indonesia (Standar Operasional)</option>
                        <option>English (US)</option>
                      </select>
                      <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                  </div>
                  <div>
                    <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Format Nomor Dokumen SKU</label>
                    <div class="relative">
                      <i class="fas fa-qrcode text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                      <input class="ai-input pl-9 font-mono" value="ASTRO-[WH]-[YEAR]-[SEQ]">
                    </div>
                  </div>
                </div>
              </form>
              </div>

              <!-- Kredensial & Keamanan Akun -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="140">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
                  <div class="flex items-start gap-3.5">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center flex-none">
                      <i class="fas fa-lock text-lg text-emerald-600"></i>
                    </div>
                    <div>
                      <h2 class="text-[16px] font-bold text-slate-800">Kredensial &amp; Keamanan Akun</h2>
                      <p class="text-[12.5px] text-slate-500 mt-0.5">Manajemen kata sandi tingkat tinggi, kunci fisik, dan multi-factor token.</p>
                    </div>
                  </div>
                  <span class="ai-badge bg-emerald-100 text-emerald-700 border border-emerald-200"><i class="fas fa-shield-alt text-sm"></i>POSTURE: AMAN</span>
                </div>

<form id="form-password" method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                  <!-- Pembaruan Kata Sandi -->
                  <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 md:p-5">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                      <h3 class="text-[14px] font-bold text-slate-800">Pembaruan Kata Sandi</h3>
                      <span class="text-[11.5px] text-slate-500 font-medium">Terakhir diubah 42 hari lalu</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                      <div>
                        <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kata Sandi Saat Ini</label>
                        <div class="relative">
                          <input id="pwdCurrent" name="current_password" type="password" class="ai-input pr-10 font-mono" placeholder="Kata sandi saat ini">
                          <button type="button" class="pwd-toggle absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" data-target="pwdCurrent"><i class="fas fa-eye text-base"></i></button>
                        </div>
                        @error('current_password')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                      </div>
                      <div>
                        <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kata Sandi Baru</label>
                        <div class="relative">
                          <input id="pwdNew" name="password" type="password" class="ai-input pr-10" placeholder="Minimal 12 karakter">
                          <button type="button" class="pwd-toggle absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" data-target="pwdNew"><i class="fas fa-eye text-base"></i></button>
                        </div>
                        @error('password')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                      </div>
                      <div>
                        <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Konfirmasi Sandi Baru</label>
                        <div class="relative">
                          <input id="pwdConfirm" name="password_confirmation" type="password" class="ai-input pr-10" placeholder="Ulangi kata sandi">
                          <button type="button" class="pwd-toggle absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600" data-target="pwdConfirm"><i class="fas fa-eye text-base"></i></button>
                        </div>
                        @error('password_confirmation')<p class="text-[10.5px] text-red-500 mt-1">{{ $message }}</p>@enderror
                      </div>
                    </div>
                    <div class="flex flex-wrap items-center justify-between gap-2 mt-5">
                      <span class="text-[12px] font-semibold text-slate-600">Tingkat Kekuatan Sandi:</span>
                      <span id="strengthLabel" class="text-[12px] font-bold text-emerald-600 flex items-center gap-1.5"><i class="fas fa-shield-alt text-base"></i>Sangat Kuat (Entropi 96-bit)</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mt-2">
                      <div id="bar1" class="h-1.5 rounded-full bg-emerald-600 transition-colors duration-300"></div>
                      <div id="bar2" class="h-1.5 rounded-full bg-emerald-600 transition-colors duration-300"></div>
                      <div id="bar3" class="h-1.5 rounded-full bg-emerald-600 transition-colors duration-300"></div>
                    </div>
                    <p class="text-[11.5px] text-slate-500 mt-2.5 leading-relaxed">Wajib mengombinasikan huruf kapital, angka, simbol unik, dan tanpa pengulangan kata kamus.</p>
                    <button type="submit" class="ai-btn ai-btn-primary w-full mt-4"><i class="fas fa-save text-base"></i>Simpan Kata Sandi</button>
                  </div>

                  <!-- TOTP + FIDO2 -->
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                      <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-mobile-alt text-lg text-slate-700"></i></div>
                        <div class="flex-1 min-w-0">
                          <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-[13.5px] font-bold text-slate-800">Authenticator App (TOTP)</span>
                            <span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span>
                          </div>
                          <p class="text-[12px] text-slate-500 mt-1 leading-relaxed">Terhubung ke Google Authenticator / 1Password. Menghasilkan kode 6 digit berkala.</p>
                        </div>
                      </div>
                      <div class="flex items-center justify-between gap-2 mt-4 pt-3 border-t border-slate-200/70">
                        <span class="text-[11.5px] text-slate-500 font-mono">ID: TOTP-ASTRO-8820</span>
                        <button class="text-[12px] font-bold text-blue-600 hover:text-blue-700" data-toast="Panduan konfigurasi ulang 2FA dikirim ke email resmi Anda." data-toast-type="info">Konfigurasi Ulang 2FA</button>
                      </div>
                    </div>
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                      <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-usb text-lg text-slate-700"></i></div>
                        <div class="flex-1 min-w-0">
                          <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-[13.5px] font-bold text-slate-800">OTP Perangkat Audit</span>
                            <span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span>
                          </div>
                          <p class="text-[12px] text-slate-500 mt-1 leading-relaxed">OTP 6 digit untuk ekspor laporan dan finalisasi temuan audit.</p>
                        </div>
                      </div>
                      <div class="flex items-center justify-between gap-2 mt-4 pt-3 border-t border-slate-200/70">
                        <span class="text-[11.5px] text-slate-500 font-mono">SN: TOTP-ASTRO-8820</span>
                        <button class="text-[12px] font-bold text-blue-600 hover:text-blue-700" id="btnUjiKunci">Uji Sentuh Kunci</button>
                      </div>
                    </div>
                  </div>

                  <!-- Recovery codes -->
                  <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col md:flex-row md:items-center gap-4">
                    <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-vault text-lg text-slate-700"></i></div>
                    <div class="flex-1 min-w-0">
                      <div class="text-[13.5px] font-bold text-slate-800">Kunci Pemulihan Darurat (Emergency Recovery Codes)</div>
                      <p class="text-[12px] text-slate-500 mt-0.5">8 dari 10 kode pemulihan offline masih tersimpan aman.</p>
                    </div>
                    <div class="flex flex-wrap gap-2 flex-none">
                      <button class="ai-btn ai-btn-secondary" data-modal-open="modalKode"><i class="fas fa-eye text-base"></i>Lihat Kode</button>
                      <button class="ai-btn ai-btn-soft" data-toast="10 kode pemulihan baru digenerate — kode lama otomatis tidak berlaku." data-toast-type="warn"><i class="fas fa-undo text-base"></i>Generate Ulang</button>
                    </div>
                  </div>
                </div>
              </form>
              </div>
            </div>

            <!-- Kolom kanan -->
            <div class="space-y-5">

              <!-- Matriks Hak Akses (RBAC) -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="100">
                <div class="flex items-start gap-3 mb-4">
                  <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
                  <div>
                    <h3 class="text-[15px] font-bold text-slate-800">Matriks Hak Akses (RBAC)</h3>
                    <div class="text-[11px] font-extrabold text-blue-600 mt-0.5 tracking-wide">LEVEL 5: AUDITOR</div>
                  </div>
                </div>
                <p class="text-[12px] text-slate-500 leading-relaxed mb-4">Akses baca penuh untuk pemeriksaan, verifikasi temuan, dan eskalasi kepatuhan.</p>
                <div class="space-y-2.5">
                                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Akses Audit Log &amp; Temuan</span>
                <span class="ai-badge bg-emerald-100 text-emerald-700 font-mono">FULL</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Verifikasi Stok Opname</span>
                <span class="ai-badge bg-indigo-100 text-indigo-700 font-mono">VERIFY</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Data Barang &amp; Mutasi</span>
                <span class="ai-badge bg-slate-100 text-slate-600 font-mono">VIEW</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-2.5">
                <i class="fas fa-check-circle text-lg text-emerald-500 flex-none"></i>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Laporan &amp; Analitik</span>
                <span class="ai-badge bg-slate-100 text-slate-600 font-mono">VIEW</span>
              </div>
                </div>
                <div class="mt-4 bg-blue-50 border border-blue-100 rounded-xl py-2.5 text-center text-[12px] font-bold text-blue-700">Kebijakan Zero-Trust Enforcement: AKTIF</div>
              </div>

              <!-- Sesi Login Aktif -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="150">
                <div class="flex items-start gap-3 mb-4">
                  <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none"><i class="fas fa-desktop text-lg text-blue-600"></i></div>
                  <div>
                    <h3 class="text-[15px] font-bold text-slate-800">Sesi Login Aktif</h3>
                    <p class="text-[12px] text-slate-500 mt-0.5">2 Perangkat terhubung saat ini</p>
                  </div>
                </div>
                <div class="space-y-2.5">
                                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5">
                <div class="flex items-center justify-between gap-2">
                  <div class="flex items-center gap-2.5 min-w-0">
                    <i class="fas fa-laptop text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13px] font-bold text-slate-800 truncate">MacBook Pro M2 • Chrome 122</span>
                  </div>
                  <span class="ai-live-dot flex-none"></span>
                </div>
                <div class="text-[11.5px] text-slate-500 mt-1 ml-7">IP 10.24.30.10 • Ruang Audit DC-01</div>
              </div>
                <div class="text-[10.5px] font-extrabold text-emerald-600 mt-1.5 ml-7 tracking-wide">PERANGKAT INI (AKTIF SEKARANG)</div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5">
                <div class="flex items-center justify-between gap-2">
                  <div class="flex items-center gap-2.5 min-w-0">
                    <i class="fas fa-desktop text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13px] font-bold text-slate-800 truncate">ThinkPad X1 Carbon • Audit Suite</span>
                  </div>
                  <span class="text-[11px] text-slate-400 font-medium flex-none">2 jam lalu</span>
                </div>
                <div class="text-[11.5px] text-slate-500 mt-1 ml-7">IP 10.24.30.7 • Zona Server &amp; Ledger</div>
              </div>
                </div>
                <button class="ai-btn ai-btn-danger w-full mt-4" data-modal-open="modalLogoutAll"><i class="fas fa-sign-out-alt text-base"></i>Keluar Dari Semua Perangkat Lain</button>
              </div>

              <!-- Aktivitas Operasional Bulan Ini -->
              <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="200">
                <h3 class="text-[15px] font-bold text-slate-800">Aktivitas Operasional Bulan Ini</h3>
                <p class="text-[12px] text-slate-500 mt-0.5 mb-4">Performa akuntabilitas &amp; kepatuhan audit internal.</p>
                <div class="space-y-2.5">
                                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-search text-lg text-blue-600"></i></div>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Audit Sesi Dijalankan</span>
                <span class="text-[18px] font-extrabold text-slate-800" data-count="64">0</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-clipboard-check text-lg text-blue-600"></i></div>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Temuan Diverifikasi</span>
                <span class="text-[18px] font-extrabold text-slate-800" data-count="18">0</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-balance-scale text-lg text-blue-600"></i></div>
                <span class="text-[12.5px] font-semibold text-slate-700 flex-1">Pelanggaran SOP / SLA</span>
                <span class="text-[18px] font-extrabold text-amber-600" data-count="3">0</span>
              </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 3 kartu bawah -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
            <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="80">
              <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center mb-4"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
              <h3 class="text-[15px] font-bold text-slate-800">Privasi &amp; Kepatuhan ISO 27001</h3>
              <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Seluruh riwayat klik, approval, dan mutasi barang terenkripsi menggunakan SHA-256 ledger dan dipantau oleh dewan kepatuhan audit internal Astro.</p>
              <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Dokumen regulasi keamanan ISO 27001 dibuka." data-toast-type="info">Baca Regulasi Keamanan <i class="fas fa-arrow-right text-base"></i></button>
            </div>
            <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="140">
              <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center mb-4"><i class="fas fa-rotate text-lg text-blue-600"></i></div>
              <h3 class="text-[15px] font-bold text-slate-800">Siklus Sandi 90 Hari</h3>
              <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Sesuai kebijakan keamanan gudang terpadu, akun diwajibkan melakukan rotasi kredensial setiap 90 hari kalender. Tersisa 48 hari pada siklus ini.</p>
              <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Rotasi kata sandi dijadwalkan — pengingat dikirim ke kalender kerja Anda." data-toast-type="success">Jadwalkan Rotasi Sandi <i class="fas fa-arrow-right text-base"></i></button>
            </div>
            <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="200">
              <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mb-4"><i class="fas fa-headset text-lg text-emerald-600"></i></div>
              <h3 class="text-[15px] font-bold text-slate-800">CSIRT Astro Incident Response</h3>
              <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Jika Anda mendeteksi anomali login, akses token mencurigakan, atau kehilangan token keamanan fisik, segera eskalasikan ke Pusat Tanggap Darurat IT.</p>
              <button class="mt-4 text-[13px] font-bold text-red-600 hover:text-red-700 flex items-center gap-1.5" data-toast="Tiket darurat CSIRT dibuat — tim tanggap menghubungi Anda < 5 menit." data-toast-type="danger">Buka Tiket Darurat CSIRT <i class="fas fa-asterisk text-base"></i></button>
            </div>
          </div>
        </div>

        <!-- ===== PANEL 2 — KEAMANAN, PASSWORD & 2FA ===== -->
        <div data-tabpanel="profil" data-panel-name="keamanan" style="display:none">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <div class="ai-card ai-card-hover p-5">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center"><i class="fas fa-key text-lg text-emerald-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Riwayat Perubahan Kata Sandi</h2>
                  <p class="text-[12px] text-slate-500">Rotasi wajib setiap 90 hari — tersisa 48 hari.</p>
                </div>
              </div>
              <div class="ai-table">
                <table class="w-full">
                  <thead><tr><th class="text-left rounded-tl-lg">Waktu</th><th class="text-left">Perangkat</th><th class="text-left rounded-tr-lg">Metode</th></tr></thead>
                  <tbody>
                                    <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">30 hari lalu</td><td class="py-2.5 text-slate-500">MacBook Pro M2</td><td class="py-2.5"><span class="ai-badge bg-blue-50 text-blue-700">Manual</span></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">95 hari lalu</td><td class="py-2.5 text-slate-500">ThinkPad X1 Carbon</td><td class="py-2.5"><span class="ai-badge bg-blue-50 text-blue-700">Manual</span></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">190 hari lalu</td><td class="py-2.5 text-slate-500">MacBook Pro M2</td><td class="py-2.5"><span class="ai-badge bg-slate-100 text-slate-600">Paksa Sistem</span></td></tr>
                  </tbody>
                </table>
              </div>
              <button class="ai-btn ai-btn-soft w-full mt-4" data-toast="Pengingat rotasi sandi dipercepat ke hari ini." data-toast-type="warn"><i class="fas fa-rotate text-base"></i>Percepat Rotasi Sekarang</button>
            </div>
            <div class="ai-card ai-card-hover p-5">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-fingerprint text-lg text-blue-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Kebijakan Multi-Factor</h2>
                  <p class="text-[12px] text-slate-500">Lapisan verifikasi untuk aksi berisiko tinggi.</p>
                </div>
              </div>
              <div class="space-y-3">
                            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">TOTP Wajib untuk Ekspor Laporan Audit</div><div class="text-[11.5px] text-slate-500">Setiap unduh ledger memerlukan verifikasi.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Konfirmasi Ulang untuk Finalisasi Temuan</div><div class="text-[11.5px] text-slate-500">Temuan harus diverifikasi dua tahap.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Email Alert Saat Login Perangkat Baru</div><div class="text-[11.5px] text-slate-500">Notifikasi instan ke email resmi.</div></div><div class="ai-switch ai-on"></div></div>
                <button class="ai-btn ai-btn-primary w-full" data-toast="Kebijakan multi-factor tersimpan."><i class="fas fa-save text-base"></i>Simpan Kebijakan</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== PANEL 3 — HAK AKSES & MATRIKS PERIZINAN ===== -->
        <div data-tabpanel="profil" data-panel-name="akses" style="display:none">
          <div class="ai-card ai-card-hover p-5">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Matriks Perizinan Detail per Modul</h2>
                  <p class="text-[12px] text-slate-500">Role: Auditor • LEVEL 5: AUDITOR</p>
                </div>
              </div>
              <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100">Zero-Trust: AKTIF</span>
            </div>
            <div class="ai-table overflow-x-auto">
              <table class="w-full min-w-[640px]">
                <thead><tr><th class="text-left rounded-tl-lg">Modul Sistem</th><th class="text-left">Lihat</th><th class="text-left">Buat / Edit</th><th class="text-left">Hapus</th><th class="text-left rounded-tr-lg">Otorisasi</th></tr></thead>
                <tbody>
                  <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Log Audit &amp; Temuan">Log Audit &amp; Temuan</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-indigo-100 text-indigo-700">VERIFY</span></td><td class="py-2.5"><span class="ai-badge bg-indigo-100 text-indigo-700">VERIFY</span></td><td class="py-2.5"><span class="ai-badge bg-amber-100 text-amber-700">ESCALATE</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Stok Opname &amp; Deviasi">Stok Opname &amp; Deviasi</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">FULL</span></td><td class="py-2.5"><span class="ai-badge bg-indigo-100 text-indigo-700">VERIFY</span></td><td class="py-2.5"><span class="ai-badge bg-indigo-100 text-indigo-700">VERIFY</span></td><td class="py-2.5"><span class="ai-badge bg-amber-100 text-amber-700">ESCALATE</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Data Barang &amp; Mutasi">Data Barang &amp; Mutasi</td><td class="py-2.5"><span class="ai-badge bg-slate-100 text-slate-600">VIEW</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Hak Akses &amp; Otorisasi">Hak Akses &amp; Otorisasi</td><td class="py-2.5"><span class="ai-badge bg-slate-100 text-slate-600">VIEW</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 Laporan &amp; Analitik rounded-bl-lg">Laporan &amp; Analitik</td><td class="py-2.5"><span class="ai-badge bg-slate-100 text-slate-600">VIEW</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td><td class="py-2.5 rounded-br-lg"><span class="ai-badge bg-red-100 text-red-600">DENIED</span></td></tr>
                </tbody>
              </table>
            </div>
            <p class="text-[11.5px] text-slate-500 mt-4 leading-relaxed">Matriks ditentukan otomatis oleh peran dan tidak dapat diubah manual. Setiap upaya akses di luar matriks tercatat pada ledger SHA-256 dan memicu alert Zero-Trust ke CSIRT.</p>
          </div>
        </div>

        <!-- ===== PANEL 4 — RIWAYAT LOGIN & SESI AKTIF ===== -->
        <div data-tabpanel="profil" data-panel-name="sesi" style="display:none">
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="ai-card ai-card-hover p-5 lg:col-span-2">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-history text-lg text-blue-600"></i></div>
                <div>
                  <h2 class="text-[15px] font-bold text-slate-800">Riwayat Login 30 Hari Terakhir</h2>
                  <p class="text-[12px] text-slate-500">Semua percobaan autentikasi tercatat forensik.</p>
                </div>
              </div>
              <div class="ai-table overflow-x-auto">
                <table class="w-full min-w-[560px]">
                  <thead><tr><th class="text-left rounded-tl-lg">Waktu</th><th class="text-left">Perangkat</th><th class="text-left">Lokasi / IP</th><th class="text-left rounded-tr-lg">Status</th></tr></thead>
                  <tbody>
                    <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Hari ini, 07:52 WIB</td><td class="py-2.5 text-slate-500">MacBook Pro M2 • Chrome 122</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Jakarta • 10.24.30.10</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">SUKSES</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Hari ini, 07:10 WIB</td><td class="py-2.5 text-slate-500">ThinkPad X1 Carbon</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Hub Cakung • 10.24.30.7</td><td class="py-2.5"><span class="ai-badge bg-emerald-100 text-emerald-700">SUKSES</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Kemarin, 21:44 WIB</td><td class="py-2.5 text-slate-500">Windows PC • Tidak dikenal</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Surabaya • 118.136.44.19</td><td class="py-2.5"><span class="ai-badge bg-red-100 text-red-600">DIBLOKIR 2FA</span></td></tr>
<tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700 rounded-bl-lg">2 hari lalu, 06:58 WIB</td><td class="py-2.5 text-slate-500">MacBook Pro M2 • Chrome 122</td><td class="py-2.5 text-slate-500 font-mono text-[11.5px]">Jakarta • 10.24.30.10</td><td class="py-2.5 rounded-br-lg"><span class="ai-badge bg-emerald-100 text-emerald-700">SUKSES</span></td></tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="ai-card ai-card-hover p-5">
              <h2 class="text-[15px] font-bold text-slate-800 mb-1">Kontrol Sesi</h2>
              <p class="text-[12px] text-slate-500 mb-4">Kelola durasi &amp; perangkat tepercaya.</p>
              <div class="space-y-3">
                <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Timeout Sesi Idle</label><select class="ai-input"><option>30 menit (Rekomendasi)</option><option>15 menit</option><option>60 menit</option></select></div>
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Perangkat Tepercaya 30 Hari</div><div class="text-[11.5px] text-slate-500">Lewati 2FA pada perangkat familiar.</div></div><div class="ai-switch"></div></div>
                <button class="ai-btn ai-btn-danger w-full" data-modal-open="modalLogoutAll"><i class="fas fa-sign-out-alt text-base"></i>Keluar Dari Semua Perangkat Lain</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== Modal Lihat Kode Pemulihan ===== -->
        <div id="modalKode" class="modal-overlay">
          <div class="modal-box p-6">
            <div class="flex items-center justify-between mb-1">
              <h3 class="text-[16px] font-bold text-slate-800 flex items-center gap-2"><i class="fas fa-vault text-lg text-blue-600"></i>Kode Pemulihan Darurat</h3>
              <button data-close-modal class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-500"><i class="fas fa-times text-base"></i></button>
            </div>
            <p class="text-[12.5px] text-slate-500 mb-4">8 dari 10 kode masih tersimpan aman. Simpan di tempat offline — setiap kode hanya bisa dipakai satu kali.</p>
            <div class="grid grid-cols-2 sm:grid-cols-2 gap-2.5">
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">4XK9-P2QM-7TZR<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">B8NV-QLD3-KW5M<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">TR72-MZP4-XQ8C<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">J6WD-K9TN-2FHL<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">M4QP-8XZ2-RT7B<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-400 line-through flex items-center justify-between">C93K-N7FT-VB2M<span class="ai-badge bg-slate-200 text-slate-500">TERPAKAI</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-700 flex items-center justify-between">Z7RT-4KWP-QN6M<span class="ai-badge bg-emerald-100 text-emerald-700">AKTIF</span></div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 font-mono text-[13px] font-bold text-slate-400 line-through flex items-center justify-between">H2XM-9TQD-L83K<span class="ai-badge bg-slate-200 text-slate-500">TERPAKAI</span></div>
            </div>
            <div class="flex gap-2 mt-5">
              <button class="ai-btn ai-btn-secondary flex-1" data-toast="Daftar kode pemulihan diunduh terenkripsi." data-toast-type="success"><i class="fas fa-download text-base"></i>Unduh Salinan</button>
              <button class="ai-btn ai-btn-primary flex-1" data-close-modal>Selesai</button>
            </div>
          </div>
        </div>

        <!-- ===== Modal Konfirmasi Keluar Semua Perangkat ===== -->
        <div id="modalLogoutAll" class="modal-overlay">
          <div class="modal-box p-6" style="max-width:440px">
            <div class="w-12 h-12 rounded-xl bg-red-50 border border-red-100 flex items-center justify-center mb-4">
              <i class="fas fa-triangle-exclamation text-xl text-red-500"></i>
            </div>
            <h3 class="text-[16px] font-bold text-slate-800">Keluar Dari Semua Perangkat Lain?</h3>
            <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Sesi pada <span class="font-bold text-slate-700">ThinkPad X1 Carbon • Audit Suite</span> akan diakhiri paksa dan perangkat tersebut harus login ulang dengan 2FA. Perangkat saat ini tetap aktif.</p>
            <div class="flex gap-2 mt-5">
              <button class="ai-btn ai-btn-secondary flex-1" data-close-modal>Batal</button>
              <button class="ai-btn ai-btn-danger flex-1" id="btnConfirmLogoutAll"><i class="fas fa-sign-out-alt text-base"></i>Ya, Keluar Paksa</button>
            </div>
          </div>
        </div>
        @endif

    </main>
</div>

<script>
/* ============================================================
   Shared interaction layer (toast + modal)
   ============================================================ */
(function () {
    'use strict';

    function toast(msg, type) {
        var c = document.getElementById('toast-container');
        if (!c) { c = document.createElement('div'); c.id = 'toast-container'; document.body.appendChild(c); }
        var t = document.createElement('div');
        t.className = 'toast ' + (type || '');
        t.textContent = msg;
        c.appendChild(t);
        setTimeout(function () { t.style.opacity = '0'; t.style.transition = 'opacity .3s'; setTimeout(function () { t.remove(); }, 300); }, 3200);
    }
    window.toast = toast;

    window.aiToast = function (msg, type) {
        var map = { success: 'success', danger: 'error', warn: 'warn', info: '' };
        toast(msg, map[type] || '');
    };

    window.openModal = function (id) {
        var m = document.getElementById(id);
        if (m) m.classList.add('open');
    };
    window.closeModal = function (id) {
        var m = document.getElementById(id);
        if (m) m.classList.remove('open');
    };
    function initModals() {
        document.querySelectorAll('.modal-overlay').forEach(function (m) {
            m.addEventListener('click', function (e) { if (e.target === m) m.classList.remove('open'); });
        });
        document.querySelectorAll('[data-close-modal], [data-modal-close]').forEach(function (b) {
            b.addEventListener('click', function () {
                var m = b.closest('.modal-overlay'); if (m) m.classList.remove('open');
            });
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') document.querySelectorAll('.modal-overlay.open').forEach(function (m) { m.classList.remove('open'); });
        });
    }
    document.addEventListener('DOMContentLoaded', initModals);
})();
</script>

<script>
/* ============================================================
   Profil (semua role) — interaksi layout profil ai-*
   ============================================================ */
(function () {
    if (!document.querySelector('[data-tabs="profil"]')) return;

    /* ai switches */
    document.querySelectorAll('.ai-switch').forEach(function (sw) {
      if (sw.__aiSw) return; sw.__aiSw = true;
      sw.addEventListener('click', function () {
        sw.classList.toggle('ai-on');
        sw.dispatchEvent(new CustomEvent('ai:switch', { detail: { on: sw.classList.contains('ai-on') }, bubbles: true }));
      });
    });

    /* ai tabs (pills) */
    document.querySelectorAll('[data-tabs]').forEach(function (group) {
      var pills = group.querySelectorAll('[data-tab]');
      pills.forEach(function (pill) {
        if (pill.__aiTab) return; pill.__aiTab = true;
        pill.addEventListener('click', function () {
          pills.forEach(function (p) { p.classList.remove('ai-pill-active'); });
          pill.classList.add('ai-pill-active');
          var name = pill.getAttribute('data-tab');
          document.querySelectorAll('[data-tabpanel="' + group.getAttribute('data-tabs') + '"]').forEach(function (panel) {
            var match = panel.getAttribute('data-panel-name') === name;
            panel.style.display = match ? '' : 'none';
            if (match) { panel.classList.remove('ai-revealed'); void panel.offsetWidth; panel.classList.add('ai-revealed'); }
          });
        });
      });
    });

    /* reveal */
    document.querySelectorAll('.ai-reveal').forEach(function (e) {
      var d = parseInt(e.getAttribute('data-delay') || '0', 10);
      setTimeout(function () { e.classList.add('ai-revealed'); }, d);
    });

    /* data-toast */
    document.querySelectorAll('[data-toast]').forEach(function (b) {
      if (b.__aiT) return; b.__aiT = true;
      b.addEventListener('click', function () {
        window.aiToast(b.getAttribute('data-toast'), b.getAttribute('data-toast-type') || 'success');
      });
    });

    /* data-modal */
    document.querySelectorAll('[data-modal-open]').forEach(function (b) {
      b.addEventListener('click', function () { window.openModal(b.getAttribute('data-modal-open')); });
    });

    /* ripple */
    document.querySelectorAll('.ai-btn').forEach(function (btn) {
      if (btn.__aiR) return; btn.__aiR = true;
      btn.addEventListener('click', function (e) {
        var r = btn.getBoundingClientRect(); var d = Math.max(r.width, r.height);
        var s = document.createElement('span'); s.className = 'ai-ripple';
        s.style.width = s.style.height = d + 'px';
        s.style.left = (e.clientX - r.left - d / 2) + 'px'; s.style.top = (e.clientY - r.top - d / 2) + 'px';
        btn.appendChild(s); setTimeout(function () { s.remove(); }, 650);
      });
    });

    /* count-up */
    document.querySelectorAll('[data-count]').forEach(function (el) {
      var target = parseInt(el.getAttribute('data-count') || '0', 10);
      var start = null;
      function step(ts) {
        if (!start) start = ts;
        var p = Math.min((ts - start) / 1200, 1);
        el.textContent = Math.floor(target * (1 - Math.pow(1 - p, 3)));
        if (p < 1) requestAnimationFrame(step);
      }
      requestAnimationFrame(step);
    });

    /* Toggle show/hide password */
    document.querySelectorAll('.pwd-toggle').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var input = document.getElementById(btn.getAttribute('data-target'));
        var showing = input.type === 'text';
        input.type = showing ? 'password' : 'text';
        btn.innerHTML = '<i class="fas ' + (showing ? 'fa-eye' : 'fa-eye-slash') + '"></i>';
      });
    });

    /* Strength meter live */
    var bars = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3')];
    var label = document.getElementById('strengthLabel');
    var pwdNew = document.getElementById('pwdNew');
    function setMeter(score, text, color, textColor, icon) {
      bars.forEach(function (b, i) {
        b.className = 'h-1.5 rounded-full transition-colors duration-300 ' + (i < score ? color : 'bg-slate-200');
      });
      label.className = 'text-[12px] font-bold flex items-center gap-1.5 ' + textColor;
      label.innerHTML = '<i class="fas ' + icon + '"></i>' + text;
    }
    function evaluate() {
      var v = pwdNew.value || '';
      var score = 0;
      if (v.length >= 8) score++;
      if (v.length >= 12 && /[A-Z]/.test(v) && /[a-z]/.test(v) && /[0-9]/.test(v) && /[^A-Za-z0-9]/.test(v)) score = 2;
      if (v.length >= 15 && /[A-Z]/.test(v) && /[a-z]/.test(v) && /[0-9]/.test(v) && /[^A-Za-z0-9]/.test(v) && !/(.)\1{2,}/.test(v)) score = 3;
      if (!v) { setMeter(0, 'Masukkan kata sandi baru', '', 'text-slate-400', 'fa-shield-alt'); return; }
      if (score <= 1) setMeter(1, 'Lemah (Entropi < 40-bit)', 'bg-red-500', 'text-red-600', 'fa-triangle-exclamation');
      else if (score === 2) setMeter(2, 'Cukup Kuat (Entropi ~64-bit)', 'bg-amber-500', 'text-amber-600', 'fa-shield-alt');
      else setMeter(3, 'Sangat Kuat (Entropi 96-bit)', 'bg-emerald-600', 'text-emerald-600', 'fa-shield-alt');
    }
    if (pwdNew) { pwdNew.addEventListener('input', evaluate); evaluate(); }

    /* Batal perubahan */
    var btnBatal = document.getElementById('btnBatal');
    if (btnBatal) btnBatal.addEventListener('click', function () {
      window.aiToast('Perubahan dibatalkan — data dikembalikan dari sinkronisasi HRIS.', 'warn');
    });

    /* Uji sentuh kunci */
    var btnUji = document.getElementById('btnUjiKunci');
    if (btnUji) btnUji.addEventListener('click', function () {
      window.aiToast('Kunci keamanan terverifikasi (FIDO2 OK).', 'success');
    });

    /* Konfirmasi logout semua perangkat */
    var btnConfirm = document.getElementById('btnConfirmLogoutAll');
    if (btnConfirm) btnConfirm.addEventListener('click', function () {
      window.closeModal('modalLogoutAll');
      window.aiToast('Semua perangkat lain telah dikeluarkan — 1 sesi diakhiri paksa.', 'success');
    });
})();
</script>


@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () { window.toast({!! json_encode(session('success')) !!}, 'success'); }, 300);
    });
</script>
@endif
@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            var errs = {!! json_encode($errors->all()) !!};
            errs.forEach(function (e) { window.toast(e, 'error'); });
        }, 300);
    });
</script>
@endif

</body>
</html>
