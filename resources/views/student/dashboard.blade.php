@extends('layouts.app', ['title' => 'Dashboard Mahasiswa'])

@section('content')
<!-- Welcome Card -->
<div class="bg-gradient-to-r from-navy-900 to-navy-800 text-white rounded-lg p-8 shadow-lg mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">Selamat datang, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-cyan-100">
                Mari sampaikan laporan atau aspirasi Anda untuk kemajuan bersama
            </p>
        </div>
        <svg class="w-24 h-24 text-cyan-400 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
        </svg>
    </div>
</div>

<!-- Statistics Cards with Scroll Animations -->


<!-- ============================================
     QUICK ACTIONS SECTION - Interactive Buttons with Click Animation
     ============================================
     Setiap button di section ini memiliki animasi click effect:
     - x-data="{ clicked: false }" = Alpine.js state untuk track click
     - @click event = trigger animasi ketika user klik
     - :class binding = conditional CSS class berdasarkan state
     
     ANIMASI SEQUENCE:
     1. User klik tombol
     2. clicked state → true
     3. CSS classes apply: scale-95 (tombol kecil) + shadow-2xl (shadow besar)
     4. Icon box scale-125 rotate-12 (icon membesar + rotate)
     5. setTimeout 400ms → clicked state kembali false (reset)
     6. CSS transition-all 300ms → smooth kembali ke ukuran normal
     
     Effect: Pressing button effect seperti iPhone - subtle tapi meaningful!
     ============================================ -->

<!-- Quick Actions -->
<div class="grid md:grid-cols-3 gap-6 mb-8">
    <!-- Tombol 1: Buat Laporan Baru (Primary Action) -->
    <a href="{{ route('student.reports.create') }}" 
       class="card-elevated p-6 hover:shadow-xl transition-all duration-300 cursor-pointer group"
       x-data="{ clicked: false }"
       @click="clicked = true; setTimeout(() => clicked = false, 400)"
       :class="clicked ? 'scale-95 shadow-2xl' : 'scale-100'">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center transition-transform duration-300 group-hover:scale-110"
                 :class="clicked ? 'scale-125 rotate-12 bg-cyan-200' : 'scale-100'">
                <svg class="w-6 h-6 text-cyan-600 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     :class="clicked ? 'scale-110' : 'scale-100'">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-navy-900">Buat Laporan Baru</h3>
                <p class="text-sm text-navy-600">Sampaikan keluhan atau aspirasi Anda</p>
            </div>
        </div>
    </a>

    <a href="{{ route('student.reports.index') }}" 
       class="card-elevated p-6 hover:shadow-xl transition-all duration-300 cursor-pointer group"
       x-data="{ clicked: false }"
       @click="clicked = true; setTimeout(() => clicked = false, 400)"
       :class="clicked ? 'scale-95 shadow-2xl' : 'scale-100'">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center transition-transform duration-300 group-hover:scale-110"
                 :class="clicked ? 'scale-125 rotate-12 bg-cyan-200' : 'scale-100'">
                <svg class="w-6 h-6 text-cyan-600 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     :class="clicked ? 'scale-110' : 'scale-100'">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-navy-900">Lihat Laporan Saya</h3>
                <p class="text-sm text-navy-600">Pantau status laporan yang telah dibuat</p>
            </div>
        </div>
    </a>

    <a href="{{ route('student.profile.index') }}" 
       class="card-elevated p-6 hover:shadow-xl transition-all duration-300 cursor-pointer group"
       x-data="{ clicked: false }"
       @click="clicked = true; setTimeout(() => clicked = false, 400)"
       :class="clicked ? 'scale-95 shadow-2xl' : 'scale-100'">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center transition-transform duration-300 group-hover:scale-110"
                 :class="clicked ? 'scale-125 rotate-12 bg-cyan-200' : 'scale-100'">
                <svg class="w-6 h-6 text-cyan-600 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     :class="clicked ? 'scale-110' : 'scale-100'">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-navy-900">Profil Saya</h3>
                <p class="text-sm text-navy-600">Kelola informasi profil Anda</p>
            </div>
        </div>
    </a>
</div>

