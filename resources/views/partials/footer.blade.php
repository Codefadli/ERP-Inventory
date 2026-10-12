<footer class="w-full bg-surface-container-low">
    <div class="max-w-[1440px] mx-auto px-gutter pt-space-xl pb-space-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-gutter mb-space-xl">
            <!-- Brand Column -->
            <div class="lg:col-span-4 flex flex-col gap-space-md">
                <div class="flex items-center gap-space-sm">
                    <img alt="Logo Asro Inventory" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1Vu_O2bcJnBWtCIc_snB85_C8IuokD_Dd5whISHNO2x541BXVXGTkqBogqgC-tJ5of5to6z8dmQv0p9ojwDL_pWHHBEB1EWfgETZy0GYw1yo1PyZqz26PHpucja7H3fK28cZbxOZVw8uuiQZrQO112WfR_rKjqX72N-0ZRtUMdi8l2qdES3sn_J6ciDM20fiZDYQ5-wbFwq-u_rUOq8jmBQ6BNWdLfiTY29eYamcZGos3GG3sTKK9-Si4TN"/>
                    <span class="font-title-md text-title-md text-on-surface tracking-tight">Asro Inventory</span>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-sm">
                    Platform orkestrasi inventaris cerdas, pelacakan armada logistik multimodal, dan visibilitas gudang berbasis telemetry real-time untuk manufaktur dan distribusi skala enterprise.
                </p>
                <div class="flex items-center gap-space-sm text-on-surface-variant">
                    @foreach(['public', 'send', 'hub', 'terminal'] as $icon)
                    <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center hover:bg-surface-container-high transition-colors cursor-pointer">
                        <span class="material-symbols-outlined text-[18px]">{{ $icon }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Product Links -->
            <div class="lg:col-span-2">
                <h4 class="font-title-md text-title-md text-on-surface font-semibold mb-space-md">Produk</h4>
                <ul class="flex flex-col gap-space-sm text-on-surface-variant">
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">Fitur Unggulan</a></li>
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">Integrasi</a></li>
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">Mobile App</a></li>
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">Harga & Paket</a></li>
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">Perbandingan</a></li>
                </ul>
            </div>

            <!-- Solutions -->
            <div class="lg:col-span-2">
                <h4 class="font-title-md text-title-md text-on-surface font-semibold mb-space-md">Solusi</h4>
                <ul class="flex flex-col gap-space-sm text-on-surface-variant">
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">Retail & E-commerce</a></li>
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">Manufaktur</a></li>
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">Distribusi</a></li>
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">Farmasi & Healthcare</a></li>
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">F&B</a></li>
                </ul>
            </div>

            <!-- Resources -->
            <div class="lg:col-span-2">
                <h4 class="font-title-md text-title-md text-on-surface font-semibold mb-space-md">Sumber Daya</h4>
                <ul class="flex flex-col gap-space-sm text-on-surface-variant">
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">Blog</a></li>
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">Dokumentasi API</a></li>
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">Webinar</a></li>
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">Case Studies</a></li>
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">Pusat Bantuan</a></li>
                </ul>
            </div>

            <!-- Company -->
            <div class="lg:col-span-2">
                <h4 class="font-title-md text-title-md text-on-surface font-semibold mb-space-md">Perusahaan</h4>
                <ul class="flex flex-col gap-space-sm text-on-surface-variant">
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">Karir</a></li>
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">Partner</a></li>
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">Hubungi Kami</a></li>
                    <li><a href="#" class="font-body-md text-body-md hover:text-primary transition-colors">Media Kit</a></li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="pt-space-lg border-t border-outline-variant flex flex-col md:flex-row items-center justify-between gap-space-md">
            <p class="font-body-sm text-body-sm text-on-surface-variant">
                © {{ date('Y') }} Asro Inventory. Seluruh hak cipta dilindungi.
            </p>
            <div class="flex items-center gap-space-lg text-on-surface-variant">
                <a href="#" class="font-body-sm text-body-sm hover:text-primary transition-colors">Kebijakan Privasi</a>
                <a href="#" class="font-body-sm text-body-sm hover:text-primary transition-colors">Syarat Layanan</a>
                <a href="#" class="font-body-sm text-body-sm hover:text-primary transition-colors">Keamanan</a>
            </div>
        </div>
    </div>
</footer>
