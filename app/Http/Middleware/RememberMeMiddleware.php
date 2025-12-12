<?php

namespace App\Http\MIddleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;

class RememberMeMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() && Cookie::has('remember_token')) {

            $token = Cookie::get('remember_token');

            $user = User::where('remember_token', hash('sha256', $token))->first();

            if ($user) {
                Auth::login($user);
            }
        }

        return $next($request);
    }
}
