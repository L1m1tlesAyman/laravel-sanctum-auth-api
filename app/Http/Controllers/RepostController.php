<?php

namespace App\Http\Controllers;

use App\Events\UserRepostedEvent;
use App\Http\Resources\UserResource;
use App\Models\Post;
use Illuminate\Http\Request;

class RepostController extends Controller
{
    //
    public function repost(Request $request , Post $post){
        //
        $repost = $post->reposts()->toggle($request->user()->id);
        if(!empty($repost['attached'])){
            event(new UserRepostedEvent($request->user() , $post));
        }
        
        return response()->json([
            'repost' => !empty($repost['attached'])
        ],200);
    }

    public function repostsUsers(Post $post){
        //
        $repostsUsers = $post->load('reposts');

        return response()->json([
            'reposted_users' => UserResource::collection($repostsUsers->reposts)
        ],200);
    }
}
