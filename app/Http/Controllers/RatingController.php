<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Ratings;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    // Send Rating
    public function rate(Request $request) {

        // merge user id to request
        $user_id = auth()->user()->id;
        $request->merge(['user_id' => $user_id]);

        // check if user rated before
        $post_id = $request->input('post_id');
        $matchRate = ['user_id' => $user_id, 'post_id' => $post_id];
        $canRate = Ratings::where($matchRate)->get();

        if(count($canRate) > 0) {
            $notification = array(
                'message' => 'You have rated before!',
                'alert-type' => 'error'
            );

        } else {
            $notification = array(
                'message' => 'Rated successfully!',
                'alert-type' => 'success'
            );

            Ratings::create($request->all());
        }

        return back()->with($notification);
    }
}
