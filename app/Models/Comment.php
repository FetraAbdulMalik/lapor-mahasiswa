<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

# =====================================================================
# COMMENT MODEL - Report Discussion/Feedback Comments
# =====================================================================
# Represents comments/notes on reports
# Used for communication between students and admins
# Can be public (visible to student) or internal (admin only)
#
# Properties:
# - report_id: Which report this comment belongs to
# - user_id: Who wrote the comment (student or admin)
# - comment: Comment text/message
# - is_official: Whether this is official response
# - is_internal: Whether visible only to admins
#
# Relationships:
# - report (M:1): The report being commented on
# - user (M:1): The author of comment
#
# Scopes:
# - public(): Only comments visible to students (is_internal=false)
# - official(): Only official responses (is_official=true)
# - internal(): Only internal admin comments (is_internal=true)
#
# Helpers:
# - author_name: Name of comment author
# - author_role: "Resmi" (official) or "Mahasiswa" (student)
# - badge_color: UI color for role display

class Comment extends Model
{
    protected $fillable = [
        'report_id',
        'user_id',
        'comment',
        'is_official',
        'is_internal',
    ];

    protected $casts = [
        'is_official' => 'boolean',
        'is_internal' => 'boolean',
    ];

    # ===== RELATIONSHIPS =====
    
    # report() - Comment belongs to one report
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    # user() - Comment written by one user
    # Can be student or admin
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    # ===== SCOPES =====
    
    # public() - Comments visible to students
    # is_internal=false: Not hidden from students
    public function scopePublic($query)
    {
        return $query->where('is_internal', false);
    }

    # official() - Official responses only
    # is_official=true: Official response from admin/staff
    public function scopeOfficial($query)
    {
        return $query->where('is_official', true);
    }

    # internal() - Internal admin comments only
    # is_internal=true: Only visible to admins
    public function scopeInternal($query)
    {
        return $query->where('is_internal', true);
    }

    # ===== HELPER METHODS =====
    
    # Get author's full name
    public function getAuthorNameAttribute()
    {
        return $this->user->name;
    }

    # Get role label for display
    # Official comments marked as "Resmi", others as "Mahasiswa"
    public function getAuthorRoleAttribute()
    {
        return $this->is_official ? 'Resmi' : 'Mahasiswa';
    }

    # Get badge color for role display
    # Official=blue, Student=gray
    public function getBadgeColorAttribute()
    {
        return $this->is_official ? 'blue' : 'gray';
    }
}