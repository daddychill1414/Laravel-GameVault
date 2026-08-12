{{-- Add Game Form --}}
{{-- Form for creating a new game with cover image upload --}}

@extends('layouts.app')

@section('title', 'Add Game — GameVault')

@section('content')
    {{-- Page Header --}}
    <div class="mb-6">
        <a href="{{ route('games.index') }}"
            class="text-[--color-vault-muted] hover:text-[--color-vault-accent] text-sm inline-flex items-center gap-1 mb-3 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Games
        </a>
        <h1 class="text-2xl font-bold text-white">Add New Game</h1>
        <p class="text-[--color-vault-muted] text-sm mt-1">Add a game to your vault</p>
    </div>

    {{-- Form Card --}}
    <div class="card bg-[--color-vault-card] border border-[--color-vault-border] shadow-lg max-w-3xl">
        <div class="card-body">
            <form method="POST" action="{{ route('games.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Cover Image Upload --}}
                <div class="form-control mb-5">
                    <label class="label" for="cover_image">
                        <span class="label-text text-[--color-vault-muted]">Cover Image</span>
                        <span class="label-text-alt text-[--color-vault-muted]">JPG, PNG, WebP — Max 2MB</span>
                    </label>
                    <input type="file" name="cover_image" id="cover_image" accept="image/*"
                        class="file-input file-input-bordered w-full bg-[--color-vault-dark] border-[--color-vault-border] @error('cover_image') file-input-error @enderror" />
                    @error('cover_image')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                {{-- Title --}}
                <div class="form-control mb-5">
                    <label class="label" for="title">
                        <span class="label-text text-[--color-vault-muted]">Title <span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        placeholder="e.g., The Legend of Zelda" required
                        class="input input-bordered w-full bg-[--color-vault-dark] border-[--color-vault-border] focus:border-[--color-vault-accent] @error('title') input-error @enderror" />
                    @error('title')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                {{-- Genre & Platform (side by side) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                    {{-- Genre --}}
                    <div class="form-control">
                        <label class="label" for="genre">
                            <span class="label-text text-[--color-vault-muted]">Genre <span class="text-error">*</span></span>
                        </label>
                        <select name="genre" id="genre" required
                            class="select select-bordered w-full bg-[--color-vault-dark] border-[--color-vault-border] focus:border-[--color-vault-accent] @error('genre') select-error @enderror">
                            <option value="" disabled {{ old('genre') ? '' : 'selected' }}>Select genre</option>
                            @foreach (\App\Models\Game::GENRE_OPTIONS as $genre)
                                <option value="{{ $genre }}" {{ old('genre') === $genre ? 'selected' : '' }}>
                                    {{ $genre }}
                                </option>
                            @endforeach
                        </select>
                        @error('genre')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Platform --}}
                    <div class="form-control">
                        <label class="label" for="platform">
                            <span class="label-text text-[--color-vault-muted]">Platform <span class="text-error">*</span></span>
                        </label>
                        <select name="platform" id="platform" required
                            class="select select-bordered w-full bg-[--color-vault-dark] border-[--color-vault-border] focus:border-[--color-vault-accent] @error('platform') select-error @enderror">
                            <option value="" disabled {{ old('platform') ? '' : 'selected' }}>Select platform</option>
                            @foreach (\App\Models\Game::PLATFORM_OPTIONS as $platform)
                                <option value="{{ $platform }}" {{ old('platform') === $platform ? 'selected' : '' }}>
                                    {{ $platform }}
                                </option>
                            @endforeach
                        </select>
                        @error('platform')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                {{-- Developer --}}
                <div class="form-control mb-5">
                    <label class="label" for="developer">
                        <span class="label-text text-[--color-vault-muted]">Developer <span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="developer" id="developer" value="{{ old('developer') }}"
                        placeholder="e.g., Nintendo" required
                        class="input input-bordered w-full bg-[--color-vault-dark] border-[--color-vault-border] focus:border-[--color-vault-accent] @error('developer') input-error @enderror" />
                    @error('developer')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                {{-- Release Date, Status & Price (row) --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
                    {{-- Release Date --}}
                    <div class="form-control">
                        <label class="label" for="release_date">
                            <span class="label-text text-[--color-vault-muted]">Release Date <span class="text-error">*</span></span>
                        </label>
                        <input type="date" name="release_date" id="release_date" value="{{ old('release_date') }}"
                            required
                            class="input input-bordered w-full bg-[--color-vault-dark] border-[--color-vault-border] focus:border-[--color-vault-accent] @error('release_date') input-error @enderror" />
                        @error('release_date')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="form-control">
                        <label class="label" for="status">
                            <span class="label-text text-[--color-vault-muted]">Status <span class="text-error">*</span></span>
                        </label>
                        <select name="status" id="status" required
                            class="select select-bordered w-full bg-[--color-vault-dark] border-[--color-vault-border] focus:border-[--color-vault-accent] @error('status') select-error @enderror">
                            <option value="" disabled {{ old('status') ? '' : 'selected' }}>Select status</option>
                            @foreach (\App\Models\Game::STATUS_OPTIONS as $status)
                                <option value="{{ $status }}" {{ old('status') === $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div class="form-control">
                        <label class="label" for="price">
                            <span class="label-text text-[--color-vault-muted]">Price ($)</span>
                        </label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}"
                            placeholder="0.00" step="0.01" min="0"
                            class="input input-bordered w-full bg-[--color-vault-dark] border-[--color-vault-border] focus:border-[--color-vault-accent] @error('price') input-error @enderror" />
                        @error('price')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                {{-- Description --}}
                <div class="form-control mb-6">
                    <label class="label" for="description">
                        <span class="label-text text-[--color-vault-muted]">Description</span>
                    </label>
                    <textarea name="description" id="description" rows="4" placeholder="Brief description of the game..."
                        class="textarea textarea-bordered w-full bg-[--color-vault-dark] border-[--color-vault-border] focus:border-[--color-vault-accent] @error('description') textarea-error @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                {{-- Submit Buttons --}}
                <div class="flex gap-3 justify-end">
                    <a href="{{ route('games.index') }}" class="btn btn-ghost text-[--color-vault-muted]">
                        Cancel
                    </a>
                    <button type="submit"
                        class="btn bg-[--color-vault-accent] hover:bg-[--color-vault-accent-hover] text-white border-none gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Game
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
