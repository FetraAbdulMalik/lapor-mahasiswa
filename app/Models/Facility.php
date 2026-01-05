<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

# =====================================================================
# FACILITY MODEL - Specific Rooms/Areas Within Buildings
# =====================================================================
# Represents specific facilities within buildings
# Examples: Classroom, Lab, Library, Canteen, Toilet, Parking
# Used for detailed location reporting in reports
#
# Properties:
# - building_id: Which building contains this facility
# - name: Facility name (e.g., "Lab Komputer 1", "Toilet Lantai 2")
# - code: Short code (A101, B205, etc)
# - type: Type of facility (classroom, lab, library, etc)
# - floor: Floor number
# - room_number: Room/area code
# - capacity: Capacity (seats, people, etc)
# - description: Additional description
# - is_active: Available for reporting
#
# Relationships:
# - building (M:1): Building containing facility
# - reports (1:M): Reports submitted for this facility
#
# Scopes:
# - active(): Only active facilities
# - byBuilding($id): Filter by building
# - byType($type): Filter by facility type
#
# Helpers:
# - full_name: "Building - Facility Name"
# - full_location: "Building, Lantai X - Facility"
# - type_name: Indonesian type label
#
# Used for: Specific location selection in report forms

/**
 * @property int $id
 * @property int $building_id
 * @property string $name
 * @property string $code
 * @property int|null $floor
 * @property string|null $room_number
 * @property int|null $capacity
 * @property string|null $type
 * @property string|null $description
 * @property bool $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Facility extends Model
{
    protected $fillable = [
        'building_id',
        'name',
        'code',
        'type',
        'floor',
        'capacity',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    # ===== RELATIONSHIPS =====
    
    # building() - Facility belongs to one building
    # Every facility is within a specific building
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    # reports() - Facility has many reports
    # Multiple reports can be submitted for same facility
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    # ===== SCOPES =====
    
    # active() - Only active facilities
    # is_active=true: Available for new reports
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    # byBuilding() - Filter by building ID
    # Used for loading facilities in specific building
    public function scopeByBuilding($query, $buildingId)
    {
        return $query->where('building_id', $buildingId);
    }

    # byType() - Filter by facility type
    # Load specific type of facilities
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    # ===== HELPER METHODS =====
    
    # Get full name with building
    # Example: "Gedung A - Lab Komputer 1"
    public function getFullNameAttribute()
    {
        return $this->building->name . ' - ' . $this->name;
    }

    # Get complete location string
    # Example: "Gedung A, Lantai 2 - Lab Komputer 1"
    public function getFullLocationAttribute()
    {
        return $this->building->name . ', Lantai ' . $this->floor .  ' - ' . $this->name;
    }

    # Get Indonesian name for facility type
    # Convert system type to user-friendly label
    public function getTypeNameAttribute()
    {
        return match($this->type) {
            'classroom' => 'Ruang Kelas',
            'lab' => 'Laboratorium',
            'library' => 'Perpustakaan',
            'canteen' => 'Kantin',
            'mosque' => 'Masjid',
            'toilet' => 'Toilet',
            'parking' => 'Parkir',
            'sport_facility' => 'Fasilitas Olahraga',
            'office' => 'Kantor',
            default => 'Lainnya'
        };
    }
}