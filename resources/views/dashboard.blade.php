@extends('app.app')

@section('title', 'Dashboard - Astro Warehouse Intelligence')

@section('content')
<!-- HERO HEADER: Warm, human contextual greetings + Shift Handover Note -->
<section class="w-full bg-white/90 backdrop-blur-md rounded-2xl p-6 sm:p-7 border border-slate-200/70 shadow-[0_2px_16px_rgba(11,28,48,0.03)] flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 relative overflow-hidden">
<!-- Decorative ambient corner glow -->
<div class="absolute -right-16 -top-16 w-64 h-64 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
<div class="flex flex-col gap-2 z-10 max-w-3xl">
<div class="flex flex-wrap items-center gap-2.5">
<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-medium border border-emerald-200/60 shadow-xs">
<span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Operasional Normal &amp; Terkendali
          </span>
<span class="text-slate-300">•</span>
<span class="text-xs text-on-surface-variant font-mono flex items-center gap-1">
<span class="material-symbols-outlined text-[15px] text-slate-400">schedule</span>
            Shift Pagi (07:00 – 15:30 WIB)
          </span>
<span class="text-slate-300">•</span>
<span class="text-xs text-on-surface-variant flex items-center gap-1">
<span class="material-symbols-outlined text-[15px] text-secondary">dock</span>
            Gate 1 &amp; Gate 3 Aktif
          </span>
</div>
<h1 class="text-2xl sm:text-3xl font-headline font-extrabold text-on-surface tracking-tight">
          Selamat pagi, Rian! <span class="font-normal text-slate-500">Gudang Hub Cikarang DC-01 beroperasi lancar pagi ini.</span>
</h1>
<p class="text-sm text-slate-600 leading-relaxed">
          Semua jalur alokasi pallet dan put-away siap. Terdapat <span class="text-error font-semibold underline decoration-error/40 underline-offset-2">12 item stok menipis</span> yang perlu restock darurat dan <span class="text-primary font-semibold">3 persetujuan</span> membutuhkan tanda tangan Anda sebelum pergantian shift.
        </p>
</div>
<!-- Live Handover & Capacity Widget -->
<div class="flex flex-col sm:flex-row lg:flex-col xl:flex-row items-stretch sm:items-center gap-3 z-10 w-full lg:w-auto shrink-0">
<!-- Shift handover note card -->
<div class="px-4 py-3 rounded-xl bg-surface-container-low border border-slate-200/80 flex items-center gap-3 shadow-xs">
<div class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-[18px]">handshake</span>
</div>
<div class="flex flex-col">
<span class="text-[11px] uppercase tracking-wider text-on-surface-variant font-semibold">Catatan Handover</span>
<span class="text-xs font-headline font-bold text-on-surface">Serah terima shift pukul 15:30</span>
<span class="text-[11px] text-slate-500">Dengan Bpk. Hendra (Shift Sore)</span>
</div>
</div>
<!-- Warehouse capacity quick dial -->
<div class="px-4 py-3 rounded-xl bg-surface-container-low border border-slate-200/80 flex items-center gap-3 shadow-xs">
<div class="relative w-9 h-9 flex items-center justify-center shrink-0">
<svg class="w-9 h-9 -rotate-90" viewbox="0 0 36 36">
<path class="text-slate-200" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3.5"></path>
<path class="text-primary stroke-current" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke-dasharray="82.4, 100" stroke-linecap="round" stroke-width="3.5"></path>
</svg>
<span class="absolute text-[10px] font-mono font-bold text-on-surface">82%</span>
</div>
<div class="flex flex-col">
<span class="text-[11px] uppercase tracking-wider text-on-surface-variant font-semibold">Kapasitas Rak</span>
<span class="text-xs font-headline font-bold text-on-surface">82.4% Terisi Penuh</span>
<span class="text-[11px] text-slate-500">1,240 slot pallet tersisa</span>
</div>
</div>
</div>
</section>
<!-- SPOTLIGHT COMMAND BAR: Linear / Raycast Style Search Experience -->
<section class="w-full">
<div class="bg-white/95 rounded-2xl p-4 sm:p-5 border border-slate-200/70 shadow-[0_4px_24px_rgba(11,28,48,0.04)] flex flex-col gap-4">
<!-- Search input box with floating feel -->
<div class="flex flex-col md:flex-row items-stretch md:items-center gap-3">
<div class="flex-1 relative flex items-center">
<div class="absolute left-4 flex items-center pointer-events-none text-slate-400">
<span class="material-symbols-outlined text-[22px]">search</span>
</div>
<input class="w-full h-12 pl-12 pr-28 rounded-xl bg-slate-50/80 border border-slate-200/80 text-on-surface placeholder:text-slate-400 text-sm font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" id="globalSearchInput" placeholder="Cari SKU (misal: AST-8821), nama barang, kategori, atau lokasi rak gudang..." type="text"/>
<div class="absolute right-3.5 flex items-center gap-1.5">
<kbd class="hidden sm:inline-flex items-center px-2 py-1 bg-white border border-slate-200/80 text-slate-500 font-mono text-[11px] rounded shadow-2xs font-semibold">
                ⌘K
              </kbd>
</div>
</div>
<!-- Secondary Filters & Instant Search Action -->
<div class="flex flex-wrap items-center gap-2">
<!-- Category Dropdown -->
<div class="relative">
<select class="h-12 pl-3.5 pr-8 rounded-xl bg-slate-50/80 border border-slate-200/80 text-xs font-headline font-medium text-on-surface appearance-none cursor-pointer focus:outline-none focus:bg-white focus:ring-2 focus:ring-primary/20 transition-all">
<option value="">Semua Kategori</option>
<option value="sembako">Bahan Pokok &amp; Beras</option>
<option value="minuman">Minuman &amp; Dairy</option>
<option value="minyak">Minyak &amp; Lemak</option>
<option value="pembersih">Perawatan &amp; Kebersihan</option>
<option value="snack">Camilan &amp; Instan</option>
</select>
<span class="material-symbols-outlined absolute right-2.5 top-3.5 text-[18px] text-slate-400 pointer-events-none">expand_more</span>
</div>
<!-- Zone Rack Dropdown -->
<div class="relative">
<select class="h-12 pl-3.5 pr-8 rounded-xl bg-slate-50/80 border border-slate-200/80 text-xs font-headline font-medium text-on-surface appearance-none cursor-pointer focus:outline-none focus:bg-white focus:ring-2 focus:ring-primary/20 transition-all">
<option value="">Semua Zona Rak</option>
<option value="A">Zona A (Fast-Moving Sembako)</option>
<option value="B">Zona B (Dairy &amp; Minuman Dingin)</option>
<option value="C">Zona C (Bahan Kering &amp; Tepung)</option>
<option value="D">Zona D (Homecare &amp; Sabun)</option>
<option value="E">Zona E (Buffer Stock &amp; Pallet)</option>
</select>
<span class="material-symbols-outlined absolute right-2.5 top-3.5 text-[18px] text-slate-400 pointer-events-none">expand_more</span>
</div>
<!-- Stock Status Dropdown -->
<div class="relative">
<select class="h-12 pl-3.5 pr-8 rounded-xl bg-slate-50/80 border border-slate-200/80 text-xs font-headline font-medium text-on-surface appearance-none cursor-pointer focus:outline-none focus:bg-white focus:ring-2 focus:ring-primary/20 transition-all">
<option value="">Status Stok</option>
<option value="safe">Tersedia (Aman)</option>
<option value="low">Menipis (&lt;20%)</option>
<option value="empty">Habis / Out of Stock</option>
<option value="over">Overstock</option>
</select>
<span class="material-symbols-outlined absolute right-2.5 top-3.5 text-[18px] text-slate-400 pointer-events-none">expand_more</span>
</div>
<button class="h-12 px-5 bg-primary hover:bg-primary-container text-white font-headline font-semibold text-xs rounded-xl flex items-center gap-2 shadow-sm shadow-primary/25 transition-all active:scale-[0.98]">
<span class="material-symbols-outlined text-[18px]">search</span>
<span>Cari Sekarang</span>
</button>
<button class="h-12 px-4 bg-surface-container-low hover:bg-surface-container text-primary border border-primary/20 font-headline font-semibold text-xs rounded-xl flex items-center gap-2 transition-all active:scale-[0.98]" onclick="triggerScannerModal()">
<span class="material-symbols-outlined text-[18px]">qr_code_scanner</span>
<span>Scan Barcode</span>
</button>
</div>
</div>
<!-- Quick Tag Chips + Scanner Status Pill -->
<div class="flex flex-wrap items-center justify-between gap-3 pt-1 border-t border-slate-100 text-xs">
<div class="flex flex-wrap items-center gap-1.5">
<span class="text-slate-400 font-medium mr-1 text-[11px] uppercase tracking-wider">Pencarian Cepat:</span>
<button class="px-2.5 py-1 rounded-full bg-slate-100/90 hover:bg-primary-fixed hover:text-primary text-slate-600 font-medium text-xs transition-colors" onclick="applyTagSearch('Beras')">
              #Beras Premium
            </button>
