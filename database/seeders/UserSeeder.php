<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@university.ac.id',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'role' => 'super_admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Admin Units
        $admins = [
            ['name' => 'Admin Fasilitas', 'email' => 'fasilitas@university.ac.id', 'phone' => '081234567891'],
            ['name' => 'Admin Akademik', 'email' => 'akademik@university.ac.id', 'phone' => '081234567892'],
            ['name' => 'Admin Kemahasiswaan', 'email' => 'kemahasiswaan@university.ac.id', 'phone' => '081234567893'],
            ['name' => 'Admin IT', 'email' => 'it@university.ac.id', 'phone' => '081234567894'],
        ];

        foreach ($admins as $admin) {
            User::create([
                'name' => $admin['name'],
                'email' => $admin['email'],
                'password' => Hash::make('password'),
                'phone' => $admin['phone'],
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
        }

        // Sample Students
        $students = [
            ['name' => 'Budi Santoso', 'email' => 'budi.santoso@student.university.ac.id', 'phone' => '081298765432'],
            ['name' => 'Siti Nurhaliza', 'email' => 'siti.nurhaliza@student.university.ac.id', 'phone' => '081298765433'],
            ['name' => 'Ahmad Fauzi', 'email' => 'ahmad.fauzi@student.university.ac.id', 'phone' => '081298765434'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi.lestari@student.university.ac.id', 'phone' => '081298765435'],
            ['name' => 'Rudi Hermawan', 'email' => 'rudi.hermawan@student.university.ac.id', 'phone' => '081298765436'],
            ['name' => 'Rina Wijayanti', 'email' => 'rina.wijayanti@student.university.ac.id', 'phone' => '081298765437'],
            ['name' => 'Andi Pratama', 'email' => 'andi.pratama@student.university.ac.id', 'phone' => '081298765438'],
            ['name' => 'Maya Sari', 'email' => 'maya.sari@student.university.ac.id', 'phone' => '081298765439'],
            ['name' => 'Doni Saputra', 'email' => 'doni.saputra@student.university.ac.id', 'phone' => '081298765440'],
            ['name' => 'Lisa Anggraini', 'email' => 'lisa.anggraini@student.university.ac.id', 'phone' => '081298765441'],
        ];

        foreach ($students as $student) {
            User::create([
                'name' => $student['name'],
                'email' => $student['email'],
                'password' => Hash::make('password'),
                'phone' => $student['phone'],
                'role' => 'student',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
        }

        $this->command->info('✅ User data seeded successfully!');
        $this->command->info('📧 Login credentials:');
        $this->command->info('   Super Admin: admin@university.ac.id / password');
        $this->command->info('   Admin: fasilitas@university.ac.id / password');
        $this->command->info('   Student: siti.nurhaliza@student.university.ac.id / password');
    }
}