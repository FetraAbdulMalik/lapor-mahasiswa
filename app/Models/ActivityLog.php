<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'properties',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    // ========== RELATIONSHIPS ==========
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function model()
    {
        return $this->morphTo();
    }

    // ========== SCOPES ==========
    
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // ========== HELPER METHODS ==========
    
    public function getActionNameAttribute()
    {
        return match($this->action) {
            'create_report' => 'Membuat Laporan',
            'update_report' => 'Mengubah Laporan',
            'delete_report' => 'Menghapus Laporan',
            'update_status' => 'Mengubah Status',
            'assign_report' => 'Menugaskan Laporan',
            'add_comment' => 'Menambah Komentar',
            'login' => 'Login',
            'logout' => 'Logout',
            default => $this->action
        };
    }

    public function getActionIconAttribute()
    {
        return match($this->action) {
            'create_report' => '➕',
            'update_report' => '✏️',
            'delete_report' => '🗑️',
            'update_status' => '🔄',
            'assign_report' => '👤',
            'add_comment' => '💬',
            'login' => '🔓',
            'logout' => '🔒',
            default => '📌'
        };
    }
}