@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- Page header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Overview</h1>
        <p class="mt-0.5 text-sm text-gray-500">Ringkasan aktivitas dan data persuratan.</p>
    </div>
    @if(auth()->user()->isAdminTU())
    <a href="{{ route('surat-masuk.create') }}"
       id="btn-new-entry"
       class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold
              text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
              transition-colors shadow-sm">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Entri Baru
    </a>
    @endif
</div>

{{-- =========================================================
     STATISTIK CARDS
========================================================= --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">

    {{-- Surat Masuk --}}
    <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Surat Masuk</p>
                <p class="mt-1.5 text-3xl font-bold text-gray-900">{{ number_format($totalSuratMasuk) }}</p>
            </div>
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z"/>
                </svg>
            </div>
        </div>
        <p class="mt-3 text-xs text-gray-400">Jumlah surat yang diterima</p>
    </article>

    {{-- Surat Keluar --}}
    <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Surat Keluar</p>
                <p class="mt-1.5 text-3xl font-bold text-gray-900">{{ number_format($totalSuratKeluar) }}</p>
            </div>
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-50 text-purple-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/>
                </svg>
            </div>
        </div>
        <p class="mt-3 text-xs text-gray-400">Jumlah surat yang dikirim</p>
    </article>

    {{-- Disposisi --}}
    <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Disposisi</p>
                <p class="mt-1.5 text-3xl font-bold text-gray-900">{{ number_format($totalDisposisi) }}</p>
            </div>
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-50 text-orange-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/>
                </svg>
            </div>
        </div>
        <p class="mt-3 text-xs text-gray-400">Total disposisi dibuat</p>
    </article>

    {{-- Pending Disposisi --}}
    <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Pending Disposisi</p>
                <p class="mt-1.5 text-3xl font-bold {{ $pendingDisposisi > 0 ? 'text-red-600' : 'text-gray-900' }}">
                    {{ number_format($pendingDisposisi) }}
                </p>
            </div>
            <div class="flex h-10 w-10 items-center justify-center rounded-lg {{ $pendingDisposisi > 0 ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    @if($pendingDisposisi > 0)
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                    @else
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    @endif
                </svg>
            </div>
        </div>
        <p class="mt-3 text-xs {{ $pendingDisposisi > 0 ? 'text-red-400' : 'text-gray-400' }}">
            {{ $pendingDisposisi > 0 ? 'Memerlukan perhatian' : 'Semua sudah diproses' }}
        </p>
    </article>

</div>

{{-- =========================================================
     AKTIVITAS TERBARU
========================================================= --}}
<div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
        <h2 class="text-base font-semibold text-gray-900">Aktivitas Terbaru</h2>
        <a href="{{ route('arsip.index') }}"
           class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline transition-colors">
            Lihat Semua
        </a>
    </div>

    @if($aktivitasTerbaru->isEmpty())
    <div class="flex flex-col items-center justify-center py-12 text-gray-400">
        <svg class="h-12 w-12 mb-3" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
        </svg>
        <p class="text-sm">Belum ada aktivitas.</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100" aria-label="Tabel aktivitas terbaru">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">ID</th>
                    <th scope="col" class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Perihal</th>
                    <th scope="col" class="hidden md:table-cell px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Asal / Tujuan</th>
                    <th scope="col" class="hidden sm:table-cell px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal</th>
                    <th scope="col" class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Tipe</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @foreach($aktivitasTerbaru as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3.5 text-xs text-gray-400 font-mono whitespace-nowrap">
                        #{{ $item['nomor_surat'] }}
                    </td>
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900">
                        {{ $item['perihal'] }}
                    </td>
                    <td class="hidden md:table-cell px-5 py-3.5 text-sm text-gray-500">
                        {{ $item['tipe'] === 'masuk' ? ($item['asal_surat'] ?? '—') : ($item['tujuan_surat'] ?? '—') }}
                    </td>
                    <td class="hidden sm:table-cell px-5 py-3.5 text-sm text-gray-500 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($item['tgl_surat'])->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-5 py-3.5">
                        @if($item['tipe'] === 'masuk')
                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">
                            Masuk
                        </span>
                        @else
                        <span class="inline-flex items-center rounded-full bg-purple-50 px-2.5 py-0.5 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-600/20">
                            Keluar
                        </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

@endsection
