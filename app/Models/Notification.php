<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $title
 * @property string $message
 * @property int|null $related_id
 * @property string|null $related_type
 * @property bool $is_read
 * @property \Carbon\Carbon|null $read_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'report_id',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    // ========== RELATIONSHIPS ==========
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    // ========== SCOPES ==========
    
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // ========== HELPER METHODS ==========
    
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    public function getIconAttribute()
    {
        return match($this->type) {
            'report_created' => '📝',
            'report_status_changed' => '🔄',
            'report_assigned' => '👤',
            'comment_added' => '💬',
            'report_resolved' => '✅',
            'report_rejected' => '❌',
            default => '🔔'
        };
    }

    public function getTypeNameAttribute()
    {
        return match($this->type) {
            'report_created' => 'Laporan Dibuat',
            'report_status_changed' => 'Status Berubah',
            'report_assigned' => 'Laporan Ditugaskan',
            'comment_added' => 'Komentar Baru',
            'report_resolved' => 'Laporan Selesai',
            'report_rejected' => 'Laporan Ditolak',
            default => 'Notifikasi'
        };
    }
}