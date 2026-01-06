@extends('layouts.guest')

@section('title', 'Tentang Kami')

@section('content')
<div class="bg-gradient-to-r from-navy-800 to-navy-700 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-2">Tentang Lapor Mahasiswa</h1>
        <p class="text-xl text-blue-100">Platform pelaporan masalah kampus yang transparan dan terpercaya</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Introduction -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Apa itu Lapor Mahasiswa?</h2>
        <p class="text-gray-600 mb-4 text-lg">
            Lapor Mahasiswa adalah sistem pelaporan online yang dirancang untuk memberikan mahasiswa kesempatan 
            untuk melaporkan berbagai masalah terkait fasilitas kampus, layanan akademik, administrasi, dan aspek 
            lainnya yang memerlukan perhatian dari pihak universitas.
        </p>
        <p class="text-gray-600 text-lg">
            Platform ini memastikan setiap laporan ditangani dengan serius, transparan, dan terukur hingga 
            permasalahan tersebut terselesaikan dengan baik.
        </p>
    </div>

    <!-- Mission & Vision -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-navy-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Misi Kami</h3>
            <p class="text-gray-600">
                Menciptakan lingkungan kampus yang lebih baik melalui komunikasi terbuka antara mahasiswa dan 
                administrasi universitas, sehingga setiap masalah dapat ditangani dengan cepat dan profesional.
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-navy-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Visi Kami</h3>
            <p class="text-gray-600">
                Menjadi platform terdepan dalam pengelolaan aspirasi mahasiswa dan peningkatan kualitas 
                layanan kampus secara berkelanjutan.
            </p>
        </div>
    </div>

    <!-- Core Values -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Nilai-Nilai Inti</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-1">Transparansi</h4>
                    <p class="text-gray-600 text-sm">Setiap laporan dan penanganannya dicatat dengan jelas dan dapat dipantau oleh pelapor.</p>
                </div>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-1">Akuntabilitas</h4>
                    <p class="text-gray-600 text-sm">Setiap tindakan yang diambil harus dapat dipertanggungjawabkan dan terukur hasilnya.</p>
                </div>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-1">Profesionalisme</h4>
                    <p class="text-gray-600 text-sm">Penanganan laporan dilakukan dengan standar profesional dan kualitas terbaik.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Features -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Fitur Unggulan</h2>
        <div class="space-y-4">
            <div class="flex items-start">
                <div class="flex-shrink-0 w-8 h-8 bg-navy-800 text-white rounded-full flex items-center justify-center mr-4 text-sm font-bold">
                    ✓
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">Laporan Anonim</h4>
                    <p class="text-gray-600 text-sm">Mahasiswa dapat melaporkan secara anonim untuk privasi yang lebih terjaga.</p>
                </div>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0 w-8 h-8 bg-navy-800 text-white rounded-full flex items-center justify-center mr-4 text-sm font-bold">
                    ✓
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">Tracking Real-time</h4>
                    <p class="text-gray-600 text-sm">Pantau status laporan Anda dari pengajuan hingga penyelesaian.</p>
                </div>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0 w-8 h-8 bg-navy-800 text-white rounded-full flex items-center justify-center mr-4 text-sm font-bold">
                    ✓
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">Lampiran Bukti</h4>
                    <p class="text-gray-600 text-sm">Unggah foto atau dokumen untuk mendukung laporan Anda.</p>
                </div>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0 w-8 h-8 bg-navy-800 text-white rounded-full flex items-center justify-center mr-4 text-sm font-bold">
                    ✓
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">Komunikasi Dua Arah</h4>
                    <p class="text-gray-600 text-sm">Berinteraksi dengan tim penanganan melalui fitur komentar dan tanggapan.</p>
                </div>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0 w-8 h-8 bg-navy-800 text-white rounded-full flex items-center justify-center mr-4 text-sm font-bold">
                    ✓
                </div>
                <div>
                    <h4 class="font-bold text-gray-900">Statistik Publik</h4>
                    <p class="text-gray-600 text-sm">Lihat data laporan secara agregat untuk transparansi kampus.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-gradient-to-r from-navy-800 to-navy-700 rounded-lg p-8 text-white text-center">
        <h2 class="text-2xl font-bold mb-3">Siap Melaporkan Masalah Anda?</h2>
        <p class="text-blue-100 mb-6">Bergabunglah dengan ribuan mahasiswa yang telah memperbaiki kampus melalui laporan konstruktif.</p>
        <a href="{{ route('login') }}" class="inline-block bg-white text-navy-800 font-bold py-3 px-8 rounded-lg hover:bg-blue-50 transition">
            Mulai Melapor Sekarang
        </a>
    </div>
</div>
@endsection
