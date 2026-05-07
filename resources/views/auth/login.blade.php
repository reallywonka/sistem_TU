<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Masuk — Sistem TU SMKN 1 Bojong Gede</title>
    <meta name="description" content="Halaman login Sistem Manajemen Tata Usaha SMKN 1 Bojong Gede." />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased">

<div class="flex min-h-screen">

    {{-- =========================================================
         LEFT PANEL — ilustrasi / branding
    ========================================================= --}}
    <div class="relative hidden lg:flex lg:w-1/2 items-end bg-gray-900 overflow-hidden">
        {{-- Background gradient --}}
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900 via-blue-800 to-slate-900"></div>

        {{-- Overlay pattern --}}
        <div class="absolute inset-0 opacity-10"
             style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;);"></div>

        {{-- Content --}}
        <div class="relative z-10 p-10 text-white">
            {{-- Logo --}}
            <div class="flex items-center gap-3 mb-12">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 backdrop-blur">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z"/>
                    </svg>
                </div>
                <span class="text-xl font-bold tracking-tight">Sistem Manajemen Persuratan</span>
            </div>

            {{-- Tagline --}}
            <h1 class="text-3xl font-bold leading-tight mb-3">
                Platform terpadu untuk<br/>administrasi sekolah
            </h1>
            <p class="text-blue-200 text-base leading-relaxed max-w-sm">
                Kelola surat masuk, surat keluar, disposisi, dan arsip digital secara efisien, aman, dan terstruktur.
            </p>

            {{-- Feature list --}}
            <ul class="mt-8 space-y-3 text-sm text-blue-100" aria-label="Fitur unggulan">
                @foreach([
                    'Pencatatan surat masuk & keluar digital',
                    'Disposisi cepat dari Kepala Sekolah',
                    'Arsip digital yang mudah dicari',
                    'Akses berbasis peran pengguna',
                ] as $feature)
                <li class="flex items-center gap-2">
                    <svg class="h-4 w-4 text-blue-300 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                    </svg>
                    {{ $feature }}
                </li>
                @endforeach
            </ul>
        </div>

        {{-- School name at bottom --}}
        <div class="absolute bottom-0 left-0 right-0 p-6 text-xs text-blue-300/70 text-center">
            SMKN 1 Bojong Gede — Sistem Tata Usaha Digital
        </div>
    </div>

    {{-- =========================================================
         RIGHT PANEL — form login
    ========================================================= --}}
    <div class="flex flex-1 flex-col justify-center px-6 py-12 sm:px-10 lg:px-14">
        <div class="w-full max-w-sm mx-auto">

            {{-- Mobile logo --}}
            <div class="flex items-center gap-2 mb-8 lg:hidden">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z"/>
                    </svg>
                </div>
                <span class="text-base font-bold text-gray-900">Sistem TU</span>
            </div>

            <h2 class="text-2xl font-bold text-gray-900">Selamat Datang</h2>
            <p class="mt-1 text-sm text-gray-500">
                Silakan masukkan kredensial Anda untuk melanjutkan ke dashboard.
            </p>

            {{-- Flash success (e.g. setelah logout) --}}
            @if(session('success'))
            <div role="alert"
                 class="mt-4 flex items-center gap-2 rounded-lg bg-green-50 border border-green-200 p-3 text-sm text-green-700">
                <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login.post') }}" class="mt-8 space-y-5" novalidate>
                @csrf

                {{-- Username --}}
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nama Pengguna
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                            </svg>
                        </div>
                        <input id="username"
                               type="text"
                               name="username"
                               value="{{ old('username') }}"
                               required
                               autocomplete="username"
                               placeholder="Masukkan nama pengguna"
                               class="block w-full rounded-lg border py-2.5 pl-10 pr-3 text-sm
                                      text-gray-900 placeholder-gray-400
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                      transition-colors
                                      {{ $errors->has('username') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400' }}"
                               aria-describedby="{{ $errors->has('username') ? 'username-error' : '' }}"
                               aria-invalid="{{ $errors->has('username') ? 'true' : 'false' }}" />
                    </div>
                    @error('username')
                    <p id="username-error" class="mt-1.5 text-xs text-red-600" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
                            </svg>
                        </div>
                        <input id="password"
                               type="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               placeholder="Masukkan kata sandi"
                               class="block w-full rounded-lg border py-2.5 pl-10 pr-10 text-sm
                                      text-gray-900 placeholder-gray-400
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                      transition-colors
                                      {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white hover:border-gray-400' }}"
                               aria-describedby="{{ $errors->has('password') ? 'password-error' : '' }}"
                               aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}" />
                        {{-- Toggle visibility --}}
                        <button type="button"
                                id="btn-toggle-password"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
                                aria-label="Tampilkan/sembunyikan kata sandi"
                                onclick="togglePassword()">
                            <svg id="eye-icon" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                    <p id="password-error" class="mt-1.5 text-xs text-red-600" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-2">
                    <input id="remember"
                           type="checkbox"
                           name="remember"
                           class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" />
                    <label for="remember" class="text-sm text-gray-600 cursor-pointer">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        id="btn-login"
                        class="flex w-full items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5
                               text-sm font-semibold text-white shadow-sm
                               hover:bg-blue-700 active:bg-blue-800
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                               transition-colors">
                    Masuk Sistem
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </button>
            </form>

            {{-- Footer help --}}
            <p class="mt-8 text-center text-xs text-gray-400">
                Mengalami kendala teknis?
                <a href="#" class="text-blue-600 hover:underline">Hubungi Admin</a>
            </p>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eye-icon');

        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/>`;
        } else {
            input.type = 'password';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>`;
        }
    }
</script>
</body>
</html>
