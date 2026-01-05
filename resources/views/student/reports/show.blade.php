@extends('layouts.app', ['title' => 'Detail Laporan'])

@section('content')
<div class="max-w-6xl mx-auto">
    
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('student.reports.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Laporan
        </a>
    </div>
    
    <div class="grid grid-cols-1 lg: grid-cols-3 gap-6">
        
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Report Header -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-3">
                            <span class="badge badge-{{ $report->status_badge_color }} text-base">
                                {{ $report->status_label }}
                            </span>
                            <span class="badge badge-{{ $report->priority_badge_color }}">
                                {{ $report->priority_label }}
                            </span>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $report->title }}</h1>
                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                            <span class="font-mono">{{ $report->reference_number }}</span>
                            <span>•</span>
                            <span>{{ $report->created_at->format('d M Y, H:i') }}</span>
                            <span>•</span>
                            <span>{{ $report->views_count }} views</span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    @if($report->status === 'pending')
                    <div class="flex space-x-2">
                        <a href="{{ route('student.reports.edit', $report->id) }}" class="btn-outline text-sm">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>
                        <form method="POST" action="{{ route('student.reports.destroy', $report->id) }}" 
                              onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 hover:bg-red-50 px-4 py-2 rounded-lg border border-red-300">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
                
                <!-- Category & Location -->
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-4 pb-4 border-b">
                    <div class="flex items-center">
                        <span class="text-2xl mr-2">{{ $report->category->icon }}</span>
                        <div>
                            <div class="text-xs text-gray-500">Kategori</div>
                            <div class="font-semibold">{{ $report->category->name }}</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17. 657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <div>
                            <div class="text-xs text-gray-500">Lokasi</div>
                            <div class="font-semibold">{{ $report->full_location }}</div>
                        </div>
                    </div>
                    
                    @if($report->incident_date)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <div class="text-xs text-gray-500">Tanggal Kejadian</div>
                            <div class="font-semibold">{{ $report->incident_date->format('d M Y') }}</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($report->assigned_to)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div>
                            <div class="text-xs text-gray-500">Ditangani Oleh</div>
                            <div class="font-semibold">{{ $report->assignedTo->name }}</div>
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Description -->
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Deskripsi Masalah</h3>
                    <div class="prose prose-sm max-w-none text-gray-700">
                        {{ $report->description }}
                    </div>
                </div>
                
                <!-- Resolution Notes (if resolved) -->
                @if($report->status === 'resolved' && $report->resolution_notes)
                <div class="mt-6 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                    <h3 class="text-lg font-bold text-green-900 mb-2">✓ Penyelesaian</h3>
                    <p class="text-green-700">{{ $report->resolution_notes }}</p>
                    <p class="text-sm text-green-600 mt-2">
                        Diselesaikan pada {{ $report->resolved_at->format('d M Y, H:i') }}
                    </p>
                </div>
                @endif
                
                @if($report->status === 'rejected')
                <div class="mt-6 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                    <h3 class="text-lg font-bold text-red-900 mb-2">✗ Laporan Ditolak</h3>
                    <p class="text-red-700">{{ $report->resolution_notes ??  'Laporan tidak dapat diproses.' }}</p>
                </div>
                @endif
            </div>
            
            <!-- Attachments -->
            @if($report->attachments->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Bukti Lampiran ({{ $report->attachments->count() }})</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($report->attachments as $attachment)
                    <div class="relative group">
                        @if($attachment->isImage())
                            <a href="{{ $attachment->url }}" target="_blank" class="block">
                                <img src="{{ $attachment->url }}" alt="{{ $attachment->file_name }}" 
                                     class="w-full h-32 object-cover rounded-lg border-2 border-gray-200 hover:border-blue-500 transition">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 rounded-lg transition flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                    </svg>
                                </div>
                            </a>
                        @else
                            <a href="{{ $attachment->url }}" target="_blank" 
                               class="block w-full h-32 bg-gray-100 rounded-lg border-2 border-gray-200 hover:border-blue-500 transition flex flex-col items-center justify-center p-2">
                                <span class="text-4xl mb-2">{{ $attachment->icon }}</span>
                                <span class="text-xs text-gray-600 text-center truncate w-full">{{ $attachment->file_name }}</span>
                            </a>
                        @endif
                        <p class="text-xs text-gray-500 mt-1 text-center">{{ $attachment->file_size_human }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Comments Section -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">
                    Komentar & Tanggapan ({{ $report->comments->count() }})
                </h3>
                
                <!-- Comments List -->
                @if($report->comments->count() > 0)
                <div class="space-y-4 mb-6">
                    @foreach($report->comments as $comment)
                    <div class="flex space-x-3 {{ $comment->is_official ? 'bg-blue-50 -mx-6 px-6 py-4' :  '' }}">
                        <div class="flex-shrink-0">
                            @if($comment->is_official)
                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                    <span class="text-gray-600 font-semibold">{{ substr($comment->user->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="font-semibold text-gray-900">{{ $comment->user->name }}</span>
                                @if($comment->is_official)
                                    <span class="badge badge-blue text-xs">Official</span>
                                @endif
                                <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-700">{{ $comment->comment }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 mb-6">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h. 01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <p class="text-gray-600">Belum ada komentar</p>
                </div>
                @endif
                
                <!-- Add Comment Form -->
                @if(in_array($report->status, ['pending', 'in_review', 'in_progress']))
                <form method="POST" action="{{ route('student.reports.comment', $report->id) }}" class="border-t pt-4">
                    @csrf
                    <textarea name="comment" rows="3" required
                              class="input-field mb-3" 
                              placeholder="Tambahkan komentar atau pertanyaan... "></textarea>
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Kirim Komentar
                    </button>
                </form>
                @endif
            </div>
            
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            
            <!-- Status Timeline -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Timeline Tracking</h3>
                
                <div class="relative">
                    @foreach($report->statusHistory as $index => $status)
                    <div class="flex pb-6 {{ $loop->last ? '' : 'border-l-2 border-gray-200 ml-3' }}">
                        <div class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center 
                                    {{ $status->new_status === 'resolved' ? 'bg-green-500' : 
                                       ($status->new_status === 'rejected' ? 'bg-red-500' :  'bg-blue-500') }} 
                                    text-white z-10 -ml-3">
                            <span class="text-xs font-bold">{{ $status->icon }}</span>
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-semibold text-gray-900">{{ $status->status_label }}</span>
                                <span class="text-xs text-gray-500">{{ $status->created_at->format('d M, H:i') }}</span>
                            </div>
                            @if($status->notes)
                                <p class="text-sm text-gray-600">{{ $status->notes }}</p>
                            @endif
                            <p class="text-xs text-gray-500 mt-1">oleh {{ $status->createdBy->name }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Duration -->
                <div class="mt-4 pt-4 border-t">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Durasi: </span>
                        <span class="font-semibold text-gray-900">{{ $report->days_open }} hari</span>
                    </div>
                </div>
            </div>
            
            <!-- Report Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Laporan</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Pelapor:</span>
                        <span class="font-semibold">{{ $report->reporter_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nomor Referensi:</span>
                        <span class="font-mono font-semibold">{{ $report->reference_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Dibuat: </span>
                        <span class="font-semibold">{{ $report->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Terakhir Update:</span>
                        <span class="font-semibold">{{ $report->updated_at->format('d M Y, H: i') }}</span>
                    </div>
                    @if($report->resolved_at)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Diselesaikan:</span>
                        <span class="font-semibold text-green-600">{{ $report->resolved_at->format('d M Y, H:i') }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600">Visibilitas:</span>
                        <span class="font-semibold capitalize">{{ $report->visibility }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Views:</span>
                        <span class="font-semibold">{{ $report->views_count }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="space-y-2">
                    <button onclick="window.print()" class="w-full btn-outline text-sm">
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Laporan
                    </button>
                    <button onclick="shareReport()" class="w-full btn-outline text-sm">
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8. 684 13.342C8.886 12.938 9 12.482 9 12c0-. 482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                        </svg>
                        Share Laporan
                    </button>
                    @if(in_array($report->status, ['pending', 'in_review', 'in_progress']))
                    <a href="{{ route('student.reports.index', ['status' => $report->status]) }}" class="block w-full btn-outline text-sm text-center">
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h. 01M9 16h.01"></path>
                        </svg>
                        Laporan Serupa
                    </a>
                    @endif
                </div>
            </div>
            
            <!-- Help -->
            <div class="bg-blue-50 rounded-lg p-6 border-l-4 border-blue-500">
                <h3 class="text-lg font-bold text-primary-900 mb-2">Butuh Bantuan?</h3>
                <p class="text-sm text-navy-700 mb-3">
                    Jika ada pertanyaan tentang laporan Anda, silakan tambahkan komentar atau hubungi admin. 
                </p>
                <a href="{{ route('contact') }}" class="text-sm text-navy-800 hover:text-navy-700 font-semibold">
                    Hubungi Admin →
                </a>
            </div>
            
        </div>
    </div>
</div>

@push('scripts')
<script>
function shareReport() {
    const url = window.location.href;
    const title = '{{ $report->title }}';
    
    if (navigator.share) {
        navigator.share({
            title: title,
            url: url
        });
    } else {
        // Fallback:  copy to clipboard
        navigator.clipboard.writeText(url);
        alert('Link laporan berhasil disalin! ');
    }
}

// Print styles
window.onbeforeprint = function() {
    document.body.classList.add('printing');
}
window.onafterprint = function() {
    document.body.classList.remove('printing');
}
</script>

<style>
@media print {
    body. printing aside,
    body.printing nav,
    body.printing button,
    body.printing . no-print {
        display: none !important;
    }
    
    body.printing .bg-white {
        box-shadow: none !important;
    }
}
</style>
@endpush
@endsection
