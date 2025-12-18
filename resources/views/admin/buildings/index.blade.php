@extends('layouts.admin', ['title' => 'Gedung'])

@section('content')

<!-- Header -->
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Manajemen Gedung</h2>
        <p class="text-gray-600">Kelola data gedung dan lokasi di kampus</p>
    </div>
    <a href="{{ route('admin.buildings.create') }}"
       class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
        + Tambah Gedung
    </a>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 text-sm">Total Gedung</p>
        <p class="text-3xl font-bold text-primary-600 mt-2">{{ $total_buildings }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 text-sm">Total Fasilitas</p>
        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $total_facilities }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 text-sm">Rata-rata Fasilitas</p>
        <p class="text-3xl font-bold text-green-600 mt-2">{{ $avg_facilities }}</p>
    </div>
</div>

<!-- Buildings Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left font-medium text-gray-700">Nama Gedung</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-700">Kode</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-700">Lokasi</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-700">Fasilitas</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-700">Laporan</th>
                    <th class="px-6 py-3 text-left font-medium text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($buildings as $building)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3">
                            <div class="font-medium text-gray-900">{{ $building->name }}</div>
                        </td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium">{{ $building->code }}</span>
                        </td>
                        <td class="px-6 py-3 text-gray-600 text-sm">{{ $building->location ?? '-' }}</td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                                {{ $building->facilities_count ?? 0 }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-gray-600 text-sm">
                            {{ $building->reports_count ?? 0 }}
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.buildings.show', $building->id) }}"
                                   class="text-primary-600 hover:text-primary-700 font-medium text-sm">
                                    Lihat
                                </a>
                                <a href="{{ route('admin.buildings.edit', $building->id) }}"
                                   class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.buildings.destroy', $building->id) }}" class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus gedung ini?');">
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
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <p>Belum ada data gedung</p>
                            <a href="{{ route('admin.buildings.create') }}" class="text-primary-600 hover:text-primary-700 text-sm mt-2 inline-block">
                                Buat yang pertama
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($buildings->hasPages())
        <div class="px-6 py-4 border-t bg-gray-50">
            {{ $buildings->links() }}
        </div>
    @endif
</div>

@endsection
