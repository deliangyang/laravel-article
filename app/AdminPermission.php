<?php

namespace App;

/**
 * App\AdminPermission
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AdminRole[] $roles
 * @mixin \Eloquent
 */
class AdminPermission extends Model
{
    /*
     * 权限属于哪些角色
     */
    public function roles()
    {
        return $this->belongsToMany(\App\AdminRole::class, 'admin_permission_role', 'role_id', 'permission_id')->withPivot(['permission_id', 'role_id']);
    }
}
