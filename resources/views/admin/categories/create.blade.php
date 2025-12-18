@extends('layouts.admin', ['title' => 'Buat Kategori'])

@section('content')

<!-- Header -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Buat Kategori Laporan</h2>
    <p class="text-gray-600">Tambahkan kategori baru untuk mengorganisir laporan</p>
</div>

<!-- Form Card -->
<div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
    <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Kategori *
            </label>
            <input type="text" id="name" name="name" required maxlength="255"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror"
                   value="{{ old('name') }}"
                   placeholder="Contoh: Akademik">
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
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('description') border-red-500 @enderror"
                      placeholder="Deskripsi kategori ini...">{{ old('description') }}</textarea>
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
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('icon') border-red-500 @enderror"
                           placeholder="📋"
                           value="{{ old('icon', '📋') }}">
                    <div class="text-4xl" id="iconPreview">{{ old('icon', '📋') }}</div>
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
                           class="w-12 h-10 border border-gray-300 rounded cursor-pointer @error('color') border-red-500 @enderror"
                           value="{{ old('color', '#3B82F6') }}">
                    <input type="text" id="colorHex" maxlength="7" readonly
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                           value="{{ old('color', '#3B82F6') }}">
                    <div class="w-12 h-10 rounded-lg border-2 border-gray-300" id="colorPreview"
                         style="background-color: {{ old('color', '#3B82F6') }}"></div>
                </div>
                @error('color')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Active Status -->
        <div>
            <label class="flex items-center space-x-3">
                <input type="checkbox" name="is_active" value="1"
                       class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                       {{ old('is_active', true) ? 'checked' : '' }}>
                <span class="text-sm font-medium text-gray-700">Aktif</span>
            </label>
        </div>

        <!-- Form Actions -->
        <div class="flex gap-3 pt-6">
            <a href="{{ route('admin.categories.index') }}"
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                Buat Kategori
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.getElementById('icon').addEventListener('change', function() {
        document.getElementById('iconPreview').textContent = this.value || '📋';
    });

    const colorInput = document.getElementById('color');
    const colorHex = document.getElementById('colorHex');
    const colorPreview = document.getElementById('colorPreview');

    colorInput.addEventListener('change', function() {
        colorHex.value = this.value;
        colorPreview.style.backgroundColor = this.value;
    });

    colorHex.addEventListener('change', function() {
        if (/^#[0-9A-F]{6}$/i.test(this.value)) {
            colorInput.value = this.value;
            colorPreview.style.backgroundColor = this.value;
        }
    });
</script>
@endpush

@endsection
