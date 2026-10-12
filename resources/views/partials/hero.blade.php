<!-- AMBIENT BACKGROUND GLOWS -->
<div class="relative w-full overflow-hidden">
    <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[980px] h-[480px] bg-gradient-to-b from-primary-fixed-dim/20 via-surface-container-high/40 to-transparent blur-3xl pointer-events-none -z-10"></div>
    <div class="absolute top-96 -left-32 w-80 h-80 bg-tertiary-fixed/30 rounded-full blur-2xl pointer-events-none -z-10"></div>
    <div class="absolute top-[800px] -right-24 w-96 h-96 bg-secondary-fixed/30 rounded-full blur-3xl pointer-events-none -z-10"></div>

    <!-- 1. HERO SECTION -->
    <section class="max-w-[1440px] mx-auto px-gutter pt-space-lg pb-space-xl">
        <div class="flex flex-col items-center text-center max-w-4xl mx-auto">
            <!-- Badge Chip -->
            <div class="inline-flex items-center gap-space-xs bg-surface-container-low px-space-md py-space-xs rounded-full shadow-sm mb-space-md animate-pulse">
                <span class="material-symbols-outlined text-[18px] text-primary" style="font-variation-settings: 'FILL' 1;">bolt</span>
                <span class="font-label-md text-label-md text-primary font-semibold tracking-wide">Platform Manajemen Inventaris Pintar No. 1 di Indonesia</span>
            </div>

            <!-- Headline -->
            <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight mb-space-md text-balance">
                Kendali Penuh Stok & Gudang Bisnis Anda dalam <span class="bg-gradient-to-r from-primary via-tertiary to-secondary bg-clip-text text-transparent">Satu Ekosistem Pintar</span>
            </h1>

            <!-- Subheading -->
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mb-space-lg text-balance">
                Asro Inventory mengotomasi pelacakan stok multi-gudang, pemindaian barcode real-time, prediksi restock berbasis AI, dan sinkronisasi omnichannel tanpa batas.
            </p>

            <!-- Dual CTA -->
            <div class="flex flex-col sm:flex-row items-center gap-space-md w-full sm:w-auto mb-space-xl">
                <a class="w-full sm:w-auto inline-flex items-center justify-center gap-space-xs bg-primary text-on-primary px-space-xl py-3.5 rounded-xl font-title-md text-title-md hover:bg-tertiary shadow-md transition-all hover:scale-[1.02]" href="{{ route('register') }}">
                    <span>Mulai Uji Coba Gratis</span>
                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                </a>
                <button class="w-full sm:w-auto inline-flex items-center justify-center gap-space-xs bg-surface-container-lowest text-on-surface px-space-lg py-3.5 rounded-xl font-title-md text-title-md hover:bg-surface-container-low shadow-sm transition-all" onclick="document.getElementById('video-modal').classList.remove('hidden')">
                    <span class="material-symbols-outlined text-primary text-[22px]" style="font-variation-settings: 'FILL' 1;">play_circle</span>
                    <span>Jadwalkan Demo Langsung</span>
                </button>
            </div>

            <!-- Trust Badges Bar -->
            <div class="flex flex-col items-center gap-space-sm pt-space-xs">
                <p class="font-label-sm text-label-sm uppercase tracking-wider text-outline font-semibold">
                    Dipercaya oleh 2.500+ bisnis retail, manufaktur, dan e-commerce di Asia Tenggara
                </p>
                <div class="flex flex-wrap items-center justify-center gap-space-md text-on-surface-variant opacity-85">
                    @foreach(['storefront' => 'TokoMaju', 'local_shipping' => 'LogisTek', 'factory' => 'IndoSumber', 'inventory_2' => 'SentraPack', 'hub' => 'RetailNusantara'] as $icon => $name)
                    <div class="flex items-center gap-1.5 px-space-sm py-1 rounded-lg bg-surface-container-low">
                        <span class="material-symbols-outlined text-primary text-[18px]">{{ $icon }}</span>
                        <span class="font-title-md text-body-md font-bold tracking-tight">{{ $name }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Hero Visual Showcase -->
        <div class="relative mt-space-xl max-w-5xl mx-auto">
            <!-- Main Workspace Preview Container -->
            <div class="relative bg-surface-container-lowest rounded-2xl shadow-xl overflow-hidden p-2 sm:p-4">
                <div class="relative aspect-[16/9] w-full rounded-xl overflow-hidden bg-surface-dim">
                    <img alt="Logistics Command Center Asro Inventory pada monitor desktop dengan barcode scanner genggam" class="w-full h-full object-cover object-center scale-[1.01] hover:scale-105 transition-transform duration-700 ease-out" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBiM-tJUog_P0gE9CjYlR6s-EVVEdUEAtb8AD5EHQF8Qj4M837N4TedJIhv3_4nkIHnjBXEktbI_rdRT-nckv9Aq0BLGZCaL0W4_Yuqka-bkzUdEX-1WuFzFQUDXphquRFey0h-yh5rwTOEu4tc2-oS1K3XTxEIriUe7oktX1FocRVKxLx1mHJqcHU9BqGGICm9ucGny1tisI-xHADlKTdhUIOHQNgzAyozSferZFf0s9WiYvNwjrkgYw"/>
                    <!-- Dark Gradient Vignette for UI clarity -->
                    <div class="absolute inset-0 bg-gradient-to-t from-inverse-surface/40 via-transparent to-transparent pointer-events-none"></div>
                </div>

                <!-- Floating Glassmorphism KPI Widget 1: Akurasi Stok -->
                <div class="absolute top-8 left-8 sm:left-10 bg-surface/90 backdrop-blur-md p-space-sm sm:p-space-md rounded-xl shadow-lg flex items-center gap-space-sm max-w-[240px] transform hover:-translate-y-1 transition-transform">
                    <div class="w-10 h-10 rounded-lg bg-primary-fixed flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined text-[22px]">verified</span>
                    </div>
                    <div class="min-w-0">
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline block">Akurasi Stok</span>
                        <div class="flex items-baseline gap-1">
                            <span class="font-data-metric text-title-md font-bold text-on-surface">99.8%</span>
                            <span class="font-label-sm text-label-sm text-primary font-semibold">+4.2%</span>
                        </div>
                    </div>
                </div>

                <!-- Floating Glassmorphism KPI Widget 2: Otomasi Restock -->
                <div class="hidden md:flex absolute top-12 right-10 bg-surface/90 backdrop-blur-md p-space-sm sm:p-space-md rounded-xl shadow-lg items-center gap-space-sm transform hover:-translate-y-1 transition-transform">
                    <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined text-[22px]">smart_toy</span>
                    </div>
                    <div class="min-w-0">
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline block">Otomasi Restock</span>
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-primary animate-ping"></span>
                            <span class="font-title-md text-title-md text-on-surface font-semibold">Aktif (18 SKU Dipesan)</span>
                        </div>
                    </div>
                </div>

                <!-- Floating Glassmorphism KPI Widget 3: Audit Efficiency -->
                <div class="absolute bottom-6 right-6 sm:bottom-8 sm:right-10 bg-surface/90 backdrop-blur-md p-space-sm sm:p-space-md rounded-xl shadow-lg flex items-center gap-space-sm transform hover:-translate-y-1 transition-transform">
                    <div class="w-10 h-10 rounded-lg bg-primary-fixed-dim flex items-center justify-center text-on-primary-fixed shrink-0">
                        <span class="material-symbols-outlined text-[22px]">schedule</span>
                    </div>
                    <div class="min-w-0">
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline block">Efisiensi Audit Opname</span>
                        <span class="font-title-md text-title-md text-on-surface font-bold">Hemat 70% Waktu</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
