<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Astro Inventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Astro Inventory Design System */
        :root {
            --brand: #2563eb;
            --brand-dark: #1d4ed8;
            --bg: #f5f7fb;
            --line: #e7ebf2;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif;
            background: var(--bg);
            color: #172033;
            -webkit-font-smoothing: antialiased;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 9px;
            height: 9px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cdd6e4;
            border-radius: 99px;
            border: 2px solid #f5f7fb;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #aab8cf;
        }

        /* Entrance Animations */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .anim-fade-up {
            animation: fadeUp 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        .anim-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .anim-slide-in {
            animation: slideIn 0.5s cubic-bezier(0.22, 1, 0.36, 1);
        }

        /* Delay classes */
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }

        /* Cards */
        .metric-card {
            transition: transform 0.25s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.25s;
        }
        .metric-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px -12px rgba(37, 99, 235, 0.22), 0 4px 10px rgba(15, 23, 42, 0.06);
        }

        /* Nav links */
        .nav-link {
            transition: all 0.16s ease;
        }
        .nav-link:hover {
            background: #f1f5f9;
            color: #172033;
            transform: translateX(3px);
        }
        .nav-link.active {
            background: var(--brand);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 6px 14px -6px rgba(37, 99, 235, 0.55);
        }
        .nav-link.active:hover {
            transform: none;
            background: var(--brand);
        }

        /* Pulse animation */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        .badge-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Progress bar */
        @keyframes progressFill {
            from { width: 0; }
        }
        .progress-bar div {
            animation: progressFill 1s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        .progress-bar-fill {
            animation: progressFill 1.5s ease-out forwards;
        }

        /* Button ripple */
        @keyframes ripple {
            from {
                opacity: 1;
                transform: scale(0);
            }
            to {
                opacity: 0;
                transform: scale(2);
            }
        }

        /* Panel */
        .panel {
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.05);
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
        }

        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 6px;
        }

        /* ===== Notifikasi: Toast ===== */
        #toast-container { position: fixed; right: 1rem; bottom: 1rem; z-index: 100; display: flex; flex-direction: column; gap: .5rem; }
        .toast {
            background: #fff; border: 1px solid #e5eeff; border-left: 4px solid #2563eb;
            border-radius: .5rem; padding: .75rem 1rem;
            box-shadow: 0 8px 20px -6px rgba(0,0,0,.2);
            font-size: .875rem; color: #0b1c30;
            animation: toastIn .2s ease; max-width: 340px;
        }
        .toast.success { border-left-color: #16a34a; }
        .toast.warn { border-left-color: #f59e0b; }
        .toast.error { border-left-color: #dc2626; }
        @keyframes toastIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: none; } }

        /* ===== Notifikasi: Modal ===== */
        .modal-overlay { position: fixed; inset: 0; background: rgba(11,28,48,.55); display: none; align-items: flex-start; justify-content: center; z-index: 80; padding: 5vh 1rem 1rem; overflow-y: auto; }
        .modal-overlay.open { display: flex; }
        .modal-box { background: #fff; border-radius: .75rem; width: 100%; max-width: 640px; box-shadow: 0 20px 50px -10px rgba(0,0,0,.35); animation: modalIn .18s ease; }
        @keyframes modalIn { from { opacity: 0; transform: translateY(12px) scale(.98); } to { opacity: 1; transform: none; } }

        /* ===== Notifikasi: HR card / tab / channel / chart ===== */
        .notification-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .notification-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px -5px rgba(0, 0, 0, 0.15);
        }
        .tab-filter {
            transition: all 0.2s ease;
        }
        .tab-filter:hover {
            background-color: #EFF6FF;
            transform: translateY(-2px);
        }
        .tab-filter.active {
            background-color: #DBEAFE;
            border-color: #2563EB;
        }
        .badge-count {
            transition: all 0.3s ease;
        }
        .badge-count:hover {
            transform: scale(1.1);
        }
        .channel-status {
            transition: all 0.3s ease;
        }
        .channel-status:hover {
            transform: translateX(5px);
        }
        .chart-bar {
            animation: barGrow 0.8s ease-out forwards;
        }
        @keyframes barGrow {
            from { height: 0; }
        }
        .glow-animation {
            animation: glow 2s ease-in-out infinite;
        }
        @keyframes glow {
            0%, 100% { box-shadow: 0 0 5px rgba(239, 68, 68, 0.5); }
            50% { box-shadow: 0 0 20px rgba(239, 68, 68, 0.8); }
        }
        .notice-in { animation: rise .3s ease both; }
        @keyframes rise { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-gray-50">

@include('components.navbar')

<div class="flex min-h-screen">
    @include('components.sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-4 lg:p-6 overflow-x-hidden">

        {{-- ================= KEPALA GUDANG ================= --}}
        @if(auth()->user()->isKepalaGudang())

        <div class="flex items-center gap-2 text-sm text-gray-500 mb-4 overflow-x-auto whitespace-nowrap anim-fade-in">
            <span>Beranda</span><i class="fas fa-chevron-right text-xs"></i>
            <span>Pengaturan &amp; Akun</span><i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-900 font-medium">Notifikasi</span>
        </div>

        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-6 anim-fade-up">
            <div class="flex-1">
                <h1 class="text-xl lg:text-2xl font-bold text-gray-900 mb-2">Pusat Notifikasi &amp; Pemberitahuan</h1>
                <p class="text-sm lg:text-base text-gray-600">Pemberitahuan langsung terkait antrean persetujuan mutasi, peringatan ambang batas ROP, dan otorisasi audit log gudang terintegrasi.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <span class="badge bg-red-100 text-red-700"><i class="fas fa-circle" style="font-size:5px"></i>5 Belum Ditanggapi</span>
                <button onclick="toast('Semua notifikasi ditandai sudah dibaca.','success')" class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm flex items-center gap-2"><i class="fas fa-check-double"></i>Tandai Semua Sudah Dibaca</button>
                <button onclick="openModal('modalPref')" class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm flex items-center gap-2"><i class="fas fa-sliders-h"></i>Kelola Preferensi</button>
            </div>
        </div>

        <!-- Top filter bar -->
        <div class="panel p-4 mb-6 anim-fade-up delay-1">
            <div class="flex flex-col lg:flex-row lg:items-center gap-3">
                <div class="relative flex-1 min-w-[200px]">
                    <input id="searchNotif" type="text" placeholder="Cari judul, SKU, No. transaksi, atau kata kunci notifikasi." class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                </div>
                <select id="fKanal" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option value="">Kanal: Semua</option>
                    <option value="inapp">In-App</option>
                    <option value="telegram">Telegram</option>
                    <option value="email">Email</option>
                    <option value="gateway">Gateway Telemetri</option>
                </select>
                <select id="fJenis" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option value="">Jenis: Semua</option>
                    <option value="mutasi">Mutasi &amp; Persetujuan</option>
                    <option value="rop">Peringatan Stok &amp; ROP</option>
                    <option value="otorisasi">Otorisasi &amp; Audit</option>
                    <option value="hak">Hak Akses</option>
                </select>
                <select id="fStatus" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    <option value="">Status: Semua</option>
                    <option value="unread">Belum Dibaca</option>
                    <option value="read">Sudah Dibaca</option>
                </select>
                <span class="text-sm text-gray-500 whitespace-nowrap">Urutan: <select class="px-2 py-1.5 border border-gray-300 rounded-lg text-sm"><option>Terkini</option><option>Terdahulu</option><option>Prioritas</option></select></span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 anim-fade-up delay-2">
            <!-- LEFT: notification list -->
            <div class="lg:col-span-2 space-y-6">
                <!-- HARI INI -->
                <div class="panel p-4 lg:p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-gray-900 text-sm lg:text-base">HARI INI — 18 OKTOBER 2025</h3>
                            <span class="badge bg-red-100 text-red-700">4 pembaruan prioritas</span>
                        </div>
                        <button onclick="toast('Grup HARI INI ditandai dibaca.','success')" class="text-xs text-blue-600 hover:underline">Tandai grup ini dibaca</button>
                    </div>
                    <div class="space-y-3">
                        <!-- Notif 1 -->
                        <div class="border-l-4 border-red-500 bg-red-50/40 rounded-r-lg p-3 hover:bg-red-50 transition" data-kanal="inapp" data-jenis="mutasi" data-status="unread">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0"><i class="fas fa-exchange-alt text-red-600"></i></div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <p class="font-semibold text-gray-900 text-sm">Permintaan Mutasi Urgent Mendekati Batas SLA</p>
                                        <span class="badge bg-red-100 text-red-700"><i class="fas fa-bolt"></i>Urgent</span>
                                        <span class="text-xs text-gray-400 ml-auto">10 menit lalu</span>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1">Hub Cakung DC-01 ke Halim DC-02 mendekati batas waktu SLA otorisasi HR &amp; Dispatch (sisa &lt; 30 menit).</p>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="text-xs text-gray-400">REF: REQ-2025-0381</span>
                                        <button onclick="toast('Membuka persetujuan REQ-2025-0381...','success')" class="text-xs text-blue-600 hover:underline"><i class="fas fa-arrow-right"></i> Tinjau Persetujuan</button>
                                        <button onclick="toast('Notifikasi ditandai dibaca.','success')" class="text-xs text-gray-500 hover:underline ml-auto">Tandai dibaca</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Notif 2 -->
                        <div class="border-l-4 border-amber-500 bg-amber-50/40 rounded-r-lg p-3 hover:bg-amber-50 transition" data-kanal="inapp" data-jenis="rop" data-status="unread">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0"><i class="fas fa-boxes text-amber-600"></i></div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <p class="font-semibold text-gray-900 text-sm">Peringatan Stok &amp; ROP</p>
                                        <span class="badge bg-amber-100 text-amber-700"><i class="fas fa-exclamation"></i>ROP &lt; 30 Menit</span>
                                        <span class="text-xs text-gray-400 ml-auto">35 menit lalu</span>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1">Stok di Bawah Batas Reorder Point (ROP). SKU #CAM-600D di Bin Lokasi WH01-RACK-A4 tersisa 4 unit (ambang batas ROP: 25 unit). Kapasitas buffer tersisa 16%. Diperlukan tindakan pengadaan segera.</p>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="text-xs text-gray-400">Level Penyangga (ROP: 25 Unit)</span>
                                        <button onclick="toast('Membuka detail stok SKU #CAM-600D...','success')" class="text-xs text-blue-600 hover:underline"><i class="fas fa-arrow-right"></i> Lihat Detail Stok</button>
                                        <button onclick="toast('Notifikasi ditandai dibaca.','success')" class="text-xs text-gray-500 hover:underline ml-auto">Tandai dibaca</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Notif 3 -->
                        <div class="border-l-4 border-green-500 bg-green-50/40 rounded-r-lg p-3 hover:bg-green-50 transition" data-kanal="email" data-jenis="otorisasi" data-status="unread">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0"><i class="fas fa-check-circle text-green-600"></i></div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <p class="font-semibold text-gray-900 text-sm">Transaksi Otorisasi Mutasi Berhasil Disetujui</p>
                                        <span class="badge bg-green-100 text-green-700"><i class="fas fa-check"></i>Disetujui</span>
                                        <span class="text-xs text-gray-400 ml-auto">1 jam lalu</span>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1">Surat Jalan elektronik SPO-WMS-019 telah terbit dan siap cetak untuk armada truk Box C-04. Pengeluaran logistik telah disinkronkan ke buku inventaris utama.</p>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="text-xs text-gray-400">Otorisator: Budi Santoso (Admin HR)</span>
                                        <button onclick="toast('Menyiapkan unduhan manifest & QR SPO-WMS-019...','success')" class="text-xs text-blue-600 hover:underline"><i class="fas fa-download"></i> Unduh Manifest &amp; QR SPO</button>
                                        <button onclick="toast('Notifikasi ditandai dibaca.','success')" class="text-xs text-gray-500 hover:underline ml-auto">Tandai dibaca</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Notif 4 -->
                        <div class="border-l-4 border-indigo-500 bg-indigo-50/40 rounded-r-lg p-3 hover:bg-indigo-50 transition" data-kanal="telegram" data-jenis="otorisasi" data-status="unread">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0"><i class="fas fa-shield-alt text-indigo-600"></i></div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <p class="font-semibold text-gray-900 text-sm">Log Audit Mingguan Terenkripsi Tersedia</p>
                                        <span class="badge bg-indigo-100 text-indigo-700"><i class="fas fa-lock"></i>Audit Trail</span>
                                        <span class="text-xs text-gray-400 ml-auto">3 jam lalu</span>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1">Rekapitulasi log otorisasi minggu ke-42 telah selesai diverifikasi oleh hash SHA-256 (3fa2b0...890c). Semua 1.480 aktivitas mutasi dinyatakan valid tanpa deviasi anomali.</p>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="text-xs text-gray-400">Status Integritas: 100% cacah</span>
                                        <button onclick="toast('Membuka dokumen audit minggu ke-42...','success')" class="text-xs text-blue-600 hover:underline"><i class="fas fa-arrow-right"></i> Buka Dokumen Audit</button>
                                        <button onclick="toast('Notifikasi ditandai dibaca.','success')" class="text-xs text-gray-500 hover:underline ml-auto">Tandai dibaca</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KEMARIN -->
                <div class="panel p-4 lg:p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-gray-900 text-sm lg:text-base">KEMARIN — 17 OKTOBER 2025</h3>
                            <span class="badge bg-gray-100 text-gray-700">Telah ditinjau</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <!-- Notif 5 -->
                        <div class="border-l-4 border-gray-300 bg-gray-50/40 rounded-r-lg p-3 hover:bg-gray-50 transition" data-kanal="inapp" data-jenis="hak" data-status="read">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0"><i class="fas fa-user-shield text-gray-600"></i></div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <p class="font-semibold text-gray-700 text-sm">Pembaruan Hak Akses Staf Lapangan</p>
                                        <span class="badge bg-blue-100 text-blue-700"><i class="fas fa-key"></i>SEC-819</span>
                                        <span class="text-xs text-gray-400 ml-auto">Kemarin, 16:42 WIB</span>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1">Perubahan wewenang otorisasi cetak label manifest di lorong WH01 telah diperbarui oleh Admin Rian Hidayat untuk 3 operator barcode scanner.</p>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="text-xs text-gray-400">AUID: 4SEC-819</span>
                                        <button onclick="toast('Membuka detail validasi otomatis SEC-819...','success')" class="text-xs text-blue-600 hover:underline"><i class="fas fa-arrow-right"></i> Validasi Otomatis</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Notif 6 -->
                        <div class="border-l-4 border-gray-300 bg-gray-50/40 rounded-r-lg p-3 hover:bg-gray-50 transition" data-kanal="inapp" data-jenis="mutasi" data-status="read">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0"><i class="fas fa-clipboard-check text-gray-600"></i></div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <p class="font-semibold text-gray-700 text-sm">Rekonsiliasi Fisik Batch SO-2023-112 Selesai</p>
                                        <span class="badge bg-purple-100 text-purple-700"><i class="fas fa-balance-scale"></i>Opname</span>
                                        <span class="text-xs text-gray-400 ml-auto">Kemarin, 17:20 WIB</span>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1">Deviasi minus 3 unit pada Lorong B3 (Rak Elektronik) telah di-input ke modul Write-Off Minor. Menunggu tinjauan berkala dari Kepala Logistik Pusat.</p>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="text-xs text-gray-400">Supervisor: Dewi Anggraini</span>
                                        <button onclick="toast('Membuka berita acara SO-2023-112...','success')" class="text-xs text-blue-600 hover:underline"><i class="fas fa-arrow-right"></i> Lihat Berita Acara</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Load more -->
                <div class="flex flex-col items-center gap-3">
                    <span class="text-sm text-gray-500">Menampilkan 6 dari 12 notifikasi tersimpan</span>
                    <button onclick="toast('Memuat 6 notifikasi terdahulu...','success')" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm flex items-center gap-2"><i class="fas fa-history"></i>Muat Notifikasi Terdahulu</button>
                </div>
            </div>

            <!-- RIGHT: kanal pengiriman aktif -->
            <div class="space-y-6">
                <div class="panel p-4 lg:p-5">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-satellite-dish text-blue-600"></i>
                        <h3 class="font-bold text-gray-900 text-sm">Kanal Pengiriman Aktif</h3>
                        <span class="badge bg-green-100 text-green-700 ml-auto"><i class="fas fa-circle" style="font-size:5px"></i>Sinkron</span>
                    </div>
                    <p class="text-xs text-gray-600 mb-4">Pemberitahuan darurat diteruskan secara paralel ke kanal operasional resmi berikut.</p>
                    <div class="space-y-3">
                        <!-- In-App -->
                        <div class="border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-desktop text-blue-600"></i></div>
                                <div class="flex-1"><p class="text-sm font-semibold text-gray-900">In-App Alert Dashboard</p><p class="text-xs text-gray-500">Pop-up real-time &amp; banner</p></div>
                                <span class="badge bg-green-100 text-green-700"><i class="fas fa-check"></i>Aktif</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">5 belum dibaca</p>
                        </div>
                        <!-- Telegram -->
                        <div class="border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-8 h-8 bg-cyan-100 rounded-lg flex items-center justify-center"><i class="fab fa-telegram text-cyan-600"></i></div>
                                <div class="flex-1"><p class="text-sm font-semibold text-gray-900">Bot Telegram Lapangan</p><p class="text-xs text-gray-500">@AstroApproverBot</p></div>
                                <span class="badge bg-green-100 text-green-700"><i class="fas fa-check"></i>Aktif</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">HR &amp; Dispatch queue</p>
                        </div>
                        <!-- Email -->
                        <div class="border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center"><i class="fas fa-envelope text-indigo-600"></i></div>
                                <div class="flex-1"><p class="text-sm font-semibold text-gray-900">Email Kedinasan</p><p class="text-xs text-gray-500">budi.s@astro-dc.co.id</p></div>
                                <span class="badge bg-green-100 text-green-700"><i class="fas fa-check"></i>Aktif</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">Kelola Preferensi &amp; Jam Senyap</p>
                        </div>
                        <!-- Gateway -->
                        <div class="border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center"><i class="fas fa-server text-amber-600"></i></div>
                                <div class="flex-1"><p class="text-sm font-semibold text-gray-900">Gateway Telemetri (Kafka)</p><p class="text-xs text-gray-500">Sinkronisasi real-time</p></div>
                                <span class="badge bg-green-100 text-green-700"><i class="fas fa-check"></i>Aktif</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">Throughput Sinyal Kafka (24 jam): 12,4k</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <p class="text-xs text-gray-500 mb-2">Sinkronisasi terakhir: 10:45:12 WIB · Node: dc01-edge-03</p>
                        <button onclick="toast('Memulai sinkronisasi ulang kanal notifikasi...','success')" class="w-full px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm flex items-center justify-center gap-2"><i class="fas fa-sync-alt"></i>Sinkronkan Ulang Kanal</button>
                    </div>
                </div>

                <!-- Quick help -->
                <div class="panel p-4 lg:p-5">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-life-ring text-blue-600"></i>
                        <h3 class="font-bold text-gray-900 text-sm">Bantuan Otorisasi Urgent</h3>
                    </div>
                    <p class="text-xs text-gray-600 mb-3">Menemukan notifikasi yang tertahan lebih dari 60 menit tanpa persetujuan tim supervisor? Segera eskalasikan ke Dispatch Utama.</p>
                    <button onclick="toast('Eskalasi dikirim ke Dispatch Utama.','warn')" class="w-full px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm flex items-center justify-center gap-2"><i class="fas fa-paper-plane"></i>Eskalasi ke Dispatcher Utama</button>
                </div>

                <!-- Stats -->
                <div class="panel p-4 lg:p-5">
                    <h3 class="font-bold text-gray-900 text-sm mb-3"><i class="fas fa-chart-pie text-blue-600 mr-2"></i>Ringkasan Notifikasi</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center justify-between"><span class="text-gray-600">Hari Ini</span><span class="font-semibold text-gray-900">4</span></div>
                        <div class="flex items-center justify-between"><span class="text-gray-600">Kemarin</span><span class="font-semibold text-gray-900">2</span></div>
                        <div class="flex items-center justify-between"><span class="text-gray-600">7 Hari Terakhir</span><span class="font-semibold text-gray-900">12</span></div>
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100"><span class="text-gray-600">Belum Dibaca</span><span class="font-semibold text-red-600">5</span></div>
                        <div class="flex items-center justify-between"><span class="text-gray-600">Prioritas Urgent</span><span class="font-semibold text-red-600">2</span></div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- ================= HR ================= --}}
        @if(auth()->user()->isHR())

        <div class="grid grid-cols-1 xl:grid-cols-[minmax(0,1fr)_340px] gap-6 items-start">

            <!-- Main column -->
            <div class="min-w-0">

                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-4 overflow-x-auto whitespace-nowrap anim-fade-in">
                    <span>Beranda</span><i class="fas fa-chevron-right text-xs"></i>
                    {{-- <span>Pengaturan &amp; Akun</span><i class="fas fa-chevron-right text-xs"></i> --}}
                    <span class="text-gray-900 font-medium">Notifikasi</span>
                </div>

                <!-- Page Header -->
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-4 anim-fade-up">
                    <div class="flex-1">
                        <h1 class="text-xl lg:text-2xl font-bold text-gray-900 mb-2">Pusat Notifikasi &amp; Pemberitahuan System</h1>
                        {{-- <p class="text-sm lg:text-base text-gray-600">Pemberitahuan langsung terkait antrean persetujuan mutasi, peringatan ambang batas ROP, dan otorisasi audit log gudang terintegrasi.</p> --}}
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm flex items-center gap-2">
                            <i class="fas fa-check"></i>Tandai Semua Sudah Dibaca
                        </button>
                        <button class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm flex items-center gap-2">
                            <i class="fas fa-cog"></i>Pengaturan Notifikasi
                        </button>
                    </div>
                </div>

                <!-- Alert Box -->
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 glow-animation anim-fade-up delay-1">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-exclamation text-white"></i>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-lg font-bold text-red-900">
                                <span class="count-up" data-target="5">0</span> Belum Ditangani
                            </h3>
                            <p class="text-sm text-red-700 mt-1">Antrean persetujuan mutasi, peringatan ambang batas ROP, dan otorisasi audit log gudang membutuhkan perhatian Anda.</p>
                        </div>
                    </div>
                </div>

                <!-- Filter Tabs -->
                <div class="panel p-4 mb-6 anim-fade-up delay-1">
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <button class="tab-filter active px-4 py-2 border-2 rounded-lg text-sm font-semibold flex items-center space-x-2">
                            <span>Semua</span>
                            <span class="badge-count bg-blue-600 text-white px-2 py-0.5 rounded-full text-xs">12</span>
                        </button>
                        <button class="tab-filter px-4 py-2 border-2 border-gray-200 rounded-lg text-sm font-semibold flex items-center space-x-2">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Menunggu Otorisasi</span>
                            <span class="badge-count bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full text-xs">4</span>
                        </button>
                        <button class="tab-filter px-4 py-2 border-2 border-gray-200 rounded-lg text-sm font-semibold flex items-center space-x-2">
                            <i class="fas fa-exclamation-triangle text-yellow-500"></i>
                            <div class="flex flex-col items-start">
                                <span>Stok Kritis</span>
                                <span class="text-xs text-gray-500">&amp; ROP</span>
                            </div>
                            <span class="badge-count bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full text-xs">3</span>
                        </button>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center space-x-3">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" class="w-4 h-4 text-blue-600 rounded">
                                <span class="text-sm text-gray-700">Hanya belum dibaca</span>
                            </label>
                            <select class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm">
                                <option>Urutan: Terkini</option>
                                <option>Urutan: Terlama</option>
                                <option>Urutan: Prioritas</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Date Header -->
                <div class="flex items-center justify-between mb-4 anim-fade-up" style="animation-delay: 0.3s">
                    <div class="flex items-center space-x-3">
                        <h2 class="text-sm font-bold text-gray-900 uppercase">HARI INI — 9 NOVEMBER 2026</h2>
                        <span class="text-sm text-gray-600">• <span class="count-up" data-target="4">0</span> pembaruan prioritas</span>
                    </div>
                    <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Tandai grup ini dibaca</a>
                </div>

                <!-- Notification Cards -->
                <div class="space-y-4">

                    <!-- Card 1: Prioritas Kritis -->
                    <div class="notification-card bg-white border-l-4 border-red-500 rounded-lg p-5 shadow-sm anim-fade-up" style="animation-delay: 0.4s">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-start space-x-3">
                                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold flex items-center space-x-1">
                                            <i class="fas fa-circle text-xs"></i>
                                            <span>Prioritas Kritis</span>
                                        </span>
                                        <span class="text-blue-600 font-semibold text-sm">#TRX-2025-0891</span>
                                    </div>
                                    <h3 class="text-base font-bold text-gray-900 mb-1">Permintaan Mutasi Urgent Mendekati Batas SLA</h3>
                                    <p class="text-sm text-gray-600 mb-3">
                                        Hub Cakung DC-01 ke Halim DC-02 mendekati batas waktu SLA otorisasi HR &amp; Dispatch (sisa 20 menit).
                                    </p>
                                    <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500">
                                        <span class="flex items-center space-x-1">
                                            <i class="fas fa-users"></i>
                                            <span>Tim Logistik Timur</span>
                                        </span>
                                        <span>•</span>
                                        <span class="flex items-center space-x-1">
                                            <i class="fas fa-truck"></i>
                                            <span>Box Truck #04</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500 whitespace-nowrap">
                                <i class="fas fa-clock mr-1"></i>10 menit lalu
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-2 ml-15">
                            <button class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm flex items-center gap-2">
                                                            <i class="fas fa-eye"></i>
                                                            <span>Tinjau Sekarang</span>
                                                        </button>
                            <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm flex items-center gap-2">
                                <i class="fas fa-times"></i>
                                <span>Tolak Cepat</span>
                            </button>
                        </div>
                    </div>

                    <!-- Card 2: Peringatan Stok -->
                    <div class="notification-card bg-white border-l-4 border-yellow-500 rounded-lg p-5 shadow-sm anim-fade-up" style="animation-delay: 0.5s">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-start space-x-3">
                                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-bold flex items-center space-x-1">
                                            <i class="fas fa-circle text-xs"></i>
                                            <span>Peringatan Stok &amp; ROP</span>
                                        </span>
                                    </div>
                                    <h3 class="text-base font-bold text-gray-900 mb-1">Stok di Bawah Batas Reorder Point (ROP)</h3>
                                    <p class="text-sm text-gray-600 mb-3">
                                        SKU #CAN-6000 di Bin Lokasi WH01-RACK-A4 tersisa 4 unit (ambang batas ROP: 25 unit).
                                        Kapasitas buffer tersisa 16%. Diperlukan tindakan pengadaan segera.
                                    </p>
                                    <!-- Progress Bar -->
                                    <div class="mb-2">
                                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                                            <span>Level Penyimpanan (ROP: 25 Unit)</span>
                                            <span class="font-bold">4 / 25 Unit</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="progress-bar-fill bg-red-500 h-2 rounded-full" style="width: 16%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500 whitespace-nowrap">
                                <i class="fas fa-clock mr-1"></i>35 menit lalu
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-2 ml-15">
                            <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm flex items-center gap-2">
                                <i class="fas fa-chart-bar"></i>
                                <span>Lihat Detail Stok</span>
                            </button>
                        </div>
                    </div>

                    <!-- Card 3: Sukses Otorisasi -->
                    <div class="notification-card bg-white border-l-4 border-green-500 rounded-lg p-5 shadow-sm anim-fade-up" style="animation-delay: 0.6s">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-start space-x-3">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 mb-2 flex-wrap">
                                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold flex items-center space-x-1">
                                            <i class="fas fa-circle text-xs"></i>
                                            <span>Sukses Otorisasi</span>
                                        </span>
                                        <span class="text-gray-600 text-sm">Ref #MUT-2023-0541</span>
                                    </div>
                                    <h3 class="text-base font-bold text-gray-900 mb-1">Transaksi Otorisasi Mutasi Berhasil Disetujui</h3>
                                    <p class="text-sm text-gray-600 mb-2">
                                        Surat Jalan elektronik SPO-WMS-019 telah terbit dan siap cetak untuk armada truk Box C-04.
                                        Pengeluaran logistik telah disinkronkan ke buku inventaris utama Cakung.
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        <i class="fas fa-user-check mr-1"></i>Otorisator: Budi Santoso (Admin HR)
                                    </p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500 whitespace-nowrap">
                                <i class="fas fa-clock mr-1"></i>1 jam lalu
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-2 ml-15">
                            <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm flex items-center gap-2">
                                <i class="fas fa-download"></i>
                                <span>Unduh Manifest &amp; QR SPO</span>
                            </button>
                        </div>
                    </div>

                    <!-- Card 4: Audit Kepatuhan -->
                    <div class="notification-card bg-white border-l-4 border-blue-500 rounded-lg p-5 shadow-sm anim-fade-up" style="animation-delay: 0.7s">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-start space-x-3">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-bold flex items-center space-x-1">
                                            <i class="fas fa-circle text-xs"></i>
                                            <span>Audit Kepatuhan</span>
                                        </span>
                                    </div>
                                    <h3 class="text-base font-bold text-gray-900 mb-1">Log Audit Mingguan Terenkripsi Tersedia</h3>
                                    <p class="text-sm text-gray-600 mb-2">
                                        Rekapitulasi log otorisasi minggu ke-42 telah selesai diverifikasi oleh hash SHA-256 (3fa2b9...090c).
                                        Semua 1.480 aktivitas mutasi dinyatakan valid tanpa deviasi anomali.
                                    </p>
                                    <p class="text-xs text-green-600 font-semibold">
                                        <i class="fas fa-check-circle mr-1"></i>Status Integritas: 100% Cocok
                                    </p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500 whitespace-nowrap">
                                <i class="fas fa-clock mr-1"></i>3 jam lalu
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-2 ml-15">
                            <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm flex items-center gap-2">
                                <i class="fas fa-file-alt"></i>
                                <span>Buka Dokumen Audit</span>
                            </button>
                        </div>
                    </div>

                    <!-- Date Separator -->
                    <div class="flex items-center justify-between py-4 anim-fade-up" style="animation-delay: 0.8s">
                        <div class="flex items-center space-x-3">
                            <h2 class="text-sm font-bold text-gray-900 uppercase">KEMARIN — 8 NOVEMBER 2026</h2>
                            <span class="text-sm text-gray-500">• Telah ditinjau</span>
                        </div>
                    </div>

                    <!-- Card 5: Keamanan -->
                    <div class="notification-card bg-white border-l-4 border-gray-400 rounded-lg p-5 shadow-sm anim-fade-up" style="animation-delay: 0.9s">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-start space-x-3">
                                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-lock text-gray-600 text-xl"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-xs font-bold">Keamanan &amp; RBAC</span>
                                    </div>
                                    <h3 class="text-base font-bold text-gray-900 mb-1">Pembaruan Hak Akses Staf Lapangan</h3>
                                    <p class="text-sm text-gray-600 mb-2">
                                        Perubahan wewenang otorisasi cetak label manifest di lorong WH01 telah diperbarui oleh Admin Rian Hidayat
                                        untuk 3 operator barcode scanner.
                                    </p>
                                    <p class="text-xs text-gray-500">#SEC-819</p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500 whitespace-nowrap">Kemarin, 16:42 WIB</span>
                        </div>
                        <div class="flex flex-wrap gap-2 ml-15">
                            <span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-lg text-xs font-semibold flex items-center space-x-1">
                                <i class="fas fa-check"></i>
                                <span>Tervalidasi Otomatis</span>
                            </span>
                        </div>
                    </div>

                    <!-- Card 6: Stok Opsional -->
                    <div class="notification-card bg-white border-l-4 border-purple-500 rounded-lg p-5 shadow-sm anim-fade-up" style="animation-delay: 1s">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-start space-x-3">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-box text-purple-600 text-xl"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="bg-purple-500 text-white px-3 py-1 rounded-full text-xs font-bold">Stok Opsional</span>
                                    </div>
                                    <h3 class="text-base font-bold text-gray-900 mb-1">Rekonsiliasi Fisik Batch SO-2023-112 Selesai</h3>
                                    <p class="text-sm text-gray-600 mb-2">
                                        Deviasi minus 3 unit pada Lorong B3 (Rak Elektronik) telah di-input ke modul Write-Off Minor.
                                        Menunggu tinjauan berkala dari Kepala Logistik Pusat.
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        <i class="fas fa-user mr-1"></i>Supervisor: Dewi Anggraini
                                    </p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500 whitespace-nowrap">Kemarin, 11:20 WIB</span>
                        </div>
                        <div class="flex flex-wrap gap-2 ml-15">
                            <button class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm flex items-center gap-2">
                                <i class="fas fa-file-contract"></i>
                                <span>Lihat Berita Acara</span>
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Footer Load More -->
                <div class="mt-6 pt-6 border-t border-gray-200 flex items-center justify-between anim-fade-up" style="animation-delay: 1.1s">
                    <p class="text-sm text-gray-600">Menampilkan 6 dari <span class="count-up font-bold" data-target="12">0</span> notifikasi tersimpan</p>
                    <a href="#" class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center space-x-1">
                        <span>Muat Notifikasi Terdahulu</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>

            </div>

            <!-- Sidebar Kanan -->
            <aside class="panel p-4 lg:p-5 xl:sticky xl:top-20 space-y-6">

                <!-- Kanal Pengiriman Aktif -->
                <div class="anim-fade-up" style="animation-delay: 0.5s">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-900 text-sm">Kanal Pengiriman Aktif</h3>
                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-semibold">3 Aktif</span>
                    </div>
                    <p class="text-xs text-gray-600 mb-4">
                        Pemberitahuan darurat diteruskan secara paralel ke kanal operasional resmi berikut:
                    </p>

                    <div class="space-y-3">
                        <div class="channel-status flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-mobile-alt text-blue-600"></i>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">In-App Alert Dashboard</p>
                                    <p class="text-xs text-gray-500">app.astro.co.id &amp; banner</p>
                                </div>
                            </div>
                            <i class="fas fa-circle text-green-500 text-xs"></i>
                        </div>

                        <div class="channel-status flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <i class="fab fa-telegram text-blue-500"></i>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Bot Telegram Lapangan</p>
                                    <p class="text-xs text-gray-500">@astro_hr_bot</p>
                                </div>
                            </div>
                            <i class="fas fa-circle text-green-500 text-xs"></i>
                        </div>

                        <div class="channel-status flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-envelope text-red-600"></i>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Email Kedinasan</p>
                                    <p class="text-xs text-gray-500">hr4.approver@astro.co.id</p>
                                </div>
                            </div>
                            <i class="fas fa-circle text-green-500 text-xs"></i>
                        </div>

                        <button class="w-full px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm flex items-center justify-center gap-2">
                                                    <i class="fas fa-cog mr-2"></i>Kelola Preferensi &amp; Jam Senyap
                                                </button>
                    </div>
                </div>

                <!-- Gateway Telemetri -->
                <div class="anim-fade-up" style="animation-delay: 0.6s">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-900 text-sm">Gateway Telemetri</h3>
                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-semibold flex items-center space-x-1">
                            <i class="fas fa-circle text-xs"></i>
                            <span>99.98% Up</span>
                        </span>
                    </div>

                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Antrean Push</span>
                            <span class="font-bold text-gray-900">0 <span class="text-xs text-gray-500">| Zero Backlog</span></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Latency Rata-rata</span>
                            <span class="font-bold text-gray-900">14ms <span class="text-xs text-gray-500">| Optimal Hub</span></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Throughput Sinyal Kafka (24 Jam)</span>
                            <span class="font-bold text-gray-900">12.4k <span class="text-xs text-gray-500">pkt/dtk</span></span>
                        </div>
                    </div>

                    <!-- Bar Chart -->
                    <div class="bg-gray-50 rounded-lg p-3">
                        <div class="flex items-end justify-between h-24 space-x-1">
                            <div class="chart-bar bg-green-200 w-full rounded-t" style="height: 40%; animation-delay: 0s"></div>
                            <div class="chart-bar bg-green-200 w-full rounded-t" style="height: 55%; animation-delay: 0.1s"></div>
                            <div class="chart-bar bg-green-200 w-full rounded-t" style="height: 45%; animation-delay: 0.2s"></div>
                            <div class="chart-bar bg-green-300 w-full rounded-t" style="height: 70%; animation-delay: 0.3s"></div>
                            <div class="chart-bar bg-green-300 w-full rounded-t" style="height: 60%; animation-delay: 0.4s"></div>
                            <div class="chart-bar bg-green-400 w-full rounded-t" style="height: 85%; animation-delay: 0.5s"></div>
                            <div class="chart-bar bg-green-500 w-full rounded-t" style="height: 100%; animation-delay: 0.6s"></div>
                        </div>
                    </div>

                    <p class="text-xs text-gray-500 mt-2">
                        Sinkronisasi terakhir: 10:48:12 Node: dc01-edge-03-WIB
                    </p>
                </div>

                <!-- Bantuan Otorisasi Urgent -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 anim-fade-up" style="animation-delay: 0.7s">
                    <div class="flex items-start space-x-3 mb-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-life-ring text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-blue-900 text-sm mb-2">Bantuan Otorisasi Urgent</h3>
                            <p class="text-xs text-blue-800">
                                Memerlukan notifikasi yang tertahan lebih dari 60 menit tanpa persetujuan tim supervisor?
                                Segera eskalasikan ke Dispatch Dispatcher Utama.
                            </p>
                        </div>
                    </div>
                    <button class="w-full px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm flex items-center justify-center gap-2">
                                            <i class="fas fa-phone"></i>
                                            <span>Hubungi Hotline Dispatch DC-01</span>
                                        </button>
                </div>

            </aside>
        </div>
        @endif

        {{-- ================= PEGAWAI ================= --}}
        @if(auth()->user()->isPegawai())

        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-4 overflow-x-auto whitespace-nowrap anim-fade-in">
            <span>Beranda</span><i class="fas fa-chevron-right text-xs"></i>
            <span>Pengaturan &amp; Akun</span><i class="fas fa-chevron-right text-xs"></i>
            <span class="text-gray-900 font-medium">Notifikasi</span>
        </div>

        <!-- Page Header -->
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-6 anim-fade-up">
            <div class="flex-1">
                <h1 class="text-xl lg:text-2xl font-bold text-gray-900 mb-2">Pusat Notifikasi &amp; Informasi Shift</h1>
                <p class="text-sm lg:text-base text-gray-600">Pemberitahuan real-time terkait persetujuan tiket, penugasan picking &amp; inbound baru, peringatan stok opname, serta instruksi supervisor.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <button id="mark-all" class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm flex items-center gap-2">
                    <i class="fas fa-check-double"></i>Tandai Semua Sudah Dibaca
                </button>
                <button data-toast="Filter tanggal dan shift dapat dipilih." class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm flex items-center gap-2">
                    <i class="fas fa-filter"></i>Filter Tanggal &amp; Shift
                </button>
                <button data-toast="Form pengumuman cepat dibuka." class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm flex items-center gap-2">
                    <i class="fas fa-bullhorn"></i>+ Buat Pengumuman Internal / Laporan Cepat
                </button>
            </div>
        </div>

        <!-- Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6 anim-fade-up delay-1">
            <div class="metric-card panel p-4 lg:p-5">
                <p class="text-[11px] font-bold text-gray-500 tracking-wide">TOTAL NOTIFIKASI SHIFT INI</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">14 <span class="text-sm font-semibold text-gray-500">Notifikasi</span></p>
                <p class="text-xs text-gray-500 mt-1">Shift Pagi: DC Cakung · 82% terselesaikan</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <p class="text-[11px] font-bold text-red-500 tracking-wide">BELUM DIBACA (UNREAD)</p>
                <p class="text-3xl font-extrabold text-red-600 mt-1"><span id="unread-count">3</span> <span class="text-sm font-semibold text-gray-500">Pesan</span></p>
                <p class="text-xs text-gray-500 mt-1">Perlu konfirmasi segera</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <p class="text-[11px] font-bold text-emerald-600 tracking-wide">TUGAS OPERASIONAL</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">7 <span class="text-sm font-semibold text-gray-500">Tugas</span></p>
                <p class="text-xs text-gray-500 mt-1">3 Disetujui &amp; Tugas Baru · Inbound &amp; Titik Tujuan</p>
            </div>
            <div class="metric-card panel p-4 lg:p-5">
                <p class="text-[11px] font-bold text-gray-500 tracking-wide">PERINGATAN &amp; SINYAL</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">2 <span class="text-sm font-semibold text-gray-500">Insiden</span></p>
                <p class="text-xs text-gray-500 mt-1">Peringatan Stok &amp; Sinyal (Alerts)</p>
            </div>
        </div>

        <!-- Notice list -->
        <section class="panel p-4 lg:p-5 mb-6 anim-fade-up delay-2">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 pb-3 mb-4">
                <div class="flex flex-wrap gap-2">
                    <button data-kind="Semua" class="notice-tab h-9 whitespace-nowrap rounded-md bg-blue-600 px-3 text-sm font-semibold text-white">Semua Notifikasi <span class="ml-1 rounded bg-white/20 px-1">14</span></button>
                    <button data-kind="Belum Dibaca" class="notice-tab h-9 whitespace-nowrap rounded-md px-3 text-sm text-gray-600">Belum Dibaca <span class="ml-1">3</span></button>
                    <button data-kind="Tugas Operasional" class="notice-tab h-9 whitespace-nowrap rounded-md px-3 text-sm text-gray-600">Tugas Operasional</button>
                    <button data-kind="Persetujuan Tiket" class="notice-tab h-9 whitespace-nowrap rounded-md px-3 text-sm text-gray-600">Persetujuan Tiket</button>
                    <button data-kind="Peringatan Stok" class="notice-tab h-9 whitespace-nowrap rounded-md px-3 text-sm text-gray-600">Peringatan Stok</button>
                </div>
            </div>
            <div class="flex flex-col lg:flex-row lg:items-center gap-3 mb-4">
                <div class="relative flex-1 min-w-[200px]">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                    <input id="notice-search" placeholder="Cari nomor tiket, nama barang, atau nama pengirim notifikasi" class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <select id="priority" class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700"><option value="">Prioritas: Semua Tingkat</option><option>Darurat</option><option>Tinggi</option><option>Normal</option></select>
                <select id="module" class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-700"><option value="">Kategori: Semua Modul</option><option>Permintaan Tiket</option><option>Tugas Inbound</option><option>Audit Stok</option><option>Pengeluaran Barang</option><option>Status Permintaan</option></select>
                <div class="flex items-center gap-2">
                    <button id="clear-notifications" title="Bersihkan notifikasi yang dibaca" class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm text-gray-600"><i class="fas fa-broom"></i></button>
                    <button data-toast="Notifikasi diperbarui." class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm text-gray-600"><i class="fas fa-rotate"></i></button>
                </div>
            </div>
            <div id="notice-list" class="space-y-3"></div>
            <div class="flex items-center justify-between gap-3 pt-3 mt-4 border-t border-gray-100 text-sm text-gray-600">
                <span id="notice-count" aria-live="polite"></span>
                <button id="load-more" class="px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-semibold text-blue-700">Muat Notifikasi Lainnya</button>
            </div>
        </section>

        <!-- Settings -->
        <section class="anim-fade-up delay-3">
            <div class="flex items-center gap-2 mb-2">
                <i class="fas fa-sliders-h text-blue-600"></i>
                <h2 class="font-bold text-gray-900 text-sm lg:text-base">Pengaturan Notifikasi &amp; Kanal Komunikasi Shift</h2>
            </div>
            <p class="text-sm text-gray-600 mb-4">Konfigurasi preferensi ke kanal komunikasi dan eskalasi alert darurat operasional gudang.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="metric-card panel p-4 lg:p-5">
                    <div class="flex items-start justify-between mb-2">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-volume-high text-blue-600"></i></div>
                        <span class="badge bg-emerald-50 text-emerald-700"><i class="fas fa-circle" style="font-size:5px"></i>Aktif</span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-sm">Notifikasi Suara &amp; Getar Scanner</h3>
                    <p class="text-xs text-gray-500 mt-1 mb-3">Terminal Zebra TC21 dikonfigurasi pada mode Vibrate On + Beeper Volume Maksimal (100%) untuk alert staging berisik.</p>
                    <button data-toast="Pengaturan suara terminal dibuka." class="w-full px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm flex items-center justify-center gap-2"><i class="fas fa-bell"></i>Atur Nada Dering</button>
                </div>
                <div class="metric-card panel p-4 lg:p-5">
                    <div class="flex items-start justify-between mb-2">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center"><i class="fas fa-radio text-blue-600"></i></div>
                        <span class="badge bg-blue-50 text-blue-700"><i class="fas fa-circle" style="font-size:5px"></i>Kanal 04 Terhubung</span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-sm">Pengumuman Darurat Supervisor</h3>
                    <p class="text-xs text-gray-500 mt-1 mb-3">Sinkronisasi pesan suara darurat dengan radio HT Saluran 04 Hub DC Cakung dan peringatan lampu strobo dock.</p>
                    <button data-toast="Status radio HT: terhubung di Channel 04." class="w-full px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm flex items-center justify-center gap-2"><i class="fas fa-tower-broadcast"></i>Cek Saluran Radio</button>
                </div>
                <div class="metric-card panel p-4 lg:p-5">
                    <div class="flex items-start justify-between mb-2">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center"><i class="fas fa-clock text-gray-600"></i></div>
                        <span class="badge bg-gray-100 text-gray-600"><i class="fas fa-circle" style="font-size:5px"></i>Otomatis 30 Hari</span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-sm">Retensi Pemberitahuan Staf</h3>
                    <p class="text-xs text-gray-500 mt-1 mb-3">Log notifikasi workflow, audit slip, dan approval tiket tersimpan aman dalam server lokal DC Cakung selama 30 hari terakhir.</p>
                    <button data-toast="Pengaturan arsip notifikasi dibuka." class="w-full px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm flex items-center justify-center gap-2"><i class="fas fa-download"></i>Unduh Arsip Log Notifikasi</button>
                </div>
            </div>
        </section>
        @endif

        {{-- ================= SUPERADMIN / AUDITOR (placeholder) ================= --}}
        @if(auth()->user()->isSuperAdmin() || auth()->user()->isAuditor())
        <div class="panel p-10 text-center anim-fade-up">
            <i class="fas fa-bell text-4xl text-gray-300 mb-3"></i>
            <h2 class="text-lg font-bold text-gray-900">Pusat Notifikasi</h2>
            <p class="text-sm text-gray-500 mt-1 max-w-md mx-auto">Halaman notifikasi untuk role ini belum tersedia pada prototype. Silakan gunakan menu Dashboard untuk pemantauan aktivitas.</p>
        </div>
        @endif

    </main>
</div>

<!-- ============ MODAL: preferensi (Kepala Gudang) ============ -->
<div class="modal-overlay" id="modalPref">
    <div class="modal-box" style="max-width:560px">
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-900"><i class="fas fa-sliders-h mr-2 text-blue-600"></i>Kelola Preferensi Notifikasi</h3>
            <button data-close-modal class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
        </div>
        <div class="p-4 space-y-3 text-sm">
            <label class="flex items-center justify-between p-3 border border-gray-200 rounded-lg"><span>Notifikasi Persetujuan &amp; Mutasi Urgent</span><input type="checkbox" checked class="rounded text-blue-600"></label>
            <label class="flex items-center justify-between p-3 border border-gray-200 rounded-lg"><span>Peringatan Stok &amp; ROP &lt; 30 Menit</span><input type="checkbox" checked class="rounded text-blue-600"></label>
            <label class="flex items-center justify-between p-3 border border-gray-200 rounded-lg"><span>Log Audit Mingguan Terenkripsi</span><input type="checkbox" checked class="rounded text-blue-600"></label>
            <label class="flex items-center justify-between p-3 border border-gray-200 rounded-lg"><span>Pembaruan Hak Akses Staf</span><input type="checkbox" class="rounded text-blue-600"></label>
            <label class="flex items-center justify-between p-3 border border-gray-200 rounded-lg"><span>Rekonsiliasi &amp; Write-off Minor</span><input type="checkbox" checked class="rounded text-blue-600"></label>
            <div class="p-3 bg-[#eff4ff] rounded-lg">
                <p class="text-xs font-medium text-gray-700 mb-2">Jam Senyap (Quiet Hours)</p>
                <div class="flex items-center gap-2">
                    <input type="time" value="22:00" class="px-2 py-1 border border-gray-300 rounded text-sm">
                    <span class="text-gray-400">—</span>
                    <input type="time" value="06:00" class="px-2 py-1 border border-gray-300 rounded text-sm">
                    <span class="text-xs text-gray-500 ml-auto">Notifikasi urgent tetap aktif</span>
                </div>
            </div>
        </div>
        <div class="p-4 border-t border-gray-100 flex justify-end gap-2">
            <button data-close-modal class="px-4 py-2 border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Batal</button>
            <button data-close-modal onclick="toast('Preferensi notifikasi disimpan.','success')" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">Simpan Preferensi</button>
        </div>
    </div>
</div>

<script>
/* ============================================================
   Shared interaction layer (toast + modal)
   ============================================================ */
(function () {
    'use strict';

    /* ---------- Toast ---------- */
    function toast(msg, type) {
        var c = document.getElementById('toast-container');
        if (!c) { c = document.createElement('div'); c.id = 'toast-container'; document.body.appendChild(c); }
        var t = document.createElement('div');
        t.className = 'toast ' + (type || '');
        t.textContent = msg;
        c.appendChild(t);
        setTimeout(function () { t.style.opacity = '0'; t.style.transition = 'opacity .3s'; setTimeout(function () { t.remove(); }, 300); }, 3200);
    }
    window.toast = toast;

    /* ---------- Modals ---------- */
    window.openModal = function (id) {
        var m = document.getElementById(id);
        if (m) m.classList.add('open');
    };
    window.closeModal = function (id) {
        var m = document.getElementById(id);
        if (m) m.classList.remove('open');
    };
    function initModals() {
        document.querySelectorAll('.modal-overlay').forEach(function (m) {
            m.addEventListener('click', function (e) { if (e.target === m) m.classList.remove('open'); });
        });
        document.querySelectorAll('[data-close-modal]').forEach(function (b) {
            b.addEventListener('click', function () {
                var m = b.closest('.modal-overlay'); if (m) m.classList.remove('open');
            });
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') document.querySelectorAll('.modal-overlay.open').forEach(function (m) { m.classList.remove('open'); });
        });
    }
    document.addEventListener('DOMContentLoaded', initModals);
})();
</script>

<script>
/* ============================================================
   Kepala Gudang — filter notif list by kanal/jenis/status
   ============================================================ */
(function () {
    var searchEl = document.getElementById('searchNotif');
    if (!searchEl) return; // role lain tidak punya elemen ini

    function applyNotifFilter() {
        var q = (searchEl.value || '').toLowerCase().trim();
        var kanal = document.getElementById('fKanal').value;
        var jenis = document.getElementById('fJenis').value;
        var status = document.getElementById('fStatus').value;
        document.querySelectorAll('[data-kanal]').forEach(function (el) {
            var matchQ = !q || el.textContent.toLowerCase().indexOf(q) !== -1;
            var matchK = !kanal || el.getAttribute('data-kanal') === kanal;
            var matchJ = !jenis || el.getAttribute('data-jenis') === jenis;
            var matchS = !status || el.getAttribute('data-status') === status;
            el.style.display = (matchQ && matchK && matchJ && matchS) ? '' : 'none';
        });
    }
    searchEl.addEventListener('input', applyNotifFilter);
    document.getElementById('fKanal').addEventListener('change', applyNotifFilter);
    document.getElementById('fJenis').addEventListener('change', applyNotifFilter);
    document.getElementById('fStatus').addEventListener('change', applyNotifFilter);
})();
</script>

<script>
/* ============================================================
   HR — count up animation + tab filter
   ============================================================ */
(function () {
    if (document.querySelectorAll('.count-up').length) {
        function animateCountUp() {
            var counters = document.querySelectorAll('.count-up');
            counters.forEach(function (counter) {
                var target = parseInt(counter.getAttribute('data-target'));
                var duration = 1500;
                var increment = target / (duration / 16);
                var current = 0;
                function updateCounter() {
                    current += increment;
                    if (current < target) {
                        counter.textContent = Math.floor(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                }
                updateCounter();
            });
        }
        window.addEventListener('load', function () {
            setTimeout(animateCountUp, 500);
        });
    }

    var tabs = document.querySelectorAll('.tab-filter');
    if (tabs.length) {
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(function (t) { t.classList.remove('active'); });
                this.classList.add('active');
            });
        });
    }
})();
</script>

