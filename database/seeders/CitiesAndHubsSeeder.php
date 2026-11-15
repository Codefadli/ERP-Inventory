<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Hub;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitiesAndHubsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DKI Jakarta
        $jakarta = City::create([
            'name' => 'DKI Jakarta',
            'region' => 'DKI Jakarta',
            'status' => 'active',
            'active_hubs_count' => 4,
            'areas' => ['Cakung', 'Halim', 'Pluit', 'Cengkareng'],
        ]);

        Hub::create([
            'city_id' => $jakarta->id,
            'code' => 'HUB-JKT-01',
            'name' => 'Hub Cakung DC-01',
            'category' => 'Pusat Distribusi Utama',
            'address' => 'Jl. Raya Cakung Cilincing No.1, Cakung Timur, Jakarta Timur',
            'capacity' => 12,
            'occupancy' => 88,
            'area' => 'Cakung',
            'status' => 'active',
        ]);

        Hub::create([
            'city_id' => $jakarta->id,
            'code' => 'HUB-JKT-02',
            'name' => 'Hub Halim DC-02',
            'category' => 'Logistik Transit Udara',
            'address' => 'Kawasan Bandara Halim Perdanakusuma, Jakarta Timur',
            'capacity' => 8,
            'occupancy' => 72,
            'area' => 'Halim',
            'status' => 'active',
        ]);

        Hub::create([
            'city_id' => $jakarta->id,
            'code' => 'HUB-JKT-03',
            'name' => 'Hub Pluit DC-03',
            'category' => 'Fulfillment Maritim & Komersial',
            'address' => 'Jl. Pluit Karang Timur, dekat Pelabuhan Tanjung Priok, Jakarta Utara',
            'capacity' => 6,
            'occupancy' => 65,
            'area' => 'Pluit',
            'status' => 'active',
        ]);

        Hub::create([
            'city_id' => $jakarta->id,
            'code' => 'HUB-JKT-04',
            'name' => 'Hub Cengkareng DC-04',
            'category' => 'Ekspedisi Kargo Cepat',
            'address' => 'Kawasan Bandara Soekarno-Hatta, Cengkareng, Tangerang',
            'capacity' => 7,
            'occupancy' => 80,
            'area' => 'Cengkareng',
            'status' => 'active',
        ]);

        // Kota Bandung
        $bandung = City::create([
            'name' => 'Kota Bandung',
            'region' => 'Jawa Barat',
            'status' => 'active',
            'active_hubs_count' => 3,
            'areas' => ['Soekarno Hatta', 'Pasteur', 'Gedebage'],
        ]);

        Hub::create([
            'city_id' => $bandung->id,
            'code' => 'HUB-BDG-01',
            'name' => 'Hub Soekarno Hatta DC-01',
            'category' => 'Distribusi Regional Jawa Barat',
            'address' => 'Jl. Soekarno Hatta No.200, Bandung',
            'capacity' => 10,
            'occupancy' => 75,
            'area' => 'Soekarno Hatta',
            'status' => 'active',
        ]);

        Hub::create([
            'city_id' => $bandung->id,
            'code' => 'HUB-BDG-02',
            'name' => 'Hub Pasteur DC-02',
            'category' => 'Logistik Komersial',
            'address' => 'Jl. Dr. Djunjunan (Pasteur), Bandung',
            'capacity' => 8,
            'occupancy' => 68,
            'area' => 'Pasteur',
            'status' => 'active',
        ]);

        Hub::create([
            'city_id' => $bandung->id,
            'code' => 'HUB-BDG-03',
            'name' => 'Hub Gedebage DC-03',
            'category' => 'Transit Kereta Api',
            'address' => 'Kawasan Stasiun Kereta Api Gedebage, Bandung',
            'capacity' => 6,
            'occupancy' => 55,
            'area' => 'Gedebage',
            'status' => 'active',
        ]);

        // Kota Surabaya
        $surabaya = City::create([
            'name' => 'Kota Surabaya',
            'region' => 'Jawa Timur',
            'status' => 'active',
            'active_hubs_count' => 3,
            'areas' => ['Rungkut', 'Tanjung Perak', 'Waru'],
        ]);

        Hub::create([
            'city_id' => $surabaya->id,
            'code' => 'HUB-SBY-01',
            'name' => 'Hub Rungkut DC-01',
            'category' => 'Pusat Distribusi Jawa Timur',
            'address' => 'Jl. Rungkut Industri III, Surabaya',
            'capacity' => 11,
            'occupancy' => 82,
            'area' => 'Rungkut',
            'status' => 'active',
        ]);

        Hub::create([
            'city_id' => $surabaya->id,
            'code' => 'HUB-SBY-02',
            'name' => 'Hub Tanjung Perak DC-02',
            'category' => 'Logistik Pelabuhan & Maritim',
            'address' => 'Kawasan Pelabuhan Tanjung Perak, Surabaya',
            'capacity' => 9,
            'occupancy' => 78,
            'area' => 'Tanjung Perak',
            'status' => 'active',
        ]);

        Hub::create([
            'city_id' => $surabaya->id,
            'code' => 'HUB-SBY-03',
            'name' => 'Hub Waru DC-03',
            'category' => 'Fulfillment E-Commerce',
            'address' => 'Jl. Raya Waru, Sidoarjo',
            'capacity' => 7,
            'occupancy' => 70,
            'area' => 'Waru',
            'status' => 'active',
        ]);

        // Kota Semarang
        $semarang = City::create([
            'name' => 'Kota Semarang',
            'region' => 'Jawa Tengah',
            'status' => 'active',
            'active_hubs_count' => 2,
            'areas' => ['Tanjung Mas', 'Genuk'],
        ]);

        Hub::create([
            'city_id' => $semarang->id,
            'code' => 'HUB-SMG-01',
            'name' => 'Hub Tanjung Mas DC-01',
            'category' => 'Logistik Pelabuhan',
            'address' => 'Kawasan Pelabuhan Tanjung Mas, Semarang',
            'capacity' => 8,
            'occupancy' => 73,
            'area' => 'Tanjung Mas',
            'status' => 'active',
        ]);

        Hub::create([
            'city_id' => $semarang->id,
            'code' => 'HUB-SMG-02',
            'name' => 'Hub Genuk DC-02',
            'category' => 'Distribusi Regional',
            'address' => 'Jl. Raya Semarang-Demak, Genuk, Semarang',
            'capacity' => 6,
            'occupancy' => 60,
            'area' => 'Genuk',
            'status' => 'active',
        ]);

        // Kota Medan
        $medan = City::create([
            'name' => 'Kota Medan',
            'region' => 'Sumatera Utara',
            'status' => 'active',
            'active_hubs_count' => 2,
            'areas' => ['Belawan', 'Amplas'],
        ]);

        Hub::create([
            'city_id' => $medan->id,
            'code' => 'HUB-MDN-01',
            'name' => 'Hub Belawan DC-01',
            'category' => 'Logistik Pelabuhan Sumatera',
            'address' => 'Kawasan Pelabuhan Belawan, Medan',
            'capacity' => 9,
            'occupancy' => 76,
            'area' => 'Belawan',
            'status' => 'active',
        ]);

        Hub::create([
            'city_id' => $medan->id,
            'code' => 'HUB-MDN-02',
            'name' => 'Hub Amplas DC-02',
            'category' => 'Distribusi Sumatera Utara',
            'address' => 'Jl. Gatot Subroto, Amplas, Medan',
            'capacity' => 7,
            'occupancy' => 64,
            'area' => 'Amplas',
            'status' => 'active',
        ]);

        $this->command->info('✓ Cities and Hubs seeded successfully!');
    }
}
