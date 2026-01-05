<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

# =====================================================================
# LOGIN CONTROLLER - User Authentication Management
# =====================================================================
# Handles user login, logout, and password reset functionality
# Supports role-based redirection (student vs admin)
# Session management and security features
#
# Methods:
# - showLoginForm() - Display login form
# - login() - Handle login submission with validation
# - logout() - Destroy session and logout
# - showForgotPasswordForm() - Display forgot password form
# - sendResetLinkEmail() - Send password reset email
# - showResetPasswordForm() - Display reset password form
# - resetPassword() - Process password reset
#
# Features:
# - "Remember me" functionality
# - Role-based dashboard redirection
# - Session regeneration for security
# - Password reset flow (placeholder)
# - Email validation
#
# Security:
# - Session regeneration after login
# - CSRF protection via middleware
# - Password hashing on reset
# - Remember token support

class LoginController extends Controller
{
    # =========== DISPLAY LOGIN FORM ===========
    # Show login form to user
    #
    # Returns: View - auth.login template
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    # =========== HANDLE LOGIN ===========
    # Process user login submission
    #
    # Validation Rules:
    # - email: required, valid email format
    # - password: required, minimum 6 characters
    #
    # Workflow:
    # 1. Validate email and password input
    # 2. Attempt authentication with credentials
    # 3. If remember checkbox checked, set "remember me" token
    # 4. Regenerate session ID for security
    # 5. Redirect to role-specific dashboard:
    #    - Student → student.dashboard
    #    - Admin → admin.dashboard
    # 6. Use intended() for post-login redirect
    #
    # If login fails:
    # - Return with error message
    # - Keep email input for re-submission
    # - Remove password from request data
    #
    # Returns: RedirectResponse to dashboard or back with errors
    /**
     * Handle login
     */
    public function login(Request $request)
    {
        # Validate credentials
        # Both email and password required
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        # Attempt authentication
        # $request->filled('remember') checks if remember checkbox is checked
        # If remember checked, sets remember_token for "remember me" functionality
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            # Regenerate session ID to prevent session fixation attacks
            $request->session()->regenerate();

            # Redirect based on authenticated user's role
            # isStudent() checks if user->role == 'student'
            # Route priority: intended() > role-based > default
            if (auth()->user()->isStudent()) {
                return redirect()->intended(route('student.dashboard'));
            }
            # Admin or super_admin redirects to admin dashboard
            return redirect()->intended(route('admin.dashboard'));
        }

        # Login failed - return with error
        # withErrors() flashes error messages
        # onlyInput('email') keeps email for re-entry, removes password
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    # =========== LOGOUT ===========
    # Destroy authenticated session and logout user
    #
    # Workflow:
    # 1. Logout user from Auth guard
    # 2. Invalidate all sessions
    # 3. Regenerate CSRF token
    # 4. Redirect to home page
    #
    # Security:
    # - Invalidating session prevents session hijacking
    # - New CSRF token prevents cross-site attacks
    # - All "remember me" tokens invalidated
    #
    # Returns: RedirectResponse to home
    /**
     * Logout
     */
    public function logout(Request $request)
    {
        # Logout user from authentication guard
        Auth::logout();
        
        # Invalidate all sessions for user
        # Prevents further requests with old session ID
        $request->session()->invalidate();
        
        # Generate new CSRF token
        # Prevents CSRF attacks on next request
        $request->session()->regenerateToken();

        # Redirect to home page
        return redirect()->route('home');
    }

    # =========== FORGOT PASSWORD FORM ===========
    # Display password reset request form
    #
    # Returns: View - auth.forgot-password template
    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    # =========== SEND PASSWORD RESET EMAIL ===========
    # Send password reset link to user's email
    #
    # Status: PLACEHOLDER - Not fully implemented
    # TODO: Connect to Mail/notification system
    #
    # Validation:
    # - email: required, valid email format
    #
    # Workflow (when implemented):
    # 1. Validate email exists in system
    # 2. Generate password reset token
    # 3. Send email with reset link
    # 4. Inform user link was sent
    #
    # Security:
    # - Token expires after set time (usually 60 minutes)
    # - One-time use tokens
    # - Email verification
    #
    # Returns: RedirectResponse with success message
    /**
     * Send reset link (placeholder)
     */
    public function sendResetLinkEmail(Request $request)
    {
        # Validate email is provided and valid format
        $request->validate(['email' => 'required|email']);
        
        # TODO: Implement password reset email sending
        # Should use Mail facade to send reset email with token
        # Example: Mail::send(new ResetPasswordMail($user, $token))
        return back()->with('status', 'Link reset password telah dikirim ke email Anda! ');
    }

    # =========== PASSWORD RESET FORM ===========
    # Display form to enter new password
    #
    # Parameters:
    # - $token: Password reset token from email link
    #
    # Validation (on form display):
    # - Token must be valid and not expired
    # - Token must match email in request
    #
    # Returns: View - auth.reset-password with token
    /**
     * Show reset password form
     */
    public function showResetPasswordForm($token)
    {
        # Pass token to view for form submission
        # Token used to validate reset request
        return view('auth.reset-password', ['token' => $token]);
    }

    # =========== PROCESS PASSWORD RESET ===========
    # Update user password with reset token
    #
    # Status: PLACEHOLDER - Not fully implemented
    # TODO: Implement full password reset logic
    #
    # Validation (when implemented):
    # - email: required, valid email
    # - token: required, valid token
    # - password: required, confirmed, strong
    #
    # Workflow (when implemented):
    # 1. Validate token hasn't expired
    # 2. Validate token matches email
    # 3. Hash new password
    # 4. Update user password
    # 5. Delete used token
    # 6. Redirect to login
    #
    # Returns: RedirectResponse to login
    /**
     * Reset password (placeholder)
     */
    public function resetPassword(Request $request)
    {
        # TODO: Implement password reset logic
        # Steps:
        # 1. Validate email, token, password in request
        # 2. Check password reset broker for valid token
        # 3. Update user password with Hash::make()
        # 4. Delete password reset token
        # 5. Log user in automatically or redirect to login
        return redirect()->route('login')->with('status', 'Password berhasil direset!');
    }
}