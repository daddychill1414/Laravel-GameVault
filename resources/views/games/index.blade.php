{{-- Games Listing Page --}}
{{-- Displays the user's game collection with search, filters, and game cards --}}

@extends('layouts.app')

@section('title', 'My Games — GameVault')

@section('content')
    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">My Games</h1>
            <p class="text-[--color-vault-muted] text-sm mt-1">Manage your personal game collection</p>
        </div>
        <a href="{{ route('games.create') }}"
            class="btn bg-[--color-vault-accent] hover:bg-[--color-vault-accent-hover] text-white border-none gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add Game
        </a>
    </div>

    {{-- Search & Filter Bar --}}
    <div class="card bg-[--color-vault-card] border border-[--color-vault-border] mb-6">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('games.index') }}" class="flex flex-col sm:flex-row gap-3">
                {{-- Search input --}}
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search games..."
                        class="input input-bordered w-full bg-[--color-vault-dark] border-[--color-vault-border] focus:border-[--color-vault-accent]" />
                </div>

                {{-- Status filter --}}
                <select name="status"
                    class="select select-bordered bg-[--color-vault-dark] border-[--color-vault-border] focus:border-[--color-vault-accent] w-full sm:w-auto">
                    <option value="">All Statuses</option>
                    @foreach (\App\Models\Game::STATUS_OPTIONS as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>

                {{-- Buttons --}}
                <div class="flex gap-2">
                    <button type="submit"
                        class="btn bg-[--color-vault-accent] hover:bg-[--color-vault-accent-hover] text-white border-none">
                        Search
                    </button>
                    @if (request('search') || request('status'))
                        <a href="{{ route('games.index') }}" class="btn btn-ghost text-[--color-vault-muted]">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Games Grid or Empty State --}}
    @if ($games->isEmpty())
        {{-- ══════════════════════════════════════════ --}}
        {{-- EMPTY STATE — shown when no games exist   --}}
        {{-- ══════════════════════════════════════════ --}}
        <div class="card bg-[--color-vault-card] border border-[--color-vault-border] shadow-lg">
            <div class="card-body items-center text-center py-16">
                <span class="text-6xl mb-4">🎮</span>
                <h2 class="text-xl font-bold text-white mb-2">No games found</h2>
                <p class="text-[--color-vault-muted] mb-6 max-w-sm">
                    @if (request('search') || request('status'))
                        No games match your search criteria. Try clearing the filters.
                    @else
                        Your vault is empty. Start building your collection by adding your first game!
                    @endif
                </p>
                @if (request('search') || request('status'))
                    <a href="{{ route('games.index') }}" class="btn btn-ghost text-[--color-vault-muted]">
                        Clear Filters
                    </a>
                @else
                    <a href="{{ route('games.create') }}"
                        class="btn bg-[--color-vault-accent] hover:bg-[--color-vault-accent-hover] text-white border-none gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Your First Game
                    </a>
                @endif
            </div>
        </div>
    @else
        {{-- ══════════════════════════════════════════ --}}
        {{-- GAME CARDS GRID                           --}}
        {{-- ══════════════════════════════════════════ --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach ($games as $game)
                <div class="card bg-[--color-vault-card] border border-[--color-vault-border] shadow-md hover:border-[--color-vault-accent]/40 transition-all duration-300 group">
                    {{-- Cover Image --}}
                    <figure class="relative h-48 overflow-hidden">
                        @if ($game->cover_image)
                            <img src="{{ asset('storage/' . $game->cover_image) }}" alt="{{ $game->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-br from-[--color-vault-accent]/20 to-[--color-vault-card] flex items-center justify-center">
                                <span class="text-5xl opacity-40">🎮</span>
                            </div>
                        @endif

                        {{-- Status Badge (overlay) --}}
                        <div class="absolute top-3 right-3">
                            @php
                                $statusColors = [
                                    'Playing'   => 'badge-success',
                                    'Completed' => 'badge-info',
                                    'Backlog'   => 'badge-warning',
                                    'Dropped'   => 'badge-error',
                                ];
                            @endphp
                            <span class="badge {{ $statusColors[$game->status] ?? 'badge-neutral' }} badge-sm font-medium">
                                {{ $game->status }}
                            </span>
                        </div>
                    </figure>

                    {{-- Card Body --}}
                    <div class="card-body p-4">
                        <h2 class="card-title text-white text-base">{{ $game->title }}</h2>

                        <div class="flex flex-wrap gap-2 mt-1">
                            <span class="badge badge-outline badge-sm text-[--color-vault-accent] border-[--color-vault-accent]/40">
                                {{ $game->genre }}
                            </span>
                            <span class="badge badge-outline badge-sm text-[--color-vault-muted] border-[--color-vault-border]">
                                {{ $game->platform }}
                            </span>
                        </div>

                        <p class="text-sm text-[--color-vault-muted] mt-1">{{ $game->developer }}</p>

                        {{-- Action Buttons --}}
                        <div class="card-actions justify-end mt-3 pt-3 border-t border-[--color-vault-border]">
                            <a href="{{ route('games.show', $game) }}"
                                class="btn btn-ghost btn-sm text-[--color-vault-accent] hover:bg-[--color-vault-accent]/10">
                                View
                            </a>
                            <a href="{{ route('games.edit', $game) }}"
                                class="btn btn-ghost btn-sm text-[--color-vault-muted] hover:bg-[--color-vault-card]">
                                Edit
                            </a>
                            <button onclick="document.getElementById('delete-modal-{{ $game->id }}').showModal()"
                                class="btn btn-ghost btn-sm text-red-400 hover:bg-red-400/10">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Delete Confirmation Modal --}}
                <dialog id="delete-modal-{{ $game->id }}" class="modal">
                    <div class="modal-box bg-[--color-vault-card] border border-[--color-vault-border]">
                        <h3 class="font-bold text-lg text-white">Delete Game</h3>
                        <p class="py-4 text-[--color-vault-muted]">
                            Are you sure you want to delete <strong class="text-white">{{ $game->title }}</strong>? This
                            action cannot be undone.
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
            @endforeach
        </div>

        {{-- Pagination --}}
        @if ($games->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $games->links() }}
            </div>
        @endif
    @endif
@endsection
