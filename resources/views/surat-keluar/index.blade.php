@extends('layouts.app')
@section('title', 'Surat Keluar')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Surat Keluar</h1>
        <p class="mt-0.5 text-sm text-gray-500">Daftar semua surat yang dikirim.</p>
    </div>
    <a href="{{ route('surat-keluar.create') }}" id="btn-tambah-surat-keluar"
       class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors shadow-sm">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Tambah Surat
    </a>
</div>

<form method="GET" action="{{ route('surat-keluar.index') }}" class="mb-4 flex flex-wrap gap-3 items-end">
    <div class="flex-1 min-w-48">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nomor/perihal/tujuan..."
               class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500"/>
    </div>
    <select name="kategori" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
        <option value="">Semua Kategori</option>
        @foreach($kategoris as $k)
        <option value="{{ $k->id_kategori }}" {{ request('kategori') == $k->id_kategori ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
        @endforeach
    </select>
    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">Cari</button>
    @if(request()->hasAny(['q','kategori']))
    <a href="{{ route('surat-keluar.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">Reset</a>
    @endif
</form>

<div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
    @if($suratKeluars->isEmpty())
    <div class="flex flex-col items-center justify-center py-16 text-gray-400">
        <svg class="h-12 w-12 mb-3" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/></svg>
        <p class="text-sm">Belum ada surat keluar.</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">No</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nomor Surat</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Tujuan</th>
                    <th class="hidden md:table-cell px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Perihal</th>
                    <th class="hidden sm:table-cell px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @foreach($suratKeluars as $i => $s)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3.5 text-sm text-gray-400">{{ $suratKeluars->firstItem() + $i }}</td>
                    <td class="px-5 py-3.5 text-sm font-mono text-gray-700 whitespace-nowrap">{{ $s->nomor_surat }}</td>
                    <td class="px-5 py-3.5 text-sm text-gray-700">{{ $s->tujuan_surat }}</td>
                    <td class="hidden md:table-cell px-5 py-3.5 text-sm text-gray-700 max-w-xs truncate">{{ $s->perihal }}</td>
                    <td class="hidden sm:table-cell px-5 py-3.5 text-sm text-gray-500 whitespace-nowrap">{{ $s->tgl_surat->format('d/m/Y') }}</td>
                    <td class="px-5 py-3.5 text-right whitespace-nowrap">
                        <div class="inline-flex items-center gap-1">
                            <a href="{{ route('surat-keluar.show', $s->id_surat_keluar) }}" title="Lihat"
                               class="rounded-md p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            </a>
                            <a href="{{ route('surat-keluar.edit', $s->id_surat_keluar) }}" title="Edit"
                               class="rounded-md p-1.5 text-gray-400 hover:bg-gray-100 hover:text-blue-600 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('surat-keluar.destroy', $s->id_surat_keluar) }}" onsubmit="return confirm('Hapus surat ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Hapus" class="rounded-md p-1.5 text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex items-center justify-between px-5 py-3 border-t border-gray-100 bg-gray-50 text-sm text-gray-500">
        <span>Menampilkan {{ $suratKeluars->firstItem() }} – {{ $suratKeluars->lastItem() }} dari {{ $suratKeluars->total() }} entri</span>
        {{ $suratKeluars->links() }}
    </div>
    @endif
</div>
@endsection
