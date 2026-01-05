<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\ReportController as StudentReportController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;
use App\Http\Controllers\Student\NotificationController as StudentNotificationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicReportController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/how-to-report', [HomeController::class, 'howToReport'])->name('how.to.report');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/statistics', [HomeController::class, 'statistics'])->name('statistics');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'sendContact'])->name('contact.send');

// Public Reports
Route::get('/reports/public', [PublicReportController:: class, 'index'])->name('reports.public');
Route::get('/reports/public/{id}', [PublicReportController::class, 'show'])->name('reports.public.show');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // Forgot Password
    Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [LoginController::class, 'sendResetLinkEmail'])->name('password.email');
    
    // Reset Password
    Route::get('/reset-password/{token}', [LoginController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('password.update');
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    
    // Reports
    Route::resource('reports', StudentReportController:: class);
    Route::post('/reports/{id}/comment', [StudentReportController::class, 'addComment'])->name('reports.comment');
    
    // Profile
    Route::get('/profile', [StudentProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [StudentProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [StudentProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [StudentProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    
    // Notifications
    Route::get('/notifications', [StudentNotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [StudentNotificationController::class, 'markAsRead'])->name('notifications.read');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController:: class, 'index'])->name('dashboard');
    
    // Reports Management
    Route::resource('reports', AdminReportController::class)->only(['index', 'show']);
    Route::post('/reports/{id}/status', [AdminReportController::class, 'updateStatus'])->name('reports.status');
    Route::post('/reports/{id}/assign', [AdminReportController::class, 'assign'])->name('reports.assign');
    Route::post('/reports/{id}/comment', [AdminReportController::class, 'addComment'])->name('reports.comment');
    Route::post('/reports/bulk-action', [AdminReportController::class, 'bulkAction'])->name('reports.bulk');
    Route::get('/reports/export/excel', [AdminReportController:: class, 'exportExcel'])->name('reports.export.excel');
    Route::get('/reports/export/pdf', [AdminReportController::class, 'exportPdf'])->name('reports.export.pdf');
    
    // Students Management
    Route::resource('students', AdminStudentController:: class);
    Route::post('/students/{id}/status', [AdminStudentController::class, 'updateStatus'])->name('students.status');
    Route::post('/students/import', [AdminStudentController::class, 'import'])->name('students.import');
    Route::get('/students/export', [AdminStudentController::class, 'export'])->name('students.export');
    
    // Categories Management (Super Admin only)
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::post('/categories/{id}/toggle', [\App\Http\Controllers\Admin\CategoryController::class, 'toggle'])->name('categories.toggle');
    });
    
    // Faculties Management (Super Admin only)
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('faculties', \App\Http\Controllers\Admin\FacultyController::class);
    });
    
    // Departments Management (Super Admin only)
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('departments', \App\Http\Controllers\Admin\DepartmentController::class);
    });
    
    // Buildings Management (Super Admin only)
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('buildings', \App\Http\Controllers\Admin\BuildingController::class);
    });
    
    // Facilities Management (Super Admin only)
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('facilities', \App\Http\Controllers\Admin\FacilityController::class);
    });
    
    // Analytics
    Route::get('/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/category', [\App\Http\Controllers\Admin\AnalyticsController:: class, 'byCategory'])->name('analytics.category');
    Route::get('/analytics/department', [\App\Http\Controllers\Admin\AnalyticsController::class, 'byDepartment'])->name('analytics.department');
    Route::get('/analytics/trend', [\App\Http\Controllers\Admin\AnalyticsController::class, 'trend'])->name('analytics.trend');
    
    // Settings (Super Admin only)
    Route::middleware('role:super_admin')->group(function () {
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
        Route::post('/settings/backup-database', [\App\Http\Controllers\Admin\SettingsController::class, 'backupDatabase'])->name('settings.backup');
        Route::post('/settings/clear-cache', [\App\Http\Controllers\Admin\SettingsController::class, 'clearCache'])->name('settings.clear-cache');
        Route::post('/settings/clear-logs', [\App\Http\Controllers\Admin\SettingsController::class, 'clearLogs'])->name('settings.clear-logs');
    });
    
    // Activity Logs
    Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController:: class, 'index'])->name('logs.index');
    
    // User Management (Super Admin only)
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    });
});

/*
|--------------------------------------------------------------------------
| API Routes (for AJAX)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('api')->name('api.')->group(function () {
    
    // Get departments by faculty
    Route::get('/departments/{faculty_id}', function($facultyId) {
        $departments = \App\Models\Department::where('faculty_id', $facultyId)
            ->active()
            ->get(['id', 'name', 'code']);
        return response()->json($departments);
    })->name('departments.by-faculty');
    
    // Get facilities by building
    Route::get('/facilities/{building_id}', function($buildingId) {
        $facilities = \App\Models\Facility::where('building_id', $buildingId)
            ->active()
            ->get(['id', 'name', 'code', 'type', 'floor']);
        return response()->json($facilities);
    })->name('facilities.by-building');
    
    // Get unread notifications count
    Route::get('/notifications/unread', [StudentNotificationController::class, 'unreadCount'])->name('notifications.unread');
    
    // Search students (Admin only)
    Route::middleware('role:admin,super_admin')->get('/students/search', function(\Illuminate\Http\Request $request) {
        $query = $request->get('q');
        $students = \App\Models\User::students()
            ->where('name', 'like', "%{$query}%")
            ->orWhereHas('studentProfile', function($q) use ($query) {
                $q->where('nim', 'like', "%{$query}%");
            })
            ->with('studentProfile')
            ->limit(10)
            ->get(['id', 'name', 'email']);
        return response()->json($students);
    })->name('students.search');
});

/*
|--------------------------------------------------------------------------
| Redirect Routes
|--------------------------------------------------------------------------
*/

// Redirect after login based on role
Route::get('/dashboard', function () {
    if (auth()->user()->isStudent()) {
        return redirect()->route('student.dashboard');
    }
    return redirect()->route('admin.dashboard');
})->middleware('auth')->name('dashboard');

// Fallback route
Route::fallback(function () {
    return view('errors.404');
});