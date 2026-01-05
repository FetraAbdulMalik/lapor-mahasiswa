@extends('layouts.guest', ['title' => 'Lapor Mahasiswa - Sampaikan Laporan Anda'])

@section('content')
<!-- Hero Section -->
<div class="min-h-screen bg-gradient-to-br from-navy-900 via-navy-800 to-navy-900 relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="pt-20 pb-32 text-center">
            <!-- Logo & Branding -->
            <div class="mb-8 flex justify-center">
                <div class="w-16 h-16 bg-gradient-to-br from-cyan-400 to-cyan-500 rounded-lg flex items-center justify-center shadow-lg">
                    <span class="text-white text-2xl font-bold">LM</span>
                </div>
            </div>
            
            <!-- Main Heading -->
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                Layanan Aspirasi dan Pengaduan
                <span class="block text-cyan-400">Mahasiswa Kampus</span>
            </h1>
            
            <!-- Subtitle -->
            <p class="text-xl text-cyan-100 mb-8 max-w-2xl mx-auto">
                Sampaikan laporan Anda langsung kepada pihak yang berwenang dengan mudah, aman, dan terpercaya
            </p>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
                @auth
                    <a href="{{ route('student.reports.create') }}" class="btn-primary text-lg px-8 py-4">
                        Buat Laporan Baru
                    </a>
                    <a href="{{ route('student.reports.index') }}" class="btn-outline text-lg px-8 py-4">
                        Lihat Laporan Saya
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary text-lg px-8 py-4">
                        Masuk & Buat Laporan
                    </a>
                    <a href="{{ route('register') }}" class="btn-outline text-lg px-8 py-4">
                        Daftar Akun Baru
                    </a>
                @endauth
            </div>
            
            <!-- Stats -->
            <div class="grid grid-cols-3 gap-6 md:gap-12">
                <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-lg p-6 border border-white border-opacity-20">
                    <div class="text-3xl font-bold text-cyan-300 mb-2">{{ \App\Models\Report::count() }}</div>
                    <p class="text-cyan-100 text-sm">Total Laporan</p>
                </div>
                <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-lg p-6 border border-white border-opacity-20">
                    <div class="text-3xl font-bold text-cyan-300 mb-2">{{ \App\Models\Report::where('status', 'completed')->count() }}</div>
                    <p class="text-cyan-100 text-sm">Selesai</p>
                </div>
                <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-lg p-6 border border-white border-opacity-20">
                    <div class="text-3xl font-bold text-cyan-300 mb-2">{{ \App\Models\User::count() }}</div>
                    <p class="text-cyan-100 text-sm">Pengguna Aktif</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Proses Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="heading-lg mb-4">Proses Penanganan Laporan</h2>
            <p class="text-navy-600 text-lg">Laporan Anda ditangani dengan sistematis dan transparan</p>
        </div>
        
        <div class="grid md:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-cyan-100 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-cyan-500">
                    <span class="text-2xl font-bold text-cyan-600">1</span>
                </div>
                <h3 class="heading-sm text-navy-900 mb-2">Sampaikan Laporan</h3>
                <p class="text-navy-600">
                    Tulis laporan Anda dengan jelas dan lengkap dengan bukti pendukung
                </p>
            </div>
            
            <!-- Step 2 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-cyan-100 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-cyan-500">
                    <span class="text-2xl font-bold text-cyan-600">2</span>
                </div>
                <h3 class="heading-sm text-navy-900 mb-2">Verifikasi (3 hari)</h3>
                <p class="text-navy-600">
                    Laporan Anda diverifikasi dan diteruskan ke instansi yang berwenang
                </p>
            </div>
            
            <!-- Step 3 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-cyan-100 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-cyan-500">
                    <span class="text-2xl font-bold text-cyan-600">3</span>
                </div>
                <h3 class="heading-sm text-navy-900 mb-2">Tindak Lanjut (5 hari)</h3>
                <p class="text-navy-600">
                    Instansi menindaklanjuti dan memberikan respon terhadap laporan
                </p>
            </div>
            
            <!-- Step 4 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-cyan-100 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-cyan-500">
                    <span class="text-2xl font-bold text-cyan-600">4</span>
                </div>
                <h3 class="heading-sm text-navy-900 mb-2">Selesai</h3>
                <p class="text-navy-600">
                    Laporan ditindaklanjuti hingga tuntas dan Anda dapat memberi tanggapan
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Klasifikasi Section -->
<section class="py-20 bg-navy-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="heading-lg mb-4">Jenis Laporan</h2>
            <p class="text-navy-600 text-lg">Pilih jenis laporan yang sesuai dengan kebutuhan Anda</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Pengaduan -->
            <div class="card-elevated">
                <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 p-8 text-center border-b-4 border-cyan-500">
                    <svg class="w-16 h-16 text-cyan-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 4v2M6.343 3.665c.886-.887 2.318-.887 3.203 0l9.759 9.759c.886.886.886 2.318 0 3.203l-9.759 9.759c-.886.886-2.318.886-3.203 0L3.464 18.422c-.886-.886-.886-2.318 0-3.203L6.343 3.665z"></path>
                    </svg>
                    <h3 class="heading-sm text-navy-900 mb-2">Pengaduan</h3>
                    <p class="text-navy-600 text-sm">Laporkan keluhan atau masalah yang terjadi</p>
                </div>
                <div class="p-6">
                    <p class="text-navy-600 mb-4">
                        Gunakan kategori ini untuk melaporkan keluhan atau masalah yang memerlukan tindakan cepat
                    </p>
                    @auth
                        <a href="{{ route('student.reports.create', ['type' => 'pengaduan']) }}" class="btn-primary w-full text-center">
                            Buat Pengaduan
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary w-full text-center">
                            Masuk untuk Lanjut
                        </a>
                    @endauth
                </div>
            </div>
            
            <!-- Aspirasi -->
            <div class="card-elevated">
                <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 p-8 text-center border-b-4 border-cyan-500">
                    <svg class="w-16 h-16 text-cyan-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <h3 class="heading-sm text-navy-900 mb-2">Aspirasi</h3>
                    <p class="text-navy-600 text-sm">Sampaikan saran dan ide untuk perbaikan</p>
                </div>
                <div class="p-6">
                    <p class="text-navy-600 mb-4">
                        Gunakan kategori ini untuk memberikan saran atau ide konstruktif untuk perbaikan
                    </p>
                    @auth
                        <a href="{{ route('student.reports.create', ['type' => 'aspirasi']) }}" class="btn-primary w-full text-center">
                            Buat Aspirasi
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary w-full text-center">
                            Masuk untuk Lanjut
                        </a>
                    @endauth
                </div>
            </div>
            
            <!-- Permintaan Informasi -->
            <div class="card-elevated">
                <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 p-8 text-center border-b-4 border-cyan-500">
                    <svg class="w-16 h-16 text-cyan-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="heading-sm text-navy-900 mb-2">Permintaan Informasi</h3>
                    <p class="text-navy-600 text-sm">Minta informasi dari pihak terkait</p>
                </div>
                <div class="p-6">
                    <p class="text-navy-600 mb-4">
                        Gunakan kategori ini untuk meminta informasi atau dokumentasi tertentu
                    </p>
                    @auth
                        <a href="{{ route('student.reports.create', ['type' => 'informasi']) }}" class="btn-primary w-full text-center">
                            Buat Permintaan
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary w-full text-center">
                            Masuk untuk Lanjut
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-20 bg-gradient-to-r from-navy-900 to-navy-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold mb-4">Statistik Laporan</h2>
            <p class="text-cyan-100">Data real-time dari sistem Lapor Mahasiswa</p>
        </div>
        
        <div class="grid md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-5xl font-bold text-cyan-400 mb-2">
                    {{ \App\Models\Report::count() }}
                </div>
                <p class="text-cyan-100 text-lg">Total Laporan</p>
            </div>
            
            <div class="text-center">
                <div class="text-5xl font-bold text-cyan-400 mb-2">
                    {{ \App\Models\Report::where('status', 'completed')->count() }}
                </div>
                <p class="text-cyan-100 text-lg">Laporan Selesai</p>
            </div>
            
            <div class="text-center">
                <div class="text-5xl font-bold text-cyan-400 mb-2">
                    {{ \App\Models\ReportCategory::count() }}
                </div>
                <p class="text-cyan-100 text-lg">Kategori</p>
            </div>
            
            <div class="text-center">
                <div class="text-5xl font-bold text-cyan-400 mb-2">
                    {{ \App\Models\User::count() }}
                </div>
                <p class="text-cyan-100 text-lg">Pengguna Aktif</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="heading-lg mb-4">Pertanyaan yang Sering Diajukan</h2>
            <p class="text-navy-600 text-lg">Cari jawaban untuk pertanyaan Anda</p>
        </div>
        
        <div class="space-y-4">
            <!-- FAQ Item 1 -->
            <div x-data="{ open: false }" class="border border-navy-200 rounded-lg">
                <button @click="open = !open" class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-navy-50 transition-colors">
                    <h3 class="font-semibold text-navy-900">Apakah laporan saya dijamin rahasia?</h3>
                    <svg class="w-5 h-5 text-navy-600 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </button>
                <div x-show="open" class="px-6 py-4 bg-navy-50 border-t border-navy-200">
                    <p class="text-navy-600">
                        Ya, laporan Anda dapat dibuat secara anonim dan dijaga kerahasiaannya sesuai dengan peraturan yang berlaku.
                    </p>
                </div>
            </div>
            
            <!-- FAQ Item 2 -->
            <div x-data="{ open: false }" class="border border-navy-200 rounded-lg">
                <button @click="open = !open" class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-navy-50 transition-colors">
                    <h3 class="font-semibold text-navy-900">Berapa lama proses penanganan laporan?</h3>
                    <svg class="w-5 h-5 text-navy-600 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </button>
                <div x-show="open" class="px-6 py-4 bg-navy-50 border-t border-navy-200">
                    <p class="text-navy-600">
                        Proses verifikasi membutuhkan 3 hari, dilanjutkan dengan tindak lanjut dalam 5 hari kerja, dan penyelesaian hingga 10 hari.
                    </p>
                </div>
            </div>
            
            <!-- FAQ Item 3 -->
            <div x-data="{ open: false }" class="border border-navy-200 rounded-lg">
                <button @click="open = !open" class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-navy-50 transition-colors">
                    <h3 class="font-semibold text-navy-900">Bisakah saya melacak status laporan saya?</h3>
                    <svg class="w-5 h-5 text-navy-600 transform transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </button>
                <div x-show="open" class="px-6 py-4 bg-navy-50 border-t border-navy-200">
                    <p class="text-navy-600">
                        Ya, Anda dapat melacak status laporan Anda melalui dashboard akun Anda dengan real-time updates.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Final -->
<section class="py-20 bg-gradient-to-r from-cyan-500 to-cyan-600">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold text-white mb-6">Siap Menyampaikan Laporan Anda?</h2>
        <p class="text-xl text-cyan-100 mb-8">
            Bergabunglah dengan ribuan pengguna lainnya dalam membuat perubahan positif
        </p>
        
        @auth
            <a href="{{ route('student.reports.create') }}" class="inline-block bg-white text-cyan-600 font-bold py-4 px-8 rounded-lg hover:bg-cyan-50 transition-colors shadow-lg">
                Mulai Buat Laporan Sekarang
            </a>
        @else
            <a href="{{ route('register') }}" class="inline-block bg-white text-cyan-600 font-bold py-4 px-8 rounded-lg hover:bg-cyan-50 transition-colors shadow-lg">
                Daftar & Buat Laporan
            </a>
        @endauth
    </div>
</section>
@endsection
