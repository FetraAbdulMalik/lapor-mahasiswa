<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

# ============================================================================
# ConfirmablePasswordController - Password Confirmation Handler
# ============================================================================
# Handles password confirmation for sensitive operations
# 
# Purpose:
# - Requires user to re-enter password before accessing sensitive features
# - Used for: changing password, updating profile, accessing settings
# - Security: Ensures only user (not attacker with stolen session) can proceed
# - Prevents unauthorized access via stolen cookies/sessions
# 
# Key Features:
# - Password re-authentication: Validates current password
# - Session marker: Sets 'auth.password_confirmed_at' timestamp
# - Security check: Uses Auth guard to validate credentials
# - Error handling: Throws ValidationException with password error
# 
# Password Confirmation Workflow:
# 1. User attempts sensitive operation (change password, update profile)
# 2. Middleware checks if 'auth.password_confirmed_at' exists and is recent
# 3. If not confirmed recently: Redirect to password confirmation page
# 4. User enters password and submits to store()
# 5. Password validated against user's current password hash
# 6. If valid: Set session flag and redirect to original action
# 7. If invalid: Show error and return to confirmation page
# 
# Security Considerations:
# - Uses Auth::guard('web')->validate() with email + password
# - Password verified against bcrypt hash (timing-safe comparison)
# - Session flag has timestamp, can be checked for expiration (typically 3 hours)
# - Prevents CSRF attacks by requiring password re-entry
# - Prevents unauthorized changes even with stolen session cookie
# 
# Session Flag Details:
# - Key: 'auth.password_confirmed_at'
# - Value: time() = Unix timestamp when password was confirmed
# - Used by: Middleware to check if confirmation is recent enough
# - Expiration: Configurable (typically 3 hours or per-session)
# - Invalidation: Logging out clears session flags
#
class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     # 
     # Workflow:
     # - Load and return auth.confirm-password view template
     # - Page displays password input form
     # - Form message: "For security, please confirm your password"
     # - User enters password and submits to store()
     # 
     # Returns:
     # - View: auth.confirm-password blade template
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     * @property string $password
     # 
     # Workflow:
     # 
     # 1. VALIDATE PASSWORD
     #    - Auth::guard('web')->validate():
     #      - 'email': Uses current authenticated user's email
     #      - 'password': Input password from form
     #      - Validates against bcrypt hash in users table
     #      - Returns: boolean true if password correct, false if incorrect
     #    - If validation fails (password incorrect):
     #      - Throw ValidationException with custom message
     #      - Exception includes: 'password' => __('auth.password')
     #      - __('auth.password') translates to localized password error message
     #      - Exception caught by Laravel error handler
     #      - Redirects back to confirm-password with errors displayed
     #      - Error message shows under password field
     # 
     # 2. SET SESSION CONFIRMATION FLAG (if password valid)
     #    - $request->session()->put('auth.password_confirmed_at', time())
     #    - Stores Unix timestamp of confirmation in session
     #    - Key: 'auth.password_confirmed_at'
     #    - Value: time() = current Unix timestamp
     #    - Session persists across requests
     #    - Middleware checks this flag on sensitive operations
     # 
     # 3. REDIRECT TO INTENDED PAGE
     #    - redirect()->intended(route('dashboard'))
     #    - intended(): Remembers page user originally tried to access
     #    - Falls back to dashboard if no intended page
     #    - User sent to originally requested sensitive operation
     #    - Operation can now proceed (password confirmed flag set)
     # 
     # Security Flow:
     # - User visits /profile/edit (requires password confirmation)
     # - Middleware checks 'auth.password_confirmed_at' doesn't exist or expired
     # - Redirects to password confirmation page
     # - User enters password correctly
     # - Session flag set with current timestamp
     # - Redirected to /profile/edit (middleware passes now)
     # - User can edit profile
     # - After 3 hours (or logout): Session flag expires or cleared
     # - Next sensitive operation: Must confirm password again
     # 
     # Error Handling:
     # - ValidationException thrown if password incorrect
     # - Laravel catches exception and returns JSON or redirects
     # - Back to password confirmation form with error message
     # - User can retry with correct password
     # - Session flag NOT set if validation fails
     # 
     # Related Middleware:
     # - Typically in middleware/auth middleware or custom middleware
     # - Checks: auth.password_confirmed_at exists and is recent
     # - Redirects to confirm-password if not confirmed
     # - Can configure expiration time
     */
    public function store(Request $request): RedirectResponse
    {
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->input('password'),
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