<button class="px-2.5 py-1 rounded-full bg-slate-100/90 hover:bg-primary-fixed hover:text-primary text-slate-600 font-medium text-xs transition-colors" onclick="applyTagSearch('Minyak')">
              #Minyak 2L
            </button>
<button class="px-2.5 py-1 rounded-full bg-slate-100/90 hover:bg-primary-fixed hover:text-primary text-slate-600 font-medium text-xs transition-colors" onclick="applyTagSearch('UHT')">
              #Susu UHT
            </button>
<button class="px-2.5 py-1 rounded-full bg-slate-100/90 hover:bg-primary-fixed hover:text-primary text-slate-600 font-medium text-xs transition-colors" onclick="applyTagSearch('Kopi')">
              #Kopi Robusta
            </button>
<button class="px-2.5 py-1 rounded-full bg-slate-100/90 hover:bg-primary-fixed hover:text-primary text-slate-600 font-medium text-xs transition-colors" onclick="applyTagSearch('Rak B')">
              #Rak-B-04
            </button>
</div>
<div class="flex items-center gap-3 text-slate-500 font-medium">
<div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100/80 border border-slate-200/50">
<span class="w-2 h-2 rounded-full bg-emerald-500"></span>
<span class="text-[11px] text-slate-600">Scanner Zebra TC26: <strong class="text-on-surface">Terkoneksi</strong></span>
</div>
<button class="flex items-center gap-1 text-primary hover:text-primary-container transition-colors text-[11px] font-semibold" onclick="quickRefresh()">
<span class="material-symbols-outlined text-[15px]" id="refreshIcon">sync</span>
<span>Sinkronisasi Data</span>
</button>
</div>
</div>
</div>
</section>
<!-- DYNAMIC ASYMMETRICAL KPI METRIC GRID -->
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4">
<!-- KPI 1: Total SKU (3 Cols) -->
<div class="lg:col-span-3 bg-white rounded-2xl p-5 border border-slate-200/70 shadow-[0_2px_12px_rgba(11,28,48,0.02)] flex flex-col justify-between hover:shadow-md transition-shadow group">
<div class="flex items-center justify-between">
<div class="flex items-center gap-2">
<div class="w-8 h-8 rounded-xl bg-blue-50 text-primary flex items-center justify-center">
<span class="material-symbols-outlined text-[18px]">inventory_2</span>
</div>
<span class="text-[11px] uppercase tracking-wider text-slate-500 font-semibold">Total Item SKU</span>
</div>
<span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-mono font-semibold border border-emerald-200/50">+3.4% bln ini</span>
</div>
<div class="my-4">
<div class="flex items-baseline gap-2">
<span class="font-headline font-extrabold text-3xl text-on-surface tracking-tight">14,820</span>
<span class="text-xs font-semibold text-slate-400">SKU Aktif</span>
</div>
<div class="w-full bg-slate-100 h-1.5 rounded-full mt-3 overflow-hidden">
<div class="bg-primary h-full rounded-full transition-all duration-500" style="width: 88%"></div>
</div>
</div>
<div class="flex items-center justify-between text-xs text-slate-500 pt-2 border-t border-slate-100">
<span>Tersebar di 6 Zona Hub</span>
<span class="font-mono text-[11px] text-primary font-medium">88% Alokasi Rak</span>
</div>
</div>
<!-- KPI 2: Inbound Today (2 Cols) -->
<div class="lg:col-span-2 bg-white rounded-2xl p-5 border border-slate-200/70 shadow-[0_2px_12px_rgba(11,28,48,0.02)] flex flex-col justify-between hover:shadow-md transition-shadow group">
<div class="flex items-center justify-between">
<div class="flex items-center gap-2">
<div class="w-8 h-8 rounded-xl bg-sky-50 text-secondary flex items-center justify-center">
<span class="material-symbols-outlined text-[18px]">move_to_inbox</span>
</div>
<span class="text-[11px] uppercase tracking-wider text-slate-500 font-semibold">Barang Masuk</span>
</div>
<span class="px-2 py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed-variant text-[10px] font-mono font-bold">INBOUND</span>
</div>
<div class="my-4">
<div class="flex items-baseline gap-1.5">
<span class="font-headline font-extrabold text-3xl text-secondary tracking-tight">1,240</span>
<span class="text-xs font-semibold text-slate-400">Box</span>
</div>
<div class="w-full bg-slate-100 h-1.5 rounded-full mt-3 overflow-hidden">
<div class="bg-secondary h-full rounded-full transition-all duration-500" style="width: 72%"></div>
</div>
</div>
<div class="flex items-center justify-between text-xs text-slate-500 pt-2 border-t border-slate-100">
<span><strong class="text-on-surface">18 PO</strong> selesai unbox</span>
<span class="font-mono text-[11px] text-secondary font-medium">72% Goal</span>
</div>
</div>
<!-- KPI 3: Outbound Today (2 Cols) -->
<div class="lg:col-span-2 bg-white rounded-2xl p-5 border border-slate-200/70 shadow-[0_2px_12px_rgba(11,28,48,0.02)] flex flex-col justify-between hover:shadow-md transition-shadow group">
<div class="flex items-center justify-between">
<div class="flex items-center gap-2">
<div class="w-8 h-8 rounded-xl bg-indigo-50 text-primary-container flex items-center justify-center">
<span class="material-symbols-outlined text-[18px]">local_shipping</span>
</div>
<span class="text-[11px] uppercase tracking-wider text-slate-500 font-semibold">Barang Keluar</span>
</div>
<span class="px-2 py-0.5 rounded-full bg-tertiary-fixed text-tertiary text-[10px] font-mono font-bold">OUTBOUND</span>
</div>
<div class="my-4">
<div class="flex items-baseline gap-1.5">
<span class="font-headline font-extrabold text-3xl text-primary-container tracking-tight">3,450</span>
<span class="text-xs font-semibold text-slate-400">Item</span>
</div>
<div class="w-full bg-slate-100 h-1.5 rounded-full mt-3 overflow-hidden">
<div class="bg-primary-container h-full rounded-full transition-all duration-500" style="width: 91%"></div>
</div>
</div>
<div class="flex items-center justify-between text-xs text-slate-500 pt-2 border-t border-slate-100">
<span><strong class="text-on-surface">42 DO</strong> ke Armada</span>
<span class="font-mono text-[11px] text-primary-container font-medium">91% Goal</span>
</div>
</div>
<!-- KPI 4: Pending Approval (2 Cols) -->
<div class="lg:col-span-2 bg-white rounded-2xl p-5 border border-slate-200/70 shadow-[0_2px_12px_rgba(11,28,48,0.02)] flex flex-col justify-between hover:shadow-md transition-shadow group">
<div class="flex items-center justify-between">
<div class="flex items-center gap-2">
<div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
<span class="material-symbols-outlined text-[18px]">pending_actions</span>
</div>
<span class="text-[11px] uppercase tracking-wider text-slate-500 font-semibold">Persetujuan</span>
</div>
<span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[10px] font-mono font-bold border border-amber-200/50">PENDING</span>
</div>
<div class="my-4">
<div class="flex items-baseline gap-1.5">
<span class="font-headline font-extrabold text-3xl text-on-surface tracking-tight">7</span>
<span class="text-xs font-semibold text-slate-400">Tiket</span>
</div>
<div class="w-full bg-slate-100 h-1.5 rounded-full mt-3 overflow-hidden">
<div class="bg-amber-500 h-full rounded-full transition-all duration-500" style="width: 45%"></div>
</div>
</div>
<div class="flex items-center justify-between text-xs text-slate-500 pt-2 border-t border-slate-100">
<span>Mutasi &amp; Purchase</span>
<span class="font-mono text-[11px] text-amber-600 font-semibold">3 Butuh Aksi</span>
</div>
</div>
<!-- KPI 5: Modern Critical Stock Alert Card (3 Cols - Featured Gradient) -->
<div class="lg:col-span-3 bg-gradient-to-br from-rose-50 via-white to-red-50/70 rounded-2xl p-5 border border-rose-200/80 shadow-[0_2px_14px_rgba(186,26,26,0.06)] flex flex-col justify-between hover:shadow-md transition-shadow relative overflow-hidden">
<div class="absolute -right-4 -bottom-4 w-24 h-24 bg-rose-500/5 rounded-full blur-xl pointer-events-none"></div>
<div class="flex items-center justify-between z-10">
<div class="flex items-center gap-2">
<div class="w-8 h-8 rounded-xl bg-red-100/80 text-error flex items-center justify-center">
<span class="material-symbols-outlined text-[18px]">warning</span>
</div>
<span class="text-[11px] uppercase tracking-wider text-error font-bold">Peringatan Kritis</span>
</div>
<span class="px-2 py-0.5 rounded-full bg-rose-100 text-error font-mono text-[10px] font-bold border border-rose-200/60 animate-pulse">
            URGENT
          </span>
