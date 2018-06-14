<?php

namespace App\Http\Middleware;

use App\Models\Permission as PermissionModel;
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
            return redirect('/login');
        }

        $user = Auth::user();
        $routeName = Route::currentRouteName();
        $permission = PermissionModel::firstByName($routeName);

        if ($permission && !$user->can($routeName)) {
            return redirect()->back();
        }

        return $next($request);
    }
}
