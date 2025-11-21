<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (($user->must_change_password ?? false) === true) {
                $allowed = ['logout', 'password.change', 'password.update'];

                $routeName = optional($request->route())->getName();

                if (! in_array($routeName, $allowed, true)) {
                    return redirect()
                        ->route('password.change')
                        ->with('error', 'You must change your password to continue.');
                }
            }
        }

        return $next($request);
    }
}