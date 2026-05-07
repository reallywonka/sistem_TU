@extends('layouts.app')
@section('title', 'Detail Disposisi')

@section('content')
<div class="mb-6">
    <nav class="flex items-center gap-1 text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
        <a href="{{ route('disposisi.index') }}" class="hover:text-blue-600 transition-colors">Disposisi</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
        <span class="text-gray-900 font-medium">Detail</span>
    </nav>
    <h1 class="text-2xl font-bold text-gray-900">Detail Disposisi</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Info Surat --}}
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm p-6">
        <h2 class="text-base font-semibold text-gray-900 mb-4">Surat Terkait</h2>
        @if($disposisi->suratMasuk)
        <dl class="space-y-3">
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nomor Surat</dt>
                <dd class="mt-1 text-sm font-mono text-gray-900">{{ $disposisi->suratMasuk->nomor_surat }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Perihal</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $disposisi->suratMasuk->perihal }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Asal Surat</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $disposisi->suratMasuk->asal_surat }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tanggal Surat</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $disposisi->suratMasuk->tgl_surat->translatedFormat('d F Y') }}</dd>
            </div>
        </dl>
        <a href="{{ route('surat-masuk.show', $disposisi->id_surat_masuk) }}"
           class="mt-4 inline-flex items-center gap-1 text-sm text-blue-600 hover:underline">
            Lihat Surat Masuk
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
        </a>
        @endif
    </div>

    {{-- Info Disposisi + Update Status --}}
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm p-6">
        <h2 class="text-base font-semibold text-gray-900 mb-4">Instruksi Disposisi</h2>
        <dl class="space-y-3 mb-5">
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Instruksi</dt>
                <dd class="mt-1 text-sm text-gray-900 leading-relaxed bg-gray-50 rounded-lg p-3">{{ $disposisi->instruksi }}</dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Status Saat Ini</dt>
                <dd class="mt-1">
                    @php
                        $colorMap = ['belum_dibaca'=>'red','sedang_diproses'=>'yellow','selesai'=>'green'];
                        $c = $colorMap[$disposisi->status_tugas] ?? 'gray';
                    @endphp
                    <span class="inline-flex items-center rounded-full bg-{{ $c }}-50 px-3 py-1 text-sm font-medium text-{{ $c }}-700">
                        {{ $disposisi->status_label }}
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Dibuat</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $disposisi->created_at->translatedFormat('d F Y, H:i') }}</dd>
            </div>
        </dl>

        {{-- Update status --}}
        @if(auth()->user()->isAdminTU())
        <div class="border-t border-gray-100 pt-4">
            <p class="text-sm font-medium text-gray-700 mb-3">Perbarui Status</p>
            <form method="POST" action="{{ route('disposisi.update-status', $disposisi->id_disposisi) }}" class="flex flex-wrap gap-2">
                @csrf @method('PATCH')
                @foreach(['belum_dibaca' => 'Belum Dibaca', 'sedang_diproses' => 'Sedang Diproses', 'selesai' => 'Selesai'] as $val => $label)
                <button type="submit" name="status_tugas" value="{{ $val }}"
                        class="rounded-lg border px-3 py-1.5 text-sm font-medium transition-colors
                               {{ $disposisi->status_tugas === $val
                                    ? 'bg-blue-600 text-white border-blue-600'
                                    : 'border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                    {{ $label }}
                </button>
                @endforeach
            </form>
        </div>
        @endif

        {{-- Hapus (kepala_sekolah) --}}
        @if(auth()->user()->isKepsek())
        <div class="border-t border-gray-100 pt-4 mt-4">
            <form method="POST" action="{{ route('disposisi.destroy', $disposisi->id_disposisi) }}" onsubmit="return confirm('Hapus disposisi ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg border border-red-300 px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                    Hapus Disposisi
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
