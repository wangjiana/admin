<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'xtgl', 'guard_name' => 'web', 'icon' => 'fa fa-tasks', 'menu_name' => '系统管理', 'url' => '', 'children' => [
                ['name' => 'users.index', 'guard_name' => 'web', 'icon' => 'fa fa-users', 'menu_name' => '用户列表 ', 'url' => '/users'],
                ['name' => 'users.create', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '创建用户', 'url' => ''],
                ['name' => 'users.store', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '保存用户', 'url' => ''],
                ['name' => 'users.edit', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '编辑用户', 'url' => ''],
                ['name' => 'users.update', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '更新用户', 'url' => ''],
                ['name' => 'users.destroy', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '删除用户', 'url' => ''],

                ['name' => 'roles.index', 'guard_name' => 'web', 'icon' => 'fa fa-user', 'menu_name' => '角色列表', 'url' => '/roles'],
                ['name' => 'roles.create', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '创建角色', 'url' => ''],
                ['name' => 'roles.store', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '保存角色', 'url' => ''],
                ['name' => 'roles.edit', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '编辑角色', 'url' => ''],
                ['name' => 'roles.update', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '更新角色', 'url' => ''],
                ['name' => 'roles.destroy', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '删除角色', 'url' => ''],

                ['name' => 'permissions.index', 'guard_name' => 'web', 'icon' => 'fa fa-ban', 'menu_name' => '权限列表', 'url' => '/permissions'],
                ['name' => 'permissions.create', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '创建权限', 'url' => ''],
                ['name' => 'permissions.store', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '保存权限', 'url' => ''],
                ['name' => 'permissions.edit', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '编辑权限', 'url' => ''],
                ['name' => 'permissions.update', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '更新权限', 'url' => ''],
                ['name' => 'permissions.destroy', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '删除权限', 'url' => ''],

                ['name' => 'menus.index', 'guard_name' => 'web', 'icon' => 'fa fa-bars', 'menu_name' => '菜单列表', 'url' => '/menus'],
                ['name' => 'menus.update', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '更新菜单', 'url' => ''],

                ['name' => 'logs.index', 'guard_name' => 'web', 'icon' => 'fa fa-exclamation-triangle', 'menu_name' => '错误日志', 'url' => '/logs'],

                ['name' => 'operations.index', 'guard_name' => 'web', 'icon' => 'fa fa-history', 'menu_name' => '操作日志', 'url' => '/operations'],
            ]],
        ];

        foreach ($permissions as $item) {
            $permission = Permission::where('name', $item['name'])->first();
            if (isset($item['children'])) {
                $children = $item['children'];
                unset($item['children']);
            }
            if (! $permission) {
                $item['parent_id'] = 0;
                $permission = Permission::create($item);
            }
            if (isset($children)) {
                $parent_id = $permission->id;
                foreach ($children as $value) {
                    $value['parent_id'] = $parent_id;
                    $permission = Permission::where('name', $value['name'])->first();
                    $permission or Permission::create($value);
                }
            }
        }
    }
}
