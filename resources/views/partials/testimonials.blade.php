<!-- 6. CUSTOMER TESTIMONIALS & CASE STUDY -->
<section class="max-w-[1440px] mx-auto px-gutter py-space-xl">
    <div class="text-center max-w-3xl mx-auto mb-space-xl">
        <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-semibold mb-space-xs block">Kisah Sukses Pengguna</span>
        <h2 class="font-headline-lg text-headline-lg text-on-surface tracking-tight mb-space-sm">
            Dipercaya Pemimpin Industri Distribusi & Retail
        </h2>
        <p class="font-body-md text-body-md text-on-surface-variant">
            Lihat bagaimana Asro Inventory mengubah operasi gudang yang padat menjadi alur kerja yang tenang, efisien, dan presisi.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
        @php
        $testimonials = [
            [
                'quote' => '"Efisiensi waktu stock opname meningkat hingga 80%. Sebelumnya butuh 3 hari tutup toko, sekarang cukup hitungan jam menggunakan scanner genggam Asro."',
                'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCJ75gLtxN-SQhRkNxFXE7cEI_W3Z6etWvvWDZdTTau9fglUSlulGmEhUhN-PZyi6Kwr5o4rB4EuhypZLs3News1ucZeiwt23kjtsBJTA8fEjunaGtlzDJBTy74JFpTTbWK37F1K8YLOkpUgPw7Wb4qGRFXYw3PFeMXSdx7LTF6RGxlm7vwfMpnL5JsvrSdV8TV-GWj-JK9I8XD4feb2EwLwxghgmPxcHaFQrZDvi7KO_XTaHiZnsS9hQ',
                'name' => 'Bambang Hartono',
                'position' => 'Head of Logistics, SentraPack Retail'
            ],
            [
                'quote' => '"Sinkronisasi multichannel-nya luar biasa cepat. Risiko pembatalan order karena stok kosong di Shopee & Tokopedia sekarang 0%. Margin untung naik signifikan!"',
                'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBr-ZjVj9QC-pYVEjUPrDHv0cAyyefahz-D0Jx_0MWLEuJPpBB-Vdp2zoBMfUFSReIqorwlU4Abqx9f2naOQpXBbRkdN-Q6QuhGVHy2_UVU7c4oMycKD4GZN2Nvf7ThOIw56PSZ4qN1Zz82KS-h2tpRj4xY2jN9WNCGSV8RBrXKJS7yXLueVhjFe4XD9gFGz7x4gBMaLLwdhf6bKPRN-yQoWBgGnP2lf3Gk0TFTdpbHWyEdkZBPjliO4A',
                'name' => 'Citra Anggraini',
                'position' => 'COO, RetailNusantara Group'
            ],
            [
                'quote' => '"Sistem auto reorder prediksi AI-nya sangat akurat. Kami berhasil memangkas biaya modal tertahan pada stok berlebih (overstock) hingga 35% dalam semester pertama."',
                'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB1MCEBAae2IaYi4tlCo-kjJS47Bx9uWEGzwGE5z9WXJDZR5Kv5qCn7HISCM9OGw3WvxmWZ5LrZEwJDQDHSsc6UPOtWbUWmID6vBIrVY01POL99Uu0R2MnAslo_7GaXi9DnQJFy4QmqqPcBbuje-NhYHmw3TSbubwXUBiiC71Qk2SdmEvAC7ulohQuOhAAo_SqmAhPhhwoRmImWQ1fzu_sSwdXoaAzZ1Mqf25W3LzoRS7F9jKKd7BhfGA',
                'name' => 'Hendra Wibowo',
                'position' => 'VP Operation, LogisTek Solusi'
            ]
        ];
        @endphp

        @foreach($testimonials as $testimonial)
        <div class="bg-surface-container-lowest p-space-lg rounded-2xl shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-1 text-primary mb-space-md">
                    @for($i = 0; $i < 5; $i++)
                    <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">star</span>
                    @endfor
                </div>
                <p class="font-body-md text-body-md text-on-surface italic mb-space-lg">
                    {{ $testimonial['quote'] }}
                </p>
            </div>
            <div class="flex items-center gap-space-sm pt-space-sm">
                <img class="w-12 h-12 rounded-full object-cover" alt="{{ $testimonial['name'] }}" src="{{ $testimonial['avatar'] }}"/>
                <div>
                    <p class="font-title-md text-title-md text-on-surface font-semibold">{{ $testimonial['name'] }}</p>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">{{ $testimonial['position'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
