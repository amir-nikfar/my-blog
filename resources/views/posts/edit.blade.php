@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h4>Edit a Post</h4>
            <form method="post" action="{{route('posts.update', $post->id)}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PATCH">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" class="form-control" id="title" placeholder="Enter post title" value="{{$post->title}}">
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                @if($post->post_image != null)
                <div class="form-group">
                    <img width="200" class="rounded" src="{{ asset('/storage/images/' . $post->post_image) }}">
                    <a onclick="return confirm('Are you sure?')" href="{{ route('posts.deleteImage', $post->id) }}" class="btn btn-danger delete-image">X</a>
                </div>
                @endif
                <div class="form-group">
                    <label for="file">File</label>
                    <input type="file" name="post_image" class="form-control-file" id="post_image">
                </div>
                <div class="form-group">
                    <label for="title">Body</label>
                    <textarea class="form-control @error('body') is-invalid @enderror" name="body" id="body" cols="30" rows="10" class="form-control">{{$post->body}}</textarea>
                    @error('body')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
