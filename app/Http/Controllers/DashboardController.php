<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index_admin(Request $request)
    {
        $selectedYear = $request->query('tahun', now()->year);
        
        $allYears = Pendaftaran::selectRaw('YEAR(created_at) as tahun')
            ->distinct()
            ->orderByRaw('YEAR(created_at) DESC')
            ->pluck('tahun')
            ->toArray();

        if (empty($allYears)) {
            $allYears = [now()->year];
        }

        $stats = [
            'total' => Pendaftaran::whereYear('created_at', $selectedYear)->count(),
            'pending' => Pendaftaran::whereYear('created_at', $selectedYear)->where('status', 'pending')->count(),
            'diterima' => Pendaftaran::whereYear('created_at', $selectedYear)->where('status', 'diterima')->count(),
            'ditolak' => Pendaftaran::whereYear('created_at', $selectedYear)->where('status', 'ditolak')->count()
        ];

        $kategoriStats = Pendaftaran::selectRaw('kategori, COUNT(*) as total')
            ->whereYear('created_at', $selectedYear)
            ->groupBy('kategori')
            ->pluck('total', 'kategori')
            ->toArray();

        $monthlyStats = Pendaftaran::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $selectedYear)
            ->groupByRaw('MONTH(created_at)')
            ->get();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $monthlyChartData = [];
        
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $count = $monthlyStats->where('bulan', $bulan)->first();
            $monthlyChartData[] = [
                'label' => $months[$bulan - 1],
                'count' => $count ? $count->total : 0
            ];
        }

        return view('admin.dashboard', compact('stats', 'kategoriStats', 'monthlyChartData', 'allYears', 'selectedYear'));
    }

    public function index_user()
    {
        $user = Auth::user();
        $pendaftaran = Pendaftaran::where('user_id', $user->id)->first();

        return view('user.dashboard', compact('pendaftaran'));
    }

    public function cetakSurat()
    {
        $user = auth()->user();
        $pendaftaran = Pendaftaran::with('instansi')->where('user_id', $user->id)->first();

        if (!$pendaftaran || $pendaftaran->status !== 'diterima') {
            abort(403, 'Akses ditolak. surat hanya dapat dicetak bagi pendaftar yang sudah diterima.');
        }

        $pdf = Pdf::loadView('user.surat-balasan', compact('pendaftaran', 'user'));
        $namaFile = 'Surat_Penerimaan_Magang_' . str_replace(' ', '_', $user->name) . '.pdf';
        return $pdf->download($namaFile);
    }
}
