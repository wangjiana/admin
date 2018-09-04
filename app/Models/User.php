<?php

namespace App\Models;

use Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAllPermissionsTree()
    {
        return Cache::tags('layout_menus')->rememberForever($this->id, function() {

            $permission = $this->permissions->merge($this->getPermissionsViaRoles())->sortBy('sort')->values();

            return arrayToTree($permission);

        });
    }
}
