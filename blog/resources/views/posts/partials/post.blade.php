
<div class="card shadow">
    <div class="card-body">

    {{-- Post title  --}}
    <h4 class="card-title">
        {{ $post->title }}
    </h4>
    {{-- Owner name with created_at --}}
    <small class="text-muted">
        Posted by: <b>{{ $post->owner->name }}</b> on {{ $post->created_at->format('M d, Y H:i:s') }}
    </small>

    {{-- Post body --}}
    <p class="card-text">
        {{ $post->body }}
    </p>

    <img src="{{ asset('images/' . $post->image) }}" class="mb-2" style="width:400px;height:200px;">

    <like-component :blog="{{ $post->id }}"></like-component>
    <dislike-component :blog="{{ $post->id }}"></dislike-component>


    <hr>
    @include('posts.partials.comments')
    </div>
</div>