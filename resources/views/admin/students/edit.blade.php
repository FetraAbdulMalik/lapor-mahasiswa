@extends('layouts.admin', ['title' => 'Edit Mahasiswa'])

@section('content')

<!-- Header -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Edit Data Mahasiswa</h2>
    <p class="text-gray-600">Perbarui informasi mahasiswa</p>
</div>

<!-- Form Card -->
<div class="bg-white rounded-lg shadow-md p-8">
    <form method="POST" action="{{ route('admin.students.update', $student->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Lengkap *
            </label>
            <input type="text" id="name" name="name" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror"
                   value="{{ old('name', $student->name) }}">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                Email *
            </label>
            <input type="email" id="email" name="email" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('email') border-red-500 @enderror"
                   value="{{ old('email', $student->email) }}">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                Nomor Telepon
            </label>
            <input type="tel" id="phone" name="phone"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                   value="{{ old('phone', $student->phone) }}">
            @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- NIM -->
        <div>
            <label for="nim" class="block text-sm font-medium text-gray-700 mb-2">
                NIM (Nomor Induk Mahasiswa) *
            </label>
            <input type="text" id="nim" name="nim" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('nim') border-red-500 @enderror"
                   value="{{ old('nim', $student->studentProfile->nim) }}">
            @error('nim')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Faculty & Department -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="faculty_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Fakultas *
                </label>
                <select id="faculty_id" name="faculty_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('faculty_id') border-red-500 @enderror">
                    <option value="">Pilih Fakultas</option>
                    @foreach($faculties as $faculty)
                        <option value="{{ $faculty->id }}" {{ old('faculty_id', $student->studentProfile->faculty_id) == $faculty->id ? 'selected' : '' }}>
                            {{ $faculty->name }}
                        </option>
                    @endforeach
                </select>
                @error('faculty_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="department_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Jurusan *
                </label>
                <select id="department_id" name="department_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('department_id') border-red-500 @enderror">
                    <option value="">Pilih Jurusan</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ old('department_id', $student->studentProfile->department_id) == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Semester & Year of Entry -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="semester" class="block text-sm font-medium text-gray-700 mb-2">
                    Semester *
                </label>
                <input type="number" id="semester" name="semester" required min="1" max="14"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('semester') border-red-500 @enderror"
                       value="{{ old('semester', $student->studentProfile->semester) }}">
                @error('semester')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="year_of_entry" class="block text-sm font-medium text-gray-700 mb-2">
                    Tahun Masuk *
                </label>
                <input type="number" id="year_of_entry" name="year_of_entry" required min="2000" max="{{ date('Y') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('year_of_entry') border-red-500 @enderror"
                       value="{{ old('year_of_entry', $student->studentProfile->year_of_entry) }}">
                @error('year_of_entry')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex items-center justify-between pt-6 border-t">
            <a href="{{ route('admin.students.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                Batal
            </a>
            <button type="submit" class="btn-primary">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection
