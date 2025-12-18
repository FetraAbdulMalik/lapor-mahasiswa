@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
<!-- Welcome Section -->
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">
        Selamat Datang, {{ auth()->user()->name }}!  👋
    </h2>
    <p class="text-gray-600">
        NIM: {{ auth()->user()->studentProfile->nim }} | 
        {{ auth()->user()->studentProfile->department->name }} | 
        Semester {{ auth()->user()->studentProfile->semester }}
    </p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Laporan</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalReports }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Menunggu</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $pendingReports }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Dalam Proses</p>
                <p class="text-3xl font-bold text-purple-600">{{ $inProgressReports }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10. 325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Selesai</p>
                <p class="text-3xl font-bold text-green-600">{{ $resolvedReports }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Aksi Cepat</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('student.reports.create') }}" class="btn-primary text-center">
            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Buat Laporan Baru
        </a>
        <a href="{{ route('student.reports.index') }}" class="btn-outline text-center">
            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Lihat Semua Laporan
        </a>
        <a href="{{ route('reports.public') }}" class="btn-outline text-center">
            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
            Laporan Publik
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Recent Reports -->
    <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900">Laporan Terbaru Saya</h3>
            <a href="{{ route('student.reports.index') }}" class="text-sm text-primary-600 hover:text-primary-700">
                Lihat Semua →
            </a>
        </div>
        
        @if($recentReports->count() > 0)
            <div class="space-y-4">
                @foreach($recentReports as $report)
                <div class="border border-gray-200 rounded-lg p-4 hover:border-primary-300 transition">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="badge badge-{{ $report->status_badge_color }}">
                                    {{ $report->status_label }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $report->reference_number }}</span>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">{{ $report->title }}</h4>
                            <p class="text-sm text-gray-600 mb-2">{{ Str::limit($report->description, 100) }}</p>
                            <div class="flex items-center space-x-4 text-xs text-gray-500">
                                <span>{{ $report->category->icon }} {{ $report->category->name }}</span>
                                <span>📍 {{ $report->building->name ??  'Lokasi tidak disebutkan' }}</span>
                                <span>🕒 {{ $report->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <a href="{{ route('student.reports.show', $report->id) }}" class="ml-4 text-primary-600 hover:text-primary-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-600 mb-4">Belum ada laporan</p>
                <a href="{{ route('student.reports.create') }}" class="btn-primary">
                    Buat Laporan Pertama
                </a>
            </div>
        @endif
    </div>
    
    <!-- Notifications -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900">Notifikasi</h3>
            <a href="{{ route('student.notifications.index') }}" class="text-sm text-primary-600 hover:text-primary-700">
                Lihat Semua →
            </a>
        </div>
        
        @if($notifications->count() > 0)
            <div class="space-y-3">
                @foreach($notifications as $notif)
                <div class="border-l-4 border-primary-500 bg-primary-50 p-3 rounded">
                    <div class="flex items-start">
                        <span class="text-lg mr-2">{{ $notif->icon }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900">{{ $notif->title }}</p>
                            <p class="text-xs text-gray-600 mt-1">{{ $notif->message }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 . 538-.214 1.055-. 595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <p class="text-sm text-gray-600">Tidak ada notifikasi baru</p>
            </div>
        @endif
    </div>
</div>
@endsection
