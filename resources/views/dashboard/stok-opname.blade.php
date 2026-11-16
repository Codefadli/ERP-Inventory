<style>
    * {
        box-sizing: border-box;
    }

    html,
    body {
        margin: 0;
        padding: 0;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        overflow-x: hidden;
        background-color: #f8f9ff;
        color: #0b1c30;
    }

    /* ---------- Layout shell ---------- */
    .app-shell {
        display: flex;
        min-height: 100vh;
    }

    .sidebar-left {
        width: 256px;
        flex-shrink: 0;
        background: #ffffff;
        border-right: 1px solid #e5eeff;
        position: sticky;
        top: 64px;
        height: calc(100vh - 64px);
        overflow-y: auto;
    }

    .main-area {
        flex: 1;
        min-width: 0;
    }

    @media (max-width: 1024px) {
        .sidebar-left {
            display: none;
        }
    }

    /* ---------- Sidebar items ---------- */
    .sidebar-item {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .625rem .75rem;
        border-radius: .5rem;
        font-size: .875rem;
        color: #334155;
        text-decoration: none;
        transition: background-color .15s ease, color .15s ease;
        border-left: 3px solid transparent;
    }

    .sidebar-item:hover {
        background-color: #eff6ff;
    }

    .sidebar-item.active {
        background-color: #0044ce;
        border-left: 3px solid #0033b8;
        font-weight: 600;
        color: #ffffff;
    }

    .sidebar-item.active:hover {
        background-color: #0040d8;
    }

    /* non-referenced items: visually normal (reference fidelity), behaviorally inactive */
    .sidebar-item.disabled {
        opacity: 1;
        cursor: not-allowed;
    }

    .sidebar-item.disabled:hover {
        background-color: transparent;
    }

    .sidebar-section-label {
        font-size: .6875rem;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: .04em;
        padding: 0 .75rem;
        margin: 0.625rem 0 0.375rem;
    }

    .sidebar-section-label:first-child {
        margin-top: 0;
    }

    /* ---------- Cards ---------- */
    .metric-card {
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, .15);
    }

    .panel {
        background: #fff;
        border: 1px solid #e5eeff;
        border-radius: .5rem;
        box-shadow: 0 1px 2px rgba(16, 24, 40, .04);
    }

    /* ---------- Tables ---------- */
    .table-row {
        transition: background-color .15s ease;
    }

    .table-row:hover {
        background-color: #f9fafb;
    }

    /* ---------- Filter chips ---------- */
    .filter-tag {
        transition: background-color .15s ease;
    }

    .filter-tag:hover {
        background-color: #dbeafe;
    }

    /* ---------- Progress ---------- */
    .progress-bar {
        transition: width .5s ease;
    }

    /* ---------- Tabs ---------- */
    .tab-btn {
        transition: all .15s ease;
    }

    .tab-btn.active {
        background: #2563eb;
        color: #fff;
    }

    /* ---------- Badges ---------- */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: .25rem;
        padding: .125rem .625rem;
        border-radius: 9999px;
        font-size: .75rem;
        font-weight: 600;
    }

    /* ---------- Modal ---------- */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(11, 28, 48, .55);
        display: none;
        align-items: flex-start;
        justify-content: center;
        z-index: 80;
        padding: 5vh 1rem 1rem;
        overflow-y: auto;
    }

    .modal-overlay.open {
        display: flex;
    }

    .modal-box {
        background: #fff;
        border-radius: .75rem;
        width: 100%;
        max-width: 640px;
        box-shadow: 0 20px 50px -10px rgba(0, 0, 0, .35);
        animation: modalIn .18s ease;
    }

    @keyframes modalIn {
        from {
            opacity: 0;
            transform: translateY(12px) scale(.98);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }

    /* ---------- Dropdown ---------- */
    .dropdown {
        position: absolute;
        top: calc(100% + 6px);
        right: 0;
        background: #fff;
        border: 1px solid #e5eeff;
        border-radius: .5rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, .18);
        min-width: 260px;
        z-index: 70;
        display: none;
    }

    .dropdown.open {
        display: block;
    }

    /* ---------- Toast ---------- */
    #toast-container {
        position: fixed;
        right: 1rem;
        bottom: 1rem;
        z-index: 100;
        display: flex;
        flex-direction: column;
        gap: .5rem;
    }

    .toast {
        background: #fff;
        border: 1px solid #e5eeff;
        border-left: 4px solid #2563eb;
        border-radius: .5rem;
        padding: .75rem 1rem;
        box-shadow: 0 8px 20px -6px rgba(0, 0, 0, .2);
        font-size: .875rem;
        color: #0b1c30;
        animation: toastIn .2s ease;
        max-width: 340px;
    }

    .toast.success {
        border-left-color: #16a34a;
    }

    .toast.warn {
        border-left-color: #f59e0b;
    }

    .toast.error {
        border-left-color: #dc2626;
    }

    @keyframes toastIn {
        from {
            opacity: 0;
            transform: translateX(20px);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }

    /* ---------- Mobile sidebar drawer ---------- */
    .drawer-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(11, 28, 48, .45);
        z-index: 60;
        display: none;
    }

    .drawer-backdrop.open {
        display: block;
    }

    @media (max-width:1024px) {
        .sidebar-left.drawer {
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 61;
            transform: translateX(-100%);
            transition: transform .25s ease;
        }

        .sidebar-left.drawer.open {
            transform: translateX(0);
        }
    }

    /* ---------- Scrollbar ---------- */
    .sidebar-left::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-left::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    /* ---------- Misc helpers ---------- */
    .anim-fade-up {
        animation: fadeUp .35s ease both;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }

    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
</style>
@endsection

@section('content')
@include('components.navbar')

