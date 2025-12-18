@extends('layouts.admin', ['title' => 'Edit Gedung'])

@section('content')

<!-- Header -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Edit Gedung</h2>
    <p class="text-gray-600">Perbarui informasi gedung</p>
</div>

<!-- Form Card -->
<div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
    <form method="POST" action="{{ route('admin.buildings.update', $building->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Gedung *
            </label>
            <input type="text" id="name" name="name" required maxlength="255"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror"
                   value="{{ old('name', $building->name) }}">
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
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('code') border-red-500 @enderror"
                   value="{{ old('code', $building->code) }}">
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
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('location') border-red-500 @enderror"
                   value="{{ old('location', $building->location) }}">
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
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('floors') border-red-500 @enderror"
                   value="{{ old('floors', $building->floors) }}">
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
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $building->description) }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Form Actions -->
        <div class="flex gap-3 pt-6">
            <a href="{{ route('admin.buildings.index') }}"
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection
