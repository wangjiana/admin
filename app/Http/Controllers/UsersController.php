<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $users = User::where(function ($query) use ($input) {
            if (! empty($input['name'])) {
                $query->where('name', 'like', "%{$input['name']}%");
            }
            if (! empty($input['email'])) {
                $query->where('email', 'like', "%{$input['email']}%");
            }
        })->paginate();

        return view('users.index', compact('input', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $user->assignRole($input['role_id']);

        return response()->json(['message' => '操作成功'], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $roles = Role::all();
        $userRoleNames = $user->getRoleNames()->toArray();
        return view('users.show', compact('user', 'roles', 'userRoleNames'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoleNames = $user->getRoleNames()->toArray();
        return view('users.edit', compact('user', 'roles', 'userRoleNames'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $input = $request->all();
        $input['avatar'] = $input['avatar'] ? : '';

        if (! empty($input['password'])) {
            $input['password'] = bcrypt($input['password']);
        } else {
            unset($input['password']);
        }

        $user->update($input);
        return response()->json(['message' => '操作成功'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => '操作成功'], Response::HTTP_OK);
    }
}
