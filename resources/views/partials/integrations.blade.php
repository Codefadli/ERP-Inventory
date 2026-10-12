<!-- 5. INTEGRATIONS SECTION -->
<section class="max-w-[1440px] mx-auto px-gutter py-space-xl">
    <div class="text-center max-w-3xl mx-auto mb-space-xl">
        <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-semibold mb-space-xs block">Konektivitas Tanpa Batas</span>
        <h2 class="font-headline-lg text-headline-lg text-on-surface tracking-tight mb-space-sm">
            Terhubung Mulus dengan Ekosistem Bisnis Anda
        </h2>
        <p class="font-body-md text-body-md text-on-surface-variant">
            Sinkronkan transaksi penjualan, keuangan, dan pengiriman kurir pihak ketiga secara otomatis tanpa perlu entri manual ganda.
        </p>
    </div>

    <!-- Integrations Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-space-md">
        @php
        $integrations = [
            ['abbr' => 'SAP', 'name' => 'SAP ERP', 'category' => 'Enterprise'],
            ['abbr' => 'ACC', 'name' => 'Accurate', 'category' => 'Akuntansi'],
            ['abbr' => 'JNL', 'name' => 'Jurnal', 'category' => 'Finansial'],
            ['abbr' => 'SPF', 'name' => 'Shopify', 'category' => 'E-Commerce'],
            ['abbr' => 'TKP', 'name' => 'Tokopedia', 'category' => 'Marketplace'],
            ['abbr' => 'TTS', 'name' => 'TikTok Shop', 'category' => 'Social Commerce'],
            ['abbr' => 'POS', 'name' => 'Kasir POS', 'category' => 'Toko Fisik'],
            ['abbr' => 'LOG', 'name' => 'Kurir Kilat', 'category' => 'Auto Resi']
        ];
        @endphp

        @foreach($integrations as $integration)
        <div class="bg-surface-container-lowest p-space-md rounded-2xl shadow-sm flex flex-col items-center justify-center text-center gap-2 hover:bg-surface-container-low transition-colors">
            <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-primary font-bold text-title-md">
                {{ $integration['abbr'] }}
            </div>
            <span class="font-title-md text-body-sm text-on-surface font-semibold">{{ $integration['name'] }}</span>
            <span class="font-label-sm text-[10px] text-outline">{{ $integration['category'] }}</span>
        </div>
        @endforeach
    </div>
</section>
