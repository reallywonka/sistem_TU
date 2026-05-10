<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\KategoriSurat;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SuratMasukController extends Controller
{
    /** Daftar surat masuk */
    public function index(Request $request): View
    {
        $query = SuratMasuk::with('kategori')->latest();

        // Filter pencarian
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($builder) use ($q) {
                $builder->where('nomor_surat', 'like', "%{$q}%")
                        ->orWhere('perihal', 'like', "%{$q}%")
                        ->orWhere('asal_surat', 'like', "%{$q}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->filled('dari') && $request->filled('sampai')) {
            $query->whereBetween('tgl_surat', [$request->dari, $request->sampai]);
        }

        $suratMasuks = $query->paginate(10)->withQueryString();
        $kategoris   = KategoriSurat::orderBy('nama_kategori')->get();

        return view('surat-masuk.index', compact('suratMasuks', 'kategoris'));
    }

    /** Form tambah surat masuk */
    public function create(): View
    {
        $this->authorizeAdminTU();
        $kategoris = KategoriSurat::orderBy('nama_kategori')->get();

        return view('surat-masuk.create', compact('kategoris'));
    }

    /** Simpan surat masuk baru */
    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdminTU();

        $data = $request->validate([
            'nomor_surat'  => ['required', 'string', 'max:50'],
            'tgl_surat'    => ['required', 'date'],
            'tgl_diterima' => ['required', 'date'],
            'asal_surat'   => ['required', 'string', 'max:100'],
            'perihal'      => ['required', 'string', 'max:255'],
            'id_kategori'  => ['required', 'exists:kategori_surat,id_kategori'],
            'file_pdf'     => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ], [
            'nomor_surat.required'  => 'Nomor surat wajib diisi.',
            'tgl_surat.required'    => 'Tanggal surat wajib diisi.',
            'tgl_diterima.required' => 'Tanggal diterima wajib diisi.',
            'asal_surat.required'   => 'Asal surat wajib diisi.',
            'perihal.required'      => 'Perihal wajib diisi.',
            'id_kategori.required'  => 'Kategori surat wajib dipilih.',
            'file_pdf.mimes'        => 'File harus berformat PDF.',
            'file_pdf.max'          => 'Ukuran file maksimal 10MB.',
        ]);

        // Upload PDF
        if ($request->hasFile('file_pdf')) {
            $data['file_pdf'] = $request->file('file_pdf')
                ->store('surat-masuk', 'public');
        }

        SuratMasuk::create($data);

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    /** Detail surat masuk */
    public function show(int $id): View
    {
        $suratMasuk = SuratMasuk::with(['kategori', 'disposisi.penerima'])->findOrFail($id);

        return view('surat-masuk.show', compact('suratMasuk'));
    }

    /** Form edit surat masuk */
    public function edit(int $id): View
    {
        $this->authorizeAdminTU();
        $suratMasuk = SuratMasuk::findOrFail($id);
        $kategoris  = KategoriSurat::orderBy('nama_kategori')->get();

        return view('surat-masuk.edit', compact('suratMasuk', 'kategoris'));
    }

    /** Update surat masuk */
    public function update(Request $request, int $id): RedirectResponse
    {
        $this->authorizeAdminTU();
        $suratMasuk = SuratMasuk::findOrFail($id);

        $data = $request->validate([
            'nomor_surat'  => ['required', 'string', 'max:50'],
            'tgl_surat'    => ['required', 'date'],
            'tgl_diterima' => ['required', 'date'],
            'asal_surat'   => ['required', 'string', 'max:100'],
            'perihal'      => ['required', 'string', 'max:255'],
            'id_kategori'  => ['required', 'exists:kategori_surat,id_kategori'],
            'file_pdf'     => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        // Ganti file PDF jika ada yang baru
        if ($request->hasFile('file_pdf')) {
            // Hapus file lama
            if ($suratMasuk->file_pdf) {
                Storage::disk('public')->delete($suratMasuk->file_pdf);
            }
            $data['file_pdf'] = $request->file('file_pdf')
                ->store('surat-masuk', 'public');
        } else {
            unset($data['file_pdf']);
        }

        $suratMasuk->update($data);

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil diperbarui.');
    }

    /** Hapus surat masuk */
    public function destroy(int $id): RedirectResponse
    {
        $this->authorizeAdminTU();
        $suratMasuk = SuratMasuk::findOrFail($id);

        // Hapus file PDF
        if ($suratMasuk->file_pdf) {
            Storage::disk('public')->delete($suratMasuk->file_pdf);
        }

        $suratMasuk->delete();

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil dihapus.');
    }

    /** Download file PDF */
    public function download(int $id): StreamedResponse|RedirectResponse
    {
        $suratMasuk = SuratMasuk::findOrFail($id);

        if (!$suratMasuk->file_pdf || !Storage::disk('public')->exists($suratMasuk->file_pdf)) {
            return back()->with('error', 'File PDF tidak ditemukan.');
        }

        return Storage::disk('public')->download(
            $suratMasuk->file_pdf,
            "surat-masuk-{$suratMasuk->nomor_surat}.pdf"
        );
    }

    /** Pastikan hanya admin_tu yang bisa aksi write */
    private function authorizeAdminTU(): void
    {
        if (!auth()->user()->isAdminTU()) {
            abort(403, 'Akses ditolak.');
        }
    }
}
