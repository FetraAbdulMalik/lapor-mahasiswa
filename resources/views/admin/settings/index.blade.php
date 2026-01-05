@extends('layouts.admin', ['title' => 'Settings'])

@section('content')

<!-- Header -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Pengaturan Sistem</h2>
    <p class="text-gray-600">Kelola konfigurasi dan pengaturan aplikasi</p>
</div>

<!-- Settings Navigation -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <a href="#general" class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition cursor-pointer border-l-4 border-primary-600">
        <h3 class="font-bold text-gray-900">Umum</h3>
        <p class="text-sm text-gray-600">Pengaturan dasar aplikasi</p>
    </a>
    <a href="#email" class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition cursor-pointer">
        <h3 class="font-bold text-gray-900">Email</h3>
        <p class="text-sm text-gray-600">Konfigurasi email</p>
    </a>
    <a href="#backup" class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition cursor-pointer">
        <h3 class="font-bold text-gray-900">Backup</h3>
        <p class="text-sm text-gray-600">Manajemen backup</p>
    </a>
    <a href="#maintenance" class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition cursor-pointer">
        <h3 class="font-bold text-gray-900">Maintenance</h3>
        <p class="text-sm text-gray-600">Mode maintenance</p>
    </a>
</div>

<!-- General Settings -->
<div id="general" class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-4">Pengaturan Umum</h3>
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- App Name -->
            <div>
                <label for="app_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Aplikasi
                </label>
                <input type="text" id="app_name" name="app_name" maxlength="255"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('app_name') border-red-500 @enderror"
                       value="{{ old('app_name', config('app.name', 'Lapor Mahasiswa')) }}">
                @error('app_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Institution Name -->
            <div>
                <label for="institution_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Institusi
                </label>
                <input type="text" id="institution_name" name="institution_name" maxlength="255"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('institution_name') border-red-500 @enderror"
                       value="{{ old('institution_name', config('app.institution', 'Universitas')) }}">
                @error('institution_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                Deskripsi Aplikasi
            </label>
            <textarea id="description" name="description" rows="3"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', 'Platform untuk melaporkan masalah dan keluhan di kampus') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<!-- Email Settings -->
<div id="email" class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-4">Pengaturan Email</h3>
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="mail_driver" class="block text-sm font-medium text-gray-700 mb-2">
                    Driver Email
                </label>
                <select id="mail_driver" name="mail_driver"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="smtp" {{ config('mail.driver') === 'smtp' ? 'selected' : '' }}>SMTP</option>
                    <option value="sendmail" {{ config('mail.driver') === 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                    <option value="log" {{ config('mail.driver') === 'log' ? 'selected' : '' }}>Log</option>
                </select>
            </div>

            <div>
                <label for="mail_from_address" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Pengirim
                </label>
                <input type="email" id="mail_from_address" name="mail_from_address"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                       value="{{ config('mail.from.address', 'noreply@example.com') }}">
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-sm text-blue-900">
                <strong>Catatan:</strong> Untuk konfigurasi email lebih lanjut, silakan edit file <code class="bg-blue-100 px-2 py-1 rounded">.env</code> di root aplikasi.
            </p>
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<!-- Backup Settings -->
<div id="backup" class="bg-white rounded-lg shadow-md p-6 mb-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-4">Manajemen Backup</h3>

    <div class="space-y-4">
        <!-- Database Backup -->
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
            <div>
                <p class="font-medium text-gray-900">Database Backup</p>
                <p class="text-sm text-gray-600">Buat backup database lengkap</p>
            </div>
            <form method="POST" action="{{ route('admin.settings.backup') }}" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition" onclick="return confirm('Buat backup database sekarang?')">
                    Buat Backup
                </button>
            </form>
        </div>

        <!-- Cache Clearing -->
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
            <div>
                <p class="font-medium text-gray-900">Cache Clearing</p>
                <p class="text-sm text-gray-600">Bersihkan cache aplikasi</p>
            </div>
            <form method="POST" action="{{ route('admin.settings.clear-cache') }}" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg text-sm hover:bg-yellow-700 transition" onclick="return confirm('Bersihkan cache aplikasi?')">
                    Bersihkan Cache
                </button>
            </form>
        </div>

        <!-- Log Clearing -->
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
            <div>
                <p class="font-medium text-gray-900">Log Clearing</p>
                <p class="text-sm text-gray-600">Bersihkan file log aplikasi</p>
            </div>
            <form method="POST" action="{{ route('admin.settings.clear-logs') }}" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700 transition" onclick="return confirm('Bersihkan semua log aplikasi?')">
                    Bersihkan Log
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Maintenance Settings -->
<div id="maintenance" class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-4">Mode Maintenance</h3>

    <div class="space-y-4">
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
            <div>
                <p class="font-medium text-gray-900">Status Mode Maintenance</p>
                <p class="text-sm text-gray-600">Aktifkan untuk melakukan pemeliharaan sistem</p>
            </div>
            <div>
                @if(file_exists(storage_path('framework/down')))
                    <span class="px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full font-medium">Aktif</span>
                @else
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full font-medium">Tidak Aktif</span>
                @endif
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-4">
            <p class="text-sm text-blue-900">
                <strong>Info:</strong> Untuk mengaktifkan/menonaktifkan mode maintenance, gunakan perintah artisan:
            </p>
            <p class="text-sm text-blue-900 mt-2 font-mono bg-blue-100 p-2 rounded">
                php artisan down / php artisan up
            </p>
        </div>
    </div>
</div>

@endsection
