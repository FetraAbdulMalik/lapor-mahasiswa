<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} - Lapor Mahasiswa</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-white" x-data="{ sidebarOpen: false }">
    
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg flex-shrink-0 hidden md:block sidebar-enter">
            <div class="h-full flex flex-col">
                <!-- Logo -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <a href="{{ route('student.dashboard') }}" class="flex items-center space-x-3 sidebar-logo transition-all duration-300">
                        <div class="w-10 h-10 bg-gradient-to-br from-navy-700 to-navy-900 rounded-lg flex items-center justify-center shadow-md">
                            <span class="text-white text-xl font-bold">LM</span>
                        </div>
                        <span class="text-lg font-bold bg-gradient-to-r from-navy-800 to-navy-900 bg-clip-text text-transparent">Lapor Mahasiswa</span>
                    </a>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    <a href="{{ route('student.dashboard') }}" 
                       class="sidebar-nav-item nav-link flex items-center space-x-3 px-4 py-3 rounded-lg relative transition-all duration-300 {{ request()->routeIs('student.dashboard') ? 'bg-cyan-50 text-navy-700 active' : 'text-navy-600' }}">
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('student.reports.create') }}" 
                       class="sidebar-nav-item nav-link flex items-center space-x-3 px-4 py-3 rounded-lg relative transition-all duration-300 {{ request()->routeIs('student.reports.create') ? 'bg-cyan-50 text-navy-700 active' : 'text-navy-600' }}">
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span class="font-medium">Buat Laporan</span>
                    </a>
                    
                    <a href="{{ route('student.reports.index') }}" 
                       class="sidebar-nav-item nav-link flex items-center space-x-3 px-4 py-3 rounded-lg relative transition-all duration-300 {{ request()->routeIs('student.reports.*') && ! request()->routeIs('student.reports.create') ? 'bg-cyan-50 text-navy-700 active' : 'text-navy-600' }}">
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="font-medium">Laporan Saya</span>
                    </a>
                    
                    <a href="{{ route('reports.public') }}" 
                       class="sidebar-nav-item nav-link flex items-center space-x-3 px-4 py-3 rounded-lg relative transition-all duration-300 text-navy-600">
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span class="font-medium">Laporan Publik</span>
                    </a>
                    
                    <a href="{{ route('student.notifications.index') }}" 
                       class="sidebar-nav-item nav-link flex items-center space-x-3 px-4 py-3 rounded-lg relative transition-all duration-300 {{ request()->routeIs('student.notifications.*') ? 'bg-cyan-50 text-navy-700 active' : 'text-navy-600' }}">
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="font-medium">Notifikasi</span>
                        @auth
                            @if(auth()->user()->notifications()->unread()->count() > 0)
                                <span class="ml-auto bg-gradient-to-r from-red-500 to-red-600 text-white text-xs px-2 py-1 rounded-full font-semibold notification-badge shadow-md">
                                    {{ auth()->user()->notifications()->unread()->count() }}
                                </span>
                            @endif
                        @endauth
                    </a>
                    
                    <a href="{{ route('student.profile.index') }}" 
                       class="sidebar-nav-item nav-link flex items-center space-x-3 px-4 py-3 rounded-lg relative transition-all duration-300 {{ request()->routeIs('student.profile.*') ? 'bg-cyan-50 text-navy-700 active' : 'text-navy-600' }}">
                        <svg class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="font-medium">Profil</span>
                    </a>
                </nav>
                
                <!-- Divider -->
                <div class="border-t border-gray-200"></div>
                
                <!-- User Info -->
                @auth
                <div class="sidebar-user-info px-4 py-4">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="relative">
                            <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-10 h-10 rounded-full ring-2 ring-cyan-200 transition-transform duration-300 hover:scale-110">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-xs text-gray-500 truncate">
                                {{ auth()->user()->studentProfile->nim }}
                            </p>
                        </div>
                    </div>
                @endauth
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm font-medium text-navy-600 bg-navy-50 hover:bg-navy-100 rounded-lg transition-all duration-300 border border-navy-200 hover:border-navy-300 hover:text-navy-700">
                            ← Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        
        <!-- Contact Info Sidebar -->
        @if(!isset($hideSidebar) || !$hideSidebar)
        <aside class="w-80 bg-gradient-to-b from-blue-50 to-indigo-50 border-l border-blue-200 hidden xl:block flex-shrink-0 overflow-y-auto">
            <div class="p-6 space-y-6">
                <!-- Contact Header -->
                <div class="text-center border-b border-blue-200 pb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Hubungi Kami</h3>
                    <p class="text-sm text-gray-600">Kami siap membantu Anda</p>
                </div>

                <!-- Email Card -->
                <div class="bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-all duration-300 border border-blue-100">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-gray-900 mb-1">Email</h4>
                            <a href="mailto:support@lapormahasiswa.ac.id" class="text-sm text-blue-600 hover:text-blue-700 font-medium break-all">
                                support@lapormahasiswa.ac.id
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Phone Card -->
                <div class="bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-all duration-300 border border-green-100">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-gray-900 mb-1">Telepon</h4>
                            <a href="tel:+62-XXX-XXXX-XXXX" class="text-sm text-green-600 hover:text-green-700 font-medium">
                                +62-XXX-XXXX-XXXX
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Location Card -->
                <div class="bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-all duration-300 border border-red-100">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-gray-900 mb-1">Lokasi</h4>
                            <p class="text-xs text-gray-600 leading-relaxed">
                                Kampus Utama, Gedung A<br>
                                Jalan Universitas No. 1
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t border-blue-200"></div>

                <!-- CTA Button -->
                <a href="{{ route('contact') }}" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 rounded-lg text-center transition-all duration-300 shadow-md hover:shadow-lg">
                    Kirim Pesan
                </a>

                <!-- Support Info -->
                <div class="bg-white rounded-lg p-4 border border-indigo-100">
                    <p class="text-xs text-gray-600 text-center">
                        <span class="font-semibold text-gray-900">Jam Kerja:</span><br>
                        Senin - Jumat: 08:00 - 17:00<br>
                        <span class="text-xs text-gray-500">Waktu Setempat</span>
                    </p>
                </div>
            </div>
        </aside>
        @endif

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Bar -->
            <header class="bg-white shadow-sm z-10 border-b border-navy-200">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-navy-900">{{ $title ?? 'Dashboard' }}</h1>
                        @isset($subtitle)
                            <p class="text-sm text-navy-600">{{ $subtitle }}</p>
                        @endisset
                    </div>
                    
                    <!-- Mobile Menu Button -->
                    <button @click="sidebarOpen = ! sidebarOpen" class="md:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                
                <!-- Alerts -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                        <p class="text-green-700">{{ session('success') }}</p>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <p class="text-red-700">{{ session('error') }}</p>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
        
    </div>
    
    @stack('scripts')
</body>
</html>
