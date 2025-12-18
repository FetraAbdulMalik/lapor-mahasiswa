<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Find user by email
        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Email tidak ditemukan dalam sistem.']);
        }

        // Send notification to admin instead of reset link to user
        $adminEmails = User::where('role', 'admin')->orWhere('role', 'super_admin')->pluck('email');
        
        if ($adminEmails->isNotEmpty()) {
            try {
                Mail::send('emails.admin-password-reset-notification', [
                    'userEmail' => $user->email,
                    'userName' => $user->name,
                ], function ($message) use ($adminEmails) {
                    $message->to($adminEmails->toArray())
                        ->subject('Permintaan Reset Password - Lapor Mahasiswa');
                });
            } catch (\Exception $e) {
                // Silently fail if email can't be sent
            }
        }

        // Show success message to user
        return back()->with('status', 'Permintaan reset password Anda telah dikirim ke admin. Admin akan menghubungi Anda segera.');
    }
}
