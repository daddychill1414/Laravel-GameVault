<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * GameController
 *
 * Resource controller for managing the user's game collection.
 * Uses all 7 RESTful methods: index, create, store, show, edit, update, destroy.
 *
 * All games are scoped to the authenticated user via their Supabase user ID.
 * Route model binding is used for show, edit, update, and destroy.
 */
class GameController extends Controller
{
    /**
     * Display a listing of the user's games.
     *
     * GET /games
     *
     * Supports:
     * - Search by title (?search=...)
     * - Filter by status (?status=...)
     * - Pagination (12 per page)
     */
    public function index(Request $request)
    {
        // Get the authenticated user's ID from the session
        $userId = session('supabase_user.id');

        // Start building the query — only this user's games
        $query = Game::where('user_id', $userId);

        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        // Apply status filter if provided
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Get paginated results, ordered by newest first
        $games = $query->orderBy('created_at', 'desc')->paginate(12);

        // Preserve search/filter parameters in pagination links
        $games->appends($request->only(['search', 'status']));

        return view('games.index', compact('games'));
    }

    /**
     * Show the form for creating a new game.
     *
     * GET /games/create
     */
    public function create()
    {
        return view('games.create');
    }

    /**
     * Store a newly created game in the database.
     *
     * POST /games
     *
     * Uses StoreGameRequest for validation.
     * Handles cover image upload to storage/app/public/covers/.
     */
    public function store(StoreGameRequest $request)
    {
        // Get the validated data from the Form Request
        $validated = $request->validated();

        // Set the user_id from the authenticated session
        $validated['user_id'] = session('supabase_user.id');

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = $path;
        }

        // Create the game record using Eloquent
        Game::create($validated);

        return redirect()->route('games.index')
            ->with('success', 'Game added to your vault!');
    }

    /**
     * Display the specified game.
     *
     * GET /games/{game}
     *
     * Uses route model binding — Laravel automatically finds the Game by ID.
     */
    public function show(Game $game)
    {
        // Ensure the game belongs to the authenticated user
        $this->authorizeGame($game);

        return view('games.show', compact('game'));
    }

    /**
     * Show the form for editing the specified game.
     *
     * GET /games/{game}/edit
     */
    public function edit(Game $game)
    {
        // Ensure the game belongs to the authenticated user
        $this->authorizeGame($game);

        return view('games.edit', compact('game'));
    }

    /**
     * Update the specified game in the database.
     *
     * PUT /games/{game}
     *
     * Uses UpdateGameRequest for validation.
     */
    public function update(UpdateGameRequest $request, Game $game)
    {
        // Ensure the game belongs to the authenticated user
        $this->authorizeGame($game);

        // Get the validated data
        $validated = $request->validated();

        // Handle cover image replacement
        if ($request->hasFile('cover_image')) {
            // Delete the old cover image if it exists
            if ($game->cover_image) {
                Storage::disk('public')->delete($game->cover_image);
            }

            // Store the new cover image
            $path = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = $path;
        }

        // Update the game record using Eloquent
        $game->update($validated);

        return redirect()->route('games.show', $game)
            ->with('success', 'Game updated successfully!');
    }

    /**
     * Remove the specified game from the database.
     *
     * DELETE /games/{game}
     */
    public function destroy(Game $game)
    {
        // Ensure the game belongs to the authenticated user
        $this->authorizeGame($game);

        // Delete the cover image from storage if it exists
        if ($game->cover_image) {
            Storage::disk('public')->delete($game->cover_image);
        }

        // Delete the game record from the database
        $game->delete();

        return redirect()->route('games.index')
            ->with('success', 'Game removed from your vault.');
    }

    /**
     * Verify that the given game belongs to the authenticated user.
     *
     * @param  \App\Models\Game  $game
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    protected function authorizeGame(Game $game): void
    {
        if ($game->user_id !== session('supabase_user.id')) {
            abort(403, 'This game does not belong to you.');
        }
    }
}
