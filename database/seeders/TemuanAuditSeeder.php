<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// Data demo temuan audit (LTA).
class TemuanAuditSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('temuan_audits')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $auditor = DB::table('users')->where('role_id', 6)->value('id') ?? null;
        $hubIds = DB::table('hubs')->orderBy('id')->pluck('id')->all();
        $now = now();

        $temuans = [
            [
                'kode' => 'LTA-2510-001',
                'judul' => 'Selisih stok fisik vs catatan pada rak fast-moving',
                'deskripsi' => 'Hasil opname menemukan selisih qty fisik lebih rendah 2 unit dari catatan sistem pada rak A1-02; perlu verifikasi ulang.',
                'tingkat' => 'Sedang',
                'status' => 'Temuan Baru',
                'lokasi' => 'RAK-A1-02 / Gudang Utama (A)',
            ],
            [
                'kode' => 'LTA-2510-002',
                'judul' => 'Dokumen surat jalan tidak terlampir pada penerimaan',
                'deskripsi' => 'Penerimaan PO-2025-0831 tercatat tanpa salinan surat jalan fisik di arsip; berpotensi masalah kepatuhan BAST.',
                'tingkat' => 'Kritis',
                'status' => 'Diverifikasi',
                'lokasi' => 'DOCK 02 / Receiving',
            ],
            [
                'kode' => 'LTA-2510-003',
                'judul' => 'Barang karantina melebihi batas waktu inspeksi',
                'deskripsi' => 'Batch bearing karantina belum diinspeksi ulang setelah 3 hari, berisiko keterlambatan penempatan stok.',
                'tingkat' => 'Ringan',
                'status' => 'Selesai',
                'lokasi' => 'Area Karantina / Gudang',
            ],
        ];

        foreach ($temuans as $i => $t) {
            DB::table('temuan_audits')->insert(array_merge($t, [
                'user_id' => $auditor,
                'hub_id' => $hubIds[$i % count($hubIds)] ?? null,
                'created_at' => $now->copy()->subDays(count($temuans) - $i),
                'updated_at' => $now->copy()->subDays(count($temuans) - $i),
            ]));
        }
    }
}
