@extends('layouts.guest')

@section('title', 'Statistik Laporan')

@section('content')
<div class="bg-gradient-to-r from-navy-800 to-navy-700 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-2">Statistik Laporan</h1>
        <p class="text-xl text-blue-100">Data dan analisis laporan mahasiswa</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Reports -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Total Laporan</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalReports }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Pending Reports -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Menunggu</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $pendingReports }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-2xl text-yellow-600"></i>
                </div>
            </div>
        </div>

        <!-- In Progress Reports -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Diproses</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $inProgressReports }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-spinner text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Resolved Reports -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Selesai</p>
                    <p class="text-3xl font-bold text-green-600">{{ $resolvedReports }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-2xl text-green-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Reports by Category -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Laporan per Kategori</h2>
            <div class="space-y-4">
                @foreach($reportsByCategory as $category)
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">{{ $category->name }}</span>
                            <span class="text-sm font-bold text-gray-900">{{ $category->reports_count }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-navy-800 h-2 rounded-full transition-all duration-300" 
                                 style="width: {{ $reportsByCategory->max('reports_count') > 0 ? ($category->reports_count / $reportsByCategory->max('reports_count')) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Average Response Time -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Waktu Respons</h2>
            <div class="text-center py-8">
                <div class="inline-flex items-center justify-center w-32 h-32 bg-blue-100 rounded-full mb-4">
                    <div>
                        <div class="text-4xl font-bold text-navy-800">
                            {{ $avgResponseTime ? number_format($avgResponseTime, 1) : '0' }}
                        </div>
                        <div class="text-sm text-navy-800 font-medium">Hari</div>
                    </div>
                </div>
                <p class="text-gray-600">Rata-rata waktu penyelesaian laporan</p>
            </div>

            <!-- Status Distribution -->
            <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-200">
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-600">
                        {{ $totalReports > 0 ? number_format(($pendingReports / $totalReports) * 100, 1) : 0 }}%
                    </div>
                    <div class="text-xs text-gray-600 mt-1">Menunggu</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">
                        {{ $totalReports > 0 ? number_format(($inProgressReports / $totalReports) * 100, 1) : 0 }}%
                    </div>
                    <div class="text-xs text-gray-600 mt-1">Diproses</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">
                        {{ $totalReports > 0 ? number_format(($resolvedReports / $totalReports) * 100, 1) : 0 }}%
                    </div>
                    <div class="text-xs text-gray-600 mt-1">Selesai</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reports Trend (Last 6 Months) -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Tren Laporan (6 Bulan Terakhir)</h2>
        <div class="overflow-x-auto">
            @if($reportsByMonth->count() > 0)
                <div class="flex items-end justify-around h-64 px-4">
                    @foreach($reportsByMonth as $month)
                        @php
                            $monthNames = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
                            $maxCount = $reportsByMonth->max('total');
                            $height = $maxCount > 0 ? ($month->total / $maxCount) * 100 : 0;
                        @endphp
                        <div class="flex flex-col items-center">
                            <div class="text-sm font-bold text-gray-900 mb-2">{{ $month->total }}</div>
                            <div class="w-16 bg-navy-800 rounded-t-lg transition-all duration-300 hover:bg-navy-700" 
                                 style="height: {{ max($height, 5) }}%">
                            </div>
                            <div class="text-xs text-gray-600 mt-2">
                                {{ $monthNames[$month->month] ?? '' }}<br>{{ $month->year }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 text-gray-500">
                    <i class="fas fa-chart-line text-4xl mb-4"></i>
                    <p>Belum ada data tren laporan</p>
                </div>
            @endif
        </div>
    </div>

    <!-- CTA Section -->
    <div class="mt-12 bg-gradient-to-r from-navy-800 to-navy-700 rounded-lg shadow-xl p-8 text-center">
        <h2 class="text-2xl font-bold text-white mb-4">Punya Masalah atau Keluhan?</h2>
        <p class="text-blue-100 mb-6">Laporkan sekarang dan bantu kami meningkatkan kualitas kampus</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white text-navy-800 font-semibold rounded-lg hover:bg-gray-100 transition duration-200">
                <i class="fas fa-sign-in-alt mr-2"></i>Login untuk Melapor
            </a>
            <a href="{{ route('reports.public') }}" class="inline-flex items-center justify-center px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg hover:bg-primary-400 transition duration-200">
                <i class="fas fa-list mr-2"></i>Lihat Laporan Publik
            </a>
        </div>
    </div>
</div>
@endsection
