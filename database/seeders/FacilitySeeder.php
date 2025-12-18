<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;
use App\Models\Building;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $gta = Building::where('code', 'GTA')->first();
        $gtb = Building::where('code', 'GTB')->first();
        $gtc = Building::where('code', 'GTC')->first();
        $lib = Building::where('code', 'LIB')->first();
        $gor = Building::where('code', 'GOR')->first();
        $sc = Building::where('code', 'SC')->first();

        $facilities = [
            // Gedung Teknik A (Informatika & Sistem Informasi)
            [
                'building_id' => $gta->id,
                'name' => 'Ruang Kelas A101',
                'code' => 'A101',
                'type' => 'classroom',
                'floor' => 1,
                'capacity' => 40,
                'is_active' => true,
            ],
            [
                'building_id' => $gta->id,
                'name' => 'Ruang Kelas A102',
                'code' => 'A102',
                'type' => 'classroom',
                'floor' => 1,
                'capacity' => 40,
                'is_active' => true,
            ],
            [
                'building_id' => $gta->id,
                'name' => 'Lab Komputer 1',
                'code' => 'LAB-A201',
                'type' => 'lab',
                'floor' => 2,
                'capacity' => 35,
                'is_active' => true,
            ],
            [
                'building_id' => $gta->id,
                'name' => 'Lab Komputer 2',
                'code' => 'LAB-A202',
                'type' => 'lab',
                'floor' => 2,
                'capacity' => 35,
                'is_active' => true,
            ],
            [
                'building_id' => $gta->id,
                'name' => 'Lab Jaringan Komputer',
                'code' => 'LAB-A301',
                'type' => 'lab',
                'floor' => 3,
                'capacity' => 30,
                'is_active' => true,
            ],
            [
                'building_id' => $gta->id,
                'name' => 'Lab Multimedia',
                'code' => 'LAB-A302',
                'type' => 'lab',
                'floor' => 3,
                'capacity' => 25,
                'is_active' => true,
            ],
            [
                'building_id' => $gta->id,
                'name' => 'Lab Pemrograman',
                'code' => 'LAB-A401',
                'type' => 'lab',
                'floor' => 4,
                'capacity' => 30,
                'is_active' => true,
            ],
            [
                'building_id' => $gta->id,
                'name' => 'Toilet Lantai 1 Pria',
                'code' => 'WC-A1-M',
                'type' => 'toilet',
                'floor' => 1,
                'capacity' => null,
                'is_active' => true,
            ],
            [
                'building_id' => $gta->id,
                'name' => 'Toilet Lantai 1 Wanita',
                'code' => 'WC-A1-F',
                'type' => 'toilet',
                'floor' => 1,
                'capacity' => null,
                'is_active' => true,
            ],
            [
                'building_id' => $gta->id,
                'name' => 'Kantin Gedung A',
                'code' => 'KANT-A',
                'type' => 'canteen',
                'floor' => 1,
                'capacity' => 60,
                'is_active' => true,
            ],

            // Gedung Teknik B (Teknik Sipil & Arsitektur)
            [
                'building_id' => $gtb->id,
                'name' => 'Ruang Kelas B101',
                'code' => 'B101',
                'type' => 'classroom',
                'floor' => 1,
                'capacity' => 45,
                'is_active' => true,
            ],
            [
                'building_id' => $gtb->id,
                'name' => 'Ruang Kelas B102',
                'code' => 'B102',
                'type' => 'classroom',
                'floor' => 1,
                'capacity' => 45,
                'is_active' => true,
            ],
            [
                'building_id' => $gtb->id,
                'name' => 'Studio Arsitektur 1',
                'code' => 'STD-B201',
                'type' => 'lab',
                'floor' => 2,
                'capacity' => 30,
                'is_active' => true,
            ],
            [
                'building_id' => $gtb->id,
                'name' => 'Studio Arsitektur 2',
                'code' => 'STD-B202',
                'type' => 'lab',
                'floor' => 2,
                'capacity' => 30,
                'is_active' => true,
            ],
            [
                'building_id' => $gtb->id,
                'name' => 'Lab Struktur & Material',
                'code' => 'LAB-B301',
                'type' => 'lab',
                'floor' => 3,
                'capacity' => 25,
                'is_active' => true,
            ],
            [
                'building_id' => $gtb->id,
                'name' => 'Toilet Lantai 1',
                'code' => 'WC-B1',
                'type' => 'toilet',
                'floor' => 1,
                'capacity' => null,
                'is_active' => true,
            ],

            // Gedung Teknik C (Teknik Industri)
            [
                'building_id' => $gtc->id,
                'name' => 'Ruang Kelas C101',
                'code' => 'C101',
                'type' => 'classroom',
                'floor' => 1,
                'capacity' => 40,
                'is_active' => true,
            ],
            [
                'building_id' => $gtc->id,
                'name' => 'Lab Sistem Produksi',
                'code' => 'LAB-C201',
                'type' => 'lab',
                'floor' => 2,
                'capacity' => 30,
                'is_active' => true,
            ],
            [
                'building_id' => $gtc->id,
                'name' => 'Lab Ergonomi',
                'code' => 'LAB-C202',
                'type' => 'lab',
                'floor' => 2,
                'capacity' => 25,
                'is_active' => true,
            ],
            [
                'building_id' => $gtc->id,
                'name' => 'Toilet Lantai 1',
                'code' => 'WC-C1',
                'type' => 'toilet',
                'floor' => 1,
                'capacity' => null,
                'is_active' => true,
            ],

            // Perpustakaan Facilities
            [
                'building_id' => $lib->id,
                'name' => 'Ruang Baca Utama',
                'code' => 'LIB-READ1',
                'type' => 'library',
                'floor' => 2,
                'capacity' => 150,
                'is_active' => true,
            ],
            [
                'building_id' => $lib->id,
                'name' => 'Ruang Diskusi 1',
                'code' => 'LIB-DISC1',
                'type' => 'library',
                'floor' => 3,
                'capacity' => 10,
                'is_active' => true,
            ],
            [
                'building_id' => $lib->id,
                'name' => 'Ruang Diskusi 2',
                'code' => 'LIB-DISC2',
                'type' => 'library',
                'floor' => 3,
                'capacity' => 10,
                'is_active' => true,
            ],
            [
                'building_id' => $lib->id,
                'name' => 'Ruang Komputer Perpustakaan',
                'code' => 'LIB-COMP',
                'type' => 'library',
                'floor' => 2,
                'capacity' => 20,
                'is_active' => true,
            ],

            // Gedung Olahraga
            [
                'building_id' => $gor->id,
                'name' => 'Lapangan Indoor',
                'code' => 'GOR-INDOOR',
                'type' => 'sport_facility',
                'floor' => 1,
                'capacity' => 200,
                'is_active' => true,
            ],
            [
                'building_id' => $gor->id,
                'name' => 'Fitness Center',
                'code' => 'GOR-FIT',
                'type' => 'sport_facility',
                'floor' => 2,
                'capacity' => 30,
                'is_active' => true,
            ],

            // Student Center
            [
                'building_id' => $sc->id,
                'name' => 'Ruang BEM',
                'code' => 'SC-BEM',
                'type' => 'office',
                'floor' => 2,
                'capacity' => 20,
                'is_active' => true,
            ],
            [
                'building_id' => $sc->id,
                'name' => 'Kantin Student Center',
                'code' => 'SC-KANT',
                'type' => 'canteen',
                'floor' => 1,
                'capacity' => 100,
                'is_active' => true,
            ],
            [
                'building_id' => $sc->id,
                'name' => 'Ruang Serbaguna',
                'code' => 'SC-MULTI',
                'type' => 'other',
                'floor' => 3,
                'capacity' => 300,
                'is_active' => true,
            ],
        ];

        foreach ($facilities as $facility) {
            Facility:: create($facility);
        }

        $this->command->info('✅ Facilities created successfully! ');
    }
}