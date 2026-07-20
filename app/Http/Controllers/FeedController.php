<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    //
    public function index(Request $request){
        //
        $followersIds = $request->user()->followers->pluck('id');
        $followersPosts = Post::whereIn('id',$followersIds)->latest()->get();

        return response()->json([
            'posts' => PostResource::collection($followersPosts)
        ]);
    }
}
