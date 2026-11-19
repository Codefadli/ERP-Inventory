<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Gudang &amp; Lokasi - Astro Inventory</title>

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
        :root { --brand: #2563eb; --brand-dark: #1d4ed8; --bg: #f5f7fb; --line: #e7ebf2; }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif; }

        .nav-link { transition: all 0.16s ease; }
        .nav-link:hover { background: #f1f5f9; color: #172033; transform: translateX(3px); }
        .nav-link.active { background: var(--brand); color: #fff; font-weight: 600; box-shadow: 0 6px 14px -6px rgba(37, 99, 235, 0.55); }
        .nav-link.active:hover { transform: none; background: var(--brand); }

        .soft-button { transition: transform .16s ease, box-shadow .16s ease, background .16s ease; }
        .soft-button:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(15, 23, 42, .08); }

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

        @php
            $isSuperAdmin = auth()->user()->isSuperAdmin();
            $isKepalaGudang = auth()->user()->isKepalaGudang();
            $isAuditor = auth()->user()->isAuditor();
            $scopeLabel = $isSuperAdmin ? 'Manajemen Sistem' : ($isKepalaGudang ? 'Operasional Gudang' : 'Pengendalian Audit');
            $scopeDesc = $isSuperAdmin
                ? 'Pemetaan fasilitas penyimpanan fisik seluruh hub, konfigurasi zona gudang, kapasitas rak/bin, dan status okupansi.'
                : ($isKepalaGudang
                    ? 'Pemetaan fasilitas penyimpanan fisik hub Anda: zona gudang, kapasitas rak/bin, dan okupansi.'
                    : 'Referensi pemeriksaan fasilitas penyimpanan: kapasitas, okupansi, dan status lokasi tanpa hak mengubah data.');
        @endphp

        <section class="reveal mb-4 flex flex-wrap items-end justify-between gap-3">
            <div>
                <p class="mb-1 text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">{{ $scopeLabel }} <span class="text-blue-700">&gt; Data Gudang &amp; Lokasi Rak</span></p>
                <h1 class="text-[24px] font-bold leading-tight tracking-tight text-slate-800">Manajemen Data Gudang &amp; Lokasi Rak</h1>
                <p class="mt-1.5 max-w-[620px] text-[12px] leading-relaxed text-slate-500">{{ $scopeDesc }}</p>
            </div>
            <div class="flex items-center gap-2">
                @if($canManage)
                <button id="btn-tambah-lokasi" type="button" class="soft-button flex h-10 items-center gap-2 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white shadow-sm hover:bg-blue-700">
                    <i data-lucide="plus" class="h-4 w-4"></i>Tambah Fasilitas / Rak Baru
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

        <section aria-label="Ringkasan lokasi" class="reveal reveal-delay-1 mb-4 grid grid-cols-2 gap-3 md:grid-cols-4">
            <article class="flex min-h-[100px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Total Lokasi Rak</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight">{{ number_format($stats['total']) }}</p><p class="mt-2 text-[10.5px] text-slate-500">Tercatat pada hub ini</p></div>
                <span class="flex h-8 w-8 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="warehouse" class="h-4 w-4"></i></span>
            </article>
            <article class="flex min-h-[100px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Kapasitas Total</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight">{{ number_format($stats['kapasitas']) }}</p><p class="mt-2 text-[10.5px] text-slate-500">Slot penyimpanan</p></div>
                <span class="flex h-8 w-8 items-center justify-center rounded-md bg-emerald-50 text-emerald-700"><i data-lucide="layers" class="h-4 w-4"></i></span>
            </article>
            <article class="flex min-h-[100px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Terisi</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight">{{ number_format($stats['terisi']) }}</p><p class="mt-2 text-[10.5px] text-slate-500">{{ $stats['persen'] }}% okupansi</p></div>
                <span class="flex h-8 w-8 items-center justify-center rounded-md bg-amber-50 text-amber-600"><i data-lucide="archive" class="h-4 w-4"></i></span>
            </article>
            <article class="flex min-h-[100px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
                <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Aktif</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight text-emerald-700">{{ number_format($stats['aktif']) }}</p><p class="mt-2 text-[10.5px] text-slate-500">Lokasi berstatus aktif</p></div>
                <span class="flex h-8 w-8 items-center justify-center rounded-md bg-indigo-50 text-indigo-600"><i data-lucide="check-circle-2" class="h-4 w-4"></i></span>
            </article>
        </section>

        <section class="reveal reveal-delay-2 mb-4 rounded-xl border border-slate-100 bg-white p-3 shadow-sm">
            <form method="GET" action="{{ route($routeName) }}" class="flex flex-wrap items-center gap-2">
                <label class="flex h-10 min-w-[220px] flex-1 items-center gap-2 rounded-md bg-blue-50/80 px-3 text-slate-400 md:max-w-[420px]">
                    <i data-lucide="search" class="h-4 w-4"></i>
                    <input name="q" value="{{ $q }}" type="search" placeholder="Cari kode gudang, zona, lorong, nomor rak..." class="w-full bg-transparent text-[12px] text-slate-700 outline-none placeholder:text-slate-400" />
                </label>
                <select name="hub" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none">
                    <option value="all" {{ $selectedHubId === 'all' ? 'selected' : '' }}>Semua Hub</option>
                    @foreach($hubs as $hubOpt)
                        <option value="{{ $hubOpt->id }}" {{ (string) $hubOpt->id === (string) $selectedHubId ? 'selected' : '' }}>{{ $hubOpt->name }} ({{ $hubOpt->code }})</option>
                    @endforeach
                </select>
                <select name="gudang" class="h-10 rounded-md border-0 bg-blue-50 px-3 text-[12px] text-slate-700 outline-none">
                    <option value="">Semua Gedung</option>
                    @foreach($buildings as $bld)
                        <option value="{{ $bld }}" {{ $gudang === $bld ? 'selected' : '' }}>{{ $bld }}</option>
                    @endforeach
                </select>
                <button type="submit" class="flex h-10 items-center gap-2 rounded-md bg-blue-50 px-3 text-[12px] text-slate-700"><i data-lucide="list-filter" class="h-4 w-4"></i>Filter</button>
                <a href="{{ route($routeName) }}" class="flex h-10 w-10 items-center justify-center rounded-md bg-blue-50 text-slate-600" aria-label="Reset filter" title="Reset filter"><i data-lucide="rotate-cw" class="h-4 w-4"></i></a>
            </form>
        </section>

        <section class="reveal reveal-delay-3 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1100px] table-fixed border-collapse text-left">
                    <thead class="h-11 bg-[#f0f4fc] text-[9.5px] font-semibold uppercase tracking-wide text-slate-600">
                        <tr>
                            <th class="w-[120px] whitespace-nowrap px-2">Kode Lokasi</th>
                            <th class="w-[200px] whitespace-nowrap px-2">Nama / Rak</th>
                            <th class="w-[180px] whitespace-nowrap px-2">Gudang</th>
                            <th class="w-[120px] whitespace-nowrap px-2">Kapasitas</th>
                            <th class="w-[120px] whitespace-nowrap px-2">Terisi</th>
                            <th class="w-[150px] whitespace-nowrap px-2">Hub</th>
                            <th class="w-[100px] whitespace-nowrap px-2">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-[12px]">
                        @forelse($locations as $loc)
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-2"><span class="font-bold text-blue-700">{{ $loc->kode }}</span></td>
                            <td class="px-2"><span class="truncate block font-semibold text-slate-800">{{ $loc->nama }}</span><span class="text-[10.5px] text-slate-500">{{ $loc->nama_rak }}</span></td>
                            <td class="px-2 text-slate-600">{{ $loc->gudang }}</td>
                            <td class="px-2 text-slate-600">{{ number_format($loc->kapasitas) }}</td>
                            <td class="px-2 text-slate-600">{{ number_format($loc->terisi) }}</td>
                            <td class="px-2"><span class="rounded bg-blue-50 px-2 py-1 text-[10.5px] text-slate-600">{{ optional($loc->hub)->code ?? '-' }}</span></td>
                            <td class="px-2"><span class="rounded-full px-2.5 py-1 text-[10.5px] font-semibold {{ $loc->status ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">● {{ $loc->status ? 'Aktif' : 'Nonaktif' }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center">
                                <i data-lucide="search-x" class="h-8 w-8 text-slate-300 mx-auto"></i>
                                <p class="mt-2 text-[12.5px] font-semibold text-slate-500">Belum ada lokasi yang cocok dengan filter pada hub ini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <footer class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 px-4 py-3 text-[12px] text-slate-600">
                <span>Menampilkan {{ $locations->firstItem() ?? 0 }} - {{ $locations->lastItem() ?? 0 }} dari {{ number_format($locations->total()) }} lokasi &bull; Hub: {{ $hubScopeLabel }}</span>
                <div class="flex items-center gap-1">
                    @if($locations->onFirstPage())
                        <span class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-400">‹ Sebelumnya</span>
                    @else
                        <a href="{{ $locations->previousPageUrl() }}" class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">‹ Sebelumnya</a>
                    @endif
                    @foreach($locations->getUrlRange(max(1, $locations->currentPage() - 2), min($locations->lastPage(), $locations->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}" class="h-8 min-w-8 rounded px-2 text-[12px] {{ $page === $locations->currentPage() ? 'bg-blue-600 px-2 font-semibold text-white' : 'text-slate-600' }}">{{ $page }}</a>
                    @endforeach
                    @if($locations->hasMorePages())
                        <a href="{{ $locations->nextPageUrl() }}" class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">Selanjutnya ›</a>
                    @else
                        <span class="h-8 rounded bg-blue-50 px-2 text-[12px] text-slate-400">Selanjutnya ›</span>
                    @endif
                </div>
            </footer>
        </section>

    </main>
</div>

@if($canManage)
<div id="modal-tambah-lokasi" class="fixed inset-0 z-[70] hidden items-center justify-center bg-slate-950/40 p-4">
  <form method="POST" action="{{ route($routeName . '.store') }}" class="max-h-[90vh] w-full max-w-[520px] overflow-y-auto rounded-xl bg-white p-5 shadow-xl">
    @csrf
    <div class="mb-4 flex items-start justify-between">
      <div>
        <h2 class="text-[14px] font-bold text-slate-800">Tambah Fasilitas / Rak Baru</h2>
        <p class="mt-1 text-[11px] text-slate-500">Daftarkan lokasi penyimpanan fisik baru pada lingkup hub terpilih.</p>
      </div>
      <button type="button" id="tutup-modal-lokasi" class="rounded p-1 text-slate-400 hover:bg-slate-100" aria-label="Tutup"><i data-lucide="x" class="h-4 w-4"></i></button>
    </div>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
      <label class="text-[12px] font-medium text-slate-700">Kode lokasi *
        <input name="kode" required maxlength="30" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="RAK-A3-01">
      </label>
      <label class="text-[12px] font-medium text-slate-700">Nama lokasi / rak *
        <input name="nama" required maxlength="100" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="Rak Besi Tingkat 3">
      </label>
      <label class="text-[12px] font-medium text-slate-700">Gudang *
        <input name="gudang" required maxlength="100" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="Gudang Utama (A)">
      </label>
      <label class="text-[12px] font-medium text-slate-700">Nama rak / zona
        <input name="nama_rak" maxlength="100" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="Zona C - Rak 2">
      </label>
      <label class="text-[12px] font-medium text-slate-700">Kapasitas
        <input name="kapasitas" type="number" min="0" value="0" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="50">
      </label>
      <label class="text-[12px] font-medium text-slate-700">Terisi
        <input name="terisi" type="number" min="0" value="0" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="0">
      </label>
      <label class="text-[12px] font-medium text-slate-700">Hub
        <select name="hub_id" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500">
          <option value="">— Hub default saya —</option>
          @foreach($hubs as $hubOpt)
            <option value="{{ $hubOpt->id }}" {{ (string) $hubOpt->id === (string) $selectedHubId ? 'selected' : '' }}>{{ $hubOpt->name }} ({{ $hubOpt->code }})</option>
          @endforeach
        </select>
      </label>
      <label class="text-[12px] font-medium text-slate-700">Status
        <select name="status" required class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500">
          <option value="1">Aktif</option>
          <option value="0">Nonaktif</option>
        </select>
      </label>
      <label class="text-[12px] font-medium text-slate-700 sm:col-span-2">Keterangan
        <textarea name="keterangan" rows="2" maxlength="500" class="mt-1.5 w-full rounded-md border border-slate-200 px-3 py-2 text-[12px] outline-none focus:border-blue-500" placeholder="Catatan lokasi, mis. dekat loading bay"></textarea>
      </label>
    </div>
    <div class="mt-5 flex justify-end gap-2">
      <button type="button" id="batal-modal-lokasi" class="h-10 rounded-md border border-slate-200 px-4 text-[12px] font-medium text-slate-600 hover:bg-slate-50">Batal</button>
      <button type="submit" class="h-10 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white hover:bg-blue-700">Simpan Lokasi</button>
    </div>
  </form>
</div>
@endif

<script>
    lucide.createIcons();
    const filterForm = document.querySelector('form[method="GET"]');
    document.querySelectorAll('select[name="hub"], select[name="gudang"]').forEach((s) => {
        s.addEventListener('change', () => filterForm && filterForm.submit());
    });

    @if($canManage)
    const modalLokasi = document.getElementById('modal-tambah-lokasi');
    function bukaModalLokasi() {
        modalLokasi.classList.remove('hidden');
        modalLokasi.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }
    function tutupModalLokasi() {
        modalLokasi.classList.add('hidden');
        modalLokasi.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }
    document.getElementById('btn-tambah-lokasi').addEventListener('click', bukaModalLokasi);
    ['tutup-modal-lokasi', 'batal-modal-lokasi'].forEach((id) => document.getElementById(id).addEventListener('click', tutupModalLokasi));
    modalLokasi.addEventListener('click', (e) => { if (e.target === modalLokasi) tutupModalLokasi(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !modalLokasi.classList.contains('hidden')) tutupModalLokasi(); });
    @endif
</script>
</body>
</html>
