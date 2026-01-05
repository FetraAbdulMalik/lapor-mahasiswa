@extends('layouts.guest')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-navy-800 via-navy-900 to-navy-800 text-white relative overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-accent-500 opacity-10 rounded-full -mr-20 -mt-20"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-accent-500 opacity-10 rounded-full -ml-20 -mb-20"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center space-x-2 bg-accent-500 bg-opacity-20 text-accent-300 px-4 py-2 rounded-full mb-6">
                <span class="w-2 h-2 bg-accent-500 rounded-full"></span>
                <span class="text-sm font-semibold">Platform Pelaporan Modern</span>
            </div>
            <h1 class="text-6xl font-extrabold mb-6 leading-tight">
                Laporkan Masalah Kampus Anda! 
            </h1>
            <p class="text-xl mb-10 text-gray-300 max-w-2xl mx-auto">
                Sistem pelaporan yang cepat, transparan, dan terpercaya. Suarakan masalah Anda dan lihat perubahan nyata di kampus kami.
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                @auth
                    <a href="{{ auth()->user()->isStudent() ? route('student.dashboard') : route('admin.dashboard') }}" 
                       class="btn-primary px-8 py-4 text-lg inline-flex items-center justify-center space-x-2 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span>Ke Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-secondary px-8 py-4 text-lg inline-flex items-center justify-center space-x-2 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <span>Daftar Sekarang</span>
                    </a>
                    <a href="{{ route('login') }}" class="btn-outline px-8 py-4 text-lg inline-flex items-center justify-center space-x-2 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Masuk</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Total Reports Card -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-lg p-8 border-l-4 border-navy-800 hover:shadow-2xl transition transform hover:scale-105">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-navy-800 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-navy-800 bg-white px-3 py-1 rounded-full">Total</span>
            </div>
            <div class="text-4xl font-bold text-navy-800 mb-2">{{ $totalReports }}</div>
            <p class="text-gray-700 font-medium">Total Laporan</p>
        </div>
        
        <!-- Resolved Reports Card -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow-lg p-8 border-l-4 border-green-600 hover:shadow-2xl transition transform hover:scale-105">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-green-700 bg-white px-3 py-1 rounded-full">Selesai</span>
            </div>
            <div class="text-4xl font-bold text-green-600 mb-2">{{ $resolvedReports }}</div>
            <p class="text-gray-700 font-medium">Laporan Selesai</p>
        </div>
        
        <!-- In Progress Card -->
        <div class="bg-gradient-to-br from-accent-50 to-accent-100 rounded-xl shadow-lg p-8 border-l-4 border-accent-500 hover:shadow-2xl transition transform hover:scale-105">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-accent-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-accent-700 bg-white px-3 py-1 rounded-full">Proses</span>
            </div>
            <div class="text-4xl font-bold text-accent-500 mb-2">{{ $inProgressReports }}</div>
            <p class="text-gray-700 font-medium">Dalam Proses</p>
        </div>
        
        <!-- Pending Card -->
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl shadow-lg p-8 border-l-4 border-amber-500 hover:shadow-2xl transition transform hover:scale-105">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-amber-700 bg-white px-3 py-1 rounded-full">Menunggu</span>
            </div>
            <div class="text-4xl font-bold text-amber-500 mb-2">{{ $pendingReports }}</div>
            <p class="text-gray-700 font-medium">Menunggu Review</p>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="bg-gradient-to-b from-gray-50 to-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-navy-800 mb-4">Kategori Laporan</h2>
            <p class="text-lg text-gray-600">Pilih kategori sesuai dengan masalah yang ingin dilaporkan</p>
            <div class="h-1 w-20 bg-accent-500 mx-auto mt-6"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
            <div class="group bg-white rounded-xl shadow-md p-8 hover:shadow-2xl hover:border-accent-500 border-2 border-transparent transition-all duration-300 cursor-pointer">
                <div class="text-5xl mb-4 group-hover:scale-110 transition-transform duration-300">{{ $category->icon }}</div>
                <h3 class="font-bold text-lg mb-2 text-navy-800 group-hover:text-accent-500 transition-colors">{{ $category->name }}</h3>
                <p class="text-sm text-gray-600 leading-relaxed">{{ Str::limit($category->description, 70) }}</p>
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="#" class="inline-flex items-center text-accent-500 font-semibold text-sm hover:text-accent-600">
                        Laporkan
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- How It Works -->
<div class="bg-gradient-to-r from-navy-900 to-navy-800 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-white mb-4">Cara Melaporkan</h2>
            <p class="text-xl text-gray-300">4 langkah mudah untuk membuat laporan</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Step 1 -->
            <div class="relative">
                <div class="bg-white rounded-xl p-8 shadow-lg">
                    <div class="w-16 h-16 bg-accent-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-3 text-navy-800 text-center">Pilih Kategori</h3>
                    <p class="text-sm text-gray-600 text-center">Pilih kategori masalah yang sesuai dengan kebutuhan Anda</p>
                </div>
                <div class="hidden md:block absolute top-1/2 right-0 transform translate-x-1/2 w-12 h-12 bg-accent-500 rounded-full flex items-center justify-center text-white text-2xl">→</div>
            </div>
            
            <!-- Step 2 -->
            <div class="relative">
                <div class="bg-white rounded-xl p-8 shadow-lg">
                    <div class="w-16 h-16 bg-accent-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-3 text-navy-800 text-center">Isi Detail</h3>
                    <p class="text-sm text-gray-600 text-center">Jelaskan masalah secara detail dan lengkap</p>
                </div>
                <div class="hidden md:block absolute top-1/2 right-0 transform translate-x-1/2 w-12 h-12 bg-accent-500 rounded-full flex items-center justify-center text-white text-2xl">→</div>
            </div>
            
            <!-- Step 3 -->
            <div class="relative">
                <div class="bg-white rounded-xl p-8 shadow-lg">
                    <div class="w-16 h-16 bg-accent-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-3 text-navy-800 text-center">Upload Bukti</h3>
                    <p class="text-sm text-gray-600 text-center">Upload foto/dokumen pendukung Anda</p>
                </div>
                <div class="hidden md:block absolute top-1/2 right-0 transform translate-x-1/2 w-12 h-12 bg-accent-500 rounded-full flex items-center justify-center text-white text-2xl">→</div>
            </div>
            
            <!-- Step 4 -->
            <div>
                <div class="bg-white rounded-xl p-8 shadow-lg">
                    <div class="w-16 h-16 bg-accent-500 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-3 text-navy-800 text-center">Submit & Track</h3>
                    <p class="text-sm text-gray-600 text-center">Pantau progress laporan Anda secara real-time</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Reports -->
