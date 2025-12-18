@extends('layouts.guest')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg: px-8 py-24">
        <div class="text-center">
            <h1 class="text-5xl font-extrabold mb-6">
                Laporkan Masalah Kampus Anda! 
            </h1>
            <p class="text-xl mb-8 text-primary-100">
                Sistem pelaporan yang cepat, transparan, dan terpercaya untuk mahasiswa
            </p>
            <div class="flex justify-center space-x-4">
                @auth
                    <a href="{{ auth()->user()->isStudent() ? route('student.dashboard') : route('admin.dashboard') }}" 
                       class="bg-white text-primary-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-primary-50 transition">
                        Ke Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-white text-primary-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-primary-50 transition">
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="border-2 border-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-white hover: text-primary-600 transition">
                        Masuk
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 md: grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
            <div class="text-4xl font-bold text-primary-600 mb-2">{{ $totalReports }}</div>
            <div class="text-gray-600">Total Laporan</div>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
            <div class="text-4xl font-bold text-green-600 mb-2">{{ $resolvedReports }}</div>
            <div class="text-gray-600">Selesai</div>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
            <div class="text-4xl font-bold text-purple-600 mb-2">{{ $inProgressReports }}</div>
            <div class="text-gray-600">Dalam Proses</div>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
            <div class="text-4xl font-bold text-yellow-600 mb-2">{{ $pendingReports }}</div>
            <div class="text-gray-600">Menunggu</div>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Kategori Laporan</h2>
            <p class="text-gray-600">Pilih kategori sesuai dengan masalah yang ingin dilaporkan</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition cursor-pointer">
                <div class="text-4xl mb-3">{{ $category->icon }}</div>
                <h3 class="font-bold text-lg mb-2">{{ $category->name }}</h3>
                <p class="text-sm text-gray-600">{{ Str::limit($category->description, 60) }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- How It Works -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Cara Melaporkan</h2>
        <p class="text-gray-600">4 langkah mudah untuk membuat laporan</p>
    </div>
    
    <div class="grid grid-cols-1 md: grid-cols-4 gap-8">
        <div class="text-center">
            <div class="w-16 h-16 bg-primary-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">1</div>
            <h3 class="font-bold text-lg mb-2">Pilih Kategori</h3>
            <p class="text-sm text-gray-600">Pilih kategori masalah yang sesuai</p>
        </div>
        <div class="text-center">
            <div class="w-16 h-16 bg-primary-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">2</div>
            <h3 class="font-bold text-lg mb-2">Isi Detail</h3>
            <p class="text-sm text-gray-600">Jelaskan masalah secara detail</p>
        </div>
        <div class="text-center">
            <div class="w-16 h-16 bg-primary-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">3</div>
            <h3 class="font-bold text-lg mb-2">Upload Bukti</h3>
            <p class="text-sm text-gray-600">Upload foto/dokumen pendukung</p>
        </div>
        <div class="text-center">
            <div class="w-16 h-16 bg-primary-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">4</div>
            <h3 class="font-bold text-lg mb-2">Submit & Track</h3>
            <p class="text-sm text-gray-600">Submit dan pantau progress laporan</p>
        </div>
    </div>
</div>

<!-- Recent Reports -->
<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Laporan Terbaru</h2>
            <a href="{{ route('reports.public') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                Lihat Semua →
            </a>
        </div>
        
        <div class="grid grid-cols-1 md: grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($recentReports as $report)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="badge badge-{{ $report->status_badge_color }}">
                            {{ $report->status_label }}
                        </span>
                        <span class="text-xs text-gray-500">{{ $report->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <h3 class="font-bold text-lg mb-2">{{ Str::limit($report->title, 50) }}</h3>
                    <p class="text-sm text-gray-600 mb-4">{{ Str::limit($report->description, 100) }}</p>
                    
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">
                            <span class="mr-1">{{ $report->category->icon }}</span>
                            {{ $report->category->name }}
                        </span>
                        <a href="{{ route('reports.public.show', $report->id) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                            Lihat Detail →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-primary-600 text-white py-16">
    <div class="max-w-4xl mx-auto text-center px-4">
        <h2 class="text-3xl font-bold mb-4">Siap Membuat Laporan?</h2>
        <p class="text-xl text-primary-100 mb-8">
            Bergabunglah dengan ribuan mahasiswa yang telah mempercayai sistem kami
        </p>
        @auth
            <a href="{{ route('student.reports.create') }}" class="bg-white text-primary-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-primary-50 transition inline-block">
                Buat Laporan Sekarang
            </a>
        @else
            <a href="{{ route('register') }}" class="bg-white text-primary-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-primary-50 transition inline-block">
                Daftar Gratis
            </a>
        @endauth
    </div>
</div>
@endsection