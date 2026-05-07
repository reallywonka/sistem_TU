@extends('layouts.app')
@section('title', 'Surat Masuk')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Surat Masuk</h1>
        <p class="mt-0.5 text-sm text-gray-500">Daftar semua surat yang diterima.</p>
    </div>
    @if(auth()->user()->isAdminTU())
    <a href="{{ route('surat-masuk.create') }}" id="btn-tambah-surat-masuk"
       class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors shadow-sm">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Tambah Surat
    </a>
    @endif
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('surat-masuk.index') }}" class="mb-4 flex flex-wrap gap-3 items-end">
    <div class="flex-1 min-w-48">
        <label for="filter-q" class="sr-only">Cari</label>
        <input id="filter-q" type="search" name="q" value="{{ request('q') }}" placeholder="Cari nomor/perihal/asal..."
               class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"/>
    </div>
    <div>
        <label for="filter-kategori" class="sr-only">Kategori</label>
        <select id="filter-kategori" name="kategori" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
            <option value="">Semua Kategori</option>
            @foreach($kategoris as $k)
            <option value="{{ $k->id_kategori }}" {{ request('kategori') == $k->id_kategori ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex gap-2">
        <input type="date" name="dari" value="{{ request('dari') }}" class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none"/>
        <span class="self-center text-gray-400 text-sm">s/d</span>
        <input type="date" name="sampai" value="{{ request('sampai') }}" class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none"/>
    </div>
    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">Cari</button>
    @if(request()->hasAny(['q','kategori','dari','sampai']))
    <a href="{{ route('surat-masuk.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50 transition-colors">Reset</a>
    @endif
</form>

{{-- Tabel --}}
<div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
    @if($suratMasuks->isEmpty())
    <div class="flex flex-col items-center justify-center py-16 text-gray-400">
        <svg class="h-12 w-12 mb-3" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z"/></svg>
        <p class="text-sm">Belum ada surat masuk.</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">No</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nomor Surat</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Asal Surat</th>
                    <th class="hidden md:table-cell px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Perihal</th>
                    <th class="hidden sm:table-cell px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal</th>
                    <th class="hidden lg:table-cell px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Kategori</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @foreach($suratMasuks as $i => $s)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3.5 text-sm text-gray-400">{{ $suratMasuks->firstItem() + $i }}</td>
                    <td class="px-5 py-3.5 text-sm font-mono text-gray-700 whitespace-nowrap">{{ $s->nomor_surat }}</td>
                    <td class="px-5 py-3.5 text-sm text-gray-700">{{ $s->asal_surat }}</td>
                    <td class="hidden md:table-cell px-5 py-3.5 text-sm text-gray-700 max-w-xs truncate">{{ $s->perihal }}</td>
                    <td class="hidden sm:table-cell px-5 py-3.5 text-sm text-gray-500 whitespace-nowrap">{{ $s->tgl_surat->format('d/m/Y') }}</td>
                    <td class="hidden lg:table-cell px-5 py-3.5">
                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700">{{ $s->kategori->nama_kategori ?? '—' }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-right whitespace-nowrap">
                        <div class="inline-flex items-center gap-1">
                            <a href="{{ route('surat-masuk.show', $s->id_surat_masuk) }}" title="Lihat detail"
                               class="rounded-md p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            </a>
                            @if(auth()->user()->isAdminTU())
                            <a href="{{ route('surat-masuk.edit', $s->id_surat_masuk) }}" title="Edit"
                               class="rounded-md p-1.5 text-gray-400 hover:bg-gray-100 hover:text-blue-600 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125"/></svg>
                            </a>
                            <form method="POST" action="{{ route('surat-masuk.destroy', $s->id_surat_masuk) }}" onsubmit="return confirm('Hapus surat ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Hapus" class="rounded-md p-1.5 text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex items-center justify-between px-5 py-3 border-t border-gray-100 bg-gray-50 text-sm text-gray-500">
        <span>Menampilkan {{ $suratMasuks->firstItem() }} – {{ $suratMasuks->lastItem() }} dari {{ $suratMasuks->total() }} entri</span>
        {{ $suratMasuks->links() }}
    </div>
    @endif
</div>
@endsection
