<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureLoggedOut
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('aid')) {
            return $next($request);
        }

        return response()->json(['message' => 'Forbidden.'], 403);
    }
}
