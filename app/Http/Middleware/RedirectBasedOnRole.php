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
        if (Auth::check()) {
            $user = Auth::user();

            // If admin tries to access user dashboard, redirect to admin dashboard
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // If regular user tries to access admin area, redirect to user dashboard
            if ($user->role !== 'admin' && $request->is('admin/*')) {
                return redirect()->route('dashboard')
                    ->with('error', 'Access denied: You do not have the privileges.');
            }
        }

        return $next($request);
    }
}
