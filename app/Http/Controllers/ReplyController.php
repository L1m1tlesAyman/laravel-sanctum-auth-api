<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Http\Resources\ReplyResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Reply;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post,  Comment $comment)
    {
        //
        if($post->id !== $comment->post_id){
            return response()->json([
                'message' => 'Comment not found for this post.'
            ],404);
        }
        $replies = $comment->replies()->with('user')->paginate(50);

        return response()->json([
            'replies' => ReplyResource::collection($replies)
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReplyRequest $request , Post $post , Comment $comment)
    {
        //
        $ReplyInfo = $request->validated();

        $reply = $comment->replies()->create([
            'body' => $ReplyInfo['body'],
            'user_id' => $request->user()->id
        ]);

        return response()->json([
            'reply' => new ReplyResource($reply->load('user'))
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reply $reply)
    {
        //
        return response()->json([
            'reply' => new ReplyResource($reply->load('user'))
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReplyRequest $request , Reply $reply)
    {
        //
        $this->authorize('update' , $reply);

        $ReplyInfo = $request->validated();
        $reply->update($ReplyInfo);

        return response()->json([
            'reply' => new ReplyResource($reply->load('user'))
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reply $reply)
    {
        //
        $this->authorize('delete',$reply);

        $reply->delete();

        return response()->json([
            'message' => 'The reply message deleted succesfully'
        ],200);
    }
}
