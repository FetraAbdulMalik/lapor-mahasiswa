@extends('layouts.admin', ['title' => 'Detail Mahasiswa'])

@section('content')

<!-- Back Button -->
<div class="mb-6">
    <a href="{{ route('admin.students.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Kembali ke Daftar Mahasiswa
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Student Profile -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <img src="{{ $student->avatar }}" alt="{{ $student->name }}" 
                 class="w-32 h-32 rounded-full mx-auto mb-4 border-4 border-gray-200">
            
            <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $student->name }}</h2>
            <p class="text-gray-600 mb-4">{{ $student->studentProfile->nim }}</p>
            
            <div class="space-y-2 text-sm text-left mb-6">
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Fakultas: </span>
                    <span class="font-semibold">{{ $student->studentProfile->faculty->code }}</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Jurusan:</span>
                    <span class="font-semibold">{{ $student->studentProfile->department->name }}</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Semester:</span>
                    <span class="font-semibold">{{ $student->studentProfile->semester }}</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Angkatan:</span>
                    <span class="font-semibold">{{ $student->studentProfile->year_of_entry }}</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Status:</span>
                    <span class="badge {{ $student->is_active ? 'badge-green' : 'badge-red' }}">
                        {{ $student->is_active ? 'Aktif' :  'Nonaktif' }}
                    </span>
                </div>
            </div>
            
            <div class="space-y-2 text-sm text-left mb-6 pt-4 border-t">
                <div class="flex items-center text-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    {{ $student->email }}
                </div>
                @if($student->phone)
                <div class="flex items-center text-gray-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-. 502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    {{ $student->phone }}
                </div>
                @endif
            </div>
            
            <div class="flex space-x-2">
                <a href="mailto:{{ $student->email }}" class="flex-1 btn-outline text-sm">
                    📧 Email
                </a>
                <a href="{{ route('admin.students.edit', $student->id) }}" class="flex-1 btn-primary text-sm">
                    ✏️ Edit
                </a>
            </div>
        </div>
    </div>
    
    <!-- Student Activity -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Statistics -->
        <div class="grid grid-cols-1 md: grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <p class="text-sm text-gray-600 mb-1">Total Laporan</p>
                <p class="text-3xl font-bold text-blue-600">{{ $totalReports }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <p class="text-sm text-gray-600 mb-1">Sedang Proses</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $pendingReports }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <p class="text-sm text-gray-600 mb-1">Selesai</p>
                <p class="text-3xl font-bold text-green-600">{{ $resolvedReports }}</p>
            </div>
        </div>
        
        <!-- Recent Reports -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Riwayat Laporan</h3>
            
            @if($student->reports->count() > 0)
            <div class="space-y-4">
                @foreach($student->reports()->latest()->take(10)->get() as $report)
                <div class="border-l-4 border-{{ $report->status_badge_color }}-500 bg-gray-50 p-4 rounded">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <span class="badge badge-{{ $report->status_badge_color }} text-xs">
                                    {{ $report->status_label }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $report->reference_number }}</span>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">{{ $report->title }}</h4>
                            <p class="text-sm text-gray-600 mb-2">{{ Str::limit($report->description, 100) }}</p>
                            <div class="flex items-center space-x-4 text-xs text-gray-500">
                                <span>{{ $report->category->icon }} {{ $report->category->name }}</span>
                                <span>🕒 {{ $report->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.reports.show', $report->id) }}" 
                           class="ml-4 text-navy-800 hover:text-navy-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8 text-gray-500">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p>Belum ada laporan</p>
            </div>
            @endif
        </div>
        
    </div>
</div>

@endsection
