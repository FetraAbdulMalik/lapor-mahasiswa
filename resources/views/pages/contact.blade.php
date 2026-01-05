@extends('layouts.app', ['title' => 'Hubungi Kami', 'hideSidebar' => true])

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <!-- Page Title -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-3">Hubungi Kami</h1>
        <p class="text-lg text-gray-600">Kami siap membantu dan menjawab pertanyaan Anda</p>
    </div>

    <!-- Contact Form Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Form (2 columns) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>
                
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                        <p class="text-green-700 font-medium">✓ {{ session('success') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}" class="space-y-5">
                    @csrf

                    <!-- Name Input -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-800 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-500 bg-red-50 @enderror"
                               placeholder="Masukkan nama lengkap Anda"
                               value="{{ old('name', auth()?->user()?->name ?? '') }}">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-800 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-500 bg-red-50 @enderror"
                               placeholder="email@example.com"
                               value="{{ old('email', auth()?->user()?->email ?? '') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject Input -->
                    <div>
                        <label for="subject" class="block text-sm font-semibold text-gray-800 mb-2">
                            Subjek <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="subject" 
                               name="subject" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('subject') border-red-500 bg-red-50 @enderror"
                               placeholder="Topik pesan Anda"
                               value="{{ old('subject') }}">
                        @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message Textarea -->
                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-800 mb-2">
                            Pesan <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="5" 
                                  required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none @error('message') border-red-500 bg-red-50 @enderror"
                                  placeholder="Tulis pesan Anda di sini...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex gap-3 pt-4">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition duration-200 shadow-md">
                            Kirim Pesan
                        </button>
                        <a href="{{ url('/') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 rounded-lg transition duration-200 text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Contact Info Cards (1 column) -->
        <div class="space-y-5">
            <!-- Email Card -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Email</h3>
                <p class="text-sm text-gray-600 mb-3">Hubungi kami melalui email</p>
                <a href="mailto:support@lapormahasiswa.ac.id" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                    support@lapormahasiswa.ac.id
                </a>
            </div>

            <!-- Phone Card -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Telepon</h3>
                <p class="text-sm text-gray-600 mb-3">Hubungi melalui telepon</p>
                <a href="tel:+62-XXX-XXXX-XXXX" class="text-green-600 hover:text-green-700 font-medium text-sm">
                    +62-XXX-XXXX-XXXX
                </a>
            </div>

            <!-- Location Card -->
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Lokasi</h3>
                <p class="text-sm text-gray-600">
                    Kampus Utama, Gedung A<br>
                    <span class="text-xs">Jalan Universitas No. 1</span>
                </p>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-8 border border-blue-200">
        <h2 class="text-2xl font-bold text-gray-900 mb-3">Pertanyaan yang Sering Diajukan</h2>
        <p class="text-gray-700 mb-4">
            Belum menemukan jawaban yang Anda cari? 
        </p>
        <a href="{{ route('faq') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
            Baca FAQ Lengkap →
        </a>
    </div>
</div>
@endsection
