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

<body class="min-h-screen bg-[--color-vault-dark] bg-tech-grid text-[--color-vault-text] antialiased selection:bg-[--color-vault-accent] selection:text-white relative overflow-x-hidden">
    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>

    {{-- DaisyUI Drawer: sidebar on desktop, hamburger on mobile --}}
    <div class="drawer lg:drawer-open">
        <input id="sidebar-toggle" type="checkbox" class="drawer-toggle" />

        {{-- ═══════════════════════════════════════ --}}
        {{-- MAIN CONTENT AREA                      --}}
        {{-- ═══════════════════════════════════════ --}}
        <div class="drawer-content flex flex-col min-h-screen">

            {{-- Top bar (mobile only) --}}
            <div class="navbar bg-[--color-vault-sidebar]/90 backdrop-blur-md border-b border-[--color-vault-border] lg:hidden sticky top-0 z-30">
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
                    <a href="{{ route('games.index') }}" class="flex items-center gap-2">
                        <img src="{{ asset('Logo GameVault.png') }}" alt="GameVault Logo" class="h-8 w-auto object-contain rounded-lg" />
                    </a>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="px-4 pt-4 lg:px-8 lg:pt-6">
                    <div role="alert" class="alert alert-success bg-emerald-950/80 border border-emerald-500/30 text-emerald-200 shadow-xl backdrop-blur-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-emerald-400 shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="px-4 pt-4 lg:px-8 lg:pt-6">
                    <div role="alert" class="alert alert-error bg-rose-950/80 border border-rose-500/30 text-rose-200 shadow-xl backdrop-blur-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-rose-400 shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- Page Content --}}
            <main class="flex-1 p-4 lg:p-8 max-w-7xl w-full mx-auto">
                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="border-t border-[--color-vault-border] p-6 text-center text-xs tracking-wider uppercase text-[--color-vault-muted]">
                <p>© {{ date('Y') }} GameVault — Precision Library Management</p>
            </footer>
        </div>

        {{-- ═══════════════════════════════════════ --}}
        {{-- SIDEBAR                                --}}
        {{-- ═══════════════════════════════════════ --}}
        <div class="drawer-side z-40">
            <label for="sidebar-toggle" aria-label="close sidebar" class="drawer-overlay"></label>
            <aside
                class="w-72 min-h-screen bg-[--color-vault-sidebar]/95 backdrop-blur-xl border-r border-[--color-vault-border] flex flex-col justify-between">

                <div>
                    {{-- Brand --}}
                    <div class="p-6 border-b border-[--color-vault-border]">
                        <a href="{{ route('games.index') }}" class="flex items-center gap-3 group">
                            <img src="{{ asset('Logo Icon.png') }}" alt="GameVault Logo" class="h-8 w-auto object-contain shrink-0 group-hover:scale-105 transition-transform" />
                            <div class="min-w-0">
                                <h1 class="text-lg font-black tracking-wider text-white truncate">GAMEVAULT</h1>
                                <p class="text-[10px] font-mono tracking-widest text-[--color-vault-gold] uppercase truncate">Vault Control v2.0</p>
                            </div>
                        </a>
                    </div>

                    {{-- Navigation --}}
                    <nav class="p-4 space-y-2">
                        <p class="text-[10px] font-mono uppercase tracking-widest text-[--color-vault-muted] mb-3 px-3">
                            Navigation
                        </p>

                        {{-- Dashboard / Games link --}}
                        <a href="{{ route('games.index') }}"
                            class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-semibold transition-all duration-200 hover-lift
                            {{ request()->routeIs('games.index') ? 'bg-gradient-to-r from-purple-600 to-indigo-600 text-white shadow-lg shadow-purple-600/30' : 'text-[--color-vault-muted] hover:bg-white/5 hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            Collection
                        </a>

                        {{-- Add Game link --}}
                        <a href="{{ route('games.create') }}"
                            class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-semibold transition-all duration-200 hover-lift
                            {{ request()->routeIs('games.create') ? 'bg-gradient-to-r from-purple-600 to-indigo-600 text-white shadow-lg shadow-purple-600/30' : 'text-[--color-vault-muted] hover:bg-white/5 hover:text-white' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Add New Game
                        </a>
                    </nav>
                </div>

                {{-- User info + Logout --}}
                @isset($authUser)
                    <div class="p-4 m-3 rounded-2xl bg-white/[0.03] border border-[--color-vault-border]">
                        <div class="flex items-center gap-3 mb-3 px-1">
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-tr from-purple-500 to-amber-400 flex items-center justify-center text-white font-black text-sm shadow-md">
                                {{ strtoupper(substr($authUser['email'], 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-white truncate">{{ $authUser['email'] }}</p>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                    <span class="text-[10px] font-mono text-[--color-vault-muted] uppercase">Authenticated</span>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="btn btn-ghost btn-xs w-full justify-center gap-2 text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 border border-rose-500/20 rounded-lg py-2 h-auto transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
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
