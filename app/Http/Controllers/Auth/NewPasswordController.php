<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

# ============================================================================
# NewPasswordController - Password Reset Implementation
# ============================================================================
# Handles complete password reset flow using Laravel's Password broker
# 
# Purpose:
# - Completes self-service password reset for authenticated and unauthenticated users
# - Validates reset token and user identity
# - Securely updates password with new hash
# - Fires PasswordReset event for post-reset actions
# 
# Key Features:
# - Token validation: Uses Password broker to validate reset token
# - Atomic password update: Changes password and regenerates remember_token together
# - Event-based notifications: Fires PasswordReset event for event listeners
# - Error handling: Shows email-specific errors (invalid token, wrong email)
# - User lookup: Password broker finds user by email
# 
# Password Reset Flow:
# 1. User receives password reset link with token (from PasswordResetLinkController or LoginController)
# 2. Token sent to create() method which displays reset form
# 3. User enters new password and submits to store()
# 4. Password broker validates token and executes closure with user
# 5. Closure hashes new password and regenerates remember_token
# 6. User redirected to login page with success message
# 
# Security:
# - Token validation: Broker ensures token is valid and not expired (default 60 min)
# - Password hashing: Uses bcrypt via Hash::make()
# - Token regeneration: remember_token refreshed to invalidate old sessions
# - Email verification: Token tied to specific email, prevents wrong user reset
# - Event firing: Allows listeners to log reset, notify user, etc.
#
class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     # 
     # Workflow:
     # - Returns auth.reset-password view with request passed as data
     # - Request passed so view can access: token, email from URL query params
     # - Blade template uses $request->query('token') and $request->query('email')
     # 
     # Parameters:
     # - Request: Contains token and email from reset link in URL
     # 
     # Returns:
     # - View: auth.reset-password blade template with password reset form
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     # 
     # Workflow:
     # 
     # 1. VALIDATION PHASE
     #    - token: required, sent in URL query param from reset link
     #    - email: required, user's email address attempting reset
     #    - password: required, confirmed (password_confirmation must match)
     #               Uses Password::defaults() = min 8, uppercase, number, symbol
     # 
     # 2. PASSWORD BROKER RESET PHASE (Password::reset())
     #    - Laravel's Password facade handles token validation
     #    - Password::reset() looks up reset token in password_resets table
     #    - Validates: token exists, matches email, not expired (60 min default)
     #    - If valid: Finds User by email, executes closure with user
     #    - If invalid: Returns error constant (PASSWORD_RESET_FAILED, INVALID_TOKEN, etc)
     # 
     # 3. CLOSURE EXECUTION (when token valid)
     #    - Receives: User $user (looked up by broker)
     #    - forceFill(): Directly updates model attributes, bypassing mutators
     #    - password: New password hashed with Hash::make(bcrypt)
     #    - remember_token: Regenerated with random 60-char string
     #                      Invalidates all remember-me cookies
     #    - save(): Persists changes to database
     #    - Fires PasswordReset event:
     #      - Listeners can log reset, notify admin, update audit trail
     #      - Event includes: User object, timestamp
     # 
     # 4. ERROR HANDLING
     #    - If $status == Password::PASSWORD_RESET (success constant)
     #      - Redirect to login with success message
     #      - Message: "Your password has been reset. Please login."
     #      - User logs in with new password on next login
     #    - If status != PASSWORD_RESET (failure - invalid token, expired, etc)
     #      - Redirect back to form with error
     #      - withInput('email'): Repopulates email field
     #      - withErrors: Shows error message under email field
     # 
     # 5. REDIRECT OUTCOMES
     #    - Success: redirect to login page with 'status' query showing success message
     #    - Failure: back() with email field pre-filled and error message shown
     # 
     # Security Considerations:
     # - Token validation: Broker ensures token legitimate and not expired
     # - Password hashing: New password hashed, old hash completely replaced
     # - Session invalidation: remember_token regeneration invalidates old sessions
     # - Email verification: Token tied to email, prevents account hijacking
     # - Error messages: Generic error messages don't reveal if email exists
     # - Atomic operation: Password and remember_token updated together in single transaction
     # 
     # Password Reset Token Details:
     # - Stored in: password_resets table (email, token, created_at)
     # - Expires: 60 minutes (config/auth.php 'expire')
     # - Format: Hashed token for security
     # - Auto-cleanup: Laravel can manually delete after use or auto-cleanup job
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->input('password')),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
