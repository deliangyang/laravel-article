<?php

namespace App;

use App\Model\PostLogs;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Post
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PostTopic[] $postTopics
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Topic[] $topics
 * @property-read \App\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Zan[] $zans
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post authorBy($user_id)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post aviable()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post topicNotBy($topic_id)
 * @mixin \Eloquent
 */
class Post extends Model
{
    //use Searchable;

    protected $table = "posts";

    /*
     * 搜索的type
     */
    public function searchableAs()
    {
        return 'posts_index';
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }


    /*
     * 所有评论
     */
    public function comments()
    {
        return $this->hasMany('\App\Comment')->orderBy('created_at', 'desc');
    }

    /*
     * 作者
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    /*
     * 点赞
     */
    public function zans()
    {
        return $this->hasMany(\App\Zan::class)->orderBy('created_at', 'desc');
    }

    /*
     * 判断一个用户是否已经给这篇文章点赞了
     */
    public function zan($user_id)
    {
        return $this->hasOne(\App\Zan::class)->where('user_id', $user_id);
    }

    /*
     * 一篇文章有哪些主题
     */
    public function topics()
    {
        return $this->belongsToMany(\App\Topic::class, 'post_topics', 'post_id', 'topic_id')->withPivot(['topic_id', 'post_id']);
    }

    public function postTopics()
    {
        return $this->hasMany(\App\PostTopic::class, 'post_id');
    }

    public function scopeTopicNotBy(Builder $query, $topic_id)
    {
        return $query->doesntHave('postTopics', 'and', function($q) use ($topic_id) {
            $q->where("topic_id", $topic_id);
        });
    }


    public function scopeAuthorBy($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    /*
     * 可以显示的文章
     */
    public function scopeAviable($query)
    {
        return $query->whereIn('status', [0, 1]);
    }


    public function recommend()
    {
        $key = 'recommend:all';
        if ($data = \Cache::get($key)) {
            return $data;
        }
        $viewedTimes = PostLogs::select(\DB::raw('sum(viewed_time) as total_viewed_time, post_id'))
            ->groupBy('post_id')
            ->orderBy('total_viewed_time', 'desc')
            ->limit(5)
            ->get(['post_id']);

        $viewedCounters = Post::orderBy('viewed', 'desc')
            ->limit(5)
            ->get(['id']);

        $_viewedTimes = [];
        foreach ($viewedTimes as $k => $viewedTime) {
            $_viewedTimes[] = $viewedTime->post_id;
        }

        $_viewedCounters = [];
        foreach ($viewedCounters as $k => $viewedCounter) {
            $_viewedCounters[] = $viewedCounter->id;
        }

        $postIds = array_intersect($_viewedTimes, $_viewedCounters);
        $postIds = array_slice($postIds,0, 5);
        $posts = Post::whereIn('id', $postIds)
                    ->get();
        \Cache::put($key, $posts, 10);
        return $posts;
    }

}
