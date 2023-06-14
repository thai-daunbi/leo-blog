@extends('layouts.app')

@section('content')
    <h1>Edit Post</h1>
    <form action="/posts/{{ $post->id }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}" required>
        </div>
        <div class="form-group">
            <label for="body">Content:</label>
            <textarea class="form-control" id="body" name="body" rows="5" required>{{ $post->body }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">수정 완료</button>
    </form>
@endsection
