@extends('admin_layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-12">
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
@endsection

@section('js')
    <script>
        $(function () {
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