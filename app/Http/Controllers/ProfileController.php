<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

# =====================================================================
# PROFILE CONTROLLER - General User Profile Management
# =====================================================================
# Handles general user profile operations (not role-specific)
# Currently used for display only - actual profile updates handled in
# Student/ProfileController for role-specific functionality
# 
# Methods:
# - edit() - Display profile form view
# - update() - Update profile information with validation
# - destroy() - Delete user account permanently
#
# Features:
# - Email verification reset on email change
# - Password validation on account deletion
# - Session invalidation after deletion
# - Redirect to home after account deletion

class ProfileController extends Controller
{
    # =========== DISPLAY PROFILE FORM ===========
    # Display the user's profile edit form with current data
    # 
    # Workflow:
    # 1. Get current authenticated user
    # 2. Pass user data to view
    # 3. Return profile.edit view
    #
    # Returns: View - profile.edit template with user data
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
