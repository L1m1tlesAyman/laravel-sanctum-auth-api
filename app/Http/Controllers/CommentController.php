<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
        $comments = $post->comments()->with('user')->get();

        return response()->json([
            'comments' => CommentResource::collection($comments)
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request , Post $post)
    {
        $commentInfo = $request->validated();
        $comment = $post->comments()->create([
            'body' => $commentInfo['body'],
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'comment' => new CommentResource($comment)
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        $cmnt = $comment->load('user');
        return response()->json([
            'comment' => new CommentResource($cmnt)
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        if((int)$request->user()->id !== (int)$comment->user_id && $request->user()->role !== 'admin'){
            return response()->json([
                'message' => 'You do not have permission to updated this comment'
            ],403);
        }

        $commentInfo = $request->validated();
        $comment->update($commentInfo);

        return response()->json([
            'updated_comment' => new CommentResource($comment)
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request , Comment $comment)
    {
        if((int)$request->user()->id !== (int)$comment->user_id && $request->user()->role !== 'admin'){
            return response()->json([
                'message' => 'You do not have permission to delete this comment'
            ],403);
        }

        $comment->delete();
        return response()->json([
            'message' => 'Comment Deleted Succesfully'
        ],200);
    }
}
