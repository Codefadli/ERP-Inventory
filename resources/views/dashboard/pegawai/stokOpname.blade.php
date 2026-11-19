<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Audit Stok Opname Fisik | Astro Inventory</title>

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
                <p class="mb-1 text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Portal Pegawai <span class="text-blue-700">&gt; Stok Opname</span></p>
                <h1 class="text-[24px] font-bold leading-tight tracking-tight text-slate-800">Audit Stok Opname Fisik</h1>
                <p class="mt-1.5 max-w-[620px] text-[12px] leading-relaxed text-slate-500">Hasil penghitungan fisik (stock count) yang dicatat staf: qty sistem vs qty fisik aktual, selisih, dan status verifikasi — data nyata dari tabel stock_opnames.</p>
            </div>
            <div class="flex items-center gap-2">
                <button id="btn-input-opname" type="button" class="flex h-10 items-center gap-2 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white shadow-sm hover:bg-blue-700">
                    <i data-lucide="plus" class="h-4 w-4"></i>Input Hasil Opname
                </button>
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

        <section aria-label="Ringkasan opname" class="reveal reveal-delay-1 mb-4 grid grid-cols-2 gap-3 md:grid-cols-4">
            <article class="flex min-h-[100px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Total Pemeriksaan</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight">{{ number_format($stats['total']) }}</p><p class="mt-2 text-[10.5px] text-slate-500">Item diopname</p></div>
                <span class="flex h-8 w-8 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="clipboard-check" class="h-4 w-4"></i></span>
            </article>
            <article class="flex min-h-[100px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Sesuai</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight text-emerald-700">{{ number_format($stats['sesuai']) }}</p><p class="mt-2 text-[10.5px] text-slate-500">Fisik = catatan</p></div>
                <span class="flex h-8 w-8 items-center justify-center rounded-md bg-emerald-50 text-emerald-700"><i data-lucide="check-check" class="h-4 w-4"></i></span>
            </article>
            <article class="flex min-h-[100px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Selisih</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight text-red-600">{{ number_format($stats['selisih']) }}</p><p class="mt-2 text-[10.5px] text-slate-500">Perlu verifikasi</p></div>
                <span class="flex h-8 w-8 items-center justify-center rounded-md bg-red-50 text-red-600"><i data-lucide="triangle-alert" class="h-4 w-4"></i></span>
            </article>
            <article class="flex min-h-[100px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Belum Diverifikasi</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight text-amber-600">{{ number_format($stats['pending']) }}</p><p class="mt-2 text-[10.5px] text-slate-500">Menunggu konfirmasi</p></div>
                <span class="flex h-8 w-8 items-center justify-center rounded-md bg-amber-50 text-amber-600"><i data-lucide="hourglass" class="h-4 w-4"></i></span>
            </article>
        </section>

        <section class="reveal reveal-delay-2 mb-4 rounded-xl border border-slate-100 bg-white p-3 shadow-sm">
            <form method="GET" action="{{ route($routeName) }}" class="flex flex-wrap items-center gap-2">
                <label class="flex h-10 min-w-[220px] flex-1 items-center gap-2 rounded-md bg-blue-50/80 px-3 text-slate-400 md:max-w-[420px]">
                    <i data-lucide="search" class="h-4 w-4"></i>
                    <input name="q" value="{{ $q }}" type="search" placeholder="Cari SKU, nama barang..." class="w-full bg-transparent text-[12px] text-slate-700 outline-none placeholder:text-slate-400" />
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

        <section class="reveal reveal-delay-3 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1050px] table-fixed border-collapse text-left">
                    <thead class="h-11 bg-[#f0f4fc] text-[9.5px] font-semibold uppercase tracking-wide text-slate-600">
                        <tr>
                            <th class="w-[50px] whitespace-nowrap px-2">NO</th>
                            <th class="w-[180px] whitespace-nowrap px-2">SKU &amp; Nama Barang</th>
                            <th class="w-[130px] whitespace-nowrap px-2">Lokasi Bin</th>
                            <th class="w-[100px] whitespace-nowrap px-2">QTY Sistem</th>
                            <th class="w-[100px] whitespace-nowrap px-2">QTY Fisik</th>
                            <th class="w-[90px] whitespace-nowrap px-2">Selisih</th>
                            <th class="w-[140px] whitespace-nowrap px-2">Status Verifikasi</th>
                            <th class="w-[200px] whitespace-nowrap px-2">PIC &amp; Hub</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-[12px]">
                        @forelse($opnames as $i => $op)
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-2 text-slate-500">{{ $i + 1 }}</td>
                            <td class="px-2">
                                <span class="font-bold text-blue-700">{{ $op->item?->sku }}</span>
                                <span class="block truncate text-[10.5px] text-slate-500">{{ $op->item?->nama }}</span>
                            </td>
                            <td class="px-2 text-slate-600">{{ optional($op->item?->location)->kode ?? '-' }}</td>
                            <td class="px-2 font-semibold text-slate-700">{{ number_format($op->qty_sistem) }}</td>
                            <td class="px-2 font-semibold text-slate-700">{{ number_format($op->qty_fisik) }}</td>
                            <td class="px-2">
                                @if($op->selisih == 0)
                                    <span class="text-emerald-700">0</span>
                                @else
                                    <span class="font-semibold text-red-600">{{ $op->selisih > 0 ? '+' : '' }}{{ number_format($op->selisih) }}</span>
                                @endif
                            </td>
                            <td class="px-2">
                                @php
                                    $badge = match ($op->status) {
                                        'Sesuai' => 'bg-emerald-100 text-emerald-800',
                                        'Selisih' => 'bg-red-100 text-red-700',
                                        default => 'bg-amber-100 text-amber-700',
                                    };
                                @endphp
                                <span class="rounded-full px-2.5 py-1 text-[10.5px] font-semibold {{ $badge }}">● {{ $op->status }}</span>
                            </td>
                            <td class="px-2">
                                <span class="block truncate text-[10.5px] text-slate-500">{{ optional($op->user)->name ?? '-' }}</span>
                                <span class="rounded bg-blue-50 px-2 py-0.5 text-[10.5px] text-slate-600">{{ optional($op->hub)->code ?? '-' }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-10 text-center">
                                <i data-lucide="search-x" class="h-8 w-8 text-slate-300 mx-auto"></i>
                                <p class="mt-2 text-[12.5px] font-semibold text-slate-500">Belum ada hasil opname yang cocok dengan filter pada hub ini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <footer class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 px-4 py-3 text-[12px] text-slate-600">
                <span>Menampilkan {{ $opnames->firstItem() ?? 0 }} - {{ $opnames->lastItem() ?? 0 }} dari {{ number_format($opnames->total()) }} pemeriksaan &bull; Hub: {{ $hubScopeLabel }}</span>
                <div class="flex items-center gap-1">
                    @if($opnames->onFirstPage())
                        <span class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-400">‹ Sebelumnya</span>
                    @else
                        <a href="{{ $opnames->previousPageUrl() }}" class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">‹ Sebelumnya</a>
                    @endif
                    @foreach($opnames->getUrlRange(max(1, $opnames->currentPage() - 2), min($opnames->lastPage(), $opnames->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}" class="h-8 min-w-8 rounded px-2 text-[12px] {{ $page === $opnames->currentPage() ? 'bg-blue-600 px-2 font-semibold text-white' : 'text-slate-600' }}">{{ $page }}</a>
                    @endforeach
                    @if($opnames->hasMorePages())
                        <a href="{{ $opnames->nextPageUrl() }}" class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">Selanjutnya ›</a>
                    @else
                        <span class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-400">Selanjutnya ›</span>
                    @endif
                </div>
            </footer>
        </section>

    </main>
</div>

<div id="modal-input-opname" class="fixed inset-0 z-[70] hidden items-center justify-center bg-slate-950/40 p-4">
  <form method="POST" action="{{ route('pegawai.stok-opname.store') }}" class="max-h-[90vh] w-full max-w-[480px] overflow-y-auto rounded-xl bg-white p-5 shadow-xl">
    @csrf
    <div class="mb-4 flex items-start justify-between">
      <div>
        <h2 class="text-[14px] font-bold text-slate-800">Input Hasil Opname Fisik</h2>
        <p class="mt-1 text-[11px] text-slate-500">Catat hasil hitung fisik. Status otomatis Sesuai (selisih 0) atau Selisih.</p>
      </div>
      <button type="button" id="tutup-modal-opname" class="rounded p-1 text-slate-400 hover:bg-slate-100" aria-label="Tutup"><i data-lucide="x" class="h-4 w-4"></i></button>
    </div>
    <div class="grid grid-cols-1 gap-3">
      <label class="text-[12px] font-medium text-slate-700">Item (SKU — Nama) *
        <select name="item_id" required class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500">
          <option value="">— Pilih item —</option>
          @forelse($itemsBelum as $itemOpt)
            <option value="{{ $itemOpt->id }}">{{ $itemOpt->sku }} — {{ $itemOpt->nama }} ({{ optional($itemOpt->location)->kode ?? '-' }})</option>
          @empty
            <option value="" disabled>Semua item sudah diopname</option>
          @endforelse
        </select>
      </label>
      <label class="text-[12px] font-medium text-slate-700">QTY Fisik Aktual *
        <input name="qty_fisik" type="number" min="0" required class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="0">
      </label>
      <label class="text-[12px] font-medium text-slate-700">Catatan
        <textarea name="catatan" rows="2" maxlength="500" class="mt-1.5 w-full rounded-md border border-slate-200 px-3 py-2 text-[12px] outline-none focus:border-blue-500" placeholder="Catatan pemeriksaan (opsional)"></textarea>
      </label>
    </div>
    <div class="mt-5 flex justify-end gap-2">
      <button type="button" id="batal-modal-opname" class="h-10 rounded-md border border-slate-200 px-4 text-[12px] font-medium text-slate-600 hover:bg-slate-50">Batal</button>
      <button type="submit" class="h-10 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white hover:bg-blue-700">Simpan Opname</button>
    </div>
  </form>
</div>

<script>
    lucide.createIcons();
    const filterForm = document.querySelector('form[method="GET"]');
    document.querySelectorAll('select[name="hub"]').forEach((s) => {
        s.addEventListener('change', () => filterForm && filterForm.submit());
    });

    const modalOpname = document.getElementById('modal-input-opname');
    function bukaModalOpname() {
        modalOpname.classList.remove('hidden');
        modalOpname.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }
    function tutupModalOpname() {
        modalOpname.classList.add('hidden');
        modalOpname.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }
    document.getElementById('btn-input-opname').addEventListener('click', bukaModalOpname);
    ['tutup-modal-opname', 'batal-modal-opname'].forEach((id) => document.getElementById(id).addEventListener('click', tutupModalOpname));
    modalOpname.addEventListener('click', (e) => { if (e.target === modalOpname) tutupModalOpname(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !modalOpname.classList.contains('hidden')) tutupModalOpname(); });
</script>
</body>
</html>
