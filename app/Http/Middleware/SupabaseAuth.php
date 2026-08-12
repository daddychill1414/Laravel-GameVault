<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * SupabaseAuth Middleware
 *
 * Protects routes by checking if the user is authenticated via Supabase.
 * Authentication state is stored in Laravel's session after login.
 *
 * Usage in routes: ->middleware('supabase.auth')
 */
class SupabaseAuth
{
    /**
     * Handle an incoming request.
     *
     * Checks if the session contains Supabase user data.
     * If not authenticated, redirects to the login page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user data exists in the session
        if (!session()->has('supabase_user')) {
            return redirect()->route('login')
                ->with('error', 'Please log in to access your game vault.');
        }

        // Share user data with all views so the layout can display it
        view()->share('authUser', session('supabase_user'));

        return $next($request);
    }
}
