<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        if ($request->user()->role->value !== $role) {
            abort(403);
        }
        return $next($request);
    }
}