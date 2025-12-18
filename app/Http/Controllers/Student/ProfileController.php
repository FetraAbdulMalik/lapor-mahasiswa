<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display student profile.
     */
    public function index()
    {
        $user = auth()->user();
        $profile = $user->studentProfile;

        return view('student.profile.index', compact('user', 'profile'));
    }

    /**
     * Show edit profile form.
     */
    public function edit()
    {
        $user = auth()->user();
        $profile = $user->studentProfile;

        return view('student.profile.edit', compact('user', 'profile'));
    }

    /**
     * Update student profile.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $profile = $user->studentProfile;

        $validated = $request->validate([
            'name' => 'required|string|max: 255',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update user
        $user->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($profile->avatar) {
                Storage:: disk('public')->delete($profile->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $profile->update(['avatar' => $path]);
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}