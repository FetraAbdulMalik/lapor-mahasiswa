@extends('layouts.admin', ['title' => 'Dashboard Admin'])

@section('content')

<!-- Welcome Section -->
<div class="mb-3">
    <h2 class="text-xl font-bold text-gray-900 mb-1">
        Dashboard Admin
    </h2>
    <p class="text-gray-600 text-sm">
        Selamat datang, {{ auth()->user()->name }}! Berikut ringkasan sistem hari ini.
    </p>
</div>

<!-- KPI Cards with Animations -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-4 btn-group">
    <!-- Total Reports -->
    <div class="btn-item bg-white rounded-lg shadow-md p-4 hover:shadow-xl hover:scale-105 transition-all duration-300 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-600 mb-1">Total Laporan</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalReports }}</p>
                <p class="text-xs text-gray-500 mt-1">Semua waktu</p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center transition-all duration-300 icon-animated group-hover:shadow-lg"
                 style="animation: fadeIn 0.5s ease-out forwards; animation-delay: 0s;">
                <svg class="w-7 h-7 text-blue-600 icon-glow transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Pending Reports -->
    <div class="btn-item bg-white rounded-lg shadow-md p-4 hover:shadow-xl hover:scale-105 transition-all duration-300 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-600 mb-1">Perlu Ditangani</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $pendingReports }}</p>
                <p class="text-xs text-gray-500 mt-1">Status: Menunggu</p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-lg flex items-center justify-center transition-all duration-300 icon-animated group-hover:shadow-lg"
                 style="animation: fadeIn 0.5s ease-out forwards; animation-delay: 0.1s;">
                <svg class="w-7 h-7 text-yellow-600 icon-glow transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- In Progress -->
    <div class="btn-item bg-white rounded-lg shadow-md p-4 hover:shadow-xl hover:scale-105 transition-all duration-300 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-600 mb-1">Dalam Proses</p>
                <p class="text-2xl font-bold text-purple-600">{{ $inProgressReports }}</p>
                <p class="text-xs text-gray-500 mt-1">Sedang ditangani</p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-purple-100 to-purple-200 rounded-lg flex items-center justify-center transition-all duration-300 icon-animated group-hover:shadow-lg"
                 style="animation: fadeIn 0.5s ease-out forwards; animation-delay: 0.2s;">
                <svg class="w-7 h-7 text-purple-600 icon-glow transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Resolved -->
    <div class="btn-item bg-white rounded-lg shadow-md p-4 hover:shadow-xl hover:scale-105 transition-all duration-300 group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-600 mb-1">Selesai</p>
                <p class="text-2xl font-bold text-green-600">{{ $resolvedReports }}</p>
                <p class="text-xs text-gray-500 mt-1">Terselesaikan</p>
            </div>
            <div class="w-14 h-14 bg-gradient-to-br from-green-100 to-green-200 rounded-lg flex items-center justify-center transition-all duration-300 icon-animated group-hover:shadow-lg"
                 style="animation: fadeIn 0.5s ease-out forwards; animation-delay: 0.3s;">
                <svg class="w-7 h-7 text-green-600 icon-glow transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</div>

