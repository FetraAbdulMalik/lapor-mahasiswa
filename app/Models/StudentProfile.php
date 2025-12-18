<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    // ========== RELATIONSHIPS ==========
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // ========== SCOPES ==========
    
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByFaculty($query, $facultyId)
    {
        return $query->where('faculty_id', $facultyId);
    }

    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    // ========== HELPER METHODS ==========
    
    public function getFullNameAttribute()
    {
        return $this->user->name;
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar 
            ? asset('storage/' . $this->avatar) 
            : asset('images/default-avatar.png');
    }

    public function getCurrentSemesterAttribute()
    {
        $yearDiff = now()->year - $this->year_of_entry;
        $monthDiff = now()->month;
        
        $semesterFromYear = $yearDiff * 2;
        $currentSemester = $monthDiff >= 7 ? $semesterFromYear + 1 : $semesterFromYear;
        
        return max(1, $currentSemester);
    }
}