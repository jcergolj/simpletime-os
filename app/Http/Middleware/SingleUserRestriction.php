<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SingleUserRestriction
{
    public function handle(Request $request, Closure $next): Response
    {
        if (User::exists()) {
            if ($request->expectsJson()) {
                return new JsonResponse([
                    'message' => __('Registration is disabled. Only one user is allowed per application.'),
                ], Response::HTTP_FORBIDDEN);
            }

            // For web requests, redirect to login with message
            return to_route('login')->with('error', __('Registration is disabled. Only one user is allowed per application.'));
        }

        return $next($request);
    }
}
