@extends('layouts.app', ['title' => 'Laporan Saya'])

@section('content')
<!-- Header with Filters -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Laporan Saya</h2>
            <p class="text-gray-600">Kelola dan pantau status laporan Anda</p>
        </div>
        <a href="{{ route('student.reports.create') }}" class="btn-primary mt-4 md:mt-0">
            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Buat Laporan Baru
        </a>
    </div>
    
    <!-- Filters -->
    <form method="GET" action="{{ route('student.reports.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
            <input type="text" name="search" placeholder="Cari judul atau ref..." 
                   value="{{ request('search') }}"
                   class="input-field">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="input-field">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' :  '' }}>Menunggu</option>
                <option value="in_review" {{ request('status') == 'in_review' ? 'selected' : '' }}>Ditinjau</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ?  'selected' : '' }}>Diproses</option>
                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Selesai</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
            <select name="category" class="input-field">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="flex items-end space-x-2">
            <button type="submit" class="btn-primary flex-1">
                Filter
            </button>
            <a href="{{ route('student.reports.index') }}" class="btn-secondary">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Reports List -->
@if($reports->count() > 0)
    <div class="space-y-4">
        @foreach($reports as $report)
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <!-- Header -->
                    <div class="flex items-center space-x-3 mb-3">
                        <span class="badge badge-{{ $report->status_badge_color }}">
                            {{ $report->status_label }}
                        </span>
                        <span class="badge badge-{{ $report->priority_badge_color }}">
                            {{ $report->priority_label }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $report->reference_number }}</span>
                    </div>
                    
                    <!-- Title -->
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $report->title }}</h3>
                    
                    <!-- Description -->
                    <p class="text-gray-600 mb-4">{{ Str::limit($report->description, 150) }}</p>
                    
                    <!-- Meta Info -->
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                        <span class="flex items-center">
                            <span class="mr-1">{{ $report->category->icon }}</span>
                            {{ $report->category->name }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17. 657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $report->full_location }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $report->created_at->format('d M Y, H:i') }}
                        </span>
                        @if($report->attachments_count > 0)
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15. 172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                            {{ $report->attachments_count }} file
                        </span>
                        @endif
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="ml-6 flex flex-col space-y-2">
                    <a href="{{ route('student.reports.show', $report->id) }}" 
                       class="btn-primary text-center text-sm px-4 py-2">
                        Lihat Detail
                    </a>
                    
                    @if($report->status === 'pending')
                        <a href="{{ route('student.reports.edit', $report->id) }}" 
                           class="btn-outline text-center text-sm px-4 py-2">
                            Edit
                        </a>
                        
                        <form method="POST" action="{{ route('student.reports.destroy', $report->id) }}" 
                              onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full text-sm text-red-600 hover:bg-red-50 px-4 py-2 rounded-lg border border-red-300">
                                Hapus
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="mt-6">
        {{ $reports->links() }}
    </div>
@else
    <!-- Empty State -->
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Laporan</h3>
        <p class="text-gray-600 mb-6">
            @if(request()->hasAny(['search', 'status', 'category']))
                Tidak ada laporan yang sesuai dengan filter Anda
            @else
                Anda belum membuat laporan apapun
            @endif
        </p>
        @if(request()->hasAny(['search', 'status', 'category']))
            <a href="{{ route('student.reports.index') }}" class="btn-outline">
                Reset Filter
            </a>
        @else
            <a href="{{ route('student.reports.create') }}" class="btn-primary">
                Buat Laporan Pertama
            </a>
        @endif
    </div>
@endif
@endsection