@extends('admin_layouts.app')

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">新增</h3>

            <div class="box-tools">
                <div class="btn-group pull-right" style="margin-right: 10px">
                    <a href="{{ route('roles.index') }}" class="btn btn-sm btn-default"><i
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
                    <label for="name" class="col-sm-2 control-label">角色名</label>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="name" class="form-control" name="name" placeholder="角色名" maxlength="10" required>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
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

            $(function () {
                $("#appForm").validate({
                    rules: {
                        name: {
                            required: true,
                            normalizer: function(value) {
                                return $.trim(value);
                            },
                            maxlength: 10
//                            ,minlength: {
//                                param: 10,
//                                depends: function (element) {
//                                    return true;
//                                }
//                            }
                        }
                    },
                    messages: {
                        name: {
                            required: '角色名不能为空',
                            maxlength: '角色名最多为10个字符'
                        }
                    },
                    submitHandler: function (form) {
                        $.ajax({
                            type: 'POST',
                            url: '/roles',
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