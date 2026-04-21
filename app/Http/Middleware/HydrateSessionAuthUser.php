<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HydrateSessionAuthUser
{
    public function handle(Request $request, Closure $next): Response
    {
        $sessionUser = $request->session()->get('auth_user');

        if (is_array($sessionUser) && ! empty($sessionUser)) {
            $user = new User();
            $user->forceFill($sessionUser);
            $user->exists = true;

            Auth::setUser($user);
            $request->setUserResolver(static fn () => $user);
        }

        return $next($request);
    }
}
