<?php use Illuminate\Support\Str; ?>
@extends('layout')

@section('content')
<div class="container mt-4">
    <div class="border p-4">
        <h1 class="h5 mb-4">
            投稿の新規作成
        </h1>

        <form method="POST" action="{{ route('posts.store') }}">
            @csrf

            <fieldset class="mb-4">
                <div class="form-group">
                    <label for="title">
                        タイトル
                    </label>
                    <input
                        id="title"
                        name="title"
                        class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                        value="{{ old('title') }}"
                        type="text"
                    >
                    @if ($errors->has('title'))
                        <div class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                </div>

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

                <div class="mt-5">
                    <a class="btn btn-secondary" href="{{ route('top') }}">
                        キャンセル
                    </a>

                    <button type="submit" class="btn btn-primary">
                        投稿する
                    </button>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<div class="container mt-4">
    @foreach ($posts as $post)
        <div class="card mb-4">
            <div class="card-header">
                {{ $post->title }}
            </div>
            <div class="card-body">
                <p class="card-text">
                    {!! nl2br(e(Str::limit($post->body, 200))) !!}
                </p>
                <a class="card-link" href="{{ route('posts.show', ['post' => $post]) }}">
                    続きを読む
                </a>
            </div>
            <div class="card-footer">
                <span class="mr-2">
                    投稿日時 {{ $post->created_at->format('Y.m.d') }}
                </span>

                @if ($post->contents->count())
                    <span class="badge badge-primary">
                        コメント {{ $post->contents->count() }}件
                    </span>
                @endif
            </div>
        </div>
    @endforeach
</div>
<div class="d-flex justify-content-center mb-5">
    {{ $posts->links() }}
</div>
@endsection
