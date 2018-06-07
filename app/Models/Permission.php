<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    public $guarded = ['id'];

    protected static function getPermissionsDelimiter()
    {
        $permissions = self::all();

        return arrayAddDelimiter($permissions);
    }

    protected static function getPermissionsTree()
    {
        $permission = self::orderBy('sort')->get();

        return arrayToTree($permission);
    }
}
