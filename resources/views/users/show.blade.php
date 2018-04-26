@extends('admin_layouts.app')

@section('content')
    <div class="box box-info">
        {{--<div class="box-header with-border">--}}
        {{--<h3 class="box-title">Horizontal Form</h3>--}}
        {{--</div>--}}
        <div class="box-header with-border">
            <h3 class="box-title">Edit</h3>

            <div class="box-tools">
                <div class="btn-group pull-right" style="margin-right: 10px">
                    <a href="http://laravel-admin.org/demo/auth/users" class="btn btn-sm btn-default"><i
                                class="fa fa-list"></i>&nbsp;List</a>
                </div>
                <div class="btn-group pull-right" style="margin-right: 10px">
                    <a class="btn btn-sm btn-default form-history-back"><i class="fa fa-arrow-left"></i>&nbsp;Back</a>
                </div>
            </div>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal">
            <div class="box-body">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-8">
                        <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>

                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"> Remember me
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="col-sm-2">

                </div>
                <div class="col-sm-8">
                    <button type="submit" class="btn btn-default">Cancel</button>
                    <button type="submit" class="btn btn-info pull-right">Sign in</button>
                </div>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>
@endsection