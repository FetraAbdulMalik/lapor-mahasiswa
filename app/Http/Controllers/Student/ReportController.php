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

class ReportController extends Controller
{
    /**
     * Display a listing of reports.
     * @param Request $request
     * @property string|null $status
     * @property int|null $category
     * @property string|null $search
     */
    public function index(Request $request)
    {
        $query = Report::where('user_id', auth()->id())
            ->with(['category', 'building', 'facility']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('reference_number', 'like', '%' . $request->input('search') . '%');
            });
        }

        $reports = $query->latest()->paginate(10);
        $categories = ReportCategory::active()->get();

        return view('student.reports.index', compact('reports', 'categories'));
    }

    /**
     * Show the form for creating a new report.
     */
    public function create()
    {
        $categories = ReportCategory::active()->get();
        $buildings = Building::active()->get();

        return view('student.reports.create', compact('categories', 'buildings'));
    }

    /**
     * Store a newly created report.
     */
    public function store(Request $request)
    {
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

        DB::beginTransaction();
        try {
            // Create report
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

            // Handle file uploads
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('report-attachments', 'public');
                    
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

            // Create initial status history
            ReportStatus::create([
                'report_id' => $report->id,
                'previous_status' => null,
                'new_status' => 'pending',
                'notes' => 'Laporan dibuat oleh mahasiswa',
                'created_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('student.reports.show', $report->id)
                ->with('success', 'Laporan berhasil dibuat dengan nomor referensi: ' . $report->reference_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat membuat laporan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified report.
     */
    public function show($id)
    {
        $report = Report::with([
            'category',
            'building',
            'facility',
            'attachments',
            'statusHistory.createdBy',
            'comments.user',
            'assignedTo'
        ])->where('user_id', auth()->id())
          ->findOrFail($id);

        // Increment views
        $report->incrementViews();

        return view('student.reports.show', compact('report'));
    }

    /**
     * Show the form for editing the report.
     */
    public function edit($id)
    {
        $report = Report::where('user_id', auth()->id())
            ->where('status', 'pending') // Only pending can be edited
            ->findOrFail($id);

        $categories = ReportCategory::active()->get();
        $buildings = Building::active()->get();
        $facilities = $report->building_id 
            ? Facility::where('building_id', $report->building_id)->active()->get()
            : collect();

        return view('student.reports.edit', compact('report', 'categories', 'buildings', 'facilities'));
    }

    /**
     * Update the specified report.
     */
    public function update(Request $request, $id)
    {
        $report = Report::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->findOrFail($id);

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

        $report->update($validated);

        return redirect()->route('student.reports.show', $report->id)
            ->with('success', 'Laporan berhasil diperbarui! ');
    }

    /**
     * Remove the specified report. 
     */
    public function destroy($id)
    {
        $report = Report::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->findOrFail($id);

        // Delete attachments from storage
        foreach ($report->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $report->delete();

        return redirect()->route('student.reports.index')
            ->with('success', 'Laporan berhasil dihapus! ');
    }

    /**
     * Add comment to report
     */
    public function addComment(Request $request, $id)
    {
        $report = Report::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        Comment::create([
            'report_id' => $report->id,
            'user_id' => auth()->id(),
            'comment' => $validated['comment'],
            'is_official' => false,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Get facilities by building (AJAX)
     */
    public function getFacilities($buildingId)
    {
        $facilities = Facility::where('building_id', $buildingId)
            ->active()
            ->get(['id', 'name', 'code', 'type']);

        return response()->json($facilities);
    }
}