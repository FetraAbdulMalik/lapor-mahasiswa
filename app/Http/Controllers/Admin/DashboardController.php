<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use App\Models\ReportCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
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