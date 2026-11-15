<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Kategori Barang - Astro Inventory</title>

    <!-- Tailwind CSS CDN + brand tokens -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { DEFAULT: '#2563eb', dark: '#1d4ed8', 50: '#eff6ff', 100: '#dbeafe', 600: '#2563eb', 700: '#1d4ed8' },
                        ink: '#17243b',
                        canvas: '#f5f7fc',
                        line: '#e8edf5',
                    },
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
        /* ============================================================
           Astro Inventory - gaya lokal halaman Manajemen Kategori Barang
           (diambil dari file sumber; blok milik shell sidebar/topbar
           dibuang karena digantikan komponen Blade)
           ============================================================ */
        /* Token disamakan dengan halaman superadmin lain supaya komponen
           components.sidebar tampil identik di seluruh aplikasi */
        :root {
            --brand: #2563eb;
            --brand-dark: #1d4ed8;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif;
        }

        /* Gaya .nav-link milik components.sidebar */
        .nav-link { transition: all 0.16s ease; }
        .nav-link:hover { background: #f1f5f9; color: #172033; transform: translateX(3px); }
        .nav-link.active { background: var(--brand); color: #fff; font-weight: 600; box-shadow: 0 6px 14px -6px rgba(37, 99, 235, 0.55); }
        .nav-link.active:hover { transform: none; background: var(--brand); }

        /* Animasi masuk konten halaman (dipakai section konten) */
        .reveal { animation: rise-in .45s cubic-bezier(.2,.8,.2,1) both; }
        .reveal-delay-1 { animation-delay: 50ms; }
        .reveal-delay-2 { animation-delay: 100ms; }
        .reveal-delay-3 { animation-delay: 150ms; }
        @keyframes rise-in { from { opacity: 0; transform: translateY(9px); } to { opacity: 1; transform: translateY(0); } }

        /* Animasi & tinggi baris kategori, plus ikon baris (dipakai konten) */
        .category-row { animation: row-in .3s ease both; }
        .category-row:hover .row-icon { transform: translateY(-1px) scale(1.05); }
        .row-icon { transition: transform .18s ease; }
        @keyframes row-in { from { opacity: 0; transform: translateX(-5px); } to { opacity: 1; transform: translateX(0); } }
        #category-rows > tr.category-row { height: 60px; }
        #table-view tbody { font-size: 12px; }
        #table-view tbody td { padding: 10px 12px; vertical-align: middle; }

        /* Efek tombol aksi halaman (dipakai konten) */
        .soft-button { transition: transform .16s ease, box-shadow .16s ease, background .16s ease; }
        .soft-button:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(15, 23, 42, .08); }

        /* Kunci scroll body saat modal terbuka (dipakai setModal) */
        .modal-open { overflow: hidden; }

        /* Skala konten mengikuti file sumber. Diterapkan ke <main> saja agar
           komponen navbar & sidebar tetap tampil 100% seperti halaman lain. */
        @media (min-width: 768px) {
            main { zoom: 1.15; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; scroll-behavior: auto !important; }
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50">

@include('components.navbar')

<div class="flex min-h-screen">
    @include('components.sidebar')

    <!-- Main Content -->
    <main class="flex-1 overflow-x-hidden bg-canvas p-4 lg:p-6">

        {{-- ================= SUPER ADMIN ================= --}}
        @if(auth()->user()->isSuperAdmin())

        <section class="reveal relative mb-4 flex flex-wrap items-end justify-between gap-3">
          <span class="absolute right-0 top-0 flex items-center gap-1.5 text-[10.5px] text-slate-500"><span class="h-1.5 w-1.5 animate-pulse rounded-full bg-emerald-500"></span>Sinkronisasi Katalog: 2 menit lalu</span>
          <div class="max-w-[600px]">
            <p class="mb-1 text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Master Data & Inventaris <span class="text-blue-700">&gt; Manajemen Kategori</span></p>
            <h1 class="text-[24px] font-bold leading-tight tracking-tight text-slate-800">Manajemen Kategori Barang & Klasifikasi</h1>
            <p class="mt-1.5 max-w-[600px] text-[12px] leading-relaxed text-slate-500">Pengelompokan hierarki komoditas inventaris, alokasi zona penyimpanan gudang, pengaturan batasan buffer stock, dan rekapitulasi SKU aktif.</p>
          </div>
          <div class="flex items-center gap-2">
            <button id="export-button" class="soft-button flex h-10 items-center gap-2 rounded-md border border-slate-100 bg-white px-4 text-[12px] font-semibold text-slate-700 shadow-sm"><i data-lucide="download" class="h-4 w-4 text-blue-600"></i>Ekspor Hierarki</button>
            <button id="zone-button" class="soft-button flex h-10 items-center gap-2 rounded-md border border-slate-100 bg-white px-4 text-[12px] font-semibold text-slate-700 shadow-sm"><i data-lucide="map" class="h-4 w-4 text-blue-600"></i>Atur Zona Rak</button>
            <button id="add-category" class="soft-button flex h-10 items-center gap-2 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white shadow-sm hover:bg-blue-700"><i data-lucide="plus" class="h-4 w-4"></i>Tambah Kategori Baru</button>
          </div>
        </section>

        <section aria-label="Ringkasan kategori" class="reveal reveal-delay-1 mb-4 grid grid-cols-2 gap-3 md:grid-cols-4">
          <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
            <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Total Kategori Aktif</p><p id="total-categories" class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight">28</p><p class="mt-2.5 text-[10.5px] text-slate-500"><span class="font-semibold text-emerald-700">↗ +3 bulan ini</span></p></div>
            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600"><i data-lucide="folder" class="h-4 w-4"></i></span>
          </article>
          <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
            <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Sub-Kategori / Klasifikasi</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight">142</p><p class="mt-2.5 text-[10.5px] text-slate-500"><span class="rounded bg-blue-50 px-1.5 py-0.5 font-semibold text-blue-700">✥ 6 zona utama</span></p></div>
            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-700"><i data-lucide="network" class="h-4 w-4"></i></span>
          </article>
          <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
            <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Rata-rata SKU / Kategori</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight">308</p><p class="mt-2.5 text-[10.5px] text-slate-500"><span class="rounded bg-indigo-50 px-1.5 py-0.5 font-semibold text-indigo-700">Okupansi seimbang</span></p></div>
            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-100 text-indigo-700"><i data-lucide="chart-no-axes-column-increasing" class="h-4 w-4"></i></span>
          </article>
          <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-red-100 bg-red-50/50 px-4 py-3 shadow-sm">
            <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-red-600">Buffer Kritis</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight text-red-600">4</p><p class="mt-2.5 text-[10.5px] text-red-600"><span class="rounded bg-red-100 px-1.5 py-0.5 font-semibold">Stok di bawah 20%</span></p></div>
            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-100 text-red-600"><i data-lucide="triangle-alert" class="h-4 w-4"></i></span>
          </article>
        </section>

        <section class="reveal reveal-delay-2 mb-4 rounded-lg border border-slate-100 bg-white p-3 shadow-[0_1px_3px_rgba(15,23,42,.025)]">
          <div class="flex flex-wrap items-center gap-2">
            <label class="flex h-10 min-w-[220px] flex-1 items-center gap-2 rounded-md bg-blue-50/80 px-3 text-slate-400 md:max-w-[430px]">
              <i data-lucide="search" class="h-4 w-4"></i><input id="category-search" type="search" placeholder="Cari nama kategori, kode zona, zona gudang..." class="w-full bg-transparent text-[12px] text-slate-700 outline-none placeholder:text-slate-400"><i data-lucide="scan-search" class="h-4 w-4 text-slate-500"></i>
            </label>
            <select id="zone-filter" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none"><option value="">Semua Zona Rak</option><option>Zona A</option><option>Zona B</option><option>Zona C</option><option>Zona D</option></select>
            <select id="activity-filter" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none"><option value="">Status Aktivitas</option><option value="Aktif">Aktif</option><option value="Nonaktif">Nonaktif</option></select>
            <select id="sort-filter" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none"><option value="name">Tingkat Pengurutan</option><option value="sku-desc">SKU Terbanyak</option><option value="sku-asc">SKU Tersedikit</option></select>
            <div class="flex items-center rounded-md bg-blue-50 p-1">
              <button data-view="table" class="view-button flex h-8 items-center gap-1.5 rounded px-2.5 text-[10.5px] font-semibold text-blue-700"><i data-lucide="table-2" class="h-3.5 w-3.5"></i>Tabel</button>
              <button data-view="grid" class="view-button flex h-8 items-center gap-1.5 rounded px-2.5 text-[10.5px] text-slate-600"><i data-lucide="layout-grid" class="h-3.5 w-3.5"></i>Grid</button>
            </div>
          </div>
          <div id="category-chips" class="mt-3 flex flex-wrap items-center gap-2 text-[10.5px]"></div>
        </section>

        <section id="table-view" class="reveal reveal-delay-3 overflow-hidden rounded-lg border border-slate-200 bg-white shadow-[0_1px_3px_rgba(15,23,42,.025)]">
          <div class="overflow-x-auto">
            <table class="w-full min-w-[1300px] table-fixed border-collapse text-left">
              <thead class="h-11 bg-[#f0f4fc] text-[9.5px] font-semibold uppercase tracking-wide text-slate-600 whitespace-nowrap">
                <tr>
                  <th class="w-[48px] px-2"><input type="checkbox" aria-label="Pilih semua kategori" class="h-4 w-4 accent-blue-600"></th>
                  <th class="w-[260px] px-2">Nama Kategori & Hierarki</th>
                  <th class="w-[100px] px-2">Prefix SKU</th>
                  <th class="w-[170px] px-2">Alokasi Zona & Rak</th>
                  <th class="w-[120px] px-2">SKU Terdaftar</th>
                  <th class="w-[190px] px-2">Total Unit Fisik</th>
                  <th class="w-[140px] px-2">Perputaran Stok</th>
                  <th class="w-[170px] px-2">PIC Kategori</th>
                  <th class="w-[100px] px-2 text-center">Aksi</th>
                </tr>
              </thead>
              <tbody id="category-rows" class="divide-y divide-slate-100 text-[12px]"></tbody>
            </table>
          </div>
          <footer class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 px-4 py-3 text-[12px] text-slate-600">
            <div class="flex items-center gap-2"><span id="row-count">Menampilkan 1 - 8 dari 28 kategori</span><span>Baris:</span><select id="page-size" class="h-8 rounded bg-blue-50 px-2 text-[12px]"><option value="10">10</option><option value="25">25</option><option value="50">50</option></select></div>
            <div class="flex items-center gap-1.5"><button id="previous-page" class="rounded bg-blue-50 px-3 py-2 text-slate-600">‹ Sebelumnya</button><div id="pagination" class="flex items-center gap-1.5"></div><button id="next-page" class="rounded bg-blue-50 px-3 py-2 text-slate-600">Selanjutnya ›</button></div>
          </footer>
        </section>

        <section id="grid-view" class="hidden grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
          <div id="category-cards" class="contents"></div>
        </section>

        <section class="reveal reveal-delay-3 mt-4 grid grid-cols-1 gap-3 md:grid-cols-3">
          <article class="flex min-h-[60px] items-center gap-3 rounded-lg border border-slate-100 bg-white px-4 py-3 shadow-[0_1px_3px_rgba(15,23,42,.025)]">
            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="warehouse" class="h-4 w-4"></i></span><div><h2 class="text-[12px] font-semibold">Alokasi Otomatis Zona A (Fast Moving)</h2><p class="mt-0.5 text-[10.5px] text-slate-500">4 Kategori diprioritaskan dekat conveyor dispatch</p></div>
          </article>
          <article class="flex min-h-[60px] items-center gap-3 rounded-lg border border-slate-100 bg-white px-4 py-3 shadow-[0_1px_3px_rgba(15,23,42,.025)]">
            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-red-50 text-red-600"><i data-lucide="shield-alert" class="h-4 w-4"></i></span><div><h2 class="text-[12px] font-semibold">Penyesuaian Buffer Stok Q1</h2><p class="mt-0.5 text-[10.5px] text-slate-500">4 Kategori telah mencapai batas minimum re-order point</p></div>
          </article>
          <article class="flex min-h-[60px] items-center justify-between gap-3 rounded-lg border border-slate-100 bg-white px-4 py-3 shadow-[0_1px_3px_rgba(15,23,42,.025)]">
            <div class="flex items-center gap-3"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-slate-100 text-slate-600"><i data-lucide="scan-barcode" class="h-4 w-4"></i></span><div><h2 class="text-[12px] font-semibold">Prefix SKU Terstandarisasi</h2><p class="mt-0.5 text-[10.5px] text-slate-500">Format: [CAT]-[SUB]-[WH]-[ID]</p></div></div><button class="text-[10.5px] font-semibold text-blue-600">Konfigurasi →</button>
          </article>
        </section>
        @endif

    </main>
</div>

<div id="category-modal" class="fixed inset-0 z-[70] hidden items-center justify-center bg-slate-950/30 p-4">
  <form id="category-form" class="w-full max-w-[320px] rounded-xl bg-white p-4 shadow-xl">
    <div class="mb-3 flex items-start justify-between"><div><h2 class="text-sm font-bold text-slate-800">Tambah Kategori</h2><p class="mt-1 text-[10.5px] text-slate-500">Tambahkan kategori baru ke katalog inventaris.</p></div><button type="button" id="close-modal" class="rounded p-1 text-slate-400 hover:bg-slate-100" aria-label="Tutup"><i data-lucide="x" class="h-4 w-4"></i></button></div>
    <label class="mb-2 block text-[12px] font-medium text-slate-700">Nama kategori<input name="name" required maxlength="48" class="mt-1 w-full rounded-md border border-slate-200 px-2 py-1.5 text-xs outline-none focus:border-blue-500" placeholder="Contoh: Peralatan Jaringan"></label>
    <label class="mb-3 block text-[12px] font-medium text-slate-700">Prefix SKU<input name="prefix" required maxlength="5" pattern="[A-Za-z0-9]{2,5}" class="mt-1 w-full rounded-md border border-slate-200 px-2 py-1.5 text-xs uppercase outline-none focus:border-blue-500" placeholder="NET"></label>
    <p id="modal-error" class="mb-2 hidden text-[10.5px] text-red-600"></p>
    <div class="flex justify-end gap-2"><button type="button" id="cancel-modal" class="rounded-md border border-slate-200 px-4 py-2 text-[12px] font-medium text-slate-600 hover:bg-slate-50">Batal</button><button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-[12px] font-semibold text-white hover:bg-blue-700">Simpan Kategori</button></div>
  </form>
</div>

<div id="toast" role="status" class="fixed bottom-4 right-4 z-[80] hidden rounded-lg bg-slate-900 px-3 py-2 text-xs text-white shadow-lg"></div>

<script>
/* ============================================================
   Astro Inventory - logika halaman Manajemen Kategori Barang: render tabel &
   grid kategori, chip filter, pengurutan, pagination, modal tambah kategori,
   ekspor CSV, dan toast.
   Shell sidebar/topbar file sumber dibuang (digantikan komponen Blade
   components.navbar & components.sidebar); handler toggleSidebar() ikut
   dibuang karena sidebar komponen mengurus dirinya sendiri.
   ============================================================ */
    lucide.createIcons();

    const categoryData = [
      { name: 'Kamera & Optik', detail: 'DSLR, Mirrorless, Lensa & Aksesoris Studio', prefix: 'CAM-', zone: 'Zona A', rack: 'WH01-RA-01 (01-04)', sku: 420, units: '18.500 Unit', percent: 75, rotation: 'Fast Moving', icon: 'camera', person: 'Hendra Kusuma', initials: 'HK', color: 'blue', subs: 11 },
      { name: 'Laptop & Komputer', detail: 'Laptop Bisnis, Ultrabook, PC Rakitan & Mini PC', prefix: 'LAP-', zone: 'Zona A', rack: 'WH01-RB-01B (01-06)', sku: 680, units: '24.100 Unit', percent: 92, rotation: 'Fast Moving', icon: 'laptop', person: 'Rizki Hidayat', initials: 'RH', color: 'slate', subs: 14 },
      { name: 'Aksesoris Komputer', detail: 'Keyboard Mekanikal, Mouse, Kabel Data & Adaptor', prefix: 'ACC-', zone: 'Zona B', rack: 'WH01-RC-01 (01-12)', sku: 1890, units: '85.400 Unit', percent: 60, rotation: 'Medium Moving', icon: 'keyboard', person: 'Dewi Anggraini', initials: 'DA', color: 'emerald', subs: 21 },
      { name: 'Wearable Gadget', detail: 'Smartwatch, Smartband, Smart Ring & Tali Jam', prefix: 'WTC-', zone: 'Zona A', rack: 'WH01-RA-01 (01-08)', sku: 450, units: '32.000 Unit', percent: 84, rotation: 'Fast Moving', icon: 'watch', person: 'Budi Setiadi', initials: 'BS', color: 'blue', subs: 9 },
      { name: 'Audio & Sound System', detail: 'Headset, TWS, Soundbar, Mikrofon & Interface', prefix: 'AUD-', zone: 'Zona C', rack: 'WH01-RE-01 (01-05)', sku: 870, units: '41.200 Unit', percent: 45, rotation: 'Medium Moving', icon: 'headphones', person: 'Fajar Kurnia', initials: 'FK', color: 'amber', subs: 16 },
      { name: 'Storage & Media Drive', detail: 'SSD NVMe, External HDD, Flashdisk & MicroSD Card', prefix: 'STR-', zone: 'Zona B', rack: 'WH01-RC-01 (01-05)', sku: 1250, units: '62.000 Unit', percent: 88, rotation: 'Fast Moving', icon: 'hard-drive', person: 'Siti Nurhaliza', initials: 'SN', color: 'indigo', subs: 12 },
      { name: 'Peralatan & Tools Gudang', detail: 'Barcode Scanner, Label Printer, Rak Bin & Pallet Jack', prefix: 'TLS-', zone: 'Zona C', rack: 'WH02-RA-02 (01-03)', sku: 310, units: '8.400 Unit', percent: 30, rotation: 'Slow Moving', icon: 'wrench', person: 'Joko Susilo', initials: 'JS', color: 'slate', subs: 7 },
      { name: 'Jaringan & Komunikasi', detail: 'Router, Switch, Access Point & Kabel Jaringan', prefix: 'NET-', zone: 'Zona D', rack: 'WH02-RB-01 (01-04)', sku: 528, units: '21.600 Unit', percent: 52, rotation: 'Medium Moving', icon: 'router', person: 'Maya Putri', initials: 'MP', color: 'purple', subs: 10 }
    ];

    const categoryRows = document.getElementById('category-rows');
    const categoryCards = document.getElementById('category-cards');
    const searchInput = document.getElementById('category-search');
    const zoneFilter = document.getElementById('zone-filter');
    const activityFilter = document.getElementById('activity-filter');
    const sortFilter = document.getElementById('sort-filter');
    const categoryChips = document.getElementById('category-chips');
    const pageSize = document.getElementById('page-size');
    let activeChip = '';
    let currentPage = 1;
    let currentView = 'table';
    const colors = {
      blue: ['bg-blue-100', 'text-blue-700'],
      slate: ['bg-slate-200', 'text-slate-600'],
      emerald: ['bg-emerald-100', 'text-emerald-700'],
      amber: ['bg-amber-100', 'text-amber-700'],
      indigo: ['bg-indigo-100', 'text-indigo-700'],
      purple: ['bg-violet-100', 'text-violet-700']
    };

    function compactNumber(value) {
      return new Intl.NumberFormat('id-ID').format(value);
    }

    function escapeHtml(value) {
      return String(value).replace(/[&<>"']/g, (character) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;'
      })[character]);
    }

    function visibleCategories() {
      const query = searchInput.value.trim().toLowerCase();
      const filtered = categoryData.filter((category) => {
        const matchesQuery = !query || `${category.name} ${category.detail} ${category.prefix} ${category.zone} ${category.rack} ${category.person}`.toLowerCase().includes(query);
        const matchesZone = !zoneFilter.value || category.zone === zoneFilter.value;
        const matchesActivity = !activityFilter.value || activityFilter.value === 'Aktif';
        const matchesChip = !activeChip || (activeChip === 'Semua Kategori' || category.name === activeChip);
        return matchesQuery && matchesZone && matchesActivity && matchesChip;
      });
      if (sortFilter.value === 'sku-desc') filtered.sort((a, b) => b.sku - a.sku);
      if (sortFilter.value === 'sku-asc') filtered.sort((a, b) => a.sku - b.sku);
      return filtered;
    }

    function categoryRow(category, index) {
      const tone = colors[category.color] || colors.blue;
      const safeName = escapeHtml(category.name);
      const safePrefix = escapeHtml(category.prefix);
      const rotationTone = category.rotation === 'Fast Moving'
        ? 'bg-emerald-100 text-emerald-800'
        : category.rotation === 'Medium Moving'
          ? 'bg-blue-100 text-blue-700'
          : 'bg-indigo-100 text-indigo-700';
      return `<tr data-category="${safeName}" class="category-row hover:bg-slate-50/70" style="animation-delay:${Math.min(index * 25, 175)}ms">
        <td class="px-2"><div class="flex items-center gap-1.5"><button class="expand-category rounded p-1 text-slate-400 hover:bg-blue-50 hover:text-blue-600" aria-label="Lihat subkategori ${safeName}" aria-expanded="false"><i data-lucide="chevron-right" class="h-4 w-4 transition-transform"></i></button><input type="checkbox" aria-label="Pilih kategori ${safeName}" class="h-4 w-4 accent-blue-600"></div></td>
        <td class="px-1"><div class="flex items-center gap-2.5"><span class="row-icon flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="${category.icon}" class="h-4 w-4"></i></span><span class="min-w-0"><b class="block truncate text-[12px] font-semibold text-slate-800">${safeName} <span class="rounded bg-blue-50 px-1.5 py-0.5 text-[9.5px] font-medium text-blue-700">Lv 1</span></b><span class="mt-0.5 block truncate text-[10.5px] text-slate-500">${category.detail}</span></span></div></td>
        <td class="px-1"><span class="rounded bg-blue-100 px-2 py-1 text-[10.5px] font-semibold text-blue-700">${safePrefix}</span></td>
        <td class="px-1"><span class="flex items-center gap-1 whitespace-nowrap text-[12px] font-medium text-slate-700"><i data-lucide="map-pin" class="h-3.5 w-3.5 shrink-0 text-blue-600"></i>${category.zone}</span><span class="mt-0.5 block truncate whitespace-nowrap pl-[18px] text-[10.5px] text-slate-500">Rak ${category.rack}</span></td>
        <td class="px-1"><span class="rounded-full bg-blue-100 px-2.5 py-1 text-[10.5px] font-semibold text-blue-700">${compactNumber(category.sku)} SKU</span></td>
        <td class="px-1"><div class="flex items-baseline justify-between gap-2 text-[10.5px]"><b class="whitespace-nowrap text-[12px] text-slate-700">${category.units}</b><span class="whitespace-nowrap text-emerald-700">${category.percent}% Okupansi</span></div><div class="mt-1.5 h-1 rounded bg-blue-100"><div class="h-full rounded bg-emerald-600" style="width:${category.percent}%"></div></div></td>
        <td class="px-1"><span class="rounded-full ${rotationTone} px-2.5 py-1 text-[10.5px] font-semibold">${category.rotation}</span></td>
        <td class="px-1"><div class="flex items-center gap-3"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full ${tone[0]} text-[9.5px] font-bold ${tone[1]}">${category.initials}</span><span class="truncate"><b class="block truncate text-[12px] font-medium text-slate-700">${category.person}</b><span class="mt-0.5 block text-[10.5px] text-emerald-700">Aktif</span></span></div></td>
        <td class="px-1"><div class="flex items-center justify-center gap-1 text-slate-600"><button class="edit-category rounded p-1.5 hover:bg-slate-100" aria-label="Edit kategori ${category.name}"><i data-lucide="pencil" class="h-4 w-4"></i></button><button class="view-category rounded p-1.5 hover:bg-slate-100" aria-label="Lihat kategori ${category.name}"><i data-lucide="eye" class="h-4 w-4"></i></button><button class="more-category rounded p-1.5 hover:bg-slate-100" aria-label="Opsi kategori ${category.name}"><i data-lucide="ellipsis-vertical" class="h-4 w-4"></i></button></div></td>
      </tr>
      <tr class="subcategory-row hidden bg-slate-50/70" data-parent="${safeName}"><td></td><td colspan="8" class="px-2 py-2.5 text-[10.5px] text-slate-500"><span class="font-semibold text-slate-700">${category.subs} subkategori:</span> ${safeName} - Umum &nbsp;·&nbsp; ${safeName} - Premium &nbsp;·&nbsp; ${safeName} - Komponen</td></tr>`;
    }

    function categoryCard(category, index) {
      const tone = colors[category.color] || colors.blue;
      const safeName = escapeHtml(category.name);
      const safePrefix = escapeHtml(category.prefix);
      return `<article class="category-row rounded-lg border border-slate-100 bg-white p-3 shadow-sm" style="animation-delay:${index * 30}ms">
        <div class="flex items-start justify-between"><div class="flex items-center gap-2"><span class="row-icon flex h-7 w-7 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="${category.icon}" class="h-4 w-4"></i></span><div><h3 class="text-[12px] font-semibold text-slate-800">${safeName}</h3><p class="text-[10.5px] text-slate-500">${safePrefix} · ${category.zone}</p></div></div><span class="rounded-full bg-blue-100 px-2.5 py-1 text-[10.5px] font-semibold text-blue-700">${compactNumber(category.sku)} SKU</span></div>
        <p class="mt-3 text-[10.5px] text-slate-500">${category.detail}</p><div class="mt-3 flex justify-between text-[10.5px]"><span class="text-slate-500">Okupansi gudang</span><b class="text-emerald-700">${category.percent}%</b></div><div class="mt-1 h-1 rounded bg-blue-100"><div class="h-full rounded bg-emerald-600" style="width:${category.percent}%"></div></div><div class="mt-3 flex items-center justify-between text-[10.5px]"><span class="text-slate-500">${category.units}</span><span class="flex items-center gap-1.5"><span class="flex h-6 w-6 items-center justify-center rounded-full ${tone[0]} text-[9.5px] font-bold ${tone[1]}">${category.initials}</span>${category.person}</span></div>
      </article>`;
    }

    function renderChips() {
      const names = ['Semua Kategori', ...categoryData.slice(0, 5).map((category) => category.name)];
      categoryChips.innerHTML = names.map((name) => {
        const active = activeChip === name || (!activeChip && name === 'Semua Kategori');
        const count = name === 'Semua Kategori' ? 28 : categoryData.find((category) => category.name === name)?.sku;
        return `<button data-chip="${name}" class="rounded-full px-3 py-1 font-semibold transition-colors ${active ? 'bg-blue-700 text-white' : 'bg-blue-50 text-slate-700 hover:bg-blue-100'}">${name} (${name === 'Semua Kategori' ? 28 : compactNumber(count)})</button>`;
      }).join('');
    }

    function render() {
      const all = visibleCategories();
      const size = Number(pageSize.value);
      const totalPages = Math.max(1, Math.ceil(all.length / size));
      currentPage = Math.min(currentPage, totalPages);
      const start = (currentPage - 1) * size;
      const pageItems = all.slice(start, start + size);
      categoryRows.innerHTML = pageItems.map(categoryRow).join('');
      categoryCards.innerHTML = pageItems.map(categoryCard).join('');
      document.getElementById('row-count').textContent = all.length
        ? `Menampilkan ${start + 1} - ${Math.min(start + size, all.length)} dari ${all.length === categoryData.length ? 28 : all.length} kategori`
        : 'Tidak ada kategori yang cocok';
      document.getElementById('pagination').innerHTML = Array.from({ length: totalPages }, (_, index) =>
        `<button data-page="${index + 1}" class="h-8 min-w-8 rounded px-2 text-[12px] ${currentPage === index + 1 ? 'bg-blue-700 text-white' : 'text-slate-600 hover:bg-blue-50'}">${index + 1}</button>`
      ).join('');
      document.getElementById('previous-page').disabled = currentPage === 1;
      document.getElementById('next-page').disabled = currentPage === totalPages;
      document.getElementById('previous-page').classList.toggle('opacity-50', currentPage === 1);
      document.getElementById('next-page').classList.toggle('opacity-50', currentPage === totalPages);
      renderChips();
      lucide.createIcons();
    }

    function showToast(message) {
      const toast = document.getElementById('toast');
      toast.textContent = message;
      toast.classList.remove('hidden');
      clearTimeout(showToast.timeout);
      showToast.timeout = setTimeout(() => toast.classList.add('hidden'), 2600);
    }

    function setModal(open) {
      const modal = document.getElementById('category-modal');
      modal.classList.toggle('hidden', !open);
      modal.classList.toggle('flex', open);
      document.body.classList.toggle('modal-open', open);
      if (open) modal.querySelector('[name="name"]').focus();
    }

    [searchInput, zoneFilter, activityFilter, sortFilter, pageSize].forEach((control) => {
      control.addEventListener(control === searchInput ? 'input' : 'change', () => { currentPage = 1; render(); });
    });

    categoryChips.addEventListener('click', (event) => {
      const button = event.target.closest('[data-chip]');
      if (!button) return;
      activeChip = button.dataset.chip === 'Semua Kategori' ? '' : button.dataset.chip;
      currentPage = 1;
      render();
    });

    categoryRows.addEventListener('click', (event) => {
      const expand = event.target.closest('.expand-category');
      if (expand) {
        const row = expand.closest('tr');
        const subRow = row.nextElementSibling;
        const expanded = expand.getAttribute('aria-expanded') === 'true';
        expand.setAttribute('aria-expanded', String(!expanded));
        expand.querySelector('svg').classList.toggle('rotate-90', !expanded);
        subRow.classList.toggle('hidden', expanded);
        return;
      }
      const action = event.target.closest('button');
      if (action?.classList.contains('edit-category')) showToast('Mode edit kategori siap digunakan.');
      if (action?.classList.contains('view-category')) showToast('Detail kategori ditampilkan pada katalog.');
      if (action?.classList.contains('more-category')) showToast('Opsi kategori: edit, nonaktifkan, atau lihat riwayat.');
    });

    document.querySelectorAll('.view-button').forEach((button) => {
      button.addEventListener('click', () => {
        currentView = button.dataset.view;
        document.getElementById('table-view').classList.toggle('hidden', currentView !== 'table');
        document.getElementById('grid-view').classList.toggle('hidden', currentView !== 'grid');
        document.getElementById('grid-view').classList.toggle('grid', currentView === 'grid');
        document.querySelectorAll('.view-button').forEach((item) => {
          item.classList.toggle('bg-white', item === button);
          item.classList.toggle('font-semibold', item === button);
          item.classList.toggle('text-blue-700', item === button);
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

    document.getElementById('add-category').addEventListener('click', () => setModal(true));
    ['close-modal', 'cancel-modal'].forEach((id) => document.getElementById(id).addEventListener('click', () => setModal(false)));
    document.getElementById('category-modal').addEventListener('click', (event) => {
      if (event.target.id === 'category-modal') setModal(false);
    });
    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') setModal(false);
    });
    document.getElementById('category-form').addEventListener('submit', (event) => {
      event.preventDefault();
      const form = event.currentTarget;
      const name = new FormData(form).get('name').trim();
      const prefix = new FormData(form).get('prefix').trim().toUpperCase();
      const error = document.getElementById('modal-error');
      if (categoryData.some((category) => category.name.toLowerCase() === name.toLowerCase() || category.prefix === `${prefix}-`)) {
        error.textContent = 'Nama kategori atau prefix SKU sudah digunakan.';
        error.classList.remove('hidden');
        return;
      }
      categoryData.push({ name, detail: 'Kategori baru — lengkapi deskripsi dan alokasi zona', prefix: `${prefix}-`, zone: 'Zona D', rack: 'WH02-RB-01 (01-04)', sku: 0, units: '0 Unit', percent: 0, rotation: 'Slow Moving', icon: 'boxes', person: 'Budi Santoso', initials: 'BS', color: 'blue', subs: 0 });
      document.getElementById('total-categories').textContent = String(28 + categoryData.length - 8);
      form.reset();
      error.classList.add('hidden');
      setModal(false);
      render();
      showToast(`Kategori "${name}" berhasil ditambahkan.`);
    });

    document.getElementById('export-button').addEventListener('click', () => {
      const data = visibleCategories();
      const csv = ['Kategori,Prefix SKU,Zona,Rak,SKU,Total Unit,PIC', ...data.map((category) =>
        [category.name, category.prefix, category.zone, category.rack, category.sku, category.units, category.person].map((value) => `"${String(value).replaceAll('"', '""')}"`).join(',')
      )].join('\n');
      const link = document.createElement('a');
      link.href = URL.createObjectURL(new Blob([csv], { type: 'text/csv;charset=utf-8' }));
      link.download = 'hierarki-kategori.csv';
      link.click();
      URL.revokeObjectURL(link.href);
    });
    document.getElementById('zone-button').addEventListener('click', () => showToast('Pengaturan zona rak akan dibuka dari modul gudang.'));

    render();
</script>
</body>
</html>
