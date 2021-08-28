@extends('layouts.app')

@section('content')
<div class="container">
    @if(count($posts) > 0)
        @foreach($posts->chunk(3) as $chunk)
        <div class="row mt-3">
            @foreach($chunk as $post)
            <div class="col-lg-4 d-flex">
                <div class="card">
                    @if($post->post_image != null)
                        <img class="card-img-top" src="{{ asset('/storage/images/' . $post->post_image) }}">
                    @else
                        <img class="card-img-top" src="https://dummyimage.com/348x195/5c6bc0/fff" />
                    @endif
                    <div class="card-body">
                    <h5 class="card-title"><a href="{{route('posts.show', $post->id)}}">{{ $post->title }}</a></h5>
                    @php $rating = $post->rate()->avg('rating'); @endphp

                    <p>
                        <div class="placeholder" style="color: #bdbdbd;">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <span class="small">({{ number_format((float)$post->rate()->avg('rating'), 1, '.', ''); }}) from {{ $post->rate()->count('rating') }} votes</span>
                        </div>
                        <div class="overlay" style="position: relative;top: -22px; height:0px;">
                            @while($rating>0)
                                @if($rating >0.5)
                                    <i class="fa fa-star"></i>
                                @else
                                    <i class="fa fa-star-half"></i>
                                @endif
                                @php $rating--; @endphp
                            @endwhile
                        </div>
                    </p>

                    <p class="card-text">{{ Str::limit($post->body, 100, '...') }}</p>
                    </div>
                    <div class="card-footer text-muted">
                        <small>Created {{ $post->created_at->diffForHumans() }} by {{ $post->user->name }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    @else
    <div class="alert alert-info" role="alert">
        Create your first post!
    </div>
    @endif
</div>
@endsection
