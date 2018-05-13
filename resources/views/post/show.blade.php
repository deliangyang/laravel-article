@extends("layout.main")

@section("content")


    <div class="col-sm-8 blog-main">
        <div class="blog-post">
            <div style="display:inline-flex">
                <h2 class="blog-post-title">{{$post->title}}</h2>
                @if (Auth::user()->can('update', $post))
                    <a style="margin: auto" href="/posts/{{$post->id}}/edit">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>
                @endif
                @if (Auth::user()->can('update', $post))
                    <a style="margin: auto" href="/posts/{{$post->id}}/delete">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </a>
                @endif
            </div>

            <div style="word-wrap: break-word; word-break: normal; ">
                <p class="blog-post-meta">{{$post->created_at->toFormattedDateString()}} by
                    <a target="_blank" href="/user/{{ $post->user->id }}">{{$post->user->name}}</a>
                    @if ($favorite)
                        <a class="favorite cancel" href="javascript://">取消收藏</a>
                        @else
                        <a class="favorite add" href="javascript://">收藏</a>
                    @endif
                </p>

                <p>
                    {!! $post->content !!}
                </p>
            </div>
            <div>
                @if($post->zan(\Auth::id())->exists())
                    <a href="/posts/{{$post->id}}/unzan" type="button" class="btn btn-default btn-lg">取消赞</a>
                @else
                    <a href="/posts/{{$post->id}}/zan" type="button" class="btn btn-primary btn-lg">赞</a>
                @endif

            </div>
        </div>

        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">评论</div>

            <!-- List group -->
            <ul class="list-group">
                @foreach($post->comments as $comment)
                    <li class="list-group-item">
                        <h5>{{$comment->created_at}} by {{$comment->user->name}}</h5>
                        <div>
                            {{$comment->content}}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">发表评论</div>

            <!-- List group -->
            <ul class="list-group">
                <form action="/posts/comment" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="post_id" value="{{$post->id}}"/>
                    <li class="list-group-item">
                        <textarea name="content" class="form-control" rows="10">{{ old('content') }}</textarea>
                        @if ($errors->has('content'))
                            <span style="color: red;" class="help-block">
				                <strong>{{ $errors->first('content') }}</strong>
			                </span>
                        @endif
                        <button class="btn btn-default" type="submit">提交</button>
                    </li>
                </form>

            </ul>
        </div>

    </div><!-- /.blog-main -->



@endsection
@push('script')
    <script type="text/javascript">
        var post_id = '{{ $post->id }}';
        var timer = setInterval(function () {
            $.ajax({
                url: '/post/logs',
                data: {
                    post_id: post_id,
                    _token: '{{ csrf_token() }}',
                    _method: 'post',
                },
                dataType: 'json',
                type: 'post',
                success: function (res) {
                    console.log(res)
                }
            });
        }, 10000);

        $('.favorite.cancel').on('click', function() {
            $.ajax({
                url: '/favorite/' + post_id,
                data: {
                    post_id: post_id,
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE',
                },
                dataType: 'json',
                type: 'post',
                success: function (res) {
                    window.location.reload();
                }
            });
        });
        $('.favorite.add').on('click', function() {
            $.ajax({
                url: '/favorite',
                data: {
                    post_id: post_id,
                    _token: '{{ csrf_token() }}',
                    _method: 'POST',
                },
                dataType: 'json',
                type: 'post',
                success: function (res) {
                    window.location.reload();
                }
            });
        });
    </script>
@endpush
