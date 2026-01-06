@extends('layouts.admin', ['title' => 'Kelola Laporan'])

@section('content')

<!-- Header -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Kelola Semua Laporan</h2>
    <p class="text-gray-600">Pantau dan kelola semua laporan dari mahasiswa</p>
</div>

<!-- Filters & Actions -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <form method="GET" action="{{ route('admin.reports.index') }}" class="space-y-4">
        
        <!-- Search & Filters Grid -->
        <div class="grid grid-cols-1 md: grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text" name="search" placeholder="Ref/Judul/Pelapor..." 
                       value="{{ request('search') }}"
                       class="input-field text-sm">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="input-field text-sm">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="in_review" {{ request('status') == 'in_review' ? 'selected' : '' }}>Ditinjau</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Diproses</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Selesai</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' :  '' }}>Ditolak</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category" class="input-field text-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                <select name="priority" class="input-field text-sm">
                    <option value="">Semua</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                    <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Mendesak</option>
                </select>
            </div>
            
            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 btn-primary text-sm flex items-center justify-center space-x-2 group hover:shadow-lg transition-all duration-300">
                    <svg class="w-4 h-4 icon-animated" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    <span>Filter</span>
                </button>
                <a href="{{ route('admin.reports.index') }}" class="btn-secondary text-sm flex items-center justify-center space-x-2 group hover:shadow-lg transition-all duration-300">
                    <svg class="w-4 h-4 icon-animated" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span>Reset</span>
                </a>
            </div>
        </div>
        
        <!-- Date Range -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="input-field text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="input-field text-sm">
            </div>
            <div class="flex items-end space-x-2">
                <a href="{{ route('admin.reports.export.excel', request()->all()) }}" class="flex-1 btn-outline text-sm text-center flex items-center justify-center space-x-2 group hover:shadow-lg transition-all duration-300">
                    <svg class="w-4 h-4 icon-animated" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>📊 Export Excel</span>
                </a>
                <a href="{{ route('admin.reports.export.pdf', request()->all()) }}" class="flex-1 btn-outline text-sm text-center flex items-center justify-center space-x-2 group hover:shadow-lg transition-all duration-300">
                    <svg class="w-4 h-4 icon-animated" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>📄 Export PDF</span>
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Results Summary -->
<div class="bg-white rounded-lg shadow-md p-4 mb-6 flex items-center justify-between">
    <div class="text-sm text-gray-600">
        Menampilkan <strong>{{ $reports->count() }}</strong> dari <strong>{{ $reports->total() }}</strong> laporan
    </div>
    <div class="text-sm text-gray-600">
        Halaman {{ $reports->currentPage() }} dari {{ $reports->lastPage() }}
    </div>
</div>

