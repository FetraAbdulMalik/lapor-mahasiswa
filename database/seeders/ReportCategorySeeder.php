<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReportCategory;

class ReportCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Akademik',
                'slug' => 'akademik',
                'description' => 'Masalah terkait perkuliahan, dosen, KRS/KHS, jadwal, nilai, ujian, dan tugas',
                'icon' => '📚',
                'color' => '#3B82F6',
                'department_handle' => 'Unit Akademik',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Fasilitas Kampus',
                'slug' => 'fasilitas-kampus',
                'description' => 'Kerusakan atau masalah pada fasilitas seperti ruang kelas, lab, perpustakaan, toilet, wifi, parkir, dll',
                'icon' => '🏢',
                'color' => '#10B981',
                'department_handle' => 'Unit Sarana & Prasarana',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Administrasi',
                'slug' => 'administrasi',
                'description' => 'Masalah pembayaran UKT, surat keterangan, transkrip, legalisir, ijazah, kartu mahasiswa',
                'icon' => '📋',
                'color' => '#F59E0B',
                'department_handle' => 'Unit Administrasi Akademik',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Kemahasiswaan',
                'slug' => 'kemahasiswaan',
                'description' => 'Organisasi mahasiswa, beasiswa, kegiatan kampus, UKM (Unit Kegiatan Mahasiswa)',
                'icon' => '👥',
                'color' => '#8B5CF6',
                'department_handle' => 'Unit Kemahasiswaan',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Layanan Kampus',
                'slug' => 'layanan-kampus',
                'description' => 'Keamanan, kebersihan, kesehatan (klinik kampus), konseling mahasiswa',
                'icon' => '🛎️',
                'color' => '#06B6D4',
                'department_handle' => 'Unit Layanan Umum',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Infrastruktur',
                'slug' => 'infrastruktur',
                'description' => 'Jalan/akses kampus, lampu penerangan, drainase, kondisi bangunan',
                'icon' => '🏗️',
                'color' => '#EF4444',
                'department_handle' => 'Unit Infrastruktur',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Bullying & Harassment',
                'slug' => 'bullying-harassment',
                'description' => 'Laporan terkait bullying, pelecehan, diskriminasi (dijamin kerahasiaan dan ditangani profesional)',
                'icon' => '🚨',
                'color' => '#DC2626',
                'department_handle' => 'Unit Konseling & Hukum',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Teknologi Informasi',
                'slug' => 'teknologi-informasi',
                'description' => 'Masalah portal akademik, email kampus, wifi, sistem informasi, website kampus',
                'icon' => '💻',
                'color' => '#6366F1',
                'department_handle' => 'Unit IT',
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Saran & Kritik',
                'slug' => 'saran-kritik',
                'description' => 'Saran, kritik, dan masukan konstruktif untuk peningkatan kualitas kampus',
                'icon' => '💡',
                'color' => '#14B8A6',
                'department_handle' => 'Rektorat',
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'Lainnya',
                'slug' => 'lainnya',
                'description' => 'Masalah lain yang tidak termasuk kategori di atas',
                'icon' => '📌',
                'color' => '#64748B',
                'department_handle' => 'Unit Umum',
                'is_active' => true,
                'sort_order' => 10,
            ],
        ];

        foreach ($categories as $category) {
            ReportCategory::create($category);
        }

        $this->command->info('✅ Report Category data seeded successfully!');
    }
}