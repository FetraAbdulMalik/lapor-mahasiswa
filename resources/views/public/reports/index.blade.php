@extends('layouts.guest')

@section('title', 'Laporan Publik')

@section('content')
<div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-2">Laporan Publik</h1>
        <p class="text-xl text-primary-100">Lihat semua laporan yang dibagikan kepada publik</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('reports.public') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Laporan</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari judul laporan..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Diproses</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Selesai</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex items-end">
                <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Reports Grid -->
    @if($reports->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($reports as $report)
                <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                    <!-- Report Header -->
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                {{ $report->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $report->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $report->status == 'resolved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $report->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $report->status == 'pending' ? 'Menunggu' : '' }}
                                {{ $report->status == 'in_progress' ? 'Diproses' : '' }}
                                {{ $report->status == 'resolved' ? 'Selesai' : '' }}
                                {{ $report->status == 'rejected' ? 'Ditolak' : '' }}
                            </span>
                            <span class="text-xs text-gray-500">{{ $report->created_at->diffForHumans() }}</span>
                        </div>

                        <!-- Category Badge -->
                        <div class="mb-3">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-primary-100 text-primary-800">
                                <i class="{{ $report->category->icon ?? 'fas fa-folder' }} mr-1"></i>
                                {{ $report->category->name }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">
                            {{ $report->title }}
                        </h3>

                        <!-- Description -->
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            {{ $report->description }}
                        </p>

                        <!-- Location -->
                        @if($report->building)
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span>{{ $report->building->name }}</span>
                            </div>
                        @endif

                        <!-- Footer -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div class="flex items-center text-xs text-gray-500">
                                <i class="fas fa-user-circle mr-1"></i>
                                @if($report->is_anonymous)
                                    <span>Anonim</span>
                                @else
                                    <span>{{ $report->user->name }}</span>
                                @endif
                            </div>
                            <a href="{{ route('reports.public.show', $report->id) }}" 
                               class="text-primary-600 hover:text-primary-700 font-medium text-sm">
                                Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $reports->appends(request()->query())->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                <i class="fas fa-inbox text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak Ada Laporan</h3>
            <p class="text-gray-600 mb-6">Belum ada laporan publik yang tersedia saat ini.</p>
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition duration-200">
                <i class="fas fa-home mr-2"></i>Kembali ke Beranda
            </a>
        </div>
    @endif
</div>
@endsection
