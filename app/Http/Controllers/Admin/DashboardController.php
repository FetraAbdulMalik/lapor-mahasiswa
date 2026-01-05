<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use App\Models\ReportCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

# ============================================================================
# DashboardController - Admin Dashboard Statistics & Analytics
# ============================================================================
# Displays comprehensive admin dashboard with key metrics and trends
# 
# Purpose:
# - Shows real-time statistics for admin overview
# - Displays report status distribution
# - Shows recent reports and trends
# - Provides category and response time analytics
# 
# Key Metrics Calculated:
# - Total, pending, in-progress, resolved reports
# - Total number of students
# - Average response time (days from creation to resolution)
# - Reports grouped by category
# - Reports by status (for chart visualization)
# - Recent 10 reports with details
# - 7-day trend data
# 
# Dashboard Uses:
# - Report counts: pie charts, progress bars
# - Category breakdown: top 5 categories by report count
# - Status distribution: bar chart data
# - Trend data: line chart for last 7 days
# - Recent reports: quick access to latest submissions
# 
# Performance:
# - Uses eager loading (with()) to prevent N+1 queries
# - Counts calculated efficiently at database level
# - Limited queries (top 5, last 10, 7 days) for speed
# - Compact() passes data to view efficiently
#
class DashboardController extends Controller
{
    /**
     * Display admin dashboard with statistics.
     # 
     # Workflow:
     # 1. BASIC STATISTICS
     #    - Count total reports (all statuses)
     #    - Count pending reports (status = 'pending')
     #    - Count in-progress reports (status = 'in_progress')
     #    - Count resolved reports (status = 'resolved')
     #    - Count total students (role = 'student')
     # 
     # 2. RESPONSE TIME CALCULATION
     #    - Query resolved reports (resolved_at is not null)
     #    - Calculate average: DATEDIFF(resolved_at, created_at) in days
     #    - DATEDIFF: SQL function, returns days between dates
     #    - Result: Average days from report creation to resolution
     #    - Shows response efficiency
     # 
     # 3. CATEGORY ANALYSIS
     #    - Get all categories with count of reports
     #    - withCount('reports'): Adds reports_count attribute
     #    - Sort by reports_count descending (most reports first)
     #    - Take top 5 categories
     #    - Used for pie/donut chart
     # 
     # 4. STATUS DISTRIBUTION
     #    - Get reports grouped by status
     #    - Select: status, COUNT(*) as total
     #    - GroupBy: status
     #    - Used for bar chart showing each status count
     #    - Helps visualize bottlenecks
     # 
     # 5. RECENT REPORTS (Last 10)
     #    - Load with relationships:
     #      - user.studentProfile: Student name and profile
     #      - category: Report category name
     #      - building: Building/location info
     #    - Latest: Newest reports first
     #    - Take 10: Limit to 10 records
     #    - Shows: Recent activity at a glance
     # 
     # 6. TREND DATA (Last 7 Days)
     #    - Query reports created in last 7 days
     #    - Group by DATE(created_at)
     #    - Count reports per day
     #    - Sort by date ascending
     #    - Used for line chart showing daily trends
     #    - Helps identify spikes or patterns
     # 
     # 7. VIEW RENDERING
     #    - Compact all calculated data
     #    - Pass to admin.dashboard view
     #    - View renders: cards, charts, tables
     #    - Admin sees summary at glance
     #    - Can drill down to details
     # 
     # Data Passed to View:
     # - totalReports: Total number of reports
     # - pendingReports: Count of pending reports
     # - inProgressReports: Count of in-progress reports
     # - resolvedReports: Count of resolved reports
     # - totalStudents: Count of student users
     # - avgResponseTime: Average days to resolve (float/null)
     # - reportsByCategory: Collection of top 5 categories with counts
     # - reportsByStatus: Collection of status distribution
     # - recentReports: Collection of 10 most recent reports
     # - reportsTrend: Collection of daily trend data
     # 
     # View Components Expected:
     # - Metric cards: Display counts (total, pending, etc)
     # - Pie/Donut chart: Category distribution
     # - Bar chart: Status distribution
     # - Line chart: 7-day trend
     # - Table: Recent reports with quick actions
     # 
     # Performance Notes:
     # - All counts done at DB level (not post-processing)
     # - Relationships loaded eagerly (prevents N+1)
     # - Limited results (top 5, last 10, 7 days)
     # - Suitable for loading on every dashboard visit
     */
    public function index()
    {
        // Statistics
        $totalReports = Report::count();
        $pendingReports = Report::pending()->count();
        $inProgressReports = Report::inProgress()->count();
        $resolvedReports = Report::resolved()->count();
        $totalStudents = User::students()->count();

        // Average response time (in days)
        $avgResponseTime = Report::whereNotNull('resolved_at')
            ->selectRaw('AVG(DATEDIFF(resolved_at, created_at)) as avg_days')
            ->value('avg_days');

        // Reports by category
        $reportsByCategory = ReportCategory::withCount('reports')
            ->orderBy('reports_count', 'desc')
            ->take(5)
            ->get();

        // Reports by status (for chart)
        $reportsByStatus = Report::select(['status', DB::raw('count(*) as total')])
            ->groupBy('status')
            ->get();

        // Recent reports
        $recentReports = Report::with(['user.studentProfile', 'category', 'building'])
            ->latest()
            ->take(10)
            ->get();

        // Reports trend (last 7 days)
        $reportsTrend = Report::where('created_at', '>=', now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'totalReports',
            'pendingReports',
            'inProgressReports',
            'resolvedReports',
            'totalStudents',
            'avgResponseTime',
            'reportsByCategory',
            'reportsByStatus',
            'recentReports',
            'reportsTrend'
        ));
    }
}