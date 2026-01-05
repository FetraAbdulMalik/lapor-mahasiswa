@extends('layouts.admin', ['title' => 'Kelola Kategori'])

@section('content')

<!-- Header -->
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Kelola Kategori Laporan</h2>
        <p class="text-gray-600">Kelola kategori laporan mahasiswa</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn-primary">
        ➕ Tambah Kategori
    </a>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-sm text-gray-600 mb-1">Total Kategori</p>
        <p class="text-3xl font-bold text-gray-900">{{ $categories->total() }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-sm text-gray-600 mb-1">Total Laporan</p>
        <p class="text-3xl font-bold text-gray-900">{{ $categories->sum('reports_count') }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-sm text-gray-600 mb-1">Kategori Aktif</p>
        <p class="text-3xl font-bold text-gray-900">{{ $categories->where('is_active', true)->count() }}</p>
    </div>
</div>

<!-- Categories Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Kategori</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Kode</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Total Laporan</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
                <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($categories as $category)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-lg" 
                             style="background-color: {{ $category->color ?? '#e5e7eb' }}; color: white;">
                            {{ $category->icon ?? '📋' }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $category->name }}</p>
                            <p class="text-sm text-gray-500">{{ $category->description }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        {{ $category->code }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.categories.show', $category->id) }}" 
                       class="text-navy-800 hover:text-navy-700 font-semibold">
                        {{ $category->reports_count }}
                    </a>
                </td>
                <td class="px-6 py-4">
                    @if($category->is_active)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            Nonaktif
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.categories.show', $category->id) }}" 
                           class="text-navy-800 hover:text-navy-700 text-sm font-medium">
                            Lihat
                        </a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('admin.categories.edit', $category->id) }}" 
                           class="text-gray-600 hover:text-gray-900 text-sm">
                            Edit
                        </a>
                        <span class="text-gray-300">|</span>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" 
                              class="inline"
                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <p class="text-gray-500">Belum ada kategori</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    @if($categories->hasPages())
    <div class="px-6 py-4 border-t bg-gray-50">
        {{ $categories->links() }}
    </div>
    @endif
</div>

@endsection
