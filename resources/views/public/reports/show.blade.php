@extends('layouts.guest')

@section('title', $report->title)

@section('content')
<div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('reports.public') }}" class="inline-flex items-center text-primary-100 hover:text-white mb-4">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Laporan Publik
        </a>
        <h1 class="text-3xl font-bold">Detail Laporan</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Report Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <!-- Header -->
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $report->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $report->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $report->status == 'resolved' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $report->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ $report->status == 'pending' ? 'Menunggu' : '' }}
                            {{ $report->status == 'in_progress' ? 'Diproses' : '' }}
                            {{ $report->status == 'resolved' ? 'Selesai' : '' }}
                            {{ $report->status == 'rejected' ? 'Ditolak' : '' }}
                        </span>
                    </div>
                    <div class="text-right text-sm text-gray-500">
                        <div>{{ $report->created_at->format('d M Y, H:i') }}</div>
                        <div class="flex items-center justify-end mt-1">
                            <i class="fas fa-eye mr-1"></i>
                            <span>{{ $report->views_count ?? 0 }} views</span>
                        </div>
                    </div>
                </div>

                <!-- Title & Category -->
                <div class="mb-6">
                    <span class="inline-flex items-center px-3 py-1 rounded text-sm font-medium bg-primary-100 text-primary-800 mb-3">
                        <i class="{{ $report->category->icon ?? 'fas fa-folder' }} mr-2"></i>
                        {{ $report->category->name }}
                    </span>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $report->title }}</h1>
                </div>

                <!-- Description -->
                <div class="prose max-w-none mb-6">
                    <p class="text-gray-700 whitespace-pre-line">{{ $report->description }}</p>
                </div>

                <!-- Attachments -->
                @if($report->attachments && $report->attachments->count() > 0)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Lampiran Foto</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($report->attachments as $attachment)
                                <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="group">
                                    <img src="{{ Storage::url($attachment->file_path) }}" 
                                         alt="Attachment" 
                                         class="w-full h-48 object-cover rounded-lg group-hover:opacity-75 transition">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Location -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Lokasi</h3>
                    <div class="space-y-2">
                        @if($report->building)
                            <div class="flex items-center text-gray-700">
                                <i class="fas fa-building w-6 mr-3 text-gray-400"></i>
                                <span>{{ $report->building->name }}</span>
                            </div>
                        @endif
                        @if($report->facility)
                            <div class="flex items-center text-gray-700">
                                <i class="fas fa-door-open w-6 mr-3 text-gray-400"></i>
                                <span>{{ $report->facility->name }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            @if($report->comments && $report->comments->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-comments mr-2"></i>Komentar ({{ $report->comments->count() }})
                    </h3>
                    <div class="space-y-4">
                        @foreach($report->comments as $comment)
                            <div class="border-l-4 border-primary-500 pl-4 py-2">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-primary-600"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $comment->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-700 ml-11">{{ $comment->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Reporter Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pelapor</h3>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user-circle text-2xl text-gray-400"></i>
                    </div>
                    <div>
                        @if($report->is_anonymous)
                            <div class="font-medium text-gray-900">Anonim</div>
                            <div class="text-sm text-gray-500">Identitas disembunyikan</div>
                        @else
                            <div class="font-medium text-gray-900">{{ $report->user->name }}</div>
                            <div class="text-sm text-gray-500">Mahasiswa</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Status Timeline -->
            @if($report->statusHistory && $report->statusHistory->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Status</h3>
                    <div class="space-y-4">
                        @foreach($report->statusHistory->sortByDesc('created_at') as $history)
                            <div class="flex">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center
                                    {{ $history->status == 'pending' ? 'bg-yellow-100 text-yellow-600' : '' }}
                                    {{ $history->status == 'in_progress' ? 'bg-blue-100 text-blue-600' : '' }}
                                    {{ $history->status == 'resolved' ? 'bg-green-100 text-green-600' : '' }}
                                    {{ $history->status == 'rejected' ? 'bg-red-100 text-red-600' : '' }}">
                                    <i class="fas fa-circle text-xs"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <div class="font-medium text-gray-900">
                                        {{ ucfirst(str_replace('_', ' ', $history->status)) }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $history->created_at->format('d M Y, H:i') }}</div>
                                    @if($history->notes)
                                        <p class="text-sm text-gray-600 mt-1">{{ $history->notes }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Related Reports -->
            @if($relatedReports && $relatedReports->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Laporan Terkait</h3>
                    <div class="space-y-4">
                        @foreach($relatedReports as $related)
                            <a href="{{ route('reports.public.show', $related->id) }}" class="block group">
                                <div class="flex items-start">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900 group-hover:text-primary-600 line-clamp-2">
                                            {{ $related->title }}
                                        </h4>
                                        <p class="text-sm text-gray-500 mt-1">{{ $related->created_at->diffForHumans() }}</p>
                                    </div>
                                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-primary-600 ml-2"></i>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
