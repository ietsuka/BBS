<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Content;

class CommentsController extends Controller
{
    public function store(Request $request) {
      $params = $request->validate([
        'post_id' => 'required|exists:posts,id',
        'body' => 'required|max:2000',
      ]);

      $post = Post::findOrFail($params['post_id']);
      $post -> contents() -> create($params);

      return redirect() -> route('posts.show', ['post'=>$post]);
    }

    public function destroy($content_id) {
      $content = Content::findOrFail($content_id);
      $post_id = $content -> post -> id;

      \DB::transaction(function() use ($content) {
        $content->delete();
      });

      return redirect()->route('posts.show', ['post'=>$post_id]);
    }
}
