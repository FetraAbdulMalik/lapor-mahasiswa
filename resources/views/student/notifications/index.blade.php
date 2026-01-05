@extends('layouts.app', ['title' => 'Notifikasi'])

@section('content')
<!-- Header -->
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">🔔 Notifikasi</h1>
    <p class="text-gray-600 mt-2">Semua notifikasi terkait laporan Anda</p>
</div>

@if($notifications->isEmpty())
    <!-- Empty State -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
        <div class="text-5xl mb-4">🔕</div>
        <h3 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Notifikasi</h3>
        <p class="text-gray-500">Notifikasi terkait laporan Anda akan muncul di sini</p>
    </div>
@else
    <!-- Notifications List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="divide-y divide-gray-200">
            @foreach($notifications as $notification)
                <div class="p-6 hover:bg-gradient-to-r hover:from-slate-50 hover:to-slate-100 transition-colors {{ $notification->is_read ? 'opacity-75' : 'bg-slate-50/30' }}">
                    <div class="flex items-start gap-4">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            @if($notification->type === 'status_update')
                                <div class="h-12 w-12 rounded-full bg-slate-200 flex items-center justify-center text-xl">
                                    ℹ️
                                </div>
                            @elseif($notification->type === 'comment')
                                <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center text-xl">
                                    💬
                                </div>
                            @else
                                <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center text-xl">
                                    🔔
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-sm font-semibold text-gray-900">
                                        {{ $notification->title }}
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ $notification->message }}
                                    </p>
                                    
                                    @if($notification->report)
                                        <div class="mt-3">
                                            <a href="{{ route('student.reports.show', $notification->report_id) }}" 
                                               class="inline-flex items-center text-sm text-cyan-600 hover:text-cyan-700 font-semibold">
                                                <span>📋 Lihat Laporan #{{ $notification->report->report_number }}</span>
                                                <svg class="ml-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <!-- Badge -->
                                @if(!$notification->is_read)
                                    <span class="flex-shrink-0 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-200 text-slate-800">
                                        Baru
                                    </span>
                                @endif
                            </div>

                                <!-- Timestamp -->
                                <p class="mt-2 text-xs text-gray-500 notification-time" data-time="{{ $notification->created_at->toIso8601String() }}">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    @endif
</div>

<!-- Real-time Clock Update Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateNotificationTimes() {
        const timeElements = document.querySelectorAll('.notification-time');
        
        timeElements.forEach(element => {
            const isoTime = element.dataset.time;
            if (!isoTime) return;
            
            const createdDate = new Date(isoTime);
            const now = new Date();
            const diff = now - createdDate;
            
            // Convert to seconds, minutes, hours, days
            const seconds = Math.floor(diff / 1000);
            const minutes = Math.floor(seconds / 60);
            const hours = Math.floor(minutes / 60);
            const days = Math.floor(hours / 24);
            
            let timeText = '';
            
            if (seconds < 60) {
                timeText = 'baru saja';
            } else if (minutes < 60) {
                timeText = minutes === 1 ? '1 menit yang lalu' : minutes + ' menit yang lalu';
            } else if (hours < 24) {
                timeText = hours === 1 ? '1 jam yang lalu' : hours + ' jam yang lalu';
            } else if (days < 7) {
                timeText = days === 1 ? '1 hari yang lalu' : days + ' hari yang lalu';
            } else {
                timeText = createdDate.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
            }
            
            element.textContent = timeText;
        });
    }
    
    // Update immediately
    updateNotificationTimes();
    
    // Update every 1 second for real-time display
    setInterval(updateNotificationTimes, 1000);
});
</script>
@endsection
