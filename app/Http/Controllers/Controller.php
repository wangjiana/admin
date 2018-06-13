<?php

namespace App\Http\Controllers;

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
        $this->middleware('permission');

        if (! $request->ajax()) {
            $menus = $this->getMenus();
            $routeName = Route::currentRouteName();
            $menuName = $this->getCurrentMenuName($menus, $routeName);
            $navPath = $this->getNavPath($this->getMenus(), $routeName);

            view()->share('layout_menus', $menus);
//        view()->share('layout_uri', '/' . $request->path());
            view()->share('layout_route_name', $routeName);
            view()->share('layout_menu_name', $menuName);
            view()->share('layout_nav_path', $navPath);
        }
    }

    protected function getMenus()
    {
        return Permission::getPermissionsTree();
    }

    protected function getCurrentMenuName($menus, $routeName)
    {
        $data = treeFindNode($menus, 'name', $routeName);
        return $data->menu_name;
    }

    protected function getNavPath($menus, $routeName)
    {
        $data = treeFindNode($menus, 'name', $routeName, true);
        $data = treeToArray([$data]);
        return $data;
    }
}
