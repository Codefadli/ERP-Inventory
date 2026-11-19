<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Supplier - Astro Inventory</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { DEFAULT: '#2563eb', dark: '#1d4ed8', 50: '#eff6ff', 100: '#dbeafe', 600: '#2563eb', 700: '#1d4ed8' },
                        ink: '#17243b', canvas: '#f5f7fc', line: '#e8edf5',
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
        :root { --brand: #2563eb; --brand-dark: #1d4ed8; }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
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

        .supplier-row { animation: row-in .25s ease both; }
        @keyframes row-in { from { opacity: 0; transform: translateX(-4px); } to { opacity: 1; transform: translateX(0); } }
        #supplier-rows > tr.supplier-row { height: 60px; }

        .soft-button { transition: transform .16s ease, box-shadow .16s ease, background .16s ease; }
        .soft-button:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(15, 23, 42, .08); }
        .soft-button:disabled { opacity: .45; cursor: not-allowed; transform: none; box-shadow: none; }

        @media (min-width: 768px) { main { zoom: 1.1; } }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; scroll-behavior: auto !important; }
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50">

@include('components.navbar')

<div class="flex min-h-screen">
    @include('components.sidebar')

    <main class="flex-1 overflow-x-hidden bg-canvas p-4 lg:p-6">

        {{-- ================= SUPER ADMIN ================= --}}
        @if(auth()->user()->isSuperAdmin())

        <section class="reveal mb-4 flex flex-wrap items-end justify-between gap-3">
          <div>
            <p class="mb-1 text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Master Data & Inventaris <span class="text-blue-700">&gt; Manajemen Data Supplier & Mitra Pemasok</span></p>
            <h1 class="text-[24px] font-bold leading-tight tracking-tight text-slate-800">Manajemen Data Supplier & Mitra Pemasok</h1>
            <p class="mt-1.5 max-w-2xl text-[12px] leading-relaxed text-slate-500">Direktori pemasok vendor resmi, kontak PIC, lokasi, dan lingkup hub —</p>
          </div>
          <div class="flex flex-wrap items-center gap-2">
            <button disabled title="Fitur ekspor belum tersedia" class="soft-button flex h-10 items-center gap-2 rounded-md border border-slate-200 bg-white px-4 text-[12px] font-semibold text-slate-700 shadow-sm"><i data-lucide="download" class="h-4 w-4 text-blue-600"></i>Ekspor Data Vendor</button>
            <button disabled title="Fitur evaluasi SLA belum tersedia" class="soft-button flex h-10 items-center gap-2 rounded-md border border-slate-200 bg-white px-4 text-[12px] font-semibold text-slate-700 shadow-sm"><i data-lucide="clipboard-check" class="h-4 w-4 text-emerald-600"></i>Evaluasi SLA & Rating</button>
            @if($canManage)
            <button id="add-supplier" class="soft-button flex h-10 items-center gap-2 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white shadow-sm hover:bg-blue-700"><i data-lucide="plus" class="h-4 w-4"></i>Tambah Supplier Baru</button>
            @endif
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

        <section aria-label="Ringkasan supplier" class="reveal reveal-delay-1 mb-4 grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
          <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
            <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Total Supplier</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight text-slate-800">{{ number_format($stats['total']) }}</p><p class="mt-2.5 text-[10.5px] text-slate-500">Pada lingkup hub terpilih</p></div>
            <span class="flex h-8 w-8 items-center justify-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="shield-check" class="h-4 w-4"></i></span>
          </article>
          <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
            <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Aktif</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight text-slate-800">{{ number_format($stats['aktif']) }}</p><p class="mt-2.5 text-[10.5px] text-slate-500">Supplier berstatus aktif</p></div>
            <span class="flex h-8 w-8 items-center justify-center rounded-md bg-emerald-50 text-emerald-700"><i data-lucide="check-circle-2" class="h-4 w-4"></i></span>
          </article>
          <article class="flex min-h-[112px] items-start justify-between rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-sm">
            <div><p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Nonaktif</p><p class="mt-1.5 text-[24px] font-bold leading-tight tracking-tight text-slate-800">{{ number_format($stats['total'] - $stats['aktif']) }}</p><p class="mt-2.5 text-[10.5px] text-slate-500">Tidak beroperasi</p></div>
            <span class="flex h-8 w-8 items-center justify-center rounded-md bg-slate-100 text-slate-500"><i data-lucide="building" class="h-4 w-4"></i></span>
          </article>
        </section>

        <section class="reveal reveal-delay-2 mb-4 rounded-xl border border-slate-100 bg-white p-3 shadow-sm">
          <div class="flex flex-wrap items-center gap-2">
            <form method="GET" action="{{ route($routeName) }}" class="flex flex-wrap items-center gap-2 w-full">
              <label class="flex h-10 min-w-[220px] flex-1 items-center gap-2 rounded-md bg-blue-50/80 px-3 text-slate-400 xl:max-w-[430px]">
                <i data-lucide="search" class="h-4 w-4"></i>
                <input name="q" value="{{ $q }}" type="search" placeholder="Cari nama, kode vendor, PIC, email supplier..." class="w-full bg-transparent text-[12px] text-slate-700 outline-none placeholder:text-slate-400">
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
          </div>
        </section>

        <section class="reveal reveal-delay-3 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
          <div class="overflow-x-auto">
            <table class="w-full min-w-[1100px] table-fixed border-collapse text-left">
              <thead class="h-11 whitespace-nowrap bg-[#f0f4fc] text-[9.5px] font-semibold uppercase tracking-wide text-slate-600">
                <tr>
                  <th class="w-[150px] px-2">Kode</th>
                  <th class="w-[230px] px-2">Nama Supplier</th>
                  <th class="w-[170px] px-2">PIC</th>
                  <th class="w-[170px] px-2">Telepon</th>
                  <th class="w-[200px] px-2">Email</th>
                  <th class="w-[150px] px-2">Lokasi</th>
                  <th class="w-[120px] px-2">Hub</th>
                  <th class="w-[110px] px-2">Status</th>
                </tr>
              </thead>
              <tbody id="supplier-rows" class="divide-y divide-slate-100 text-[12px]">
                @forelse($suppliers as $sup)
                <tr class="supplier-row hover:bg-slate-50/70">
                  <td class="px-2"><span class="rounded bg-slate-100 px-2 py-1 text-[10.5px] font-semibold text-blue-700">{{ $sup->kode }}</span></td>
                  <td class="px-2"><b class="block truncate text-[12px] font-semibold text-slate-800">{{ $sup->nama }}</b></td>
                  <td class="px-2"><b class="block truncate text-[12px] font-medium text-slate-700">{{ $sup->pic ?? '-' }}</b></td>
                  <td class="px-2 text-slate-600">{{ $sup->telepon ?? '-' }}</td>
                  <td class="px-2 truncate text-slate-500">{{ $sup->email ?? '-' }}</td>
                  <td class="px-2 truncate text-slate-500">{{ $sup->kota ? $sup->kota . ($sup->alamat ? ', ' . $sup->alamat : '') : '-' }}</td>
                  <td class="px-2"><span class="rounded bg-blue-50 px-2 py-1 text-[10.5px] text-slate-600">{{ optional($sup->hub)->code ?? '-' }}</span></td>
                  <td class="px-2"><span class="rounded-full px-2.5 py-1 text-[10.5px] font-semibold {{ $sup->status ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ $sup->status ? 'Aktif' : 'Nonaktif' }}</span></td>
                </tr>
                @empty
                <tr>
                  <td colspan="8" class="px-4 py-10 text-center">
                    <i data-lucide="search-x" class="h-8 w-8 text-slate-300 mx-auto"></i>
                    <p class="mt-2 text-[12.5px] font-semibold text-slate-500">Belum ada supplier yang cocok dengan filter pada hub ini.</p>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <footer class="flex flex-wrap items-center justify-between gap-2 border-t border-slate-100 px-4 py-3 text-[12px] text-slate-600">
            <span aria-live="polite">Menampilkan {{ $suppliers->firstItem() ?? 0 }} - {{ $suppliers->lastItem() ?? 0 }} dari {{ number_format($suppliers->total()) }} supplier &bull; Hub: {{ $hubScopeLabel }}</span>
            <div class="flex items-center gap-1">
              @if($suppliers->onFirstPage())
                <span class="h-8 min-w-8 rounded bg-blue-50 px-2 text-[12px] text-slate-400">‹ Sebelumnya</span>
              @else
                <a href="{{ $suppliers->previousPageUrl() }}" class="h-8 min-w-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">‹ Sebelumnya</a>
              @endif
              @foreach($suppliers->getUrlRange(max(1, $suppliers->currentPage() - 2), min($suppliers->lastPage(), $suppliers->currentPage() + 2)) as $page => $url)
                <a href="{{ $url }}" class="h-8 min-w-8 rounded px-2 text-[12px] {{ $page === $suppliers->currentPage() ? 'bg-blue-600 font-semibold text-white' : 'text-slate-600 hover:bg-blue-50' }}">{{ $page }}</a>
              @endforeach
              @if($suppliers->hasMorePages())
                <a href="{{ $suppliers->nextPageUrl() }}" class="h-8 min-w-8 rounded bg-blue-50 px-2 text-[12px] text-slate-600">Selanjutnya ›</a>
              @else
                <span class="h-8 min-w-8 rounded bg-blue-50 px-2 text-[12px] text-slate-400">Selanjutnya ›</span>
              @endif
            </div>
          </footer>
        </section>

        @endif

    </main>
