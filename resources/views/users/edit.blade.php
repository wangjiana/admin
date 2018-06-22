@extends('admin_layouts.app')

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">编辑</h3>

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
                    <label for="id" class="col-md-2 control-label">ID</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="id" name="id" value="{{ $user->id }}" class="form-control" placeholder="ID" disabled required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-md-2 control-label">用户名</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control" placeholder="用户名" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username" class="col-md-2 control-label">邮箱</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="邮箱" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-md-2 control-label">密码</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-eye-slash"></i></span>
                            <input type="password" id="password" name="password" value="" class="form-control" placeholder="密码">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="col-md-2 control-label">密码确认</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-eye-slash"></i></span>
                            <input type="password" id="password_confirmation" name="password_confirmation" value="" class="form-control password_confirmation" placeholder="密码确认">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="role_id" class="col-md-2 control-label">角色</label>

                    <div class="col-md-8">
                        <select id="role_id" name="role_id" class="form-control">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @if(in_array($role->name, $userRoleNames)) selected @endif>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="created_at" class="col-md-2 control-label">创建时间</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="created_at" name="created_at" value="{{ $user->created_at }}" class="form-control" placeholder="创建时间" disabled>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="updated_at" class="col-md-2 control-label">更新时间</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="updated_at" name="updated_at" value="{{ $user->updated_at }}" class="form-control" placeholder="更新时间" disabled>
                        </div>
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
    <script>
        (function () {
            'use strict';

            $("select").select2();

            $(function () {
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
                            normalizer: function(value) {
                                return $.trim(value);
                            },
                            minlength: {
                                param: 6,
                                depends: function (element) {
                                    if ($(element).val()) {
                                        return true;
                                    } else {
                                        return false;
                                    }
                                }
                            }
                        },
                        password_confirmation: {
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
                            required: '用户名不能为空',
                            maxlength: '用户名最多为10个字符'
                        },
                        email: {
                            required: '邮箱不能为空',
                            email: '请输入有效的邮箱地址。'
                        },
                        password: {
                            minlength: '密码不能少于6个字符'
                        },
                        password_confirmation: {
                            equalTo: '请输入相同的密码'
                        },
                        role_id: {
                            required: '角色不能为空',
                            number: '请选择有效角色',
                            min: '请选择有效角色'
                        }
                    },
                    submitHandler: function (form) {
                        $.ajax({
                            type: 'PUT',
                            url: '/users/' + "{{ $user->id }}",
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
                });
            });
        })();
    </script>
@endsection