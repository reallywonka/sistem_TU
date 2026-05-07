@extends('layouts.app')
@section('title', 'Kelola Laporan')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Kelola Laporan</h1>
        <p class="mt-0.5 text-sm text-gray-500">Rekapitulasi surat dan disposisi per periode.</p>
    </div>
    <a href="{{ route('laporan.export', request()->query()) }}"
       class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
        Export
    </a>
</div>

{{-- Filter periode --}}
<div class="rounded-xl border border-gray-200 bg-white shadow-sm p-4 mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div>
            <label for="bulan" class="block text-xs font-medium text-gray-600 mb-1">Bulan</label>
            <select id="bulan" name="bulan" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                @foreach(range(1,12) as $m)
                <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="tahun" class="block text-xs font-medium text-gray-600 mb-1">Tahun</label>
            <select id="tahun" name="tahun" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                @foreach(range(now()->year, now()->year - 4) as $y)
                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">Tampilkan</button>
    </form>
</div>

{{-- Stat cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['label' => 'Surat Masuk', 'value' => $totalMasuk, 'color' => 'blue'],
        ['label' => 'Surat Keluar', 'value' => $totalKeluar, 'color' => 'purple'],
        ['label' => 'Total Disposisi', 'value' => $totalDisp, 'color' => 'orange'],
        ['label' => 'Disposisi Selesai', 'value' => $dispSelesai, 'color' => 'green'],
    ] as $stat)
    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <p class="text-sm font-medium text-gray-500">{{ $stat['label'] }}</p>
        <p class="mt-1.5 text-3xl font-bold text-gray-900">{{ $stat['value'] }}</p>
    </div>
    @endforeach
</div>

{{-- Tabel surat masuk periode ini --}}
<div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden mb-5">
    <div class="px-5 py-4 border-b border-gray-100">
        <h2 class="text-base font-semibold text-gray-900">Surat Masuk — Periode Ini</h2>
    </div>
    @if($suratMasuks->isEmpty())
    <p class="px-5 py-6 text-sm text-gray-400 text-center">Tidak ada data.</p>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nomor Surat</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Perihal</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Asal</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @foreach($suratMasuks as $s)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 text-sm font-mono text-gray-600">{{ $s->nomor_surat }}</td>
                    <td class="px-5 py-3 text-sm text-gray-900 max-w-xs truncate">{{ $s->perihal }}</td>
                    <td class="px-5 py-3 text-sm text-gray-500">{{ $s->asal_surat }}</td>
                    <td class="px-5 py-3 text-sm text-gray-500">{{ $s->tgl_surat->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

{{-- Tabel surat keluar --}}
<div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100">
        <h2 class="text-base font-semibold text-gray-900">Surat Keluar — Periode Ini</h2>
    </div>
    @if($suratKeluars->isEmpty())
    <p class="px-5 py-6 text-sm text-gray-400 text-center">Tidak ada data.</p>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nomor Surat</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Perihal</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tujuan</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @foreach($suratKeluars as $s)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 text-sm font-mono text-gray-600">{{ $s->nomor_surat }}</td>
                    <td class="px-5 py-3 text-sm text-gray-900 max-w-xs truncate">{{ $s->perihal }}</td>
                    <td class="px-5 py-3 text-sm text-gray-500">{{ $s->tujuan_surat }}</td>
                    <td class="px-5 py-3 text-sm text-gray-500">{{ $s->tgl_surat->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
