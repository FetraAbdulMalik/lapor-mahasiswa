<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

# =====================================================================
# HOME CONTROLLER - Public routes untuk landing page & info pages
# =====================================================================
# Controller ini menangani public pages yang bisa diakses tanpa login:
# - index(): Landing page dengan intro sistem
# - about(): Tentang aplikasi
# - howToReport(): Panduan cara membuat laporan
# - faq(): Frequently Asked Questions
# - statistics(): Dashboard statistik laporan publik
# - contact(): Contact form untuk komunikasi
# =====================================================================
# Features:
#   - Landing page dengan fitur sistem & CTA untuk registrasi
#   - About page dengan visi/misi & informasi aplikasi
#   - How-to guide dengan kategori laporan yang tersedia
#   - FAQ dengan pertanyaan umum & jawaban (hardcoded, bisa di-database)
#   - Statistics dashboard dengan laporan metrics (total, by category, trend)
#   - Contact form untuk hubungi admin/support
#   - Responsive design untuk mobile & desktop
# =====================================================================
# Security:
#   - Public access (NO auth required)
#   - Form validation untuk contact submission
#   - Email validation dengan rfc & dns checks
#   - No sensitive data exposure (query scope untuk public reports only)
# =====================================================================

class HomeController extends Controller
{
    # ===================================================================
    # index() - Landing page / Homepage
    # ===================================================================
    # Tampilkan landing page welcome untuk user publik
    # Akses: public, tanpa login required
    
    /**
     * Homepage
     */
    public function index()
    {
        # Return view landing page dengan intro & features
        return view('landing');
    }

    # ===================================================================
    # about() - About application page
    # ===================================================================
    # Tampilkan informasi tentang aplikasi & visi/misi kampus
    
    /**
     * About page
     */
    public function about()
    {
        # Return static about page
        return view('pages.about');
    }

    # ===================================================================
    # howToReport() - Panduan cara membuat laporan
    # ===================================================================
    # Tampilkan step-by-step guide untuk membuat laporan dengan kategori
    # Gunakan untuk educate user sebelum login
    
    /**
     * How to report guide
     */
    public function howToReport()
    {
        # Load semua kategori aktif untuk tampilkan di guide
        # User lihat kategori apa saja yang bisa di-lapor
        $categories = ReportCategory::active()->get();
        return view('pages.how-to-report', compact('categories'));
    }

    # ===================================================================
    # faq() - Frequently Asked Questions page
    # ===================================================================
    # Tampilkan daftar FAQ dalam array untuk accordion display
    # Jawaban di-hardcode (bisa dipindah ke database di masa depan)
    
    /**
     * FAQ page
     */
    public function faq()
    {
        # Array FAQ dengan question & answer pairs
        # Topik: cara lapor, anonim, waktu proses, tracking, edit/delete, dll
        $faqs = [
            [
                'question' => 'Bagaimana cara membuat laporan?',
                'answer' => 'Login ke akun Anda, pilih menu "Buat Laporan", pilih kategori, isi detail masalah, upload bukti foto (opsional), dan submit.'
            ],
            [
                'question' => 'Apakah bisa melaporkan secara anonim?',
                'answer' => 'Ya, saat membuat laporan pilih opsi "Lapor sebagai Anonim".  Identitas Anda akan disembunyikan dari publik.'
            ],
            [
                'question' => 'Berapa lama waktu penanganan laporan?',
                'answer' => 'Rata-rata 3-7 hari kerja tergantung jenis dan urgensi masalah. Anda bisa tracking progress laporan secara real-time.'
            ],
            [
                'question' => 'Apa yang terjadi setelah saya submit laporan?',
                'answer' => 'Laporan akan ditinjau oleh admin terkait, Anda akan mendapat notifikasi setiap ada update status atau komentar dari admin.'
            ],
            [
                'question' => 'Bisa menghapus atau edit laporan?',
                'answer' => 'Laporan hanya bisa diedit/dihapus jika masih berstatus "Menunggu".  Setelah ditinjau admin, tidak bisa diubah.'
            ],
        ];

        # Return FAQ page dengan data array
        return view('pages.faq', compact('faqs'));
    }

    # ===================================================================
    # statistics() - Public statistics dashboard
    # ===================================================================
    # Tampilkan statistik laporan publik untuk transparansi
    # Data yang ditampilkan:
    # - Total laporan, resolved, in progress, pending
    # - Laporan by kategori
    # - Trend laporan per bulan (6 bulan terakhir)
    # - Rata-rata waktu response
    
    /**
     * Statistics page
     */
    public function statistics()
    {
        # OVERALL STATISTICS
        # Count laporan berdasarkan status
        $totalReports = Report::count();
        $resolvedReports = Report::resolved()->count();  # Menggunakan query scope
        $inProgressReports = Report::inProgress()->count();
        $pendingReports = Report::pending()->count();

        # REPORTS BY CATEGORY
        # Count laporan per kategori, order by count descending
        # withCount('reports') = eager load count relation
        $reportsByCategory = ReportCategory::withCount('reports')
            ->orderBy('reports_count', 'desc')
            ->get();

        # REPORTS BY MONTH (Last 6 months)
        # Group laporan by MONTH & YEAR
        # Gunakan untuk trend chart
        $reportsByMonth = Report::where('created_at', '>=', now()->subMonths(6))
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as total'))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        # AVERAGE RESPONSE TIME
        # Hitung rata-rata hari dari created_at hingga resolved_at
        # Gunakan untuk SLA metric
        $avgResponseTime = Report::whereNotNull('resolved_at')
            ->selectRaw('AVG(DATEDIFF(resolved_at, created_at)) as avg_days')
            ->value('avg_days');

        # Return statistics page dengan semua data
        return view('pages.statistics', compact(
            'totalReports',
            'resolvedReports',
            'inProgressReports',
            'pendingReports',
            'reportsByCategory',
            'reportsByMonth',
            'avgResponseTime'
        ));
    }

    # ===================================================================
    # contact() - Contact form page
    # ===================================================================
    # Tampilkan contact form untuk user hubungi sistem
    
    /**
     * Contact page
     */
    public function contact()
    {
        # Return contact form page
        return view('pages.contact');
    }

    # ===================================================================
    # sendContact() - Process contact form submission
    # ===================================================================
    # Validate & process contact message dari user
    # TODO: Implement email sending atau database storage
    
    /**
     * Send contact message
     */
    public function sendContact(Request $request)
    {
        # VALIDATE contact form input
        # name: required, max 255 chars
        # email: required, valid email format (RFC & DNS)
        # subject: required, max 255 chars
        # message: required, min 10 chars, max 5000 chars
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
        ]);

        # TODO: IMPLEMENT EMAIL SENDING
        # Option 1: Send email ke admin menggunakan Mail::send()
        # Option 2: Save ke database contact_messages table
        # Currently just redirect dengan success message

        # REDIRECT BACK dengan success message
        return redirect()->back()
            ->with('success', 'Pesan Anda telah terkirim. Kami akan menghubungi Anda segera.');
    }
}