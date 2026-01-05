<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

# =====================================================================
# ROLE MIDDLEWARE - Authorization check berdasarkan user role
# =====================================================================
# Middleware ini melakukan authorization check untuk route
# Memastikan hanya user dengan role tertentu bisa access route
#
# Usage dalam routes:
#   Route::get('/admin/reports', [...])
#       ->middleware('role:admin,super_admin');
#
#   Route::post('/report/create', [...])
#       ->middleware('role:student');
# =====================================================================

class RoleMiddleware
{
    # ===================================================================
    # handle() - Check user role authorization
    # ===================================================================
    # Parameter:
    #   $request - HTTP request object
    #   $next - Next middleware dalam chain
    #   $roles - Variable arguments dengan list allowed roles
    #           Contoh: 'admin', 'student', atau 'admin,super_admin'
    #
    # Process:
    # 1. Check apakah user sudah login (authenticated)
    # 2. Check apakah user role ada dalam allowed roles list
    # 3. Jika tidak, return 403 Unauthorized
    # 4. Jika yes, lanjut ke next middleware/controller
    
    /**
     * Handle an incoming request. 
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        # CHECK: User sudah login/authenticated?
        # Jika belum, redirect ke login page
        if (!$request->user()) {
            return redirect()->route('login');
        }

        # CHECK: User role ada dalam allowed roles list?
        # in_array() untuk cek apakah user->role ada di $roles array
        # Contoh: in_array('student', ['admin', 'super_admin']) = false (abort)
        #         in_array('admin', ['admin', 'super_admin']) = true (continue)
        # Jika user->role NULL, gunakan default 'student'
        $userRole = $request->user()->role ?? 'student';
        
        if (!in_array($userRole, $roles)) {
            # ABORT 403 - User tidak punya permission untuk access route ini
            # Return 403 Forbidden dengan message
            abort(403, 'Unauthorized action.');
        }

        # CONTINUE: User authorized, lanjut ke next middleware/controller
        return $next($request);
    }
}