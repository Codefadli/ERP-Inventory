<!-- 4. INTERACTIVE PRODUCT HIGHLIGHT / WORKFLOW -->
<section class="max-w-[1440px] mx-auto px-gutter py-space-xl">
    <div class="bg-surface-container-low rounded-3xl p-space-lg lg:p-space-xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-xl items-center">
            <!-- Text & Steps Column -->
            <div class="lg:col-span-6 flex flex-col gap-space-lg">
                <div>
                    <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-semibold mb-space-xs block">Alur Kerja Otomatis</span>
                    <h2 class="font-headline-lg text-headline-lg text-on-surface tracking-tight mb-space-sm">
                        4 Tahap Presisi Operasional dari Inbound hingga Kirim
                    </h2>
                    <p class="font-body-md text-body-md text-on-surface-variant">
                        Eliminasi human error hingga 99% dengan pemindaian barcode tervalidasi di setiap stasiun kerja pergudangan.
                    </p>
                </div>

                <!-- Steps -->
                <div class="flex flex-col gap-space-md">
                    @php
                    $steps = [
                        [
                            'number' => 1,
                            'title' => 'Inbound & Penerimaan Cepat',
                            'description' => 'Pemindaian barcode PO langsung memvalidasi kuantitas item dan mencetak label batch otomatis.',
                            'highlight' => true
                        ],
                        [
                            'number' => 2,
                            'title' => 'Penyimpanan & Smart Putaway',
                            'description' => 'Sistem memetakan lokasi rak terdekat berdasarkan frekuensi pengambilan barang (fast-moving vs slow-moving).'
                        ],
                        [
                            'number' => 3,
                            'title' => 'Pemenuhan Pesanan (Wave Picking & Packing)',
                            'description' => 'Rute pemungutan barang paling hemat langkah dengan panduan visual layar scanner untuk mencegah salah kemas.'
                        ],
                        [
                            'number' => 4,
                            'title' => 'Pengiriman & Auto Stock Sync',
                            'description' => 'Manifest cetak thermal, nomor resi otomatis dibuat, dan stok terpotong bersamaan di seluruh marketplace.'
                        ]
                    ];
                    @endphp

                    @foreach($steps as $step)
                    <div class="flex items-start gap-space-md p-space-md rounded-xl bg-surface-container-lowest shadow-sm">
                        <div class="w-10 h-10 rounded-full {{ isset($step['highlight']) ? 'bg-primary-fixed text-primary' : 'bg-surface-container text-secondary' }} flex items-center justify-center font-title-md font-bold shrink-0">
                            {{ $step['number'] }}
                        </div>
                        <div>
                            <h4 class="font-title-md text-title-md text-on-surface">{{ $step['title'] }}</h4>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">{{ $step['description'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Visual Workflow Graphic / Photo Column -->
            <div class="lg:col-span-6 flex flex-col gap-space-md">
                <div class="bg-surface-container-lowest p-space-md rounded-2xl shadow-md">
                    <div class="flex items-center justify-between pb-space-sm mb-space-sm">
                        <div class="flex items-center gap-space-xs">
                            <span class="w-3 h-3 rounded-full bg-error"></span>
                            <span class="w-3 h-3 rounded-full bg-surface-dim"></span>
                            <span class="w-3 h-3 rounded-full bg-primary-fixed"></span>
                            <span class="font-label-sm text-label-sm text-outline ml-2">Console Putaway Real-Time</span>
                        </div>
                        <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-surface-container text-primary font-semibold">Online: 42 Scanner</span>
                    </div>

                    <!-- Warehouse Visual Context -->
                    <div class="relative rounded-xl overflow-hidden aspect-[4/3] bg-surface-dim mb-space-sm">
                        <img class="w-full h-full object-cover" alt="Modern high-tech distribution center warehouse aisle" src="https://lh3.googleusercontent.com/aida-public/AB6AXuABT97qP-LFHARjKTLwJnFj83NXGR8qwTNJGWNGX-ot8GWdSzd8bPRXSosAzcsS9M0_ZabNTlUU7BwxHKYjdovlYQwnB8GabxAuzUzGDw-wjiYeEEEe37-T6P5byx2MEBuWXvbw4V5wTFdLwWe_LH8_cra98pMW193c4_K60sMksECyzdv8QH0jpyvcUJk1DMVcMWgDg2z-xC8oTHEu36V6SrfaZiBF7xEQ0_UyMEN5iL7xoRkvSTYELg"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-on-surface/60 via-transparent to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4 text-on-primary">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-label-sm text-label-sm uppercase tracking-wide opacity-80">Gudang Utama Cikarang - Koridor B7</p>
                                    <p class="font-title-md text-title-md font-semibold">Tingkat Utilisasi Rak: 88.4%</p>
                                </div>
                                <div class="bg-surface-container-lowest/90 text-on-surface px-3 py-1.5 rounded-lg text-center backdrop-blur-sm">
                                    <span class="font-label-sm text-label-sm block text-outline">Kapasitas Sisa</span>
                                    <span class="font-title-md text-title-md font-bold text-primary">1.240 Palet</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Progress Spark -->
                    <div class="bg-surface-container-low p-space-sm rounded-xl flex items-center justify-between">
                        <div class="flex items-center gap-space-xs">
                            <span class="material-symbols-outlined text-primary text-[20px]">insights</span>
                            <span class="font-body-sm text-body-sm text-on-surface font-medium">Kecepatan Pick-to-Ship Hari Ini: <strong>14.2 mnt</strong></span>
                        </div>
                        <span class="font-label-sm text-label-sm text-primary font-bold">28% Lebih Cepat</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
