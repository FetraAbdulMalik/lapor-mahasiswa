<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\Faculty;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegistrationForm()
    {
        $faculties = Faculty::active()->get();
        $departments = Department::active()->get();

        return view('auth.register', compact('faculties', 'departments'));
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'nim' => 'required|string|unique:student_profiles,nim',
            'faculty_id' => 'required|exists:faculties,id',
            'department_id' => 'required|exists:departments,id',
            'year_of_entry' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        DB::beginTransaction();
        try {
            // Create user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'role' => 'student',
                'is_active' => true,
                'email_verified_at' => now(), // Auto verify for now
            ]);

            // Create student profile
            StudentProfile::create([
                'user_id' => $user->id,
                'nim' => $validated['nim'],
                'faculty_id' => $validated['faculty_id'],
                'department_id' => $validated['department_id'],
                'semester' => 1,
                'year_of_entry' => $validated['year_of_entry'],
                'status' => 'active',
            ]);

            DB::commit();

            // Auto login
            Auth::login($user);

            return redirect()->route('student.dashboard')
                ->with('success', 'Registrasi berhasil! Selamat datang di Lapor Mahasiswa.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Registrasi gagal: ' . $e->getMessage())->withInput();
        }
    }
}