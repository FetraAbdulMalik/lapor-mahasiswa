<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportCategory;
use Illuminate\Http\Request;

class PublicReportController extends Controller
{
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