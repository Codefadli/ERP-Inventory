@extends('app.app')

@section('title', 'Dashboard HR - Astro Inventory')

@section('content')
<!-- BREADCRUMB & PAGE TITLE -->
<section class="w-full mb-6">
  <div class="flex items-center gap-2 text-xs text-slate-500 mb-3">
    <span>Beranda</span>
    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
    <span class="text-primary font-medium">Dashboard HR (Overview)</span>
  </div>
  
  <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
    <div class="flex-1">
      <h1 class="text-2xl sm:text-3xl font-headline font-extrabold text-on-surface tracking-tight mb-2">
        Pusat Otorisasi & Dasbor Operasional HR
      </h1>
      <p class="text-sm text-slate-600 leading-relaxed">
        Pemantauan antrean persetujuan mutasi, verifikasi selisih stok opname, dan keputusan regulasi logistik real-time.
      </p>
    </div>
    
    <div class="flex items-center gap-2.5">
      <button class="h-11 px-4 rounded-xl bg-slate-100 hover:bg-slate-200/80 text-on-surface border border-slate-200/70 font-headline font-semibold text-sm flex items-center gap-2 transition-all active:scale-[0.98]">
        <span class="material-symbols-outlined text-[18px]">download</span>
        <span>Unduh Laporan Ringkas</span>
      </button>
      <button class="h-11 px-5 bg-primary hover:bg-primary-container text-white font-headline font-semibold text-sm rounded-xl flex items-center gap-2 shadow-sm shadow-primary/25 transition-all active:scale-[0.98]">
        <span class="material-symbols-outlined text-[18px]">fast_forward</span>
        <span>Proses Antrean Tercepat</span>
      </button>
    </div>
  </div>
</section>

