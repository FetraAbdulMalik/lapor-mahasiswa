@extends('layouts.app', ['title' => 'Edit Laporan'])

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('student.reports.show', $report->id) }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Detail
        </a>
    </div>

    <!-- Edit Form -->
    <form method="POST" action="{{ route('student.reports.update', $report->id) }}" enctype="multipart/form-data" 
          x-data="reportForm()" @submit="validateForm($event)">
        @csrf
        @method('PUT')
        
        {{-- # ERROR ALERT - Tampilkan jika ada validation errors --}}
        @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <h4 class="font-semibold text-red-800 mb-2">⚠️ Ada kesalahan dalam pengisian form:</h4>
            <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <div class="bg-white rounded-lg shadow-md p-8">
            
            <!-- Report Info -->
            <div class="mb-8 pb-8 border-b">
                <h3 class="text-sm font-semibold text-gray-500 mb-4">INFORMASI LAPORAN</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Nomor Referensi</p>
                        <p class="text-lg font-bold text-gray-900">{{ $report->reference_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <p class="text-lg font-bold">
                            <span class="px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-800">
                                {{ $report->status_label }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Category Selection -->
            <div class="mb-8">
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Kategori Laporan *
                </label>
                <select id="category_id" name="category_id" required
                        class="input-field @error('category_id') border-red-500 @enderror">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $report->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title -->
            <div class="mb-8">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Laporan *
                </label>
                <input type="text" id="title" name="title" required maxlength="255"
                       class="input-field @error('title') border-red-500 @enderror"
                       placeholder="Contoh: AC Rusak di Lab Komputer 1"
                       value="{{ old('title', $report->title) }}">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-8">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi Detail *
                </label>
                <textarea id="description" name="description" rows="6" required minlength="50"
                          class="input-field @error('description') border-red-500 @enderror"
                          placeholder="Jelaskan masalah secara detail...">{{ old('description', $report->description) }}</textarea>
                <p class="mt-1 text-sm text-gray-500">Minimal 50 karakter</p>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div class="mb-8">
                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                    Lokasi Kejadian
                </label>
                <input type="text" id="location" name="location" maxlength="255"
                       class="input-field"
                       placeholder="Contoh: Gedung A Lantai 2"
                       value="{{ old('location', $report->location) }}">
            </div>

            <!-- Building & Facility -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label for="building_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Gedung
                    </label>
                    <select id="building_id" name="building_id"
                            class="input-field"
                            @change="loadFacilities()">
                        <option value="">Pilih Gedung (opsional)</option>
                        @foreach($buildings as $building)
                            <option value="{{ $building->id }}" {{ old('building_id', $report->building_id) == $building->id ? 'selected' : '' }}>
                                {{ $building->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="facility_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Fasilitas
                    </label>
                    <select id="facility_id" name="facility_id" class="input-field">
                        <option value="">Pilih Fasilitas (opsional)</option>
                        @foreach($facilities as $facility)
                            <option value="{{ $facility->id }}" {{ old('facility_id', $report->facility_id) == $facility->id ? 'selected' : '' }}>
                                {{ $facility->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Incident Date -->
            <div class="mb-8">
                <label for="incident_date" class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Kejadian
                </label>
                <input type="date" id="incident_date" name="incident_date"
                       class="input-field"
                       value="{{ old('incident_date', $report->incident_date) }}">
            </div>

            <!-- Priority -->
            <div class="mb-8">
                <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                    Tingkat Prioritas *
                </label>
                <select id="priority" name="priority" required
                        class="input-field @error('priority') border-red-500 @enderror">
                    <option value="">Pilih Prioritas</option>
                    <option value="low" {{ old('priority', $report->priority) == 'low' ? 'selected' : '' }}>🟢 Rendah</option>
                    <option value="medium" {{ old('priority', $report->priority) == 'medium' ? 'selected' : '' }}>🟡 Sedang</option>
                    <option value="high" {{ old('priority', $report->priority) == 'high' ? 'selected' : '' }}>🟠 Tinggi</option>
                    <option value="urgent" {{ old('priority', $report->priority) == 'urgent' ? 'selected' : '' }}>🔴 Urgen</option>
                </select>
                @error('priority')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Visibility -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Visibilitas Laporan *
                </label>
                <div class="space-y-3">
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="visibility" value="public" required
                               class="mr-3" {{ old('visibility', $report->visibility) == 'public' ? 'checked' : '' }}>
                        <div>
                            <p class="font-medium text-gray-900">Publik</p>
                            <p class="text-sm text-gray-600">Laporan dapat dilihat oleh semua mahasiswa</p>
                        </div>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="visibility" value="private" required
                               class="mr-3" {{ old('visibility', $report->visibility) == 'private' ? 'checked' : '' }}>
                        <div>
                            <p class="font-medium text-gray-900">Pribadi</p>
                            <p class="text-sm text-gray-600">Hanya Anda dan admin yang dapat melihat</p>
                        </div>
                    </label>
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="visibility" value="anonymous" required
                               class="mr-3" {{ old('visibility', $report->visibility) == 'anonymous' ? 'checked' : '' }}>
                        <div>
                            <p class="font-medium text-gray-900">Anonim</p>
                            <p class="text-sm text-gray-600">Laporan tidak menampilkan nama Anda</p>
                        </div>
                    </label>
                </div>
                @error('visibility')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-between pt-6 border-t">
                <a href="{{ route('student.reports.show', $report->id) }}" class="btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn-primary" x-bind:disabled="isSubmitting">
                    <span x-show="! isSubmitting">Simpan Perubahan</span>
                    <span x-show="isSubmitting" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function reportForm() {
        return {
            isSubmitting: false,
            {{-- # VALIDASI FORM CLIENT-SIDE --}}
            {{-- # Cek field required sebelum submit --}}
            validateForm(event) {
                {{-- # GET FORM REFERENCE --}}
                const form = event.target;
                let hasError = false;
                const errorMessages = [];
                
                {{-- # VALIDASI: CATEGORY HARUS DIPILIH --}}
                const categorySelect = form.querySelector('select[name="category_id"]');
                if (!categorySelect.value) {
                    hasError = true;
                    errorMessages.push('❌ Pilih kategori laporan terlebih dahulu');
                }
                
                {{-- # VALIDASI: TITLE TIDAK BOLEH KOSONG --}}
                const titleInput = form.querySelector('input[name="title"]');
                if (!titleInput.value.trim()) {
                    hasError = true;
                    errorMessages.push('❌ Judul laporan tidak boleh kosong');
                }
                
                {{-- # VALIDASI: DESCRIPTION MINIMAL 50 KARAKTER --}}
                const descriptionInput = form.querySelector('textarea[name="description"]');
                if (!descriptionInput.value.trim()) {
                    hasError = true;
                    errorMessages.push('❌ Deskripsi laporan tidak boleh kosong');
                } else if (descriptionInput.value.trim().length < 50) {
                    hasError = true;
                    errorMessages.push('❌ Deskripsi minimal 50 karakter (saat ini: ' + descriptionInput.value.trim().length + ')');
                }
                
                {{-- # VALIDASI: PRIORITY HARUS DIPILIH --}}
                const prioritySelect = form.querySelector('select[name="priority"]');
                if (!prioritySelect.value) {
                    hasError = true;
                    errorMessages.push('❌ Pilih prioritas laporan');
                }
                
                {{-- # JIKA ADA ERROR, TAMPILKAN ALERT DAN PREVENT FORM SUBMIT --}}
                if (hasError) {
                    alert('⚠️ Mohon lengkapi form terlebih dahulu:\n\n' + errorMessages.join('\n'));
                    event.preventDefault();
                    return false;
                }
                
                {{-- # SEMUA VALIDASI PASSED, SET SUBMITTING STATE & ALLOW FORM SUBMIT --}}
                this.isSubmitting = true;
                return true;
            },
            loadFacilities() {
                const buildingId = document.getElementById('building_id').value;
                if (!buildingId) {
                    document.getElementById('facility_id').innerHTML = '<option value="">Pilih Fasilitas (opsional)</option>';
                    return;
                }
                
                fetch(`/student/reports/facilities/${buildingId}`)
                    .then(response => response.json())
                    .then(facilities => {
                        let html = '<option value="">Pilih Fasilitas (opsional)</option>';
                        facilities.forEach(facility => {
                            html += `<option value="${facility.id}">${facility.name}</option>`;
                        });
                        document.getElementById('facility_id').innerHTML = html;
                    });
            }
        }
    }
</script>
@endsection
