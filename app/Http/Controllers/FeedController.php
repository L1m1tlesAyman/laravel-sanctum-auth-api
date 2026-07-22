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

    public function mostLiked(){
        $posts = Post::withCount('likes')
                       ->orderBy('likes_count','desc')
                       ->get();
                       
        return response()->json([
            'posts' => PostResource::collection($posts)
        ], 200);
    }

    public function mostWatched(){
        $posts = Post::withCount('views')
                       ->orderBy('views_count' , 'desc')
                       ->get();

        return response()->json([
            'posts' => PostResource::collection($posts)
        ], 200);
    }
}