<script>
/* ============================================================
   Pegawai — dynamic notification list (render + filter)
   Ikon lucide diganti Font Awesome agar konsisten dengan tema.
   ============================================================ */
(function () {
    if (!document.getElementById('notice-list')) return; // role lain tidak punya elemen ini

    var iconMap = {
        'package-check': 'fa-boxes-packing',
        'truck': 'fa-truck',
        'clipboard-check': 'fa-clipboard-check',
        'triangle-alert': 'fa-triangle-exclamation',
        'clipboard-list': 'fa-clipboard-list',
        'megaphone': 'fa-bullhorn',
        'refresh-cw': 'fa-rotate'
    };
    function iconClass(name) { return 'fa-' + (iconMap[name] || 'bell'); }

    var all = [
        {id:'TIKET REQ-2025-1042',time:'5 menit yang lalu (13:55 WIB)',sender:'Hendra Wijaya (Kepala Gudang Cakung)',kind:'Persetujuan Tiket',module:'Permintaan Tiket',priority:'Darurat',title:'Penggantian Scanner Zebra TC21 Rusak Telah Disetujui',body:'Permintaan handheld pengganti siap diambil di Locker Tools Room L-02 dengan menunjukkan barcode pinjam. Segera serahkan unit yang rusak ke Tim IT Support DC.',actions:['Ambil Barcode Slip','Lihat Detail Tiket'],icon:'package-check',unread:true},
        {id:'TUGAS INBOUND BARU · DOCK 02',time:'22 menit yang lalu (13:38 WIB)',sender:'Sistem Otomasi Gerbang DC',kind:'Tugas Operasional',module:'Tugas Inbound',priority:'Tinggi',title:'Armada Masuk Truk Box Schneider (B-9421-KDC) Tiba di Dock Receiving',body:'Surat Jalan SJ-CHB-1827 (PO-2025-0894) membutuhkan 1 checker untuk verifikasi fisik 1.420 unit. Anda dialokasikan sebagai checker shift berjalan.',actions:['Buka Form Input Inbound','Lihat Manifest Truk'],icon:'truck',unread:true},
        {id:'AUDIT STOK OPNAME · INVESTIGASI SELISIH',time:'45 menit yang lalu (13:15 WIB)',sender:'Supervisor Shift (Bambang H.)',kind:'Peringatan Stok',module:'Audit Stok',priority:'Normal',title:'Klarifikasi Selisih -3 Unit Barcode Scanner Zebra di Bin Locator Rak B-12',body:'Ditemukan selisih pada sesi opname SO-2025-0872. Harap lakukan blind second count bersama staf checker sebelum pukul 15:30 WIB.',actions:['Masuk Sesi Audit Rak B-12','Unggah Bukti Fisik'],icon:'clipboard-check',unread:true},
        {id:'PENGELUARAN BARANG · OUTBOUND',time:'1 jam yang lalu (12:00 WIB)',sender:'Dispatch Controller Hub',kind:'Tugas Operasional',module:'Pengeluaran Barang',priority:'Normal',title:'Surat Jalan DO-2025-0447 Tujuan Regional Bandung Berhasil Diverifikasi',body:'Truk Box B-9921-UTN telah keluar dari Gate 04 dengan segel pintu nomor 981-772931. Transaksi telah tercatat di sistem.',actions:['Lihat Bukti Surat Jalan'],icon:'truck',unread:false},
        {id:'STATUS PERMINTAAN · PERLENGKAPAN SHIFT',time:'3 jam yang lalu (10:15 WIB)',sender:'Siti Rahma (Admin Inventory DC)',kind:'Persetujuan Tiket',module:'Status Permintaan',priority:'Normal',title:'Pengajuan 5 Roll Bubble Wrap Heavy Duty Telah Divalidasi',body:'Konsumsi normal telah dicatat dalam kuota staging packing area lama A.',actions:['Rincian Tiket'],icon:'clipboard-list',unread:false}
    ];
    all.push(
        {id:'TUGAS PICKING · ZONA A',time:'4 jam yang lalu (09:20 WIB)',sender:'Supervisor Shift Pagi',kind:'Tugas Operasional',module:'Tugas Inbound',priority:'Normal',title:'Penugasan Picking SKU Elektronik Selesai Dialokasikan',body:'Batch PK-2025-2218 untuk Zona A tersedia pada terminal Anda.',actions:['Lihat Detail Tugas'],icon:'package-check',unread:false},
        {id:'PERSETUJUAN TIKET · REQ-2025-0962',time:'5 jam yang lalu (08:45 WIB)',sender:'Bambang H. (Supervisor Shift)',kind:'Persetujuan Tiket',module:'Permintaan Tiket',priority:'Normal',title:'Permintaan Label Barcode Thermal Telah Disetujui',body:'Empat box label thermal dapat diambil di Tool Crib sebelum mulai proses inbound.',actions:['Rincian Tiket'],icon:'clipboard-check',unread:false},
        {id:'PERINGATAN STOK · ZONA C',time:'Kemarin (16:40 WIB)',sender:'Sistem Monitoring Persediaan',kind:'Peringatan Stok',module:'Audit Stok',priority:'Tinggi',title:'Stok Buffer Kabel Jaringan Mendekati Batas Minimum',body:'Pemeriksaan ulang kuantitas fisik dijadwalkan pada cycle count berikutnya.',actions:['Lihat Detail Stok'],icon:'triangle-alert',unread:false},
        {id:'TUGAS INBOUND · PO-2025-0887',time:'Kemarin (15:10 WIB)',sender:'Sistem Otomasi Gerbang DC',kind:'Tugas Operasional',module:'Tugas Inbound',priority:'Normal',title:'Dokumen Penerimaan PO-2025-0887 Telah Lengkap',body:'Berkas penerimaan tervalidasi. Silakan lanjutkan pemeriksaan kualitas barang.',actions:['Buka Form Inbound'],icon:'truck',unread:false},
        {id:'STATUS PERMINTAAN · REQ-2025-0955',time:'Kemarin (14:25 WIB)',sender:'Siti Rahma (Admin Inventory DC)',kind:'Persetujuan Tiket',module:'Status Permintaan',priority:'Normal',title:'Permintaan Perlengkapan Staging Siap Diambil',body:'Permintaan sarung tangan kerja sudah diproses sesuai kuota shift.',actions:['Lihat Status'],icon:'clipboard-list',unread:false},
        {id:'AUDIT STOK OPNAME · SO-2025-0861',time:'Kemarin (13:50 WIB)',sender:'Supervisor Shift (Bambang H.)',kind:'Peringatan Stok',module:'Audit Stok',priority:'Normal',title:'Jadwal Cycle Count Zona B Diperbarui',body:'Sesi hitung fisik dimulai pukul 16:00 WIB pada rak B-12.',actions:['Lihat Jadwal Audit'],icon:'clipboard-check',unread:false},
        {id:'PENGELUARAN BARANG · DO-2025-0439',time:'Kemarin (12:35 WIB)',sender:'Dispatch Controller Hub',kind:'Tugas Operasional',module:'Pengeluaran Barang',priority:'Normal',title:'Verifikasi Barang Keluar Regional Bekasi Selesai',body:'Dokumen serah terima sudah dicatat pada log shift.',actions:['Lihat Bukti Surat Jalan'],icon:'truck',unread:false},
        {id:'PENGUMUMAN SHIFT · DC-01',time:'Kemarin (11:10 WIB)',sender:'Kepala Gudang Cakung',kind:'Tugas Operasional',module:'Status Permintaan',priority:'Normal',title:'Briefing Keselamatan Kerja Sebelum Pergantian Shift',body:'Seluruh staf zona receiving diminta hadir di area briefing pada pukul 16:30 WIB.',actions:['Baca Pengumuman'],icon:'megaphone',unread:false},
        {id:'SISTEM · TERMINAL ZBR-TC21-042',time:'Kemarin (08:05 WIB)',sender:'Sistem Astro Inventory',kind:'Tugas Operasional',module:'Tugas Inbound',priority:'Normal',title:'Sinkronisasi Data Terminal Berhasil',body:'Seluruh transaksi offline dari sesi sebelumnya sudah tersinkron ke server gudang.',actions:['Lihat Status Perangkat'],icon:'refresh-cw',unread:false}
    );

    var mode = 'Semua', limit = 5, timer;
    var list = document.getElementById('notice-list');
    function esc(s) { return String(s).replace(/[&<>"']/g, function (c) { return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]); }); }

    function render() {
        var q = document.getElementById('notice-search').value.toLowerCase();
        var p = document.getElementById('priority').value;
        var m = document.getElementById('module').value;
        var filtered = all.filter(function (n) {
            return (mode === 'Semua' || (mode === 'Belum Dibaca' ? n.unread : n.kind === mode)) &&
                (!q || Object.values(n).join(' ').toLowerCase().indexOf(q) !== -1) &&
                (!p || n.priority === p) && (!m || n.module === m);
        });
        list.innerHTML = filtered.slice(0, limit).map(function (n, i) {
            var border = n.priority === 'Darurat' ? 'border-red-500' : (n.kind === 'Tugas Operasional' ? 'border-blue-500' : 'border-gray-300');
            var iconBg = n.priority === 'Darurat' ? 'bg-red-50 text-red-600' : (n.kind === 'Tugas Operasional' ? 'bg-blue-50 text-blue-600' : 'bg-gray-100 text-gray-600');
            var idColor = n.priority === 'Darurat' ? 'text-red-600' : 'text-blue-700';
            return '<article class="notice-in flex gap-3 rounded-lg border-l-[3px] ' + border + ' ' + (n.unread ? 'bg-white' : 'bg-gray-50/70') + ' p-4" style="animation-delay:' + (i * 25) + 'ms">' +
                '<span class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-md ' + iconBg + '"><i class="fas ' + iconClass(n.icon) + '"></i></span>' +
                '<div class="min-w-0 flex-1">' +
                '<div class="flex flex-wrap items-center gap-2 text-xs"><b class="' + idColor + '">' + esc(n.id) + '</b><span>· ' + esc(n.time) + '</span><span>· ' + esc(n.sender) + '</span>' +
                '<button data-read="' + esc(n.id) + '" class="ml-auto whitespace-nowrap rounded-md bg-gray-50 px-2.5 py-1 text-xs">' + (n.unread ? '✓ Tandai Dibaca' : '✓ Dibaca') + '</button>' +
                (n.unread ? '<i class="fas fa-circle h-1.5 w-1.5 shrink-0 rounded-full text-blue-600" style="font-size:5px"></i>' : '') + '</div>' +
                '<b class="mt-1 block text-sm text-gray-900">' + esc(n.title) + '</b>' +
                '<p class="mt-0.5 text-xs leading-relaxed text-gray-500">' + esc(n.body) + '</p>' +
                '<div class="mt-2 flex flex-wrap gap-2">' + n.actions.map(function (a) { return '<button data-action="' + esc(a) + '" class="whitespace-nowrap rounded-md bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">' + esc(a) + '</button>'; }).join('') + '</div>' +
                '</div></article>';
        }).join('') || '<p class="p-6 text-center text-xs text-gray-500">Tidak ada notifikasi yang cocok.</p>';

        document.getElementById('notice-count').textContent = 'Menampilkan ' + Math.min(limit, filtered.length) + ' dari ' + filtered.length + ' notifikasi';
        var unread = all.filter(function (n) { return n.unread; }).length;
        document.getElementById('unread-count').textContent = unread;
        var loadMore = document.getElementById('load-more');
        loadMore.disabled = limit >= filtered.length;
        loadMore.classList.toggle('opacity-50', limit >= filtered.length);
    }

    document.querySelectorAll('.notice-tab').forEach(function (b) {
        b.onclick = function () {
            mode = b.dataset.kind;
            document.querySelectorAll('.notice-tab').forEach(function (x) {
                x.className = x === b ? 'notice-tab h-9 whitespace-nowrap rounded-md bg-blue-600 px-3 text-sm font-semibold text-white' : 'notice-tab h-9 whitespace-nowrap rounded-md px-3 text-sm text-gray-600';
            });
            render();
        };
    });
    ['notice-search', 'priority', 'module'].forEach(function (id) {
        document.getElementById(id).addEventListener(id === 'notice-search' ? 'input' : 'change', render);
    });
    document.getElementById('mark-all').onclick = function () {
        all.forEach(function (n) { n.unread = false; });
        render();
        toast('Semua notifikasi ditandai sudah dibaca.');
    };
    document.getElementById('load-more').onclick = function () { limit += 5; render(); };
    document.getElementById('clear-notifications').onclick = function () {
        all = all.filter(function (n) { return n.unread; });
        render();
        toast('Notifikasi yang sudah dibaca dihapus dari tampilan.');
    };
    list.addEventListener('click', function (e) {
        var b = e.target.closest('[data-read],[data-action]');
        if (!b) return;
        if (b.dataset.read) {
            var n = all.find(function (x) { return x.id === b.dataset.read; });
            n.unread = false;
            render();
        } else {
            toast(b.dataset.action + ': instruksi tersedia untuk shift aktif.');
        }
    });
    document.querySelectorAll('[data-toast]').forEach(function (b) { b.onclick = function () { toast(b.dataset.toast); }; });
    render();
})();
</script>

</body>
</html>
