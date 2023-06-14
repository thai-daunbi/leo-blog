<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostList;

class PostlistController extends Controller
{   
    public function index(){
        $data = PostList::with('user')->get();
        return view('postlist', compact('data'));
    }
    
    public function edit(PostList $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, PostList $post)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);



        $post->update($request->except(['_token', '_method']));

        return redirect()->route('postlist.index')->with('success', 'Post updated successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        PostList::create($request->except(['_token', '_method']));

        redirect()->route('postlist.index')->with('success', 'Post updated successfully');

    }

    public function toggleVisibility($id)
    {
        $posts = PostList::findOrFail($id);
        $posts->is_public = !$posts->is_public;;
        $posts->save();
        return redirect()->back();

    }


}
