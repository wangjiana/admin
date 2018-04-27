@extends('admin_layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <form class="form-inline">
                        <div class="form-group">
                            <label for="name" class="control-label">用户名</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="用户名" value="{{$input['name'] or ''}}">
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">邮箱</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="邮箱" value="{{$input['email'] or ''}}">
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label">关键字搜索</label>
                            <input type="text" name="search" id="search" class="form-control" placeholder="关键字搜索" value="{{$input['search'] or ''}}">
                            <button type="submit"
                                    style="margin-left: -3px; border-top-left-radius: 0; border-bottom-left-radius: 0;"
                                    class="btn btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>

                        <div class="pull-right">
                            {{--<div class="btn-group pull-right" style="margin-right: 10px">--}}
                                {{--<a class="btn btn-sm btn-twitter"><i class="fa fa-download"></i> Export</a>--}}
                                {{--<button type="button" class="btn btn-sm btn-twitter dropdown-toggle" data-toggle="dropdown">--}}
                                    {{--<span class="caret"></span>--}}
                                    {{--<span class="sr-only">Toggle Dropdown</span>--}}
                                {{--</button>--}}
                                {{--<ul class="dropdown-menu" role="menu">--}}
                                    {{--<li><a href="/demo/auth/users?_export_=all" target="_blank">All</a></li>--}}
                                    {{--<li><a href="/demo/auth/users?_export_=page%3A1" target="_blank">Current page</a></li>--}}
                                    {{--<li><a href="/demo/auth/users?_export_=selected%3A__rows__" target="_blank" class="export-selected">Selected rows</a></li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}

                            <div class="btn-group pull-right" style="margin-right: 10px">
                                <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">
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
                            <th>用户名</th>
                            <th>邮箱</th>
                            <th>创建时间</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($users as $key => $user)
                            <tr>
                                <td>{{ $users->firstItem() + $key }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>
                                {{--<td>--}}
                                    {{--<a href=""><i class="fa fa-eye"></i></a>--}}
                                    {{--<a href="/demo/auth/users/2/edit">--}}
                                        {{--<i class="fa fa-edit"></i>--}}
                                    {{--</a><a href="javascript:void(0);" data-id="2" class="grid-row-delete">--}}
                                        {{--<i class="fa fa-trash"></i>--}}
                                    {{--</a>--}}
                                {{--</td>--}}
                                <td>
                                    <a href="{{ route('users.show', [$user->id]) }}" class="btn btn-default btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('users.edit', [$user->id]) }}" class="btn btn-default btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button href="javascript:void(0);" data-id="55" class="btn btn-default btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="pull-right">
                        {{ $users->appends($input)->links() }}
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection