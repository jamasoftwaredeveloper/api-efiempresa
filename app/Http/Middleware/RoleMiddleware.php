<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $roleOrPermission)
    {
        if (!Auth::check() || !$request->user()->hasAnyRole([$roleOrPermission]) && !$request->user()->hasPermissionTo($roleOrPermission)) {
            return response()->json(['error' => 'No tienes permiso'], 403);
        }

        return $next($request);
    }
}
