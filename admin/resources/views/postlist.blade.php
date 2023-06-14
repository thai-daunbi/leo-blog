@extends('layouts.app')

@section('title', 'Admin Settings')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Admin Settings - Post Management</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>User Id</th>
                        <th>Page Content</th>
                        <th>Actions</th>
                        <th>status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ Str::limit($item->title, 8) }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ Str::limit($item->body, 10) }}</td>
                            <td>
                                <a href="{{ route('edit-post', $item->id) }}" class="btn btn-warning">Edit</a>
                                @if ($item->is_public == 1)
                                    <a href="{{ route('post.toggle-visibility', $item->id) }}" class="btn btn-secondary">비공개</a>
                                @else
                                    
                                    <a href="{{ route('post.toggle-visibility', $item->id) }}" class="btn btn-primary">공개</a>
                                @endif
                            </td>
                            <td class="status">
                                {{ $item->is_public ? '공개' : '비공개' }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
