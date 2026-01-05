<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

# =====================================================================
# NOTIFICATION MODEL - Notifikasi untuk user tentang laporan
# =====================================================================
# Fields utama:
# - user_id: User yang menerima notifikasi
# - type: Tipe notifikasi (report_created, status_changed, assigned, dll)
# - title: Judul notifikasi
# - message: Detail pesan
# - report_id: Foreign key ke report (jika terkait laporan)
# - data: JSON additional data
# - is_read: Boolean flag apakah sudah dibaca
# - read_at: Timestamp kapan dibaca
#
# Types:
# - report_created: Laporan baru dibuat
# - report_status_changed: Status laporan berubah
# - report_assigned: Laporan di-assign ke staff
# - comment_added: Ada komentar baru
# - report_resolved: Laporan selesai
# - report_rejected: Laporan ditolak
# =====================================================================

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
    # Fields yang boleh mass-assign
    protected $fillable = [
        'user_id',           # User yang terima notifikasi
        'type',              # Tipe notifikasi
        'title',             # Judul notifikasi
        'message',           # Pesan notifikasi
        'data',              # JSON data tambahan
        'report_id',         # ID laporan terkait
        'is_read',           # Boolean sudah dibaca
        'read_at',           # Timestamp dibaca
    ];

    # Type casting untuk database values
    protected $casts = [
        'data' => 'array',               # JSON to array
        'is_read' => 'boolean',          # 0/1 to true/false
        'read_at' => 'datetime',
    ];

    # ==================== RELATIONSHIPS ====================
    
    # BELONGS TO: User
    # Satu notifikasi untuk satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    # BELONGS TO: Report
    # Notifikasi terkait satu laporan (bisa null)
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    # ==================== QUERY SCOPES ====================
    
    # Scope untuk filter notifikasi yang belum dibaca
    # is_read = false
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    # Scope untuk filter notifikasi yang sudah dibaca
    # is_read = true
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    # Scope untuk order notifikasi terbaru duluan
    # Order by created_at DESC
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    # ==================== HELPER METHODS ====================
    
    # Mark notifikasi sebagai read
    # Update is_read=true dan set read_at timestamp
    # Gunakan di user action untuk mark sebagai read
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    # Get icon emoji untuk notifikasi type
    # Gunakan untuk display di UI
    # report_created=📝, status_changed=🔄, assigned=👤, etc
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

    # Get human-readable type name dalam Bahasa Indonesia
    # Gunakan untuk display di UI
    # report_created -> "Laporan Dibuat", etc
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