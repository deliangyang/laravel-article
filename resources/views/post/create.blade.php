@extends("layout.main")

@section("content")

    <div class="col-sm-8 blog-main">
        <form action="/posts" method="POST">
            {{csrf_field()}}
            <div class="form-group">
                <label>标题</label>
                <input name="title" type="text" class="form-control" value="{{ old('title') }}" placeholder="这里是标题">
                @if ($errors->has('title'))
                    <span style="color: red;" class="help-block">
				        <strong>{{ $errors->first('title') }}</strong>
			        </span>
                @endif
            </div>
            <div class="form-group">
                <label>内容</label>
                <textarea id="content" style="height:400px;max-height:500px;" name="content" class="form-control"
                          placeholder="这里是内容">{{ old('content') }}</textarea>
                @if ($errors->has('content'))
                    <span style="color: red;" class="help-block">
				        <strong>{{ $errors->first('content') }}</strong>
			        </span>
                @endif
            </div>
            <button type="submit" class="btn btn-default">提交</button>
        </form>
        <br>

    </div><!-- /.blog-main -->


@endsection
