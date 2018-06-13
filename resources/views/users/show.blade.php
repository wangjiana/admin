@extends('admin_layouts.app')

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">查看</h3>

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
        <form class="form-horizontal">
            <div class="box-body">
                <div class="form-group">
                    <label for="id" class="col-md-2 control-label">ID</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="id" name="id" value="{{ $user->id }}" class="form-control" placeholder="ID" disabled>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-md-2 control-label">用户名</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control" placeholder="用户名" disabled>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username" class="col-md-2 control-label">邮箱</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="text" id="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="邮箱" disabled>
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

                <div class="form-group  ">
                    <label for="updated_at" class="col-md-2 control-label">更新时间</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="updated_at" name="updated_at" value="{{ $user->updated_at }}" class="form-control updated_at" placeholder="更新时间" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </form>
    </div>
@endsection