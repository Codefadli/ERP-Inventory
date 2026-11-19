<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterDataSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hub untuk distribusi master data (filter "pemilihan hub").
        $hubIds = DB::table('hubs')->orderBy('id')->pluck('id')->all();
        $hubFor = function (int $index) use ($hubIds) {
            if (empty($hubIds)) return null;
            return $hubIds[$index % count($hubIds)];
        };

        // 1. Categories — matching hardcoded data from MasterDataController::getCommonData()
        $categories = [
            ['kode' => 'CAT-001', 'nama' => 'Elektronik & Hardware', 'deskripsi' => 'Komponen IT, kabel, adaptor, dan perangkat periferal', 'status' => true],
            ['kode' => 'CAT-002', 'nama' => 'Alat Tulis Kantor (ATK)', 'deskripsi' => 'Kertas, pena, map, binder, dan perlengkapan administrasi', 'status' => true],
            ['kode' => 'CAT-003', 'nama' => 'Sparepart Mesin Pabrik', 'deskripsi' => 'Bearing, belt, bearing motor, baut industri', 'status' => true],
            ['kode' => 'CAT-004', 'nama' => 'Chemical & Cleaning', 'deskripsi' => 'Deterjen industri, desinfektan, cairan pelumas', 'status' => true],
            ['kode' => 'CAT-005', 'nama' => 'Packaging & Logistik', 'deskripsi' => 'Kardus packing, stretch film, lakban, pallet strap', 'status' => true],
            ['kode' => 'CAT-006', 'nama' => 'Safety & APD', 'deskripsi' => 'Helm proyek, sarung tangan safety, kacamata pelindung', 'status' => false],
        ];

        foreach ($categories as $index => $cat) {
            $cat['created_at'] = now();
            $cat['updated_at'] = now();
            $cat['deleted_at'] = null;
            if (!array_key_exists('hub_id', $cat)) {
                $cat['hub_id'] = $hubFor($index);
            }
            DB::table('categories')->insert($cat);
        }

        // 2. Units
        $units = [
            ['kode' => 'PCS', 'nama' => 'Pieces / Buah', 'keterangan' => 'Satuan hitung unit satuan terkecil', 'status' => true],
            ['kode' => 'BOX', 'nama' => 'Box / Kotak', 'keterangan' => 'Kemasan sekunder isi variatif', 'status' => true],
            ['kode' => 'RIM', 'nama' => 'Rim (500 lbr)', 'keterangan' => 'Khusus kertas HVS & dokumen', 'status' => true],
            ['kode' => 'KG', 'nama' => 'Kilogram', 'keterangan' => 'Satuan berat material curah', 'status' => true],
            ['kode' => 'LTR', 'nama' => 'Liter', 'keterangan' => 'Satuan volume cairan / chemical', 'status' => true],
            ['kode' => 'ROLL', 'nama' => 'Roll / Gulung', 'keterangan' => 'Lakban, stretch film, kabel rol', 'status' => true],
            ['kode' => 'SET', 'nama' => 'Set / Pasang', 'keterangan' => 'Perangkat paket perakitan lengkap', 'status' => true],
        ];

        foreach ($units as $unit) {
            $unit['created_at'] = now();
            $unit['updated_at'] = now();
            $unit['deleted_at'] = null;
            DB::table('units')->insert($unit);
        }

        // 3. Locations
        $locations = [
            ['kode' => 'RAK-A1-01', 'nama' => 'Rak Besi Tingkat 1', 'gudang' => 'Gudang Utama (A)', 'nama_rak' => 'Rak Besi Tingkat 1', 'kapasitas' => 50, 'terisi' => 32, 'keterangan' => 'Dekat pintu loading bay barat', 'status' => true],
            ['kode' => 'RAK-A1-02', 'nama' => 'Rak Besi Tingkat 2', 'gudang' => 'Gudang Utama (A)', 'nama_rak' => 'Rak Besi Tingkat 2', 'kapasitas' => 50, 'terisi' => 48, 'keterangan' => 'Stok fast-moving Elektronik', 'status' => true],
            ['kode' => 'RAK-B2-01', 'nama' => 'Rak Pallet 1', 'gudang' => 'Gudang Logistik (B)', 'nama_rak' => 'Rak Pallet 1', 'kapasitas' => 80, 'terisi' => 20, 'keterangan' => 'Untuk barang packaging karton', 'status' => true],
            ['kode' => 'RAK-C1-03', 'nama' => 'Lemari Safety Bersegel', 'gudang' => 'Gudang Khusus Kimia (C)', 'nama_rak' => 'Lemari Safety Bersegel', 'kapasitas' => 20, 'terisi' => 8, 'keterangan' => 'Suhu terkontrol & tahan korosi', 'status' => true],
            ['kode' => 'RAK-T-00', 'nama' => 'Lantai Transit Sementara', 'gudang' => 'Area Transit', 'nama_rak' => 'Lantai Transit Sementara', 'kapasitas' => 30, 'terisi' => 5, 'keterangan' => 'Barang baru bongkar belum QC', 'status' => true],
        ];

        foreach ($locations as $index => $loc) {
            $loc['created_at'] = now();
            $loc['updated_at'] = now();
            $loc['deleted_at'] = null;
            if (!array_key_exists('hub_id', $loc)) {
                $loc['hub_id'] = $hubFor($index);
            }
            DB::table('locations')->insert($loc);
        }

        // 4. Suppliers
        $suppliers = [
            ['kode' => 'SPL-001', 'nama' => 'PT Mitra Sarana Abadi', 'pic' => 'Bambang Irawan', 'telepon' => '0812-3456-7890', 'email' => 'sales@mitrasarana.co.id', 'kota' => 'Jakarta Barat', 'alamat' => 'Kawasan Industri Puri Blok C4 No 12', 'status' => true],
            ['kode' => 'SPL-002', 'nama' => 'CV Sumber Makmur Mandiri', 'pic' => 'Dewi Sartika', 'telepon' => '0813-8899-1122', 'email' => 'order@sumbermakmur.com', 'kota' => 'Tangerang', 'alamat' => 'Jl. Daan Mogot KM 18 Pergudangan Era Prima', 'status' => true],
            ['kode' => 'SPL-003', 'nama' => 'PT Surya Delta Chemika', 'pic' => 'Hendro Wijaya', 'telepon' => '0821-7766-3344', 'email' => 'hendro@suryadelta.co.id', 'kota' => 'Bekasi', 'alamat' => 'Kawasan MM2100 Cikarang Barat', 'status' => true],
            ['kode' => 'SPL-004', 'nama' => 'UD Sejahtera Logistik Pack', 'pic' => 'Agus Pratama', 'telepon' => '0811-2233-4455', 'email' => 'agus@sejahterapack.id', 'kota' => 'Surabaya', 'alamat' => 'Rungkut Industri Raya No 55', 'status' => true],
        ];

        foreach ($suppliers as $index => $supplier) {
            $supplier['created_at'] = now();
            $supplier['updated_at'] = now();
            $supplier['deleted_at'] = null;
            if (!array_key_exists('hub_id', $supplier)) {
                $supplier['hub_id'] = $hubFor($index);
            }
            DB::table('suppliers')->insert($supplier);
        }

        // 5. Divisions
        $divisions = [
            ['kode' => 'DIV-IT', 'nama' => 'Teknologi Informasi & Infrastruktur', 'kepala' => 'Rian Kurniawan, S.Kom', 'keterangan' => 'Peralatan kantor IT, kabel jaringan, perlengkapan server', 'status' => true],
            ['kode' => 'DIV-OPS', 'nama' => 'Operasional & Warehouse', 'kepala' => 'Siti Nurhaliza', 'keterangan' => 'Kebutuhan lakban, stretch film, APD gudang', 'status' => true],
            ['kode' => 'DIV-PROD', 'nama' => 'Produksi & Maintenance Mesin', 'kepala' => 'Ir. Hartono', 'keterangan' => 'Sparepart mesin pabrik, pelumas, bearing', 'status' => true],
            ['kode' => 'DIV-GA', 'nama' => 'General Affairs & HR', 'kepala' => 'Maya Anggraeni', 'keterangan' => 'ATK seluruh divisi dan bahan kebersihan', 'status' => true],
            ['kode' => 'DIV-FIN', 'nama' => 'Keuangan & Akuntansi', 'kepala' => 'Budi Santoso, SE', 'keterangan' => 'ATK, kertas faktur, binder arsip pajak', 'status' => true],
        ];

        foreach ($divisions as $index => $division) {
            $division['created_at'] = now();
            $division['updated_at'] = now();
            $division['deleted_at'] = null;
            if (!array_key_exists('hub_id', $division)) {
                $division['hub_id'] = $hubFor($index);
            }
            DB::table('divisions')->insert($division);
        }

        // 6. Items — setiap item diberi hub_id (distribusi ke hub yang ada,
        //    agar filter "pemilihan hub" pada halaman Data Barang berfungsi).
        $items = [
            [
                'sku' => 'ELK-0010',
                'barcode' => '899275300101',
                'nama' => 'Barcode Scanner Wireless 2D Laser',
                'category_id' => 1,
                'unit_id' => 1,
                'location_id' => 2,
                'supplier_id' => 1,
                'division_id' => 1,
                'deskripsi' => 'Barcode scanner nirkabel 2D laser untuk gudang',
                'foto' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=150&auto=format&fit=crop&q=80',
                'status' => 'Aktif',
                'stok_minimum' => 5,
                'harga_beli' => 750000,
                'harga_jual' => 920000,
            ],
            [
                'sku' => 'ATK-0004',
                'barcode' => '899275300205',
                'nama' => 'Kertas HVS PaperOne A4 80gr',
                'category_id' => 2,
                'unit_id' => 3,
                'location_id' => 1,
                'supplier_id' => 2,
                'division_id' => 4,
                'deskripsi' => 'Kertas HVS A4 80 gram untuk cetak dokumen',
                'foto' => 'https://images.unsplash.com/photo-1589330694653-dad6bc01cf0e?w=150&auto=format&fit=crop&q=80',
                'status' => 'Stok Kritis',
                'stok_minimum' => 10,
                'harga_beli' => 48000,
                'harga_jual' => 55000,
            ],
            [
                'sku' => 'LOG-0012',
                'barcode' => '899275300331',
                'nama' => 'Stretch Film Plastik Wrapping 50cm x 200m',
                'category_id' => 5,
                'unit_id' => 6,
                'location_id' => 3,
                'supplier_id' => 4,
                'division_id' => 2,
                'deskripsi' => 'Stretch film untuk wrapping pallet',
                'foto' => 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?w=150&auto=format&fit=crop&q=80',
                'status' => 'Aktif',
                'stok_minimum' => 15,
                'harga_beli' => 62000,
                'harga_jual' => 75000,
            ],
            [
                'sku' => 'ENG-0088',
                'barcode' => '899275300449',
                'nama' => 'Ball Bearing SKF 6205-2RSH C3',
                'category_id' => 3,
                'unit_id' => 1,
                'location_id' => 2,
                'supplier_id' => 1,
                'division_id' => 3,
                'deskripsi' => 'Bearing mesin pabrik SKF',
                'foto' => 'https://images.unsplash.com/photo-1530124566582-a618bc2615dc?w=150&auto=format&fit=crop&q=80',
                'status' => 'Stok Kritis',
                'stok_minimum' => 6,
                'harga_beli' => 110000,
                'harga_jual' => 135000,
            ],
            [
                'sku' => 'CHM-0003',
                'barcode' => '899275300552',
                'nama' => 'WD-40 Multi-Use Lubricant Spray 412ml',
                'category_id' => 4,
                'unit_id' => 1,
                'location_id' => 4,
                'supplier_id' => 2,
                'division_id' => 2,
                'deskripsi' => 'Lubricant spray multi-purpose',
                'foto' => 'https://images.unsplash.com/photo-1628177142898-93e36e4e3a50?w=150&auto=format&fit=crop&q=80',
                'status' => 'Aktif',
                'stok_minimum' => 8,
                'harga_beli' => 68000,
                'harga_jual' => 82000,
            ],
            [
                'sku' => 'LOG-0007',
                'barcode' => '899275300667',
                'nama' => 'Lakban Coklat Daimaru 2 Inch 100 Yard',
                'category_id' => 5,
                'unit_id' => 6,
                'location_id' => 3,
                'supplier_id' => 4,
                'division_id' => 2,
                'deskripsi' => 'Lakban coklat untuk packaging',
                'foto' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=150&auto=format&fit=crop&q=80',
                'status' => 'Aktif',
                'stok_minimum' => 30,
                'harga_beli' => 12500,
                'harga_jual' => 15000,
            ],
        ];

        foreach ($items as $index => $item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
            $item['deleted_at'] = null;
            if (!array_key_exists('hub_id', $item)) {
                $item['hub_id'] = $hubFor($index);
            }
            DB::table('items')->insert($item);
        }
    }
}
