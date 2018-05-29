@extends('admin_layouts.app')

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">编辑</h3>

            <div class="box-tools">
                <div class="btn-group pull-right" style="margin-right: 10px">
                    <a href="{{ route('permissions.index') }}" class="btn btn-sm btn-default"><i
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
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label for="id" class="col-sm-2 control-label">ID</label>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="id" name="id" value="{{ $permission->id }}" class="form-control" placeholder="ID" disabled required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">菜单图标</label>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="icon" class="form-control" name="icon" value="{{ $permission->icon }}" placeholder="菜单图标" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">菜单名称</label>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="menu_name" class="form-control" name="menu_name" value="{{ $permission->menu_name }}" placeholder="菜单名称" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">菜单路径</label>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="url" class="form-control" name="url" value="{{ $permission->url }}" placeholder="菜单路径" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">权限名称</label>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="name" name="name" value="{{ $permission->name }}" class="form-control" placeholder="权限名称" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="created_at" class="col-sm-2 control-label">创建时间</label>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="created_at" name="created_at" value="{{ $permission->created_at }}" class="form-control" placeholder="创建时间" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="updated_at" class="col-sm-2 control-label">更新时间</label>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="updated_at" name="updated_at" value="{{ $permission->updated_at }}" class="form-control" placeholder="更新时间" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
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

            $(function () {
                $("#appForm").validate({
                    rules: {
                        menu_name: {
                            required: true,
                            normalizer: function(value) {
                                return $.trim(value);
                            }
                        },
                        name: {
                            required: true,
                            normalizer: function(value) {
                                return $.trim(value);
                            }
                        }
                    },
                    messages: {
                        menu_name: {
                            required: '菜单名称不能为空'
                        },
                        name: {
                            required: '权限标识不能为空'
                        }
                    },
                    submitHandler: function (form) {
                        $.ajax({
                            type: 'PUT',
                            url: '/permissions/' + "{{ $permission->id }}",
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