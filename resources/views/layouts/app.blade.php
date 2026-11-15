<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ASTRO INVENTORY')</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Styles -->
    @yield('styles')
</head>
<body class="bg-gray-50">
    @yield('content')

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <!-- Column 1: Logo & Status -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-blue-600 rounded flex items-center justify-center">
                            <i class="fas fa-cube text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-white font-bold">ASTRO INVENTORY</h3>
                        </div>
                    </div>
                    <p class="text-sm mb-4">Sistem Manajemen Pergudangan & Kontrol Stok Multi-Hub Terintegrasi</p>
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full pulse-animation"></div>
                        <span class="text-sm text-green-400 font-semibold">Jakarta DC-01 Online</span>
                    </div>
                </div>

                <!-- Column 2: Akses & Portal -->
                <div>
                    <h4 class="text-white font-bold mb-4">AKSES & PORTAL</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('login') }}" class="hover:text-blue-400 transition-colors">Portal Login SSO Pegawai</a></li>
                        <li><a href="#status-server" class="hover:text-blue-400 transition-colors">Matriks 5 Role Akses</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Permohonan Kredensial Baru</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Reset Otentikasi 2FA</a></li>
                    </ul>
                </div>

                <!-- Column 3: Kepatuhan & SOP -->
                <div>
                    <h4 class="text-white font-bold mb-4">KEPATUHAN & SOP</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Manual Mutasi Antar-DC v2.4</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Prosedur Write-Off Barang Rusak</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Checklist Pemisahan Tugas (SOD)</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">Laporan Audit Ketercapaian Sistem</a></li>
                    </ul>
                </div>

                <!-- Column 4: Dukungan Teknis -->
                <div>
                    <h4 class="text-white font-bold mb-4">DUKUNGAN TEKNIS</h4>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-envelope text-blue-400"></i>
                            <span>helpdesk-wms@astro-internal.id</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-phone text-blue-400"></i>
                            <span>Ext: 104 (Pusat Kendali IT)</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-clock text-blue-400"></i>
                            <span>Jam Layanan: 24/7 Siaga Logistik</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center">
                <p class="text-sm">&copy; {{ date('Y') }} ASTRO INVENTORY. All rights reserved. Built with security & compliance in mind.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @yield('scripts')
</body>
</html>
