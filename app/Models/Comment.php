<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    // ========== RELATIONSHIPS ==========
    
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ========== SCOPES ==========
    
    public function scopePublic($query)
    {
        return $query->where('is_internal', false);
    }

    public function scopeOfficial($query)
    {
        return $query->where('is_official', true);
    }

    public function scopeInternal($query)
    {
        return $query->where('is_internal', true);
    }

    // ========== HELPER METHODS ==========
    
    public function getAuthorNameAttribute()
    {
        return $this->user->name;
    }

    public function getAuthorRoleAttribute()
    {
        return $this->is_official ? 'Resmi' : 'Mahasiswa';
    }

    public function getBadgeColorAttribute()
    {
        return $this->is_official ? 'blue' : 'gray';
    }
}