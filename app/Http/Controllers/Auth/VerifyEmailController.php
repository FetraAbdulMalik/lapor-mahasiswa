<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

# ============================================================================
# VerifyEmailController - Email Verification Completion Handler
# ============================================================================
# Handles marking user's email address as verified
# Uses invokable controller pattern (__invoke method)
# 
# Purpose:
# - Marks authenticated user's email as verified in database
# - Called when user clicks email verification link from their inbox
# - Fires Verified event for post-verification actions
# - Redirects user to dashboard with verification success indicator
# 
# Key Features:
# - Invokable controller: Can be called as single action controller
# - EmailVerificationRequest: Automatic validation of verification link
# - Duplicate verification prevention: Checks if already verified
# - Event-based notifications: Fires Verified event
# - Query parameter indicator: Appends ?verified=1 to redirect URL
# 
# Invokable Controller Pattern:
# - Single __invoke() method instead of multiple methods
# - Used for single-action controllers (verify email, cancel something, etc)
# - Routing: Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
# - Called like: $controller() instead of $controller->action()
# - Benefits: Simpler code for single-action endpoints
# 
# Email Verification Flow:
# 1. User receives welcome email with verification link
# 2. Link contains: user ID, email hash, timestamp, signature
# 3. User clicks link in email, browser requests verification endpoint
# 4. EmailVerificationRequest validates: link signature, user ID, email hash
# 5. VerifyEmailController::__invoke() receives request with validated user
# 6. Marks user's email_verified_at timestamp
# 7. Fires Verified event for listeners (logging, welcome email, etc)
# 8. Redirects to dashboard with ?verified=1 showing success
# 
# Security:
# - Link signature: Prevents tampering with user ID or email
# - Timestamp: Expires old links (config/auth.php verification.expire)
# - Hash: Ensures link is for specific user's email
# - Automatic validation: EmailVerificationRequest handles verification
#
class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     # 
     # Workflow:
     # 1. EMAIL ALREADY VERIFIED CHECK
     #    - Call hasVerifiedEmail() method on authenticated user
     #    - Checks if email_verified_at timestamp is not null
     #    - If already verified: Redirect to dashboard with ?verified=1
     #    - Prevents unnecessary database updates
     #    - Return early before attempting to mark verified again
     # 
     # 2. MARK EMAIL AS VERIFIED (if not already verified)
     #    - Call markEmailAsVerified() on user
     #    - Sets email_verified_at = now() in users table
     #    - Returns boolean: true if update successful, false if already verified
     #    - If successful: Fire Verified event
     #      - Listeners can: log verification, send welcome email, etc
     #      - Event includes: User object with verified_at timestamp
     # 
     # 3. REDIRECT TO DASHBOARD
     #    - Redirect to dashboard route
     #    - intended(): Redirects to originally requested page if available
     #    - absolute: false = relative path, respects domain/subdomain
     #    - Query parameter: ?verified=1
     #      - Blade template checks for 'verified' query param
     #      - Shows success message: "Email verified successfully!"
     #      - User sees confirmation in dashboard
     # 
     # Parameters:
     # - EmailVerificationRequest: Custom FormRequest that validates:
     #   - User is authenticated (has session/token)
     #   - Link hash matches user's email
     #   - Signature is valid (not tampered)
     #   - Request automatically provides $request->user()
     # 
     # Returns:
     # - RedirectResponse: Redirects to dashboard with ?verified=1
     # 
     # Security Flow:
     # - EmailVerificationRequest validates signature before __invoke runs
     # - Invalid signature: FormRequest returns 403 Forbidden
     # - Valid signature: __invoke runs with guaranteed valid request
     # - User is verified before reaching controller
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
