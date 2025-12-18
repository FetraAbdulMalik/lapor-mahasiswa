@extends('layouts.admin', ['title' => 'Analytics'])

@section('content')

<!-- Header -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Analytics & Laporan</h2>
    <p class="text-gray-600">Ringkasan dan analisis data laporan</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 text-sm">Total Laporan</p>
        <p class="text-3xl font-bold text-primary-600 mt-2">{{ $total_reports }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 text-sm">Menunggu</p>
        <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $pending_reports }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 text-sm">Diproses</p>
        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $in_progress_reports }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 text-sm">Selesai</p>
        <p class="text-3xl font-bold text-green-600 mt-2">{{ $completed_reports }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 text-sm">Ditolak</p>
        <p class="text-3xl font-bold text-red-600 mt-2">{{ $rejected_reports }}</p>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Status Distribution -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Distribusi Status</h3>
        <div class="space-y-4">
            @php
                $statuses = [
                    'pending' => ['label' => 'Menunggu', 'color' => 'bg-yellow-200', 'count' => $pending_reports],
                    'in_progress' => ['label' => 'Diproses', 'color' => 'bg-blue-200', 'count' => $in_progress_reports],
                    'completed' => ['label' => 'Selesai', 'color' => 'bg-green-200', 'count' => $completed_reports],
                    'rejected' => ['label' => 'Ditolak', 'color' => 'bg-red-200', 'count' => $rejected_reports],
                ];
                $max_count = max($pending_reports, $in_progress_reports, $completed_reports, $rejected_reports);
                $max_count = max($max_count, 1);
            @endphp

            @foreach($statuses as $status => $data)
                @php
                    $percentage = $total_reports > 0 ? ($data['count'] / $total_reports * 100) : 0;
                    $bar_width = $max_count > 0 ? ($data['count'] / $max_count * 100) : 0;
                @endphp
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">{{ $data['label'] }}</span>
                        <span class="text-sm font-bold text-gray-900">{{ $data['count'] }} ({{ number_format($percentage, 1) }}%)</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                        <div class="{{ $data['color'] }} h-full rounded-full transition-all" style="width: {{ $bar_width }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Category Breakdown -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Top Kategori</h3>
        <div class="space-y-3">
            @forelse($top_categories as $category)
                <div class="flex items-center justify-between pb-3 border-b last:border-b-0 last:pb-0">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">{{ $category->icon }}</span>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $category->name }}</p>
                            <p class="text-xs text-gray-500">{{ $category->reports_count }} laporan</p>
                        </div>
                    </div>
                    <span class="text-lg font-bold text-primary-600">{{ $category->reports_count }}</span>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Belum ada data kategori</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Recent Reports -->
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-900">Laporan Terbaru</h3>
        <a href="{{ route('admin.reports.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
            Lihat Semua →
        </a>
    </div>

    @if($recent_reports->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Referensi</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Judul</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Kategori</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Pelapor</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Tanggal</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recent_reports as $report)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3 font-mono text-xs text-gray-600">{{ $report->reference_number }}</td>
                            <td class="px-6 py-3">
                                <div class="font-medium text-gray-900">{{ Str::limit($report->title, 25) }}</div>
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-1">
                                    <span class="text-lg">{{ $report->category->icon }}</span>
                                    <span class="text-gray-600">{{ $report->category->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-gray-600">{{ $report->user?->name ?? '-' }}</td>
                            <td class="px-6 py-3">
                                @php
                                    $statusValue = $report->status ?? 'unknown';
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    @if($statusValue === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($statusValue === 'in_progress') bg-blue-100 text-blue-800
                                    @elseif($statusValue === 'completed') bg-green-100 text-green-800
                                    @elseif($statusValue === 'rejected') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $statusValue)) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-gray-600 text-xs">{{ $report->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-3">
                                <a href="{{ route('admin.reports.show', $report->id) }}"
                                   class="text-primary-600 hover:text-primary-700 font-medium text-sm">
                                    Lihat
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8 text-gray-500">
            <p>Belum ada laporan</p>
        </div>
    @endif
</div>

@endsection