</div>
<div class="my-4 z-10">
<div class="flex items-baseline gap-2">
<span class="font-headline font-extrabold text-3xl text-error tracking-tight">12</span>
<span class="text-xs font-semibold text-rose-800">SKU Menipis (&lt;20%)</span>
</div>
<div class="w-full bg-rose-100/70 h-1.5 rounded-full mt-3 overflow-hidden">
<div class="bg-error h-full rounded-full" style="width: 100%"></div>
</div>
</div>
<div class="flex items-center justify-between text-xs z-10 pt-2 border-t border-rose-200/60">
<span class="text-rose-700 font-medium flex items-center gap-1">
            Minyak &amp; Beras prioritas
          </span>
<button class="font-headline font-semibold text-[11px] text-error hover:underline flex items-center gap-0.5" onclick="filterCatalog('low')">
            Lihat Item <span class="material-symbols-outlined text-[13px]">arrow_forward</span>
</button>
</div>
</div>
</section>
<!-- QUICK ACTIONS TOOLBAR (Refined Linear-style horizontal dock) -->
<section class="w-full bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/70 shadow-[0_2px_12px_rgba(11,28,48,0.02)] flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-[20px]">bolt</span>
</div>
<div>
<h4 class="font-headline font-bold text-sm text-on-surface">Aksi Cepat Logistik Terpadu</h4>
<p class="text-xs text-slate-500">Akses instan untuk pemrosesan tiket inbound, surat jalan, dan audit harian.</p>
</div>
</div>
<div class="flex flex-wrap items-center gap-2.5 w-full md:w-auto">
<button class="flex-1 md:flex-initial h-10 px-4 rounded-xl bg-primary hover:bg-primary-container text-white font-headline font-semibold text-xs flex items-center justify-center gap-1.5 shadow-sm shadow-primary/20 transition-all active:scale-[0.98]" onclick="openActionModal('inbound')">
<span class="material-symbols-outlined text-[18px]">add_box</span>
<span>Input Barang Masuk</span>
</button>
<button class="flex-1 md:flex-initial h-10 px-4 rounded-xl bg-secondary hover:bg-on-secondary-fixed-variant text-white font-headline font-semibold text-xs flex items-center justify-center gap-1.5 shadow-sm transition-all active:scale-[0.98]" onclick="openActionModal('outbound')">
<span class="material-symbols-outlined text-[18px]">local_shipping</span>
<span>Buat Surat Jalan</span>
</button>
<button class="flex-1 md:flex-initial h-10 px-3.5 rounded-xl bg-slate-100 hover:bg-slate-200/80 text-on-surface font-headline font-semibold text-xs flex items-center justify-center gap-1.5 transition-all" onclick="openActionModal('scanner')">
<span class="material-symbols-outlined text-[18px] text-slate-600">barcode_scanner</span>
<span>Scan Barcode</span>
</button>
<button class="flex-1 md:flex-initial h-10 px-3.5 rounded-xl bg-slate-100 hover:bg-slate-200/80 text-on-surface font-headline font-semibold text-xs flex items-center justify-center gap-1.5 transition-all" onclick="downloadReport()" title="Unduh File XLSX">
<span class="material-symbols-outlined text-[18px] text-slate-600">file_download</span>
<span>Unduh Laporan</span>
</button>
</div>
</section>
<!-- DUAL LAYOUT: Dynamic Activity Stream & Approval Matrix -->
<section class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
<!-- LEFT: Live Activity Stream Timeline (7 Cols) -->
<div class="lg:col-span-7 bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/70 shadow-[0_2px_12px_rgba(11,28,48,0.02)] flex flex-col gap-5">
<div class="flex items-center justify-between pb-3 border-b border-slate-100">
<div class="flex items-center gap-2.5">
<div class="w-8 h-8 rounded-xl bg-blue-50 text-primary flex items-center justify-center">
<span class="material-symbols-outlined text-[18px]">stream</span>
</div>
<div>
<h3 class="font-headline font-bold text-base text-on-surface">Notifikasi Operasional Real-Time</h3>
<p class="text-[11px] text-slate-500">Live feed aktivitas gudang dan perpindahan muatan</p>
</div>
</div>
<!-- Filter pill tabs -->
<div class="flex items-center gap-1 bg-slate-100 p-0.5 rounded-lg text-xs font-headline">
<button class="px-3 py-1 rounded-md font-semibold bg-white text-primary shadow-2xs" id="tabInboundBtn" onclick="switchNotifTab('all')">Semua</button>
<button class="px-3 py-1 rounded-md text-slate-600 hover:text-on-surface font-medium" id="tabInboundFilter" onclick="switchNotifTab('inbound')">Inbound</button>
<button class="px-3 py-1 rounded-md text-slate-600 hover:text-on-surface font-medium" id="tabOutboundFilter" onclick="switchNotifTab('outbound')">Outbound</button>
</div>
</div>
<!-- Feed List with Human Avatars and Clear Context -->
<div class="space-y-3" id="notifContainer">
<!-- Activity Item 1: Inbound -->
<div class="notif-item inbound p-4 rounded-xl bg-slate-50/70 hover:bg-blue-50/40 border border-slate-200/60 hover:border-blue-200/60 transition-all flex items-start justify-between gap-4 group">
<div class="flex items-start gap-3.5">
<!-- Human checker avatar -->
<div class="relative shrink-0">
<div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-500 to-primary text-white font-headline font-bold text-xs flex items-center justify-center shadow-xs">
                  BS
                </div>
