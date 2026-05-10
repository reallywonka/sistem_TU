<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\KategoriSurat;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ArsipController extends Controller
{
    public function index(Request $request): View
    {
        $q        = $request->input('q');
        $dari     = $request->input('dari');
        $sampai   = $request->input('sampai');
        $kategori = $request->input('kategori');
        $tipe     = $request->input('tipe'); // masuk | keluar | null (semua)

        // Surat Masuk query
        $smQuery = SuratMasuk::with('kategori')->select(
            'id_surat_masuk as id', 'nomor_surat', 'tgl_surat', 'perihal', 'id_kategori',
            'asal_surat as pihak', 'file_pdf', 'created_at'
        )->selectRaw("'masuk' as tipe");

        // Surat Keluar query
        $skQuery = SuratKeluar::with('kategori')->select(
            'id_surat_keluar as id', 'nomor_surat', 'tgl_surat', 'perihal', 'id_kategori',
            'tujuan_surat as pihak', 'file_pdf', 'created_at'
        )->selectRaw("'keluar' as tipe");

        // Terapkan filter
        if ($q) {
            $smQuery->where(fn($b) => $b->where('nomor_surat', 'like', "%$q%")->orWhere('perihal', 'like', "%$q%")->orWhere('asal_surat', 'like', "%$q%"));
            $skQuery->where(fn($b) => $b->where('nomor_surat', 'like', "%$q%")->orWhere('perihal', 'like', "%$q%")->orWhere('tujuan_surat', 'like', "%$q%"));
        }

        if ($kategori) {
            $smQuery->where('id_kategori', $kategori);
            $skQuery->where('id_kategori', $kategori);
        }

        if ($dari && $sampai) {
            $smQuery->whereBetween('tgl_surat', [$dari, $sampai]);
            $skQuery->whereBetween('tgl_surat', [$dari, $sampai]);
        }

        // Ambil sesuai tipe filter
        $arsips    = collect();
        $kategoris = KategoriSurat::orderBy('nama_kategori')->get();

        if (!$tipe || $tipe === 'masuk') {
            $arsips = $arsips->merge($smQuery->get());
        }
        if (!$tipe || $tipe === 'keluar') {
            $arsips = $arsips->merge($skQuery->get());
        }

        $arsips = $arsips->sortByDesc('tgl_surat')->values();

        // Manual paginate
        $page    = $request->input('page', 1);
        $perPage = 10;
        $total   = $arsips->count();
        $items   = $arsips->slice(($page - 1) * $perPage, $perPage)->values();

        return view('arsip.index', compact('items', 'total', 'page', 'perPage', 'kategoris'));
    }

    public function show(string $type, int $id): View
    {
        abort_unless(in_array($type, ['masuk', 'keluar']), 404);

        if ($type === 'masuk') {
            $arsip = SuratMasuk::with(['kategori', 'disposisi'])->findOrFail($id);
        } else {
            $arsip = SuratKeluar::with('kategori')->findOrFail($id);
        }

        return view('arsip.show', compact('arsip', 'type'));
    }

    public function download(string $type, int $id): StreamedResponse|RedirectResponse
    {
        abort_unless(in_array($type, ['masuk', 'keluar']), 404);

        $model = $type === 'masuk'
            ? SuratMasuk::findOrFail($id)
            : SuratKeluar::findOrFail($id);

        if (!$model->file_pdf || !Storage::disk('public')->exists($model->file_pdf)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download(
            $model->file_pdf,
            "arsip-{$type}-{$model->nomor_surat}.pdf"
        );
    }
}
