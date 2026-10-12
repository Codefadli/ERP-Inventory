<!-- 2. STATS & IMPACT METRICS BANNER -->
<section class="max-w-[1440px] mx-auto px-gutter py-space-lg">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter">
        @php
        $stats = [
            [
                'label' => 'Volume SKU Harian',
                'icon' => 'layers',
                'value' => '15 Juta+',
                'description' => 'Item terlacak real-time per hari'
            ],
            [
                'label' => 'Tingkat Ketepatan',
                'icon' => 'check_circle',
                'value' => '99.8%',
                'description' => 'Akurasi data inventaris real-time'
            ],
            [
                'label' => 'Kepuasan Pengguna',
                'icon' => 'star',
                'value' => '4.8/5',
                'description' => 'Dari 2.500+ ulasan terverifikasi',
                'filled' => true
            ],
            [
                'label' => 'Waktu Onboarding',
                'icon' => 'speed',
                'value' => '< 30 Menit',
                'description' => 'Waktu implementasi awal & integrasi'
            ]
        ];
        @endphp

        @foreach($stats as $stat)
        <div class="bg-surface-container-lowest p-space-lg rounded-2xl shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-space-sm">
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline font-semibold">{{ $stat['label'] }}</span>
                <div class="w-8 h-8 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[20px]" @if(isset($stat['filled'])) style="font-variation-settings: 'FILL' 1;" @endif>{{ $stat['icon'] }}</span>
                </div>
            </div>
            <p class="font-data-metric text-data-metric text-on-surface mb-1">{{ $stat['value'] }}</p>
            <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $stat['description'] }}</p>
        </div>
        @endforeach
    </div>
</section>
