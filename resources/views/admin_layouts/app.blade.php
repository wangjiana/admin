<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ env('APP_NAME') }} | 仪表盘</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta content="{{ csrf_token() }}" name="csrf-token">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <style type="text/css">
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            vertical-align: middle;
        }
        .pagination {
            margin-right: 20px;
        }
    </style>

    @yield('css')

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/adminlte/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/adminlte/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/adminlte/dist/css/skins/_all-skins.min.css">
    <!-- Morris chart -->
    {{--<link rel="stylesheet" href="/adminlte/bower_components/morris.js/morris.css">--}}
    <!-- jvectormap -->
    <link rel="stylesheet" href="/adminlte/bower_components/jvectormap/jquery-jvectormap.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    @include('admin_layouts._header')
    <!-- Left side column. contains the logo and sidebar -->
    @include('admin_layouts._left')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    {{ $layout_menu_name }}
                    <small>控制面板</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="/home"><i class="fa fa-dashboard"></i>主页</a></li>
                    @foreach($layout_nav_path as $key => $value)
                        @if($layout_menu_name == $value->menu_name)
                            <li class="active">{{ $value->menu_name }}</li>
                            @break;
                        @else
                            <li><a href="{{ $value->url ?: '#' }}">{{ $value->menu_name }}</a></li>
                        @endif
                    @endforeach
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('admin_layouts._footer')

    <!-- Control Sidebar -->
    @include('admin_layouts._right')
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<script src="{{ asset('layer-v3.1.1/layer/layer.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    toastr.options.closeButton = true;
    toastr.options.progressBar = true;

    jQuery.validator.setDefaults({
        // 错误高亮
        highlight: function(element, errorClass, validClass) {
            $(element).parents("div.form-group").addClass('has-error');
        },
        // 取消错误高亮
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents("div.form-group").removeClass('has-error');
        },
        // 更改错误元素显示位置
        errorPlacement: function(error, element) {
            error.insertAfter(element.parents("div.input-group"));
        },
        // 校验通过元素删除错误 label
        success: function(label, element) {
            label.remove();
        },
        submitHandler: function (form) {

        }
    });

    $.ajaxSetup({
        layerIndex: -1,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function (xhr) {
            this.layerIndex = layer.load();
        },
        success: function (response, textStatus, xhr) {
            toastr.success('请求成功！');
//            layer.alert('请求成功！', {icon: 6});
        },
        error: function (xhr, textStatus) {
            toastr.error('请求失败，请刷新后重试！');
//            layer.alert('请求失败，请刷新后重试！', {icon: 5});
        },
        complete: function (xhr, ts) {
            layer.close(this.layerIndex);
        }
    });
</script>
<script src="{{ asset('js/util.js') }}"></script>

@yield('js')

<!-- jQuery UI 1.11.4 -->
<script src="/adminlte/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
{{--<script src="/adminlte/bower_components/raphael/raphael.min.js"></script>--}}
{{--<script src="/adminlte/bower_components/morris.js/morris.min.js"></script>--}}
<!-- Sparkline -->
<script src="/adminlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="/adminlte/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/adminlte/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/adminlte/dist/js//adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{--<script src="/adminlte/dist/js/pages/dashboard.js"></script>--}}
<!-- AdminLTE for demo purposes -->
<script src="/adminlte/dist/js/demo.js"></script>
</body>
</html>
