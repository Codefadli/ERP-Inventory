<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Data demo modul pegawai: permintaan barang (requests) dan
 * hasil stok opname (stock_opnames) — agar halaman pegawai
 * menampilkan data nyata dari DB, bukan simulasi.
 */
class PegawaiDataSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Idempoten: kosongkan dulu agar bisa dijalankan ulang tanpa error unik.
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('requests')->truncate();
        DB::table('stock_opnames')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $pegawaiIds = DB::table('users')->where('role_id', 4)->pluck('id')->all(); // role pegawai
        if (empty($pegawaiIds)) {
            $pegawaiIds = [4];
        }

        $hubIds = DB::table('hubs')->orderBy('id')->pluck('id')->all();
        $pegawaiId = $pegawaiIds[0];
        $pegawai2 = count($pegawaiIds) > 1 ? $pegawaiIds[1] : $pegawaiId;

        // --- Requests (permintaan barang) ---
        $requests = [
            [
                'tiket' => 'REQ-' . now()->format('ymd') . '-001',
                'tipe' => 'Barang Keluar',
                'rincian' => 'Permintaan pengambilan Kertas HVS A4 untuk cetak laporan bulanan.',
                'prioritas' => 'Normal',
                'approver' => 'Kepala Gudang',
                'status' => 'Disetujui',
                'user_id' => $pegawaiId,
                'hub_id' => $hubIds[0] ?? null,
                'disetujui_at' => now()->subHours(3),
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subHours(3),
            ],
            [
                'tiket' => 'REQ-' . now()->format('ymd') . '-002',
                'tipe' => 'Barang Keluar',
                'rincian' => 'Permintaan Barcode Scanner Wireless untuk stasiun QC lantai 1.',
                'prioritas' => 'Tinggi',
                'approver' => 'Kepala Gudang',
                'status' => 'Menunggu',
                'user_id' => $pegawai2,
                'hub_id' => $hubIds[1] ?? null,
                'disetujui_at' => null,
                'created_at' => now()->subHours(5),
                'updated_at' => now()->subHours(5),
            ],
            [
                'tiket' => 'REQ-' . now()->format('ymd') . '-003',
                'tipe' => 'Barang Keluar',
                'rincian' => 'Permintaan lakban coklat dan stretch film untuk packing ekspedisi.',
                'prioritas' => 'Normal',
                'approver' => 'Kepala Gudang',
                'status' => 'Ditolak',
                'user_id' => $pegawaiId,
                'hub_id' => $hubIds[0] ?? null,
                'disetujui_at' => null,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(1),
            ],
            [
                'tiket' => 'REQ-' . now()->format('ymd') . '-004',
                'tipe' => 'Pemeliharaan',
                'rincian' => 'Permintaan bearing SKF 6205 untuk penggantian mesin produksi.',
                'prioritas' => 'Normal',
                'approver' => 'Kepala Gudang',
                'status' => 'Selesai',
                'user_id' => $pegawai2,
                'hub_id' => $hubIds[1] ?? null,
                'disetujui_at' => now()->subDays(2),
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(1),
            ],
        ];

        foreach ($requests as $req) {
            DB::table('requests')->insert($req);
        }

        // --- Stock Opnames (hasil hitung fisik) ---
        $items = DB::table('items')->orderBy('id')->take(4)->get();
        foreach ($items as $i => $item) {
            $qtyFisik = 12 + ($i * 5);
            $selisih = $qtyFisik > 0 ? ($i === 1 ? -2 : 0) : 0;
            DB::table('stock_opnames')->insert([
                'item_id' => $item->id,
                'user_id' => ($i % 2 === 0) ? $pegawaiId : $pegawai2,
                'hub_id' => $item->hub_id ?? ($hubIds[$i % count($hubIds)] ?? null),
                'qty_sistem' => max(0, $qtyFisik - $selisih),
                'qty_fisik' => $qtyFisik,
                'selisih' => $selisih,
                'status' => $selisih === 0 ? 'Sesuai' : 'Selisih',
                'catatan' => $selisih === 0 ? 'Stok fisik sesuai dengan catatan sistem.' : 'Terdapat selisih, perlu verifikasi ulang.',
                'created_at' => now()->subDays($i),
                'updated_at' => now()->subDays($i),
            ]);
        }
    }
}
