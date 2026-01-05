<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ActivityLogFilterRequest;
use App\Models\ActivityLog;

# ============================================================================
# ActivityLogController - System Activity & Audit Trail
# ============================================================================
# Displays system activity logs for auditing and monitoring
# 
# Purpose: View/audit all system actions, track user behavior, compliance
# Features: Filter by user/action/date, distinct action types, pagination
# Use: Audit trail, compliance, debugging, security investigation
#

class ActivityLogController extends Controller
{
    public function index(ActivityLogFilterRequest $request)
    {
        $filters = $request->validated();
        $query = ActivityLog::with('user')->latest();

        if (array_key_exists('user_id', $filters) && $filters['user_id'] !== null) {
            $query->where('user_id', $filters['user_id']);
        }

        if (array_key_exists('action', $filters) && $filters['action'] !== null) {
            $query->where('action', $filters['action']);
        }

        if (!empty($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        $logs = $query->paginate(50);

        $actions = ActivityLog::select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        return view('admin.logs.index', compact('logs', 'actions'));
    }
}