<div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-secondary text-white flex items-center justify-center ring-2 ring-white text-[9px]">
<span class="material-symbols-outlined text-[10px]">archive</span>
</div>
</div>
<div class="flex flex-col gap-1">
<div class="flex flex-wrap items-center gap-2">
<span class="font-headline font-bold text-sm text-on-surface group-hover:text-primary transition-colors">
                    Inbound PO #AST-INB-9921 Selesai Dibongkar
                  </span>
<span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-semibold font-mono border border-emerald-200/60">
                    Diterima
                  </span>
</div>
<p class="text-xs text-slate-600 leading-relaxed">
                  Pengiriman dari <strong class="text-on-surface font-semibold">PT Sinar Logistik</strong> di Dock 3 selesai diverifikasi. Muatan: <span class="font-medium text-on-surface">500 unit Susu UHT 1000ml</span> telah masuk ke palet buffer.
                </p>
<div class="flex flex-wrap items-center gap-3 pt-1.5 text-[11px] text-slate-500">
<span class="flex items-center gap-1 font-mono text-slate-400">
<span class="material-symbols-outlined text-[13px]">schedule</span> 10 menit lalu
                  </span>
<span>•</span>
<span>Petugas: <strong class="text-on-surface font-medium">Budi Santoso (Checker Dock 3)</strong></span>
</div>
</div>
</div>
<button class="shrink-0 p-1.5 rounded-lg hover:bg-white text-slate-400 hover:text-primary transition-colors" title="Lihat Manifest">
<span class="material-symbols-outlined text-[20px]">chevron_right</span>
</button>
</div>
<!-- Activity Item 2: Outbound -->
<div class="notif-item outbound p-4 rounded-xl bg-slate-50/70 hover:bg-indigo-50/40 border border-slate-200/60 hover:border-indigo-200/60 transition-all flex items-start justify-between gap-4 group">
<div class="flex items-start gap-3.5">
<div class="relative shrink-0">
<div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-tertiary-container text-white font-headline font-bold text-xs flex items-center justify-center shadow-xs">
                  AR
                </div>
<div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-indigo-600 text-white flex items-center justify-center ring-2 ring-white text-[9px]">
<span class="material-symbols-outlined text-[10px]">unarchive</span>
</div>
</div>
<div class="flex flex-col gap-1">
<div class="flex flex-wrap items-center gap-2">
<span class="font-headline font-bold text-sm text-on-surface group-hover:text-primary-container transition-colors">
                    Outbound DO #AST-OUT-4410 Dalam Proses Loading
                  </span>
<span class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[10px] font-semibold font-mono border border-blue-200/60">
                    Sedang Dimuat
                  </span>
</div>
<p class="text-xs text-slate-600 leading-relaxed">
                  Alokasi distribusi untuk <strong class="text-on-surface font-semibold">Hub Jakarta Selatan</strong> sedang dilakukan staging di Dock 1. Total muatan: <span class="font-medium text-on-surface">320 karton sembako dan minyak</span>.
                </p>
<div class="flex flex-wrap items-center gap-3 pt-1.5 text-[11px] text-slate-500">
<span class="flex items-center gap-1 font-mono text-slate-400">
<span class="material-symbols-outlined text-[13px]">schedule</span> 25 menit lalu
                  </span>
<span>•</span>
<span>Armada: <strong class="text-on-surface font-medium">Isuzu Giga (B 9812 UIK)</strong></span>
</div>
</div>
</div>
<button class="shrink-0 p-1.5 rounded-lg hover:bg-white text-slate-400 hover:text-primary transition-colors" title="Lihat Manifest">
<span class="material-symbols-outlined text-[20px]">chevron_right</span>
</button>
</div>
<!-- Activity Item 3: Put-away -->
<div class="notif-item inbound p-4 rounded-xl bg-slate-50/70 hover:bg-emerald-50/40 border border-slate-200/60 hover:border-emerald-200/60 transition-all flex items-start justify-between gap-4 group">
<div class="flex items-start gap-3.5">
<div class="relative shrink-0">
<div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-teal-500 to-emerald-600 text-white font-headline font-bold text-xs flex items-center justify-center shadow-xs">
                  AF
                </div>
<div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-teal-600 text-white flex items-center justify-center ring-2 ring-white text-[9px]">
<span class="material-symbols-outlined text-[10px]">shelves</span>
</div>
</div>
<div class="flex flex-col gap-1">
<div class="flex flex-wrap items-center gap-2">
<span class="font-headline font-bold text-sm text-on-surface group-hover:text-primary transition-colors">
                    Put-away Rak Selesai: SKU-AST-FD-0012
                  </span>
<span class="px-2 py-0.5 rounded-full bg-teal-50 text-teal-700 text-[10px] font-semibold font-mono border border-teal-200/60">
                    Selesai Rak
                  </span>
</div>
<p class="text-xs text-slate-600 leading-relaxed">
                  Sebanyak 150 sak <strong class="text-on-surface font-semibold">Beras Premium Astro 5kg</strong> berhasil dialokasikan ke Zona Rak B-04-A level 2 tanpa deviasi.
                </p>
