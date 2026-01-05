<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

# =====================================================================
# REPORT CATEGORY MODEL - Report Classification Categories
# =====================================================================
# Represents categories/types for classifying reports
# Examples: Facility Issues, Safety Concerns, Environmental, Academic, etc
# Each category has emoji icon and color for UI display
#
# Properties:
# - name: Category name (e.g., "Fasilitas Rusak")
# - slug: URL-friendly name (auto-generated from name)
# - description: Detailed category description
# - icon: Emoji icon representing category (🛠️, 🚨, 🌍, etc)
# - color: Color code for UI display (blue, red, green, etc)
# - department_handle: Which department handles this category
# - is_active: Whether category available for new reports
# - sort_order: Display order in dropdowns
#
# Relationships:
# - reports (1:M): All reports in this category
#
# Scopes:
# - active(): Only active categories ordered by sort_order
#
# Helper Methods:
# - report_count: Count of reports in category
# - pending_report_count: Count of pending reports
# - resolved_report_count: Count of resolved reports
#
# Features:
# - Auto-slug generation on create/update
# - Report counting for analytics
# - Status-based scoping

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

    # ===== RELATIONSHIPS =====
    # reports() - One-to-many: Category has many reports
    # Used for counting reports by category in analytics
    # Filtered by scope methods for active/pending/resolved counts
    
    public function reports()
    {
        return $this->hasMany(Report::class, 'category_id');
    }

    # ===== SCOPES =====
    # active() - Query scope for active categories
    # Filters: is_active=true
    # Orders: by sort_order ascending (display priority)
    # Used in: Report creation dropdown, public listing
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    # ===== HELPER METHODS =====
    # Dynamic properties for counting and analytics
    
    # Get count of all reports in this category
    public function getReportCountAttribute()
    {
        return $this->reports()->count();
    }

    # Get count of pending reports in this category
    # Used for admin dashboard to see backlog by category
    public function getPendingReportCountAttribute()
    {
        return $this->reports()->where('status', 'pending')->count();
    }

    # Get count of resolved reports in this category
    # Used for completion rate analytics
    public function getResolvedReportCountAttribute()
    {
        return $this->reports()->where('status', 'resolved')->count();
    }

    # ===== MODEL EVENTS =====
    # boot() with creating/updating hooks for auto-slug generation
    
    protected static function boot()
    {
        parent:: boot();
        
        # Auto-generate slug from name on create
        # Converts "Fasilitas Rusak" → "fasilitas-rusak"
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        # Auto-update slug if name changes
        # Keeps slug in sync with name for URL consistency
        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str:: slug($category->name);
            }
        });
    }
}