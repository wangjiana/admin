<?php

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;

class SeedUsersAndRolesAndPermissionsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            ['name' => 'xtgl', 'guard_name' => 'web', 'icon' => 'fa fa-tasks', 'menu_name' => '系统管理', 'url' => '', 'children' => [
                ['name' => 'users.index', 'guard_name' => 'web', 'icon' => 'fa fa-users', 'menu_name' => '用户列表 ', 'url' => '/users', 'children' => [
                    ['name' => 'users.create', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '创建用户', 'url' => ''],
                    ['name' => 'users.store', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '保存用户', 'url' => ''],
                    ['name' => 'users.edit', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '编辑用户', 'url' => ''],
                    ['name' => 'users.update', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '更新用户', 'url' => ''],
                    ['name' => 'users.destroy', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '删除用户', 'url' => ''],
                ]],
                ['name' => 'roles.index', 'guard_name' => 'web', 'icon' => 'fa fa-user', 'menu_name' => '角色列表', 'url' => '/roles', 'children' => [
                    ['name' => 'roles.create', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '创建角色', 'url' => ''],
                    ['name' => 'roles.store', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '保存角色', 'url' => ''],
                    ['name' => 'roles.edit', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '编辑角色', 'url' => ''],
                    ['name' => 'roles.update', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '更新角色', 'url' => ''],
                    ['name' => 'roles.destroy', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '删除角色', 'url' => ''],
                    ['name' => 'roles.getRoleAuth', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '获取授权权限', 'url' => ''],
                    ['name' => 'roles.roleAuth', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '授权权限', 'url' => ''],
                ]],
                ['name' => 'permissions.index', 'guard_name' => 'web', 'icon' => 'fa fa-ban', 'menu_name' => '权限列表', 'url' => '/permissions', 'children' => [
                    ['name' => 'permissions.create', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '创建权限', 'url' => ''],
                    ['name' => 'permissions.store', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '保存权限', 'url' => ''],
                    ['name' => 'permissions.edit', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '编辑权限', 'url' => ''],
                    ['name' => 'permissions.update', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '更新权限', 'url' => ''],
                    ['name' => 'permissions.destroy', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '删除权限', 'url' => ''],
                ]],
                ['name' => 'menus.index', 'guard_name' => 'web', 'icon' => 'fa fa-bars', 'menu_name' => '菜单列表', 'url' => '/menus', 'children' => [
                    ['name' => 'menus.update', 'guard_name' => 'web', 'icon' => '', 'menu_name' => '更新菜单', 'url' => ''],
                ]],
                ['name' => 'logs.index', 'guard_name' => 'web', 'icon' => 'fa fa-exclamation-triangle', 'menu_name' => '错误日志', 'url' => '/logs'],
                ['name' => 'operations.index', 'guard_name' => 'web', 'icon' => 'fa fa-history', 'menu_name' => '操作日志', 'url' => '/operations'],
            ]],
        ];

        // 先创建权限
        $permissions = treeToArrayNoId($permissions);
        Permission::insert($permissions);

        // 创建超级管理员角色，并赋予权限
        $super_admin = Role::create(['name' => '超级管理员']);
        $super_admin->givePermissionTo(array_column($permissions, 'id'));

        // 创建管理员角色，并赋予权限
        $admin = Role::create(['name' => '管理员']);
        // 不赋予的权限
        $invalidData = ['权限列表', '创建权限', '保存权限', '编辑权限', '权限列表', '创建权限'];
        $permissions = Permission::whereNotIN('menu_name', $invalidData)->get();
        $admin->givePermissionTo($permissions);

        // 创建超级管理员和普通管理员账号，并赋予相应角色
        User::create([
            'name' => env('SUPER_ADMIN_NAME', "super_admin"),
            'email' => env('SUPER_ADMIN_EMAIL', 'super_admin@qq.com'),
            'password' => bcrypt(env('SUPER_ADMIN_PASSWORD', 'secret')), // secret
        ])->assignRole($super_admin);

        User::create([
            'name' => env('ADMIN_NAME', "admin"),
            'email' => env('ADMIN_EMAIL', 'admin@qq.com'),
            'password' => bcrypt(env('ADMIN_PASSWORD', 'secret')), // secret
        ])->assignRole($admin);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 清空所有数据表数据
        $tableNames = config('permission.table_names');

        Model::unguard();
        DB::table($tableNames['role_has_permissions'])->delete();
        DB::table($tableNames['model_has_roles'])->delete();
        DB::table($tableNames['model_has_permissions'])->delete();
        DB::table($tableNames['roles'])->delete();
        DB::table($tableNames['permissions'])->delete();
        Model::reguard();
    }
}
