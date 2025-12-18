<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database. 
     */
    public function run(): void
    {
        $this->call([
            FacultySeeder::class,
            DepartmentSeeder::class,
            BuildingSeeder::class,
            FacilitySeeder::class,
            ReportCategorySeeder::class,
            UserSeeder::class,
            StudentProfileSeeder::class,
            // ReportSeeder::class, // Optional:  uncomment untuk data laporan dummy
        ]);

        $this->command->info('✅ Semua data dummy berhasil di-seed!');
    }
}