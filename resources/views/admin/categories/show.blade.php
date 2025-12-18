@extends('layouts.admin', ['title' => $category->name])

@section('content')

<!-- Header with Back Button -->
<div class="mb-6 flex items-center justify-between">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.categories.index') }}" class="text-primary-600 hover:text-primary-700 text-sm">
                ← Kembali
            </a>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h2>
        <p class="text-gray-600 mt-1">{{ $category->description }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.categories.edit', $category->id) }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Edit
        </a>
        <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" class="inline"
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                Hapus
            </button>
        </form>
    </div>
</div>

<!-- Category Info Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm">Icon</p>
                <p class="text-2xl font-bold mt-2">{{ $category->icon }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 text-sm">Warna</p>
        <div class="mt-2 flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg border-2 border-gray-300" style="background-color: {{ $category->color }}"></div>
            <span class="font-mono text-sm">{{ $category->color }}</span>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 text-sm">Status</p>
        <div class="mt-2">
            @if($category->is_active)
                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">Aktif</span>
            @else
                <span class="px-3 py-1 bg-red-100 text-red-800 text-sm rounded-full">Tidak Aktif</span>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 text-sm">Total Laporan</p>
        <p class="text-2xl font-bold mt-2">{{ $category->reports->count() }}</p>
    </div>
</div>

<!-- Recent Reports -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Laporan Terbaru</h3>

    @if($category->reports->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Referensi</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Judul</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Pelapor</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Tanggal</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($category->reports as $report)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3 font-mono text-xs text-gray-600">{{ $report->reference_number }}</td>
                            <td class="px-6 py-3">
                                <div class="font-medium text-gray-900">{{ Str::limit($report->title, 30) }}</div>
                                <div class="text-xs text-gray-500">{{ $report->facility?->name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-3 text-gray-600">{{ $report->user?->name ?? '-' }}</td>
                            <td class="px-6 py-3">
                                @php
                                    $statusValue = $report->status ?? 'unknown';
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    @if($statusValue === 'open') bg-yellow-100 text-yellow-800
                                    @elseif($statusValue === 'in_progress') bg-blue-100 text-blue-800
                                    @elseif($statusValue === 'resolved') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($statusValue) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-gray-600 text-xs">{{ $report->created_at->format('d/m/Y') }}</td>
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
            <p>Belum ada laporan untuk kategori ini</p>
        </div>
    @endif
</div>

@endsection
