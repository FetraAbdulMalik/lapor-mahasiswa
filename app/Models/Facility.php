<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    // ========== RELATIONSHIPS ==========
    
    public function building()
    {
        return $this->belongsTo(Building::class);
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

    public function scopeByBuilding($query, $buildingId)
    {
        return $query->where('building_id', $buildingId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // ========== HELPER METHODS ==========
    
    public function getFullNameAttribute()
    {
        return $this->building->name . ' - ' . $this->name;
    }

    public function getFullLocationAttribute()
    {
        return $this->building->name . ', Lantai ' . $this->floor .  ' - ' . $this->name;
    }

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