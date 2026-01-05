@extends('layouts.admin', ['title' => 'Buat Gedung'])

@section('content')

<!-- Header -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Buat Gedung Baru</h2>
    <p class="text-gray-600">Tambahkan gedung baru ke sistem</p>
</div>

<!-- Form Card -->
<div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
    <form method="POST" action="{{ route('admin.buildings.store') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Gedung *
            </label>
            <input type="text" id="name" name="name" required maxlength="255"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                   value="{{ old('name') }}"
                   placeholder="Contoh: Gedung A">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Code -->
        <div>
            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                Kode Gedung *
            </label>
            <input type="text" id="code" name="code" required maxlength="10"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('code') border-red-500 @enderror"
                   value="{{ old('code') }}"
                   placeholder="Contoh: GD-A">
            @error('code')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Location -->
        <div>
            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                Lokasi
            </label>
            <input type="text" id="location" name="location" maxlength="255"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('location') border-red-500 @enderror"
                   value="{{ old('location') }}"
                   placeholder="Contoh: Kampus Utama">
            @error('location')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Floors -->
        <div>
            <label for="floors" class="block text-sm font-medium text-gray-700 mb-2">
                Jumlah Lantai
            </label>
            <input type="number" id="floors" name="floors" min="1"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('floors') border-red-500 @enderror"
                   value="{{ old('floors') }}"
                   placeholder="Contoh: 5">
            @error('floors')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                Deskripsi
            </label>
            <textarea id="description" name="description" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                      placeholder="Deskripsi gedung ini...">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Form Actions -->
        <div class="flex gap-3 pt-6">
            <a href="{{ route('admin.buildings.index') }}"
               class="btn-secondary">
                Batal
            </a>
            <button type="submit"
                    class="btn-primary">
                Buat Gedung
            </button>
        </div>
    </form>
</div>

@endsection
