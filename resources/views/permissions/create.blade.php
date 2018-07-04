@extends('admin_layouts.app')

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">新增</h3>

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
            <div class="box-body">
                <div class="form-group">
                    <label for="name" class="col-md-2 control-label">父级菜单</label>

                    <div class="col-md-8">
                        <select id="parent_id" name="parent_id" class="form-control">
                            <option value="0">根目录</option>

                            @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}">{{ $permission->delimiter }}{{ $permission->menu_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-2 control-label">菜单图标</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="icon" class="form-control" name="icon" placeholder="菜单图标">
                        </div>
                        <span class="help-block">
    <i class="fa fa-info-circle"></i>&nbsp;For more icons please see <a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons/</a>
</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-2 control-label">菜单名称</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="menu_name" class="form-control" name="menu_name" placeholder="菜单名称" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-2 control-label">菜单路径</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="url" class="form-control" name="url" placeholder="菜单路径">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-2 control-label">权限标识</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="name" class="form-control" name="name" placeholder="权限标识" required>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <button type="reset" class="btn btn-default">重置</button>
                    <button type="submit" class="btn btn-info pull-right store">保存</button>
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
                            type: 'POST',
                            url: '/permissions',
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