<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

# =====================================================================
# REPORT MODEL - Merepresentasikan laporan mahasiswa di database
# =====================================================================
# Fields utama:
# - reference_number: Unique identifier (REP-2026-00001)
# - user_id: Mahasiswa yang membuat laporan
# - category_id: Kategori laporan (Akademik, Fasilitas, dsb)
# - title, description: Detail laporan
# - status: pending, in_review, in_progress, resolved, rejected
# - priority: low, medium, high, urgent
# - visibility: public, anonymous, private
# - is_anonymous: Boolean flag untuk anonymity
# - incident_date: Kapan kejadian terjadi
# - assigned_to: Staff/admin yang handle laporan
# - resolved_at: Waktu laporan selesai diproses
# 
# Relationships:
# - user: Mahasiswa yang membuat laporan
# - category: Kategori laporan
# - building: Lokasi gedung
# - facility: Lokasi spesifik ruangan
# - attachments: File-file pendukung
# - statusHistory: Track perubahan status
# - comments: Komunikasi user dengan staff
# =====================================================================

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
    # Fillable attributes yang bisa mass-assign
    # Ini untuk security - prevent mass assignment ke fields yang tidak diinginkan
    protected $fillable = [
        'reference_number',  # Unique reference like REP-2026-00001
        'user_id',           # Mahasiswa yang lapor
        'category_id',       # Kategori laporan
        'title',             # Judul laporan
        'description',       # Detail deskripsi
        'location',          # Lokasi tambahan text
        'building_id',       # Gedung
        'facility_id',       # Fasilitas/Ruangan
        'incident_date',     # Kapan terjadi
        'status',            # pending, in_review, in_progress, resolved, rejected
        'priority',          # low, medium, high, urgent
        'visibility',        # public, anonymous, private
        'is_anonymous',      # Boolean anonymity flag
        'assigned_to',       # Staff/admin handler
        'assigned_at',       # Kapan assign ke staff
        'resolved_at',       # Kapan selesai resolve
        'resolution_notes',  # Catatan dari admin
        'views_count',       # Jumlah yang lihat (engagement metric)
    ];

    # Type casting untuk database fields
    # Otomatis convert ke tipe yang sesuai saat access
    protected $casts = [
        'incident_date' => 'date',       # Cast to Carbon date object
        'assigned_at' => 'datetime',     # Cast to Carbon datetime
        'resolved_at' => 'datetime',     # Cast to Carbon datetime
        'is_anonymous' => 'boolean',     # Cast 0/1 to true/false
    ];

    # ==================== RELATIONSHIPS ====================
    
    # Relationship ke User model
    # Satu laporan dimiliki satu mahasiswa
    # Inverse: User hasMany Reports
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    # Relationship ke ReportCategory model
    # Satu laporan punya satu kategori
    # Inverse: Category hasMany Reports
    public function category()
    {
        return $this->belongsTo(ReportCategory:: class, 'category_id');
    }

    # Relationship ke Building model
    # Laporan terjadi di satu gedung (bisa null jika tidak spesifik)
    public function building()
    {
        return $this->belongsTo(Building:: class);
    }

    # Relationship ke Facility model
    # Laporan terjadi di satu fasilitas (bisa null, optional)
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    # Relationship ke User model untuk assigned staff/admin
    # Siapa yang assign untuk handle laporan (bisa null jika belum assign)
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    # Relationship ke ReportAttachment model
    # Satu laporan bisa punya banyak file attachments
    public function attachments()
    {
        return $this->hasMany(ReportAttachment::class);
    }

    # Relationship ke ReportStatus model
    # Track semua perubahan status laporan (history/audit trail)
    # orderBy created_at desc = status terbaru duluan
    public function statusHistory()
    {
        return $this->hasMany(ReportStatus::class)->orderBy('created_at', 'desc');
    }

    # Relationship ke Comment model
    # Komunikasi antara user dan staff/admin pada laporan
    # orderBy created_at asc = comment lama duluan (thread-like display)
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'asc');
    }

    # Relationship ke Notification model
    # Notifikasi untuk user tentang progress laporan
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    # ==================== QUERY SCOPES ====================
    # Scopes adalah shortcut untuk query filtering yang sering digunakan
    # Contoh: Report::pending()->get() instead of Report::where('status', 'pending')->get()
    
    # Scope untuk filter laporan dengan status pending
    # Status pending = baru dibuat, belum di-review
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    # Scope untuk filter laporan dengan status in_review
    # Status in_review = sedang di-review admin
    public function scopeInReview($query)
    {
        return $query->where('status', 'in_review');
    }

    # Scope untuk filter laporan dengan status in_progress
    # Status in_progress = sedang ditindak lanjuti
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    # Scope untuk filter laporan yang sudah resolved/selesai
    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    # Scope untuk filter laporan yang ditolak/rejected
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    # Scope untuk filter laporan publik (visibility = public)
    # Bisa dilihat siapa saja (dengan nama penulis terlihat)
    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

    # Scope untuk order laporan terbaru duluan
    # Digunakan di index untuk tampilkan laporan terbaru
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    # Scope untuk filter laporan by kategori
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    # Scope untuk filter laporan milik user tertentu
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    # Scope untuk filter laporan yang assign ke staff tertentu
    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    # ==================== HELPER METHODS ====================
    # Methods ini adalah computed properties/accessors untuk format/transform data
    
    # Get status badge color untuk CSS styling
    # Digunakan untuk tampilkan status dengan warna berbeda
    # pending=yellow, in_review=blue, in_progress=purple, resolved=green, rejected=red
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

    # Get status label dalam Bahasa Indonesia
    # Transform database value ke human-readable text
    # pending -> "Menunggu", in_review -> "Sedang Ditinjau", dsb
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

    # Get priority badge color untuk CSS styling
    # low=gray, medium=blue, high=orange, urgent=red
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

    # Get priority label dalam Bahasa Indonesia
    # Transform database value ke human-readable text
    # low -> "Rendah", medium -> "Sedang", high -> "Tinggi", urgent -> "Mendesak"
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

    # Get reporter name - handle anonymity
    # Jika is_anonymous=true, tampilkan "Anonim" instead of actual name
    # Protect privacy user yang lapor anonim
    public function getReporterNameAttribute()
    {
        return $this->is_anonymous ? 'Anonim' : $this->user->name;
    }

    # Get reporter avatar - handle anonymity
    # Jika anonim, gunakan generic anonymous avatar
    # Jika bukan anonim, gunakan user avatar profile
    public function getReporterAvatarAttribute()
    {
        return $this->is_anonymous 
            ? asset('images/anonymous-avatar.png') 
            : $this->user->avatar;
    }

    # Get jumlah hari laporan terbuka
    # Dihitung dari created_at hingga resolved_at (atau now jika belum selesai)
    # Gunakan untuk SLA tracking & performance metrics
    public function getDaysOpenAttribute()
    {
        $endDate = $this->resolved_at ?? now();
        return $this->created_at->diffInDays($endDate);
    }

    # Get lokasi lengkap untuk display
    # Priority: facility > building + location > location text > default message
    # Gunakan untuk show full location info di report detail
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

    # Increment views counter
    # Digunakan untuk track engagement/popularity report
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    # Check apakah laporan dimiliki user tertentu
    # Used untuk authorization check
    public function isOwnedBy($user)
    {
        return $this->user_id === $user->id;
    }

    # Check apakah laporan bisa diedit user tertentu
    # Hanya pemilik dengan status pending yang bisa edit
    # Jika sudah di-review/di-proses, tidak bisa diedit lagi
    public function canBeEditedBy($user)
    {
        return $this->isOwnedBy($user) && $this->status === 'pending';
    }

    # ==================== MODEL EVENTS ====================
    # Boot method: setup model event listeners
    # Ini dipanggil setiap kali model di-create/update/delete
    
    protected static function boot()
    {
        parent::boot();
        
        # EVENT: Creating
        # Dipanggil sebelum report disave ke database
        # Generate reference_number otomatis jika kosong
        # Reference number format: REP-YYYY-00001
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