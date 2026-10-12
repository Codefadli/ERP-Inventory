<!-- Interactive Modal for Demo Video Schedule -->
<div class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-on-surface/40 backdrop-blur-sm" id="video-modal">
    <div class="bg-surface-container-lowest rounded-2xl max-w-lg w-full p-space-lg shadow-xl relative animate-in fade-in zoom-in duration-200">
        <button 
            class="absolute top-4 right-4 text-on-surface-variant hover:text-on-surface" 
            onclick="document.getElementById('video-modal').classList.add('hidden')"
        >
            <span class="material-symbols-outlined text-[24px]">close</span>
        </button>

        <div class="flex items-center gap-space-sm mb-space-sm">
            <div class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[22px]">calendar_today</span>
            </div>
            <div>
                <h3 class="font-title-md text-title-md text-on-surface font-bold">Jadwalkan Live Demo Asro</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Pilih waktu 20 menit bersama konsultan logistik kami.</p>
            </div>
        </div>

        <form action="{{ route('demo.schedule') }}" method="POST" class="flex flex-col gap-space-sm my-space-md">
            @csrf
            
            <label class="font-label-sm text-label-sm text-outline">Nama Lengkap</label>
            <input 
                class="bg-surface-container-low px-space-sm py-2 rounded-lg font-body-md text-body-md focus:outline-none focus:ring-1 focus:ring-primary" 
                placeholder="cth. Anton Wijaya" 
                type="text"
                name="name"
                required
            />

            <label class="font-label-sm text-label-sm text-outline mt-1">Perusahaan & Jumlah Gudang</label>
            <input 
                class="bg-surface-container-low px-space-sm py-2 rounded-lg font-body-md text-body-md focus:outline-none focus:ring-1 focus:ring-primary" 
                placeholder="cth. PT Maju Bersama (3 Gudang)" 
                type="text"
                name="company"
                required
            />

            <label class="font-label-sm text-label-sm text-outline mt-1">Nomor WhatsApp</label>
            <input 
                class="bg-surface-container-low px-space-sm py-2 rounded-lg font-body-md text-body-md focus:outline-none focus:ring-1 focus:ring-primary" 
                placeholder="+62 812 3456 7890" 
                type="tel"
                name="phone"
                required
            />

            <button 
                type="submit"
                class="w-full bg-primary text-on-primary py-3 rounded-xl font-title-md text-title-md hover:bg-tertiary transition-colors mt-space-md"
            >
                Konfirmasi Jadwal Demo
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Simple micro-interaction for closing modal on escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('video-modal');
            if (modal) modal.classList.add('hidden');
        }
    });
</script>
@endpush
