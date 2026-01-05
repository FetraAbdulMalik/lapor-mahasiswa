@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
<!-- Welcome Section -->
<div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-8 mb-12 border-l-4 border-navy-800 scroll-fade-in" data-observe-once="true">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-navy-800 mb-2">
                Selamat Datang, {{ auth()->user()->name }}! 👋
            </h2>
            <p class="text-gray-700 flex flex-wrap gap-4">
                <span class="flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5H5.75A2.25 2.25 0 003.5 3.75v12.5A2.25 2.25 0 005.75 18.5h8.5a2.25 2.25 0 002.25-2.25V6.5m-11-3v3m6-3v3m-7 3h12"></path></svg>
                    <span><strong>NIM:</strong> {{ auth()->user()->studentProfile->nim }}</span>
                </span>
                <span class="flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.5 1.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9zM10.5 13a6.5 6.5 0 100 4 6.5 6.5 0 000-4z"></path></svg>
                    <span>{{ auth()->user()->studentProfile->department->name }}</span>
                </span>
                <span class="flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path></svg>
                    <span><strong>Semester:</strong> {{ auth()->user()->studentProfile->semester }}</span>
                </span>
            </p>
        </div>
        <div class="hidden md:block text-5xl opacity-20">📊</div>
    </div>
</div>

<!-- Statistics Cards with Scroll Animations -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-16" data-section>
    <!-- Total Reports -->
    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-md p-6 border-l-4 border-navy-800 hover:shadow-lg transition scroll-fade-in micro-card" data-observe-once="true">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700 mb-2">Total Laporan</p>
                <p class="text-4xl font-bold text-navy-800 stat-counter" data-target="{{ $totalReports }}">0</p>
                <p class="text-xs text-gray-600 mt-1">Semua laporan Anda</p>
            </div>
            <div class="w-14 h-14 bg-navy-800 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Pending Reports -->
    <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl shadow-md p-6 border-l-4 border-amber-500 hover:shadow-lg transition scroll-slide-left micro-card" data-observe-once="true">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700 mb-2">Menunggu</p>
                <p class="text-4xl font-bold text-amber-600 stat-counter" data-target="{{ $pendingReports }}">0</p>
                <p class="text-xs text-gray-600 mt-1">Perlu review</p>
            </div>
            <div class="w-14 h-14 bg-amber-500 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- In Progress Reports -->
    <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 rounded-xl shadow-md p-6 border-l-4 border-cyan-500 hover:shadow-lg transition scroll-slide-right micro-card" data-observe-once="true">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700 mb-2">Dalam Proses</p>
                <p class="text-4xl font-bold text-cyan-600 stat-counter" data-target="{{ $inProgressReports }}">0</p>
                <p class="text-xs text-gray-600 mt-1">Sedang ditangani</p>
            </div>
            <div class="w-14 h-14 bg-cyan-500 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Resolved Reports -->
    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl shadow-md p-6 border-l-4 border-green-600 hover:shadow-lg transition scroll-scale-in micro-card" data-observe-once="true">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-700 mb-2">Selesai</p>
                <p class="text-4xl font-bold text-green-600 stat-counter" data-target="{{ $resolvedReports }}">0</p>
                <p class="text-xs text-gray-600 mt-1">Sudah terselesaikan</p>
            </div>
            <div class="w-14 h-14 bg-green-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Recent Reports & Notifications Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 scroll-fade-in" data-section>
    <!-- Recent Reports (Left Column - 2/3 width) -->
    <div class="lg:col-span-2 scroll-slide-left">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                <svg class="w-6 h-6 mr-3 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                </svg>
                Laporan Terbaru
            </h3>
            <a href="{{ route('student.reports.index') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg text-sm font-semibold hover:shadow-lg transition btn-micro">
                Lihat Semua
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        
        @if($recentReports->count() > 0)
            <div class="space-y-4" data-stagger-list>
                @foreach($recentReports->take(3) as $report)
                <div class="bg-white rounded-lg shadow hover:shadow-md transition p-4 border-l-4 border-blue-600 micro-card stagger-item">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="badge badge-{{ $report->status_badge_color }}">
                                    {{ $report->status_label }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $report->reference_number }}</span>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1 link-hover">{{ $report->title }}</h4>
                            <p class="text-sm text-gray-600">{{ Str::limit($report->description, 80) }}</p>
                            <div class="flex items-center space-x-3 text-xs text-gray-500 mt-2">
                                <span>{{ $report->category->icon }} {{ $report->category->name }}</span>
                                <span>📍 {{ $report->building->name ?? 'N/A' }}</span>
                                <span>{{ $report->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <a href="{{ route('student.reports.show', $report->id) }}" class="ml-4 text-blue-600 hover:text-blue-800 btn-micro">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-600 font-medium">Belum ada laporan</p>
            </div>
        @endif
    </div>

    <!-- Notifications (Right Column - 1/3 width) -->
    <div class="scroll-slide-right">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5.951-1.429 5.951 1.429a1 1 0 001.169-1.409l-7-14z"></path>
                </svg>
                Notifikasi
            </h3>
        </div>
        
        @if($notifications->count() > 0)
            <div class="space-y-3" data-stagger-list>
                @foreach($notifications as $notif)
                <div class="bg-white rounded-lg shadow hover:shadow-md transition p-4 border-l-4 border-yellow-400 micro-card stagger-item">
                    <div class="flex items-start space-x-3">
                        <span class="text-lg flex-shrink-0">{{ $notif->icon ?? '📢' }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 link-hover">{{ $notif->title }}</p>
                            <p class="text-xs text-gray-600 mt-1">{{ Str::limit($notif->message, 60) }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <p class="text-gray-600 text-sm">Tidak ada notifikasi</p>
            </div>
        @endif
    </div>
</div>
@endsection
