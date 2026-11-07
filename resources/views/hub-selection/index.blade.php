<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pemilihan Hub - ASTRO Inventory</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            background: linear-gradient(to bottom, #f9fafb 0%, #e5e7eb 100%);
            min-height: 100vh;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .card-selected {
            border: 3px solid #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-3">
                    <div class="bg-indigo-600 w-10 h-10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Astro Inventory</h1>
                        <p class="text-xs text-gray-500">SISTEM INVENTARIS TERPADU</p>
                    </div>
                </div>

                <!-- User Info -->
                <div class="flex items-center space-x-3">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">{{ $user->nama_lengkap }}</p>
                        <p class="text-xs text-gray-500">{{ $user->role->name }}</p>
                    </div>
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-semibold text-indigo-700">{{ strtoupper(substr($user->nama_lengkap, 0, 2)) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        
        <!-- Welcome Section -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Pilih Kota & Hub Operasional</h2>
            <p class="text-gray-600">Pilih lokasi kota dan hub operasional Anda untuk melanjutkan ke dashboard</p>
        </div>

        <!-- Alerts -->
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
        @endif

        @if(session('info'))
        <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
            <p class="text-sm text-blue-700">{{ session('info') }}</p>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
            <ul class="list-disc list-inside text-sm text-red-700">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Progress Stepper -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <!-- Step 1 -->
                <div class="flex items-center">
                    <div class="flex items-center space-x-3">
                        <div id="step1-circle" class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                            1
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-semibold text-gray-900">Pilih Kota</p>
                            <p id="step1-status" class="text-xs text-gray-500">Pilih kota operasional</p>
                        </div>
                    </div>
                </div>

                <!-- Connector -->
                <div class="w-24 h-1 bg-gray-300 mx-4"></div>

                <!-- Step 2 -->
                <div class="flex items-center">
                    <div class="flex items-center space-x-3">
                        <div id="step2-circle" class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-semibold">
                            2
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-semibold text-gray-900">Pilih Hub</p>
                            <p id="step2-status" class="text-xs text-gray-500">Pilih hub operasional</p>
                        </div>
                    </div>
                </div>

                <!-- Connector -->
                <div class="w-24 h-1 bg-gray-300 mx-4"></div>

                <!-- Step 3 -->
                <div class="flex items-center">
                    <div class="flex items-center space-x-3">
                        <div id="step3-circle" class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-semibold">
                            3
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-semibold text-gray-900">Masuk Dashboard</p>
                            <p id="step3-status" class="text-xs text-gray-500">Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form id="hubSelectionForm" method="POST" action="{{ route('hub.selection.store') }}">
            @csrf
            <input type="hidden" name="city_id" id="selectedCityId" value="">
            <input type="hidden" name="hub_id" id="selectedHubId" value="">

            <!-- Tahap 1: Pilih Kota -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tahap 1: Pilih Kota Operasional</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($cities as $city)
                    <div class="city-card card-hover bg-white rounded-lg border-2 border-gray-200 p-5 cursor-pointer" 
                         data-city-id="{{ $city->id }}"
                         onclick="selectCity({{ $city->id }}, '{{ $city->name }}')">
                        
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-1">
                                    <input type="radio" name="city_radio" value="{{ $city->id }}" class="w-4 h-4 text-blue-600">
                                    <h4 class="text-lg font-bold text-gray-900">{{ $city->name }}</h4>
                                </div>
                                <span class="inline-block px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded">
                                    Aktif
                                </span>
                            </div>
                        </div>

                        <div class="text-sm text-gray-600 space-y-1">
                            <p><span class="font-semibold">{{ $city->active_hubs_count }} Hub</span> Aktif</p>
                            <p class="text-xs"><span class="font-semibold">Region:</span> {{ $city->region }}</p>
                            <p class="text-xs"><span class="font-semibold">Wilayah:</span> {{ implode(', ', $city->areas ?? []) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Tahap 2: Pilih Hub -->
            <div id="hubSection" class="mb-8" style="display: none;">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Tahap 2: Daftar Hub di <span id="selectedCityName" class="text-blue-600"></span></h3>
                    <p class="text-sm text-gray-600">Menampilkan <span id="hubCount">0</span> Hub Terverifikasi</p>
                </div>

                <div id="hubsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Hubs will be loaded here dynamically -->
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                    ← Kembali ke Halaman Login
                </a>

                <div class="text-right">
                    <div id="selectedInfo" class="text-sm text-gray-600 mb-2" style="display: none;">
                        <span class="font-semibold">Terpilih:</span> 
                        <span id="infoCity">-</span> | <span id="infoHub">-</span>
                    </div>
                    <button type="submit" 
                            id="submitButton"
                            disabled
                            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition">
                        Lanjutkan ke Dashboard Operasional →
                    </button>
                </div>
            </div>
        </form>

        <!-- Logout Form (hidden) -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between text-sm text-gray-600">
                <p>© 2026 Astro Inventory. Sistem Manajemen Inventaris Terpadu.</p>
                <div class="flex items-center space-x-4">
                    <a href="#" class="hover:text-gray-900">Pusat Bantuan</a>
                    <a href="#" class="hover:text-gray-900">Panduan Pengguna</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        let selectedCityId = null;
        let selectedCityName = null;
        let selectedHubId = null;
        let selectedHubName = null;

        function selectCity(cityId, cityName) {
            selectedCityId = cityId;
            selectedCityName = cityName;
            
            // Update UI
            document.querySelectorAll('.city-card').forEach(card => {
                card.classList.remove('card-selected');
                card.querySelector('input[type="radio"]').checked = false;
            });
            
            const selectedCard = document.querySelector(`[data-city-id="${cityId}"]`);
            selectedCard.classList.add('card-selected');
            selectedCard.querySelector('input[type="radio"]').checked = true;
            
            // Update hidden input
            document.getElementById('selectedCityId').value = cityId;
            
            // Update stepper
            document.getElementById('step1-circle').innerHTML = '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>';
            document.getElementById('step1-circle').classList.remove('bg-blue-600');
            document.getElementById('step1-circle').classList.add('bg-green-500');
            document.getElementById('step1-status').textContent = cityName + ' - Terpilih';
            
            document.getElementById('step2-circle').classList.remove('bg-gray-300', 'text-gray-600');
            document.getElementById('step2-circle').classList.add('bg-blue-600', 'text-white');
            
            // Load hubs
            loadHubs(cityId, cityName);
        }

        function loadHubs(cityId, cityName) {
            document.getElementById('selectedCityName').textContent = cityName;
            document.getElementById('hubSection').style.display = 'block';
            
            // Fetch hubs
            fetch(`{{ route('hub.selection.hubs-by-city') }}?city_id=${cityId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayHubs(data.data);
                    }
                })
                .catch(error => {
                    console.error('Error loading hubs:', error);
                });
        }

        function displayHubs(hubs) {
            const container = document.getElementById('hubsContainer');
            document.getElementById('hubCount').textContent = hubs.length;
            
            container.innerHTML = hubs.map(hub => `
                <div class="hub-card card-hover bg-white rounded-lg border-2 border-gray-200 p-4 cursor-pointer" 
                     data-hub-id="${hub.id}"
                     onclick="selectHub(${hub.id}, '${hub.name}', '${hub.code}')">
                    
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <input type="radio" name="hub_radio" value="${hub.id}" class="w-4 h-4 text-blue-600">
                    </div>

                    <span class="inline-block px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded mb-2">
                        Aktif
                    </span>

                    <h4 class="font-bold text-gray-900 mb-1 text-sm">${hub.name}</h4>
                    <p class="text-xs text-blue-600 font-semibold mb-2">${hub.category}</p>
                    <p class="text-xs text-gray-600 mb-3 line-clamp-2">${hub.address}</p>

                    <div class="border-t border-gray-200 pt-3 space-y-2">
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-600">Kapasitas:</span>
                            <span class="font-semibold text-gray-900">${hub.capacity} Gudang</span>
                        </div>
                        <div class="space-y-1">
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-600">Okupansi:</span>
                                <span class="font-semibold text-blue-600">${hub.occupancy}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: ${hub.occupancy}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function selectHub(hubId, hubName, hubCode) {
            selectedHubId = hubId;
            selectedHubName = hubName;
            
            // Update UI
            document.querySelectorAll('.hub-card').forEach(card => {
                card.classList.remove('card-selected');
                card.querySelector('input[type="radio"]').checked = false;
            });
            
            const selectedCard = document.querySelector(`[data-hub-id="${hubId}"]`);
            selectedCard.classList.add('card-selected');
            selectedCard.querySelector('input[type="radio"]').checked = true;
            
            // Update hidden input
            document.getElementById('selectedHubId').value = hubId;
            
            // Update stepper
            document.getElementById('step2-circle').innerHTML = '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>';
            document.getElementById('step2-circle').classList.remove('bg-blue-600');
            document.getElementById('step2-circle').classList.add('bg-green-500');
            document.getElementById('step2-status').textContent = hubName + ' - Terpilih';
            
            document.getElementById('step3-circle').classList.remove('bg-gray-300', 'text-gray-600');
            document.getElementById('step3-circle').classList.add('bg-blue-600', 'text-white');
            
            // Update info & enable button
            document.getElementById('selectedInfo').style.display = 'block';
            document.getElementById('infoCity').textContent = selectedCityName;
            document.getElementById('infoHub').textContent = `${hubName} (${hubCode})`;
            document.getElementById('submitButton').disabled = false;
        }
    </script>
</body>
</html>
