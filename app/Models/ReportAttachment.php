<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ReportAttachment extends Model
{
    protected $fillable = [
        'report_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'mime_type',
        'description',
    ];

    // ========== RELATIONSHIPS ==========
    
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    // ========== HELPER METHODS ==========
    
    public function getUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    public function getFileSizeHumanAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function isImage()
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    public function isPdf()
    {
        return $this->mime_type === 'application/pdf';
    }

    public function isDocument()
    {
        return in_array($this->mime_type, [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml. document',
        ]);
    }

    public function getIconAttribute()
    {
        if ($this->isImage()) {
            return '🖼️';
        }
        if ($this->isPdf()) {
            return '📄';
        }
        if ($this->isDocument()) {
            return '📝';
        }
        return '📎';
    }
}