<!-- Stats Row -->
<div class="grid md:grid-cols-4 gap-4 mb-8">
    <!-- Total Laporan -->
    <div class="card-base p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-navy-600 text-sm font-medium">Total Laporan</p>
                <p class="text-3xl font-bold text-navy-900">{{ Auth::user()->reports()->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Menunggu Verifikasi -->
    <div class="card-base p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-navy-600 text-sm font-medium">Menunggu Verifikasi</p>
                <p class="text-3xl font-bold text-navy-900">{{ Auth::user()->reports()->where('status', 'pending')->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Dalam Proses -->
    <div class="card-base p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-navy-600 text-sm font-medium">Dalam Proses</p>
                <p class="text-3xl font-bold text-navy-900">{{ Auth::user()->reports()->where('status', 'in_progress')->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Selesai -->
    <div class="card-base p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-navy-600 text-sm font-medium">Selesai</p>
                <p class="text-3xl font-bold text-navy-900">{{ Auth::user()->reports()->where('status', 'completed')->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Recent Reports -->
<div class="card-base overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-navy-200 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-navy-900">Laporan Terbaru Saya</h2>
        <a href="{{ route('student.reports.index') }}" class="text-cyan-600 hover:text-cyan-700 text-sm font-medium">
            Lihat Semua →
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-navy-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-navy-900">Judul</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-navy-900">Kategori</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-navy-900">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-navy-900">Tanggal</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-navy-900">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-navy-200">
                @forelse(Auth::user()->reports()->latest()->take(5)->get() as $report)
                    <tr class="hover:bg-navy-50 transition-colors">
                        <td class="px-6 py-4 text-navy-900 font-medium">{{ $report->title }}</td>
                        <td class="px-6 py-4">
                            <span class="badge-primary px-3 py-1 rounded-full text-xs">
                                {{ $report->category->name ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @switch($report->status)
                                @case('pending')
                                    <span class="badge-primary bg-yellow-50 text-yellow-700 border border-yellow-200 px-3 py-1 rounded text-xs font-medium">
                                        Menunggu Verifikasi
                                    </span>
                                    @break
                                @case('in_progress')
                                    <span class="badge-primary bg-cyan-50 text-cyan-700 border border-cyan-200 px-3 py-1 rounded text-xs font-medium">
                                        Dalam Proses
                                    </span>
                                    @break
                                @case('completed')
                                    <span class="badge-primary bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded text-xs font-medium">
                                        Selesai
                                    </span>
                                    @break
                            @endswitch
                        </td>
                        <td class="px-6 py-4 text-navy-600 text-sm">
                            {{ $report->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('student.reports.show', $report) }}" class="text-cyan-600 hover:text-cyan-700 font-medium text-sm">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-navy-600">
                            <p class="mb-4">Anda belum membuat laporan apapun</p>
                            <a href="{{ route('student.reports.create') }}" class="text-cyan-600 hover:text-cyan-700 font-medium">
                                Buat Laporan Pertama Anda →
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Info Cards -->
<div class="grid md:grid-cols-2 gap-6">
    <!-- Proses Info -->
    <div class="card-base p-6">
        <h3 class="text-lg font-semibold text-navy-900 mb-4 flex items-center space-x-2">
            <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Proses Penanganan</span>
        </h3>
        <div class="space-y-3">
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 bg-cyan-500 text-white rounded-full flex items-center justify-center flex-shrink-0 font-semibold text-sm">1</div>
                <div>
                    <p class="font-medium text-navy-900">Verifikasi</p>
                    <p class="text-sm text-navy-600">3 hari kerja</p>
                </div>
            </div>
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 bg-cyan-500 text-white rounded-full flex items-center justify-center flex-shrink-0 font-semibold text-sm">2</div>
                <div>
                    <p class="font-medium text-navy-900">Tindak Lanjut</p>
                    <p class="text-sm text-navy-600">5 hari kerja</p>
                </div>
            </div>
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 bg-cyan-500 text-white rounded-full flex items-center justify-center flex-shrink-0 font-semibold text-sm">3</div>
                <div>
                    <p class="font-medium text-navy-900">Penyelesaian</p>
                    <p class="text-sm text-navy-600">Sampai tuntas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tips & Trik -->
    <div class="card-base p-6">
        <h3 class="text-lg font-semibold text-navy-900 mb-4 flex items-center space-x-2">
            <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
            <span>Tips Membuat Laporan</span>
        </h3>
        <ul class="space-y-2 text-sm text-navy-600">
            <li class="flex items-start space-x-2">
                <svg class="w-4 h-4 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span>Jelaskan dengan detail dan kronologi kejadian</span>
            </li>
            <li class="flex items-start space-x-2">
                <svg class="w-4 h-4 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span>Sertakan bukti pendukung jika tersedia</span>
            </li>
            <li class="flex items-start space-x-2">
                <svg class="w-4 h-4 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span>Gunakan bahasa yang sopan dan profesional</span>
            </li>
            <li class="flex items-start space-x-2">
                <svg class="w-4 h-4 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span>Cantumkan lokasi dan waktu kejadian dengan tepat</span>
            </li>
        </ul>
    </div>
</div>
@endsection
