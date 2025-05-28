<?php

namespace App\Http\Middleware;
use Closure;

class CheckTokenExpiry
{
    public function handle($request, Closure $next)
    {
        $token = $request->user()?->currentAccessToken();
        if ($token && $token->expires_at && now()->greaterThan($token->expires_at)) {
            $token->delete();
            return response()->json(['error' => 'Token expired'], 401);
        }
        return $next($request);
    }
}
