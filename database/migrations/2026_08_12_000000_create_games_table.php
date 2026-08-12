<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates the 'games' table to store the user's game collection.
     * Each game belongs to a user (identified by their Supabase UUID).
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();                                   // Auto-incrementing primary key
            $table->string('user_id');                      // Supabase user UUID — links game to owner
            $table->string('title', 255);                   // Game title (required)
            $table->text('description')->nullable();        // Game description (optional)
            $table->string('genre', 100);                   // Genre (e.g., RPG, FPS, Adventure)
            $table->string('platform', 100);                // Platform (e.g., PC, PS5, Xbox)
            $table->string('developer', 255);               // Developer studio name
            $table->date('release_date');                    // Game release date
            $table->decimal('price', 8, 2)->nullable();     // Price in dollars (optional)
            $table->string('status', 50);                   // Playing, Completed, Backlog, Dropped
            $table->string('cover_image', 255)->nullable(); // Path to uploaded cover image
            $table->timestamps();                           // created_at & updated_at

            $table->index('user_id');                       // Index for fast per-user queries
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
