<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Persetujuan Barang — Kepala Gudang | Astro Inventory</title>

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
                <p class="mb-1 text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Operasional Gudang <span class="text-blue-700">&gt; Persetujuan Barang</span></p>
                <h1 class="text-[24px] font-bold leading-tight tracking-tight text-slate-800">Persetujuan Barang</h1>
                <p class="mt-1.5 max-w-[620px] text-[12px] leading-relaxed text-slate-500">Kaji dan proses pengajuan barang dari pegawai: setujui atau tolak tiket permintaan —</p>
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

        <section aria-label="Ringkasan persetujuan" class="reveal reveal-delay-1 mb-4 grid grid-cols-2 gap-2.5 md:grid-cols-5">
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-slate-100 bg-white px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-slate-500">Total</p><p class="mt-0.5 text-[20px] font-bold leading-tight">{{ number_format($stats['total']) }}</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="ticket" class="h-3.5 w-3.5"></i></span>
            </article>
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-amber-100 bg-amber-50/40 px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-amber-600">Menunggu</p><p class="mt-0.5 text-[20px] font-bold leading-tight text-amber-700">{{ number_format($stats['menunggu']) }}</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-amber-100 text-amber-700"><i data-lucide="clock-3" class="h-3.5 w-3.5"></i></span>
            </article>
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-slate-100 bg-white px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-slate-500">Disetujui</p><p class="mt-0.5 text-[20px] font-bold leading-tight text-blue-700">{{ number_format($stats['disetujui']) }}</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-blue-50 text-blue-700"><i data-lucide="thumbs-up" class="h-3.5 w-3.5"></i></span>
            </article>
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-slate-100 bg-white px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-slate-500">Ditolak</p><p class="mt-0.5 text-[20px] font-bold leading-tight text-red-600">{{ number_format($stats['ditolak']) }}</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-red-50 text-red-600"><i data-lucide="x-circle" class="h-3.5 w-3.5"></i></span>
            </article>
            <article class="flex min-h-[72px] items-center justify-between rounded-xl border border-slate-100 bg-white px-3.5 py-2.5 shadow-sm">
                <div><p class="text-[9px] font-semibold uppercase tracking-wide text-slate-500">Selesai</p><p class="mt-0.5 text-[20px] font-bold leading-tight text-emerald-700">{{ number_format($stats['selesai']) }}</p></div>
                <span class="flex h-7 w-7 items-center justify-center rounded-md bg-emerald-50 text-emerald-700"><i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i></span>
            </article>
        </section>

        <section class="reveal reveal-delay-2 mb-4 rounded-xl border border-slate-100 bg-white p-3 shadow-sm">
            <form method="GET" action="{{ route($routeName) }}" class="flex flex-wrap items-center gap-2">
                <label class="flex h-10 min-w-[220px] flex-1 items-center gap-2 rounded-md bg-blue-50/80 px-3 text-slate-400 md:max-w-[400px]">
                    <i data-lucide="search" class="h-4 w-4"></i>
                    <input name="q" value="{{ $q }}" type="search" placeholder="Cari tiket, rincian, pemohon..." class="w-full bg-transparent text-[12px] text-slate-700 outline-none placeholder:text-slate-400" />
                </label>
                <select name="status" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none">
                    <option value="">Semua Status</option>
                    <option value="Menunggu" {{ $status === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Disetujui" {{ $status === 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Ditolak" {{ $status === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
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

        <section class="reveal reveal-delay-3 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1000px] table-fixed border-collapse text-left">
                    <thead class="h-10 bg-[#f0f4fc] text-[9px] font-semibold uppercase tracking-wide text-slate-600">
                        <tr>
                            <th class="w-[150px] whitespace-nowrap px-2">Tiket &amp; Waktu</th>
                            <th class="w-[180px] whitespace-nowrap px-2">Pemohon</th>
                            <th class="w-[300px] whitespace-nowrap px-2">Rincian &amp; Tipe</th>
                            <th class="w-[110px] whitespace-nowrap px-2">Prioritas</th>
                            <th class="w-[130px] whitespace-nowrap px-2">Hub</th>
                            <th class="w-[120px] whitespace-nowrap px-2">Status</th>
                            <th class="w-[160px] whitespace-nowrap px-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-[12px]">
                        @forelse($permintaans as $prm)
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-2">
                                <span class="font-bold text-blue-700">{{ $prm->tiket }}</span>
                                <span class="block text-[10.5px] text-slate-500">{{ $prm->created_at?->format('d M Y H:i') }}</span>
                            </td>
                            <td class="px-2">
                                <span class="block truncate font-medium text-slate-700">{{ optional($prm->user)->name ?? '-' }}</span>
                                <span class="block text-[10.5px] text-slate-500">{{ $prm->tipe }}</span>
                            </td>
                            <td class="px-2 truncate text-slate-600" title="{{ $prm->rincian }}">{{ $prm->rincian }}</td>
                            <td class="px-2">
                                <span class="rounded-full px-2.5 py-1 text-[10.5px] font-semibold {{ $prm->prioritas === 'Tinggi' ? 'bg-red-50 text-red-700' : 'bg-slate-100 text-slate-600' }}">{{ $prm->prioritas }}</span>
                            </td>
                            <td class="px-2"><span class="rounded bg-blue-50 px-2 py-1 text-[10.5px] text-slate-600">{{ optional($prm->hub)->code ?? '-' }}</span></td>
                            <td class="px-2">
                                @php
                                    $badge = match ($prm->status) {
                                        'Selesai' => 'bg-emerald-100 text-emerald-800',
                                        'Disetujui' => 'bg-blue-100 text-blue-700',
                                        'Ditolak' => 'bg-red-100 text-red-700',
                                        default => 'bg-amber-100 text-amber-700',
                                    };
                                @endphp
                                <span class="rounded-full px-2.5 py-1 text-[10.5px] font-semibold {{ $badge }}">● {{ $prm->status }}</span>
                            </td>
                            <td class="px-2">
                                @if($prm->status === 'Menunggu')
                                <div class="flex items-center justify-center gap-1.5">
                                    <form method="POST" action="{{ route('kepalagudang.persetujuan-barang.proses', $prm->id) }}" onsubmit="return confirm('Setujui pengajuan {{ $prm->tiket }}?')">
                                        @csrf
                                        <input type="hidden" name="keputusan" value="Disetujui">
                                        <button type="submit" class="flex h-8 items-center gap-1 rounded-md bg-emerald-50 px-2.5 text-[10.5px] font-semibold text-emerald-700 hover:bg-emerald-100" title="Setujui pengajuan"><i data-lucide="check" class="h-3.5 w-3.5"></i>Setujui</button>
                                    </form>
                                    <form method="POST" action="{{ route('kepalagudang.persetujuan-barang.proses', $prm->id) }}" onsubmit="return confirm('Tolak pengajuan {{ $prm->tiket }}?')">
                                        @csrf
                                        <input type="hidden" name="keputusan" value="Ditolak">
                                        <button type="submit" class="flex h-8 items-center gap-1 rounded-md bg-red-50 px-2.5 text-[10.5px] font-semibold text-red-700 hover:bg-red-100" title="Tolak pengajuan"><i data-lucide="x" class="h-3.5 w-3.5"></i>Tolak</button>
                                    </form>
                                </div>
                                @else
                                <span class="block text-center text-[10.5px] text-slate-400">Diproses {{ optional($prm->user)->name ?? '-' }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center">
                                <i data-lucide="search-x" class="h-8 w-8 text-slate-300 mx-auto"></i>
                                <p class="mt-2 text-[12.5px] font-semibold text-slate-500">Belum ada pengajuan yang cocok dengan filter pada hub ini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <footer class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 px-4 py-3 text-[12px] text-slate-600">
                <span>Menampilkan {{ $permintaans->firstItem() ?? 0 }} - {{ $permintaans->lastItem() ?? 0 }} dari {{ number_format($permintaans->total()) }} pengajuan &bull; Hub: {{ $hubScopeLabel }}</span>
                <div class="flex items-center gap-1">
                    @if($permintaans->onFirstPage())
                        <span class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-400">‹ Sebelumnya</span>
                    @else
                        <a href="{{ $permintaans->previousPageUrl() }}" class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">‹ Sebelumnya</a>
                    @endif
                    @foreach($permintaans->getUrlRange(max(1, $permintaans->currentPage() - 2), min($permintaans->lastPage(), $permintaans->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}" class="h-8 min-w-8 rounded px-2 text-[12px] {{ $page === $permintaans->currentPage() ? 'bg-blue-600 px-2 font-semibold text-white' : 'text-slate-600' }}">{{ $page }}</a>
                    @endforeach
                    @if($permintaans->hasMorePages())
                        <a href="{{ $permintaans->nextPageUrl() }}" class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">Selanjutnya ›</a>
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
    document.querySelectorAll('select[name="hub"], select[name="status"]').forEach((s) => {
        s.addEventListener('change', () => filterForm && filterForm.submit());
    });
</script>
</body>
</html>