<div class="flex flex-wrap items-center gap-3 pt-1.5 text-[11px] text-slate-500">
<span class="flex items-center gap-1 font-mono text-slate-400">
<span class="material-symbols-outlined text-[13px]">schedule</span> 42 menit lalu
                  </span>
<span>•</span>
<span>Forklift Driver: <strong class="text-on-surface font-medium">Ahmad Fauzi</strong></span>
</div>
</div>
</div>
<button class="shrink-0 p-1.5 rounded-lg hover:bg-white text-slate-400 hover:text-primary transition-colors" title="Lihat Manifest">
<span class="material-symbols-outlined text-[20px]">chevron_right</span>
</button>
</div>
</div>
</div>
<!-- RIGHT: Human Approval Workflow Matrix (5 Cols) -->
<div class="lg:col-span-5 bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/70 shadow-[0_2px_12px_rgba(11,28,48,0.02)] flex flex-col gap-5">
<div class="flex items-center justify-between pb-3 border-b border-slate-100">
<div class="flex items-center gap-2.5">
<div class="w-8 h-8 rounded-xl bg-indigo-50 text-secondary flex items-center justify-center">
<span class="material-symbols-outlined text-[18px]">rule_folder</span>
</div>
<div>
<h3 class="font-headline font-bold text-base text-on-surface">Alur Persetujuan Barang</h3>
<p class="text-[11px] text-slate-500">Otorisasi tiket mutasi stok dan PO darurat</p>
</div>
</div>
<span class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 font-mono text-[11px] font-bold border border-amber-200/60">
            3 Butuh Tindakan
          </span>
</div>
<div class="space-y-3.5">
<!-- Interactive Action Card 1: Needs Supervisor Approval -->
<div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/80 flex flex-col gap-3 transition-all hover:bg-slate-50" id="approvalCard1">
<div class="flex items-start justify-between gap-3">
<div class="flex flex-col">
<span class="font-headline font-bold text-sm text-on-surface">Permintaan Restock SKU-4019</span>
<span class="text-xs text-slate-600 font-medium">Minyak Goreng 2L • 200 Karton</span>
</div>
<span class="px-2.5 py-0.5 rounded-full bg-amber-100/70 text-amber-800 text-[10px] font-semibold font-mono border border-amber-200">
                Menunggu Supervisor
              </span>
</div>
<div class="p-3 bg-white rounded-lg border border-slate-200/60 text-xs text-slate-600 flex items-center justify-between">
<span class="flex items-center gap-1.5 text-slate-600">
<span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                Alasan: Safety stock menipis di bawah 15%
              </span>
<span class="font-mono text-primary font-bold text-[11px]">Req #AP-881</span>
</div>
<!-- Tactile Approval Buttons -->
<div class="flex items-center justify-end gap-2 pt-1">
<button class="h-8 px-3.5 rounded-lg border border-slate-300 hover:bg-rose-50 hover:text-rose-700 hover:border-rose-200 text-slate-700 font-headline font-semibold text-xs flex items-center gap-1.5 transition-colors" onclick="handleApproval('approvalCard1', false)" type="button">
<span class="material-symbols-outlined text-[15px]">close</span>
<span>Tolak</span>
</button>
<button class="h-8 px-4 rounded-lg bg-primary hover:bg-primary-container text-white font-headline font-semibold text-xs flex items-center gap-1.5 shadow-sm shadow-primary/20 transition-all active:scale-[0.98]" onclick="handleApproval('approvalCard1', true)" type="button">
<span class="material-symbols-outlined text-[15px]">check</span>
<span>Setujui</span>
</button>
</div>
</div>
<!-- Already Approved Item Card -->
<div class="p-4 rounded-xl bg-emerald-50/40 border border-emerald-200/60 flex flex-col gap-2">
<div class="flex items-start justify-between gap-2">
<div class="flex flex-col">
<span class="font-headline font-bold text-sm text-on-surface">Penyesuaian Stok Rusak SKU-8812</span>
<span class="text-xs text-slate-600">Kerusakan Packaging Saat Transit (8 Box)</span>
</div>
<span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-semibold font-mono flex items-center gap-1">
<span class="material-symbols-outlined text-[13px]">done_all</span> Disetujui
              </span>
</div>
<div class="text-[11px] text-slate-500 flex items-center gap-1.5 pt-1 border-t border-emerald-200/40">
<span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
<span>Disetujui oleh <strong class="text-on-surface font-semibold">Bpk. Hendra</strong> (Manajer Ops) • 1 Jam lalu</span>
</div>
</div>
<!-- Rejected Item Card -->
<div class="p-4 rounded-xl bg-rose-50/40 border border-rose-200/60 flex flex-col gap-2">
<div class="flex items-start justify-between gap-2">
<div class="flex flex-col">
<span class="font-headline font-bold text-sm text-on-surface">Pengeluaran Event Promo #EV-88</span>
<span class="text-xs text-slate-600">Alokasi Merchandise &amp; Kopi Robusta 250g</span>
</div>
<span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-800 text-[10px] font-semibold font-mono flex items-center gap-1">
<span class="material-symbols-outlined text-[13px]">block</span> Ditolak
              </span>
</div>
<div class="text-[11px] text-rose-700 font-medium flex items-center gap-1.5 pt-1 border-t border-rose-200/40">
<span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
<span>Alasan: Kuota alokasi marketing habis untuk batch minggu ini.</span>
</div>
</div>
</div>
</div>
</section>
<!-- WAREHOUSE PRODUCT CATALOG: Modern Stripe/Shopify Data Table -->
<section class="w-full bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/70 shadow-[0_2px_16px_rgba(11,28,48,0.03)] flex flex-col gap-5">
<!-- Catalog Header & Modern Filter Tabs -->
<div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 pb-2 border-b border-slate-100">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-xl bg-blue-50 text-primary flex items-center justify-center shrink-0">
<span class="material-symbols-outlined text-[22px]">inventory</span>
</div>
<div>
<div class="flex items-center gap-2">
<h2 class="font-headline font-bold text-lg text-on-surface">Katalog Produk Gudang</h2>
<span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-xs font-mono font-medium">14,820 Total SKU</span>
</div>
<p class="text-xs text-slate-500">Peta ketersediaan inventori fisik, kapasitas rak penyimpanan, dan kontrol pesanan real-time.</p>
</div>
</div>
<!-- Filter Sub-Tabs -->
<div class="flex flex-wrap items-center gap-1 bg-slate-100/90 p-1 rounded-xl">
<button class="px-3.5 py-1.5 rounded-lg text-xs font-headline font-semibold bg-white text-primary shadow-xs transition-all" id="btnCatAll" onclick="filterCatalog('all')">
            Semua Produk
          </button>
<button class="px-3.5 py-1.5 rounded-lg text-xs font-headline font-medium text-slate-600 hover:text-on-surface hover:bg-white/60 transition-all" id="btnCatFast" onclick="filterCatalog('fast')">
            Fast Moving
          </button>
