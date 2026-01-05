<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

# =====================================================================
# BUILDING MODEL - Campus Building Locations
# =====================================================================
# Represents buildings/structures on campus
# Used for location classification in reports
# Each building can have multiple facilities (rooms, areas)
#
# Properties:
# - name: Building name/code (e.g., "Gedung A", "Rektorat")
# - code: Short code for identification (A, B, R, dll)
# - faculty_id: Which faculty maintains building
# - address: Physical location address
# - floor_count: Number of floors in building
# - is_active: Available for report submission
#
# Relationships:
# - faculty (M:1): Faculty responsible for building
# - facilities (1:M): Rooms/areas in building
# - reports (1:M): All reports submitted for this building
#
# Scopes:
# - active(): Only active buildings
# - byFaculty($id): Filter by faculty
#
# Helpers:
# - facility_count: Count of facilities
# - report_count: Count of reports

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

    # ===== RELATIONSHIPS =====
    
    # faculty() - Building belongs to one faculty
    # Faculty manages and maintains the building
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    # facilities() - Building has many facilities/rooms
    # Each facility is a specific area or room in building
    public function facilities()
    {
        return $this->hasMany(Facility:: class);
    }

    # reports() - Building has many reports
    # Reports are submitted for issues in this building
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    # ===== SCOPES =====
    
    # active() - Filter for active buildings only
    # is_active=true: Building available for report submission
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    # byFaculty($id) - Filter by faculty
    # Gets buildings managed by specific faculty
    public function scopeByFaculty($query, $facultyId)
    {
        return $query->where('faculty_id', $facultyId);
    }

    # ===== HELPER METHODS =====
    
    # Count facilities in building
    public function getFacilityCountAttribute()
    {
        return $this->facilities()->count();
    }

    # Count reports submitted for this building
    public function getReportCountAttribute()
    {
        return $this->reports()->count();
    }

}