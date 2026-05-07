@extends('layouts.app')
@section('title', 'Tambah Surat Masuk')

@section('content')
<div class="mb-6">
    <nav class="flex items-center gap-1 text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
        <a href="{{ route('surat-masuk.index') }}" class="hover:text-blue-600 transition-colors">Surat Masuk</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
        <span class="text-gray-900 font-medium">Tambah Baru</span>
    </nav>
    <h1 class="text-2xl font-bold text-gray-900">Tambah Surat Masuk</h1>
    <p class="mt-0.5 text-sm text-gray-500">Silakan isi formulir di bawah ini untuk mencatat surat masuk baru.</p>
</div>

<form method="POST" action="{{ route('surat-masuk.store') }}" enctype="multipart/form-data" novalidate>
    @csrf
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm p-6 mb-6">
        <h2 class="text-base font-semibold text-gray-900 mb-5 flex items-center gap-2">
            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
            Form Surat Masuk
        </h2>
        @include('surat-masuk._form')
    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('surat-masuk.index') }}"
           class="rounded-lg border border-gray-300 px-5 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
            Batal
        </a>
        <button type="submit" id="btn-simpan-surat-masuk"
                class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors shadow-sm">
            Simpan
        </button>
    </div>
</form>
@endsection
