<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Ratings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{

    public function __construct() {
        // Prevent unregistered users
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
        $ratings = Ratings::all();
        return view('posts.index', compact('posts', 'ratings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ], [
            'title.required' => 'Title is required',
            'body.required' => 'Body is required'
        ]);

        // Getting User ID
        $user_id = auth()->user()->id;

        // Adding User ID to Request
        $validatedData['user_id'] = $user_id;

        // Handling Post Image
        if ($request->hasFile('post_image')) {
            $file = $request->file('post_image');
            $file_extension = $file->getClientOriginalExtension();
            $path = public_path() . '/storage/images';
            $filename = time() . '.' .$file_extension;
            $request->file('post_image')->move($path, $filename);
            $validatedData['post_image'] = $filename;
        }

        // Create post
        Post::create($validatedData);

        // Notification
        $notification = array(
            'message' => 'Post created successfully!',
            'alert-type' => 'success'
        );

        return redirect()->route('posts.list')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Another approach without using policy
        $user_id = auth()->user()->id;
        $post = Post::findOrFail($id);
        if ($user_id === $post->user_id) {
            return view('posts.edit', compact('post'));
        }

        return abort(403);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // if ($request->user()->can('update', $post)) {
            $validatedData = $request->validate([
                'title' => 'required',
                'body' => 'required',
            ], [
                'title.required' => 'Title can not be empty',
                'body.required' => 'Body can not be empty'
            ]);

            if ($request->hasFile('post_image')) {
                // Delete old image before updating
                File::delete('storage/images/'. $post->post_image);
                $file = $request->file('post_image');
                $file_extension = $file->getClientOriginalName();
                $path = public_path() . '/storage/images';
                $filename = time() . '.' .$file_extension;
                $request->file('post_image')->move($path, $filename);
                $validatedData['post_image'] = $filename;
            }

            $post->fill($validatedData)->save();

            $notification = array(
                'message' => 'Post updated successfully!',
                'alert-type' => 'success'
            );

            return redirect()->route('posts.list')->with($notification);

        // } else {
        //     abort(403);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Post $post)
    {
        if ($request->user()->can('delete', $post)) {

            File::delete('storage/images/'. $post->post_image);
            $post->delete();
            $notification = array(
                'message' => 'Post deleted successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        } else {
            abort(403);
        }
    }

    public function list() {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $posts = $user->posts()->get();
        return view('posts.list', compact('posts'));
    }

    public function deleteImage($id) {
        $post = Post::findOrFail($id);

        File::delete('storage/images/'. $post->post_image);

        $post['post_image'] = null;

        $post->save();

        $notification = array(
            'message' => 'Image deleted successfully!',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }
}
