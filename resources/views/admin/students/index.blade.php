@extends('layouts.admin', ['title' => 'Kelola Mahasiswa'])

@section('content')

<!-- Header -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Kelola Data Mahasiswa</h2>
    <p class="text-gray-600">Pantau dan kelola data mahasiswa terdaftar</p>
</div>

<!-- Actions Bar -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
        <!-- Search & Filter -->
        <form method="GET" action="{{ route('admin.students.index') }}" class="flex-1 flex space-x-4">
            <input type="text" name="search" placeholder="Cari nama, NIM, atau email..." 
                   value="{{ request('search') }}"
                   class="input-field flex-1">
            
            <select name="department" class="input-field w-48" onchange="this.form.submit()">
                <option value="">Semua Jurusan</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
            
            <button type="submit" class="btn-primary flex items-center space-x-2 group hover:shadow-lg transition-all duration-300">
                <svg class="w-4 h-4 icon-animated" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                <span>Cari</span>
            </button>
            
            @if(request()->hasAny(['search', 'department']))
            <a href="{{ route('admin.students.index') }}" class="btn-secondary flex items-center space-x-2 group hover:shadow-lg transition-all duration-300">
                <svg class="w-4 h-4 icon-animated" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <span>Reset</span>
            </a>
            @endif
        </form>
        
        <!-- Action Buttons -->
        <div class="flex space-x-2">
            <button onclick="alert('Import feature coming soon!')" class="btn-outline text-sm flex items-center space-x-2 group hover:shadow-lg transition-all duration-300">
                <svg class="w-4 h-4 icon-animated" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Import</span>
            </button>
            <button onclick="alert('Export feature coming soon!')" class="btn-outline text-sm flex items-center space-x-2 group hover:shadow-lg transition-all duration-300">
                <svg class="w-4 h-4 icon-animated" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                <span>Export</span>
            </button>
            <a href="{{ route('admin.students.create') }}" class="btn-primary text-sm flex items-center space-x-2 group hover:shadow-lg transition-all duration-300">
                <svg class="w-4 h-4 icon-animated" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Mahasiswa</span>
            </a>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-sm text-gray-600 mb-1">Total Mahasiswa</p>
        <p class="text-3xl font-bold text-gray-900">{{ $students->total() }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-sm text-gray-600 mb-1">Aktif</p>
        <p class="text-3xl font-bold text-green-600">
            {{ $students->where('is_active', true)->count() }}
        </p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-sm text-gray-600 mb-1">Total Laporan</p>
        <p class="text-3xl font-bold text-blue-600">
            {{ $students->sum(fn($s) => $s->reports->count()) }}
        </p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-sm text-gray-600 mb-1">Avg Laporan/Mhs</p>
        <p class="text-3xl font-bold text-purple-600">
            {{ $students->count() > 0 ? number_format($students->sum(fn($s) => $s->reports->count()) / $students->count(), 1) : 0 }}
        </p>
    </div>
</div>

<!-- Students Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr class="text-left text-xs text-gray-600 uppercase">
                    <th class="px-6 py-3 font-semibold">NIM</th>
                    <th class="px-6 py-3 font-semibold">Nama</th>
                    <th class="px-6 py-3 font-semibold">Email</th>
                    <th class="px-6 py-3 font-semibold">Jurusan</th>
                    <th class="px-6 py-3 font-semibold">Semester</th>
                    <th class="px-6 py-3 font-semibold">Total Laporan</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($students as $student)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <span class="font-mono">{{ $student->studentProfile->nim }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <img src="{{ $student->avatar }}" alt="{{ $student->name }}" 
                                 class="w-10 h-10 rounded-full mr-3">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $student->name }}</p>
                                <p class="text-xs text-gray-500">Angkatan {{ $student->studentProfile->year_of_entry }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $student->email }}
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $student->studentProfile->department->name }}</p>
                        <p class="text-xs text-gray-500">{{ $student->studentProfile->faculty->code }}</p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="badge badge-blue">
                            Semester {{ $student->studentProfile->semester }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-lg font-bold text-gray-900">{{ $student->reports->count() }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($student->is_active)
                            <span class="badge badge-green">Aktif</span>
                        @else
                            <span class="badge badge-red">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.students.show', $student->id) }}" 
                               class="text-navy-800 hover:text-navy-700 text-sm font-medium flex items-center space-x-1 group transition-all duration-300 hover:scale-105">
                                <svg class="w-4 h-4 icon-animated" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Detail</span>
                            </a>
                            <span class="text-gray-300">|</span>
                            <a href="{{ route('admin.students.edit', $student->id) }}" 
                               class="text-gray-600 hover:text-gray-900 text-sm flex items-center space-x-1 group transition-all duration-300 hover:scale-105">
                                <svg class="w-4 h-4 icon-animated" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span>Edit</span>
                            </a>
                            <span class="text-gray-300">|</span>
                            <form method="POST" action="{{ route('admin.students.destroy', $student->id) }}" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus mahasiswa ini? Tindakan ini tidak dapat dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm flex items-center space-x-1 group transition-all duration-300 hover:scale-105">
                                    <svg class="w-4 h-4 icon-animated" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4. 354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <p class="text-gray-600 mb-2">Tidak ada mahasiswa ditemukan</p>
                        <a href="{{ route('admin.students. index') }}" class="text-navy-800 text-sm">Reset Filter</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $students->links() }}
</div>

@endsection
