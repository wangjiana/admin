@extends('admin_layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('nestable/nestable.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">

                <div class="box-header">

                    <div id="nestable-menu" class="btn-group">
                        <a class="btn btn-primary btn-sm" data-action="expand">
                            <i class="fa fa-plus-square-o"></i>&nbsp;展开
                        </a>
                        <a class="btn btn-primary btn-sm" data-action="collapse">
                            <i class="fa fa-minus-square-o"></i>&nbsp;合并
                        </a>
                    </div>

                    <div id="btn-save" class="btn-group">
                        <a class="btn btn-info btn-sm"><i class="fa fa-save"></i>&nbsp;保存</a>
                    </div>

                    <div id="btn-refresh" class="btn-group">
                        <a class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i>&nbsp;刷新</a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">

                    <div class="dd">
                        <ol class="dd-list">
                            @foreach ($menus as $menu)
                            <li class="dd-item" data-id="{{ $menu->id }}">
                                <div class="dd-handle">
                                    <i class="{{ $menu->icon }}"></i>&nbsp;<strong>{{ $menu->menu_name }}</strong>&nbsp;&nbsp;&nbsp;<a href="{{ $menu->url }}">{{ $menu->url }}</a>
                                </div>
                                @if (! empty($menu->children))
                                <ol class="dd-list">
                                    @foreach ($menu->children as $child)
                                    <li class="dd-item" data-id="{{ $child->id }}">
                                        <div class="dd-handle">
                                            <i class="{{ $child->icon }}"></i>&nbsp;<strong>{{ $child->menu_name }}</strong>&nbsp;&nbsp;&nbsp;<a href="{{ $child->url }}">{{ $child->url }}</a>
                                        </div>
                                    </li>
                                    @endforeach
                                </ol>
                                @endif
                            </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('nestable/jquery.nestable.js') }}"></script>
    <script>
        $(function () {
            $('.dd').nestable({maxDepth: 2});

            $('#nestable-menu').on('click', function(e) {
                var target = $(e.target),
                    action = target.data('action');
                if (action === 'expand') {
                    $('.dd').nestable('expandAll');
                }
                if (action === 'collapse') {
                    $('.dd').nestable('collapseAll');
                }
            });

            $("#btn-save").click(function () {
                $.ajax({
                    type: 'PUT',
                    url: '/menus/' + 1,
                    data: {data: $('.dd').nestable('serialize')},
                    dataType: 'json',
                    success: function (response, textStatus, xhr) {
                        toastr.success(response.message);
                        location.reload();
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

            $("#btn-refresh").click(function () {
                toastr.success('刷新成功');
                location.reload();
            });
        });
    </script>
@endsection