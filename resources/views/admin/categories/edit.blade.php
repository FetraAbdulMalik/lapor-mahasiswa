@extends('layouts.admin', ['title' => 'Edit Kategori'])

@section('content')

<!-- Header -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Edit Kategori Laporan</h2>
    <p class="text-gray-600">Perbarui informasi kategori</p>
</div>

<!-- Form Card -->
<div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
    <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Kategori *
            </label>
            <input type="text" id="name" name="name" required maxlength="255"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                   value="{{ old('name', $category->name) }}">
            @error('name')
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
                      placeholder="Deskripsi kategori ini...">{{ old('description', $category->description) }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Icon & Color -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                    Icon (Emoji atau Unicode)
                </label>
                <div class="flex items-center space-x-3">
                    <input type="text" id="icon" name="icon" maxlength="50"
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('icon') border-red-500 @enderror"
                           placeholder="📋"
                           value="{{ old('icon', $category->icon) }}">
                    <div class="text-4xl" id="iconPreview">{{ $category->icon ?? '📋' }}</div>
                </div>
                @error('icon')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                    Warna
                </label>
                <div class="flex items-center space-x-3">
                    <input type="color" id="color" name="color"
                           class="h-10 px-3 rounded-lg cursor-pointer border border-gray-300 @error('color') border-red-500 @enderror"
                           value="{{ old('color', $category->color ?? '#6366f1') }}">
                    <input type="text" id="colorText" readonly
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                           value="{{ old('color', $category->color ?? '#6366f1') }}">
                </div>
                @error('color')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Active Status -->
        <div class="flex items-center">
            <input type="checkbox" id="is_active" name="is_active" 
                   class="h-4 w-4 text-navy-800 focus:ring-blue-500 border-gray-300 rounded"
                   {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
            <label for="is_active" class="ml-2 block text-sm text-gray-700">
                Aktifkan kategori ini
            </label>
        </div>

        <!-- Buttons -->
        <div class="flex items-center justify-between pt-6 border-t">
            <a href="{{ route('admin.categories.index') }}" class="btn-secondary">
                Batal
            </a>
            <button type="submit" class="btn-primary">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<!-- Script for Icon Preview -->
<script>
document.getElementById('icon').addEventListener('input', function() {
    document.getElementById('iconPreview').textContent = this.value || '📋';
});

document.getElementById('color').addEventListener('input', function() {
    document.getElementById('colorText').value = this.value;
});
</script>

@endsection
