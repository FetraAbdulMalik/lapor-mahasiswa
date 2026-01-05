@extends('layouts.app', ['title' => 'Buat Laporan Baru'])

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Progress Steps -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between" x-data="{ step: 1 }">
            <div class="flex-1">
                <div class="flex items-center">
                    <div class="flex items-center text-navy-800 relative">
                        <div class="rounded-full h-12 w-12 flex items-center justify-center bg-navy-800 text-white font-bold">
                            1
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-semibold">Pilih Kategori</div>
                        </div>
                    </div>
                    <div class="flex-auto border-t-2 border-gray-300 mx-4"></div>
                    <div class="flex items-center text-gray-400 relative">
                        <div class="rounded-full h-12 w-12 flex items-center justify-center bg-gray-300 text-white font-bold">
                            2
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-semibold">Detail Laporan</div>
                        </div>
                    </div>
                    <div class="flex-auto border-t-2 border-gray-300 mx-4"></div>
                    <div class="flex items-center text-gray-400 relative">
                        <div class="rounded-full h-12 w-12 flex items-center justify-center bg-gray-300 text-white font-bold">
                            3
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-semibold">Upload Bukti</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Form -->
    <form method="POST" action="{{ route('student.reports.store') }}" enctype="multipart/form-data" 
          x-data="reportForm()" @submit="isSubmitting = true">
        @csrf
        
        <div class="bg-white rounded-lg shadow-md p-8">
            
            <!-- Step 1: Category Selection -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Pilih Kategori Laporan</h3>
                <p class="text-gray-600 mb-6">Pilih kategori yang sesuai dengan masalah Anda</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($categories as $category)
                    <label class="relative cursor-pointer">
                        <input type="radio" name="category_id" value="{{ $category->id }}" 
                               class="peer sr-only" required
                               {{ old('category_id') == $category->id ? 'checked' : '' }}>
                        <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-accent-300 peer-checked:border-navy-800 peer-checked:bg-blue-50 transition">
                            <div class="text-3xl mb-2">{{ $category->icon }}</div>
                            <div class="font-bold text-gray-900 mb-1">{{ $category->name }}</div>
                            <div class="text-sm text-gray-600">{{ Str::limit($category->description, 60) }}</div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <hr class="my-8">
            
            <!-- Step 2: Report Details -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Detail Laporan</h3>
                <p class="text-gray-600 mb-6">Jelaskan masalah Anda secara detail dan jelas</p>
                
                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Laporan *
                        </label>
                        <input type="text" id="title" name="title" required maxlength="255"
                               class="input-field @error('title') border-red-500 @enderror"
                               placeholder="Contoh: AC Rusak di Lab Komputer 1"
                               value="{{ old('title') }}">
                        <p class="mt-1 text-sm text-gray-500">Buat judul yang singkat dan jelas</p>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Detail *
                        </label>
                        <textarea id="description" name="description" rows="6" required
                                  class="input-field @error('description') border-red-500 @enderror"
                                  placeholder="Jelaskan masalah secara detail:  apa yang terjadi, sejak kapan, dampaknya, dll.  (Minimal 50 karakter)">{{ old('description') }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Minimal 50 karakter.  Semakin detail semakin baik. </p>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Location -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="building_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Gedung
                            </label>
                            <select id="building_id" name="building_id" 
                                    class="input-field @error('building_id') border-red-500 @enderror"
                                    @change="loadFacilities($event.target.value)">
                                <option value="">Pilih Gedung</option>
                                @foreach($buildings as $building)
                                    <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>
                                        {{ $building->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('building_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="facility_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Ruangan/Fasilitas
                            </label>
                            <select id="facility_id" name="facility_id" 
                                    class="input-field @error('facility_id') border-red-500 @enderror">
                                <option value="">Pilih Ruangan (Optional)</option>
                            </select>
                            @error('facility_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Lokasi Tambahan
                        </label>
                        <input type="text" id="location" name="location"
                               class="input-field @error('location') border-red-500 @enderror"
                               placeholder="Contoh:  Dekat pintu masuk, lantai 2, sebelah kiri"
                               value="{{ old('location') }}">
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Incident Date & Priority -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="incident_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Kejadian
                            </label>
                            <input type="date" id="incident_date" name="incident_date"
                                   class="input-field @error('incident_date') border-red-500 @enderror"
                                   max="{{ date('Y-m-d') }}"
                                   value="{{ old('incident_date', date('Y-m-d')) }}">
                            @error('incident_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                                Tingkat Urgensi *
                            </label>
                            <select id="priority" name="priority" required
                                    class="input-field @error('priority') border-red-500 @enderror">
                                <option value="low" {{ old('priority') == 'low' ? 'selected' :  '' }}>Rendah - Tidak Mendesak</option>
                                <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Sedang - Perlu Ditangani</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi - Mengganggu</option>
                                <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Mendesak - Sangat Penting</option>
                            </select>
                            @error('priority')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Visibility -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Lapor Sebagai *
                        </label>
                        <div class="space-y-3">
                            <label class="flex items-start cursor-pointer">
                                <input type="radio" name="visibility" value="public" 
                                       {{ old('visibility', 'public') == 'public' ? 'checked' : '' }}
                                       class="mt-1 h-4 w-4 text-navy-800">
                                <div class="ml-3">
                                    <span class="font-medium text-gray-900">Publik</span>
                                    <p class="text-sm text-gray-600">Nama Anda akan terlihat, laporan bisa dilihat siapa saja</p>
                                </div>
                            </label>
                            <label class="flex items-start cursor-pointer">
                                <input type="radio" name="visibility" value="anonymous"
                                       {{ old('visibility') == 'anonymous' ? 'checked' : '' }}
                                       class="mt-1 h-4 w-4 text-navy-800">
                                <div class="ml-3">
                                    <span class="font-medium text-gray-900">Anonim</span>
                                    <p class="text-sm text-gray-600">Identitas Anda disembunyikan, hanya admin yang tahu</p>
                                </div>
                            </label>
                            <label class="flex items-start cursor-pointer">
                                <input type="radio" name="visibility" value="private"
                                       {{ old('visibility') == 'private' ? 'checked' : '' }}
                                       class="mt-1 h-4 w-4 text-navy-800">
                                <div class="ml-3">
                                    <span class="font-medium text-gray-900">Private</span>
                                    <p class="text-sm text-gray-600">Hanya Anda dan admin yang bisa melihat</p>
                                </div>
                            </label>
                        </div>
                        @error('visibility')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <hr class="my-8">
            
            <!-- Step 3: Attachments -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Upload Bukti (Opsional)</h3>
                <p class="text-gray-600 mb-6">Upload foto atau dokumen pendukung laporan Anda</p>
                
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <label for="attachments" class="cursor-pointer">
                        <span class="text-navy-800 font-semibold">Upload file</span>
                        <span class="text-gray-600"> atau drag & drop</span>
                    </label>
                    <input type="file" id="attachments" name="attachments[]" multiple accept="image/*,. pdf,.doc,.docx"
                           class="hidden" onchange="previewFiles(this)">
                    <p class="text-sm text-gray-500 mt-2">JPG, PNG, PDF, DOC (Max 5 file, 5MB per file)</p>
                </div>
                
                <div id="preview-container" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                
                @error('attachments.*')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Terms -->
            <div class="mb-6">
                <label class="flex items-start cursor-pointer">
                    <input type="checkbox" name="terms" required class="mt-1 h-4 w-4 text-navy-800">
                    <span class="ml-3 text-sm text-gray-700">
                        Saya menyatakan bahwa informasi yang saya berikan adalah benar dan dapat dipertanggungjawabkan.  
                        Saya memahami bahwa laporan palsu dapat dikenakan sanksi. 
                    </span>
                </label>
            </div>
            
            <!-- Submit Buttons -->
            <div class="flex items-center justify-between pt-6 border-t">
                <a href="{{ route('student.reports.index') }}" class="btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn-primary" x-bind:disabled="isSubmitting">
                    <span x-show="! isSubmitting">Kirim Laporan</span>
                    <span x-show="isSubmitting" class="flex items-center">
                        <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Mengirim... 
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function reportForm() {
    return {
        isSubmitting: false
    }
}

// Load facilities based on building
async function loadFacilities(buildingId) {
    const facilitySelect = document.getElementById('facility_id');
    facilitySelect.innerHTML = '<option value="">Loading... </option>';
    
    if (!buildingId) {
        facilitySelect.innerHTML = '<option value="">Pilih Gedung dulu</option>';
        return;
    }
    
    try {
        const response = await fetch(`/api/facilities/${buildingId}`);
        const facilities = await response.json();
        
        facilitySelect.innerHTML = '<option value="">Pilih Ruangan (Optional)</option>';
        facilities.forEach(facility => {
            const option = document.createElement('option');
            option.value = facility.id;
            option.textContent = `${facility.name} (${facility.code}) - Lt. ${facility.floor}`;
            facilitySelect.appendChild(option);
        });
    } catch (error) {
        facilitySelect.innerHTML = '<option value="">Error loading facilities</option>';
    }
}

// Preview uploaded files
function previewFiles(input) {
    const container = document.getElementById('preview-container');
    container.innerHTML = '';
    
    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative border rounded-lg p-2';
                
                if (file.type.startsWith('image/')) {
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-24 object-cover rounded">
                        <p class="text-xs text-gray-600 mt-1 truncate">${file.name}</p>
                    `;
                } else {
                    div.innerHTML = `
                        <div class="w-full h-24 bg-gray-100 rounded flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-600 mt-1 truncate">${file.name}</p>
                    `;
                }
                
                container.appendChild(div);
            };
            
            reader.readAsDataURL(file);
        });
    }
}
</script>
@endpush
@endsection
