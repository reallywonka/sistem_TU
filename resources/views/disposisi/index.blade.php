@extends('layouts.app')
@section('title', 'Disposisi Digital')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Disposisi Digital</h1>
        <p class="mt-0.5 text-sm text-gray-500">Daftar disposisi dari Kepala Sekolah.</p>
    </div>
</div>

<form method="GET" class="mb-4 flex flex-wrap gap-3">
    <select name="status" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
        <option value="">Semua Status</option>
        <option value="belum_dibaca" {{ request('status') == 'belum_dibaca' ? 'selected' : '' }}>Belum Dibaca</option>
        <option value="sedang_diproses" {{ request('status') == 'sedang_diproses' ? 'selected' : '' }}>Sedang Diproses</option>
        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
    </select>
    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">Filter</button>
</form>

<div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
    @if($disposisis->isEmpty())
    <div class="flex flex-col items-center justify-center py-16 text-gray-400">
        <svg class="h-12 w-12 mb-3" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/></svg>
        <p class="text-sm">Belum ada disposisi.</p>
        @if(auth()->user()->isKepsek())
        <p class="text-xs text-gray-400 mt-1">Buka detail Surat Masuk untuk membuat disposisi.</p>
        @endif
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">No</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Surat</th>
                    <th class="hidden md:table-cell px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Instruksi</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                    <th class="hidden sm:table-cell px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @foreach($disposisis as $i => $d)
                @php
                    $colorMap = ['belum_dibaca'=>['bg'=>'bg-red-50','text'=>'text-red-700'], 'sedang_diproses'=>['bg'=>'bg-yellow-50','text'=>'text-yellow-700'], 'selesai'=>['bg'=>'bg-green-50','text'=>'text-green-700']];
                    $c = $colorMap[$d->status_tugas] ?? ['bg'=>'bg-gray-50','text'=>'text-gray-700'];
                @endphp
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3.5 text-sm text-gray-400">{{ $disposisis->firstItem() + $i }}</td>
                    <td class="px-5 py-3.5">
                        <p class="text-sm font-medium text-gray-900">{{ $d->suratMasuk->perihal ?? '—' }}</p>
                        <p class="text-xs text-gray-400 font-mono">{{ $d->suratMasuk->nomor_surat ?? '—' }}</p>
                    </td>
                    <td class="hidden md:table-cell px-5 py-3.5 text-sm text-gray-700 max-w-xs truncate">{{ $d->instruksi }}</td>
                    <td class="px-5 py-3.5">
                        <span class="inline-flex items-center rounded-full {{ $c['bg'] }} px-2.5 py-0.5 text-xs font-medium {{ $c['text'] }}">
                            {{ $d->status_label }}
                        </span>
                    </td>
                    <td class="hidden sm:table-cell px-5 py-3.5 text-sm text-gray-500 whitespace-nowrap">
                        {{ $d->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <a href="{{ route('disposisi.show', $d->id_disposisi) }}"
                           class="rounded-md p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition-colors inline-block">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex items-center justify-between px-5 py-3 border-t border-gray-100 bg-gray-50 text-sm text-gray-500">
        <span>Menampilkan {{ $disposisis->firstItem() }} – {{ $disposisis->lastItem() }} dari {{ $disposisis->total() }} entri</span>
        {{ $disposisis->links() }}
    </div>
    @endif
</div>
@endsection
