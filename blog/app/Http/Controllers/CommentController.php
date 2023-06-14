<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Post $post, Request $request)
    {
        // validate incoming request data
        $request->validate([
            'new_comment' => ['required', 'min:1', 'max:255']
        ]);

        // store comment
        $post->comments()->create([
            'user_id'   => auth()->id(),
            'body'      => $request->input('new_comment')
        ]);

        // redirect to the previous URL
        return redirect()->back();
    }
}

