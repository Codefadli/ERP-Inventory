<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Astro Inventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ============================================================
           Astro Inventory — Shared Design System (pengaturan)
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
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes scaleIn { from { transform: scale(.8); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: .7; } }
        @keyframes glow { 0%, 100% { box-shadow: 0 0 5px rgba(239,68,68,.5); } 50% { box-shadow: 0 0 20px rgba(239,68,68,.8); } }
        @keyframes progressFill { from { width: 0; } }
        @keyframes toastIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: none; } }
        @keyframes modalIn { from { opacity: 0; transform: translateY(12px) scale(.98); } to { opacity: 1; transform: none; } }
        @keyframes rise { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes ai-fade-up { to { opacity: 1; transform: translateY(0); } }
        @keyframes ai-ripple { to { transform: scale(2.6); opacity: 0; } }
        @keyframes ai-pulse { 0% { transform: scale(.5); opacity: 1; } 100% { transform: scale(1.6); opacity: 0; } }

        .anim-fade-up { animation: fadeUp .6s cubic-bezier(.22,1,.36,1) forwards; }
        .anim-fade-in { animation: fadeIn .5s ease-out; }
        .anim-slide-in { animation: slideIn .5s cubic-bezier(.22,1,.36,1); }
        .animate-fade-in { animation: fadeIn .6s ease-out; }
        .animate-fade-in-up { animation: fadeInUp .5s ease-out; }
        .animate-slide-down { animation: slideDown .4s ease-out; }
        .animate-scale-in { animation: scaleIn .4s ease-out; }
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
        .badge-pulse { animation: pulse 2s cubic-bezier(.4,0,.6,1) infinite; }
        .progress-bar-fill { animation: progressFill 1.5s ease-out forwards; }

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
           Kepala Gudang — tab pengaturan
           ============================================================ */
        .tab-btn { transition: all .15s ease; }
        .tab-btn.active { background: #2563eb; color: #fff; }

        /* ============================================================
           HR — toggle, tab item, card, radio, device
           ============================================================ */
        .toggle-switch { position: relative; display: inline-block; width: 52px; height: 28px; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #CBD5E1; transition: .3s; border-radius: 28px; }
        .toggle-slider:before { position: absolute; content: ""; height: 20px; width: 20px; left: 4px; bottom: 4px; background-color: white; transition: .3s; border-radius: 50%; box-shadow: 0 2px 4px rgba(0,0,0,.2); }
        input:checked + .toggle-slider { background-color: #2563EB; }
        input:checked + .toggle-slider:before { transform: translateX(24px); }
        .toggle-slider.green { background-color: #10B981; }
        .tab-item { transition: all .3s ease; position: relative; }
        .tab-item:hover { background-color: #EFF6FF; transform: translateY(-2px); }
        .tab-item.active { background-color: #2563EB; color: white; }
        .tab-item.active::after { content: ''; position: absolute; bottom: -2px; left: 0; right: 0; height: 3px; background: #2563EB; }
        .settings-card { transition: all .3s cubic-bezier(.4,0,.2,1); }
        .settings-card:hover { transform: translateY(-2px); box-shadow: 0 12px 24px -5px rgba(0,0,0,.1); }
        .btn-primary { transition: all .3s ease; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 16px -3px rgba(37,99,235,.4); }
        .btn-primary:active { transform: translateY(0); }
        .radio-custom { transition: all .2s ease; }
        .radio-custom:hover { background-color: #F3F4F6; }
        .radio-custom.selected { background-color: #EFF6FF; border-color: #2563EB; }
        .device-card { transition: all .2s ease; }
        .device-card:hover { background-color: #F9FAFB; transform: translateX(5px); }

        /* ============================================================
           Pegawai — soft button, setting tab, reveal, grid
           ============================================================ */
        .soft-button { transition: transform .16s ease, box-shadow .16s ease; }
        .soft-button:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(15,23,42,.08); }
        .setting-tab { transition: all .15s ease; }
        .setting-tab.active { background: #0b49d8; color: white; }
        .reveal { animation: rise .35s ease both; }
        .row-in { animation: rise .25s ease both; }
        input[type=range] { accent-color: #0b49d8; }
        @media (min-width: 768px) {
            .metrics-grid { grid-template-columns: repeat(4, minmax(0, 1fr)) !important; }
            #settings-panel { grid-template-columns: repeat(2, minmax(0, 1fr)); }
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
        <!-- ===== Breadcrumb + versi sistem ===== -->
    <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
      <div class="flex items-center gap-2 text-sm text-gray-500 mb-4 overflow-x-auto whitespace-nowrap anim-fade-in">
        <span>Beranda</span><i class="fas fa-chevron-right text-xs"></i>
        <span>Pengaturan &amp; Akun</span><i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-900 font-medium">Pengaturan</span>
    </div>
      <div class="ai-badge bg-white border border-slate-200 text-slate-500 shadow-sm">
        <span class="ai-live-dot"></span>
        <span class="text-emerald-600">SISTEM OPTIMAL</span>
        <span class="text-slate-300">•</span>
        <span>VERSI 4.2.0-LTS</span>
        <span class="font-mono font-semibold text-slate-400">SHA:8f92af</span>
      </div>
    </div>

    <!-- ===== Header card ===== -->
    <div class="ai-card ai-card-hover p-5 md:p-6 mb-5 ai-reveal flex flex-col lg:flex-row lg:items-center gap-5">
      <div class="flex items-start gap-4 flex-1">
        <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
          <i class="fas fa-sliders-h text-xl text-blue-600"></i>
        </div>
        <div>
          <h1 class="text-[22px] md:text-2xl font-extrabold text-slate-800 leading-tight">Pengaturan &amp; Konfigurasi Sistem</h1>
          <p class="text-[13px] text-slate-500 mt-1 max-w-xl leading-relaxed">Kelola parameter operasional inventaris, kebijakan keamanan, integrasi barcode/printer thermal, koneksi ERP, serta preferensi umum Hub Cakung DC-01.</p>
        </div>
      </div>
      <div class="flex flex-wrap items-center gap-2.5 flex-none">
        <button class="ai-btn ai-btn-secondary" id="btnReset"><i class="fas fa-undo text-base "></i>Kembalikan Default</button>
        <button class="ai-btn ai-btn-secondary" data-modal-open="modalLog"><i class="fas fa-history text-base "></i>Lihat Log Perubahan</button>
        <button class="ai-btn ai-btn-primary" id="btnSimpan"><i class="fas fa-check-circle text-base "></i>Simpan Perubahan</button>
      </div>
    </div>

    <!-- ===== Tab nomor ===== -->
    <div data-tabs="pengaturan" class="flex gap-2 overflow-x-auto pb-1 mb-5 ai-reveal" data-delay="80">
      <button class="ai-pill ai-pill-active" data-tab="umum"><i class="fas fa-sliders-h text-base "></i>1. Umum &amp; Profil Hub</button>
      <button class="ai-pill" data-tab="stok"><i class="fas fa-clipboard-list text-base "></i>2. Aturan Inventaris &amp; Stok</button>
      <button class="ai-pill" data-tab="printer"><i class="fas fa-print text-base "></i>3. Perangkat &amp; Printer Barcode</button>
      <button class="ai-pill" data-tab="erp"><i class="fas fa-exchange-alt text-base "></i>4. Integrasi ERP &amp; API</button>
      <button class="ai-pill" data-tab="keamanan"><i class="fas fa-shield-alt text-base "></i>5. Keamanan &amp; Kebijakan Sesi</button>
      <button class="ai-pill" data-tab="backup"><i class="fas fa-cloud text-base "></i>6. Backup &amp; Pemulihan</button>
    </div>

    <!-- ============================================================
         PANEL 1 — UMUM & PROFIL HUB (sesuai desain)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="umum">
      <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        <!-- ===== Kolom kiri ===== -->
        <div class="xl:col-span-2 space-y-5">

          <!-- Informasi Identitas & Hub Operasional -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="100">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                  <i class="fas fa-warehouse text-lg text-blue-600"></i>
                </div>
                <div>
                  <h2 class="text-[16px] font-bold text-slate-800">Informasi Identitas &amp; Hub Operasional</h2>
                  <p class="text-[12.5px] text-slate-500 mt-0.5">Data legalitas, pengkodean logistik WMS, dan kontak darurat operasional gudang.</p>
                </div>
              </div>
              <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100 font-mono">DC-ID: 7702-CGK</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Nama Hub Distribusi</label>
                <div class="relative">
                  <i class="fas fa-circle text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="Hub Cakung DC-01 Utama">
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kode Fasilitas (DC Code)</label>
                <div class="relative">
                  <i class="fas fa-qrcode text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9 font-mono" value="DC-CGK-01">
                </div>
              </div>
              <div class="md:col-span-2">
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Alamat Fisik Gudang &amp; Titik Bongkar Muat</label>
                <div class="relative">
                  <i class="fas fa-map-marker-alt text-base text-slate-400 absolute left-3 top-4 -translate-y-1/2"></i>
                  <textarea class="ai-input pl-9 min-h-[64px] resize-none leading-relaxed">Kawasan Industri Pulogadung - Cakung Logistics Park Blok B3 No. 12-14, RW02, Cakung Timur, Jakarta Timur 13910</textarea>
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Zona Waktu Sistem Operasional</label>
                <div class="relative">
                  <i class="fas fa-globe text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <select class="ai-input pl-9 appearance-none">
                    <option>Asia/Jakarta (WIB - UTC+07:00)</option>
                    <option>Asia/Makassar (WITA - UTC+08:00)</option>
                    <option>Asia/Jayapura (WIT - UTC+09:00)</option>
                  </select>
                  <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Email Dispatcher Operasional</label>
                <div class="relative">
                  <i class="fas fa-envelope text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="ops-cakung@astro-inventory.co.id">
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Hotline Dispatch &amp; PIC Supervisor</label>
                <div class="relative">
                  <i class="fas fa-phone text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="+62 21 460-9981 (Ext. 204)">
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kapasitas Staging &amp; Bay Penampungan</label>
                <div class="relative">
                  <i class="fas fa-th-large text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="48 Bay (12 Inbound / 36 Outbound)">
                </div>
              </div>
            </div>
          </div>

          <!-- Parameter Operasional & Ambang Batas Stok -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="150">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                  <i class="fas fa-chart-line text-lg text-blue-600"></i>
                </div>
                <div>
                  <h2 class="text-[16px] font-bold text-slate-800">Parameter Operasional &amp; Ambang Batas Stok</h2>
                  <p class="text-[12.5px] text-slate-500 mt-0.5">Konfigurasi otomatisasi Reorder Point (ROP), buffer safety stock, dan kebijakan mitigasi stok mati.</p>
                </div>
              </div>
              <span class="ai-badge bg-slate-100 text-slate-600 border border-slate-200">Aktif Otomatis</span>
            </div>

            <div class="space-y-4">
              <!-- Slider buffer stock -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                <div class="flex flex-wrap items-start justify-between gap-3">
                  <div>
                    <div class="text-[13.5px] font-bold text-slate-800">Formula Buffer Stock Default (% Safety Stock dari Lead Time)</div>
                    <div class="text-[12px] text-slate-500 mt-0.5">Kompensasi fluktuasi pasokan supplier tier-1 &amp; keterlambatan ekspedisi lintas pulau.</div>
                  </div>
                  <div class="text-2xl font-extrabold text-blue-600"><span id="bufferVal">25</span>%</div>
                </div>
                <input type="range" id="bufferSlider" min="5" max="50" step="5" value="25" class="w-full mt-4 accent-blue-600 cursor-pointer">
                <div class="flex justify-between mt-1.5 text-[10.5px] font-semibold text-slate-400">
                  <span>5% (Konservatif)</span>
                  <span class="hidden sm:inline">15% (Rekomendasi FMCG)</span>
                  <span class="text-blue-600">25% (Aktif - High Velocity)</span>
                  <span>50% (Seasonal Peak)</span>
                </div>
              </div>

              <!-- Dead stock -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col md:flex-row md:items-center gap-4">
                <div class="flex-1">
                  <div class="text-[13.5px] font-bold text-slate-800">Ambang Batas Penandaan Dead Stock (Barang Mengendap)</div>
                  <div class="text-[12px] text-slate-500 mt-0.5 leading-relaxed">Barang tanpa pergerakan mutasi keluar akan ditandai untuk diskon likuidasi atau retur vendor.</div>
                </div>
                <div class="flex flex-none rounded-xl bg-white border border-slate-200 p-1 gap-1" id="deadStockGroup">
                  <button class="dead-opt px-3.5 py-2 rounded-lg text-[12.5px] font-semibold text-slate-600 transition-all" data-dead="60">&gt; 60 Hari</button>
                  <button class="dead-opt px-3.5 py-2 rounded-lg text-[12.5px] font-semibold transition-all" data-dead="90">&gt; 90 Hari (Aktif)</button>
                  <button class="dead-opt px-3.5 py-2 rounded-lg text-[12.5px] font-semibold text-slate-600 transition-all" data-dead="180">&gt; 180 Hari</button>
                </div>
              </div>

              <!-- Otomatisasi persetujuan -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center flex-none">
                  <i class="fas fa-bolt text-lg text-amber-500"></i>
                </div>
                <div class="flex-1">
                  <div class="text-[13.5px] font-bold text-slate-800">Otomatisasi Persetujuan Pengeluaran &lt; Rp 5.000.000</div>
                  <div class="text-[12px] text-slate-500 mt-0.5 leading-relaxed">Permintaan barang logistik internal di bawah Rp 5 juta langsung diterbitkan Surat Jalan tanpa antrean manual Head of Logistics.</div>
                </div>
                <div class="ai-switch ai-on flex-none" id="swAutoApprove"></div>
              </div>

              <!-- Metode valuasi -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                <div class="flex flex-wrap items-start justify-between gap-2">
                  <div>
                    <div class="text-[13.5px] font-bold text-slate-800">Kebijakan Metode Valuasi &amp; Penjatahan Batch Inventaris</div>
                    <div class="text-[12px] text-slate-500 mt-0.5">Menentukan alokasi fisik barang di rak penyimpanan dan perhitungan COGS buku persediaan.</div>
                  </div>
                  <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100">Kepatuhan PSAK 14</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4" id="valuasiGroup">
                  <button class="valuasi-opt text-left rounded-xl border-2 p-4 transition-all bg-white" data-valuasi="fifo">
                    <div class="flex items-center gap-2.5 flex-wrap">
                      <span class="valuasi-dot w-5 h-5 rounded-full flex items-center justify-center flex-none bg-blue-600 text-white"><i class="fas fa-check-circle text-base "></i></span>
                      <span class="text-[13.5px] font-bold text-slate-800">FIFO (First In, First Out)</span>
                      <span class="ai-badge bg-blue-50 text-blue-700">Rekomendasi</span>
                    </div>
                    <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Barang dengan nomor batch dan tanggal masuk terlama diprioritaskan keluar terlebih dahulu untuk mencegah kadaluarsa.</p>
                  </button>
                  <button class="valuasi-opt text-left rounded-xl border-2 p-4 transition-all bg-slate-100/60" data-valuasi="avg">
                    <div class="flex items-center gap-2.5 flex-wrap">
                      <span class="valuasi-dot w-5 h-5 rounded-full flex items-center justify-center flex-none bg-slate-300 text-transparent"></span>
                      <span class="text-[13.5px] font-bold text-slate-800">Average Moving Cost</span>
                    </div>
                    <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Biaya perolehan dihitung rata-rata berbobot setiap ada batch penerimaan baru dari PO supplier.</p>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Integrasi Perangkat Keras -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="200">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                  <i class="fas fa-desktop text-lg text-blue-600"></i>
                </div>
                <div>
                  <h2 class="text-[16px] font-bold text-slate-800">Integrasi Perangkat Keras Gudang (Hardware &amp; Scanners)</h2>
                  <p class="text-[12.5px] text-slate-500 mt-0.5">Monitoring koneksi nirkabel scanner genggam, terminal forklift, dan stasiun printer barcode thermal.</p>
                </div>
              </div>
              <button class="ai-btn ai-btn-soft flex-none" data-toast="Pemindaian jaringan perangkat dimulai..." data-toast-type="info"><i class="fas fa-rotate text-base "></i>Scan Jaringan</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <!-- Scanner -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                <div class="flex items-start justify-between gap-2">
                  <div class="flex items-center gap-2.5">
                    <i class="fas fa-barcode text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13.5px] font-bold text-slate-800">Scanner Barcode / RFID Handheld</span>
                  </div>
                  <span class="ai-badge bg-emerald-100 text-emerald-700">24 Online</span>
                </div>
                <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Zebra TC21 Enterprise Mobile Terminal aktif di Zona A, B, Staging Rak C, dan Dock Loading.</p>
                <div class="flex items-center justify-between mt-4 text-[12px]">
                  <span class="font-semibold text-slate-600">Battery Health Armada Scanner</span>
                  <span class="font-extrabold text-slate-800">94% Rata-rata</span>
                </div>
                <div class="ai-bar mt-1.5" data-w="94"><span class="bg-emerald-500"></span></div>
                <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-200/70">
                  <span class="flex items-center gap-1.5 text-[11.5px] font-semibold text-slate-600"><span class="ai-live-dot"></span>WiFi 6 DC-IoT Mesh</span>
                  <button class="text-[12px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1" data-toast="Panel manajemen 24 perangkat scanner dibuka." data-toast-type="info">Kelola 24 Device <i class="fas fa-arrow-right text-sm "></i></button>
                </div>
              </div>

              <!-- Printer -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                <div class="flex items-start justify-between gap-2">
                  <div class="flex items-center gap-2.5">
                    <i class="fas fa-print text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13.5px] font-bold text-slate-800">Thermal Label Printer Inbound</span>
                  </div>
                  <span class="ai-badge bg-emerald-100 text-emerald-700">Ready</span>
                </div>
                <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Zebra ZD230 Heavy Duty di Stasiun Dock Inbound 01-04 untuk cetak barcode pallet &amp; bin tag.</p>
                <div class="flex flex-wrap gap-2 mt-4">
                  <span class="text-[11px] font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 font-mono">IP: 192.168.10.85</span>
                  <span class="text-[11px] font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 font-mono">Port: 9100</span>
                  <span class="text-[11px] font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 font-mono">DPI: 300</span>
                </div>
                <div class="flex items-center justify-between mt-auto pt-4">
                  <span class="text-[12px] text-slate-500">Kertas Sisa: <span class="font-bold text-slate-700">~620 Label</span></span>
                  <button class="ai-btn ai-btn-primary" id="btnTestPrint"><i class="fas fa-print text-base "></i>Test Print Barcode</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== Kolom kanan ===== -->
        <div class="space-y-5">

          <!-- Status Layanan & Sync -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="120">
            <div class="flex items-center justify-between mb-4">
              <div class="flex items-center gap-2.5">
                <i class="fas fa-network-wired text-lg text-blue-600"></i>
                <h3 class="text-[15px] font-bold text-slate-800">Status Layanan &amp; Sync</h3>
              </div>
              <span class="ai-live-dot"></span>
            </div>
            <div class="space-y-2.5">
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-database text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">PostgreSQL Cluster</div>
                  <div class="text-[11px] text-slate-500 truncate">Master Read/Write • Cakung DC</div>
                </div>
                <div class="text-right flex-none">
                  <span class="ai-badge bg-emerald-100 text-emerald-700 font-mono">4ms</span>
                  <div class="text-[11px] font-bold text-emerald-600 mt-1">Sehat</div>
                </div>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-cloud text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">SAP S/4HANA Connector</div>
                  <div class="text-[11px] text-slate-500 truncate">Sync otomatis tiap 15 menit</div>
                </div>
                <div class="text-right flex-none">
                  <span class="ai-badge bg-blue-50 text-blue-700">RFC OK</span>
                  <div class="text-[11px] text-slate-400 mt-1 font-medium">2 mnt lalu</div>
                </div>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-envelope text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">SMTP / Email Alert Gateway</div>
                  <div class="text-[11px] text-slate-500 truncate">Notifikasi Purchase Order &amp; SO</div>
                </div>
                <span class="ai-badge bg-emerald-100 text-emerald-700 flex-none">Aktif</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-comment-dots text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">WhatsApp Business API</div>
                  <div class="text-[11px] text-slate-500 truncate">Alert Insiden Stok &amp; Dispatcher</div>
                </div>
                <span class="ai-badge bg-emerald-100 text-emerald-700 flex-none">Terhubung</span>
              </div>
            </div>
            <button class="ai-btn ai-btn-secondary w-full mt-4" data-toast="Diagnostik jaringan penuh sedang berjalan — hasil dalam ~30 detik." data-toast-type="info">Cek Diagnostik Jaringan Penuh</button>
          </div>

          <!-- Jadwal Backup Otomatis -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="170">
            <div class="flex items-center justify-between gap-2 mb-4">
              <div class="flex items-center gap-2.5">
                <i class="fas fa-cloud text-lg text-blue-600"></i>
                <h3 class="text-[15px] font-bold text-slate-800">Jadwal Backup Otomatis</h3>
              </div>
              <span class="text-[10.5px] font-bold text-slate-400 font-mono tracking-tight">CRON: 0 3 * * *</span>
            </div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 space-y-2.5 text-[12.5px]">
              <div class="flex items-start justify-between gap-3">
                <span class="text-slate-500">Backup Snapshot Terakhir:</span>
                <span class="font-bold text-slate-800 text-right">Hari ini, 03:00 WIB</span>
              </div>
              <div class="flex items-start justify-between gap-3">
                <span class="text-slate-500">Ukuran Arsip SQL + Blob:</span>
                <span class="font-bold text-blue-600 text-right">1.42 GB (Terenkripsi)</span>
              </div>
              <div class="flex items-start justify-between gap-3">
                <span class="text-slate-500">Titik Redundansi Retensi:</span>
                <span class="text-right font-semibold text-slate-700">AWS S3 (Jakarta ap-southeast-3)<br><span class="text-slate-500 font-normal">NAS Lokal DC Cakung (Synology)</span></span>
              </div>
            </div>
            <button class="ai-btn ai-btn-soft w-full mt-4" id="btnBackup"><i class="fas fa-cloud-download-alt text-base "></i>Buat Backup Manual Sekarang</button>
            <div id="backupProgress" class="mt-3" style="display:none">
              <div class="flex justify-between text-[11px] font-semibold text-slate-500 mb-1"><span>Proses kompresi &amp; enkripsi arsip...</span><span id="backupPct">0%</span></div>
              <div class="ai-bar"><span id="backupBar" class="bg-blue-600"></span></div>
            </div>
          </div>

          <!-- Zona Bahaya & Intervensi -->
          <div class="ai-card p-5 ai-reveal border-red-200" data-delay="220">
            <div class="flex items-center gap-2.5 mb-1.5">
              <i class="fas fa-triangle-exclamation text-lg text-red-500"></i>
              <h3 class="text-[15px] font-bold text-red-600">Zona Bahaya &amp; Intervensi</h3>
            </div>
            <p class="text-[12px] text-slate-500 mb-4 leading-relaxed">Tindakan berikut berdampak langsung pada operasional penerimaan dan pengeluaran fisik gudang.</p>
            <div class="space-y-2.5">
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800">Freeze Transaksi Gudang</div>
                  <div class="text-[11.5px] text-slate-500 mt-0.5">Kunci mutasi untuk Stock Opname Massal</div>
                </div>
                <button class="ai-btn ai-btn-danger flex-none" data-toast="Peringatan: Freeze transaksi memerlukan otorisasi dua langkah!" data-toast-type="danger">Kunci</button>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800">Hapus Cache Sesi Redis</div>
                  <div class="text-[11.5px] text-slate-500 mt-0.5">Paksa refresh 18 sesi admin aktif</div>
                </div>
                <button class="ai-btn ai-btn-secondary flex-none" data-toast="Cache Sesi Redis berhasil di-flush." data-toast-type="warn">Flush</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ===== 3 kartu bawah ===== -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
        <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="100">
          <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center mb-4"><i class="fas fa-code text-lg text-slate-600"></i></div>
          <h3 class="text-[15px] font-bold text-slate-800">Dokumentasi &amp; API Key Sistem</h3>
          <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Kelola token Webhook untuk sinkronisasi WMS pihak ketiga, integrasi armada ekspedisi, dan portal inventaris B2B mitra.</p>
          <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Portal Developer dibuka (demo)." data-toast-type="info">Akses Portal Developer <i class="fas fa-arrow-right text-base "></i></button>
        </div>
        <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="160">
          <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center mb-4"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
          <h3 class="text-[15px] font-bold text-slate-800">Audit &amp; Kepatuhan Konfigurasi</h3>
          <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Setiap penyesuaian parameter dan batas stok tercatat otomatis dalam audit trail forensik SHA-256 yang memenuhi standar ISO 27001.</p>
          <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Laporan Audit Trail (SHA-256) diunduh." data-toast-type="success">Unduh Laporan Audit Trail <i class="fas fa-download text-base "></i></button>
        </div>
        <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="220">
          <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mb-4"><i class="fas fa-headset text-lg text-emerald-600"></i></div>
          <h3 class="text-[15px] font-bold text-slate-800">Dukungan Teknis Enterprise</h3>
          <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Bantuan penanganan insiden infrastruktur gudang 24/7 dengan jaminan respon SLA &lt;15 menit langsung dari Cloud Command Center.</p>
          <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Tiket eskalasi IT dibuat — SLA respon &lt;15 menit." data-toast-type="success">Buka Tiket Eskalasi IT <i class="fas fa-external-link-alt text-base "></i></button>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 2 — ATURAN INVENTARIS & STOK (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="stok" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-clipboard-list text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Reorder Point &amp; Safety Stock</h2>
              <p class="text-[12px] text-slate-500">Ambang ROP otomatis per kategori barang.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div>
              <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Perhitungan ROP Default</label>
              <select class="ai-input"><option>(Rata-rata Harian × Lead Time) + Safety Stock</option><option>Min-Max Manual per SKU</option><option>Konsumsi 30 Hari Terakhir</option></select>
            </div>
            <div>
              <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Lead Time Default Supplier Tier-1 (Hari)</label>
              <input class="ai-input" value="7">
            </div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3">
              <div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Notifikasi Stok Kritis ke WhatsApp Dispatcher</div><div class="text-[11.5px] text-slate-500">Kirim alert saat stok menyentuh 80% nilai ROP.</div></div>
              <div class="ai-switch ai-on"></div>
            </div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-circle text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Batch, ED &amp; Satuan Ukur</h2>
              <p class="text-[12px] text-slate-500">Kebijakan pelacakan lot dan konversi satuan.</p>
            </div>
          </div>
          <div class="space-y-3">
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Wajib Nomor Batch &amp; Tanggal Kedaluwarsa</div><div class="text-[11.5px] text-slate-500">Untuk kategori FMCG &amp; obat-obatan.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Blokir Keluar Barang ED &lt; 90 Hari</div><div class="text-[11.5px] text-slate-500">Butuh override Super Admin.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Izinkan Stok Negara Sementara (In-Transit)</div><div class="text-[11.5px] text-slate-500">Mutasi antar-hub belum diterima fisik.</div></div><div class="ai-switch"></div></div>
            <button class="ai-btn ai-btn-primary w-full" data-toast="Aturan inventaris tersimpan."><i class="fas fa-save text-base "></i>Simpan Aturan Inventaris</button>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 3 — PERANGKAT & PRINTER BARCODE (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="printer" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-print text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Default Template Label</h2>
              <p class="text-[12px] text-slate-500">Format cetak barcode pallet &amp; bin tag.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Ukuran Label</label><select class="ai-input"><option>100 x 50 mm (Standar Pallet)</option><option>75 x 50 mm (Bin Tag)</option><option>60 x 40 mm (Item Kecil)</option></select></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Symbology Barcode</label><select class="ai-input"><option>Code 128 (Rekomendasi)</option><option>QR Code 2D</option><option>Code 39</option></select></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Jumlah Salinan Otomatis per DO</label><input class="ai-input" value="2"></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-barcode text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Pengaturan Scanner Armada</h2>
              <p class="text-[12px] text-slate-500">Zebra TC21 • 24 perangkat terdaftar.</p>
            </div>
          </div>
          <div class="space-y-3">
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Suara Konfirmasi Scan Berhasil</div><div class="text-[11.5px] text-slate-500">Feedback audio di seluruh armada.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Auto-Sync Offline Queue</div><div class="text-[11.5px] text-slate-500">Sinkron otomatis saat sinyal WiFi 6 kembali.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Mode Hemat Baterai Shift Malam</div><div class="text-[11.5px] text-slate-500">Aktif 22:00 - 06:00 WIB.</div></div><div class="ai-switch"></div></div>
            <div class="flex gap-2">
              <button class="ai-btn ai-btn-primary flex-1" data-toast="Pengaturan printer & scanner tersimpan."><i class="fas fa-save text-base "></i>Simpan</button>
              <button class="ai-btn ai-btn-secondary flex-1" data-toast="Test label dikirim ke Zebra ZD230 (Dock Inbound 01)." data-toast-type="info"><i class="fas fa-print text-base "></i>Test Print</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 4 — INTEGRASI ERP & API (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="erp" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-exchange-alt text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Koneksi SAP S/4HANA</h2>
              <p class="text-[12px] text-slate-500">RFC Destination • Status: RFC OK (2 mnt lalu).</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Endpoint Host</label><input class="ai-input font-mono" value="sapgw.astro-inventory.co.id:3300"></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Client / System ID</label><input class="ai-input font-mono" value="100 / PRD-DCG"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Sync Master SKU Dua Arah</div><div class="text-[11.5px] text-slate-500">Perubahan master data ikut ke SAP.</div></div><div class="ai-switch ai-on"></div></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-key text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">API Key &amp; Webhook</h2>
              <p class="text-[12px] text-slate-500">Token integrasi mitra ekspedisi &amp; B2B.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Production API Key</label><div class="relative"><input class="ai-input pr-10 font-mono" type="password" value="«redacted:sk_live_...»" readonly><i class="fas fa-eye text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2"></i></div></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Webhook URL Mutasi Stok</label><input class="ai-input font-mono" value="https://hooks.astro-logistics.id/wms/mutation"></div>
            <div class="flex gap-2">
              <button class="ai-btn ai-btn-primary flex-1" data-toast="Konfigurasi integrasi ERP & API tersimpan."><i class="fas fa-save text-base "></i>Simpan</button>
              <button class="ai-btn ai-btn-secondary flex-1" data-toast="API Key baru digenerate — token lama dicabut." data-toast-type="warn"><i class="fas fa-undo text-base "></i>Regenerate Key</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 5 — KEAMANAN & KEBIJAKAN SESI (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="keamanan" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Kebijakan Sesi Pengguna</h2>
              <p class="text-[12px] text-slate-500">Berlaku untuk seluruh role di Hub Cakung DC-01.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Timeout Sesi Idle (Menit)</label><input class="ai-input" value="30"></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Maksimal Percobaan Login Gagal</label><input class="ai-input" value="5"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Wajib 2FA untuk Semua Role</div><div class="text-[11.5px] text-slate-500">TOTP atau kunci fisik FIDO2.</div></div><div class="ai-switch ai-on"></div></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-lock text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Whitelist IP &amp; Akses Jarak Jauh</h2>
              <p class="text-[12px] text-slate-500">Pembatasan akses panel admin.</p>
            </div>
          </div>
          <div class="space-y-3">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Rentang IP Diizinkan (CIDR)</label><input class="ai-input font-mono" value="182.253.110.0/24, 10.240.0.0/16"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Blokir Akses di Luar Jam Operasional</div><div class="text-[11.5px] text-slate-500">Panel admin terkunci 23:00 - 05:00 WIB.</div></div><div class="ai-switch"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Audit Forensik Klik Kritis</div><div class="text-[11.5px] text-slate-500">Ledger SHA-256 untuk approval &amp; mutasi.</div></div><div class="ai-switch ai-on"></div></div>
            <button class="ai-btn ai-btn-primary w-full" data-toast="Kebijakan keamanan tersimpan."><i class="fas fa-save text-base "></i>Simpan Kebijakan Keamanan</button>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 6 — BACKUP & PEMULIHAN (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="backup" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-cloud text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Penjadwalan Backup</h2>
              <p class="text-[12px] text-slate-500">Snapshot SQL + Blob terenkripsi AES-256.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Ekspresi CRON</label><input class="ai-input font-mono" value="0 3 * * *"></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Retensi Snapshot (Hari)</label><input class="ai-input" value="90"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Replikasi ke AWS S3 Jakarta</div><div class="text-[11.5px] text-slate-500">ap-southeast-3 • versi objek aktif.</div></div><div class="ai-switch ai-on"></div></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-hdd text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Titik Pemulihan Tersedia</h2>
              <p class="text-[12px] text-slate-500">Snapshot terverifikasi 30 hari terakhir.</p>
            </div>
          </div>
          <div class="ai-table w-full text-[12.5px]">
            <table class="w-full">
              <thead><tr><th class="text-left rounded-tl-lg">Snapshot</th><th class="text-left">Ukuran</th><th class="text-left rounded-tr-lg">Aksi</th></tr></thead>
              <tbody>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Hari ini, 03:00 WIB</td><td class="py-2.5 text-slate-500">1.42 GB</td><td class="py-2.5"><button class="text-[12px] font-bold text-blue-600" data-toast="Mode restore dibuka — konfirmasi dua langkah diperlukan." data-toast-type="warn">Restore</button></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Kemarin, 03:00 WIB</td><td class="py-2.5 text-slate-500">1.40 GB</td><td class="py-2.5"><button class="text-[12px] font-bold text-blue-600" data-toast="Mode restore dibuka — konfirmasi dua langkah diperlukan." data-toast-type="warn">Restore</button></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">2 hari lalu, 03:00 WIB</td><td class="py-2.5 text-slate-500">1.38 GB</td><td class="py-2.5"><button class="text-[12px] font-bold text-blue-600" data-toast="Mode restore dibuka — konfirmasi dua langkah diperlukan." data-toast-type="warn">Restore</button></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

        <!-- ===== Modal Log Perubahan ===== -->
  <div id="modalLog" class="modal-overlay">
    <div class="modal-box p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-[16px] font-bold text-slate-800 flex items-center gap-2"><i class="fas fa-history text-lg text-blue-600"></i>Log Perubahan Konfigurasi</h3>
        <button data-modal-close class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-500"><i class="fas fa-times text-base "></i></button>
      </div>
      <div class="space-y-2.5 text-[12.5px]">
        <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center justify-between gap-3"><div><div class="font-bold text-slate-800">Buffer Stock Default diubah 25% → 30%</div><div class="text-slate-500 text-[11.5px]">Budi Santoso • Hari ini 09:14 WIB</div></div><span class="ai-badge bg-blue-50 text-blue-700 flex-none">SHA:81ac02</span></div>
        <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center justify-between gap-3"><div><div class="font-bold text-slate-800">Ambang Dead Stock digeser &gt; 60 → &gt; 90 Hari</div><div class="text-slate-500 text-[11.5px]">Budi Santoso • 2 hari lalu</div></div><span class="ai-badge bg-blue-50 text-blue-700 flex-none">SHA:4de911</span></div>
        <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center justify-between gap-3"><div><div class="font-bold text-slate-800">Jadwal Backup CRON diubah ke 0 3 * * *</div><div class="text-slate-500 text-[11.5px]">Sistem • 12 hari lalu</div></div><span class="ai-badge bg-slate-100 text-slate-600 flex-none">SHA:0b7f5a</span></div>
      </div>
      <button class="ai-btn ai-btn-secondary w-full mt-5" data-modal-close>Tutup</button>
    </div>
  </div>
        @endif

        @if(auth()->user()->isKepalaGudang())
        <!-- ===== Breadcrumb + versi sistem ===== -->
    <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
      <div class="flex items-center gap-2 text-sm text-gray-500 mb-4 overflow-x-auto whitespace-nowrap anim-fade-in">
        <span>Beranda</span><i class="fas fa-chevron-right text-xs"></i>
        <span>Pengaturan &amp; Akun</span><i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-900 font-medium">Pengaturan</span>
    </div>
      <div class="ai-badge bg-white border border-slate-200 text-slate-500 shadow-sm">
        <span class="ai-live-dot"></span>
        <span class="text-emerald-600">SISTEM OPTIMAL</span>
        <span class="text-slate-300">•</span>
        <span>VERSI 4.2.0-LTS</span>
        <span class="font-mono font-semibold text-slate-400">SHA:8f92af</span>
      </div>
    </div>

    <!-- ===== Header card ===== -->
    <div class="ai-card ai-card-hover p-5 md:p-6 mb-5 ai-reveal flex flex-col lg:flex-row lg:items-center gap-5">
      <div class="flex items-start gap-4 flex-1">
        <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
          <i class="fas fa-sliders-h text-xl text-blue-600"></i>
        </div>
        <div>
          <h1 class="text-[22px] md:text-2xl font-extrabold text-slate-800 leading-tight">Pengaturan Akun &amp; Preferensi Approver Gudang</h1>
          <p class="text-[13px] text-slate-500 mt-1 max-w-xl leading-relaxed">Kelola preferensi alur persetujuan gudang, ambang batas wewenang, notifikasi otorisasi, keamanan sesi, dan perangkat terminal logistik.</p>
        </div>
      </div>
      <div class="flex flex-wrap items-center gap-2.5 flex-none">
        <button class="ai-btn ai-btn-secondary" id="btnReset"><i class="fas fa-undo text-base "></i>Kembalikan Default</button>
        <button class="ai-btn ai-btn-secondary" data-modal-open="modalLog"><i class="fas fa-history text-base "></i>Lihat Log Perubahan</button>
        <button class="ai-btn ai-btn-primary" id="btnSimpan"><i class="fas fa-check-circle text-base "></i>Simpan Perubahan</button>
      </div>
    </div>

    <!-- ===== Tab nomor ===== -->
    <div data-tabs="pengaturan" class="flex gap-2 overflow-x-auto pb-1 mb-5 ai-reveal" data-delay="80">
      <button class="ai-pill ai-pill-active" data-tab="umum"><i class="fas fa-sliders-h text-base "></i>1. Umum &amp; Profil Hub</button>
      <button class="ai-pill" data-tab="stok"><i class="fas fa-clipboard-list text-base "></i>2. Aturan Inventaris &amp; Stok</button>
      <button class="ai-pill" data-tab="printer"><i class="fas fa-print text-base "></i>3. Perangkat &amp; Printer Barcode</button>
      <button class="ai-pill" data-tab="erp"><i class="fas fa-exchange-alt text-base "></i>4. Integrasi ERP &amp; API</button>
      <button class="ai-pill" data-tab="keamanan"><i class="fas fa-shield-alt text-base "></i>5. Keamanan &amp; Kebijakan Sesi</button>
      <button class="ai-pill" data-tab="backup"><i class="fas fa-cloud text-base "></i>6. Backup &amp; Pemulihan</button>
    </div>

    <!-- ============================================================
         PANEL 1 — UMUM & PROFIL HUB (sesuai desain)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="umum">
      <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        <!-- ===== Kolom kiri ===== -->
        <div class="xl:col-span-2 space-y-5">

          <!-- Informasi Identitas & Hub Operasional -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="100">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                  <i class="fas fa-warehouse text-lg text-blue-600"></i>
                </div>
                <div>
                  <h2 class="text-[16px] font-bold text-slate-800">Identitas &amp; Wewenang Approver</h2>
                  <p class="text-[12.5px] text-slate-500 mt-0.5">Data hub operasional, wewenang persetujuan mutasi, dan kontak darurat gudang.</p>
                </div>
              </div>
              <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100 font-mono">ID: KG001-DC01</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Nama Hub Distribusi</label>
                <div class="relative">
                  <i class="fas fa-circle text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="Hub Cakung DC-01 Utama">
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kode Fasilitas (DC Code)</label>
                <div class="relative">
                  <i class="fas fa-qrcode text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9 font-mono" value="KG-DC01">
                </div>
              </div>
              <div class="md:col-span-2">
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Alamat Fisik Gudang &amp; Titik Bongkar Muat</label>
                <div class="relative">
                  <i class="fas fa-map-marker-alt text-base text-slate-400 absolute left-3 top-4 -translate-y-1/2"></i>
                  <textarea class="ai-input pl-9 min-h-[64px] resize-none leading-relaxed">Kawasan Industri Pulogadung - Cakung Logistics Park Blok B3 No. 12-14, RW02, Cakung Timur, Jakarta Timur 13910</textarea>
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Zona Waktu Sistem Operasional</label>
                <div class="relative">
                  <i class="fas fa-globe text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <select class="ai-input pl-9 appearance-none">
                    <option>Asia/Jakarta (WIB - UTC+07:00)</option>
                    <option>Asia/Makassar (WITA - UTC+08:00)</option>
                    <option>Asia/Jayapura (WIT - UTC+09:00)</option>
                  </select>
                  <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Email Dispatcher Operasional</label>
                <div class="relative">
                  <i class="fas fa-envelope text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="budi.s@astro-dc.co.id">
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Hotline Dispatch &amp; PIC Supervisor</label>
                <div class="relative">
                  <i class="fas fa-phone text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="+62 21 460-9981 (Ext. 204)">
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kapasitas Staging &amp; Bay Penampungan</label>
                <div class="relative">
                  <i class="fas fa-th-large text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="48 Bay (12 Inbound / 36 Outbound)">
                </div>
              </div>
            </div>
          </div>

          <!-- Parameter Operasional & Ambang Batas Stok -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="150">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                  <i class="fas fa-chart-line text-lg text-blue-600"></i>
                </div>
                <div>
                  <h2 class="text-[16px] font-bold text-slate-800">Ambang Batas &amp; Parameter Persetujuan</h2>
                  <p class="text-[12.5px] text-slate-500 mt-0.5">Konfigurasi batas nominal wewenang mandiri, dual-approval Supervisor &amp; Head DC, dan eskalasi otomatis.</p>
                </div>
              </div>
              <span class="ai-badge bg-slate-100 text-slate-600 border border-slate-200">Aktif Otomatis</span>
            </div>

            <div class="space-y-4">
              <!-- Slider buffer stock -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                <div class="flex flex-wrap items-start justify-between gap-3">
                  <div>
                    <div class="text-[13.5px] font-bold text-slate-800">Formula Buffer Stock Default (% Safety Stock dari Lead Time)</div>
                    <div class="text-[12px] text-slate-500 mt-0.5">Kompensasi fluktuasi pasokan supplier tier-1 &amp; keterlambatan ekspedisi lintas pulau.</div>
                  </div>
                  <div class="text-2xl font-extrabold text-blue-600"><span id="bufferVal">25</span>%</div>
                </div>
                <input type="range" id="bufferSlider" min="5" max="50" step="5" value="25" class="w-full mt-4 accent-blue-600 cursor-pointer">
                <div class="flex justify-between mt-1.5 text-[10.5px] font-semibold text-slate-400">
                  <span>5% (Konservatif)</span>
                  <span class="hidden sm:inline">15% (Rekomendasi FMCG)</span>
                  <span class="text-blue-600">25% (Aktif - High Velocity)</span>
                  <span>50% (Seasonal Peak)</span>
                </div>
              </div>

              <!-- Dead stock -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col md:flex-row md:items-center gap-4">
                <div class="flex-1">
                  <div class="text-[13.5px] font-bold text-slate-800">Ambang Batas Penandaan Dead Stock (Barang Mengendap)</div>
                  <div class="text-[12px] text-slate-500 mt-0.5 leading-relaxed">Barang tanpa pergerakan mutasi keluar akan ditandai untuk diskon likuidasi atau retur vendor.</div>
                </div>
                <div class="flex flex-none rounded-xl bg-white border border-slate-200 p-1 gap-1" id="deadStockGroup">
                  <button class="dead-opt px-3.5 py-2 rounded-lg text-[12.5px] font-semibold text-slate-600 transition-all" data-dead="60">&gt; 60 Hari</button>
                  <button class="dead-opt px-3.5 py-2 rounded-lg text-[12.5px] font-semibold transition-all" data-dead="90">&gt; 90 Hari (Aktif)</button>
                  <button class="dead-opt px-3.5 py-2 rounded-lg text-[12.5px] font-semibold text-slate-600 transition-all" data-dead="180">&gt; 180 Hari</button>
                </div>
              </div>

              <!-- Otomatisasi persetujuan -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center flex-none">
                  <i class="fas fa-bolt text-lg text-amber-500"></i>
                </div>
                <div class="flex-1">
                  <div class="text-[13.5px] font-bold text-slate-800">Otomatisasi Persetujuan Pengeluaran &lt; Rp 5.000.000</div>
                  <div class="text-[12px] text-slate-500 mt-0.5 leading-relaxed">Permintaan logistik internal di bawah Rp 5 juta langsung diterbitkan Surat Jalan tanpa antrean manual.</div>
                </div>
                <div class="ai-switch ai-on flex-none" id="swAutoApprove"></div>
              </div>

              <!-- Metode valuasi -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                <div class="flex flex-wrap items-start justify-between gap-2">
                  <div>
                    <div class="text-[13.5px] font-bold text-slate-800">Kebijakan Metode Valuasi &amp; Penjatahan Batch Inventaris</div>
                    <div class="text-[12px] text-slate-500 mt-0.5">Menentukan alokasi fisik barang di rak penyimpanan dan perhitungan COGS buku persediaan.</div>
                  </div>
                  <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100">Kepatuhan PSAK 14</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4" id="valuasiGroup">
                  <button class="valuasi-opt text-left rounded-xl border-2 p-4 transition-all bg-white" data-valuasi="fifo">
                    <div class="flex items-center gap-2.5 flex-wrap">
                      <span class="valuasi-dot w-5 h-5 rounded-full flex items-center justify-center flex-none bg-blue-600 text-white"><i class="fas fa-check-circle text-base "></i></span>
                      <span class="text-[13.5px] font-bold text-slate-800">FIFO (First In, First Out)</span>
                      <span class="ai-badge bg-blue-50 text-blue-700">Rekomendasi</span>
                    </div>
                    <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Barang dengan nomor batch dan tanggal masuk terlama diprioritaskan keluar terlebih dahulu untuk mencegah kadaluarsa.</p>
                  </button>
                  <button class="valuasi-opt text-left rounded-xl border-2 p-4 transition-all bg-slate-100/60" data-valuasi="avg">
                    <div class="flex items-center gap-2.5 flex-wrap">
                      <span class="valuasi-dot w-5 h-5 rounded-full flex items-center justify-center flex-none bg-slate-300 text-transparent"></span>
                      <span class="text-[13.5px] font-bold text-slate-800">Average Moving Cost</span>
                    </div>
                    <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Biaya perolehan dihitung rata-rata berbobot setiap ada batch penerimaan baru dari PO supplier.</p>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Integrasi Perangkat Keras -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="200">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                  <i class="fas fa-desktop text-lg text-blue-600"></i>
                </div>
                <div>
                  <h2 class="text-[16px] font-bold text-slate-800">Integrasi Perangkat Keras Gudang (Hardware &amp; Scanners)</h2>
                  <p class="text-[12.5px] text-slate-500 mt-0.5">Monitoring koneksi nirkabel scanner genggam, terminal forklift, dan stasiun printer barcode thermal.</p>
                </div>
              </div>
              <button class="ai-btn ai-btn-soft flex-none" data-toast="Pemindaian jaringan perangkat dimulai..." data-toast-type="info"><i class="fas fa-rotate text-base "></i>Scan Jaringan</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <!-- Scanner -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                <div class="flex items-start justify-between gap-2">
                  <div class="flex items-center gap-2.5">
                    <i class="fas fa-barcode text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13.5px] font-bold text-slate-800">Scanner Barcode / RFID Handheld</span>
                  </div>
                  <span class="ai-badge bg-emerald-100 text-emerald-700">18 Online</span>
                </div>
                <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Zebra TC52x Enterprise Mobile Terminal aktif di Zona A, B, Staging Rak C, dan Dock Loading.</p>
                <div class="flex items-center justify-between mt-4 text-[12px]">
                  <span class="font-semibold text-slate-600">Battery Health Armada Scanner</span>
                  <span class="font-extrabold text-slate-800">91% Rata-rata</span>
                </div>
                <div class="ai-bar mt-1.5" data-w="94"><span class="bg-emerald-500"></span></div>
                <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-200/70">
                  <span class="flex items-center gap-1.5 text-[11.5px] font-semibold text-slate-600"><span class="ai-live-dot"></span>WiFi 6 DC-IoT Mesh</span>
                  <button class="text-[12px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1" data-toast="Panel manajemen 24 perangkat scanner dibuka." data-toast-type="info">Kelola 18 Device <i class="fas fa-arrow-right text-sm "></i></button>
                </div>
              </div>

              <!-- Printer -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                <div class="flex items-start justify-between gap-2">
                  <div class="flex items-center gap-2.5">
                    <i class="fas fa-print text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13.5px] font-bold text-slate-800">Thermal Label Printer Inbound</span>
                  </div>
                  <span class="ai-badge bg-emerald-100 text-emerald-700">Ready</span>
                </div>
                <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Zebra ZD421 Heavy Duty di Stasiun Dock Inbound 01-04 untuk cetak barcode pallet &amp; bin tag.</p>
                <div class="flex flex-wrap gap-2 mt-4">
                  <span class="text-[11px] font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 font-mono">IP: 192.168.10.45</span>
                  <span class="text-[11px] font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 font-mono">Port: 9100</span>
                  <span class="text-[11px] font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 font-mono">DPI: 300</span>
                </div>
                <div class="flex items-center justify-between mt-auto pt-4">
                  <span class="text-[12px] text-slate-500">Kertas Sisa: <span class="font-bold text-slate-700">~540 Label</span></span>
                  <button class="ai-btn ai-btn-primary" id="btnTestPrint"><i class="fas fa-print text-base "></i>Test Print Barcode</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== Kolom kanan ===== -->
        <div class="space-y-5">

          <!-- Status Layanan & Sync -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="120">
            <div class="flex items-center justify-between mb-4">
              <div class="flex items-center gap-2.5">
                <i class="fas fa-network-wired text-lg text-blue-600"></i>
                <h3 class="text-[15px] font-bold text-slate-800">Status Layanan &amp; Sync</h3>
              </div>
              <span class="ai-live-dot"></span>
            </div>
            <div class="space-y-2.5">
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-database text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">WMS Service Gudang</div>
                  <div class="text-[11px] text-slate-500 truncate">Master Read/Write • Cakung DC</div>
                </div>
                <div class="text-right flex-none">
                  <span class="ai-badge bg-emerald-100 text-emerald-700 font-mono">12ms</span>
                  <div class="text-[11px] font-bold text-emerald-600 mt-1">Sehat</div>
                </div>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-cloud text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">Zebra Printer Fleet</div>
                  <div class="text-[11px] text-slate-500 truncate">ZD421 &amp; ZD230 • 8 unit</div>
                </div>
                <div class="text-right flex-none">
                  <span class="ai-badge bg-blue-50 text-blue-700">ONLINE</span>
                  <div class="text-[11px] text-slate-400 mt-1 font-medium">Baru saja</div>
                </div>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-envelope text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">SMTP DO &amp; SO</div>
                  <div class="text-[11px] text-slate-500 truncate">Surat jalan &amp; stok opname</div>
                </div>
                <span class="ai-badge bg-emerald-100 text-emerald-700 flex-none">Aktif</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-comment-dots text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">WhatsApp Alert Dispatcher</div>
                  <div class="text-[11px] text-slate-500 truncate">Alert mutasi &amp; dispatch</div>
                </div>
                <span class="ai-badge bg-emerald-100 text-emerald-700 flex-none">Terhubung</span>
              </div>
            </div>
            <button class="ai-btn ai-btn-secondary w-full mt-4" data-toast="Diagnostik jaringan penuh sedang berjalan — hasil dalam ~30 detik." data-toast-type="info">Cek Diagnostik Jaringan Penuh</button>
          </div>

          <!-- Jadwal Backup Otomatis -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="170">
            <div class="flex items-center justify-between gap-2 mb-4">
              <div class="flex items-center gap-2.5">
                <i class="fas fa-cloud text-lg text-blue-600"></i>
                <h3 class="text-[15px] font-bold text-slate-800">Jadwal Backup Otomatis</h3>
              </div>
              <span class="text-[10.5px] font-bold text-slate-400 font-mono tracking-tight">CRON: 0 3 * * *</span>
            </div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 space-y-2.5 text-[12.5px]">
              <div class="flex items-start justify-between gap-3">
                <span class="text-slate-500">Backup Snapshot Terakhir:</span>
                <span class="font-bold text-slate-800 text-right">Hari ini, 03:00 WIB</span>
              </div>
              <div class="flex items-start justify-between gap-3">
                <span class="text-slate-500">Ukuran Arsip SQL + Blob:</span>
                <span class="font-bold text-blue-600 text-right">1.42 GB (Terenkripsi)</span>
              </div>
              <div class="flex items-start justify-between gap-3">
                <span class="text-slate-500">Titik Redundansi Retensi:</span>
                <span class="text-right font-semibold text-slate-700">AWS S3 (Jakarta ap-southeast-3)<br><span class="text-slate-500 font-normal">NAS Lokal DC Cakung (Synology)</span></span>
              </div>
            </div>
            <button class="ai-btn ai-btn-soft w-full mt-4" id="btnBackup"><i class="fas fa-cloud-download-alt text-base "></i>Buat Backup Manual Sekarang</button>
            <div id="backupProgress" class="mt-3" style="display:none">
              <div class="flex justify-between text-[11px] font-semibold text-slate-500 mb-1"><span>Proses kompresi &amp; enkripsi arsip...</span><span id="backupPct">0%</span></div>
              <div class="ai-bar"><span id="backupBar" class="bg-blue-600"></span></div>
            </div>
          </div>

          <!-- Zona Bahaya & Intervensi -->
          <div class="ai-card p-5 ai-reveal border-red-200" data-delay="220">
            <div class="flex items-center gap-2.5 mb-1.5">
              <i class="fas fa-triangle-exclamation text-lg text-red-500"></i>
              <h3 class="text-[15px] font-bold text-red-600">Zona Bahaya &amp; Intervensi</h3>
            </div>
            <p class="text-[12px] text-slate-500 mb-4 leading-relaxed">Tindakan berikut berdampak langsung pada operasional penerimaan dan pengeluaran fisik gudang.</p>
            <div class="space-y-2.5">
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800">Freeze Transaksi Gudang</div>
                  <div class="text-[11.5px] text-slate-500 mt-0.5">Kunci mutasi untuk Stock Opname Massal</div>
                </div>
                <button class="ai-btn ai-btn-danger flex-none" data-toast="Peringatan: Freeze transaksi memerlukan otorisasi dua langkah!" data-toast-type="danger">Kunci</button>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800">Putuskan Sesi Terminal</div>
                  <div class="text-[11.5px] text-slate-500 mt-0.5">Paksa refresh 18 sesi operator aktif</div>
                </div>
                <button class="ai-btn ai-btn-secondary flex-none" data-toast="Semua sesi terminal operator diputuskan." data-toast-type="warn">Putuskan</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ===== 3 kartu bawah ===== -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
        <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="100">
          <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center mb-4"><i class="fas fa-code text-lg text-slate-600"></i></div>
          <h3 class="text-[15px] font-bold text-slate-800">Dokumentasi SOP &amp; API WMS</h3>
          <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Kelola token Webhook sinkronisasi WMS pihak ketiga, integrasi armada ekspedisi, dan portal inventaris B2B mitra.</p>
          <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Portal Developer dibuka (demo)." data-toast-type="info">Akses Portal Developer <i class="fas fa-arrow-right text-base "></i></button>
        </div>
        <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="160">
          <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center mb-4"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
          <h3 class="text-[15px] font-bold text-slate-800">Audit &amp; Kepatuhan Konfigurasi</h3>
          <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Setiap penyesuaian parameter dan batas stok tercatat otomatis dalam audit trail forensik SHA-256 yang memenuhi standar ISO 27001.</p>
          <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Laporan Audit Trail (SHA-256) diunduh." data-toast-type="success">Unduh Laporan Audit Trail <i class="fas fa-download text-base "></i></button>
        </div>
        <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="220">
          <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mb-4"><i class="fas fa-headset text-lg text-emerald-600"></i></div>
          <h3 class="text-[15px] font-bold text-slate-800">Dukungan Teknis Operasional</h3>
          <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Bantuan penanganan insiden infrastruktur gudang 24/7 dengan jaminan respon SLA &lt;15 menit langsung dari Command Center.</p>
          <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Tiket eskalasi IT dibuat — SLA respon &lt;15 menit." data-toast-type="success">Buka Tiket Eskalasi IT <i class="fas fa-external-link-alt text-base "></i></button>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 2 — ATURAN INVENTARIS & STOK (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="stok" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-clipboard-list text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Reorder Point &amp; Safety Stock</h2>
              <p class="text-[12px] text-slate-500">Ambang ROP otomatis per kategori barang.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div>
              <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Perhitungan ROP Default</label>
              <select class="ai-input"><option>(Rata-rata Harian × Lead Time) + Safety Stock</option><option>Min-Max Manual per SKU</option><option>Konsumsi 30 Hari Terakhir</option></select>
            </div>
            <div>
              <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Lead Time Default Supplier Tier-1 (Hari)</label>
              <input class="ai-input" value="7">
            </div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3">
              <div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Notifikasi Stok Kritis ke WhatsApp Dispatcher</div><div class="text-[11.5px] text-slate-500">Kirim alert saat stok menyentuh 80% nilai ROP.</div></div>
              <div class="ai-switch ai-on"></div>
            </div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-circle text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Batch, ED &amp; Satuan Ukur</h2>
              <p class="text-[12px] text-slate-500">Kebijakan pelacakan lot dan konversi satuan.</p>
            </div>
          </div>
          <div class="space-y-3">
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Wajib Nomor Batch &amp; Tanggal Kedaluwarsa</div><div class="text-[11.5px] text-slate-500">Untuk kategori FMCG &amp; obat-obatan.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Blokir Keluar Barang ED &lt; 90 Hari</div><div class="text-[11.5px] text-slate-500">Butuh override Super Admin.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Izinkan Stok Negara Sementara (In-Transit)</div><div class="text-[11.5px] text-slate-500">Mutasi antar-hub belum diterima fisik.</div></div><div class="ai-switch"></div></div>
            <button class="ai-btn ai-btn-primary w-full" data-toast="Aturan inventaris tersimpan."><i class="fas fa-save text-base "></i>Simpan Aturan Inventaris</button>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 3 — PERANGKAT & PRINTER BARCODE (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="printer" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-print text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Default Template Label</h2>
              <p class="text-[12px] text-slate-500">Format cetak barcode pallet &amp; bin tag.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Ukuran Label</label><select class="ai-input"><option>100 x 50 mm (Standar Pallet)</option><option>75 x 50 mm (Bin Tag)</option><option>60 x 40 mm (Item Kecil)</option></select></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Symbology Barcode</label><select class="ai-input"><option>Code 128 (Rekomendasi)</option><option>QR Code 2D</option><option>Code 39</option></select></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Jumlah Salinan Otomatis per DO</label><input class="ai-input" value="2"></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-barcode text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Pengaturan Scanner Armada</h2>
              <p class="text-[12px] text-slate-500">Zebra TC21 • 24 perangkat terdaftar.</p>
            </div>
          </div>
          <div class="space-y-3">
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Suara Konfirmasi Scan Berhasil</div><div class="text-[11.5px] text-slate-500">Feedback audio di seluruh armada.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Auto-Sync Offline Queue</div><div class="text-[11.5px] text-slate-500">Sinkron otomatis saat sinyal WiFi 6 kembali.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Mode Hemat Baterai Shift Malam</div><div class="text-[11.5px] text-slate-500">Aktif 22:00 - 06:00 WIB.</div></div><div class="ai-switch"></div></div>
            <div class="flex gap-2">
              <button class="ai-btn ai-btn-primary flex-1" data-toast="Pengaturan printer & scanner tersimpan."><i class="fas fa-save text-base "></i>Simpan</button>
              <button class="ai-btn ai-btn-secondary flex-1" data-toast="Test label dikirim ke Zebra ZD230 (Dock Inbound 01)." data-toast-type="info"><i class="fas fa-print text-base "></i>Test Print</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 4 — INTEGRASI ERP & API (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="erp" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-exchange-alt text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Koneksi SAP S/4HANA</h2>
              <p class="text-[12px] text-slate-500">RFC Destination • Status: RFC OK (2 mnt lalu).</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Endpoint Host</label><input class="ai-input font-mono" value="sapgw.astro-inventory.co.id:3300"></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Client / System ID</label><input class="ai-input font-mono" value="100 / PRD-DCG"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Sync Master SKU Dua Arah</div><div class="text-[11.5px] text-slate-500">Perubahan master data ikut ke SAP.</div></div><div class="ai-switch ai-on"></div></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-key text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">API Key &amp; Webhook</h2>
              <p class="text-[12px] text-slate-500">Token integrasi mitra ekspedisi &amp; B2B.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Production API Key</label><div class="relative"><input class="ai-input pr-10 font-mono" type="password" value="«redacted:sk_live_...»" readonly><i class="fas fa-eye text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2"></i></div></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Webhook URL Mutasi Stok</label><input class="ai-input font-mono" value="https://hooks.astro-logistics.id/wms/mutation"></div>
            <div class="flex gap-2">
              <button class="ai-btn ai-btn-primary flex-1" data-toast="Konfigurasi integrasi ERP & API tersimpan."><i class="fas fa-save text-base "></i>Simpan</button>
              <button class="ai-btn ai-btn-secondary flex-1" data-toast="API Key baru digenerate — token lama dicabut." data-toast-type="warn"><i class="fas fa-undo text-base "></i>Regenerate Key</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 5 — KEAMANAN & KEBIJAKAN SESI (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="keamanan" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Kebijakan Sesi Pengguna</h2>
              <p class="text-[12px] text-slate-500">Berlaku untuk seluruh role di Hub Cakung DC-01.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Timeout Sesi Idle (Menit)</label><input class="ai-input" value="30"></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Maksimal Percobaan Login Gagal</label><input class="ai-input" value="5"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Wajib 2FA untuk Semua Role</div><div class="text-[11.5px] text-slate-500">TOTP atau kunci fisik FIDO2.</div></div><div class="ai-switch ai-on"></div></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-lock text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Whitelist IP &amp; Akses Jarak Jauh</h2>
              <p class="text-[12px] text-slate-500">Pembatasan akses panel admin.</p>
            </div>
          </div>
          <div class="space-y-3">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Rentang IP Diizinkan (CIDR)</label><input class="ai-input font-mono" value="182.253.110.0/24, 10.240.0.0/16"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Blokir Akses di Luar Jam Operasional</div><div class="text-[11.5px] text-slate-500">Panel admin terkunci 23:00 - 05:00 WIB.</div></div><div class="ai-switch"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Audit Forensik Klik Kritis</div><div class="text-[11.5px] text-slate-500">Ledger SHA-256 untuk approval &amp; mutasi.</div></div><div class="ai-switch ai-on"></div></div>
            <button class="ai-btn ai-btn-primary w-full" data-toast="Kebijakan keamanan tersimpan."><i class="fas fa-save text-base "></i>Simpan Kebijakan Keamanan</button>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 6 — BACKUP & PEMULIHAN (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="backup" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-cloud text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Penjadwalan Backup</h2>
              <p class="text-[12px] text-slate-500">Snapshot SQL + Blob terenkripsi AES-256.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Ekspresi CRON</label><input class="ai-input font-mono" value="0 3 * * *"></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Retensi Snapshot (Hari)</label><input class="ai-input" value="90"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Replikasi ke AWS S3 Jakarta</div><div class="text-[11.5px] text-slate-500">ap-southeast-3 • versi objek aktif.</div></div><div class="ai-switch ai-on"></div></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-hdd text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Titik Pemulihan Tersedia</h2>
              <p class="text-[12px] text-slate-500">Snapshot terverifikasi 30 hari terakhir.</p>
            </div>
          </div>
          <div class="ai-table w-full text-[12.5px]">
            <table class="w-full">
              <thead><tr><th class="text-left rounded-tl-lg">Snapshot</th><th class="text-left">Ukuran</th><th class="text-left rounded-tr-lg">Aksi</th></tr></thead>
              <tbody>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Hari ini, 03:00 WIB</td><td class="py-2.5 text-slate-500">1.42 GB</td><td class="py-2.5"><button class="text-[12px] font-bold text-blue-600" data-toast="Mode restore dibuka — konfirmasi dua langkah diperlukan." data-toast-type="warn">Restore</button></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Kemarin, 03:00 WIB</td><td class="py-2.5 text-slate-500">1.40 GB</td><td class="py-2.5"><button class="text-[12px] font-bold text-blue-600" data-toast="Mode restore dibuka — konfirmasi dua langkah diperlukan." data-toast-type="warn">Restore</button></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">2 hari lalu, 03:00 WIB</td><td class="py-2.5 text-slate-500">1.38 GB</td><td class="py-2.5"><button class="text-[12px] font-bold text-blue-600" data-toast="Mode restore dibuka — konfirmasi dua langkah diperlukan." data-toast-type="warn">Restore</button></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

        <!-- ===== Modal Log Perubahan ===== -->
  <div id="modalLog" class="modal-overlay">
    <div class="modal-box p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-[16px] font-bold text-slate-800 flex items-center gap-2"><i class="fas fa-history text-lg text-blue-600"></i>Log Perubahan Konfigurasi</h3>
        <button data-modal-close class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-500"><i class="fas fa-times text-base "></i></button>
      </div>
      <div class="space-y-2.5 text-[12.5px]">
        <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center justify-between gap-3"><div><div class="font-bold text-slate-800">Wewenang Mutasi diubah Rp 50 Juta → Rp 100 Juta</div><div class="text-slate-500 text-[11.5px]">Budi Santoso • Hari ini 09:14 WIB</div></div><span class="ai-badge bg-blue-50 text-blue-700 flex-none">SHA:81ac02</span></div>
        <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center justify-between gap-3"><div><div class="font-bold text-slate-800">Ambang Dead Stock digeser &gt; 60 → &gt; 90 Hari</div><div class="text-slate-500 text-[11.5px]">Budi Santoso • 2 hari lalu</div></div><span class="ai-badge bg-blue-50 text-blue-700 flex-none">SHA:4de911</span></div>
        <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center justify-between gap-3"><div><div class="font-bold text-slate-800">Jadwal Backup CRON diubah ke 0 3 * * *</div><div class="text-slate-500 text-[11.5px]">Sistem • 12 hari lalu</div></div><span class="ai-badge bg-slate-100 text-slate-600 flex-none">SHA:0b7f5a</span></div>
      </div>
      <button class="ai-btn ai-btn-secondary w-full mt-5" data-modal-close>Tutup</button>
    </div>
  </div>
        @endif

        @if(auth()->user()->isHR())
        <!-- ===== Breadcrumb + versi sistem ===== -->
    <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
      <div class="flex items-center gap-2 text-sm text-gray-500 mb-4 overflow-x-auto whitespace-nowrap anim-fade-in">
        <span>Beranda</span><i class="fas fa-chevron-right text-xs"></i>
        <span>Pengaturan &amp; Akun</span><i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-900 font-medium">Pengaturan</span>
    </div>
      <div class="ai-badge bg-white border border-slate-200 text-slate-500 shadow-sm">
        <span class="ai-live-dot"></span>
        <span class="text-emerald-600">SISTEM OPTIMAL</span>
        <span class="text-slate-300">•</span>
        <span>VERSI 4.2.0-LTS</span>
        <span class="font-mono font-semibold text-slate-400">SHA:8f92af</span>
      </div>
    </div>

    <!-- ===== Header card ===== -->
    <div class="ai-card ai-card-hover p-5 md:p-6 mb-5 ai-reveal flex flex-col lg:flex-row lg:items-center gap-5">
      <div class="flex items-start gap-4 flex-1">
        <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
          <i class="fas fa-sliders-h text-xl text-blue-600"></i>
        </div>
        <div>
          <h1 class="text-[22px] md:text-2xl font-extrabold text-slate-800 leading-tight">Pengaturan Akun &amp; Preferensi HR Approver</h1>
          <p class="text-[13px] text-slate-500 mt-1 max-w-xl leading-relaxed">Kelola preferensi alur persetujuan HR, notifikasi otorisasi, keamanan sesi, dan integrasi perangkat sistem terminal logistik.</p>
        </div>
      </div>
      <div class="flex flex-wrap items-center gap-2.5 flex-none">
        <button class="ai-btn ai-btn-secondary" id="btnReset"><i class="fas fa-undo text-base "></i>Kembalikan Default</button>
        <button class="ai-btn ai-btn-secondary" data-modal-open="modalLog"><i class="fas fa-history text-base "></i>Lihat Log Perubahan</button>
        <button class="ai-btn ai-btn-primary" id="btnSimpan"><i class="fas fa-check-circle text-base "></i>Simpan Perubahan</button>
      </div>
    </div>

    <!-- ===== Tab nomor ===== -->
    <div data-tabs="pengaturan" class="flex gap-2 overflow-x-auto pb-1 mb-5 ai-reveal" data-delay="80">
      <button class="ai-pill ai-pill-active" data-tab="umum"><i class="fas fa-sliders-h text-base "></i>1. Umum &amp; Profil Hub</button>
      <button class="ai-pill" data-tab="stok"><i class="fas fa-clipboard-list text-base "></i>2. Aturan Inventaris &amp; Stok</button>
      <button class="ai-pill" data-tab="printer"><i class="fas fa-print text-base "></i>3. Perangkat &amp; Printer Barcode</button>
      <button class="ai-pill" data-tab="erp"><i class="fas fa-exchange-alt text-base "></i>4. Integrasi ERP &amp; API</button>
      <button class="ai-pill" data-tab="keamanan"><i class="fas fa-shield-alt text-base "></i>5. Keamanan &amp; Kebijakan Sesi</button>
      <button class="ai-pill" data-tab="backup"><i class="fas fa-cloud text-base "></i>6. Backup &amp; Pemulihan</button>
    </div>

    <!-- ============================================================
         PANEL 1 — UMUM & PROFIL HUB (sesuai desain)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="umum">
      <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        <!-- ===== Kolom kiri ===== -->
        <div class="xl:col-span-2 space-y-5">

          <!-- Informasi Identitas & Hub Operasional -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="100">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                  <i class="fas fa-warehouse text-lg text-blue-600"></i>
                </div>
                <div>
                  <h2 class="text-[16px] font-bold text-slate-800">Identitas &amp; Otorisasi Approver HR</h2>
                  <p class="text-[12.5px] text-slate-500 mt-0.5">Data unit HR, wewenang persetujuan, dan kontak darurat otorisasi logistik.</p>
                </div>
              </div>
              <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100 font-mono">ID: HR001-DC01</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Nama Hub Distribusi</label>
                <div class="relative">
                  <i class="fas fa-circle text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="Hub Cakung DC-01 Utama">
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kode Fasilitas (DC Code)</label>
                <div class="relative">
                  <i class="fas fa-qrcode text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9 font-mono" value="HR-DC01">
                </div>
              </div>
              <div class="md:col-span-2">
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Alamat Fisik Gudang &amp; Titik Bongkar Muat</label>
                <div class="relative">
                  <i class="fas fa-map-marker-alt text-base text-slate-400 absolute left-3 top-4 -translate-y-1/2"></i>
                  <textarea class="ai-input pl-9 min-h-[64px] resize-none leading-relaxed">Kawasan Industri Pulogadung - Cakung Logistics Park Blok B3 No. 12-14, RW02, Cakung Timur, Jakarta Timur 13910</textarea>
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Zona Waktu Sistem Operasional</label>
                <div class="relative">
                  <i class="fas fa-globe text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <select class="ai-input pl-9 appearance-none">
                    <option>Asia/Jakarta (WIB - UTC+07:00)</option>
                    <option>Asia/Makassar (WITA - UTC+08:00)</option>
                    <option>Asia/Jayapura (WIT - UTC+09:00)</option>
                  </select>
                  <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Email Dispatcher Operasional</label>
                <div class="relative">
                  <i class="fas fa-envelope text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="hr4.approver@astro.co.id">
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Hotline Dispatch &amp; PIC Supervisor</label>
                <div class="relative">
                  <i class="fas fa-phone text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="+62 21 460-9981 (Ext. 105)">
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kapasitas Staging &amp; Bay Penampungan</label>
                <div class="relative">
                  <i class="fas fa-th-large text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="12 Antrean Persetujuan / Shift">
                </div>
              </div>
            </div>
          </div>

          <!-- Parameter Operasional & Ambang Batas Stok -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="150">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                  <i class="fas fa-chart-line text-lg text-blue-600"></i>
                </div>
                <div>
                  <h2 class="text-[16px] font-bold text-slate-800">Ambang Batas &amp; Delegasi Persetujuan</h2>
                  <p class="text-[12.5px] text-slate-500 mt-0.5">Kontrol batas nominal wewenang mandiri HR dan pendelegasian eskalasi otomatis.</p>
                </div>
              </div>
              <span class="ai-badge bg-slate-100 text-slate-600 border border-slate-200">Aktif Otomatis</span>
            </div>

            <div class="space-y-4">
              <!-- Slider buffer stock -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                <div class="flex flex-wrap items-start justify-between gap-3">
                  <div>
                    <div class="text-[13.5px] font-bold text-slate-800">Formula Buffer Stock Default (% Safety Stock dari Lead Time)</div>
                    <div class="text-[12px] text-slate-500 mt-0.5">Kompensasi fluktuasi pasokan supplier tier-1 &amp; keterlambatan ekspedisi lintas pulau.</div>
                  </div>
                  <div class="text-2xl font-extrabold text-blue-600"><span id="bufferVal">25</span>%</div>
                </div>
                <input type="range" id="bufferSlider" min="5" max="50" step="5" value="25" class="w-full mt-4 accent-blue-600 cursor-pointer">
                <div class="flex justify-between mt-1.5 text-[10.5px] font-semibold text-slate-400">
                  <span>5% (Konservatif)</span>
                  <span class="hidden sm:inline">15% (Rekomendasi FMCG)</span>
                  <span class="text-blue-600">25% (Aktif - High Velocity)</span>
                  <span>50% (Seasonal Peak)</span>
                </div>
              </div>

              <!-- Dead stock -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col md:flex-row md:items-center gap-4">
                <div class="flex-1">
                  <div class="text-[13.5px] font-bold text-slate-800">Ambang Batas Penandaan Dead Stock (Barang Mengendap)</div>
                  <div class="text-[12px] text-slate-500 mt-0.5 leading-relaxed">Barang tanpa pergerakan mutasi keluar akan ditandai untuk diskon likuidasi atau retur vendor.</div>
                </div>
                <div class="flex flex-none rounded-xl bg-white border border-slate-200 p-1 gap-1" id="deadStockGroup">
                  <button class="dead-opt px-3.5 py-2 rounded-lg text-[12.5px] font-semibold text-slate-600 transition-all" data-dead="60">&gt; 60 Hari</button>
                  <button class="dead-opt px-3.5 py-2 rounded-lg text-[12.5px] font-semibold transition-all" data-dead="90">&gt; 90 Hari (Aktif)</button>
                  <button class="dead-opt px-3.5 py-2 rounded-lg text-[12.5px] font-semibold text-slate-600 transition-all" data-dead="180">&gt; 180 Hari</button>
                </div>
              </div>

              <!-- Otomatisasi persetujuan -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center flex-none">
                  <i class="fas fa-bolt text-lg text-amber-500"></i>
                </div>
                <div class="flex-1">
                  <div class="text-[13.5px] font-bold text-slate-800">Otomatisasi Persetujuan &lt; Rp 10.000.000</div>
                  <div class="text-[12px] text-slate-500 mt-0.5 leading-relaxed">Permintaan di bawah Rp 10 juta disetujui otomatis tanpa antrean manual Head of HR.</div>
                </div>
                <div class="ai-switch ai-on flex-none" id="swAutoApprove"></div>
              </div>

              <!-- Metode valuasi -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                <div class="flex flex-wrap items-start justify-between gap-2">
                  <div>
                    <div class="text-[13.5px] font-bold text-slate-800">Kebijakan Metode Valuasi &amp; Penjatahan Batch Inventaris</div>
                    <div class="text-[12px] text-slate-500 mt-0.5">Menentukan alokasi fisik barang di rak penyimpanan dan perhitungan COGS buku persediaan.</div>
                  </div>
                  <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100">Kepatuhan PSAK 14</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4" id="valuasiGroup">
                  <button class="valuasi-opt text-left rounded-xl border-2 p-4 transition-all bg-white" data-valuasi="fifo">
                    <div class="flex items-center gap-2.5 flex-wrap">
                      <span class="valuasi-dot w-5 h-5 rounded-full flex items-center justify-center flex-none bg-blue-600 text-white"><i class="fas fa-check-circle text-base "></i></span>
                      <span class="text-[13.5px] font-bold text-slate-800">FIFO (First In, First Out)</span>
                      <span class="ai-badge bg-blue-50 text-blue-700">Rekomendasi</span>
                    </div>
                    <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Barang dengan nomor batch dan tanggal masuk terlama diprioritaskan keluar terlebih dahulu untuk mencegah kadaluarsa.</p>
                  </button>
                  <button class="valuasi-opt text-left rounded-xl border-2 p-4 transition-all bg-slate-100/60" data-valuasi="avg">
                    <div class="flex items-center gap-2.5 flex-wrap">
                      <span class="valuasi-dot w-5 h-5 rounded-full flex items-center justify-center flex-none bg-slate-300 text-transparent"></span>
                      <span class="text-[13.5px] font-bold text-slate-800">Average Moving Cost</span>
                    </div>
                    <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Biaya perolehan dihitung rata-rata berbobot setiap ada batch penerimaan baru dari PO supplier.</p>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Integrasi Perangkat Keras -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="200">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                  <i class="fas fa-desktop text-lg text-blue-600"></i>
                </div>
                <div>
                  <h2 class="text-[16px] font-bold text-slate-800">Integrasi Perangkat Otorisasi (Hardware &amp; Scanners)</h2>
                  <p class="text-[12.5px] text-slate-500 mt-0.5">Monitoring perangkat approver, scanner dokumen, dan stasiun printer slip persetujuan.</p>
                </div>
              </div>
              <button class="ai-btn ai-btn-soft flex-none" data-toast="Pemindaian jaringan perangkat dimulai..." data-toast-type="info"><i class="fas fa-rotate text-base "></i>Scan Jaringan</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <!-- Scanner -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                <div class="flex items-start justify-between gap-2">
                  <div class="flex items-center gap-2.5">
                    <i class="fas fa-barcode text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13.5px] font-bold text-slate-800">Scanner Dokumen &amp; Approver</span>
                  </div>
                  <span class="ai-badge bg-emerald-100 text-emerald-700">4 Online</span>
                </div>
                <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Zebra ZD421 dan scanner dokumen HR aktif di Ruang Otorisasi DC-01.</p>
                <div class="flex items-center justify-between mt-4 text-[12px]">
                  <span class="font-semibold text-slate-600">Battery Health Armada Scanner</span>
                  <span class="font-extrabold text-slate-800">92% Rata-rata</span>
                </div>
                <div class="ai-bar mt-1.5" data-w="94"><span class="bg-emerald-500"></span></div>
                <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-200/70">
                  <span class="flex items-center gap-1.5 text-[11.5px] font-semibold text-slate-600"><span class="ai-live-dot"></span>WiFi 6 DC-IoT Mesh</span>
                  <button class="text-[12px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1" data-toast="Panel manajemen 24 perangkat scanner dibuka." data-toast-type="info">Kelola 4 Device <i class="fas fa-arrow-right text-sm "></i></button>
                </div>
              </div>

              <!-- Printer -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                <div class="flex items-start justify-between gap-2">
                  <div class="flex items-center gap-2.5">
                    <i class="fas fa-print text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13.5px] font-bold text-slate-800">Printer Dokumen Otorisasi</span>
                  </div>
                  <span class="ai-badge bg-emerald-100 text-emerald-700">Ready</span>
                </div>
                <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Canon LBP untuk cetak SPO, slip persetujuan, dan manifest otorisasi.</p>
                <div class="flex flex-wrap gap-2 mt-4">
                  <span class="text-[11px] font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 font-mono">IP: 192.168.10.61</span>
                  <span class="text-[11px] font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 font-mono">Port: 9100</span>
                  <span class="text-[11px] font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 font-mono">DPI: 600</span>
                </div>
                <div class="flex items-center justify-between mt-auto pt-4">
                  <span class="text-[12px] text-slate-500">Kertas Sisa: <span class="font-bold text-slate-700">~320 Lembar</span></span>
                  <button class="ai-btn ai-btn-primary" id="btnTestPrint"><i class="fas fa-print text-base "></i>Test Print Barcode</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== Kolom kanan ===== -->
        <div class="space-y-5">

          <!-- Status Layanan & Sync -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="120">
            <div class="flex items-center justify-between mb-4">
              <div class="flex items-center gap-2.5">
                <i class="fas fa-network-wired text-lg text-blue-600"></i>
                <h3 class="text-[15px] font-bold text-slate-800">Status Layanan &amp; Sync</h3>
              </div>
              <span class="ai-live-dot"></span>
            </div>
            <div class="space-y-2.5">
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-database text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">Antrean Persetujuan</div>
                  <div class="text-[11px] text-slate-500 truncate">12 pending • SLA 60 mnt</div>
                </div>
                <div class="text-right flex-none">
                  <span class="ai-badge bg-emerald-100 text-emerald-700 font-mono">12</span>
                  <div class="text-[11px] font-bold text-emerald-600 mt-1">Sehat</div>
                </div>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-cloud text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">Bot Telegram @astro_hr_bot</div>
                  <div class="text-[11px] text-slate-500 truncate">Ringkasan antrean real-time</div>
                </div>
                <div class="text-right flex-none">
                  <span class="ai-badge bg-blue-50 text-blue-700">TERHUBUNG</span>
                  <div class="text-[11px] text-slate-400 mt-1 font-medium">2 mnt lalu</div>
                </div>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-envelope text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">SMTP Email Kedinasan</div>
                  <div class="text-[11px] text-slate-500 truncate">Notifikasi otorisasi &amp; approval</div>
                </div>
                <span class="ai-badge bg-emerald-100 text-emerald-700 flex-none">Aktif</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-comment-dots text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">Log Audit &amp; Otorisasi</div>
                  <div class="text-[11px] text-slate-500 truncate">Ledger SHA-256 kepatuhan</div>
                </div>
                <span class="ai-badge bg-emerald-100 text-emerald-700 flex-none">Terhubung</span>
              </div>
            </div>
            <button class="ai-btn ai-btn-secondary w-full mt-4" data-toast="Diagnostik jaringan penuh sedang berjalan — hasil dalam ~30 detik." data-toast-type="info">Cek Diagnostik Jaringan Penuh</button>
          </div>

          <!-- Jadwal Backup Otomatis -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="170">
            <div class="flex items-center justify-between gap-2 mb-4">
              <div class="flex items-center gap-2.5">
                <i class="fas fa-cloud text-lg text-blue-600"></i>
                <h3 class="text-[15px] font-bold text-slate-800">Jadwal Backup Otomatis</h3>
              </div>
              <span class="text-[10.5px] font-bold text-slate-400 font-mono tracking-tight">CRON: 0 3 * * *</span>
            </div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 space-y-2.5 text-[12.5px]">
              <div class="flex items-start justify-between gap-3">
                <span class="text-slate-500">Backup Snapshot Terakhir:</span>
                <span class="font-bold text-slate-800 text-right">Hari ini, 03:00 WIB</span>
              </div>
              <div class="flex items-start justify-between gap-3">
                <span class="text-slate-500">Ukuran Arsip SQL + Blob:</span>
                <span class="font-bold text-blue-600 text-right">1.42 GB (Terenkripsi)</span>
              </div>
              <div class="flex items-start justify-between gap-3">
                <span class="text-slate-500">Titik Redundansi Retensi:</span>
                <span class="text-right font-semibold text-slate-700">AWS S3 (Jakarta ap-southeast-3)<br><span class="text-slate-500 font-normal">NAS Lokal DC Cakung (Synology)</span></span>
              </div>
            </div>
            <button class="ai-btn ai-btn-soft w-full mt-4" id="btnBackup"><i class="fas fa-cloud-download-alt text-base "></i>Buat Backup Manual Sekarang</button>
            <div id="backupProgress" class="mt-3" style="display:none">
              <div class="flex justify-between text-[11px] font-semibold text-slate-500 mb-1"><span>Proses kompresi &amp; enkripsi arsip...</span><span id="backupPct">0%</span></div>
              <div class="ai-bar"><span id="backupBar" class="bg-blue-600"></span></div>
            </div>
          </div>

          <!-- Zona Bahaya & Intervensi -->
          <div class="ai-card p-5 ai-reveal border-red-200" data-delay="220">
            <div class="flex items-center gap-2.5 mb-1.5">
              <i class="fas fa-triangle-exclamation text-lg text-red-500"></i>
              <h3 class="text-[15px] font-bold text-red-600">Zona Bahaya &amp; Intervensi</h3>
            </div>
            <p class="text-[12px] text-slate-500 mb-4 leading-relaxed">Tindakan berikut berdampak langsung pada operasional penerimaan dan pengeluaran fisik gudang.</p>
            <div class="space-y-2.5">
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800">Freeze Antrean Persetujuan</div>
                  <div class="text-[11.5px] text-slate-500 mt-0.5">Kunci antrean approval untuk rekonsiliasi akhir bulan</div>
                </div>
                <button class="ai-btn ai-btn-danger flex-none" data-toast="Peringatan: Freeze antrean memerlukan otorisasi dua langkah!" data-toast-type="danger">Kunci</button>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800">Hapus Cache Sesi HR</div>
                  <div class="text-[11.5px] text-slate-500 mt-0.5">Paksa refresh sesi admin HR aktif</div>
                </div>
                <button class="ai-btn ai-btn-secondary flex-none" data-toast="Cache Sesi HR berhasil di-flush." data-toast-type="warn">Flush</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ===== 3 kartu bawah ===== -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
        <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="100">
          <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center mb-4"><i class="fas fa-code text-lg text-slate-600"></i></div>
          <h3 class="text-[15px] font-bold text-slate-800">Dokumentasi SOP HR &amp; API</h3>
          <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Kelola token Webhook sinkronisasi otorisasi dan integrasi portal kepatuhan.</p>
          <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Portal Developer dibuka (demo)." data-toast-type="info">Akses Portal Developer <i class="fas fa-arrow-right text-base "></i></button>
        </div>
        <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="160">
          <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center mb-4"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
          <h3 class="text-[15px] font-bold text-slate-800">Audit &amp; Kepatuhan Konfigurasi</h3>
          <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Setiap penyesuaian parameter persetujuan tercatat otomatis dalam audit trail forensik SHA-256 yang memenuhi standar ISO 27001.</p>
          <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Laporan Audit Trail (SHA-256) diunduh." data-toast-type="success">Unduh Laporan Audit Trail <i class="fas fa-download text-base "></i></button>
        </div>
        <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="220">
          <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mb-4"><i class="fas fa-headset text-lg text-emerald-600"></i></div>
          <h3 class="text-[15px] font-bold text-slate-800">Dukungan Teknis Enterprise</h3>
          <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Bantuan penanganan insiden infrastruktur 24/7 dengan jaminan respon SLA &lt;15 menit langsung dari Command Center.</p>
          <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Tiket eskalasi IT dibuat — SLA respon &lt;15 menit." data-toast-type="success">Buka Tiket Eskalasi IT <i class="fas fa-external-link-alt text-base "></i></button>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 2 — ATURAN INVENTARIS & STOK (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="stok" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-clipboard-list text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Batas Otorisasi &amp; SLA Persetujuan</h2>
              <p class="text-[12px] text-slate-500">Ambang SLA otorisasi per kategori persetujuan.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div>
              <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Perhitungan ROP Default</label>
              <select class="ai-input"><option>Auto-Eskalasi setelah SLA 60 Menit</option><option>Min-Max Manual per SKU</option><option>Konsumsi 30 Hari Terakhir</option></select>
            </div>
            <div>
              <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Batas SLA Persetujuan (Menit)</label>
              <input class="ai-input" value="60">
            </div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3">
              <div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Notifikasi SLA ke WhatsApp Dispatcher</div><div class="text-[11.5px] text-slate-500">Kirim alert saat tiket mendekati batas SLA.</div></div>
              <div class="ai-switch ai-on"></div>
            </div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-circle text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Batch, ED &amp; Satuan Ukur</h2>
              <p class="text-[12px] text-slate-500">Kebijakan pelacakan lot dan konversi satuan.</p>
            </div>
          </div>
          <div class="space-y-3">
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Wajib Nomor Batch &amp; Tanggal Kedaluwarsa</div><div class="text-[11.5px] text-slate-500">Untuk kategori FMCG &amp; obat-obatan.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Blokir Keluar Barang ED &lt; 90 Hari</div><div class="text-[11.5px] text-slate-500">Butuh override Super Admin.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Izinkan Stok Negara Sementara (In-Transit)</div><div class="text-[11.5px] text-slate-500">Mutasi antar-hub belum diterima fisik.</div></div><div class="ai-switch"></div></div>
            <button class="ai-btn ai-btn-primary w-full" data-toast="Aturan inventaris tersimpan."><i class="fas fa-save text-base "></i>Simpan Aturan Inventaris</button>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 3 — PERANGKAT & PRINTER BARCODE (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="printer" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-print text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Template Dokumen Otorisasi</h2>
              <p class="text-[12px] text-slate-500">Format cetak SPO, slip persetujuan, dan manifest.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Ukuran Label</label><select class="ai-input"><option>A4 (SPO &amp; Manifest)</option><option>75 x 50 mm (Bin Tag)</option><option>60 x 40 mm (Item Kecil)</option></select></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Symbology Barcode</label><select class="ai-input"><option>Code 128 (Rekomendasi)</option><option>QR Code 2D</option><option>Code 39</option></select></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Jumlah Salinan Otomatis per Persetujuan</label><input class="ai-input" value="1"></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-barcode text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Pengaturan Perangkat Approver</h2>
              <p class="text-[12px] text-slate-500">Zebra ZD421 • 4 perangkat terdaftar.</p>
            </div>
          </div>
          <div class="space-y-3">
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Suara Konfirmasi Scan Berhasil</div><div class="text-[11.5px] text-slate-500">Feedback audio di seluruh armada.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Auto-Sync Offline Queue</div><div class="text-[11.5px] text-slate-500">Sinkron otomatis saat sinyal WiFi 6 kembali.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Mode Hemat Baterai Shift Malam</div><div class="text-[11.5px] text-slate-500">Aktif 22:00 - 06:00 WIB.</div></div><div class="ai-switch"></div></div>
            <div class="flex gap-2">
              <button class="ai-btn ai-btn-primary flex-1" data-toast="Pengaturan printer & scanner tersimpan."><i class="fas fa-save text-base "></i>Simpan</button>
              <button class="ai-btn ai-btn-secondary flex-1" data-toast="Test label dikirim ke Zebra ZD230 (Dock Inbound 01)." data-toast-type="info"><i class="fas fa-print text-base "></i>Test Print</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 4 — INTEGRASI ERP & API (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="erp" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-exchange-alt text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Koneksi Portal HR &amp; WMS</h2>
              <p class="text-[12px] text-slate-500">RFC Destination • Status: RFC OK (2 mnt lalu).</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Endpoint Host</label><input class="ai-input font-mono" value="hrgw.astro-inventory.co.id:3300"></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Client / System ID</label><input class="ai-input font-mono" value="100 / PRD-HR"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Sync Data Approval Dua Arah</div><div class="text-[11.5px] text-slate-500">Perubahan otorisasi ikut ke portal HR.</div></div><div class="ai-switch ai-on"></div></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-key text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">API Key &amp; Webhook</h2>
              <p class="text-[12px] text-slate-500">Token integrasi mitra ekspedisi &amp; B2B.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Production API Key</label><div class="relative"><input class="ai-input pr-10 font-mono" type="password" value="«redacted:sk_live_...»" readonly><i class="fas fa-eye text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2"></i></div></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Webhook URL Mutasi Stok</label><input class="ai-input font-mono" value="https://hooks.astro-logistics.id/hr/approval"></div>
            <div class="flex gap-2">
              <button class="ai-btn ai-btn-primary flex-1" data-toast="Konfigurasi integrasi ERP & API tersimpan."><i class="fas fa-save text-base "></i>Simpan</button>
              <button class="ai-btn ai-btn-secondary flex-1" data-toast="API Key baru digenerate — token lama dicabut." data-toast-type="warn"><i class="fas fa-undo text-base "></i>Regenerate Key</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 5 — KEAMANAN & KEBIJAKAN SESI (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="keamanan" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Kebijakan Sesi Pengguna</h2>
              <p class="text-[12px] text-slate-500">Berlaku untuk seluruh role di Hub Cakung DC-01.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Timeout Sesi Idle (Menit)</label><input class="ai-input" value="30"></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Maksimal Percobaan Login Gagal</label><input class="ai-input" value="5"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Wajib 2FA untuk Approval Kritis</div><div class="text-[11.5px] text-slate-500">TOTP untuk persetujuan di atas plafon mandiri.</div></div><div class="ai-switch ai-on"></div></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-lock text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Whitelist IP &amp; Akses Jarak Jauh</h2>
              <p class="text-[12px] text-slate-500">Pembatasan akses panel HR.</p>
            </div>
          </div>
          <div class="space-y-3">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Rentang IP Diizinkan (CIDR)</label><input class="ai-input font-mono" value="182.253.110.0/24, 10.240.0.0/16"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Blokir Akses di Luar Jam Operasional</div><div class="text-[11.5px] text-slate-500">Panel admin terkunci 23:00 - 05:00 WIB.</div></div><div class="ai-switch"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Audit Forensik Klik Kritis</div><div class="text-[11.5px] text-slate-500">Ledger SHA-256 untuk approval &amp; mutasi.</div></div><div class="ai-switch ai-on"></div></div>
            <button class="ai-btn ai-btn-primary w-full" data-toast="Kebijakan keamanan tersimpan."><i class="fas fa-save text-base "></i>Simpan Kebijakan Keamanan</button>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 6 — BACKUP & PEMULIHAN (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="backup" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-cloud text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Penjadwalan Backup</h2>
              <p class="text-[12px] text-slate-500">Snapshot SQL + Blob terenkripsi AES-256.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Ekspresi CRON</label><input class="ai-input font-mono" value="0 3 * * *"></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Retensi Snapshot (Hari)</label><input class="ai-input" value="90"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Replikasi ke AWS S3 Jakarta</div><div class="text-[11.5px] text-slate-500">ap-southeast-3 • versi objek aktif.</div></div><div class="ai-switch ai-on"></div></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-hdd text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Titik Pemulihan Tersedia</h2>
              <p class="text-[12px] text-slate-500">Snapshot terverifikasi 30 hari terakhir.</p>
            </div>
          </div>
          <div class="ai-table w-full text-[12.5px]">
            <table class="w-full">
              <thead><tr><th class="text-left rounded-tl-lg">Snapshot</th><th class="text-left">Ukuran</th><th class="text-left rounded-tr-lg">Aksi</th></tr></thead>
              <tbody>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Hari ini, 03:00 WIB</td><td class="py-2.5 text-slate-500">1.42 GB</td><td class="py-2.5"><button class="text-[12px] font-bold text-blue-600" data-toast="Mode restore dibuka — konfirmasi dua langkah diperlukan." data-toast-type="warn">Restore</button></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Kemarin, 03:00 WIB</td><td class="py-2.5 text-slate-500">1.40 GB</td><td class="py-2.5"><button class="text-[12px] font-bold text-blue-600" data-toast="Mode restore dibuka — konfirmasi dua langkah diperlukan." data-toast-type="warn">Restore</button></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">2 hari lalu, 03:00 WIB</td><td class="py-2.5 text-slate-500">1.38 GB</td><td class="py-2.5"><button class="text-[12px] font-bold text-blue-600" data-toast="Mode restore dibuka — konfirmasi dua langkah diperlukan." data-toast-type="warn">Restore</button></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

        <!-- ===== Modal Log Perubahan ===== -->
  <div id="modalLog" class="modal-overlay">
    <div class="modal-box p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-[16px] font-bold text-slate-800 flex items-center gap-2"><i class="fas fa-history text-lg text-blue-600"></i>Log Perubahan Konfigurasi</h3>
        <button data-modal-close class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-500"><i class="fas fa-times text-base "></i></button>
      </div>
      <div class="space-y-2.5 text-[12.5px]">
        <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center justify-between gap-3"><div><div class="font-bold text-slate-800">Plafon Otorisasi HR diubah → Rp 100 Juta</div><div class="text-slate-500 text-[11.5px]">Siti Nurhaliza • Hari ini 09:14 WIB</div></div><span class="ai-badge bg-blue-50 text-blue-700 flex-none">SHA:81ac02</span></div>
        <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center justify-between gap-3"><div><div class="font-bold text-slate-800">SLA Persetujuan diubah 45 → 60 Menit</div><div class="text-slate-500 text-[11.5px]">Siti Nurhaliza • 2 hari lalu</div></div><span class="ai-badge bg-blue-50 text-blue-700 flex-none">SHA:4de911</span></div>
        <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center justify-between gap-3"><div><div class="font-bold text-slate-800">Jadwal Backup CRON diubah ke 0 3 * * *</div><div class="text-slate-500 text-[11.5px]">Sistem • 12 hari lalu</div></div><span class="ai-badge bg-slate-100 text-slate-600 flex-none">SHA:0b7f5a</span></div>
      </div>
      <button class="ai-btn ai-btn-secondary w-full mt-5" data-modal-close>Tutup</button>
    </div>
  </div>
        @endif

        @if(auth()->user()->isPegawai())
        <!-- ===== Breadcrumb + versi sistem ===== -->
    <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
      <div class="flex items-center gap-2 text-sm text-gray-500 mb-4 overflow-x-auto whitespace-nowrap anim-fade-in">
        <span>Beranda</span><i class="fas fa-chevron-right text-xs"></i>
        <span>Pengaturan &amp; Akun</span><i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-900 font-medium">Pengaturan</span>
    </div>
      <div class="ai-badge bg-white border border-slate-200 text-slate-500 shadow-sm">
        <span class="ai-live-dot"></span>
        <span class="text-emerald-600">SISTEM OPTIMAL</span>
        <span class="text-slate-300">•</span>
        <span>VERSI 4.2.0-LTS</span>
        <span class="font-mono font-semibold text-slate-400">SHA:8f92af</span>
      </div>
    </div>

    <!-- ===== Header card ===== -->
    <div class="ai-card ai-card-hover p-5 md:p-6 mb-5 ai-reveal flex flex-col lg:flex-row lg:items-center gap-5">
      <div class="flex items-start gap-4 flex-1">
        <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
          <i class="fas fa-sliders-h text-xl text-blue-600"></i>
        </div>
        <div>
          <h1 class="text-[22px] md:text-2xl font-extrabold text-slate-800 leading-tight">Pengaturan &amp; Konfigurasi Perangkat Staf</h1>
          <p class="text-[13px] text-slate-500 mt-1 max-w-xl leading-relaxed">Kelola konfigurasi pemindai barcode handheld, integrasi printer label thermal, preferensi audio, peringatan gudang, serta pengamanan sesi terminal shift.</p>
        </div>
      </div>
      <div class="flex flex-wrap items-center gap-2.5 flex-none">
        <button class="ai-btn ai-btn-secondary" id="btnReset"><i class="fas fa-undo text-base "></i>Kembalikan Default</button>
        <button class="ai-btn ai-btn-secondary" data-modal-open="modalLog"><i class="fas fa-history text-base "></i>Lihat Log Perubahan</button>
        <button class="ai-btn ai-btn-primary" id="btnSimpan"><i class="fas fa-check-circle text-base "></i>Simpan Perubahan</button>
      </div>
    </div>

    <!-- ===== Tab nomor ===== -->
    <div data-tabs="pengaturan" class="flex gap-2 overflow-x-auto pb-1 mb-5 ai-reveal" data-delay="80">
      <button class="ai-pill ai-pill-active" data-tab="umum"><i class="fas fa-sliders-h text-base "></i>1. Umum &amp; Profil Hub</button>
      <button class="ai-pill" data-tab="stok"><i class="fas fa-clipboard-list text-base "></i>2. Aturan Inventaris &amp; Stok</button>
      <button class="ai-pill" data-tab="printer"><i class="fas fa-print text-base "></i>3. Perangkat &amp; Printer Barcode</button>
      <button class="ai-pill" data-tab="erp"><i class="fas fa-exchange-alt text-base "></i>4. Integrasi ERP &amp; API</button>
      <button class="ai-pill" data-tab="keamanan"><i class="fas fa-shield-alt text-base "></i>5. Keamanan &amp; Kebijakan Sesi</button>
      <button class="ai-pill" data-tab="backup"><i class="fas fa-cloud text-base "></i>6. Backup &amp; Pemulihan</button>
    </div>

    <!-- ============================================================
         PANEL 1 — UMUM & PROFIL HUB (sesuai desain)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="umum">
      <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        <!-- ===== Kolom kiri ===== -->
        <div class="xl:col-span-2 space-y-5">

          <!-- Informasi Identitas & Hub Operasional -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="100">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                  <i class="fas fa-warehouse text-lg text-blue-600"></i>
                </div>
                <div>
                  <h2 class="text-[16px] font-bold text-slate-800">Identitas Terminal &amp; Profil Staf</h2>
                  <p class="text-[12.5px] text-slate-500 mt-0.5">Data perangkat terminal, zona penugasan, dan kontak operasional staf gudang.</p>
                </div>
              </div>
              <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100 font-mono">ID: STF-90214-ZBR</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Nama Hub Distribusi</label>
                <div class="relative">
                  <i class="fas fa-circle text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="Terminal Zebra TC21 - Staf Operasional">
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kode Fasilitas (DC Code)</label>
                <div class="relative">
                  <i class="fas fa-qrcode text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9 font-mono" value="STF-DC01">
                </div>
              </div>
              <div class="md:col-span-2">
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Alamat Fisik Gudang &amp; Titik Bongkar Muat</label>
                <div class="relative">
                  <i class="fas fa-map-marker-alt text-base text-slate-400 absolute left-3 top-4 -translate-y-1/2"></i>
                  <textarea class="ai-input pl-9 min-h-[64px] resize-none leading-relaxed">Zona A &amp; Staging Inbound, Hub Cakung DC-01</textarea>
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Zona Waktu Sistem Operasional</label>
                <div class="relative">
                  <i class="fas fa-globe text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <select class="ai-input pl-9 appearance-none">
                    <option>Asia/Jakarta (WIB - UTC+07:00)</option>
                    <option>Asia/Makassar (WITA - UTC+08:00)</option>
                    <option>Asia/Jayapura (WIT - UTC+09:00)</option>
                  </select>
                  <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Email Dispatcher Operasional</label>
                <div class="relative">
                  <i class="fas fa-envelope text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="agus.prasetyo@astroinventory.com">
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Hotline Dispatch &amp; PIC Supervisor</label>
                <div class="relative">
                  <i class="fas fa-phone text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="+62 812-9842-1102">
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kapasitas Staging &amp; Bay Penampungan</label>
                <div class="relative">
                  <i class="fas fa-th-large text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="500 Slot Cache Offline">
                </div>
              </div>
            </div>
          </div>

          <!-- Parameter Operasional & Ambang Batas Stok -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="150">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                  <i class="fas fa-chart-line text-lg text-blue-600"></i>
                </div>
                <div>
                  <h2 class="text-[16px] font-bold text-slate-800">Preferensi Terminal &amp; Pemindaian</h2>
                  <p class="text-[12.5px] text-slate-500 mt-0.5">Konfigurasi symbology barcode, mode pemicu scan, dan buffer transaksi offline.</p>
                </div>
              </div>
              <span class="ai-badge bg-slate-100 text-slate-600 border border-slate-200">Aktif Otomatis</span>
            </div>

            <div class="space-y-4">
              <!-- Slider buffer stock -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                <div class="flex flex-wrap items-start justify-between gap-3">
                  <div>
                    <div class="text-[13.5px] font-bold text-slate-800">Formula Buffer Stock Default (% Safety Stock dari Lead Time)</div>
                    <div class="text-[12px] text-slate-500 mt-0.5">Kompensasi fluktuasi pasokan supplier tier-1 &amp; keterlambatan ekspedisi lintas pulau.</div>
                  </div>
                  <div class="text-2xl font-extrabold text-blue-600"><span id="bufferVal">25</span>%</div>
                </div>
                <input type="range" id="bufferSlider" min="5" max="50" step="5" value="25" class="w-full mt-4 accent-blue-600 cursor-pointer">
                <div class="flex justify-between mt-1.5 text-[10.5px] font-semibold text-slate-400">
                  <span>5% (Konservatif)</span>
                  <span class="hidden sm:inline">15% (Rekomendasi FMCG)</span>
                  <span class="text-blue-600">25% (Aktif - High Velocity)</span>
                  <span>50% (Seasonal Peak)</span>
                </div>
              </div>

              <!-- Dead stock -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col md:flex-row md:items-center gap-4">
                <div class="flex-1">
                  <div class="text-[13.5px] font-bold text-slate-800">Ambang Batas Penandaan Dead Stock (Barang Mengendap)</div>
                  <div class="text-[12px] text-slate-500 mt-0.5 leading-relaxed">Barang tanpa pergerakan mutasi keluar akan ditandai untuk diskon likuidasi atau retur vendor.</div>
                </div>
                <div class="flex flex-none rounded-xl bg-white border border-slate-200 p-1 gap-1" id="deadStockGroup">
                  <button class="dead-opt px-3.5 py-2 rounded-lg text-[12.5px] font-semibold text-slate-600 transition-all" data-dead="60">&gt; 60 Hari</button>
                  <button class="dead-opt px-3.5 py-2 rounded-lg text-[12.5px] font-semibold transition-all" data-dead="90">&gt; 90 Hari (Aktif)</button>
                  <button class="dead-opt px-3.5 py-2 rounded-lg text-[12.5px] font-semibold text-slate-600 transition-all" data-dead="180">&gt; 180 Hari</button>
                </div>
              </div>

              <!-- Otomatisasi persetujuan -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center flex-none">
                  <i class="fas fa-bolt text-lg text-amber-500"></i>
                </div>
                <div class="flex-1">
                  <div class="text-[13.5px] font-bold text-slate-800">Auto-Print Label Saat Validasi</div>
                  <div class="text-[12px] text-slate-500 mt-0.5 leading-relaxed">Cetak otomatis label barcode setiap validasi penerimaan tanpa konfirmasi manual.</div>
                </div>
                <div class="ai-switch ai-on flex-none" id="swAutoApprove"></div>
              </div>

              <!-- Metode valuasi -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                <div class="flex flex-wrap items-start justify-between gap-2">
                  <div>
                    <div class="text-[13.5px] font-bold text-slate-800">Kebijakan Metode Valuasi &amp; Penjatahan Batch Inventaris</div>
                    <div class="text-[12px] text-slate-500 mt-0.5">Menentukan alokasi fisik barang di rak penyimpanan dan perhitungan COGS buku persediaan.</div>
                  </div>
                  <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100">Kepatuhan PSAK 14</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4" id="valuasiGroup">
                  <button class="valuasi-opt text-left rounded-xl border-2 p-4 transition-all bg-white" data-valuasi="fifo">
                    <div class="flex items-center gap-2.5 flex-wrap">
                      <span class="valuasi-dot w-5 h-5 rounded-full flex items-center justify-center flex-none bg-blue-600 text-white"><i class="fas fa-check-circle text-base "></i></span>
                      <span class="text-[13.5px] font-bold text-slate-800">FIFO (First In, First Out)</span>
                      <span class="ai-badge bg-blue-50 text-blue-700">Rekomendasi</span>
                    </div>
                    <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Barang dengan nomor batch dan tanggal masuk terlama diprioritaskan keluar terlebih dahulu untuk mencegah kadaluarsa.</p>
                  </button>
                  <button class="valuasi-opt text-left rounded-xl border-2 p-4 transition-all bg-slate-100/60" data-valuasi="avg">
                    <div class="flex items-center gap-2.5 flex-wrap">
                      <span class="valuasi-dot w-5 h-5 rounded-full flex items-center justify-center flex-none bg-slate-300 text-transparent"></span>
                      <span class="text-[13.5px] font-bold text-slate-800">Average Moving Cost</span>
                    </div>
                    <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Biaya perolehan dihitung rata-rata berbobot setiap ada batch penerimaan baru dari PO supplier.</p>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Integrasi Perangkat Keras -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="200">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                  <i class="fas fa-desktop text-lg text-blue-600"></i>
                </div>
                <div>
                  <h2 class="text-[16px] font-bold text-slate-800">Perangkat &amp; Konektivitas Terminal</h2>
                  <p class="text-[12.5px] text-slate-500 mt-0.5">Monitoring koneksi nirkabel scanner handheld dan stasiun printer label thermal.</p>
                </div>
              </div>
              <button class="ai-btn ai-btn-soft flex-none" data-toast="Pemindaian jaringan perangkat dimulai..." data-toast-type="info"><i class="fas fa-rotate text-base "></i>Scan Jaringan</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <!-- Scanner -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                <div class="flex items-start justify-between gap-2">
                  <div class="flex items-center gap-2.5">
                    <i class="fas fa-barcode text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13.5px] font-bold text-slate-800">Scanner Handheld Zebra TC21</span>
                  </div>
                  <span class="ai-badge bg-emerald-100 text-emerald-700">ONLINE</span>
                </div>
                <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Zebra TC21 Enterprise Mobile Terminal di Zona A, B, Staging Rak C, dan Dock Loading.</p>
                <div class="flex items-center justify-between mt-4 text-[12px]">
                  <span class="font-semibold text-slate-600">Battery Health Armada Scanner</span>
                  <span class="font-extrabold text-slate-800">85% (Kondisi Prima)</span>
                </div>
                <div class="ai-bar mt-1.5" data-w="94"><span class="bg-emerald-500"></span></div>
                <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-200/70">
                  <span class="flex items-center gap-1.5 text-[11.5px] font-semibold text-slate-600"><span class="ai-live-dot"></span>Wi-Fi DC-01 • S/N ZBR-8Q21</span>
                  <button class="text-[12px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1" data-toast="Panel manajemen 24 perangkat scanner dibuka." data-toast-type="info">Detail Perangkat <i class="fas fa-arrow-right text-sm "></i></button>
                </div>
              </div>

              <!-- Printer -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                <div class="flex items-start justify-between gap-2">
                  <div class="flex items-center gap-2.5">
                    <i class="fas fa-print text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13.5px] font-bold text-slate-800">Printer Thermal Label</span>
                  </div>
                  <span class="ai-badge bg-emerald-100 text-emerald-700">Ready</span>
                </div>
                <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Zebra ZD421 di Stasiun Staging Inbound Area A untuk cetak label karton &amp; bin tag.</p>
                <div class="flex flex-wrap gap-2 mt-4">
                  <span class="text-[11px] font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 font-mono">IP: 192.168.10.45</span>
                  <span class="text-[11px] font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 font-mono">Port: 9100</span>
                  <span class="text-[11px] font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 font-mono">DPI: 300</span>
                </div>
                <div class="flex items-center justify-between mt-auto pt-4">
                  <span class="text-[12px] text-slate-500">Kertas Sisa: <span class="font-bold text-slate-700">~620 Label</span></span>
                  <button class="ai-btn ai-btn-primary" id="btnTestPrint"><i class="fas fa-print text-base "></i>Test Print Barcode</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== Kolom kanan ===== -->
        <div class="space-y-5">

          <!-- Status Layanan & Sync -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="120">
            <div class="flex items-center justify-between mb-4">
              <div class="flex items-center gap-2.5">
                <i class="fas fa-network-wired text-lg text-blue-600"></i>
                <h3 class="text-[15px] font-bold text-slate-800">Status Layanan &amp; Sync</h3>
              </div>
              <span class="ai-live-dot"></span>
            </div>
            <div class="space-y-2.5">
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-database text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">Terminal Zebra TC21</div>
                  <div class="text-[11px] text-slate-500 truncate">ZBR-TC21-042 • Zona A</div>
                </div>
                <div class="text-right flex-none">
                  <span class="ai-badge bg-emerald-100 text-emerald-700 font-mono">ONLINE</span>
                  <div class="text-[11px] font-bold text-emerald-600 mt-1">Aktif</div>
                </div>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-cloud text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">Printer ZD421</div>
                  <div class="text-[11px] text-slate-500 truncate">Staging Inbound Area A</div>
                </div>
                <div class="text-right flex-none">
                  <span class="ai-badge bg-blue-50 text-blue-700">SIAP CETAK</span>
                  <div class="text-[11px] text-slate-400 mt-1 font-medium">Baru saja</div>
                </div>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-envelope text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">Wi-Fi DC-01</div>
                  <div class="text-[11px] text-slate-500 truncate">Jaringan gudang operasional</div>
                </div>
                <span class="ai-badge bg-emerald-100 text-emerald-700 flex-none">Aktif</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-comment-dots text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">Buffer Offline</div>
                  <div class="text-[11px] text-slate-500 truncate">14.2 MB cache transaksi</div>
                </div>
                <span class="ai-badge bg-emerald-100 text-emerald-700 flex-none">100% Terkirim</span>
              </div>
            </div>
            <button class="ai-btn ai-btn-secondary w-full mt-4" data-toast="Diagnostik jaringan penuh sedang berjalan — hasil dalam ~30 detik." data-toast-type="info">Cek Diagnostik Jaringan Penuh</button>
          </div>

          <!-- Jadwal Backup Otomatis -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="170">
            <div class="flex items-center justify-between gap-2 mb-4">
              <div class="flex items-center gap-2.5">
                <i class="fas fa-cloud text-lg text-blue-600"></i>
                <h3 class="text-[15px] font-bold text-slate-800">Jadwal Backup Otomatis</h3>
              </div>
              <span class="text-[10.5px] font-bold text-slate-400 font-mono tracking-tight">CRON: 0 3 * * *</span>
            </div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 space-y-2.5 text-[12.5px]">
              <div class="flex items-start justify-between gap-3">
                <span class="text-slate-500">Backup Snapshot Terakhir:</span>
                <span class="font-bold text-slate-800 text-right">Hari ini, 03:00 WIB</span>
              </div>
              <div class="flex items-start justify-between gap-3">
                <span class="text-slate-500">Ukuran Arsip SQL + Blob:</span>
                <span class="font-bold text-blue-600 text-right">1.42 GB (Terenkripsi)</span>
              </div>
              <div class="flex items-start justify-between gap-3">
                <span class="text-slate-500">Titik Redundansi Retensi:</span>
                <span class="text-right font-semibold text-slate-700">AWS S3 (Jakarta ap-southeast-3)<br><span class="text-slate-500 font-normal">NAS Lokal DC Cakung (Synology)</span></span>
              </div>
            </div>
            <button class="ai-btn ai-btn-soft w-full mt-4" id="btnBackup"><i class="fas fa-cloud-download-alt text-base "></i>Buat Backup Manual Sekarang</button>
            <div id="backupProgress" class="mt-3" style="display:none">
              <div class="flex justify-between text-[11px] font-semibold text-slate-500 mb-1"><span>Proses kompresi &amp; enkripsi arsip...</span><span id="backupPct">0%</span></div>
              <div class="ai-bar"><span id="backupBar" class="bg-blue-600"></span></div>
            </div>
          </div>

          <!-- Zona Bahaya & Intervensi -->
          <div class="ai-card p-5 ai-reveal border-red-200" data-delay="220">
            <div class="flex items-center gap-2.5 mb-1.5">
              <i class="fas fa-triangle-exclamation text-lg text-red-500"></i>
              <h3 class="text-[15px] font-bold text-red-600">Zona Bahaya &amp; Intervensi</h3>
            </div>
            <p class="text-[12px] text-slate-500 mb-4 leading-relaxed">Tindakan berikut berdampak langsung pada operasional penerimaan dan pengeluaran fisik gudang.</p>
            <div class="space-y-2.5">
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800">Bersihkan Cache Terminal</div>
                  <div class="text-[11.5px] text-slate-500 mt-0.5">Hapus 14.2 MB cache transaksi offline yang sudah tersinkron</div>
                </div>
                <button class="ai-btn ai-btn-danger flex-none" data-toast="Cache lokal yang sudah tersinkron berhasil dibersihkan." data-toast-type="danger">Bersihkan</button>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800">Reset Preferensi Perangkat</div>
                  <div class="text-[11.5px] text-slate-500 mt-0.5">Kembalikan pengaturan perangkat ke default pabrik</div>
                </div>
                <button class="ai-btn ai-btn-secondary flex-none" data-toast="Preferensi default pabrik dipulihkan." data-toast-type="warn">Reset</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ===== 3 kartu bawah ===== -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
        <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="100">
          <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center mb-4"><i class="fas fa-code text-lg text-slate-600"></i></div>
          <h3 class="text-[15px] font-bold text-slate-800">Panduan SOP Perangkat</h3>
          <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Akses SOP-HW-08 kalibrasi laser, prosedur hot-swap baterai, dan bantuan IT.</p>
          <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Portal Developer dibuka (demo)." data-toast-type="info">Buka SOP-HW-08 <i class="fas fa-arrow-right text-base "></i></button>
        </div>
        <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="160">
          <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center mb-4"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
          <h3 class="text-[15px] font-bold text-slate-800">Log Diagnostik Hardware</h3>
          <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Riwayat 24 jam terakhir kesehatan perangkat terminal dan koneksi jaringan gudang.</p>
          <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Laporan Audit Trail (SHA-256) diunduh." data-toast-type="success">Lihat Log Diagnostik <i class="fas fa-download text-base "></i></button>
        </div>
        <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="220">
          <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mb-4"><i class="fas fa-headset text-lg text-emerald-600"></i></div>
          <h3 class="text-[15px] font-bold text-slate-800">Helpdesk IT &amp; HR</h3>
          <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Hubungi Helpdesk Ekstensi 204 untuk gangguan terminal atau HR Ekstensi 105.</p>
          <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Tiket eskalasi IT dibuat — SLA respon &lt;15 menit." data-toast-type="success">Hubungi Helpdesk <i class="fas fa-external-link-alt text-base "></i></button>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 2 — ATURAN INVENTARIS & STOK (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="stok" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-clipboard-list text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Peringatan Stok &amp; ROP</h2>
              <p class="text-[12px] text-slate-500">Pengingat stok kritis saat tugas receiving &amp; picking.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div>
              <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Perhitungan ROP Default</label>
              <select class="ai-input"><option>Konsumsi 30 Hari Terakhir</option><option>Min-Max Manual per SKU</option><option>Konsumsi 30 Hari Terakhir</option></select>
            </div>
            <div>
              <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Lead Time Default Supplier (Hari)</label>
              <input class="ai-input" value="7">
            </div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3">
              <div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Notifikasi Stok Kritis ke Terminal</div><div class="text-[11.5px] text-slate-500">Alert langsung di beeper scanner saat stok menyentuh 80% ROP.</div></div>
              <div class="ai-switch ai-on"></div>
            </div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-circle text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Batch, ED &amp; Satuan Ukur</h2>
              <p class="text-[12px] text-slate-500">Kebijakan pelacakan lot dan konversi satuan.</p>
            </div>
          </div>
          <div class="space-y-3">
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Wajib Nomor Batch &amp; Tanggal Kedaluwarsa</div><div class="text-[11.5px] text-slate-500">Untuk kategori FMCG &amp; obat-obatan.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Blokir Keluar Barang ED &lt; 90 Hari</div><div class="text-[11.5px] text-slate-500">Butuh override Super Admin.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Izinkan Stok Negara Sementara (In-Transit)</div><div class="text-[11.5px] text-slate-500">Mutasi antar-hub belum diterima fisik.</div></div><div class="ai-switch"></div></div>
            <button class="ai-btn ai-btn-primary w-full" data-toast="Aturan inventaris tersimpan."><i class="fas fa-save text-base "></i>Simpan Aturan Inventaris</button>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 3 — PERANGKAT & PRINTER BARCODE (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="printer" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-print text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Default Template Label</h2>
              <p class="text-[12px] text-slate-500">Format cetak barcode pallet &amp; bin tag.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Ukuran Label</label><select class="ai-input"><option>100 x 50 mm (Standar Pallet)</option><option>75 x 50 mm (Bin Tag)</option><option>60 x 40 mm (Item Kecil)</option></select></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Symbology Barcode</label><select class="ai-input"><option>Code 128 (Rekomendasi)</option><option>QR Code 2D</option><option>Code 39</option></select></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Jumlah Salinan Otomatis per DO</label><input class="ai-input" value="2"></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-barcode text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Pengaturan Scanner Armada</h2>
              <p class="text-[12px] text-slate-500">Zebra TC21 • 1 perangkat terdaftar.</p>
            </div>
          </div>
          <div class="space-y-3">
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Suara Konfirmasi Scan Berhasil</div><div class="text-[11.5px] text-slate-500">Feedback audio di seluruh armada.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Auto-Sync Offline Queue</div><div class="text-[11.5px] text-slate-500">Sinkron otomatis saat sinyal WiFi 6 kembali.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Mode Hemat Baterai Shift Malam</div><div class="text-[11.5px] text-slate-500">Aktif 22:00 - 06:00 WIB.</div></div><div class="ai-switch"></div></div>
            <div class="flex gap-2">
              <button class="ai-btn ai-btn-primary flex-1" data-toast="Pengaturan printer & scanner tersimpan."><i class="fas fa-save text-base "></i>Simpan</button>
              <button class="ai-btn ai-btn-secondary flex-1" data-toast="Test label dikirim ke Zebra ZD230 (Dock Inbound 01)." data-toast-type="info"><i class="fas fa-print text-base "></i>Test Print</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 4 — INTEGRASI ERP & API (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="erp" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-exchange-alt text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Integrasi Terminal &amp; WMS</h2>
              <p class="text-[12px] text-slate-500">Gateway WMS • Status: Terhubung.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Endpoint Host</label><input class="ai-input font-mono" value="wms-gw.astro-inventory.co.id:3300"></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Client / System ID</label><input class="ai-input font-mono" value="100 / PRD-WMS"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Auto-Sync Offline Queue</div><div class="text-[11.5px] text-slate-500">Sinkron otomatis saat sinyal Wi-Fi kembali.</div></div><div class="ai-switch ai-on"></div></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-key text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">API Key &amp; Webhook</h2>
              <p class="text-[12px] text-slate-500">Token integrasi DataWedge &amp; sinkronisasi terminal.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Production API Key</label><div class="relative"><input class="ai-input pr-10 font-mono" type="password" value="«redacted:sk_live_...»" readonly><i class="fas fa-eye text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2"></i></div></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Webhook URL Mutasi Stok</label><input class="ai-input font-mono" value="https://hooks.astro-logistics.id/wms/mutation"></div>
            <div class="flex gap-2">
              <button class="ai-btn ai-btn-primary flex-1" data-toast="Konfigurasi integrasi ERP & API tersimpan."><i class="fas fa-save text-base "></i>Simpan</button>
              <button class="ai-btn ai-btn-secondary flex-1" data-toast="API Key baru digenerate — token lama dicabut." data-toast-type="warn"><i class="fas fa-undo text-base "></i>Regenerate Key</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 5 — KEAMANAN & KEBIJAKAN SESI (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="keamanan" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Keamanan Sesi &amp; PIN Terminal</h2>
              <p class="text-[12px] text-slate-500">Berlaku untuk sesi shift staf operasional.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Timeout Sesi Idle (Menit)</label><input class="ai-input" value="10"></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Maksimal Percobaan Login Gagal</label><input class="ai-input" value="5"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">PIN Wajib saat Buka Kunci Terminal</div><div class="text-[11.5px] text-slate-500">Setiap buka kunci scanner meminta PIN 6 digit.</div></div><div class="ai-switch ai-on"></div></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-lock text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Akses &amp; Sesi Terminal</h2>
              <p class="text-[12px] text-slate-500">Pembatasan akses terminal operasional.</p>
            </div>
          </div>
          <div class="space-y-3">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Rentang IP Diizinkan (CIDR)</label><input class="ai-input font-mono" value="192.168.10.0/24, 10.240.0.0/16"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Blokir Akses di Luar Jam Operasional</div><div class="text-[11.5px] text-slate-500">Panel admin terkunci 23:00 - 05:00 WIB.</div></div><div class="ai-switch"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Audit Forensik Klik Kritis</div><div class="text-[11.5px] text-slate-500">Ledger SHA-256 untuk approval &amp; mutasi.</div></div><div class="ai-switch ai-on"></div></div>
            <button class="ai-btn ai-btn-primary w-full" data-toast="Kebijakan keamanan tersimpan."><i class="fas fa-save text-base "></i>Simpan Kebijakan Keamanan</button>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 6 — BACKUP & PEMULIHAN (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="backup" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-cloud text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Backup Cache Lokal</h2>
              <p class="text-[12px] text-slate-500">Cache transaksi offline tersinkron otomatis.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Ekspresi CRON</label><input class="ai-input font-mono" value="0 3 * * *"></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Retensi Cache (Hari)</label><input class="ai-input" value="30"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Replikasi ke Cloud Server</div><div class="text-[11.5px] text-slate-500">Sinkron otomatis ke server gudang.</div></div><div class="ai-switch ai-on"></div></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-hdd text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Titik Pemulihan Tersedia</h2>
              <p class="text-[12px] text-slate-500">Snapshot terverifikasi 30 hari terakhir.</p>
            </div>
          </div>
          <div class="ai-table w-full text-[12.5px]">
            <table class="w-full">
              <thead><tr><th class="text-left rounded-tl-lg">Snapshot</th><th class="text-left">Ukuran</th><th class="text-left rounded-tr-lg">Aksi</th></tr></thead>
              <tbody>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Hari ini, 03:00 WIB</td><td class="py-2.5 text-slate-500">1.42 GB</td><td class="py-2.5"><button class="text-[12px] font-bold text-blue-600" data-toast="Mode restore dibuka — konfirmasi dua langkah diperlukan." data-toast-type="warn">Restore</button></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Kemarin, 03:00 WIB</td><td class="py-2.5 text-slate-500">1.40 GB</td><td class="py-2.5"><button class="text-[12px] font-bold text-blue-600" data-toast="Mode restore dibuka — konfirmasi dua langkah diperlukan." data-toast-type="warn">Restore</button></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">2 hari lalu, 03:00 WIB</td><td class="py-2.5 text-slate-500">1.38 GB</td><td class="py-2.5"><button class="text-[12px] font-bold text-blue-600" data-toast="Mode restore dibuka — konfirmasi dua langkah diperlukan." data-toast-type="warn">Restore</button></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

        <!-- ===== Modal Log Perubahan ===== -->
  <div id="modalLog" class="modal-overlay">
    <div class="modal-box p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-[16px] font-bold text-slate-800 flex items-center gap-2"><i class="fas fa-history text-lg text-blue-600"></i>Log Perubahan Konfigurasi</h3>
        <button data-modal-close class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-500"><i class="fas fa-times text-base "></i></button>
      </div>
      <div class="space-y-2.5 text-[12.5px]">
        <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center justify-between gap-3"><div><div class="font-bold text-slate-800">Mode Scan diubah ke Continuous</div><div class="text-slate-500 text-[11.5px]">Ahmad Fauzi • Hari ini 08:14 WIB</div></div><span class="ai-badge bg-blue-50 text-blue-700 flex-none">SHA:81ac02</span></div>
        <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center justify-between gap-3"><div><div class="font-bold text-slate-800">Kegelapan Thermal diset 12</div><div class="text-slate-500 text-[11.5px]">Ahmad Fauzi • 2 hari lalu</div></div><span class="ai-badge bg-blue-50 text-blue-700 flex-none">SHA:4de911</span></div>
        <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center justify-between gap-3"><div><div class="font-bold text-slate-800">PIN Terminal diperbarui</div><div class="text-slate-500 text-[11.5px]">Sistem • 12 hari lalu</div></div><span class="ai-badge bg-slate-100 text-slate-600 flex-none">SHA:0b7f5a</span></div>
      </div>
      <button class="ai-btn ai-btn-secondary w-full mt-5" data-modal-close>Tutup</button>
    </div>
  </div>
        @endif

        @if(auth()->user()->isAuditor())
        <!-- ===== Breadcrumb + versi sistem ===== -->
    <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
      <div class="flex items-center gap-2 text-sm text-gray-500 mb-4 overflow-x-auto whitespace-nowrap anim-fade-in">
        <span>Beranda</span><i class="fas fa-chevron-right text-xs"></i>
        <span>Pengaturan &amp; Akun</span><i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-900 font-medium">Pengaturan</span>
    </div>
      <div class="ai-badge bg-white border border-slate-200 text-slate-500 shadow-sm">
        <span class="ai-live-dot"></span>
        <span class="text-emerald-600">SISTEM OPTIMAL</span>
        <span class="text-slate-300">•</span>
        <span>VERSI 4.2.0-LTS</span>
        <span class="font-mono font-semibold text-slate-400">SHA:8f92af</span>
      </div>
    </div>

    <!-- ===== Header card ===== -->
    <div class="ai-card ai-card-hover p-5 md:p-6 mb-5 ai-reveal flex flex-col lg:flex-row lg:items-center gap-5">
      <div class="flex items-start gap-4 flex-1">
        <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
          <i class="fas fa-sliders-h text-xl text-blue-600"></i>
        </div>
        <div>
          <h1 class="text-[22px] md:text-2xl font-extrabold text-slate-800 leading-tight">Pengaturan Akun &amp; Preferensi Auditor</h1>
          <p class="text-[13px] text-slate-500 mt-1 max-w-xl leading-relaxed">Kelola preferensi pemeriksaan audit, ambang deviasi, notifikasi temuan, keamanan sesi, dan integrasi ledger kepatuhan.</p>
        </div>
      </div>
      <div class="flex flex-wrap items-center gap-2.5 flex-none">
        <button class="ai-btn ai-btn-secondary" id="btnReset"><i class="fas fa-undo text-base "></i>Kembalikan Default</button>
        <button class="ai-btn ai-btn-secondary" data-modal-open="modalLog"><i class="fas fa-history text-base "></i>Lihat Log Perubahan</button>
        <button class="ai-btn ai-btn-primary" id="btnSimpan"><i class="fas fa-check-circle text-base "></i>Simpan Perubahan</button>
      </div>
    </div>

    <!-- ===== Tab nomor ===== -->
    <div data-tabs="pengaturan" class="flex gap-2 overflow-x-auto pb-1 mb-5 ai-reveal" data-delay="80">
      <button class="ai-pill ai-pill-active" data-tab="umum"><i class="fas fa-sliders-h text-base "></i>1. Umum &amp; Profil Hub</button>
      <button class="ai-pill" data-tab="stok"><i class="fas fa-clipboard-list text-base "></i>2. Aturan Inventaris &amp; Stok</button>
      <button class="ai-pill" data-tab="printer"><i class="fas fa-print text-base "></i>3. Perangkat &amp; Printer Barcode</button>
      <button class="ai-pill" data-tab="erp"><i class="fas fa-exchange-alt text-base "></i>4. Integrasi ERP &amp; API</button>
      <button class="ai-pill" data-tab="keamanan"><i class="fas fa-shield-alt text-base "></i>5. Keamanan &amp; Kebijakan Sesi</button>
      <button class="ai-pill" data-tab="backup"><i class="fas fa-cloud text-base "></i>6. Backup &amp; Pemulihan</button>
    </div>

    <!-- ============================================================
         PANEL 1 — UMUM & PROFIL HUB (sesuai desain)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="umum">
      <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        <!-- ===== Kolom kiri ===== -->
        <div class="xl:col-span-2 space-y-5">

          <!-- Informasi Identitas & Hub Operasional -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="100">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                  <i class="fas fa-warehouse text-lg text-blue-600"></i>
                </div>
                <div>
                  <h2 class="text-[16px] font-bold text-slate-800">Identitas Unit Audit</h2>
                  <p class="text-[12.5px] text-slate-500 mt-0.5">Data unit audit, lingkup pemeriksaan, dan kontak darurat kepatuhan.</p>
                </div>
              </div>
              <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100 font-mono">ID: AU001-DC03</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Nama Hub Distribusi</label>
                <div class="relative">
                  <i class="fas fa-circle text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="Hub Waru DC-03 Utama">
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kode Fasilitas (DC Code)</label>
                <div class="relative">
                  <i class="fas fa-qrcode text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9 font-mono" value="AU-DC03">
                </div>
              </div>
              <div class="md:col-span-2">
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Alamat Fisik Gudang &amp; Titik Bongkar Muat</label>
                <div class="relative">
                  <i class="fas fa-map-marker-alt text-base text-slate-400 absolute left-3 top-4 -translate-y-1/2"></i>
                  <textarea class="ai-input pl-9 min-h-[64px] resize-none leading-relaxed">Kawasan Industri Pulogadung - Cakung Logistics Park Blok B3 No. 12-14, RW02, Cakung Timur, Jakarta Timur 13910</textarea>
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Zona Waktu Sistem Operasional</label>
                <div class="relative">
                  <i class="fas fa-globe text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <select class="ai-input pl-9 appearance-none">
                    <option>Asia/Jakarta (WIB - UTC+07:00)</option>
                    <option>Asia/Makassar (WITA - UTC+08:00)</option>
                    <option>Asia/Jayapura (WIT - UTC+09:00)</option>
                  </select>
                  <i class="fas fa-chevron-down text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Email Dispatcher Operasional</label>
                <div class="relative">
                  <i class="fas fa-envelope text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="auditor@astro.com">
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Hotline Dispatch &amp; PIC Supervisor</label>
                <div class="relative">
                  <i class="fas fa-phone text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="+62 21 460-9981 (Ext. 108)">
                </div>
              </div>
              <div>
                <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Kapasitas Staging &amp; Bay Penampungan</label>
                <div class="relative">
                  <i class="fas fa-th-large text-base text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                  <input class="ai-input pl-9" value="Unlimited Akses Baca Ledger">
                </div>
              </div>
            </div>
          </div>

          <!-- Parameter Operasional & Ambang Batas Stok -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="150">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                  <i class="fas fa-chart-line text-lg text-blue-600"></i>
                </div>
                <div>
                  <h2 class="text-[16px] font-bold text-slate-800">Ambang Deviasi &amp; Parameter Audit</h2>
                  <p class="text-[12.5px] text-slate-500 mt-0.5">Konfigurasi toleransi deviasi stok opname, ambang temuan, dan kebijakan eskalasi kepatuhan.</p>
                </div>
              </div>
              <span class="ai-badge bg-slate-100 text-slate-600 border border-slate-200">Aktif Otomatis</span>
            </div>

            <div class="space-y-4">
              <!-- Slider buffer stock -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                <div class="flex flex-wrap items-start justify-between gap-3">
                  <div>
                    <div class="text-[13.5px] font-bold text-slate-800">Formula Buffer Stock Default (% Safety Stock dari Lead Time)</div>
                    <div class="text-[12px] text-slate-500 mt-0.5">Kompensasi fluktuasi pasokan supplier tier-1 &amp; keterlambatan ekspedisi lintas pulau.</div>
                  </div>
                  <div class="text-2xl font-extrabold text-blue-600"><span id="bufferVal">25</span>%</div>
                </div>
                <input type="range" id="bufferSlider" min="5" max="50" step="5" value="25" class="w-full mt-4 accent-blue-600 cursor-pointer">
                <div class="flex justify-between mt-1.5 text-[10.5px] font-semibold text-slate-400">
                  <span>5% (Konservatif)</span>
                  <span class="hidden sm:inline">15% (Rekomendasi FMCG)</span>
                  <span class="text-blue-600">25% (Aktif - High Velocity)</span>
                  <span>50% (Seasonal Peak)</span>
                </div>
              </div>

              <!-- Dead stock -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col md:flex-row md:items-center gap-4">
                <div class="flex-1">
                  <div class="text-[13.5px] font-bold text-slate-800">Ambang Batas Penandaan Dead Stock (Barang Mengendap)</div>
                  <div class="text-[12px] text-slate-500 mt-0.5 leading-relaxed">Barang tanpa pergerakan mutasi keluar akan ditandai untuk diskon likuidasi atau retur vendor.</div>
                </div>
                <div class="flex flex-none rounded-xl bg-white border border-slate-200 p-1 gap-1" id="deadStockGroup">
                  <button class="dead-opt px-3.5 py-2 rounded-lg text-[12.5px] font-semibold text-slate-600 transition-all" data-dead="60">&gt; 60 Hari</button>
                  <button class="dead-opt px-3.5 py-2 rounded-lg text-[12.5px] font-semibold transition-all" data-dead="90">&gt; 90 Hari (Aktif)</button>
                  <button class="dead-opt px-3.5 py-2 rounded-lg text-[12.5px] font-semibold text-slate-600 transition-all" data-dead="180">&gt; 180 Hari</button>
                </div>
              </div>

              <!-- Otomatisasi persetujuan -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-100 flex items-center justify-center flex-none">
                  <i class="fas fa-bolt text-lg text-amber-500"></i>
                </div>
                <div class="flex-1">
                  <div class="text-[13.5px] font-bold text-slate-800">Eskalasi Otomatis Temuan &gt; 0,2%</div>
                  <div class="text-[12px] text-slate-500 mt-0.5 leading-relaxed">Deviasi audit fisik di atas 0,2% otomatis dieskalasi ke dewan kepatuhan tanpa antrean manual.</div>
                </div>
                <div class="ai-switch ai-on flex-none" id="swAutoApprove"></div>
              </div>

              <!-- Metode valuasi -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                <div class="flex flex-wrap items-start justify-between gap-2">
                  <div>
                    <div class="text-[13.5px] font-bold text-slate-800">Kebijakan Metode Valuasi &amp; Penjatahan Batch Inventaris</div>
                    <div class="text-[12px] text-slate-500 mt-0.5">Menentukan alokasi fisik barang di rak penyimpanan dan perhitungan COGS buku persediaan.</div>
                  </div>
                  <span class="ai-badge bg-emerald-50 text-emerald-700 border border-emerald-100">Kepatuhan PSAK 14</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4" id="valuasiGroup">
                  <button class="valuasi-opt text-left rounded-xl border-2 p-4 transition-all bg-white" data-valuasi="fifo">
                    <div class="flex items-center gap-2.5 flex-wrap">
                      <span class="valuasi-dot w-5 h-5 rounded-full flex items-center justify-center flex-none bg-blue-600 text-white"><i class="fas fa-check-circle text-base "></i></span>
                      <span class="text-[13.5px] font-bold text-slate-800">FIFO (First In, First Out)</span>
                      <span class="ai-badge bg-blue-50 text-blue-700">Rekomendasi</span>
                    </div>
                    <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Barang dengan nomor batch dan tanggal masuk terlama diprioritaskan keluar terlebih dahulu untuk mencegah kadaluarsa.</p>
                  </button>
                  <button class="valuasi-opt text-left rounded-xl border-2 p-4 transition-all bg-slate-100/60" data-valuasi="avg">
                    <div class="flex items-center gap-2.5 flex-wrap">
                      <span class="valuasi-dot w-5 h-5 rounded-full flex items-center justify-center flex-none bg-slate-300 text-transparent"></span>
                      <span class="text-[13.5px] font-bold text-slate-800">Average Moving Cost</span>
                    </div>
                    <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Biaya perolehan dihitung rata-rata berbobot setiap ada batch penerimaan baru dari PO supplier.</p>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Integrasi Perangkat Keras -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="200">
            <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
              <div class="flex items-start gap-3.5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center flex-none">
                  <i class="fas fa-desktop text-lg text-blue-600"></i>
                </div>
                <div>
                  <h2 class="text-[16px] font-bold text-slate-800">Perangkat Audit &amp; Verifikasi</h2>
                  <p class="text-[12.5px] text-slate-500 mt-0.5">Monitoring perangkat audit lapangan dan stasiun verifikasi ledger.</p>
                </div>
              </div>
              <button class="ai-btn ai-btn-soft flex-none" data-toast="Pemindaian jaringan perangkat dimulai..." data-toast-type="info"><i class="fas fa-rotate text-base "></i>Scan Jaringan</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <!-- Scanner -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                <div class="flex items-start justify-between gap-2">
                  <div class="flex items-center gap-2.5">
                    <i class="fas fa-barcode text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13.5px] font-bold text-slate-800">Handheld Audit Verifier</span>
                  </div>
                  <span class="ai-badge bg-emerald-100 text-emerald-700">6 Online</span>
                </div>
                <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Zebra TC52x dan tablet audit aktif di Zona A, B, dan Ruang Ledger.</p>
                <div class="flex items-center justify-between mt-4 text-[12px]">
                  <span class="font-semibold text-slate-600">Battery Health Armada Scanner</span>
                  <span class="font-extrabold text-slate-800">88% Rata-rata</span>
                </div>
                <div class="ai-bar mt-1.5" data-w="94"><span class="bg-emerald-500"></span></div>
                <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-200/70">
                  <span class="flex items-center gap-1.5 text-[11.5px] font-semibold text-slate-600"><span class="ai-live-dot"></span>WiFi 6 DC-IoT Mesh</span>
                  <button class="text-[12px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1" data-toast="Panel manajemen 24 perangkat scanner dibuka." data-toast-type="info">Kelola 6 Device <i class="fas fa-arrow-right text-sm "></i></button>
                </div>
              </div>

              <!-- Printer -->
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex flex-col">
                <div class="flex items-start justify-between gap-2">
                  <div class="flex items-center gap-2.5">
                    <i class="fas fa-print text-lg text-slate-700 flex-none"></i>
                    <span class="text-[13.5px] font-bold text-slate-800">Printer Dokumen Audit</span>
                  </div>
                  <span class="ai-badge bg-emerald-100 text-emerald-700">Ready</span>
                </div>
                <p class="text-[12px] text-slate-500 mt-2 leading-relaxed">Canon LBP untuk cetak berita acara, laporan temuan, dan SPO audit.</p>
                <div class="flex flex-wrap gap-2 mt-4">
                  <span class="text-[11px] font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 font-mono">IP: 192.168.10.77</span>
                  <span class="text-[11px] font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 font-mono">Port: 9100</span>
                  <span class="text-[11px] font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg px-2.5 py-1.5 font-mono">DPI: 600</span>
                </div>
                <div class="flex items-center justify-between mt-auto pt-4">
                  <span class="text-[12px] text-slate-500">Kertas Sisa: <span class="font-bold text-slate-700">~200 Lembar</span></span>
                  <button class="ai-btn ai-btn-primary" id="btnTestPrint"><i class="fas fa-print text-base "></i>Test Print Barcode</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== Kolom kanan ===== -->
        <div class="space-y-5">

          <!-- Status Layanan & Sync -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="120">
            <div class="flex items-center justify-between mb-4">
              <div class="flex items-center gap-2.5">
                <i class="fas fa-network-wired text-lg text-blue-600"></i>
                <h3 class="text-[15px] font-bold text-slate-800">Status Layanan &amp; Sync</h3>
              </div>
              <span class="ai-live-dot"></span>
            </div>
            <div class="space-y-2.5">
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-database text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">Ledger SHA-256</div>
                  <div class="text-[11px] text-slate-500 truncate">Master Read/Write • Cakung DC</div>
                </div>
                <div class="text-right flex-none">
                  <span class="ai-badge bg-emerald-100 text-emerald-700 font-mono">VERIFIED</span>
                  <div class="text-[11px] font-bold text-emerald-600 mt-1">Sehat</div>
                </div>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-cloud text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">Log Audit Mingguan</div>
                  <div class="text-[11px] text-slate-500 truncate">Rekap minggu ke-42 diverifikasi</div>
                </div>
                <div class="text-right flex-none">
                  <span class="ai-badge bg-blue-50 text-blue-700">OK</span>
                  <div class="text-[11px] text-slate-400 mt-1 font-medium">1 mnt lalu</div>
                </div>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-envelope text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">Gateway Temuan</div>
                  <div class="text-[11px] text-slate-500 truncate">Notifikasi deviasi &amp; insiden</div>
                </div>
                <span class="ai-badge bg-emerald-100 text-emerald-700 flex-none">Aktif</span>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-none"><i class="fas fa-comment-dots text-base 18px] 18px] text-slate-600"></i></div>
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800 truncate">CSIRT Escalation</div>
                  <div class="text-[11px] text-slate-500 truncate">Tiket darurat kepatuhan</div>
                </div>
                <span class="ai-badge bg-emerald-100 text-emerald-700 flex-none">Terhubung</span>
              </div>
            </div>
            <button class="ai-btn ai-btn-secondary w-full mt-4" data-toast="Diagnostik jaringan penuh sedang berjalan — hasil dalam ~30 detik." data-toast-type="info">Cek Diagnostik Jaringan Penuh</button>
          </div>

          <!-- Jadwal Backup Otomatis -->
          <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="170">
            <div class="flex items-center justify-between gap-2 mb-4">
              <div class="flex items-center gap-2.5">
                <i class="fas fa-cloud text-lg text-blue-600"></i>
                <h3 class="text-[15px] font-bold text-slate-800">Jadwal Backup Otomatis</h3>
              </div>
              <span class="text-[10.5px] font-bold text-slate-400 font-mono tracking-tight">CRON: 0 3 * * *</span>
            </div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 space-y-2.5 text-[12.5px]">
              <div class="flex items-start justify-between gap-3">
                <span class="text-slate-500">Backup Snapshot Terakhir:</span>
                <span class="font-bold text-slate-800 text-right">Hari ini, 03:00 WIB</span>
              </div>
              <div class="flex items-start justify-between gap-3">
                <span class="text-slate-500">Ukuran Arsip SQL + Blob:</span>
                <span class="font-bold text-blue-600 text-right">1.42 GB (Terenkripsi)</span>
              </div>
              <div class="flex items-start justify-between gap-3">
                <span class="text-slate-500">Titik Redundansi Retensi:</span>
                <span class="text-right font-semibold text-slate-700">AWS S3 (Jakarta ap-southeast-3)<br><span class="text-slate-500 font-normal">NAS Lokal DC Cakung (Synology)</span></span>
              </div>
            </div>
            <button class="ai-btn ai-btn-soft w-full mt-4" id="btnBackup"><i class="fas fa-cloud-download-alt text-base "></i>Buat Backup Manual Sekarang</button>
            <div id="backupProgress" class="mt-3" style="display:none">
              <div class="flex justify-between text-[11px] font-semibold text-slate-500 mb-1"><span>Proses kompresi &amp; enkripsi arsip...</span><span id="backupPct">0%</span></div>
              <div class="ai-bar"><span id="backupBar" class="bg-blue-600"></span></div>
            </div>
          </div>

          <!-- Zona Bahaya & Intervensi -->
          <div class="ai-card p-5 ai-reveal border-red-200" data-delay="220">
            <div class="flex items-center gap-2.5 mb-1.5">
              <i class="fas fa-triangle-exclamation text-lg text-red-500"></i>
              <h3 class="text-[15px] font-bold text-red-600">Zona Bahaya &amp; Intervensi</h3>
            </div>
            <p class="text-[12px] text-slate-500 mb-4 leading-relaxed">Tindakan berikut berdampak langsung pada operasional penerimaan dan pengeluaran fisik gudang.</p>
            <div class="space-y-2.5">
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800">Finalisasi Ledger Audit</div>
                  <div class="text-[11.5px] text-slate-500 mt-0.5">Kunci ledger bulan berjalan untuk rekonsiliasi</div>
                </div>
                <button class="ai-btn ai-btn-danger flex-none" data-toast="Peringatan: Finalisasi ledger memerlukan otorisasi dua langkah!" data-toast-type="danger">Kunci</button>
              </div>
              <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center gap-3">
                <div class="flex-1 min-w-0">
                  <div class="text-[13px] font-bold text-slate-800">Ekspor Log Forensik</div>
                  <div class="text-[11.5px] text-slate-500 mt-0.5">Buat snapshot log forensik untuk pemeriksaan eksternal</div>
                </div>
                <button class="ai-btn ai-btn-secondary flex-none" data-toast="Snapshot log forensik berhasil diekspor." data-toast-type="warn">Ekspor</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ===== 3 kartu bawah ===== -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
        <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="100">
          <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center mb-4"><i class="fas fa-code text-lg text-slate-600"></i></div>
          <h3 class="text-[15px] font-bold text-slate-800">Dokumentasi Regulasi &amp; API</h3>
          <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Akses dokumen regulasi ISO 27001, kebijakan audit, dan token API ledger.</p>
          <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Portal Developer dibuka (demo)." data-toast-type="info">Akses Portal Kepatuhan <i class="fas fa-arrow-right text-base "></i></button>
        </div>
        <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="160">
          <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center mb-4"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
          <h3 class="text-[15px] font-bold text-slate-800">Audit &amp; Kepatuhan Konfigurasi</h3>
          <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Seluruh perubahan parameter audit tercatat otomatis dalam ledger SHA-256 yang memenuhi standar ISO 27001.</p>
          <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Laporan Audit Trail (SHA-256) diunduh." data-toast-type="success">Unduh Laporan Audit Trail <i class="fas fa-download text-base "></i></button>
        </div>
        <div class="ai-card ai-card-hover p-5 ai-reveal" data-delay="220">
          <div class="w-10 h-10 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-center mb-4"><i class="fas fa-headset text-lg text-emerald-600"></i></div>
          <h3 class="text-[15px] font-bold text-slate-800">Dukungan Teknis Enterprise</h3>
          <p class="text-[12.5px] text-slate-500 mt-1.5 leading-relaxed">Bantuan penanganan insiden infrastruktur 24/7 dengan jaminan respon SLA &lt;15 menit langsung dari Command Center.</p>
          <button class="mt-4 text-[13px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1.5" data-toast="Tiket eskalasi IT dibuat — SLA respon &lt;15 menit." data-toast-type="success">Buka Tiket Eskalasi IT <i class="fas fa-external-link-alt text-base "></i></button>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 2 — ATURAN INVENTARIS & STOK (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="stok" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-clipboard-list text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Ambang Deviasi &amp; Toleransi</h2>
              <p class="text-[12px] text-slate-500">Toleransi selisih stok opname per kategori pemeriksaan.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div>
              <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Perhitungan ROP Default</label>
              <select class="ai-input"><option>Deviasi Fisik &gt; 0,2% (Eskalasi)</option><option>Min-Max Manual per SKU</option><option>Konsumsi 30 Hari Terakhir</option></select>
            </div>
            <div>
              <label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Toleransi Deviasi Maksimal (%)</label>
              <input class="ai-input" value="0.2">
            </div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3">
              <div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Notifikasi Temuan ke CSIRT</div><div class="text-[11.5px] text-slate-500">Alert instan saat deviasi melebihi toleransi.</div></div>
              <div class="ai-switch ai-on"></div>
            </div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-circle text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Batch, ED &amp; Satuan Ukur</h2>
              <p class="text-[12px] text-slate-500">Kebijakan pelacakan lot dan konversi satuan.</p>
            </div>
          </div>
          <div class="space-y-3">
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Wajib Nomor Batch &amp; Tanggal Kedaluwarsa</div><div class="text-[11.5px] text-slate-500">Untuk kategori FMCG &amp; obat-obatan.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Blokir Keluar Barang ED &lt; 90 Hari</div><div class="text-[11.5px] text-slate-500">Butuh override Super Admin.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Izinkan Stok Negara Sementara (In-Transit)</div><div class="text-[11.5px] text-slate-500">Mutasi antar-hub belum diterima fisik.</div></div><div class="ai-switch"></div></div>
            <button class="ai-btn ai-btn-primary w-full" data-toast="Aturan inventaris tersimpan."><i class="fas fa-save text-base "></i>Simpan Aturan Inventaris</button>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 3 — PERANGKAT & PRINTER BARCODE (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="printer" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-print text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Template Dokumen Audit</h2>
              <p class="text-[12px] text-slate-500">Format cetak berita acara &amp; laporan temuan.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Ukuran Label</label><select class="ai-input"><option>A4 (Berita Acara)</option><option>75 x 50 mm (Bin Tag)</option><option>60 x 40 mm (Item Kecil)</option></select></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Symbology Barcode</label><select class="ai-input"><option>Code 128 (Rekomendasi)</option><option>QR Code 2D</option><option>Code 39</option></select></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Jumlah Salinan Otomatis per Laporan</label><input class="ai-input" value="1"></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-barcode text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Pengaturan Perangkat Audit</h2>
              <p class="text-[12px] text-slate-500">Zebra TC52x • 6 perangkat terdaftar.</p>
            </div>
          </div>
          <div class="space-y-3">
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Suara Konfirmasi Scan Berhasil</div><div class="text-[11.5px] text-slate-500">Feedback audio di seluruh armada.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Auto-Sync Offline Queue</div><div class="text-[11.5px] text-slate-500">Sinkron otomatis saat sinyal WiFi 6 kembali.</div></div><div class="ai-switch ai-on"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Mode Hemat Baterai Shift Malam</div><div class="text-[11.5px] text-slate-500">Aktif 22:00 - 06:00 WIB.</div></div><div class="ai-switch"></div></div>
            <div class="flex gap-2">
              <button class="ai-btn ai-btn-primary flex-1" data-toast="Pengaturan printer & scanner tersimpan."><i class="fas fa-save text-base "></i>Simpan</button>
              <button class="ai-btn ai-btn-secondary flex-1" data-toast="Test label dikirim ke Zebra ZD230 (Dock Inbound 01)." data-toast-type="info"><i class="fas fa-print text-base "></i>Test Print</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 4 — INTEGRASI ERP & API (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="erp" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-exchange-alt text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Koneksi Ledger &amp; Kepatuhan</h2>
              <p class="text-[12px] text-slate-500">Ledger Gateway • Status: VERIFIED.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Endpoint Host</label><input class="ai-input font-mono" value="ledger.astro-inventory.co.id:3300"></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Client / System ID</label><input class="ai-input font-mono" value="100 / PRD-AUDIT"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Sync Ledger Dua Arah</div><div class="text-[11.5px] text-slate-500">Perubahan ledger ikut ke portal kepatuhan.</div></div><div class="ai-switch ai-on"></div></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-key text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">API Key &amp; Webhook</h2>
              <p class="text-[12px] text-slate-500">Token integrasi mitra ekspedisi &amp; B2B.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Production API Key</label><div class="relative"><input class="ai-input pr-10 font-mono" type="password" value="«redacted:sk_live_...»" readonly><i class="fas fa-eye text-base text-slate-400 absolute right-3 top-1/2 -translate-y-1/2"></i></div></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Webhook URL Mutasi Stok</label><input class="ai-input font-mono" value="https://hooks.astro-logistics.id/audit/ledger"></div>
            <div class="flex gap-2">
              <button class="ai-btn ai-btn-primary flex-1" data-toast="Konfigurasi integrasi ERP & API tersimpan."><i class="fas fa-save text-base "></i>Simpan</button>
              <button class="ai-btn ai-btn-secondary flex-1" data-toast="API Key baru digenerate — token lama dicabut." data-toast-type="warn"><i class="fas fa-undo text-base "></i>Regenerate Key</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 5 — KEAMANAN & KEBIJAKAN SESI (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="keamanan" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-shield-alt text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Kebijakan Sesi Pengguna</h2>
              <p class="text-[12px] text-slate-500">Berlaku untuk seluruh role di Hub Cakung DC-01.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Timeout Sesi Idle (Menit)</label><input class="ai-input" value="30"></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Maksimal Percobaan Login Gagal</label><input class="ai-input" value="5"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Wajib 2FA untuk Ekspor Laporan</div><div class="text-[11.5px] text-slate-500">TOTP wajib setiap unduh laporan audit.</div></div><div class="ai-switch ai-on"></div></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-lock text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Whitelist IP &amp; Akses Jarak Jauh</h2>
              <p class="text-[12px] text-slate-500">Pembatasan akses panel audit.</p>
            </div>
          </div>
          <div class="space-y-3">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Rentang IP Diizinkan (CIDR)</label><input class="ai-input font-mono" value="182.253.110.0/24, 10.240.0.0/16"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Blokir Akses di Luar Jam Operasional</div><div class="text-[11.5px] text-slate-500">Panel admin terkunci 23:00 - 05:00 WIB.</div></div><div class="ai-switch"></div></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Audit Forensik Klik Kritis</div><div class="text-[11.5px] text-slate-500">Ledger SHA-256 untuk approval &amp; mutasi.</div></div><div class="ai-switch ai-on"></div></div>
            <button class="ai-btn ai-btn-primary w-full" data-toast="Kebijakan keamanan tersimpan."><i class="fas fa-save text-base "></i>Simpan Kebijakan Keamanan</button>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================================
         PANEL 6 — BACKUP & PEMULIHAN (ringkas)
    ============================================================= -->
    <div data-tabpanel="pengaturan" data-panel-name="backup" style="display:none">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-cloud text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Penjadwalan Backup</h2>
              <p class="text-[12px] text-slate-500">Snapshot SQL + Blob terenkripsi AES-256.</p>
            </div>
          </div>
          <div class="space-y-4">
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Ekspresi CRON</label><input class="ai-input font-mono" value="0 3 * * *"></div>
            <div><label class="block text-[12px] font-semibold text-slate-600 mb-1.5">Retensi Snapshot (Hari)</label><input class="ai-input" value="90"></div>
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 flex items-center gap-3"><div class="flex-1"><div class="text-[13px] font-bold text-slate-800">Replikasi ke AWS S3 Jakarta</div><div class="text-[11.5px] text-slate-500">ap-southeast-3 • versi objek aktif.</div></div><div class="ai-switch ai-on"></div></div>
          </div>
        </div>
        <div class="ai-card ai-card-hover p-5">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center"><i class="fas fa-hdd text-lg text-blue-600"></i></div>
            <div>
              <h2 class="text-[15px] font-bold text-slate-800">Titik Pemulihan Tersedia</h2>
              <p class="text-[12px] text-slate-500">Snapshot terverifikasi 30 hari terakhir.</p>
            </div>
          </div>
          <div class="ai-table w-full text-[12.5px]">
            <table class="w-full">
              <thead><tr><th class="text-left rounded-tl-lg">Snapshot</th><th class="text-left">Ukuran</th><th class="text-left rounded-tr-lg">Aksi</th></tr></thead>
              <tbody>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Hari ini, 03:00 WIB</td><td class="py-2.5 text-slate-500">1.42 GB</td><td class="py-2.5"><button class="text-[12px] font-bold text-blue-600" data-toast="Mode restore dibuka — konfirmasi dua langkah diperlukan." data-toast-type="warn">Restore</button></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">Kemarin, 03:00 WIB</td><td class="py-2.5 text-slate-500">1.40 GB</td><td class="py-2.5"><button class="text-[12px] font-bold text-blue-600" data-toast="Mode restore dibuka — konfirmasi dua langkah diperlukan." data-toast-type="warn">Restore</button></td></tr>
                <tr class="border-t border-slate-100"><td class="py-2.5 font-semibold text-slate-700">2 hari lalu, 03:00 WIB</td><td class="py-2.5 text-slate-500">1.38 GB</td><td class="py-2.5"><button class="text-[12px] font-bold text-blue-600" data-toast="Mode restore dibuka — konfirmasi dua langkah diperlukan." data-toast-type="warn">Restore</button></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

        <!-- ===== Modal Log Perubahan ===== -->
  <div id="modalLog" class="modal-overlay">
    <div class="modal-box p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-[16px] font-bold text-slate-800 flex items-center gap-2"><i class="fas fa-history text-lg text-blue-600"></i>Log Perubahan Konfigurasi</h3>
        <button data-modal-close class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-500"><i class="fas fa-times text-base "></i></button>
      </div>
      <div class="space-y-2.5 text-[12.5px]">
        <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center justify-between gap-3"><div><div class="font-bold text-slate-800">Toleransi Deviasi diubah → 0,2%</div><div class="text-slate-500 text-[11.5px]">Eko Prasetyo • Hari ini 09:14 WIB</div></div><span class="ai-badge bg-blue-50 text-blue-700 flex-none">SHA:81ac02</span></div>
        <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center justify-between gap-3"><div><div class="font-bold text-slate-800">Ambang Eskalasi Temuan digeser</div><div class="text-slate-500 text-[11.5px]">Eko Prasetyo • 2 hari lalu</div></div><span class="ai-badge bg-blue-50 text-blue-700 flex-none">SHA:4de911</span></div>
        <div class="bg-slate-50 border border-slate-100 rounded-xl p-3.5 flex items-center justify-between gap-3"><div><div class="font-bold text-slate-800">Jadwal Backup CRON diubah ke 0 3 * * *</div><div class="text-slate-500 text-[11.5px]">Sistem • 12 hari lalu</div></div><span class="ai-badge bg-slate-100 text-slate-600 flex-none">SHA:0b7f5a</span></div>
      </div>
      <button class="ai-btn ai-btn-secondary w-full mt-5" data-modal-close>Tutup</button>
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

    /* ---------- Toast ---------- */
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

    /* SuperAdmin alias (ai-toast -> shared toast) */
    window.aiToast = function (msg, type) {
        var map = { success: 'success', danger: 'error', warn: 'warn', info: '' };
        toast(msg, map[type] || '');
    };

    /* ---------- Modals ---------- */
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
    (function () {
    if (!document.querySelector('[data-tabs="pengaturan"]')) return;

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

    /* ai bars */
    document.querySelectorAll('.ai-bar[data-w]').forEach(function (b) {
      b.querySelector('span').style.width = b.getAttribute('data-w') + '%';
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

      /* Slider buffer stock — update angka live */
      var slider = document.getElementById("bufferSlider");
      var out = document.getElementById("bufferVal");
      if (slider && out) {
        slider.addEventListener("input", function () { out.textContent = slider.value; });
      }

      /* Radio dead stock */
      var deadBtns = document.querySelectorAll(".dead-opt");
      function paintDead() {
        deadBtns.forEach(function (b) {
          var on = b.hasAttribute("data-active");
          b.classList.toggle("bg-blue-600", on);
          b.classList.toggle("text-white", on);
          b.classList.toggle("shadow-md", on);
          b.classList.toggle("shadow-blue-600/30", on);
          b.classList.toggle("text-slate-600", !on);
        });
      }
      deadBtns.forEach(function (b) {
        if (b.getAttribute("data-dead") === "90") b.setAttribute("data-active", "");
        b.addEventListener("click", function () {
          deadBtns.forEach(function (x) { x.removeAttribute("data-active"); });
          b.setAttribute("data-active", "");
          b.textContent = "> " + b.getAttribute("data-dead") + " Hari" + (b.getAttribute("data-dead") === "90" ? " (Aktif)" : "");
          deadBtns.forEach(function (x) {
            if (x !== b) x.textContent = "> " + x.getAttribute("data-dead") + " Hari";
          });
          paintDead();
          window.aiToast("Ambang dead stock diset ke > " + b.getAttribute("data-dead") + " hari (belum disimpan).", "info");
        });
      });
      paintDead();

      /* Pilihan metode valuasi */
      var valBtns = document.querySelectorAll(".valuasi-opt");
      function paintValuasi() {
        valBtns.forEach(function (b) {
          var on = b.hasAttribute("data-selected");
          b.classList.toggle("border-blue-600", on);
          b.classList.toggle("bg-white", on);
          b.classList.toggle("shadow-md", on);
          b.classList.toggle("shadow-blue-600/10", on);
          b.classList.toggle("border-transparent", !on);
          b.classList.toggle("bg-slate-100/60", !on);
          var dot = b.querySelector(".valuasi-dot");
          dot.classList.toggle("bg-blue-600", on);
          dot.classList.toggle("text-white", on);
          dot.classList.toggle("bg-slate-300", !on);
          dot.classList.toggle("text-transparent", !on);
        });
      }
      valBtns.forEach(function (b) {
        if (b.getAttribute("data-valuasi") === "fifo") b.setAttribute("data-selected", "");
        b.addEventListener("click", function () {
          valBtns.forEach(function (x) { x.removeAttribute("data-selected"); });
          b.setAttribute("data-selected", "");
          paintValuasi();
          window.aiToast("Metode valuasi: " + (b.getAttribute("data-valuasi") === "fifo" ? "FIFO (First In, First Out)" : "Average Moving Cost") + " dipilih.", "info");
        });
      });
      paintValuasi();

      /* Toggle otomatisasi persetujuan */
      var swAuto = document.getElementById("swAutoApprove");
      if (swAuto) swAuto.addEventListener("ai:switch", function (e) {
        window.aiToast(e.detail.on ? "Otomatisasi persetujuan < Rp 5.000.000 diaktifkan." : "Otomatisasi persetujuan dimatikan — semua DO butuh approval manual.", e.detail.on ? "success" : "warn");
      });

      /* Simpan perubahan */
      var btnSave = document.getElementById("btnSimpan");
      if (btnSave) btnSave.addEventListener("click", function () {
        window.aiToast("Semua perubahan konfigurasi berhasil disimpan & tercatat di audit trail.", "success");
      });

      /* Kembalikan default */
      var btnReset = document.getElementById("btnReset");
      if (btnReset) btnReset.addEventListener("click", function () {
        window.aiToast("Peringatan: konfigurasi akan dikembalikan ke default pabrik — review sebelum simpan!", "warn");
      });

      /* Test print */
      var btnPrint = document.getElementById("btnTestPrint");
      if (btnPrint) btnPrint.addEventListener("click", function () {
        window.aiToast("Test label dikirim ke Zebra ZD230 — cetakan keluar dari Dock Inbound 01.", "success");
      });

      /* Backup manual + progress */
      var btnBackup = document.getElementById("btnBackup");
      var wrap = document.getElementById("backupProgress");
      var bar = document.getElementById("backupBar");
      var pct = document.getElementById("backupPct");
      if (btnBackup) btnBackup.addEventListener("click", function () {
        window.aiToast("Backup manual dimulai — arsip SQL + Blob dikompresi & terenkripsi.", "success");
        wrap.style.display = "block";
        var p = 0;
        bar.style.width = "0%";
        var iv = setInterval(function () {
          p += Math.random() * 18 + 6;
          if (p >= 100) {
            p = 100;
            clearInterval(iv);
            window.aiToast("Backup manual selesai — 1.42 GB tersimpan ke AWS S3 (ap-southeast-3).", "success");
            setTimeout(function () { wrap.style.display = "none"; }, 1600);
          }
          bar.style.width = p + "%";
          pct.textContent = Math.round(p) + "%";
        }, 260);
      });
})();
  </script>

</body>
</html>