<!-- KPI CARDS SECTION -->
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
  <!-- Card 1: MENUNGGU PERSETUJUAN -->
  <div class="bg-white rounded-2xl p-5 border border-slate-200/70 shadow-[0_2px_12px_rgba(11,28,48,0.02)] hover:shadow-md transition-all duration-300 group animate-fade-in">
    <div class="flex items-start justify-between mb-4">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-50 text-primary flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
          <span class="material-symbols-outlined text-[22px]">schedule</span>
        </div>
        <div>
          <div class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold mb-0.5">MENUNGGU PERSETUJUAN</div>
          <div class="text-xs text-error font-medium flex items-center gap-1">
            <span class="w-1.5 h-1.5 rounded-full bg-error animate-pulse"></span>
            3 Butuh Review
          </div>
        </div>
      </div>
    </div>
    
    <div class="mb-3">
      <div class="flex items-baseline gap-2">
        <span class="font-headline font-extrabold text-4xl text-on-surface tracking-tight">5</span>
      </div>
    </div>
    
    <div class="flex items-center gap-1.5 text-xs">
      <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
      <span class="text-error font-medium">3 Kritis (&lt; 2 Jam ROP / SLA)</span>
    </div>
  </div>

  <!-- Card 2: DISETUJUI HARI INI -->
  <div class="bg-white rounded-2xl p-5 border border-slate-200/70 shadow-[0_2px_12px_rgba(11,28,48,0.02)] hover:shadow-md transition-all duration-300 group animate-fade-in" style="animation-delay: 0.1s;">
    <div class="flex items-start justify-between mb-4">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
          <span class="material-symbols-outlined text-[22px]">check_circle</span>
        </div>
        <div>
          <div class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold mb-0.5">DISETUJUI HARI INI</div>
          <div class="text-xs text-emerald-600 font-medium flex items-center gap-1">
            <span class="material-symbols-outlined text-[14px]">trending_up</span>
            +12% bb lalu
          </div>
        </div>
      </div>
    </div>
    
    <div class="mb-3">
      <div class="flex items-baseline gap-2">
        <span class="font-headline font-extrabold text-4xl text-on-surface tracking-tight">18</span>
      </div>
    </div>
    
    <div class="flex items-center gap-1.5 text-xs">
      <span class="material-symbols-outlined text-[14px] text-emerald-600">verified</span>
      <span class="text-slate-600">18 Transaksi Tervalidasi SPO</span>
    </div>
  </div>

  <!-- Card 3: DITOLAK / VALUASI -->
  <div class="bg-white rounded-2xl p-5 border border-slate-200/70 shadow-[0_2px_12px_rgba(11,28,48,0.02)] hover:shadow-md transition-all duration-300 group animate-fade-in" style="animation-delay: 0.2s;">
    <div class="flex items-start justify-between mb-4">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
          <span class="material-symbols-outlined text-[22px]">warning</span>
        </div>
        <div>
          <div class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold mb-0.5">DITOLAK / VALUASI</div>
          <div class="text-xs text-emerald-600 font-medium">99.8% Akurasi</div>
        </div>
      </div>
    </div>
    
    <div class="mb-3">
      <div class="flex items-baseline gap-2">
        <span class="font-headline font-extrabold text-4xl text-on-surface tracking-tight">2</span>
      </div>
    </div>
    
    <div class="flex items-center gap-1.5 text-xs">
      <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
      <span class="text-slate-600">Deviasi Fisik SPO Dilaporkan</span>
    </div>
  </div>

  <!-- Card 4: RATA-RATA SLA RESPON -->
  <div class="bg-white rounded-2xl p-5 border border-slate-200/70 shadow-[0_2px_12px_rgba(11,28,48,0.02)] hover:shadow-md transition-all duration-300 group animate-fade-in" style="animation-delay: 0.3s;">
    <div class="flex items-start justify-between mb-4">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
          <span class="material-symbols-outlined text-[22px]">bolt</span>
        </div>
        <div>
          <div class="text-[10px] uppercase tracking-wider text-slate-500 font-semibold mb-0.5">RATA-RATA SLA RESPON</div>
          <div class="text-xs text-emerald-600 font-medium flex items-center gap-1">
            <span class="material-symbols-outlined text-[14px]">verified</span>
            100% Siap
          </div>
        </div>
      </div>
    </div>
    
    <div class="mb-3">
      <div class="flex items-baseline gap-2">
        <span class="font-headline font-extrabold text-4xl text-on-surface tracking-tight">48</span>
        <span class="text-lg text-slate-500 font-medium">Menit</span>
      </div>
    </div>
    
    <div class="flex items-center gap-1.5 text-xs">
      <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
      <span class="text-emerald-600 font-medium">Target &lt; 4 Jam (Kinerja Optimal)</span>
    </div>
  </div>
</section>

