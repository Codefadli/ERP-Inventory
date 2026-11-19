<!-- Sidebar -->
<aside class="w-64 bg-white border-r border-gray-200 hidden lg:block overflow-y-auto">
    <nav class="p-3">
        <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2">Menu Utama</p>
        <a href="{{ route(auth()->user()->isSuperAdmin() ? 'admin.dashboard' : (auth()->user()->isKepalaGudang() ? 'kepalagudang.dashboard' : (auth()->user()->isHR() ? 'hr.dashboard' : (auth()->user()->isPegawai() ? 'pegawai.dashboard' : 'audit.dashboard')))) }}" class="nav-link {{ (request()->routeIs('dashboard') || request()->routeIs('*.dashboard')) ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-1">
            <i class="fas fa-th-large w-4"></i>
            <span>Dashboard</span>
        </a>

        @if(auth()->user()->isSuperAdmin())
        <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Manajemen Sistem</p>
        <a href="{{ route('admin.pengguna') }}" class="nav-link {{ request()->routeIs('admin.pengguna') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-users w-4"></i>
            <span>Manajemen Pengguna</span>
        </a>
        <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-user-shield w-4"></i>
            <span>Role & Permission</span>
        </a>
        <a href="{{ route('admin.log-aktivitas') }}" class="nav-link {{ request()->routeIs('admin.log-aktivitas') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-file-alt w-4"></i>
            <span>Log Aktivitas</span>
        </a>

        <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Master Data</p>
        <a href="{{ route('admin.data-barang') }}" class="nav-link {{ request()->routeIs('admin.data-barang') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-boxes w-4"></i>
            <span>Data Barang</span>
        </a>
        <a href="{{ route('admin.data-gudang-lokasi') }}" class="nav-link {{ request()->routeIs('admin.data-gudang-lokasi') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-warehouse w-4"></i>
            <span>Data Gudang &amp; Lokasi</span>
        </a>
        <a href="{{ route('admin.data-departemen') }}" class="nav-link {{ request()->routeIs('admin.data-departemen') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-building w-4"></i>
            <span>Data Departemen</span>
        </a>
        <a href="{{ route('admin.data-supplier') }}" class="nav-link {{ request()->routeIs('admin.data-supplier') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-truck w-4"></i>
            <span>Data Supplier</span>
        </a>
        <a href="{{ route('admin.kategori-barang') }}" class="nav-link {{ request()->routeIs('admin.kategori-barang') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-tags w-4"></i>
            <span>Kategori Barang</span>
        </a>

        <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Operasional</p>
        <a href="{{ route(auth()->user()->isSuperAdmin() ? 'admin.barang-masuk' : (auth()->user()->isKepalaGudang() ? 'kepalagudang.barang-masuk' : (auth()->user()->isHR() ? 'hr.barang-masuk' : (auth()->user()->isPegawai() ? 'pegawai.barang-masuk' : 'audit.barang-masuk')))) }}" class="nav-link {{ request()->routeIs('*.barang-masuk') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-arrow-down w-4"></i>
            <span>Barang Masuk</span>
        </a>
        <a href="{{ route(auth()->user()->isSuperAdmin() ? 'admin.barang-keluar' : (auth()->user()->isKepalaGudang() ? 'kepalagudang.barang-keluar' : (auth()->user()->isHR() ? 'hr.barang-keluar' : (auth()->user()->isPegawai() ? 'pegawai.barang-keluar' : 'audit.barang-keluar')))) }}" class="nav-link {{ request()->routeIs('*.barang-keluar') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-arrow-up w-4"></i>
            <span>Barang Keluar</span>
        </a>
        <a href="{{ route('admin.mutasi-barang') }}" class="nav-link {{ request()->routeIs('admin.mutasi-barang') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-exchange-alt w-4"></i>
            <span>Mutasi Barang</span>
        </a>
        <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-clipboard-check w-4"></i>
            <span>Stok Opname</span>
        </a>

        <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Laporan & Analitik</p>
        <a href="{{ route('admin.laporan-analitik') }}" class="nav-link {{ request()->routeIs('admin.laporan-analitik') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-chart-bar w-4"></i>
            <span>Laporan & Analitik</span>
        </a>
        <a href="{{ route('admin.laporan-riwayat') }}" class="nav-link {{ request()->routeIs('admin.laporan-riwayat') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-history w-4"></i>
            <span>Laporan & Riwayat</span>
        </a>

        <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Persetujuan</p>
        <a href="{{ route('admin.persetujuan-barang') }}" class="nav-link {{ request()->routeIs('admin.persetujuan-barang') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-file-contract w-4"></i>
            <span>Persetujuan Barang</span>
        </a>
        @endif

        @if(auth()->user()->isKepalaGudang())
        <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Master Data & Inventaris</p>
        <a href="{{ route('kepalagudang.data-barang') }}" class="nav-link {{ request()->routeIs('kepalagudang.data-barang') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-boxes w-4"></i>
            <span>Data Barang</span>
        </a>
        <a href="{{ route('kepalagudang.data-gudang-lokasi') }}"
            class="nav-link {{ request()->routeIs('kepalagudang.data-gudang-lokasi') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-warehouse w-4"></i>
            <span>Data Gudang & Lokasi</span>
        </a>

        <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Operasional & Transaksi</p>
        <a href="{{ route('kepalagudang.barang-masuk') }}" class="nav-link {{ request()->routeIs('kepalagudang.barang-masuk') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-truck-loading w-4"></i>
            <span>Barang Masuk</span>
        </a>
        <a href="{{ route('kepalagudang.barang-keluar') }}" class="nav-link {{ request()->routeIs('kepalagudang.barang-keluar') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-truck w-4"></i>
            <span>Barang Keluar</span>
        </a>
        <a href="{{ route('kepalagudang.mutasi-barang') }}" class="nav-link {{ request()->routeIs('kepalagudang.mutasi-barang') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-exchange-alt w-4"></i>
            <span>Mutasi Barang</span>
        </a>
        <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-clipboard-check w-4"></i>
            <span>Stok Opname</span>
        </a>
        <a href="{{ route('kepalagudang.persetujuan-barang') }}"
            class="nav-link {{ request()->routeIs('kepalagudang.persetujuan-barang') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-clipboard-check w-4"></i>
            <span>Persetujuan Barang</span>
        </a>
        <a href="{{ route('kepalagudang.laporan') }}" class="nav-link {{ request()->routeIs('kepalagudang.laporan') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-chart-bar w-4"></i>
            <span>Laporan & Analitik</span>
        </a>
        @endif

        @if(auth()->user()->isHR())
        <!-- HR Menu -->
        <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Operasional & Persetujuan</p>
        <a href="{{ route('hr.persetujuan-barang') }}" class="nav-link {{ request()->routeIs('hr.persetujuan-barang') ? 'active' : '' }} flex items-center justify-between gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <div class="flex items-center gap-3">
                <i class="fas fa-clock w-4"></i>
                <span>Antrean Persetujuan</span>
            </div>
            <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">5</span>
        </a>
        <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-file-alt w-4"></i>
            <span>Detail Permintaan</span>
        </a>
        <a href="{{ route('hr.riwayat-persetujuan') }}" class="nav-link {{ request()->routeIs('hr.riwayat-persetujuan') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-history w-4"></i>
            <span>Riwayat Persetujuan</span>
        </a>

        <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Manajemen & Laporan</p>
        <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-chart-line w-4"></i>
            <span>Laporan Inventaris</span>
        </a>
        <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-shield-alt w-4"></i>
            <span>Log Audit & Otorisasi</span>
        </a>
        @endif

        @if(auth()->user()->isPegawai())
        <!-- Pegawai Menu -->
        <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Operasional Gudang</p>
        <a href="{{ route(auth()->user()->isSuperAdmin() ? 'admin.barang-masuk' : (auth()->user()->isKepalaGudang() ? 'kepalagudang.barang-masuk' : (auth()->user()->isHR() ? 'hr.barang-masuk' : (auth()->user()->isPegawai() ? 'pegawai.barang-masuk' : 'audit.barang-masuk')))) }}" class="nav-link {{ request()->routeIs('*.barang-masuk') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-arrow-down w-4"></i>
            <span>Barang Masuk</span>
        </a>
        <a href="{{ route(auth()->user()->isSuperAdmin() ? 'admin.barang-keluar' : (auth()->user()->isKepalaGudang() ? 'kepalagudang.barang-keluar' : (auth()->user()->isHR() ? 'hr.barang-keluar' : (auth()->user()->isPegawai() ? 'pegawai.barang-keluar' : 'audit.barang-keluar')))) }}" class="nav-link {{ request()->routeIs('*.barang-keluar') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-arrow-up w-4"></i>
            <span>Barang Keluar</span>
        </a>
        <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-clipboard-check w-4"></i>
            <span>Stok Opname</span>
        </a>

        <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Monitoring & Laporan</p>
        <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-history w-4"></i>
            <span>Riwayat Transaksi</span>
        </a>
        <a href="#" class="nav-link flex items-center justify-between gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <div class="flex items-center gap-3">
                <i class="fas fa-tasks w-4"></i>
                <span>Status Permintaan</span>
            </div>
            <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">2</span>
        </a>
        @endif

        @if(auth()->user()->isAuditor())
        <!-- Auditor Menu -->
        <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Audit & Pemeriksaan</p>
        <a href="{{ route(auth()->user()->isSuperAdmin() ? 'admin.barang-masuk' : (auth()->user()->isKepalaGudang() ? 'kepalagudang.barang-masuk' : (auth()->user()->isHR() ? 'hr.barang-masuk' : (auth()->user()->isPegawai() ? 'pegawai.barang-masuk' : 'audit.barang-masuk')))) }}" class="nav-link {{ request()->routeIs('*.barang-masuk') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-arrow-down w-4"></i>
            <span>Barang Masuk</span>
        </a>
        <a href="{{ route(auth()->user()->isSuperAdmin() ? 'admin.barang-keluar' : (auth()->user()->isKepalaGudang() ? 'kepalagudang.barang-keluar' : (auth()->user()->isHR() ? 'hr.barang-keluar' : (auth()->user()->isPegawai() ? 'pegawai.barang-keluar' : 'audit.barang-keluar')))) }}" class="nav-link {{ request()->routeIs('*.barang-keluar') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-arrow-up w-4"></i>
            <span>Barang Keluar</span>
        </a>
        <a href="{{ route('audit.mutasi-barang') }}" class="nav-link {{ request()->routeIs('audit.mutasi-barang') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-exchange-alt w-4"></i>
            <span>Mutasi Barang</span>
        </a>
        <a href="{{ route('audit.data-barang') }}" class="nav-link {{ request()->routeIs('audit.data-barang') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-boxes w-4"></i>
            <span>Data Barang</span>
        </a>
        <a href="{{ route('audit.data-gudang-lokasi') }}" class="nav-link {{ request()->routeIs('audit.data-gudang-lokasi') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-warehouse w-4"></i>
            <span>Data Gudang & Lokasi</span>
        </a>
        <a href="#" class="nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-clipboard-check w-4"></i>
            <span>Stok Opname</span>
        </a>
        <a href="{{ route('audit.temuan-audit') }}" class="nav-link {{ request()->routeIs('audit.temuan-audit') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-exclamation-triangle w-4"></i>
            <span>Temuan Audit</span>
        </a>
        @endif

        <!-- Common Menu for All Roles -->
        <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-2 mt-4">Pengaturan & Akun</p>
        <a href="{{ route(auth()->user()->isSuperAdmin() ? 'admin.notifikasi' : (auth()->user()->isKepalaGudang() ? 'kepalagudang.notifikasi' : (auth()->user()->isHR() ? 'hr.notifikasi' : (auth()->user()->isPegawai() ? 'pegawai.notifikasi' : 'audit.notifikasi')))) }}" class="nav-link {{ request()->routeIs('*.notifikasi') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-bell w-4"></i>
            <span>Notifikasi</span>
        </a>
        <a href="{{ route(auth()->user()->isSuperAdmin() ? 'admin.pengaturan' : (auth()->user()->isKepalaGudang() ? 'kepalagudang.pengaturan' : (auth()->user()->isHR() ? 'hr.pengaturan' : (auth()->user()->isPegawai() ? 'pegawai.pengaturan' : 'audit.pengaturan')))) }}" class="nav-link {{ request()->routeIs('*.pengaturan') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-cog w-4"></i>
            <span>Pengaturan</span>
        </a>
        <a href="{{ route(auth()->user()->isSuperAdmin() ? 'admin.profile' : (auth()->user()->isKepalaGudang() ? 'kepalagudang.profile' : (auth()->user()->isHR() ? 'hr.profile' : (auth()->user()->isPegawai() ? 'pegawai.profile' : 'audit.profile')))) }}" class="nav-link {{ request()->routeIs('*.profile') ? 'active' : '' }} flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 mb-1">
            <i class="fas fa-user w-4"></i>
            <span>Profil Saya</span>
        </a>
    </nav>

    <!-- Sidebar Footer Info (for Pegawai & Kepala Gudang) -->
    @if(auth()->user()->isPegawai() || auth()->user()->isKepalaGudang())
    <div class="m-3 p-3 bg-blue-50 border border-blue-100 rounded-lg">
        <p class="text-[11px] font-bold text-blue-700 mb-1">
            <i class="fas fa-headset mr-1"></i>Bantuan {{ auth()->user()->selectedHub ? auth()->user()->selectedHub->name : 'DC-01' }}
        </p>
        <p class="text-[10px] text-blue-700/70 mb-2">Hotline Logistik & Tim WMS aktif 24/7.</p>
        <button class="w-full text-[11px] py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
            Hubungi
        </button>
    </div>
    @endif
</aside>
