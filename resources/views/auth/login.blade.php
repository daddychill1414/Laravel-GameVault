<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Log in to GameVault to manage your game collection">
    <title>Login — GameVault</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[--color-vault-dark] bg-tech-grid flex items-center justify-center p-4 antialiased selection:bg-[--color-vault-accent] selection:text-white relative overflow-hidden">
    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>

    <div class="w-full max-w-md relative z-10">
        {{-- Brand header --}}
        <div class="text-center mb-8">
            <img src="{{ asset('Logo Icon.png') }}" alt="GameVault Logo" class="h-16 w-auto mx-auto mb-3 object-contain filter drop-shadow-[0_10px_20px_rgba(139,92,246,0.4)]" />
            <h1 class="text-3xl font-black text-white tracking-tight">GAMEVAULT</h1>
            <p class="text-xs font-mono tracking-widest text-[--color-vault-gold] uppercase mt-1">Authenticating User Access</p>
        </div>

        {{-- Flash messages --}}
        @if (session('success'))
            <div role="alert" class="alert alert-success bg-emerald-950/80 border border-emerald-500/30 text-emerald-200 mb-6 shadow-xl backdrop-blur-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-emerald-400 shrink-0 h-5 w-5" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div role="alert" class="alert alert-error bg-rose-950/80 border border-rose-500/30 text-rose-200 mb-6 shadow-xl backdrop-blur-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-rose-400 shrink-0 h-5 w-5" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Login Card --}}
        <div class="glass-panel rounded-3xl p-8 shadow-2xl border border-white/10">
            <h2 class="text-xl font-bold text-white mb-6 tracking-tight">Log In to Your Vault</h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-[--color-vault-muted] mb-2" for="email">
                        Email Address
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        placeholder="you@example.com" required
                        class="input input-bordered w-full bg-white/[0.03] border-[--color-vault-border] focus:border-[--color-vault-accent] focus:outline-none text-white rounded-xl placeholder:text-slate-600 @error('email') input-error border-rose-500 @enderror" />
                    @error('email')
                        <p class="mt-1 text-xs text-rose-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-[--color-vault-muted] mb-2" for="password">
                        Password
                    </label>
                    <input type="password" name="password" id="password" placeholder="••••••••" required
                        class="input input-bordered w-full bg-white/[0.03] border-[--color-vault-border] focus:border-[--color-vault-accent] focus:outline-none text-white rounded-xl placeholder:text-slate-600 @error('password') input-error border-rose-500 @enderror" />
                    @error('password')
                        <p class="mt-1 text-xs text-rose-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="btn w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white border-none shadow-lg shadow-purple-600/30 rounded-xl py-3 h-auto font-bold tracking-wide mt-2 hover-lift">
                    Sign In
                </button>
            </form>

            {{-- Register link --}}
            <p class="text-center text-xs text-[--color-vault-muted] mt-6">
                Don't have a vault account?
                <a href="{{ route('register') }}"
                    class="text-purple-400 hover:text-purple-300 font-bold ml-1 transition-colors">
                    Register Now
                </a>
            </p>
        </div>
    </div>

</body>

</html>
