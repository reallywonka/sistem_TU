@extends('layouts.app')
@section('title', 'Kelola User')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Kelola Pengguna</h1>
        <p class="mt-0.5 text-sm text-gray-500">Kelola akun pengguna sistem.</p>
    </div>
    <a href="{{ route('users.create') }}" id="btn-tambah-user"
       class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors shadow-sm">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Tambah Pengguna
    </a>
</div>

<div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
    @if($users->isEmpty())
    <div class="flex flex-col items-center justify-center py-16 text-gray-400">
        <p class="text-sm">Belum ada pengguna.</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">No</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama Lengkap</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Username</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Role</th>
                    <th class="px-5 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @foreach($users as $i => $u)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-3.5 text-sm text-gray-400">{{ $users->firstItem() + $i }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-blue-700 font-semibold text-xs select-none">
                                {{ strtoupper(substr($u->nama_lengkap, 0, 2)) }}
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $u->nama_lengkap }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-sm font-mono text-gray-600">{{ $u->username }}</td>
                    <td class="px-5 py-3.5">
                        @if($u->role === 'admin_tu')
                        <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700">Admin TU</span>
                        @else
                        <span class="inline-flex rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700">Kepala Sekolah</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-right whitespace-nowrap">
                        <div class="inline-flex items-center gap-1">
                            <a href="{{ route('users.edit', $u->id_user) }}"
                               class="rounded-md p-1.5 text-gray-400 hover:bg-gray-100 hover:text-blue-600 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/></svg>
                            </a>
                            @if(auth()->user()->id_user !== $u->id_user)
                            <form method="POST" action="{{ route('users.destroy', $u->id_user) }}" onsubmit="return confirm('Hapus pengguna ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="rounded-md p-1.5 text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors">
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
        <span>{{ $users->total() }} pengguna terdaftar</span>
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
