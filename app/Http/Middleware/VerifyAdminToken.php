<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class VerifyAdminToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $adminToken = User::find(1);
        if ($request->header('Authorization') !== $adminToken->remember_token) {
            return response()->json(['message' => 'Invalid token'], Response::HTTP_BAD_REQUEST);
        }

        return $next($request);
    }
}
