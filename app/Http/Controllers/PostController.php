<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json([
            'posts' => PostResource::collection($posts)
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $validated = $request->validated();

        $post = $request->user()->posts()->create([
            'title' => $validated['title'],
            'body' => $validated['body'],
        ]);

        return response()->json([
            'post' => new PostResource($post)
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post = $post->load('user');
        return response()->json([
            'post' => new PostResource($post),
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $validated = $request->validated();

        $this->authorize('update',$post);

        $post->title = $validated['title'];
        $post->body = $validated['body'];
        $post->save();
        
        return response()->json([
            'updated_post'=> new PostResource($post)
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete',$post);

        $post->delete();

        return response()->json([
            'message'=> 'the post deleted successfully'
        ],200);
    }
}
