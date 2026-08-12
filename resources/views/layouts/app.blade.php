<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GameVault — Manage your personal game collection">
    <title>@yield('title', 'GameVault')</title>

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Vite: CSS + JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[--color-vault-dark] text-[--color-vault-text]">

    {{-- DaisyUI Drawer: sidebar on desktop, hamburger on mobile --}}
    <div class="drawer lg:drawer-open">
        <input id="sidebar-toggle" type="checkbox" class="drawer-toggle" />

        {{-- ═══════════════════════════════════════ --}}
        {{-- MAIN CONTENT AREA                      --}}
        {{-- ═══════════════════════════════════════ --}}
        <div class="drawer-content flex flex-col min-h-screen">

            {{-- Top bar (mobile only) --}}
            <div class="navbar bg-[--color-vault-sidebar] border-b border-[--color-vault-border] lg:hidden sticky top-0 z-30">
                <div class="flex-none">
                    <label for="sidebar-toggle" class="btn btn-square btn-ghost drawer-button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </label>
                </div>
                <div class="flex-1">
                    <a href="{{ route('games.index') }}" class="text-lg font-bold text-[--color-vault-accent]">
                        🎮 GameVault
                    </a>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="px-4 pt-4 lg:px-8 lg:pt-6">
                    <div role="alert" class="alert alert-success shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="px-4 pt-4 lg:px-8 lg:pt-6">
                    <div role="alert" class="alert alert-error shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- Page Content --}}
            <main class="flex-1 p-4 lg:p-8">
                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="border-t border-[--color-vault-border] p-4 text-center text-sm text-[--color-vault-muted]">
                <p>© {{ date('Y') }} GameVault — Your Personal Game Library</p>
            </footer>
        </div>

        {{-- ═══════════════════════════════════════ --}}
        {{-- SIDEBAR                                --}}
        {{-- ═══════════════════════════════════════ --}}
        <div class="drawer-side z-40">
            <label for="sidebar-toggle" aria-label="close sidebar" class="drawer-overlay"></label>
            <aside
                class="w-72 min-h-screen bg-[--color-vault-sidebar] border-r border-[--color-vault-border] flex flex-col">

                {{-- Brand --}}
                <div class="p-6 border-b border-[--color-vault-border]">
                    <a href="{{ route('games.index') }}" class="flex items-center gap-3">
                        <span class="text-3xl">🎮</span>
                        <div>
                            <h1 class="text-xl font-bold text-white">GameVault</h1>
                            <p class="text-xs text-[--color-vault-muted]">Your Game Library</p>
                        </div>
                    </a>
                </div>

                {{-- Navigation --}}
                <nav class="flex-1 p-4 space-y-1">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[--color-vault-muted] mb-3 px-3">
                        Menu
                    </p>

                    {{-- Dashboard / Games link --}}
                    <a href="{{ route('games.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                        {{ request()->routeIs('games.index') ? 'bg-[--color-vault-accent] text-white' : 'text-[--color-vault-muted] hover:bg-[--color-vault-card] hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Games
                    </a>

                    {{-- Add Game link --}}
                    <a href="{{ route('games.create') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                        {{ request()->routeIs('games.create') ? 'bg-[--color-vault-accent] text-white' : 'text-[--color-vault-muted] hover:bg-[--color-vault-card] hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        Add Game
                    </a>
                </nav>

                {{-- User info + Logout --}}
                @isset($authUser)
                    <div class="p-4 border-t border-[--color-vault-border]">
                        <div class="flex items-center gap-3 mb-3 px-2">
                            <div
                                class="w-9 h-9 rounded-full bg-[--color-vault-accent] flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($authUser['email'], 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-white truncate">{{ $authUser['email'] }}</p>
                                <p class="text-xs text-[--color-vault-muted]">Logged in</p>
                            </div>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="btn btn-ghost btn-sm w-full justify-start gap-2 text-[--color-vault-muted] hover:text-red-400 hover:bg-red-400/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Log Out
                            </button>
                        </form>
                    </div>
                @endisset
            </aside>
        </div>
    </div>
</body>

</html>
