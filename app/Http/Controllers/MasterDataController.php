<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    private function getCommonData()
    {
        return [
            'categories' => [
                ['id' => 1, 'kode' => 'KAT-001', 'nama' => 'Elektronik & Hardware', 'total_sku' => 14, 'deskripsi' => 'Komponen IT, kabel, adaptor, dan perangkat periferal', 'status' => 'Aktif'],
                ['id' => 2, 'kode' => 'KAT-002', 'nama' => 'Alat Tulis Kantor (ATK)', 'total_sku' => 38, 'deskripsi' => 'Kertas, pena, map, binder, dan perlengkapan administrasi', 'status' => 'Aktif'],
                ['id' => 3, 'kode' => 'KAT-003', 'nama' => 'Sparepart Mesin Pabrik', 'total_sku' => 22, 'deskripsi' => 'Bearing, belt, bearing motor, baut industri', 'status' => 'Aktif'],
                ['id' => 4, 'kode' => 'KAT-004', 'nama' => 'Chemical & Cleaning', 'total_sku' => 9, 'deskripsi' => 'Deterjen industri, desinfektan, cairan pelumas', 'status' => 'Aktif'],
                ['id' => 5, 'kode' => 'KAT-005', 'nama' => 'Packaging & Logistik', 'total_sku' => 17, 'deskripsi' => 'Kardus packing, stretch film, lakban, pallet strap', 'status' => 'Aktif'],
                ['id' => 6, 'kode' => 'KAT-006', 'nama' => 'Safety & APD', 'total_sku' => 11, 'deskripsi' => 'Helm proyek, sarung tangan safety, kacamata pelindung', 'status' => 'Nonaktif'],
            ],
            'units' => [
                ['id' => 1, 'kode' => 'PCS', 'nama' => 'Pieces / Buah', 'keterangan' => 'Satuan hitung unit satuan terkecil', 'status' => 'Aktif'],
                ['id' => 2, 'kode' => 'BOX', 'nama' => 'Box / Kotak', 'keterangan' => 'Kemasan sekunder isi variatif', 'status' => 'Aktif'],
                ['id' => 3, 'kode' => 'RIM', 'nama' => 'Rim (500 lbr)', 'keterangan' => 'Khusus kertas HVS & dokumen', 'status' => 'Aktif'],
                ['id' => 4, 'kode' => 'KG', 'nama' => 'Kilogram', 'keterangan' => 'Satuan berat material curah', 'status' => 'Aktif'],
                ['id' => 5, 'kode' => 'LTR', 'nama' => 'Liter', 'keterangan' => 'Satuan volume cairan / chemical', 'status' => 'Aktif'],
                ['id' => 6, 'kode' => 'ROLL', 'nama' => 'Roll / Gulung', 'keterangan' => 'Lakban, stretch film, kabel rol', 'status' => 'Aktif'],
                ['id' => 7, 'kode' => 'SET', 'nama' => 'Set / Pasang', 'keterangan' => 'Perangkat paket perakitan lengkap', 'status' => 'Aktif'],
            ],
            'locations' => [
                ['id' => 1, 'kode' => 'RAK-A1-01', 'gudang' => 'Gudang Utama (A)', 'nama_rak' => 'Rak Besi Tingkat 1', 'kapasitas' => 50, 'terisi' => 32, 'keterangan' => 'Dekat pintu loading bay barat', 'status' => 'Aktif'],
                ['id' => 2, 'kode' => 'RAK-A1-02', 'gudang' => 'Gudang Utama (A)', 'nama_rak' => 'Rak Besi Tingkat 2', 'kapasitas' => 50, 'terisi' => 48, 'keterangan' => 'Stok fast-moving Elektronik', 'status' => 'Hampir Penuh'],
                ['id' => 3, 'kode' => 'RAK-B2-01', 'gudang' => 'Gudang Logistik (B)', 'nama_rak' => 'Rak Pallet 1', 'kapasitas' => 80, 'terisi' => 20, 'keterangan' => 'Untuk barang packaging karton', 'status' => 'Aktif'],
                ['id' => 4, 'kode' => 'RAK-C1-03', 'gudang' => 'Gudang Khusus Kimia (C)', 'nama_rak' => 'Lemari Safety Bersegel', 'kapasitas' => 20, 'terisi' => 8, 'keterangan' => 'Suhu terkontrol & tahan korosi', 'status' => 'Aktif'],
                ['id' => 5, 'kode' => 'RAK-T-00', 'gudang' => 'Area Transit', 'nama_rak' => 'Lantai Transit Sementara', 'kapasitas' => 30, 'terisi' => 5, 'keterangan' => 'Barang baru bongkar belum QC', 'status' => 'Aktif'],
            ],
            'suppliers' => [
                ['id' => 1, 'kode' => 'SPL-001', 'nama' => 'PT Mitra Sarana Abadi', 'pic' => 'Bambang Irawan', 'telepon' => '0812-3456-7890', 'email' => 'sales@mitrasarana.co.id', 'kota' => 'Jakarta Barat', 'alamat' => 'Kawasan Industri Puri Blok C4 No 12', 'status' => 'Aktif'],
                ['id' => 2, 'kode' => 'SPL-002', 'nama' => 'CV Sumber Makmur Mandiri', 'pic' => 'Dewi Sartika', 'telepon' => '0813-8899-1122', 'email' => 'order@sumbermakmur.com', 'kota' => 'Tangerang', 'alamat' => 'Jl. Daan Mogot KM 18 Pergudangan Era Prima', 'status' => 'Aktif'],
                ['id' => 3, 'kode' => 'SPL-003', 'nama' => 'PT Surya Delta Chemika', 'pic' => 'Hendro Wijaya', 'telepon' => '0821-7766-3344', 'email' => 'hendro@suryadelta.co.id', 'kota' => 'Bekasi', 'alamat' => 'Kawasan MM2100 Cikarang Barat', 'status' => 'Aktif'],
                ['id' => 4, 'kode' => 'SPL-004', 'nama' => 'UD Sejahtera Logistik Pack', 'pic' => 'Agus Pratama', 'telepon' => '0811-2233-4455', 'email' => 'agus@sejahterapack.id', 'kota' => 'Surabaya', 'alamat' => 'Rungkut Industri Raya No 55', 'status' => 'Aktif'],
            ],
            'divisions' => [
                ['id' => 1, 'kode' => 'DIV-IT', 'nama' => 'Teknologi Informasi & Infrastruktur', 'kepala' => 'Rian Kurniawan, S.Kom', 'total_permintaan' => 142, 'keterangan' => 'Peralatan kantor IT, kabel jaringan, perlengkapan server', 'status' => 'Aktif'],
                ['id' => 2, 'kode' => 'DIV-OPS', 'nama' => 'Operasional & Warehouse', 'kepala' => 'Siti Nurhaliza', 'total_permintaan' => 456, 'keterangan' => 'Kebutuhan lakban, stretch film, APD gudang', 'status' => 'Aktif'],
                ['id' => 3, 'kode' => 'DIV-PROD', 'nama' => 'Produksi & Maintenance Mesin', 'kepala' => 'Ir. Hartono', 'total_permintaan' => 289, 'keterangan' => 'Sparepart mesin pabrik, pelumas, bearing', 'status' => 'Aktif'],
                ['id' => 4, 'kode' => 'DIV-GA', 'nama' => 'General Affairs & HR', 'kepala' => 'Maya Anggraeni', 'total_permintaan' => 97, 'keterangan' => 'ATK seluruh divisi dan bahan kebersihan', 'status' => 'Aktif'],
                ['id' => 5, 'kode' => 'DIV-FIN', 'nama' => 'Keuangan & Akuntansi', 'kepala' => 'Budi Santoso, SE', 'total_permintaan' => 53, 'keterangan' => 'ATK, kertas faktur, binder arsip pajak', 'status' => 'Aktif'],
            ],
            'items' => [
                [
                    'id' => 1,
                    'sku' => 'ELK-0010',
                    'barcode' => '899275300101',
                    'nama' => 'Barcode Scanner Wireless 2D Laser',
                    'kategori' => 'Elektronik & Hardware',
                    'satuan' => 'PCS',
                    'lokasi' => 'RAK-A1-02',
                    'stok' => 8,
                    'min_stok' => 5,
                    'harga_beli' => 750000,
                    'harga_jual' => 920000,
                    'status' => 'Aktif',
                    'img' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=150&auto=format&fit=crop&q=80'
                ],
                [
                    'id' => 2,
                    'sku' => 'ATK-0004',
                    'barcode' => '899275300205',
                    'nama' => 'Kertas HVS PaperOne A4 80gr',
                    'kategori' => 'Alat Tulis Kantor (ATK)',
                    'satuan' => 'RIM',
                    'lokasi' => 'RAK-A1-01',
                    'stok' => 3,
                    'min_stok' => 10,
                    'harga_beli' => 48000,
                    'harga_jual' => 55000,
                    'status' => 'Stok Kritis',
                    'img' => 'https://images.unsplash.com/photo-1589330694653-dad6bc01cf0e?w=150&auto=format&fit=crop&q=80'
                ],
                [
                    'id' => 3,
                    'sku' => 'LOG-0012',
                    'barcode' => '899275300331',
                    'nama' => 'Stretch Film Plastik Wrapping 50cm x 200m',
                    'kategori' => 'Packaging & Logistik',
                    'satuan' => 'ROLL',
                    'lokasi' => 'RAK-B2-01',
                    'stok' => 45,
                    'min_stok' => 15,
                    'harga_beli' => 62000,
                    'harga_jual' => 75000,
                    'status' => 'Aktif',
                    'img' => 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?w=150&auto=format&fit=crop&q=80'
                ],
                [
                    'id' => 4,
                    'sku' => 'ENG-0088',
                    'barcode' => '899275300449',
                    'nama' => 'Ball Bearing SKF 6205-2RSH C3',
                    'kategori' => 'Sparepart Mesin Pabrik',
                    'satuan' => 'PCS',
                    'lokasi' => 'RAK-A1-02',
                    'stok' => 2,
                    'min_stok' => 6,
                    'harga_beli' => 110000,
                    'harga_jual' => 135000,
                    'status' => 'Stok Kritis',
                    'img' => 'https://images.unsplash.com/photo-1530124566582-a618bc2615dc?w=150&auto=format&fit=crop&q=80'
                ],
                [
                    'id' => 5,
                    'sku' => 'CHM-0003',
                    'barcode' => '899275300552',
                    'nama' => 'WD-40 Multi-Use Lubricant Spray 412ml',
                    'kategori' => 'Chemical & Cleaning',
                    'satuan' => 'PCS',
                    'lokasi' => 'RAK-C1-03',
                    'stok' => 24,
                    'min_stok' => 8,
                    'harga_beli' => 68000,
                    'harga_jual' => 82000,
                    'status' => 'Aktif',
                    'img' => 'https://images.unsplash.com/photo-1628177142898-93e36e4e3a50?w=150&auto=format&fit=crop&q=80'
                ],
                [
                    'id' => 6,
                    'sku' => 'LOG-0007',
                    'barcode' => '899275300667',
                    'nama' => 'Lakban Coklat Daimaru 2 Inch 100 Yard',
                    'kategori' => 'Packaging & Logistik',
                    'satuan' => 'ROLL',
                    'lokasi' => 'RAK-B2-01',
                    'stok' => 120,
                    'min_stok' => 30,
                    'harga_beli' => 12500,
                    'harga_jual' => 15000,
                    'status' => 'Aktif',
                    'img' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=150&auto=format&fit=crop&q=80'
                ]
            ]
        ];
    }

    public function barang()
    {
        $data = $this->getCommonData();
        return view('master-data.barang', [
            'active_sub' => 'barang',
            'items' => $data['items'],
            'categories' => $data['categories'],
            'units' => $data['units'],
            'locations' => $data['locations']
        ]);
    }

    public function kategori()
    {
        $data = $this->getCommonData();
        return view('master-data.kategori', [
            'active_sub' => 'kategori',
            'categories' => $data['categories']
        ]);
    }

    public function satuan()
    {
        $data = $this->getCommonData();
        return view('master-data.satuan', [
            'active_sub' => 'satuan',
            'units' => $data['units']
        ]);
    }

    public function lokasi()
    {
        $data = $this->getCommonData();
        return view('master-data.lokasi', [
            'active_sub' => 'lokasi',
            'locations' => $data['locations']
        ]);
    }

    public function supplier()
    {
        $data = $this->getCommonData();
        return view('master-data.supplier', [
            'active_sub' => 'supplier',
            'suppliers' => $data['suppliers']
        ]);
    }

    public function divisi()
    {
        $data = $this->getCommonData();
        return view('master-data.divisi', [
            'active_sub' => 'divisi',
            'divisions' => $data['divisions']
        ]);
    }
}
