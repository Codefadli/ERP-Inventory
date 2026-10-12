<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="web_standard" name="shell-type"/>
    <title>@yield('title', 'Astro Warehouse Intelligence — Hub Cikarang DC-01')</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-primary": "#ffffff",
                        "primary-fixed": "#d9e2ff",
                        "on-error-container": "#93000a",
                        "surface-bright": "#f8f9ff",
                        "inverse-primary": "#b0c6ff",
                        "surface-container-lowest": "#ffffff",
                        "surface-variant": "#d3e4fe",
                        "background": "#f8f9ff",
                        "on-secondary-fixed-variant": "#004b73",
                        "primary-container": "#0a58ca",
                        "on-tertiary-fixed-variant": "#3f465c",
                        "on-tertiary-fixed": "#131b2e",
                        "outline-variant": "#c3c6d6",
                        "on-error": "#ffffff",
                        "on-secondary-container": "#00476e",
                        "on-secondary-fixed": "#001d31",
                        "on-secondary": "#ffffff",
                        "tertiary-container": "#565e74",
                        "surface-container-highest": "#d3e4fe",
                        "surface-container-high": "#dce9ff",
                        "secondary-fixed": "#cce5ff",
                        "on-primary-fixed-variant": "#00419d",
                        "on-tertiary": "#ffffff",
                        "error-container": "#ffdad6",
                        "secondary-container": "#5bb8fe",
                        "on-background": "#0b1c30",
                        "primary": "#00429d",
                        "secondary": "#006398",
                        "on-surface": "#0b1c30",
                        "surface-container-low": "#eff4ff",
                        "inverse-on-surface": "#eaf1ff",
                        "secondary-fixed-dim": "#93ccff",
                        "tertiary-fixed-dim": "#bec6e0",
                        "outline": "#737785",
                        "surface-container": "#e5eeff",
                        "surface-dim": "#cbdbf5",
                        "inverse-surface": "#213145",
                        "on-primary-container": "#ccd8ff",
                        "on-surface-variant": "#424653",
                        "primary-fixed-dim": "#b0c6ff",
                        "on-primary-fixed": "#001945",
                        "error": "#ba1a1a",
                        "on-tertiary-container": "#d0d8f2",
                        "surface-tint": "#0958ca",
                        "tertiary-fixed": "#dae2fd",
                        "surface": "#f8f9ff",
                        "tertiary": "#3f465c"
                    },
                    fontFamily: {
                        "headline": ["Plus Jakarta Sans", "sans-serif"],
                        "body": ["Inter", "sans-serif"],
                        "mono": ["JetBrains Mono", "monospace"]
                    }
                }
            }
        }
    </script>
    <style>
        @layer base {
            html, body {
                margin: 0;
                padding: 0;
                font-family: 'Inter', sans-serif;
                background-color: #f7f9fd;
                color: #0b1c30;
                letter-spacing: -0.011em;
            }
        }
        .mesh-gradient {
            background: radial-gradient(at 0% 0%, rgba(217, 226, 255, 0.45) 0px, transparent 50%),
                        radial-gradient(at 100% 0%, rgba(204, 229, 255, 0.35) 0px, transparent 40%),
                        radial-gradient(at 50% 100%, rgba(240, 246, 255, 0.6) 0px, transparent 60%);
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .subtle-border {
            border: 1px solid rgba(195, 198, 214, 0.38);
        }
        .custom-scroll::-webkit-scrollbar {
            height: 6px;
            width: 6px;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background: #c3c6d6;
            border-radius: 9999px;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-[#f7f9fd] antialiased selection:bg-primary-fixed selection:text-primary min-h-screen flex flex-col font-body">
    
    <!-- TOP APP BAR -->
    <header class="sticky top-0 z-40 w-full glass-panel border-b border-slate-200/60 shadow-[0_1px_12px_rgba(11,28,48,0.03)] transition-all">
        <div class="max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            <!-- Brand & Facility Switcher -->
            <div class="flex items-center gap-6">
                <a class="flex items-center gap-3 group" href="{{ url('/') }}">
                    <div class="h-9 w-9 rounded-xl bg-gradient-to-tr from-primary to-[#006398] p-0.5 shadow-sm shadow-primary/20 flex items-center justify-center transition-transform group-hover:scale-105">
                        <img alt="Astro Warehouse Logo" class="h-6 w-auto object-contain brightness-0 invert" src="https://lh3.googleusercontent.com/aida-public/AB6AXuApsZiR4iNtSixU0qGFTMmtCi2D4sAwjG2GXkatjf979WkLO-WkhR8vBMvhtp-997d7woiAYbgeMVUeWzPafvcIpHnc8J385G-bDdSl1gfNJ4LUPKrsT0uDtsv1XPJypKOkUubW7pbncTKRwo-aOZPFgsSpVN4SP-I-poZGuiTmkHr-k3T-6z5VVUkyUiuW8YLrrPpDEa1sqZCltyLvQbUlqF3nNIQ9ERyNfSoOJnHGW3utckOt-uJzyA"/>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-center gap-1.5">
                            <span class="font-headline font-bold text-[15px] tracking-tight text-on-surface">Astro WMS</span>
                            <span class="px-1.5 py-0.5 rounded-full bg-primary/10 text-primary text-[10px] font-mono font-medium tracking-wide">ENTERPRISE</span>
                        </div>
                        <span class="text-[11px] text-on-surface-variant font-medium">Logistics &amp; Supply Hub</span>
                    </div>
                </a>
                <!-- Facility Pill Indicator -->
                <div class="hidden md:flex items-center gap-2 pl-4 border-l border-slate-200/70">
                    <button class="group flex items-center gap-2 px-3 py-1.5 rounded-full bg-surface-container-low hover:bg-surface-container border border-slate-200/50 transition-all text-left">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <div class="flex flex-col">
                            <span class="text-[10px] uppercase tracking-wider text-on-surface-variant font-medium">Fasilitas Utama</span>
                            <span class="text-[12px] font-headline font-semibold text-on-surface group-hover:text-primary transition-colors flex items-center gap-0.5">
                                Hub Cikarang DC-01
                                <span class="material-symbols-outlined text-[15px] text-slate-400 group-hover:text-primary">expand_more</span>
                            </span>
                        </div>
                    </button>
                </div>
            </div>
            <!-- Navigation Links (Linear/Stripe subtle pill tabs) -->
            <nav class="hidden xl:flex items-center gap-1 bg-slate-100/70 p-1 rounded-full border border-slate-200/60">
                <a aria-current="page" class="px-3.5 py-1.5 rounded-full text-[13px] font-headline font-semibold bg-white text-primary shadow-[0_1px_3px_rgba(0,0,0,0.06)] border border-slate-200/50 transition-all" href="{{ url('/') }}">
                    Dashboard
                </a>
                <a class="px-3.5 py-1.5 rounded-full text-[13px] font-headline font-medium text-on-surface-variant hover:text-on-surface hover:bg-white/60 transition-all" href="#">
                    Inbound &amp; Outbound
                </a>
                <a class="px-3.5 py-1.5 rounded-full text-[13px] font-headline font-medium text-on-surface-variant hover:text-on-surface hover:bg-white/60 transition-all" href="#">
                    Katalog Produk
                </a>
                <a class="px-3.5 py-1.5 rounded-full text-[13px] font-headline font-medium text-on-surface-variant hover:text-on-surface hover:bg-white/60 transition-all" href="#">
                    Mutasi Stok
                </a>
                <a class="px-3.5 py-1.5 rounded-full text-[13px] font-headline font-medium text-on-surface-variant hover:text-on-surface hover:bg-white/60 transition-all" href="#">
                    Laporan &amp; Audit
                </a>
            </nav>
            <!-- Right Actions & Human Profile -->
            <div class="flex items-center gap-3">
                <!-- Quick Utility Buttons -->
                <div class="flex items-center gap-1">
                    <button class="w-9 h-9 rounded-full flex items-center justify-center text-slate-500 hover:text-on-surface hover:bg-surface-container transition-all" title="Bantuan &amp; SOP">
                        <span class="material-symbols-outlined text-[20px]">help_outline</span>
                    </button>
                    <button class="relative w-9 h-9 rounded-full flex items-center justify-center text-slate-500 hover:text-on-surface hover:bg-surface-container transition-all" title="Notifikasi Baru">
                        <span class="material-symbols-outlined text-[20px]">notifications</span>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full ring-2 ring-white"></span>
                    </button>
                </div>
                <!-- Human Profile Section -->
                <div class="flex items-center gap-3 pl-2 sm:pl-3 border-l border-slate-200/60">
                    <div class="relative cursor-pointer group flex items-center gap-2.5">
                        <div class="relative">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-primary to-secondary-container flex items-center justify-center text-white font-headline font-bold text-xs ring-2 ring-white shadow-sm">
                                RP
                            </div>
                            <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-500 ring-2 ring-white" title="Status: On Duty"></span>
                        </div>
                        <div class="hidden sm:flex flex-col text-left">
                            <span class="font-headline font-bold text-[13px] text-on-surface group-hover:text-primary transition-colors leading-tight">Rian Pratama</span>
                            <div class="flex items-center gap-1.5 text-[11px] text-slate-500">
                                <span class="font-medium text-primary">Supervisor</span>
                                <span>•</span>
                                <span class="text-emerald-600 font-medium">Shift Pagi</span>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-slate-400 group-hover:text-slate-600 text-[18px]">keyboard_arrow_down</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- MAIN CANVAS -->
    <main class="flex-1 w-full max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-7 mesh-gradient">
        @yield('content')
    </main>

    <!-- QUICK ACTION MODAL / SCANNER SPOTLIGHT -->
    <div class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm hidden items-center justify-center p-4" id="quickActionModal">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6 flex flex-col gap-5 animate-in fade-in zoom-in-95 duration-150 border border-slate-200/80">
            <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-[22px]" id="modalIcon">qr_code_scanner</span>
                    </div>
                    <div>
                        <h3 class="font-headline font-bold text-base text-on-surface" id="modalTitle">Terminal Scanner Handheld</h3>
                        <p class="text-xs text-slate-500">Pemindaian inventaris real-time</p>
                    </div>
                </div>
                <button class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors" onclick="closeModal()" type="button">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            <div class="p-6 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-center gap-3">
                <div class="w-14 h-14 rounded-2xl bg-blue-100/60 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-[32px]">barcode_reader</span>
                </div>
                <div class="flex flex-col gap-0.5">
                    <span class="font-headline font-bold text-sm text-on-surface">Arahkan Laser Scanner ke Kode Barcode / QR</span>
                    <span class="text-xs text-slate-500">Mendukung format UPC-A, EAN-13, GS1 DataMatrix, &amp; Tag Pallet Astro</span>
                </div>
                <div class="w-full max-w-sm mt-2">
                    <input class="w-full h-11 px-4 rounded-xl bg-white border border-slate-200 text-on-surface font-mono text-xs placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-center" placeholder="Atau ketik SKU manual (misal: AST-8821)" type="text"/>
                </div>
            </div>
            <div class="flex items-center justify-between text-xs text-slate-500 pt-1">
                <span class="flex items-center gap-1.5 font-medium">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Zebra TC26 Handheld Terkoneksi
                </span>
                <span class="font-mono text-[11px] text-slate-400">COM4 / Port Terbuka</span>
            </div>
            <div class="flex items-center justify-end gap-2.5 pt-2">
                <button class="h-10 px-4 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 font-headline font-semibold text-xs transition-colors" onclick="closeModal()" type="button">
                    Batal
                </button>
                <button class="h-10 px-5 rounded-xl bg-primary hover:bg-primary-container text-white font-headline font-semibold text-xs flex items-center gap-1.5 shadow-sm shadow-primary/20 transition-all active:scale-[0.98]" onclick="confirmScanSimulated()" type="button">
                    <span class="material-symbols-outlined text-[15px]">check_circle</span>
                    <span>Proses Kode SKU</span>
                </button>
            </div>
        </div>
    </div>

    <!-- MODERN MINIMAL FOOTER -->
    <footer class="w-full bg-white border-t border-slate-200/70 py-6 mt-12">
        <div class="max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <div class="flex flex-wrap items-center gap-4">
                <span>© 2025 <strong>Astro Supply &amp; Logistics Corp.</strong> Seluruh hak cipta dilindungi.</span>
                <span class="text-slate-300 hidden sm:inline">•</span>
                <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-medium border border-emerald-200/50">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Sistem Operasional Optimal (Latency 24ms)</span>
                </div>
                <span class="text-slate-300 hidden sm:inline">•</span>
                <div class="flex items-center gap-1 font-mono text-slate-400">
                    <span class="material-symbols-outlined text-[14px]">sync</span>
                    <span>Sinkronisasi otomatis aktif</span>
                </div>
            </div>
            <div class="flex items-center gap-4 font-medium">
                <a class="text-slate-500 hover:text-primary transition-colors" href="#">SOP Gudang</a>
                <span class="text-slate-300">•</span>
                <a class="text-slate-500 hover:text-primary transition-colors" href="#">Pusat Bantuan</a>
                <span class="text-slate-300">•</span>
                <a class="text-slate-500 hover:text-primary transition-colors" href="#">Hubungi IT Ops</a>
            </div>
        </div>
    </footer>

    <!-- SCRIPT LOGIC -->
    <script>
        // Filter Tabs Catalog Logic
        function filterCatalog(category) {
            const tabs = ['btnCatAll', 'btnCatFast', 'btnCatLow', 'btnCatNew'];
            tabs.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.className = 'px-3.5 py-1.5 rounded-lg text-xs font-headline font-medium text-slate-600 hover:text-on-surface hover:bg-white/60 transition-all';
                }
            });

            const activeMap = {
                all: 'btnCatAll',
                fast: 'btnCatFast',
                low: 'btnCatLow',
                new: 'btnCatNew'
            };

            const activeEl = document.getElementById(activeMap[category]);
            if (activeEl) {
                activeEl.className = 'px-3.5 py-1.5 rounded-lg text-xs font-headline font-semibold bg-white text-primary shadow-xs transition-all';
            }

            const rows = document.querySelectorAll('#catalogTableBody tr');
            rows.forEach(row => {
                if (category === 'all') {
                    row.style.display = '';
                } else {
                    const rowCat = row.getAttribute('data-category');
                    row.style.display = (rowCat === category) ? '' : 'none';
                }
            });
        }

        // Notif Filter Switcher
        function switchNotifTab(type) {
            const btnAll = document.getElementById('tabInboundBtn');
            const btnInb = document.getElementById('tabInboundFilter');
            const btnOut = document.getElementById('tabOutboundFilter');

            [btnAll, btnInb, btnOut].forEach(b => {
                b.className = 'px-3 py-1 rounded-md text-slate-600 hover:text-on-surface font-medium';
            });

            if (type === 'all') btnAll.className = 'px-3 py-1 rounded-md font-semibold bg-white text-primary shadow-2xs';
            if (type === 'inbound') btnInb.className = 'px-3 py-1 rounded-md font-semibold bg-white text-primary shadow-2xs';
            if (type === 'outbound') btnOut.className = 'px-3 py-1 rounded-md font-semibold bg-white text-primary shadow-2xs';

            const items = document.querySelectorAll('#notifContainer .notif-item');
            items.forEach(item => {
                if (type === 'all') {
                    item.style.display = 'flex';
                } else {
                    item.style.display = item.classList.contains(type) ? 'flex' : 'none';
                }
            });
        }

        // Handle Approval Action
        function handleApproval(elementId, isApproved) {
            const card = document.getElementById(elementId);
            if (!card) return;

            if (isApproved) {
                card.innerHTML = `
                    <div class="flex items-center justify-between p-3.5 bg-emerald-50 border border-emerald-200/70 rounded-xl animate-in fade-in">
                        <div class="flex items-center gap-2 text-xs font-medium text-emerald-900">
                            <span class="material-symbols-outlined text-emerald-600 text-[18px]">check_circle</span>
                            <span>Permintaan Restock SKU-4019 Berhasil <strong>Disetujui</strong></span>
                        </div>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-200/70 text-emerald-800 text-[10px] font-mono font-bold">Disetujui</span>
                    </div>
                `;
            } else {
                card.innerHTML = `
                    <div class="flex items-center justify-between p-3.5 bg-rose-50 border border-rose-200/70 rounded-xl animate-in fade-in">
                        <div class="flex items-center gap-2 text-xs font-medium text-rose-900">
                            <span class="material-symbols-outlined text-rose-600 text-[18px]">cancel</span>
                            <span>Permintaan Restock SKU-4019 <strong>Ditolak</strong></span>
                        </div>
                        <span class="px-2 py-0.5 rounded-full bg-rose-200/70 text-rose-800 text-[10px] font-mono font-bold">Ditolak</span>
                    </div>
                `;
            }
        }

        // Modal Controls
        function openActionModal(type) {
            const modal = document.getElementById('quickActionModal');
            const title = document.getElementById('modalTitle');
            const icon = document.getElementById('modalIcon');
            
            if (type === 'inbound') {
                title.innerText = 'Input Penerimaan Barang Masuk (Inbound)';
                icon.innerText = 'add_box';
            } else if (type === 'outbound') {
                title.innerText = 'Buat Surat Jalan Pengiriman (Outbound)';
                icon.innerText = 'local_shipping';
            } else if (type === 'scanner') {
                title.innerText = 'Terminal Scanner Handheld Terpadu';
                icon.innerText = 'barcode_scanner';
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function triggerScannerModal() {
            openActionModal('scanner');
        }

        function closeModal() {
            const modal = document.getElementById('quickActionModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function confirmScanSimulated() {
            alert('Barcode terdeteksi: SKU-AST-FD-0012 (Beras Premium 5kg). Sistem siap melakukan alokasi rak.');
            closeModal();
        }

        function downloadReport() {
            alert('Mengunduh Berkas Laporan: REKAP_LOGISTIK_ASTRO_DC01_' + new Date().toISOString().slice(0,10) + '.xlsx');
        }

        function quickRefresh() {
            const icon = document.getElementById('refreshIcon');
            if (icon) icon.classList.add('animate-spin');
            setTimeout(() => {
                if (icon) icon.classList.remove('animate-spin');
                alert('Data operasional gudang berhasil disinkronkan secara realtime.');
            }, 600);
        }

        function applyTagSearch(query) {
            const input = document.getElementById('globalSearchInput');
            if (input) {
                input.value = query;
                input.focus();
            }
        }

        // Shortcut Cmd/Ctrl + K
        window.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                const input = document.getElementById('globalSearchInput');
                if (input) {
                    input.focus();
                    input.select();
                }
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
