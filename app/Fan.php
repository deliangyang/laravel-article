<?php

namespace App;

use \App\Model;

/**
 * App\Fan
 *
 * @property-read \App\User $fuser
 * @property-read \App\User $suser
 * @mixin \Eloquent
 */
class Fan extends Model
{
    protected $table = "fans";

    /*
     * 粉丝用户
     */
    public function fuser()
    {
        return $this->hasOne(\App\User::class, 'id', 'fan_id');
    }

    /*
     * 明星用户
     */
    public function suser()
    {
        return $this->hasOne(\App\User::class, 'id', 'star_id');
    }
}
