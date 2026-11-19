<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengaturan - Astro Inventory</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --brand: #2563eb; --line: #e7ebf2; }
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; background: #f5f7fb; color: #172033; }
        .ai-card { background: #fff; border: 1px solid var(--line); border-radius: 16px; box-shadow: 0 1px 2px rgba(15,23,42,.05); }
        .ai-input {
            width: 100%; border: 1px solid #dbe2ec; border-radius: 10px; padding: 10px 13px;
            background: #fff; color: #243044; outline: none; font-size: 13px;
        }
        .ai-input:focus { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(37,99,235,.13); }
        .ai-input:disabled { background: #f8fafc; color: #64748b; cursor: not-allowed; }
        .ai-btn {
            display: inline-flex; align-items: center; gap: 8px; border-radius: 10px;
            padding: 10px 16px; font-size: 12.5px; font-weight: 700; transition: all .15s;
        }
        .ai-btn-primary { background: var(--brand); color: #fff; }
        .ai-btn-primary:hover { background: #1d4ed8; }
        .ai-btn-secondary { background: #fff; border: 1px solid #dbe2ec; color: #334155; }
        .ai-btn-secondary:hover { background: #f8fafc; }
        .ai-badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 9px; border-radius: 999px; font-size: 10.5px; font-weight: 700; }
        .setting-tab { border: 1px solid #dbe2ec; background: #fff; color: #475569; border-radius: 999px; padding: 8px 14px; font-size: 12px; font-weight: 700; }
        .setting-tab.active { background: var(--brand); border-color: var(--brand); color: #fff; }
        .group-panel { display: none; }
        .group-panel.active { display: block; }
        .switch { position: relative; display: inline-flex; height: 24px; width: 44px; flex: none; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .switch span { position: absolute; inset: 0; background: #cbd5e1; border-radius: 999px; transition: .2s; cursor: pointer; }
        .switch span::before { content: ''; position: absolute; height: 18px; width: 18px; left: 3px; top: 3px; background: white; border-radius: 999px; transition: .2s; }
        .switch input:checked + span { background: #16a34a; }
        .switch input:checked + span::before { transform: translateX(20px); }
        .switch input:disabled + span { opacity: .5; cursor: not-allowed; }
        .toast { position: fixed; right: 20px; bottom: 20px; z-index: 9999; background: #0f172a; color: #fff; padding: 12px 16px; border-radius: 12px; font-size: 13px; box-shadow: 0 12px 30px rgba(15,23,42,.25); }
        .toast.success { border-left: 4px solid #16a34a; }
        .toast.error { border-left: 4px solid #dc2626; }
        .modal-overlay { position: fixed; inset: 0; background: rgba(15,23,42,.45); display: none; align-items: center; justify-content: center; padding: 16px; z-index: 100; }
        .modal-overlay.open { display: flex; }
        .modal-box { background: #fff; border-radius: 16px; max-width: 620px; width: 100%; max-height: 80vh; overflow-y: auto; }
    </style>
</head>
<body>

@include('components.navbar')

<div class="flex min-h-screen">
    @include('components.sidebar')

    <main class="flex-1 p-4 lg:p-6 overflow-x-hidden">
        <nav class="flex items-center gap-1.5 text-[11px] tracking-[0.04em] uppercase mb-2">
            <span class="text-slate-400 font-semibold">PENGATURAN</span>
            <i class="fas fa-chevron-right text-[9px] text-slate-300"></i>
            <span class="text-blue-600 font-bold">{{ $user->role?->name ?? 'Pengguna' }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4 mb-5">
            <div>
                <h1 class="text-[25px] md:text-[29px] font-extrabold text-slate-900 leading-tight">Pengaturan Sistem</h1>
                <p class="text-[13px] text-slate-500 mt-1.5 max-w-3xl">
                    Konfigurasi yang tersimpan di database dan berlaku sesuai cakupan (global, hub, atau preferensi pengguna).
                    Field yang belum didukung teknis ditandai <span class="font-bold text-amber-600">Belum tersedia</span> dan tidak akan disimpan.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5 flex-none">
                <span class="ai-badge bg-blue-50 text-blue-700 border border-blue-100">
                    <i class="fas fa-warehouse"></i> {{ $hub->name ?? 'Hub belum dipilih' }}
                </span>
                <span class="ai-badge bg-purple-50 text-purple-700 border border-purple-100">
                    <i class="fas fa-user-shield"></i> {{ $user->role?->name }}
                </span>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 ai-card p-4 border-l-4 border-emerald-500 text-[13px] text-emerald-800 bg-emerald-50">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 ai-card p-4 border-l-4 border-red-500 text-[13px] text-red-800 bg-red-50">{{ session('error') }}</div>
        @endif
        @if(session('info'))
            <div class="mb-4 ai-card p-4 border-l-4 border-blue-500 text-[13px] text-blue-800 bg-blue-50">{{ session('info') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-4 ai-card p-4 border-l-4 border-red-500 bg-red-50">
                <div class="text-[13px] font-bold text-red-800 mb-1">Konfigurasi tidak dapat disimpan:</div>
                <ul class="list-disc pl-5 text-[12.5px] text-red-700 space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(!$hub)
            <div class="mb-4 ai-card p-4 border-l-4 border-amber-500 bg-amber-50 text-[12.5px] text-amber-800">
                <i class="fas fa-triangle-exclamation mr-1"></i>
                Anda belum memilih hub operasional. Konfigurasi ber-cakupan hub tidak dapat disimpan sampai hub dipilih.
                <a href="{{ route('hub.selection.show') }}" class="font-bold underline ml-1">Pilih hub sekarang</a>.
            </div>
        @endif

        {{-- Tab navigasi kelompok konfigurasi --}}
        <div class="flex flex-wrap gap-2 mb-4">
            @foreach($groups as $groupKey => $group)
                <button type="button" class="setting-tab {{ $loop->first ? 'active' : '' }}" data-tab="{{ $groupKey }}">
                    {{ $group['label'] }}
                </button>
            @endforeach
            <button type="button" id="btnLog" class="setting-tab !bg-slate-900 !text-white !border-slate-900">
                <i class="fas fa-clock-rotate-left mr-1"></i> Log Perubahan
            </button>
        </div>

        @foreach($groups as $groupKey => $group)
            <div class="group-panel {{ $loop->first ? 'active' : '' }}" data-panel="{{ $groupKey }}">
                <div class="ai-card p-4 lg:p-6 mb-5">
                    <div class="flex items-start justify-between gap-3 mb-5">
                        <div>
                            <h2 class="text-[16px] font-extrabold text-slate-900">{{ $group['label'] }}</h2>
                            <p class="text-[12px] text-slate-500 mt-0.5">Nilai disimpan ke database sesuai cakupan masing-masing field.</p>
                        </div>
                        <span class="ai-badge bg-slate-100 text-slate-600">
                            {{ count(array_filter($group['fields'], fn ($f) => $f['can_edit'] && $f['supported'])) }} dapat diubah
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($group['fields'] as $key => $field)
                            @php
                                $fieldName = 'settings[' . $key . ']';
                                $fieldId = 'setting_' . str_replace(['.', '[', ']'], ['__', '_', ''], $key);
                                $inputValue = old('settings.' . $key, $field['value']);
                                $disabled = !$field['can_edit'] || !$field['supported'];
                            @endphp

                            <div class="{{ $field['type'] === 'text' ? 'md:col-span-2' : '' }}">
                                <div class="flex items-center justify-between gap-2 mb-1.5">
                                    <label for="{{ $fieldId }}" class="text-[12px] font-bold text-slate-600">{{ $field['label'] }}</label>
                                    @if(!$field['supported'])
                                        <span class="ai-badge bg-amber-50 text-amber-700 border border-amber-100">Belum tersedia</span>
                                    @elseif(!$field['can_edit'])
                                        <span class="ai-badge bg-slate-100 text-slate-500">Hanya baca</span>
                                    @endif
                                </div>

                                @if(!$field['supported'])
                                    <input id="{{ $fieldId }}" class="ai-input" value="{{ is_bool($field['value']) ? ($field['value'] ? 'Aktif' : 'Nonaktif') : ($field['value'] ?? '-') }}" disabled>
                                @elseif($field['type'] === 'boolean')
                                    <div class="flex items-center gap-3 pt-1">
                                        <label class="switch">
                                            <input type="hidden" name="{{ $fieldName }}" value="0" @disabled($disabled)>
                                            <input id="{{ $fieldId }}" type="checkbox" name="{{ $fieldName }}" value="1"
                                                @checked((bool) $inputValue) @disabled($disabled)>
                                            <span></span>
                                        </label>
                                        <span class="text-[12px] text-slate-500">{{ $inputValue ? 'Aktif' : 'Nonaktif' }}</span>
                                    </div>
                                @elseif($field['type'] === 'select')
                                    <select id="{{ $fieldId }}" name="{{ $fieldName }}" class="ai-input" @disabled($disabled)>
                                        @foreach(($field['options'] ?? []) as $optionValue => $optionLabel)
                                            <option value="{{ $optionValue }}" @selected((string) $inputValue === (string) $optionValue)>{{ $optionLabel }}</option>
                                        @endforeach
                                    </select>
                                @elseif($field['type'] === 'secret')
                                    <input id="{{ $fieldId }}" type="password" name="{{ $fieldName }}" class="ai-input" value=""
                                        placeholder="{{ $field['value'] ? 'Tersimpan (kosongkan bila tidak diubah)' : 'Belum diatur' }}" autocomplete="new-password" @disabled($disabled)>
                                @elseif($field['type'] === 'text')
                                    <textarea id="{{ $fieldId }}" name="{{ $fieldName }}" rows="2" class="ai-input" @disabled($disabled)>{{ $inputValue }}</textarea>
                                @else
                                    <input id="{{ $fieldId }}" type="text" name="{{ $fieldName }}" class="ai-input" value="{{ $inputValue }}" @disabled($disabled)>
                                @endif

                                @if($field['type'] === 'secret' && $field['supported'])
                                    <p class="text-[11px] text-slate-400 mt-1">Nilai terenkripsi; tidak pernah dikirim utuh ke browser.</p>
                                @endif

                                @if(!empty($field['unsupported_reason']))
                                    <p class="text-[11px] text-amber-600 mt-1"><i class="fas fa-circle-info mr-1"></i>{{ $field['unsupported_reason'] }}</p>
                                @elseif(!empty($field['note']))
                                    <p class="text-[11px] text-slate-400 mt-1">{{ $field['note'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 ai-card p-4 mb-6">
            <p class="text-[11.5px] text-slate-500">
                <i class="fas fa-shield-halved text-slate-400 mr-1"></i>
                Setiap perubahan dicatat pada <span class="font-bold">audit_logs</span> beserta pengguna dan waktunya.
            </p>
            <div class="flex items-center gap-2">
                <form method="POST" action="{{ route($routePrefix . '.pengaturan.reset') }}" onsubmit="return confirm('Kembalikan seluruh konfigurasi yang dapat Anda ubah ke nilai default?')">
                    @csrf
                    <button type="submit" class="ai-btn ai-btn-secondary" @disabled(!$canEditAny)>
                        <i class="fas fa-rotate-left"></i> Reset ke Default
                    </button>
                </form>
                <form method="POST" action="{{ route($routePrefix . '.pengaturan.update') }}">
                    @csrf
                    <button type="submit" class="ai-btn ai-btn-primary" @disabled(!$canEditAny)>
                        <i class="fas fa-floppy-disk"></i> Simpan Konfigurasi
                    </button>
                </form>
            </div>
        </div>
    </main>
</div>

{{-- Modal log perubahan konfigurasi --}}
<div id="modalLog" class="modal-overlay">
    <div class="modal-box">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <div>
                <div class="text-[15px] font-extrabold text-slate-900">Log Perubahan Konfigurasi</div>
                <div class="text-[11.5px] text-slate-500">Bersumber dari tabel audit_logs</div>
            </div>
            <button type="button" id="btnCloseLog" class="w-9 h-9 rounded-xl hover:bg-slate-100 text-slate-500"><i class="fas fa-xmark"></i></button>
        </div>
        <div id="logContent" class="p-5 text-[12.5px] text-slate-500">Memuat riwayat...</div>
    </div>
</div>

<div id="toast-container"></div>

<script>
(function () {
    // Tab kelompok konfigurasi
    document.querySelectorAll('[data-tab]').forEach(function (button) {
        button.addEventListener('click', function () {
            var key = button.getAttribute('data-tab');
            document.querySelectorAll('.setting-tab[data-tab]').forEach(function (b) { b.classList.remove('active'); });
            document.querySelectorAll('.group-panel').forEach(function (p) {
                p.classList.toggle('active', p.getAttribute('data-panel') === key);
            });
            button.classList.add('active');
        });
    });

    // Status teks pada switch
    document.querySelectorAll('.switch input[type=checkbox]').forEach(function (input) {
        input.addEventListener('change', function () {
            var label = input.closest('.flex').querySelector('span.text-\\[12px\\]');
            if (label) label.textContent = input.checked ? 'Aktif' : 'Nonaktif';
        });
    });

    var logModal = document.getElementById('modalLog');
    function esc(value) {
        return String(value == null ? '' : value).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }
    document.getElementById('btnLog').addEventListener('click', function () {
        logModal.classList.add('open');
        fetch(@json(route($routePrefix . '.pengaturan.history')), { headers: { 'Accept': 'application/json' } })
            .then(function (response) { return response.json(); })
            .then(function (payload) {
                var box = document.getElementById('logContent');
                if (!payload.data || payload.data.length === 0) {
                    box.innerHTML = '<div class="text-center py-6"><i class="fas fa-clock-rotate-left text-2xl text-slate-300"></i><div class="mt-2 font-bold text-slate-600">Belum ada perubahan tercatat</div></div>';
                    return;
                }
                box.innerHTML = payload.data.map(function (item) {
                    return '<div class="border border-slate-100 rounded-xl p-3 mb-2">'
                        + '<div class="flex items-center justify-between gap-2"><div class="font-bold text-slate-800">' + esc(item.description || 'Perubahan konfigurasi') + '</div>'
                        + '<span class="text-[11px] text-slate-400">' + esc(item.created_at) + '</span></div>'
                        + '<div class="text-[11.5px] text-slate-500 mt-1">Oleh: ' + esc(item.actor) + '</div></div>';
                }).join('');
            })
            .catch(function () {
                document.getElementById('logContent').innerHTML = '<div class="text-red-600">Gagal memuat log perubahan.</div>';
            });
    });
    document.getElementById('btnCloseLog').addEventListener('click', function () { logModal.classList.remove('open'); });
    logModal.addEventListener('click', function (event) { if (event.target === logModal) logModal.classList.remove('open'); });
})();
</script>
</body>
</html>
