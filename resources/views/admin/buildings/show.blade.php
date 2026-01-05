@extends('layouts.admin', ['title' => $building->name])

@section('content')

<!-- Header with Back Button -->
<div class="mb-6 flex items-center justify-between">
    <div>
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.buildings.index') }}" class="text-navy-800 hover:text-navy-700 text-sm">
                ← Kembali
            </a>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">{{ $building->name }}</h2>
        <p class="text-gray-600 mt-1">{{ $building->description ?? 'Tidak ada deskripsi' }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.buildings.edit', $building->id) }}"
           class="btn-primary">
            Edit
        </a>
        <form method="POST" action="{{ route('admin.buildings.destroy', $building->id) }}" class="inline"
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus gedung ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-outline">
                Hapus
            </button>
        </form>
    </div>
</div>

<!-- Building Info Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 text-sm">Kode Gedung</p>
        <p class="text-2xl font-bold mt-2">{{ $building->code }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 text-sm">Lokasi</p>
        <p class="text-lg font-medium mt-2">{{ $building->location ?? '-' }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 text-sm">Jumlah Lantai</p>
        <p class="text-2xl font-bold mt-2">{{ $building->floors ?? '-' }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-600 text-sm">Total Fasilitas</p>
        <p class="text-2xl font-bold mt-2">{{ $building->facilities->count() }}</p>
    </div>
</div>

<!-- Facilities List -->
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-900">Fasilitas</h3>
        <a href="{{ route('admin.facilities.create', ['building_id' => $building->id]) }}"
           class="px-3 py-1 bg-navy-800 text-white text-sm rounded-lg hover:bg-navy-700 transition">
            + Tambah
        </a>
    </div>

    @if($building->facilities->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Nama Fasilitas</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Tipe</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Lokasi</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($building->facilities as $facility)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3 font-medium text-gray-900">{{ $facility->name }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $facility->type ?? '-' }}</td>
                            <td class="px-6 py-3 text-gray-600 text-sm">{{ $facility->location ?? '-' }}</td>
                            <td class="px-6 py-3">
                                @if($facility->is_active)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full font-medium">Aktif</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full font-medium">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.facilities.edit', $facility->id) }}"
                                       class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.facilities.destroy', $facility->id) }}" class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 font-medium text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8 text-gray-500">
            <p>Belum ada fasilitas untuk gedung ini</p>
            <a href="{{ route('admin.facilities.create', ['building_id' => $building->id]) }}"
               class="text-navy-800 hover:text-navy-700 text-sm mt-2 inline-block">
                Tambah fasilitas pertama
            </a>
        </div>
    @endif
</div>

@endsection
