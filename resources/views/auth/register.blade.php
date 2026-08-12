<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Create a GameVault account to manage your game collection">
    <title>Register — GameVault</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[--color-vault-dark] flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        {{-- Brand header --}}
        <div class="text-center mb-8">
            <span class="text-5xl mb-4 block">🎮</span>
            <h1 class="text-3xl font-bold text-white">GameVault</h1>
            <p class="text-[--color-vault-muted] mt-1">Create your account</p>
        </div>

        {{-- Flash messages --}}
        @if (session('error'))
            <div role="alert" class="alert alert-error mb-4 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Register Card --}}
        <div class="card bg-[--color-vault-card] border border-[--color-vault-border] shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-white text-lg mb-4">Create Account</h2>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="form-control mb-4">
                        <label class="label" for="email">
                            <span class="label-text text-[--color-vault-muted]">Email</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            placeholder="you@example.com" required
                            class="input input-bordered w-full bg-[--color-vault-dark] border-[--color-vault-border] focus:border-[--color-vault-accent] @error('email') input-error @enderror" />
                        @error('email')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-control mb-4">
                        <label class="label" for="password">
                            <span class="label-text text-[--color-vault-muted]">Password</span>
                        </label>
                        <input type="password" name="password" id="password" placeholder="At least 6 characters"
                            required
                            class="input input-bordered w-full bg-[--color-vault-dark] border-[--color-vault-border] focus:border-[--color-vault-accent] @error('password') input-error @enderror" />
                        @error('password')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="form-control mb-6">
                        <label class="label" for="password_confirmation">
                            <span class="label-text text-[--color-vault-muted]">Confirm Password</span>
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="Repeat your password" required
                            class="input input-bordered w-full bg-[--color-vault-dark] border-[--color-vault-border] focus:border-[--color-vault-accent]" />
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="btn w-full bg-[--color-vault-accent] hover:bg-[--color-vault-accent-hover] text-white border-none">
                        Create Account
                    </button>
                </form>

                {{-- Login link --}}
                <p class="text-center text-sm text-[--color-vault-muted] mt-4">
                    Already have an account?
                    <a href="{{ route('login') }}"
                        class="text-[--color-vault-accent] hover:underline font-medium">
                        Log in
                    </a>
                </p>
            </div>
        </div>
    </div>

</body>

</html>
