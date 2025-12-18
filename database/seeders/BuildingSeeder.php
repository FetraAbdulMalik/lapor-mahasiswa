<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Building;
use App\Models\Faculty;

class BuildingSeeder extends Seeder
{
    public function run(): void
    {
        $ft = Faculty::where('code', 'FT')->first();

        $buildings = [
            [
                'name' => 'Gedung Teknik A',
                'code' => 'GTA',
                'faculty_id' => $ft->id,
                'address' => 'Kampus Utama, Jalan Raya Kampus No. 1',
                'floor_count' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Gedung Teknik B',
                'code' => 'GTB',
                'faculty_id' => $ft->id,
                'address' => 'Kampus Utama, Jalan Raya Kampus No. 2',
                'floor_count' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Gedung Teknik C',
                'code' => 'GTC',
                'faculty_id' => $ft->id,
                'address' => 'Kampus Utama, Jalan Raya Kampus No. 3',
                'floor_count' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Perpustakaan Pusat',
                'code' => 'LIB',
                'faculty_id' => null,
                'address' => 'Kampus Utama, Area Tengah',
                'floor_count' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Gedung Rektorat',
                'code' => 'REK',
                'faculty_id' => null,
                'address' => 'Kampus Utama, Area Depan',
                'floor_count' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Gedung Olahraga',
                'code' => 'GOR',
                'faculty_id' => null,
                'address' => 'Kampus Utama, Area Belakang',
                'floor_count' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Gedung Student Center',
                'code' => 'SC',
                'faculty_id' => null,
                'address' => 'Kampus Utama, Area Tengah',
                'floor_count' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Masjid Kampus',
                'code' => 'MSJ',
                'faculty_id' => null,
                'address' => 'Kampus Utama, Area Timur',
                'floor_count' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($buildings as $building) {
            Building::create($building);
        }

        $this->command->info('✅ Buildings created successfully!');
    }
}