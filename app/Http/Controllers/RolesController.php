<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RoleRequest $request)
    {
        $input = $request->all();

        $roles = Role::where(function ($query) use ($input) {
            if (! empty($input['search'])) {
                $query->where('name', 'like', "%{$input['search']}%");
            }
        })->paginate();

        return view('roles.index', compact('input', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $input = $request->all();

        Role::create($input);

        return response()->json(['message' => '操作成功'], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        $input = $request->all();

        $role->update($input);

        return response()->json(['message' => '操作成功'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(['message' => '操作成功'], Response::HTTP_OK);
    }

    public function getRoleAuth(Role $role)
    {
        $permissions = Permission::getPermissionsDelimiter();

        $role_permissions = $role->permissions()->pluck('id')->toArray();

        return view('roles._auth', compact('permissions', 'role_permissions'));
    }

    public function roleAuth(Request $request, Role $role)
    {
        $role->syncPermissions($request->input('permission_ids', []));

        return response()->json(['message' => '操作成功'], Response::HTTP_OK);
    }
}
