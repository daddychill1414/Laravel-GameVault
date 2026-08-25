{{-- Games Listing Page --}}
{{-- Displays the user's game collection with search, filters, and game cards --}}

@extends('layouts.app')

@section('title', 'My Games — GameVault')

@section('content')
    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-0.5 rounded-full bg-purple-500/10 border border-purple-500/20 text-purple-400 text-xs font-mono font-medium">LIBRARY MANAGEMENT</span>
            </div>
            <h1 class="text-3xl lg:text-4xl font-extrabold text-white tracking-tight">Game Collection</h1>
            <p class="text-[--color-vault-muted] text-sm mt-1">Curate, track, and manage your personal video game backlog</p>
        </div>
        <a href="{{ route('games.create') }}"
            class="btn bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white border-none shadow-lg shadow-purple-600/30 gap-2 hover-lift rounded-xl px-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add New Game
        </a>
    </div>

    {{-- Search & Filter Bar --}}
    <div class="glass-panel rounded-2xl p-5 mb-8 shadow-xl">
        <form method="GET" action="{{ route('games.index') }}" class="flex flex-col sm:flex-row gap-3">
            {{-- Search input --}}
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[--color-vault-muted]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search collection by title..."
                    class="input input-bordered w-full pl-11 bg-white/[0.03] border-[--color-vault-border] focus:border-[--color-vault-accent] focus:outline-none text-white rounded-xl placeholder:text-slate-500" />
            </div>

            {{-- Status filter --}}
            <select name="status"
                class="select select-bordered bg-[--color-vault-dark] border-[--color-vault-border] focus:border-[--color-vault-accent] focus:outline-none text-white rounded-xl w-full sm:w-48">
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
                    class="btn bg-white/10 hover:bg-white/20 text-white border-none rounded-xl px-5">
                    Filter
                </button>
                @if (request('search') || request('status'))
                    <a href="{{ route('games.index') }}" class="btn btn-ghost text-[--color-vault-muted] hover:text-white rounded-xl">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Games Grid or Empty State --}}
    @if ($games->isEmpty())
        {{-- EMPTY STATE --}}
        <div class="glass-panel rounded-3xl p-12 text-center my-8 shadow-2xl">
            <div class="w-20 h-20 mx-auto rounded-3xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-4xl mb-5">
                👾
            </div>
            <h2 class="text-2xl font-bold text-white mb-2">No games found</h2>
            <p class="text-[--color-vault-muted] max-w-md mx-auto mb-8 text-sm leading-relaxed">
                @if (request('search') || request('status'))
                    We couldn't find any games matching your current search parameters. Try adjusting your query or resetting filters.
                @else
                    Your collection is currently empty. Start populating your personal vault by creating your first entry.
                @endif
            </p>
            @if (request('search') || request('status'))
                <a href="{{ route('games.index') }}" class="btn btn-outline border-white/20 text-white hover:bg-white/10 rounded-xl px-6">
                    Clear Filters
                </a>
            @else
                <a href="{{ route('games.create') }}"
                    class="btn bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white border-none shadow-lg shadow-purple-600/30 gap-2 rounded-xl px-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Your First Game
                </a>
            @endif
        </div>
    @else
        {{-- GAME CARDS GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach ($games as $game)
                <div class="glass-panel rounded-3xl overflow-hidden hover-lift group border border-white/[0.08]">
                    {{-- Cover Image Container --}}
                    <div class="relative h-52 overflow-hidden bg-slate-900">
                        @if ($game->cover_image)
                            <img src="{{ asset('storage/' . $game->cover_image) }}" alt="{{ $game->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out" />
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-purple-900/40 via-indigo-950/60 to-slate-950 flex flex-col items-center justify-center gap-2">
                                <span class="text-5xl opacity-40 group-hover:scale-110 transition-transform duration-500">🕹️</span>
                                <span class="text-xs font-mono uppercase tracking-widest text-white/30">No Cover Media</span>
                            </div>
                        @endif

                        {{-- Gradient Overlay for readable badges --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-[#13131e] via-transparent to-black/40"></div>

                        {{-- Status Badge --}}
                        <div class="absolute top-3.5 right-3.5">
                            @php
                                $statusBadgeStyles = [
                                    'Playing'   => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40',
                                    'Completed' => 'bg-sky-500/20 text-sky-300 border-sky-500/40',
                                    'Backlog'   => 'bg-amber-500/20 text-amber-300 border-amber-500/40',
                                    'Dropped'   => 'bg-rose-500/20 text-rose-300 border-rose-500/40',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-md border {{ $statusBadgeStyles[$game->status] ?? 'bg-slate-500/20 text-slate-300 border-slate-500/40' }}">
                                {{ $game->status }}
                            </span>
                        </div>
                    </div>

                    {{-- Card Content --}}
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <h2 class="text-lg font-bold text-white tracking-tight line-clamp-1 group-hover:text-purple-300 transition-colors">
                                {{ $game->title }}
                            </h2>
                        </div>

                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="px-2.5 py-0.5 rounded-lg text-xs font-medium bg-purple-500/10 text-purple-300 border border-purple-500/20">
                                {{ $game->genre }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-lg text-xs font-medium bg-white/[0.04] text-slate-300 border border-white/10">
                                {{ $game->platform }}
                            </span>
                        </div>

                        <p class="text-xs text-[--color-vault-muted] font-medium truncate mb-4">
                            By {{ $game->developer }}
                        </p>

                        {{-- Card Action Footer --}}
                        <div class="flex items-center justify-between pt-4 border-t border-white/[0.06]">
                            <a href="{{ route('games.show', $game) }}"
                                class="text-xs font-bold text-purple-400 hover:text-purple-300 flex items-center gap-1">
                                View Details
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>

                            <div class="flex items-center gap-1">
                                <a href="{{ route('games.edit', $game) }}"
                                    class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/10 transition-colors"
                                    title="Edit Game">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button onclick="document.getElementById('delete-modal-{{ $game->id }}').showModal()"
                                    class="p-2 rounded-lg text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 transition-colors"
                                    title="Delete Game">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modals --}}
                <dialog id="delete-modal-{{ $game->id }}" class="modal backdrop-blur-md">
                    <div class="modal-box glass-panel rounded-3xl border border-white/10 text-slate-200">
                        <h3 class="font-bold text-xl text-white">Remove from Vault</h3>
                        <p class="py-4 text-sm text-[--color-vault-muted]">
                            Are you sure you want to delete <strong class="text-white">{{ $game->title }}</strong>? This action will permanently erase the record.
                        </p>
                        <div class="modal-action">
                            <form method="dialog">
                                <button class="btn btn-ghost text-slate-400 rounded-xl">Cancel</button>
                            </form>
                            <form action="{{ route('games.destroy', $game) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn bg-rose-600 hover:bg-rose-500 text-white border-none rounded-xl px-5">Confirm Delete</button>
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
            <div class="mt-10 flex justify-center">
                {{ $games->links() }}
            </div>
        @endif
    @endif
@endsection
