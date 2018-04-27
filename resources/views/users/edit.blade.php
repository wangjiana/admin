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
        <form class="form-horizontal" method="post" action="{{ route('users.update', [$user->id]) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="box-body">
                <div class="form-group @if($errors->has('id')) has-error @endif">
                    <label for="id" class="col-sm-2 control-label">ID</label>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="id" name="id" value="{{ old('id', $user->id) }}" class="form-control" placeholder="ID" disabled required>
                        </div>
                    </div>
                    @if($errors->has('id')) <div class="col-sm-offset-2 col-sm-8 help-block no-margin-bottom">{{ $errors->first('id') }}</div>@endif
                </div>

                <div class="form-group @if($errors->has('name')) has-error @endif">
                    <label for="name" class="col-sm-2 control-label">用户名</label>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" placeholder="用户名" required>
                        </div>
                    </div>
                    @if($errors->has('name')) <div class="col-sm-offset-2 col-sm-8 help-block no-margin-bottom">{{ $errors->first('name') }}</div>@endif
                </div>

                <div class="form-group @if($errors->has('email')) has-error @endif">
                    <label for="username" class="col-sm-2 control-label">邮箱</label>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" placeholder="邮箱" required>
                        </div>
                    </div>
                    @if($errors->has('email')) <div class="col-sm-offset-2 col-sm-8 help-block no-margin-bottom">{{ $errors->first('email') }}</div>@endif
                </div>

                <div class="form-group @if($errors->has('password')) has-error @endif">
                    <label for="password" class="col-sm-2 control-label">密码</label>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-eye-slash"></i></span>
                            <input type="password" id="password" name="password" value="{{ old('password') }}" class="form-control" placeholder="密码">
                        </div>
                    </div>
                    @if($errors->has('password')) <div class="col-sm-offset-2 col-sm-8 help-block no-margin-bottom">{{ $errors->first('password') }}</div>@endif
                </div>

                <div class="form-group @if($errors->has('password_confirmation')) has-error @endif">
                    <label for="password_confirmation" class="col-sm-2 control-label">密码确认</label>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-eye-slash"></i></span>
                            <input type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control password_confirmation" placeholder="密码确认">
                        </div>
                    </div>
                    @if($errors->has('password_confirmation')) <div class="col-sm-offset-2 col-sm-8 help-block no-margin-bottom">{{ $errors->first('password_confirmation') }}</div>@endif
                </div>

                <div class="form-group @if($errors->has('created_at')) has-error @endif">
                    <label for="created_at" class="col-sm-2 control-label">创建时间</label>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="created_at" name="created_at" value="{{ old('created_at', $user->created_at) }}" class="form-control" placeholder="创建时间" disabled>
                        </div>
                    </div>
                    @if($errors->has('created_at')) <div class="col-sm-offset-2 col-sm-8 help-block no-margin-bottom">{{ $errors->first('created_at') }}</div>@endif
                </div>

                <div class="form-group @if($errors->has('updated_at')) has-error @endif">
                    <label for="updated_at" class="col-sm-2 control-label">更新时间</label>

                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                            <input type="text" id="updated_at" name="updated_at" value="{{ old('updated_at', $user->updated_at) }}" class="form-control updated_at" placeholder="更新时间" disabled>
                        </div>
                    </div>
                    @if($errors->has('updated_at')) <div class="col-sm-offset-2 col-sm-8 help-block no-margin-bottom">{{ $errors->first('updated_at') }}</div>@endif
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