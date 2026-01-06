@extends('layouts.admin', ['title' => 'Edit Fasilitas'])

@section('content')

<!-- Header -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Edit Fasilitas</h2>
    <p class="text-gray-600">Perbarui informasi fasilitas</p>
</div>

<!-- Form Card -->
<div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
    <form method="POST" action="{{ route('admin.facilities.update', $facility->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Building -->
        <div>
            <label for="building_id" class="block text-sm font-medium text-gray-700 mb-2">
                Gedung *
            </label>
            <select id="building_id" name="building_id" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('building_id') border-red-500 @enderror">
                <option value="">-- Pilih Gedung --</option>
                @foreach($buildings as $building)
                    <option value="{{ $building->id }}" {{ old('building_id', $facility->building_id) == $building->id ? 'selected' : '' }}>
                        {{ $building->name }}
                    </option>
                @endforeach
            </select>
            @error('building_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Fasilitas *
            </label>
            <input type="text" id="name" name="name" required maxlength="255"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                   value="{{ old('name', $facility->name) }}">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Code -->
        <div>
            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                Kode Fasilitas *
            </label>
            <input type="text" id="code" name="code" required maxlength="50"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('code') border-red-500 @enderror"
                   value="{{ old('code', $facility->code) }}">
            @error('code')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Type -->
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                Tipe Fasilitas
            </label>
            <select id="type" name="type"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('type') border-red-500 @enderror">
                <option value="">-- Pilih Tipe --</option>
                <option value="classroom" {{ old('type', $facility->type) === 'classroom' ? 'selected' : '' }}>Ruang Kelas</option>
                <option value="lab" {{ old('type', $facility->type) === 'lab' ? 'selected' : '' }}>Laboratorium</option>
                <option value="library" {{ old('type', $facility->type) === 'library' ? 'selected' : '' }}>Perpustakaan</option>
                <option value="cafeteria" {{ old('type', $facility->type) === 'cafeteria' ? 'selected' : '' }}>Kafetaria</option>
                <option value="toilet" {{ old('type', $facility->type) === 'toilet' ? 'selected' : '' }}>Toilet</option>
                <option value="parking" {{ old('type', $facility->type) === 'parking' ? 'selected' : '' }}>Parkir</option>
                <option value="sport_facility" {{ old('type', $facility->type) === 'sport_facility' ? 'selected' : '' }}>Fasilitas Olahraga</option>
                <option value="other" {{ old('type', $facility->type) === 'other' ? 'selected' : '' }}>Lainnya</option>
            </select>
            @error('type')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Floor -->
            <div>
                <label for="floor" class="block text-sm font-medium text-gray-700 mb-2">
                    Lantai *
                </label>
                <input type="number" id="floor" name="floor" required min="1"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('floor') border-red-500 @enderror"
                       value="{{ old('floor', $facility->floor) }}">
                @error('floor')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Capacity -->
            <div>
                <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">
                    Kapasitas
                </label>
                <input type="number" id="capacity" name="capacity" min="1"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('capacity') border-red-500 @enderror"
                       value="{{ old('capacity', $facility->capacity) }}">
                @error('capacity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Location -->
        <div>
            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                Lokasi
            </label>
            <input type="text" id="location" name="location" maxlength="255"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('location') border-red-500 @enderror"
                   value="{{ old('location', $facility->location ?? '') }}">
            @error('location')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Active Status -->
        <div>
            <label class="flex items-center space-x-3">
                <input type="checkbox" name="is_active" value="1"
                       class="w-4 h-4 text-navy-800 border-gray-300 rounded focus:ring-blue-500"
                       {{ old('is_active', $facility->is_active) ? 'checked' : '' }}>
                <span class="text-sm font-medium text-gray-700">Aktif</span>
            </label>
        </div>

        <!-- Form Actions -->
        <div class="flex gap-3 pt-6">
            <a href="{{ route('admin.buildings.show', $facility->building_id) }}"
               class="btn-secondary">
                Batal
            </a>
            <button type="submit"
                    class="btn-primary">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection
