<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportCategory;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

# ============================================================================
# AnalyticsController - Report Analytics & Insights
# ============================================================================
# Provides analytics and reporting views for admin dashboards
# 
# Purpose: Display analytics on reports by category, department, trends
# Features: Overview dashboard, category analysis, department analysis, trends
# Use: Leadership reports, identifying bottlenecks, resource planning
#

class AnalyticsController extends Controller
{
    public function index()
    {
        $total_reports = Report::count();
        $pending_reports = Report::where('status', 'pending')->count();
        $in_progress_reports = Report::where('status', 'in_progress')->count();
        $completed_reports = Report::where('status', 'completed')->count();
        $rejected_reports = Report::where('status', 'rejected')->count();

        $recent_reports = Report::with(['user', 'category', 'facility'])
            ->latest()
            ->take(10)
            ->get();

        $top_categories = ReportCategory::withCount('reports')
            ->orderByDesc('reports_count')
            ->take(5)
            ->get();

        return view('admin.analytics.index', compact(
            'total_reports',
            'pending_reports',
            'in_progress_reports',
            'completed_reports',
            'rejected_reports',
            'recent_reports',
            'top_categories'
        ));
    }

    public function byCategory()
    {
        $categories = ReportCategory::withCount('reports')
            ->orderByDesc('reports_count')
            ->get();

        return view('admin.analytics.category', compact('categories'));
    }

    public function byDepartment()
    {
        $departments = Department::with(['studentProfiles' => function ($query) {
            $query->withCount('reports');
        }])
        ->get()
        ->map(function ($department) {
            $department->reports_count = $department->studentProfiles->sum('reports_count');
            return $department;
        })
        ->sortByDesc('reports_count');

        return view('admin.analytics.department', compact('departments'));
    }

    public function trend(Request $request)
    {
        $period = $request->get('period', '30'); // days

        $trends = Report::select([
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        ])
        ->where('created_at', '>=', now()->subDays($period))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        return view('admin.analytics.trend', compact('trends', 'period'));
    }
}
