<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\Faculty;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

# ============================================================================
# StudentController - Student User Management
# ============================================================================
# Manages student accounts and academic profiles
# 
# Purpose: Create/manage student accounts with academic details (NIM, faculty, dept)
# Features: CRUD, search (name/email/NIM), department filtering, status management
# Use: Admin creates students, edits academic info, deactivates accounts
#

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(Request $request)
    {
        $query = User::students()
            ->with(['studentProfile.faculty', 'studentProfile.department']);

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('email', 'like', '%' . $request->input('search') . '%')
                  ->orWhereHas('studentProfile', function($q2) use ($request) {
                      $q2->where('nim', 'like', '%' .  $request->input('search') . '%');
                  });
            });
        }

        // Filter by department
        if ($request->filled('department')) {
            $query->whereHas('studentProfile', function($q) use ($request) {
                $q->where('department_id', $request->input('department'));
            });
        }

        $students = $query->paginate(20);
        $departments = Department::active()->get();

        return view('admin.students.index', compact('students', 'departments'));
    }

    /**
     * Display the specified student. 
     */
    public function show($id)
    {
        $student = User::students()
            ->with([
                'studentProfile.faculty',
                'studentProfile.department',
                'reports.category'
            ])
            ->findOrFail($id);

        // Student statistics
        $totalReports = $student->reports()->count();
        $resolvedReports = $student->reports()->resolved()->count();
        $pendingReports = $student->reports()->pending()->count();

        return view('admin.students.show', compact('student', 'totalReports', 'resolvedReports', 'pendingReports'));
    }

    /**
     * Show form to create student.
     */
    public function create()
    {
        $faculties = Faculty::active()->get();
        $departments = Department::active()->get();

        return view('admin.students.create', compact('faculties', 'departments'));
    }

    /**
     * Store new student.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
            'nim' => 'required|string|unique:student_profiles,nim',
            'faculty_id' => 'required|exists:faculties,id',
            'department_id' => 'required|exists:departments,id',
            'semester' => 'required|integer|min:1|max:14',
            'year_of_entry' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        DB::beginTransaction();
        try {
            // Create user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash:: make($validated['password']),
                'role' => 'student',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            // Create student profile
            StudentProfile::create([
                'user_id' => $user->id,
                'nim' => $validated['nim'],
                'faculty_id' => $validated['faculty_id'],
                'department_id' => $validated['department_id'],
                'semester' => $validated['semester'],
                'year_of_entry' => $validated['year_of_entry'],
                'status' => 'active',
            ]);

            DB::commit();

            return redirect()->route('admin.students.index')
                ->with('success', 'Mahasiswa berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan mahasiswa: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update student status.
     */
    public function updateStatus(Request $request, $id)
    {
        $user = User::students()->findOrFail($id);

        $validated = $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $user->update(['is_active' => $validated['is_active']]);

        return back()->with('success', 'Status mahasiswa berhasil diperbarui!');
    }

    /**
     * Show form to edit student.
     */
    public function edit($id)
    {
        $student = User::students()
            ->with(['studentProfile.faculty', 'studentProfile.department'])
            ->findOrFail($id);

        $faculties = Faculty::active()->get();
        $departments = Department::active()->get();

        return view('admin.students.edit', compact('student', 'faculties', 'departments'));
    }

    /**
     * Update student information.
     */
    public function update(Request $request, $id)
    {
        $student = User::students()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'nim' => 'required|string|unique:student_profiles,nim,' . $student->studentProfile->id,
            'faculty_id' => 'required|exists:faculties,id',
            'department_id' => 'required|exists:departments,id',
            'semester' => 'required|integer|min:1|max:14',
            'year_of_entry' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        DB::beginTransaction();
        try {
            // Update user
            $student->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
            ]);

            // Update student profile
            $student->studentProfile->update([
                'nim' => $validated['nim'],
                'faculty_id' => $validated['faculty_id'],
                'department_id' => $validated['department_id'],
                'semester' => $validated['semester'],
                'year_of_entry' => $validated['year_of_entry'],
            ]);

            DB::commit();

            return redirect()->route('admin.students.index')
                ->with('success', 'Data mahasiswa berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui mahasiswa: ' . $e->getMessage())->withInput();
        }
    }
}