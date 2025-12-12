<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class RedirectToRegistrationIfNoUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!User::exists()) {
            return Redirect::route('register');
        }

        return $next($request);
    }
}
