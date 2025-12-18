<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faculty;

class FacultySeeder extends Seeder
{
    public function run(): void
    {
        $faculty = [
            'name' => 'Fakultas Teknik',
            'code' => 'FT',
            'dean_name' => 'Dr. Ir. Budi Hartono, M.T',
            'email' => 'ft@university.ac.id',
            'phone' => '021-12345678',
            'description' => 'Fakultas Teknik dengan berbagai program studi teknik dan rekayasa',
            'is_active' => true,
        ];

        Faculty::create($faculty);

        $this->command->info('✅ Faculty Teknik created successfully!');
    }
}