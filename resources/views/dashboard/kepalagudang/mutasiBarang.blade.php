<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mutasi Barang — Kepala Gudang | Astro Inventory</title>

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

        <section class="reveal mb-4 flex flex-wrap items-end justify-between gap-3">
            <div>
                <p class="mb-1 text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Operasional Gudang <span class="text-blue-700">&gt; Mutasi Barang</span></p>
                <h1 class="text-[24px] font-bold leading-tight tracking-tight text-slate-800">Mutasi Barang</h1>
                <p class="mt-1.5 max-w-[620px] text-[12px] leading-relaxed text-slate-500">Alur pergerakan stok kronologis (barang masuk &amp; barang keluar) pada lingkup hub — data nyata dari tabel inbounds &amp; outbounds.</p>
            </div>
            <span class="rounded-full bg-blue-50 px-3 py-1.5 text-[11px] font-semibold text-blue-700">Hub: {{ $hubScopeLabel }}{{ $hubScopeCode ? ' (' . $hubScopeCode . ')' : '' }}</span>
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

        <section aria-label="Ringkasan mutasi" class="reveal reveal-delay-1 mb-4 grid grid-cols-2 gap-2.5 md:grid-cols-4">
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-slate-100 bg-white px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-slate-500">Total Mutasi</p><p class="mt-0.5 text-[20px] font-bold leading-tight">{{ number_format($stats['total']) }}</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="repeat" class="h-3.5 w-3.5"></i></span>
            </article>
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-slate-100 bg-white px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-slate-500">Masuk</p><p class="mt-0.5 text-[20px] font-bold leading-tight text-emerald-700">{{ number_format($stats['masuk']) }}</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-emerald-50 text-emerald-700"><i data-lucide="arrow-down-left" class="h-3.5 w-3.5"></i></span>
            </article>
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-slate-100 bg-white px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-slate-500">Keluar</p><p class="mt-0.5 text-[20px] font-bold leading-tight text-blue-700">{{ number_format($stats['keluar']) }}</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-blue-50 text-blue-700"><i data-lucide="arrow-up-right" class="h-3.5 w-3.5"></i></span>
            </article>
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-slate-100 bg-white px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-slate-500">Total Qty</p><p class="mt-0.5 text-[20px] font-bold leading-tight">{{ number_format($stats['qty']) }}</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-indigo-50 text-indigo-600"><i data-lucide="package" class="h-3.5 w-3.5"></i></span>
            </article>
        </section>

        <section class="reveal reveal-delay-2 mb-4 rounded-xl border border-slate-100 bg-white p-3 shadow-sm">
            <form method="GET" action="{{ route($routeName) }}" class="flex flex-wrap items-center gap-2">
                <label class="flex h-10 min-w-[220px] flex-1 items-center gap-2 rounded-md bg-blue-50/80 px-3 text-slate-400 md:max-w-[400px]">
                    <i data-lucide="search" class="h-4 w-4"></i>
                    <input name="q" value="{{ $q }}" type="search" placeholder="Cari PO/DO, SKU, nama barang, tipe mutasi..." class="w-full bg-transparent text-[12px] text-slate-700 outline-none placeholder:text-slate-400" />
                </label>
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

        <section class="reveal reveal-delay-3 space-y-2.5">
            @forelse($mutasis as $mut)
            <article class="trx-card flex flex-wrap items-center gap-x-5 gap-y-2 rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                <div class="flex min-w-[170px] flex-1 items-center gap-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg {{ $mut->mutasi_tipe === 'Masuk' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-600' }}">
                        <i data-lucide="{{ $mut->mutasi_tipe === 'Masuk' ? 'arrow-down-left' : 'arrow-up-right' }}" class="h-4 w-4"></i>
                    </span>
                    <div class="min-w-0">
                        <p class="text-[12px] font-bold {{ $mut->mutasi_tipe === 'Masuk' ? 'text-emerald-700' : 'text-blue-700' }}">{{ $mut->kode }}</p>
                        <p class="text-[10.5px] text-slate-500">{{ $mut->created_at?->format('d M Y H:i') }}</p>
                    </div>
                </div>
                <div class="min-w-[150px]">
                    <span class="rounded-full px-2.5 py-1 text-[10.5px] font-semibold {{ $mut->mutasi_tipe === 'Masuk' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-700' }}">{{ $mut->mutasi_tipe }}</span>
                    <p class="mt-1 truncate text-[10.5px] text-slate-500">{{ $mut->surat_jalan ?? $mut->permintaan ?? '-' }}</p>
                </div>
                <div class="min-w-[160px] flex-1">
                    <p class="truncate text-[12px] font-medium text-slate-800">{{ optional($mut->item)->nama ?? '-' }}</p>
                    <p class="truncate text-[10.5px] text-slate-500">{{ optional($mut->item)->sku ?? '-' }}</p>
                </div>
                <div class="min-w-[120px]">
                    <p class="text-[12px] font-semibold text-slate-700">{{ number_format($mut->qty) }} <span class="text-[10.5px] font-normal text-slate-500">{{ $mut->satuan }}</span></p>
                    <p class="truncate text-[10.5px] text-slate-500">{{ optional($mut->location)->kode ?? optional($mut->hub)->code ?? '-' }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="rounded bg-blue-50 px-2 py-1 text-[10.5px] text-slate-600">{{ optional($mut->hub)->code ?? '-' }}</span>
                    <span class="rounded-full px-2.5 py-1 text-[10.5px] font-semibold {{ $mut->status === 'Selesai' ? 'bg-emerald-100 text-emerald-800' : ($mut->status === 'Karantina' || $mut->status === 'Ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">● {{ $mut->status }}</span>
                </div>
            </article>
            @empty
            <div class="rounded-xl border border-slate-100 bg-white px-4 py-12 text-center shadow-sm">
                <i data-lucide="search-x" class="h-8 w-8 text-slate-300 mx-auto"></i>
                <p class="mt-2 text-[12.5px] font-semibold text-slate-500">Belum ada mutasi yang cocok dengan filter pada hub ini.</p>
            </div>
            @endforelse

            <footer class="flex flex-wrap items-center justify-between gap-2 pt-1 text-[12px] text-slate-600">
                <span>Menampilkan {{ $mutasis->firstItem() ?? 0 }} - {{ $mutasis->lastItem() ?? 0 }} dari {{ number_format($mutasis->total()) }} mutasi &bull; Hub: {{ $hubScopeLabel }}</span>
                <div class="flex items-center gap-1">
                    @if($mutasis->onFirstPage())
                        <span class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-400">‹ Sebelumnya</span>
                    @else
                        <a href="{{ $mutasis->previousPageUrl() }}" class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">‹ Sebelumnya</a>
                    @endif
                    @foreach($mutasis->getUrlRange(max(1, $mutasis->currentPage() - 2), min($mutasis->lastPage(), $mutasis->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}" class="h-8 min-w-8 rounded px-2 text-[12px] {{ $page === $mutasis->currentPage() ? 'bg-blue-600 px-2 font-semibold text-white' : 'text-slate-600' }}">{{ $page }}</a>
                    @endforeach
                    @if($mutasis->hasMorePages())
                        <a href="{{ $mutasis->nextPageUrl() }}" class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">Selanjutnya ›</a>
                    @else
                        <span class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-400">Selanjutnya ›</span>
                    @endif
                </div>
            </footer>
        </section>

    </main>
</div>

<script>
    lucide.createIcons();
    const filterForm = document.querySelector('form[method="GET"]');
    document.querySelectorAll('select[name="hub"]').forEach((s) => {
        s.addEventListener('change', () => filterForm && filterForm.submit());
    });
</script>
</body>
</html>
