<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property string|null $icon
 * @property string|null $color
 * @property bool $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ReportCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'department_handle',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ========== RELATIONSHIPS ==========
    
    public function reports()
    {
        return $this->hasMany(Report::class, 'category_id');
    }

    // ========== SCOPES ==========
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    // ========== HELPER METHODS ==========
    
    public function getReportCountAttribute()
    {
        return $this->reports()->count();
    }

    public function getPendingReportCountAttribute()
    {
        return $this->reports()->where('status', 'pending')->count();
    }

    public function getResolvedReportCountAttribute()
    {
        return $this->reports()->where('status', 'resolved')->count();
    }

    // ========== BOOT ==========
    
    protected static function boot()
    {
        parent:: boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str:: slug($category->name);
            }
        });
    }
}