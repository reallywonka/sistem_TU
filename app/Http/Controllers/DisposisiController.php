<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class DisposisiController extends Controller
{
    public function index(Request $request): View
    {
        $query = Disposisi::with(['suratMasuk', 'penerima'])->latest();

        if ($request->filled('status')) {
            $query->where('status_tugas', $request->status);
        }

        $disposisis = $query->paginate(10)->withQueryString();

        return view('disposisi.index', compact('disposisis'));
    }

    /** Buat disposisi baru (dari halaman show surat masuk) — kepala_sekolah only */
    public function store(Request $request): RedirectResponse
    {
        if (!Auth::user()?->isKepsek()) {
            abort(403, 'Hanya Kepala Sekolah yang dapat membuat disposisi.');
        }

        $data = $request->validate([
            'id_surat_masuk' => ['required', 'exists:surat_masuk,id_surat_masuk'],
            'id_penerima'    => ['required', 'exists:users,id_user'],
            'instruksi'      => ['required', 'string'],
        ], [
            'id_surat_masuk.required' => 'Surat masuk wajib dipilih.',
            'id_penerima.required'    => 'Penerima disposisi wajib dipilih.',
            'instruksi.required'      => 'Instruksi disposisi wajib diisi.',
        ]);

        Disposisi::create($data);

        return redirect()->route('surat-masuk.show', $data['id_surat_masuk'])
            ->with('success', 'Disposisi berhasil dikirim.');
    }

    public function show(int $id): View
    {
        $disposisi = Disposisi::with(['suratMasuk.kategori', 'penerima'])->findOrFail($id);

        return view('disposisi.show', compact('disposisi'));
    }

    public function destroy(int $id): RedirectResponse
    {
        if (!Auth::user()?->isKepsek()) {
            abort(403, 'Akses ditolak.');
        }

        Disposisi::findOrFail($id)->delete();

        return redirect()->route('disposisi.index')
            ->with('success', 'Disposisi berhasil dihapus.');
    }

    /** Update status disposisi */
    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $disposisi = Disposisi::findOrFail($id);

        $request->validate([
            'status_tugas' => ['required', 'in:belum_dibaca,sedang_diproses,selesai'],
        ]);

        $disposisi->updateStatus($request->status_tugas);

        return back()->with('success', 'Status disposisi berhasil diperbarui.');
    }
}
