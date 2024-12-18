<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $roles)
{
    $roles = explode('|', $roles); 
    $user = Auth::user();

    if (!$user || !in_array($user->getRoleNames()->first(), $roles)) {
        return response()->json(['error' => 'Forbidden'], 403);
    }

    return $next($request);
}
}
