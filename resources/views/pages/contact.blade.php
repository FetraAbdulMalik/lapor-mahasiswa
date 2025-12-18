@extends('layouts.app', ['title' => 'Hubungi Kami'])

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Hubungi Kami</h1>
        <p class="text-lg text-gray-600">Kami siap membantu menjawab pertanyaan Anda</p>
    </div>

    <!-- Contact Information Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <!-- Email -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Email</h3>
            <p class="text-gray-600 mb-3">Hubungi kami melalui email</p>
            <a href="mailto:support@lapormahasiswa.ac.id" class="text-primary-600 hover:text-primary-700 font-medium">
                support@lapormahasiswa.ac.id
            </a>
        </div>

        <!-- Phone -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Telepon</h3>
            <p class="text-gray-600 mb-3">Hubungi melalui telepon</p>
            <a href="tel:+62-XXX-XXXX-XXXX" class="text-primary-600 hover:text-primary-700 font-medium">
                +62-XXX-XXXX-XXXX
            </a>
        </div>

        <!-- Location -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Lokasi</h3>
            <p class="text-gray-600">Kampus Utama, Gedung A<br>Jalan Universitas No. 1</p>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>
        
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('contact.send') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap *
                </label>
                <input type="text" id="name" name="name" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror"
                       placeholder="Nama Anda"
                       value="{{ old('name', auth()->user()->name ?? '') }}">
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
                       placeholder="email@example.com"
                       value="{{ old('email', auth()->user()->email ?? '') }}">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Subject -->
            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                    Subjek *
                </label>
                <input type="text" id="subject" name="subject" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('subject') border-red-500 @enderror"
                       placeholder="Subjek pesan Anda"
                       value="{{ old('subject') }}">
                @error('subject')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Message -->
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                    Pesan *
                </label>
                <textarea id="message" name="message" rows="6" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('message') border-red-500 @enderror"
                          placeholder="Tulis pesan Anda di sini...">{{ old('message') }}</textarea>
                @error('message')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between pt-4">
                <a href="javascript:history.back()" class="text-gray-600 hover:text-gray-900 font-medium">
                    Kembali
                </a>
                <button type="submit" class="btn-primary">
                    Kirim Pesan
                </button>
            </div>
        </form>
    </div>

    <!-- FAQ Section -->
    <div class="mt-12 bg-gray-50 rounded-lg p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Pertanyaan Umum</h2>
        <p class="text-gray-600 mb-6">
            Belum menemukan jawaban yang Anda cari? 
            <a href="{{ route('faq') }}" class="text-primary-600 hover:text-primary-700 font-medium">Kunjungi halaman FAQ kami</a>
        </p>
    </div>
</div>
@endsection
