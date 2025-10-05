<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Checks if user is admin and allows access
        if ($user && $user->role === 'admin') {
            return $next($request);
        }

        // if request is an api request
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Access denied: You do not have the privileges.'
            ], 403);
        }

        // If not admin, redirect with error message
        return redirect('/')
            ->with('error', 'Access denied: You do not have the privileges.');
    }
}
