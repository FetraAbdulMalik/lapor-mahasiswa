<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

# ============================================================================
# EmailVerificationNotificationController - Resend Email Verification Link
# ============================================================================
# Sends/resends email verification link to user
# 
# Purpose:
# - Sends initial verification email after user registration
# - Allows user to resend verification email if first one was lost/missed
# - Uses Laravel's built-in sendEmailVerificationNotification()
# - Redirects user based on current verification status
# 
# Key Features:
# - Already verified check: Skips resend if email already verified
# - User notification: Calls Laravel's sendEmailVerificationNotification()
# - Mailable integration: Uses configured mail driver and templates
# - Status feedback: Shows message after resending
# 
# Email Verification Flow:
# 1. User registers account
# 2. Registered event fires, Listener sends initial verification email
# 3. User may not receive email or lose email
# 4. User clicks "Resend verification email" button
# 5. Request sent to this controller's store() method
# 6. If already verified: Redirect to dashboard
# 7. If not verified: Send email and show "link sent" message
# 
# Verification Email Details:
# - Sent by: sendEmailVerificationNotification() method on User model
# - Template: resources/views/emails/verify-email.blade.php (configurable)
# - Contains: User's name, verification link with signature
# - Link format: /email/verify/{id}/{hash} with signature
# - Signature ensures link can't be tampered with
# 
# Resend Scenarios:
# - Initial: After registration (fired by Registered event)
# - Resend: User lost/missed email clicks "Resend" button
# - Multiple: Can resend unlimited times until verified
# 
# Session Message:
# - Key: 'status'
# - Value: 'verification-link-sent'
# - Blade template checks for this and shows success message
# - Message: "A new verification link has been sent to your email address."
#
class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     # 
     # Workflow:
     # 
     # 1. CHECK IF ALREADY VERIFIED
     #    - Call $request->user()->hasVerifiedEmail()
     #    - Checks: email_verified_at timestamp is not null
     #    - If true (already verified):
     #      - Redirect to dashboard immediately
     #      - User doesn't need verification email
     #      - Skips unnecessary email send
     # 
     # 2. SEND VERIFICATION EMAIL (if not already verified)
     #    - Call $request->user()->sendEmailVerificationNotification()
     #    - User model method (typically in User class)
     #    - Generates verification link: /email/verify/{id}/{hash}
     #    - Link includes signature to prevent tampering
     #    - Signature includes: user ID, email, timestamp
     #    - Email sent via configured mail driver
     #    - Template: emails.verify-email (configurable in User::sendEmailVerificationNotification())
     #    - To: User's email address
     #    - Subject: Configurable (typically "Verify Email Address")
     # 
     # 3. SET SUCCESS MESSAGE IN SESSION
     #    - back()->with('status', 'verification-link-sent')
     #    - back(): Return to previous page (verify-email form page)
     #    - with('status', ...): Add message to session flash data
     #    - Flash data: Automatically deleted after displaying
     #    - Blade template checks for $request->session()->get('status')
     #    - If 'verification-link-sent': Shows success message
     # 
     # 4. REDIRECT RESPONSE
     #    - Returns back() - refreshes current page (verify-email.blade.php)
     #    - Page shows: "Verification link sent!" message
     #    - User sees: "Didn't receive the email? Resend" button still available
     # 
     # Email Verification Link Details:
     # - Path: /email/verify/{id}/{hash}
     # - {id}: User's ID from users table
     # - {hash}: Hash of user's email address
     # - Signature: Cryptographically signed URL
     # - Route: routes/auth.php defines: Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
     # - Validation: EmailVerificationRequest validates signature
     # - Expiration: Can be configured (typically valid for 24 hours)
     # 
     # Resend Limits (Optional):
     # - Laravel doesn't rate-limit by default
     # - Can add throttling middleware if desired
     # - Could prevent spam resend (e.g., max 3 per hour)
     # - Currently: Unlimited resend allowed
     # 
     # Security Considerations:
     # - Signature prevents forging verification links for other users
     # - User authentication: Requires logged-in user to resend
     # - Email content: Link has expiration so stolen emails eventually expire
     # - User privacy: Only shows verification link to legitimate user
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
