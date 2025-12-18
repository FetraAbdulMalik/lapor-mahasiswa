@extends('layouts.app', ['title' => 'Profil Saya'])

@section('content')

<!-- Header -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Profil Saya</h2>
    <p class="text-gray-600">Lihat dan kelola informasi profil Anda</p>
</div>

@if($profile)
    <!-- Profile Card -->
    <div class="bg-white rounded-lg shadow-md p-8 max-w-3xl">
        <div class="flex items-start justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">{{ $profile->user->name }}</h3>
                <p class="text-gray-600">{{ $profile->user->email }}</p>
            </div>
            <a href="{{ route('student.profile.edit') }}"
               class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                Edit Profil
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Personal Information -->
            <div class="space-y-4">
                <h4 class="font-bold text-gray-900 border-b pb-2">Informasi Pribadi</h4>

                <div>
                    <label class="text-sm text-gray-600">NIM</label>
                    <p class="text-gray-900 font-medium">{{ $profile->nim ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">No. Telepon</label>
                    <p class="text-gray-900 font-medium">{{ $profile->phone ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Jenis Kelamin</label>
                    <p class="text-gray-900 font-medium">
                        @if($profile->gender === 'male')
                            Laki-laki
                        @elseif($profile->gender === 'female')
                            Perempuan
                        @else
                            -
                        @endif
                    </p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Tanggal Lahir</label>
                    <p class="text-gray-900 font-medium">
                        @if($profile->date_of_birth)
                            {{ \Carbon\Carbon::parse($profile->date_of_birth)->format('d M Y') }}
                        @else
                            -
                        @endif
                    </p>
                </div>
            </div>

            <!-- Academic Information -->
            <div class="space-y-4">
                <h4 class="font-bold text-gray-900 border-b pb-2">Informasi Akademik</h4>

                <div>
                    <label class="text-sm text-gray-600">Fakultas</label>
                    <p class="text-gray-900 font-medium">{{ $profile->faculty?->name ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Jurusan</label>
                    <p class="text-gray-900 font-medium">{{ $profile->department?->name ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Semester</label>
                    <p class="text-gray-900 font-medium">{{ $profile->semester ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Tahun Akademik</label>
                    <p class="text-gray-900 font-medium">{{ $profile->academic_year ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="border-t pt-6">
            <h4 class="font-bold text-gray-900 mb-4 border-b pb-2">Informasi Kontak</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm text-gray-600">Alamat</label>
                    <p class="text-gray-900 font-medium">{{ $profile->address ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Kota</label>
                    <p class="text-gray-900 font-medium">{{ $profile->city ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Provinsi</label>
                    <p class="text-gray-900 font-medium">{{ $profile->province ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Kode Pos</label>
                    <p class="text-gray-900 font-medium">{{ $profile->postal_code ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Account Information -->
        <div class="border-t pt-6 mt-6">
            <h4 class="font-bold text-gray-900 mb-4 border-b pb-2">Informasi Akun</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm text-gray-600">Status</label>
                    <p class="text-gray-900 font-medium">
                        @if($profile->user->email_verified_at)
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Terverifikasi</span>
                        @else
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">Belum Terverifikasi</span>
                        @endif
                    </p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Terdaftar Sejak</label>
                    <p class="text-gray-900 font-medium">{{ $profile->user->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="border-t pt-6 mt-6 flex gap-3">
            <a href="{{ route('student.profile.edit') }}"
               class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                Edit Profil
            </a>
            <a href="{{ route('student.dashboard') }}"
               class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                Kembali
            </a>
        </div>
    </div>
@else
    <!-- No Profile Found -->
    <div class="bg-white rounded-lg shadow-md p-8 text-center max-w-3xl">
        <p class="text-gray-600 mb-4">Profil Anda belum dibuat.</p>
        <a href="{{ route('student.profile.create') }}"
           class="inline-block px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
            Buat Profil
        </a>
    </div>
@endif

@endsection
