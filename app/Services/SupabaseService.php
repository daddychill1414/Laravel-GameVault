<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

/**
 * SupabaseService
 *
 * Wraps the Supabase Auth REST API using Laravel's HTTP client.
 * This service handles user registration, login, and logout by making
 * HTTP requests to your Supabase project's authentication endpoints.
 *
 * No external packages needed — just Laravel's built-in Http facade.
 */
class SupabaseService
{
    /**
     * The Supabase project URL (e.g., https://xxxx.supabase.co)
     */
    protected string $url;

    /**
     * The Supabase anon/public API key
     */
    protected string $key;

    public function __construct()
    {
        $this->url = config('supabase.url');
        $this->key = config('supabase.key');
    }

    /**
     * Register a new user with email and password.
     *
     * Calls: POST /auth/v1/signup
     *
     * @param  string  $email
     * @param  string  $password
     * @return array   Contains 'user', 'access_token', 'refresh_token', etc.
     *
     * @throws \Exception  If Supabase returns an error
     */
    public function signUp(string $email, string $password): array
    {
        $response = Http::withHeaders($this->headers())
            ->post("{$this->url}/auth/v1/signup", [
                'email'    => $email,
                'password' => $password,
            ]);

        if ($response->failed()) {
            $error = $response->json('msg') ?? $response->json('error_description') ?? $response->json('message') ?? 'Registration failed. Please try again.';
            throw new \Exception($error);
        }

        return $response->json();
    }

    /**
     * Sign in an existing user with email and password.
     *
     * Calls: POST /auth/v1/token?grant_type=password
     *
     * @param  string  $email
     * @param  string  $password
     * @return array   Contains 'user', 'access_token', 'refresh_token', etc.
     *
     * @throws \Exception  If credentials are invalid
     */
    public function signIn(string $email, string $password): array
    {
        $response = Http::withHeaders($this->headers())
            ->post("{$this->url}/auth/v1/token?grant_type=password", [
                'email'    => $email,
                'password' => $password,
            ]);

        if ($response->failed()) {
            $error = $response->json('error_description') ?? $response->json('msg') ?? $response->json('message') ?? 'Invalid email or password.';
            throw new \Exception($error);
        }

        return $response->json();
    }

    /**
     * Sign out the current user.
     *
     * Calls: POST /auth/v1/logout
     *
     * @param  string  $accessToken  The user's current access token
     * @return void
     */
    public function signOut(string $accessToken): void
    {
        Http::withHeaders($this->headers($accessToken))
            ->post("{$this->url}/auth/v1/logout");

        // We don't throw on failure here — the session will be cleared regardless
    }

    /**
     * Get the currently authenticated user's info.
     *
     * Calls: GET /auth/v1/user
     *
     * @param  string  $accessToken
     * @return array|null  User data or null if token is invalid/expired
     */
    public function getUser(string $accessToken): ?array
    {
        $response = Http::withHeaders($this->headers($accessToken))
            ->get("{$this->url}/auth/v1/user");

        if ($response->failed()) {
            return null;
        }

        return $response->json();
    }

    /**
     * Build the required headers for Supabase API requests.
     *
     * @param  string|null  $accessToken  Include Bearer token if provided
     * @return array
     */
    protected function headers(?string $accessToken = null): array
    {
        $headers = [
            'apikey'       => $this->key,
            'Content-Type' => 'application/json',
        ];

        if ($accessToken) {
            $headers['Authorization'] = "Bearer {$accessToken}";
        }

        return $headers;
    }
}
