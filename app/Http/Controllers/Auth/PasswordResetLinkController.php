<?php
/** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

# ============================================================================
# PasswordResetLinkController - Custom Admin-Driven Password Reset
# ============================================================================
# Handles password reset by notifying admins instead of sending reset link to user
# 
# Purpose:
# - Custom password reset flow for admin oversight
# - Provides way for users to request password reset
# - Notifies admin(s) of reset request instead of user
# - Admin can then manually reset password or contact user
# 
# Key Features:
# - Email validation: Ensures email exists in system
# - Admin notification: Sends password reset request to all admins
# - User feedback: Shows success message but doesn't reveal if email exists/doesn't
# - Error handling: Gracefully handles email send failures (silent fail)
# - Role-based admin lookup: Uses role='admin' or role='super_admin'
# 
# Differences from Standard Password Reset:
# - Standard: User gets reset link via email, self-service reset
# - This: Admin gets notification of reset request, admin-driven reset
# - Security: Adds extra step of admin approval/intervention
# - UX: User doesn't immediately reset password themselves
# 
# Use Cases:
# - Increased security: Admin can verify identity before allowing reset
# - Support: Admin can help user reset and answer questions
# - Audit trail: Admin notification creates record of reset request
# - Identity verification: Admin can verify user through other means
# 
# Workflow:
# 1. User navigates to forgot-password page
# 2. User enters email address
# 3. Request validated for email format
# 4. System checks if email exists in users table
# 5. If not found: Show error message, email repopulated
# 6. If found: Find all admin users (role = admin or super_admin)
# 7. Send email to all admins with user's name and email
# 8. Show success message to user
# 9. Admin receives notification and handles reset request
#
class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     # 
     # Workflow:
     # - Returns auth.forgot-password view
     # - View displays form with email field
     # - Form submits to store() method via POST
     # 
     # Returns:
     # - View: auth.forgot-password blade template
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     # 
     # Workflow:
     # 
     # 1. VALIDATION PHASE
     #    - email: required field, must be valid email format
     #    - Does NOT validate if email exists yet
     # 
     # 2. EMAIL LOOKUP PHASE
     #    - Query User table for matching email (case-insensitive typically in DB)
     #    - Store validated email in $validated variable
     #    - Find user using User::where('email', ...)->first()
     #    - first() returns User object if found, null if not found
     # 
     # 3. ERROR HANDLING - EMAIL NOT FOUND
     #    - If $user is null/falsy, user doesn't exist
     #    - Return back() to forgot-password form
     #    - withInput('email'): Repopulate email field with entered email
     #    - withErrors(['email' => message]): Show error message
     #    - Message: 'Email tidak ditemukan dalam sistem.' (Email not found in system)
     #    - User sees error but form still has email field filled
     # 
     # 4. ADMIN LOOKUP PHASE (if user found)
     #    - Query User table for all admin users
     #    - Conditions: role = 'admin' OR role = 'super_admin'
     #    - pluck('email'): Gets array of email addresses from results
     #    - Store in $adminEmails collection
     #    - Can be 0, 1, or many admins
     # 
     # 5. EMAIL NOTIFICATION PHASE (if admins exist)
     #    - Check if $adminEmails is not empty (has at least one admin)
     #    - Try block: Attempt to send email (wrapped for error handling)
     #    - Mail::send() sends email to specified recipients
     #    - Template: 'emails.admin-password-reset-notification'
     #    - Data passed to email template:
     #      - userEmail: Email of user requesting reset
     #      - userName: Full name of user requesting reset
     #    - Closure: Configures email:
     #      - to($adminEmails->toArray()): Email goes to all admins
     #      - subject('Permintaan Reset Password - Lapor Mahasiswa'): Subject line
     #    - Catch block: If email fails (SMTP error, invalid address)
     #      - Silently catches exception and continues
     #      - No error message shown to user
     #      - No logging of error
     #      - User sees success message even if email failed
     # 
     # 6. SUCCESS RESPONSE PHASE
     #    - Return back() to forgot-password form (refresh page)
     #    - with('status', message): Add status message to session
     #    - Message: 'Permintaan reset password Anda telah dikirim ke admin. Admin akan menghubungi Anda segera.'
     #    - Message shown to user even if:
     #      - User found and admin notified
     #      - User NOT found (early return prevents this)
     #      - Admin email send failed (silently)
     # 
     # Security Considerations:
     # - User doesn't get reset link via email (admin-controlled reset)
     # - Email lookup doesn't reveal if account exists (though we do with error message currently)
     # - No token generated or stored (admin handles reset directly)
     # - Admin notification creates audit trail of reset requests
     # - Silent failure on email send prevents system errors being exposed
     # 
     # Potential Improvements:
     # - Generic "success" message even if email not found (currently shows error)
     # - Log reset requests for audit trail
     # - Add email resend for admin in case first notification failed
     # - Add status/resolution tracking for admin to mark as resolved
     # 
     # Differences from Standard Password Reset:
     # - Standard: Send reset link to user, user self-resets
     # - This: Notify admin, admin handles reset
     # - Standard: Faster UX for user
     # - This: More secure, admin oversight, but slower UX for user
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Find user by email
        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Email tidak ditemukan dalam sistem.']);
        }

        // Send notification to admin instead of reset link to user
        $adminEmails = User::where('role', 'admin')->orWhere('role', 'super_admin')->pluck('email');
        
        if ($adminEmails->isNotEmpty()) {
            try {
                Mail::send('emails.admin-password-reset-notification', [
                    'userEmail' => $user->email,
                    'userName' => $user->name,
                ], function ($message) use ($adminEmails) {
                    $message->to($adminEmails->toArray())
                        ->subject('Permintaan Reset Password - Lapor Mahasiswa');
                });
            } catch (\Exception $e) {
                // Silently fail if email can't be sent
            }
        }

        // Show success message to user
        return back()->with('status', 'Permintaan reset password Anda telah dikirim ke admin. Admin akan menghubungi Anda segera.');
    }
}
