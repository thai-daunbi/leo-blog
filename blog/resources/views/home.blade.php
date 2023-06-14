@extends('layouts.app')

@section('content')

<div class="clearfix">
    <h2 class="float-left">Blog post</h2>

    {{-- link to create new post --}}
    <a href="{{ route('posts.create') }}" class="btn btn-link float-right">Create new post</a>
</div>

{{-- List all posts --}}
@forelse ($posts as $post)
<div class="card m-2 shadow-sm wrapper row3">
        <div class="card-body hoc container clear">
            <ul class="nospace group">
                <li class="one_third">
                <figure><a class="" href="{{ route('posts.show', $post->id) }}"><img src="{{ asset('images/' . $post->image) }}" class="mb-2" style="width:400px;height:200px;"></a>
                    <figcaption>
                    <h4 class="card-title">
                        <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                    </h4>

                    <p class="card-text">
                    <small href="{{ route('posts.show', $post->id) }}">{{ Illuminate\Support\Str::limit($post->body, 10) }}</small><br>


                        {{-- post owner --}}
                        <small class="float-left">By: {{ $post->owner->name }}</small><br>

                        {{-- creation time --}}
                        <small class="float-right text-muted">{{ $post->created_at->format('M d, Y h:i A') }}</small><br>
                        
                        {{-- check if the signed-in user is the post owner, then show edit post link --}}
                        @if (auth()->id() == $post->owner->id )
                            {{-- edit post link --}}
                            <small class="float-right mr-2 ml-2">
                                <a href="{{ route('posts.edit', $post->id) }}" class="float-right">edit your post</a>
                            </small>
                        @endif
                    </p>
                    </figcaption>
                </figure>
                </li>
            </ul>   
        </div>
    </div>
@empty
    <p>No posts yet, stay tuned!</p>
@endforelse

@endsection