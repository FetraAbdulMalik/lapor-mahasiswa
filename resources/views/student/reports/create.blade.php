@extends('layouts.app', ['title' => 'Buat Laporan Baru'])

@section('content')
{{-- # CONTAINER UTAMA - Max width 4xl dengan auto margin untuk center --}}
<div class="max-w-4xl mx-auto">
    {{-- # PROGRESS INDICATOR - Menampilkan 3 tahapan pembuatan laporan --}}
    {{-- # Tahap 1: Pilih Kategori (Active) --}}
    {{-- # Tahap 2: Detail Laporan (Inactive) --}}
    {{-- # Tahap 3: Upload Bukti (Inactive) --}}
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between" x-data="{ step: 1 }">
            <div class="flex-1">
                <div class="flex items-center">
                    {{-- # STEP 1: PILIH KATEGORI (Status: Active = Navy) --}}
                    <div class="flex items-center text-navy-800 relative">
                        <div class="rounded-full h-12 w-12 flex items-center justify-center bg-navy-800 text-white font-bold">
                            1
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-semibold">Pilih Kategori</div>
                        </div>
                    </div>
                    {{-- # CONNECTOR LINE ANTARA STEP 1 & 2 --}}
                    <div class="flex-auto border-t-2 border-gray-300 mx-4"></div>
                    {{-- # STEP 2: DETAIL LAPORAN (Status: Inactive = Gray) --}}
                    <div class="flex items-center text-gray-400 relative">
                        <div class="rounded-full h-12 w-12 flex items-center justify-center bg-gray-300 text-white font-bold">
                            2
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-semibold">Detail Laporan</div>
                        </div>
                    </div>
                    {{-- # CONNECTOR LINE ANTARA STEP 2 & 3 --}}
                    <div class="flex-auto border-t-2 border-gray-300 mx-4"></div>
                    {{-- # STEP 3: UPLOAD BUKTI (Status: Inactive = Gray) --}}
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
    
    {{-- # FORM UTAMA - POST ke route student.reports.store --}}
    {{-- # enctype="multipart/form-data" untuk support upload file --}}
    {{-- # x-data="reportForm()" untuk Alpine.js state management --}}
    {{-- # @submit event untuk validate dan disable button saat submit --}}
    <form method="POST" action="{{ route('student.reports.store') }}" enctype="multipart/form-data" 
          x-data="reportForm()" @submit="validateForm($event)">
        {{-- # CSRF Token untuk security Laravel --}}
        @csrf
        
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
        
        {{-- # MAIN FORM CONTAINER --}}
        <div class="bg-white rounded-lg shadow-md p-8">
            
            {{-- # =====================================================
                 STEP 1: PILIH KATEGORI LAPORAN (WITH ANIMATIONS)
                 ===================================================== --}}
            {{-- # User harus memilih kategori sesuai dengan masalahnya --}}
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Pilih Kategori Laporan</h3>
                <p class="text-gray-600 mb-6">Pilih kategori yang sesuai dengan masalah Anda</p>
                
                {{-- # GRID KATEGORI - 3 kolom di desktop, 2 di tablet, 1 di mobile --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    {{-- # LOOP SETIAP KATEGORI DARI DATABASE --}}
                    @foreach($categories as $category)
                    {{-- # LABEL CONTAINER - Cursor pointer karena clickable --}}
                    <label class="relative cursor-pointer group">
                        {{-- # RADIO INPUT KATEGORI - hidden (sr-only) tapi tetap functional --}}
                        {{-- # peer class untuk CSS styling berdasarkan checked state --}}
                        {{-- # old('category_id') untuk retain selection jika ada error --}}
                        <input type="radio" name="category_id" value="{{ $category->id }}" 
                               class="peer sr-only" required
                               {{ old('category_id') == $category->id ? 'checked' : '' }}>
                        {{-- # CARD KATEGORI - Styling berubah saat radio checked --}}
                        {{-- # border-2 = 2px border default gray-200 --}}
                        {{-- # hover:border-accent-300 = border cyan saat hover --}}
                        {{-- # peer-checked:border-navy-800 = border navy saat radio checked --}}
                        {{-- # peer-checked:bg-blue-50 = background light blue saat radio checked --}}
                        {{-- # ANIMASI TERSEDIA: fade-in scale hover, shadow, checked pulse effect --}}
                        <div class="border-2 border-gray-200 rounded-lg p-4 
                                    hover:border-accent-300 hover:shadow-lg hover:scale-105
                                    peer-checked:border-navy-800 peer-checked:bg-blue-50 peer-checked:shadow-md peer-checked:ring-2 peer-checked:ring-navy-300
                                    transition-all duration-300 ease-out
                                    animate-fade-in"
                             style="animation-fill-mode: both; animation-duration: 0.5s; animation-delay: {{ $loop->index * 0.1 }}s;">
                            {{-- # ICON EMOJI KATEGORI - Dari database --}}
                            {{-- # ANIMASI: Icon scale & rotate on hover --}}
                            <div class="text-3xl mb-2 transform group-hover:scale-125 group-hover:rotate-6 transition-transform duration-300 ease-out">
                                {{ $category->icon }}
                            </div>
                            {{-- # NAMA KATEGORI --}}
                            <div class="font-bold text-gray-900 mb-1">{{ $category->name }}</div>
                            {{-- # DESKRIPSI KATEGORI - Limit 60 karakter untuk brevity --}}
                            <div class="text-sm text-gray-600">{{ Str::limit($category->description, 60) }}</div>
                            
                            {{-- # CHECKMARK INDICATOR - Muncul saat card di-check --}}
                            <div class="absolute top-2 right-2 w-6 h-6 bg-navy-800 rounded-full flex items-center justify-center opacity-0 peer-checked:opacity-100 transform scale-0 peer-checked:scale-100 transition-all duration-300">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
                {{-- # ERROR MESSAGE - Tampil jika kategori belum dipilih saat submit --}}
                @error('category_id')
                    <p class="mt-2 text-sm text-red-600 animate-shake">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- # GLOBAL STYLES UNTUK ANIMASI --}}
            <style>
                /* Fade in animation untuk category cards */
                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: translateY(20px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                
                .animate-fade-in {
                    animation: fadeIn forwards;
                }
                
                /* Shake animation untuk error message */
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    25% { transform: translateX(-5px); }
                    75% { transform: translateX(5px); }
                }
                
                .animate-shake {
                    animation: shake 0.4s ease-in-out;
                }
                
                /* Enhanced hover effect - smooth glow */
                label.group:hover .border-gray-200 {
                    box-shadow: 0 0 15px rgba(34, 197, 254, 0.1);
                }
                
                /* Smooth radio transition */
                input[type="radio"]:checked + div {
                    animation: pulse 0.5s ease-out;
                }
                
                @keyframes pulse {
                    0% {
                        box-shadow: 0 0 0 0 rgba(30, 58, 138, 0.7);
                    }
                    70% {
                        box-shadow: 0 0 0 10px rgba(30, 58, 138, 0);
                    }
                    100% {
                        box-shadow: 0 0 0 0 rgba(30, 58, 138, 0);
                    }
                }
            </style>
            
            {{-- # HORIZONTAL LINE SEPARATOR antara step 1 dan step 2 --}}
            <hr class="my-8">
            
            {{-- # =====================================================
                 STEP 2: DETAIL LAPORAN
                 ===================================================== --}}
            {{-- # User mengisi judul, deskripsi, lokasi detail laporan --}}
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Detail Laporan</h3>
                <p class="text-gray-600 mb-6">Jelaskan masalah Anda secara detail dan jelas</p>
                
                <div class="space-y-6">
                    {{-- # INPUT: JUDUL LAPORAN (required field) --}}
                    {{-- # maxlength="255" = maksimal input 255 karakter --}}
                    {{-- # input-field = custom CSS class untuk styling --}}
                    {{-- # @error directive menampilkan error validation message --}}
                    {{-- # old('title') retain value jika ada validation error --}}
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
                        {{-- # TAMPILKAN ERROR MESSAGE JIKA ADA VALIDATION ERROR --}}
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- # INPUT: DESKRIPSI LAPORAN (required field) --}}
                    {{-- # textarea dengan 6 baris (rows="6") untuk user menulis deskripsi panjang --}}
                    {{-- # Placeholder memberikan panduan apa yang harus dijelaskan --}}
                    {{-- # Minimal 50 karakter enforced dari backend validation --}}
                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Detail *
                        </label>
                        <textarea id="description" name="description" rows="6" required
                                  class="input-field @error('description') border-red-500 @enderror"
                                  placeholder="Jelaskan masalah secara detail:  apa yang terjadi, sejak kapan, dampaknya, dll.  (Minimal 50 karakter)">{{ old('description') }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Minimal 50 karakter.  Semakin detail semakin baik. </p>
                        {{-- # TAMPILKAN ERROR JIKA DESKRIPSI TIDAK MEMENUHI VALIDASI --}}
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- # LOCATION SELECTION: GEDUNG DAN FASILITAS --}}
                    {{-- # 2 kolom grid: Gedung di kiri, Fasilitas di kanan --}}
                    {{-- # Fasilitas dependent pada Gedung yang dipilih via AJAX --}}
                    <!-- Location -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- # SELECT GEDUNG - Saat berubah, trigger loadFacilities() AJAX call --}}
                        <div>
                            <label for="building_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Gedung
                            </label>
                            <select id="building_id" name="building_id" 
                                    class="input-field @error('building_id') border-red-500 @enderror"
                                    @change="loadFacilities($event.target.value)">
                                <option value="">Pilih Gedung</option>
                                {{-- # LOOP SEMUA GEDUNG DARI DATABASE --}}
                                @foreach($buildings as $building)
                                    <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>
                                        {{ $building->name }}
                                    </option>
                                @endforeach
                            </select>
                            {{-- # TAMPILKAN ERROR VALIDASI GEDUNG --}}
                            @error('building_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- # SELECT FASILITAS - Diisi via AJAX setelah Gedung dipilih --}}
                        {{-- # facilities Alpine component state berisi list fasilitas dari AJAX --}}
                        {{-- # x-model="selectedFacility" binds selected value ke Alpine state --}}
                        <div>
                            <label for="facility_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Ruangan/Fasilitas
                            </label>
                            <select id="facility_id" name="facility_id" 
                                    class="input-field @error('facility_id') border-red-500 @enderror">
                                <option value="">Pilih Ruangan (Optional)</option>
                            </select>
                            {{-- # TAMPILKAN ERROR VALIDASI FASILITAS --}}
                            @error('facility_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- # LOKASI TAMBAHAN TEXT INPUT - Free text untuk detail lokasi spesifik --}}
                    {{-- # Optional field untuk memberikan deskripsi lokasi yang lebih detail --}}
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Lokasi Tambahan
                        </label>
                        <input type="text" id="location" name="location"
                               class="input-field @error('location') border-red-500 @enderror"
                               placeholder="Contoh:  Dekat pintu masuk, lantai 2, sebelah kiri"
                               value="{{ old('location') }}">
                        {{-- # TAMPILKAN ERROR JIKA ADA VALIDASI GAGAL --}}
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- # INCIDENT DATE & PRIORITY - Grid 2 kolom --}}
                    {{-- # Tanggal kejadian dan tingkat urgensi laporan --}}
                    <!-- Incident Date & Priority -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- # INPUT: TANGGAL KEJADIAN --}}
                        {{-- # max="{{ date('Y-m-d') }}" prevents future dates --}}
                        {{-- # default value = hari ini jika tidak diisi --}}
                        <div>
                            <label for="incident_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Kejadian
                            </label>
                            <input type="date" id="incident_date" name="incident_date"
                                   class="input-field @error('incident_date') border-red-500 @enderror"
                                   max="{{ date('Y-m-d') }}"
                                   value="{{ old('incident_date', date('Y-m-d')) }}">
                            {{-- # TAMPILKAN ERROR VALIDASI TANGGAL --}}
                            @error('incident_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- # SELECT: TINGKAT URGENSI/PRIORITAS --}}
                        {{-- # Opsi: Rendah, Sedang (default), Tinggi, Mendesak --}}
                        {{-- # Admin menggunakan priority untuk scheduling tindak lanjut --}}
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
                            {{-- # TAMPILKAN ERROR VALIDASI PRIORITY --}}
                            @error('priority')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- # VISIBILITY/VISIBILITY SETTING --}}
                    {{-- # User memilih apakah laporan publik atau anonim --}}
                    {{-- # Publik = Nama terlihat, Anonim = Identitas disembunyikan dari publik --}}
                    <!-- Visibility -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Lapor Sebagai *
                        </label>
                        {{-- # RADIO BUTTONS untuk opsi public vs anonim --}}
                        <div class="space-y-3">
                            {{-- # OPTION 1: PUBLIC - Nama terlihat, laporan terbuka publik --}}
                            <label class="flex items-start cursor-pointer">
                                <input type="radio" name="visibility" value="public" 
                                       {{ old('visibility', 'public') == 'public' ? 'checked' : '' }}
                                       class="mt-1 h-4 w-4 text-navy-800">
                                <div class="ml-3">
                                    <span class="font-medium text-gray-900">Publik</span>
                                    <p class="text-sm text-gray-600">Nama Anda akan terlihat, laporan bisa dilihat siapa saja</p>
                                </div>
                            </label>
                            {{-- # OPTION 2: ANONYMOUS - Identitas disembunyikan dari publik --}}
                            <label class="flex items-start cursor-pointer">
                                <input type="radio" name="visibility" value="anonymous"
                                       {{ old('visibility') == 'anonymous' ? 'checked' : '' }}
                                       class="mt-1 h-4 w-4 text-navy-800">
                                <div class="ml-3">
                                    <span class="font-medium text-gray-900">Anonim</span>
                                    <p class="text-sm text-gray-600">Identitas Anda disembunyikan, hanya admin yang tahu</p>
                                </div>
                            </label>
                            {{-- # OPTION 3: PRIVATE - Hanya user dan admin yang bisa melihat --}}
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
                        {{-- # TAMPILKAN ERROR VALIDASI VISIBILITY --}}
                        @error('visibility')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            {{-- # HORIZONTAL SEPARATOR ANTARA STEP 2 DAN STEP 3 --}}
            <hr class="my-8">
            
            {{-- # =====================================================
                 STEP 3: UPLOAD BUKTI PENDUKUNG (OPTIONAL)
                 ===================================================== --}}
            {{-- # User bisa upload foto/dokumen untuk mendukung laporan --}}
            <!-- Step 3: Attachments -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Upload Bukti (Opsional)</h3>
                <p class="text-gray-600 mb-6">Upload foto atau dokumen pendukung laporan Anda</p>
                
                {{-- # FILE UPLOAD AREA - Dashed border + drag & drop support --}}
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                    {{-- # UPLOAD ICON - SVG dengan styling gray-400 --}}
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    {{-- # FILE INPUT HIDDEN - Triggered via label click atau drag & drop --}}
                    {{-- # multiple = allow multiple file selection --}}
                    {{-- # accept="image/*,.pdf,.doc,.docx" = allowed file types --}}
                    {{-- # onchange="previewFiles(this)" = trigger JavaScript preview saat file selected --}}
                    <label for="attachments" class="cursor-pointer">
                        <span class="text-navy-800 font-semibold">Upload file</span>
                        <span class="text-gray-600"> atau drag & drop</span>
                    </label>
                    <input type="file" id="attachments" name="attachments[]" multiple accept="image/*,. pdf,.doc,.docx"
                           class="hidden" onchange="previewFiles(this)">
                    {{-- # FILE TYPE INFO - Supported formats dan size limits --}}
                    <p class="text-sm text-gray-500 mt-2">JPG, PNG, PDF, DOC (Max 5 file, 5MB per file)</p>
                </div>
                
                {{-- # PREVIEW CONTAINER - Dinamis menampilkan thumbnail files yang dipilih --}}
                {{-- # Grid 2 kolom mobile, 4 kolom desktop --}}
                <div id="preview-container" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                
                {{-- # ERROR MESSAGE UNTUK FILE VALIDATION ERRORS --}}
                @error('attachments.*')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- # TERMS & CONDITIONS CHECKBOX --}}
            {{-- # User harus accept terms sebelum submit (required) --}}
            <!-- Terms -->
            <div class="mb-6">
                {{-- # CHECKBOX WITH LABEL - Lebih besar, lebih user-friendly --}}
                <label class="flex items-start cursor-pointer">
                    <input type="checkbox" name="terms" required class="mt-1 h-4 w-4 text-navy-800">
                    <span class="ml-3 text-sm text-gray-700">
                        Saya menyatakan bahwa informasi yang saya berikan adalah benar dan dapat dipertanggungjawabkan.  
                        Saya memahami bahwa laporan palsu dapat dikenakan sanksi. 
                    </span>
                </label>
            </div>
            
            {{-- # SUBMIT BUTTONS SECTION --}}
            {{-- # Batal button kembali ke list laporan --}}
            {{-- # Submit button kirim laporan dengan loading state --}}
            <!-- Submit Buttons -->
            <div class="flex items-center justify-between pt-6 border-t">
                {{-- # CANCEL BUTTON - Link kembali ke laporan list (btn-secondary) --}}
                <a href="{{ route('student.reports.index') }}" class="btn-secondary">
                    Batal
                </a>
                {{-- # SUBMIT BUTTON - x-bind:disabled menunggu form process --}}
                {{-- # isSubmitting Alpine state mengontrol button disabled state --}}
                {{-- # Menampilkan loading spinner saat form sedang disubmit --}}
                <button type="submit" class="btn-primary" x-bind:disabled="isSubmitting">
                    {{-- # NORMAL TEXT - Tampil saat tidak submitting --}}
                    <span x-show="! isSubmitting">Kirim Laporan</span>
                    {{-- # LOADING STATE - Tampil saat sedang submit dengan spinner icon --}}
                    <span x-show="isSubmitting" class="flex items-center">>
                        {{-- # SPINNER SVG ICON - Animated circle untuk loading visual --}}
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
{{-- # =====================================================
     ALPINE.JS FORM STATE - reportForm()
     ===================================================== --}}
{{-- # Initialize Alpine.js component state untuk form management --}}
{{-- # isSubmitting: boolean flag untuk prevent double submit dan tampilkan loading state --}}
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
            const categoryChecked = form.querySelector('input[name="category_id"]:checked');
            if (!categoryChecked) {
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
            
            {{-- # VALIDASI: VISIBILITY HARUS DIPILIH --}}
            const visibilitySelect = form.querySelector('select[name="visibility"]');
            if (!visibilitySelect.value) {
                hasError = true;
                errorMessages.push('❌ Pilih tipe visibilitas laporan');
            }
            
            {{-- # VALIDASI: TERMS CHECKBOX HARUS DICENTANG --}}
            const termsCheckbox = form.querySelector('input[name="terms"]');
            if (!termsCheckbox.checked) {
                hasError = true;
                errorMessages.push('❌ Setujui persyaratan sebelum mengirim laporan');
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
        }
    }
}

{{-- # =====================================================
     AJAX: LOAD FACILITIES BY BUILDING
     ===================================================== --}}
{{-- # Dipanggil saat user memilih gedung (via @change event) --}}
{{-- # Fetch facilities dari API berdasarkan building_id --}}
{{-- # Populate facility select dropdown dengan hasil dari server --}}
// Load facilities based on building
async function loadFacilities(buildingId) {
    {{-- # GET REFERENCE ke facility select element --}}
    const facilitySelect = document.getElementById('facility_id');
    {{-- # SET loading state placeholder --}}
    facilitySelect.innerHTML = '<option value="">Loading... </option>';
    
    {{-- # EARLY RETURN jika buildingId kosong (user belum pilih gedung) --}}
    if (!buildingId) {
        facilitySelect.innerHTML = '<option value="">Pilih Gedung dulu</option>';
        return;
    }
    
    {{-- # TRY FETCH ke /api/facilities/{buildingId} --}}
    {{-- # Server return JSON array of facilities untuk building tersebut --}}
    try {
        const response = await fetch(`/api/facilities/${buildingId}`);
        const facilities = await response.json();
        
        {{-- # CLEAR dropdown dan set default option --}}
        facilitySelect.innerHTML = '<option value="">Pilih Ruangan (Optional)</option>';
        {{-- # LOOP setiap facility dan create option element --}}
        {{-- # Display: Nama Fasilitas (Kode) - Lantai X --}}
        facilities.forEach(facility => {
            const option = document.createElement('option');
            option.value = facility.id;
            option.textContent = `${facility.name} (${facility.code}) - Lt. ${facility.floor}`;
            facilitySelect.appendChild(option);
        });
    } catch (error) {
        {{-- # ERROR HANDLING - jika fetch gagal --}}
        facilitySelect.innerHTML = '<option value="">Error loading facilities</option>';
    }
}

{{-- # =====================================================
     FILE PREVIEW - previewFiles()
     ===================================================== --}}
{{-- # Dipanggil saat user select file (via onchange event) --}}
{{-- # Display thumbnail preview dari uploaded files --}}
{{-- # Support images dan documents --}}
// Preview uploaded files
function previewFiles(input) {
    {{-- # GET REFERENCE ke preview container --}}
    const container = document.getElementById('preview-container');
    {{-- # CLEAR container dari file preview lama --}}
    container.innerHTML = '';
    
    {{-- # CEK jika ada files yang dipilih --}}
    if (input.files) {
        {{-- # LOOP setiap file yang dipilih --}}
        Array.from(input.files).forEach((file, index) => {
            {{-- # CREATE FileReader untuk read file content --}}
            const reader = new FileReader();
            
            {{-- # ON LOAD event handler saat file selesai dibaca --}}
            reader.onload = function(e) {
                {{-- # CREATE div element untuk file preview card --}}
                const div = document.createElement('div');
                div.className = 'relative border rounded-lg p-2';
                
                {{-- # CEK TYPE FILE - image atau document --}}
                {{-- # IMAGE: display thumbnail preview dari DataURL --}}
                {{-- # DOCUMENT: display generic document icon --}}
                if (file.type.startsWith('image/')) {
                    {{-- # IMAGE PREVIEW - Show thumbnail dari file --}}
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-24 object-cover rounded">
                        <p class="text-xs text-gray-600 mt-1 truncate">${file.name}</p>
                    `;
                } else {
                    {{-- # DOCUMENT PREVIEW - Show generic file icon untuk non-image files --}}
                    div.innerHTML = `
                        <div class="w-full h-24 bg-gray-100 rounded flex items-center justify-center">
                            {{-- # DOCUMENT ICON SVG --}}
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-600 mt-1 truncate">${file.name}</p>
                    `;
                }
                
                {{-- # APPEND preview card ke container --}}
                container.appendChild(div);
            };
            
            {{-- # READ file sebagai DataURL (base64 encoded) untuk preview --}}
            reader.readAsDataURL(file);
        });
    }
}
</script>
@endpush
@endsection
