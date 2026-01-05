<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportCategory;
use Illuminate\Http\Request;

# =====================================================================
# PUBLIC REPORT CONTROLLER - Tampilan laporan publik (tanpa login)
# =====================================================================
# Controller ini menangani viewing laporan yang sudah di-approve publik:
# - index(): List semua public reports dengan filter & search
# - show(): Detail laporan publik dengan comments & related reports
# =====================================================================
# Features:
#   - Filter by category (report_categories)
#   - Filter by status (pending, in-progress, resolved, closed)
#   - Search by judul laporan
#   - Pagination 12 items per halaman (grid view)
#   - Increment views counter (track engagement)
#   - Related reports (3 reports dengan category sama)
#   - Comments display dengan user info
#   - Status history timeline
#   - Eager load relationships: category, building, attachments, comments
# =====================================================================
# Security:
#   - Public access (NO auth required)
#   - Only fetch reports dengan visibility='public' (via public() scope)
#   - Increment views tanpa authentication
#   - No edit/delete (read-only endpoints)
# =====================================================================

class PublicReportController extends Controller
{
    # ===================================================================
    # index() - List semua public reports dengan filter & search
    # ===================================================================
    # Workflow:
    # 1. Query reports dengan public() scope (visibility='public')
    # 2. Eager load relationships: category, building, user.studentProfile
    # 3. Optional filter category (where category_id = request input)
    # 4. Optional filter status (where status = request input)
    # 5. Optional search by title (where title like %search%)
    # 6. Order by latest (created_at DESC)
    # 7. Paginate 12 items per halaman
    # 8. Load semua kategori aktif untuk filter dropdown
    # Return: view('public.reports.index', compact('reports', 'categories'))
    # Parameters:
    #   - category: report_categories.id
    #   - status: pending|in-progress|resolved|closed
    #   - search: text untuk filter judul laporan
    
    /**
     * Display public reports
     * @property int|null $category
     * @property string|null $status
     * @property string|null $search
     */
    public function index(Request $request)
    {
        $query = Report::public()
            ->with(['category', 'building', 'user.studentProfile']);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        $reports = $query->latest()->paginate(12);
        $categories = ReportCategory::active()->get();

        return view('public.reports.index', compact('reports', 'categories'));
    }

    # ===================================================================
    # show() - Tampilkan detail laporan publik lengkap
    # ===================================================================
    # Workflow:
    # 1. Query report dengan public() scope (visibility='public')
    # 2. Eager load semua relationships:
    #    - category: nama kategori laporan
    #    - building/facility: lokasi detail
    #    - attachments: file yang di-upload
    #    - statusHistory.createdBy: track perubahan status (admin)
    #    - comments.user: komentar dari mahasiswa & staff
    # 3. findOrFail($id) - 404 jika tidak ketemu atau bukan public
    # 4. incrementViews() - increment view counter untuk track engagement
    # 5. Fetch 3 related reports (sama category, except current)
    # 6. Return view dengan semua detail & related reports
    # Return: view('public.reports.show', compact('report', 'relatedReports'))
    
    /**
     * Display single public report
     */
    public function show($id)
    {
        $report = Report::public()
            ->with([
                'category',
                'building',
                'facility',
                'attachments',
                'statusHistory.createdBy',
                'comments.user'
            ])
            ->findOrFail($id);

        // Increment views
        $report->incrementViews();

        // Get related reports
        $relatedReports = Report::public()
            ->where('category_id', $report->category_id)
            ->where('id', '!=', $report->id)
            ->latest()
            ->take(3)
            ->get();

        return view('public.reports.show', compact('report', 'relatedReports'));
    }
}