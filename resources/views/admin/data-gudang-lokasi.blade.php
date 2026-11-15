<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Data Gudang & Lokasi Rak — Astro Inventory</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ['Inter', 'sans-serif'] },
          colors: {
            brand: '#0b49d8',
            ink: '#17243b',
            canvas: '#f5f7fc',
            line: '#e8edf5'
          }
        }
      }
    };
  </script>
  <style>
    * { box-sizing: border-box; }
    body { font-family: Inter, sans-serif; }
    .reveal { animation: rise-in .4s cubic-bezier(.2,.8,.2,1) both; }
    .delay-1 { animation-delay: 50ms; }
    .delay-2 { animation-delay: 100ms; }
    .delay-3 { animation-delay: 150ms; }
    .location-row { animation: row-in .25s ease both; }
    #location-rows > tr.location-row { height: 60px; }
    .soft-button { transition: transform .16s ease, box-shadow .16s ease, background .16s ease; }
    .soft-button:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(15, 23, 42, .08); }
    .modal-open { overflow: hidden; }
    @keyframes rise-in { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes row-in { from { opacity: 0; transform: translateX(-4px); } to { opacity: 1; transform: translateX(0); } }
    /* Sidebar nav-link (agar menu aktif berwarna biru) */
    .nav-link { transition: all 0.16s ease; }
    .nav-link:hover { background: #f1f5f9; color: #172033; transform: translateX(3px); }
    .nav-link.active { background: #2563eb; color: #fff; font-weight: 600; box-shadow: 0 6px 14px -6px rgba(37, 99, 235, 0.55); }
    .nav-link.active:hover { transform: none; background: #2563eb; }
    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after { scroll-behavior: auto !important; animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; }
    }
  </style>
</head>
<body class="min-h-screen bg-canvas text-ink antialiased">

@include('components.navbar')

<div class="flex min-h-screen">
    @include('components.sidebar')

    <!-- Main Content -->
    <main class="flex-1 min-w-0 overflow-x-hidden min-h-[calc(100vh-56px)] bg-canvas p-4 lg:p-5">

        {{-- ================= SUPER ADMIN ================= --}}
        @if(auth()->user()->isSuperAdmin())
      <section class="reveal mb-4 flex flex-wrap items-end justify-between gap-3">
        <div>
          <p class="mb-1 text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Master Data & Inventaris <span class="text-blue-700">&gt; Manajemen Gudang & Lokasi Rak</span></p>
          <h1 class="text-[24px] font-bold leading-tight tracking-tight text-slate-800">Manajemen Data Gudang & Lokasi Rak</h1>
          <p class="mt-1 max-w-2xl text-[10.5px] leading-relaxed text-slate-500">Pemetaan fasilitas penyimpanan fisik Hub Cabang DC-01, konfigurasi zona gudang, kapasitas rak/bin, pengawasan okupansi, dan status lokasi rak palet.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
          <button id="export-layout" class="soft-button flex h-10 items-center gap-2 rounded-md border border-slate-200 bg-white px-4 text-[12px] font-semibold text-slate-700 shadow-sm"><i data-lucide="download" class="h-4 w-4 text-blue-600"></i>Ekspor Layout Denah</button>
          <button id="audit-button" class="soft-button flex h-10 items-center gap-2 rounded-md border border-slate-200 bg-white px-4 text-[12px] font-semibold text-slate-700 shadow-sm"><i data-lucide="clipboard-check" class="h-4 w-4 text-blue-600"></i>Audit Okupansi Rak</button>
          <button id="add-location" class="soft-button flex h-10 items-center gap-2 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white shadow-sm hover:bg-blue-700"><i data-lucide="plus" class="h-4 w-4"></i>Tambah Fasilitas / Rak Baru</button>
        </div>
      </section>

      <div class="mb-4 flex justify-end">
        <span class="flex items-center gap-2 rounded-full bg-emerald-50 px-2.5 py-1 text-[10.5px] font-semibold text-emerald-700"><span class="h-1.5 w-1.5 animate-pulse rounded-full bg-emerald-500"></span>Pemetaan Denah Real-time: Aktif</span>
      </div>

      <section aria-label="Ringkasan gudang" class="reveal delay-1 mb-4 grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
        <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
          <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Total Gudang Aktif</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight text-slate-800">6 Gedung / DC</p><p class="mt-2.5 rounded bg-slate-50 px-2 py-1 text-[10.5px] text-slate-600"><span class="font-semibold text-emerald-700">● +1 Fasilitas Baru</span> &nbsp;Hub Cabang DC-01</p></div>
          <span class="flex h-8 w-8 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="warehouse" class="h-4 w-4"></i></span>
        </article>
        <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
          <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Total Zona & Lorong</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight text-slate-800">24 Zona</p><p class="mt-2.5 rounded bg-slate-50 px-2 py-1 text-[10.5px] text-slate-600"><span class="font-semibold text-blue-700">⌖ Terbagi Zona A s/d F</span> · Multi-tier</p></div>
          <span class="flex h-8 w-8 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="layout-grid" class="h-4 w-4"></i></span>
        </article>
        <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
          <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Kapasitas Rak & Bin</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight text-slate-800">1.840 Slot</p><p class="mt-2.5 rounded bg-slate-50 px-2 py-1 text-[10.5px] text-slate-600"><span class="font-semibold text-blue-700">◉ 1.435 Terisi</span> (78% okupansi rata-rata)</p></div>
          <span class="flex h-8 w-8 items-center justify-center rounded-md bg-indigo-50 text-indigo-600"><i data-lucide="boxes" class="h-4 w-4"></i></span>
        </article>
        <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-red-100 bg-red-50/40 px-4 py-3 shadow-sm">
          <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-red-600">Slot Kritis / Hampir Penuh</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight text-red-600">8 Rak</p><p class="mt-2.5 rounded bg-red-50 px-2 py-1 text-[10.5px] font-semibold text-red-600">! &nbsp;Okupansi &gt; 90% · Perlu Relokasi / Penataan</p></div>
          <span class="flex h-8 w-8 items-center justify-center rounded-md bg-red-100 text-red-600"><i data-lucide="triangle-alert" class="h-4 w-4"></i></span>
        </article>
      </section>

      <section class="reveal delay-2 mb-4 rounded-xl border border-slate-100 bg-white p-3 shadow-sm">
        <div class="mb-3 flex flex-wrap items-center justify-between gap-2">
          <div class="flex items-center gap-2"><span class="flex h-8 w-8 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="map" class="h-4 w-4"></i></span><div><h2 class="text-[12px] font-semibold text-slate-800">Peta Okupansi Zona Hub Cabang DC-01</h2><p class="text-[10.5px] text-slate-500">Monitoring real-time utilisasi rak dan staging area per cluster operasional</p></div></div>
          <button id="open-map" class="flex items-center gap-2 text-[10.5px] font-semibold text-blue-600 hover:text-blue-800">Buka Visual Denah 2D Interaktif <i data-lucide="arrow-up-right" class="h-3.5 w-3.5"></i></button>
        </div>
        <div id="zone-cards" class="grid grid-cols-1 gap-2 sm:grid-cols-2 xl:grid-cols-5"></div>
      </section>

      <section class="reveal delay-2 mb-4 rounded-xl border border-slate-100 bg-white p-3 shadow-sm">
        <div class="flex flex-wrap items-center gap-2">
          <label class="flex h-10 min-w-[220px] flex-1 items-center gap-2 rounded-md bg-blue-50/80 px-3 text-slate-400 xl:max-w-[430px]"><i data-lucide="search" class="h-4 w-4"></i><input id="location-search" type="search" placeholder="Cari kode gudang, zona, lorong, nomor rak (contoh: WH01-ZA-RA01)..." class="w-full bg-transparent text-[12px] text-slate-700 outline-none placeholder:text-slate-400"><i data-lucide="scan-search" class="h-4 w-4 text-blue-500"></i></label>
          <select id="building-filter" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none"><option value="">Semua Gedung Hub DC-01</option><option>WH01</option><option>WH02</option><option>WH03</option></select>
          <select id="type-filter" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none"><option value="">Semua Tipe Penyimpanan</option><option>Heavy-Duty Shelf</option><option>High-Security Cage</option><option>Multi-Tier Bin</option><option>Pallet Racking Drive-in</option><option>Cartilever & Floor Bay</option><option>Temporary Flow Rack</option></select>
          <select id="occupancy-filter" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none"><option value="">Status Okupansi (Semua)</option><option value="high">Hampir Penuh (&gt; 90%)</option><option value="optimal">Optimal (50-90%)</option><option value="low">Lapang (&lt; 50%)</option></select>
          <button id="reset-filters" class="flex h-10 w-10 items-center justify-center rounded-md bg-blue-50 text-slate-600 hover:bg-blue-100" aria-label="Reset filter"><i data-lucide="rotate-cw" class="h-4 w-4"></i></button>
          <div class="flex items-center gap-1 rounded-md bg-blue-50 p-1"><button data-view="table" class="view-button flex h-8 items-center gap-1.5 rounded px-2.5 text-[10.5px] font-semibold text-blue-700 shadow-sm"><i data-lucide="table-2" class="h-3.5 w-3.5"></i>Tabel</button><button data-view="grid" class="view-button flex h-8 items-center gap-1.5 rounded px-2.5 text-[10.5px] text-slate-600"><i data-lucide="layout-grid" class="h-3.5 w-3.5"></i>Grid</button></div>
        </div>
        <div id="location-chips" class="mt-3 flex flex-wrap items-center gap-2 text-[10.5px]"></div>
      </section>

      <section id="table-view" class="reveal delay-3 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
          <table class="w-full min-w-[1200px] table-fixed border-collapse text-left">
            <thead class="h-11 whitespace-nowrap bg-[#f0f4fc] text-[9.5px] font-semibold uppercase tracking-wide text-slate-600">
              <tr>
                <th class="w-[48px] px-2"><input type="checkbox" aria-label="Pilih semua lokasi" class="h-4 w-4 accent-blue-600"></th>
                <th class="w-[250px] px-2">Kode & Nama Lokasi</th>
                <th class="w-[170px] px-2">Tipe Rak / Storage</th>
                <th class="w-[150px] px-2">Kapasitas Maksimal</th>
                <th class="w-[180px] px-2">Keterisian & Okupansi</th>
                <th class="w-[130px] px-2">SKU Tersimpan</th>
                <th class="w-[130px] px-2">Status</th>
                <th class="w-[100px] px-2">Aksi</th>
              </tr>
            </thead>
            <tbody id="location-rows" class="divide-y divide-slate-100 text-[12px]"></tbody>
          </table>
        </div>
        <footer class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 bg-white px-4 py-3 text-[12px] text-slate-600">
          <div class="flex items-center gap-2"><span id="row-count">Menampilkan 1 - 7 dari 24 lokasi rak aktif</span><span>Baris per halaman:</span><select id="page-size" class="h-8 rounded bg-blue-50 px-2 text-[12px]"><option value="7">7</option><option value="10">10</option><option value="25">25</option></select></div>
          <div class="flex items-center gap-1.5"><button id="previous-page" class="h-8 rounded bg-blue-50 px-3 text-[12px] text-slate-600 disabled:opacity-50">‹ Sebelumnya</button><div id="pagination" class="flex items-center gap-1.5"></div><button id="next-page" class="h-8 rounded bg-blue-50 px-3 text-[12px] text-slate-600 disabled:opacity-50">Selanjutnya ›</button></div>
        </footer>
      </section>

      <section id="grid-view" class="hidden grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3"></section>

      <section class="reveal delay-3 mt-4 grid grid-cols-1 gap-3 lg:grid-cols-3">
        <article class="flex min-h-[60px] flex-col justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
          <div class="flex gap-3"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="printer" class="h-4 w-4"></i></span><div><h2 class="text-[12px] font-semibold text-slate-800">Cetak Batch Label Barcode Rak</h2><p class="mt-0.5 text-[10.5px] leading-relaxed text-slate-500">Generate QR code standar ISO/IEC 18004 dan label barcode Code-128 untuk navigasi barcode scanner armada gudang.</p></div></div>
          <div class="mt-3 flex items-center justify-between text-[10.5px]"><span class="text-slate-500">Format: QR & EAN-128</span><button data-action="label" class="font-semibold text-blue-600 hover:text-blue-800">Konfigurasi →</button></div>
        </article>
        <article class="flex min-h-[60px] flex-col justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
          <div class="flex gap-3"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-red-50 text-red-600"><i data-lucide="bell-ring" class="h-4 w-4"></i></span><div><h2 class="text-[12px] font-semibold text-slate-800">Atur Ambang Batas Okupansi (Warning ROP)</h2><p class="mt-0.5 text-[10.5px] leading-relaxed text-slate-500">Kirimkan alert otomatis via email dan push notification ke Kepala Regu jika okupansi rak lorong melampaui &gt; 85%.</p></div></div>
          <div class="mt-3 flex items-center justify-between text-[10.5px]"><span class="text-slate-500">Ambang: 85% - 90%</span><button data-action="occupancy" class="font-semibold text-blue-600 hover:text-blue-800">Kelola</button></div>
        </article>
        <article class="flex min-h-[60px] flex-col justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
          <div class="flex gap-3"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-emerald-50 text-emerald-700"><i data-lucide="wand-sparkles" class="h-4 w-4"></i></span><div><h2 class="text-[12px] font-semibold text-slate-800">Optimasi Slotting Otomatis (AI Suggestion)</h2><p class="mt-0.5 text-[10.5px] leading-relaxed text-slate-500">Rekomendasi penempatan barang fast-moving lebih dekat ke loading dock untuk memangkas waktu picking hingga 24%.</p></div></div>
          <div class="mt-3 flex items-center justify-between text-[10.5px]"><span class="font-semibold text-emerald-700">14 rekomendasi siap</span><button data-action="optimize" class="rounded-md bg-emerald-700 px-3 py-1.5 font-semibold text-white hover:bg-emerald-800">Tinjau</button></div>
        </article>
      </section>
        @endif

        {{-- ================= ROLE LAIN (placeholder) ================= --}}
        @if(!auth()->user()->isSuperAdmin())
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-10 text-center">
            <i class="fas fa-lock text-4xl text-gray-300 mb-3"></i>
            <h2 class="text-lg font-bold text-gray-900">Manajemen Data Gudang &amp; Lokasi Rak</h2>
            <p class="text-sm text-gray-500 mt-1 max-w-md mx-auto">Halaman ini hanya tersedia untuk role Super Admin.</p>
        </div>
        @endif

    </main>
</div>

{{-- ================= MODAL, TOAST & SCRIPT (Super Admin) ================= --}}
@if(auth()->user()->isSuperAdmin())
  <div id="location-modal" class="fixed inset-0 z-[70] hidden items-center justify-center bg-slate-950/30 p-4">
    <form id="location-form" class="w-full max-w-[420px] rounded-xl bg-white p-4 shadow-xl">
      <div class="mb-3 flex items-start justify-between"><div><h2 class="text-[12px] font-bold text-slate-800">Tambah Lokasi Rak</h2><p class="mt-1 text-[10.5px] text-slate-500">Daftarkan lokasi penyimpanan baru di gudang.</p></div><button type="button" id="close-modal" class="rounded p-1 text-slate-400 hover:bg-slate-100" aria-label="Tutup"><i data-lucide="x" class="h-4 w-4"></i></button></div>
      <label class="mb-2 block text-[12px] font-medium text-slate-700">Kode & nama lokasi<input name="code" required maxlength="20" pattern="[A-Za-z0-9-]+" class="mt-1 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] uppercase outline-none focus:border-blue-500" placeholder="WH01-ZA-RA03"></label>
      <label class="mb-3 block text-[12px] font-medium text-slate-700">Tipe penyimpanan<select name="type" required class="mt-1 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500"><option value="">Pilih tipe rak</option><option>Heavy-Duty Shelf</option><option>High-Security Cage</option><option>Multi-Tier Bin</option><option>Pallet Racking Drive-in</option><option>Cartilever & Floor Bay</option><option>Temporary Flow Rack</option></select></label>
      <div class="mb-3 grid grid-cols-2 gap-3"><label class="block text-[12px] font-medium text-slate-700">Kapasitas<input name="capacity" type="number" min="1" required class="mt-1 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="400"></label><label class="block text-[12px] font-medium text-slate-700">Satuan kapasitas<select name="unit" class="mt-1 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500"><option>Unit</option><option>Slot</option><option>Pallet</option><option>Koli</option></select></label></div>
      <p id="modal-error" class="mb-2 hidden text-[10.5px] text-red-600"></p>
      <div class="flex justify-end gap-2"><button type="button" id="cancel-modal" class="h-10 rounded-md border border-slate-200 px-4 text-[12px] font-medium text-slate-600 hover:bg-slate-50">Batal</button><button type="submit" class="h-10 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white hover:bg-blue-700">Simpan Lokasi</button></div>
    </form>
  </div>

  <div id="map-modal" class="fixed inset-0 z-[70] hidden items-center justify-center bg-slate-950/40 p-4">
    <section class="w-full max-w-3xl rounded-xl bg-white p-4 shadow-xl">
      <div class="mb-3 flex items-start justify-between"><div><h2 class="text-[12px] font-bold text-slate-800">Denah Zona Gudang DC-01</h2><p class="mt-1 text-[10.5px] text-slate-500">Ringkasan visual okupansi berdasarkan zona penyimpanan.</p></div><button id="close-map" class="rounded p-1 text-slate-400 hover:bg-slate-100" aria-label="Tutup denah"><i data-lucide="x" class="h-4 w-4"></i></button></div>
      <div id="map-zones" class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5"></div>
      <div class="mt-4 flex items-center gap-4 text-[10.5px] text-slate-600"><span class="flex items-center gap-2"><i class="h-3.5 w-3.5 rounded-sm bg-emerald-500"></i>Optimal</span><span class="flex items-center gap-2"><i class="h-3.5 w-3.5 rounded-sm bg-blue-600"></i>Terisi</span><span class="flex items-center gap-2"><i class="h-3.5 w-3.5 rounded-sm bg-red-500"></i>Kritis</span></div>
    </section>
  </div>
  <div id="toast" role="status" class="fixed bottom-4 right-4 z-[80] hidden rounded-lg bg-slate-900 px-4 py-3 text-[12px] text-white shadow-lg"></div>

  <script>
    lucide.createIcons();


    const zones = [
      { name: 'Zona A', detail: 'Elektronik & High-Value', percent: 92, slots: '460 / 500 Slot', building: 'WH01' },
      { name: 'Zona B', detail: 'Aksesoris & Periferal', percent: 64, slots: '320 / 500 Slot', building: 'WH01' },
      { name: 'Zona C', detail: 'Komponen Komputer', percent: 88, slots: '440 / 500 Slot', building: 'WH02' },
      { name: 'Zona D', detail: 'Tools & Heavy Pallet', percent: 45, slots: '180 / 400 Slot', building: 'WH02' },
      { name: 'Zona E', detail: 'Staging & Inbound Buffer', percent: 70, slots: '175 / 250 Slot', building: 'WH03' }
    ];
    const locations = [
      { code: 'WH01-ZA-RA01', short: 'RA01', aisle: 'Rak Lorong A-01 (Lantai 1)', type: 'Heavy-Duty Shelf', capacity: 400, unit: 'Unit', filled: 390, rate: 92, sku: 18, goods: 'Kamera & Optik', status: 'Hampir Penuh', zone: 'Zona A', building: 'WH01' },
      { code: 'WH01-ZA-RA02', short: 'RA02', aisle: 'Rak Lorong A-02 (Lantai 1)', type: 'High-Security Cage', capacity: 250, unit: 'Unit', filled: 210, rate: 84, sku: 12, goods: 'Laptop Bisnis', status: 'Optimal', zone: 'Zona A', building: 'WH01' },
      { code: 'WH01-ZB-RB01', short: 'RB01', aisle: 'Rak Lorong B-01 (Lantai 1)', type: 'Multi-Tier Bin', capacity: 600, unit: 'Bin', filled: 360, rate: 60, sku: 45, goods: 'Aksesoris & Kabel', status: 'Optimal', zone: 'Zona B', building: 'WH01' },
      { code: 'WH01-ZB-RB02', short: 'RB02', aisle: 'Rak Lorong B-02 (Lantai 1)', type: 'Multi-Tier Bin', capacity: 600, unit: 'Bin', filled: 288, rate: 48, sku: 32, goods: 'Smartwatch & Audio', status: 'Lapang', zone: 'Zona B', building: 'WH01' },
      { code: 'WH02-ZC-RC01', short: 'RC01', aisle: 'Rak Lorong C-01 (Lantai 2)', type: 'Pallet Racking Drive-in', capacity: 50, unit: 'Pallet', filled: 44, rate: 88, sku: 8, goods: 'Bulk Storage SSD/HDD', status: 'Optimal', zone: 'Zona C', building: 'WH02' },
      { code: 'WH02-ZD-RD01', short: 'RD01', aisle: 'Rak Lorong D-01 (Lantai 2)', type: 'Cantilever & Floor Bay', capacity: 30, unit: 'Pallet', filled: 9, rate: 30, sku: 4, goods: 'Peralatan & Scanner', status: 'Lapang', zone: 'Zona D', building: 'WH02' },
      { code: 'WH03-ZE-RE01', short: 'RE01', aisle: 'Pojok Staging Area E-01 (Inbound)', type: 'Temporary Flow Rack', capacity: 200, unit: 'Unit', filled: 150, rate: 75, sku: 6, goods: 'Inbound QC & Outbound', status: 'Area Transit', zone: 'Zona E', building: 'WH03' }
    ];
    const extraOccupancy = [68, 57, 38, 73, 82, 44, 96, 55, 61, 72, 48, 86, 94, 63, 41, 77, 52];
    const extraTypes = ['Heavy-Duty Shelf', 'Multi-Tier Bin', 'Pallet Racking Drive-in', 'High-Security Cage', 'Temporary Flow Rack', 'Cantilever & Floor Bay'];
    const extraGoods = ['Elektronik & Periferal', 'Komponen & Kabel', 'Media Penyimpanan', 'Perangkat Komputer', 'Barang Inbound', 'Peralatan Operasional'];
    const extraZones = [
      { zone: 'A', building: 'WH01' },
      { zone: 'B', building: 'WH01' },
      { zone: 'C', building: 'WH02' },
      { zone: 'D', building: 'WH02' },
      { zone: 'E', building: 'WH03' }
    ];
    extraOccupancy.forEach((rate, index) => {
      const { zone, building } = extraZones[index % extraZones.length];
      const code = `${building}-Z${zone}-R${zone}${String(index + 3).padStart(2, '0')}`;
      const type = extraTypes[index % extraTypes.length];
      const unit = type === 'Pallet Racking Drive-in' || type === 'Cantilever & Floor Bay' ? 'Pallet' : type === 'Multi-Tier Bin' ? 'Bin' : 'Unit';
      const capacity = unit === 'Pallet' ? 50 : unit === 'Bin' ? 600 : 400;
      locations.push({
        code,
        short: code.slice(-4),
        aisle: `Rak Lorong ${zone}-${String(index + 3).padStart(2, '0')} (Lantai ${building === 'WH01' ? '1' : '2'})`,
        type,
        capacity,
        unit,
        filled: Math.round(capacity * rate / 100),
        rate,
        sku: 4 + index * 3,
        goods: extraGoods[index % extraGoods.length],
        status: rate > 90 ? 'Hampir Penuh' : rate < 50 ? 'Lapang' : 'Optimal',
        zone: `Zona ${zone}`,
        building
      });
    });
    const rows = document.getElementById('location-rows');
    const cards = document.getElementById('grid-view');
    const search = document.getElementById('location-search');
    const buildingFilter = document.getElementById('building-filter');
    const typeFilter = document.getElementById('type-filter');
    const occupancyFilter = document.getElementById('occupancy-filter');
    const pageSize = document.getElementById('page-size');
    const chipsContainer = document.getElementById('location-chips');
    let activeChip = '';
    let currentPage = 1;

    function escapeHtml(value) {
      return String(value).replace(/[&<>"']/g, (character) => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
      })[character]);
    }

    function occupancyStatus(rate) {
      if (rate > 90) return 'high';
      if (rate < 50) return 'low';
      return 'optimal';
    }

    function filteredLocations() {
      const query = search.value.trim().toLowerCase();
      return locations.filter((location) => {
        const matchesQuery = !query || `${location.code} ${location.aisle} ${location.type} ${location.zone} ${location.building} ${location.goods}`.toLowerCase().includes(query);
        const matchesBuilding = !buildingFilter.value || location.building === buildingFilter.value;
        const matchesType = !typeFilter.value || location.type === typeFilter.value;
        const matchesOccupancy = !occupancyFilter.value || occupancyStatus(location.rate) === occupancyFilter.value;
        const matchesChip = !activeChip || location.zone === activeChip;
        return matchesQuery && matchesBuilding && matchesType && matchesOccupancy && matchesChip;
      });
    }

    function renderZones() {
      const markup = zones.map((zone) => {
        const color = zone.percent >= 90 ? 'bg-red-500' : zone.percent >= 60 ? 'bg-blue-600' : 'bg-emerald-600';
        const badge = zone.percent >= 90 ? 'bg-red-100 text-red-700' : zone.percent >= 80 ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700';
        return `<article class="rounded-lg border border-slate-100 bg-blue-50/50 p-3 transition hover:-translate-y-0.5 hover:shadow-sm">
          <div class="flex items-center justify-between gap-2"><h3 class="text-[12px] font-semibold text-slate-800">${zone.name}</h3><span class="rounded-full ${badge} px-2 py-1 text-[10.5px] font-semibold">${zone.percent}% Terisi</span></div>
          <p class="mt-1 text-[10.5px] text-slate-600">${zone.detail}</p><div class="mt-2 h-1 rounded-full bg-slate-200"><div class="h-full rounded-full ${color}" style="width:${zone.percent}%"></div></div>
          <div class="mt-1.5 flex justify-between text-[10.5px] text-slate-500"><span>${zone.slots}</span><b class="text-slate-600">${zone.building}</b></div></article>`;
      }).join('');
      document.getElementById('zone-cards').innerHTML = markup;
      document.getElementById('map-zones').innerHTML = zones.map((zone) => {
        const tone = zone.percent >= 90 ? 'border-red-200 bg-red-50' : zone.percent >= 60 ? 'border-blue-200 bg-blue-50' : 'border-emerald-200 bg-emerald-50';
        return `<article class="rounded-lg border ${tone} p-3"><h3 class="text-[12px] font-semibold text-slate-800">${zone.name}</h3><p class="mt-1 text-[10.5px] text-slate-500">${zone.detail}</p><p class="mt-3 text-[24px] font-bold text-slate-800">${zone.percent}%</p><p class="text-[10.5px] text-slate-500">${zone.slots}</p></article>`;
      }).join('');
    }

    function locationRow(location, index) {
      const statusClass = {
        'Hampir Penuh': 'bg-red-100 text-red-700',
        Optimal: 'bg-emerald-100 text-emerald-800',
        Lapang: 'bg-blue-100 text-blue-700',
        'Area Transit': 'bg-indigo-100 text-indigo-700'
      }[location.status];
      const barClass = location.rate > 90 ? 'bg-red-600' : location.rate >= 50 ? 'bg-blue-600' : 'bg-emerald-600';
      const code = escapeHtml(location.code);
      return `<tr class="location-row h-[60px] hover:bg-slate-50/70" style="animation-delay:${Math.min(index * 25, 175)}ms">
        <td class="px-3"><input type="checkbox" aria-label="Pilih lokasi ${code}" class="row-checkbox h-4 w-4 accent-blue-600"></td>
        <td class="px-2"><div class="flex items-center gap-2"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-blue-50 text-[9.5px] font-bold text-blue-600">${escapeHtml(location.short)}</span><span class="min-w-0"><b class="block truncate text-[12px] font-semibold text-blue-700">${code}</b><span class="block truncate text-[10.5px] text-slate-500">${escapeHtml(location.aisle)}</span></span></div></td>
        <td class="px-2"><span class="block text-[12px] font-medium text-slate-700">${escapeHtml(location.type)}</span><span class="text-[10.5px] text-slate-500">${location.type === 'Heavy-Duty Shelf' ? 'Steel Tier (Level 1-4)' : location.type === 'High-Security Cage' ? 'Cage Rack & Kamera CCTV' : location.type === 'Multi-Tier Bin' ? 'Small Parts Bins (A-H8)' : location.type === 'Pallet Racking Drive-in' ? 'Forklift Dedicated Bay' : location.type === 'Cantilever & Floor Bay' ? 'Oversized Cargo & Racks' : 'Temporary Flow Storage'}</span></td>
        <td class="px-2"><b class="text-[12px] font-semibold text-slate-700">${location.capacity} ${location.unit}</b><span class="block text-[10.5px] text-slate-500">Beban maks. ${location.unit === 'Pallet' ? '10.000 kg' : '2.000 kg'}</span></td>
        <td class="px-2"><div class="flex items-center justify-between gap-2 text-[10.5px]"><b class="${location.rate > 90 ? 'text-red-600' : 'text-blue-700'}">${location.filled} ${location.unit}</b><span class="font-semibold ${location.rate > 90 ? 'text-red-600' : 'text-emerald-700'}">${location.rate}%</span></div><div class="mt-1 h-1 rounded-full bg-slate-100"><div class="h-full rounded-full ${barClass}" style="width:${location.rate}%"></div></div><span class="mt-1 block truncate text-[10.5px] text-slate-500">Sisa ruang: ${location.capacity - location.filled} ${location.unit}</span></td>
        <td class="px-2"><b class="block text-[12px] font-semibold text-slate-700">${location.sku} SKU</b><span class="block truncate text-[10.5px] text-slate-500">${escapeHtml(location.goods)}</span></td>
        <td class="px-2"><span class="rounded-full ${statusClass} px-2 py-1 text-[10.5px] font-semibold">● ${location.status}</span></td>
        <td class="px-2"><div class="flex items-center gap-1.5 text-slate-500"><button class="location-action rounded p-1.5 hover:bg-slate-100 hover:text-blue-700" data-action="view" data-code="${code}" aria-label="Lihat ${code}"><i data-lucide="eye" class="h-4 w-4"></i></button><button class="location-action rounded p-1.5 hover:bg-slate-100 hover:text-blue-700" data-action="edit" data-code="${code}" aria-label="Edit ${code}"><i data-lucide="pencil" class="h-4 w-4"></i></button><button class="location-action rounded p-1.5 hover:bg-slate-100 hover:text-blue-700" data-action="label" data-code="${code}" aria-label="Label ${code}"><i data-lucide="qr-code" class="h-4 w-4"></i></button></div></td>
      </tr>`;
    }

    function locationCard(location, index) {
      const tone = location.rate > 90 ? 'text-red-600' : location.rate >= 50 ? 'text-blue-700' : 'text-emerald-700';
      return `<article class="location-row rounded-xl border border-slate-100 bg-white p-4 shadow-sm" style="animation-delay:${index * 25}ms"><div class="flex items-start justify-between gap-2"><div class="flex items-center gap-2"><span class="flex h-8 w-8 items-center justify-center rounded-md bg-blue-50 text-[9.5px] font-bold text-blue-600">${escapeHtml(location.short)}</span><div><h3 class="text-[12px] font-semibold text-blue-700">${escapeHtml(location.code)}</h3><p class="text-[10.5px] text-slate-500">${escapeHtml(location.zone)} · ${location.building}</p></div></div><span class="rounded-full bg-blue-50 px-2 py-1 text-[10.5px]">${location.status}</span></div><p class="mt-3 text-[12px] font-medium text-slate-700">${escapeHtml(location.type)}</p><p class="text-[10.5px] text-slate-500">${escapeHtml(location.aisle)}</p><div class="mt-3 flex justify-between text-[10.5px]"><span>Kapasitas ${location.capacity} ${location.unit}</span><b class="${tone}">${location.rate}% terisi</b></div><div class="mt-1 h-1 rounded-full bg-slate-100"><div class="h-full rounded-full ${location.rate > 90 ? 'bg-red-600' : 'bg-blue-600'}" style="width:${location.rate}%"></div></div><p class="mt-2 text-[10.5px] text-slate-500">${location.sku} SKU · ${escapeHtml(location.goods)}</p></article>`;
    }

    function renderChips() {
      const items = [
        { name: 'Semua Lokasi', count: '1.840', zone: '' },
        { name: 'Zona A - Elektronik', count: '300', zone: 'Zona A' },
        { name: 'Zona B - Aksesoris', count: '500', zone: 'Zona B' },
        { name: 'Zona C - Komputer', count: '400', zone: 'Zona C' },
        { name: 'Slot Hampir Penuh', count: '42', zone: 'critical' },
        { name: 'Slot Kosong / Tersedia', count: '406', zone: 'available' }
      ];
      chipsContainer.innerHTML = items.map((item, index) => {
        const active = item.zone === 'critical'
          ? occupancyFilter.value === 'high'
          : item.zone === 'available'
            ? occupancyFilter.value === 'low'
            : activeChip === item.zone || (!activeChip && !occupancyFilter.value && index === 0);
        const color = item.zone === 'critical' ? 'bg-red-50 text-red-700' : item.zone === 'available' ? 'bg-emerald-50 text-emerald-700' : active ? 'bg-blue-700 text-white' : 'bg-blue-50 text-slate-700 hover:bg-blue-100';
        return `<button data-chip="${item.zone}" class="rounded-full px-3 py-1 text-[10.5px] font-semibold transition-colors ${color}">${item.name} (${item.count})</button>`;
      }).join('');
    }

    function render() {
      const filtered = filteredLocations();
      const size = Number(pageSize.value);
      const totalPages = Math.max(1, Math.ceil(filtered.length / size));
      currentPage = Math.min(currentPage, totalPages);
      const start = (currentPage - 1) * size;
      const pageItems = filtered.slice(start, start + size);
      rows.innerHTML = pageItems.map(locationRow).join('');
      cards.innerHTML = pageItems.map(locationCard).join('');
      document.getElementById('row-count').textContent = filtered.length
        ? `Menampilkan ${start + 1} - ${Math.min(start + size, filtered.length)} dari ${filtered.length === locations.length ? `${locations.length} lokasi rak aktif` : `${filtered.length} lokasi`}`
        : 'Tidak ada lokasi yang cocok';
      document.getElementById('pagination').innerHTML = Array.from({ length: totalPages }, (_, index) =>
        `<button data-page="${index + 1}" class="h-8 min-w-8 rounded px-2 text-[12px] ${currentPage === index + 1 ? 'bg-blue-700 text-white' : 'text-slate-600 hover:bg-blue-50'}">${index + 1}</button>`
      ).join('');
      document.getElementById('previous-page').disabled = currentPage === 1;
      document.getElementById('next-page').disabled = currentPage === totalPages;
      renderChips();
      lucide.createIcons();
    }

    function showToast(message) {
      const toast = document.getElementById('toast');
      toast.textContent = message;
      toast.classList.remove('hidden');
      clearTimeout(showToast.timeout);
      showToast.timeout = setTimeout(() => toast.classList.add('hidden'), 2800);
    }

    function setModal(id, open) {
      const modal = document.getElementById(id);
      modal.classList.toggle('hidden', !open);
      modal.classList.toggle('flex', open);
      document.body.classList.toggle('modal-open', open);
      if (open && id === 'location-modal') modal.querySelector('[name="code"]').focus();
    }

    [search, buildingFilter, typeFilter, occupancyFilter, pageSize].forEach((control) => {
      control.addEventListener(control === search ? 'input' : 'change', () => { currentPage = 1; render(); });
    });

    chipsContainer.addEventListener('click', (event) => {
      const button = event.target.closest('[data-chip]');
      if (!button) return;
      const value = button.dataset.chip;
      if (value === 'critical') {
        occupancyFilter.value = 'high';
        activeChip = '';
      } else if (value === 'available') {
        occupancyFilter.value = 'low';
        activeChip = '';
      } else {
        occupancyFilter.value = '';
        activeChip = value;
      }
      currentPage = 1;
      render();
    });

    document.getElementById('reset-filters').addEventListener('click', () => {
      search.value = '';
      buildingFilter.value = '';
      typeFilter.value = '';
      occupancyFilter.value = '';
      activeChip = '';
      currentPage = 1;
      render();
    });

    document.querySelectorAll('.view-button').forEach((button) => {
      button.addEventListener('click', () => {
        const isGrid = button.dataset.view === 'grid';
        document.getElementById('table-view').classList.toggle('hidden', isGrid);
        cards.classList.toggle('hidden', !isGrid);
        cards.classList.toggle('grid', isGrid);
        document.querySelectorAll('.view-button').forEach((item) => {
          const active = item === button;
          item.classList.toggle('bg-white', active);
          item.classList.toggle('font-semibold', active);
          item.classList.toggle('text-blue-700', active);
          item.classList.toggle('shadow-sm', active);
        });
      });
    });

    document.getElementById('pagination').addEventListener('click', (event) => {
      const button = event.target.closest('[data-page]');
      if (!button) return;
      currentPage = Number(button.dataset.page);
      render();
    });
    document.getElementById('previous-page').addEventListener('click', () => { currentPage = Math.max(1, currentPage - 1); render(); });
    document.getElementById('next-page').addEventListener('click', () => { currentPage += 1; render(); });

    rows.addEventListener('click', (event) => {
      const button = event.target.closest('.location-action');
      if (!button) return;
      const actionLabel = { view: 'Detail lokasi', edit: 'Mode edit lokasi', label: 'Label barcode' }[button.dataset.action];
      showToast(`${actionLabel} ${button.dataset.code} siap dibuka.`);
    });

    document.querySelector('thead input[type="checkbox"]').addEventListener('change', (event) => {
      document.querySelectorAll('.row-checkbox').forEach((checkbox) => { checkbox.checked = event.target.checked; });
    });

    document.getElementById('export-layout').addEventListener('click', () => {
      const csv = ['Kode,Nama Lokasi,Tipe,Kapasitas,Terisi,Okupansi,SKU,Status', ...filteredLocations().map((location) =>
        [location.code, location.aisle, location.type, `${location.capacity} ${location.unit}`, `${location.filled} ${location.unit}`, `${location.rate}%`, location.sku, location.status]
          .map((value) => `"${String(value).replaceAll('"', '""')}"`).join(',')
      )].join('\n');
      const link = document.createElement('a');
      link.href = URL.createObjectURL(new Blob([csv], { type: 'text/csv;charset=utf-8' }));
      link.download = 'layout-gudang-dc-01.csv';
      link.click();
      URL.revokeObjectURL(link.href);
    });

    document.getElementById('audit-button').addEventListener('click', () => showToast('Audit okupansi dimulai: data lokasi diperbarui.'));
    document.getElementById('open-map').addEventListener('click', () => setModal('map-modal', true));
    document.getElementById('close-map').addEventListener('click', () => setModal('map-modal', false));
    document.getElementById('map-modal').addEventListener('click', (event) => { if (event.target.id === 'map-modal') setModal('map-modal', false); });
    document.getElementById('add-location').addEventListener('click', () => setModal('location-modal', true));
    ['close-modal', 'cancel-modal'].forEach((id) => document.getElementById(id).addEventListener('click', () => setModal('location-modal', false)));
    document.getElementById('location-modal').addEventListener('click', (event) => { if (event.target.id === 'location-modal') setModal('location-modal', false); });
    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') {
        setModal('location-modal', false);
        setModal('map-modal', false);
      }
    });

    document.getElementById('location-form').addEventListener('submit', (event) => {
      event.preventDefault();
      const form = event.currentTarget;
      const values = Object.fromEntries(new FormData(form));
      const code = values.code.trim().toUpperCase();
      const error = document.getElementById('modal-error');
      if (locations.some((location) => location.code.toLowerCase() === code.toLowerCase())) {
        error.textContent = 'Kode lokasi tersebut sudah terdaftar.';
        error.classList.remove('hidden');
        return;
      }
      const building = code.slice(0, 4);
      const zoneMatch = code.match(/Z([A-F])/i);
      const zoneName = zoneMatch ? `Zona ${zoneMatch[1].toUpperCase()}` : 'Zona Baru';
      const capacity = Number(values.capacity);
      locations.push({
        code,
        short: code.slice(-4),
        aisle: `Lokasi baru ${code}`,
        type: values.type,
        capacity,
        unit: values.unit,
        filled: 0,
        rate: 0,
        sku: 0,
        goods: 'Belum ada SKU',
        status: 'Lapang',
        zone: zoneName,
        building
      });
      form.reset();
      error.classList.add('hidden');
      setModal('location-modal', false);
      currentPage = Math.ceil(locations.length / Number(pageSize.value));
      render();
      showToast(`Lokasi ${code} berhasil ditambahkan.`);
    });

    document.querySelectorAll('[data-action]').forEach((button) => {
      button.addEventListener('click', () => showToast(`${button.textContent.trim()} sedang disiapkan.`));
    });

    renderZones();
    render();
  </script>
@endif

</body>
</html>