<!-- Reports Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr class="text-left text-xs text-gray-600 uppercase">
                    <th class="px-4 py-3 font-semibold">
                        <input type="checkbox" id="selectAll" class="rounded">
                    </th>
                    <th class="px-4 py-3 font-semibold">Ref</th>
                    <th class="px-4 py-3 font-semibold">Laporan</th>
                    <th class="px-4 py-3 font-semibold">Pelapor</th>
                    <th class="px-4 py-3 font-semibold">Lokasi</th>
                    <th class="px-4 py-3 font-semibold">Status</th>
                    <th class="px-4 py-3 font-semibold">Prioritas</th>
                    <th class="px-4 py-3 font-semibold">Ditugaskan</th>
                    <th class="px-4 py-3 font-semibold">Waktu</th>
                    <th class="px-4 py-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($reports as $report)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-4">
                        <input type="checkbox" name="report_ids[]" value="{{ $report->id }}" class="rounded">
                    </td>
                    <td class="px-4 py-4">
                        <span class="font-mono text-xs">{{ $report->reference_number }}</span>
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex items-center">
                            <span class="text-xl mr-2">{{ $report->category->icon }}</span>
                            <div>
                                <p class="font-semibold text-gray-900">{{ Str::limit($report->title, 35) }}</p>
                                <p class="text-xs text-gray-500">{{ $report->category->name }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        @if($report->is_anonymous)
                            <span class="text-gray-500 italic text-xs">Anonim</span>
                        @else
                            <div>
                                <p class="font-medium text-gray-900">{{ $report->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $report->user->studentProfile->nim }}</p>
                            </div>
                        @endif
                    </td>
                    <td class="px-4 py-4">
                        <p class="text-xs text-gray-600">{{ Str::limit($report->building->name ??  'N/A', 20) }}</p>
                    </td>
                    <td class="px-4 py-4">
                        <span class="badge badge-{{ $report->status_badge_color }} text-xs">
                            {{ $report->status_label }}
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        <span class="badge badge-{{ $report->priority_badge_color }} text-xs">
                            {{ $report->priority_label }}
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        @if($report->assigned_to)
                            <p class="text-xs text-gray-600">{{ Str::limit($report->assignedTo->name, 15) }}</p>
                        @else
                            <span class="text-xs text-gray-400 italic">Belum</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-xs text-gray-600">
                        {{ $report->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-4 py-4">
                        <a href="{{ route('admin.reports.show', $report->id) }}" 
                           class="text-navy-800 hover:text-navy-700 text-sm font-medium flex items-center space-x-1 group transition-all duration-300 hover:scale-105">
                            <svg class="w-4 h-4 icon-animated group-hover:icon-glow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Detail</span>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-4 py-12 text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-gray-600 mb-2">Tidak ada laporan ditemukan</p>
                        <a href="{{ route('admin.reports.index') }}" class="text-navy-800 text-sm">Reset Filter</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $reports->links() }}
</div>

<!-- Bulk Actions (Fixed Bottom Bar) -->
<div id="bulkActions" class="fixed bottom-0 left-0 right-0 bg-gray-900 text-white p-4 transform translate-y-full transition-transform duration-300 z-50" style="display: none;">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <div>
            <span id="selectedCount">0</span> laporan dipilih
        </div>
        <div class="flex items-center space-x-4">
            <button onclick="bulkAssign()" class="btn-primary text-sm flex items-center space-x-2 group hover:shadow-lg transition-all duration-300">
                <svg class="w-4 h-4 icon-animated" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                <span>Assign ke Admin</span>
            </button>
            <button onclick="bulkChangeStatus()" class="btn-secondary text-sm flex items-center space-x-2 group hover:shadow-lg transition-all duration-300">
                <svg class="w-4 h-4 icon-animated" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Ubah Status</span>
            </button>
            <button onclick="clearSelection()" class="text-white hover:text-gray-300 text-sm flex items-center space-x-2 group">
                <svg class="w-4 h-4 icon-animated" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span>Batal</span>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Checkbox selection
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document. querySelectorAll('input[name="report_ids[]"]');
    checkboxes.forEach(cb => cb.checked = this.checked);
    updateBulkActions();
});

document.querySelectorAll('input[name="report_ids[]"]').forEach(checkbox => {
    checkbox.addEventListener('change', updateBulkActions);
});

function updateBulkActions() {
    const selected = document.querySelectorAll('input[name="report_ids[]"]:checked').length;
    const bulkBar = document.getElementById('bulkActions');
    
    if (selected > 0) {
        bulkBar.style.display = 'block';
        setTimeout(() => bulkBar.style.transform = 'translateY(0)', 10);
        document.getElementById('selectedCount').textContent = selected;
    } else {
        bulkBar.style. transform = 'translateY(100%)';
        setTimeout(() => bulkBar.style.display = 'none', 300);
    }
}

function clearSelection() {
    document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
    updateBulkActions();
}

function bulkAssign() {
    alert('Fitur bulk assign akan segera tersedia! ');
}

function bulkChangeStatus() {
    alert('Fitur bulk change status akan segera tersedia!');
}
</script>
@endpush

@endsection
