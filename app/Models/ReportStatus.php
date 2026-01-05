<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

# =====================================================================
# REPORT STATUS MODEL - Report Status Change History
# =====================================================================\n# Tracks status changes throughout report lifecycle
# Creates audit trail of who changed status and when
# Stores notes for each status change\n#\n# Properties:
# - report_id: Which report this status change is for
# - previous_status: Status before change
# - new_status: Status after change (pending, in_review, in_progress, resolved, rejected)
# - notes: Reason/description for status change
# - created_by: Admin who made the change
#\n# Status Values:
# - pending: Initial status, waiting for review
# - in_review: Under review by admin
# - in_progress: Being worked on
# - resolved: Issue fixed/completed
# - rejected: Report rejected/invalid
#\n# Relationships:
# - report (M:1): The report being tracked
# - createdBy (M:1): Admin who changed status
#\n# Helpers:
# - status_label: Indonesian label for status (Menunggu, Diproses, dll)
# - status_color: Bootstrap color for status display
# - status_icon: Emoji icon for status visual
#\n# Used for: Status timeline, audit trail, notifications

class ReportStatus extends Model
{
    protected $fillable = [
        'report_id',
        'previous_status',
        'new_status',
        'notes',
        'created_by',
    ];

    # ===== RELATIONSHIPS =====
    
    # report() - Status change belongs to one report
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    # createdBy() - Status change created by one admin
    # Foreign key 'created_by' references users.id
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    # ===== HELPER METHODS =====
    
    # Get Indonesian label for new status
    # Used for displaying human-readable status
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

    # Get Bootstrap color for status display
    # Used in status badge UI elements
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

    # Get emoji icon representing status
    # Visual indicator for quick status recognition
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