{{-- Game Detail Page --}}
{{-- Displays all information about a single game --}}

@extends('layouts.app')

@section('title', $game->title . ' — GameVault')

@section('content')
    {{-- Back link --}}
    <a href="{{ route('games.index') }}"
        class="text-[--color-vault-muted] hover:text-[--color-vault-accent] text-sm inline-flex items-center gap-1 mb-6 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Games
    </a>

    <div class="card bg-[--color-vault-card] border border-[--color-vault-border] shadow-lg max-w-4xl">
        <div class="card-body p-0">
            <div class="flex flex-col md:flex-row">

                {{-- Cover Image (left side) --}}
                <div class="md:w-1/3 shrink-0">
                    @if ($game->cover_image)
                        <img src="{{ asset('storage/' . $game->cover_image) }}" alt="{{ $game->title }}"
                            class="w-full h-64 md:h-full object-cover rounded-t-2xl md:rounded-l-2xl md:rounded-tr-none" />
                    @else
                        <div
                            class="w-full h-64 md:h-full bg-gradient-to-br from-[--color-vault-accent]/20 to-[--color-vault-card] flex items-center justify-center rounded-t-2xl md:rounded-l-2xl md:rounded-tr-none">
                            <span class="text-7xl opacity-30">🎮</span>
                        </div>
                    @endif
                </div>

                {{-- Game Details (right side) --}}
                <div class="flex-1 p-6 md:p-8">
                    {{-- Title & Status --}}
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <h1 class="text-2xl font-bold text-white">{{ $game->title }}</h1>
                        @php
                            $statusColors = [
                                'Playing'   => 'badge-success',
                                'Completed' => 'badge-info',
                                'Backlog'   => 'badge-warning',
                                'Dropped'   => 'badge-error',
                            ];
                        @endphp
                        <span class="badge {{ $statusColors[$game->status] ?? 'badge-neutral' }} font-medium shrink-0">
                            {{ $game->status }}
                        </span>
                    </div>

                    {{-- Badges --}}
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="badge badge-outline text-[--color-vault-accent] border-[--color-vault-accent]/40">
                            {{ $game->genre }}
                        </span>
                        <span class="badge badge-outline text-[--color-vault-muted] border-[--color-vault-border]">
                            {{ $game->platform }}
                        </span>
                    </div>

                    {{-- Info Grid --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-xs uppercase tracking-wider text-[--color-vault-muted] mb-1">Developer</p>
                            <p class="text-white font-medium">{{ $game->developer }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wider text-[--color-vault-muted] mb-1">Release Date</p>
                            <p class="text-white font-medium">{{ $game->release_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wider text-[--color-vault-muted] mb-1">Price</p>
                            <p class="text-white font-medium">
                                {{ $game->price ? '$' . number_format($game->price, 2) : 'Free / Not set' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-wider text-[--color-vault-muted] mb-1">Added</p>
                            <p class="text-white font-medium">{{ $game->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    {{-- Description --}}
                    @if ($game->description)
                        <div class="mb-6">
                            <p class="text-xs uppercase tracking-wider text-[--color-vault-muted] mb-2">Description</p>
                            <p class="text-[--color-vault-text] leading-relaxed">{{ $game->description }}</p>
                        </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="flex flex-wrap gap-3 pt-4 border-t border-[--color-vault-border]">
                        <a href="{{ route('games.edit', $game) }}"
                            class="btn bg-[--color-vault-accent] hover:bg-[--color-vault-accent-hover] text-white border-none gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>

                        <button onclick="document.getElementById('delete-modal').showModal()"
                            class="btn btn-outline btn-error gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>

                        <a href="{{ route('games.index') }}" class="btn btn-ghost text-[--color-vault-muted]">
                            Back to Games
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <dialog id="delete-modal" class="modal">
        <div class="modal-box bg-[--color-vault-card] border border-[--color-vault-border]">
            <h3 class="font-bold text-lg text-white">Delete Game</h3>
            <p class="py-4 text-[--color-vault-muted]">
                Are you sure you want to delete <strong class="text-white">{{ $game->title }}</strong>? This action
                cannot be undone.
            </p>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-ghost text-[--color-vault-muted]">Cancel</button>
                </form>
                <form action="{{ route('games.destroy', $game) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error">Delete</button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
@endsection