<div class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-4xl font-bold text-navy-800 mb-2">Laporan Terbaru</h2>
                <p class="text-gray-600">Daftar laporan yang telah dibagikan ke publik</p>
            </div>
            <a href="{{ route('reports.public') }}" class="inline-flex items-center space-x-2 text-accent-500 hover:text-accent-600 font-semibold text-lg">
                <span>Lihat Semua</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($recentReports as $report)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition-all duration-300 border-l-4 border-navy-800">
                <div class="p-6">
                    <!-- Status Badge -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="badge badge-{{ $report->status_badge_color }} inline-flex items-center space-x-1">
                            <span class="w-2 h-2 rounded-full bg-current"></span>
                            <span>{{ $report->status_label }}</span>
                        </span>
                        <span class="text-xs font-medium text-gray-500">{{ $report->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <!-- Title -->
                    <h3 class="font-bold text-lg mb-3 text-navy-800 line-clamp-2">{{ $report->title }}</h3>
                    
                    <!-- Description -->
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2 leading-relaxed">{{ $report->description }}</p>
                    
                    <!-- Footer -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <div class="flex items-center space-x-2 text-gray-600">
                            <span class="text-lg">{{ $report->category->icon }}</span>
                            <span class="text-sm font-medium">{{ $report->category->name }}</span>
                        </div>
                        <a href="{{ route('reports.public.show', $report->id) }}" class="inline-flex items-center text-accent-500 hover:text-accent-600 font-semibold text-sm">
                            <span>Detail</span>
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-navy-800 text-white py-20 relative overflow-hidden">
    <!-- Animated background elements -->
    <div class="absolute top-0 left-0 w-64 h-64 bg-accent-500 opacity-5 rounded-full -ml-32 -mt-32 animate-pulse"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-accent-500 opacity-5 rounded-full -mr-48 -mb-48 animate-pulse" style="animation-delay: 1s;"></div>
    
    <div class="max-w-4xl mx-auto text-center px-4 relative z-10">
        <h2 class="text-4xl font-bold mb-4 animate-bounce-in">Siap Membuat Laporan?</h2>
        <p class="text-xl text-gray-300 mb-10">
            Bergabunglah dengan ribuan mahasiswa yang telah mempercayai sistem kami
        </p>
        @auth
            <a href="{{ route('student.reports.create') }}" class="btn-secondary btn-lg px-10 inline-block group">
                <span class="flex items-center justify-center space-x-2">
                    <svg class="w-6 h-6 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Buat Laporan Sekarang</span>
                </span>
            </a>
        @else
            <a href="{{ route('register') }}" class="btn-secondary btn-lg px-10 inline-block group">
                <span class="flex items-center justify-center space-x-2">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    <span>Daftar Gratis</span>
                </span>
            </a>
        @endauth
    </div>
</div>
@endsection
