<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportCategory;
use App\Models\Building;
use App\Models\User;
use App\Models\ReportStatus;
use App\Models\Comment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Display a listing of reports.
     * @property string|null $status
     * @property int|null $category
     * @property string|null $priority
     * @property string|null $date_from
     * @property string|null $date_to
     * @property string|null $search
     */
    public function index(Request $request)
    {
        $query = Report::with(['user.studentProfile', 'category', 'building', 'assignedTo']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->input('priority'));
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('reference_number', 'like', '%' . $request->input('search') . '%')
                  ->orWhereHas('user', function($q2) use ($request) {
                      $q2->where('name', 'like', '%' .  $request->input('search') . '%');
                  });
            });
        }

        $reports = $query->latest()->paginate(15);
        $categories = ReportCategory::active()->get();

        return view('admin.reports.index', compact('reports', 'categories'));
    }

    /**
     * Display the specified report.
     */
    public function show($id)
    {
        $report = Report::with([
            'user.studentProfile.faculty',
            'user.studentProfile.department',
            'category',
            'building',
            'facility',
            'attachments',
            'statusHistory.createdBy',
            'comments.user',
            'assignedTo'
        ])->findOrFail($id);

        $admins = User::admins()->active()->get();

        return view('admin.reports.show', compact('report', 'admins'));
    }

    /**
     * Update report status.
     */
    public function updateStatus(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,in_review,in_progress,resolved,rejected',
            'notes' => 'required|string|max:1000',
            'resolution_notes' => 'nullable|string|max:2000',
        ]);

        DB::beginTransaction();
        try {
            $oldStatus = $report->status;

            // Update report
            $updateData = ['status' => $validated['status']];
            
            if ($validated['status'] === 'resolved') {
                $updateData['resolved_at'] = now();
                $updateData['resolution_notes'] = $validated['resolution_notes'];
            }

            $report->update($updateData);

            // Create status history
            ReportStatus:: create([
                'report_id' => $report->id,
                'previous_status' => $oldStatus,
                'new_status' => $validated['status'],
                'notes' => $validated['notes'],
                'created_by' => auth()->id(),
            ]);

            // Send notification to student
            Notification::create([
                'user_id' => $report->user_id,
                'type' => 'report_status_changed',
                'title' => 'Status Laporan Berubah',
                'message' => "Laporan #{$report->reference_number} telah diubah statusnya menjadi:  " . $report->status_label,
                'report_id' => $report->id,
            ]);

            DB::commit();

            return back()->with('success', 'Status laporan berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui status:  ' . $e->getMessage());
        }
    }

    /**
     * Assign report to admin.
     */
    public function assign(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
            'notes' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $report->update([
                'assigned_to' => $validated['assigned_to'],
                'assigned_at' => now(),
                'status' => 'in_review', // Auto change to in_review
            ]);

            // Create status history
            ReportStatus::create([
                'report_id' => $report->id,
                'previous_status' => $report->status,
                'new_status' => 'in_review',
                'notes' => $validated['notes'] ?? 'Laporan ditugaskan ke admin',
                'created_by' => auth()->id(),
            ]);

            // Notify assigned admin
            Notification::create([
                'user_id' => $validated['assigned_to'],
                'type' => 'report_assigned',
                'title' => 'Laporan Ditugaskan',
                'message' => "Anda ditugaskan untuk menangani laporan #{$report->reference_number}",
                'report_id' => $report->id,
            ]);

            // Notify student
            Notification::create([
                'user_id' => $report->user_id,
                'type' => 'report_assigned',
                'title' => 'Laporan Sedang Ditinjau',
                'message' => "Laporan #{$report->reference_number} sedang ditinjau oleh admin terkait",
                'report_id' => $report->id,
            ]);

            DB::commit();

            return back()->with('success', 'Laporan berhasil ditugaskan! ');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menugaskan laporan:  ' . $e->getMessage());
        }
    }

    /**
     * Add official comment.
     */
    public function addComment(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
            'is_internal' => 'boolean',
        ]);

        Comment::create([
            'report_id' => $report->id,
            'user_id' => auth()->id(),
            'comment' => $validated['comment'],
            'is_official' => true,
            'is_internal' => $validated['is_internal'] ?? false,
        ]);

        // Notify student if not internal
        if (!($validated['is_internal'] ?? false)) {
            Notification::create([
                'user_id' => $report->user_id,
                'type' => 'comment_added',
                'title' => 'Komentar Baru dari Admin',
                'message' => "Admin menambahkan komentar pada laporan #{$report->reference_number}",
                'report_id' => $report->id,
            ]);
        }

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Bulk action on reports.
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:assign,change_status,delete',
            'report_ids' => 'required|array',
            'report_ids.*' => 'exists:reports,id',
            'assigned_to' => 'required_if:action,assign|exists:users,id',
            'status' => 'required_if:action,change_status|in:pending,in_review,in_progress,resolved,rejected',
        ]);

        DB::beginTransaction();
        try {
            $reports = Report::whereIn('id', $validated['report_ids'])->get();

            foreach ($reports as $report) {
                switch ($validated['action']) {
                    case 'assign':
                        $report->update([
                            'assigned_to' => $validated['assigned_to'],
                            'assigned_at' => now(),
                        ]);
                        break;

                    case 'change_status':
                        $report->update(['status' => $validated['status']]);
                        
                        ReportStatus::create([
                            'report_id' => $report->id,
                            'previous_status' => $report->status,
                            'new_status' => $validated['status'],
                            'notes' => 'Bulk action oleh admin',
                            'created_by' => auth()->id(),
                        ]);
                        break;

                    case 'delete':
                        $report->delete();
                        break;
                }
            }

            DB::commit();

            return back()->with('success', 'Bulk action berhasil dieksekusi pada ' . count($reports) . ' laporan! ');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal melakukan bulk action: ' . $e->getMessage());
        }
    }

    /**
     * Export reports to Excel.
     */
    public function exportExcel(Request $request)
    {
        // Get filtered reports
        $query = Report::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference_number', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->input('priority'));
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->input('to_date'));
        }

        $reports = $query->with(['category', 'user', 'building'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        // Create Excel file
        $fileName = 'laporan_' . now()->format('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new class($reports) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $reports;

            public function __construct($reports)
            {
                $this->reports = $reports;
            }

            public function collection()
            {
                return $this->reports->map(function ($report) {
                    return [
                        $report->reference_number,
                        $report->title,
                        $report->category->name ?? '-',
                        $report->user->name ?? '-',
                        $report->status_label,
                        $report->priority_label,
                        $report->building->name ?? '-',
                        $report->created_at->format('d-m-Y H:i'),
                    ];
                });
            }

            public function headings(): array
            {
                return ['No. Referensi', 'Judul', 'Kategori', 'Pelapor', 'Status', 'Prioritas', 'Gedung', 'Tanggal Laporan'];
            }
        }, $fileName);
    }

    /**
     * Export reports to PDF.
     */
    public function exportPdf(Request $request)
    {
        // Get filtered reports
        $query = Report::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference_number', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->input('priority'));
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->input('to_date'));
        }

        $reports = $query->with(['category', 'user', 'building'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        $pdf = Pdf::loadView('admin.exports.reports-pdf', [
            'reports' => $reports,
            'totalReports' => $reports->count(),
            'exportDate' => now()->format('d-m-Y H:i:s'),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan_' . now()->format('Y-m-d_His') . '.pdf');
    }
}