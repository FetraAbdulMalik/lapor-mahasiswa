<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

# ============================================================================
# SettingsController - Application Configuration & System Management
# ============================================================================
# Manages system settings, database backups, cache/log clearing
# 
# Purpose: System configuration, maintenance operations, data backup/cleanup
# Features: Email/app settings, database backup, cache clear, log clear
# Use: System administration, maintenance, configuration updates
#

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

    /**
     * Backup database
     */
    public function backupDatabase()
    {
        try {
            $filename = 'lapor-mahasiswa-backup-' . now()->format('Y-m-d-H-i-s') . '.sql';
            $backupPath = storage_path('backups/' . $filename);
            
            // Create backups directory if not exists
            if (!File::exists(storage_path('backups'))) {
                File::makeDirectory(storage_path('backups'), 0755, true);
            }

            // Execute mysqldump command
            $command = sprintf(
                'mysqldump --user=%s --password=%s %s > %s',
                env('DB_USERNAME'),
                env('DB_PASSWORD'),
                env('DB_DATABASE'),
                escapeshellarg($backupPath)
            );

            exec($command, $output, $return_var);

            if ($return_var === 0 && file_exists($backupPath)) {
                return redirect()->route('admin.settings.index')
                    ->with('success', "Database backup created: {$filename}");
            } else {
                return redirect()->route('admin.settings.index')
                    ->with('error', 'Failed to create database backup.');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Clear application cache
     */
    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            return redirect()->route('admin.settings.index')
                ->with('success', 'Application cache cleared successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                ->with('error', 'Error clearing cache: ' . $e->getMessage());
        }
    }

    /**
     * Clear application logs
     */
    public function clearLogs()
    {
        try {
            $logPath = storage_path('logs');
            
            if (File::exists($logPath)) {
                $files = File::glob($logPath . '/*');
                foreach ($files as $file) {
                    if (File::isFile($file)) {
                        File::delete($file);
                    }
                }
                return redirect()->route('admin.settings.index')
                    ->with('success', 'Application logs cleared successfully.');
            }
            
            return redirect()->route('admin.settings.index')
                ->with('warning', 'No logs found to clear.');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                ->with('error', 'Error clearing logs: ' . $e->getMessage());
        }
    }
}
