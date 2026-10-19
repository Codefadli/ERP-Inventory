<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kepala Gudang - ASTRO</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-bold text-indigo-600">ASTRO</span>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('gudang.dashboard') }}" class="border-indigo-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Dashboard</a>
                        <a href="{{ route('gudang.products.index') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Barang</a>
                        <a href="{{ route('gudang.master.categories') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Master Data</a>
                        <a href="{{ route('reports.index') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">Laporan</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="text-sm text-gray-700 mr-4">{{ $user->nama_lengkap }}</span>
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full mr-4">{{ $user->role->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-700 hover:text-gray-900">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Dashboard Kepala Gudang</h1>
            
            @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
            @endif

            <!-- Stats -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-4 mb-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Total SKU</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">0</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Barang Masuk (Hari Ini)</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">0</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Barang Keluar (Hari Ini)</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-2">0</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Stok Menipis</h3>
                    <p class="text-2xl font-bold text-red-600 mt-2">0</p>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Selamat Datang, {{ $user->nama_lengkap }}!</h3>
                <p class="text-gray-600 mb-4">Anda memiliki 19 permission untuk mengelola gudang.</p>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <a href="{{ route('gudang.products.index') }}" class="block p-4 border rounded-lg hover:bg-gray-50">
                        <h4 class="font-medium">Kelola Barang</h4>
                        <p class="text-sm text-gray-600 mt-1">Tambah, edit, nonaktifkan barang</p>
                    </a>
                    <a href="{{ route('gudang.master.categories') }}" class="block p-4 border rounded-lg hover:bg-gray-50">
                        <h4 class="font-medium">Master Data</h4>
                        <p class="text-sm text-gray-600 mt-1">Kategori, lokasi, supplier</p>
                    </a>
                    <a href="{{ route('reports.index') }}" class="block p-4 border rounded-lg hover:bg-gray-50">
                        <h4 class="font-medium">Laporan</h4>
                        <p class="text-sm text-gray-600 mt-1">View & ekspor laporan</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
