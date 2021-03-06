<?php

namespace App;

use \App\Model;

/**
 * App\Comment
 *
 * @property-read \App\Post $post
 * @property-read \App\User $user
 * @mixin \Eloquent
 */
class Comment extends Model
{
    protected $table = "comments";

    public function post()
    {
        return $this->belongsTo('\App\Post', 'post_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }
}
