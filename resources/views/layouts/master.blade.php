<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Master Data') - ERP Inventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased text-sm">

    <div class="flex h-screen overflow-hidden">
        <!-- SIDEBAR -->
        <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col flex-shrink-0 border-r border-slate-800">
            <!-- Brand -->
            <div class="h-14 flex items-center px-5 border-b border-slate-800 gap-2.5">
                <div class="w-7 h-7 rounded-md bg-blue-600 flex items-center justify-center text-white font-bold text-sm">
                    <i class="fa-solid fa-box text-xs"></i>
                </div>
                <span class="font-semibold text-white tracking-tight">ERP Inventory</span>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md text-xs font-medium text-slate-400 hover:text-white hover:bg-slate-800/60 transition">
                    <i class="fa-solid fa-chart-pie w-4 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <!-- MASTER DATA (Single item, no submenus) -->
                <a href="{{ route('master-data.barang') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-md text-xs font-semibold bg-blue-600 text-white">
                    <i class="fa-solid fa-database w-4 text-center"></i>
                    <span>Master Data</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md text-xs font-medium text-slate-400 hover:text-white hover:bg-slate-800/60 transition">
                    <i class="fa-solid fa-arrow-down w-4 text-center"></i>
                    <span>Barang Masuk</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md text-xs font-medium text-slate-400 hover:text-white hover:bg-slate-800/60 transition">
                    <i class="fa-solid fa-arrow-up w-4 text-center"></i>
                    <span>Barang Keluar</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md text-xs font-medium text-slate-400 hover:text-white hover:bg-slate-800/60 transition">
                    <i class="fa-solid fa-file-lines w-4 text-center"></i>
                    <span>Laporan</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md text-xs font-medium text-slate-400 hover:text-white hover:bg-slate-800/60 transition">
                    <i class="fa-solid fa-users w-4 text-center"></i>
                    <span>Pengguna</span>
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md text-xs font-medium text-slate-400 hover:text-white hover:bg-slate-800/60 transition">
                    <i class="fa-solid fa-gear w-4 text-center"></i>
                    <span>Pengaturan</span>
                </a>
            </nav>

            <!-- User Info Footer -->
            <div class="p-3 border-t border-slate-800 flex items-center justify-between text-xs">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-full bg-slate-700 flex items-center justify-center font-bold text-white text-[11px]">
                        BS
                    </div>
                    <div class="leading-tight">
                        <p class="font-medium text-slate-200">Budi Santoso</p>
                        <p class="text-[11px] text-slate-400">Admin Gudang</p>
                    </div>
                </div>
                <button class="text-slate-500 hover:text-slate-300" title="Keluar">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- TOP BAR -->
            <header class="h-14 bg-white border-b border-slate-200 px-6 flex items-center justify-between z-10 flex-shrink-0">
                <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                    <span>Admin</span>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-300"></i>
                    <span class="text-slate-800 font-semibold">Master Data</span>
                </div>

                <div class="flex items-center gap-3">
                    <div class="relative w-64">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" placeholder="Cari..."
                               class="w-full pl-8 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded-md text-xs focus:bg-white focus:outline-none focus:border-blue-500">
                    </div>
                    <button class="w-8 h-8 rounded-md border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50">
                        <i class="fa-regular fa-bell text-xs"></i>
                    </button>
                </div>
            </header>

            <!-- SUB-NAV: TABS DI ATAS KONTEN MASTER DATA -->
            <div class="bg-white border-b border-slate-200 px-6 flex items-center justify-between flex-shrink-0">
                <div class="flex space-x-1">
                    <a href="{{ route('master-data.barang') }}"
                       class="px-4 py-3 text-xs font-medium border-b-2 transition {{ $active_sub == 'barang' ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
                        Barang & SKU
                    </a>
                    <a href="{{ route('master-data.kategori') }}"
                       class="px-4 py-3 text-xs font-medium border-b-2 transition {{ $active_sub == 'kategori' ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
                        Kategori
                    </a>
                    <a href="{{ route('master-data.satuan') }}"
                       class="px-4 py-3 text-xs font-medium border-b-2 transition {{ $active_sub == 'satuan' ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
                        Satuan (UoM)
                    </a>
                    <a href="{{ route('master-data.lokasi') }}"
                       class="px-4 py-3 text-xs font-medium border-b-2 transition {{ $active_sub == 'lokasi' ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
                        Lokasi / Rak
                    </a>
                    <a href="{{ route('master-data.supplier') }}"
                       class="px-4 py-3 text-xs font-medium border-b-2 transition {{ $active_sub == 'supplier' ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
                        Supplier
                    </a>
                    <a href="{{ route('master-data.divisi') }}"
                       class="px-4 py-3 text-xs font-medium border-b-2 transition {{ $active_sub == 'divisi' ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
                        Divisi
                    </a>
                </div>
            </div>

            <!-- CONTENT -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Notification Toast -->
    <div x-data="{ show: false, msg: '' }"
         x-on:show-toast.window="msg = $event.detail; show = true; setTimeout(() => show = false, 2500)"
         x-cloak
         x-show="show"
         class="fixed bottom-5 right-5 bg-slate-900 text-white px-4 py-2.5 rounded-md shadow-lg flex items-center gap-2 z-50 text-xs">
        <i class="fa-solid fa-check text-emerald-400"></i>
        <span x-text="msg"></span>
    </div>

</body>
</html>
