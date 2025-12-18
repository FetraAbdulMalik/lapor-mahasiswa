<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
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