<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Disposisi;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        // Statistik umum
        $totalSuratMasuk  = SuratMasuk::count();
        $totalSuratKeluar = SuratKeluar::count();
        $totalDisposisi   = Disposisi::count();
        $pendingDisposisi = Disposisi::where('status_tugas', 'belum_dibaca')->count();

        // Aktivitas terbaru — gabungan 10 terakhir
        $suratMasukTerbaru  = SuratMasuk::with('kategori')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn ($s) => array_merge($s->toArray(), ['tipe' => 'masuk', 'model' => $s]));

        $suratKeluarTerbaru = SuratKeluar::with('kategori')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn ($s) => array_merge($s->toArray(), ['tipe' => 'keluar', 'model' => $s]));

        $aktivitasTerbaru = $suratMasukTerbaru
            ->merge($suratKeluarTerbaru)
            ->sortByDesc('created_at')
            ->take(10)
            ->values();

        return view('dashboard', compact(
            'totalSuratMasuk',
            'totalSuratKeluar',
            'totalDisposisi',
            'pendingDisposisi',
            'aktivitasTerbaru',
        ));
    }
}