<button class="px-3.5 py-1.5 rounded-lg text-xs font-headline font-medium text-slate-600 hover:text-on-surface hover:bg-white/60 transition-all flex items-center gap-1" id="btnCatLow" onclick="filterCatalog('low')">
<span>Stok Menipis</span>
<span class="w-1.5 h-1.5 rounded-full bg-error"></span>
</button>
<button class="px-3.5 py-1.5 rounded-lg text-xs font-headline font-medium text-slate-600 hover:text-on-surface hover:bg-white/60 transition-all" id="btnCatNew" onclick="filterCatalog('new')">
            Baru Masuk
          </button>
</div>
</div>
<!-- High-Density Catalog Table with Smooth Hover & Polish -->
<div class="w-full overflow-x-auto custom-scroll">
<table class="w-full text-left border-collapse min-w-[960px]">
<thead>
<tr class="border-b border-slate-200/80 text-[11px] font-headline font-bold uppercase tracking-wider text-slate-400">
<th class="py-3 px-3">Produk &amp; SKU</th>
<th class="py-3 px-3">Kategori</th>
<th class="py-3 px-3">Lokasi Rak</th>
<th class="py-3 px-3 text-right">Fisik / Tersedia</th>
<th class="py-3 px-3 text-right">Terpesan</th>
<th class="py-3 px-4 w-48">Kapasitas Maksimal</th>
<th class="py-3 px-3">Status</th>
<th class="py-3 px-3 text-center">Aksi Cepat</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-100 text-xs" id="catalogTableBody">
<!-- Row 1: Beras Premium -->
<tr class="hover:bg-blue-50/30 transition-colors group" data-category="fast">
<td class="py-3.5 px-3">
<div class="flex items-center gap-3">
<div class="w-11 h-11 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200/60 p-0.5">
<img class="w-full h-full object-cover rounded-lg" data-alt="Modern crisp packaging bag of Astro Premium Rice five kilograms" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDTgLrKmUL9pnPf_03O2fNLGsqptnwX2v9asspFxS-SkDngZGuFutNlZLramBYREJaUar8qwDgL1cadou2RlyH5iQEgnNOg_ZAclh9E7dmR9sNEGRlJYk9wH4NAOawUfDAXHGDIHMyBxo8Ms02QXk65phpT4l6hdrwD4HDW77Z5zbM9ORPZEm--qzcVctp3Q8VcqulC5dPyyc-fu1Kq8yHZV589vsPmCGyAiN4ae26TA6qwtkrvbSm-vA"/>
</div>
<div class="flex flex-col">
<span class="font-headline font-bold text-sm text-on-surface group-hover:text-primary transition-colors">Beras Premium Astro Fresh 5kg</span>
<span class="font-mono text-[11px] text-primary font-semibold">AST-FD-0012</span>
</div>
</div>
</td>
<td class="py-3.5 px-3 text-slate-600 font-medium">Bahan Pokok &amp; Beras</td>
<td class="py-3.5 px-3">
<span class="px-2.5 py-1 rounded-md bg-slate-100 font-mono text-[11px] font-semibold text-slate-700 border border-slate-200/60">
                  Rak B-04-A
                </span>
</td>
<td class="py-3.5 px-3 text-right font-mono font-bold text-sm text-on-surface">
                1,420 <span class="font-sans text-xs text-slate-400 font-normal">Sak</span>
</td>
<td class="py-3.5 px-3 text-right font-mono text-slate-500">
                180 Sak
              </td>
<td class="py-3.5 px-4">
<div class="flex flex-col gap-1.5">
<div class="flex justify-between text-[10px] font-mono font-medium text-slate-500">
<span>78%</span>
<span class="text-slate-400">Max: 1,800</span>
</div>
<div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
<div class="bg-primary h-full rounded-full" style="width: 78%"></div>
</div>
</div>
</td>
<td class="py-3.5 px-3">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-medium border border-emerald-200/60">
<span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Stok Aman
                </span>
</td>
<td class="py-3.5 px-3 text-center">
<div class="inline-flex items-center gap-1">
<button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-primary transition-colors" onclick="alert('Detail SKU: AST-FD-0012')" title="Lihat Detail">
<span class="material-symbols-outlined text-[18px]">visibility</span>
</button>
<button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-secondary transition-colors" onclick="alert('Menu penyesuaian stok')" title="Sesuaikan Stok">
<span class="material-symbols-outlined text-[18px]">edit_note</span>
</button>
<button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-on-surface transition-colors" onclick="alert('Cetak label barcode zebra')" title="Cetak Barcode">
<span class="material-symbols-outlined text-[18px]">print</span>
</button>
</div>
</td>
</tr>
<!-- Row 2: Susu UHT -->
<tr class="hover:bg-blue-50/30 transition-colors group" data-category="new">
<td class="py-3.5 px-3">
<div class="flex items-center gap-3">
<div class="w-11 h-11 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200/60 p-0.5">
<img class="w-full h-full object-cover rounded-lg" data-alt="Sterile UHT milk carton box one liter container" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD55V6mSUocw1kOwzPTNCf6RJkrIowagen_ju1QPBjLOlTi94liOzIQdoH1OmIoIqNupduGIcIZolkGyrSQsec5Uxr_XpJwr50RAbwz3H45liN79suhGci400BCfY8Jc3luxSEZAxdJCzoMykOjOiNV6xwW5AvBCXYiRAZTg2bkiBAD_5UiWRJ5cAVQ-pDXmUYIUJJ0ZUOEuxekRtYa1NOoUd1OIvDg2htdXRoSi_zUsW6HefGvJ5UgCg"/>
</div>
<div class="flex flex-col">
<span class="font-headline font-bold text-sm text-on-surface group-hover:text-primary transition-colors">Susu Steril UHT 1000ml</span>
<span class="font-mono text-[11px] text-primary font-semibold">AST-BV-9941</span>
</div>
</div>
</td>
<td class="py-3.5 px-3 text-slate-600 font-medium">Minuman &amp; Dairy</td>
<td class="py-3.5 px-3">
<span class="px-2.5 py-1 rounded-md bg-slate-100 font-mono text-[11px] font-semibold text-slate-700 border border-slate-200/60">
                  Rak C-12-B
                </span>
</td>
<td class="py-3.5 px-3 text-right font-mono font-bold text-sm text-on-surface">
                2,100 <span class="font-sans text-xs text-slate-400 font-normal">Pcs</span>
</td>
<td class="py-3.5 px-3 text-right font-mono text-slate-500">
                500 Pcs
              </td>
<td class="py-3.5 px-4">
<div class="flex flex-col gap-1.5">
<div class="flex justify-between text-[10px] font-mono font-medium text-slate-500">
<span>84%</span>
<span class="text-slate-400">Max: 2,500</span>
</div>
<div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
<div class="bg-secondary h-full rounded-full" style="width: 84%"></div>
</div>
</div>
</td>
<td class="py-3.5 px-3">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-50 text-primary text-[11px] font-medium border border-blue-200/60">
<span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Baru Masuk
                </span>
