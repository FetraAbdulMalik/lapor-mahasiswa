<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

# =====================================================================
# STUDENT PROFILE MODEL - Student-Specific Information
# =====================================================================
# Extends User model with student-specific data
# One-to-one relationship with User model
# Contains academic info: NIM, faculty, department, semester
#
# Properties:
# - user_id: Foreign key to users table
# - nim: Student ID number (unique identifier)
# - faculty_id: Faculty/college student enrolled in
# - department_id: Department/program student is in
# - semester: Current academic semester
# - year_of_entry: Year student started
# - status: Student status (active, inactive, graduated, suspended)
# - avatar: Profile picture path (stored in public/storage)
#
# Relationships:
# - user (1:1): The user account for this student
# - faculty (M:1): Faculty containing student's department
# - department (M:1): Department student is enrolled in
#
# Scopes:
# - active(): Only active students
# - byFaculty($id): Filter by faculty
# - byDepartment($id): Filter by department
#
# Helpers:
# - full_name: Get student name from user
# - avatar_url: Full URL to avatar image
# - current_semester: Auto-calculate current semester based on entry year

/**
 * @property int $id
 * @property int $user_id
 * @property int $department_id
 * @property string $student_number
 * @property string|null $year
 * @property string|null $address
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class StudentProfile extends Model
{
    protected $fillable = [
        'user_id',
        'nim',
        'faculty_id',
        'department_id',
        'semester',
        'year_of_entry',
        'status',
        'avatar',
    ];

    protected $casts = [
        'year_of_entry' => 'integer',
    ];

    # ===== RELATIONSHIPS =====
    
    # user() - Profile belongs to one user
    # One-to-one relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    # faculty() - Profile belongs to one faculty
    # Student's faculty/college
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    # department() - Profile belongs to one department
    # Student's major/program department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    # ===== SCOPES =====
    
    # active() - Only active students
    # status='active': Currently enrolled and active
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    # byFaculty() - Filter by faculty ID
    # Get students in specific faculty
    public function scopeByFaculty($query, $facultyId)
    {
        return $query->where('faculty_id', $facultyId);
    }

    # byDepartment() - Filter by department ID
    # Get students in specific department
    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    # ===== HELPER METHODS =====
    
    # Get student's full name from user relationship
    public function getFullNameAttribute()
    {
        return $this->user->name;
    }

    # Get full avatar URL
    # Returns public path if avatar exists, otherwise default image
    public function getAvatarUrlAttribute()
    {
        return $this->avatar 
            ? asset('storage/' . $this->avatar) 
            : asset('images/default-avatar.png');
    }

    # Auto-calculate current semester
    # Based on year_of_entry and current date
    #
    # Calculation:
    # - Each year = 2 semesters
    # - Semesters 1-2: Jan-Jun (before July)
    # - Semesters 3-4: Jul-Dec (July onwards)
    # 
    # Examples:
    # - Entered 2022, now 2024 (July+): 2 years × 2 + 1 = 5th semester
    # - Entered 2023, now 2024 (Jan): 1 year × 2 = 2nd semester
    public function getCurrentSemesterAttribute()
    {
        # Calculate years since enrollment
        $yearDiff = now()->year - $this->year_of_entry;
        
        # Get current month
        $monthDiff = now()->month;
        
        # Calculate semester: 2 per year
        $semesterFromYear = $yearDiff * 2;
        
        # Add 1 if July or later (odd semester)
        $currentSemester = $monthDiff >= 7 ? $semesterFromYear + 1 : $semesterFromYear;
        
        # Ensure minimum of semester 1
        return max(1, $currentSemester);
    }
}