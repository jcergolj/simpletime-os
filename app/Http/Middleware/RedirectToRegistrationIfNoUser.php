<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectToRegistrationIfNoUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! User::exists()) {
            return to_route('register');
        }

        return $next($request);
    }
}
