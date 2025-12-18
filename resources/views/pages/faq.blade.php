@extends('layouts.guest')

@section('title', 'FAQ - Pertanyaan yang Sering Diajukan')

@section('content')
<div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-2">Pertanyaan yang Sering Diajukan</h1>
        <p class="text-xl text-primary-100">Temukan jawaban untuk pertanyaan umum tentang sistem pelaporan</p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Search Box -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="relative">
            <input type="text" id="faqSearch" placeholder="Cari pertanyaan..." 
                   class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            <i class="fas fa-search absolute left-4 top-4 text-gray-400"></i>
        </div>
    </div>

    <!-- FAQ Accordion -->
    <div class="space-y-4" id="faqContainer">
        @foreach($faqs as $index => $faq)
            <div class="bg-white rounded-lg shadow-md overflow-hidden faq-item" data-question="{{ strtolower($faq['question']) }}" data-answer="{{ strtolower($faq['answer']) }}">
                <button type="button" 
                        class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors duration-200 faq-button"
                        onclick="toggleFaq({{ $index }})">
                    <span class="flex items-start flex-1">
                        <i class="fas fa-question-circle text-primary-600 mr-3 mt-1"></i>
                        <span class="font-semibold text-gray-900">{{ $faq['question'] }}</span>
                    </span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200 faq-icon-{{ $index }}"></i>
                </button>
                <div id="faq-{{ $index }}" class="hidden px-6 pb-4 faq-content">
                    <div class="pl-8 text-gray-600 leading-relaxed">
                        {{ $faq['answer'] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- No Results Message -->
    <div id="noResults" class="hidden bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Tidak Ada Hasil</h3>
        <p class="text-gray-600">Coba gunakan kata kunci yang berbeda</p>
    </div>

    <!-- Still Have Questions -->
    <div class="mt-12 bg-gradient-to-r from-primary-600 to-primary-700 rounded-lg shadow-xl p-8 text-center">
        <i class="fas fa-question-circle text-4xl text-white mb-4"></i>
        <h2 class="text-2xl font-bold text-white mb-4">Masih Punya Pertanyaan?</h2>
        <p class="text-primary-100 mb-6">Hubungi kami atau buat laporan langsung jika Anda memiliki masalah</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white text-primary-600 font-semibold rounded-lg hover:bg-gray-100 transition duration-200">
                <i class="fas fa-envelope mr-2"></i>Hubungi Kami
            </a>
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary-500 text-white font-semibold rounded-lg hover:bg-primary-400 transition duration-200">
                <i class="fas fa-plus-circle mr-2"></i>Buat Laporan
            </a>
        </div>
    </div>

    <!-- Help Categories -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('how.to.report') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow duration-200 group">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4 group-hover:bg-blue-200 transition-colors duration-200">
                <i class="fas fa-book text-2xl text-blue-600"></i>
            </div>
            <h3 class="font-bold text-gray-900 mb-2">Panduan Melapor</h3>
            <p class="text-sm text-gray-600">Pelajari cara membuat laporan dengan benar</p>
        </a>

        <a href="{{ route('reports.public') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow duration-200 group">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4 group-hover:bg-green-200 transition-colors duration-200">
                <i class="fas fa-list text-2xl text-green-600"></i>
            </div>
            <h3 class="font-bold text-gray-900 mb-2">Laporan Publik</h3>
            <p class="text-sm text-gray-600">Lihat laporan yang telah dibuat mahasiswa lain</p>
        </a>

        <a href="{{ route('statistics') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow duration-200 group">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4 group-hover:bg-purple-200 transition-colors duration-200">
                <i class="fas fa-chart-bar text-2xl text-purple-600"></i>
            </div>
            <h3 class="font-bold text-gray-900 mb-2">Statistik</h3>
            <p class="text-sm text-gray-600">Lihat data dan statistik laporan kampus</p>
        </a>
    </div>
</div>

@push('scripts')
<script>
    // Toggle FAQ accordion
    function toggleFaq(index) {
        const content = document.getElementById(`faq-${index}`);
        const icon = document.querySelector(`.faq-icon-${index}`);
        
        content.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }

    // Search functionality
    document.getElementById('faqSearch').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const faqItems = document.querySelectorAll('.faq-item');
        const noResults = document.getElementById('noResults');
        let hasResults = false;

        faqItems.forEach(item => {
            const question = item.getAttribute('data-question');
            const answer = item.getAttribute('data-answer');
            
            if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                item.classList.remove('hidden');
                hasResults = true;
            } else {
                item.classList.add('hidden');
            }
        });

        if (hasResults || searchTerm === '') {
            noResults.classList.add('hidden');
        } else {
            noResults.classList.remove('hidden');
        }
    });
</script>
@endpush
@endsection
