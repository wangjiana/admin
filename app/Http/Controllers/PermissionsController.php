<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class PermissionsController extends Controller
{
    public function index(PermissionRequest $request)
    {
        $input = $request->all();
        $permissions = Permission::where(function ($query) use ($input) {
            if (! empty($input['search'])) {
                $query->where('name', 'like', "%{$input['search']}%")->orWhere('menu_name', 'like', "%{$input['search']}%");
            }
        })->paginate();

        return view('permissions.index', compact('input', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $input = $request->all();
        Permission::create($input);
        return response()->json(['message' => '操作成功'], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return view('permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        $input = $request->all();
        $permission->update($input);
        return response()->json(['message' => '操作成功'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(['message' => '操作成功'], Response::HTTP_OK);
    }
}