<!-- MAIN CONTENT GRID: CHART + SIDEBAR -->
<section class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
  <!-- CHART CARD (8 cols) -->
  <div class="lg:col-span-8 bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/70 shadow-[0_2px_12px_rgba(11,28,48,0.02)] animate-slide-in-left">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-5 pb-4 border-b border-slate-100">
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-xl bg-blue-50 text-primary flex items-center justify-center">
          <span class="material-symbols-outlined text-[20px]">show_chart</span>
        </div>
        <div>
          <h3 class="font-headline font-bold text-base text-on-surface">Arus Persetujuan & Mutasi Barang Hub</h3>
          <p class="text-[11px] text-slate-500">Analisis throughput pergerakan stok harian dalam satuan unit</p>
        </div>
      </div>
      
      <div class="flex items-center gap-2">
        <div class="flex items-center gap-1 bg-slate-100 p-0.5 rounded-lg text-xs font-headline">
          <button class="px-3 py-1.5 rounded-md font-semibold bg-white text-primary shadow-2xs">7 Hari Terakhir</button>
          <button class="px-3 py-1.5 rounded-md text-slate-600 hover:text-on-surface font-medium">30 Hari</button>
          <button class="px-3 py-1.5 rounded-md text-slate-600 hover:text-on-surface font-medium">Bulan Ini</button>
        </div>
        <button class="h-9 px-3 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium flex items-center gap-1.5">
          <span class="material-symbols-outlined text-[16px]">location_on</span>
          Semua Zona DC
        </button>
      </div>
    </div>
    
    <!-- Chart Area -->
    <div class="relative h-72 mb-4">
      <canvas id="throughputChart" class="w-full h-full"></canvas>
    </div>
    
    <!-- Chart Legend & Stats -->
    <div class="flex flex-wrap items-center justify-between gap-4 pt-4 border-t border-slate-100">
      <div class="flex flex-wrap items-center gap-4 text-sm">
        <div class="flex items-center gap-2">
          <div class="w-3 h-3 rounded-sm bg-primary"></div>
          <span class="text-slate-600">Inbound (Masuk)</span>
          <span class="font-mono font-bold text-primary">8.420 unit</span>
        </div>
        <div class="flex items-center gap-2">
          <div class="w-3 h-3 rounded-sm bg-purple-500 opacity-60"></div>
          <span class="text-slate-600">Outbound (Keluar)</span>
          <span class="font-mono font-bold text-purple-600">6.850 unit</span>
        </div>
      </div>
      
      <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500">
        <span>Rata-rata Harian: <strong class="text-on-surface">1.202 Unit/Hari</strong></span>
        <span class="text-slate-300">•</span>
        <span>Puncak Throughput: <strong class="text-on-surface">Sabtu (1.480 Unit)</strong></span>
        <span class="text-slate-300">•</span>
        <span class="text-emerald-600 font-medium">Efisiensi Otorisasi: 98.4% On-Schedule</span>
      </div>
    </div>
  </div>

  <!-- STOK KRITIS SIDEBAR (4 cols) -->
  <div class="lg:col-span-4 bg-white rounded-2xl p-5 border border-slate-200/70 shadow-[0_2px_12px_rgba(11,28,48,0.02)] animate-slide-in-right">
    <div class="flex items-center justify-between mb-5 pb-3 border-b border-slate-100">
      <div class="flex items-center gap-2">
        <div class="w-8 h-8 rounded-xl bg-rose-50 text-error flex items-center justify-center">
          <span class="material-symbols-outlined text-[18px]">inventory_2</span>
        </div>
        <h3 class="font-headline font-bold text-sm text-on-surface">Stok Kritis & Menipis</h3>
      </div>
      <span class="px-2.5 py-1 rounded-full bg-rose-100 text-error text-[10px] font-bold font-mono border border-rose-200">3 SKU Kritis</span>
    </div>
    
    <div class="space-y-3">
      <!-- Product Card 1 -->
      <div class="relative p-4 rounded-xl bg-slate-50/70 border border-slate-200/70 hover:border-primary/40 transition-all group">
        <div class="absolute top-3 right-3">
          <span class="px-2 py-0.5 rounded-md bg-error text-white text-[10px] font-bold">Sisa 4 Unit</span>
        </div>
        
        <div class="mb-3">
          <h4 class="font-headline font-bold text-sm text-on-surface mb-1 pr-16">Canon 6D DSLR Camera Body</h4>
          <div class="flex items-center gap-2 text-[11px] font-mono text-slate-500">
            <span class="text-primary font-semibold">BAM • CAM • DSLR</span>
            <span class="text-slate-300">|</span>
            <span>WH01-RACK-A4</span>
          </div>
        </div>
        
        <div class="mb-2">
          <div class="flex justify-between text-[10px] text-slate-500 mb-1">
            <span>Kapasitas Buffer (ROP: 25)</span>
            <span class="text-error font-bold">96% dari buffer</span>
          </div>
          <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden">
            <div class="bg-error h-full rounded-full transition-all duration-1000 animate-pulse-slow" style="width: 96%"></div>
          </div>
        </div>
        
        <button class="text-xs text-primary hover:text-primary-container font-semibold flex items-center gap-1 group-hover:gap-2 transition-all">
          <span class="material-symbols-outlined text-[16px]">refresh</span>
          Ajukan Restock
        </button>
      </div>

      <!-- Product Card 2 -->
      <div class="relative p-4 rounded-xl bg-slate-50/70 border border-slate-200/70 hover:border-primary/40 transition-all group">
        <div class="absolute top-3 right-3">
          <span class="px-2 py-0.5 rounded-md bg-amber-500 text-white text-[10px] font-bold">Sisa 7 Unit</span>
        </div>
        
        <div class="mb-3">
          <h4 class="font-headline font-bold text-sm text-on-surface mb-1 pr-16">Nikon Reel Optical Pro X</h4>
          <div class="flex items-center gap-2 text-[11px] font-mono text-slate-500">
            <span class="text-primary font-semibold">BAM • CAM • MIRR</span>
            <span class="text-slate-300">|</span>
            <span>WH01-RACK-B2</span>
          </div>
        </div>
        
        <div class="mb-2">
          <div class="flex justify-between text-[10px] text-slate-500 mb-1">
            <span>Kapasitas Buffer (ROP: 30)</span>
            <span class="text-amber-600 font-bold">23% dari buffer</span>
          </div>
          <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden">
            <div class="bg-amber-500 h-full rounded-full transition-all duration-1000" style="width: 23%"></div>
          </div>
        </div>
        
        <button class="text-xs text-primary hover:text-primary-container font-semibold flex items-center gap-1 group-hover:gap-2 transition-all">
          <span class="material-symbols-outlined text-[16px]">refresh</span>
          Ajukan Restock
        </button>
      </div>

      <!-- Product Card 3 -->
      <div class="relative p-4 rounded-xl bg-slate-50/70 border border-slate-200/70 hover:border-primary/40 transition-all group">
        <div class="absolute top-3 right-3">
          <span class="px-2 py-0.5 rounded-md bg-amber-500 text-white text-[10px] font-bold">Sisa 12 Unit</span>
        </div>
        
        <div class="mb-3">
          <h4 class="font-headline font-bold text-sm text-on-surface mb-1 pr-16">Watch 4th Gen Smartwatch</h4>
          <div class="flex items-center gap-2 text-[11px] font-mono text-slate-500">
            <span class="text-primary font-semibold">BAM • WTCH • SMWT</span>
            <span class="text-slate-300">|</span>
            <span>WH01-RACK-C1</span>
          </div>
        </div>
        
        <div class="mb-2">
          <div class="flex justify-between text-[10px] text-slate-500 mb-1">
            <span>Kapasitas Buffer (ROP: 40)</span>
            <span class="text-primary font-bold">30% dari buffer</span>
          </div>
          <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden">
            <div class="bg-primary h-full rounded-full transition-all duration-1000" style="width: 30%"></div>
          </div>
        </div>
        
        <button class="text-xs text-primary hover:text-primary-container font-semibold flex items-center gap-1 group-hover:gap-2 transition-all">
          <span class="material-symbols-outlined text-[16px]">refresh</span>
          Ajukan Restock
        </button>
      </div>
    </div>
  </div>
