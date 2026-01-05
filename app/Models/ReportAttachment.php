<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

# =====================================================================
# REPORT ATTACHMENT MODEL - Files Attached to Reports
# =====================================================================
# Represents files/documents attached to reports
# Stores file metadata and provides helper methods
# Used for photos, documents, evidence files
#
# Properties:
# - report_id: Which report file belongs to
# - file_name: Original filename from upload
# - file_path: Storage path in public/storage
# - file_type: Document type (image, pdf, document, etc)
# - file_size: File size in bytes
# - mime_type: MIME type (image/jpeg, application/pdf, etc)
# - description: User-provided description
#
# Relationships:
# - report (M:1): The report this file is attached to
#
# Helpers:
# - url: Full public URL to access file
# - file_size_human: Human-readable size (2.5 MB, 100 KB, etc)
# - isImage(): Check if file is image
# - isPdf(): Check if PDF document
# - isDocument(): Check if office document
# - icon: Emoji icon based on file type
#
# Used for: Photo evidence, supporting documents, compliance files

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

    # ===== RELATIONSHIPS =====
    
    # report() - Attachment belongs to one report
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    # ===== HELPER METHODS =====
    
    # Get public URL for file access
    # Uses Storage::url() to generate full URL
    public function getUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    # Get human-readable file size
    # Converts bytes to KB, MB, GB
    # Example: 2097152 bytes → "2 MB"
    public function getFileSizeHumanAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        # Divide by 1024 until reaches appropriate unit
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        # Return formatted size with unit
        return round($bytes, 2) . ' ' . $units[$i];
    }

    # Check if file is image type
    # mime_type starts with 'image/'
    public function isImage()
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    # Check if file is PDF
    public function isPdf()
    {
        return $this->mime_type === 'application/pdf';
    }

    # Check if file is office document
    # Includes PDF, Word docs
    public function isDocument()
    {
        return in_array($this->mime_type, [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml. document',
        ]);
    }

    # Get emoji icon based on file type
    # Used for file type visual indication
    # 🖼️ = Image, 📄 = PDF, 📝 = Document, 📎 = Other
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