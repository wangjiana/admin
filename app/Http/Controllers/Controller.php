<?php

namespace App\Http\Controllers;

use Auth;
use Route;
use App\Models\Permission;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Request $request)
    {
        $this->middleware('auth');

        $this->middleware('permission');

        $this->middleware(function ($request, $next) {
            if (! $request->ajax()) {
                $routeName = Route::currentRouteName();
                $menuName = Permission::firstByName($routeName)->menu_name;
                $navPath = $this->getNavPath(Auth::user()->getAllPermissionsTree(), $routeName);

                view()->share('layout_menus', Auth::user()->getAllPermissionsTree());
                view()->share('layout_route_name', $routeName);
                view()->share('layout_menu_name', $menuName);
                view()->share('layout_nav_path', $navPath);
            }

            return $next($request);
        });
    }

    protected function getNavPath($menus, $routeName)
    {
        $data = treeFindNode($menus, 'name', $routeName, true);
        $data = treeToArray([$data]);
        return $data;
    }
}
