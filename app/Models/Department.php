<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $faculty_id
 * @property string $name
 * @property string $code
 * @property string|null $head_of_department
 * @property string|null $email
 * @property bool $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Department extends Model
{
    protected $fillable = [
        'faculty_id',
        'name',
        'code',
        'head_of_department',
        'email',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ========== RELATIONSHIPS ==========
    
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function students()
    {
        return $this->hasMany(StudentProfile:: class);
    }

    // ========== SCOPES ==========
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ========== HELPER METHODS ==========
    
    public function getFullNameAttribute()
    {
        return $this->faculty->name . ' - ' . $this->name;
    }

    public function getStudentCountAttribute()
    {
        return $this->students()->count();
    }
}