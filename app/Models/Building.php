<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int|null $floors
 * @property string|null $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Building extends Model
{
    protected $fillable = [
        'name',
        'code',
        'faculty_id',
        'address',
        'floor_count',
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

    public function facilities()
    {
        return $this->hasMany(Facility:: class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // ========== SCOPES ==========
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByFaculty($query, $facultyId)
    {
        return $query->where('faculty_id', $facultyId);
    }

    // ========== HELPER METHODS ==========
    
    public function getFacilityCountAttribute()
    {
        return $this->facilities()->count();
    }

    public function getReportCountAttribute()
    {
        return $this->reports()->count();
    }
}