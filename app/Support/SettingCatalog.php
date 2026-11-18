<?php

namespace App\Support;

/**
 * Katalog konfigurasi yang benar-benar didukung aplikasi.
 *
 * Setiap definisi menentukan:
 * - grup/tab UI
 * - tipe & validasi nilai
 * - scope penyimpanan (global / hub / user)
 * - role yang boleh melihat dan mengubah
 * - status dukungan teknis (supported)
 *
 * Field dengan supported=false tetap ditampilkan pada UI sebagai
 * "belum tersedia" dan TIDAK pernah disimpan.
 */
class SettingCatalog
{
    public const GROUPS = [
        'umum' => 'Umum & Profil Hub',
        'preferensi' => 'Preferensi Pengguna',
        'stok' => 'Aturan Inventaris & Stok',
        'printer' => 'Perangkat & Printer Barcode',
        'erp' => 'Integrasi ERP & API',
        'keamanan' => 'Keamanan & Kebijakan Sesi',
        'backup' => 'Backup & Pemulihan',
    ];

    private const ALL_ROLES = ['super_admin', 'kepala_gudang', 'hr', 'pegawai', 'audit'];

    /**
     * Role yang dapat mengubah konfigurasi operasional hub.
     */
    private const HUB_EDITORS = ['super_admin', 'kepala_gudang'];

