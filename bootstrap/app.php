<?php

use App\Http\Middleware\CheckLibrarianRole;
use App\Http\Middleware\CheckStudentRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Redirect unauthenticated guests to login URL
        $middleware->redirectGuestsTo(fn (Request $request) => '/login');

        // Register Middleware Aliases
        $middleware->alias([
            'librarian' => CheckLibrarianRole::class,
            'student'   => CheckStudentRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();