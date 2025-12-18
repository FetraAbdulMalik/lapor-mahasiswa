<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Report;
use App\Models\User;
use App\Models\ReportCategory;
use App\Models\Building;
use App\Models\Facility;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::where('role', 'student')->get();
        $fasilitas = ReportCategory::where('slug', 'fasilitas-kampus')->first();
        $akademik = ReportCategory::where('slug', 'akademik')->first();
        $gta = Building::where('code', 'GTA')->first();
        $labKomputer = Facility::where('code', 'LAB-A201')->first();

        $reports = [
            [
                'user_id' => $students[0]->id,
                'category_id' => $fasilitas->id,
                'title' => 'AC Lab Komputer 1 Tidak Dingin',
                'description' => 'AC di Lab Komputer 1 (LAB-A201) Gedung Teknik A sudah tidak dingin sejak 3 hari yang lalu. Mahasiswa merasa kepanasan saat praktikum pemrograman.',
                'location' => 'Gedung Teknik A Lantai 2',
                'building_id' => $gta->id,
                'facility_id' => $labKomputer->id,
                'incident_date' => now()->subDays(3),
                'status' => 'in_progress',
                'priority' => 'high',
                'visibility' => 'public',
                'is_anonymous' => false,
            ],
            [
                'user_id' => $students[1]->id,
                'category_id' => $akademik->id,
                'title' => 'Dosen Tidak Hadir 3 Kali Berturut-turut',
                'description' => 'Dosen mata kuliah Basis Data tidak hadir selama 3 minggu berturut-turut tanpa pemberitahuan atau dosen pengganti.',
                'location' => 'Ruang A101',
                'building_id' => $gta->id,
                'facility_id' => null,
                'incident_date' => now()->subWeeks(1),
                'status' => 'in_review',
                'priority' => 'urgent',
                'visibility' => 'public',
                'is_anonymous' => false,
            ],
            [
                'user_id' => $students[2]->id,
                'category_id' => $fasilitas->id,
                'title' => 'Proyektor Rusak di Kelas A102',
                'description' => 'Proyektor di ruang kelas A102 mati total, tidak bisa menyala sama sekali. Ini mengganggu proses pembelajaran.',
                'location' => 'Gedung Teknik A Lantai 1',
                'building_id' => $gta->id,
                'facility_id' => null,
                'incident_date' => now()->subDays(1),
                'status' => 'pending',
                'priority' => 'medium',
                'visibility' => 'public',
                'is_anonymous' => false,
            ],
        ];

        foreach ($reports as $report) {
            Report::create($report);
        }

        $this->command->info('✅ Sample Reports created successfully!');
    }
}