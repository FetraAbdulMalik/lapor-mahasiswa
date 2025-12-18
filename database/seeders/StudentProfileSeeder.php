<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\Faculty;
use App\Models\Department;

class StudentProfileSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::where('role', 'student')->get();
        
        $ft = Faculty::where('code', 'FT')->first();
        
        $ti = Department::where('code', 'TI')->first();
        $tin = Department::where('code', 'TIN')->first();
        $si = Department::where('code', 'SI')->first();
        $ts = Department::where('code', 'TS')->first();
        $ars = Department::where('code', 'ARS')->first();

        $profiles = [
            ['nim' => '11220001', 'faculty_id' => $ft->id, 'department_id' => $ti->id, 'semester' => 5, 'year_of_entry' => 2022, 'status' => 'active'],
            ['nim' => '11230002', 'faculty_id' => $ft->id, 'department_id' => $si->id, 'semester' => 3, 'year_of_entry' => 2023, 'status' => 'active'],
            ['nim' => '11210003', 'faculty_id' => $ft->id, 'department_id' => $ti->id, 'semester' => 7, 'year_of_entry' => 2021, 'status' => 'active'],
            ['nim' => '11220004', 'faculty_id' => $ft->id, 'department_id' => $tin->id, 'semester' => 5, 'year_of_entry' => 2022, 'status' => 'active'],
            ['nim' => '11240005', 'faculty_id' => $ft->id, 'department_id' => $ts->id, 'semester' => 1, 'year_of_entry' => 2024, 'status' => 'active'],
            ['nim' => '11220006', 'faculty_id' => $ft->id, 'department_id' => $ars->id, 'semester' => 5, 'year_of_entry' => 2022, 'status' => 'active'],
            ['nim' => '11230007', 'faculty_id' => $ft->id, 'department_id' => $si->id, 'semester' => 3, 'year_of_entry' => 2023, 'status' => 'active'],
            ['nim' => '11220008', 'faculty_id' => $ft->id, 'department_id' => $tin->id, 'semester' => 5, 'year_of_entry' => 2022, 'status' => 'active'],
            ['nim' => '11230009', 'faculty_id' => $ft->id, 'department_id' => $ti->id, 'semester' => 3, 'year_of_entry' => 2023, 'status' => 'active'],
            ['nim' => '11220010', 'faculty_id' => $ft->id, 'department_id' => $ts->id, 'semester' => 5, 'year_of_entry' => 2022, 'status' => 'active'],
        ];

        foreach ($students as $index => $student) {
            if (isset($profiles[$index])) {
                StudentProfile::create(array_merge(
                    ['user_id' => $student->id],
                    $profiles[$index]
                ));
            }
        }

        $this->command->info('✅ Student Profiles created successfully!');
    }
}