@extends('layouts.admin', ['title' => 'Detail Laporan'])

@section('content')

<!-- Back Button -->
<div class="mb-6">
    <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
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
                        @if($report->is_anonymous)
                            <span class="badge badge-gray">
                                <svg class="w-3 h-3 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Anonim
                            </span>
                        @endif
                    </div>
                    
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $report->title }}</h1>
                    
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                        <span class="font-mono">{{ $report->reference_number }}</span>
                        <span>•</span>
                        <span>{{ $report->created_at->format('d M Y, H:i') }}</span>
                        <span>•</span>
                        <span>{{ $report->views_count }} views</span>
                        <span>•</span>
                        <span>{{ $report->days_open }} hari</span>
                    </div>
                </div>
            </div>
            
            <!-- Reporter Info -->
            <div class="grid grid-cols-1 md: grid-cols-2 gap-4 p-4 bg-gray-50 rounded-lg mb-4">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Pelapor</p>
                    @if($report->is_anonymous)
                        <p class="font-semibold text-gray-900">Anonim</p>
                        <p class="text-xs text-gray-500">(Identitas disembunyikan)</p>
                    @else
                        <p class="font-semibold text-gray-900">{{ $report->user->name }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $report->user->studentProfile->nim }} - 
                            {{ $report->user->studentProfile->department->name }}
                        </p>
                    @endif
                </div>
                
                <div>
                    <p class="text-xs text-gray-500 mb-1">Kontak</p>
                    @if($report->is_anonymous)
                        <p class="text-sm text-gray-400 italic">Tidak tersedia</p>
                    @else
                        <p class="text-sm text-gray-900">📧 {{ $report->user->email }}</p>
                        @if($report->user->phone)
                            <p class="text-sm text-gray-900">📱 {{ $report->user->phone }}</p>
                        @endif
                    @endif
                </div>
            </div>
            
            <!-- Category & Location -->
            <div class="grid grid-cols-1 md: grid-cols-3 gap-4 pb-4 border-b">
                <div class="flex items-center">
                    <span class="text-3xl mr-3">{{ $report->category->icon }}</span>
                    <div>
                        <p class="text-xs text-gray-500">Kategori</p>
                        <p class="font-semibold text-gray-900">{{ $report->category->name }}</p>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17. 657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <div>
                        <p class="text-xs text-gray-500">Lokasi</p>
                        <p class="font-semibold text-gray-900">{{ $report->full_location }}</p>
                    </div>
                </div>
                
                @if($report->incident_date)
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <div>
                        <p class="text-xs text-gray-500">Tanggal Kejadian</p>
                        <p class="font-semibold text-gray-900">{{ $report->incident_date->format('d M Y') }}</p>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Description -->
            <div class="mt-4">
                <h3 class="text-lg font-bold text-gray-900 mb-3">Deskripsi Masalah</h3>
                <div class="prose prose-sm max-w-none text-gray-700 whitespace-pre-line">
                    {{ $report->description }}
                </div>
            </div>
            
            <!-- Resolution Notes -->
            @if($report->resolution_notes)
            <div class="mt-6 p-4 {{ $report->status === 'resolved' ? 'bg-green-50 border-l-4 border-green-500' : 'bg-red-50 border-l-4 border-red-500' }} rounded">
                <h3 class="text-lg font-bold {{ $report->status === 'resolved' ? 'text-green-900' : 'text-red-900' }} mb-2">
                    {{ $report->status === 'resolved' ? '✓ Penyelesaian' : '✗ Catatan Penolakan' }}
                </h3>
                <p class="{{ $report->status === 'resolved' ? 'text-green-700' : 'text-red-700' }}">
                    {{ $report->resolution_notes }}
                </p>
                @if($report->resolved_at)
                    <p class="text-sm {{ $report->status === 'resolved' ? 'text-green-600' : 'text-red-600' }} mt-2">
                        {{ $report->resolved_at->format('d M Y, H:i') }}
                    </p>
                @endif
            </div>
            @endif
        </div>
        
        <!-- Attachments -->
        @if($report->attachments->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Lampiran ({{ $report->attachments->count() }})</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($report->attachments as $attachment)
                <div class="relative group">
                    @if($attachment->isImage())
                        <a href="{{ $attachment->url }}" target="_blank" class="block">
                            <img src="{{ $attachment->url }}" alt="{{ $attachment->file_name }}" 
                                 class="w-full h-32 object-cover rounded-lg border-2 border-gray-200 hover:border-primary-500 transition">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 rounded-lg transition flex items-center justify-center">
                                <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                </svg>
                            </div>
                        </a>
                    @else
                        <a href="{{ $attachment->url }}" target="_blank" 
                           class="block w-full h-32 bg-gray-100 rounded-lg border-2 border-gray-200 hover:border-primary-500 transition flex flex-col items-center justify-center p-2">
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
        
        <!-- Comments -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">
                Komentar & Tanggapan ({{ $report->comments->count() }})
            </h3>
            
            @if($report->comments->count() > 0)
            <div class="space-y-4 mb-6">
                @foreach($report->comments as $comment)
                <div class="flex space-x-3 {{ $comment->is_official ? 'bg-blue-50 -mx-6 px-6 py-4 rounded' : '' }}">
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
                            @if($comment->is_internal)
                                <span class="badge badge-gray text-xs">Internal</span>
                            @endif
                            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-700">{{ $comment->comment }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            
            <!-- Add Official Comment Form -->
            <form method="POST" action="{{ route('admin.reports.comment', $report->id) }}" class="border-t pt-4">
                @csrf
                <label class="block text-sm font-medium text-gray-700 mb-2">Tambah Tanggapan Official</label>
                <textarea name="comment" rows="3" required
                          class="input-field mb-3" 
                          placeholder="Tulis tanggapan atau update untuk mahasiswa..."></textarea>
                
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_internal" value="1" class="rounded mr-2">
                        <span class="text-sm text-gray-700">Internal only (tidak terlihat mahasiswa)</span>
                    </label>
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Kirim Tanggapan
                    </button>
                </div>
            </form>
        </div>
        
    </div>
    
    <!-- Sidebar Actions -->
    <div class="space-y-6">
        
        <!-- Status Management -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Kelola Status</h3>
            
            <form method="POST" action="{{ route('admin.reports.status', $report->id) }}">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ubah Status</label>
                        <select name="status" required class="input-field">
                            <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="in_review" {{ $report->status == 'in_review' ? 'selected' : '' }}>Sedang Ditinjau</option>
                            <option value="in_progress" {{ $report->status == 'in_progress' ?  'selected' : '' }}>Sedang Diproses</option>
                            <option value="resolved" {{ $report->status == 'resolved' ? 'selected' : '' }}>Selesai</option>
                            <option value="rejected" {{ $report->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan *</label>
                        <textarea name="notes" rows="3" required class="input-field" 
                                  placeholder="Catatan perubahan status..."></textarea>
                    </div>
                    
                    <div id="resolutionField" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Penyelesaian</label>
                        <textarea name="resolution_notes" rows="3" class="input-field" 
                                  placeholder="Jelaskan bagaimana masalah diselesaikan..."></textarea>
                    </div>
                    
                    <button type="submit" class="w-full btn-primary">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Assignment -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Tugaskan Laporan</h3>
            
            @if($report->assigned_to)
                <div class="mb-4 p-3 bg-blue-50 rounded">
                    <p class="text-sm text-gray-600 mb-1">Saat ini ditangani oleh:</p>
                    <p class="font-semibold text-gray-900">{{ $report->assignedTo->name }}</p>
                    <p class="text-xs text-gray-500">{{ $report->assigned_at->diffForHumans() }}</p>
                </div>
            @endif
            
            <form method="POST" action="{{ route('admin.reports.assign', $report->id) }}">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Admin</label>
                        <select name="assigned_to" required class="input-field">
                            <option value="">Pilih Admin</option>
                            @foreach($admins as $admin)
                                <option value="{{ $admin->id }}" {{ $report->assigned_to == $admin->id ? 'selected' : '' }}>
                                    {{ $admin->name }} ({{ $admin->role }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                        <textarea name="notes" rows="2" class="input-field" 
                                  placeholder="Catatan untuk admin (optional)"></textarea>
                    </div>
                    
                    <button type="submit" class="w-full btn-primary">
                        {{ $report->assigned_to ? 'Reassign' : 'Assign' }} Laporan
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Timeline -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Timeline</h3>
            
            <div class="relative">
                @foreach($report->statusHistory as $status)
                <div class="flex pb-6 {{ $loop->last ? '' : 'border-l-2 border-gray-200 ml-3' }}">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center 
                                {{ $status->new_status === 'resolved' ? 'bg-green-500' : 
                                   ($status->new_status === 'rejected' ? 'bg-red-500' : 'bg-blue-500') }} 
                                text-white z-10 -ml-3">
                        <span class="text-xs">{{ $status->icon }}</span>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-semibold text-sm text-gray-900">{{ $status->status_label }}</span>
                            <span class="text-xs text-gray-500">{{ $status->created_at->format('d/m H:i') }}</span>
                        </div>
                        @if($status->notes)
                            <p class="text-xs text-gray-600 mb-1">{{ $status->notes }}</p>
                        @endif
                        <p class="text-xs text-gray-500">oleh {{ $status->createdBy->name }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Report Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Referensi:</span>
                    <span class="font-mono font-semibold">{{ $report->reference_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Dibuat:</span>
                    <span class="font-semibold">{{ $report->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Update:</span>
                    <span class="font-semibold">{{ $report->updated_at->format('d M Y, H: i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Durasi:</span>
                    <span class="font-semibold">{{ $report->days_open }} hari</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Views:</span>
                    <span class="font-semibold">{{ $report->views_count }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Visibilitas:</span>
                    <span class="font-semibold capitalize">{{ $report->visibility }}</span>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="space-y-2">
                <button onclick="window.print()" class="w-full btn-outline text-sm">
                    🖨️ Print Laporan
                </button>
                <a href="mailto:{{ $report->user->email }}?subject=RE:  {{ $report->reference_number }}" 
                   class="block w-full btn-outline text-sm text-center">
                    📧 Email Pelapor
                </a>
                @if(! $report->is_anonymous && $report->user->phone)
                <a href="tel:{{ $report->user->phone }}" 
                   class="block w-full btn-outline text-sm text-center">
                    📱 Hubungi Pelapor
                </a>
                @endif
            </div>
        </div>
        
    </div>
</div>

@push('scripts')
<script>
// Show resolution field when status is resolved/rejected
document.querySelector('select[name="status"]').addEventListener('change', function() {
    const resolutionField = document.getElementById('resolutionField');
    if (this.value === 'resolved' || this.value === 'rejected') {
        resolutionField.style.display = 'block';
        resolutionField.querySelector('textarea').required = true;
    } else {
        resolutionField.style.display = 'none';
        resolutionField.querySelector('textarea').required = false;
    }
});

// Trigger on page load
document.querySelector('select[name="status"]').dispatchEvent(new Event('change'));
</script>
@endpush

@endsection