@extends('layouts.app', ['title' => 'Edit Profil'])

@section('content')

<!-- Header -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Edit Profil</h2>
    <p class="text-gray-600">Perbarui informasi profil Anda</p>
</div>

<!-- Edit Profile Form -->
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl">
    <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap *
                </label>
                <input type="text" id="name" name="name" required maxlength="255"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror"
                       value="{{ old('name', $user->name) }}">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email (Read-only) -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email
                </label>
                <input type="email" id="email" readonly
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                       value="{{ $user->email }}">
                <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                    No. Telepon
                </label>
                <input type="tel" id="phone" name="phone" maxlength="20"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                       value="{{ old('phone', $profile?->phone ?? '') }}"
                       placeholder="Contoh: 08123456789">
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- NIM (Read-only) -->
            <div>
                <label for="nim" class="block text-sm font-medium text-gray-700 mb-2">
                    NIM
                </label>
                <input type="text" id="nim" readonly
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                       value="{{ $profile?->nim ?? '-' }}">
                <p class="text-xs text-gray-500 mt-1">NIM tidak dapat diubah</p>
            </div>
        </div>

        <!-- Avatar Upload -->
        <div>
            <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">
                Foto Profil
            </label>
            <div class="flex items-center gap-4">
                @if($profile?->avatar)
                    <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Avatar"
                         class="w-16 h-16 rounded-full object-cover">
                @else
                    <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center">
                        <span class="text-2xl">👤</span>
                    </div>
                @endif
                <div class="flex-1">
                    <input type="file" id="avatar" name="avatar" accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 @error('avatar') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG (Maks 2MB)</p>
                </div>
            </div>
            @error('avatar')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Academic Info (Read-only section) -->
        <div class="border-t pt-6">
            <h3 class="font-bold text-gray-900 mb-4">Informasi Akademik (Tidak dapat diubah)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Fakultas</label>
                    <p class="px-4 py-2 bg-gray-50 rounded-lg text-gray-900">{{ $profile?->faculty?->name ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Jurusan</label>
                    <p class="px-4 py-2 bg-gray-50 rounded-lg text-gray-900">{{ $profile?->department?->name ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Semester</label>
                    <p class="px-4 py-2 bg-gray-50 rounded-lg text-gray-900">{{ $profile?->semester ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Tahun Akademik</label>
                    <p class="px-4 py-2 bg-gray-50 rounded-lg text-gray-900">{{ $profile?->academic_year ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="border-t pt-6 flex gap-3">
            <a href="{{ route('student.profile.index') }}"
               class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<!-- Change Password Section -->
<div class="bg-white rounded-lg shadow-md p-8 max-w-3xl mt-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-4">Ubah Password</h3>
    
    <form method="POST" action="{{ route('student.profile.updatePassword') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                Password Saat Ini *
            </label>
            <input type="password" id="current_password" name="current_password" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('current_password') border-red-500 @enderror">
            @error('current_password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                Password Baru *
            </label>
            <input type="password" id="password" name="password" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('password') border-red-500 @enderror">
            <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter, kombinasi huruf besar, kecil, angka, dan simbol</p>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                Konfirmasi Password *
            </label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('password_confirmation') border-red-500 @enderror">
            @error('password_confirmation')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Ubah Password
            </button>
        </div>
    </form>
</div>

@endsection
