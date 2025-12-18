<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Homepage
     */
    public function index()
    {
        // Statistics for homepage
        $totalReports = Report::count();
        $resolvedReports = Report::resolved()->count();
        $inProgressReports = Report::inProgress()->count();
        $pendingReports = Report::pending()->count();

        // Categories
        $categories = ReportCategory::active()->get();

        // Recent public reports
        $recentReports = Report::public()
            ->with(['category', 'building'])
            ->latest()
            ->take(6)
            ->get();

        return view('welcome', compact(
            'totalReports',
            'resolvedReports',
            'inProgressReports',
            'pendingReports',
            'categories',
            'recentReports'
        ));
    }

    /**
     * About page
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * How to report guide
     */
    public function howToReport()
    {
        $categories = ReportCategory::active()->get();
        return view('pages.how-to-report', compact('categories'));
    }

    /**
     * FAQ page
     */
    public function faq()
    {
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

        return view('pages.faq', compact('faqs'));
    }

    /**
     * Statistics page
     */
    public function statistics()
    {
        // Overall statistics
        $totalReports = Report::count();
        $resolvedReports = Report::resolved()->count();
        $inProgressReports = Report::inProgress()->count();
        $pendingReports = Report::pending()->count();

        // Reports by category
        $reportsByCategory = ReportCategory::withCount('reports')
            ->orderBy('reports_count', 'desc')
            ->get();

        // Reports by month (last 6 months)
        $reportsByMonth = Report::where('created_at', '>=', now()->subMonths(6))
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as total'))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Average response time
        $avgResponseTime = Report::whereNotNull('resolved_at')
            ->selectRaw('AVG(DATEDIFF(resolved_at, created_at)) as avg_days')
            ->value('avg_days');

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

    /**
     * Contact page
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Send contact message
     */
    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
        ]);

        // You can send email or save to database here
        // For now, just redirect with success message
        // TODO: Implement email sending or database storage

        return redirect()->back()
            ->with('success', 'Pesan Anda telah terkirim. Kami akan menghubungi Anda segera.');
    }
}