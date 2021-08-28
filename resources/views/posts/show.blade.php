@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="post-title">{{ $post->title }}</h1>
            <p class="post-body">{!! nl2br(e($post->body)) !!}</p>
        </div>
        <div class="col-lg-4">
            @if($post->post_image != null)
                <img class="post-image_view mb-3" src="{{ asset('/storage/images/' . $post->post_image) }}" />
            @else
                <img class="post-image_view mb-3" src="https://dummyimage.com/348x195/5c6bc0/fff" />
            @endif
            <p>Published <strong>{{ $post->created_at->diffForHumans() }}</strong> by <strong>{{ $post->user->name }}</strong></p>
            @if (Auth::check())
            <div id="container" class="stars">
                <form method="post" action="{{route('rate.store', $post->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="post_id" value="{{$post->id}}">
                    <div class="d-inline-block mt-1">
                        <input class="star star-5" id="star-5" type="radio" name="rating" value="5"/>
                        <label class="star star-5" for="star-5"></label>
                        <input class="star star-4" id="star-4" type="radio" name="rating" value="4"/>
                        <label class="star star-4" for="star-4"></label>
                        <input class="star star-3" id="star-3" type="radio" name="rating" value="3"/>
                        <label class="star star-3" for="star-3"></label>
                        <input class="star star-2" id="star-2" type="radio" name="rating" value="2"/>
                        <label class="star star-2" for="star-2"></label>
                        <input class="star star-1" id="star-1" type="radio" name="rating" value="1"/>
                        <label class="star star-1" for="star-1"></label>
                    </div>
                  <button id="send" type="submit" class="btn btn-primary rate-btn ml-3" disabled='disabled'>Rate</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
<script>
    $("input:radio").change(function () {$("#send").prop("disabled", false);});
</script>

@endsection

