<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Game Model
 *
 * Represents a game in the user's collection.
 * Each game belongs to a Supabase-authenticated user via user_id.
 * Demonstrates Eloquent ORM features: fillable, casts, and model constants.
 */
class Game extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * This protects against mass-assignment vulnerabilities by only allowing
     * these fields to be set via create() or update() with an array.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'genre',
        'platform',
        'developer',
        'release_date',
        'price',
        'status',
        'cover_image',
    ];

    /**
     * The attributes that should be cast.
     *
     * Casts automatically convert database values to PHP types.
     * For example, 'release_date' is cast to a Carbon date instance.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'release_date' => 'date',
            'price' => 'decimal:2',
        ];
    }

    /**
     * Available status options for a game.
     * Used in form select dropdowns and validation rules.
     */
    public const STATUS_OPTIONS = [
        'Playing',
        'Completed',
        'Backlog',
        'Dropped',
    ];

    /**
     * Available genre options.
     * Used in form select dropdowns.
     */
    public const GENRE_OPTIONS = [
        'Action',
        'Adventure',
        'RPG',
        'Strategy',
        'Simulation',
        'Sports',
        'Racing',
        'Puzzle',
        'Horror',
        'Shooter',
        'Fighting',
        'Platformer',
        'Sandbox',
        'MMO',
        'Indie',
        'Other',
    ];

    /**
     * Available platform options.
     * Used in form select dropdowns.
     */
    public const PLATFORM_OPTIONS = [
        'PC',
        'PlayStation 5',
        'PlayStation 4',
        'Xbox Series X|S',
        'Xbox One',
        'Nintendo Switch',
        'Mobile',
        'Steam Deck',
        'Other',
    ];
}
