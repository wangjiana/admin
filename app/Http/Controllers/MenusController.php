<?php

namespace App\Http\Controllers;

use Cache;
use DB;
use App\Models\Permission;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MenusController extends Controller
{
    public function index()
    {
        $menus = Permission::getPermissionsTree();

        return view('menus.index', compact('menus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->input('data');
        $data = treeToArray($data);

        DB::beginTransaction();
        try {
            foreach ($data as $key => $value) {
                Permission::where('id', $value['id'])->update(['parent_id' => $value['parent_id'], 'sort' => $key]);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['message' => '操作失败'], Response::HTTP_BAD_REQUEST);
        }
        DB::commit();

        Cache::tags('layout_menus')->flush();

        return response()->json(['message' => '操作成功'], Response::HTTP_OK);
    }
}
