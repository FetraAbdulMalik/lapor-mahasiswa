<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportStatus extends Model
{
    protected $fillable = [
        'report_id',
        'previous_status',
        'new_status',
        'notes',
        'created_by',
    ];

    // ========== RELATIONSHIPS ==========
    
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ========== HELPER METHODS ==========
    
    public function getStatusLabelAttribute()
    {
        return match($this->new_status) {
            'pending' => 'Menunggu',
            'in_review' => 'Sedang Ditinjau',
            'in_progress' => 'Sedang Diproses',
            'resolved' => 'Selesai',
            'rejected' => 'Ditolak',
            default => $this->new_status
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->new_status) {
            'pending' => 'yellow',
            'in_review' => 'blue',
            'in_progress' => 'purple',
            'resolved' => 'green',
            'rejected' => 'red',
            default => 'gray'
        };
    }

    public function getStatusIconAttribute()
    {
        return match($this->new_status) {
            'pending' => '⏳',
            'in_review' => '👀',
            'in_progress' => '⚙️',
            'resolved' => '✅',
            'rejected' => '❌',
            default => '📌'
        };
    }
}