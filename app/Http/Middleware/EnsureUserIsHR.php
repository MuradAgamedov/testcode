<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsHR
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        dd(auth('hr')->user());
        if (auth('hr')->user()?->user_type !== 'hr') {
            return response()->json(['message' => 'Unauthorized. HR only.'], 403);
        }

        return $next($request);
    }
}
