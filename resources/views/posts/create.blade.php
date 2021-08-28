@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h4>Create a Post</h4>
            <form method="post" action="{{route('posts.store')}}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="form-group">
                        <label for="title">Title</label>
                        <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" class="form-control" id="title" aria-describedby="" placeholder="Enter post title">
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                </div>
                <div class="form-group">
                        <label for="file">File</label>
                        <input type="file" name="post_image" class="form-control-file" id="post_image">
                </div>
                <div class="form-group">
                        <label for="title">Body</label>
                        <textarea class="form-control @error('body') is-invalid @enderror" name="body" id="body" cols="30" rows="10" class="form-control"></textarea>
                        @error('body')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