<!-- Secondary Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
    <div class="bg-white rounded-lg shadow-md p-3">
        <div class="flex items-center justify-between mb-2">
            <h3 class="font-semibold text-gray-900 text-sm">Total Mahasiswa</h3>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </div>
        <p class="text-lg font-bold text-gray-900">{{ $totalStudents }}</p>
        <p class="text-xs text-gray-600 mt-0.5">Pengguna aktif</p>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-3">
        <div class="flex items-center justify-between mb-2">
            <h3 class="font-semibold text-gray-900 text-sm">Avg Response Time</h3>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <p class="text-lg font-bold text-gray-900">{{ number_format($avgResponseTime ??  0, 1) }}</p>
        <p class="text-xs text-gray-600 mt-0.5">Hari rata-rata</p>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-3">
        <div class="flex items-center justify-between mb-2">
            <h3 class="font-semibold text-gray-900 text-sm">Success Rate</h3>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
            </svg>
        </div>
        <p class="text-lg font-bold text-gray-900">
            {{ $totalReports > 0 ? number_format(($resolvedReports / $totalReports) * 100, 1) : 0 }}%
        </p>
        <p class="text-xs text-gray-600 mt-0.5">Tingkat penyelesaian</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-3">
    
    <!-- Recent Reports -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-base font-bold text-gray-900">Laporan Terbaru</h3>
                <a href="{{ route('admin.reports.index') }}" class="text-sm text-navy-800 hover:text-navy-700 font-medium">
                    Lihat Semua →
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b">
                        <tr class="text-left text-xs text-gray-600">
                            <th class="pb-2 font-semibold">Ref</th>
                            <th class="pb-2 font-semibold">Laporan</th>
                            <th class="pb-2 font-semibold">Pelapor</th>
                            <th class="pb-2 font-semibold">Status</th>
                            <th class="pb-2 font-semibold">Waktu</th>
                            <th class="pb-2 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs">
                        @forelse($recentReports->take(10) as $report)
                        <tr class="border-b last:border-0 hover:bg-gray-50">
                            <td class="py-2">
                                <span class="font-mono text-xs">{{ $report->reference_number }}</span>
                            </td>
                            <td class="py-2">
                                <div class="flex items-center">
                                    <span class="mr-2">{{ $report->category->icon }}</span>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ Str::limit($report->title, 40) }}</p>
                                        <p class="text-xs text-gray-500">{{ $report->category->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2">
                                @if($report->is_anonymous)
                                    <span class="text-gray-500 italic">Anonim</span>
                                @else
                                    <div>
                                        <p class="font-medium">{{ $report->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $report->user->studentProfile->nim }}</p>
                                    </div>
                                @endif
                            </td>
                            <td class="py-2">
                                <span class="badge badge-{{ $report->status_badge_color }}">
                                    {{ $report->status_label }}
                                </span>
                            </td>
                            <td class="py-2 text-gray-600">
                                {{ $report->created_at->diffForHumans() }}
                            </td>
                            <td class="py-2">
                                <a href="{{ route('admin.reports.show', $report->id) }}" 
                                   class="text-navy-800 hover:text-navy-700">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-gray-500">
                                Belum ada laporan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Right Sidebar -->
    <div class="space-y-2">
        
        <!-- Reports by Category -->
        <div class="bg-white rounded-lg shadow-md p-3">
            <h3 class="text-sm font-bold text-gray-900 mb-2">Laporan per Kategori</h3>
            <div class="space-y-2">
                @foreach($reportsByCategory->take(3) as $category)
                <div class="flex items-center justify-between">
                    <div class="flex items-center flex-1">
                        <span class="text-lg mr-2">{{ $category->icon }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-900 truncate">{{ $category->name }}</p>
                            <div class="w-full bg-gray-200 rounded-full h-1 mt-0.5">
                                <div class="bg-navy-800 h-1 rounded-full" 
                                     style="width: {{ $reportsByCategory->max('reports_count') > 0 ? ($category->reports_count / $reportsByCategory->max('reports_count')) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="ml-2 text-sm font-bold text-gray-900">{{ $category->reports_count }}</span>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Reports by Status Chart -->
        <div class="bg-white rounded-lg shadow-md p-2">
            <h3 class="text-xs font-bold text-gray-900 mb-1">Status Overview</h3>
            <div style="height: 160px; position: relative;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md p-4">
            <h3 class="text-base font-bold text-gray-900 mb-2">Aksi Cepat</h3>
            <div class="space-y-1">
                <a href="{{ route('admin.reports.index', ['status' => 'pending']) }}" 
                   class="block w-full btn-primary text-center text-xs py-1.5">
                    Laporan Pending ({{ $pendingReports }})
                </a>
                <a href="{{ route('admin.reports.index') }}" 
                   class="block w-full btn-outline text-center text-xs py-1.5">
                    Semua Laporan
                </a>
                <a href="{{ route('admin.students.index') }}" 
                   class="block w-full btn-outline text-center text-xs py-1.5">
                    Kelola Mahasiswa
                </a>
            </div>
        </div>
        
    </div>
</div>

<!-- Trends Chart -->
<div class="mt-1">
    <div class="bg-white rounded-lg shadow-md p-2">
        <h3 class="text-xs font-bold text-gray-900 mb-1">Trend (7H)</h3>
        <div style="height: 200px; position: relative;">
            <canvas id="trendChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Status Pie Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusChart = new Chart(statusCtx, {
    type:  'doughnut',
    data: {
        labels: [
            @foreach($reportsByStatus as $status)
                '{{ ucfirst($status->status) }}',
            @endforeach
        ],
        datasets: [{
            data: [
                @foreach($reportsByStatus as $status)
                    {{ $status->total }},
                @endforeach
            ],
            backgroundColor: [
                '#FCD34D', // pending - yellow
                '#60A5FA', // in_review - blue
                '#A78BFA', // in_progress - purple
                '#34D399', // resolved - green
                '#F87171', // rejected - red
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    font: { size: 10 },
                    padding: 5
                }
            }
        }
    }
});

// Trend Line Chart
const trendCtx = document.getElementById('trendChart').getContext('2d');
const trendChart = new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: [
            @foreach($reportsTrend as $trend)
                '{{ \Carbon\Carbon::parse($trend->date)->format("d M") }}',
            @endforeach
        ],
        datasets: [{
            label: 'Jumlah Laporan',
            data: [
                @foreach($reportsTrend as $trend)
                    {{ $trend->total }},
                @endforeach
            ],
            borderColor:  '#3B82F6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.4,
            fill: true,
            pointRadius: 4,
            pointBackgroundColor: '#3B82F6',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1,
                    font: { size: 8 }
                }
            },
            x: {
                ticks: {
                    font: { size: 8 }
                }
            }
        }
    }
});
</script>
@endpush

@endsection
