<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

# =====================================================================
# STUDENT PROFILE CONTROLLER - Manajemen profil mahasiswa
# =====================================================================
# Controller ini menangani CRUD profil student/mahasiswa:
# - index(): Tampilkan profil user (name, email, phone, avatar)
# - edit(): Form edit profil (name, phone, avatar)
# - update(): Update profil dengan validasi file upload (avatar)
# - updatePassword(): Update password dengan current_password verification
# =====================================================================
# Features:
#   - Profile picture upload dengan validasi file (jpg/png, max 2MB)
#   - Password update dengan confirmation & strength validation
#   - Avatar storage di public disk (storage/app/public/avatars)
#   - Old avatar deletion saat upload avatar baru (cleanup storage)
#   - Password hashing dengan Hash::make() (bcrypt)
#   - Current password verification (Hash::check via current_password rule)
# =====================================================================
# Security:
#   - Only authenticated users (auth middleware)
#   - current_password field required untuk update password
#   - Password strength validation (min 8 char, uppercase, number, symbol)
#   - File upload validation (mimes, max size 2MB)
#   - Storage path: public/avatars (accessible via web)
# =====================================================================

class ProfileController extends Controller
{
    # ===================================================================
    # index() - Tampilkan profil user yang sedang login
    # ===================================================================
    # Menampilkan data profil mahasiswa berdasarkan authenticated user
    # Load user & relationship studentProfile untuk profile details
    # Return: view('student.profile.index', $data)
    
    /**
     * Display student profile.
     */
    public function index()
    {
        $user = auth()->user();
        $profile = $user->studentProfile;

        return view('student.profile.index', compact('user', 'profile'));
    }

    # ===================================================================
    # edit() - Tampilkan form edit profil
    # ===================================================================
    # Load profil user saat ini untuk pre-fill form fields
    # User bisa edit: name, phone, avatar
    # Return: view('student.profile.edit', $data)
    
    /**
     * Show edit profile form.
     */
    public function edit()
    {
        $user = auth()->user();
        $profile = $user->studentProfile;

        return view('student.profile.edit', compact('user', 'profile'));
    }

    # ===================================================================
    # update() - Update profil user (name, phone, avatar)
    # ===================================================================
    # Proses:
    # 1. Validate input (name required, phone optional, avatar image max 2MB)
    # 2. Update user table (name, phone)
    # 3. Handle avatar upload - delete old, store new to public/avatars
    # 4. Update studentProfile table (avatar path)
    # 5. Redirect back dengan success message
    # Return: redirect()->back() dengan session success message
    
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

    # ===================================================================
    # updatePassword() - Update password dengan verification
    # ===================================================================
    # Proses:
    # 1. Validate: current_password (verify matches user password)
    # 2. Validate: password dengan confirmation & strength rules
    # 3. Hash password baru dengan Hash::make() (bcrypt)
    # 4. Update user.password di database
    # 5. Return redirect dengan success message
    # Parameter: password confirmation required, password strength rules
    
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