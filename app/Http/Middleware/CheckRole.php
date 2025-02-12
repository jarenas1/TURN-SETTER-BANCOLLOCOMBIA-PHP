<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $userRole = Auth::user()->role->value;
    
    if ($userRole !== $role) {
        abort(403, 'Acceso no autorizado');
    }

    return $next($request);
}
}