<?php

namespace App\Http\Controllers;

use Auth;
use App\Handlers\ImageUploadHandler;
use Illuminate\Http\Request;

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
                $data['file_path'] = $result['path'];
                $data['message']   = "上传成功!";
                $data['success']   = true;
            }
        }

        return $data;
    }
}
