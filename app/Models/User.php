<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

# =====================================================================
# USER MODEL - Merepresentasikan user di sistem (student, admin, staff)
# =====================================================================
# Fields utama:
# - name: Nama user
# - email: Email unik untuk login
# - password: Hashed password
# - phone: Nomor telepon (optional)
# - role: student, admin, super_admin
# - is_active: Boolean untuk soft disable user
# - email_verified_at: Timestamp email verification
#
# Roles:
# - student: Mahasiswa yang membuat laporan
# - admin: Staff admin yang proses laporan
# - super_admin: Admin utama dengan full access
#
# Relationships:
# - studentProfile: Profile detail mahasiswa (one-to-one)
# - reports: Laporan yang dibuat user (one-to-many)
# - assignedReports: Laporan yang di-assign ke user (one-to-many)
# - comments: Comments dari user (one-to-many)
# - notifications: Notifikasi untuk user (one-to-many)
# - activityLogs: Activity log dari user (one-to-many)
# =====================================================================

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

    # Fields yang boleh mass-assign untuk security
    protected $fillable = [
        'name',           # Nama user
        'email',          # Email untuk login
        'password',       # Hashed password
        'phone',          # Nomor telepon (optional)
        'role',           # student, admin, super_admin
        'is_active',      # Boolean active/inactive flag
    ];

    # Attributes yang disembunyikan saat serialize ke JSON
    # password & remember_token tidak boleh di-expose
    protected $hidden = [
        'password',
        'remember_token',
    ];

    # Type casting untuk database values
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',           # Auto hash & verify
        'is_active' => 'boolean',
    ];

    # ==================== RELATIONSHIPS ====================
    
    # ONE-TO-ONE: User hasOne StudentProfile
    # Profil detail student (NIM, fakultas, dll)
    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    # ONE-TO-MANY: User hasMany Report (sebagai pembuat laporan)
    # Semua laporan yang dibuat user
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    # ONE-TO-MANY: User hasMany Comment
    # Semua komentar dari user
    public function comments()
    {
        return $this->hasMany(Comment:: class);
    }

    # ONE-TO-MANY: User hasMany Notification
    # Semua notifikasi untuk user
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    # ONE-TO-MANY: User hasMany Report (sebagai assigned staff)
    # Laporan yang di-assign ke user untuk diproses
    # Menggunakan foreign key 'assigned_to'
    public function assignedReports()
    {
        return $this->hasMany(Report::class, 'assigned_to');
    }

    # ONE-TO-MANY: User hasMany ActivityLog
    # Activity log dari user (login, action, dll)
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    # ==================== QUERY SCOPES ====================
    
    # Scope untuk filter student users
    # role = 'student'
    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    # Scope untuk filter admin/staff users
    # role IN (admin, super_admin)
    public function scopeAdmins($query)
    {
        return $query->whereIn('role', ['admin', 'super_admin']);
    }

    # Scope untuk filter active users
    # is_active = true
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    # ==================== HELPER METHODS ====================
    
    # Check apakah user adalah student
    # role == 'student'
    public function isStudent()
    {
        return $this->role === 'student';
    }

    # Check apakah user adalah admin
    # role IN (admin, super_admin)
    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    # Check apakah user adalah super admin
    # role == 'super_admin'
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    # Get full name (accessor attribute)
    # Bisa diperluas ke format: first_name + last_name
    public function getFullNameAttribute()
    {
        return $this->name;
    }

    # Get user avatar URL
    # Student: Ambil dari studentProfile->avatar
    # Non-student: Gunakan default avatar
    # Path: storage/app/public/... (accessible via URL)
    public function getAvatarAttribute()
    {
        if ($this->isStudent() && $this->studentProfile && $this->studentProfile->avatar) {
            return asset('storage/' . $this->studentProfile->avatar);
        }
        return asset('images/default-avatar.png');
    }
}