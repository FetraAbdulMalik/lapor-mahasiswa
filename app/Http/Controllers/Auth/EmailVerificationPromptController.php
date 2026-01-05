<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

# ============================================================================
# EmailVerificationPromptController - Email Verification Prompt Display
# ============================================================================
# Shows email verification prompt if user's email is not yet verified
# Uses invokable controller pattern (__invoke method)
# 
# Purpose:
# - Checks if user's email is verified
# - If verified: Redirects to dashboard (no need to verify)
# - If not verified: Shows verify-email page
# - Can also trigger resend of verification email
# 
# Key Features:
# - Invokable controller: Single __invoke() method
# - Conditional logic: Returns different response based on verification status
# - Ternary operator: One-line conditional for simple logic
# - Return type union: Returns RedirectResponse OR View
# 
# Invokable Controller Pattern:
# - Single __invoke() method for single action
# - Used when controller has one primary responsibility
# - Routing: Route::get('/email/verify', EmailVerificationPromptController::class)
# - Called as: $controller() instead of $controller->method()
# - Benefits: Cleaner code for simple operations
# 
# Email Verification State Machine:
# 1. After registration: email_verified_at = null
# 2. User sees verify-email prompt (this controller)
# 3. Click "Resend Email" -> EmailVerificationNotificationController sends link
# 4. Click link in email -> VerifyEmailController marks as verified
# 5. Next request to this controller -> Redirects to dashboard (verified)
# 
# Middleware Integration:
# - Often protected by 'verified' middleware
# - Also accessed directly from dashboard/app pages
# - Shows reminder until user verifies email
# 
# User Flow:
# 1. User completes registration
# 2. Application redirects to this endpoint
# 3. Controller checks: hasVerifiedEmail() = false
# 4. Returns verify-email view with "Resend Email" button
# 5. User clicks "Resend Email" button
# 6. Request goes to EmailVerificationNotificationController
# 7. Verification email sent with link
# 8. User clicks link, goes to VerifyEmailController
# 9. Email marked verified, user sent here again
# 10. hasVerifiedEmail() = true, redirects to dashboard
#
class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     # 
     # Workflow (Single Line with Ternary Operator):
     # 
     # 1. CHECK VERIFICATION STATUS
     #    - Call hasVerifiedEmail() on $request->user()
     #    - Checks if user.email_verified_at timestamp is not null
     #    - Returns: boolean true/false
     # 
     # 2. CONDITIONAL RESPONSE (Ternary Operator)
     #    - If true (email verified):
     #      - redirect()->intended(route('dashboard'))
     #      - Redirects to dashboard route
     #      - intended() remembers if user tried another page first
     #      - absolute: false = relative path, respects domain
     #      - User sees dashboard, no verification needed
     #    - If false (email NOT verified):
     #      - view('auth.verify-email')
     #      - Returns verify-email blade template
     #      - Shows "Verify Your Email" page with:
     #        - Message: "Please verify your email address"
     #        - Button: "Resend Verification Email" (posts to EmailVerificationNotificationController)
     # 
     # Parameters:
     # - Request $request: Contains authenticated user via $request->user()
     #   - Typically protected by 'auth' middleware
     #   - $request->user() returns current authenticated User model
     # 
     # Returns:
     # - RedirectResponse|View (union type)
     #   - RedirectResponse: If email already verified, redirect to dashboard
     #   - View: If email not verified, show verify-email prompt page
     # 
     # Blade Template Access (in verify-email.blade.php):
     # - Can access $request->user() in view
     # - Can show user's email: {{ $request->user()->email }}
     # - Can show helper text: "We've sent verification link to your email"
     # - Can show resend button form that posts to resend endpoint
     # 
     # Related Endpoints:
     # - EmailVerificationNotificationController: Resends verification email
     # - VerifyEmailController: Marks email as verified when link clicked
     # - Routes in routes/auth.php:
     #   - GET /email/verify -> This controller (show prompt)
     #   - POST /email/verification-notification -> EmailVerificationNotificationController
     #   - GET /email/verify/{id}/{hash} -> VerifyEmailController
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(route('dashboard', absolute: false))
                    : view('auth.verify-email');
    }
}
