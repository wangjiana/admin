<?php

namespace App\Http\Controllers;

use Auth;
use App\Handlers\ImageUploadHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class uploadFileController extends Controller
{
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'message'   => '上传失败!',
            'file_path' => ''
        ];

        // 灵活定义前端文件 input name
        $inputName = $request->input('input_name', 'upload_file');
        $folder = $request->input('folder', 'default');

        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->{$inputName}) {
            // 保存图片到本地
            $result = $uploader->save($file, $folder, Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['file_path'];
                $data['message']   = "上传成功!";
                $data['success']   = true;

                return response()->json($data, Response::HTTP_CREATED);
            }
        }

        return response()->json($data, Response::HTTP_BAD_REQUEST);
    }

    public function deleteImage(Request $request)
    {
        $file_path = public_path() . $request->key;

        unlink($file_path);

        return response()->json(['delete_image' => $file_path, 'message' => '删除成功！']);
    }
}