</div>

@if($canManage)
<div id="supplier-modal" class="fixed inset-0 z-[70] hidden items-center justify-center bg-slate-950/40 p-4">
  <form id="supplier-form" method="POST" action="{{ route('admin.data-supplier.store') }}" class="max-h-[90vh] w-full max-w-[520px] overflow-y-auto rounded-xl bg-white p-4 shadow-xl">
    @csrf
    <div class="mb-4 flex items-start justify-between">
      <div><h2 class="text-[12px] font-bold text-slate-800">Tambah Supplier Baru</h2><p class="mt-1 text-[10.5px] text-slate-500">Lengkapi informasi pemasok untuk direktori vendor.</p></div>
      <button type="button" id="close-modal" class="rounded p-1 text-slate-400 hover:bg-slate-100" aria-label="Tutup"><i data-lucide="x" class="h-4 w-4"></i></button>
    </div>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
      <label class="text-[12px] font-medium text-slate-700 sm:col-span-2">Nama perusahaan *
        <input name="nama" required maxlength="150" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="PT Contoh Nusantara">
      </label>
      <label class="text-[12px] font-medium text-slate-700">Kode supplier *
        <input name="kode" required maxlength="30" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] uppercase outline-none focus:border-blue-500" placeholder="SPL-005">
      </label>
      <label class="text-[12px] font-medium text-slate-700">Nama PIC
        <input name="pic" maxlength="100" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="Nama penanggung jawab">
      </label>
      <label class="text-[12px] font-medium text-slate-700">Email PIC
        <input name="email" type="email" maxlength="100" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="pic@perusahaan.co.id">
      </label>
      <label class="text-[12px] font-medium text-slate-700">Nomor telepon
        <input name="telepon" maxlength="30" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="+62 21 5555 0000">
      </label>
      <label class="text-[12px] font-medium text-slate-700">Kota
        <input name="kota" maxlength="100" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="Jakarta Barat">
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
      <label class="text-[12px] font-medium text-slate-700 sm:col-span-2">Alamat
        <input name="alamat" maxlength="300" class="mt-1.5 h-10 w-full rounded-md border border-slate-200 px-3 text-[12px] outline-none focus:border-blue-500" placeholder="Kawasan industri, nama jalan, blok">
      </label>
    </div>
    <div class="mt-5 flex justify-end gap-2">
      <button type="button" id="cancel-modal" class="h-10 rounded-md border border-slate-200 px-4 text-[12px] font-medium text-slate-600 hover:bg-slate-50">Batal</button>
      <button type="submit" class="h-10 rounded-md bg-blue-600 px-4 text-[12px] font-semibold text-white hover:bg-blue-700">Simpan Supplier</button>
    </div>
  </form>
</div>
@endif

<script>
    lucide.createIcons();
    const filterForm = document.querySelector('form[method="GET"]');
    document.querySelectorAll('select[name="hub"]').forEach((s) => {
        s.addEventListener('change', () => filterForm && filterForm.submit());
    });

    @if($canManage)
    const supplierModal = document.getElementById('supplier-modal');
    function closeSupplierModal() {
        supplierModal.classList.add('hidden');
        supplierModal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }
    document.getElementById('add-supplier').addEventListener('click', () => {
        supplierModal.classList.remove('hidden');
        supplierModal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    });
    ['close-modal', 'cancel-modal'].forEach((id) => document.getElementById(id).addEventListener('click', closeSupplierModal));
    supplierModal.addEventListener('click', (event) => { if (event.target === supplierModal) closeSupplierModal(); });
    document.addEventListener('keydown', (event) => { if (event.key === 'Escape' && !supplierModal.classList.contains('hidden')) closeSupplierModal(); });
    @endif
</script>
</body>
</html>
