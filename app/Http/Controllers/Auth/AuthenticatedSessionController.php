<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

# =====================================================================
# AUTHENTICATED SESSION CONTROLLER - Session Management
# =====================================================================
# Handles creating and destroying authenticated sessions
# Uses FormRequest for validated login credentials
# Implements rate limiting and security checks
#
# Methods:
# - create() - Display login form
# - store() - Authenticate and create session
# - destroy() - Logout and destroy session
#
# Features:
# - Rate limiting (prevent brute force - 5 attempts per minute)
# - Session regeneration (security)
# - CSRF token regeneration
# - LoginRequest validation with custom logic
# - Remember me functionality
# - Intended redirect (post-login redirect)
#
# Security:
# - LoginRequest handles rate limiting
# - Session regeneration prevents fixation attacks
# - CSRF token regeneration prevents cross-site attacks
# - Remember token management
#
# Related:
# - App\Http\Requests\Auth\LoginRequest - Validation & rate limiting

class AuthenticatedSessionController extends Controller
{
    # =========== DISPLAY LOGIN VIEW ===========
    # Show login form to unauthenticated users
    #
    # Returns: View - auth.login template
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    # =========== STORE AUTHENTICATED SESSION ===========
    # Process login request and create authenticated session
    #
    # Uses LoginRequest for validation:
    # - Email & password required
    # - Rate limiting (max 5 attempts per minute)
    # - Lockout after too many attempts
    # - Remember me checkbox support
    #
    # Workflow:
    # 1. LoginRequest validates credentials
    # 2. authenticate() method checks credentials
    # 3. If valid, LoginRequest authenticates user
    # 4. Regenerate session ID for security
    # 5. Redirect to intended page or default dashboard
    #
    # Intended Redirect:
    # - If user was redirected to login, go back to original page
    # - Example: User visits /student/reports → redirected to login
    #           After login → back to /student/reports
    #
    # Rate Limiting (in LoginRequest):
    # - Tracks failed attempts by IP + email
    # - Max 5 attempts per minute
    # - After limit exceeded, shows "too many attempts" error
    # - Lockout duration increases with attempts
    #
    # Returns: RedirectResponse to intended page or dashboard
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        # Authenticate using LoginRequest
        # LoginRequest::authenticate() handles:
        # - Rate limit checking
        # - Credential validation
        # - Throws ValidationException if fails
        $request->authenticate();

        # Regenerate session ID
        # Prevents session fixation attacks
        # Old session ID invalid after this
        $request->session()->regenerate();

        # Redirect to intended destination
        # route('dashboard') is fallback if no intended route
        # absolute: false uses relative URLs
        return redirect()->intended(route('dashboard', absolute: false));
    }

    # =========== DESTROY SESSION ===========
    # Logout user and destroy session
    #
    # Workflow:
    # 1. Logout user from 'web' authentication guard
    # 2. Invalidate all sessions (prevents session hijacking)
    # 3. Regenerate CSRF token (new token for next request)
    # 4. Redirect to home page
    #
    # Security:
    # - Invalidating session prevents further auth with old session
    # - CSRF token regeneration prevents cross-site attacks
    # - All remember tokens invalidated
    #
    # Returns: RedirectResponse to home page
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        # Logout from 'web' authentication guard
        # Removes authentication from session
        Auth::guard('web')->logout();

        # Invalidate all sessions for user
        # Prevents use of old session IDs
        $request->session()->invalidate();

        # Generate new CSRF token
        # Prevents CSRF attacks on next unauthenticated request
        $request->session()->regenerateToken();

        # Redirect to home page after logout
        return redirect('/');
    }
}
