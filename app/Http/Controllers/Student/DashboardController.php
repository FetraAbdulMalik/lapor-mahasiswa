<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Notification;
use Illuminate\Http\Request;

# =====================================================================
# STUDENT DASHBOARD CONTROLLER - Dashboard untuk student/mahasiswa
# =====================================================================
# Controller ini menangani student dashboard yang menampilkan:
# - Statistics laporan (total, pending, in progress, resolved)
# - Recent reports list
# - Unread notifications
# =====================================================================

class DashboardController extends Controller
{
    # ===================================================================
    # index() - Tampilkan student dashboard dengan summary statistics
    # ===================================================================
    # Menampilkan overview laporan & notifications untuk student
    # Data yang ditampilkan:
    # - Total laporan user
    # - Laporan pending (belum diproses)
    # - Laporan in progress (sedang diproses)
    # - Laporan resolved (sudah selesai)
    # - 5 laporan terbaru
    # - 5 notifikasi terbaru yang belum dibaca
    
    public function index()
    {
        # GET current authenticated user
        $user = auth()->user();

        # ==================== STATISTICS ====================
        # COUNT laporan user berdasarkan status
        # Gunakan query scope untuk reusable query filters
        $totalReports = Report::where('user_id', $user->id)->count();
        $pendingReports = Report::where('user_id', $user->id)->pending()->count();
        $inProgressReports = Report::where('user_id', $user->id)->inProgress()->count();
        $resolvedReports = Report::where('user_id', $user->id)->resolved()->count();

        # ==================== RECENT REPORTS ====================
        # FETCH 5 laporan terbaru user dengan relationships
        # with() = eager load category, building, facility untuk performance
        # latest() = order by created_at DESC
        $recentReports = Report::where('user_id', $user->id)
            ->with(['category', 'building', 'facility'])
            ->latest()
            ->take(5)
            ->get();

        # ==================== UNREAD NOTIFICATIONS ====================
        # FETCH 5 notifikasi terbaru yang belum dibaca
        # unread() = scope where('read_at', null)
        # Gunakan untuk alert/badge di navigation
        $notifications = Notification::where('user_id', $user->id)
            ->unread()
            ->latest()
            ->take(5)
            ->get();

        # RETURN dashboard view dengan semua data
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