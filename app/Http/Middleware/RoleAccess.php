<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleAccess
{
    public function handle(Request $request, Closure $next, string $area = 'public'): Response
    {
        $user = Auth::user();

        // =========================
        // GUEST-ONLY CHECKS
        // =========================
        if (!$user) {
            if ($area === 'customer' || $area === 'admin') {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Authentication required'], 401);
                }

                return redirect()->route('login')
                    ->with('error', 'Please log in to continue.');
            }

            return $next($request);
        }

        // =========================
        // ADMIN HAS FULL ACCESS
        // =========================
        if ($user->role === 'admin') {
            return $next($request);
        }

        // =========================
        // CUSTOMER RESTRICTIONS
        // =========================
        if ($area === 'admin') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Admin access only'], 403);
            }

            return redirect()->route('dashboard')
                ->with('error', 'You do not have admin privileges.');
        }

        return $next($request);
    }
}
