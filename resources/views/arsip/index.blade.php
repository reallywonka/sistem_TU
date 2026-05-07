@extends('layouts.app')
@section('title', 'Cari Arsip')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Cari Arsip</h1>
    <p class="mt-0.5 text-sm text-gray-500">Saring dan temukan korespondensi sekolah tertentu.</p>
</div>

{{-- Filter --}}
<div class="rounded-xl border border-gray-200 bg-white shadow-sm p-4 mb-5">
    <form method="GET" action="{{ route('arsip.index') }}" class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-48">
            <label for="arsip-q" class="sr-only">Pencarian</label>
            <input id="arsip-q" type="search" name="q" value="{{ request('q') }}"
                   placeholder="Nomor Surat, Perihal..."
                   class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"/>
        </div>
        <div>
            <label for="arsip-dari" class="sr-only">Tanggal Mulai</label>
            <input id="arsip-dari" type="date" name="dari" value="{{ request('dari') }}"
                   class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none"/>
        </div>
        <div>
            <label for="arsip-sampai" class="sr-only">Tanggal Akhir</label>
            <input id="arsip-sampai" type="date" name="sampai" value="{{ request('sampai') }}"
                   class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none"/>
        </div>
        <div>
            <label for="arsip-kategori" class="sr-only">Kategori</label>
            <select id="arsip-kategori" name="kategori" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                <option value="">Semua</option>
                @foreach($kategoris as $k)
                <option value="{{ $k->id_kategori }}" {{ request('kategori') == $k->id_kategori ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <select name="tipe" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                <option value="">Semua Tipe</option>
                <option value="masuk" {{ request('tipe') == 'masuk' ? 'selected' : '' }}>Surat Masuk</option>
                <option value="keluar" {{ request('tipe') == 'keluar' ? 'selected' : '' }}>Surat Keluar</option>
            </select>
        </div>
        <button type="submit" id="btn-cari-arsip"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
            Cari
        </button>
    </form>
</div>

{{-- Tabel --}}
<div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
    @if($items->isEmpty())
    <div class="flex flex-col items-center justify-center py-16 text-gray-400">
        <svg class="h-12 w-12 mb-3" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
        <p class="text-sm">Tidak ada hasil yang ditemukan.</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">No</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nomor Surat</th>
                    <th class="hidden sm:table-cell px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal</th>
                    <th class="hidden md:table-cell px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Asal/Tujuan</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Perihal</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Tipe</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @foreach($items as $i => $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3.5 text-sm text-gray-400">{{ ($page - 1) * $perPage + $i + 1 }}</td>
                    <td class="px-5 py-3.5 text-sm font-mono text-gray-600 whitespace-nowrap">{{ $item['nomor_surat'] }}</td>
                    <td class="hidden sm:table-cell px-5 py-3.5 text-sm text-gray-500 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($item['tgl_surat'])->format('d M Y') }}
                    </td>
                    <td class="hidden md:table-cell px-5 py-3.5 text-sm text-gray-500">{{ $item['pihak'] }}</td>
                    <td class="px-5 py-3.5 text-sm font-medium text-gray-900 max-w-xs truncate">{{ $item['perihal'] }}</td>
                    <td class="px-5 py-3.5">
                        @if($item['tipe'] === 'masuk')
                        <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700">Masuk</span>
                        @else
                        <span class="inline-flex rounded-full bg-purple-50 px-2.5 py-0.5 text-xs font-medium text-purple-700">Keluar</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-right whitespace-nowrap">
                        <div class="inline-flex items-center gap-1">
                            <a href="{{ route('arsip.show', [$item['tipe'], $item['id']]) }}"
                               class="rounded-md p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            </a>
                            @if($item['file_pdf'])
                            <a href="{{ route('arsip.download', [$item['tipe'], $item['id']]) }}"
                               class="rounded-md p-1.5 text-gray-400 hover:bg-gray-100 hover:text-blue-600 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination manual --}}
    <div class="flex items-center justify-between px-5 py-3 border-t border-gray-100 bg-gray-50 text-sm text-gray-500">
        <span>Menampilkan {{ ($page - 1) * $perPage + 1 }} hingga {{ min($page * $perPage, $total) }} dari {{ $total }} entri</span>
        <div class="flex items-center gap-1">
            @if($page > 1)
            <a href="{{ request()->fullUrlWithQuery(['page' => $page - 1]) }}"
               class="rounded-md px-3 py-1 border border-gray-300 text-gray-600 hover:bg-gray-100 transition-colors">Sebelumnya</a>
            @endif
            @php $totalPages = ceil($total / $perPage); @endphp
            @for($p = max(1, $page - 2); $p <= min($totalPages, $page + 2); $p++)
            <a href="{{ request()->fullUrlWithQuery(['page' => $p]) }}"
               class="rounded-md px-3 py-1 border transition-colors
                      {{ $p == $page ? 'bg-blue-600 text-white border-blue-600' : 'border-gray-300 text-gray-600 hover:bg-gray-100' }}">
                {{ $p }}
            </a>
            @endfor
            @if($page < $totalPages)
            <a href="{{ request()->fullUrlWithQuery(['page' => $page + 1]) }}"
               class="rounded-md px-3 py-1 border border-gray-300 text-gray-600 hover:bg-gray-100 transition-colors">Selanjutnya</a>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
