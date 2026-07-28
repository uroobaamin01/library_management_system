<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLibrarianRole
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->role, ['librarian', 'admin'])) {
            return $next($request);
        }

        abort(403, 'Unauthorized action. Only Librarians and Admins can access this section.');
    }
}