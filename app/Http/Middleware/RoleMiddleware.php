<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if ($user->role !== $role) {
            return response()->json([
                'status' => 'error',
                'message' => 'Forbidden. You do not have permission to create blog categories.',
                'status_code' => 403
            ], 403);
        }

        return $next($request);
    }
}
