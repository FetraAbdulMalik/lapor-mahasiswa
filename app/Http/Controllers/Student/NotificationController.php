<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

# =====================================================================
# STUDENT NOTIFICATION CONTROLLER - Manajemen notifikasi mahasiswa
# =====================================================================
# Controller ini menangani notifikasi untuk student/mahasiswa:
# - index(): List semua notifikasi dengan pagination (20 items/page)
# - markAsRead(): Mark single notification sebagai read & redirect
# - unreadCount(): Get unread notification count via AJAX (JSON)
# =====================================================================
# Features:
#   - Notification listing dengan pagination (20 items/page)
#   - Auto-mark all as read saat visit index (update is_read & read_at)
#   - Mark single notification as read dengan optional redirect
#   - AJAX endpoint untuk unread count (dropdown badge)
#   - Eager load report relationship untuk notification context
#   - Filter by user_id (only logged-in user notifications)
#   - Order by latest (order by created_at DESC)
# =====================================================================
# Security:
#   - Only authenticated users (auth middleware)
#   - Filter by user_id = auth()->id() (no access other users)
#   - findOrFail untuk validation (404 jika tidak punya akses)
# =====================================================================

class NotificationController extends Controller
{
    # ===================================================================
    # index() - List semua notifikasi user dengan pagination
    # ===================================================================
    # Workflow:
    # 1. Query notifikasi milik user (filter user_id = auth()->id())
    # 2. Eager load report relationship (untuk context notifikasi)
    # 3. Order by latest (terbaru duluan)
    # 4. Paginate 20 items per halaman
    # 5. Auto-mark all unread notifications sebagai read (is_read=true, read_at=now)
    # 6. Return view dengan paginated notifications
    # Return: view('student.notifications.index', compact('notifications'))
    
    /**
     * Display notifications. 
     */
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->with('report')
            ->latest()
            ->paginate(20);

        // Mark all as read
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return view('student.notifications.index', compact('notifications'));
    }

    # ===================================================================
    # markAsRead() - Mark single notification sebagai read
    # ===================================================================
    # Parameter: $id = notification id
    # Proses:
    # 1. Fetch notification & validate user punya akses (where user_id = auth)
    # 2. Call markAsRead() method pada notification (set is_read=true, read_at=now)
    # 3. Jika notification punya report_id, redirect ke report.show
    # 4. Jika tidak, redirect back ke previous page
    # Return: redirect() ke report show atau back
    
    /**
     * Mark single notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())->findOrFail($id);
        $notification->markAsRead();

        if ($notification->report_id) {
            return redirect()->route('student.reports.show', $notification->report_id);
        }

        return back();
    }

    # ===================================================================
    # unreadCount() - Get unread notification count via AJAX
    # ===================================================================
    # Endpoint untuk fetch unread count tanpa reload page
    # Dipanggil via fetch() dari frontend untuk update badge count
    # Workflow:
    # 1. Query unread notifications (unread() scope filter is_read=false)
    # 2. Count semua unread untuk user (filter user_id = auth()->id())
    # 3. Return JSON response dengan count value
    # Return: response()->json(['count' => $count])
    # Usage: fetch('/api/notifications/unread-count')
    
    /**
     * Get unread count (AJAX).
     */
    public function unreadCount()
    {
        $count = Notification::where('user_id', auth()->id())
            ->unread()
            ->count();

        return response()->json(['count' => $count]);
    }
}