@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h4>My Posts</h4>
            <table class="table mt-3">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Published Date</th>
                    <th scope="col" width="200">Actions</th>
                  </tr>
                </thead>
                <tbody>
                @if(count($posts) > 0)
                    @foreach ($posts as $key => $post)
                    <tr>
                        <td class="align-middle">
                        {{ $key + 1 }}
                        </td>
                        <td class="align-middle">
                            <div class="thumbnail">
                                @if($post->post_image != null)
                                    <img class="post-image_list" src="{{ asset('/storage/images/' . $post->post_image) }}" />
                                @else
                                    <img class="post-image_list" src="https://dummyimage.com/400x400/5c6bc0/fff" />
                                @endif
                            </div>
                        </td>
                        <td class="align-middle">{{ $post->title }}</td>
                        <td class="align-middle" width="250">{{ $post->created_at }}</td>
                        <td class="align-middle actions">
                            <a type="button" href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-primary d-inline">Edit</a>
                            <form method="post" action="{{ route('posts.destroy', $post->id) }}" enctype="multipart/form-data" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="5" class="text-center">You have no post.</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
