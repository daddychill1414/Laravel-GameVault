<?php

namespace App\Http\Controllers;

use App\Services\SupabaseService;
use Illuminate\Http\Request;

/**
 * AuthController
 *
 * Handles user authentication via Supabase.
 * Login, register, and logout are all server-side (Blade forms + PHP).
 * No JavaScript authentication is needed.
 */
class AuthController extends Controller
{
    /**
     * The Supabase service instance.
     */
    protected SupabaseService $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

    /**
     * Show the login form.
     *
     * GET /login
     */
    public function showLogin()
    {
        // If already logged in, go to games
        if (session()->has('supabase_user')) {
            return redirect()->route('games.index');
        }

        return view('auth.login');
    }

    /**
     * Handle a login request.
     *
     * POST /login
     * Validates credentials, calls Supabase Auth API, stores user in session.
     */
    public function login(Request $request)
    {
        // Validate the form input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        try {
            // Call Supabase Auth API to sign in
            $response = $this->supabase->signIn(
                $request->input('email'),
                $request->input('password')
            );

            // Store user data and token in the Laravel session
            session([
                'supabase_user' => [
                    'id'    => $response['user']['id'],
                    'email' => $response['user']['email'],
                ],
                'supabase_access_token'  => $response['access_token'],
                'supabase_refresh_token' => $response['refresh_token'] ?? null,
            ]);

            return redirect()->route('games.index')
                ->with('success', 'Welcome back! You are now logged in.');

        } catch (\Exception $e) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Show the registration form.
     *
     * GET /register
     */
    public function showRegister()
    {
        // If already logged in, go to games
        if (session()->has('supabase_user')) {
            return redirect()->route('games.index');
        }

        return view('auth.register');
    }

    /**
     * Handle a registration request.
     *
     * POST /register
     * Validates input, creates user in Supabase, auto-logs in.
     */
    public function register(Request $request)
    {
        // Validate the form input
        $request->validate([
            'email'                 => 'required|email',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        try {
            // Call Supabase Auth API to create the user
            $response = $this->supabase->signUp(
                $request->input('email'),
                $request->input('password')
            );

            // Check if Supabase returned a session (auto-confirm enabled)
            if (isset($response['access_token'])) {
                // Auto-login: store user in session
                session([
                    'supabase_user' => [
                        'id'    => $response['user']['id'],
                        'email' => $response['user']['email'],
                    ],
                    'supabase_access_token'  => $response['access_token'],
                    'supabase_refresh_token' => $response['refresh_token'] ?? null,
                ]);

                return redirect()->route('games.index')
                    ->with('success', 'Account created! Welcome to GameVault.');
            }

            // If email confirmation is required, redirect to login
            return redirect()->route('login')
                ->with('success', 'Account created! Please check your email to confirm, then log in.');

        } catch (\Exception $e) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Handle logout.
     *
     * POST /logout
     * Signs out from Supabase and clears the Laravel session.
     */
    public function logout()
    {
        // Call Supabase to invalidate the token
        $token = session('supabase_access_token');
        if ($token) {
            $this->supabase->signOut($token);
        }

        // Clear all Supabase data from the session
        session()->forget(['supabase_user', 'supabase_access_token', 'supabase_refresh_token']);

        return redirect()->route('login')
            ->with('success', 'You have been logged out.');
    }
}
