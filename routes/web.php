<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| GameVault Routes:
| - Public: login, register, logout
| - Protected: game CRUD (requires Supabase authentication)
|
*/

// Redirect root to games (will redirect to login if not authenticated)
Route::get('/', fn () => redirect()->route('games.index'));

// ──────────────────────────────────────────────
// Authentication Routes (public — no middleware)
// ──────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ──────────────────────────────────────────────
// Game CRUD Routes (protected — requires login)
// ──────────────────────────────────────────────
// Route::resource generates all 7 RESTful routes:
//   GET    /games              → index
//   GET    /games/create       → create
//   POST   /games              → store
//   GET    /games/{game}       → show
//   GET    /games/{game}/edit  → edit
//   PUT    /games/{game}       → update
//   DELETE /games/{game}       → destroy
Route::middleware('supabase.auth')->group(function () {
    Route::resource('games', GameController::class);
});
