<?php

namespace App\Http\Controllers;

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
        $menus = $this->getMenus();
        view()->share('layout_menus', $menus);
        view()->share('layout_uri', '/' . $request->path());
    }

    protected function getMenus()
    {
        $permission = Permission::where('parent_id', 0)->orWhere('url', '!=', '')->orderBy('sort')->get();
        return arrayToTree($permission);
    }
}
