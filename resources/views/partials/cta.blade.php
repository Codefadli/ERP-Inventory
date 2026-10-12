<!-- 7. FINAL CTA BANNER -->
<section class="max-w-[1440px] mx-auto px-gutter pt-space-md pb-space-xl">
    <div class="bg-gradient-to-r from-surface-container-high via-surface-container-low to-primary-fixed/40 rounded-3xl p-space-lg lg:p-space-xl shadow-lg relative overflow-hidden">
        <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-primary-fixed-dim/30 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 max-w-3xl mx-auto text-center flex flex-col items-center">
            <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-semibold mb-space-xs block">
                Uji Coba 14 Hari Tanpa Kartu Kredit
            </span>
            <h2 class="font-headline-lg text-headline-lg text-on-surface tracking-tight mb-space-md text-balance">
                Siap Tingkatkan Efisiensi Gudang Anda Hari Ini?
            </h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant mb-space-lg max-w-xl text-balance">
                Bergabunglah dengan ribuan pelaku bisnis yang telah menghemat ratusan jam kerja dan menekan kerugian selisih inventaris.
            </p>

            <!-- Quick Signup Form -->
            <form action="{{ route('register') }}" method="POST" class="flex flex-col sm:flex-row items-center gap-space-xs w-full max-w-lg mb-space-md">
                @csrf
                <input 
                    class="w-full bg-surface-container-lowest px-space-md py-3.5 rounded-xl font-body-md text-body-md text-on-surface placeholder:text-on-surface-variant focus:outline-none focus:ring-2 focus:ring-primary shadow-sm" 
                    placeholder="Masukkan alamat email bisnis Anda" 
                    type="email"
                    name="email"
                    required
                />
                <button 
                    type="submit"
                    class="w-full sm:w-auto shrink-0 bg-primary text-on-primary px-space-lg py-3.5 rounded-xl font-title-md text-title-md hover:bg-tertiary transition-all shadow-md"
                >
                    Daftar Sekarang
                </button>
            </form>

            <div class="flex items-center gap-space-md text-on-surface-variant">
                <a class="inline-flex items-center gap-1 font-body-md text-body-md text-primary font-semibold hover:underline" href="{{ route('contact') }}">
                    <span class="material-symbols-outlined text-[18px]">support_agent</span>
                    <span>Konsultasi Gratis dengan Spesialis Solusi Asro</span>
                </a>
            </div>
        </div>
    </div>
</section>
