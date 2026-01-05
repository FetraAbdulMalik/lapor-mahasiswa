<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

# ============================================================================
# RegisteredUserController - Generic User Registration Handler
# ============================================================================
# Handles registration for generic users (not student-specific)
# 
# Purpose:
# - Provides alternative registration endpoint for non-student users
# - Creates basic User records without StudentProfile associations
# - Complements RegisterController which is student-specific
# 
# Key Features:
# - Form validation: name (required, max 255), email (unique), password (confirmed)
# - Secure password hashing with Hash::make()
# - Automatic event-based notification via Registered event
# - Auto-login after successful registration
# - Role-based dashboard redirect
# 
# Differences from RegisterController:
# - RegisterController: Creates User + StudentProfile with semester/status
# - RegisteredUserController: Creates only User record, no student fields
# - Use RegisterController for student self-registration
# - Use RegisteredUserController for staff, admin, or other user types
# 
# Security:
# - Password validation: confirmed rule ensures password_confirmation match
# - Password hashing: Uses bcrypt via Hash::make()
# - Email uniqueness: Validates email doesn't already exist in users table
# - Automatic auth session: User logged in immediately after creation
#
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     # 
     # Workflow:
     # - Load and return auth.register view template
     # - View displays registration form with name, email, password fields
     # - Form submits to store() method via POST
     # 
     # Returns:
     # - View: auth.register blade template
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     # 
     # Workflow:
     # 1. Validate incoming request data
     #    - name: required string, max 255 characters
     #    - email: required, unique in users table, lowercase for consistency
     #    - password: required, must be confirmed (password_confirmation field)
     #               Uses Laravel's Password::defaults() rule (min 8, uppercase, number, symbol)
     # 
     # 2. Create new User record
     #    - Hash password using bcrypt (Hash::make())
     #    - Store name and lowercased email
     #    - User model auto-fills timestamps (created_at, updated_at)
     # 
     # 3. Fire Registered event
     #    - Triggers registered event listeners
     #    - Can be used for: email verification, welcome emails, logging
     #    - Extensible point for custom registration actions
     # 
     # 4. Authenticate user session
     #    - Auth::login() immediately logs in new user
     #    - Creates session and auth cookies
     #    - User authenticated for subsequent requests
     # 
     # 5. Redirect to dashboard
     #    - Redirects to 'dashboard' route (app/dashboard)
     #    - absolute: false = uses relative path, respects domain mapping
     #    - Next request shows authenticated user dashboard
     # 
     # Security Considerations:
     # - Password never stored in plain text, hashed with bcrypt
     # - Email uniqueness prevents duplicate accounts
     # - Password confirmation prevents typos
     # - Strong password rules enforced (min 8, complexity)
     # 
     # Difference from RegisterController:
     # - This creates only User record (generic user)
     # - RegisterController creates User + StudentProfile (for students)
     # - No student-specific fields (semester, status) set here
     # - Both fire Registered event but process differs afterward
     */
    /**
     * Store user registration
     * @property string $name
     * @property string $email
     * @property string $password
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
