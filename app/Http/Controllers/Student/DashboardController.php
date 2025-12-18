<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Notification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Statistics
        $totalReports = Report::where('user_id', $user->id)->count();
        $pendingReports = Report::where('user_id', $user->id)->pending()->count();
        $inProgressReports = Report::where('user_id', $user->id)->inProgress()->count();
        $resolvedReports = Report::where('user_id', $user->id)->resolved()->count();

        // Recent Reports
        $recentReports = Report::where('user_id', $user->id)
            ->with(['category', 'building', 'facility'])
            ->latest()
            ->take(5)
            ->get();

        // Unread Notifications
        $notifications = Notification::where('user_id', $user->id)
            ->unread()
            ->latest()
            ->take(5)
            ->get();

        return view('student.dashboard', compact(
            'totalReports',
            'pendingReports',
            'inProgressReports',
            'resolvedReports',
            'recentReports',
            'notifications'
        ));
    }
}