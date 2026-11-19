<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Permintaan — HR Manager | Astro Inventory</title>

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
            $badge = match ($permintaan->status) {
                'Selesai' => 'bg-emerald-100 text-emerald-800',
                'Disetujui' => 'bg-blue-100 text-blue-700',
                'Ditolak' => 'bg-red-100 text-red-700',
                default => 'bg-amber-100 text-amber-700',
            };
        @endphp

        <section class="reveal mb-4 flex flex-wrap items-end justify-between gap-3">
            <div>
                <p class="mb-1 text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Operasional & Persetujuan <span class="text-blue-700">&gt; Detail Permintaan</span></p>
                <h1 class="text-[24px] font-bold leading-tight tracking-tight text-slate-800">Detail Permintaan {{ $permintaan->tiket }}</h1>
                <p class="mt-1.5 max-w-[620px] text-[12px] leading-relaxed text-slate-500">Informasi lengkap pengajuan dan status keputusan — data nyata dari tabel requests.</p>
            </div>
            <a href="{{ route($backRoute) }}" class="flex h-10 items-center gap-2 rounded-md bg-blue-50 px-3 text-[12px] font-semibold text-slate-700 hover:bg-blue-100" title="Kembali ke antrean persetujuan"><i data-lucide="arrow-left" class="h-4 w-4"></i>Kembali</a>
        </section>

        <section class="reveal reveal-delay-1 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="grid grid-cols-1 gap-px bg-slate-100 md:grid-cols-2">
                <div class="bg-white px-5 py-4">
                    <p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Tiket &amp; Jenis</p>
                    <p class="mt-1 text-[13px] font-bold text-blue-700">{{ $permintaan->tiket }}</p>
                    <p class="text-[12px] text-slate-600">{{ $permintaan->tipe }}</p>
                </div>
                <div class="bg-white px-5 py-4">
                    <p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Status Pengajuan</p>
                    <span class="mt-1 inline-block rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $badge }}">● {{ $permintaan->status }}</span>
                </div>
                <div class="bg-white px-5 py-4">
                    <p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Pemohon</p>
                    <p class="mt-1 text-[12px] font-medium text-slate-800">{{ optional($permintaan->user)->name ?? '-' }}</p>
                </div>
                <div class="bg-white px-5 py-4">
                    <p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Hub</p>
                    <p class="mt-1 text-[12px] font-medium text-slate-800">{{ optional($permintaan->hub)->name ?? '-' }} <span class="rounded bg-blue-50 px-2 py-0.5 text-[10.5px] text-slate-600">{{ optional($permintaan->hub)->code ?? '-' }}</span></p>
                </div>
                <div class="bg-white px-5 py-4">
                    <p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Prioritas</p>
                    <span class="mt-1 inline-block rounded-full px-2.5 py-1 text-[10.5px] font-semibold {{ $permintaan->prioritas === 'Tinggi' ? 'bg-red-50 text-red-700' : 'bg-slate-100 text-slate-600' }}">{{ $permintaan->prioritas }}</span>
                </div>
                <div class="bg-white px-5 py-4">
                    <p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Approver</p>
                    <p class="mt-1 text-[12px] font-medium text-slate-800">{{ $permintaan->approver ?? '-' }}</p>
                </div>
                <div class="bg-white px-5 py-4 md:col-span-2">
                    <p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Rincian Kebutuhan</p>
                    <p class="mt-1 text-[12px] leading-relaxed text-slate-700">{{ $permintaan->rincian ?? '-' }}</p>
                </div>
                <div class="bg-white px-5 py-4">
                    <p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Diajukan</p>
                    <p class="mt-1 text-[12px] text-slate-600">{{ $permintaan->created_at?->format('d M Y H:i') ?? '-' }}</p>
                </div>
                <div class="bg-white px-5 py-4">
                    <p class="text-[9.5px] font-semibold uppercase tracking-wide text-slate-500">Waktu Keputusan</p>
                    <p class="mt-1 text-[12px] text-slate-600">{{ $permintaan->disetujui_at?->format('d M Y H:i') ?? '-' }}</p>
                </div>
            </div>
        </section>

    </main>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>
