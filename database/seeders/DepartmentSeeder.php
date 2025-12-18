<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Faculty;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $ft = Faculty::where('code', 'FT')->first();

        $departments = [
            [
                'faculty_id' => $ft->id,
                'name' => 'Teknik Informatika',
                'code' => 'TI',
                'head_of_department' => 'Dr. Agus Supriyanto, M. Kom',
                'email' => 'ti@university. ac.id',
                'is_active' => true,
            ],
            [
                'faculty_id' => $ft->id,
                'name' => 'Teknik Industri',
                'code' => 'TIN',
                'head_of_department' => 'Dr.  Ir. Dwi Susanto, M.T',
                'email' => 'tin@university.ac.id',
                'is_active' => true,
            ],
            [
                'faculty_id' => $ft->id,
                'name' => 'Sistem Informasi',
                'code' => 'SI',
                'head_of_department' => 'Dr. Rina Handayani, M.Kom',
                'email' => 'si@university.ac.id',
                'is_active' => true,
            ],
            [
                'faculty_id' => $ft->id,
                'name' => 'Teknik Sipil',
                'code' => 'TS',
                'head_of_department' => 'Dr.  Ir. Slamet Riyadi, M.T',
                'email' => 'ts@university.ac.id',
                'is_active' => true,
            ],
            [
                'faculty_id' => $ft->id,
                'name' => 'Arsitektur',
                'code' => 'ARS',
                'head_of_department' => 'Dr.  Ir. Maya Kusuma, M. Ars',
                'email' => 'ars@university.ac.id',
                'is_active' => true,
            ],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }

        $this->command->info('✅ 5 Departments (TI, TIN, SI, TS, ARS) created successfully! ');
    }
}