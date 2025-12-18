<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'app_name' => config('app.name', 'Lapor Mahasiswa'),
            'app_timezone' => config('app.timezone', 'Asia/Jakarta'),
            'app_locale' => config('app.locale', 'id'),
            'mail_from_address' => config('mail.from.address', 'noreply@university.ac.id'),
            'mail_from_name' => config('mail.from.name', 'Lapor Mahasiswa'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_timezone' => 'required|string|max:50',
            'app_locale' => 'required|string|max:5',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string|max:255',
        ]);

        // In a real application, you would save these to a database or .env file
        // For now, we'll just cache them
        foreach ($validated as $key => $value) {
            Cache::forever("settings.{$key}", $value);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
