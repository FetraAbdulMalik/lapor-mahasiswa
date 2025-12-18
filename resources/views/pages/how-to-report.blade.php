@extends('layouts.guest')

@section('title', 'Cara Melapor')

@section('content')
<div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-2">Cara Melapor</h1>
        <p class="text-xl text-primary-100">Panduan lengkap membuat laporan mahasiswa</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Introduction -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <div class="flex items-start mb-6">
            <div class="flex-shrink-0 w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-info-circle text-2xl text-primary-600"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Tentang Sistem Pelaporan</h2>
                <p class="text-gray-600">
                    Sistem Lapor Mahasiswa adalah platform yang memudahkan mahasiswa untuk melaporkan berbagai masalah 
                    terkait fasilitas kampus, akademik, dan layanan lainnya. Laporan Anda akan ditangani oleh tim terkait 
                    dan dipantau hingga selesai.
                </p>
            </div>
        </div>
    </div>

    <!-- Steps -->
    <div class="space-y-6 mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Langkah-langkah Membuat Laporan</h2>

        <!-- Step 1 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-600 text-white rounded-full flex items-center justify-center font-bold text-xl mr-4">
                    1
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Login ke Akun Anda</h3>
                    <p class="text-gray-600 mb-4">
                        Masuk menggunakan akun mahasiswa Anda. Jika belum memiliki akun, lakukan registrasi terlebih dahulu 
                        menggunakan email kampus dan NIM Anda.
                    </p>
                    <a href="{{ route('login') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login Sekarang
                    </a>
                </div>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-600 text-white rounded-full flex items-center justify-center font-bold text-xl mr-4">
                    2
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pilih Menu "Buat Laporan"</h3>
                    <p class="text-gray-600 mb-4">
                        Setelah login, klik tombol "Buat Laporan" di dashboard mahasiswa atau pada menu navigasi.
                    </p>
                </div>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-600 text-white rounded-full flex items-center justify-center font-bold text-xl mr-4">
                    3
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pilih Kategori Laporan</h3>
                    <p class="text-gray-600 mb-4">
                        Pilih kategori yang sesuai dengan masalah yang ingin Anda laporkan:
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($categories as $category)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <i class="{{ $category->icon ?? 'fas fa-folder' }} text-primary-600 mr-3"></i>
                                <span class="text-gray-700 font-medium">{{ $category->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-600 text-white rounded-full flex items-center justify-center font-bold text-xl mr-4">
                    4
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Isi Detail Laporan</h3>
                    <p class="text-gray-600 mb-4">Lengkapi informasi berikut dengan jelas dan detail:</p>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                            <span><strong>Judul Laporan:</strong> Buat judul yang singkat dan jelas</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                            <span><strong>Deskripsi:</strong> Jelaskan masalah secara detail, kapan terjadi, dan dampaknya</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                            <span><strong>Lokasi:</strong> Pilih gedung dan ruangan/fasilitas yang bermasalah</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                            <span><strong>Foto Bukti:</strong> Upload foto jika ada (opsional, maksimal 5 foto)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Step 5 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-600 text-white rounded-full flex items-center justify-center font-bold text-xl mr-4">
                    5
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pilih Opsi Privasi</h3>
                    <p class="text-gray-600 mb-4">Tentukan apakah laporan Anda:</p>
                    <div class="space-y-3">
                        <div class="flex items-start p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <i class="fas fa-eye text-blue-600 mr-3 mt-1"></i>
                            <div>
                                <div class="font-semibold text-gray-900">Publik</div>
                                <div class="text-sm text-gray-600">Laporan dapat dilihat oleh mahasiswa lain</div>
                            </div>
                        </div>
                        <div class="flex items-start p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <i class="fas fa-user-secret text-gray-600 mr-3 mt-1"></i>
                            <div>
                                <div class="font-semibold text-gray-900">Anonim</div>
                                <div class="text-sm text-gray-600">Identitas Anda disembunyikan dari publik</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 6 -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-600 text-white rounded-full flex items-center justify-center font-bold text-xl mr-4">
                    6
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Submit Laporan</h3>
                    <p class="text-gray-600 mb-4">
                        Periksa kembali semua informasi yang telah Anda isi, kemudian klik tombol <strong>"Kirim Laporan"</strong>. 
                        Anda akan menerima notifikasi konfirmasi dan dapat memantau progress laporan di dashboard.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tips Section -->
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg mb-8">
        <div class="flex items-start">
            <i class="fas fa-lightbulb text-2xl text-yellow-600 mr-4 mt-1"></i>
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Tips Membuat Laporan yang Baik</h3>
                <ul class="space-y-2 text-gray-700">
                    <li>✓ Gunakan bahasa yang sopan dan profesional</li>
                    <li>✓ Berikan detail yang cukup agar mudah dipahami</li>
                    <li>✓ Sertakan foto bukti untuk memperkuat laporan</li>
                    <li>✓ Pastikan informasi lokasi sudah tepat</li>
                    <li>✓ Periksa kembali sebelum mengirim</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Tracking Section -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Memantau Status Laporan</h2>
        <p class="text-gray-600 mb-6">
            Setelah laporan dikirim, Anda dapat memantau statusnya melalui dashboard. Berikut adalah status yang mungkin muncul:
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 border border-gray-200 rounded-lg">
                <div class="flex items-center mb-2">
                    <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                    <span class="font-semibold text-gray-900">Menunggu</span>
                </div>
                <p class="text-sm text-gray-600">Laporan sedang menunggu verifikasi dari admin</p>
            </div>
            <div class="p-4 border border-gray-200 rounded-lg">
                <div class="flex items-center mb-2">
                    <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                    <span class="font-semibold text-gray-900">Diproses</span>
                </div>
                <p class="text-sm text-gray-600">Laporan sedang ditangani oleh pihak terkait</p>
            </div>
            <div class="p-4 border border-gray-200 rounded-lg">
                <div class="flex items-center mb-2">
                    <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                    <span class="font-semibold text-gray-900">Selesai</span>
                </div>
                <p class="text-sm text-gray-600">Masalah telah selesai ditangani</p>
            </div>
            <div class="p-4 border border-gray-200 rounded-lg">
                <div class="flex items-center mb-2">
                    <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                    <span class="font-semibold text-gray-900">Ditolak</span>
                </div>
                <p class="text-sm text-gray-600">Laporan tidak dapat diproses (lihat keterangan)</p>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="text-center bg-gradient-to-r from-primary-600 to-primary-700 rounded-lg shadow-xl p-8">
        <h2 class="text-2xl font-bold text-white mb-4">Siap Membuat Laporan?</h2>
        <p class="text-primary-100 mb-6">Login sekarang dan sampaikan masalah Anda</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white text-primary-600 font-semibold rounded-lg hover:bg-gray-100 transition duration-200">
                <i class="fas fa-sign-in-alt mr-2"></i>Login
            </a>
            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary-500 text-white font-semibold rounded-lg hover:bg-primary-400 transition duration-200">
                <i class="fas fa-user-plus mr-2"></i>Daftar
            </a>
        </div>
    </div>
</div>
@endsection
