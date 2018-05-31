@extends('admin_layouts.app')

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">查看</h3>

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
        <form class="form-horizontal">
            <div class="box-body">
                <div class="form-group">
                    <label for="id" class="col-md-2 control-label">ID</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="id" name="id" value="{{ $permission->id }}" class="form-control" placeholder="ID" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-2 control-label">菜单图标</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="icon" class="form-control" name="icon" value="{{ $permission->icon }}"  placeholder="菜单图标" required disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-2 control-label">菜单名称</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="menu_name" class="form-control" name="menu_name" value="{{ $permission->menu_name }}" placeholder="菜单名称" required disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-2 control-label">菜单路径</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="url" class="form-control" name="url" value="{{ $permission->url }}" placeholder="菜单路径" required disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-md-2 control-label">权限标识</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="name" name="name" value="{{ $permission->name }}" class="form-control" placeholder="权限标识" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="created_at" class="col-md-2 control-label">创建时间</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="created_at" name="created_at" value="{{ $permission->created_at }}" class="form-control" placeholder="创建时间" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="updated_at" class="col-md-2 control-label">更新时间</label>

                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="updated_at" name="updated_at" value="{{ $permission->updated_at }}" class="form-control updated_at" placeholder="更新时间" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </form>
    </div>
@endsection