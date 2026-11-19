<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// Data demo transaksi: inbounds & outbounds (terhubung item/supplier/lokasi).
class TransaksiBarangSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('inbounds')->truncate();
        DB::table('outbounds')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $items = DB::table('items')->orderBy('id')->get();
        $suppliers = DB::table('suppliers')->orderBy('id')->pluck('id')->all();
        $locations = DB::table('locations')->orderBy('id')->pluck('id')->all();
        $users = DB::table('users')->orderBy('id')->pluck('id')->all();
        $now = now();

        if ($items->isEmpty()) return;

        // Inbounds
        $inbounds = [
            ['kode' => 'PO-2025-0819', 'surat_jalan' => 'SJ-01829-DC', 'qty' => 120, 'satuan' => 'Unit', 'dock' => 'DOCK 01', 'status' => 'Selesai', 'keterangan' => 'Penerimaan barcode scanner batch 1, QC lolos.'],
            ['kode' => 'PO-2025-0831', 'surat_jalan' => 'SJ-01844-DC', 'qty' => 300, 'satuan' => 'Rim', 'dock' => 'DOCK 02', 'status' => 'Lolos QC', 'keterangan' => 'Kertas HVS A4 siap putaway.'],
            ['kode' => 'PO-2025-0842', 'surat_jalan' => 'SJ-01857-DC', 'qty' => 80, 'satuan' => 'Roll', 'dock' => 'DOCK 03', 'status' => 'Menunggu QC', 'keterangan' => 'Stretch film menunggu sampling AQL.'],
            ['kode' => 'PO-2025-0855', 'surat_jalan' => 'SJ-01870-DC', 'qty' => 50, 'satuan' => 'Unit', 'dock' => 'DOCK 01', 'status' => 'Karantina', 'keterangan' => 'Bearing diterima tapi sebagian defect, karantina.'],
            ['kode' => 'PO-2025-0861', 'surat_jalan' => 'SJ-01879-DC', 'qty' => 200, 'satuan' => 'Unit', 'dock' => 'DOCK 02', 'status' => 'Menunggu QC', 'keterangan' => 'WD-40 spray tiba sore, antrean inspeksi.'],
        ];

        foreach ($inbounds as $i => $row) {
            $item = $items[$i % $items->count()];
            DB::table('inbounds')->insert(array_merge($row, [
                'item_id' => $item->id,
                'supplier_id' => $suppliers[$i % count($suppliers)] ?? null,
                'location_id' => $locations[$i % count($locations)] ?? null,
                'user_id' => $users[$i % count($users)] ?? null,
                'hub_id' => $item->hub_id,
                'created_at' => $now->copy()->subDays(count($inbounds) - $i)->subHours(3),
                'updated_at' => $now->copy()->subDays(count($inbounds) - $i),
            ]));
        }

        // Outbounds
        $outbounds = [
            ['kode' => 'DO-2025-0819', 'permintaan' => 'REQ-2510-001', 'departemen' => 'Operasional & Warehouse', 'pic' => 'Siti Nurhaliza', 'qty' => 5, 'satuan' => 'Roll', 'tujuan' => 'Kurir Internal DC', 'status' => 'Selesai', 'keterangan' => 'Stretch film untuk wrapping pallet ekspedisi.'],
            ['kode' => 'DO-2025-0820', 'permintaan' => 'REQ-2510-002', 'departemen' => 'Teknologi Informasi', 'pic' => 'Rian Kurniawan', 'qty' => 2, 'satuan' => 'Unit', 'tujuan' => 'Kurir Internal DC', 'status' => 'Picking', 'keterangan' => 'Barcode scanner untuk stasiun QC lantai 1.'],
            ['kode' => 'DO-2025-0821', 'permintaan' => 'REQ-2510-003', 'departemen' => 'General Affairs & HR', 'pic' => 'Maya Anggraeni', 'qty' => 40, 'satuan' => 'Rim', 'tujuan' => 'Cabang Regional', 'status' => 'Picking', 'keterangan' => 'Kertas HVS untuk cetak laporan bulanan cabang.'],
            ['kode' => 'DO-2025-0822', 'permintaan' => 'REQ-2510-004', 'departemen' => 'Produksi & Maintenance', 'pic' => 'Ir. Hartono', 'qty' => 10, 'satuan' => 'Unit', 'tujuan' => 'Gudang Produksi', 'status' => 'Menunggu', 'keterangan' => 'Bearing SKF cadangan mesin produksi.'],
        ];

        foreach ($outbounds as $i => $row) {
            $item = $items[$i % $items->count()];
            DB::table('outbounds')->insert(array_merge($row, [
                'item_id' => $item->id,
                'user_id' => $users[$i % count($users)] ?? null,
                'hub_id' => $item->hub_id,
                'created_at' => $now->copy()->subDays(count($outbounds) - $i)->subHours(2),
                'updated_at' => $now->copy()->subDays(count($outbounds) - $i),
            ]));
        }
    }
}
