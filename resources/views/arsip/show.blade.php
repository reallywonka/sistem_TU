@extends('layouts.app')
@section('title', 'Detail Arsip')

@section('content')
<div class="mb-6">
    <nav class="flex items-center gap-1 text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
        <a href="{{ route('arsip.index') }}" class="hover:text-blue-600 transition-colors">Cari Arsip</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
        <span class="text-gray-900 font-medium">Detail</span>
    </nav>
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $arsip->perihal }}</h1>
            <p class="mt-1 text-sm text-gray-500 flex items-center gap-2">
                <span class="font-mono">{{ $arsip->nomor_surat }}</span>
                &mdash;
                @if($type === 'masuk')
                <span class="inline-flex rounded-full bg-blue-50 px-2 py-0.5 text-xs font-medium text-blue-700">Surat Masuk</span>
                @else
                <span class="inline-flex rounded-full bg-purple-50 px-2 py-0.5 text-xs font-medium text-purple-700">Surat Keluar</span>
                @endif
            </p>
        </div>
        @if($arsip->file_pdf)
        <a href="{{ route('arsip.download', [$type, $arsip->id_surat_masuk ?? $arsip->id_surat_keluar]) }}"
           class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
            Unduh
        </a>
        @endif
    </div>
</div>

<div class="rounded-xl border border-gray-200 bg-white shadow-sm p-6">
    <dl class="grid grid-cols-1 gap-y-4 sm:grid-cols-2">
        <div>
            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nomor Surat</dt>
            <dd class="mt-1 text-sm font-mono text-gray-900">{{ $arsip->nomor_surat }}</dd>
        </div>
        <div>
            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kategori</dt>
            <dd class="mt-1">
                <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-700">
                    {{ $arsip->kategori->nama_kategori ?? '—' }}
                </span>
            </dd>
        </div>
        <div>
            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tanggal Surat</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $arsip->tgl_surat->translatedFormat('d F Y') }}</dd>
        </div>
        <div>
            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">
                {{ $type === 'masuk' ? 'Asal Surat' : 'Tujuan Surat' }}
            </dt>
            <dd class="mt-1 text-sm text-gray-900">
                {{ $type === 'masuk' ? ($arsip->asal_surat ?? '—') : ($arsip->tujuan_surat ?? '—') }}
            </dd>
        </div>
        @if($type === 'masuk' && $arsip->tgl_diterima)
        <div>
            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Tanggal Diterima</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $arsip->tgl_diterima->translatedFormat('d F Y') }}</dd>
        </div>
        @endif
        <div class="sm:col-span-2">
            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Perihal</dt>
            <dd class="mt-1 text-sm text-gray-900 leading-relaxed">{{ $arsip->perihal }}</dd>
        </div>
    </dl>
</div>

@if($arsip->file_pdf)
<div class="mt-6 rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
    <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
        <h2 class="text-base font-semibold text-gray-900">Preview Dokumen</h2>
    </div>
    <div class="w-full h-[800px] bg-gray-100">
        <iframe src="{{ asset('storage/' . $arsip->file_pdf) }}" class="w-full h-full border-0"></iframe>
    </div>
</div>
@endif

@endsection
