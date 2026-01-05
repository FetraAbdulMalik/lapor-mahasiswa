@extends('layouts.guest')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <div class="mx-auto h-16 w-16 bg-navy-800 rounded-full flex items-center justify-center">
                <span class="text-white text-2xl font-bold">LM</span>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Daftar Akun Mahasiswa
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-medium text-navy-800 hover:text-blue-500">
                    Masuk di sini
                </a>
            </p>
        </div>
        
        <div class="bg-white shadow-xl rounded-lg p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                
                <!-- Personal Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pribadi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                            <input id="name" name="name" type="text" required 
                                   class="input-field @error('name') border-red-500 @enderror" 
                                   placeholder="Nama sesuai KTP"
                                   value="{{ old('name') }}">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Kampus *</label>
                            <input id="email" name="email" type="email" required 
                                   class="input-field @error('email') border-red-500 @enderror" 
                                   placeholder="nama@student.university.ac.id"
                                   value="{{ old('email') }}">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                            <input id="phone" name="phone" type="text" 
                                   class="input-field @error('phone') border-red-500 @enderror" 
                                   placeholder="08123456789"
                                   value="{{ old('phone') }}">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Academic Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Akademik</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nim" class="block text-sm font-medium text-gray-700 mb-1">NIM *</label>
                            <input id="nim" name="nim" type="text" required 
                                   class="input-field @error('nim') border-red-500 @enderror" 
                                   placeholder="11220001"
                                   value="{{ old('nim') }}">
                            @error('nim')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="year_of_entry" class="block text-sm font-medium text-gray-700 mb-1">Tahun Masuk *</label>
                            <input id="year_of_entry" name="year_of_entry" type="number" required 
                                   class="input-field @error('year_of_entry') border-red-500 @enderror" 
                                   placeholder="{{ date('Y') }}"
                                   min="2000" max="{{ date('Y') }}"
                                   value="{{ old('year_of_entry', date('Y')) }}">
                            @error('year_of_entry')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="faculty_id" class="block text-sm font-medium text-gray-700 mb-1">Fakultas *</label>
                            <select id="faculty_id" name="faculty_id" required 
                                    class="input-field @error('faculty_id') border-red-500 @enderror">
                                <option value="">Pilih Fakultas</option>
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->id }}" {{ old('faculty_id') == $faculty->id ? 'selected' : '' }}>
                                        {{ $faculty->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('faculty_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="department_id" class="block text-sm font-medium text-gray-700 mb-1">Jurusan *</label>
                            <select id="department_id" name="department_id" required 
                                    class="input-field @error('department_id') border-red-500 @enderror">
                                <option value="">Pilih Jurusan</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" data-faculty="{{ $dept->faculty_id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Password -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Keamanan Akun</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                            <input id="password" name="password" type="password" required 
                                   class="input-field @error('password') border-red-500 @enderror" 
                                   placeholder="Minimal 8 karakter">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password *</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required 
                                   class="input-field" 
                                   placeholder="Ketik ulang password">
                        </div>
                    </div>
                </div>
                
                <!-- Terms -->
                <div class="flex items-start">
                    <input id="terms" name="terms" type="checkbox" required 
                           class="mt-1 h-4 w-4 text-navy-800 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="terms" class="ml-2 block text-sm text-gray-900">
                        Saya menyetujui <a href="#" class="text-navy-800 hover:underline">Syarat & Ketentuan</a> dan 
                        <a href="#" class="text-navy-800 hover:underline">Kebijakan Privasi</a>
                    </label>
                </div>
                
                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full btn-primary py-3 text-lg">
                        Daftar Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Filter departments by faculty
document.getElementById('faculty_id').addEventListener('change', function() {
    const facultyId = this.value;
    const departmentSelect = document.getElementById('department_id');
    const options = departmentSelect.querySelectorAll('option');
    
    options.forEach(option => {
        if (option.value === '') {
            option.style.display = 'block';
        } else if (option.dataset.faculty == facultyId) {
            option.style.display = 'block';
        } else {
            option.style.display = 'none';
        }
    });
    
    departmentSelect.value = '';
});
</script>
@endpush
@endsection
