<form id="modal_form">
    <table id="table" class="table table-hover">
        <tbody>
        <tr>
            <th><input type="checkbox" class="minimal" id="all" @if(empty(array_diff(array_column($permissions, 'id'), $role_permissions))) checked @endif></th>
            <th>菜单名称</th>
        </tr>
        @foreach($permissions as $permission)
            <tr>
                <td><input type="checkbox" class="minimal" name="permission_ids[]" pid="{{$permission->parent_id}}" value="{{$permission->id}}" @if(in_array($permission->id, $role_permissions)) checked @endif></td>
                <td>{{ $permission->delimiter }}{{ $permission->menu_name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</form>

<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="/adminlte/plugins/iCheck/all.css">
<!-- iCheck 1.0.1 -->
<script src="/adminlte/plugins/iCheck/icheck.min.js"></script>

<script type="text/javascript">
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });

    // 全选
    $('#all').on('ifChecked', function () {
        $('table input[type="checkbox"]').iCheck('check');
    }).on('ifUnchecked', function () {
        $('table input[type="checkbox"]').iCheck('uncheck');
    });

    // 选中、取消选中
    $('table input[type="checkbox"]').each(function () {
        $(this).on('ifChecked', function () {
            var current_id = $(this).val();
            var parent_id = $(this).attr('pid');

            $("table input[type='checkbox'][value='" + parent_id + "']").iCheck('check');
            if ($("table input[type='checkbox'][pid='" + current_id + "']:checked").length <= 0) {
                $("table input[type='checkbox'][pid='" + current_id + "']").iCheck('check');
            }
        });
        $(this).on('ifUnchecked', function () {
            var current_id = $(this).val();
            var parent_id = $(this).attr('pid');

            $("table input[type='checkbox'][pid='" + current_id + "']").iCheck('uncheck');
            if ($("table input[type='checkbox'][pid='" + parent_id + "']:checked").length <= 0) {
                $("table input[type='checkbox'][value='" + parent_id + "']").iCheck('uncheck');
            }
        });
    });
</script>