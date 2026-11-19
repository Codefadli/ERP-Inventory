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
            $isPegawai = $user->isPegawai();
            $isAuditor = $user->isAuditor();

            // Hak lihat katalog (semua role yang punya route ke halaman ini)
            $canView = $isSuperAdmin || $isKepalaGudang || $isPegawai || $isAuditor || $user->hasPermission('master.view');
            // Hak ubah master barang (tambah/edit) - auditor & pegawai read-only
            $canManage = $isSuperAdmin || $user->hasPermission('product.manage') || $user->hasPermission('master.manage');
            // Hak import batch (master.manage saja)
            $canImport = $isSuperAdmin || $user->hasPermission('master.manage');

            $roleLabel = $user->role->name ?? ucfirst($user->role->code ?? 'Pengguna');
            $scopeLabel = $isSuperAdmin ? 'Manajemen Sistem' : ($isKepalaGudang ? 'Operasional Gudang' : ($isPegawai ? 'Portal Operasional' : 'Pengendalian Audit'));
            $scopeDesc = $isSuperAdmin
                ? 'Katalog terpusat seluruh SKU produk, klasifikasi kategori, status stok multi-gudang, harga acuan, dan unit penyimpanan fisik hub.'
                : ($isKepalaGudang
                    ? 'Katalog SKU untuk pengelolaan stok harian hub Anda: status stok, lokasi rak/bin, reorder point (ROP), dan harga acuan.'
                    : ($isPegawai
                        ? 'Informasi ketersediaan stok fisik, lokasi bin rak, nomor serial SKU, dan status pergerakan barang untuk staf operasional.'
                        : 'Katalog referensi pemeriksaan: bandingkan stok fisik, lokasi rak, dan nilai aset tanpa hak mengubah data.'));
            $roleRoute = $isSuperAdmin ? 'admin.data-barang' : ($isKepalaGudang ? 'kepalagudang.data-barang' : ($isPegawai ? 'pegawai.data-barang' : 'audit.data-barang'));
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
            <button class="flex h-10 items-center gap-2 rounded-md border border-slate-100 bg-white px-4 text-[12px] font-semibold text-slate-700 shadow-sm opacity-60 cursor-not-allowed" disabled title="Ekspor data belum tersedia"><i data-lucide="download" class="h-4 w-4 text-blue-600"></i>Ekspor Data</button>
            @if($canImport)
            <button class="flex h-10 items-center gap-2 rounded-md border border-slate-100 bg-white px-4 text-[12px] font-semibold text-slate-700 shadow-sm opacity-60 cursor-not-allowed" disabled title="Import batch belum tersedia"><i data-lucide="upload" class="h-4 w-4 text-blue-600"></i>Import Batch</button>
            @endif
            @if($canManage)
            <button type="button" onclick="document.getElementById('modalTambahBarang').classList.remove('hidden')" class="flex h-10 items-center gap-2 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white shadow-sm hover:bg-blue-700"><i data-lucide="square-plus" class="h-4 w-4"></i>Tambah Barang Baru</button>
            @endif
          </div>
        </section>

        {{-- @unless($canManage)
        <section class="reveal reveal-delay-1 mb-4 flex items-start gap-2.5 rounded-xl border border-amber-100 bg-amber-50 px-4 py-3 text-[12px] text-amber-800">
          <i data-lucide="eye" class="mt-0.5 h-4 w-4 shrink-0"></i>
          <p><b>Mode baca ({{ $roleLabel }})</b> &mdash; Anda dapat menelusuri katalog, memakai filter, tetapi tidak dapat menambah atau mengubah barang.</p>
        </section>
        @endunless --}}

        <section aria-label="Ringkasan inventaris" class="reveal reveal-delay-1 mb-4 grid grid-cols-2 gap-3 md:grid-cols-4">
          <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
            <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Total SKU Terdaftar</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight">{{ number_format($stats['total']) }}</p><p class="mt-2.5 text-[10.5px] text-slate-500"><span class="font-semibold text-emerald-700">Hub:</span> &nbsp;{{ $hubScopeLabel }}{{ $hubScopeCode ? ' (' . $hubScopeCode . ')' : '' }}</p></div>
            <span class="flex h-8 w-8 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="archive" class="h-4 w-4"></i></span>
          </article>
          <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
            <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Barang Aktif</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight">{{ number_format($stats['aktif']) }}</p><p class="mt-2.5 text-[10.5px] text-slate-500"><span class="font-semibold text-emerald-700">●</span> &nbsp;Status Aktif</p></div>
            <span class="flex h-8 w-8 items-center justify-center rounded-md bg-emerald-50 text-emerald-700"><i data-lucide="settings" class="h-4 w-4"></i></span>
          </article>
          <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
            <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-red-600">Stok Kritis (ROP)</p><p class="mt-1.5 flex items-baseline gap-1.5 text-[24px] font-bold leading-tight tracking-tight text-red-600">{{ number_format($stats['kritis']) }} <span class="text-[10.5px] font-normal text-slate-600">SKU</span></p><p class="mt-2.5 text-[10.5px] font-semibold text-red-600">! &nbsp;Perlu PO &amp; Restock Segera</p></div>
            <span class="flex h-8 w-8 items-center justify-center rounded-md bg-red-50 text-red-600"><i data-lucide="triangle-alert" class="h-4 w-4"></i></span>
          </article>
          <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
            <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Total Kategori</p><p class="mt-1.5 flex items-baseline gap-1.5 text-[24px] font-bold leading-tight tracking-tight">{{ number_format($stats['kategori']) }}</p><p class="mt-2.5 text-[10.5px] text-slate-600"><span class="font-semibold text-blue-600">▣</span> &nbsp;Klasifikasi produk</p></div>
            <span class="flex h-8 w-8 items-center justify-center rounded-md bg-indigo-50 text-indigo-600"><i data-lucide="shopping-cart" class="h-4 w-4"></i></span>
          </article>
        </section>

        <section class="reveal reveal-delay-2 mb-4 rounded-xl border border-slate-100 bg-white p-3 shadow-sm">
          <form method="GET" action="{{ route($roleRoute) }}" class="flex flex-wrap items-center gap-2">
            <label class="flex h-10 min-w-[220px] flex-1 items-center gap-2 rounded-md bg-blue-50/80 px-3 text-slate-400 md:max-w-[430px]">
              <i data-lucide="search" class="h-4 w-4"></i>
              <input id="product-search" name="q" value="{{ $q }}" type="search" placeholder="Cari SKU, nama produk, barcode, lokasi rak..." class="w-full bg-transparent text-[12px] text-slate-700 outline-none placeholder:text-slate-400" />
              <i data-lucide="scan-line" class="h-4 w-4 text-blue-500"></i>
            </label>
            <select name="hub" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none">
              <option value="all" {{ $selectedHubId === 'all' ? 'selected' : '' }}>Semua Hub</option>
              @foreach($hubs as $hubOpt)
                <option value="{{ $hubOpt->id }}" {{ (string) $hubOpt->id === (string) $selectedHubId ? 'selected' : '' }}>
                    {{ $hubOpt->name }} ({{ $hubOpt->code }})
                </option>
              @endforeach
            </select>
            <select id="category-filter" name="category" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none">
              <option value="">Semua Kategori</option>
              @foreach($categories as $catOpt)
                <option value="{{ $catOpt->id }}" {{ (string) $catOpt->id === (string) $category ? 'selected' : '' }}>{{ $catOpt->nama }}</option>
              @endforeach
            </select>
            <select id="status-filter" name="status" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none">
              <option value="">Semua Status</option>
              <option value="Aktif" {{ $status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
              <option value="Stok Kritis" {{ $status === 'Stok Kritis' ? 'selected' : '' }}>Stok Kritis</option>
            </select>
            <button type="submit" class="flex h-10 items-center gap-2 rounded-md bg-blue-50 px-3 text-[12px] text-slate-700"><i data-lucide="list-filter" class="h-4 w-4"></i>Filter</button>
            <a href="{{ route($roleRoute) }}" class="flex h-10 w-10 items-center justify-center rounded-md bg-blue-50 text-slate-600" aria-label="Reset filter" title="Reset filter"><i data-lucide="rotate-cw" class="h-4 w-4"></i></a>
          </form>
          <div class="mt-3 flex flex-wrap items-center gap-2 text-[10.5px]">
            <span class="mr-1 font-semibold uppercase text-slate-600">FILTER CEPAT:</span>
            <a href="{{ route($roleRoute, ['hub' => $selectedHubId === 'all' ? null : $selectedHubId]) }}" class="rounded-full bg-blue-600 px-3 py-1 font-semibold text-white">Semua Barang ({{ number_format($stats['total']) }})</a>
            <a href="{{ route($roleRoute, ['status' => 'Stok Kritis', 'hub' => $selectedHubId === 'all' ? null : $selectedHubId]) }}" class="rounded-full bg-red-50 px-3 py-1 font-semibold text-red-600">● Stok Kritis ({{ number_format($stats['kritis']) }})</a>
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
                @forelse($items as $item)
                <tr class="hover:bg-slate-50/70">
                  <td class="px-2"><input type="checkbox" aria-label="Pilih {{ $item->nama }}" class="h-4 w-4 accent-blue-600"></td>
                  <td class="px-2"><span class="font-bold text-blue-700">{{ $item->sku }}</span><p class="mt-0.5 text-[10.5px] text-slate-500">{{ $item->barcode }}</p></td>
                  <td class="px-2"><div class="flex items-center gap-1.5"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="box" class="h-4 w-4"></i></span><span class="truncate"><b class="block truncate font-semibold text-slate-800">{{ $item->nama }}</b><span class="text-[10.5px] text-slate-500">{{ optional($item->supplier)->nama }}</span></span></div></td>
                  <td class="px-2"><span class="rounded bg-blue-50 px-2.5 py-1 text-[10.5px] text-slate-600">{{ optional($item->category)->nama }}</span></td>
                  <td class="px-2"><span class="inline-flex whitespace-nowrap items-center gap-2 rounded bg-blue-50 px-2.5 py-1 text-[10.5px] text-slate-700"><i data-lucide="map-pin" class="h-3.5 w-3.5 text-blue-600"></i>{{ optional($item->location)->kode }}<span class="text-slate-400">{{ optional($item->location)->nama_rak }}</span></span></td>
                  <td class="px-2"><div class="flex items-center justify-between text-[10.5px]"><b class="text-slate-600">Stok: -</b><span class="text-slate-500">ROP: {{ $item->stok_minimum ?? '-' }}</span></div></td>
                  <td class="px-2 text-center text-slate-600">{{ optional($item->unit)->nama }}</td>
                  <td class="px-2 text-right font-semibold text-slate-800">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                  <td class="px-2"><span class="rounded-full px-2.5 py-1 text-[10.5px] font-semibold {{ $item->status === 'Stok Kritis' ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-800' }}">● {{ $item->status }}</span></td>
                  <td class="px-2"><div class="flex items-center gap-1 text-slate-600"><button class="rounded p-1.5 opacity-50 cursor-not-allowed" disabled title="Lihat detail belum tersedia" aria-label="Lihat {{ $item->nama }}"><i data-lucide="eye" class="h-4 w-4"></i></button>@if($canManage)<button class="rounded p-1.5 opacity-50 cursor-not-allowed" disabled title="Edit belum tersedia" aria-label="Edit {{ $item->nama }}"><i data-lucide="pencil" class="h-4 w-4"></i></button>@endif<button class="rounded p-1.5 opacity-50 cursor-not-allowed" disabled title="QR belum tersedia" aria-label="Detail {{ $item->nama }}"><i data-lucide="qr-code" class="h-4 w-4"></i></button></div></td>
                </tr>
                @empty
                <tr>
                  <td colspan="10" class="px-4 py-10 text-center">
                    <i data-lucide="search-x" class="h-8 w-8 text-slate-300 mx-auto"></i>
                    <p class="mt-2 text-[12.5px] font-semibold text-slate-500">Belum ada barang yang cocok dengan filter pada hub ini.</p>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <footer class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 px-4 py-3 text-[12px] text-slate-600">
            <div class="flex items-center gap-2"><span>Menampilkan {{ $items->firstItem() ?? 0 }} - {{ $items->lastItem() ?? 0 }} dari {{ number_format($items->total()) }} total barang &bull; Hub: {{ $hubScopeLabel }}</span></div>
            <div class="flex items-center gap-1">
              @if($items->onFirstPage())
                <span class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-400">‹ Sebelumnya</span>
              @else
                <a href="{{ $items->previousPageUrl() }}" class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">‹ Sebelumnya</a>
              @endif
              @foreach($items->getUrlRange(max(1, $items->currentPage() - 2), min($items->lastPage(), $items->currentPage() + 2)) as $page => $url)
                <a href="{{ $url }}" class="h-8 min-w-8 rounded px-2 text-[12px] {{ $page === $items->currentPage() ? 'bg-blue-600 px-2 font-semibold text-white' : 'text-slate-600' }}">{{ $page }}</a>
              @endforeach
              @if($items->hasMorePages())
                <a href="{{ $items->nextPageUrl() }}" class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">Selanjutnya ›</a>
              @else
                <span class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-400">Selanjutnya ›</span>
              @endif
            </div>
          </footer>
        </section>

        @else
        <section class="reveal rounded-xl border border-red-100 bg-white p-6 shadow-sm">
          <h1 class="text-[18px] font-bold text-slate-800">Akses ditolak</h1>
          <p class="mt-1 text-[12.5px] text-slate-500">Modul Data Barang hanya tersedia untuk Super Admin, Kepala Gudang, Pegawai, dan Auditor.</p>
        </section>
        @endif

        @if(session('success'))
        <div class="reveal mb-4 flex items-start gap-2.5 rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-[12px] text-emerald-800">
          <i data-lucide="check-circle-2" class="mt-0.5 h-4 w-4 shrink-0"></i>
          <p>{{ session('success') }}</p>
        </div>
        @endif

        @if($errors->any())
        <div class="reveal mb-4 flex items-start gap-2.5 rounded-xl border border-red-100 bg-red-50 px-4 py-3 text-[12px] text-red-800">
          <i data-lucide="alert-triangle" class="mt-0.5 h-4 w-4 shrink-0"></i>
          <ul class="list-disc pl-4 space-y-0.5">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

    </main>
</div>

{{-- ===== Modal Tambah Barang ===== --}}
@if($canManage)
<div id="modalTambahBarang" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
  <div class="absolute inset-0 bg-slate-900/45" onclick="document.getElementById('modalTambahBarang').classList.add('hidden')"></div>
  <div class="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl bg-white shadow-xl">
    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
      <div>
        <h2 class="text-[16px] font-bold text-slate-800">Tambah Barang Baru</h2>
        <p class="text-[11.5px] text-slate-500 mt-0.5">Lengkapi data SKU barang di bawah ini.</p>
      </div>
      <button type="button" class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-500 hover:bg-slate-100" onclick="document.getElementById('modalTambahBarang').classList.add('hidden')" aria-label="Tutup"><i data-lucide="x" class="h-4 w-4"></i></button>
    </div>
    <form method="POST" action="{{ route($user->isSuperAdmin() ? 'admin.data-barang.store' : 'kepalagudang.data-barang.store') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-5">
      @csrf

      <div class="sm:col-span-2">
        <label class="text-[11.5px] font-semibold text-slate-600">Nama Barang <span class="text-red-500">*</span></label>
        <input type="text" name="nama" value="{{ old('nama') }}" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-[12.5px] outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10" placeholder="Contoh: Barcode Scanner Wireless 2D" required>
        @error('nama')<p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="text-[11.5px] font-semibold text-slate-600">Kode SKU <span class="text-red-500">*</span></label>
        <input type="text" name="sku" value="{{ old('sku') }}" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-[12.5px] outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10" placeholder="ELK-0010" required>
        @error('sku')<p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="text-[11.5px] font-semibold text-slate-600">Barcode <span class="text-red-500">*</span></label>
        <input type="text" name="barcode" value="{{ old('barcode') }}" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-[12.5px] outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10" placeholder="899275300101" required>
        @error('barcode')<p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="text-[11.5px] font-semibold text-slate-600">Kategori <span class="text-red-500">*</span></label>
        <select name="category_id" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-[12.5px] outline-none focus:border-blue-500" required>
          <option value="">-- Pilih Kategori --</option>
          @foreach($categories as $catOpt)
            <option value="{{ $catOpt->id }}" {{ old('category_id') == $catOpt->id ? 'selected' : '' }}>{{ $catOpt->nama }}</option>
          @endforeach
        </select>
        @error('category_id')<p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="text-[11.5px] font-semibold text-slate-600">Satuan <span class="text-red-500">*</span></label>
        <select name="unit_id" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-[12.5px] outline-none focus:border-blue-500" required>
          <option value="">-- Pilih Satuan --</option>
          @foreach($units as $unitOpt)
            <option value="{{ $unitOpt->id }}" {{ old('unit_id') == $unitOpt->id ? 'selected' : '' }}>{{ $unitOpt->nama }}</option>
          @endforeach
        </select>
        @error('unit_id')<p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="text-[11.5px] font-semibold text-slate-600">Lokasi Rak <span class="text-red-500">*</span></label>
        <select name="location_id" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-[12.5px] outline-none focus:border-blue-500" required>
          <option value="">-- Pilih Lokasi --</option>
          @foreach($locations as $locOpt)
            <option value="{{ $locOpt->id }}" {{ old('location_id') == $locOpt->id ? 'selected' : '' }}>{{ $locOpt->kode }} - {{ $locOpt->nama }}</option>
          @endforeach
        </select>
        @error('location_id')<p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="text-[11.5px] font-semibold text-slate-600">Supplier</label>
        <select name="supplier_id" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-[12.5px] outline-none focus:border-blue-500">
          <option value="">-- Pilih Supplier --</option>
          @foreach($suppliers as $supOpt)
            <option value="{{ $supOpt->id }}" {{ old('supplier_id') == $supOpt->id ? 'selected' : '' }}>{{ $supOpt->nama }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="text-[11.5px] font-semibold text-slate-600">Divisi</label>
        <select name="division_id" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-[12.5px] outline-none focus:border-blue-500">
          <option value="">-- Pilih Divisi --</option>
          @foreach($divisions as $divOpt)
            <option value="{{ $divOpt->id }}" {{ old('division_id') == $divOpt->id ? 'selected' : '' }}>{{ $divOpt->nama }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="text-[11.5px] font-semibold text-slate-600">Hub</label>
        <select name="hub_id" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-[12.5px] outline-none focus:border-blue-500">
          <option value="">-- Default: hub terpilih Anda --</option>
          @foreach($hubs as $hubOpt)
            <option value="{{ $hubOpt->id }}" {{ old('hub_id') == $hubOpt->id ? 'selected' : '' }}>{{ $hubOpt->name }} ({{ $hubOpt->code }})</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="text-[11.5px] font-semibold text-slate-600">Stok Minimum (ROP)</label>
        <input type="number" name="stok_minimum" value="{{ old('stok_minimum') }}" min="0" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-[12.5px] outline-none focus:border-blue-500" placeholder="5">
      </div>

      <div>
        <label class="text-[11.5px] font-semibold text-slate-600">Harga Beli</label>
        <input type="number" name="harga_beli" value="{{ old('harga_beli') }}" min="0" step="0.01" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-[12.5px] outline-none focus:border-blue-500" placeholder="750000">
      </div>

      <div>
        <label class="text-[11.5px] font-semibold text-slate-600">Harga Jual</label>
        <input type="number" name="harga_jual" value="{{ old('harga_jual') }}" min="0" step="0.01" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-[12.5px] outline-none focus:border-blue-500" placeholder="920000">
      </div>

      <div>
        <label class="text-[11.5px] font-semibold text-slate-600">Status <span class="text-red-500">*</span></label>
        <select name="status" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-[12.5px] outline-none focus:border-blue-500" required>
          <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
          <option value="Stok Kritis" {{ old('status') == 'Stok Kritis' ? 'selected' : '' }}>Stok Kritis</option>
        </select>
      </div>

      <div class="sm:col-span-2">
        <label class="text-[11.5px] font-semibold text-slate-600">URL Foto</label>
        <input type="url" name="foto" value="{{ old('foto') }}" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-[12.5px] outline-none focus:border-blue-500" placeholder="https://...">
      </div>

      <div class="sm:col-span-2">
        <label class="text-[11.5px] font-semibold text-slate-600">Deskripsi</label>
        <textarea name="deskripsi" rows="2" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-[12.5px] outline-none focus:border-blue-500" placeholder="Keterangan singkat barang">{{ old('deskripsi') }}</textarea>
      </div>

      <div class="sm:col-span-2 mt-2 flex items-center justify-end gap-2 border-t border-slate-100 pt-4">
        <button type="button" onclick="document.getElementById('modalTambahBarang').classList.add('hidden')" class="rounded-lg border border-slate-200 px-4 py-2 text-[12.5px] font-semibold text-slate-600 hover:bg-slate-50">Batal</button>
        <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-[12.5px] font-semibold text-white hover:bg-blue-700"><i data-lucide="check" class="h-4 w-4 inline-block mr-1"></i>Simpan Barang</button>
      </div>
    </form>
  </div>
</div>
@endif

<script>
/* ============================================================
   Astro Inventory — logika halaman Data Barang: loader ikon Lucide.
   Filter (pencarian, hub, kategori, status) berjalan server-side;
   select langsung submit form GET.
   ============================================================ */
    lucide.createIcons();

    const filterForm = document.querySelector('form[method="GET"]');
    const productSearch = document.getElementById('product-search');
    const categoryFilter = document.getElementById('category-filter');
    const statusFilter = document.getElementById('status-filter');

    // Submit otomatis saat filter diubah (kecuali input pencarian)
    [categoryFilter, statusFilter].filter(Boolean).forEach((select) => {
        select.addEventListener('change', () => filterForm && filterForm.submit());
    });

    // Enter pada kolom pencarian langsung submit
    productSearch && productSearch.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') { e.preventDefault(); filterForm && filterForm.submit(); }
    });
</script>
</body>
</html>
