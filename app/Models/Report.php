<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property int|null $facility_id
 * @property string $title
 * @property string $description
 * @property string $status
 * @property string|null $priority
 * @property bool $is_anonymous
 * @property \Carbon\Carbon|null $resolved_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Report extends Model
{
    protected $fillable = [
        'reference_number',
        'user_id',
        'category_id',
        'title',
        'description',
        'location',
        'building_id',
        'facility_id',
        'incident_date',
        'status',
        'priority',
        'visibility',
        'is_anonymous',
        'assigned_to',
        'assigned_at',
        'resolved_at',
        'resolution_notes',
        'views_count',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'assigned_at' => 'datetime',
        'resolved_at' => 'datetime',
        'is_anonymous' => 'boolean',
    ];

    // ========== RELATIONSHIPS ==========
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(ReportCategory:: class, 'category_id');
    }

    public function building()
    {
        return $this->belongsTo(Building:: class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function attachments()
    {
        return $this->hasMany(ReportAttachment::class);
    }

    public function statusHistory()
    {
        return $this->hasMany(ReportStatus::class)->orderBy('created_at', 'desc');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'asc');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // ========== SCOPES ==========
    
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInReview($query)
    {
        return $query->where('status', 'in_review');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    // ========== HELPER METHODS ==========
    
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'in_review' => 'blue',
            'in_progress' => 'purple',
            'resolved' => 'green',
            'rejected' => 'red',
            default => 'gray'
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'in_review' => 'Sedang Ditinjau',
            'in_progress' => 'Sedang Diproses',
            'resolved' => 'Selesai',
            'rejected' => 'Ditolak',
            default => $this->status
        };
    }

    public function getPriorityBadgeColorAttribute()
    {
        return match($this->priority) {
            'low' => 'gray',
            'medium' => 'blue',
            'high' => 'orange',
            'urgent' => 'red',
            default => 'gray'
        };
    }

    public function getPriorityLabelAttribute()
    {
        return match($this->priority) {
            'low' => 'Rendah',
            'medium' => 'Sedang',
            'high' => 'Tinggi',
            'urgent' => 'Mendesak',
            default => $this->priority
        };
    }

    public function getReporterNameAttribute()
    {
        return $this->is_anonymous ? 'Anonim' : $this->user->name;
    }

    public function getReporterAvatarAttribute()
    {
        return $this->is_anonymous 
            ? asset('images/anonymous-avatar.png') 
            : $this->user->avatar;
    }

    public function getDaysOpenAttribute()
    {
        $endDate = $this->resolved_at ?? now();
        return $this->created_at->diffInDays($endDate);
    }

    public function getFullLocationAttribute()
    {
        if ($this->facility) {
            return $this->facility->full_location;
        }
        if ($this->building) {
            return $this->building->name .  ($this->location ? ' - ' . $this->location : '');
        }
        return $this->location ??  'Lokasi tidak disebutkan';
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function isOwnedBy($user)
    {
        return $this->user_id === $user->id;
    }

    public function canBeEditedBy($user)
    {
        return $this->isOwnedBy($user) && $this->status === 'pending';
    }

    // ========== BOOT ==========
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($report) {
            if (empty($report->reference_number)) {
                $report->reference_number = self::generateReferenceNumber();
            }
        });
    }

    public static function generateReferenceNumber()
    {
        $year = now()->format('y');
        $month = now()->format('m');
        
        $lastReport = self::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->latest('id')
            ->first();
        
        $number = $lastReport ? (int) substr($lastReport->reference_number, -4) + 1 : 1;
        
        return 'REF' . $year . $month . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}