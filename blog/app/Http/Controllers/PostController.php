<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\LikeControl;
use App\Models\DislikeControl;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create()
    {
        // phpinfo();
        // exit;
        
        // view create form
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // print_r(request()->title); echo"<br>";
        // print_r(request()->body); echo"<br>";
        // print_r(request()->image); echo"<br>";
        // exit;

        // validate incoming request data with validation rules
        $this->validate(request(), [
            'title' => 'required|min:1|max:255',
            'body'  => 'required|min:1|max:300',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        // store data with create() method
        $post = Post::create([
            'user_id'   => auth()->id(),
            'title'     => request()->title,
            'body'      => request()->body,
        ]);
        
        
        if ($request->hasFile('image')) {
            $post->image = $request->file('image');
            $imageName = $request->file('image')->getClientOriginalName();
            $request->image->move(public_path('images'), $imageName);
            $post->image = $imageName;
            $post->save();
        }

        // redirect to show post URL
        // return redirect($post->path());
        return redirect($post->path())->with([
            'success' => 'You have successfully uploaded image.',
            'image' => $imageName
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // we are using route model binding 
        // view show page with post data
        // echo "<pre>"; print_r ($post); echo "</pre>";
        // exit;
        $post = Post::findOrFail($post->id);

    // 접근 제한
        if (!$post->is_public) {
            return abort(403, 'Unauthorized action.');
        }
        return view('posts.show')->with('post', $post);
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('auth.home');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // we are using route model binding 
        // view edit page with post data
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // validate incoming request data with validation rules
        $this->validate(request(), [
            'title' => 'required|min:1|max:255',
            'body'  => 'required|min:1|max:300',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ]);

        // update post with new data using update() method
        $post->update([
            'title'     => request()->title,
            'body'      => request()->body
        ]);

        if ($request->hasFile('image')) {
            $post->image = $request->file('image');
            $imageName = $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads'), $imageName);
            $post->image = 'uploads/' . $imageName;
            $post->save();
        }

        // return to show post URL
        return redirect($post->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }


    public function fetchLike(Request $request)
    {
        $post = Post::find($request->post);
        return response()->json([
            'post' => $post,
        ]);
    }
 
    public function handleLike(Request $request)
{
    try {
        $postId = $request->post;
        $userId = auth()->id();

        $post = Post::find($postId);

        $likeControl = LikeControl::where('like_user_id', $userId)
            ->where('like_post_id', $postId)
            ->first();
            
        $dislikeControl = DislikeControl::where('dislike_user_id', $userId)
            ->where('dislike_post_id', $postId)
            ->first();

        $message = '';

        if (!$likeControl) {
            LikeControl::create([
                'like_user_id' => $userId,
                'like_post_id' => $postId,
            ]);

            $post->like += 1;

            // 싫어요 상태에서 좋아요 눌렀으므로 싫어요 취소
            if ($dislikeControl) {
                $dislikeControl->delete();
                $post->dislike -= 1;
            }

            
        }
        else {
            $likeControl->delete();
            $post->like -= 1;
            
        }

        $post->save();

        return response()->json([
            'message' => $message,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Internal Server Error',
            'error' => $e->getMessage(),
        ], 500);
    }
}
    public function fetchDislike(Request $request)
    {
        $post = Post::find($request->post);
        return response()->json([
            'post' => $post,
        ]);
    }
 
    public function handleDislike(Request $request)
{
    try {
        $postId = $request->post;
        $userId = auth()->id();

        $post = Post::find($postId);

        $dislikeControl = DislikeControl::where('dislike_user_id', $userId)
            ->where('dislike_post_id', $postId)
            ->first();
            
        $likeControl = LikeControl::where('like_user_id', $userId)
            ->where('like_post_id', $postId)
            ->first();

        $message = '';

        if (!$dislikeControl) {
            DislikeControl::create([
                'dislike_user_id' => $userId,
                'dislike_post_id' => $postId,
            ]);

            $post->dislike += 1;

            // 좋아요 상태에서 싫어요 눌렀으므로 좋아요 취소
            if ($likeControl) {
                $likeControl->delete();
                $post->like -= 1;
            }

            
        }
        else {
            $dislikeControl->delete();
            $post->dislike -= 1;
            
        }

        $post->save();

       
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Internal Server Error',
            'error' => $e->getMessage(),
        ], 500);
    }
}
}