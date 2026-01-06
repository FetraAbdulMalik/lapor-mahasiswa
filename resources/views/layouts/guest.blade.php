<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Lapor Mahasiswa' }} - Sistem Pelaporan Kampus</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display:  none !important; }
    </style>
</head>
<body class="bg-gray-50">
    
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-navy-800 rounded-lg flex items-center justify-center">
                            <span class="text-white text-xl font-bold">LM</span>
                        </div>
                        <span class="text-xl font-bold text-gray-900">Lapor Mahasiswa</span>
                    </a>
                    
                    <!-- Navigation Links -->
                    <div class="hidden md:flex md:ml-10 md:space-x-8">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-navy-800 px-3 py-2 text-sm font-medium">
                            Beranda
                        </a>
                        <a href="{{ route('reports.public') }}" class="text-gray-700 hover:text-navy-800 px-3 py-2 text-sm font-medium">
                            Laporan Publik
                        </a>
                        <a href="{{ route('statistics') }}" class="text-gray-700 hover:text-navy-800 px-3 py-2 text-sm font-medium">
                            Statistik
                        </a>
                        <a href="{{ route('how.to.report') }}" class="text-gray-700 hover:text-navy-800 px-3 py-2 text-sm font-medium">
                            Cara Melapor
                        </a>
                        <a href="{{ route('faq') }}" class="text-gray-700 hover:text-navy-800 px-3 py-2 text-sm font-medium">
                            FAQ
                        </a>
                    </div>
                </div>
                
                <!-- Auth Links -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ auth()->user()->isStudent() ? route('student.dashboard') : route('admin.dashboard') }}" 
                           class="text-gray-700 hover:text-navy-800 px-3 py-2 text-sm font-medium">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-navy-800 px-3 py-2 text-sm font-medium">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm: px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Lapor Mahasiswa</h3>
                    <p class="text-gray-400 text-sm">
                        Sistem pelaporan masalah kampus yang cepat, transparan, dan terpercaya.
                    </p>
                </div>
                
                <!-- Links -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Menu</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white">Beranda</a></li>
                        <li><a href="{{ route('reports.public') }}" class="text-gray-400 hover:text-white">Laporan Publik</a></li>
                        <li><a href="{{ route('statistics') }}" class="text-gray-400 hover:text-white">Statistik</a></li>
                        <li><a href="{{ route('faq') }}" class="text-gray-400 hover:text-white">FAQ</a></li>
                    </ul>
                </div>
                
                <!-- Support -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Bantuan</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('how.to.report') }}" class="text-gray-400 hover:text-white">Cara Melapor</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white">Kontak</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white">Tentang Kami</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Kontak</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>📧 TB-Kelompok2</li>
                        <li>📞 021-12345678</li>
                        <li>📍 Jl. Raya Kampus No. 1</li>
                        <li>�  anggota Fetra, Sandra, Agni</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} Lapor Mahasiswa. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    @stack('scripts')
</body>
</html>
