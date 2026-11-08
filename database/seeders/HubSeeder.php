<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Hub;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding Hubs...');

        // Get or create cities first
        $cities = $this->getOrCreateCities();

        // Seed Jakarta Hubs
        $this->seedJakartaHubs($cities['jakarta']);

        // Seed Bandung Hubs
        $this->seedBandungHubs($cities['bandung']);

        // Seed Surabaya Hubs
        $this->seedSurabayaHubs($cities['surabaya']);

        // Seed Semarang Hubs
        $this->seedSemarangHubs($cities['semarang']);

        // Seed Medan Hubs
        $this->seedMedanHubs($cities['medan']);

        // Seed Makassar Hubs
        $this->seedMakassarHubs($cities['makassar']);

        // Seed Denpasar Hubs
        $this->seedDenpassarHubs($cities['denpasar']);

        $totalHubs = Hub::count();
        $this->command->info("✓ Total {$totalHubs} Hubs seeded successfully!");
    }

    private function getOrCreateCities(): array
    {
        return [
            'jakarta' => City::firstOrCreate(
                ['name' => 'DKI Jakarta'],
                [
                    'region' => 'DKI Jakarta',
                    'status' => 'active',
                    'active_hubs_count' => 0,
                    'areas' => ['Cakung', 'Halim', 'Pluit', 'Cengkareng'],
                ]
            ),
            'bandung' => City::firstOrCreate(
                ['name' => 'Kota Bandung'],
                [
                    'region' => 'Jawa Barat',
                    'status' => 'active',
                    'active_hubs_count' => 0,
                    'areas' => ['Soekarno Hatta', 'Pasteur', 'Gedebage'],
                ]
            ),
            'surabaya' => City::firstOrCreate(
                ['name' => 'Kota Surabaya'],
                [
                    'region' => 'Jawa Timur',
                    'status' => 'active',
                    'active_hubs_count' => 0,
                    'areas' => ['Rungkut', 'Tanjung Perak', 'Waru'],
                ]
            ),
            'semarang' => City::firstOrCreate(
                ['name' => 'Kota Semarang'],
                [
                    'region' => 'Jawa Tengah',
                    'status' => 'active',
                    'active_hubs_count' => 0,
                    'areas' => ['Tanjung Mas', 'Genuk'],
                ]
            ),
            'medan' => City::firstOrCreate(
                ['name' => 'Kota Medan'],
                [
                    'region' => 'Sumatera Utara',
                    'status' => 'active',
                    'active_hubs_count' => 0,
                    'areas' => ['Belawan', 'Amplas'],
                ]
            ),
            'makassar' => City::firstOrCreate(
                ['name' => 'Kota Makassar'],
                [
                    'region' => 'Sulawesi Selatan',
                    'status' => 'active',
                    'active_hubs_count' => 0,
                    'areas' => ['Daya', 'Parangloe'],
                ]
            ),
            'denpasar' => City::firstOrCreate(
                ['name' => 'Kota Denpasar'],
                [
                    'region' => 'Bali',
                    'status' => 'active',
                    'active_hubs_count' => 0,
                    'areas' => ['Sanur', 'Ngurah Rai'],
                ]
            ),
        ];
    }

    private function seedJakartaHubs($city): void
    {
        $hubs = [
            [
                'code' => 'HUB-JKT-01',
                'name' => 'Hub Cakung DC-01',
                'category' => 'Pusat Distribusi Utama',
                'address' => 'Jl. Raya Cakung Cilincing No.1, Cakung Timur, Jakarta Timur',
                'capacity' => 12,
                'occupancy' => 88,
                'area' => 'Cakung',
                'status' => 'active',
            ],
            [
                'code' => 'HUB-JKT-02',
                'name' => 'Hub Halim DC-02',
                'category' => 'Logistik Transit Udara',
                'address' => 'Kawasan Bandara Halim Perdanakusuma, Jakarta Timur',
                'capacity' => 8,
                'occupancy' => 72,
                'area' => 'Halim',
                'status' => 'active',
            ],
            [
                'code' => 'HUB-JKT-03',
                'name' => 'Hub Pluit DC-03',
                'category' => 'Fulfillment Maritim & Komersial',
                'address' => 'Jl. Pluit Karang Timur, dekat Pelabuhan Tanjung Priok, Jakarta Utara',
                'capacity' => 6,
                'occupancy' => 65,
                'area' => 'Pluit',
                'status' => 'active',
            ],
            [
                'code' => 'HUB-JKT-04',
                'name' => 'Hub Cengkareng DC-04',
                'category' => 'Ekspedisi Kargo Cepat',
                'address' => 'Kawasan Bandara Soekarno-Hatta, Cengkareng, Tangerang',
                'capacity' => 7,
                'occupancy' => 80,
                'area' => 'Cengkareng',
                'status' => 'active',
            ],
        ];

        foreach ($hubs as $hub) {
            Hub::updateOrCreate(
                ['code' => $hub['code']],
                array_merge($hub, ['city_id' => $city->id])
            );
        }

        $this->command->info('  ✓ Jakarta Hubs seeded');
    }

    private function seedBandungHubs($city): void
    {
        $hubs = [
            [
                'code' => 'HUB-BDG-01',
                'name' => 'Hub Soekarno Hatta DC-01',
                'category' => 'Distribusi Regional Jawa Barat',
                'address' => 'Jl. Soekarno Hatta No.200, Bandung',
                'capacity' => 10,
                'occupancy' => 75,
                'area' => 'Soekarno Hatta',
                'status' => 'active',
            ],
            [
                'code' => 'HUB-BDG-02',
                'name' => 'Hub Pasteur DC-02',
                'category' => 'Logistik Komersial',
                'address' => 'Jl. Dr. Djunjunan (Pasteur), Bandung',
                'capacity' => 8,
                'occupancy' => 68,
                'area' => 'Pasteur',
                'status' => 'active',
            ],
            [
                'code' => 'HUB-BDG-03',
                'name' => 'Hub Gedebage DC-03',
                'category' => 'Transit Kereta Api',
                'address' => 'Kawasan Stasiun Kereta Api Gedebage, Bandung',
                'capacity' => 6,
                'occupancy' => 55,
                'area' => 'Gedebage',
                'status' => 'active',
            ],
        ];

        foreach ($hubs as $hub) {
            Hub::updateOrCreate(
                ['code' => $hub['code']],
                array_merge($hub, ['city_id' => $city->id])
            );
        }

        $this->command->info('  ✓ Bandung Hubs seeded');
    }

    private function seedSurabayaHubs($city): void
    {
        $hubs = [
            [
                'code' => 'HUB-SBY-01',
                'name' => 'Hub Rungkut DC-01',
                'category' => 'Pusat Distribusi Jawa Timur',
                'address' => 'Jl. Rungkut Industri III, Surabaya',
                'capacity' => 11,
                'occupancy' => 82,
                'area' => 'Rungkut',
                'status' => 'active',
            ],
            [
                'code' => 'HUB-SBY-02',
                'name' => 'Hub Tanjung Perak DC-02',
                'category' => 'Logistik Pelabuhan & Maritim',
                'address' => 'Kawasan Pelabuhan Tanjung Perak, Surabaya',
                'capacity' => 9,
                'occupancy' => 78,
                'area' => 'Tanjung Perak',
                'status' => 'active',
            ],
            [
                'code' => 'HUB-SBY-03',
                'name' => 'Hub Waru DC-03',
                'category' => 'Fulfillment E-Commerce',
                'address' => 'Jl. Raya Waru, Sidoarjo',
                'capacity' => 7,
                'occupancy' => 70,
                'area' => 'Waru',
                'status' => 'active',
            ],
        ];

        foreach ($hubs as $hub) {
            Hub::updateOrCreate(
                ['code' => $hub['code']],
                array_merge($hub, ['city_id' => $city->id])
            );
        }

        $this->command->info('  ✓ Surabaya Hubs seeded');
    }

    private function seedSemarangHubs($city): void
    {
        $hubs = [
            [
                'code' => 'HUB-SMG-01',
                'name' => 'Hub Tanjung Mas DC-01',
                'category' => 'Logistik Pelabuhan',
                'address' => 'Kawasan Pelabuhan Tanjung Mas, Semarang',
                'capacity' => 8,
                'occupancy' => 73,
                'area' => 'Tanjung Mas',
                'status' => 'active',
            ],
            [
                'code' => 'HUB-SMG-02',
                'name' => 'Hub Genuk DC-02',
                'category' => 'Distribusi Regional',
                'address' => 'Jl. Raya Semarang-Demak, Genuk, Semarang',
                'capacity' => 6,
                'occupancy' => 60,
                'area' => 'Genuk',
                'status' => 'active',
            ],
        ];

        foreach ($hubs as $hub) {
            Hub::updateOrCreate(
                ['code' => $hub['code']],
                array_merge($hub, ['city_id' => $city->id])
            );
        }

        $this->command->info('  ✓ Semarang Hubs seeded');
    }

    private function seedMedanHubs($city): void
    {
        $hubs = [
            [
                'code' => 'HUB-MDN-01',
                'name' => 'Hub Belawan DC-01',
                'category' => 'Logistik Pelabuhan Sumatera',
                'address' => 'Kawasan Pelabuhan Belawan, Medan',
                'capacity' => 9,
                'occupancy' => 76,
                'area' => 'Belawan',
                'status' => 'active',
            ],
            [
                'code' => 'HUB-MDN-02',
                'name' => 'Hub Amplas DC-02',
                'category' => 'Distribusi Sumatera Utara',
                'address' => 'Jl. Gatot Subroto, Amplas, Medan',
                'capacity' => 7,
                'occupancy' => 64,
                'area' => 'Amplas',
                'status' => 'active',
            ],
        ];

        foreach ($hubs as $hub) {
            Hub::updateOrCreate(
                ['code' => $hub['code']],
                array_merge($hub, ['city_id' => $city->id])
            );
        }

        $this->command->info('  ✓ Medan Hubs seeded');
    }

    private function seedMakassarHubs($city): void
    {
        $hubs = [
            [
                'code' => 'HUB-MKS-01',
                'name' => 'Hub Daya DC-01',
                'category' => 'Pusat Distribusi Sulawesi',
                'address' => 'Jl. Sultan Alauddin, Daya, Makassar',
                'capacity' => 8,
                'occupancy' => 71,
                'area' => 'Daya',
                'status' => 'active',
            ],
            [
                'code' => 'HUB-MKS-02',
                'name' => 'Hub Parangloe DC-02',
                'category' => 'Logistik Regional',
                'address' => 'Kawasan Industri Parangloe, Makassar',
                'capacity' => 6,
                'occupancy' => 58,
                'area' => 'Parangloe',
                'status' => 'active',
            ],
        ];

        foreach ($hubs as $hub) {
            Hub::updateOrCreate(
                ['code' => $hub['code']],
                array_merge($hub, ['city_id' => $city->id])
            );
        }

        $this->command->info('  ✓ Makassar Hubs seeded');
    }

    private function seedDenpassarHubs($city): void
    {
        $hubs = [
            [
                'code' => 'HUB-DPS-01',
                'name' => 'Hub Sanur DC-01',
                'category' => 'Distribusi Pariwisata & Retail',
                'address' => 'Jl. By Pass Ngurah Rai, Sanur, Denpasar',
                'capacity' => 5,
                'occupancy' => 62,
                'area' => 'Sanur',
                'status' => 'active',
            ],
            [
                'code' => 'HUB-DPS-02',
                'name' => 'Hub Ngurah Rai DC-02',
                'category' => 'Logistik Bandara',
                'address' => 'Kawasan Bandara I Gusti Ngurah Rai, Bali',
                'capacity' => 4,
                'occupancy' => 55,
                'area' => 'Ngurah Rai',
                'status' => 'active',
            ],
        ];

        foreach ($hubs as $hub) {
            Hub::updateOrCreate(
                ['code' => $hub['code']],
                array_merge($hub, ['city_id' => $city->id])
            );
        }

        $this->command->info('  ✓ Denpasar Hubs seeded');
    }
}
