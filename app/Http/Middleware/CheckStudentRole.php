<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckStudentRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'student') {
            return $next($request);
        }

        // If an Admin or Librarian attempts to access student portal, allow or redirect gracefully
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'librarian'])) {
            return $next($request);
        }

        abort(403, 'Unauthorized access. Student panel only.');
    }
}