<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Permission
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
        if (! Auth::check()) {
            return redirect('/home');
        }

        $user = Auth::user();
        $routeName = Route::currentRouteName();

        if (! $user->can($routeName)) {
            return redirect()->back();
        }

        return $next($request);
    }
}
