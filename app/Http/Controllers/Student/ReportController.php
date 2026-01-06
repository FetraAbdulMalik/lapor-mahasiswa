<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportCategory;
use App\Models\Building;
use App\Models\Facility;
use App\Models\ReportAttachment;
use App\Models\ReportStatus;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

# =====================================================================
# STUDENT REPORT CONTROLLER - Mengelola Laporan Mahasiswa
# =====================================================================
# Controller ini menangani seluruh lifecycle laporan mahasiswa:
# - Lihat daftar laporan dengan filter & search
# - Buat laporan baru dengan validasi
# - Edit laporan (hanya status pending)
# - Hapus laporan (hanya status pending)
# - Tambah komentar pada laporan
# - Load fasilitas via AJAX berdasarkan gedung
# =====================================================================

class ReportController extends Controller
{
    # ===================================================================
    # index() - Tampilkan daftar laporan mahasiswa dengan filter/search
    # ===================================================================
    # Parameter: Request $request
    #   - status: Filter by status (pending, processed, resolved, etc)
    #   - category: Filter by kategori laporan
    #   - search: Search by judul atau nomor referensi
    # Return: view('student.reports.index', $data) dengan pagination 10 items/halaman
    
    /**
     * Display a listing of reports.
     * @param Request $request
     * @property string|null $status
     * @property int|null $category
     * @property string|null $search
     */
    public function index(Request $request)
    {
        # Query builder: ambil laporan milik user yang sedang login
        # with(['category', 'building', 'facility']) untuk eager loading relationships
        $query = Report::where('user_id', auth()->id())
            ->with(['category', 'building', 'facility']);

        # Filter by status - Jika request ada parameter 'status', filter laporan berdasarkan status
        # Contoh: status=pending, status=processed, dll
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        # Filter by category - Jika request ada parameter 'category', filter berdasarkan kategori
        # Contoh: category=1 untuk kategori Akademik
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        # Search - Cari berdasarkan judul laporan atau nomor referensi
        # where(function($q)) membuat nested condition dengan OR logic
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('reference_number', 'like', '%' . $request->input('search') . '%');
            });
        }

        # Execute query dan paginate hasil - 10 laporan per halaman
        # latest() = order by created_at DESC (laporan terbaru duluan)
        $reports = $query->latest()->paginate(10);
        
        # Ambil semua kategori aktif untuk dropdown filter
        $categories = ReportCategory::active()->get();

        # Return view dengan data laporan dan kategori
        return view('student.reports.index', compact('reports', 'categories'));
    }

    # ===================================================================
    # create() - Tampilkan form untuk membuat laporan baru
    # ===================================================================
    # Return: view('student.reports.create', $data) dengan daftar kategori & gedung
    # Kategori: Akademik, Fasilitas, Administrasi, dll (dari ReportCategory model)
    # Gedung: Daftar semua gedung yang active untuk location selection
    
    /**
     * Show the form for creating a new report.
     */
    public function create()
    {
        # Ambil semua kategori yang aktif untuk radio button selection
        # active() scope = where('is_active', true)
        $categories = ReportCategory::active()->get();
        
        # Ambil semua gedung yang aktif untuk select dropdown
        # Digunakan untuk location detail dan trigger AJAX load facilities
        $buildings = Building::active()->get();

        # Return view dengan kategori dan gedung
        # Data digunakan di form untuk radio buttons & select dropdowns
        return view('student.reports.create', compact('categories', 'buildings'));
    }

    # ===================================================================
    # store() - Simpan laporan baru ke database
    # ===================================================================
    # Proses:
    # 1. Validate request data (kategori, judul, deskripsi, priority, file)
    # 2. Create Report record dengan user_id, category, detail laporan
    # 3. Handle file uploads - simpan attachments ke storage/public/report-attachments
    # 4. Create ReportAttachment records untuk setiap file
    # 5. Create ReportStatus history - track status changes
    # 6. Rollback transaction jika ada error
    
    /**
     * Store a newly created report.
     */
    public function store(Request $request)
    {
        # Validate semua input dari form
        # kategori_id: required, harus ada di tabel report_categories
        # title: max 255 karakter
        # description: min 50 karakter (enforce deskripsi detail)
        # priority: hanya allow low/medium/high/urgent
        # attachments: max 5MB per file, mimes jpg/png/pdf/doc/docx
        $validated = $request->validate([
            'category_id' => 'required|exists:report_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'location' => 'nullable|string|max:255',
            'building_id' => 'nullable|exists:buildings,id',
            'facility_id' => 'nullable|exists:facilities,id',
            'incident_date' => 'nullable|date|before_or_equal:today',
            'priority' => 'required|in: low,medium,high,urgent',
            'visibility' => 'required|in:public,anonymous,private',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // 5MB
        ]);

        # DB::beginTransaction() - Mulai database transaction
        # Jika ada error, semua changes akan di-rollback
        # Ini memastikan consistency - jika file upload gagal, Report tidak jadi dibuat
        DB::beginTransaction();
        try {
            # CREATE Report record dengan validated data
            # user_id: diambil dari auth()->id() - user yang sedang login
            # is_anonymous: set true jika visibility == 'anonymous'
            # status: default 'pending' - perlu diproses admin
            $report = Report::create([
                'user_id' => auth()->id(),
                'category_id' => $validated['category_id'],
                'title' => $validated['title'],
                'description' => $validated['description'],
                'location' => $validated['location'],
                'building_id' => $validated['building_id'],
                'facility_id' => $validated['facility_id'],
                'incident_date' => $validated['incident_date'],
                'priority' => $validated['priority'],
                'visibility' => $validated['visibility'],
                'is_anonymous' => $validated['visibility'] === 'anonymous',
                'status' => 'pending',
            ]);

            # HANDLE FILE UPLOADS - Jika ada files yang di-upload
            # Loop setiap file dan simpan ke storage/public/report-attachments
            # Buat ReportAttachment record untuk track file metadata (nama, path, size, mime type)
            if ($request->hasFile('attachments')) {
                # Loop setiap file dari attachments[] array
                foreach ($request->file('attachments') as $file) {
                    # store('report-attachments', 'public') = simpan ke public disk
                    # Return relative path, contoh: report-attachments/abc123.pdf
                    $path = $file->store('report-attachments', 'public');
                    
                    # CREATE ReportAttachment record untuk setiap file
                    # Store: nama file original, path, extension, size, mime type
                    # Ini untuk list attachment di report detail page
                    ReportAttachment::create([
                        'report_id' => $report->id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                        'file_type' => $file->getClientOriginalExtension(),
                        'file_size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                    ]);
                }
            }

            # CREATE INITIAL STATUS HISTORY - Track perubahan status
            # Store: previous status (null untuk baru), new status (pending), notes
            # created_by: user yang membuat laporan (auth()->id())
            # Gunakan untuk audit trail dan timeline di report detail
            ReportStatus::create([
                'report_id' => $report->id,
                'previous_status' => null,
                'new_status' => 'pending',
                'notes' => 'Laporan dibuat oleh mahasiswa',
                'created_by' => auth()->id(),
            ]);

            # COMMIT TRANSACTION - Jika semua berhasil, save ke database
            DB::commit();

            # REDIRECT KE REPORT SHOW PAGE dengan success message
            # Display reference_number untuk user reference (contoh: REP-2026-00001)
            return redirect()->route('student.reports.show', $report->id)
                ->with('success', 'Laporan berhasil dibuat dengan nomor referensi: ' . $report->reference_number);

        } catch (\Exception $e) {
            # ERROR HANDLING - Jika ada exception, rollback transaction
            # Semua database changes akan di-undo
            # File yang sudah di-upload akan tetap (perlu cleanup manual)
            DB::rollBack();
            # Kembali ke form dengan error message dan input data sebelumnya
            return back()->with('error', 'Terjadi kesalahan saat membuat laporan: ' . $e->getMessage())->withInput();
        }
    }

    # ===================================================================
    # show() - Tampilkan detail laporan dengan comments & status history
    # ===================================================================
    # Proses:
    # 1. Fetch report dengan semua relationships (category, attachments, comments, history)
    # 2. Validasi user hanya bisa lihat laporan miliknya sendiri (where user_id = auth)
    # 3. Increment views counter untuk track engagement
    # 4. Return view dengan detail lengkap laporan
    
    /**
     * Display the specified report.
     */
    public function show($id)
    {
        # Fetch report dengan eager load semua relationships
        # category: nama kategori laporan
        # building/facility: lokasi detail
        # attachments: file yang di-upload
        # statusHistory.createdBy: track siapa yang ubah status (admin)
        # comments.user: komentar dari user & staff
        # assignedTo: staff/admin yang assign untuk handle laporan
        $report = Report::with([
            'category',
            'building',
            'facility',
            'attachments',
            'statusHistory.createdBy',
            'comments.user',
            'assignedTo'
        ])->where('user_id', auth()->id())  # Validasi - hanya user sendiri yang lihat
          ->findOrFail($id);  # 404 jika tidak ketemu atau bukan milik user

        # INCREMENT VIEWS COUNTER
        # Gunakan untuk track engagement & most viewed reports
        $report->incrementViews();

        # Return view dengan report detail
        return view('student.reports.show', compact('report'));
    }

    # ===================================================================
    # edit() - Tampilkan form untuk edit laporan (hanya status pending)
    # ===================================================================
    # Constraint: Hanya bisa edit laporan dengan status 'pending'
    # Jika sudah di-process/resolve, tidak boleh di-edit
    # Return: View form dengan data laporan & dropdown facilities
    
    /**
     * Show the form for editing the report.
     */
    public function edit($id)
    {
        # Fetch report - CONSTRAINT: status harus 'pending'
        # 404 jika tidak ketemu atau status bukan pending
        $report = Report::where('user_id', auth()->id())
            ->where('status', 'pending') // Only pending can be edited
            ->findOrFail($id);

        # Ambil kategori & gedung untuk dropdown form
        $categories = ReportCategory::active()->get();
        $buildings = Building::active()->get();
        
        # Load facilities - jika sudah pilih gedung, load facilities dari gedung itu
        # Jika belum pilih gedung, return empty collection
        $facilities = $report->building_id 
            ? Facility::where('building_id', $report->building_id)->active()->get()
            : collect();

        # Return edit form dengan data laporan
        return view('student.reports.edit', compact('report', 'categories', 'buildings', 'facilities'));
    }

    # ===================================================================
    # update() - Update laporan (hanya status pending)
    # ===================================================================
    # Sama seperti store() tapi untuk laporan yang sudah ada
    # Hanya update kategori, judul, deskripsi, lokasi, priority
    # Tidak bisa update status (hanya admin yang bisa ubah status)
    
    /**
     * Update the specified report.
     */
    public function update(Request $request, $id)
    {
        # Fetch report - CONSTRAINT: hanya yang user punya & status pending
        $report = Report::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->findOrFail($id);

        # Validate data yang diupdate (sama seperti store)
        $validated = $request->validate([
            'category_id' => 'required|exists:report_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'location' => 'nullable|string|max:255',
            'building_id' => 'nullable|exists:buildings,id',
            'facility_id' => 'nullable|exists: facilities,id',
            'incident_date' => 'nullable|date|before_or_equal: today',
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        # UPDATE report dengan validated data
        $report->update($validated);

        # REDIRECT ke report show dengan success message
        return redirect()->route('student.reports.show', $report->id)
            ->with('success', 'Laporan berhasil diperbarui! ');
    }

    # ===================================================================
    # destroy() - Hapus laporan (hanya status pending)
    # ===================================================================
    # Proses:
    # 1. Fetch report - validasi user punya & status pending
    # 2. Delete attachments dari storage/public/report-attachments
    # 3. Delete report record dari database (cascade delete child records)
    # 4. Redirect ke index dengan success message
    
    /**
     * Remove the specified report.
     */
    public function destroy($id)
    {
        # Fetch report - CONSTRAINT: hanya yang user punya & status pending
        $report = Report::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->findOrFail($id);

        # DELETE ATTACHMENTS FROM STORAGE
        # Loop setiap file dan hapus dari storage/public/report-attachments
        # Penting: hapus file fisik sebelum delete database record
        foreach ($report->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        # DELETE REPORT RECORD
        # Cascade delete: ReportAttachment, ReportStatus, Comment, dsb akan otomatis dihapus
        # (asumsi foreign keys sudah punya ON DELETE CASCADE)
        $report->delete();

        # REDIRECT ke index dengan success message
        return redirect()->route('student.reports.index')
            ->with('success', 'Laporan berhasil dihapus!');
    }

    # ===================================================================
    # addComment() - Tambah komentar pada laporan
    # ===================================================================
    # User bisa tambah komentar/reply untuk komunikasi dengan staff/admin
    # Validate: comment required, max 1000 karakter
    # Create: Comment record dengan user_id & is_official=false (user comment)
    
    /**
     * Add comment to report
     */
    public function addComment(Request $request, $id)
    {
        # Fetch report - validasi laporan milik user
        $report = Report::where('user_id', auth()->id())->findOrFail($id);

        # Validate comment input
        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        # CREATE COMMENT RECORD
        # is_official: false karena ini user comment (bukan staff reply)
        # user_id: user yang comment (auth()->id())
        Comment::create([
            'report_id' => $report->id,
            'user_id' => auth()->id(),
            'comment' => $validated['comment'],
            'is_official' => false,  # False = user comment, True = staff/admin official reply
        ]);

        # REDIRECT back dengan success message
        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    # ===================================================================
    # getFacilities() - AJAX endpoint untuk load fasilitas by building
    # ===================================================================
    # Dipanggil via fetch() dari frontend saat user pilih gedung
    # Return: JSON array dengan id, name, code, type (untuk populate facility dropdown)
    
    /**
     * Get facilities by building (AJAX)
     */
    public function getFacilities($buildingId)
    {
        # Query facilities berdasarkan building_id
        # active() scope = where('is_active', true)
        # Hanya select kolom: id, name, code, type (bandwidth efficient)
        $facilities = Facility::where('building_id', $buildingId)
            ->active()
            ->get(['id', 'name', 'code', 'type']);

        # Return JSON response
        # Frontend akan populate dropdown dengan data ini
        return response()->json($facilities);
    }
}