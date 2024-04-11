<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return $next($request);
        }

        if (!$user->is_active) {
            return response()->json([
                'message' => 'User is not active'
            ], 403);
        }

        return $next($request);
    }
}
