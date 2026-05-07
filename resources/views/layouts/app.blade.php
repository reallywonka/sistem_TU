<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Dashboard') — Sistem TU SMKN 1 Bojong Gede</title>
    <meta name="description" content="Sistem Manajemen Tata Usaha SMKN 1 Bojong Gede — digitalisasi surat masuk, surat keluar, disposisi, dan arsip digital." />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased">

<div class="flex h-screen overflow-hidden bg-gray-50">

    {{-- =========================================================
         SIDEBAR
    ========================================================= --}}
    <aside id="sidebar"
           class="fixed inset-y-0 left-0 z-50 flex w-56 flex-col bg-white border-r border-gray-200
                  transition-transform duration-300 lg:static lg:translate-x-0
                  -translate-x-full"
           aria-label="Navigasi Utama">

        {{-- Logo --}}
        <div class="flex items-center gap-2 px-5 py-5 border-b border-gray-100">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600">
                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 7.5L7.5 3h9L21 7.5v9L16.5 21h-9L3 16.5v-9z"/>
                </svg>
            </div>
            <span class="text-base font-bold text-gray-900 tracking-tight">E-Arsip</span>
        </div>

        {{-- User info --}}
        <div class="px-4 py-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-100 text-blue-700 font-semibold text-sm select-none">
                    {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 2)) }}
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-gray-900">{{ auth()->user()->nama_lengkap }}</p>
                    <p class="truncate text-xs text-gray-500 capitalize">
                        {{ auth()->user()->role === 'admin_tu' ? 'Admin Tata Usaha' : 'Kepala Sekolah' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}"
               id="nav-dashboard"
               class="nav-item group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium
                      text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors
                      {{ request()->routeIs('dashboard*') ? 'bg-blue-50 text-blue-700' : '' }}">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/>
                </svg>
                Dashboard
            </a>

            {{-- Surat Masuk --}}
            <a href="{{ route('surat-masuk.index') }}"
               id="nav-surat-masuk"
               class="nav-item group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium
                      text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors
                      {{ request()->routeIs('surat-masuk*') ? 'bg-blue-50 text-blue-700' : '' }}">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z"/>
                </svg>
                Surat Masuk
            </a>

            {{-- Surat Keluar (admin_tu only) --}}
            @if(auth()->user()->isAdminTU())
            <a href="{{ route('surat-keluar.index') }}"
               id="nav-surat-keluar"
               class="nav-item group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium
                      text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors
                      {{ request()->routeIs('surat-keluar*') ? 'bg-blue-50 text-blue-700' : '' }}">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/>
                </svg>
                Surat Keluar
            </a>
            @endif

            {{-- Disposisi --}}
            <a href="{{ route('disposisi.index') }}"
               id="nav-disposisi"
               class="nav-item group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium
                      text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors
                      {{ request()->routeIs('disposisi*') ? 'bg-blue-50 text-blue-700' : '' }}">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/>
                </svg>
                Disposisi Digital
            </a>

            {{-- Arsip --}}
            <a href="{{ route('arsip.index') }}"
               id="nav-arsip"
               class="nav-item group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium
                      text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors
                      {{ request()->routeIs('arsip*') ? 'bg-blue-50 text-blue-700' : '' }}">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>
                Cari Arsip
            </a>

            <div class="my-3 border-t border-gray-100"></div>

            {{-- Kelola User (admin_tu only) --}}
            @if(auth()->user()->isAdminTU())
            <a href="{{ route('users.index') }}"
               id="nav-users"
               class="nav-item group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium
                      text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors
                      {{ request()->routeIs('users*') ? 'bg-blue-50 text-blue-700' : '' }}">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                </svg>
                Kelola User
            </a>
            @endif

            {{-- Laporan (kepala_sekolah only) --}}
            @if(auth()->user()->isKepsek())
            <a href="{{ route('laporan.index') }}"
               id="nav-laporan"
               class="nav-item group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium
                      text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors
                      {{ request()->routeIs('laporan*') ? 'bg-blue-50 text-blue-700' : '' }}">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>
                </svg>
                Kelola Laporan
            </a>
            @endif

        </nav>

        {{-- Logout --}}
        <div class="px-3 py-4 border-t border-gray-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        id="btn-logout"
                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium
                               text-gray-600 hover:bg-red-50 hover:text-red-600 transition-colors">
                    <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Sidebar overlay (mobile) --}}
    <div id="sidebar-overlay"
         class="fixed inset-0 z-40 bg-black/40 lg:hidden hidden"
         aria-hidden="true"
         onclick="closeSidebar()"></div>

    {{-- =========================================================
         MAIN CONTENT
    ========================================================= --}}
    <div class="flex flex-1 flex-col overflow-hidden">

        {{-- Header --}}
        <header class="flex h-16 flex-shrink-0 items-center gap-4 border-b border-gray-200 bg-white px-4 lg:px-6">

            {{-- Mobile hamburger --}}
            <button id="btn-open-sidebar"
                    type="button"
                    class="lg:hidden rounded-md p-2 text-gray-500 hover:bg-gray-100"
                    onclick="openSidebar()"
                    aria-label="Buka menu navigasi">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
            </button>

            {{-- Search --}}
            <div class="flex-1 max-w-md">
                <form action="{{ route('arsip.index') }}" method="GET" role="search">
                    <label for="global-search" class="sr-only">Cari arsip...</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                            </svg>
                        </div>
                        <input id="global-search"
                               type="search"
                               name="q"
                               placeholder="Cari..."
                               class="block w-full rounded-lg border border-gray-200 bg-gray-50 py-2 pl-10 pr-3
                                      text-sm text-gray-900 placeholder-gray-400
                                      focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-blue-500
                                      transition-colors" />
                    </div>
                </form>
            </div>

            <div class="ml-auto flex items-center gap-2">
                {{-- Notification bell --}}
                <button type="button"
                        id="btn-notification"
                        class="relative rounded-lg p-2 text-gray-500 hover:bg-gray-100 transition-colors"
                        aria-label="Notifikasi">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/>
                    </svg>
                    @php $pendingCount = \App\Models\Disposisi::where('status_tugas','belum_dibaca')->count(); @endphp
                    @if($pendingCount > 0)
                    <span class="absolute -right-0.5 -top-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white">
                        {{ $pendingCount > 9 ? '9+' : $pendingCount }}
                    </span>
                    @endif
                </button>

                {{-- Settings --}}
                <button type="button"
                        id="btn-settings"
                        class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 transition-colors"
                        aria-label="Pengaturan">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                </button>
            </div>
        </header>

        {{-- Flash messages --}}
        @if(session('success'))
        <div role="alert"
             class="mx-4 mt-4 flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 p-3 text-sm text-green-800">
            <svg class="h-5 w-5 flex-shrink-0 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div role="alert"
             class="mx-4 mt-4 flex items-center gap-3 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-800">
            <svg class="h-5 w-5 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
            </svg>
            {{ session('error') }}
        </div>
        @endif

        {{-- Page content --}}
        <main id="main-content" class="flex-1 overflow-y-auto p-4 lg:p-6">
            @yield('content')
        </main>
    </div>
</div>

<script>
    function openSidebar() {
        document.getElementById('sidebar').classList.remove('-translate-x-full');
        document.getElementById('sidebar-overlay').classList.remove('hidden');
        document.getElementById('btn-open-sidebar').setAttribute('aria-expanded', 'true');
    }

    function closeSidebar() {
        document.getElementById('sidebar').classList.add('-translate-x-full');
        document.getElementById('sidebar-overlay').classList.add('hidden');
        document.getElementById('btn-open-sidebar').setAttribute('aria-expanded', 'false');
    }

    // Auto-dismiss flash messages after 4 seconds
    setTimeout(() => {
        document.querySelectorAll('[role="alert"]').forEach(el => {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        });
    }, 4000);
</script>

@stack('scripts')
</body>
</html>
