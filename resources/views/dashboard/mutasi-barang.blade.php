<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mutasi Barang - Astro Inventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = {"theme":{"extend":{"fontFamily":{"sans":["Inter","sans-serif"]},"colors":{"brand":"#0b49d8","ink":"#17243b","canvas":"#f5f7fc","line":"#e8edf5"}}}};</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Astro Inventory Design System */
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

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 9px;
            height: 9px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cdd6e4;
            border-radius: 99px;
            border: 2px solid #f5f7fb;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #aab8cf;
        }

        /* Entrance Animations */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .anim-fade-up {
            animation: fadeUp 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        .anim-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .anim-slide-in {
            animation: slideIn 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        }

        /* Delay classes */
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }

        /* Cards */
        .metric-card {
            transition: transform 0.25s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.25s;
        }
        .metric-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px -12px rgba(37, 99, 235, 0.22), 0 4px 10px rgba(15, 23, 42, 0.06);
        }

        /* Nav links */
        .nav-link {
            transition: all 0.16s ease;
        }
        .nav-link:hover {
            background: #f1f5f9;
            color: #172033;
            transform: translateX(3px);
        }
        .nav-link.active {
            background: var(--brand);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 6px 14px -6px rgba(37, 99, 235, 0.55);
        }
        .nav-link.active:hover {
            transform: none;
            background: var(--brand);
        }

        /* Pulse animation */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        .badge-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Progress bar */
        @keyframes progressFill {
            from { width: 0; }
        }
        .progress-bar div {
            animation: progressFill 1s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        /* Panel */
        .panel {
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.05);
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
        }

        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 6px;
        }
    </style>
</head>
<body class="bg-gray-50">

@include('components.navbar')