    public static function definitions(): array
    {
        return [
            // ---------------------------------------------------------
            // 1. UMUM & PROFIL HUB
            // ---------------------------------------------------------
            'general.system_name' => [
                'group' => 'umum',
                'label' => 'Nama Sistem',
                'type' => 'string',
                'scope' => 'global',
                'default' => 'ASTRO Inventory',
                'edit' => ['super_admin'],
                'validation' => ['required', 'string', 'max:120'],
            ],
            'general.system_tagline' => [
                'group' => 'umum',
                'label' => 'Tagline Sistem',
                'type' => 'string',
                'scope' => 'global',
                'default' => 'Sistem Manajemen Pergudangan & Kontrol Stok Multi-Hub',
                'edit' => ['super_admin'],
                'validation' => ['required', 'string', 'max:180'],
            ],
            'general.timezone' => [
                'group' => 'umum',
                'label' => 'Zona Waktu Sistem',
                'type' => 'select',
                'scope' => 'global',
                'default' => 'Asia/Jakarta',
                'options' => [
                    'Asia/Jakarta' => 'Asia/Jakarta (WIB - UTC+07:00)',
                    'Asia/Makassar' => 'Asia/Makassar (WITA - UTC+08:00)',
                    'Asia/Jayapura' => 'Asia/Jayapura (WIT - UTC+09:00)',
                ],
                'edit' => ['super_admin'],
                'validation' => ['required', 'in:Asia/Jakarta,Asia/Makassar,Asia/Jayapura'],
            ],
            'hub.name' => [
                'group' => 'umum',
                'label' => 'Nama Hub Distribusi',
                'type' => 'string',
                'scope' => 'hub',
                'default' => null,
                'fallback_attribute' => 'name',
                'edit' => self::HUB_EDITORS,
                'validation' => ['required', 'string', 'max:200'],
            ],
            'hub.code' => [
                'group' => 'umum',
                'label' => 'Kode Fasilitas (DC Code)',
                'type' => 'string',
                'scope' => 'hub',
                'default' => null,
                'fallback_attribute' => 'code',
                'edit' => self::HUB_EDITORS,
                'validation' => ['required', 'string', 'max:50'],
            ],
            'hub.address' => [
                'group' => 'umum',
                'label' => 'Alamat Fisik Gudang',
                'type' => 'text',
                'scope' => 'hub',
                'default' => null,
                'fallback_attribute' => 'address',
                'edit' => self::HUB_EDITORS,
                'validation' => ['required', 'string', 'max:500'],
            ],
            'hub.dispatcher_email' => [
                'group' => 'umum',
                'label' => 'Email Dispatcher Operasional',
                'type' => 'string',
                'scope' => 'hub',
                'default' => null,
                'edit' => self::HUB_EDITORS,
                'validation' => ['nullable', 'email', 'max:191'],
            ],
            'hub.hotline' => [
                'group' => 'umum',
                'label' => 'Hotline Dispatch & PIC',
                'type' => 'string',
                'scope' => 'hub',
                'default' => null,
                'edit' => self::HUB_EDITORS,
                'validation' => ['nullable', 'string', 'max:60'],
            ],
            'hub.staging_capacity' => [
                'group' => 'umum',
                'label' => 'Kapasitas Staging & Bay',
                'type' => 'string',
                'scope' => 'hub',
                'default' => null,
                'edit' => self::HUB_EDITORS,
                'validation' => ['nullable', 'string', 'max:120'],
            ],

            // ---------------------------------------------------------
            // 2. PREFERENSI PENGGUNA (semua role)
            // ---------------------------------------------------------
            'preferences.language' => [
                'group' => 'preferensi',
                'label' => 'Bahasa Antarmuka',
                'type' => 'select',
                'scope' => 'user',
                'default' => 'id',
                'options' => ['id' => 'Bahasa Indonesia', 'en' => 'English'],
                'edit' => self::ALL_ROLES,
                'validation' => ['required', 'in:id,en'],
            ],
            'preferences.notify_email' => [
                'group' => 'preferensi',
                'label' => 'Notifikasi Email',
                'type' => 'boolean',
                'scope' => 'user',
                'default' => true,
                'edit' => self::ALL_ROLES,
                'validation' => ['required', 'boolean'],
                'note' => 'Preferensi tersimpan. Pengiriman email bergantung pada konfigurasi SMTP server.',
            ],
            'preferences.notify_whatsapp' => [
                'group' => 'preferensi',
                'label' => 'Notifikasi WhatsApp',
                'type' => 'boolean',
                'scope' => 'user',
                'default' => false,
                'edit' => self::ALL_ROLES,
                'validation' => ['required', 'boolean'],
                'note' => 'Gateway WhatsApp belum dikonfigurasi sehingga notifikasi belum dikirim.',
            ],
            'preferences.dashboard_compact' => [
                'group' => 'preferensi',
                'label' => 'Tampilan Dashboard Padat',
                'type' => 'boolean',
                'scope' => 'user',
                'default' => false,
                'edit' => self::ALL_ROLES,
                'validation' => ['required', 'boolean'],
            ],

            // ---------------------------------------------------------
            // 3. ATURAN INVENTARIS & STOK
            // ---------------------------------------------------------
            'stock.reorder_method' => [
                'group' => 'stok',
                'label' => 'Perhitungan ROP Default',
                'type' => 'select',
                'scope' => 'hub',
                'default' => 'formula',
                'options' => [
                    'formula' => '(Rata-rata Harian × Lead Time) + Safety Stock',
                    'min_max' => 'Min-Max Manual per SKU',
                    'consumption_30d' => 'Konsumsi 30 Hari Terakhir',
                ],
                'edit' => self::HUB_EDITORS,
                'validation' => ['required', 'in:formula,min_max,consumption_30d'],
            ],
            'stock.lead_time_days' => [
                'group' => 'stok',
                'label' => 'Lead Time Supplier Tier-1 (Hari)',
                'type' => 'integer',
                'scope' => 'hub',
                'default' => 7,
                'edit' => self::HUB_EDITORS,
                'validation' => ['required', 'integer', 'min:1', 'max:365'],
            ],
            'stock.buffer_safety_percent' => [
                'group' => 'stok',
                'label' => 'Buffer Safety Stock (%)',
                'type' => 'integer',
                'scope' => 'hub',
                'default' => 25,
                'edit' => self::HUB_EDITORS,
                'validation' => ['required', 'integer', 'min:5', 'max:50'],
            ],
            'stock.dead_stock_days' => [
                'group' => 'stok',
                'label' => 'Ambang Dead Stock (Hari)',
                'type' => 'select',
                'scope' => 'hub',
                'default' => '90',
                'options' => ['60' => '> 60 Hari', '90' => '> 90 Hari', '180' => '> 180 Hari'],
                'edit' => self::HUB_EDITORS,
                'validation' => ['required', 'in:60,90,180'],
            ],
            'stock.auto_approve_enabled' => [
                'group' => 'stok',
                'label' => 'Otomatisasi Persetujuan Pengeluaran',
                'type' => 'boolean',
                'scope' => 'hub',
                'default' => false,
                'edit' => self::HUB_EDITORS,
                'validation' => ['required', 'boolean'],
                'note' => 'Tersimpan sebagai parameter. Modul transaksi pengeluaran belum tersedia sehingga parameter ini belum memengaruhi proses apa pun.',
            ],
            'stock.valuation_method' => [
                'group' => 'stok',
                'label' => 'Metode Valuasi Persediaan',
                'type' => 'select',
                'scope' => 'hub',
                'default' => 'fifo',
                'options' => ['fifo' => 'FIFO (First In, First Out)', 'average' => 'Average Moving Cost'],
                'edit' => self::HUB_EDITORS,
                'validation' => ['required', 'in:fifo,average'],
            ],
            'stock.critical_stock_notify' => [
                'group' => 'stok',
                'label' => 'Notifikasi Stok Kritis',
                'type' => 'boolean',
                'scope' => 'hub',
                'default' => false,
                'edit' => self::HUB_EDITORS,
                'validation' => ['required', 'boolean'],
                'note' => 'Gateway WhatsApp/SMTP belum dikonfigurasi, sehingga notifikasi belum dikirim.',
            ],
            'stock.batch_required' => [
                'group' => 'stok',
                'label' => 'Wajib Nomor Batch & Tanggal Kedaluwarsa',
                'type' => 'boolean',
                'scope' => 'hub',
                'default' => false,
                'edit' => self::HUB_EDITORS,
                'validation' => ['required', 'boolean'],
                'note' => 'Tabel batch belum tersedia; nilai hanya tersimpan sebagai kebijakan.',
            ],
            'stock.block_expired' => [
                'group' => 'stok',
                'label' => 'Blokir Keluar Barang ED < 90 Hari',
                'type' => 'boolean',
                'scope' => 'hub',
                'default' => false,
                'edit' => self::HUB_EDITORS,
                'validation' => ['required', 'boolean'],
                'note' => 'Modul transaksi keluar belum tersedia; nilai belum diterapkan pada proses.',
            ],
            'stock.in_transit_stock' => [
                'group' => 'stok',
                'label' => 'Izinkan Stok In-Transit',
                'type' => 'boolean',
                'scope' => 'hub',
                'default' => false,
                'edit' => self::HUB_EDITORS,
                'validation' => ['required', 'boolean'],
                'note' => 'Modul mutasi antar-hub belum tersedia; nilai belum diterapkan.',
            ],

            // ---------------------------------------------------------
            // 3. PERANGKAT & PRINTER BARCODE
            // ---------------------------------------------------------
            'printer.label_size' => [
                'group' => 'printer',
                'label' => 'Ukuran Label',
                'type' => 'select',
                'scope' => 'hub',
                'default' => '100x50',
                'options' => [
                    '100x50' => '100 x 50 mm (Standar Pallet)',
                    '75x50' => '75 x 50 mm (Bin Tag)',
                    '60x40' => '60 x 40 mm (Item Kecil)',
                ],
                'edit' => self::HUB_EDITORS,
                'validation' => ['required', 'in:100x50,75x50,60x40'],
            ],
            'printer.barcode_symbology' => [
                'group' => 'printer',
                'label' => 'Symbology Barcode',
                'type' => 'select',
                'scope' => 'hub',
                'default' => 'code128',
                'options' => ['code128' => 'Code 128', 'qr' => 'QR Code 2D', 'code39' => 'Code 39'],
                'edit' => self::HUB_EDITORS,
                'validation' => ['required', 'in:code128,qr,code39'],
            ],
            'printer.label_copies' => [
                'group' => 'printer',
                'label' => 'Jumlah Salinan Label per DO',
                'type' => 'integer',
                'scope' => 'hub',
                'default' => 2,
                'edit' => self::HUB_EDITORS,
                'validation' => ['required', 'integer', 'min:1', 'max:10'],
            ],
            'printer.scanner_sound' => [
                'group' => 'printer',
                'label' => 'Suara Konfirmasi Scan',
                'type' => 'boolean',
                'scope' => 'hub',
                'default' => true,
                'edit' => self::HUB_EDITORS,
                'validation' => ['required', 'boolean'],
            ],
            'printer.scanner_auto_sync' => [
                'group' => 'printer',
                'label' => 'Auto-Sync Offline Queue',
                'type' => 'boolean',
                'scope' => 'hub',
                'default' => true,
                'edit' => self::HUB_EDITORS,
                'validation' => ['required', 'boolean'],
            ],
            'printer.scanner_power_save' => [
                'group' => 'printer',
                'label' => 'Mode Hemat Baterai Shift Malam',
                'type' => 'boolean',
                'scope' => 'hub',
                'default' => false,
                'edit' => self::HUB_EDITORS,
                'validation' => ['required', 'boolean'],
            ],

            // ---------------------------------------------------------
            // 4. INTEGRASI ERP & API
            // ---------------------------------------------------------
            'erp.sap_endpoint' => [
                'group' => 'erp',
                'label' => 'SAP Endpoint Host',
                'type' => 'string',
                'scope' => 'global',
                'default' => '',
                'edit' => ['super_admin'],
                'validation' => ['nullable', 'string', 'max:191'],
                'note' => 'Hanya menyimpan konfigurasi. Koneksi SAP tidak diuji/diaktifkan karena kredensial & endpoint produksi tidak tersedia.',
            ],
            'erp.sap_client_id' => [
                'group' => 'erp',
                'label' => 'SAP Client / System ID',
                'type' => 'string',
                'scope' => 'global',
                'default' => '',
                'edit' => ['super_admin'],
                'validation' => ['nullable', 'string', 'max:100'],
            ],
            'erp.sap_sync_enabled' => [
                'group' => 'erp',
                'label' => 'Sync Master SKU Dua Arah',
                'type' => 'boolean',
                'scope' => 'global',
                'default' => false,
                'edit' => ['super_admin'],
                'validation' => ['required', 'boolean'],
                'note' => 'Tidak ada worker/scheduler SAP pada proyek ini; sinkronisasi belum berjalan.',
            ],
            'erp.webhook_url' => [
                'group' => 'erp',
                'label' => 'Webhook URL Mutasi Stok',
                'type' => 'string',
                'scope' => 'global',
                'default' => '',
                'edit' => ['super_admin'],
                'validation' => ['nullable', 'url', 'max:255'],
                'note' => 'Endpoint disimpan, namun pengiriman webhook belum diimplementasikan.',
            ],
            'erp.api_key' => [
                'group' => 'erp',
                'label' => 'API Key Internal',
                'type' => 'secret',
                'scope' => 'global',
                'default' => null,
                'edit' => ['super_admin'],
                'validation' => ['nullable', 'string', 'max:255'],
                'note' => 'Disimpan terenkripsi (AES-256) dan tidak pernah dikirim utuh ke browser.',
            ],

            // ---------------------------------------------------------
            // 5. KEAMANAN & KEBIJAKAN SESI
            // ---------------------------------------------------------
            'security.session_timeout_minutes' => [
                'group' => 'keamanan',
                'label' => 'Timeout Sesi Idle (Menit)',
                'type' => 'integer',
                'scope' => 'global',
                'default' => 120,
                'edit' => ['super_admin'],
                'validation' => ['required', 'integer', 'min:5', 'max:480'],
                'note' => 'Diterapkan pada config session Laravel saat request berikutnya.',
            ],
            'security.max_login_attempts' => [
                'group' => 'keamanan',
                'label' => 'Maksimal Percobaan Login Gagal',
                'type' => 'integer',
                'scope' => 'global',
                'default' => 5,
                'edit' => ['super_admin'],
                'validation' => ['required', 'integer', 'min:3', 'max:10'],
                'note' => 'Digunakan oleh LoginController melalui model User.',
            ],
            'security.lockout_minutes' => [
                'group' => 'keamanan',
                'label' => 'Durasi Kunci Akun (Menit)',
                'type' => 'integer',
                'scope' => 'global',
                'default' => 15,
                'edit' => ['super_admin'],
                'validation' => ['required', 'integer', 'min:5', 'max:120'],
            ],

            // Field desain yang belum didukung teknis (tidak disimpan).
            'security.require_2fa' => [
                'group' => 'keamanan',
                'label' => 'Wajib 2FA untuk Semua Role',
                'type' => 'boolean',
                'scope' => 'global',
                'default' => false,
                'edit' => ['super_admin'],
                'supported' => false,
                'unsupported_reason' => 'Infrastruktur 2FA (TOTP/FIDO2) belum tersedia di proyek.',
            ],
            'security.ip_whitelist' => [
                'group' => 'keamanan',
                'label' => 'IP Whitelist Panel Admin',
                'type' => 'string',
                'scope' => 'global',
                'default' => '',
                'edit' => ['super_admin'],
                'supported' => false,
                'unsupported_reason' => 'Middleware pembatas IP belum tersedia; menyimpannya tanpa penerapan akan menyesatkan.',
            ],
            'security.off_hours_block' => [
                'group' => 'keamanan',
                'label' => 'Blokir Akses di Luar Jam Operasional',
                'type' => 'boolean',
                'scope' => 'global',
                'default' => false,
                'edit' => ['super_admin'],
                'supported' => false,
                'unsupported_reason' => 'Kebijakan jam operasional belum diterapkan pada middleware.',
            ],

            // ---------------------------------------------------------
            // 6. BACKUP & PEMULIHAN (belum didukung)
            // ---------------------------------------------------------
            'backup.cron' => [
                'group' => 'backup',
                'label' => 'Ekspresi CRON Backup',
                'type' => 'string',
                'scope' => 'global',
                'default' => '0 3 * * *',
                'edit' => ['super_admin'],
                'supported' => false,
                'unsupported_reason' => 'Tidak ada scheduler/backup driver pada proyek (tidak ada paket backup, disk arsip, atau kredensial S3).',
            ],
            'backup.retention_days' => [
                'group' => 'backup',
                'label' => 'Retensi Snapshot (Hari)',
                'type' => 'integer',
                'scope' => 'global',
                'default' => 90,
                'edit' => ['super_admin'],
                'supported' => false,
                'unsupported_reason' => 'Belum ada proses backup yang berjalan.',
            ],
            'backup.s3_enabled' => [
                'group' => 'backup',
                'label' => 'Replikasi ke AWS S3',
                'type' => 'boolean',
                'scope' => 'global',
                'default' => false,
                'edit' => ['super_admin'],
                'supported' => false,
                'unsupported_reason' => 'Konfigurasi AWS S3 tidak tersedia dan tidak boleh diasumsikan aktif.',
            ],
        ];
    }

    public static function get(string $key): ?array
    {
        return self::definitions()[$key] ?? null;
    }

    public static function isSupported(string $key): bool
    {
        $def = self::get($key);
        return $def !== null && ($def['supported'] ?? true) === true;
    }

    public static function canEdit(string $key, ?string $roleCode): bool
    {
        $def = self::get($key);

        if (!$def || !self::isSupported($key) || !$roleCode) {
            return false;
        }

        return in_array($roleCode, $def['edit'] ?? [], true);
    }

    public static function canView(string $key, ?string $roleCode): bool
    {
        return self::get($key) !== null && $roleCode !== null;
    }

    public static function group(string $key): ?string
    {
        return self::get($key)['group'] ?? null;
    }

    public static function editableKeys(?string $roleCode): array
    {
        return array_values(array_filter(array_keys(self::definitions()), function (string $key) use ($roleCode) {
            return self::canEdit($key, $roleCode);
        }));
    }
}
