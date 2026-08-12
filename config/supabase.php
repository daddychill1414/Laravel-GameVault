<?php

/**
 * Supabase Configuration
 *
 * Stores the Supabase project URL and anon/public API key.
 * These values are read from the .env file.
 */
return [
    'url' => env('SUPABASE_URL'),
    'key' => env('SUPABASE_KEY'),
];