</td>
<td class="py-3.5 px-3 text-center">
<div class="inline-flex items-center gap-1">
<button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-primary transition-colors" title="Lihat Detail">
<span class="material-symbols-outlined text-[18px]">visibility</span>
</button>
<button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-secondary transition-colors" title="Sesuaikan Stok">
<span class="material-symbols-outlined text-[18px]">edit_note</span>
</button>
<button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-on-surface transition-colors" title="Cetak Barcode">
<span class="material-symbols-outlined text-[18px]">print</span>
</button>
</div>
</td>
</tr>
<!-- Row 3: Minyak Goreng (Low Stock - Soft Tinted Warning Row) -->
<tr class="bg-rose-50/40 hover:bg-rose-50/70 transition-colors group" data-category="low">
<td class="py-3.5 px-3">
<div class="flex items-center gap-3">
<div class="w-11 h-11 rounded-xl bg-white overflow-hidden shrink-0 border border-rose-200/70 p-0.5 shadow-2xs">
<img class="w-full h-full object-cover rounded-lg" data-alt="Golden refined palm cooking oil pouch bottle 1 liter" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDSpcNgKs466xGHtNq2YJQvs6yecU6LO2uZK_VpeHR1rgZqybL98FISZDNNILMfSIzI6eJrlGlr5ERPoGESo_TXoAFjv7YPiJjG0QIv2ja1-sbm6Uv4ZcRCRj341aBglP7FiIjUnto7mnlRtTiq5gzn1bRc55hivCVsUL7buaUYHGa4tLgd3CaUdMBBVqA9u2NyUe2J9UeYBeTNAFg6g58i3LZkAUs-Up3i6Cc1dslfivaeyW_wBWkuvg"/>
</div>
<div class="flex flex-col">
<span class="font-headline font-bold text-sm text-error group-hover:text-red-700 transition-colors">Minyak Kelapa Sawit Murni 1L</span>
<span class="font-mono text-[11px] text-rose-700 font-semibold">AST-FM-3301</span>
</div>
</div>
</td>
<td class="py-3.5 px-3 text-slate-600 font-medium">Minyak &amp; Lemak</td>
<td class="py-3.5 px-3">
<span class="px-2.5 py-1 rounded-md bg-white font-mono text-[11px] font-semibold text-rose-800 border border-rose-200/70">
                  Rak A-02-C
                </span>
</td>
<td class="py-3.5 px-3 text-right font-mono font-bold text-sm text-error">
                85 <span class="font-sans text-xs text-rose-600 font-normal">Pouch</span>
</td>
<td class="py-3.5 px-3 text-right font-mono text-slate-500">
                60 Pouch
              </td>
<td class="py-3.5 px-4">
<div class="flex flex-col gap-1.5">
<div class="flex justify-between text-[10px] font-mono font-bold text-error">
<span>14% (Kritis)</span>
<span class="text-rose-400 font-normal">Max: 600</span>
</div>
<div class="w-full bg-rose-200/60 h-1.5 rounded-full overflow-hidden">
<div class="bg-error h-full rounded-full" style="width: 14%"></div>
</div>
</div>
</td>
<td class="py-3.5 px-3">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-rose-100 text-error text-[11px] font-semibold border border-rose-200">
<span class="w-1.5 h-1.5 rounded-full bg-error animate-ping"></span> Menipis (&lt;20%)
                </span>
</td>
<td class="py-3.5 px-3 text-center">
<div class="inline-flex items-center gap-1">
<button class="p-1.5 rounded-lg hover:bg-white text-slate-400 hover:text-primary transition-colors" title="Lihat Detail">
<span class="material-symbols-outlined text-[18px]">visibility</span>
</button>
<button class="p-1.5 rounded-lg bg-primary text-white hover:bg-primary-container shadow-2xs transition-colors" title="Restock Cepat">
<span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
</button>
<button class="p-1.5 rounded-lg hover:bg-white text-slate-400 hover:text-on-surface transition-colors" title="Cetak Barcode">
<span class="material-symbols-outlined text-[18px]">print</span>
</button>
</div>
</td>
</tr>
<!-- Row 4: Kopi Robusta -->
<tr class="hover:bg-blue-50/30 transition-colors group" data-category="fast">
<td class="py-3.5 px-3">
<div class="flex items-center gap-3">
<div class="w-11 h-11 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200/60 p-0.5">
<img class="w-full h-full object-cover rounded-lg" data-alt="Matte dark blue pouch of Robusta blend specialty ground coffee" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA4WTlvMDxq00CWLXfOdNEyfH25iHKORFLunmEjH-_NPQqyr-AXp1sKnJRoDxAniNX0MxGX7IMzgAwrVT4ntLPxfu3YqxgxQoa0tXNjqCSQRV_jFJDuW8jkVMSHyOGdoZ8Tr-KMOuy1uuC3jwMLyzBVJ1ndOp0L1gsxy2QGI3mlqd4odAnMTiLYjVHWPDmW65vBhjStnPPt29qCJEL3a5W9yWGvCKcc4nDrIbfm-dUq18ZXrtyvBE4iig"/>
</div>
<div class="flex flex-col">
<span class="font-headline font-bold text-sm text-on-surface group-hover:text-primary transition-colors">Kopi Robusta Blend 250g</span>
<span class="font-mono text-[11px] text-primary font-semibold">AST-CF-8820</span>
</div>
</div>
</td>
<td class="py-3.5 px-3 text-slate-600 font-medium">Bahan Kering &amp; Minuman</td>
<td class="py-3.5 px-3">
<span class="px-2.5 py-1 rounded-md bg-slate-100 font-mono text-[11px] font-semibold text-slate-700 border border-slate-200/60">
                  Rak C-05-D
                </span>
</td>
<td class="py-3.5 px-3 text-right font-mono font-bold text-sm text-on-surface">
                920 <span class="font-sans text-xs text-slate-400 font-normal">Pack</span>
</td>
<td class="py-3.5 px-3 text-right font-mono text-slate-500">
                110 Pack
              </td>
<td class="py-3.5 px-4">
<div class="flex flex-col gap-1.5">
<div class="flex justify-between text-[10px] font-mono font-medium text-slate-500">
<span>61%</span>
<span class="text-slate-400">Max: 1,500</span>
</div>
<div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
<div class="bg-primary h-full rounded-full" style="width: 61%"></div>
</div>
</div>
</td>
<td class="py-3.5 px-3">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-medium border border-emerald-200/60">
<span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Stok Aman
                </span>
</td>
<td class="py-3.5 px-3 text-center">
<div class="inline-flex items-center gap-1">
<button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-primary transition-colors" title="Lihat Detail">
<span class="material-symbols-outlined text-[18px]">visibility</span>
</button>
<button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-secondary transition-colors" title="Sesuaikan Stok">
<span class="material-symbols-outlined text-[18px]">edit_note</span>
</button>
<button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-on-surface transition-colors" title="Cetak Barcode">
<span class="material-symbols-outlined text-[18px]">print</span>
</button>
</div>
</td>
</tr>
<!-- Row 5: Tepung Terigu -->
<tr class="hover:bg-blue-50/30 transition-colors group" data-category="fast">
<td class="py-3.5 px-3">
<div class="flex items-center gap-3">
<div class="w-11 h-11 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200/60 p-0.5">
<img class="w-full h-full object-cover rounded-lg" data-alt="All purpose wheat flour one kilogram pack clean minimal branding" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCj5O2vA2VecE0ss3rW_NzF4whWMXEiD5pQLvyVsSa8rRVAYayRkH7EllXAhI6a5t8y7wDNAn1SH6iAdQNkXMZCAVF-WJpJ8l5fuJ1v2VoxdmXTXIOPRaBuLQuFVhXEuc84rBGLHi9WTZDZopUY01ZSRsBdo-nu2o8gE0Yqah8c2VlOm8yddIetCgfcPaQWo2KLISwdKPY7lAl4PEorUUPlRDZaz-eWsV60nwYuKGSaqri3bKV_8iYTOA"/>
</div>
<div class="flex flex-col">
<span class="font-headline font-bold text-sm text-on-surface group-hover:text-primary transition-colors">Tepung Terigu Serbaguna 1kg</span>
<span class="font-mono text-[11px] text-primary font-semibold">AST-FL-1092</span>
</div>
</div>
</td>
<td class="py-3.5 px-3 text-slate-600 font-medium">Bahan Pokok &amp; Beras</td>
<td class="py-3.5 px-3">
<span class="px-2.5 py-1 rounded-md bg-slate-100 font-mono text-[11px] font-semibold text-slate-700 border border-slate-200/60">
                  Rak B-02-C
                </span>
