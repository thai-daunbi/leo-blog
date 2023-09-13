<form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    {{-- Post title --}}
    <div class="form-group">
      <label for="title">Post title</label>
      <input type="text"
                name="title"
                id="title"
                class="form-control"
                placeholder="write post title here.."
                required />

        @if ($errors->has('title'))
            <small class="text-danger">{{ $errors->first('title') }}</small>
        @endif
    </div>
    {{-- End --}}

    {{-- Post body --}}
    <div class="form-group">
      <label for="body">Post body</label>
      <textarea class="form-control"
                name="body"
                id="body"
                rows="3"
                placeholder="write post body here.."
                required
                style="resize: none;"></textarea>

        @if ($errors->has('body'))
            <small class="text-danger">{{ $errors->first('body') }}</small>
        @endif
    </div>
    {{-- End --}}

    {{-- Image upload --}}
    <div class="mb-6">
        <label class="block">
            <span class="sr-only">Choose File</span>
            <input type="file" 
                name="image"
                id="inputImage"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
        </label>
        @error('image')
        <div class="flex items-center text-sm text-red-600">
            {{ $message }}

        </div>
        @enderror
    </div>
    <!-- <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image" id="image" class="form-control-file">
        @if ($errors->has('image'))
            <small class="text-danger">{{ $errors->first('image') }}</small>
        @endif
    </div> -->
    {{-- End --}}

    <div class="form-group">
        <button type="submit" class="btn btn-primary" class="btn btn-success">Save Post</button>
        <a href="{{ route('home') }}" class="btn btn-default">Back</a>
    </div>
</form>
