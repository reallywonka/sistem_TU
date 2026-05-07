@extends('layouts.app')
@section('title', 'Tambah Pengguna')

@section('content')
<div class="mb-6">
    <nav class="flex items-center gap-1 text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
        <a href="{{ route('users.index') }}" class="hover:text-blue-600 transition-colors">Kelola Pengguna</a>
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
        <span class="text-gray-900 font-medium">Tambah Baru</span>
    </nav>
    <h1 class="text-2xl font-bold text-gray-900">Tambah Pengguna</h1>
</div>

<form method="POST" action="{{ route('users.store') }}" novalidate>
    @csrf
    <div class="rounded-xl border border-gray-200 bg-white shadow-sm p-6 mb-6">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

            <div class="sm:col-span-2">
                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input id="nama_lengkap" type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                       class="block w-full rounded-lg border px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                              {{ $errors->has('nama_lengkap') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400' }}" />
                @error('nama_lengkap')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1.5">Username <span class="text-red-500">*</span></label>
                <input id="username" type="text" name="username" value="{{ old('username') }}" required autocomplete="off"
                       class="block w-full rounded-lg border px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                              {{ $errors->has('username') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400' }}" />
                @error('username')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1.5">Role <span class="text-red-500">*</span></label>
                <select id="role" name="role" required
                        class="block w-full rounded-lg border px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                               {{ $errors->has('role') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400' }}">
                    <option value="">Pilih role...</option>
                    <option value="admin_tu" {{ old('role') === 'admin_tu' ? 'selected' : '' }}>Admin TU</option>
                    <option value="kepala_sekolah" {{ old('role') === 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                </select>
                @error('role')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Kata Sandi <span class="text-red-500">*</span></label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       class="block w-full rounded-lg border px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                              {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400' }}" />
                @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Kata Sandi <span class="text-red-500">*</span></label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="block w-full rounded-lg border px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors border-gray-300 bg-white hover:border-gray-400" />
            </div>

        </div>
    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('users.index') }}" class="rounded-lg border border-gray-300 px-5 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">Batal</a>
        <button type="submit" id="btn-simpan-user" class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors shadow-sm">Simpan</button>
    </div>
</form>
@endsection