</section>

<!-- ACTIVITY LOG & APPROVAL CARDS -->
<section class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
  <!-- LOG AKTIVITAS (7 cols) -->
  <div class="lg:col-span-7 bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/70 shadow-[0_2px_12px_rgba(11,28,48,0.02)]">
    <div class="flex items-center justify-between mb-5 pb-3 border-b border-slate-100">
      <div class="flex items-center gap-2.5">
        <div class="w-8 h-8 rounded-xl bg-blue-50 text-primary flex items-center justify-center">
          <span class="material-symbols-outlined text-[18px]">history</span>
        </div>
        <h3 class="font-headline font-bold text-base text-on-surface">Log Aktivitas Terkini (Otorisasi & Mutasi)</h3>
      </div>
      <button class="text-xs text-primary hover:text-primary-container font-semibold flex items-center gap-0.5">
        Lihat Semua Log
        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
      </button>
    </div>
    
    <div class="space-y-4">
      <!-- Activity 1 -->
      <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors animate-slide-in-up">
        <div class="relative shrink-0">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-primary text-white font-headline font-bold text-xs flex items-center justify-center shadow-xs">
            BS
          </div>
          <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-emerald-500 flex items-center justify-center ring-2 ring-white">
            <span class="material-symbols-outlined text-[10px] text-white">check</span>
          </div>
        </div>
        
        <div class="flex-1">
          <div class="flex items-start justify-between gap-2 mb-1">
            <div>
              <div class="font-headline font-bold text-sm text-on-surface mb-0.5">Budi Santoso</div>
              <div class="text-[11px] text-slate-500">Super Admin</div>
            </div>
            <span class="text-[11px] text-slate-400 font-mono">10 menit yang lalu</span>
          </div>
          
          <p class="text-xs text-slate-600 mb-2">
            Memproses persetujuan <strong class="text-on-surface">Mutasi Keluar 150 unit</strong> [SKU:CAM-8821] menuju Hub Halim DC-02.
          </p>
          
          <div class="flex items-center gap-2">
            <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-semibold border border-emerald-200/60">
              Mutasi Sukses Disetujui
            </span>
            <span class="text-[11px] text-slate-400 font-mono">Ref #MUT-2023-0841</span>
          </div>
        </div>
      </div>

      <!-- Activity 2 -->
      <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors animate-slide-in-up" style="animation-delay: 0.1s;">
        <div class="relative shrink-0">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-600 to-slate-800 text-white font-headline font-bold text-xs flex items-center justify-center shadow-xs">
            RH
          </div>
          <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-slate-500 flex items-center justify-center ring-2 ring-white">
            <span class="material-symbols-outlined text-[10px] text-white">lock</span>
          </div>
        </div>
        
        <div class="flex-1">
          <div class="flex items-start justify-between gap-2 mb-1">
            <div>
              <div class="font-headline font-bold text-sm text-on-surface mb-0.5">Rian Hidayat</div>
              <div class="text-[11px] text-slate-500">Admin Keuangan RBAC</div>
            </div>
            <span class="text-[11px] text-slate-400 font-mono">35 menit yang lalu</span>
          </div>
          
          <p class="text-xs text-slate-600 mb-2">
            Memberhentikan hak akses RBAC penjual [SK-Gudang Lapangan]: penambahan modul cetak label QR & barcode scanner.
          </p>
          
          <div class="flex items-center gap-2">
            <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[10px] font-semibold border border-slate-200/60">
              Perubahan Hak Akses
            </span>
            <span class="text-[11px] text-slate-400 font-mono">Audit ID #SEC-819</span>
          </div>
        </div>
      </div>

      <!-- Activity 3 -->
      <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors animate-slide-in-up" style="animation-delay: 0.2s;">
        <div class="relative shrink-0">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-400 to-blue-600 text-white font-headline font-bold text-xs flex items-center justify-center shadow-xs">
            DA
          </div>
          <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-rose-500 flex items-center justify-center ring-2 ring-white">
            <span class="material-symbols-outlined text-[10px] text-white">warning</span>
          </div>
        </div>
        
        <div class="flex-1">
          <div class="flex items-start justify-between gap-2 mb-1">
            <div>
              <div class="font-headline font-bold text-sm text-on-surface mb-0.5">Dewi Anggraini</div>
              <div class="text-[11px] text-slate-500">Supervisor Audit</div>
            </div>
            <span class="text-[11px] text-slate-400 font-mono">1 jam yang lalu</span>
          </div>
          
          <p class="text-xs text-slate-600 mb-2">
            Menyelesaikan <strong class="text-on-surface">Stok Opname terjadwal</strong> di Lorong B3 (Rak Elektronik). Ditemukan selisih -3 unit pada SKU Apple Watch.
          </p>
          
          <div class="flex items-center gap-2">
            <span class="px-2.5 py-0.5 rounded-full bg-rose-50 text-error text-[10px] font-semibold border border-rose-200/60">
              Discrepancy Logged
            </span>
            <span class="text-[11px] text-slate-400 font-mono">Opname #SO-2023-112</span>
          </div>
        </div>
      </div>

      <!-- Activity 4 -->
      <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors animate-slide-in-up" style="animation-delay: 0.3s;">
        <div class="relative shrink-0">
          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-500 to-slate-700 text-white font-headline font-bold text-xs flex items-center justify-center shadow-xs">
            FK
          </div>
          <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-secondary flex items-center justify-center ring-2 ring-white">
            <span class="material-symbols-outlined text-[10px] text-white">inbox</span>
          </div>
        </div>
        
        <div class="flex-1">
          <div class="flex items-start justify-between gap-2 mb-1">
            <div>
              <div class="font-headline font-bold text-sm text-on-surface mb-0.5">Fajar Kurnia</div>
              <div class="text-[11px] text-slate-500">Inbound Staff</div>
            </div>
            <span class="text-[11px] text-slate-400 font-mono">2 jam yang lalu</span>
          </div>
          
          <p class="text-xs text-slate-600 mb-2">
            Menerima penerimaan fisik <strong class="text-on-surface">PO-774</strong> dari PT Mitra Logistik Nusantara sejumlah 450 unit perlengkapan optik.
          </p>
          
          <div class="flex items-center gap-2">
            <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-semibold border border-emerald-200/60">
              Penerimaan Selesai
            </span>
            <span class="text-[11px] text-slate-400 font-mono">Surat Jalan #SJ-90928</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- APPROVAL CARDS (5 cols) -->
  <div class="lg:col-span-5 space-y-4">
    <!-- Card Header -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/70 shadow-[0_2px_12px_rgba(11,28,48,0.02)]">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-[18px]">task</span>
          </div>
          <h3 class="font-headline font-bold text-sm text-on-surface">Menunggu Persetujuan</h3>
        </div>
        <span class="px-2.5 py-1 rounded-full bg-blue-100 text-primary text-[10px] font-bold font-mono">4 Permintaan</span>
      </div>
      
      <!-- Approval Task 1 -->
      <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/80 hover:border-primary/40 transition-all">
        <div class="flex items-start gap-3 mb-3">
          <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[20px]">assignment</span>
          </div>
          <div class="flex-1">
            <h4 class="font-headline font-bold text-sm text-on-surface mb-1">Mutasi Antar-Hub - 150 Unit</h4>
            <p class="text-xs text-slate-600 leading-relaxed">
              Permintaan alokasi darurat dari Hub Calung DC-01 menuju Hub Halim DC-02 untuk batch elektronik.
            </p>
          </div>
        </div>
        
        <div class="flex items-center justify-between text-[11px] text-slate-500 mb-3 pb-3 border-b border-slate-200">
          <span>Diajukan: <strong class="text-on-surface">Tim Logistik Timur</strong></span>
          <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 font-semibold">Prioritas: Tinggi</span>
        </div>
        
        <div class="flex items-center justify-end gap-2">
          <button class="h-9 px-4 rounded-lg border border-slate-300 hover:bg-rose-50 hover:text-error hover:border-rose-200 text-slate-700 font-headline font-semibold text-xs flex items-center gap-1.5 transition-all">
            <span class="material-symbols-outlined text-[16px]">close</span>
            Tolak
          </button>
          <button class="h-9 px-4 rounded-lg bg-primary hover:bg-primary-container text-white font-headline font-semibold text-xs flex items-center gap-1.5 shadow-sm shadow-primary/20 transition-all active:scale-[0.98]">
            <span class="material-symbols-outlined text-[16px]">check</span>
            Setujui
          </button>
        </div>
      </div>
    </div>

    <!-- Adjustment Card -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/70 shadow-[0_2px_12px_rgba(11,28,48,0.02)]">
      <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200/80 hover:border-primary/40 transition-all">
        <div class="flex items-start gap-3 mb-3">
          <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-[20px]">find_in_page</span>
          </div>
          <div class="flex-1">
            <div class="flex items-center justify-between mb-2">
              <h4 class="font-headline font-bold text-sm text-on-surface">Penyesuaian Stok Opname</h4>
              <span class="px-2 py-0.5 rounded-md bg-error text-white text-xs font-bold">-3 Unit</span>
            </div>
            <p class="text-xs text-slate-600 leading-relaxed">
              Adjustment write-off setelah fisik pemeriksaan berkala rak B3 pada produk Smartwatch sertifikasi SN-5810.
            </p>
          </div>
        </div>
        
        <div class="flex items-center justify-between text-[11px] text-slate-500 mb-3 pb-3 border-b border-slate-200">
          <span>Auditor: <strong class="text-on-surface">Dewi Anggraini</strong></span>
          <span class="text-slate-600">Level: Write-Off Minor</span>
        </div>
        
        <div class="flex items-center justify-end gap-2">
          <button class="h-9 px-4 rounded-lg border border-slate-300 hover:bg-rose-50 hover:text-error hover:border-rose-200 text-slate-700 font-headline font-semibold text-xs flex items-center gap-1.5 transition-all">
            <span class="material-symbols-outlined text-[16px]">close</span>
            Tolak
          </button>
          <button class="h-9 px-4 rounded-lg bg-primary hover:bg-primary-container text-white font-headline font-semibold text-xs flex items-center gap-1.5 shadow-sm shadow-primary/20 transition-all active:scale-[0.98]">
            <span class="material-symbols-outlined text-[16px]">check</span>
            Setujui
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes slide-in-left {
  from {
    opacity: 0;
    transform: translateX(-20px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

@keyframes slide-in-right {
  from {
    opacity: 0;
    transform: translateX(20px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

@keyframes slide-in-up {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes pulse-slow {
  0%, 100% {
    opacity: 1;
  }
  50% {
    opacity: 0.7;
  }
}

.animate-fade-in {
  animation: fade-in 0.5s ease-out forwards;
  opacity: 0;
}

.animate-slide-in-left {
  animation: slide-in-left 0.6s ease-out forwards;
}

.animate-slide-in-right {
  animation: slide-in-right 0.6s ease-out forwards;
}

.animate-slide-in-up {
  animation: slide-in-up 0.4s ease-out forwards;
  opacity: 0;
}

.animate-pulse-slow {
  animation: pulse-slow 2s ease-in-out infinite;
}
</style>

<script>
// Chart.js configuration for throughput chart
document.addEventListener('DOMContentLoaded', function() {
  const ctx = document.getElementById('throughputChart');
  if (ctx && typeof Chart !== 'undefined') {
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
        datasets: [
          {
            label: 'Inbound (Masuk)',
            data: [850, 920, 1100, 1200, 1350, 1460, 1020],
            borderColor: 'rgb(37, 99, 235)',
            backgroundColor: 'rgba(37, 99, 235, 0.1)',
            tension: 0.4,
            fill: true,
            pointRadius: 4,
            pointHoverRadius: 6,
            pointBackgroundColor: 'rgb(37, 99, 235)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
          },
          {
            label: 'Outbound (Keluar)',
            data: [720, 800, 950, 1050, 1150, 1200, 880],
            borderColor: 'rgb(139, 92, 246)',
            backgroundColor: 'rgba(139, 92, 246, 0.05)',
            borderDash: [5, 5],
            tension: 0.4,
            fill: false,
            pointRadius: 4,
            pointHoverRadius: 6,
            pointBackgroundColor: 'rgb(139, 92, 246)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
          mode: 'index',
          intersect: false,
        },
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            backgroundColor: 'rgba(15, 23, 42, 0.95)',
            padding: 12,
            titleFont: {
              size: 13,
              weight: 'bold'
            },
            bodyFont: {
              size: 12
            },
            callbacks: {
              label: function(context) {
                return context.dataset.label + ': ' + context.parsed.y + ' unit';
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: false,
            min: 300,
            max: 1500,
            ticks: {
              callback: function(value) {
                if (value >= 1000) {
                  return (value / 1000).toFixed(1) + 'k';
                }
                return value;
              },
              font: {
                size: 11
              },
              color: '#64748b'
            },
            grid: {
              color: 'rgba(148, 163, 184, 0.1)',
              drawBorder: false
            }
          },
          x: {
            ticks: {
              font: {
                size: 11,
                weight: '500'
              },
              color: '#64748b'
            },
            grid: {
              display: false,
              drawBorder: false
            }
          }
        }
      }
    });
  }
});
</script>

@endsection
