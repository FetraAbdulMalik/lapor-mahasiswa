@extends('layouts.admin', ['title' => 'Fasilitas'])

@section('content')

<!-- Header -->
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Manajemen Fasilitas</h2>
        <p class="text-gray-600">Kelola data fasilitas di kampus</p>
    </div>
    <a href="{{ route('admin.facilities.create') }}"
       class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
        + Tambah Fasilitas
    </a>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 text-sm">Total Fasilitas</p>
        <p class="text-3xl font-bold text-primary-600 mt-2">{{ $total_facilities }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 text-sm">Fasilitas Aktif</p>
        <p class="text-3xl font-bold text-green-600 mt-2">{{ $active_facilities }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 text-sm">Tipe Fasilitas</p>
        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $facility_types }}</p>
    </div>
</div>

<!-- Facilities Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left font-medium text-gray-700">Nama Fasilitas</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-700">Gedung</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-700">Tipe</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-700">Lantai</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-700">Kapasitas</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-700">Status</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($facilities as $facility)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3">
                            <div class="font-medium text-gray-900">{{ $facility->name }}</div>
                            <div class="text-xs text-gray-500">{{ $facility->code }}</div>
                        </td>
                        <td class="px-6 py-3 text-gray-600">{{ $facility->building?->name ?? '-' }}</td>
                        <td class="px-6 py-3 text-gray-600">
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs">
                                {{ ucfirst(str_replace('_', ' ', $facility->type ?? 'N/A')) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-gray-600">{{ $facility->floor ?? '-' }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ $facility->capacity ?? '-' }}</td>
                        <td class="px-6 py-3">
                            @if($facility->is_active)
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-medium">Aktif</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-medium">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.facilities.edit', $facility->id) }}"
                                   class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.facilities.destroy', $facility->id) }}" class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus fasilitas ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 font-medium text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            <p>Belum ada data fasilitas</p>
                            <a href="{{ route('admin.facilities.create') }}" class="text-primary-600 hover:text-primary-700 text-sm mt-2 inline-block">
                                Buat yang pertama
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($facilities->hasPages())
        <div class="px-6 py-4 border-t bg-gray-50">
            {{ $facilities->links() }}
        </div>
    @endif
</div>

@endsection
