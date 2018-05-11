<?php

namespace App;


/**
 * App\PostTopic
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PostTopic inTopic($topic_id)
 * @mixin \Eloquent
 */
class PostTopic extends Model
{
    protected $table = "post_topics";

    public function scopeInTopic($query, $topic_id)
    {
        return $query->where('topic_id', $topic_id);
    }
}
