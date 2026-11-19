<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Barang &amp; Inventaris - Astro Inventory</title>

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
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ============================================================
           Astro Inventory — gaya lokal halaman Data Barang
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
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif;
        }

        /* Gaya .nav-link milik components.sidebar */
        .nav-link { transition: all 0.16s ease; }
        .nav-link:hover { background: #f1f5f9; color: #172033; transform: translateX(3px); }
        .nav-link.active { background: var(--brand); color: #fff; font-weight: 600; box-shadow: 0 6px 14px -6px rgba(37, 99, 235, 0.55); }
        .nav-link.active:hover { transform: none; background: var(--brand); }

        /* Animasi masuk konten halaman (dipakai section konten) */
        .reveal { animation: rise-in .4s cubic-bezier(.2,.8,.2,1) both; }
        .reveal-delay-1 { animation-delay: 50ms; }
        .reveal-delay-2 { animation-delay: 100ms; }
        .reveal-delay-3 { animation-delay: 150ms; }
        @keyframes rise-in { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

        /* Tinggi baris tabel inventaris (dipakai konten) */
        #inventory-rows > tr { height: 60px; }

        /* Skala konten mengikuti file sumber. Diterapkan ke <main> saja agar
           komponen navbar & sidebar tetap tampil 100% seperti halaman lain. */
        @media (min-width: 768px) {
            main { zoom: 1.15; }
        }

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

        {{-- ============ KATALOG SKU (super_admin, kepala_gudang, auditor) ============
             View ini dipakai bersama oleh route admin.data-barang, gudang.data-barang,
             dan audit.data-barang. HR dan Pegawai tidak diberi route ke halaman ini. --}}
        @php
            $user = auth()->user();
            $isSuperAdmin = $user->isSuperAdmin();
            $isKepalaGudang = $user->isKepalaGudang();
            $isAuditor = $user->isAuditor();

            // Hak lihat katalog (semua role yang punya route ke halaman ini)
            $canView = $isSuperAdmin || $isKepalaGudang || $isAuditor || $user->hasPermission('master.view');
            // Hak ubah master barang (tambah/edit) - auditor read-only
            $canManage = $isSuperAdmin || $user->hasPermission('product.manage') || $user->hasPermission('master.manage');
            // Hak import batch (master.manage saja)
            $canImport = $isSuperAdmin || $user->hasPermission('master.manage');

            $roleLabel = $user->role->name ?? ucfirst($user->role->code ?? 'Pengguna');
            $scopeLabel = $isSuperAdmin ? 'Manajemen Sistem' : ($isKepalaGudang ? 'Operasional Gudang' : 'Pengendalian Audit');
            $scopeDesc = $isSuperAdmin
                ? 'Katalog terpusat seluruh SKU produk, klasifikasi kategori, status stok multi-gudang, harga acuan, dan unit penyimpanan fisik Hub DC-01.'
                : ($isKepalaGudang
                    ? 'Katalog SKU untuk pengelolaan stok harian hub Anda: status stok, lokasi rak/bin, reorder point (ROP), dan harga acuan.'
                    : 'Katalog referensi pemeriksaan: bandingkan stok fisik, lokasi rak, dan nilai aset tanpa hak mengubah data.');
            $roleRoute = $isSuperAdmin ? 'admin.data-barang' : ($isKepalaGudang ? 'gudang.data-barang' : 'audit.data-barang');
        @endphp

        @if($canView)

        <section class="reveal mb-4 flex flex-wrap items-end justify-between gap-3">
          <div>
            <p class="mb-1 text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">{{ $scopeLabel }} <span class="text-blue-700">&gt; Katalog SKU Terpadu</span></p>
            <h1 class="flex flex-wrap items-center gap-2 text-[24px] font-bold leading-tight tracking-tight text-slate-800">
              Data Master Barang &amp; Inventaris
              <span class="rounded-full bg-blue-50 px-2.5 py-1 text-[10.5px] font-semibold uppercase tracking-wide text-blue-700">{{ $roleLabel }}</span>
            </h1>
            <p class="mt-1.5 max-w-[600px] text-[12px] leading-relaxed text-slate-500">{{ $scopeDesc }}</p>
          </div>
          <div class="flex items-center gap-2">
            <button class="flex h-10 items-center gap-2 rounded-md border border-slate-100 bg-white px-4 text-[12px] font-semibold text-slate-700 shadow-sm hover:bg-slate-50"><i data-lucide="download" class="h-4 w-4 text-blue-600"></i>Ekspor Data</button>
            @if($canImport)
            <button class="flex h-10 items-center gap-2 rounded-md border border-slate-100 bg-white px-4 text-[12px] font-semibold text-slate-700 shadow-sm hover:bg-slate-50"><i data-lucide="upload" class="h-4 w-4 text-blue-600"></i>Import Batch</button>
            @endif
            @if($canManage)
            <button class="flex h-10 items-center gap-2 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white shadow-sm hover:bg-blue-700"><i data-lucide="square-plus" class="h-4 w-4"></i>Tambah Barang Baru</button>
            @endif
          </div>
        </section>

        @unless($canManage)
        <section class="reveal reveal-delay-1 mb-4 flex items-start gap-2.5 rounded-xl border border-amber-100 bg-amber-50 px-4 py-3 text-[12px] text-amber-800">
          <i data-lucide="eye" class="mt-0.5 h-4 w-4 shrink-0"></i>
          <p><b>Mode baca ({{ $roleLabel }})</b> &mdash; Anda dapat menelusuri katalog, memakai filter, dan mengekspor data, tetapi tidak dapat menambah atau mengubah barang.</p>
        </section>
        @endunless

        <section aria-label="Ringkasan inventaris" class="reveal reveal-delay-1 mb-4 grid grid-cols-2 gap-3 md:grid-cols-4">
          <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
            <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Total SKU Terdaftar</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight">8.650</p><p class="mt-2.5 text-[10.5px] text-slate-500"><span class="font-semibold text-emerald-700">↗ +142 SKU</span> &nbsp;baru bulan ini</p></div>
            <span class="flex h-8 w-8 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="archive" class="h-4 w-4"></i></span>
          </article>
          <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
            <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Total Unit Fisik</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight">428.500</p><p class="mt-2.5 text-[10.5px] text-slate-500"><span class="font-semibold text-emerald-700">● &nbsp;98.4%</span> &nbsp;Akurasi stok audit</p></div>
            <span class="flex h-8 w-8 items-center justify-center rounded-md bg-emerald-50 text-emerald-700"><i data-lucide="settings" class="h-4 w-4"></i></span>
          </article>
          <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
            <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-red-600">Stok Kritis (ROP)</p><p class="mt-1.5 flex items-baseline gap-1.5 text-[24px] font-bold leading-tight tracking-tight text-red-600">24 <span class="text-[10.5px] font-normal text-slate-600">SKU</span></p><p class="mt-2.5 text-[10.5px] font-semibold text-red-600">! &nbsp;Perlu PO & Restock Segera</p></div>
            <span class="flex h-8 w-8 items-center justify-center rounded-md bg-red-50 text-red-600"><i data-lucide="triangle-alert" class="h-4 w-4"></i></span>
          </article>
          <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
            <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Out of Stock</p><p class="mt-1.5 flex items-baseline gap-1.5 text-[24px] font-bold leading-tight tracking-tight">3 <span class="text-[10.5px] font-normal text-slate-600">SKU</span></p><p class="mt-2.5 text-[10.5px] text-slate-600"><span class="font-semibold text-blue-600">▣</span> &nbsp;Dalam rute inbound supplier</p></div>
            <span class="flex h-8 w-8 items-center justify-center rounded-md bg-indigo-50 text-indigo-600"><i data-lucide="shopping-cart" class="h-4 w-4"></i></span>
          </article>
        </section>

        <section class="reveal reveal-delay-2 mb-4 rounded-xl border border-slate-100 bg-white p-3 shadow-sm">
          <div class="flex flex-wrap items-center gap-2">
            <label class="flex h-10 min-w-[220px] flex-1 items-center gap-2 rounded-md bg-blue-50/80 px-3 text-slate-400 md:max-w-[430px]">
              <i data-lucide="search" class="h-4 w-4"></i>
              <input id="product-search" type="search" placeholder="Cari SKU, nama produk, barcode EAN, brand..." class="w-full bg-transparent text-[12px] text-slate-700 outline-none placeholder:text-slate-400" />
              <i data-lucide="scan-line" class="h-4 w-4 text-blue-500"></i>
            </label>
            <select id="category-filter" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none"><option value="">Semua Kategori</option><option>Kamera & Optik</option><option>Wearable Gadget</option><option>Laptop & Komputer</option><option>Aksesoris Komputer</option><option>Audio & Sound</option><option>Storage Drive</option></select>
            <select id="status-filter" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none"><option value="">Semua Status Stok</option><option>Menipis</option><option>Stok Aman</option><option>Habis</option></select>
            <select class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none"><option>Semua Lokasi Gudang</option><option>WH01-RA-01</option><option>WH01-RA-02</option><option>WH01-RA-03</option></select>
            <button class="flex h-10 items-center gap-2 rounded-md bg-blue-50 px-3 text-[12px] text-slate-700"><i data-lucide="list-filter" class="h-4 w-4"></i>Filter</button>
            <button id="reset-filters" class="flex h-10 w-10 items-center justify-center rounded-md bg-blue-50 text-slate-600" aria-label="Reset filter"><i data-lucide="rotate-cw" class="h-4 w-4"></i></button>
          </div>
          <div class="mt-3 flex flex-wrap items-center gap-2 text-[10.5px]">
            <span class="mr-1 font-semibold uppercase text-slate-600">FILTER CEPAT:</span>
            <button data-quick-filter="" class="rounded-full bg-blue-600 px-3 py-1 font-semibold text-white">Semua Barang (8.650)</button>
            <button data-quick-filter="Stok Aman" class="rounded-full bg-slate-100 px-3 py-1 font-semibold text-slate-600">Stok Aman (8.412)</button>
            <button data-quick-filter="Menipis" class="rounded-full bg-red-50 px-3 py-1 font-semibold text-red-600">● Stok Menipis (24)</button>
            <button data-quick-filter="Habis" class="rounded-full bg-slate-100 px-3 py-1 font-semibold text-slate-600">Stok Habis (3)</button>
            <button data-quick-filter="Stok Aman" class="rounded-full bg-emerald-50 px-3 py-1 font-semibold text-emerald-700">Fast Moving (1.240)</button>
          </div>
        </section>

        <section class="reveal reveal-delay-3 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
          <div class="overflow-x-auto">
            <table class="w-full min-w-[1280px] table-fixed border-collapse text-left">
              <thead class="h-11 bg-[#f0f4fc] text-[9.5px] font-semibold uppercase tracking-wide text-slate-600">
                <tr>
                  <th class="w-[44px] whitespace-nowrap px-2"><input type="checkbox" aria-label="Pilih semua barang" class="h-4 w-4 accent-blue-600"></th>
                  <th class="w-[140px] whitespace-nowrap px-2">Kode SKU & EAN</th>
                  <th class="w-[250px] whitespace-nowrap px-2">Nama Barang & Brand</th>
                  <th class="w-[145px] whitespace-nowrap px-2">Kategori</th>
                  <th class="w-[145px] whitespace-nowrap px-2">Lokasi Rak / Bin</th>
                  <th class="w-[135px] whitespace-nowrap px-2">Stok Fisik (ROP)</th>
                  <th class="w-[70px] whitespace-nowrap px-2">Satuan</th>
                  <th class="w-[150px] whitespace-nowrap px-2">Nilai Aset / Unit</th>
                  <th class="w-[115px] whitespace-nowrap px-2">Status</th>
                  <th class="w-[100px] whitespace-nowrap px-2 text-center">Aksi</th>
                </tr>
              </thead>
              <tbody id="inventory-rows" class="divide-y divide-slate-100 text-[12px]">
                <tr data-category="Kamera & Optik" data-status="Menipis" class="hover:bg-slate-50/70">
                  <td class="px-2"><input type="checkbox" aria-label="Pilih Canon 60D" class="h-4 w-4 accent-blue-600"></td>
                  <td class="px-2"><a href="#" class="font-bold text-blue-700">SKU-CAM-60D</a><p class="mt-0.5 text-[10.5px] text-slate-500">899273681290</p></td>
                  <td class="px-2"><div class="flex items-center gap-1.5"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="camera" class="h-4 w-4"></i></span><span class="truncate"><b class="block truncate font-semibold text-slate-800">Canon 60D DSLR Camera Body</b><span class="text-[10.5px] text-slate-500">Brand: Canon Inc.</span></span></div></td>
                  <td class="px-2"><span class="rounded bg-blue-50 px-2.5 py-1 text-[10.5px] text-slate-600">Kamera & Optik</span></td>
                  <td class="px-2"><span class="inline-flex whitespace-nowrap items-center gap-2 rounded bg-blue-50 px-2.5 py-1 text-[10.5px] text-slate-700"><i data-lucide="map-pin" class="h-3.5 w-3.5 text-blue-600"></i>WH01-RA-02</span></td>
                  <td class="px-2"><div class="flex items-center justify-between text-[10.5px]"><b class="text-red-600">4 Unit</b><span class="text-slate-500">ROP: 25</span></div><div class="mt-0.5 h-1 rounded bg-blue-100"><div class="h-full w-[14%] rounded bg-red-600"></div></div></td>
                  <td class="px-2 text-center text-slate-600">Unit</td><td class="px-2 text-right font-semibold text-slate-800">Rp 8.500.000</td>
                  <td class="px-2"><span class="rounded-full bg-red-100 px-2.5 py-1 text-[10.5px] font-semibold text-red-700">● Menipis</span></td>
                  <td class="px-2"><div class="flex items-center gap-1 text-slate-600"><button class="rounded p-1.5 hover:bg-slate-100" aria-label="Lihat Canon 60D"><i data-lucide="eye" class="h-4 w-4"></i></button>@if($canManage)<button class="rounded p-1.5 hover:bg-slate-100" aria-label="Edit Canon 60D"><i data-lucide="pencil" class="h-4 w-4"></i></button>@endif<button class="rounded p-1.5 hover:bg-slate-100" aria-label="Detail Canon 60D"><i data-lucide="qr-code" class="h-4 w-4"></i></button></div></td>
                </tr>
                <tr data-category="Kamera & Optik" data-status="Menipis" class="hover:bg-slate-50/70">
                  <td class="px-2"><input type="checkbox" aria-label="Pilih Nikon Coolpix Pro X" class="h-4 w-4 accent-blue-600"></td>
                  <td class="px-2"><a href="#" class="font-bold text-blue-700">SKU-CAM-NIK8</a><p class="mt-0.5 text-[10.5px] text-slate-500">899273681412</p></td>
                  <td class="px-2"><div class="flex items-center gap-1.5"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="aperture" class="h-4 w-4"></i></span><span class="truncate"><b class="block truncate font-semibold text-slate-800">Nikon Coolpix Pro X</b><span class="text-[10.5px] text-slate-500">Brand: Nikon Corp</span></span></div></td>
                  <td class="px-2"><span class="rounded bg-blue-50 px-2.5 py-1 text-[10.5px] text-slate-600">Kamera & Optik</span></td>
                  <td class="px-2"><span class="inline-flex whitespace-nowrap items-center gap-2 rounded bg-blue-50 px-2.5 py-1 text-[10.5px] text-slate-700"><i data-lucide="map-pin" class="h-3.5 w-3.5 text-blue-600"></i>WH01-RA-03</span></td>
                  <td class="px-2"><div class="flex items-center justify-between text-[10.5px]"><b class="text-red-600">7 Unit</b><span class="text-slate-500">ROP: 20</span></div><div class="mt-0.5 h-1 rounded bg-blue-100"><div class="h-full w-[25%] rounded bg-red-600"></div></div></td>
                  <td class="px-2 text-center text-slate-600">Unit</td><td class="px-2 text-right font-semibold text-slate-800">Rp 12.450.000</td>
                  <td class="px-2"><span class="rounded-full bg-red-100 px-2.5 py-1 text-[10.5px] font-semibold text-red-700">● Menipis</span></td>
                  <td class="px-2"><div class="flex items-center gap-1 text-slate-600"><button class="rounded p-1.5 hover:bg-slate-100" aria-label="Lihat Nikon Coolpix"><i data-lucide="eye" class="h-4 w-4"></i></button>@if($canManage)<button class="rounded p-1.5 hover:bg-slate-100" aria-label="Edit Nikon Coolpix"><i data-lucide="pencil" class="h-4 w-4"></i></button>@endif<button class="rounded p-1.5 hover:bg-slate-100" aria-label="Detail Nikon Coolpix"><i data-lucide="qr-code" class="h-4 w-4"></i></button></div></td>
                </tr>
                <tr data-category="Wearable Gadget" data-status="Stok Aman" class="hover:bg-slate-50/70">
                  <td class="px-2"><input type="checkbox" aria-label="Pilih Titan Smart Watch" class="h-4 w-4 accent-blue-600"></td>
                  <td class="px-2"><a href="#" class="font-bold text-blue-700">SKU-WTC-AR40</a><p class="mt-0.5 text-[10.5px] text-slate-500">899120491023</p></td>
                  <td class="px-2"><div class="flex items-center gap-1.5"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="watch" class="h-4 w-4"></i></span><span class="truncate"><b class="block truncate font-semibold text-slate-800">Titan Smart Watch Classic Silver</b><span class="text-[10.5px] text-slate-500">Brand: Titan Gear</span></span></div></td>
                  <td class="px-2"><span class="rounded bg-blue-50 px-2.5 py-1 text-[10.5px] text-slate-600">Wearable Gadget</span></td>
                  <td class="px-2"><span class="inline-flex whitespace-nowrap items-center gap-2 rounded bg-blue-50 px-2.5 py-1 text-[10.5px] text-slate-700"><i data-lucide="map-pin" class="h-3.5 w-3.5 text-blue-600"></i>WH01-RA-02-T3</span></td>
                  <td class="px-2"><div class="flex items-center justify-between text-[10.5px]"><b class="text-emerald-700">180 Pcs</b><span class="text-slate-500">ROP: 40</span></div><div class="mt-0.5 h-1 rounded bg-blue-100"><div class="h-full w-[75%] rounded bg-emerald-700"></div></div></td>
                  <td class="px-2 text-center text-slate-600">Pcs</td><td class="px-2 text-right font-semibold text-slate-800">Rp 1.850.000</td>
                  <td class="px-2"><span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[10.5px] font-semibold text-emerald-800">● Stok Aman</span></td>
                  <td class="px-2"><div class="flex items-center gap-1 text-slate-600"><button class="rounded p-1.5 hover:bg-slate-100" aria-label="Lihat Titan Smart Watch"><i data-lucide="eye" class="h-4 w-4"></i></button>@if($canManage)<button class="rounded p-1.5 hover:bg-slate-100" aria-label="Edit Titan Smart Watch"><i data-lucide="pencil" class="h-4 w-4"></i></button>@endif<button class="rounded p-1.5 hover:bg-slate-100" aria-label="Detail Titan Smart Watch"><i data-lucide="qr-code" class="h-4 w-4"></i></button></div></td>
                </tr>
                <tr data-category="Laptop & Komputer" data-status="Stok Aman" class="hover:bg-slate-50/70">
                  <td class="px-2"><input type="checkbox" aria-label="Pilih Macbook Pro M1" class="h-4 w-4 accent-blue-600"></td>
                  <td class="px-2"><a href="#" class="font-bold text-blue-700">SKU-LAP-M102</a><p class="mt-0.5 text-[10.5px] text-slate-500">899535102450</p></td>
                  <td class="px-2"><div class="flex items-center gap-1.5"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="laptop" class="h-4 w-4"></i></span><span class="truncate"><b class="block truncate font-semibold text-slate-800">Macbook Pro M1 2020 Space Gray</b><span class="text-[10.5px] text-slate-500">Brand: Apple</span></span></div></td>
                  <td class="px-2"><span class="rounded bg-blue-50 px-2.5 py-1 text-[10.5px] text-slate-600">Laptop & Komputer</span></td>
                  <td class="px-2"><span class="inline-flex whitespace-nowrap items-center gap-2 rounded bg-blue-50 px-2.5 py-1 text-[10.5px] text-slate-700"><i data-lucide="map-pin" class="h-3.5 w-3.5 text-blue-600"></i>WH01-RA-01</span></td>
                  <td class="px-2"><div class="flex items-center justify-between text-[10.5px]"><b class="text-emerald-700">100 Unit</b><span class="text-slate-500">ROP: 15</span></div><div class="mt-0.5 h-1 rounded bg-blue-100"><div class="h-full w-[68%] rounded bg-emerald-700"></div></div></td>
                  <td class="px-2 text-center text-slate-600">Unit</td><td class="px-2 text-right font-semibold text-slate-800">Rp 16.200.000</td>
                  <td class="px-2"><span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[10.5px] font-semibold text-emerald-800">● Stok Aman</span></td>
                  <td class="px-2"><div class="flex items-center gap-1 text-slate-600"><button class="rounded p-1.5 hover:bg-slate-100" aria-label="Lihat Macbook Pro"><i data-lucide="eye" class="h-4 w-4"></i></button>@if($canManage)<button class="rounded p-1.5 hover:bg-slate-100" aria-label="Edit Macbook Pro"><i data-lucide="pencil" class="h-4 w-4"></i></button>@endif<button class="rounded p-1.5 hover:bg-slate-100" aria-label="Detail Macbook Pro"><i data-lucide="qr-code" class="h-4 w-4"></i></button></div></td>
                </tr>
                <tr data-category="Aksesoris Komputer" data-status="Stok Aman" class="hover:bg-slate-50/70">
                  <td class="px-2"><input type="checkbox" aria-label="Pilih Mechanical Keyboard" class="h-4 w-4 accent-blue-600"></td>
                  <td class="px-2"><a href="#" class="font-bold text-blue-700">SKU-ACC-KB05</a><p class="mt-0.5 text-[10.5px] text-slate-500">899610023441</p></td>
                  <td class="px-2"><div class="flex items-center gap-1.5"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="keyboard" class="h-4 w-4"></i></span><span class="truncate"><b class="block truncate font-semibold text-slate-800">Mechanical Keyboard RGB Wireless</b><span class="text-[10.5px] text-slate-500">Brand: Keychron</span></span></div></td>
                  <td class="px-2"><span class="rounded bg-blue-50 px-2.5 py-1 text-[10.5px] text-slate-600">Aksesoris Komputer</span></td>
                  <td class="px-2"><span class="inline-flex whitespace-nowrap items-center gap-2 rounded bg-blue-50 px-2.5 py-1 text-[10.5px] text-slate-700"><i data-lucide="map-pin" class="h-3.5 w-3.5 text-blue-600"></i>WH01-RA-02-T1</span></td>
                  <td class="px-2"><div class="flex items-center justify-between text-[10.5px]"><b class="text-emerald-700">210 Unit</b><span class="text-slate-500">ROP: 50</span></div><div class="mt-0.5 h-1 rounded bg-blue-100"><div class="h-full w-[80%] rounded bg-emerald-700"></div></div></td>
                  <td class="px-2 text-center text-slate-600">Unit</td><td class="px-2 text-right font-semibold text-slate-800">Rp 1.450.000</td>
                  <td class="px-2"><span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[10.5px] font-semibold text-emerald-800">● Stok Aman</span></td>
                  <td class="px-2"><div class="flex items-center gap-1 text-slate-600"><button class="rounded p-1.5 hover:bg-slate-100" aria-label="Lihat Keyboard"><i data-lucide="eye" class="h-4 w-4"></i></button>@if($canManage)<button class="rounded p-1.5 hover:bg-slate-100" aria-label="Edit Keyboard"><i data-lucide="pencil" class="h-4 w-4"></i></button>@endif<button class="rounded p-1.5 hover:bg-slate-100" aria-label="Detail Keyboard"><i data-lucide="qr-code" class="h-4 w-4"></i></button></div></td>
                </tr>
                <tr data-category="Audio & Sound" data-status="Stok Aman" class="hover:bg-slate-50/70">
                  <td class="px-2"><input type="checkbox" aria-label="Pilih Sony Headphone" class="h-4 w-4 accent-blue-600"></td>
                  <td class="px-2"><a href="#" class="font-bold text-blue-700">SKU-AUD-SN09</a><p class="mt-0.5 text-[10.5px] text-slate-500">899778219011</p></td>
                  <td class="px-2"><div class="flex items-center gap-1.5"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="headphones" class="h-4 w-4"></i></span><span class="truncate"><b class="block truncate font-semibold text-slate-800">Sony Wireless Headphone WH-1000XM4</b><span class="text-[10.5px] text-slate-500">Brand: Sony</span></span></div></td>
                  <td class="px-2"><span class="rounded bg-blue-50 px-2.5 py-1 text-[10.5px] text-slate-600">Audio & Sound</span></td>
                  <td class="px-2"><span class="inline-flex whitespace-nowrap items-center gap-2 rounded bg-blue-50 px-2.5 py-1 text-[10.5px] text-slate-700"><i data-lucide="map-pin" class="h-3.5 w-3.5 text-blue-600"></i>WH01-RA-04</span></td>
                  <td class="px-2"><div class="flex items-center justify-between text-[10.5px]"><b class="text-emerald-700">120 Unit</b><span class="text-slate-500">ROP: 25</span></div><div class="mt-0.5 h-1 rounded bg-blue-100"><div class="h-full w-[70%] rounded bg-emerald-700"></div></div></td>
                  <td class="px-2 text-center text-slate-600">Unit</td><td class="px-2 text-right font-semibold text-slate-800">Rp 3.899.000</td>
                  <td class="px-2"><span class="rounded-full bg-emerald-100 px-2.5 py-1 text-[10.5px] font-semibold text-emerald-800">● Stok Aman</span></td>
                  <td class="px-2"><div class="flex items-center gap-1 text-slate-600"><button class="rounded p-1.5 hover:bg-slate-100" aria-label="Lihat Headphone"><i data-lucide="eye" class="h-4 w-4"></i></button>@if($canManage)<button class="rounded p-1.5 hover:bg-slate-100" aria-label="Edit Headphone"><i data-lucide="pencil" class="h-4 w-4"></i></button>@endif<button class="rounded p-1.5 hover:bg-slate-100" aria-label="Detail Headphone"><i data-lucide="qr-code" class="h-4 w-4"></i></button></div></td>
                </tr>
                <tr data-category="Storage Drive" data-status="Habis" class="hover:bg-slate-50/70">
                  <td class="px-2"><input type="checkbox" aria-label="Pilih Sandisk SSD" class="h-4 w-4 accent-blue-600"></td>
                  <td class="px-2"><a href="#" class="font-bold text-blue-700">SKU-STR-SD01</a><p class="mt-0.5 text-[10.5px] text-slate-500">899881920387</p></td>
                  <td class="px-2"><div class="flex items-center gap-1.5"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="hard-drive" class="h-4 w-4"></i></span><span class="truncate"><b class="block truncate font-semibold text-slate-800">Sandisk Extreme Portable SSD 1TB</b><span class="text-[10.5px] text-slate-500">Brand: SanDisk</span></span></div></td>
                  <td class="px-2"><span class="rounded bg-blue-50 px-2.5 py-1 text-[10.5px] text-slate-600">Storage Drive</span></td>
                  <td class="px-2"><span class="inline-flex whitespace-nowrap items-center gap-2 rounded bg-blue-50 px-2.5 py-1 text-[10.5px] text-slate-700"><i data-lucide="map-pin" class="h-3.5 w-3.5 text-blue-600"></i>WH01-RA-01-T2</span></td>
                  <td class="px-2"><div class="flex items-center justify-between text-[10.5px]"><b class="text-slate-600">0 Unit</b><span class="text-slate-500">ROP: 30</span></div><div class="mt-0.5 h-1 rounded bg-blue-100"></div></td>
                  <td class="px-2 text-center text-slate-600">Box</td><td class="px-2 text-right font-semibold text-slate-800">Rp 2.100.000</td>
                  <td class="px-2"><span class="rounded-full bg-indigo-100 px-2.5 py-1 text-[10.5px] font-semibold text-indigo-800">● Habis</span></td>
                  <td class="px-2"><div class="flex items-center gap-1 text-slate-600"><button class="rounded p-1.5 hover:bg-slate-100" aria-label="Lihat Sandisk SSD"><i data-lucide="eye" class="h-4 w-4"></i></button>@if($canManage)<button class="rounded p-1.5 hover:bg-slate-100" aria-label="Edit Sandisk SSD"><i data-lucide="pencil" class="h-4 w-4"></i></button>@endif<button class="rounded p-1.5 hover:bg-slate-100" aria-label="Detail Sandisk SSD"><i data-lucide="qr-code" class="h-4 w-4"></i></button></div></td>
                </tr>
              </tbody>
            </table>
          </div>
          <footer class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 px-4 py-3 text-[12px] text-slate-600">
            <div class="flex items-center gap-2"><span id="row-count">Menampilkan 1 - 7 dari 8.650 total barang</span><span>Baris:</span><select class="h-8 rounded bg-blue-50 px-2 text-[12px]"><option>10</option><option>25</option><option>50</option></select></div>
            <div class="flex items-center gap-1">
              <button class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">‹ Sebelumnya</button>
              <button class="h-8 min-w-8 rounded bg-blue-600 px-2 text-[12px] font-semibold text-white">1</button><button class="h-8 min-w-8 rounded px-2 text-[12px]">2</button><button class="h-8 min-w-8 rounded px-2 text-[12px]">3</button><span class="px-1">…</span><button class="h-8 min-w-8 rounded px-2 text-[12px]">865</button>
              <button class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">Selanjutnya ›</button>
            </div>
          </footer>
        </section>

        @else
        <section class="reveal rounded-xl border border-red-100 bg-white p-6 shadow-sm">
          <h1 class="text-[18px] font-bold text-slate-800">Akses ditolak</h1>
          <p class="mt-1 text-[12.5px] text-slate-500">Modul Data Barang hanya tersedia untuk Super Admin, Kepala Gudang, dan Auditor.</p>
        </section>
        @endif

    </main>
</div>

<script>
/* ============================================================
   Astro Inventory — logika halaman Data Barang: loader ikon Lucide,
   pencarian produk, filter kategori/status, quick filter, reset.
   Shell sidebar/topbar file sumber dibuang (digantikan komponen Blade
   components.navbar & components.sidebar); handler toggleSidebar() ikut
   dibuang karena sidebar komponen mengurus dirinya sendiri.
   ============================================================ */
    lucide.createIcons();

    const rows = [...document.querySelectorAll('#inventory-rows tr')];
    const productSearch = document.getElementById('product-search');
    /* Kotak pencarian global pada file sumber ada di topbar; layout komponen
       tidak punya input itu, jadi referensinya dibuat null-safe. Beri
       id="global-search" pada input mana pun untuk mengaktifkannya. */
    const globalSearch = document.getElementById('global-search');
    const categoryFilter = document.getElementById('category-filter');
    const statusFilter = document.getElementById('status-filter');

    function applyFilters() {
      const query = `${productSearch.value} ${globalSearch ? globalSearch.value : ''}`.trim().toLowerCase();
      const visibleRows = rows.filter((row) => {
        const matchesSearch = !query || row.textContent.toLowerCase().includes(query);
        const matchesCategory = !categoryFilter.value || row.dataset.category === categoryFilter.value;
        const matchesStatus = !statusFilter.value || row.dataset.status === statusFilter.value;
        row.hidden = !(matchesSearch && matchesCategory && matchesStatus);
        return !row.hidden;
      });
      const hasFilters = query || categoryFilter.value || statusFilter.value;
      document.getElementById('row-count').textContent = hasFilters
        ? `${visibleRows.length} barang sesuai filter`
        : 'Menampilkan 1 - 7 dari 8.650 total barang';
    }

    [productSearch, globalSearch].filter(Boolean).forEach((input) => input.addEventListener('input', applyFilters));
    [categoryFilter, statusFilter].forEach((select) => select.addEventListener('change', applyFilters));

    /* Pill filter cepat: pada file sumber klik pill hanya mengubah select status
       tanpa menandai pill mana yang aktif — penanda aktif ditambahkan di sini
       agar status filter terlihat. */
    const quickFilters = [...document.querySelectorAll('[data-quick-filter]')];
    const pillActiveClass = 'rounded-full bg-blue-600 px-3 py-1 font-semibold text-white';
    const pillIdleClasses = quickFilters.map((button) => button.className.includes('bg-blue-600')
      ? 'rounded-full bg-slate-100 px-3 py-1 font-semibold text-slate-600'
      : button.className);

    function setActiveQuickFilter(activeIndex) {
      quickFilters.forEach((button, index) => {
        button.className = index === activeIndex ? pillActiveClass : pillIdleClasses[index];
      });
    }

    quickFilters.forEach((button, index) => {
      button.addEventListener('click', () => {
        statusFilter.value = button.dataset.quickFilter;
        applyFilters();
        setActiveQuickFilter(index);
      });
    });

    document.getElementById('reset-filters').addEventListener('click', () => {
      productSearch.value = '';
      if (globalSearch) globalSearch.value = '';
      categoryFilter.value = '';
      statusFilter.value = '';
      applyFilters();
      setActiveQuickFilter(0);
    });
</script>
</body>
</html>
