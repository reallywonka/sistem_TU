@extends('layouts.app')
@section('title', 'Edit Surat Keluar')

@section('content')
<div class="mb-6">
    <nav class="flex items-center gap-1 text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
        <a href="{{ route('surat-keluar.index') }}" class="hover:text-blue-600 transition-colors">Surat Keluar</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
        <span class="text-gray-900 font-medium">Edit</span>
    </nav>
    <h1 class="text-2xl font-bold text-gray-900">Edit Surat Keluar</h1>
    <p class="mt-0.5 text-sm text-gray-500">Perbarui data surat keluar <span class="font-medium">{{ $suratKeluar->nomor_surat }}</span>.</p>
</div>

<form method="POST" action="{{ route('surat-keluar.update', $suratKeluar->id_surat_keluar) }}" enctype="multipart/form-data" novalidate>
    @csrf @method('PUT')
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm p-6 mb-6">
        <h2 class="text-base font-semibold text-gray-900 mb-5">Detail Surat</h2>
        @include('surat-keluar._form')
    </div>
    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('surat-keluar.show', $suratKeluar->id_surat_keluar) }}" class="rounded-lg border border-gray-300 px-5 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">Batal</a>
        <button type="submit" id="btn-update-surat-keluar" class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors shadow-sm">Simpan Perubahan</button>
    </div>
</form>
@endsection
