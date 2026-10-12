<!-- 3. KEY FEATURES / MODUL INVENTARIS -->
<section class="max-w-[1440px] mx-auto px-gutter py-space-xl">
    <div class="text-center max-w-3xl mx-auto mb-space-xl">
        <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-semibold mb-space-xs block">Modul Lengkap & Skalabel</span>
        <h2 class="font-headline-lg text-headline-lg text-on-surface tracking-tight mb-space-sm">
            Solusi Lengkap Mengatasi Kerumitan Stok
        </h2>
        <p class="font-body-lg text-body-lg text-on-surface-variant">
            Dari penerimaan barang awal hingga pengiriman pesanan multibox, rancangan arsitektur modular Asro menyesuaikan skala operasional Anda.
        </p>
    </div>

    <!-- Feature Grid (6 Cards) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
        @php
        $features = [
            [
                'icon' => 'warehouse',
                'title' => 'Pelacakan Multi-Gudang & Rak',
                'description' => 'Pantau perpindahan barang antar cabang, gudang penyangga regional, dan toko fisik secara instan dengan alokasi slot tingkat bin.'
            ],
            [
                'icon' => 'qr_code_scanner',
                'title' => 'Barcode & QR Code Scanner',
                'description' => 'Dukungan pemindaian cepat via smartphone dan scanner genggam industri Bluetooth untuk inbound, stock opname, dan cross-docking.'
            ],
            [
                'icon' => 'autorenew',
                'title' => 'Prediksi Restock Otomatis (AI)',
                'description' => 'Notifikasi stok menipis dan otomatisasi penerbitan Purchase Order kepada supplier sebelum persediaan mencapai level safety stock.'
            ],
            [
                'icon' => 'timelapse',
                'title' => 'Batch, Kadaluarsa & Serial',
                'description' => 'Lacak lot produksi manufaktur, peringatan dini tanggal kedaluwarsa barang FMCG/farmasi, dan penelusuran nomor serial elektronik unit per unit.'
            ],
            [
                'icon' => 'query_stats',
                'title' => 'Analitik Keuntungan & Valuasi',
                'description' => 'Analisis perputaran persediaan (turnover rate), identifikasi slow-moving SKU, valuasi FIFO/LIFO, serta margin keuntungan bersih secara real-time.'
            ],
            [
                'icon' => 'sync_alt',
                'title' => 'Sinkronisasi Omnichannel',
                'description' => 'Terhubung langsung ke Tokopedia, Shopee, TikTok Shop, WooCommerce, dan ERP. Kurangi risiko overselling lewat alokasi terpusat.'
            ]
        ];
        @endphp

        @foreach($features as $feature)
        <div class="group bg-surface-container-lowest p-space-lg rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1">
            <div class="w-12 h-12 rounded-xl bg-surface-container flex items-center justify-center text-primary mb-space-md group-hover:bg-primary group-hover:text-on-primary transition-colors">
                <span class="material-symbols-outlined text-[26px]">{{ $feature['icon'] }}</span>
            </div>
            <h3 class="font-headline-sm text-headline-sm text-on-surface mb-space-xs">{{ $feature['title'] }}</h3>
            <p class="font-body-md text-body-md text-on-surface-variant">
                {{ $feature['description'] }}
            </p>
        </div>
        @endforeach
    </div>
</section>
