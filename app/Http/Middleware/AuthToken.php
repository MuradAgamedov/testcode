<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token || !$user = \App\Models\User::where('api_token', $token)->first()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        auth()->login($user);

        return $next($request);
    }
}
