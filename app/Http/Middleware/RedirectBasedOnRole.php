<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is not logged in
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        // If admin tries to access user pages
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('info', 'You are logged in as an admin.');
        }

        // If non-admin tries to access admin pages
        if ($user->role !== 'admin' && $request->is('admin/*')) {
                return redirect()->route('dashboard')
                ->with('error', 'Access denied: You do not have admin privileges.');
        }

        return $next($request);
    }
}