<div class="flex min-h-screen">
    @include('components.sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-4 lg:p-6 overflow-x-hidden">

        {{-- ================= SUPER ADMIN (SuperAdmin/mutasi_barang.html) ================= --}}
        @if(auth()->user()->isSuperAdmin())
        <style>
*{box-sizing:border-box}body{font-family:Inter,sans-serif}.reveal{animation:rise-in .4s cubic-bezier(.2,.8,.2,1) both}.delay-1{animation-delay:50ms}.delay-2{animation-delay:100ms}.delay-3{animation-delay:150ms}.data-row{animation:row-in .25s ease both}.soft-button{transition:transform .16s ease,box-shadow .16s ease}.soft-button:hover{transform:translateY(-1px);box-shadow:0 4px 10px rgba(15,23,42,.08)}@keyframes rise-in{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}@keyframes row-in{from{opacity:0;transform:translateX(-4px)}to{opacity:1;transform:translateX(0)}}
    @media (min-width: 768px) {
      body { zoom: 1.15; }
    }@media(prefers-reduced-motion:reduce){*,*::before,*::after{scroll-behavior:auto!important;animation-duration:.01ms!important;animation-iteration-count:1!important;transition-duration:.01ms!important}}
      #records > tr.data-row { height: 60px; }
        </style>
        <script src="https://unpkg.com/lucide@latest"></script>
  <div id="main-area" class="min-h-screen">
    <div class="bg-canvas p-4 lg:p-5">
      <section class="reveal mb-4 flex flex-wrap items-end justify-between gap-3"><div class="max-w-2xl"><p class="mb-1 text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Operasional & Transaksi <span class="text-blue-700">&gt; Mutasi Barang Internal & Antar-Hub</span></p><h1 class="text-[24px] font-bold text-slate-800 md:text-[24px]">Mutasi Barang (Stock Transfer & Relokasi)</h1><p class="mt-1 text-[10.5px] leading-relaxed text-slate-500">Pengelolaan perpindahan stok internal antar-rak, antar-zona gudang, serta transfer mutasi antar-hub operasional DC secara presisi dan tercatat real-time.</p></div><div class="flex flex-wrap items-center gap-2"><span class="hidden rounded-full bg-blue-50 px-3 py-1 text-[10.5px] font-semibold text-blue-700 xl:inline-flex">8 Mutasi Dalam Perjalanan</span><button id="export-data" class="soft-button flex h-10 items-center gap-2 rounded-md border bg-white px-4 text-[12px] font-semibold"><i data-lucide="download" class="h-4 w-4 text-blue-600"></i>Ekspor Riwayat Mutasi</button><button data-toast="Jadwal shuttle antar-hub tersedia." class="soft-button flex h-10 items-center gap-2 rounded-md border bg-white px-4 text-[12px] font-semibold"><i data-lucide="calendar-clock" class="h-4 w-4 text-blue-600"></i>Jadwal Shuttle Antar-Hub</button><button id="add-record" class="soft-button flex h-10 items-center gap-2 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white"><i data-lucide="plus" class="h-4 w-4"></i>Buat Mutasi Barang Baru</button></div></section>
      <section aria-label="Ringkasan mutasi" class="reveal delay-1 mb-4 grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
        <article class="flex min-h-[112px] items-start justify-between rounded-xl bg-white px-4 py-3 shadow-sm"><div><p class="text-[9.5px] font-semibold uppercase text-slate-500">Total Mutasi Hari Ini</p><p class="mt-1.5 text-[24px] font-bold">428 Unit</p><p class="mt-2.5 text-[10.5px] text-blue-700">↗ 12.5% vs kemarin</p></div><span class="flex h-8 w-8 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="arrow-left-right" class="h-4 w-4"></i></span></article>
        <article class="flex min-h-[112px] items-start justify-between rounded-xl bg-white px-4 py-3 shadow-sm"><div><p class="text-[9.5px] font-semibold uppercase text-slate-500">Transfer Sedang Berjalan</p><p class="mt-1.5 text-[24px] font-bold">9 Berkas MT</p><p class="mt-2.5 text-[10.5px] text-slate-500">5 Antar-Hub · 4 Intra-Gudang</p></div><span class="flex h-8 w-8 items-center justify-center rounded-md bg-emerald-50 text-emerald-700"><i data-lucide="truck" class="h-4 w-4"></i></span></article>
        <article class="flex min-h-[112px] items-start justify-between rounded-xl bg-white px-4 py-3 shadow-sm"><div><p class="text-[9.5px] font-semibold uppercase text-slate-500">Akurasi Bin-to-Bin Scan</p><p class="mt-1.5 text-[24px] font-bold">99.9%</p><p class="mt-2.5 text-[10.5px] text-emerald-700">✓ Zero Discrepancy</p></div><span class="flex h-8 w-8 items-center justify-center rounded-md bg-emerald-50 text-emerald-700"><i data-lucide="scan-line" class="h-4 w-4"></i></span></article>
        <article class="flex min-h-[112px] items-start justify-between rounded-xl bg-white px-4 py-3 shadow-sm"><div><p class="text-[9.5px] font-semibold uppercase text-amber-700">Menunggu Konfirmasi Penerima</p><p class="mt-1.5 text-[24px] font-bold">3 Berkas</p><p class="mt-2.5 text-[10.5px] text-slate-500">Barang tiba di hub tujuan</p></div><span class="flex h-8 w-8 items-center justify-center rounded-md bg-amber-50 text-amber-700"><i data-lucide="clock-3" class="h-4 w-4"></i></span></article>
      </section>
      <section class="reveal delay-2 mb-4 rounded-xl border border-slate-100 bg-white p-3 shadow-sm"><div class="mb-3 flex items-center justify-between"><h2 class="flex items-center gap-2 text-[12px] font-semibold"><i data-lucide="route" class="h-4 w-4 text-blue-600"></i>Status Alur Mutasi Aktif & Shuttle Antar-Hub</h2><button data-toast="Peta distribusi transfer antar-hub." class="text-[10.5px] font-semibold text-blue-600">Lihat Peta Rute Distribusi & Tracking →</button></div><div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-lg bg-blue-50/70 p-3"><div class="flex justify-between text-[10.5px]"><b>MT-2025-0142</b><span class="text-blue-700">Antar-Hub</span></div><b class="mt-2 block text-[12px]">Hub Cabang DC-01 → Hub Surabaya DC-02</b><p class="text-[10.5px] text-slate-500">Armada Van Shuttle · B 6421 KZ</p><div class="mt-2 h-1 rounded bg-blue-100"><div class="h-full w-[62%] rounded bg-blue-600"></div></div></article>
        <article class="rounded-lg bg-blue-50/70 p-3"><div class="flex justify-between text-[10.5px]"><b>MT-2025-0143</b><span class="text-emerald-700">Intra-Gudang</span></div><b class="mt-2 block text-[12px]">Zona A (High-Value) → Zona C (Picking Area)</b><p class="text-[10.5px] text-slate-500">Rak Tier 1 → Rak Tier 2</p><div class="mt-2 h-1 rounded bg-blue-100"><div class="h-full w-[92%] rounded bg-emerald-600"></div></div></article>
        <article class="rounded-lg bg-blue-50/70 p-3"><div class="flex justify-between text-[10.5px]"><b>MT-2025-0144</b><span class="text-blue-700">Antar-Hub</span></div><b class="mt-2 block text-[12px]">Hub Cabang DC-01 → Hub Bandung DC-03</b><p class="text-[10.5px] text-slate-500">2.500 Unit SKU & Aksesoris</p><div class="mt-2 h-1 rounded bg-blue-100"><div class="h-full w-[35%] rounded bg-blue-600"></div></div></article>
        <article class="rounded-lg bg-blue-50/70 p-3"><div class="flex justify-between text-[10.5px]"><b>MT-2025-0145</b><span class="text-violet-700">Antar-Zona</span></div><b class="mt-2 block text-[12px]">Zona E (Buffer Inbound) → Zona B (Aksesoris)</b><p class="text-[10.5px] text-slate-500">Handheld Pallet Hop-05</p><div class="mt-2 h-1 rounded bg-blue-100"><div class="h-full w-[72%] rounded bg-violet-600"></div></div></article>
      </div></section>
      <section class="reveal delay-2 mb-4 rounded-xl border border-slate-100 bg-white p-3 shadow-sm"><div class="flex flex-wrap items-center gap-2"><label class="flex h-10 min-w-[220px] flex-1 items-center gap-2 rounded-md bg-blue-50/80 px-3 text-slate-400 xl:max-w-[400px]"><i data-lucide="search" class="h-4 w-4"></i><input id="search-input" type="search" placeholder="Cari No. Mutasi, SKU, asal/tujuan, PIC..." class="w-full bg-transparent text-[12px] outline-none"></label><select id="type-filter" class="h-10 rounded-md bg-blue-50 px-3 text-[12px]"><option value="">Tipe Mutasi Semua</option><option>Antar-Hub</option><option>Intra-Gudang</option><option>Antar-Zona</option><option>Antar-Departemen</option></select><select id="status-filter" class="h-10 rounded-md bg-blue-50 px-3 text-[12px]"><option value="">Status Mutasi Semua</option><option>Selesai Diterima</option><option>Selesai Relokasi</option><option>Dalam Perjalanan</option><option>Proses Pindah</option><option>Menunggu Konfirmasi</option></select><select id="zone-filter" class="h-10 rounded-md bg-blue-50 px-3 text-[12px]"><option value="">Zona Semua Zona</option><option>WH01</option><option>WH02</option><option>WH03</option></select><button id="reset-filters" aria-label="Reset filter" class="flex h-10 w-10 items-center justify-center rounded-md bg-blue-50"><i data-lucide="rotate-cw" class="h-4 w-4"></i></button></div><div class="mt-3 flex flex-wrap gap-2 text-[10.5px]"><button data-quick="all" class="rounded-full bg-blue-600 px-3 py-1 text-[10.5px] text-white">Semua Mutasi (24)</button><button data-quick="Selesai Diterima" class="rounded-full bg-slate-100 px-3 py-1 text-[10.5px]">Selesai & Diterima (15)</button><button data-quick="Dalam Perjalanan" class="rounded-full bg-slate-100 px-3 py-1 text-[10.5px]">Dalam Perjalanan / Transit (5)</button><button data-quick="Proses Pindah" class="rounded-full bg-slate-100 px-3 py-1 text-[10.5px]">Proses Pindah Rak (3)</button><button data-quick="Menunggu Konfirmasi" class="rounded-full bg-violet-50 px-3 py-1 text-[10.5px] text-violet-700">Menunggu Persetujuan (1)</button></div></section>
      <section class="reveal delay-3 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm"><div class="overflow-x-auto"><table class="w-full min-w-[1300px] table-fixed text-left"><thead class="h-11 bg-[#f0f4fc] text-[9.5px] font-semibold uppercase whitespace-nowrap text-slate-600"><tr><th class="w-[100px] px-2"><input id="select-all" type="checkbox" aria-label="Pilih semua mutasi" class="h-4 w-4 accent-blue-600"></th><th class="w-[180px] px-2">No. Mutasi & Tanggal</th><th class="w-[180px] px-2">Tipe Mutasi</th><th class="w-[230px] px-2">Lokasi Asal & Tujuan</th><th class="w-[220px] px-2">Detail Komoditas / SKU</th><th class="w-[110px] px-2">Total Qty</th><th class="w-[140px] px-2">PIC Pengirim / Penerima</th><th class="w-[150px] px-2">Status Mutasi & QC</th><th class="w-[50px] px-2">Aksi</th></tr></thead><tbody id="records" class="divide-y divide-slate-100 text-[12px]"></tbody></table></div><footer class="flex flex-wrap items-center justify-between gap-2 border-t px-4 py-3 text-[12px]"><span id="row-count" aria-live="polite"></span><div class="flex gap-1"><button id="prev" class="h-8 min-w-8 rounded bg-blue-50 px-2 text-[12px] disabled:opacity-40">‹</button><div id="pages" class="flex gap-1"></div><button id="next" class="h-8 min-w-8 rounded bg-blue-50 px-2 text-[12px] disabled:opacity-40">›</button></div></footer></section>
      <section class="reveal delay-3 mt-4 grid grid-cols-1 gap-3 lg:grid-cols-3"><article class="flex min-h-[60px] flex-col justify-between rounded-xl border bg-white px-4 py-3"><h2 class="text-[12px] font-semibold">Validasi Barcode 2 Titik (Origin & Destination)</h2><p class="mt-1 text-[10.5px] text-slate-500">Pindai lokasi asal dan tujuan untuk validasi perpindahan bin.</p><button data-toast="Scanner handheld siap untuk validasi barcode." class="mt-3 text-[10.5px] font-semibold text-blue-600">Buka Scanner Handheld →</button></article><article class="flex min-h-[60px] flex-col justify-between rounded-xl border bg-white px-4 py-3"><h2 class="text-[12px] font-semibold">SOP Mutasi Antar-Hub & Segel Kontainer</h2><p class="mt-1 text-[10.5px] text-slate-500">Standar keamanan dan serah terima barang selama transit antar-hub.</p><button data-toast="Dokumen SOP mutasi tersedia." class="mt-3 text-[10.5px] font-semibold text-emerald-700">Unduh Dokumen SOP →</button></article><article class="flex min-h-[60px] flex-col justify-between rounded-xl border bg-white px-4 py-3"><h2 class="text-[12px] font-semibold">Integrasi Berita Acara Mutasi Otomatis (BAMO)</h2><p class="mt-1 text-[10.5px] text-slate-500">Dokumentasi mutasi dan rekonsiliasi stok otomatis setelah diterima.</p><button data-toast="Audit mutasi diperbarui." class="mt-3 text-[10.5px] font-semibold text-amber-700">Log Audit Mutasi →</button></article></section>
    </div>
  </div>
  <div id="record-modal" class="fixed inset-0 z-[70] hidden items-center justify-center bg-slate-950/40 p-4"><form id="record-form" class="max-h-[90vh] w-full max-w-[500px] overflow-y-auto rounded-xl bg-white p-4 shadow-xl"><div class="mb-4 flex justify-between"><div><h2 class="text-[12px] font-bold">Buat Mutasi Barang Baru</h2><p class="mt-1 text-[10.5px] text-slate-500">Catat relokasi stok dan penanggung jawab.</p></div><button type="button" id="close-modal" aria-label="Tutup"><i data-lucide="x" class="h-4 w-4"></i></button></div><div class="grid gap-3 sm:grid-cols-2"><label class="text-[12px]">Tipe mutasi<select name="type" required class="mt-1 w-full h-10 rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500"><option>Intra-Gudang</option><option>Antar-Zona</option><option>Antar-Hub</option><option>Antar-Departemen</option></select></label><label class="text-[12px]">Jumlah<input name="quantity" required maxlength="30" class="mt-1 w-full h-10 rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="40 Unit"></label><label class="text-[12px]">Lokasi asal<input name="origin" required maxlength="40" class="mt-1 w-full h-10 rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="WH01-ZA-RA01"></label><label class="text-[12px]">Lokasi tujuan<input name="destination" required maxlength="40" class="mt-1 w-full h-10 rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="WH01-ZB-RB02"></label><label class="text-[12px] sm:col-span-2">Barang / SKU<input name="item" required maxlength="100" class="mt-1 w-full h-10 rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500"></label><label class="text-[12px] sm:col-span-2">PIC penanggung jawab<input name="pic" required maxlength="70" class="mt-1 w-full h-10 rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500"></label></div><div class="mt-5 flex justify-end gap-2"><button type="button" id="cancel-modal" class="h-10 rounded-md border border-slate-200 px-4 text-[12px]">Batal</button><button class="h-10 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white">Simpan Mutasi</button></div></form></div>
  <div id="toast" role="status" class="fixed bottom-4 right-4 z-[80] hidden rounded-lg bg-slate-900 px-4 py-3 text-[12px] text-white shadow-lg"></div>

        <script>
(function () {
      if (!document.querySelector('#main-area')) return;
    const records=[
      {id:'MT-2025-0140',date:'12 Mar 2025 · 08:30',type:'Antar-Hub',origin:'Hub Cabang DC-01',destination:'Hub Surabaya DC-02',item:'Macbook Pro M1 2020',sku:'SKU-LAP-M102',qty:'40 Unit',pic:'Ir. Bambang S. → Hendra W.',status:'Selesai Diterima',zone:'WH01'},
      {id:'MT-2025-0141',date:'12 Mar 2025 · 09:15',type:'Intra-Gudang',origin:'WH01-ZA-RA01',destination:'WH01-ZC-RC02',item:'Sandisk SSD NVMe 1TB',sku:'SKU-STR-SD01',qty:'120 Unit',pic:'Hendra W. → Agus S.',status:'Selesai Relokasi',zone:'WH01'},
      {id:'MT-2025-0142',date:'12 Mar 2025 · 10:00',type:'Antar-Hub',origin:'Hub Cabang DC-01',destination:'Hub Bandung DC-03',item:'Sony WH-1000XM4 Audio',sku:'SKU-AUD-SN09',qty:'85 Unit',pic:'Rizky Pratama → Hendra K.',status:'Dalam Perjalanan',zone:'WH01'},
      {id:'MT-2025-0143',date:'12 Mar 2025 · 10:25',type:'Intra-Gudang',origin:'WH02-ZD-RD01',destination:'WH02-ZB-RB01',item:'Mechanical Keyboard RGB',sku:'SKU-KEY-MK01',qty:'50 Unit',pic:'Maya Anggraini → Dedi K.',status:'Proses Pindah',zone:'WH02'},
      {id:'MT-2025-0144',date:'12 Mar 2025 · 10:45',type:'Antar-Hub',origin:'Hub Cabang DC-01',destination:'Hub Semarang DC-04',item:'Canon 60D Body & Optical Lens',sku:'SKU-CAM-60D',qty:'25 Unit',pic:'Rina Marlina → Dedi S.',status:'Dalam Perjalanan',zone:'WH01'},
      {id:'MT-2025-0145',date:'12 Mar 2025 · 11:10',type:'Antar-Zona',origin:'Buffer Dock 02',destination:'Zona E (Buffer Inbound)',item:'Barcode Scanner & Printer Label',sku:'SKU-SCN-ZB01',qty:'60 Unit',pic:'Yusuf Maulana → Kusnadi',status:'Menunggu Konfirmasi',zone:'WH02'},
      {id:'MT-2025-0146',date:'12 Mar 2025 · 11:30',type:'Antar-Departemen',origin:'Hub DC-01',destination:'Divisi IT & Infra',item:'Wireless Mouse & Periferal',sku:'SKU-MOU-MS01',qty:'30 Unit',pic:'Adrian Pratama → Bambang S.',status:'Selesai Diterima',zone:'WH01'},
      {id:'MT-2025-0147',date:'12 Mar 2025 · 11:55',type:'Intra-Gudang',origin:'WH01-ZB-RB03',destination:'WH01-ZA-RA05',item:'USB-C Docking Station',sku:'SKU-ACC-DOCK',qty:'22 Unit',pic:'Dedi K. → Hendra W.',status:'Dalam Perjalanan',zone:'WH01'},
      {id:'MT-2025-0148',date:'12 Mar 2025 · 12:15',type:'Antar-Hub',origin:'Hub DC-01',destination:'Hub Bandung DC-03',item:'Laptop Workstation Pro',sku:'SKU-LAP-WKS2',qty:'12 Unit',pic:'Bambang S. → Rina M.',status:'Selesai Diterima',zone:'WH03'}
    ];
    const host=document.getElementById('records'),search=document.getElementById('search-input'),global=document.getElementById('global-search'),type=document.getElementById('type-filter'),status=document.getElementById('status-filter'),zone=document.getElementById('zone-filter');let filtered=[...records],page=1,quick='all',timer;const size=7,esc=s=>String(s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    function render(){const start=(page-1)*size,items=filtered.slice(start,start+size);host.innerHTML=items.map((r,i)=>{const tone=r.status.startsWith('Selesai')?'bg-emerald-50 text-emerald-700':r.status==='Dalam Perjalanan'?'bg-blue-50 text-blue-700':r.status==='Proses Pindah'?'bg-amber-50 text-amber-700':'bg-violet-50 text-violet-700';return `<tr class="data-row h-[60px] hover:bg-slate-50" style="animation-delay:${i*20}ms" data-id="${esc(r.id)}"><td class="px-2"><input class="row-check h-4 w-4 accent-blue-600" type="checkbox" aria-label="Pilih ${esc(r.id)}"></td><td class="px-2"><b class="text-blue-700">${esc(r.id)}</b><span class="block text-[10.5px] text-slate-500">${esc(r.date)}</span></td><td class="px-2"><span class="rounded bg-blue-50 px-1.5 py-1 text-[10.5px] text-blue-700">${esc(r.type)}</span></td><td class="px-2"><b class="block text-[12px]">${esc(r.origin)}</b><span class="text-[10.5px] text-slate-500">↓ ${esc(r.destination)}</span></td><td class="px-2"><b class="block text-[12px]">${esc(r.item)}</b><span class="text-[10.5px] text-slate-500">${esc(r.sku)}</span></td><td class="px-2"><b class="text-[12px]">${esc(r.qty)}</b><span class="block text-[10.5px] text-slate-500">Unit tervalidasi</span></td><td class="px-2 text-[10.5px]">${esc(r.pic)}</td><td class="px-2"><span class="rounded-full ${tone} px-2 py-1 text-[10.5px] font-semibold">${esc(r.status)}</span><span class="mt-1 block text-[10.5px] text-slate-500">Barcode origin & tujuan</span></td><td class="px-2 text-center"><button data-view aria-label="Lihat ${esc(r.id)}" class="rounded p-1.5 text-slate-500 hover:bg-slate-100 hover:text-blue-600"><i data-lucide="file-text" class="h-4 w-4"></i></button></td></tr>`}).join('');if (window.lucide) lucide.createIcons();document.getElementById('row-count').textContent=filtered.length?`Menampilkan ${start+1} - ${Math.min(start+size,filtered.length)} dari ${filtered.length} transaksi mutasi`:'Tidak ada mutasi yang sesuai';const n=Math.max(1,Math.ceil(filtered.length/size)),box=document.getElementById('pages');box.innerHTML='';for(let i=1;i<=n;i++){const b=document.createElement('button');b.textContent=i;b.className=`h-8 min-w-8 rounded px-2 text-[12px] ${i===page?'bg-blue-600 text-white':'hover:bg-blue-50'}`;b.onclick=()=>{page=i;render()};box.append(b)}document.getElementById('prev').disabled=page===1;document.getElementById('next').disabled=page===n}
    function apply(){const q=(search.value+' '+(global?global.value:'')).trim().toLowerCase();filtered=records.filter(r=>(!q||Object.values(r).join(' ').toLowerCase().includes(q))&&(!type.value||r.type===type.value)&&(!status.value||r.status===status.value)&&(!zone.value||r.zone===zone.value)&&(quick==='all'||r.status===quick));page=1;render()}
    [search,global].filter(Boolean).forEach(x=>x.addEventListener('input',apply));[type,status,zone].forEach(x=>x.addEventListener('change',apply));document.getElementById('prev').onclick=()=>{if(page>1){page--;render()}};document.getElementById('next').onclick=()=>{if(page<Math.ceil(filtered.length/size)){page++;render()}};document.querySelectorAll('[data-quick]').forEach(b=>b.onclick=()=>{quick=b.dataset.quick;search.value='';if(global)global.value='';type.value='';status.value='';zone.value='';document.querySelectorAll('[data-quick]').forEach(x=>x.className=x===b?'rounded-full bg-blue-600 px-3 py-1 text-[10.5px] text-white':'rounded-full bg-slate-100 px-3 py-1 text-[10.5px]');apply()});document.getElementById('reset-filters').onclick=()=>{search.value='';if(global)global.value='';type.value='';status.value='';zone.value='';quick='all';document.querySelectorAll('[data-quick]').forEach((x,i)=>x.className=i===0?'rounded-full bg-blue-600 px-3 py-1 text-[10.5px] text-white':'rounded-full bg-slate-100 px-3 py-1 text-[10.5px]');apply()};
    document.getElementById('select-all').onchange=e=>document.querySelectorAll('.row-check').forEach(x=>x.checked=e.target.checked);host.addEventListener('change',e=>{if(e.target.matches('.row-check')&&!e.target.checked)document.getElementById('select-all').checked=false});function toast(m){const t=document.getElementById('toast');t.textContent=m;t.classList.remove('hidden');clearTimeout(timer);timer=setTimeout(()=>t.classList.add('hidden'),2500)}document.querySelectorAll('[data-toast]').forEach(b=>b.onclick=()=>toast(b.dataset.toast));host.onclick=e=>{const b=e.target.closest('[data-view]');if(b){const r=records.find(x=>x.id===b.closest('tr').dataset.id);toast(`Mutasi ${r.id}: ${r.origin} → ${r.destination}`)}};
    const modal=document.getElementById('record-modal'),form=document.getElementById('record-form');document.getElementById('add-record').onclick=()=>{modal.classList.remove('hidden');modal.classList.add('flex');document.body.classList.add('overflow-hidden')};function close(){modal.classList.add('hidden');modal.classList.remove('flex');document.body.classList.remove('overflow-hidden')}['close-modal','cancel-modal'].forEach(id=>document.getElementById(id).onclick=close);modal.onclick=e=>{if(e.target===modal)close()};document.addEventListener('keydown',e=>{if(e.key==='Escape')close()});form.onsubmit=e=>{e.preventDefault();if(!form.reportValidity())return;const f=new FormData(form);records.unshift({id:`MT-2025-${String(Date.now()).slice(-4)}`,date:'12 Mar 2025 · Baru',type:String(f.get('type')),origin:String(f.get('origin')).trim().toUpperCase(),destination:String(f.get('destination')).trim().toUpperCase(),item:String(f.get('item')).trim(),sku:'SKU mutasi baru',qty:String(f.get('quantity')).trim(),pic:String(f.get('pic')).trim(),status:'Dalam Perjalanan',zone:String(f.get('origin')).slice(0,4).toUpperCase()});form.reset();close();quick='all';apply();toast('Mutasi baru dicatat dan masuk pemantauan.')};
    document.getElementById('export-data').onclick=()=>{const cols=['No Mutasi','Tanggal','Tipe','Asal','Tujuan','Barang','SKU','Jumlah','PIC','Status'];const cell=v=>`"${String(v).replace(/"/g,'""')}"`,csv=[cols,...filtered.map(r=>[r.id,r.date,r.type,r.origin,r.destination,r.item,r.sku,r.qty,r.pic,r.status])].map(r=>r.map(cell).join(',')).join('\r\n'),a=document.createElement('a');a.href=URL.createObjectURL(new Blob(['\uFEFF',csv],{type:'text/csv;charset=utf-8'}));a.download='riwayat-mutasi-barang.csv';a.click();URL.revokeObjectURL(a.href)};render();
    })();
        </script>
        @endif

        {{-- ================= KEPALA GUDANG (KepalaGudang/mutasi-barang.html) ================= --}}
        @if(auth()->user()->isKepalaGudang())
        <style>
/* ============================================================
   ASTRO Inventory — Shared Design System
   Tailwind CDN + Font Awesome. Component-level styles only.
   ============================================================ */

* { box-sizing: border-box; }
html, body { margin: 0; padding: 0; }
body {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
  overflow-x: hidden;
  background-color: #f8f9ff;
  color: #0b1c30;
}

/* ---------- Layout shell ---------- */
.main-area { flex: 1; min-width: 0; }

/* ---------- Cards ---------- */
.metric-card { transition: transform .2s ease, box-shadow .2s ease; }
.metric-card:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(0,0,0,.15); }
.panel { background:#fff; border:1px solid #e5eeff; border-radius:.5rem; box-shadow:0 1px 2px rgba(16,24,40,.04); }

/* ---------- Tables ---------- */
.table-row { transition: background-color .15s ease; }
.table-row:hover { background-color: #f9fafb; }

/* ---------- Filter chips ---------- */
.filter-tag { transition: background-color .15s ease; }
.filter-tag:hover { background-color: #dbeafe; }

/* ---------- Progress ---------- */
.progress-bar { transition: width .5s ease; }

/* ---------- Tabs ---------- */
.tab-btn { transition: all .15s ease; }
.tab-btn.active { background:#2563eb; color:#fff; }

/* ---------- Badges ---------- */
.badge { display:inline-flex; align-items:center; gap:.25rem; padding:.125rem .625rem; border-radius:9999px; font-size:.75rem; font-weight:600; }

/* ---------- Modal ---------- */
.modal-overlay { position:fixed; inset:0; background:rgba(11,28,48,.55); display:none; align-items:flex-start; justify-content:center; z-index:80; padding: 5vh 1rem 1rem; overflow-y:auto; }
.modal-overlay.open { display:flex; }
.modal-box { background:#fff; border-radius:.75rem; width:100%; max-width:640px; box-shadow:0 20px 50px -10px rgba(0,0,0,.35); animation: modalIn .18s ease; }
@keyframes modalIn { from{opacity:0; transform:translateY(12px) scale(.98);} to{opacity:1; transform:none;} }

/* ---------- Dropdown ---------- */
.dropdown { position:absolute; top:calc(100% + 6px); right:0; background:#fff; border:1px solid #e5eeff; border-radius:.5rem; box-shadow:0 10px 25px -5px rgba(0,0,0,.18); min-width:260px; z-index:70; display:none; }
.dropdown.open { display:block; }

/* ---------- Toast ---------- */
#toast-container { position:fixed; right:1rem; bottom:1rem; z-index:100; display:flex; flex-direction:column; gap:.5rem; }
.toast { background:#fff; border:1px solid #e5eeff; border-left:4px solid #2563eb; border-radius:.5rem; padding:.75rem 1rem; box-shadow:0 8px 20px -6px rgba(0,0,0,.2); font-size:.875rem; color:#0b1c30; animation: toastIn .2s ease; max-width:340px; }
.toast.success { border-left-color:#16a34a; }
.toast.warn { border-left-color:#f59e0b; }
.toast.error { border-left-color:#dc2626; }
@keyframes toastIn { from{opacity:0; transform:translateX(20px);} to{opacity:1; transform:none;} }

/* ---------- Misc helpers ---------- */
.anim-fade-up { animation: fadeUp .35s ease both; }
@keyframes fadeUp { from{opacity:0; transform:translateY(10px);} to{opacity:1; transform:none;} }
.no-scrollbar::-webkit-scrollbar { display:none; }
        </style>
  <div class="main-area p-4 lg:p-6 overflow-x-hidden">
<!-- Top status -->
<div class="flex flex-wrap items-center gap-2 text-xs mb-3">
  <span class="font-semibold tracking-wide text-gray-500">OPERASIONAL &amp; TRANSAKSI</span><i class="fas fa-chevron-right text-[9px] text-gray-400"></i>
  <span class="text-blue-600 font-semibold">MUTASI BARANG (INTERNAL &amp; ANTAR-HUB)</span>
  <span class="ml-auto flex flex-wrap items-center gap-2">
    <span class="badge bg-blue-50 text-blue-700"><i class="fas fa-circle" style="font-size:5px"></i><b>8 Mutasi Dalam Perjalanan</b></span>
    <span class="badge bg-emerald-50 text-emerald-700">SLA Pemindahan Rak <b>99.1%</b></span>
    <span class="badge bg-slate-100 text-slate-600">Sinkronisasi Inventaris Real-Time</span>
  </span>
</div>

<!-- Page header -->
<div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-6 anim-fade-up">
  <div class="flex items-start gap-3">
    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm"><i class="fas fa-right-left text-white text-lg"></i></div>
    <div>
      <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Mutasi Barang (Stock Transfer &amp; Relokasi)</h1>
      <p class="text-sm text-gray-600 max-w-2xl">Pengelolaan perpindahan stok internal antar-rak, antar-zona gudang, serta transfer mutasi antar-hub operasional DC secara presisi dan tercatat real-time.</p>
    </div>
  </div>
  <div class="flex flex-wrap items-start gap-2">
    <button data-toast="Riwayat mutasi diekspor (90 hari terakhir)..." class="px-3.5 py-2 border border-gray-300 bg-white rounded-lg hover:bg-gray-50 text-sm flex items-center gap-2 transition"><i class="fas fa-download text-blue-600"></i>Ekspor Riwayat Mutasi</button>
    <button data-toast="Jadwal shuttle antar-hub dibuka..." class="px-3.5 py-2 border border-gray-300 bg-white rounded-lg hover:bg-gray-50 text-sm flex items-center gap-2 transition"><i class="fas fa-van-shuttle text-blue-600"></i>Jadwal Shuttle Antar-Hub</button>
    <button data-open-modal="modalBuat" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm flex items-center gap-2 transition shadow-sm"><i class="fas fa-plus"></i>+ Buat Mutasi Barang Baru</button>
  </div>
</div>

<!-- KPI cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6 anim-fade-up">
  <div class="metric-card panel p-4 lg:p-5">
    <div class="flex items-start justify-between mb-2">
      <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-right-left text-blue-600"></i></div>
      <span class="badge bg-emerald-50 text-emerald-700"><i class="fas fa-arrow-trend-up"></i>+14,2% vs Kemarin</span>
    </div>
    <p class="text-3xl font-extrabold text-gray-900 mt-2"><span data-count="428" data-num="dot"></span> <span class="text-base font-semibold text-gray-500">Unit</span></p>
    <p class="text-sm font-semibold text-gray-600 mt-1">Total Mutasi Hari Ini</p>
    <p class="text-xs text-gray-500 mt-1"><span class="w-1.5 h-1.5 bg-blue-500 rounded-full inline-block"></span> <b>18 Mutasi Selesai Dipindahkan</b></p>
  </div>
  <div class="metric-card panel p-4 lg:p-5">
    <div class="flex items-start justify-between mb-2">
      <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-file-lines text-blue-600"></i></div>
      <span class="badge bg-green-100 text-green-700"><i class="fas fa-check"></i>97,8% Tepat Waktu</span>
    </div>
    <p class="text-3xl font-extrabold text-gray-900 mt-2"><span data-count="9"></span> <span class="text-base font-semibold text-gray-500">Berkas MT</span></p>
    <p class="text-sm font-semibold text-gray-600 mt-1">Transfer Sedang Berjalan</p>
    <p class="text-xs text-gray-500 mt-1"><span class="w-1.5 h-1.5 bg-blue-500 rounded-full inline-block"></span> <b>5 Antar-Hub</b> + 4 Intra-Gudang (Rak)</p>
  </div>
  <div class="metric-card panel p-4 lg:p-5">
    <div class="flex items-start justify-between mb-2">
      <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center"><i class="fas fa-shield-halved text-emerald-600"></i></div>
      <span class="badge bg-emerald-50 text-emerald-700"><i class="fas fa-shield"></i>Zero Discrepancy</span>
    </div>
    <p class="text-3xl font-extrabold text-gray-900 mt-2"><span data-count="99.9" data-dec="1"></span><span class="text-lg font-bold">%</span></p>
    <p class="text-sm font-semibold text-gray-600 mt-1">Akurasi Bin-to-Bin Scan</p>
    <p class="text-xs text-gray-500 mt-1"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full inline-block"></span> Pindai barcode lokasi asal &amp; tujuan 100% match</p>
  </div>
  <div class="metric-card panel p-4 lg:p-5">
    <div class="flex items-start justify-between mb-2">
      <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center"><i class="fas fa-clock text-amber-500"></i></div>
      <span class="badge bg-amber-100 text-amber-700"><i class="fas fa-bell"></i>Perlu Serah Terima</span>
    </div>
    <p class="text-3xl font-extrabold text-gray-900 mt-2"><span data-count="3"></span> <span class="text-base font-semibold text-gray-500">Berkas</span></p>
    <p class="text-sm font-semibold text-gray-600 mt-1">Menunggu Konfirmasi Penerima</p>
    <p class="text-xs text-amber-600 mt-1"><span class="w-1.5 h-1.5 bg-amber-500 rounded-full inline-block"></span> Barang tiba di Hub tujuan, verifikasi PIC</p>
  </div>
</div>

<!-- Alur mutasi aktif -->
<div class="panel p-4 lg:p-6 mb-6 anim-fade-up">
  <div class="flex flex-wrap items-start justify-between gap-2 mb-4">
    <div class="flex items-center gap-2">
      <span class="w-2.5 h-2.5 bg-blue-600 rounded-full inline-block"></span>
      <h3 class="font-bold text-gray-900 text-sm lg:text-base">Status Alur Mutasi Aktif &amp; Shuttle Antar-Hub</h3>
    </div>
    <button data-toast="Peta route distribusi &amp; tracking shuttle real-time dimuat..." class="text-sm font-semibold text-blue-600 hover:text-blue-800 hover:underline transition">Lihat Peta Route Distribusi &amp; Tracking <i class="fas fa-arrow-right-long"></i></button>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3">
    <div class="border border-blue-100 bg-blue-50/40 rounded-xl p-4 transition hover:shadow-md hover:-translate-y-0.5">
      <div class="flex items-center justify-between mb-1"><b class="text-xs text-gray-800">MT-2025-0142</b><span class="badge bg-blue-100 text-blue-700 text-[10px]">Antar-Hub</span></div>
      <p class="font-bold text-gray-900 text-sm">Hub Cakung DC-01 → Hub Surabaya DC-02</p>
      <p class="text-[11px] text-gray-500"><i class="fas fa-van-shuttle mr-1"></i>Armada Van Shuttle B 9421 KLA</p>
      <div class="flex items-center justify-between text-[11px] mt-2.5 mb-1"><span class="text-gray-500">120 Unit MacBook &amp; Periferal</span><span class="font-bold text-blue-600">65%</span></div>
      <div class="progress-bar bg-blue-100 rounded-full h-2" style="width:100%" data-w="65"><div class="h-2 bg-blue-600 rounded-full" style="width:0%"></div></div>
      <p class="text-[10px] text-blue-600 font-bold text-right mt-1"><i class="fas fa-car-side"></i> 65%</p>
    </div>
    <div class="border border-emerald-100 bg-emerald-50/40 rounded-xl p-4 transition hover:shadow-md hover:-translate-y-0.5">
      <div class="flex items-center justify-between mb-1"><b class="text-xs text-gray-800">MT-2025-0143</b><span class="badge bg-emerald-600 text-white text-[10px]">Intra-Gudang</span></div>
      <p class="font-bold text-gray-900 text-sm">Zona A (High-Val) → Zona C (Picking Area)</p>
      <p class="text-[11px] text-gray-500"><i class="fas fa-industry mr-1"></i>Forklift Elektrik FL-02</p>
      <div class="flex items-center justify-between text-[11px] mt-2.5 mb-1"><span class="text-gray-500">80 Unit SSD &amp; Harddisk</span><span class="font-bold text-emerald-600">90%</span></div>
      <div class="progress-bar bg-emerald-100 rounded-full h-2" style="width:100%" data-w="90"><div class="h-2 bg-emerald-600 rounded-full" style="width:0%"></div></div>
      <p class="text-[10px] text-emerald-700 font-bold text-right mt-1">Proses Pindah Rak (90%)</p>
    </div>
    <div class="border border-sky-100 bg-sky-50/40 rounded-xl p-4 transition hover:shadow-md hover:-translate-y-0.5">
      <div class="flex items-center justify-between mb-1"><b class="text-xs text-gray-800">MT-2025-0144</b><span class="badge bg-blue-100 text-blue-700 text-[10px]">Antar-Hub</span></div>
      <p class="font-bold text-gray-900 text-sm">Hub Cakung DC-01 → Hub Bandung DC-03</p>
      <p class="text-[11px] text-gray-500"><i class="fas fa-truck-box mr-1"></i>Truk Box B 9012 PQR</p>
      <div class="flex items-center justify-between text-[11px] mt-2.5 mb-1"><span class="text-gray-500">250 Unit Audio &amp; Headset</span><span class="font-bold text-sky-700">30%</span></div>
      <div class="progress-bar bg-sky-100 rounded-full h-2" style="width:100%" data-w="30"><div class="h-2 bg-sky-700 rounded-full" style="width:0%"></div></div>
      <p class="text-[10px] text-sky-700 font-bold text-right mt-1">Staging Transit (30%)</p>
    </div>
    <div class="border border-purple-100 bg-purple-50/40 rounded-xl p-4 transition hover:shadow-md hover:-translate-y-0.5">
      <div class="flex items-center justify-between mb-1"><b class="text-xs text-gray-800">MT-2025-0145</b><span class="badge bg-purple-100 text-purple-700 text-[10px]">Antar-Zona</span></div>
      <p class="font-bold text-gray-900 text-sm">Zona E (Buffer Inbound) → Zona B (Aksesoris)</p>
      <p class="text-[11px] text-gray-500"><i class="fas fa-hands mr-1"></i>Hand Pallet HP-05</p>
      <div class="flex items-center justify-between text-[11px] mt-2.5 mb-1"><span class="text-gray-500">150 Master Box Keyboard</span><span class="font-bold text-purple-600">-%</span></div>
      <div class="progress-bar bg-purple-100 rounded-full h-2" style="width:100%" data-w="12"><div class="h-2 bg-purple-600 rounded-full" style="width:0%"></div></div>
      <p class="text-[10px] text-purple-700 font-bold text-right mt-1"><i class="fas fa-shield-halved"></i> Menunggu Verifikasi</p>
    </div>
  </div>
</div>

<!-- Search & filter -->
<div class="panel p-4 lg:p-5 mb-4 anim-fade-up">
  <div class="flex flex-col lg:flex-row gap-3 items-stretch lg:items-center">
    <div class="flex-1 relative">
      <i class="fas fa-search absolute left-3.5 top-3.5 text-gray-400"></i>
      <input id="searchReq" type="text" placeholder="Cari No. Mutasi (MT), SKU, Rak Asal / Tujuan, PIC..." class="w-full pl-10 pr-4 py-2.5 bg-gray-100 border border-transparent rounded-lg text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
    </div>
    <div class="flex flex-wrap gap-2 items-center">
      <select id="fTipe" class="px-3 py-2.5 border border-gray-300 bg-white rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">Tipe Mutasi: Semua</option><option value="antar-hub">Antar-Hub</option><option value="intra-gudang">Intra-Gudang</option><option value="antar-departemen">Antar-Departemen</option>
      </select>
      <select id="fStatus" class="px-3 py-2.5 border border-gray-300 bg-white rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">Status Mutasi (Semua)</option><option value="selesai">Selesai Diterima</option><option value="relokasi">Selesai Relokasi</option><option value="perjalanan">Dalam Perjalanan</option><option value="pindah">Proses Pindah</option><option value="verifikasi">Menunggu Verifikasi</option>
      </select>
      <select id="fZona" class="px-3 py-2.5 border border-gray-300 bg-white rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">Zona: Semua Zona</option><option value="wh01">WH01</option><option value="wh02">WH02</option><option value="wh03">WH03</option>
      </select>
      <button data-refresh data-toast="Status alur mutasi diperbarui dari sensor WMS." class="px-3 py-2.5 border border-gray-300 bg-white rounded-lg hover:bg-gray-50 text-blue-600 transition"><i class="fas fa-bars-progress"></i></button>
    </div>
  </div>
  <div class="flex flex-wrap items-center gap-2 mt-4" id="chipGroup">
    <button data-chip="all" class="chip px-3.5 py-1.5 rounded-full text-xs font-semibold border transition">Semua Mutasi (24)</button>
    <button data-chip="selesai" class="chip px-3.5 py-1.5 rounded-full text-xs font-semibold border transition">Selesai &amp; Diterima (15)</button>
    <button data-chip="perjalanan" class="chip px-3.5 py-1.5 rounded-full text-xs font-semibold border transition">Dalam Perjalanan / Transit (5)</button>
    <button data-chip="pindah" class="chip px-3.5 py-1.5 rounded-full text-xs font-semibold border transition">Proses Pindah Rak (3)</button>
    <button data-chip="persetujuan" class="chip px-3.5 py-1.5 rounded-full text-xs font-semibold border transition">Menunggu Persetujuan (1)</button>
  </div>
</div>

<!-- Table -->
<div class="panel overflow-hidden mb-6 anim-fade-up">
  <div class="overflow-x-auto">
    <table class="w-full min-w-[1200px]" id="tblReq">
      <thead>
        <tr class="border-b border-gray-200 text-[11px] uppercase tracking-wide text-gray-500">
          <th class="px-4 py-3 w-10"><input type="checkbox" id="cbPilihSemua" class="rounded border-gray-300"></th>
          <th class="px-4 py-3 text-left font-bold">No. Mutasi &amp; Tanggal</th>
          <th class="px-4 py-3 text-left font-bold">Tipe Mutasi</th>
          <th class="px-4 py-3 text-left font-bold">Lokasi Asal ➞ Tujuan</th>
          <th class="px-4 py-3 text-left font-bold">Detail Komoditas / SKU</th>
          <th class="px-4 py-3 text-left font-bold">Total Qty &amp; Satuan</th>
          <th class="px-4 py-3 text-left font-bold">PIC Pengirim &amp; Penerima</th>
          <th class="px-4 py-3 text-left font-bold">Status Mutasi &amp; QC</th>
          <th class="px-4 py-3 text-right font-bold">Aksi</th>
        </tr>
      </thead>
      <tbody class="text-sm">
        <!-- MT-0140 -->
        <tr data-status="selesai" data-tipe="antar-hub" data-zona="wh01" data-kode="MT-2025-0140" class="table-row border-b border-gray-100">
          <td class="px-4 py-3"><input type="checkbox" class="row-cb rounded border-gray-300"></td>
          <td class="px-4 py-3"><p class="font-bold text-gray-900">MT-2025-0140</p><p class="text-xs text-gray-500">12 Mar 2025, 08:30 WIB</p></td>
          <td class="px-4 py-3"><span class="badge bg-blue-100 text-blue-700">Antar-Hub</span></td>
          <td class="px-4 py-3 max-w-[190px]"><b class="text-gray-800">Hub Cakung DC</b> → <b class="text-blue-700">Hub Surabaya DC</b><p class="text-xs text-gray-500">Segel: SGL-8910-JKT</p></td>
          <td class="px-4 py-3"><p class="font-semibold text-gray-900">MacBook Pro M1 2020</p><p class="text-xs text-gray-500">SKU: #LWL02012</p></td>
          <td class="px-4 py-3"><p class="font-bold text-gray-900">40 <span class="text-xs font-semibold text-gray-500">Unit</span></p><p class="text-xs text-gray-500">4 Box Segel (Palet)</p></td>
          <td class="px-4 py-3"><p class="font-semibold text-gray-900">Ir. Bambang S. → Slemet R.</p><p class="text-xs text-gray-500">Checker DC-02 Verified</p></td>
          <td class="px-4 py-3"><span class="badge bg-white border border-green-300 text-green-700"><i class="fas fa-check-circle"></i>Selesai Diterima</span></td>
          <td class="px-4 py-3 text-right whitespace-nowrap">
            <button data-detail="MT-2025-0140" class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded transition" title="Dokumen mutasi"><i class="fas fa-file-lines"></i></button>
            <button data-toast="Menu aksi cepat MT-2025-0140 dibuka..." class="p-1.5 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded transition" title="Menu"><i class="fas fa-ellipsis-vertical"></i></button>
          </td>
        </tr>
        <!-- MT-0141 -->
        <tr data-status="relokasi" data-tipe="intra-gudang" data-zona="wh01" data-kode="MT-2025-0141" class="table-row border-b border-gray-100">
          <td class="px-4 py-3"><input type="checkbox" class="row-cb rounded border-gray-300"></td>
          <td class="px-4 py-3"><p class="font-bold text-gray-900">MT-2025-0141</p><p class="text-xs text-gray-500">12 Mar 2025, 09:15 WIB</p></td>
          <td class="px-4 py-3"><span class="badge bg-emerald-100 text-emerald-700">Intra-Gudang</span></td>
          <td class="px-4 py-3 max-w-[190px]"><b class="text-blue-700">WH01-ZA-RA01</b> → <b class="text-blue-700">WH01-ZC-RC02</b><p class="text-xs text-gray-500">Bin-to-Bin Reallocation</p></td>
          <td class="px-4 py-3"><p class="font-semibold text-gray-900">Sandisk SSD NVMe 1TB</p><p class="text-xs text-gray-500">SKU: #SSDN-0994</p></td>
          <td class="px-4 py-3"><p class="font-bold text-gray-900">120 <span class="text-xs font-semibold text-gray-500">Unit</span></p><p class="text-xs text-gray-500">6 Master Carton</p></td>
          <td class="px-4 py-3"><p class="font-semibold text-gray-900">Hendra Wijaya → Agus S.</p><p class="text-xs text-gray-500">Internal Relocator</p></td>
          <td class="px-4 py-3"><span class="badge bg-white border border-green-300 text-green-700"><i class="fas fa-check-double"></i>Selesai Relokasi</span></td>
          <td class="px-4 py-3 text-right whitespace-nowrap">
            <button data-detail="MT-2025-0141" class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded transition" title="Dokumen mutasi"><i class="fas fa-file-lines"></i></button>
            <button data-toast="Menu aksi cepat MT-2025-0141 dibuka..." class="p-1.5 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded transition" title="Menu"><i class="fas fa-ellipsis-vertical"></i></button>
          </td>
        </tr>
        <!-- MT-0142 -->
        <tr data-status="perjalanan" data-tipe="antar-hub" data-zona="wh01" data-kode="MT-2025-0142" class="table-row border-b border-gray-100">
          <td class="px-4 py-3"><input type="checkbox" class="row-cb rounded border-gray-300"></td>
          <td class="px-4 py-3"><p class="font-bold text-gray-900">MT-2025-0142</p><p class="text-xs text-gray-500">12 Mar 2025, 10:00 WIB</p></td>
          <td class="px-4 py-3"><span class="badge bg-blue-100 text-blue-700">Antar-Hub</span></td>
          <td class="px-4 py-3 max-w-[190px]"><b class="text-gray-800">Hub Cakung DC</b> → <b class="text-blue-700">Hub Bandung DC</b><p class="text-xs text-gray-500">Truk: B 9012 PQR</p></td>
          <td class="px-4 py-3"><p class="font-semibold text-gray-900">Sony WH-1000XM4 Audio</p><p class="text-xs text-gray-500">SKU: #SNY-WH440</p></td>
          <td class="px-4 py-3"><p class="font-bold text-gray-900">85 <span class="text-xs font-semibold text-gray-500">Unit</span></p><p class="text-xs text-gray-500">12 Dus Karton</p></td>
          <td class="px-4 py-3"><p class="font-semibold text-gray-900">Rizky Pratama → Hendra K.</p><p class="text-xs text-gray-500">Driver Shuttle Express</p></td>
          <td class="px-4 py-3"><span class="badge bg-blue-600 text-white"><i class="fas fa-truck"></i>Dalam Perjalanan</span></td>
          <td class="px-4 py-3 text-right whitespace-nowrap">
            <button data-detail="MT-2025-0142" class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded transition" title="Dokumen mutasi"><i class="fas fa-file-lines"></i></button>
            <button data-toast="Menu aksi cepat MT-2025-0142 dibuka..." class="p-1.5 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded transition" title="Menu"><i class="fas fa-ellipsis-vertical"></i></button>
          </td>
        </tr>
        <!-- MT-0143 -->
        <tr data-status="pindah" data-tipe="intra-gudang" data-zona="wh01" data-kode="MT-2025-0143" class="table-row border-b border-gray-100">
          <td class="px-4 py-3"><input type="checkbox" class="row-cb rounded border-gray-300"></td>
          <td class="px-4 py-3"><p class="font-bold text-gray-900">MT-2025-0143</p><p class="text-xs text-gray-500">12 Mar 2025, 10:45 WIB</p></td>
          <td class="px-4 py-3"><span class="badge bg-emerald-100 text-emerald-700">Intra-Gudang</span></td>
          <td class="px-4 py-3 max-w-[190px]"><b class="text-blue-700">WH02-ZD-RD01</b> → <b class="text-blue-700">WH01-ZB-RB01</b><p class="text-xs text-gray-500">Relokasi Antar-Gudang DC</p></td>
          <td class="px-4 py-3"><p class="font-semibold text-gray-900">Mechanical Keyboard RGB</p><p class="text-xs text-gray-500">SKU: #KEY-MEC99</p></td>
          <td class="px-4 py-3"><p class="font-bold text-gray-900">50 <span class="text-xs font-semibold text-gray-500">Unit</span></p><p class="text-xs text-gray-500">2 Karton Kemasan</p></td>
          <td class="px-4 py-3"><p class="font-semibold text-gray-900">Maya Agustina → Dedi Kurniawan</p><p class="text-xs text-gray-500">Staf Warehouse Operasional</p></td>
          <td class="px-4 py-3"><span class="badge bg-amber-100 text-amber-700"><i class="fas fa-arrow-rotate-left"></i>Proses Pindah</span></td>
          <td class="px-4 py-3 text-right whitespace-nowrap">
            <button data-detail="MT-2025-0143" class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded transition" title="Dokumen mutasi"><i class="fas fa-file-lines"></i></button>
            <button data-toast="Menu aksi cepat MT-2025-0143 dibuka..." class="p-1.5 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded transition" title="Menu"><i class="fas fa-ellipsis-vertical"></i></button>
          </td>
        </tr>
        <!-- MT-0144 -->
        <tr data-status="perjalanan" data-tipe="antar-hub" data-zona="wh01" data-kode="MT-2025-0144" class="table-row border-b border-gray-100">
          <td class="px-4 py-3"><input type="checkbox" class="row-cb rounded border-gray-300"></td>
          <td class="px-4 py-3"><p class="font-bold text-gray-900">MT-2025-0144</p><p class="text-xs text-gray-500">12 Mar 2025, 11:20 WIB</p></td>
          <td class="px-4 py-3"><span class="badge bg-blue-100 text-blue-700">Antar-Hub</span></td>
          <td class="px-4 py-3 max-w-[190px]"><b class="text-gray-800">Hub Cakung DC</b> → <b class="text-blue-700">Hub Semarang DC</b><p class="text-xs text-gray-500">Segel: SGL-8932-SMG</p></td>
          <td class="px-4 py-3"><p class="font-semibold text-gray-900">Canon 60D Body &amp; Optical Lens</p><p class="text-xs text-gray-500">SKU: #CAM-CN60D</p></td>
          <td class="px-4 py-3"><p class="font-bold text-gray-900">25 <span class="text-xs font-semibold text-gray-500">Unit</span></p><p class="text-xs text-gray-500">Hardcase Transit</p></td>
          <td class="px-4 py-3"><p class="font-semibold text-gray-900">Rina Marlina → Dedi Sutisna</p><p class="text-xs text-gray-500">High Value Transit Team</p></td>
          <td class="px-4 py-3"><span class="badge bg-blue-600 text-white"><i class="fas fa-truck"></i>Dalam Perjalanan</span></td>
          <td class="px-4 py-3 text-right whitespace-nowrap">
            <button data-detail="MT-2025-0144" class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded transition" title="Dokumen mutasi"><i class="fas fa-file-lines"></i></button>
            <button data-toast="Menu aksi cepat MT-2025-0144 dibuka..." class="p-1.5 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded transition" title="Menu"><i class="fas fa-ellipsis-vertical"></i></button>
          </td>
        </tr>
        <!-- MT-0145 -->
        <tr data-status="verifikasi" data-tipe="intra-gudang" data-zona="wh03" data-kode="MT-2025-0145" class="table-row border-b border-gray-100">
          <td class="px-4 py-3"><input type="checkbox" class="row-cb rounded border-gray-300"></td>
          <td class="px-4 py-3"><p class="font-bold text-gray-900">MT-2025-0145</p><p class="text-xs text-gray-500">12 Mar 2025, 11:50 WIB</p></td>
          <td class="px-4 py-3"><span class="badge bg-emerald-100 text-emerald-700">Intra-Gudang</span></td>
          <td class="px-4 py-3 max-w-[190px]"><b class="text-gray-800">Buffer Dock 01</b> → <b class="text-blue-700">WH03-ZE-RE01</b><p class="text-xs text-gray-500">Putaway Inbound Transit</p></td>
          <td class="px-4 py-3"><p class="font-semibold text-gray-900">Barcode Scanner &amp; Printer</p><p class="text-xs text-gray-500">SKU: #PRN-LBL88</p></td>
          <td class="px-4 py-3"><p class="font-bold text-gray-900">60 <span class="text-xs font-semibold text-gray-500">Unit</span></p><p class="text-xs text-gray-500">3 Box Karton</p></td>
          <td class="px-4 py-3"><p class="font-semibold text-gray-900">Siti Nurhaliza → Kusnadi</p><p class="text-xs text-gray-500">QC Checker Inbound</p></td>
          <td class="px-4 py-3"><span class="badge bg-purple-100 text-purple-700"><i class="fas fa-shield-halved"></i>Menunggu Verifikasi</span></td>
          <td class="px-4 py-3 text-right whitespace-nowrap">
            <button data-detail="MT-2025-0145" class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded transition" title="Dokumen mutasi"><i class="fas fa-file-lines"></i></button>
            <button data-toast="Menu aksi cepat MT-2025-0145 dibuka..." class="p-1.5 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded transition" title="Menu"><i class="fas fa-ellipsis-vertical"></i></button>
          </td>
        </tr>
        <!-- MT-0146 -->
        <tr data-status="selesai" data-tipe="antar-departemen" data-zona="wh01" data-kode="MT-2025-0146" class="table-row border-b border-gray-100">
          <td class="px-4 py-3"><input type="checkbox" class="row-cb rounded border-gray-300"></td>
          <td class="px-4 py-3"><p class="font-bold text-gray-900">MT-2025-0146</p><p class="text-xs text-gray-500">12 Mar 2025, 12:15 WIB</p></td>
          <td class="px-4 py-3"><span class="badge bg-slate-200 text-slate-700">Antar-Departemen</span></td>
          <td class="px-4 py-3 max-w-[190px]"><b class="text-gray-800">Hub DC-01</b> → <b class="text-blue-700">Divisi IT &amp; Infra</b><p class="text-xs text-gray-500">Asset Internal Transfer</p></td>
          <td class="px-4 py-3"><p class="font-semibold text-gray-900">Wired Mouse &amp; Periferal</p><p class="text-xs text-gray-500">SKU: #ACC-MS012</p></td>
          <td class="px-4 py-3"><p class="font-bold text-gray-900">30 <span class="text-xs font-semibold text-gray-500">Unit</span></p><p class="text-xs text-gray-500">1 Box Penyimpanan</p></td>
          <td class="px-4 py-3"><p class="font-semibold text-gray-900">Adrian Pratama → Ir. Bambang S.</p><p class="text-xs text-gray-500">Head of Infrastructure</p></td>
          <td class="px-4 py-3"><span class="badge bg-white border border-green-300 text-green-700"><i class="fas fa-check-double"></i>Selesai Diserahkan</span></td>
          <td class="px-4 py-3 text-right whitespace-nowrap">
            <button data-detail="MT-2025-0146" class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded transition" title="Dokumen mutasi"><i class="fas fa-file-lines"></i></button>
            <button data-toast="Menu aksi cepat MT-2025-0146 dibuka..." class="p-1.5 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded transition" title="Menu"><i class="fas fa-ellipsis-vertical"></i></button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-4 lg:px-5 py-3 border-t border-gray-100 text-xs text-gray-500">
    <p>Menampilkan <b class="text-gray-800">1 - 7</b> dari <b class="text-gray-800">24</b> transaksi mutasi</p>
    <div class="flex items-center gap-1">
      <button data-toast="Anda sudah berada di halaman pertama." data-toast-type="warn" class="px-2.5 py-1 border border-gray-300 rounded text-gray-400">Sebelumnya</button>
      <button class="px-3 py-1 bg-blue-600 text-white rounded font-semibold">1</button>
      <button data-toast="Menampilkan halaman 2 riwayat mutasi..." class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">2</button>
      <button data-toast="Menampilkan halaman 3 riwayat mutasi..." class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">3</button>
      <button data-toast="Menampilkan halaman 4 riwayat mutasi..." class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-50">4</button>
      <button data-toast="Menampilkan halaman berikutnya riwayat mutasi..." class="px-2.5 py-1 border border-gray-300 rounded hover:bg-gray-50 text-blue-600">Selanjutnya</button>
    </div>
  </div>
</div>

<!-- 3 kartu utilitas bawah -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-2 anim-fade-up">
  <div class="metric-card panel p-5">
    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-3"><i class="fas fa-barcode text-blue-600"></i></div>
    <h4 class="font-bold text-gray-900 mb-1">Validasi Barcode 2 Titik (Origin &amp; Destination)</h4>
    <p class="text-xs text-gray-500 mb-3">Pemindaian wajib barcode lokasi rak asal sebelum pengangkatan dan scan barcode rak tujuan untuk meminimisasi salah penempatan (misplacement).</p>
    <div class="border-t border-gray-100 pt-3"><button data-toast="Aplikasi scanner handheld dibuka (2 titik)..." class="text-xs font-bold text-blue-600 hover:text-blue-800">Buka Scanner Handheld <i class="fas fa-arrow-right-long"></i></button></div>
  </div>
  <div class="metric-card panel p-5">
    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mb-3"><i class="fas fa-file-shield text-emerald-600"></i></div>
    <h4 class="font-bold text-gray-900 mb-1">SOP Mutasi Antar-Hub &amp; Segel Kontainer</h4>
    <p class="text-xs text-gray-500 mb-3">Regulasi wajib pemasangan security lock sealer bernomor seri unik pada pintu armada dan serah terima dokumen e-Surat Jalan Mutasi (e-SJM).</p>
    <div class="border-t border-gray-100 pt-3"><button data-toast="Dokumen SOP Mutasi (PDF) diunduh..." class="text-xs font-bold text-emerald-700 hover:text-emerald-900"><i class="fas fa-download"></i> Unduh Dokumen SOP (PDF)</button></div>
  </div>
  <div class="metric-card panel p-5">
    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center mb-3"><i class="fas fa-file-signature text-amber-500"></i></div>
    <h4 class="font-bold text-gray-900 mb-1">Integrasi Berita Acara Mutasi Otomatis <span class="text-amber-600">(BAMO)</span></h4>
    <p class="text-xs text-gray-500 mb-3">Sistem otomatis menerbitkan berita acara mutasi dan merefleksikan perubahan stok pada kartu persekutuan (inventory ledger) seketika saat barcode penerima di-scan.</p>
    <div class="border-t border-gray-100 pt-3"><button data-toast="Log audit mutasi (JSON + PDF) dibuka..." class="text-xs font-bold text-orange-600 hover:text-orange-800">Log Audit Mutasi <i class="fas fa-arrow-right-long"></i></button></div>
  </div>
</div>

<!-- ============ MODAL: buat mutasi ============ -->
<div class="modal-overlay" id="modalBuat">
  <div class="modal-box" style="max-width:560px">
    <div class="flex items-center justify-between p-4 border-b border-gray-100">
      <h3 class="font-bold text-gray-900"><i class="fas fa-right-left mr-2 text-blue-600"></i>Buat Mutasi Barang Baru</h3>
      <button data-close-modal class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
    </div>
    <div class="p-5">
      <div class="grid grid-cols-2 gap-3 text-sm">
        <div><label class="text-xs font-semibold text-gray-600">Tipe Mutasi</label><select class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg text-sm"><option>Intra-Gudang (Rak)</option><option>Antar-Zona</option><option>Antar-Hub</option><option>Antar-Departemen</option></select></div>
        <div><label class="text-xs font-semibold text-gray-600">Armada / Alat Angkut</label><select class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg text-sm"><option>Forklift Elektrik FL-02</option><option>Hand Pallet HP-05</option><option>Van Shuttle</option><option>Truk Box</option></select></div>
        <div><label class="text-xs font-semibold text-gray-600">Lokasi Asal</label><input class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg text-sm" placeholder="Scan rak asal..."></div>
        <div><label class="text-xs font-semibold text-gray-600">Lokasi Tujuan</label><input class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg text-sm" placeholder="Scan rak tujuan..."></div>
        <div><label class="text-xs font-semibold text-gray-600">SKU / Barang</label><input class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg text-sm" placeholder="Scan barcode barang..."></div>
        <div><label class="text-xs font-semibold text-gray-600">Total Qty</label><input class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg text-sm" placeholder="0"></div>
      </div>
      <div class="mt-4 p-3 bg-blue-50 border border-blue-100 rounded-lg text-xs text-blue-700"><i class="fas fa-camera mr-1"></i>Validasi 2 titik: scan rak asal &amp; rak tujuan wajib dilakukan sebelum mutasi dijalankan.</div>
    </div>
    <div class="p-4 border-t border-gray-100 flex justify-end gap-2">
      <button data-close-modal class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Batal</button>
      <button data-close-modal data-saved-toast="Mutasi dibuat — masuk antrean picking &amp; shuttle." class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700"><i class="fas fa-check mr-1"></i>Jalankan Mutasi</button>
    </div>
  </div>
</div>

<!-- ============ MODAL: detail mutasi ============ -->
<div class="modal-overlay" id="modalDetail">
  <div class="modal-box" style="max-width:680px">
    <div class="flex items-center justify-between p-4 border-b border-gray-100">
      <h3 class="font-bold text-gray-900"><i class="fas fa-right-left mr-2 text-blue-600"></i>Detail Dokumen Mutasi</h3>
      <button data-close-modal class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
    </div>
    <div class="p-5" id="detailBody"><p class="text-sm text-gray-500">Memuat detail...</p></div>
  </div>
</div>

  </div>

        <script>
/* ============================================================
   ASTRO Inventory — Shared interaction layer
   Vanilla JS, no deps. Tailwind handles layout/visuals.
   ============================================================ */
(function () {
  'use strict';
  if (!document.querySelector('.main-area')) return;

  /* ---------- Toast ---------- */
  function toast(msg, type) {
    let c = document.getElementById('toast-container');
    if (!c) { c = document.createElement('div'); c.id = 'toast-container'; document.body.appendChild(c); }
    const t = document.createElement('div');
    t.className = 'toast ' + (type || '');
    t.textContent = msg;
    c.appendChild(t);
    setTimeout(function () { t.style.opacity = '0'; t.style.transition = 'opacity .3s'; setTimeout(function(){ t.remove(); }, 300); }, 3200);
  }
  window.toast = toast;

  /* ---------- Modals ---------- */
  window.openModal = function (id) {
    const m = document.getElementById(id);
    if (m) m.classList.add('open');
  };
  window.closeModal = function (id) {
    const m = document.getElementById(id);
    if (m) m.classList.remove('open');
  };
  function initModals() {
    document.querySelectorAll('.modal-overlay').forEach(function (m) {
      m.addEventListener('click', function (e) { if (e.target === m) m.classList.remove('open'); });
    });
    document.querySelectorAll('[data-close-modal]').forEach(function (b) {
      b.addEventListener('click', function () {
        const m = b.closest('.modal-overlay'); if (m) m.classList.remove('open');
      });
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') document.querySelectorAll('.modal-overlay.open').forEach(function (m){ m.classList.remove('open'); });
    });
  }

  /* ---------- Tabs ---------- */
  window.initTabs = function (container) {
    const root = typeof container === 'string' ? document.getElementById(container) : container;
    if (!root) return;
    const btns = root.querySelectorAll('[data-tab]');
    const panels = root.querySelectorAll('[data-tab-panel]');
    btns.forEach(function (b) {
      b.addEventListener('click', function () {
        const name = b.getAttribute('data-tab');
        btns.forEach(function (x){ x.classList.remove('active'); });
        b.classList.add('active');
        panels.forEach(function (p){
          p.style.display = (p.getAttribute('data-tab-panel') === name) ? '' : 'none';
        });
      });
    });
  };

  /* ---------- Table filtering / search ---------- */
  /* Rows carry data attributes; selects/search filter them. */
  window.initTableFilter = function (opts) {
    const table = document.getElementById(opts.tableId);
    if (!table) return;
    const tbody = table.querySelector('tbody');
    const rows = Array.prototype.slice.call(tbody.querySelectorAll('tr'));
    const search = opts.searchId ? document.getElementById(opts.searchId) : null;
    const selects = (opts.selects || []).map(function (s) {
      return { el: document.getElementById(s.id), attr: s.attr };
    });

    function visible(r) {
      if (search) {
        const q = (search.value || '').toLowerCase().trim();
        if (q && r.textContent.toLowerCase().indexOf(q) === -1) return false;
      }
      for (let i = 0; i < selects.length; i++) {
        const v = selects[i].el ? selects[i].el.value : '';
        if (v && (r.getAttribute('data-' + selects[i].attr) || '').toLowerCase() !== String(v).toLowerCase()) return false;
      }
      if (opts.checkboxId) {
        const cb = document.getElementById(opts.checkboxId);
        if (cb && cb.checked) {
          const flag = r.getAttribute('data-flag') || '';
          if (flag.indexOf('anomali') === -1) return false;
        }
      }
      return true;
    }
    function apply() {
      let count = 0;
      rows.forEach(function (r) {
        const ok = visible(r);
        r.style.display = ok ? '' : 'none';
        if (ok) count++;
      });
      const info = document.getElementById(opts.countId);
      if (info) info.textContent = count;
    }
    if (search) search.addEventListener('input', apply);
    selects.forEach(function (s){ if (s.el) s.el.addEventListener('change', apply); });
    if (opts.checkboxId) { const cb = document.getElementById(opts.checkboxId); if (cb) cb.addEventListener('change', apply); }
    const reset = opts.resetId ? document.getElementById(opts.resetId) : null;
    if (reset) reset.addEventListener('click', function () {
      if (search) search.value = '';
      selects.forEach(function (s){ if (s.el) s.el.value = ''; });
      if (opts.checkboxId) { const cb = document.getElementById(opts.checkboxId); if (cb) cb.checked = false; }
      apply();
    });
    apply();
    return { reapply: apply };
  };

  /* ---------- Client-side pagination (simple) ---------- */
  window.initPagination = function (opts) {
    const table = document.getElementById(opts.tableId);
    if (!table) return;
    const tbody = table.querySelector('tbody');
    const allRows = Array.prototype.slice.call(tbody.querySelectorAll('tr'));
    let perPage = opts.perPage || 10;
    let page = 1;
    const wrap = document.getElementById(opts.controlsId);
    function filteredRows() {
      return allRows.filter(function (r){ return r.style.display !== 'none'; });
    }
    function render() {
      const fr = filteredRows();
      const pages = Math.max(1, Math.ceil(fr.length / perPage));
      if (page > pages) page = pages;
      fr.forEach(function (r, idx) {
        const start = (page - 1) * perPage;
        r.style.display = (idx >= start && idx < start + perPage) ? '' : 'none';
      });
      if (wrap) {
        const info = opts.infoId ? document.getElementById(opts.infoId) : null;
        if (info) {
          const from = fr.length ? (page - 1) * perPage + 1 : 0;
          const to = Math.min(page * perPage, fr.length);
          info.textContent = 'Menampilkan ' + from + ' - ' + to + ' dari ' + fr.length + ' ' + (opts.unit || 'data');
        }
        let html = '';
        const prev = page <= 1;
        html += '<button ' + (prev ? 'disabled' : '') + ' class="px-3 py-1 border border-gray-300 rounded text-xs lg:text-sm ' + (prev ? 'text-gray-400 cursor-not-allowed' : 'hover:bg-gray-50') + ' data-pg="' + (page - 1) + '">Sebelumnya</button>';
        for (let p = 1; p <= pages; p++) {
          html += '<button class="px-3 py-1 rounded text-xs lg:text-sm ' + (p === page ? 'bg-blue-600 text-white' : 'border border-gray-300 hover:bg-gray-50') + '" data-pg="' + p + '">' + p + '</button>';
        }
        const next = page >= pages;
        html += '<button ' + (next ? 'disabled' : '') + ' class="px-3 py-1 border border-gray-300 rounded text-xs lg:text-sm ' + (next ? 'text-gray-400 cursor-not-allowed' : 'bg-gray-100 hover:bg-gray-200') + ' data-pg="' + (page + 1) + '">Berikutnya</button>';
        wrap.innerHTML = html;
        wrap.querySelectorAll('[data-pg]').forEach(function (b) {
          b.addEventListener('click', function () {
            const v = parseInt(b.getAttribute('data-pg'), 10); if (!isNaN(v)) { page = v; render(); }
          });
        });
      }
    }
    return { render: render, setPage: function (p) { page = p; render(); } };
  };

  /* ---------- Boot ---------- */
  document.addEventListener('DOMContentLoaded', function () {
    initModals();
  });
})();

/* ============================================================
   Shared page interactions (inline ke semua halaman baru)
   ============================================================ */
(function () {
  'use strict';
  if (!document.querySelector('.main-area')) return;

  /* ---------- Animated counters ---------- */
  function fmtNum(v, style) {
    if (style === 'dot') return Math.round(v).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    return String(Math.round(v));
  }
  window.animCount = function (el) {
    var raw = el.getAttribute('data-count');
    var target = parseFloat(raw.replace(/\./g, '').replace(',', '.'));
    var styleDot = el.getAttribute('data-num') === 'dot';
    var suffix = el.getAttribute('data-suffix') || '';
    var dec = parseFloat(el.getAttribute('data-dec') || '0');
    var dur = 1100, t0 = null;
    function step(ts) {
      if (!t0) t0 = ts;
      var p = Math.min((ts - t0) / dur, 1);
      var eased = 1 - Math.pow(1 - p, 3);
      var v = (dec ? target * eased : target * eased);
      el.innerHTML = (dec ? v.toFixed(dec).replace('.', ',') : fmtNum(v, styleDot)) + (p > .55 ? suffix : '');
      if (p < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  };
  function startCounters() {
    document.querySelectorAll('[data-count]').forEach(function (el) { animCount(el); });
  }

  /* ---------- Animated progress bars ---------- */
  function startBars() {
    document.querySelectorAll('.progress-bar[data-w]').forEach(function (b, i) {
      setTimeout(function () { b.style.width = b.getAttribute('data-w') + '%'; }, 120 + i * 45);
    });
  }

  /* ---------- Modal helper buttons ---------- */
  function initModalButtons() {
    document.querySelectorAll('[data-open-modal]').forEach(function (b) {
      b.addEventListener('click', function () { openModal(b.getAttribute('data-open-modal')); });
    });
    document.querySelectorAll('[data-saved-toast]').forEach(function (b) {
      b.addEventListener('click', function () { toast(b.getAttribute('data-saved-toast'), 'success'); });
    });
  }

  /* ---------- Toast-bound buttons ---------- */
  function initToastButtons() {
    document.querySelectorAll('[data-toast]').forEach(function (b) {
      b.addEventListener('click', function () {
        var msg = b.getAttribute('data-toast');
        var type = b.getAttribute('data-toast-type') || 'success';
        toast(msg, type);
      });
    });
  }

  /* ---------- Refresh spin ---------- */
  function initRefresh() {
    document.querySelectorAll('[data-refresh]').forEach(function (b) {
      b.addEventListener('click', function () {
        var icon = b.querySelector('i');
        if (icon) { icon.style.transition = 'transform .6s'; icon.style.transform = 'rotate(360deg)'; }
        b.classList.add('pointer-events-none');
        setTimeout(function () {
          if (icon) { icon.style.transition = 'none'; icon.style.transform = 'none'; }
          b.classList.remove('pointer-events-none');
        }, 620);
        toast(b.getAttribute('data-toast') || 'Data berhasil disegarkan.', 'success');
        if (window.__applyFilters) setTimeout(function () { window.__applyFilters(); }, 300);
      });
    });
  }

  /* ---------- Chip active toggling ---------- */
  window.setChip = function (groupEl, btn) {
    groupEl.querySelectorAll('[data-chip]').forEach(function (x) {
      x.classList.remove('bg-blue-600', 'text-white', 'border-blue-600', 'shadow-sm');
    });
    btn.classList.add('bg-blue-600', 'text-white', 'border-blue-600', 'shadow-sm');
  };

  window.initChipGroup = function (groupId, onStart) {
    var group = document.getElementById(groupId);
    if (!group) return;
    group.querySelectorAll('[data-chip]').forEach(function (b) {
      b.addEventListener('click', function () {
        setChip(group, b);
        window.__activeChip = b.getAttribute('data-chip');
        if (window.__applyFilters) window.__applyFilters();
        if (b.getAttribute('data-toast')) toast(b.getAttribute('data-toast'), 'info');
      });
    });
    var first = group.querySelector('[data-chip]');
    if (first) { setChip(group, first); window.__activeChip = first.getAttribute('data-chip'); }
    if (onStart) onStart();
  };

  /* ---------- Kbd focus helper ---------- */
  document.addEventListener('keydown', function (e) {
    if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
      var s = document.querySelector('[data-header-search]');
      if (s) { e.preventDefault(); s.focus(); }
    }
  });

  /* ---------- Boot ---------- */
  document.addEventListener('DOMContentLoaded', function () {
    startCounters();
    startBars();
    initToastButtons();
    initModalButtons();
    initRefresh();
    var hs = document.querySelector('[data-header-search]');
    if (hs) hs.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') toast('Pencarian "' + hs.value.trim() + '" — menampilkan hasil di halaman terkait.', 'info');
    });
  });
})();

/* ============================================================
   Interaksi khusus: Mutasi Barang (Stock Transfer & Relokasi)
   ============================================================ */
(function () {
  'use strict';
  if (!document.querySelector('.main-area')) return;
  var search = document.getElementById('searchReq');
  var fTipe = document.getElementById('fTipe');
  var fStatus = document.getElementById('fStatus');
  var fZona = document.getElementById('fZona');
  var rows = Array.prototype.slice.call(document.querySelectorAll('#tblReq tbody tr'));

  function apply() {
    var q = (search.value || '').toLowerCase().trim();
    var tipe = fTipe.value.toLowerCase();
    var stat = fStatus.value.toLowerCase();
    var zon = fZona.value.toLowerCase();
    var chip = window.__activeChip || 'all';
    rows.forEach(function (r) {
      var st = r.getAttribute('data-status');
      var ok = true;
      if (chip === 'selesai') ok = st === 'selesai' || st === 'relokasi';
      else if (chip === 'perjalanan') ok = st === 'perjalanan';
      else if (chip === 'pindah') ok = st === 'pindah';
      else if (chip === 'persetujuan') ok = st === 'verifikasi';
      if (ok && tipe && r.getAttribute('data-tipe') !== tipe) ok = false;
      if (ok && stat && st !== stat) ok = false;
      if (ok && zon && r.getAttribute('data-zona') !== zon) ok = false;
      if (ok && q && r.textContent.toLowerCase().indexOf(q) === -1) ok = false;
      r.style.display = ok ? '' : 'none';
    });
  }
  window.__applyFilters = apply;

  [search, fTipe, fStatus, fZona].forEach(function (el) {
    el.addEventListener('input', apply);
    el.addEventListener('change', apply);
  });

  window.initChipGroup('chipGroup', apply);

  var cbAll = document.getElementById('cbPilihSemua');
  cbAll.addEventListener('change', function () {
    document.querySelectorAll('.row-cb').forEach(function (cb) {
      cb.checked = cbAll.checked;
      cb.closest('tr').classList.toggle('bg-blue-50/60', cbAll.checked);
    });
    if (cbAll.checked) toast('Mutasi terpilih — dapat diterbitkan BAMO massal.', 'info');
  });
  document.querySelectorAll('.row-cb').forEach(function (cb) {
    cb.addEventListener('change', function () { cb.closest('tr').classList.toggle('bg-blue-50/60', cb.checked); });
  });

  /* ============ Modal detail mutasi ============ */
  var META = {
    'MT-2025-0140': { tipe: 'Antar-Hub', rute: 'Hub Cakung DC → Hub Surabaya DC', segel: 'SGL-8910-JKT', barang: 'MacBook Pro M1 2020 (SKU #LWL02012)', qty: '40 Unit · 4 Box Segel (Palet)', pic: 'Ir. Bambang S. → Slemet R. (Checker DC-02 Verified)', status: 'Selesai Diterima' },
    'MT-2025-0141': { tipe: 'Intra-Gudang', rute: 'WH01-ZA-RA01 → WH01-ZC-RC02', segel: 'Bin-to-Bin Reallocation', barang: 'Sandisk SSD NVMe 1TB (SKU #SSDN-0994)', qty: '120 Unit · 6 Master Carton', pic: 'Hendra Wijaya → Agus S. (Internal Relocator)', status: 'Selesai Relokasi' },
    'MT-2025-0142': { tipe: 'Antar-Hub', rute: 'Hub Cakung DC → Hub Bandung DC', segel: 'Truk: B 9012 PQR', barang: 'Sony WH-1000XM4 Audio (SKU #SNY-WH440)', qty: '85 Unit · 12 Dus Karton', pic: 'Rizky Pratama → Hendra K. (Driver Shuttle Express)', status: 'Dalam Perjalanan' },
    'MT-2025-0143': { tipe: 'Intra-Gudang', rute: 'WH02-ZD-RD01 → WH01-ZB-RB01', segel: 'Relokasi Antar-Gudang DC', barang: 'Mechanical Keyboard RGB (SKU #KEY-MEC99)', qty: '50 Unit · 2 Karton Kemasan', pic: 'Maya Agustina → Dedi Kurniawan (Staf Warehouse Operasional)', status: 'Proses Pindah' },
    'MT-2025-0144': { tipe: 'Antar-Hub', rute: 'Hub Cakung DC → Hub Semarang DC', segel: 'SGL-8932-SMG', barang: 'Canon 60D Body & Optical Lens (SKU #CAM-CN60D)', qty: '25 Unit · Hardcase Transit', pic: 'Rina Marlina → Dedi Sutisna (High Value Transit Team)', status: 'Dalam Perjalanan' },
    'MT-2025-0145': { tipe: 'Intra-Gudang', rute: 'Buffer Dock 01 → WH03-ZE-RE01', segel: 'Putaway Inbound Transit', barang: 'Barcode Scanner & Printer (SKU #PRN-LBL88)', qty: '60 Unit · 3 Box Karton', pic: 'Siti Nurhaliza → Kusnadi (QC Checker Inbound)', status: 'Menunggu Verifikasi' },
    'MT-2025-0146': { tipe: 'Antar-Departemen', rute: 'Hub DC-01 → Divisi IT & Infra', segel: 'Asset Internal Transfer', barang: 'Wired Mouse & Periferal (SKU #ACC-MS012)', qty: '30 Unit · 1 Box Penyimpanan', pic: 'Adrian Pratama → Ir. Bambang S. (Head of Infrastructure)', status: 'Selesai Diserahkan' }
  };
  window.openDetail = function (kode) {
    var m = META[kode];
    if (!m) return;
    document.getElementById('detailBody').innerHTML =
      '<div class="grid grid-cols-2 gap-3 text-sm">' +
      '<div><p class="text-xs text-gray-500">No. Mutasi</p><p class="font-bold text-blue-700">' + kode + '</p></div>' +
      '<div><p class="text-xs text-gray-500">Tipe Mutasi</p><p class="text-gray-900 font-semibold">' + m.tipe + '</p></div>' +
      '<div class="col-span-2"><p class="text-xs text-gray-500">Rute Perpindahan</p><p class="text-gray-900 font-semibold">' + m.rute + '</p><p class="text-xs text-gray-500">' + m.segel + '</p></div>' +
      '<div class="col-span-2"><p class="text-xs text-gray-500">Komoditas / SKU</p><p class="text-gray-900">' + m.barang + '</p></div>' +
      '<div><p class="text-xs text-gray-500">Total Qty &amp; Satuan</p><p class="text-gray-900 font-semibold">' + m.qty + '</p></div>' +
      '<div><p class="text-xs text-gray-500">Status &amp; QC</p><p class="text-gray-900 font-semibold">' + m.status + '</p></div>' +
      '<div class="col-span-2"><p class="text-xs text-gray-500">PIC Pengirim ➞ Penerima</p><p class="text-gray-900">' + m.pic + '</p></div>' +
      '</div>' +
      '<div class="mt-4 p-3 bg-emerald-50 border border-emerald-100 rounded-lg text-xs text-emerald-700"><i class="fas fa-barcode mr-1"></i>Validasi barcode 2 titik tercatat: scan origin &amp; destination 100% match.</div>' +
      '<div class="mt-4 flex justify-end gap-2"><button data-close-modal class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Tutup</button><button data-close-modal onclick="toast(\'BAMO \' + \'' + kode + '\' diterbitkan & direfleksikan ke inventory ledger.\',\'success\')" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700"><i class="fas fa-file-signature mr-1"></i>Lihat BAMO</button></div>';
    openModal('modalDetail');
  };
  document.querySelectorAll('[data-detail]').forEach(function (b) {
    b.addEventListener('click', function () { openDetail(b.getAttribute('data-detail')); });
  });

  apply();
})();
        </script>
        @endif

        {{-- ================= AUDITOR (Audit/mutasi_barang.html) ================= --}}
        @if(auth()->user()->isAuditor())
        <style>
* { box-sizing: border-box; }
    html { -webkit-text-size-adjust: 100%; }
    body { font-family: Inter, sans-serif; overflow-x: hidden; }
    [hidden] { display: none !important; }
    :focus-visible { outline: 2px solid #0b49d8; outline-offset: 2px; }

    /* ---------- Animasi ---------- */
    .reveal { animation: rise-in .4s cubic-bezier(.2,.8,.2,1) both; }
    .reveal-delay-1 { animation-delay: 50ms; }
    .reveal-delay-2 { animation-delay: 100ms; }
    .reveal-delay-3 { animation-delay: 150ms; }
    @keyframes rise-in { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after { scroll-behavior: auto !important; animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; }
    }

    /* ---------- Skala tipografi tetap (stabil di semua ukuran layar) ----------
       24 judul/angka KPI · 13 judul panel · 12 isi · 10.5 teks sekunder · 9.5 label */
    .pri  { font-size: 12px; font-weight: 600; color: #1e293b; line-height: 1.35; }
    .txt  { font-size: 12px; color: #334155; line-height: 1.35; }
    .sub  { margin-top: 4px; font-size: 10.5px; line-height: 1.4; color: #64748b; }
    .sub-red { color: #dc2626; }
    .pill { display: inline-flex; align-items: center; gap: 4px; border-radius: 9999px; padding: 4px 10px; font-size: 10.5px; font-weight: 600; white-space: nowrap; }
    .tag  { display: inline-block; border-radius: 6px; padding: 4px 10px; font-size: 10.5px; font-weight: 600; line-height: 1.35; }
    .c-green  { background: #d1fae5; color: #065f46; }
    .c-red    { background: #fee2e2; color: #b91c1c; }
    .c-amber  { background: #fef3c7; color: #92400e; }
    .c-indigo { background: #e0e7ff; color: #3730a3; }
    .c-slate  { background: #f1f5f9; color: #334155; }
    .c-blue   { background: #0b49d8; color: #fff; }
    .c-gray   { background: #94a3b8; color: #fff; }
    .panel-title { font-size: 13px; font-weight: 700; color: #1e293b; line-height: 1.3; }

    /* ---------- Tabel: kartu bertumpuk di layar kecil ---------- */
    @media (max-width: 767px) {
      .rtable { min-width: 0 !important; table-layout: auto !important; }
      .rtable thead { display: none; }
      .rtable, .rtable tbody, .rtable tr { display: block; width: 100%; }
      .rtable tbody tr { padding: 12px 14px; }
      .rtable td { display: grid; grid-template-columns: 92px minmax(0, 1fr); gap: 10px; width: auto !important; padding: 6px 0 !important; text-align: left !important; }
      .rtable td::before { content: attr(data-label); padding-top: 2px; font-size: 9.5px; font-weight: 600; letter-spacing: .025em; text-transform: uppercase; color: #64748b; }
    }
    .sub-green { color: #059669; }
        </style>
        <script src="https://unpkg.com/lucide@latest"></script>
<!-- ============ KONTEN ============ -->
    <div class="bg-canvas p-4 lg:p-5">
      <!-- Judul halaman -->
      <section class="reveal mb-4 flex flex-wrap items-end justify-between gap-3">
        <div class="min-w-0 flex-1 basis-[300px]">
          <p class="mb-1 text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Operasional & Transaksi <span class="text-blue-700">&gt; Audit Mutasi</span></p>
          <h1 class="text-[24px] font-bold leading-tight tracking-tight text-slate-800">Pemeriksaan & Audit Mutasi Antar-Hub (Inter-Hub Transfer)</h1>
          <p class="mt-1.5 max-w-[720px] text-[12px] leading-relaxed text-slate-500">Audit kepatuhan alur transfer stok antar-gudang, rekonsiliasi kuantitas dispatch vs kuantitas penerimaan di tujuan, deteksi selisih transit, dan validasi Berita Acara Serah Terima (BAST).</p>
          <div class="mt-2.5 flex flex-wrap items-center gap-2">
            <span class="flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1.5 text-[10px] font-semibold text-emerald-700"><i data-lucide="circle-dashed" class="h-3.5 w-3.5 shrink-0"></i>Siklus Audit: 04-2025 Aktif</span>
            <span class="flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1.5 text-[10px] font-semibold text-slate-600"><i data-lucide="refresh-cw" class="h-3.5 w-3.5 shrink-0"></i>Sync: 18 Okt 2025, 14:32 WIB</span>
          </div>
        </div>
        <div class="flex w-full items-center gap-2 sm:w-auto">
          <button type="button" data-toast="Menyiapkan ekspor Rekonsiliasi Mutasi (XLS/PDF)..." class="flex h-10 w-full items-center justify-center gap-2 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white shadow-sm hover:bg-blue-700 sm:w-auto"><i data-lucide="file-down" class="h-4 w-4"></i>Ekspor Rekonsiliasi Mutasi</button>
        </div>
      </section>

      <!-- Ringkasan -->
      <section aria-label="Ringkasan audit mutasi" class="reveal reveal-delay-1 mb-4 grid grid-cols-2 gap-3 md:grid-cols-4">
        <article class="flex min-h-[112px] items-start justify-between gap-2 rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
          <div class="min-w-0"><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Total Mutasi Bulan Ini</p><p class="mt-1.5 flex items-baseline gap-1.5 text-[24px] font-bold leading-tight tracking-tight">142 <span class="text-[10.5px] font-normal text-slate-600">Transfer</span></p><p class="mt-2.5 text-[10.5px] leading-snug text-slate-500"><span class="font-semibold text-blue-600">● &nbsp;Antar-DC</span> &nbsp;Valuasi Stok: Rp 8,6 Miliar</p></div>
          <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="arrow-left-right" class="h-4 w-4"></i></span>
        </article>
        <article class="flex min-h-[112px] items-start justify-between gap-2 rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
          <div class="min-w-0"><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Kepatuhan Rekonsiliasi</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight">98,6%</p><p class="mt-2.5 text-[10.5px] leading-snug text-slate-500"><span class="font-semibold text-emerald-700">● &nbsp;Compliant</span> &nbsp;Tanpa Selisih: 138 dari 142 Transfer</p></div>
          <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-emerald-50 text-emerald-700"><i data-lucide="check-check" class="h-4 w-4"></i></span>
        </article>
        <article class="flex min-h-[112px] items-start justify-between gap-2 rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
          <div class="min-w-0"><p class="text-[9.5px] font-semibold uppercase tracking-wide text-red-600">Selisih Dalam Perjalanan</p><p class="mt-1.5 flex items-baseline gap-1.5 text-[24px] font-bold leading-tight tracking-tight text-red-600">1 <span class="text-[10.5px] font-normal text-slate-600">Kasus</span></p><p class="mt-2.5 text-[10.5px] leading-snug text-red-600"><span class="font-semibold">! &nbsp;Anomali</span> &nbsp;Defisit Terkonfirmasi: -2 Unit (Rute Medan)</p></div>
          <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-red-50 text-red-600"><i data-lucide="triangle-alert" class="h-4 w-4"></i></span>
        </article>
        <article class="flex min-h-[112px] items-start justify-between gap-2 rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
          <div class="min-w-0"><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Rata-rata Update BAST</p><p class="mt-1.5 flex items-baseline gap-1.5 text-[24px] font-bold leading-tight tracking-tight">1,2 <span class="text-[10.5px] font-normal text-slate-600">Jam</span></p><p class="mt-2.5 text-[10.5px] leading-snug text-slate-500"><span class="font-semibold text-emerald-700">↗ +40% Cepat</span> &nbsp;SOP Batas SLA: 2,0 Jam</p></div>
          <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-indigo-50 text-indigo-600"><i data-lucide="file-signature" class="h-4 w-4"></i></span>
        </article>
      </section>

      <!-- Filter -->
      <section class="reveal reveal-delay-2 mb-4 rounded-xl border border-slate-100 bg-white p-3 shadow-sm">
        <div class="flex flex-wrap items-center gap-2">
          <label class="flex h-10 min-w-0 basis-full items-center gap-2 rounded-md bg-blue-50/80 px-3 text-slate-400 sm:flex-1 sm:basis-[260px] lg:max-w-[430px]">
            <i data-lucide="search" class="h-4 w-4 shrink-0"></i>
            <input id="searchMut" type="search" placeholder="Cari nomor tiket (#TRX-MUT-...), SKU, pengemudi, atau hub" class="w-full min-w-0 bg-transparent text-[12px] text-slate-700 outline-none placeholder:text-slate-400" />
          </label>
          <select id="fRekon" aria-label="Filter status rekonsiliasi" class="h-10 min-w-0 basis-[calc(50%-4px)] rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none sm:basis-auto">
            <option value="">Status Rekonsiliasi: Semua</option>
            <option value="match">Rekonsiliasi Klop (Match)</option>
            <option value="anomali">Anomali / Selisih Fisik</option>
            <option value="transit">Dalam Perjalanan</option>
            <option value="pelanggaran">Pelanggaran SOP (BAST Delay)</option>
          </select>
          <select id="fKirim" aria-label="Filter hub pengirim" class="h-10 min-w-0 basis-[calc(50%-4px)] rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none sm:basis-auto">
            <option value="">Hub Pengirim: Cakung DC-01 (Utama)</option>
          </select>
          <select id="fTujuanMut" aria-label="Filter hub tujuan" class="h-10 min-w-0 basis-[calc(50%-4px)] rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none sm:basis-auto">
            <option value="">Hub Tujuan: Semua Tujuan</option>
            <option value="surabaya">Surabaya DC-02</option>
            <option value="medan">Medan DC-04</option>
            <option value="bandung">Bandung DC-03</option>
            <option value="halim">Halim DC-02</option>
          </select>
          <select id="fRentang" aria-label="Filter rentang waktu" class="h-10 min-w-0 flex-1 basis-0 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none sm:flex-none sm:basis-auto">
            <option value="">Rentang: 7 Hari Terakhir</option>
          </select>
          <button id="btnReset" type="button" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-blue-50 text-slate-600" aria-label="Reset filter"><i data-lucide="rotate-cw" class="h-4 w-4"></i></button>
        </div>
        <div class="mt-3 flex flex-col gap-2 text-[12px] text-slate-600 sm:flex-row sm:flex-wrap sm:items-center sm:gap-x-5">
          <label class="flex cursor-pointer items-start gap-2"><input id="cbSelisih" type="checkbox" class="mt-0.5 h-4 w-4 shrink-0 accent-blue-600"><span>Tampilkan hanya transfer berstatus Selisih / Deviasi Fisik</span></label>
          <label class="flex cursor-pointer items-start gap-2"><input id="cbSegera" type="checkbox" class="mt-0.5 h-4 w-4 shrink-0 accent-blue-600"><span>Perlu Tindakan Segera</span></label>
        </div>
      </section>

      <!-- Tabel -->
      <section class="reveal reveal-delay-3 mb-4 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
          <table id="tblMut" class="rtable w-full min-w-[1270px] table-fixed border-collapse text-left">
            <thead class="h-11 bg-[#f0f4fc] text-[9.5px] font-semibold uppercase tracking-wide text-slate-600">
              <tr>
                <th class="w-[150px] whitespace-nowrap px-2">No. Tiket & Tanggal</th>
                <th class="w-[190px] whitespace-nowrap px-2">Rute Transfer</th>
                <th class="w-[190px] whitespace-nowrap px-2">SKU & Deskripsi Barang</th>
                <th class="w-[130px] whitespace-nowrap px-2">Kirim vs Terima</th>
                <th class="w-[190px] whitespace-nowrap px-2">Status Rekonsiliasi Fisik</th>
                <th class="w-[150px] whitespace-nowrap px-2">Waktu Transit vs SLA</th>
                <th class="w-[190px] whitespace-nowrap px-2">Integritas BAST & Otorisasi</th>
                <th class="w-[80px] whitespace-nowrap px-2 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody id="mut-rows" class="divide-y divide-slate-100">
              <tr data-rekon="match" data-tujuan="surabaya" class="hover:bg-slate-50/70">
                <td data-label="No. Tiket" class="px-2 py-3 align-top"><div><a href="#" data-detail="TRX-MUT-20251016-00" class="text-[12px] font-bold text-blue-700 hover:underline">#TRX-MUT-20251016-00</a><p class="sub">16 Okt 2025, 08:15 WIB</p></div></td>
                <td data-label="Rute" class="px-2 py-3 align-top"><div><p class="txt">Cakung DC-01 &gt; Surabaya DC-02</p><p class="sub">Armada: Hino Wingbox #B-9182-UEK</p></div></td>
                <td data-label="SKU & Barang" class="px-2 py-3 align-top"><div><p class="pri">Titan Smart Watch v3</p><p class="sub">SKU-TTN-W3-BLK (150 Unit)</p></div></td>
                <td data-label="Kirim / Terima" class="px-2 py-3 align-top"><div><p class="txt"><b>150 / 150</b></p><p class="sub sub-green">Selisih: 0 Unit</p></div></td>
                <td data-label="Rekonsiliasi" class="px-2 py-3 align-top"><div><span class="tag c-green">Rekonsiliasi Klop (100%)</span></div></td>
                <td data-label="Transit vs SLA" class="px-2 py-3 align-top"><div><p class="txt">14 Jam (Sesuai SLA)</p><p class="sub">Target Max: 18 Jam</p></div></td>
                <td data-label="BAST & Otorisasi" class="px-2 py-3 align-top"><div><span class="tag c-green">BAST Sah Ganda (QR Sign)</span><p class="sub">PIC Dispatcher &amp; Receiver Valid</p></div></td>
                <td data-label="Aksi" class="px-2 py-3 align-top"><div class="flex items-center justify-center gap-1 text-slate-600 max-md:justify-start"><button type="button" data-detail="TRX-MUT-20251016-00" class="rounded p-1.5 hover:bg-slate-100" aria-label="Lihat detail TRX-MUT-20251016-00"><i data-lucide="eye" class="h-4 w-4"></i></button><button type="button" data-export="TRX-MUT-20251016-00" class="rounded p-1.5 hover:bg-slate-100" aria-label="Ekspor TRX-MUT-20251016-00"><i data-lucide="download" class="h-4 w-4"></i></button></div></td>
              </tr>
              <tr data-rekon="anomali" data-tujuan="medan" data-flag="anomali" class="hover:bg-slate-50/70">
                <td data-label="No. Tiket" class="px-2 py-3 align-top"><div><a href="#" data-detail="TRX-MUT-20251014-64" class="text-[12px] font-bold text-blue-700 hover:underline">#TRX-MUT-20251014-64</a><p class="sub">14 Okt 2025, 11:20 WIB</p></div></td>
                <td data-label="Rute" class="px-2 py-3 align-top"><div><p class="txt">Cakung DC-01 &gt; Medan DC-04</p><p class="sub">Ekspedisi: MultiLogistics Cargo Pelni</p></div></td>
                <td data-label="SKU & Barang" class="px-2 py-3 align-top"><div><p class="pri">Sandisk Portable SSD Extreme 1TB</p><p class="sub">SKU-SSDX-1TB-R (50 Unit)</p></div></td>
                <td data-label="Kirim / Terima" class="px-2 py-3 align-top"><div><p class="txt"><b>50 / 48</b></p><p class="sub sub-red">Defisit: -2 Unit</p></div></td>
                <td data-label="Rekonsiliasi" class="px-2 py-3 align-top"><div><span class="tag c-red">Anomali Selisih Fisik</span></div></td>
                <td data-label="Transit vs SLA" class="px-2 py-3 align-top"><div><p class="txt">48 Jam (Intra-Pulau)</p><p class="sub">SLA Target: 72 Jam</p></div></td>
                <td data-label="BAST & Otorisasi" class="px-2 py-3 align-top"><div><span class="tag c-red">BAST Ditahan (LTA Diterbitkan)</span><p class="sub">Ref LTA: #LTA-2025-045</p></div></td>
                <td data-label="Aksi" class="px-2 py-3 align-top"><div class="flex items-center justify-center gap-1 text-slate-600 max-md:justify-start"><button type="button" data-detail="TRX-MUT-20251014-64" class="rounded p-1.5 hover:bg-slate-100" aria-label="Lihat detail TRX-MUT-20251014-64"><i data-lucide="eye" class="h-4 w-4"></i></button><button type="button" data-export="TRX-MUT-20251014-64" class="rounded p-1.5 hover:bg-slate-100" aria-label="Ekspor TRX-MUT-20251014-64"><i data-lucide="download" class="h-4 w-4"></i></button></div></td>
              </tr>
              <tr data-rekon="pelanggaran" data-tujuan="bandung" class="hover:bg-slate-50/70">
                <td data-label="No. Tiket" class="px-2 py-3 align-top"><div><a href="#" data-detail="TRX-MUT-20251015-11" class="text-[12px] font-bold text-blue-700 hover:underline">#TRX-MUT-20251015-11</a><p class="sub">15 Okt 2025, 14:05 WIB</p></div></td>
                <td data-label="Rute" class="px-2 py-3 align-top"><div><p class="txt">Cakung DC-01 &gt; Bandung DC-03</p><p class="sub">Armada: Isuzu Box #D-8821-AA</p></div></td>
                <td data-label="SKU & Barang" class="px-2 py-3 align-top"><div><p class="pri">iWatch Gen 4th Space Gray</p><p class="sub">SKU-TW-G4-GRY (80 Unit)</p></div></td>
                <td data-label="Kirim / Terima" class="px-2 py-3 align-top"><div><p class="txt"><b>80 / 80</b></p><p class="sub">Selisih: 0 Unit</p></div></td>
                <td data-label="Rekonsiliasi" class="px-2 py-3 align-top"><div><span class="tag c-amber">Keterlambatan Input BAST (+75 menit)</span></div></td>
                <td data-label="Transit vs SLA" class="px-2 py-3 align-top"><div><p class="txt">Transit Tepat Waktu</p><p class="sub">Input Delay di WMS</p></div></td>
                <td data-label="BAST & Otorisasi" class="px-2 py-3 align-top"><div><span class="tag c-red">Pelanggaran SOP WMS Hub-03</span><p class="sub">Klarifikasi PIC Supervisor</p></div></td>
                <td data-label="Aksi" class="px-2 py-3 align-top"><div class="flex items-center justify-center gap-1 text-slate-600 max-md:justify-start"><button type="button" data-detail="TRX-MUT-20251015-11" class="rounded p-1.5 hover:bg-slate-100" aria-label="Lihat detail TRX-MUT-20251015-11"><i data-lucide="eye" class="h-4 w-4"></i></button><button type="button" data-export="TRX-MUT-20251015-11" class="rounded p-1.5 hover:bg-slate-100" aria-label="Ekspor TRX-MUT-20251015-11"><i data-lucide="download" class="h-4 w-4"></i></button></div></td>
              </tr>
              <tr data-rekon="match" data-tujuan="surabaya" class="hover:bg-slate-50/70">
                <td data-label="No. Tiket" class="px-2 py-3 align-top"><div><a href="#" data-detail="TRX-MUT-20251017-02" class="text-[12px] font-bold text-blue-700 hover:underline">#TRX-MUT-20251017-02</a><p class="sub">17 Okt 2025, 09:30 WIB</p></div></td>
                <td data-label="Rute" class="px-2 py-3 align-top"><div><p class="txt">Surabaya DC-02 &gt; Cakung DC-01</p><p class="sub">Retur Konsolidasi (Balik)</p></div></td>
                <td data-label="SKU & Barang" class="px-2 py-3 align-top"><div><p class="pri">Canon EOS 6D Mark II Body</p><p class="sub">SKU-CAM-C6D-BDY (38 Unit)</p></div></td>
                <td data-label="Kirim / Terima" class="px-2 py-3 align-top"><div><p class="txt"><b>38 / 38</b></p><p class="sub sub-green">Selisih: 0 Unit</p></div></td>
                <td data-label="Rekonsiliasi" class="px-2 py-3 align-top"><div><span class="tag c-green">Rekonsiliasi Lengkap (0 Selisih)</span></div></td>
                <td data-label="Transit vs SLA" class="px-2 py-3 align-top"><div><p class="txt">16 Jam (Optimal)</p><p class="sub">Target SLA: 18 Jam</p></div></td>
                <td data-label="BAST & Otorisasi" class="px-2 py-3 align-top"><div><span class="tag c-green">BAST Lengkap &amp; Terarsip</span><p class="sub">Disetujui Spv DC Cakung</p></div></td>
                <td data-label="Aksi" class="px-2 py-3 align-top"><div class="flex items-center justify-center gap-1 text-slate-600 max-md:justify-start"><button type="button" data-detail="TRX-MUT-20251017-02" class="rounded p-1.5 hover:bg-slate-100" aria-label="Lihat detail TRX-MUT-20251017-02"><i data-lucide="eye" class="h-4 w-4"></i></button><button type="button" data-export="TRX-MUT-20251017-02" class="rounded p-1.5 hover:bg-slate-100" aria-label="Ekspor TRX-MUT-20251017-02"><i data-lucide="download" class="h-4 w-4"></i></button></div></td>
              </tr>
              <tr data-rekon="transit" data-tujuan="halim" class="hover:bg-slate-50/70">
                <td data-label="No. Tiket" class="px-2 py-3 align-top"><div><a href="#" data-detail="TRX-MUT-20251010-01" class="text-[12px] font-bold text-blue-700 hover:underline">#TRX-MUT-20251010-01</a><p class="sub">18 Okt 2025, 12:40 WIB</p></div></td>
                <td data-label="Rute" class="px-2 py-3 align-top"><div><p class="txt">Cakung DC-01 &gt; Halim DC-02</p><p class="sub">Blind Van ASTRO Express #B-1002-PXZ</p></div></td>
                <td data-label="SKU & Barang" class="px-2 py-3 align-top"><div><p class="pri">Sony Alpha A7 IV Body Only</p><p class="sub">SKU-CAM-SNY-A7V (45 Unit)</p></div></td>
                <td data-label="Kirim / Terima" class="px-2 py-3 align-top"><div><p class="txt"><b>45 / 45</b></p><p class="sub">Seger · Dalam Perjalanan</p></div></td>
                <td data-label="Rekonsiliasi" class="px-2 py-3 align-top"><div><span class="tag c-indigo">Dalam Perjalanan</span><p class="sub">Tol Cikampek · Est. Tiba: 2 Jam Lagi</p></div></td>
                <td data-label="Transit vs SLA" class="px-2 py-3 align-top"><div><p class="txt">Dalam Jendela Waktu SOP</p><p class="sub">SLA: 3 Jam</p></div></td>
                <td data-label="BAST & Otorisasi" class="px-2 py-3 align-top"><div><span class="tag c-amber">Surat Jalan Dispatch Sah</span><p class="sub">BAST Menunggu Unloading</p></div></td>
                <td data-label="Aksi" class="px-2 py-3 align-top"><div class="flex items-center justify-center gap-1 text-slate-600 max-md:justify-start"><button type="button" data-detail="TRX-MUT-20251010-01" class="rounded p-1.5 hover:bg-slate-100" aria-label="Lihat detail TRX-MUT-20251010-01"><i data-lucide="eye" class="h-4 w-4"></i></button><button type="button" data-export="TRX-MUT-20251010-01" class="rounded p-1.5 hover:bg-slate-100" aria-label="Ekspor TRX-MUT-20251010-01"><i data-lucide="download" class="h-4 w-4"></i></button></div></td>
              </tr>
            </tbody>
          </table>
        </div>
        <p id="empty-state" hidden class="px-4 py-8 text-center text-[12px] text-slate-500">Tidak ada transfer yang sesuai dengan filter. Ubah atau reset filter untuk melihat data.</p>
        <footer class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 px-4 py-3 text-[12px] text-slate-600">
          <div class="flex flex-wrap items-center gap-2"><span id="rowCount">Menampilkan 1 - 5 dari 142 transfer</span><span>Baris:</span><select aria-label="Jumlah baris" class="h-8 rounded bg-blue-50 px-2 text-[12px]"><option>5</option><option>10</option><option>25</option></select></div>
          <div class="flex flex-wrap items-center gap-1">
            <button type="button" class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">‹ Sebelumnya</button>
            <button type="button" class="h-8 min-w-8 rounded bg-blue-600 px-2 text-[12px] font-semibold text-white">1</button><button type="button" class="h-8 min-w-8 rounded px-2 text-[12px]">2</button><button type="button" class="h-8 min-w-8 rounded px-2 text-[12px]">3</button><span class="px-1">…</span><button type="button" class="h-8 min-w-8 rounded px-2 text-[12px]">29</button>
            <button type="button" class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">Selanjutnya ›</button>
          </div>
        </footer>
      </section>

      <!-- SOP + matriks rute -->
      <section class="grid grid-cols-1 gap-3 lg:grid-cols-2">
        <article class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm">
          <div class="mb-1 flex flex-wrap items-center gap-2"><i data-lucide="search-check" class="h-4 w-4 shrink-0 text-blue-600"></i><h2 class="panel-title">Prosedur Investigasi Selisih Stok In-Transit</h2><span class="pill c-indigo ml-auto">SOP-WMS-MUT-04</span></div>
          <p class="sub mb-3" style="margin-top:0">Pedoman tindak lanjut auditor saat terjadi varians kuantitas terima vs kirim pada transfer antar-hub.</p>
          <div class="space-y-3">
            <div class="flex gap-3"><span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blue-50 text-[11px] font-bold text-blue-700">1</span><div class="min-w-0"><p class="pri">Hold BAST di Sistem WMS</p><p class="sub">Segera kunci status penerimaan di terminal hub penerima. Jangan izinkan posting otomatis ke ledger inventory lokal sebelum investigasi dimulai.</p></div></div>
            <div class="flex gap-3"><span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blue-50 text-[11px] font-bold text-blue-700">2</span><div class="min-w-0"><p class="pri">Dokumentasi Segel & Timbangan</p><p class="sub">Ambil 4 sisi foto nomor segel pintu kontainer, kondisi lakban palet karton, & hasil re-weighing timbangan bruto muatan vs surat jalan.</p></div></div>
            <div class="flex gap-3"><span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blue-50 text-[11px] font-bold text-blue-700">3</span><div class="min-w-0"><p class="pri">Penerbitan LTA & Berita Acara Selisih Fisik</p><p class="sub">Auditor menerbitkan Laporan Temuan Audit (LTA) & lembar Berita Acara Selisih Fisik bermaterai bersama supir transporter & spv penerima.</p></div></div>
            <div class="flex gap-3"><span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blue-50 text-[11px] font-bold text-blue-700">4</span><div class="min-w-0"><p class="pri">Eskalasi & Klaim Vendor / Asuransi Kargo</p><p class="sub">Eskalasi ke pihak vendor ekspedisi untuk deduksi tagihan ongkos kirim atau klaim polis kargo in-transit tanpa merugikan balance sheet.</p></div></div>
          </div>
          <div class="mt-4 border-t border-slate-100 pt-3"><button type="button" data-toast="Membuka berkas kasus #LTA-2025-045..." class="flex items-start gap-1.5 text-left text-[10.5px] font-semibold text-blue-700 hover:underline"><i data-lucide="folder-open" class="mt-px h-3.5 w-3.5 shrink-0"></i><span>Perlu review investigasi kasus terkini? Buka Berkas Kasus #LTA-2025-045 &gt;</span></button></div>
        </article>

        <article class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm">
          <div class="mb-1 flex flex-wrap items-center gap-2"><i data-lucide="route" class="h-4 w-4 shrink-0 text-blue-600"></i><h2 class="panel-title">Matriks Deviasi & Integritas Rute</h2><span class="pill c-slate ml-auto">ISO 9001:2015</span></div>
          <p class="sub mb-3" style="margin-top:0">Kepatuhan rute distribusi dari Cakung DC-01 ke setiap hub tujuan.</p>
          <div class="space-y-2">
            <div class="flex flex-col gap-2 rounded-lg border border-slate-100 p-3 sm:flex-row sm:items-center sm:justify-between sm:gap-3"><div class="min-w-0"><p class="pri">Cakung DC-01 &gt; Surabaya DC-02</p><p class="sub">42 Pengiriman Selesai · Avg Transit 4,8 Jam (Intra-Pulau, Kargo Darat Truk)</p></div><span class="pill c-green w-fit shrink-0">● 100% Sesuai (0 Deviasi)</span></div>
            <div class="flex flex-col gap-2 rounded-lg border border-slate-100 p-3 sm:flex-row sm:items-center sm:justify-between sm:gap-3"><div class="min-w-0"><p class="pri">Cakung DC-01 &gt; Bandung DC-03</p><p class="sub">18 Pengiriman · Intra-Pulau</p></div><span class="pill c-green w-fit shrink-0">● 100% Sesuai (0 Deviasi Fisik)</span></div>
            <div class="flex flex-col gap-2 rounded-lg border border-slate-100 p-3 sm:flex-row sm:items-center sm:justify-between sm:gap-3 bg-red-50"><div class="min-w-0"><p class="pri">Cakung DC-01 &gt; Medan DC-04</p><p class="sub">18 Pengiriman Antar-Pulau · Kargo Kapal Laut MultiLogistics</p></div><span class="pill c-red w-fit shrink-0">● 0,6% Deviasi (1 Selisih)</span></div>
            <div class="flex flex-col gap-2 rounded-lg border border-slate-100 p-3 sm:flex-row sm:items-center sm:justify-between sm:gap-3"><div class="min-w-0"><p class="pri">Cakung DC-01 &gt; Halim DC-02</p><p class="sub">18 Pengiriman Intra-City · Avg Transit 1,5 Jam</p></div><span class="pill c-green w-fit shrink-0">● 100% Sesuai (0 Deviasi)</span></div>
          </div>
          <p class="sub mt-3 flex items-start gap-1.5"><i data-lucide="shield-check" class="mt-px h-3.5 w-3.5 shrink-0"></i><span>Semua pengiriman antar-pulau terlindungi segel tamper evident barcode & asuransi marine cargo Tugu.</span></p>
        </article>
      </section>
    </div>

  <!-- ============ MODAL DETAIL ============ -->
  <div id="modalDetail" hidden class="fixed inset-0 z-[80] flex items-center justify-center bg-slate-950/40 p-4" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="flex max-h-[calc(100vh-32px)] w-full max-w-[760px] flex-col overflow-hidden rounded-xl bg-white shadow-xl">
      <div class="flex shrink-0 items-center justify-between gap-3 border-b border-line px-4 py-3">
        <h3 id="modalTitle" class="panel-title flex items-center gap-2"><i data-lucide="arrow-left-right" class="h-4 w-4 shrink-0 text-blue-600"></i>Detail Audit Mutasi Antar-Hub</h3>
        <button type="button" data-close-modal class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md text-slate-500 hover:bg-slate-100" aria-label="Tutup"><i data-lucide="x" class="h-4 w-4"></i></button>
      </div>
      <div id="detailBody" class="overflow-y-auto p-4"></div>
    </div>
  </div>

  <!-- Toast -->
  <div id="toast" role="status" aria-live="polite" hidden class="fixed bottom-4 right-4 z-[90] flex max-w-[calc(100vw-32px)] items-center gap-2 rounded-lg bg-slate-800 px-3.5 py-2.5 text-[12px] font-medium text-white shadow-lg"><i data-lucide="circle-check" class="h-4 w-4 shrink-0 text-emerald-400"></i><span id="toast-text"></span></div>

        <script>
(function () {
  if (!document.getElementById('mut-rows')) return;

    /* ---------- Toast ---------- */
    let toastTimer;
    function toast(message) {
      const el = document.getElementById('toast');
      document.getElementById('toast-text').textContent = message;
      el.hidden = false;
      clearTimeout(toastTimer);
      toastTimer = setTimeout(() => { el.hidden = true; }, 2600);
    }
    document.addEventListener('click', (e) => {
      const t = e.target.closest('[data-toast]');
      if (t) toast(t.dataset.toast);
      const x = e.target.closest('[data-export]');
      if (x) toast('Ekspor baris ' + x.dataset.export + '...');
    });

    /* ---------- Filter tabel ---------- */
    const rows = [...document.querySelectorAll('#mut-rows tr')];
    const searchMut = document.getElementById('searchMut');
    const globalSearch = document.getElementById('global-search');
    const fRekon = document.getElementById('fRekon');
    const fTujuan = document.getElementById('fTujuanMut');
    const cbSelisih = document.getElementById('cbSelisih');
    const cbSegera = document.getElementById('cbSegera');
    const rowCount = document.getElementById('rowCount');
    const emptyState = document.getElementById('empty-state');
    const defaultCount = rowCount.textContent;

    function applyFilters() {
      const query = `${searchMut.value} ${globalSearch ? globalSearch.value : ''}`.trim().toLowerCase();
      let visible = 0;
      rows.forEach((row) => {
        const d = row.dataset;
        const ok =
          (!query || row.textContent.toLowerCase().includes(query)) &&
          (!fRekon.value || d.rekon === fRekon.value) &&
          (!fTujuan.value || d.tujuan === fTujuan.value) &&
          (!cbSelisih.checked || d.flag === 'anomali');
        row.hidden = !ok;
        if (ok) visible++;
      });
      const filtered = query || fRekon.value || fTujuan.value || cbSelisih.checked;
      rowCount.textContent = filtered ? `${visible} transfer sesuai filter` : defaultCount;
      emptyState.hidden = visible > 0;
    }
    [searchMut, globalSearch].forEach((el) => el && el.addEventListener('input', applyFilters));
    [fRekon, fTujuan].forEach((el) => el.addEventListener('change', applyFilters));
    cbSelisih.addEventListener('change', applyFilters);
    cbSegera.addEventListener('change', () => toast(cbSegera.checked ? 'Filter Perlu Tindakan Segera aktif.' : 'Filter dinonaktifkan.'));
    document.getElementById('btnReset').addEventListener('click', () => {
      searchMut.value = '';
      if (globalSearch) globalSearch.value = '';
      fRekon.value = fTujuan.value = '';
      cbSelisih.checked = false;
      cbSegera.checked = false;
      applyFilters();
    });

    /* ---------- Modal detail ---------- */
    const MUT = {
      'TRX-MUT-20251016-00': { rute: 'Cakung DC-01 > Surabaya DC-02', armada: 'Hino Wingbox #B-9182-UEK', tgl: '16 Okt 2025, 08:15 WIB', sku: 'Titan Smart Watch v3 (SKU-TTN-W3-BLK, 150 Unit)', kirim: '150', terima: '150', selisih: '0 Unit', rekon: 'Rekonsiliasi Klop (100%)', transit: '14 Jam (Sesuai SLA, Target Max 18 Jam)', bast: 'BAST Sah Ganda (QR Sign)', otor: 'PIC Dispatcher & Receiver Valid', status: 'Selesai / Match', tone: 'green', note: 'Transfer intra-pulau reguler, rekonsiliasi sempurna.' },
      'TRX-MUT-20251014-64': { rute: 'Cakung DC-01 > Medan DC-04', armada: 'MultiLogistics Cargo Pelni (Kapal Laut)', tgl: '14 Okt 2025, 11:20 WIB', sku: 'Sandisk Portable SSD Extreme 1TB (SKU-SSDX-1TB-R, 50 Unit)', kirim: '50', terima: '48', selisih: '-2 Unit (Defisit)', rekon: 'Anomali Selisih Fisik', transit: '48 Jam (Intra-Pulau, SLA Target 72 Jam)', bast: 'BAST Ditahan (LTA Diterbitkan, Ref #LTA-2025-045)', otor: 'Eskalasi Vendor / Asuransi Marine Cargo', status: 'Anomali / Perlu Tindakan', tone: 'red', note: 'Defisit terkonfirmasi -2 unit. Investigasi in-transit aktif, BAST di-hold.' },
      'TRX-MUT-20251015-11': { rute: 'Cakung DC-01 > Bandung DC-03', armada: 'Isuzu Box #D-8821-AA', tgl: '15 Okt 2025, 14:05 WIB', sku: 'iWatch Gen 4th Space Gray (SKU-TW-G4-GRY, 80 Unit)', kirim: '80', terima: '80', selisih: '0 Unit', rekon: 'Keterlambatan Input BAST (+75 menit)', transit: 'Transit Tepat Waktu (Input Delay di WMS)', bast: 'Pelanggaran SOP WMS Hub-03', otor: 'Klarifikasi PIC Supervisor', status: 'Pelanggaran SOP (BAST Delay)', tone: 'amber', note: 'Fisik match, namun update BAST di WMS terlambat 75 menit melebihi SLA 2 jam.' },
      'TRX-MUT-20251017-02': { rute: 'Surabaya DC-02 > Cakung DC-01 (Retur Konsolidasi)', armada: 'Balik Retur', tgl: '17 Okt 2025, 09:30 WIB', sku: 'Canon EOS 6D Mark II Body (SKU-CAM-C6D-BDY, 38 Unit)', kirim: '38', terima: '38', selisih: '0 Unit', rekon: 'Rekonsiliasi Lengkap (0 Selisih)', transit: '16 Jam (Optimal, Target SLA 18 Jam)', bast: 'BAST Lengkap & Terarsip', otor: 'Disetujui Spv DC Cakung', status: 'Selesai', tone: 'green', note: 'Retur konsolidasi tervalidasi penuh.' },
      'TRX-MUT-20251010-01': { rute: 'Cakung DC-01 > Halim DC-02', armada: 'Blind Van ASTRO Express #B-1002-PXZ', tgl: '18 Okt 2025, 12:40 WIB', sku: 'Sony Alpha A7 IV Body Only (SKU-CAM-SNY-A7V, 45 Unit)', kirim: '45', terima: '-', selisih: 'Dalam Perjalanan', rekon: 'Dalam Perjalanan (Tol Cikampek, Est. Tiba 2 Jam Lagi)', transit: 'Dalam Jendela Waktu SOP (SLA 3 Jam)', bast: 'Surat Jalan Dispatch Sah - BAST Menunggu Unloading', otor: 'PIC Halim DC-02', status: 'Dalam Transit', tone: 'indigo', note: 'Transfer intra-city berjalan, GPS terkonfirmasi di Tol Cikampek.' }
    };

    const modal = document.getElementById('modalDetail');
    let lastFocus = null;
    function field(label, value) {
      return `<div class="min-w-0"><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">${label}</p><p class="mt-1 text-[12px] leading-snug text-slate-800">${value}</p></div>`;
    }
    function openDetail(code) {
      const d = MUT[code];
      if (!d) return;
      document.getElementById('detailBody').innerHTML =
        '<div class="grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2">' +
          field('No. Tiket', `<b>${code}</b>`) +
          field('Tanggal', d.tgl) +
          field('Rute Transfer', d.rute) +
          field('Armada', d.armada) +
          field('SKU & Deskripsi', d.sku) +
          field('Kirim vs Terima', `<b>${d.kirim} / ${d.terima}</b><br><span class="text-[10.5px] text-slate-500">Selisih: ${d.selisih}</span>`) +
          field('Status Rekonsiliasi', d.rekon) +
          field('Waktu Transit vs SLA', d.transit) +
          field('Integritas BAST', d.bast) +
          field('Otorisasi', d.otor) +
          field('Status', `<span class="pill c-${d.tone}">● ${d.status}</span>`) +
        '</div>' +
        `<div class="mt-4 flex items-start gap-2 rounded-md bg-blue-50/80 p-3 text-[10.5px] leading-relaxed text-slate-600"><i data-lucide="info" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-blue-600"></i><span>${d.note}</span></div>` +
        '<div class="mt-4 flex flex-col-reverse justify-end gap-2 sm:flex-row">' +
          '<button type="button" data-close-modal class="h-10 rounded-md border border-slate-200 bg-white px-4 text-[12px] font-semibold text-slate-700 hover:bg-slate-50">Tutup</button>' +
          `<button type="button" data-close-modal data-toast="Ekspor detail ${code} (PDF)..." class="flex h-10 items-center justify-center gap-2 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white hover:bg-blue-700"><i data-lucide="file-down" class="h-4 w-4"></i>Ekspor PDF</button>` +
        '</div>';
      if (window.lucide) lucide.createIcons();
      lastFocus = document.activeElement;
      modal.hidden = false;
      document.body.style.overflow = 'hidden';
      modal.querySelector('[data-close-modal]').focus();
    }
    function closeModal() {
      modal.hidden = true;
      document.body.style.overflow = '';
      if (lastFocus) lastFocus.focus();
    }
    document.addEventListener('click', (e) => {
      const trigger = e.target.closest('[data-detail]');
      if (trigger) { e.preventDefault(); openDetail(trigger.dataset.detail); return; }
      if (e.target === modal || e.target.closest('[data-close-modal]')) closeModal();
    });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !modal.hidden) closeModal(); });

    if (window.lucide) lucide.createIcons();
})();
        </script>
        @endif

    </main>
</div>

</body>
</html>