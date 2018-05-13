<?php

namespace App\Http\Controllers;

use App\Favorite;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    /*
     * 文章列表
     */
    public function index()
    {
        $user = \Auth::user();
        $posts = Post::aviable()->orderBy('created_at', 'desc')->withCount(["zans", "comments"])->with(['user'])->paginate(6);
//作者 创建时间降序排列 赞 评论 分页 6

        $post = new Post();
        $recommend = $post->recommend();
        return view('post/index', compact('posts', 'recommend'));
    }

    public function imageUpload(Request $request)
    {
        $path = $request->file('wangEditorH5File')
            ->storePublicly(md5(\Auth::id() . time()));
        return asset('storage/'. $path);
    }

    public function create()
    {
        $post = new Post();
        $recommend = $post->recommend();
        return view('post/create')
            ->with(compact('recommend'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255|min:4',
            'content' => 'required|min:100',
        ]);
        $params = array_merge(request(['title', 'content']), ['user_id' => \Auth::id()]);
        Post::create($params);
        return redirect('/posts');
    }

    public function edit(Post $post)
    {
        return view('post/edit', compact('post'));
    }

    public function show(\App\Post $post)
    {
        $user = \Auth::user();

        $post->viewed += 1;
        $post->save();

        $favorite = false;
        if ($user) {
            $favorite = Favorite::where('post_id', '=', $post->id)
                ->where('user_id', '=', $user->id)
                ->first();
        }

        $recommend = $post->recommend();

        return view('post/show', compact('post', 'recommend', 'favorite'));
    }

    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'title' => 'required|max:255|min:4',
            'content' => 'required|min:100',
        ]);

        $this->authorize('update', $post);

        $post->update(request(['title', 'content']));
        return redirect("/posts/{$post->id}");
    }

    /*
     * 文章评论保存
     */
    public function comment()
    {
        $this->validate(request(),[
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|min:10',
        ]);

        $user_id = \Auth::id();

        $params = array_merge(
            request(['post_id', 'content']),
            compact('user_id')
        );
        \App\Comment::create($params);
        return back();
    }

    /*
     * 点赞
     */
    public function zan(Post $post)
    {
        $zan = new \App\Zan;
        $zan->user_id = \Auth::id();
        $post->zans()->save($zan);
        return back();
    }

    /*
     * 取消点赞
     */
    public function unzan(Post $post)
    {
        $post->zan(\Auth::id())->delete();
        return back();
    }

    /*
     * 搜索页面
     */
    public function search()
    {
        $this->validate(request(),[
            'query' => 'required'
        ]);

        $query = request('query');
        $posts = Post::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->paginate(10);

        $post = new Post();
        $recommend = $post->recommend();
        return view('post/search', compact('posts', 'query', 'recommend'));
    }
}
