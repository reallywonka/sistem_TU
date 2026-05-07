<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\KategoriSurat;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SuratKeluarController extends Controller
{
    public function index(Request $request): View
    {
        $query = SuratKeluar::with('kategori')->latest();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($b) use ($q) {
                $b->where('nomor_surat', 'like', "%{$q}%")
                  ->orWhere('perihal', 'like', "%{$q}%")
                  ->orWhere('tujuan_surat', 'like', "%{$q}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->filled('dari') && $request->filled('sampai')) {
            $query->whereBetween('tgl_surat', [$request->dari, $request->sampai]);
        }

        $suratKeluars = $query->paginate(10)->withQueryString();
        $kategoris    = KategoriSurat::orderBy('nama_kategori')->get();

        return view('surat-keluar.index', compact('suratKeluars', 'kategoris'));
    }

    public function create(): View
    {
        $kategoris = KategoriSurat::orderBy('nama_kategori')->get();

        return view('surat-keluar.create', compact('kategoris'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nomor_surat'  => ['required', 'string', 'max:50'],
            'tgl_surat'    => ['required', 'date'],
            'tujuan_surat' => ['required', 'string', 'max:100'],
            'perihal'      => ['required', 'string', 'max:255'],
            'id_kategori'  => ['required', 'exists:kategori_surat,id_kategori'],
            'file_pdf'     => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:10240'],
        ]);

        if ($request->hasFile('file_pdf')) {
            $data['file_pdf'] = $request->file('file_pdf')
                ->store('surat-keluar', 'public');
        }

        SuratKeluar::create($data);

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil ditambahkan.');
    }

    public function show(int $id): View
    {
        $suratKeluar = SuratKeluar::with('kategori')->findOrFail($id);

        return view('surat-keluar.show', compact('suratKeluar'));
    }

    public function edit(int $id): View
    {
        $suratKeluar = SuratKeluar::findOrFail($id);
        $kategoris   = KategoriSurat::orderBy('nama_kategori')->get();

        return view('surat-keluar.edit', compact('suratKeluar', 'kategoris'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $suratKeluar = SuratKeluar::findOrFail($id);

        $data = $request->validate([
            'nomor_surat'  => ['required', 'string', 'max:50'],
            'tgl_surat'    => ['required', 'date'],
            'tujuan_surat' => ['required', 'string', 'max:100'],
            'perihal'      => ['required', 'string', 'max:255'],
            'id_kategori'  => ['required', 'exists:kategori_surat,id_kategori'],
            'file_pdf'     => ['nullable', 'file', 'mimes:pdf,jpg,png', 'max:10240'],
        ]);

        if ($request->hasFile('file_pdf')) {
            if ($suratKeluar->file_pdf) {
                Storage::disk('public')->delete($suratKeluar->file_pdf);
            }
            $data['file_pdf'] = $request->file('file_pdf')
                ->store('surat-keluar', 'public');
        } else {
            unset($data['file_pdf']);
        }

        $suratKeluar->update($data);

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $suratKeluar = SuratKeluar::findOrFail($id);

        if ($suratKeluar->file_pdf) {
            Storage::disk('public')->delete($suratKeluar->file_pdf);
        }

        $suratKeluar->delete();

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil dihapus.');
    }

    public function download(int $id)
    {
        $suratKeluar = SuratKeluar::findOrFail($id);

        if (!$suratKeluar->file_pdf || !Storage::disk('public')->exists($suratKeluar->file_pdf)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download(
            $suratKeluar->file_pdf,
            "surat-keluar-{$suratKeluar->nomor_surat}.pdf"
        );
    }
}
