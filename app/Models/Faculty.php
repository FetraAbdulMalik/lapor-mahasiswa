<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $dean_name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $description
 * @property bool $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Faculty extends Model
{
    protected $fillable = [
        'name',
        'code',
        'dean_name',
        'email',
        'phone',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ========== RELATIONSHIPS ==========
    
    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function students()
    {
        return $this->hasMany(StudentProfile::class);
    }

    public function buildings()
    {
        return $this->hasMany(Building::class);
    }

    // ========== SCOPES ==========
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ========== HELPER METHODS ==========
    
    public function getStudentCountAttribute()
    {
        return $this->students()->count();
    }

    public function getDepartmentCountAttribute()
    {
        return $this->departments()->count();
    }
}