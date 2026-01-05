<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

# =====================================================================
# PASSWORD CONTROLLER - User Password Management
# =====================================================================
# Handles changing authenticated user's password
# Requires current password verification
# Enforces strong password rules
#
# Methods:
# - update() - Change user password
#
# Features:
# - Current password verification (security check)
# - Password confirmation validation
# - Strong password enforcement (min 8, uppercase, number recommended)
# - Separate validation bag for error display
# - Password hashing before storage
#
# Validation Rules:
# - current_password: required, must match user's actual password
# - password: required, must match confirmation, strong password rules
#
# Security:
# - Current password prevents unauthorized changes
# - Password hashed with bcrypt (one-way)
# - Confirmation prevents typos
# - Strong password rules enforced

class PasswordController extends Controller
{
    # =========== UPDATE PASSWORD ===========
    # Change authenticated user's password
    #
    # Validation Rules:
    # - current_password: required, must match actual password
    # - password: required, confirmed, strong (min 8, uppercase, number)
    #
    # Workflow:
    # 1. Validate current password matches user's actual password
    # 2. Validate new password meets strength requirements
    # 3. Validate password confirmation matches
    # 4. Hash new password with bcrypt
    # 5. Update user password in database
    # 6. Return with status message
    #
    # Security:
    # - Current password prevents unauthorized password changes
    # - Confirmation prevents typos in new password
    # - Password hashing prevents plaintext storage
    # - Uses separate 'updatePassword' validation bag
    #
    # Returns: RedirectResponse back with status message
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        # Validate password change
        # Uses 'updatePassword' validation bag for separate error display
        # current_password rule: checks against Auth::user()->password
        # Password::defaults() enforces: min 8 chars, uppercase, number, symbol recommended
        # confirmed rule: password must match password_confirmation field
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        # Update user password
        # Hash::make() hashes password with bcrypt algorithm
        # Original password never stored, only hash
        # Previous password becomes invalid
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        # Return with status message
        # Status message flashed to session
        return back()->with('status', 'password-updated');
    }
}
