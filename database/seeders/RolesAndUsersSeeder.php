<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Roles
        $roles = [
            [
                'code' => 'super_admin',
                'name' => 'Super Admin',
                'description' => 'Administrator sistem dengan kontrol penuh terhadap akun, role, permission, dan pengaturan sistem. Tidak mengelola transaksi operasional.',
                'is_system' => true,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'kepala_gudang',
                'name' => 'Kepala Gudang',
                'description' => 'Mengelola master data barang, kategori, lokasi, supplier, divisi. Mengelola barang masuk, barang keluar, penyesuaian stok, dan stock opname.',
                'is_system' => true,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'hr',
                'name' => 'HR (Human Resource)',
                'description' => 'Menyetujui atau menolak permintaan barang keluar, penyesuaian stok, dan hasil stock opname. Dapat melihat laporan dan dashboard.',
                'is_system' => true,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'pegawai',
                'name' => 'Pegawai Gudang',
                'description' => 'Mencatat barang masuk, mengajukan permintaan barang keluar, konfirmasi serah terima, dan input hasil hitung stock opname.',
                'is_system' => true,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'audit',
                'name' => 'Auditor',
                'description' => 'Akses baca saja untuk memeriksa transaksi, laporan, audit log, dan ekspor data. Tidak dapat mengubah data apapun.',
                'is_system' => true,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('roles')->insert($roles);

        // 2. Seed Permissions (berdasarkan matriks slide 19-20)
        $permissions = [
            // Barang dan Master
            ['code' => 'catalog.view', 'name' => 'Lihat Katalog & Stok', 'group' => 'barang', 'description' => 'Lihat katalog, stok, dan detail barang'],
            ['code' => 'dashboard.view', 'name' => 'Lihat Dashboard', 'group' => 'barang', 'description' => 'Lihat dashboard admin dengan ringkasan'],
            ['code' => 'master.view', 'name' => 'Lihat Master Data', 'group' => 'barang', 'description' => 'Lihat kategori, lokasi, supplier, divisi'],
            ['code' => 'master.manage', 'name' => 'Kelola Master Data', 'group' => 'barang', 'description' => 'Tambah, ubah, nonaktifkan master data'],
            ['code' => 'product.manage', 'name' => 'Kelola Barang', 'group' => 'barang', 'description' => 'Tambah, ubah, nonaktifkan barang'],
            ['code' => 'master.delete', 'name' => 'Hapus Master/Barang', 'group' => 'barang', 'description' => 'Hapus master atau barang tanpa referensi'],
            ['code' => 'product.label', 'name' => 'Cetak Label', 'group' => 'barang', 'description' => 'Cetak barcode dan QR code'],

            // Barang Masuk
            ['code' => 'transaction.view', 'name' => 'Lihat Riwayat Transaksi', 'group' => 'transaksi', 'description' => 'Lihat riwayat semua transaksi'],
            ['code' => 'receipt.create', 'name' => 'Catat Barang Masuk', 'group' => 'transaksi', 'description' => 'Catat dan posting barang masuk'],
            ['code' => 'receipt.void', 'name' => 'Batalkan Barang Masuk', 'group' => 'transaksi', 'description' => 'Void barang masuk yang sudah diposting'],

            // Barang Keluar
            ['code' => 'issue.create', 'name' => 'Ajukan Barang Keluar', 'group' => 'transaksi', 'description' => 'Ajukan dan batalkan permintaan barang keluar'],
            ['code' => 'issue.approve', 'name' => 'Setujui Barang Keluar', 'group' => 'transaksi', 'description' => 'Setujui atau tolak permintaan barang keluar'],
            ['code' => 'issue.cancel_approved', 'name' => 'Batalkan Setelah Disetujui', 'group' => 'transaksi', 'description' => 'Batalkan barang keluar yang sudah disetujui'],
            ['code' => 'issue.handover', 'name' => 'Konfirmasi Serah Terima', 'group' => 'transaksi', 'description' => 'Konfirmasi penyerahan barang keluar'],
            ['code' => 'issue.print', 'name' => 'Cetak Bukti', 'group' => 'transaksi', 'description' => 'Cetak bukti serah terima / surat jalan'],

            // Penyesuaian dan Opname
            ['code' => 'adjustment.create', 'name' => 'Buat Penyesuaian Stok', 'group' => 'transaksi', 'description' => 'Buat penyesuaian stok manual'],
            ['code' => 'adjustment.approve', 'name' => 'Setujui Penyesuaian', 'group' => 'transaksi', 'description' => 'Setujui atau tolak penyesuaian stok'],
            ['code' => 'opname.count', 'name' => 'Input Hasil Hitung', 'group' => 'transaksi', 'description' => 'Input hasil hitung stock opname'],
            ['code' => 'opname.manage', 'name' => 'Kelola Opname', 'group' => 'transaksi', 'description' => 'Buat sesi, review, kembalikan, batalkan opname'],
            ['code' => 'opname.approve', 'name' => 'Setujui Opname', 'group' => 'transaksi', 'description' => 'Setujui hasil stock opname'],

            // Laporan
            ['code' => 'report.view', 'name' => 'Lihat Laporan', 'group' => 'laporan', 'description' => 'Lihat laporan dan analitik'],
            ['code' => 'report.export', 'name' => 'Ekspor Laporan', 'group' => 'laporan', 'description' => 'Ekspor laporan ke Excel/CSV/PDF'],

            // Pengguna dan Sistem
            ['code' => 'user.view', 'name' => 'Lihat Pengguna', 'group' => 'sistem', 'description' => 'Lihat daftar pengguna'],
            ['code' => 'user.manage', 'name' => 'Kelola Pengguna', 'group' => 'sistem', 'description' => 'Tambah, ubah, aktifkan, nonaktifkan pengguna'],
            ['code' => 'role.manage', 'name' => 'Kelola Role', 'group' => 'sistem', 'description' => 'Kelola role dan permission'],
            ['code' => 'audit.view', 'name' => 'Lihat Audit Log', 'group' => 'sistem', 'description' => 'Lihat audit log dan riwayat aktivitas'],
            ['code' => 'settings.view', 'name' => 'Lihat Pengaturan', 'group' => 'sistem', 'description' => 'Lihat pengaturan sistem dan profil perusahaan'],
            ['code' => 'settings.manage', 'name' => 'Kelola Pengaturan', 'group' => 'sistem', 'description' => 'Ubah profil perusahaan dan parameter sistem'],
            ['code' => 'system.errors', 'name' => 'Lihat Error Log', 'group' => 'sistem', 'description' => 'Lihat log error sistem'],
            ['code' => 'backup.view', 'name' => 'Lihat Backup', 'group' => 'sistem', 'description' => 'Lihat riwayat backup'],
            ['code' => 'backup.manage', 'name' => 'Kelola Backup', 'group' => 'sistem', 'description' => 'Picu dan verifikasi backup'],
        ];

        $permissionIds = [];
        foreach ($permissions as $permission) {
            $permission['created_at'] = now();
            $permission['updated_at'] = now();
            $id = DB::table('permissions')->insertGetId($permission);
            $permissionIds[$permission['code']] = $id;
        }

        // 3. Seed Role-Permission Mapping (berdasarkan matriks slide 19-20)
        $rolePermissions = [
            'super_admin' => [
                'catalog.view', 'dashboard.view', 'master.view', 'master.manage', 'product.manage', 
                'master.delete', 'product.label', 'transaction.view', 'issue.print', 'report.view', 
                'report.export', 'user.view', 'user.manage', 'role.manage', 'audit.view', 
                'settings.view', 'settings.manage', 'system.errors', 'backup.view', 'backup.manage'
            ],
            'kepala_gudang' => [
                'catalog.view', 'dashboard.view', 'master.view', 'master.manage', 'product.manage', 
                'master.delete', 'product.label', 'transaction.view', 'receipt.create', 'receipt.void', 
                'issue.create', 'issue.cancel_approved', 'issue.handover', 'issue.print', 
                'adjustment.create', 'opname.count', 'opname.manage', 'report.view', 'report.export', 
                'settings.view'
            ],
            'hr' => [
                'catalog.view', 'dashboard.view', 'master.view', 'transaction.view', 'issue.create', 
                'issue.approve', 'issue.print', 'adjustment.approve', 'opname.approve', 
                'report.view', 'report.export'
            ],
            'pegawai' => [
                'catalog.view', 'master.view', 'product.label', 'transaction.view', 'receipt.create', 
                'issue.create', 'issue.handover', 'issue.print', 'opname.count', 'report.view'
            ],
            'audit' => [
                'catalog.view', 'dashboard.view', 'master.view', 'transaction.view', 
                'report.view', 'report.export', 'audit.view'
            ],
        ];

        $roleIds = DB::table('roles')->pluck('id', 'code')->toArray();

        foreach ($rolePermissions as $roleCode => $permissionCodes) {
            foreach ($permissionCodes as $permCode) {
                DB::table('role_permissions')->insert([
                    'role_id' => $roleIds[$roleCode],
                    'permission_id' => $permissionIds[$permCode],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 4. Seed Users
        $users = [
            [
                'username' => 'superadmin',
                'email' => 'superadmin@astro.com',
                'password' => Hash::make('password123'),
                'nama_lengkap' => 'Super Administrator',
                'nip' => 'SA001',
                'phone' => '081234567890',
                'role_id' => $roleIds['super_admin'],
                'status' => 'active',
                'failed_login_attempts' => 0,
                'locked_until' => null,
                'last_login_at' => null,
                'last_login_ip' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'kepala_gudang',
                'email' => 'kepala.gudang@astro.com',
                'password' => Hash::make('password123'),
                'nama_lengkap' => 'Budi Santoso',
                'nip' => 'KG001',
                'phone' => '081234567891',
                'role_id' => $roleIds['kepala_gudang'],
                'status' => 'active',
                'failed_login_attempts' => 0,
                'locked_until' => null,
                'last_login_at' => null,
                'last_login_ip' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'hr_manager',
                'email' => 'hr.manager@astro.com',
                'password' => Hash::make('password123'),
                'nama_lengkap' => 'Siti Nurhaliza',
                'nip' => 'HR001',
                'phone' => '081234567892',
                'role_id' => $roleIds['hr'],
                'status' => 'active',
                'failed_login_attempts' => 0,
                'locked_until' => null,
                'last_login_at' => null,
                'last_login_ip' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'pegawai1',
                'email' => 'pegawai1@astro.com',
                'password' => Hash::make('password123'),
                'nama_lengkap' => 'Ahmad Fauzi',
                'nip' => 'PG001',
                'phone' => '081234567893',
                'role_id' => $roleIds['pegawai'],
                'status' => 'active',
                'failed_login_attempts' => 0,
                'locked_until' => null,
                'last_login_at' => null,
                'last_login_ip' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'pegawai2',
                'email' => 'pegawai2@astro.com',
                'password' => Hash::make('password123'),
                'nama_lengkap' => 'Dewi Lestari',
                'nip' => 'PG002',
                'phone' => '081234567894',
                'role_id' => $roleIds['pegawai'],
                'status' => 'active',
                'failed_login_attempts' => 0,
                'locked_until' => null,
                'last_login_at' => null,
                'last_login_ip' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'auditor',
                'email' => 'auditor@astro.com',
                'password' => Hash::make('password123'),
                'nama_lengkap' => 'Eko Prasetyo',
                'nip' => 'AU001',
                'phone' => '081234567895',
                'role_id' => $roleIds['audit'],
                'status' => 'active',
                'failed_login_attempts' => 0,
                'locked_until' => null,
                'last_login_at' => null,
                'last_login_ip' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
