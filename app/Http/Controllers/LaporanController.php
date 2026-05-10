<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Disposisi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $bulan  = $request->input('bulan', now()->month);
        $tahun  = $request->input('tahun', now()->year);

        $totalMasuk   = SuratMasuk::whereMonth('tgl_surat', $bulan)->whereYear('tgl_surat', $tahun)->count();
        $totalKeluar  = SuratKeluar::whereMonth('tgl_surat', $bulan)->whereYear('tgl_surat', $tahun)->count();
        $totalDisp    = Disposisi::whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->count();
        $dispSelesai  = Disposisi::where('status_tugas', 'selesai')->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->count();

        $suratMasuks  = SuratMasuk::with('kategori')->whereMonth('tgl_surat', $bulan)->whereYear('tgl_surat', $tahun)->latest()->get();
        $suratKeluars = SuratKeluar::with('kategori')->whereMonth('tgl_surat', $bulan)->whereYear('tgl_surat', $tahun)->latest()->get();

        return view('laporan.index', compact(
            'bulan', 'tahun', 'totalMasuk', 'totalKeluar',
            'totalDisp', 'dispSelesai', 'suratMasuks', 'suratKeluars'
        ));
    }

    public function export(Request $request): RedirectResponse
    {
        // Placeholder — bisa diisi dengan export Excel/PDF nanti
        return back()->with('error', 'Fitur export akan segera tersedia.');
    }
}
