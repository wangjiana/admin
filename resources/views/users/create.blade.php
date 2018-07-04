@extends('admin_layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('bootstrap-fileinput/css/fileinput.min.css') }}">
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">新增</h3>

            <div class="box-tools">
                <div class="btn-group pull-right" style="margin-right: 10px">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-default"><i
                                class="fa fa-list"></i>&nbsp;列表</a>
                </div>
                <div class="btn-group pull-right" style="margin-right: 10px">
                    <a href="javascript:history.back();" class="btn btn-sm btn-default form-history-back"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>
                </div>
            </div>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form id="appForm" class="form-horizontal">
            <div class="box-body">
                <div class="form-group">
                    <label for="name" class="col-md-2 control-label">用户名</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="name" name="name" class="form-control" placeholder="用户名" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-md-2 control-label">邮箱</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="email" id="email" name="email" class="form-control" placeholder="邮箱" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="upload_file" class="col-md-2 control-label">头像</label>

                    <div class="col-md-8">
                        <input type="file" id="upload_file" name="upload_file" class="form-control" placeholder="头像">
                        <input type="hidden" id="avatar" name="avatar" class="form-control" placeholder="头像">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-md-2 control-label">密码</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-eye-slash"></i></span>
                            <input type="password" id="password" name="password" class="form-control" placeholder="密码" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="col-md-2 control-label">密码确认</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-eye-slash"></i></span>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control password_confirmation" placeholder="密码确认" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="role_id" class="col-md-2 control-label">角色</label>

                    <div class="col-md-8">
                        <select id="role_id" name="role_id" class="form-control" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <button type="reset" class="btn btn-default">重置</button>
                    <button type="submit" class="btn btn-info pull-right">保存</button>
                </div>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>
@endsection

@section('js')
    {{--<script src="{{ asset('bootstrap-fileinput/js/plugins/piexif.min.js') }}"></script>--}}
    {{--<script src="{{ asset('bootstrap-fileinput/js/plugins/purify.min.js') }}"></script>--}}
    {{--<script src="{{ asset('bootstrap-fileinput/js/plugins/sortable.min.js') }}"></script>--}}
    <script src="{{ asset('bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    {{--<script src="{{ asset('bootstrap-fileinput/themes/fa/theme.min.js') }}"></script>--}}
    <script src="{{ asset('bootstrap-fileinput/js/locales/zh.js') }}"></script>
    <script>
        (function () {
            'use strict';

            $("select").select2();

            function submitForm(form) {
                // 保存用户信息
                $.ajax({
                    type: 'POST',
                    url: '/users',
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function (response, textStatus, xhr) {
                        toastr.success(response.message);
                    },
                    error: function (xhr, textStatus, error) {
                        if (xhr.status == 422) {
                            // request 校验不通过
                            var errors = xhr.responseJSON.errors;
                            var errorsHtml = '';
                            $.each(errors, function(key, value) {
                                errorsHtml += '<li>' + value[0] + '</li>';
                            });
                            toastr.error(errorsHtml);
                        } else {
                            toastr.error(xhr.responseJSON.message);
                        }
                    }
                });
            }

            $(function () {
                $("#upload_file").fileinput({
                    previewFileType: "image",
                    language: "zh",
                    showUpload: false,
                    maxFileSize: 1024, // KB
                    allowedFileExtensions: ["jpg", 'jpeg', "png", "gif"],
                    allowedFileTypes: ["image"]
                }).on('filecleared', function(event) {
                    $("#avatar").val('');
                });

                $("#appForm").validate({
                    rules: {
                        name: {
                            required: true,
                            normalizer: function(value) {
                                return $.trim(value);
                            }
                        },
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true,
                            normalizer: function(value) {
                                return $.trim(value);
                            },
                            minlength: 6
                        },
                        password_confirmation: {
                            required: true,
                            normalizer: function(value) {
                                return $.trim(value);
                            },
                            equalTo: "#password"
                        },
                        role_id: {
                            required: true,
                            number: true,
                            min: 1
                        }
                    },
                    messages: {
                        name: {
                            required: '用户名不能为空'
                        },
                        email: {
                            required: '邮箱不能为空',
                            email: '请输入有效的邮箱地址。'
                        },
                        password: {
                            required: '密码不能为空',
                            minlength: '密码不能少于6个字符'
                        },
                        password_confirmation: {
                            required: '密码确认不能为空',
                            equalTo: '请输入相同的密码'
                        },
                        role_id: {
                            required: '角色不能为空',
                            number: '请选择有效角色',
                            min: '请选择有效角色'
                        }
                    },
                    submitHandler: function (form) {
                        var upload_file = $("#upload_file").val();

                        if (upload_file) {
                            var  formData = new FormData();
                            formData.append('upload_file', $("#upload_file")[0].files[0]); // 上传该文件
                            formData.append('input_name', 'upload_file'); // 上传文件时接收的参数名
                            formData.append('folder', 'avatar'); // 保存图片的目录名

                            // 上传图片
                            $.ajax({
                                type: 'POST',
                                url: '/upload_image',
                                data: formData,
                                dataType: 'json',
                                processData: false, // 不处理发送的数据
                                contentType: false, // 不处理头信息
                                success: function(data){
                                    $("#avatar").val(data.file_path);

                                    // 保存用户信息
                                    submitForm(form);
                                },
                                error: function (xhr, textStatus, error) {
                                    if (xhr.status == 422) {
                                        // request 校验不通过
                                        var errors = xhr.responseJSON.errors;
                                        var errorsHtml = '';
                                        $.each(errors, function(key, value) {
                                            errorsHtml += '<li>' + value[0] + '</li>';
                                        });
                                        toastr.error(errorsHtml);
                                    } else {
                                        toastr.error(xhr.responseJSON.message);
                                    }
                                }
                            });
                        } else {
                            // 保存用户信息
                            submitForm(form);
                        }

                    }
                });
            });
        })();
    </script>
@endsection