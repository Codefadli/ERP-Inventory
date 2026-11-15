<!-- Header -->
<header class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="w-full px-4 lg:px-6 py-3 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-cube text-white text-lg"></i>
            </div>
            <div>
                <h1 class="text-base lg:text-lg font-bold text-gray-900">Astro Inventory</h1>
                <p class="text-xs text-gray-500">Sistem Inventaris Terpadu</p>
            </div>
            @if(auth()->user()->selectedHub)
            <div class="hidden lg:flex items-center gap-2 ml-4 bg-blue-50 text-blue-700 px-3 py-1.5 rounded-full text-xs font-medium">
                <i class="fas fa-building"></i>
                <span>{{ auth()->user()->selectedHub->name }}</span>
            </div>
            @endif
            <span class="hidden lg:inline-flex items-center gap-1 bg-green-100 text-green-700 px-2.5 py-1 rounded-full text-xs font-semibold">
                <i class="fas fa-circle text-[5px]"></i> Operasional Normal
            </span>
        </div>
        <div class="flex items-center gap-3">
            <button class="relative p-2.5 text-gray-600 hover:bg-gray-100 rounded-lg">
                <i class="fas fa-bell text-lg"></i>
                <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
            </button>
            <div class="flex items-center gap-2 pl-3 border-l border-gray-200">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->nama_lengkap }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->role->name }}</p>
                </div>
                <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 2)) }}
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="ml-2">
                @csrf
                <button type="submit" class="text-sm text-gray-600 hover:text-red-600 px-3 py-2 rounded-lg hover:bg-red-50">
                    <i class="fas fa-sign-out-alt mr-1"></i> Keluar
                </button>
            </form>
        </div>
    </div>
</header>
