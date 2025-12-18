<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $phone
 * @property string $role
 * @property bool $is_active
 * @property \Carbon\Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    // ========== RELATIONSHIPS ==========
    
    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment:: class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function assignedReports()
    {
        return $this->hasMany(Report::class, 'assigned_to');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // ========== SCOPES ==========
    
    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    public function scopeAdmins($query)
    {
        return $query->whereIn('role', ['admin', 'super_admin']);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ========== HELPER METHODS ==========
    
    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function getAvatarAttribute()
    {
        if ($this->isStudent() && $this->studentProfile && $this->studentProfile->avatar) {
            return asset('storage/' . $this->studentProfile->avatar);
        }
        return asset('images/default-avatar.png');
    }
}