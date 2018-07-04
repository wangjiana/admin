<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ ! empty(Auth::user()->avatar) ? Auth::user()->avatar : asset('images/default.png') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="{{ route('users.edit', [Auth::id()]) }}"><i class="fa fa-circle text-success"></i> {{ Auth::user()->getRoleNames()->toArray()[0] }}</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">主要导航</li>
            @foreach ($layout_menus as $menu)
                @if (! empty($menu['children']))
                    <li class="@if(in_array($layout_route_name, array_column($menu->children, 'name')) || in_array($layout_route_name, array_column(arrayChildMerge(array_column($menu->children, 'children')), 'name'))) active @endif treeview">
                        <a href="@if($menu->url) {{ $menu->url }} @else # @endif">
                            <i class="@if($menu->icon) {{ $menu->icon }} @else fa fa-tasks @endif"></i> <span>{{ $menu->menu_name }}</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>

                        <ul class="treeview-menu">
                            @foreach($menu->children as $value)
                                <li @if($value->name == $layout_route_name || in_array($layout_route_name, array_column($value->children, 'name'))) class="active" @endif><a href="{{ $value->url }}"><i class="@if($value->icon) {{ $value->icon }} @else fa fa-circle-o @endif"></i> {{ $value->menu_name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li @if($menu->name == $layout_route_name) class="active" @endif>
                        <a href="@if($menu->url) {{ $menu->url }} @else # @endif">
                            <i class="{{ $menu->icon or 'fa fa-tasks' }}"></i> <span>{{ $menu->menu_name }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>