</td>
<td class="py-3.5 px-3 text-right font-mono font-bold text-sm text-on-surface">
                1,850 <span class="font-sans text-xs text-slate-400 font-normal">Pack</span>
</td>
<td class="py-3.5 px-3 text-right font-mono text-slate-500">
                340 Pack
              </td>
<td class="py-3.5 px-4">
<div class="flex flex-col gap-1.5">
<div class="flex justify-between text-[10px] font-mono font-medium text-slate-500">
<span class="text-primary font-semibold">92%</span>
<span class="text-slate-400">Max: 2,000</span>
</div>
<div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
<div class="bg-primary-container h-full rounded-full" style="width: 92%"></div>
</div>
</div>
</td>
<td class="py-3.5 px-3">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-50 text-primary-container text-[11px] font-semibold border border-blue-200/60">
<span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span> Overstock
                </span>
</td>
<td class="py-3.5 px-3 text-center">
<div class="inline-flex items-center gap-1">
<button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-primary transition-colors" title="Lihat Detail">
<span class="material-symbols-outlined text-[18px]">visibility</span>
</button>
<button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-secondary transition-colors" title="Sesuaikan Stok">
<span class="material-symbols-outlined text-[18px]">edit_note</span>
</button>
<button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-on-surface transition-colors" title="Cetak Barcode">
<span class="material-symbols-outlined text-[18px]">print</span>
</button>
</div>
</td>
</tr>
<!-- Row 6: Deterjen Cair -->
<tr class="hover:bg-blue-50/30 transition-colors group" data-category="fast">
<td class="py-3.5 px-3">
<div class="flex items-center gap-3">
<div class="w-11 h-11 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200/60 p-0.5">
<img class="w-full h-full object-cover rounded-lg" data-alt="Liquid hygiene laundry detergent 800ml refill pouch displayed on clean blue shelf" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCuvW6sxz_lsWvBtM7emVTzBWXGGpom3SMeLdIQ7ozU6NRVnrGyDZC7tAwm4nyzX6Z7e1D7r01cIxd8sRWK_k4wAFxlaNcjH4AzzTe-Dp3s7iGCgG-tL4-jASEzgTzh_DVOUNuLkJsQMh2dmOD_d71Qat25au_kEw3BzKa2rM_Wai3cgoum_DSZjQm0dsmfH5J-a8ooJbJRBF8wk8hBCylU0y0Nn2uA_uSl6A8uM8_YMWdD0I7mSotEmg"/>
</div>
<div class="flex flex-col">
<span class="font-headline font-bold text-sm text-on-surface group-hover:text-primary transition-colors">Deterjen Cair Higienis 800ml</span>
<span class="font-mono text-[11px] text-primary font-semibold">AST-HC-5504</span>
</div>
</div>
</td>
<td class="py-3.5 px-3 text-slate-600 font-medium">Perawatan &amp; Kebersihan</td>
<td class="py-3.5 px-3">
<span class="px-2.5 py-1 rounded-md bg-slate-100 font-mono text-[11px] font-semibold text-slate-700 border border-slate-200/60">
                  Rak D-01-A
                </span>
</td>
<td class="py-3.5 px-3 text-right font-mono font-bold text-sm text-on-surface">
                740 <span class="font-sans text-xs text-slate-400 font-normal">Botol</span>
</td>
<td class="py-3.5 px-3 text-right font-mono text-slate-500">
                95 Botol
              </td>
<td class="py-3.5 px-4">
<div class="flex flex-col gap-1.5">
<div class="flex justify-between text-[10px] font-mono font-medium text-slate-500">
<span>49%</span>
<span class="text-slate-400">Max: 1,500</span>
</div>
<div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
<div class="bg-primary h-full rounded-full" style="width: 49%"></div>
</div>
</div>
</td>
<td class="py-3.5 px-3">
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-medium border border-emerald-200/60">
<span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Stok Aman
                </span>
</td>
<td class="py-3.5 px-3 text-center">
<div class="inline-flex items-center gap-1">
<button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-primary transition-colors" title="Lihat Detail">
<span class="material-symbols-outlined text-[18px]">visibility</span>
</button>
<button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-secondary transition-colors" title="Sesuaikan Stok">
<span class="material-symbols-outlined text-[18px]">edit_note</span>
</button>
<button class="p-1.5 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-on-surface transition-colors" title="Cetak Barcode">
<span class="material-symbols-outlined text-[18px]">print</span>
</button>
</div>
</td>
</tr>
</tbody>
</table>
</div>
<!-- Modern Data Table Pagination Footer -->
<div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-slate-100 text-xs text-slate-500">
<div class="flex items-center gap-2">
<span>Menampilkan <strong class="text-on-surface font-semibold">1 – 6</strong> dari <strong class="text-on-surface font-semibold">14,820</strong> entri SKU</span>
<span class="text-slate-300">•</span>
<div class="flex items-center gap-1.5">
<span>Baris per halaman:</span>
<select class="bg-slate-50 border border-slate-200/70 rounded-lg px-2 py-1 text-on-surface font-medium text-xs focus:outline-none">
<option>10</option>
<option>25</option>
<option>50</option>
</select>
</div>
</div>
<div class="flex items-center gap-1">
<button class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200/80 text-slate-400 hover:bg-slate-50 disabled:opacity-40" disabled="">
<span class="material-symbols-outlined text-[18px]">chevron_left</span>
</button>
<button class="w-8 h-8 rounded-lg flex items-center justify-center bg-primary text-white font-mono font-bold text-xs shadow-2xs">
            1
          </button>
<button class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200/80 hover:bg-slate-50 text-slate-600 font-mono text-xs">
            2
          </button>
<button class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200/80 hover:bg-slate-50 text-slate-600 font-mono text-xs">
            3
          </button>
<span class="px-1 text-slate-400">…</span>
<button class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200/80 hover:bg-slate-50 text-slate-600 font-mono text-xs">
            247
          </button>
<button class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200/80 text-slate-600 hover:bg-slate-50">
<span class="material-symbols-outlined text-[18px]">chevron_right</span>
</button>
</div>
</div>
</section>
</main>

@endsection
