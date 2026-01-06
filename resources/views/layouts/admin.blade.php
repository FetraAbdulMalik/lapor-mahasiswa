<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Dashboard' }} - Lapor Mahasiswa</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-white" x-data="{ sidebarOpen: false }">
    
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-navy-900 text-white flex-shrink-0 hidden md:block sidebar-enter">
            <div class="h-full flex flex-col">
                <!-- Logo -->
                <div class="px-6 py-4 border-b border-navy-800">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 sidebar-logo transition-all duration-300">
                        <div class="w-10 h-10 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg flex items-center justify-center shadow-lg">
                            <span class="text-navy-900 text-xl font-bold">LM</span>
                        </div>
                        <div>
                            <span class="text-base font-bold bg-gradient-to-r from-cyan-400 to-cyan-300 bg-clip-text text-transparent">Admin Panel</span>
                            <p class="text-xs text-gray-400">Lapor Mahasiswa</p>
                        </div>
                    </a>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="sidebar-nav-item nav-link flex items-center space-x-3 px-4 py-3 rounded-lg relative transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-cyan-500 text-white active' : 'text-gray-300 hover:text-white' }} group">
                        <svg class="w-5 h-5 transition-all duration-300 icon-animated icon-glow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.reports.index') }}" 
                       class="sidebar-nav-item nav-link flex items-center space-x-3 px-4 py-3 rounded-lg relative transition-all duration-300 {{ request()->routeIs('admin.reports.*') ? 'bg-cyan-500 text-white active' : 'text-gray-300 hover:text-white' }} group">
                        <svg class="w-5 h-5 transition-all duration-300 icon-animated icon-glow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="font-medium">Kelola Laporan</span>
                    </a>
                    
                    <a href="{{ route('admin.students.index') }}" 
                       class="sidebar-nav-item nav-link flex items-center space-x-3 px-4 py-3 rounded-lg relative transition-all duration-300 {{ request()->routeIs('admin.students.*') ? 'bg-cyan-500 text-white active' : 'text-gray-300 hover:text-white' }} group">
                        <svg class="w-5 h-5 transition-all duration-300 icon-animated icon-glow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="font-medium">Kelola Mahasiswa</span>
                    </a>
                    
                    @if(auth()->user()->isSuperAdmin())
                    <div class="pt-4 pb-2">
                        <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Master Data</p>
                    </div>
                    
                    <a href="{{ route('admin.categories.index') }}" 
                       class="sidebar-nav-item nav-link flex items-center space-x-3 px-4 py-3 rounded-lg relative transition-all duration-300 {{ request()->routeIs('admin.categories.*') ? 'bg-cyan-500 text-white active' : 'text-gray-300 hover:text-white' }} group">
                        <svg class="w-5 h-5 transition-all duration-300 icon-animated icon-glow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <span class="font-medium">Kategori</span>
                    </a>
                    
                    <a href="{{ route('admin.buildings.index') }}" 
                       class="sidebar-nav-item nav-link flex items-center space-x-3 px-4 py-3 rounded-lg relative transition-all duration-300 {{ request()->routeIs('admin.buildings.*') ? 'bg-cyan-500 text-white active' : 'text-gray-300 hover:text-white' }} group">
                        <svg class="w-5 h-5 transition-all duration-300 icon-animated icon-glow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span class="font-medium">Gedung & Fasilitas</span>
                    </a>
                    @endif
                    
                    <div class="pt-4 pb-2">
                        <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Lainnya</p>
                    </div>
                    
                    <a href="{{ route('admin.analytics.index') }}" 
                       class="sidebar-nav-item nav-link flex items-center space-x-3 px-4 py-3 rounded-lg relative transition-all duration-300 text-gray-300 hover:text-white group">
                        <svg class="w-5 h-5 transition-all duration-300 icon-animated icon-glow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="font-medium">Analitik</span>
                    </a>
                    
                    @if(auth()->user()->isSuperAdmin())
                    <a href="{{ route('admin.settings.index') }}" 
                       class="sidebar-nav-item nav-link flex items-center space-x-3 px-4 py-3 rounded-lg relative transition-all duration-300 text-gray-300 hover:text-white group">
                        <svg class="w-5 h-5 transition-all duration-300 icon-animated icon-glow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-medium">Pengaturan</span>
                    </a>
                    @endif
                </nav>
                
                <!-- Divider -->
                <div class="border-t border-navy-800"></div>
                
                <!-- User Info -->
                <div class="sidebar-user-info px-4 py-4">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-full flex items-center justify-center ring-2 ring-navy-700 transition-transform duration-300 hover:scale-110">
                            <span class="text-navy-900 font-bold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-white truncate">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-xs text-gray-400 truncate">
                                {{ auth()->user()->role === 'super_admin' ? 'Super Admin' : 'Admin' }}
                            </p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm font-medium text-gray-300 bg-navy-800 hover:bg-navy-700 rounded-lg transition-all duration-300 border border-navy-700 hover:border-cyan-500 hover:text-cyan-400">
                            ← Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Bar -->
            <header class="bg-white shadow-sm z-10 border-b border-navy-200">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-navy-900">{{ $title ?? 'Admin Dashboard' }}</h1>
                        @isset($subtitle)
                            <p class="text-sm text-navy-600">{{ $subtitle }}</p>
                        @endisset
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-navy-600">{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                
                <!-- Alerts -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                        <p class="text-green-700">✓ {{ session('success') }}</p>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <p class="text-red-700">✗ {{ session('error') }}</p>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
        
    </div>
    
    @stack('scripts')
</body>
</html>
