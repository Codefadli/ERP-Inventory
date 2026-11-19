<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transaksi Barang Keluar — Astro Inventory</title>

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
        :root { --brand: #2563eb; --brand-dark: #1d4ed8; }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif; }

        .nav-link { transition: all 0.16s ease; }
        .nav-link:hover { background: #f1f5f9; color: #172033; transform: translateX(3px); }
        .nav-link.active { background: var(--brand); color: #fff; font-weight: 600; box-shadow: 0 6px 14px -6px rgba(37, 99, 235, 0.55); }
        .nav-link.active:hover { transform: none; background: var(--brand); }

        .reveal { animation: rise-in .4s cubic-bezier(.2,.8,.2,1) both; }
        .reveal-delay-1 { animation-delay: 50ms; }
        .reveal-delay-2 { animation-delay: 100ms; }
        .reveal-delay-3 { animation-delay: 150ms; }
        @keyframes rise-in { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

        .trx-card { transition: transform .16s ease, box-shadow .16s ease, border-color .16s ease; }
        .trx-card:hover { transform: translateY(-1px); box-shadow: 0 6px 16px -8px rgba(15, 23, 42, .14); border-color: #dbeafe; }

        @media (min-width: 768px) { main { zoom: 1.1; } }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; }
        }
    </style>
</head>

<body class="bg-gray-50">

@include('components.navbar')

<div class="flex min-h-screen">
    @include('components.sidebar')

    <main class="flex-1 p-4 lg:p-6 overflow-x-hidden">

        @php
            $canManage = $user->isSuperAdmin() || $user->hasPermission('master.manage');
            $statusBadge = [
                'Selesai'  => 'bg-emerald-100 text-emerald-800',
                'Picking'  => 'bg-blue-100 text-blue-700',
                'Menunggu' => 'bg-amber-100 text-amber-700',
            ];
        @endphp

        <section class="reveal mb-4 flex flex-wrap items-end justify-between gap-3">
            <div>
                <p class="mb-1 text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Inventaris <span class="text-blue-700">&gt; Transaksi Barang Keluar (Outbound)</span></p>
                <h1 class="text-[24px] font-bold leading-tight tracking-tight text-slate-800">Transaksi Barang Keluar</h1>
                <p class="mt-1.5 max-w-[620px] text-[12px] leading-relaxed text-slate-500">Pengeluaran barang ke unit / cabang: nomor DO, tiket permintaan, departemen pemohon, dan status pengiriman —</p>
            </div>
            <div class="flex items-center gap-2">
                @if($canManage)
                <button id="btn-catat-keluar" type="button" class="flex h-10 items-center gap-2 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white shadow-sm hover:bg-blue-700">
                    <i data-lucide="plus" class="h-4 w-4"></i>Catat Barang Keluar
                </button>
                @endif
                <span class="rounded-full bg-blue-50 px-3 py-1.5 text-[11px] font-semibold text-blue-700">Hub: {{ $hubScopeLabel }}{{ $hubScopeCode ? ' (' . $hubScopeCode . ')' : '' }}</span>
            </div>
        </section>

        @if(session('success'))
        <div class="reveal mb-4 flex items-center gap-2 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-[12px] text-emerald-800">
            <i data-lucide="check-circle-2" class="h-4 w-4"></i>{{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="reveal mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-[12px] text-red-700">
            <p class="mb-1 font-semibold"><i data-lucide="triangle-alert" class="inline h-4 w-4"></i> Periksa kembali isian form:</p>
            <ul class="ml-4 list-disc space-y-0.5">
                @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
            </ul>
        </div>
        @endif

                <section aria-label="Ringkasan barang keluar" class="reveal reveal-delay-1 mb-4 grid grid-cols-2 gap-2.5 md:grid-cols-4">
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-slate-100 bg-white px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-slate-500">Total DO</p><p class="mt-0.5 text-[20px] font-bold leading-tight">{{ number_format($stats['total']) }}</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="file-up" class="h-3.5 w-3.5"></i></span>
            </article>
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-slate-100 bg-white px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-slate-500">Total Unit</p><p class="mt-0.5 text-[20px] font-bold leading-tight">{{ number_format($stats['qty']) }}</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-indigo-50 text-indigo-600"><i data-lucide="package-open" class="h-3.5 w-3.5"></i></span>
            </article>
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-slate-100 bg-white px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-slate-500">Selesai</p><p class="mt-0.5 text-[20px] font-bold leading-tight text-emerald-700">{{ number_format($stats['selesai']) }}</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-emerald-50 text-emerald-700"><i data-lucide="check-check" class="h-3.5 w-3.5"></i></span>
            </article>
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-amber-100 bg-amber-50/40 px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-amber-600">Proses</p><p class="mt-0.5 text-[20px] font-bold leading-tight text-amber-700">{{ number_format($stats['picking'] + $stats['menunggu']) }}</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-amber-100 text-amber-700"><i data-lucide="truck" class="h-3.5 w-3.5"></i></span>
            </article>
        </section>

        <section class="reveal reveal-delay-2 mb-4 rounded-xl border border-slate-100 bg-white p-3 shadow-sm">
            <form method="GET" action="{{ route($routeName) }}" class="flex flex-wrap items-center gap-2">
                <label class="flex h-10 min-w-[220px] flex-1 items-center gap-2 rounded-md bg-blue-50/80 px-3 text-slate-400 md:max-w-[400px]">
                    <i data-lucide="search" class="h-4 w-4"></i>
                    <input name="q" value="{{ $q }}" type="search" placeholder="Cari DO, tiket, departemen, PIC, SKU..." class="w-full bg-transparent text-[12px] text-slate-700 outline-none placeholder:text-slate-400" />
                </label>
                <select name="status" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none">
                    <option value="">Semua Status</option>
                    <option value="Menunggu" {{ $status === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Picking" {{ $status === 'Picking' ? 'selected' : '' }}>Picking</option>
                    <option value="Selesai" {{ $status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
                <select name="hub" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none">
                    <option value="all" {{ $selectedHubId === 'all' ? 'selected' : '' }}>Semua Hub</option>
                    @foreach($hubs as $hubOpt)
                        <option value="{{ $hubOpt->id }}" {{ (string) $hubOpt->id === (string) $selectedHubId ? 'selected' : '' }}>{{ $hubOpt->name }} ({{ $hubOpt->code }})</option>
                    @endforeach
                </select>
                <button type="submit" class="flex h-10 items-center gap-2 rounded-md bg-blue-50 px-3 text-[12px] text-slate-700"><i data-lucide="list-filter" class="h-4 w-4"></i>Filter</button>
                <a href="{{ route($routeName) }}" class="flex h-10 w-10 items-center justify-center rounded-md bg-blue-50 text-slate-600" aria-label="Reset filter" title="Reset filter"><i data-lucide="rotate-cw" class="h-4 w-4"></i></a>
            </form>
        </section>

        {{-- Kartu transaksi: layout dinamis, tidak kaku --}}
        <section class="reveal reveal-delay-3 space-y-2.5">
            @forelse($outbounds as $ob)
            <article class="trx-card flex flex-wrap items-center gap-x-5 gap-y-2 rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                <div class="flex min-w-[190px] flex-1 items-center gap-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600"><i data-lucide="package" class="h-4 w-4"></i></span>
                    <div class="min-w-0">
                        <p class="text-[12px] font-bold text-blue-700">{{ $ob->kode }}</p>
                        <p class="truncate text-[10.5px] text-slate-500">Tiket: {{ $ob->permintaan ?? '-' }} &bull; {{ $ob->created_at?->format('d M Y H:i') }}</p>
                    </div>
                </div>
                <div class="min-w-[160px] flex-1">
                    <p class="truncate text-[12px] font-medium text-slate-800">{{ optional($ob->item)->nama ?? '-' }}</p>
                    <p class="truncate text-[10.5px] text-slate-500">{{ $ob->departemen ?? '-' }}</p>
                </div>
                <div class="min-w-[130px]">
                    <p class="text-[12px] font-semibold text-slate-700">{{ number_format($ob->qty) }} <span class="text-[10.5px] font-normal text-slate-500">{{ $ob->satuan }}</span></p>
                    <p class="truncate text-[10.5px] text-slate-500">{{ $ob->pic ?? '-' }}</p>
                </div>
                <div class="min-w-[150px]">
                    <p class="truncate text-[10.5px] text-slate-500">Tujuan</p>
                    <p class="truncate text-[11px] font-medium text-slate-600">{{ $ob->tujuan ?? '-' }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="rounded bg-blue-50 px-2 py-1 text-[10.5px] text-slate-600">{{ optional($ob->hub)->code ?? '-' }}</span>
                    <span class="rounded-full px-2.5 py-1 text-[10.5px] font-semibold {{ $statusBadge[$ob->status] ?? 'bg-slate-100 text-slate-600' }}">● {{ $ob->status }}</span>
                </div>
            </article>
            @empty
            <div class="rounded-xl border border-slate-100 bg-white px-4 py-12 text-center shadow-sm">
                <i data-lucide="search-x" class="h-8 w-8 text-slate-300 mx-auto"></i>
                <p class="mt-2 text-[12.5px] font-semibold text-slate-500">Belum ada transaksi barang keluar yang cocok dengan filter pada hub ini.</p>
            </div>
            @endforelse

            <footer class="flex flex-wrap items-center justify-between gap-2 pt-1 text-[12px] text-slate-600">
                <span>Menampilkan {{ $outbounds->firstItem() ?? 0 }} - {{ $outbounds->lastItem() ?? 0 }} dari {{ number_format($outbounds->total()) }} transaksi &bull; Hub: {{ $hubScopeLabel }}</span>
                <div class="flex items-center gap-1">
                    @if($outbounds->onFirstPage())
                        <span class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-400">‹ Sebelumnya</span>
                    @else
                        <a href="{{ $outbounds->previousPageUrl() }}" class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">‹ Sebelumnya</a>
                    @endif
                    @foreach($outbounds->getUrlRange(max(1, $outbounds->currentPage() - 2), min($outbounds->lastPage(), $outbounds->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}" class="h-8 min-w-8 rounded px-2 text-[12px] {{ $page === $outbounds->currentPage() ? 'bg-blue-600 px-2 font-semibold text-white' : 'text-slate-600' }}">{{ $page }}</a>
                    @endforeach
                    @if($outbounds->hasMorePages())
                        <a href="{{ $outbounds->nextPageUrl() }}" class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">Selanjutnya ›</a>
                    @else
                        <span class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-400">Selanjutnya ›</span>
                    @endif
                </div>
            </footer>
        </section>

    </main>
</div>

@if($canManage)
<div id="modal-catat-keluar" class="fixed inset-0 z-[70] hidden items-center justify-center bg-slate-950/40 p-4">
  <form method="POST" action="{{ route($routeName . '.store') }}" class="max-h-[90vh] w-full max-w-[520px] overflow-y-auto rounded-xl bg-white p-5 shadow-xl">
    @csrf
    <div class="mb-4 flex items-start justify-between">
      <div>
        <h2 class="text-[14px] font-bold text-slate-800">Catat Barang Keluar</h2>
        <p class="mt-1 text-[11px] text-slate-500">Daftarkan pengeluaran barang beserta tiket permintaan dan tujuan.</p>
      </div>
      <button type="button" id="tutup-modal-keluar" class="rounded p-1 text-slate-400 hover:bg-slate-100" aria-label="Tutup"><i data-lucide="x" class="h-4 w-4"></i></button>
    </div>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
      <label class="text-[12px] font-medium text-slate-700">Nomor DO *
        <input name="kode" required maxlength="30" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="DO-2025-0823">
      </label>
      <label class="text-[12px] font-medium text-slate-700">Tiket permintaan
        <input name="permintaan" maxlength="30" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="REQ-2510-005">
      </label>
      <label class="text-[12px] font-medium text-slate-700">Barang
        <select name="item_id" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500">
          <option value="">— Pilih barang —</option>
          @foreach($items as $itemOpt)
            <option value="{{ $itemOpt->id }}">{{ $itemOpt->sku }} — {{ $itemOpt->nama }}</option>
          @endforeach
        </select>
      </label>
      <label class="text-[12px] font-medium text-slate-700">Departemen pemohon
        <input name="departemen" maxlength="100" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="Operasional & Warehouse">
      </label>
      <label class="text-[12px] font-medium text-slate-700">PIC
        <input name="pic" maxlength="100" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="Nama penanggung jawab">
      </label>
      <label class="text-[12px] font-medium text-slate-700">Jumlah *
        <input name="qty" type="number" min="1" required class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="10">
      </label>
      <label class="text-[12px] font-medium text-slate-700">Satuan
        <input name="satuan" maxlength="20" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="Unit">
      </label>
      <label class="text-[12px] font-medium text-slate-700 sm:col-span-2">Tujuan
        <input name="tujuan" maxlength="150" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="Kurir Internal DC / Cabang Regional">
      </label>
      <label class="text-[12px] font-medium text-slate-700 sm:col-span-2">Status *
        <select name="status" required class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500">
          <option value="Menunggu">Menunggu</option>
          <option value="Picking">Picking</option>
          <option value="Selesai">Selesai</option>
        </select>
      </label>
      <label class="text-[12px] font-medium text-slate-700 sm:col-span-2">Keterangan
        <textarea name="keterangan" rows="2" maxlength="500" class="mt-1.5 w-full rounded-md border border-slate-200 px-3 py-2 text-[12px] outline-none focus:border-blue-500" placeholder="Catatan pengeluaran"></textarea>
      </label>
    </div>
    <div class="mt-5 flex justify-end gap-2">
      <button type="button" id="batal-modal-keluar" class="h-10 rounded-md border border-slate-200 px-4 text-[12px] font-medium text-slate-600 hover:bg-slate-50">Batal</button>
      <button type="submit" class="h-10 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white hover:bg-blue-700">Simpan Barang Keluar</button>
    </div>
  </form>
</div>
@endif

<script>
    lucide.createIcons();
    const filterForm = document.querySelector('form[method="GET"]');
    document.querySelectorAll('select[name="hub"], select[name="status"]').forEach((s) => {
        s.addEventListener('change', () => filterForm && filterForm.submit());
    });

    @if($canManage)
    const modalKeluar = document.getElementById('modal-catat-keluar');
    function bukaModalKeluar() {
        modalKeluar.classList.remove('hidden');
        modalKeluar.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }
    function tutupModalKeluar() {
        modalKeluar.classList.add('hidden');
        modalKeluar.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }
    document.getElementById('btn-catat-keluar').addEventListener('click', bukaModalKeluar);
    ['tutup-modal-keluar', 'batal-modal-keluar'].forEach((id) => document.getElementById(id).addEventListener('click', tutupModalKeluar));
    modalKeluar.addEventListener('click', (e) => { if (e.target === modalKeluar) tutupModalKeluar(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !modalKeluar.classList.contains('hidden')) tutupModalKeluar(); });
    @endif
</script>
</body>
</html>
