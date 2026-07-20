<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Post;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function like(Request $request , Post $post){
        //
        $like = $post->likes()->toggle($request->user());
        return response()->json([
            'liked' => !empty($like["attached"])
        ],200);
    }

    public function likedUsers(Post $post){
        //
        $likedUsers = $post->load('likes');

        return response()->json([
            'liked_users' => UserResource::collection($likedUsers->likes)
        ],200);
    }
}
