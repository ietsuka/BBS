@extends('layout')

@section('content')
    <div class="container mt-4">
        <div class="border p-4">
            <div class="mb-4 text-right">
              <button class="btn btn-primary" onClick="history.back()">戻る</button>
              <form
                style="display: inline-block;"
                method="POST"
                action="{{ route('posts.destroy', ['post' => $post]) }}"
              >
                @csrf
                @method('DELETE')

                <button class="btn btn-danger">削除する</button>
              </form>
            </div>
            <h1 class="h5 mb-4">
                {{ $post->title }}
            </h1>

            <p class="mb-5">
                {!! nl2br(e($post->body)) !!}
            </p>

            <section>
                <h2 class="h5 mb-4">
                    コメント
                </h2>

                <form class="mb-4" method="POST" action="{{ route('comments.store') }}">
                    @csrf

                    <input
                        name="post_id"
                        type="hidden"
                        value="{{ $post->id }}"
                    >

                    <div class="form-group">
                        <label for="body">
                            本文
                        </label>

                        <textarea
                            id="body"
                            name="body"
                            class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}"
                            rows="4"
                        >{{ old('body') }}</textarea>
                        @if ($errors->has('body'))
                            <div class="invalid-feedback">
                                {{ $errors->first('body') }}
                            </div>
                        @endif
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            コメントする
                        </button>
                    </div>
                </form>

                @forelse($post->contents as $content)
                    <div class="border-top p-4">
                        <form
                          style="display: inline-block;"
                          method="POST"
                          action="{{ route('comments.destroy', ['comment' => $content]) }}"
                        >
                          @csrf
                          @method('DELETE')

                          <button class="btn btn-danger">削除する</button>
                        </form>
                        <time class="text-secondary">
                            {{ $content->created_at->format('Y.m.d H:i') }}
                        </time>
                        <p class="mt-2">
                            {!! nl2br(e($content->body)) !!}
                        </p>
                    </div>
                @empty
                    <p>コメントはまだありません。</p>
                @endforelse
            </section>
        </div>
    </div>
@endsection
