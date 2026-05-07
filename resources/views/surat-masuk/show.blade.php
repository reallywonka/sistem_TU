@extends('layouts.app')
@section('title', 'Detail Surat Masuk')

@section('content')
<div class="mb-6">
    <nav class="flex items-center gap-1 text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
        <a href="{{ route('surat-masuk.index') }}" class="hover:text-blue-600 transition-colors">Surat Masuk</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
        <span class="text-gray-900 font-medium">Detail</span>
    </nav>
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $suratMasuk->perihal }}</h1>
            <p class="mt-1 text-sm text-gray-500">{{ $suratMasuk->nomor_surat }} &mdash; {{ $suratMasuk->asal_surat }}</p>
        </div>
        <div class="flex items-center gap-2 ml-4">
            @if($suratMasuk->file_pdf)
            <a href="{{ route('surat-masuk.download', $suratMasuk->id_surat_masuk) }}"
               class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                Unduh PDF
            </a>
            @endif
            @if(auth()->user()->isAdminTU())
            <a href="{{ route('surat-masuk.edit', $suratMasuk->id_surat_masuk) }}"
               class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/></svg>
                Edit
            </a>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Info surat --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm p-6">
            <h2 class="text-base font-semibold text-gray-900 mb-4">Informasi Surat</h2>
            <dl class="grid grid-cols-1 gap-y-4 sm:grid-cols-2">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nomor Surat</dt>
                    <dd class="mt-1 text-sm font-mono text-gray-900">{{ $suratMasuk->nomor_surat }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kategori</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700">
                            {{ $suratMasuk->kategori->nama_kategori ?? '—' }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tanggal Surat</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $suratMasuk->tgl_surat->translatedFormat('d F Y') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tanggal Diterima</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $suratMasuk->tgl_diterima->translatedFormat('d F Y') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Asal Surat</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $suratMasuk->asal_surat }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">File</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $suratMasuk->file_pdf ? 'Ada (PDF)' : 'Tidak ada' }}
                    </dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Perihal</dt>
                    <dd class="mt-1 text-sm text-gray-900 leading-relaxed">{{ $suratMasuk->perihal }}</dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- Disposisi panel --}}
    <div class="space-y-4">

        {{-- Disposisi yang ada --}}
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm p-5">
            <h2 class="text-base font-semibold text-gray-900 mb-3">Status Disposisi</h2>

            @if($suratMasuk->disposisi)
            @php $d = $suratMasuk->disposisi; @endphp
            <div class="space-y-3 text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-gray-500">Status</span>
                    @php $colors = ['belum_dibaca'=>'red','sedang_diproses'=>'yellow','selesai'=>'green']; $c = $colors[$d->status_tugas] ?? 'gray'; @endphp
                    <span class="inline-flex items-center rounded-full bg-{{ $c }}-50 px-2.5 py-0.5 text-xs font-medium text-{{ $c }}-700">
                        {{ $d->status_label }}
                    </span>
                </div>
                <div>
                    <span class="text-gray-500 block mb-1">Instruksi</span>
                    <p class="text-gray-900 text-xs leading-relaxed bg-gray-50 rounded-lg p-2">{{ $d->instruksi }}</p>
                </div>
            </div>
            @else
            <p class="text-sm text-gray-400">Belum ada disposisi untuk surat ini.</p>
            @endif
        </div>

        {{-- Form disposisi (kepala_sekolah) --}}
        @if(auth()->user()->isKepsek() && !$suratMasuk->disposisi)
        <div class="rounded-xl border border-blue-200 bg-blue-50 shadow-sm p-5">
            <h2 class="text-base font-semibold text-gray-900 mb-4">
                <svg class="inline h-4 w-4 text-blue-600 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/></svg>
                Buat Disposisi
            </h2>
            <form method="POST" action="{{ route('disposisi.store') }}" novalidate>
                @csrf
                <input type="hidden" name="id_surat_masuk" value="{{ $suratMasuk->id_surat_masuk }}"/>
                <div class="space-y-3">
                    <div>
                        <label for="id_penerima" class="block text-xs font-medium text-gray-700 mb-1">Teruskan Kepada <span class="text-red-500">*</span></label>
                        <select id="id_penerima" name="id_penerima" required
                                class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                            <option value="">Pilih penerima...</option>
                            @foreach(\App\Models\User::where('role','admin_tu')->orderBy('nama_lengkap')->get() as $u)
                            <option value="{{ $u->id_user }}">{{ $u->nama_lengkap }}</option>
                            @endforeach
                        </select>
                        @error('id_penerima')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="instruksi" class="block text-xs font-medium text-gray-700 mb-1">Instruksi <span class="text-red-500">*</span></label>
                        <textarea id="instruksi" name="instruksi" rows="3" required
                                  placeholder="Ketik instruksi detail di sini..."
                                  class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none resize-none">{{ old('instruksi') }}</textarea>
                        @error('instruksi')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" id="btn-kirim-disposisi"
                            class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/></svg>
                        Kirim Disposisi
                    </button>
                </div>
            </form>
        </div>
        @endif

    </div>
</div>
@endsection