<div class="app-shell">
    @include('components.sidebar')

    <main class="main-area p-4 lg:p-6 overflow-x-hidden">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-4 overflow-x-auto whitespace-nowrap">
            <span>Operasional &amp; Transaksi</span><i class="fas fa-chevron-right text-xs"></i>
            <span>Stok Opname &amp; Audit Fisik Inventaris</span><i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-900 font-medium">Stok Opname</span>
        </div>

        <!-- Page header -->
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-6">
            <div class="flex-1">
                <h1 class="text-xl lg:text-2xl font-bold text-gray-900 mb-2">Stok Opname (Stock Count &amp; Audit Fisik)</h1>
                <p class="text-sm lg:text-base text-gray-600">Pencocokan kuantitas stok fisik gudang terhadap sistem ledger secara berkala (cycle count &amp; wall-to-wall), identifikasi selisih (discrepancy), serta penyesuaian inventaris resmi Hub Cakung DC-01.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <span class="badge bg-blue-100 text-blue-700"><i class="fas fa-calendar-check"></i>Jadwal Audit Siklus Q1 2025</span>
                <span class="badge bg-green-100 text-green-700"><i class="fas fa-chart-line"></i>Progress Audit 68,4%</span>
                <span class="badge bg-amber-100 text-amber-700"><i class="fas fa-ruler"></i>Toleransi Selisih &lt; 0,2%</span>
                <button onclick="toast('Menyiapkan ekspor Hasil Audit (Excel/PDF)...','success')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2 text-sm"><i class="fas fa-file-export"></i><span>Ekspor Hasil Audit (Excel/PDF)</span></button>
                <button onclick="openModal('modalTim')" class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm flex items-center gap-2"><i class="fas fa-users"></i>Jadwal Tim Auditor</button>
            </div>
        </div>

        <!-- Stat cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-barcode text-blue-600"></i></div>
                    <span class="badge bg-blue-100 text-blue-700"><i class="fas fa-circle" style="font-size:5px"></i>Hari Ini</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">1.845 <span class="text-sm font-normal text-gray-500">SKU</span></h3>
                <p class="text-sm text-gray-600 mb-2">Total SKU Di-Audit Hari Ini</p>
                <p class="text-xs text-green-600">1.742 SKU Cocok 100%</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center"><i class="fas fa-clipboard-list text-indigo-600"></i></div>
                    <span class="badge bg-indigo-100 text-indigo-700"><i class="fas fa-circle" style="font-size:5px"></i>Berjalan</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">6 <span class="text-sm font-normal text-gray-500">Sesi</span></h3>
                <p class="text-sm text-gray-600 mb-2">Sesi Audit Berjalan</p>
                <p class="text-xs text-gray-500">4 Cycle Count + 2 Wall-to-Wall</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center"><i class="fas fa-check-double text-green-600"></i></div>
                    <span class="badge bg-green-100 text-green-700">AQL 0,5</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">99,2%</h3>
                <p class="text-sm text-gray-600 mb-2">Akurasi Stok Fisik vs Sistem</p>
                <p class="text-xs text-gray-500">Optimal (AQL 0.5)</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center"><i class="fas fa-exclamation-triangle text-red-600"></i></div>
                    <span class="badge bg-red-100 text-red-700">Investigasi</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">5 <span class="text-sm font-normal text-gray-500">Temuan</span></h3>
                <p class="text-sm text-gray-600 mb-2">Discrepancy / Selisih Rekonsiliasi</p>
                <p class="text-xs text-red-600">Selisih Nilai Rp 1,45 Juta (0,08%) · 3 Kurang (-), 2 Lebih (+)</p>
            </div>
        </div>

        <!-- Zone progress cards -->
        <div class="panel p-4 lg:p-6 mb-6">
            <div class="flex items-center gap-2 mb-2">
                <i class="fas fa-map-marked-alt text-blue-600"></i>
                <h3 class="font-bold text-gray-900 text-sm lg:text-base">Status Pelaksanaan Audit per Zona Gudang Hub Cakung DC-01</h3>
                <button onclick="toast('Membuka denah layout gudang & heatmap discrepancy...','success')" class="ml-auto text-blue-600 text-xs font-medium hover:underline">Lihat Denah Layout Gudang &amp; Heatmap Discrepanty <i class="fas fa-arrow-right ml-1"></i></button>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                <!-- WH01-ZA -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="badge bg-amber-100 text-amber-700"><i class="fas fa-circle" style="font-size:5px"></i>Sedang Dihitung</span>
                        <span class="text-xs font-bold text-gray-400">WH01-ZA</span>
                    </div>
                    <p class="font-semibold text-gray-900 text-sm">Zona A (Elektronik &amp; Laptop)</p>
                    <p class="text-xs text-gray-500 mt-1 mb-3">Blind Count Tahap 2</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                        <div class="bg-amber-500 h-2 rounded-full progress-bar" style="width:96%"></div>
                    </div>
                    <p class="text-xs text-gray-600">Kemajuan Audit 96% <span class="text-gray-400">(380 / 395 SKU)</span></p>
                    <p class="text-xs text-gray-500 mt-2"><i class="fas fa-user mr-1"></i>Auditor Regu 1 (Handheld Zebra)</p>
                </div>
                <!-- WH01-ZB -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="badge bg-blue-100 text-blue-700"><i class="fas fa-circle" style="font-size:5px"></i>Verifikasi Selisih</span>
                        <span class="text-xs font-bold text-gray-400">WH01-ZB</span>
                    </div>
                    <p class="font-semibold text-gray-900 text-sm">Zona B (Audio &amp; Periferal)</p>
                    <p class="text-xs text-gray-500 mt-1 mb-3">Cycle Count Bulanan</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                        <div class="bg-green-500 h-2 rounded-full progress-bar" style="width:100%"></div>
                    </div>
                    <p class="text-xs text-gray-600">Kemajuan Audit 100% <span class="text-gray-400">(280 / 280 SKU)</span></p>
                    <p class="text-xs text-gray-500 mt-2"><i class="fas fa-user mr-1"></i>Auditor Regu 3 (Checker QC)</p>
                </div>
                <!-- WH02-ZC -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="badge bg-green-100 text-green-700"><i class="fas fa-circle" style="font-size:5px"></i>Selesai &amp; Match</span>
                        <span class="text-xs font-bold text-gray-400">WH02-ZC</span>
                    </div>
                    <p class="font-semibold text-gray-900 text-sm">Zona C (Storage &amp; SSD)</p>
                    <p class="text-xs text-gray-500 mt-1 mb-3">Audit Acak (Random Sampling)</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                        <div class="bg-blue-500 h-2 rounded-full progress-bar" style="width:40%"></div>
                    </div>
                    <p class="text-xs text-gray-600">Kemajuan Audit 40% <span class="text-gray-400">(120 / 300 SKU)</span></p>
                    <p class="text-xs text-gray-500 mt-2"><i class="fas fa-user mr-1"></i>Tim Internal Audit (Verified)</p>
                </div>
                <!-- WH02-ZD -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="badge bg-indigo-100 text-indigo-700"><i class="fas fa-circle" style="font-size:5px"></i>Berlangsung</span>
                        <span class="text-xs font-bold text-gray-400">WH02-ZD</span>
                    </div>
                    <p class="font-semibold text-gray-900 text-sm">Zona D (Kabel &amp; Aksesoris)</p>
                    <p class="text-xs text-gray-500 mt-1 mb-3">Cycle Count Berkala</p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                        <div class="bg-indigo-500 h-2 rounded-full progress-bar" style="width:85%"></div>
                    </div>
                    <p class="text-xs text-gray-600">Kemajuan Audit 85% <span class="text-gray-400">(425 / 500 SKU)</span></p>
                    <p class="text-xs text-gray-500 mt-2"><i class="fas fa-user mr-1"></i>Operator Scanner Regu B</p>
                </div>
            </div>
        </div>

        <!-- Filter bar -->
        <div class="panel p-4 mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center gap-3 mb-3">
                <div class="relative flex-1 min-w-[220px]">
                    <input id="searchSo" type="text" placeholder="Cari No. Berkas Opname, SKU, Nama Barang, Rak / Bin." class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                </div>
                <select id="fTipe" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option value="">Tipe Opname: Semua (Cycle / Blind / Annual)</option>
                    <option value="cycle">Cycle Count</option>
                    <option value="blind">Blind Count</option>
                    <option value="annual">Wall-to-Wall (Annual)</option>
                </select>
                <select id="fStatus" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option value="">Status Audit: Semua (Cocok / Selisih / Draft)</option>
                    <option value="match">Cocok / Match</option>
                    <option value="selisih">Ada Selisih / Discrepancy</option>
                    <option value="proses">Dalam Proses Hitung</option>
                </select>
                <select id="fZona" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option value="">Zona Gudang: Semua Zona</option>
                    <option value="wh01-za">WH01-ZA</option>
                    <option value="wh01-zb">WH01-ZB</option>
                    <option value="wh02-zc">WH02-ZC</option>
                    <option value="wh02-zd">WH02-ZD</option>
                </select>
            </div>
            <!-- Status chips -->
            <div class="flex flex-wrap items-center gap-2">
                <button class="filter-tag px-3 py-1.5 rounded-lg text-xs font-medium bg-blue-600 text-white" data-chip="all">Semua</button>
                <button class="filter-tag px-3 py-1.5 rounded-lg text-xs font-medium border border-gray-300 hover:bg-gray-50" data-chip="match">Selesai &amp; Match <span class="ml-1 text-green-500">(19)</span></button>
                <button class="filter-tag px-3 py-1.5 rounded-lg text-xs font-medium border border-gray-300 hover:bg-gray-50" data-chip="selisih">Ada Selisih / Discrepancy <span class="ml-1 text-red-500">(5)</span></button>
                <button class="filter-tag px-3 py-1.5 rounded-lg text-xs font-medium border border-gray-300 hover:bg-gray-50" data-chip="proses">Dalam Proses Hitung <span class="ml-1 text-amber-500">(3)</span></button>
                <button class="filter-tag px-3 py-1.5 rounded-lg text-xs font-medium border border-gray-300 hover:bg-gray-50" data-chip="approval">Menunggu Approval Kepala Hub <span class="ml-1 text-indigo-500">(1)</span></button>
            </div>
        </div>

        <!-- Table -->
        <div class="panel p-4 lg:p-6 mb-6">
            <div class="overflow-x-auto -mx-4 lg:mx-0">
                <table id="tblSo" class="w-full min-w-[1080px]">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase whitespace-nowrap">Detail Komoditas / SKU</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase whitespace-nowrap">Lokasi Rak / Bin</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase whitespace-nowrap">Sistem vs Fisik (Selisih)</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase whitespace-nowrap">Tim Auditor &amp; Checker</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase whitespace-nowrap">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row 1 -->
                        <tr class="table-row border-b border-gray-100" data-tipe="blind" data-status="selisih" data-zona="wh01-za" data-chip="selisih">
                            <td class="px-4 py-4 align-top">
                                <p class="text-blue-600 font-bold text-sm">SO-2025-0080</p>
                                <p class="text-xs text-gray-400 mt-1">12 Mar 2025 · 08:00 WIB</p>
                                <p class="font-semibold text-gray-900 text-sm mt-1">Apple MacBook Pro 14" M1 Pro</p>
                                <p class="text-xs text-gray-500">SKU-LAP-0821 · LAPTOP</p>
                            </td>
                            <td class="px-4 py-4 align-top whitespace-nowrap">
                                <p class="text-sm text-gray-700">WH01-ZA-RA01</p>
                                <p class="text-xs text-gray-500 mt-1">(Rak Tier 2)</p>
                                <span class="badge bg-blue-100 text-blue-700 mt-1"><i class="fas fa-map-marker-alt"></i>Zona A</span>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <p class="text-sm text-gray-700">Sistem: <strong>120 Unit</strong></p>
                                <p class="text-sm text-gray-700 mt-1">Fisik: <strong>118 Unit</strong></p>
                                <span class="badge bg-red-100 text-red-700 mt-1"><i class="fas fa-minus"></i>-2 Unit (-Rp 42,0 Jt)</span>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <p class="text-sm font-medium text-gray-900">Hendra Wijaya</p>
                                <p class="text-xs text-gray-500 mt-1">Auditor · LAPTOP Apple Inc.</p>
                                <p class="text-xs text-gray-400 mt-1">Checker: Rina</p>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <span class="badge bg-amber-100 text-amber-700"><i class="fas fa-exclamation-circle"></i>Perlu Rekonsiliasi</span>
                                <p class="text-xs text-gray-500 mt-1">Discrepancy Audit Fisik</p>
                            </td>
                            <td class="px-4 py-4 align-top whitespace-nowrap">
                                <div class="flex flex-col gap-1.5">
                                    <button onclick="openDetail('SO-2025-0080')" class="text-blue-600 hover:bg-blue-50 px-2 py-1 rounded text-xs"><i class="fas fa-eye"></i> Detail</button>
                                    <button onclick="toast('Membuka form rekonsiliasi SO-2025-0080...','warn')" class="text-amber-600 hover:bg-amber-50 px-2 py-1 rounded text-xs border border-amber-200"><i class="fas fa-balance-scale"></i> Rekonsiliasi</button>
                                </div>
                            </td>
                        </tr>
                        <!-- Row 2 -->
                        <tr class="table-row border-b border-gray-100" data-tipe="cycle" data-status="match" data-zona="wh02-zc" data-chip="match">
                            <td class="px-4 py-4 align-top">
                                <p class="text-blue-600 font-bold text-sm">SO-2025-0082</p>
                                <p class="text-xs text-gray-400 mt-1">12 Mar 2025 · 08:15 WIB</p>
                                <p class="font-semibold text-gray-900 text-sm mt-1">SanDisk Extreme Portable SSD 1TB NVMe</p>
                                <p class="text-xs text-gray-500">SKU-SSD-4410 · STORAGE</p>
                            </td>
                            <td class="px-4 py-4 align-top whitespace-nowrap">
                                <p class="text-sm text-gray-700">WH02-ZC-RC04</p>
                                <p class="text-xs text-gray-500 mt-1">(Bin 12)</p>
                                <span class="badge bg-blue-100 text-blue-700 mt-1"><i class="fas fa-map-marker-alt"></i>Zona C</span>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <p class="text-sm text-gray-700">Sistem: <strong>250 Unit</strong></p>
                                <p class="text-sm text-gray-700 mt-1">Fisik: <strong>250 Unit</strong></p>
                                <span class="badge bg-green-100 text-green-700 mt-1"><i class="fas fa-check"></i>+0 (Cocok 100%)</span>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <p class="text-sm font-medium text-gray-900">Teguh Arianto</p>
                                <p class="text-xs text-gray-500 mt-1">Auditor · STORAGE SanDisk</p>
                                <p class="text-xs text-gray-400 mt-1">Checker: Dimas</p>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <span class="badge bg-green-100 text-green-700"><i class="fas fa-check-circle"></i>Disetujui Match</span>
                                <p class="text-xs text-gray-500 mt-1">Audit Acak Random</p>
                            </td>
                            <td class="px-4 py-4 align-top whitespace-nowrap">
                                <div class="flex flex-col gap-1.5">
                                    <button onclick="openDetail('SO-2025-0082')" class="text-blue-600 hover:bg-blue-50 px-2 py-1 rounded text-xs"><i class="fas fa-eye"></i> Detail</button>
                                    <button onclick="toast('Ekspor berita acara SO-2025-0082 (PDF)...','success')" class="text-gray-600 hover:bg-gray-100 px-2 py-1 rounded text-xs"><i class="fas fa-file-export"></i> BASO</button>
                                </div>
                            </td>
                        </tr>
                        <!-- Row 3 -->
                        <tr class="table-row border-b border-gray-100" data-tipe="blind" data-status="selisih" data-zona="wh01-zb" data-chip="selisih">
                            <td class="px-4 py-4 align-top">
                                <p class="text-blue-600 font-bold text-sm">SO-2025-0083</p>
                                <p class="text-xs text-gray-400 mt-1">12 Mar 2025 · 08:30 WIB</p>
                                <p class="font-semibold text-gray-900 text-sm mt-1">Sony WH-1000XM4 Wireless Headphone</p>
                                <p class="text-xs text-gray-500">SKU-AUD-8302 · AUDIO</p>
                            </td>
                            <td class="px-4 py-4 align-top whitespace-nowrap">
                                <p class="text-sm text-gray-700">WH01-ZB-RB02</p>
                                <p class="text-xs text-gray-500 mt-1">(Tier 3)</p>
                                <span class="badge bg-blue-100 text-blue-700 mt-1"><i class="fas fa-map-marker-alt"></i>Zona B</span>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <p class="text-sm text-gray-700">Sistem: <strong>64 Unit</strong></p>
                                <p class="text-sm text-gray-700 mt-1">Fisik: <strong>68 Unit</strong></p>
                                <span class="badge bg-amber-100 text-amber-700 mt-1"><i class="fas fa-plus"></i>+4 Unit (+Rp 12,0 Jt)</span>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <p class="text-sm font-medium text-gray-900">Tim Auditor B</p>
                                <p class="text-xs text-gray-500 mt-1">Auditor · AUDIO Sony Corp.</p>
                                <p class="text-xs text-gray-400 mt-1">Checker: Siti</p>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <span class="badge bg-red-100 text-red-700"><i class="fas fa-search"></i>Sedang Investigasi</span>
                                <p class="text-xs text-gray-500 mt-1">Cek CCTV Lorong</p>
                            </td>
                            <td class="px-4 py-4 align-top whitespace-nowrap">
                                <div class="flex flex-col gap-1.5">
                                    <button onclick="openDetail('SO-2025-0083')" class="text-blue-600 hover:bg-blue-50 px-2 py-1 rounded text-xs"><i class="fas fa-eye"></i> Detail</button>
                                    <button onclick="toast('Membuka form rekonsiliasi SO-2025-0083...','warn')" class="text-amber-600 hover:bg-amber-50 px-2 py-1 rounded text-xs border border-amber-200"><i class="fas fa-balance-scale"></i> Rekonsiliasi</button>
                                </div>
                            </td>
                        </tr>
                        <!-- Row 4 -->
                        <tr class="table-row border-b border-gray-100" data-tipe="cycle" data-status="match" data-zona="wh01-zb" data-chip="match">
                            <td class="px-4 py-4 align-top">
                                <p class="text-blue-600 font-bold text-sm">SO-2025-0084</p>
                                <p class="text-xs text-gray-400 mt-1">12 Mar 2025 · 08:45 WIB</p>
                                <p class="font-semibold text-gray-900 text-sm mt-1">Keychron Q1 Pro Wireless Custom Mechanical</p>
                                <p class="text-xs text-gray-500">SKU-KEY-1092 · PERIFERAL</p>
                            </td>
                            <td class="px-4 py-4 align-top whitespace-nowrap">
                                <p class="text-sm text-gray-700">WH01-ZB-RB03</p>
                                <p class="text-xs text-gray-500 mt-1">(Bin 03)</p>
                                <span class="badge bg-blue-100 text-blue-700 mt-1"><i class="fas fa-map-marker-alt"></i>Zona B</span>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <p class="text-sm text-gray-700">Sistem: <strong>85 Unit</strong></p>
                                <p class="text-sm text-gray-700 mt-1">Fisik: <strong>85 Unit</strong></p>
                                <span class="badge bg-green-100 text-green-700 mt-1"><i class="fas fa-check"></i>+0 (Cocok 100%)</span>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <p class="text-sm font-medium text-gray-900">Rina Maryani</p>
                                <p class="text-xs text-gray-500 mt-1">Auditor · PERIFERAL Keychron</p>
                                <p class="text-xs text-gray-400 mt-1">Checker: Hendra W.</p>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <span class="badge bg-green-100 text-green-700"><i class="fas fa-check-circle"></i>Disetujui Match</span>
                                <p class="text-xs text-gray-500 mt-1">Cycle Count Bulanan</p>
                            </td>
                            <td class="px-4 py-4 align-top whitespace-nowrap">
                                <div class="flex flex-col gap-1.5">
                                    <button onclick="openDetail('SO-2025-0084')" class="text-blue-600 hover:bg-blue-50 px-2 py-1 rounded text-xs"><i class="fas fa-eye"></i> Detail</button>
                                    <button onclick="toast('Ekspor berita acara SO-2025-0084 (PDF)...','success')" class="text-gray-600 hover:bg-gray-100 px-2 py-1 rounded text-xs"><i class="fas fa-file-export"></i> BASO</button>
                                </div>
                            </td>
                        </tr>
                        <!-- Row 5 -->
                        <tr class="table-row border-b border-gray-100" data-tipe="blind" data-status="selisih" data-zona="wh01-za" data-chip="approval">
                            <td class="px-4 py-4 align-top">
                                <p class="text-blue-600 font-bold text-sm">SO-2025-0085</p>
                                <p class="text-xs text-gray-400 mt-1">12 Mar 2025 · 10:00 WIB</p>
                                <p class="font-semibold text-gray-900 text-sm mt-1">Canon EOS 60D Digital SLR Body Only</p>
                                <p class="text-xs text-gray-500">SKU-CAM-3104 · KAMERA</p>
                            </td>
                            <td class="px-4 py-4 align-top whitespace-nowrap">
                                <p class="text-sm text-gray-700">WH01-ZA-RA04</p>
                                <p class="text-xs text-gray-500 mt-1">(Locker VIP)</p>
                                <span class="badge bg-blue-100 text-blue-700 mt-1"><i class="fas fa-map-marker-alt"></i>Zona A</span>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <p class="text-sm text-gray-700">Sistem: <strong>15 Unit</strong></p>
                                <p class="text-sm text-gray-700 mt-1">Fisik: <strong>14 Unit</strong></p>
                                <span class="badge bg-red-100 text-red-700 mt-1"><i class="fas fa-minus"></i>-1 Unit (-Rp 7,5 Jt)</span>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <p class="text-sm font-medium text-gray-900">Dimas Setiawan</p>
                                <p class="text-xs text-gray-500 mt-1">Auditor · KAMERA Canon ID</p>
                                <p class="text-xs text-gray-400 mt-1">Checker: Kepala Hub</p>
                            </td>
                            <td class="px-4 py-4 align-top">
                                <span class="badge bg-indigo-100 text-indigo-700"><i class="fas fa-user-shield"></i>Perlu Rekonsiliasi</span>
                                <p class="text-xs text-gray-500 mt-1">Menunggu Approval Ka. Hub</p>
                            </td>
                            <td class="px-4 py-4 align-top whitespace-nowrap">
                                <div class="flex flex-col gap-1.5">
                                    <button onclick="openDetail('SO-2025-0085')" class="text-blue-600 hover:bg-blue-50 px-2 py-1 rounded text-xs"><i class="fas fa-eye"></i> Detail</button>
                                    <button onclick="toast('Adjustment SO-2025-0085 diajukan — menunggu persetujuan HR/Finance.','success')" class="text-indigo-600 hover:bg-indigo-50 px-2 py-1 rounded text-xs border border-indigo-200"><i class="fas fa-paper-plane"></i> Ajukan Adjustment</button>
                                </div>
                            </td>
                        </tr>

                        @extends('layouts.app')

                        @section('title', 'Stok Opname - Astro Inventory')

                        @section('content')

                        <style>
                            #stok-opname-page {
                                color: #0f172a;
                            }

                            #stok-opname-page .metric-card {
                                transition: transform .2s ease, box-shadow .2s ease;
                            }

                            #stok-opname-page .metric-card:hover {
                                transform: translateY(-2px);
                                box-shadow: 0 10px 20px -5px rgba(15, 23, 42, .12);
                            }

                            #stok-opname-page .panel {
                                background: #fff;
                                border: 1px solid #e2e8f0;
                                border-radius: 1rem;
                                box-shadow: 0 1px 2px rgba(15, 23, 42, .04);
                            }

                            #stok-opname-page .table-row {
                                transition: background-color .15s ease;
                            }

                            #stok-opname-page .table-row:hover {
                                background-color: #f8fafc;
                            }

                            #stok-opname-page .progress-bar {
                                transition: width .5s ease;
                            }

                            #stok-opname-page .badge {
                                display: inline-flex;
                                align-items: center;
                                gap: .3rem;
                                padding: .25rem .65rem;
                                border-radius: 9999px;
                                font-size: .7rem;
                                font-weight: 600;
                                white-space: nowrap;
                            }

                            #stok-opname-page .filter-tag {
                                transition: all .15s ease;
                            }

                            #stok-opname-page .filter-tag.active {
                                background: #2563eb;
                                color: #fff;
                                border-color: #2563eb;
                            }

                            #stok-opname-page .modal-overlay {
                                position: fixed;
                                inset: 0;
                                background: rgba(15, 23, 42, .55);
                                display: none;
                                align-items: flex-start;
                                justify-content: center;
                                z-index: 100;
                                padding: 5vh 1rem 1rem;
                                overflow-y: auto;
                            }

                            #stok-opname-page .modal-overlay.open {
                                display: flex;
                            }

                            #stok-opname-page .modal-box {
                                width: 100%;
                                max-width: 640px;
                                background: #fff;
                                border-radius: 1rem;
                                box-shadow: 0 20px 50px -10px rgba(0, 0, 0, .3);
                                animation: soModalIn .18s ease;
                            }

                            @keyframes soModalIn {
                                from {
                                    opacity: 0;
                                    transform: translateY(12px) scale(.98);
                                }

                                to {
                                    opacity: 1;
                                    transform: none;
                                }
                            }

                            #stok-opname-page .so-toast-container {
                                position: fixed;
                                right: 1rem;
                                bottom: 1rem;
                                z-index: 150;
                                display: flex;
                                flex-direction: column;
                                gap: .5rem;
                            }

                            #stok-opname-page .so-toast {
                                background: #fff;
                                border: 1px solid #e2e8f0;
                                border-left: 4px solid #2563eb;
                                border-radius: .75rem;
                                padding: .75rem 1rem;
                                box-shadow: 0 8px 20px -6px rgba(0, 0, 0, .18);
                                font-size: .875rem;
                                max-width: 340px;
                                animation: soToastIn .2s ease;
                            }

                            #stok-opname-page .so-toast.success {
                                border-left-color: #16a34a;
                            }

                            #stok-opname-page .so-toast.warn {
                                border-left-color: #f59e0b;
                            }

                            #stok-opname-page .so-toast.error {
                                border-left-color: #dc2626;
                            }

                            @keyframes soToastIn {
                                from {
                                    opacity: 0;
                                    transform: translateX(20px);
                                }

                                to {
                                    opacity: 1;
                                    transform: none;
                                }
                            }

                            #stok-opname-page .no-scrollbar::-webkit-scrollbar {
                                display: none;
                            }

                            #stok-opname-page .no-scrollbar {
                                scrollbar-width: none;
                            }

                            @media (max-width: 640px) {
                                #stok-opname-page .modal-overlay {
                                    padding: 1rem .5rem;
                                }
                            }
                        </style>

                        <div id="stok-opname-page" class="space-y-6 animate-fade-in">

                            {{-- Komponen utama Laravel --}}
                            @include('components.navbar')
                            @include('components.sidebar')

                            <div class="ml-64 lg:ml-264 min-h-screen pt-6 pb-6 animate-fade-in">
                                <div class="max-w-7xl mx-auto px-4 sm:px-6">

                                    {{-- Breadcrumb --}}
                                    <div class="flex items-center gap-2 text-sm text-slate-500 mb-5 overflow-x-auto whitespace-nowrap">
                                        <span>Operasional &amp; Transaksi</span>
                                        <i class="fas fa-chevron-right text-xs"></i>
                                        <span>Stok Opname &amp; Audit Fisik Inventaris</span>
                                        <i class="fas fa-chevron-right text-xs"></i>
                                        <span class="text-slate-900 font-semibold">Stok Opname</span>
                                    </div>

                                    {{-- Header halaman --}}
                                    <div class="flex flex-col xl:flex-row xl:items-start xl:justify-between gap-5 mb-6">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                                    <i class="fas fa-clipboard-check text-lg"></i>
                                                </div>
                                                <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider">
                                                    Inventory Control
                                                </span>
                                            </div>

                                            <h1 class="text-2xl font-bold text-slate-900 mb-2">
                                                Stok Opname (Stock Count &amp; Audit Fisik)
                                            </h1>

                                            <p class="text-sm text-slate-600 leading-relaxed max-w-3xl">
                                                Pencocokan kuantitas stok fisik gudang terhadap sistem ledger secara berkala
                                                (cycle count &amp; wall-to-wall), identifikasi selisih (discrepancy), serta
                                                penyesuaian inventaris resmi Hub Cakung DC-01.
                                            </p>
                                        </div>

                                        <div class="flex flex-col gap-3 xl:items-end">
                                            <div class="flex flex-wrap gap-2">
                                                <span class="badge bg-blue-100 text-blue-700">
                                                    <i class="fas fa-calendar-check"></i>
                                                    Jadwal Audit Siklus Q1 2025
                                                </span>
                                                <span class="badge bg-green-100 text-green-700">
                                                    <i class="fas fa-chart-line"></i>
                                                    Progress Audit 68,4%
                                                </span>
                                                <span class="badge bg-amber-100 text-amber-700">
                                                    <i class="fas fa-ruler"></i>
                                                    Toleransi Selisih &lt; 0,2%
                                                </span>
                                            </div>

                                            <div class="flex flex-wrap gap-2">
                                                <button type="button"
                                                    onclick="toast('Menyiapkan ekspor Hasil Audit (Excel/PDF)...','success')"
                                                    class="px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 flex items-center gap-2 text-sm font-medium">
                                                    <i class="fas fa-file-export"></i>
                                                    Ekspor Hasil Audit
                                                </button>

                                                <button type="button"
                                                    onclick="openModal('modalTim')"
                                                    class="px-4 py-2.5 border border-slate-300 bg-white rounded-xl hover:bg-slate-50 text-sm flex items-center gap-2 font-medium text-slate-700">
                                                    <i class="fas fa-users"></i>
                                                    Jadwal Tim Auditor
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Statistik --}}
                                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

                                        <div class="metric-card panel p-5">
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="w-11 h-11 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                                                    <i class="fas fa-barcode text-lg"></i>
                                                </div>
                                                <span class="badge bg-blue-100 text-blue-700">Hari Ini</span>
                                            </div>

                                            <h3 class="text-2xl font-bold text-slate-900">
                                                1.845 <span class="text-sm font-normal text-slate-500">SKU</span>
                                            </h3>
                                            <p class="text-sm text-slate-600 mt-1">Total SKU Di-Audit Hari Ini</p>
                                            <p class="text-xs text-green-600 mt-3">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                1.742 SKU Cocok 100%
                                            </p>
                                        </div>

                                        <div class="metric-card panel p-5">
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="w-11 h-11 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center">
                                                    <i class="fas fa-clipboard-list text-lg"></i>
                                                </div>
                                                <span class="badge bg-indigo-100 text-indigo-700">Berjalan</span>
                                            </div>

                                            <h3 class="text-2xl font-bold text-slate-900">
                                                6 <span class="text-sm font-normal text-slate-500">Sesi</span>
                                            </h3>
                                            <p class="text-sm text-slate-600 mt-1">Sesi Audit Berjalan</p>
                                            <p class="text-xs text-slate-500 mt-3">
                                                4 Cycle Count + 2 Wall-to-Wall
                                            </p>
                                        </div>

                                        <div class="metric-card panel p-5">
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="w-11 h-11 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
                                                    <i class="fas fa-check-double text-lg"></i>
                                                </div>
                                                <span class="badge bg-green-100 text-green-700">AQL 0,5</span>
                                            </div>

                                            <h3 class="text-2xl font-bold text-slate-900">99,2%</h3>
                                            <p class="text-sm text-slate-600 mt-1">Akurasi Stok Fisik vs Sistem</p>
                                            <p class="text-xs text-slate-500 mt-3">Optimal (AQL 0.5)</p>
                                        </div>

                                        <div class="metric-card panel p-5">
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="w-11 h-11 bg-red-100 text-red-600 rounded-xl flex items-center justify-center">
                                                    <i class="fas fa-exclamation-triangle text-lg"></i>
                                                </div>
                                                <span class="badge bg-red-100 text-red-700">Investigasi</span>
                                            </div>

                                            <h3 class="text-2xl font-bold text-slate-900">
                                                5 <span class="text-sm font-normal text-slate-500">Temuan</span>
                                            </h3>
                                            <p class="text-sm text-slate-600 mt-1">Discrepancy / Selisih Rekonsiliasi</p>
                                            <p class="text-xs text-red-600 mt-3">
                                                Selisih Rp 1,45 Juta (0,08%) · 3 Kurang, 2 Lebih
                                            </p>
                                        </div>

                                    </div>

                                    {{-- Progres zona gudang --}}
                                    <div class="panel p-5 lg:p-6 mb-6">
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-4">
                                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                                <i class="fas fa-map-marked-alt"></i>
                                            </div>

                                            <div class="flex-1">
                                                <h3 class="font-bold text-slate-900">
                                                    Status Pelaksanaan Audit per Zona Gudang
                                                </h3>
                                                <p class="text-xs text-slate-500 mt-1">
                                                    Hub Cakung DC-01
                                                </p>
                                            </div>

                                            <button type="button"
                                                onclick="toast('Membuka denah layout gudang & heatmap discrepancy...','success')"
                                                class="text-blue-600 text-xs font-semibold hover:underline">
                                                Lihat Denah Layout Gudang
                                                <i class="fas fa-arrow-right ml-1"></i>
                                            </button>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

                                            {{-- Zona A --}}
                                            <div class="border border-slate-200 rounded-xl p-4">
                                                <div class="flex items-center justify-between gap-2 mb-3">
                                                    <span class="badge bg-amber-100 text-amber-700">Sedang Dihitung</span>
                                                    <span class="text-xs font-bold text-slate-400">WH01-ZA</span>
                                                </div>
                                                <p class="font-semibold text-slate-900 text-sm">Zona A (Elektronik &amp; Laptop)</p>
                                                <p class="text-xs text-slate-500 mt-1 mb-4">Blind Count Tahap 2</p>

                                                <div class="w-full bg-slate-100 rounded-full h-2 mb-2">
                                                    <div class="bg-amber-500 h-2 rounded-full progress-bar" style="width:96%"></div>
                                                </div>

                                                <p class="text-xs text-slate-600">
                                                    Kemajuan Audit <strong>96%</strong>
                                                    <span class="text-slate-400">(380 / 395 SKU)</span>
                                                </p>
                                                <p class="text-xs text-slate-500 mt-3">
                                                    <i class="fas fa-user mr-1"></i>
                                                    Auditor Regu 1
                                                </p>
                                            </div>

                                            {{-- Zona B --}}
                                            <div class="border border-slate-200 rounded-xl p-4">
                                                <div class="flex items-center justify-between gap-2 mb-3">
                                                    <span class="badge bg-blue-100 text-blue-700">Verifikasi Selisih</span>
                                                    <span class="text-xs font-bold text-slate-400">WH01-ZB</span>
                                                </div>
                                                <p class="font-semibold text-slate-900 text-sm">Zona B (Audio &amp; Periferal)</p>
                                                <p class="text-xs text-slate-500 mt-1 mb-4">Cycle Count Bulanan</p>

                                                <div class="w-full bg-slate-100 rounded-full h-2 mb-2">
                                                    <div class="bg-green-500 h-2 rounded-full progress-bar" style="width:100%"></div>
                                                </div>

                                                <p class="text-xs text-slate-600">
                                                    Kemajuan Audit <strong>100%</strong>
                                                    <span class="text-slate-400">(280 / 280 SKU)</span>
                                                </p>
                                                <p class="text-xs text-slate-500 mt-3">
                                                    <i class="fas fa-user mr-1"></i>
                                                    Auditor Regu 3
                                                </p>
                                            </div>

                                            {{-- Zona C --}}
                                            <div class="border border-slate-200 rounded-xl p-4">
                                                <div class="flex items-center justify-between gap-2 mb-3">
                                                    <span class="badge bg-green-100 text-green-700">Selesai &amp; Match</span>
                                                    <span class="text-xs font-bold text-slate-400">WH02-ZC</span>
                                                </div>
                                                <p class="font-semibold text-slate-900 text-sm">Zona C (Storage &amp; SSD)</p>
                                                <p class="text-xs text-slate-500 mt-1 mb-4">Audit Acak (Random Sampling)</p>

                                                <div class="w-full bg-slate-100 rounded-full h-2 mb-2">
                                                    <div class="bg-blue-500 h-2 rounded-full progress-bar" style="width:40%"></div>
                                                </div>

                                                <p class="text-xs text-slate-600">
                                                    Kemajuan Audit <strong>40%</strong>
                                                    <span class="text-slate-400">(120 / 300 SKU)</span>
                                                </p>
                                                <p class="text-xs text-slate-500 mt-3">
                                                    <i class="fas fa-user mr-1"></i>
                                                    Tim Internal Audit
                                                </p>
                                            </div>

                                            {{-- Zona D --}}
                                            <div class="border border-slate-200 rounded-xl p-4">
                                                <div class="flex items-center justify-between gap-2 mb-3">
                                                    <span class="badge bg-indigo-100 text-indigo-700">Berlangsung</span>
                                                    <span class="text-xs font-bold text-slate-400">WH02-ZD</span>
                                                </div>
                                                <p class="font-semibold text-slate-900 text-sm">Zona D (Kabel &amp; Aksesoris)</p>
                                                <p class="text-xs text-slate-500 mt-1 mb-4">Cycle Count Berkala</p>

                                                <div class="w-full bg-slate-100 rounded-full h-2 mb-2">
                                                    <div class="bg-indigo-500 h-2 rounded-full progress-bar" style="width:85%"></div>
                                                </div>

                                                <p class="text-xs text-slate-600">
                                                    Kemajuan Audit <strong>85%</strong>
                                                    <span class="text-slate-400">(425 / 500 SKU)</span>
                                                </p>
                                                <p class="text-xs text-slate-500 mt-3">
                                                    <i class="fas fa-user mr-1"></i>
                                                    Operator Scanner Regu B
                                                </p>
                                            </div>

                                        </div>
                                    </div>

                                    {{-- Filter pencarian --}}
                                    <div class="panel p-5 mb-6">
                                        <div class="grid grid-cols-1 lg:grid-cols-4 gap-3 mb-4">

                                            <div class="relative lg:col-span-1">
                                                <i class="fas fa-search absolute left-3 top-3 text-slate-400 text-sm"></i>
                                                <input id="searchSo" type="text"
                                                    placeholder="Cari nomor opname, SKU, barang, rak..."
                                                    class="w-full pl-9 pr-3 py-2.5 text-sm border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>

                                            <select id="fTipe"
                                                class="px-3 py-2.5 border border-slate-300 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="">Semua Tipe Opname</option>
                                                <option value="cycle">Cycle Count</option>
                                                <option value="blind">Blind Count</option>
                                                <option value="annual">Wall-to-Wall (Annual)</option>
                                            </select>

                                            <select id="fStatus"
                                                class="px-3 py-2.5 border border-slate-300 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="">Semua Status Audit</option>
                                                <option value="match">Cocok / Match</option>
                                                <option value="selisih">Ada Selisih</option>
                                                <option value="proses">Dalam Proses</option>
                                            </select>

                                            <select id="fZona"
                                                class="px-3 py-2.5 border border-slate-300 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="">Semua Zona Gudang</option>
                                                <option value="wh01-za">WH01-ZA</option>
                                                <option value="wh01-zb">WH01-ZB</option>
                                                <option value="wh02-zc">WH02-ZC</option>
                                                <option value="wh02-zd">WH02-ZD</option>
                                            </select>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-2">
                                            <button type="button" data-chip="all"
                                                class="filter-tag active px-3 py-2 rounded-lg text-xs font-semibold border border-blue-600">
                                                Semua
                                            </button>

                                            <button type="button" data-chip="match"
                                                class="filter-tag px-3 py-2 rounded-lg text-xs font-medium border border-slate-300 text-slate-600">
                                                Selesai &amp; Match (19)
                                            </button>

                                            <button type="button" data-chip="selisih"
                                                class="filter-tag px-3 py-2 rounded-lg text-xs font-medium border border-slate-300 text-slate-600">
                                                Ada Selisih (5)
                                            </button>

                                            <button type="button" data-chip="proses"
                                                class="filter-tag px-3 py-2 rounded-lg text-xs font-medium border border-slate-300 text-slate-600">
                                                Dalam Proses (3)
                                            </button>

                                            <button type="button" data-chip="approval"
                                                class="filter-tag px-3 py-2 rounded-lg text-xs font-medium border border-slate-300 text-slate-600">
                                                Menunggu Approval (1)
                                            </button>

                                            <button type="button" id="resetFilter"
                                                class="ml-auto text-xs text-blue-600 font-semibold hover:underline">
                                                <i class="fas fa-undo mr-1"></i>Reset Filter
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Tabel stok opname --}}
                                    <div class="panel p-5 lg:p-6 mb-6">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
                                            <div>
                                                <h3 class="font-bold text-slate-900 text-lg">Daftar Sesi Stok Opname</h3>
                                                <p class="text-xs text-slate-500 mt-1">
                                                    Data pemeriksaan stok fisik dan pencocokan sistem inventaris
                                                </p>
                                            </div>

                                            <span class="badge bg-blue-100 text-blue-700">
                                                <i class="fas fa-database"></i>
                                                7 Data Contoh
                                            </span>
                                        </div>

                                        <div class="overflow-x-auto -mx-5 lg:mx-0">
                                            <table id="tblSo" class="w-full min-w-[1100px]">
                                                <thead>
                                                    <tr class="border-b border-slate-200 bg-slate-50">
                                                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Detail Komoditas / SKU</th>
                                                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Lokasi Rak / Bin</th>
                                                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Sistem vs Fisik</th>
                                                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Auditor &amp; Checker</th>
                                                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Status</th>
                                                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Aksi</th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    {{-- Baris 1 --}}
                                                    <tr class="table-row border-b border-slate-100"
                                                        data-tipe="blind" data-status="selisih" data-zona="wh01-za" data-chip="selisih">
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-blue-600 font-bold text-sm">SO-2025-0080</p>
                                                            <p class="text-xs text-slate-400 mt-1">12 Mar 2025 · 08:00 WIB</p>
                                                            <p class="font-semibold text-slate-900 text-sm mt-2">Apple MacBook Pro 14" M1 Pro</p>
                                                            <p class="text-xs text-slate-500">SKU-LAP-0821 · LAPTOP</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm text-slate-700">WH01-ZA-RA01</p>
                                                            <p class="text-xs text-slate-500 mt-1">Rak Tier 2</p>
                                                            <span class="badge bg-blue-100 text-blue-700 mt-2">Zona A</span>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm text-slate-700">Sistem: <strong>120 Unit</strong></p>
                                                            <p class="text-sm text-slate-700 mt-1">Fisik: <strong>118 Unit</strong></p>
                                                            <span class="badge bg-red-100 text-red-700 mt-2">-2 Unit (-Rp 42,0 Jt)</span>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm font-semibold text-slate-900">Hendra Wijaya</p>
                                                            <p class="text-xs text-slate-500 mt-1">Auditor · LAPTOP Apple Inc.</p>
                                                            <p class="text-xs text-slate-400 mt-1">Checker: Rina</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <span class="badge bg-amber-100 text-amber-700">Perlu Rekonsiliasi</span>
                                                            <p class="text-xs text-slate-500 mt-2">Discrepancy Audit Fisik</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <div class="flex flex-col gap-2">
                                                                <button type="button" onclick="openDetail('SO-2025-0080')"
                                                                    class="text-blue-600 hover:bg-blue-50 px-3 py-2 rounded-lg text-xs text-left">
                                                                    <i class="fas fa-eye mr-1"></i>Detail
                                                                </button>
                                                                <button type="button"
                                                                    onclick="toast('Membuka form rekonsiliasi SO-2025-0080...','warn')"
                                                                    class="text-amber-600 hover:bg-amber-50 px-3 py-2 rounded-lg text-xs text-left">
                                                                    <i class="fas fa-balance-scale mr-1"></i>Rekonsiliasi
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    {{-- Baris 2 --}}
                                                    <tr class="table-row border-b border-slate-100"
                                                        data-tipe="cycle" data-status="match" data-zona="wh02-zc" data-chip="match">
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-blue-600 font-bold text-sm">SO-2025-0082</p>
                                                            <p class="text-xs text-slate-400 mt-1">12 Mar 2025 · 08:15 WIB</p>
                                                            <p class="font-semibold text-slate-900 text-sm mt-2">SanDisk Extreme Portable SSD 1TB NVMe</p>
                                                            <p class="text-xs text-slate-500">SKU-SSD-4410 · STORAGE</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm text-slate-700">WH02-ZC-RC04</p>
                                                            <p class="text-xs text-slate-500 mt-1">Bin 12</p>
                                                            <span class="badge bg-blue-100 text-blue-700 mt-2">Zona C</span>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm text-slate-700">Sistem: <strong>250 Unit</strong></p>
                                                            <p class="text-sm text-slate-700 mt-1">Fisik: <strong>250 Unit</strong></p>
                                                            <span class="badge bg-green-100 text-green-700 mt-2">+0 (Cocok 100%)</span>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm font-semibold text-slate-900">Teguh Arianto</p>
                                                            <p class="text-xs text-slate-500 mt-1">Auditor · STORAGE SanDisk</p>
                                                            <p class="text-xs text-slate-400 mt-1">Checker: Dimas</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <span class="badge bg-green-100 text-green-700">Disetujui Match</span>
                                                            <p class="text-xs text-slate-500 mt-2">Audit Acak Random</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <div class="flex flex-col gap-2">
                                                                <button type="button" onclick="openDetail('SO-2025-0082')"
                                                                    class="text-blue-600 hover:bg-blue-50 px-3 py-2 rounded-lg text-xs text-left">
                                                                    <i class="fas fa-eye mr-1"></i>Detail
                                                                </button>
                                                                <button type="button"
                                                                    onclick="toast('Ekspor berita acara SO-2025-0082 (PDF)...','success')"
                                                                    class="text-slate-600 hover:bg-slate-100 px-3 py-2 rounded-lg text-xs text-left">
                                                                    <i class="fas fa-file-export mr-1"></i>BASO
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    {{-- Baris 3 --}}
                                                    <tr class="table-row border-b border-slate-100"
                                                        data-tipe="blind" data-status="selisih" data-zona="wh01-zb" data-chip="selisih">
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-blue-600 font-bold text-sm">SO-2025-0083</p>
                                                            <p class="text-xs text-slate-400 mt-1">12 Mar 2025 · 08:30 WIB</p>
                                                            <p class="font-semibold text-slate-900 text-sm mt-2">Sony WH-1000XM4 Wireless Headphone</p>
                                                            <p class="text-xs text-slate-500">SKU-AUD-8302 · AUDIO</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm text-slate-700">WH01-ZB-RB02</p>
                                                            <p class="text-xs text-slate-500 mt-1">Tier 3</p>
                                                            <span class="badge bg-blue-100 text-blue-700 mt-2">Zona B</span>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm text-slate-700">Sistem: <strong>64 Unit</strong></p>
                                                            <p class="text-sm text-slate-700 mt-1">Fisik: <strong>68 Unit</strong></p>
                                                            <span class="badge bg-amber-100 text-amber-700 mt-2">+4 Unit (+Rp 12,0 Jt)</span>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm font-semibold text-slate-900">Tim Auditor B</p>
                                                            <p class="text-xs text-slate-500 mt-1">Auditor · AUDIO Sony Corp.</p>
                                                            <p class="text-xs text-slate-400 mt-1">Checker: Siti</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <span class="badge bg-red-100 text-red-700">Sedang Investigasi</span>
                                                            <p class="text-xs text-slate-500 mt-2">Cek CCTV Lorong</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <div class="flex flex-col gap-2">
                                                                <button type="button" onclick="openDetail('SO-2025-0083')"
                                                                    class="text-blue-600 hover:bg-blue-50 px-3 py-2 rounded-lg text-xs text-left">
                                                                    <i class="fas fa-eye mr-1"></i>Detail
                                                                </button>
                                                                <button type="button"
                                                                    onclick="toast('Membuka form rekonsiliasi SO-2025-0083...','warn')"
                                                                    class="text-amber-600 hover:bg-amber-50 px-3 py-2 rounded-lg text-xs text-left">
                                                                    <i class="fas fa-balance-scale mr-1"></i>Rekonsiliasi
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    {{-- Baris 4 --}}
                                                    <tr class="table-row border-b border-slate-100"
                                                        data-tipe="cycle" data-status="match" data-zona="wh01-zb" data-chip="match">
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-blue-600 font-bold text-sm">SO-2025-0084</p>
                                                            <p class="text-xs text-slate-400 mt-1">12 Mar 2025 · 08:45 WIB</p>
                                                            <p class="font-semibold text-slate-900 text-sm mt-2">Keychron Q1 Pro Wireless Custom Mechanical</p>
                                                            <p class="text-xs text-slate-500">SKU-KEY-1092 · PERIFERAL</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm text-slate-700">WH01-ZB-RB03</p>
                                                            <p class="text-xs text-slate-500 mt-1">Bin 03</p>
                                                            <span class="badge bg-blue-100 text-blue-700 mt-2">Zona B</span>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm text-slate-700">Sistem: <strong>85 Unit</strong></p>
                                                            <p class="text-sm text-slate-700 mt-1">Fisik: <strong>85 Unit</strong></p>
                                                            <span class="badge bg-green-100 text-green-700 mt-2">+0 (Cocok 100%)</span>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm font-semibold text-slate-900">Rina Maryani</p>
                                                            <p class="text-xs text-slate-500 mt-1">Auditor · PERIFERAL Keychron</p>
                                                            <p class="text-xs text-slate-400 mt-1">Checker: Hendra W.</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <span class="badge bg-green-100 text-green-700">Disetujui Match</span>
                                                            <p class="text-xs text-slate-500 mt-2">Cycle Count Bulanan</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <div class="flex flex-col gap-2">
                                                                <button type="button" onclick="openDetail('SO-2025-0084')"
                                                                    class="text-blue-600 hover:bg-blue-50 px-3 py-2 rounded-lg text-xs text-left">
                                                                    <i class="fas fa-eye mr-1"></i>Detail
                                                                </button>
                                                                <button type="button"
                                                                    onclick="toast('Ekspor berita acara SO-2025-0084 (PDF)...','success')"
                                                                    class="text-slate-600 hover:bg-slate-100 px-3 py-2 rounded-lg text-xs text-left">
                                                                    <i class="fas fa-file-export mr-1"></i>BASO
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    {{-- Baris 5 --}}
                                                    <tr class="table-row border-b border-slate-100"
                                                        data-tipe="blind" data-status="selisih" data-zona="wh01-za" data-chip="approval">
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-blue-600 font-bold text-sm">SO-2025-0085</p>
                                                            <p class="text-xs text-slate-400 mt-1">12 Mar 2025 · 10:00 WIB</p>
                                                            <p class="font-semibold text-slate-900 text-sm mt-2">Canon EOS 60D Digital SLR Body Only</p>
                                                            <p class="text-xs text-slate-500">SKU-CAM-3104 · KAMERA</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm text-slate-700">WH01-ZA-RA04</p>
                                                            <p class="text-xs text-slate-500 mt-1">Locker VIP</p>
                                                            <span class="badge bg-blue-100 text-blue-700 mt-2">Zona A</span>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm text-slate-700">Sistem: <strong>15 Unit</strong></p>
                                                            <p class="text-sm text-slate-700 mt-1">Fisik: <strong>14 Unit</strong></p>
                                                            <span class="badge bg-red-100 text-red-700 mt-2">-1 Unit (-Rp 7,5 Jt)</span>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm font-semibold text-slate-900">Dimas Setiawan</p>
                                                            <p class="text-xs text-slate-500 mt-1">Auditor · KAMERA Canon ID</p>
                                                            <p class="text-xs text-slate-400 mt-1">Checker: Kepala Hub</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <span class="badge bg-indigo-100 text-indigo-700">Perlu Rekonsiliasi</span>
                                                            <p class="text-xs text-slate-500 mt-2">Menunggu Approval Ka. Hub</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <div class="flex flex-col gap-2">
                                                                <button type="button" onclick="openDetail('SO-2025-0085')"
                                                                    class="text-blue-600 hover:bg-blue-50 px-3 py-2 rounded-lg text-xs text-left">
                                                                    <i class="fas fa-eye mr-1"></i>Detail
                                                                </button>
                                                                <button type="button"
                                                                    onclick="toast('Adjustment SO-2025-0085 diajukan — menunggu persetujuan HR/Finance.','success')"
                                                                    class="text-indigo-600 hover:bg-indigo-50 px-3 py-2 rounded-lg text-xs text-left">
                                                                    <i class="fas fa-paper-plane mr-1"></i>Ajukan Adjustment
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    {{-- Baris 6 --}}
                                                    <tr class="table-row border-b border-slate-100"
                                                        data-tipe="cycle" data-status="match" data-zona="wh02-zd" data-chip="match">
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-blue-600 font-bold text-sm">SO-2025-0088</p>
                                                            <p class="text-xs text-slate-400 mt-1">12 Mar 2025 · 10:15 WIB</p>
                                                            <p class="font-semibold text-slate-900 text-sm mt-2">Zebra TC21 Industrial Handheld Scanner</p>
                                                            <p class="text-xs text-slate-500">SKU-SCN-0055 · EQUIPMENT</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm text-slate-700">WH02-ZD-RD01</p>
                                                            <p class="text-xs text-slate-500 mt-1">Rak 01</p>
                                                            <span class="badge bg-blue-100 text-blue-700 mt-2">Zona D</span>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm text-slate-700">Sistem: <strong>40 Unit</strong></p>
                                                            <p class="text-sm text-slate-700 mt-1">Fisik: <strong>40 Unit</strong></p>
                                                            <span class="badge bg-green-100 text-green-700 mt-2">+0 (Cocok 100%)</span>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm font-semibold text-slate-900">Agus Ridwan</p>
                                                            <p class="text-xs text-slate-500 mt-1">Auditor · EQUIPMENT Zebra Tech</p>
                                                            <p class="text-xs text-slate-400 mt-1">Checker: Teguh A.</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <span class="badge bg-green-100 text-green-700">Disetujui Match</span>
                                                            <p class="text-xs text-slate-500 mt-2">Cycle Count Berkala</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <div class="flex flex-col gap-2">
                                                                <button type="button" onclick="openDetail('SO-2025-0088')"
                                                                    class="text-blue-600 hover:bg-blue-50 px-3 py-2 rounded-lg text-xs text-left">
                                                                    <i class="fas fa-eye mr-1"></i>Detail
                                                                </button>
                                                                <button type="button"
                                                                    onclick="toast('Ekspor berita acara SO-2025-0088 (PDF)...','success')"
                                                                    class="text-slate-600 hover:bg-slate-100 px-3 py-2 rounded-lg text-xs text-left">
                                                                    <i class="fas fa-file-export mr-1"></i>BASO
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    {{-- Baris 7 --}}
                                                    <tr class="table-row"
                                                        data-tipe="cycle" data-status="match" data-zona="wh02-zc" data-chip="match">
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-blue-600 font-bold text-sm">SO-2025-0087</p>
                                                            <p class="text-xs text-slate-400 mt-1">12 Mar 2025 · 09:30 WIB</p>
                                                            <p class="font-semibold text-slate-900 text-sm mt-2">Corsair Vengeance DDR5 32GB (2x16GB) 6000MHz</p>
                                                            <p class="text-xs text-slate-500">SKU-RAM-7721 · KOMPONEN</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm text-slate-700">WH02-ZC-RC02</p>
                                                            <p class="text-xs text-slate-500 mt-1">Bin 08</p>
                                                            <span class="badge bg-blue-100 text-blue-700 mt-2">Zona C</span>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm text-slate-700">Sistem: <strong>180 Unit</strong></p>
                                                            <p class="text-sm text-slate-700 mt-1">Fisik: <strong>180 Unit</strong></p>
                                                            <span class="badge bg-green-100 text-green-700 mt-2">+0 (Cocok 100%)</span>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <p class="text-sm font-semibold text-slate-900">Siti Lastari</p>
                                                            <p class="text-xs text-slate-500 mt-1">Auditor · KOMPONEN Corsair</p>
                                                            <p class="text-xs text-slate-400 mt-1">Checker: Tim Auditor</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <span class="badge bg-green-100 text-green-700">Disetujui Match</span>
                                                            <p class="text-xs text-slate-500 mt-2">Audit Acak Random</p>
                                                        </td>
                                                        <td class="px-4 py-4 align-top">
                                                            <div class="flex flex-col gap-2">
                                                                <button type="button" onclick="openDetail('SO-2025-0087')"
                                                                    class="text-blue-600 hover:bg-blue-50 px-3 py-2 rounded-lg text-xs text-left">
                                                                    <i class="fas fa-eye mr-1"></i>Detail
                                                                </button>
                                                                <button type="button"
                                                                    onclick="toast('Ekspor berita acara SO-2025-0087 (PDF)...','success')"
                                                                    class="text-slate-600 hover:bg-slate-100 px-3 py-2 rounded-lg text-xs text-left">
                                                                    <i class="fas fa-file-export mr-1"></i>BASO
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- Pagination --}}
                                        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-5 pt-4 border-t border-slate-100">
                                            <span id="soInfo" class="text-sm text-slate-500">
                                                Menampilkan 1-7 dari 7 data contoh
                                            </span>
                                            <div id="soPager" class="flex items-center gap-1"></div>
                                        </div>
                                    </div>

                                    {{-- Fitur pendukung --}}
                                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">

                                        <div class="panel p-5">
                                            <div class="flex items-center gap-3 mb-3">
                                                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                                                    <i class="fas fa-eye-slash"></i>
                                                </div>
                                                <h3 class="font-bold text-slate-900 text-sm">
                                                    Blind Count &amp; Two-Way Verification
                                                </h3>
                                            </div>

                                            <p class="text-xs text-slate-600 leading-relaxed mb-4">
                                                Pencacahan fisik tanpa menampilkan kuantitas stok buku sistem di layar
                                                terminal scanner genggam petugas lapangan untuk menjamin objektivitas
                                                hitungan fisik 100% independen.
                                            </p>

                                            <button type="button"
                                                onclick="toast('Membuka panduan Blind Count...','success')"
                                                class="text-blue-600 text-xs font-semibold hover:underline">
                                                Buka Panduan Blind Count
                                                <i class="fas fa-arrow-right ml-1"></i>
                                            </button>
                                        </div>

                                        <div class="panel p-5">
                                            <div class="flex items-center gap-3 mb-3">
                                                <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center">
                                                    <i class="fas fa-balance-scale"></i>
                                                </div>
                                                <h3 class="font-bold text-slate-900 text-sm">
                                                    SOP Rekonsiliasi &amp; Adjustment Persediaan
                                                </h3>
                                            </div>

                                            <p class="text-xs text-slate-600 leading-relaxed mb-4">
                                                Aturan persetujuan bertingkat (Kepala Gudang, Supervisor Logistik,
                                                Finance) untuk penyesuaian saldo ledger pembukuan, selisih, dan
                                                investigasi rekaman CCTV jika terjadi susut.
                                            </p>

                                            <button type="button"
                                                onclick="toast('Menyiapkan unduhan Form SOP Adjustment (PDF)...','success')"
                                                class="text-blue-600 text-xs font-semibold hover:underline">
                                                Unduh Form SOP Adjustment
                                                <i class="fas fa-arrow-right ml-1"></i>
                                            </button>
                                        </div>

                                        <div class="panel p-5">
                                            <div class="flex items-center gap-3 mb-3">
                                                <div class="w-10 h-10 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
                                                    <i class="fas fa-file-signature"></i>
                                                </div>
                                                <h3 class="font-bold text-slate-900 text-sm">
                                                    Berita Acara Stok Opname (BASO Digital)
                                                </h3>
                                            </div>

                                            <p class="text-xs text-slate-600 leading-relaxed mb-4">
                                                Penerbitan dokumen legal BASO terenkripsi otomatis dilengkapi digital
                                                signature Kepala Hub dan Tim Internal Audit guna validasi kepatuhan
                                                audit PSAK &amp; ISO 9001:2015.
                                            </p>

                                            <button type="button"
                                                onclick="toast('Memuat log riwayat BASO Digital...','success')"
                                                class="text-blue-600 text-xs font-semibold hover:underline">
                                                Log Riwayat BASO
                                                <i class="fas fa-arrow-right ml-1"></i>
                                            </button>
                                        </div>

                                    </div>

                                    {{-- Kebijakan audit --}}
                                    <div class="panel p-5 lg:p-6 mb-6">
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-3">
                                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                                <i class="fas fa-balance-scale"></i>
                                            </div>

                                            <h3 class="font-bold text-slate-900 text-sm lg:text-base flex-1">
                                                Kebijakan Audit Fisik Inventaris &amp; Rekonsiliasi Selisih
                                            </h3>

                                            <span class="badge bg-blue-100 text-blue-700">
                                                AST-SPO-2024 · Klausa Opname
                                            </span>
                                        </div>

                                        <p class="text-xs lg:text-sm text-slate-600 leading-relaxed mb-4">
                                            Penyesuaian saldo ledger akibat selisih stok opname wajib melalui alur
                                            persetujuan bertingkat dan didokumentasikan dalam Berita Acara Stok Opname
                                            (BASO) Digital. Selisih melebihi toleransi 0,2% wajib investigasi rekaman
                                            CCTV dan eskalasi ke Kepala Logistik Pusat. Kepala Gudang berwenang
                                            menyetujui adjustment hingga Rp 50 Juta; di atasnya eskalasi Finance.
                                        </p>

                                        <div class="flex flex-wrap items-center gap-3">
                                            <span class="badge bg-green-100 text-green-700">
                                                <i class="fas fa-shield-alt"></i>
                                                BASO Digital Terverifikasi PSAK
                                            </span>
                                            <span class="text-xs text-slate-500">
                                                <i class="fas fa-clock mr-1"></i>
                                                Jadwal Audit Siklus: Q1 2025 (Aktif)
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- Modal jadwal auditor --}}
                            <div class="modal-overlay" id="modalTim">
                                <div class="modal-box">
                                    <div class="flex items-center justify-between p-5 border-b border-slate-100">
                                        <div>
                                            <h3 class="font-bold text-slate-900">
                                                <i class="fas fa-users mr-2 text-blue-600"></i>
                                                Jadwal Tim Auditor Genggam
                                            </h3>
                                            <p class="text-xs text-slate-500 mt-1">Pembagian tugas audit setiap zona gudang</p>
                                        </div>

                                        <button type="button" data-close-modal
                                            class="w-8 h-8 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-700">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>

                                    <div class="p-5 space-y-3 text-sm">

                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 p-3 border border-slate-200 rounded-xl">
                                            <div>
                                                <p class="font-semibold text-slate-900">Auditor Regu 1 (Handheld Zebra)</p>
                                                <p class="text-xs text-slate-500 mt-1">Zona A · Blind Count Tahap 2</p>
                                            </div>
                                            <span class="badge bg-amber-100 text-amber-700">Sedang Dihitung</span>
                                        </div>

                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 p-3 border border-slate-200 rounded-xl">
                                            <div>
                                                <p class="font-semibold text-slate-900">Auditor Regu 3 (Checker QC)</p>
                                                <p class="text-xs text-slate-500 mt-1">Zona B · Cycle Count Bulanan</p>
                                            </div>
                                            <span class="badge bg-blue-100 text-blue-700">Verifikasi Selisih</span>
                                        </div>

                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 p-3 border border-slate-200 rounded-xl">
                                            <div>
                                                <p class="font-semibold text-slate-900">Tim Internal Audit (Verified)</p>
                                                <p class="text-xs text-slate-500 mt-1">Zona C · Audit Acak</p>
                                            </div>
                                            <span class="badge bg-green-100 text-green-700">Selesai &amp; Match</span>
                                        </div>

                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 p-3 border border-slate-200 rounded-xl">
                                            <div>
                                                <p class="font-semibold text-slate-900">Operator Scanner Regu B</p>
                                                <p class="text-xs text-slate-500 mt-1">Zona D · Cycle Count Berkala</p>
                                            </div>
                                            <span class="badge bg-indigo-100 text-indigo-700">Berlangsung</span>
                                        </div>

                                    </div>

                                    <div class="p-5 border-t border-slate-100 flex justify-end gap-2">
                                        <button type="button" data-close-modal
                                            class="px-4 py-2 border border-slate-300 rounded-xl text-sm hover:bg-slate-50">
                                            Tutup
                                        </button>

                                        <button type="button"
                                            onclick="closeModal('modalTim'); toast('Jadwal tim auditor diekspor (PDF)...','success')"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-xl text-sm hover:bg-blue-700">
                                            <i class="fas fa-file-pdf mr-1"></i>
                                            Ekspor Jadwal
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal detail sesi --}}
                            <div class="modal-overlay" id="modalDetail">
                                <div class="modal-box" style="max-width:720px">
                                    <div class="flex items-center justify-between p-5 border-b border-slate-100">
                                        <div>
                                            <h3 class="font-bold text-slate-900">
                                                <i class="fas fa-clipboard-check mr-2 text-blue-600"></i>
                                                Detail Sesi Stok Opname
                                            </h3>
                                            <p class="text-xs text-slate-500 mt-1">Informasi lengkap hasil pemeriksaan stok</p>
                                        </div>

                                        <button type="button" data-close-modal
                                            class="w-8 h-8 rounded-lg text-slate-400 hover:bg-slate-100 hover:text-slate-700">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>

                                    <div class="p-5" id="detailBody">
                                        <p class="text-sm text-slate-500">Memuat detail...</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Notifikasi --}}
                            <div class="so-toast-container" id="soToastContainer"></div>

                        </div>
                        @endsection

                        @section('scripts')
                        <script>
                            (function() {
                                'use strict';

                                const root = document.getElementById('stok-opname-page');

                                if (!root) return;

                                // ==========================================
                                // NOTIFIKASI TOAST
                                // ==========================================
                                window.toast = function(message, type = 'success') {
                                    const container = document.getElementById('soToastContainer');

                                    if (!container) return;

                                    const item = document.createElement('div');
                                    item.className = 'so-toast ' + type;
                                    item.textContent = message;

                                    container.appendChild(item);

                                    setTimeout(function() {
                                        item.style.opacity = '0';
                                        item.style.transition = 'opacity .3s';

                                        setTimeout(function() {
                                            item.remove();
                                        }, 300);
                                    }, 3200);
                                };

                                // ==========================================
                                // MODAL
                                // ==========================================
                                window.openModal = function(id) {
                                    const modal = document.getElementById(id);

                                    if (modal) {
                                        modal.classList.add('open');
                                    }
                                };

                                window.closeModal = function(id) {
                                    const modal = document.getElementById(id);

                                    if (modal) {
                                        modal.classList.remove('open');
                                    }
                                };

                                root.querySelectorAll('.modal-overlay').forEach(function(modal) {
                                    modal.addEventListener('click', function(event) {
                                        if (event.target === modal) {
                                            modal.classList.remove('open');
                                        }
                                    });
                                });

                                root.querySelectorAll('[data-close-modal]').forEach(function(button) {
                                    button.addEventListener('click', function() {
                                        const modal = button.closest('.modal-overlay');

                                        if (modal) {
                                            modal.classList.remove('open');
                                        }
                                    });
                                });

                                document.addEventListener('keydown', function(event) {
                                    if (event.key === 'Escape') {
                                        root.querySelectorAll('.modal-overlay.open').forEach(function(modal) {
                                            modal.classList.remove('open');
                                        });
                                    }
                                });

                                // ==========================================
                                // DATA DETAIL STOK OPNAME
                                // ==========================================
                                const SO = {
                                    'SO-2025-0080': {
                                        sku: 'Apple MacBook Pro 14" M1 Pro',
                                        kode: 'SKU-LAP-0821',
                                        kat: 'LAPTOP',
                                        vendor: 'Apple Inc.',
                                        zona: 'WH01-ZA-RA01 (Rak Tier 2)',
                                        tipe: 'Blind Count',
                                        sistem: '120 Unit',
                                        fisik: '118 Unit',
                                        selisih: '-2 Unit (-Rp 42,0 Jt)',
                                        auditor: 'Hendra Wijaya',
                                        checker: 'Rina',
                                        status: 'Perlu Rekonsiliasi',
                                        tgl: '12 Mar 2025 · 08:00 WIB'
                                    },

                                    'SO-2025-0082': {
                                        sku: 'SanDisk Extreme Portable SSD 1TB NVMe',
                                        kode: 'SKU-SSD-4410',
                                        kat: 'STORAGE',
                                        vendor: 'SanDisk',
                                        zona: 'WH02-ZC-RC04 (Bin 12)',
                                        tipe: 'Cycle Count',
                                        sistem: '250 Unit',
                                        fisik: '250 Unit',
                                        selisih: '+0 (Cocok 100%)',
                                        auditor: 'Teguh Arianto',
                                        checker: 'Dimas',
                                        status: 'Disetujui Match',
                                        tgl: '12 Mar 2025 · 08:15 WIB'
                                    },

                                    'SO-2025-0083': {
                                        sku: 'Sony WH-1000XM4 Wireless Headphone',
                                        kode: 'SKU-AUD-8302',
                                        kat: 'AUDIO',
                                        vendor: 'Sony Corp.',
                                        zona: 'WH01-ZB-RB02 (Tier 3)',
                                        tipe: 'Blind Count',
                                        sistem: '64 Unit',
                                        fisik: '68 Unit',
                                        selisih: '+4 Unit (+Rp 12,0 Jt)',
                                        auditor: 'Tim Auditor B',
                                        checker: 'Siti',
                                        status: 'Sedang Investigasi',
                                        tgl: '12 Mar 2025 · 08:30 WIB'
                                    },

                                    'SO-2025-0084': {
                                        sku: 'Keychron Q1 Pro Wireless Custom Mechanical',
                                        kode: 'SKU-KEY-1092',
                                        kat: 'PERIFERAL',
                                        vendor: 'Keychron',
                                        zona: 'WH01-ZB-RB03 (Bin 03)',
                                        tipe: 'Cycle Count',
                                        sistem: '85 Unit',
                                        fisik: '85 Unit',
                                        selisih: '+0 (Cocok 100%)',
                                        auditor: 'Rina Maryani',
                                        checker: 'Hendra W.',
                                        status: 'Disetujui Match',
                                        tgl: '12 Mar 2025 · 08:45 WIB'
                                    },

                                    'SO-2025-0085': {
                                        sku: 'Canon EOS 60D Digital SLR Body Only',
                                        kode: 'SKU-CAM-3104',
                                        kat: 'KAMERA',
                                        vendor: 'Canon ID',
                                        zona: 'WH01-ZA-RA04 (Locker VIP)',
                                        tipe: 'Blind Count',
                                        sistem: '15 Unit',
                                        fisik: '14 Unit',
                                        selisih: '-1 Unit (-Rp 7,5 Jt)',
                                        auditor: 'Dimas Setiawan',
                                        checker: 'Kepala Hub',
                                        status: 'Perlu Rekonsiliasi (Menunggu Approval)',
                                        tgl: '12 Mar 2025 · 10:00 WIB'
                                    },

                                    'SO-2025-0088': {
                                        sku: 'Zebra TC21 Industrial Handheld Scanner',
                                        kode: 'SKU-SCN-0055',
                                        kat: 'EQUIPMENT',
                                        vendor: 'Zebra Tech',
                                        zona: 'WH02-ZD-RD01 (Rak 01)',
                                        tipe: 'Cycle Count',
                                        sistem: '40 Unit',
                                        fisik: '40 Unit',
                                        selisih: '+0 (Cocok 100%)',
                                        auditor: 'Agus Ridwan',
                                        checker: 'Teguh A.',
                                        status: 'Disetujui Match',
                                        tgl: '12 Mar 2025 · 10:15 WIB'
                                    },

                                    'SO-2025-0087': {
                                        sku: 'Corsair Vengeance DDR5 32GB (2x16GB) 6000MHz',
                                        kode: 'SKU-RAM-7721',
                                        kat: 'KOMPONEN',
                                        vendor: 'Corsair',
                                        zona: 'WH02-ZC-RC02 (Bin 08)',
                                        tipe: 'Cycle Count',
                                        sistem: '180 Unit',
                                        fisik: '180 Unit',
                                        selisih: '+0 (Cocok 100%)',
                                        auditor: 'Siti Lastari',
                                        checker: 'Tim Auditor',
                                        status: 'Disetujui Match',
                                        tgl: '12 Mar 2025 · 09:30 WIB'
                                    }
                                };

                                // ==========================================
                                // MENAMPILKAN DETAIL
                                // ==========================================
                                window.openDetail = function(code) {
                                    const data = SO[code];
                                    const body = document.getElementById('detailBody');

                                    if (!data || !body) return;

                                    const fields = [
                                        ['No. Berkas Opname', code],
                                        ['Waktu Hitung', data.tgl],
                                        ['Komoditas / SKU', data.sku],
                                        ['Kode SKU', data.kode],
                                        ['Kategori', data.kat],
                                        ['Vendor', data.vendor],
                                        ['Tipe Opname', data.tipe],
                                        ['Lokasi Rak / Bin', data.zona],
                                        ['Auditor', data.auditor],
                                        ['Stok Sistem', data.sistem],
                                        ['Stok Fisik', data.fisik],
                                        ['Selisih (Variance)', data.selisih],
                                        ['Checker', data.checker],
                                        ['Status', data.status]
                                    ];

                                    body.innerHTML = '';

                                    const grid = document.createElement('div');
                                    grid.className = 'grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm';

                                    fields.forEach(function(field) {
                                        const item = document.createElement('div');

                                        if (field[0] === 'Komoditas / SKU' || field[0] === 'Selisih (Variance)') {
                                            item.className = 'sm:col-span-2';
                                        }

                                        const label = document.createElement('p');
                                        label.className = 'text-xs text-slate-500 mb-1';
                                        label.textContent = field[0];

                                        const value = document.createElement('p');
                                        value.className = 'text-slate-900 font-semibold';
                                        value.textContent = field[1];

                                        item.appendChild(label);
                                        item.appendChild(value);
                                        grid.appendChild(item);
                                    });

                                    body.appendChild(grid);

                                    const actions = document.createElement('div');
                                    actions.className = 'mt-5 pt-4 border-t border-slate-100 flex justify-end gap-2';

                                    const closeButton = document.createElement('button');
                                    closeButton.type = 'button';
                                    closeButton.className = 'px-4 py-2 border border-slate-300 rounded-xl text-sm hover:bg-slate-50';
                                    closeButton.textContent = 'Tutup';
                                    closeButton.addEventListener('click', function() {
                                        closeModal('modalDetail');
                                    });

                                    const exportButton = document.createElement('button');
                                    exportButton.type = 'button';
                                    exportButton.className = 'px-4 py-2 bg-blue-600 text-white rounded-xl text-sm hover:bg-blue-700';
                                    exportButton.innerHTML = '<i class="fas fa-file-pdf mr-1"></i>Ekspor PDF';
                                    exportButton.addEventListener('click', function() {
                                        closeModal('modalDetail');
                                        toast('Ekspor detail ' + code + ' (PDF)...', 'success');
                                    });

                                    actions.appendChild(closeButton);
                                    actions.appendChild(exportButton);
                                    body.appendChild(actions);

                                    openModal('modalDetail');
                                };

                                // ==========================================
                                // FILTER DAN PENCARIAN
                                // ==========================================
                                const table = document.getElementById('tblSo');
                                const search = document.getElementById('searchSo');
                                const filterTipe = document.getElementById('fTipe');
                                const filterStatus = document.getElementById('fStatus');
                                const filterZona = document.getElementById('fZona');
                                const info = document.getElementById('soInfo');
                                const pager = document.getElementById('soPager');
                                const resetButton = document.getElementById('resetFilter');

                                if (!table) return;

                                const rows = Array.from(table.querySelectorAll('tbody tr'));
                                const chips = Array.from(root.querySelectorAll('[data-chip]'));

                                let activeChip = 'all';
                                let currentPage = 1;
                                const perPage = 7;

                                function getFilteredRows() {
                                    const keyword = search.value.toLowerCase().trim();
                                    const tipe = filterTipe.value;
                                    const status = filterStatus.value;
                                    const zona = filterZona.value;

                                    return rows.filter(function(row) {
                                        const rowText = row.textContent.toLowerCase();

                                        const matchSearch = !keyword || rowText.includes(keyword);
                                        const matchTipe = !tipe || row.dataset.tipe === tipe;
                                        const matchStatus = !status || row.dataset.status === status;
                                        const matchZona = !zona || row.dataset.zona === zona;

                                        let matchChip = true;

                                        if (activeChip === 'match') {
                                            matchChip = row.dataset.status === 'match';
                                        } else if (activeChip === 'selisih') {
                                            matchChip = row.dataset.status === 'selisih';
                                        } else if (activeChip === 'proses') {
                                            matchChip = row.dataset.status === 'proses';
                                        } else if (activeChip === 'approval') {
                                            matchChip = row.dataset.chip === 'approval';
                                        }

                                        return matchSearch && matchTipe && matchStatus && matchZona && matchChip;
                                    });
                                }

                                function renderTable() {
                                    const filteredRows = getFilteredRows();
                                    const totalPages = Math.max(1, Math.ceil(filteredRows.length / perPage));

                                    if (currentPage > totalPages) {
                                        currentPage = totalPages;
                                    }

                                    const start = (currentPage - 1) * perPage;
                                    const end = start + perPage;
                                    const visibleRows = filteredRows.slice(start, end);

                                    rows.forEach(function(row) {
                                        row.style.display = 'none';
                                    });

                                    visibleRows.forEach(function(row) {
                                        row.style.display = '';
                                    });

                                    if (info) {
                                        const from = filteredRows.length === 0 ? 0 : start + 1;
                                        const to = Math.min(end, filteredRows.length);

                                        info.textContent = 'Menampilkan ' + from + '-' + to +
                                            ' dari ' + filteredRows.length + ' data';
                                    }

                                    renderPager(totalPages);
                                }

                                function renderPager(totalPages) {
                                    if (!pager) return;

                                    pager.innerHTML = '';

                                    function createButton(label, page, disabled, active) {
                                        const button = document.createElement('button');

                                        button.type = 'button';
                                        button.textContent = label;
                                        button.className = 'px-3 py-2 rounded-lg text-xs border ' +
                                            (active ?
                                                'bg-blue-600 text-white border-blue-600' :
                                                'border-slate-300 text-slate-600 hover:bg-slate-50') +
                                            (disabled ? ' opacity-40 cursor-not-allowed' : '');

                                        button.disabled = disabled;

                                        button.addEventListener('click', function() {
                                            if (disabled) return;

                                            currentPage = page;
                                            renderTable();
                                        });

                                        pager.appendChild(button);
                                    }

                                    createButton('Sebelumnya', currentPage - 1, currentPage === 1, false);

                                    for (let page = 1; page <= totalPages; page++) {
                                        createButton(String(page), page, false, page === currentPage);
                                    }

                                    createButton('Berikutnya', currentPage + 1, currentPage === totalPages, false);
                                }

                                function updateChipAppearance() {
                                    chips.forEach(function(button) {
                                        const active = button.dataset.chip === activeChip;

                                        button.classList.toggle('active', active);

                                        if (active) {
                                            button.classList.add('border-blue-600');
                                            button.classList.remove('border-slate-300');
                                        } else {
                                            button.classList.remove('border-blue-600');
                                            button.classList.add('border-slate-300');
                                        }
                                    });
                                }

                                if (search) {
                                    search.addEventListener('input', function() {
                                        currentPage = 1;
                                        renderTable();
                                    });
                                }

                                [filterTipe, filterStatus, filterZona].forEach(function(filter) {
                                    if (filter) {
                                        filter.addEventListener('change', function() {
                                            currentPage = 1;
                                            renderTable();
                                        });
                                    }
                                });

                                chips.forEach(function(button) {
                                    button.addEventListener('click', function() {
                                        activeChip = button.dataset.chip;
                                        currentPage = 1;

                                        updateChipAppearance();
                                        renderTable();
                                    });
                                });

                                if (resetButton) {
                                    resetButton.addEventListener('click', function() {
                                        if (search) search.value = '';
                                        if (filterTipe) filterTipe.value = '';
                                        if (filterStatus) filterStatus.value = '';
                                        if (filterZona) filterZona.value = '';

                                        activeChip = 'all';
                                        currentPage = 1;

                                        updateChipAppearance();
                                        renderTable();

                                        toast('Filter berhasil direset.', 'success');
                                    });
                                }

                                renderTable();
                                updateChipAppearance();

                            })();
                        </script>
                        @endsection
