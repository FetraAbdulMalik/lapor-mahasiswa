@extends('layouts.admin', ['title' => 'Gedung'])

@section('content')

<!-- Header -->
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Manajemen Gedung</h2>
        <p class="text-gray-600">Kelola data gedung dan lokasi di kampus</p>
    </div>
    <a href="{{ route('admin.buildings.create') }}"
       class="px-4 py-2 bg-navy-800 text-white rounded-lg hover:bg-navy-700 transition flex items-center space-x-2 group hover:shadow-lg duration-300">
        <svg class="w-5 h-5 icon-animated" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Tambah Gedung</span>
    </a>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 text-sm">Total Gedung</p>
        <p class="text-3xl font-bold text-navy-800 mt-2">{{ $total_buildings }}</p>
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
                                   class="text-navy-800 hover:text-navy-700 font-medium text-sm flex items-center space-x-1 group transition-all duration-300 hover:scale-105">
                                    <svg class="w-4 h-4 icon-animated" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span>Lihat</span>
                                </a>
                                <a href="{{ route('admin.buildings.edit', $building->id) }}"
                                   class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center space-x-1 group transition-all duration-300 hover:scale-105">
                                    <svg class="w-4 h-4 icon-animated" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    <span>Edit</span>
                                </a>
                                <form method="POST" action="{{ route('admin.buildings.destroy', $building->id) }}" class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus gedung ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 font-medium text-sm flex items-center space-x-1 group transition-all duration-300 hover:scale-105">
                                        <svg class="w-4 h-4 icon-animated" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <p>Belum ada data gedung</p>
                            <a href="{{ route('admin.buildings.create') }}" class="text-navy-800 hover:text-navy-700 text-sm mt-2 inline-block">
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
