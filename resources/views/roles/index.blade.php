@extends('admin_layouts.app')

@section('css')
    <style>
        .model-body-max{
            max-height: 760px;
            overflow-y :auto;
            padding: 0px 15px;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <form class="form-inline">
                        <div class="form-group">
                            <label for="email" class="control-label">角色名</label>
                            <input type="text" name="search" id="search" class="form-control" placeholder="角色名搜索" value="{{ $input['search'] or '' }}">
                            <button type="submit"
                                    style="margin-left: -3px; border-top-left-radius: 0; border-bottom-left-radius: 0;"
                                    class="btn btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>

                        <div class="pull-right">
                            <div class="btn-group pull-right" style="margin-right: 10px">
                                <a href="{{ route('roles.create') }}" class="btn btn-sm btn-success">
                                    <i class="fa fa-save"></i>&nbsp;&nbsp;New
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>#</th>
                            <th>角色名</th>
                            <th>创建时间</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($roles as $key => $role)
                            <tr>
                                <td>{{ $roles->firstItem() + $key }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->created_at }}</td>
                                <td>{{ $role->updated_at }}</td>
                                <td>
                                    <button data-id="{{ $role->id }}" class="btn btn-default btn-sm auth" data-toggle="modal" data-target="#modal">
                                        <i class="fa fa-paper-plane"></i>
                                    </button>
                                    <a href="{{ route('roles.show', [$role->id]) }}" class="btn btn-default btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('roles.edit', [$role->id]) }}" class="btn btn-default btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button data-id="{{ $role->id }}" class="btn btn-default btn-sm destroy">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="pull-right">
                        {{ $roles->appends($input)->links() }}
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalLabel">授权</h4>
                </div>
                <div class="modal-body model-body-max">

                </div>
                <div class="modal-footer">
                    <input type="hidden" id="role_id" value="0">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary save">保存</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            // 授权
            $(document).on('click', 'button.auth', function () {
                var role_id = $(this).attr('data-id');
                $("#role_id").val(role_id);
                $.get('/roles/' + role_id + '/auth', function (data) {
                    $("#modal .modal-body").empty().append(data);
                    $('#modal').modal('show');
                });
            });

            $("button.save").click(function () {
                var role_id = $("#role_id").val();
                $.ajax({
                    type: 'POST',
                    url: '/roles/' + role_id + '/auth',
                    data: $("#modal_form").serialize(),
                    dataType: 'json',
                    success: function (response, textStatus, xhr) {
                        $('#modal').modal('hide');
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
            });

            $("button.destroy").click(function () {
                var id = $(this).attr("data-id");
                $.ajax({
                    type: 'DELETE',
                    url: '/roles/' + id,
                    dataType: 'json',
                    context: this,
                    success: function (response, textStatus, xhr) {
                        $(this).parents('tr').remove();
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
            });
        });
    </script>
@endsection