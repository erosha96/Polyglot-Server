<?php

namespace App\Http\Middleware;

use Closure;
use App\UsersToken;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = UsersToken::where('token', $request->bearerToken())->first();
        if (!$token) {
            abort(403, 'Access denied');
        }
        $user = UsersToken::where('token', $request->bearerToken())->first()->user;
        if (!$user) {
            abort(403, 'Access denied');
        } else {
            $request->setUserResolver(function () use ($user) {
                return $user;
            });
            return $next($request);
        }
    }
}
