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

# =====================================================================
# REGISTER CONTROLLER - Student Registration Onboarding
# =====================================================================
# Handles student registration and profile creation
# Creates both User and StudentProfile records in single transaction
# Validates academic information (faculty, department, NIM)
# Auto-logs in user after successful registration
#
# Methods:
# - showRegistrationForm() - Display registration form with dropdowns
# - register() - Process registration with validation
#
# Features:
# - Faculty and department selection
# - NIM (Student ID) uniqueness validation
# - Email uniqueness validation
# - Auto email verification (for now)
# - Atomic transaction (both user and profile created or rolled back)
# - Auto login after registration
# - Automatic semester 1 assignment
#
# Validation:
# - name: required, max 255
# - email: required, unique, valid email
# - phone: optional
# - password: required, min 8, confirmed
# - nim: required, unique (per student)
# - faculty_id: must exist in faculties
# - department_id: must exist in departments
# - year_of_entry: 2000-current year
#
# Security:
# - Password hashed with bcrypt
# - Database transaction for atomicity
# - Unique email and NIM per student

class RegisterController extends Controller
{
    # =========== DISPLAY REGISTRATION FORM ===========
    # Show registration form with faculty/department dropdowns
    #
    # Data Loaded:
    # - Active faculties for faculty dropdown
    # - Active departments for department dropdown
    #
    # Workflow:
    # 1. Query Faculty::active() - only active faculties
    # 2. Query Department::active() - only active departments
    # 3. Pass to view via compact()
    # 4. Return registration form view
    #
    # Returns: View - auth.register with faculties & departments
    /**
     * Show registration form
     */
    public function showRegistrationForm()
    {
        # Get all active faculties for dropdown
        # active() scope: is_active=true
        $faculties = Faculty::active()->get();
        
        # Get all active departments for dropdown
        # active() scope: is_active=true
        $departments = Department::active()->get();

        # Return registration view with dropdown data
        return view('auth.register', compact('faculties', 'departments'));
    }

    # =========== PROCESS REGISTRATION ===========
    # Handle student registration with validation
    #
    # Validation Rules:
    # - name: required, string, max 255
    # - email: required, unique in users table
    # - phone: optional, max 20
    # - password: min 8 chars, must match confirmation
    # - nim: required, unique per student
    # - faculty_id: must exist in faculties table
    # - department_id: must exist in departments table
    # - year_of_entry: 2000-current year
    #
    # Workflow:
    # 1. Validate all input data
    # 2. Begin database transaction
    # 3. Create User record:
    #    - Hash password with bcrypt
    #    - Set role to 'student'
    #    - Mark is_active=true
    #    - Auto-verify email for now
    # 4. Create StudentProfile record:
    #    - Link to new user
    #    - Set initial semester=1
    #    - Status='active'
    # 5. Commit transaction
    # 6. Auto-login created user
    # 7. Redirect to student dashboard
    #
    # If validation fails:
    # - Return with validation errors
    # - Keep input for re-submission
    #
    # If creation fails:
    # - Rollback transaction (atomic)
    # - Return error message with exception details
    #
    # Returns: RedirectResponse to student dashboard or back with errors
    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        # Validate all registration input
        # Rule::unique() ensures no duplicate emails
        # exists rules validate foreign keys exist
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

        # Start database transaction
        # If any step fails, entire transaction rolled back
        # Ensures both User and StudentProfile created together or not at all
        DB::beginTransaction();
        try {
            # Create User record
            # Hash::make() hashes password with bcrypt algorithm
            # role='student': All new registrations are students
            # is_active=true: Account active immediately
            # email_verified_at=now(): Auto-verify (TODO: should use email verification)
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'role' => 'student',
                'is_active' => true,
                'email_verified_at' => now(), # Auto verify for now
            ]);

            # Create StudentProfile record
            # Links academic info to user account
            # semester=1: Always start in first semester
            # status='active': Student is active/enrolled
            StudentProfile::create([
                'user_id' => $user->id,
                'nim' => $validated['nim'],
                'faculty_id' => $validated['faculty_id'],
                'department_id' => $validated['department_id'],
                'semester' => 1,
                'year_of_entry' => $validated['year_of_entry'],
                'status' => 'active',
            ]);

            # Commit transaction - all changes saved
            DB::commit();

            # Auto-login user immediately after registration
            # Sets auth session for new student
            Auth::login($user);

            # Redirect to student dashboard with success message
            return redirect()->route('student.dashboard')
                ->with('success', 'Registrasi berhasil! Selamat datang di Lapor Mahasiswa.');

        } catch (\Exception $e) {
            # If any error occurs, rollback transaction
            # Ensures no orphaned records created
            DB::rollBack();
            
            # Return with error message and keep form input
            return back()->with('error', 'Registrasi gagal: ' . $e->getMessage())->withInput();
        }
    }
}