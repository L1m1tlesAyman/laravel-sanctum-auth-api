<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\RepostController;
use App\Http\Controllers\SaveController;
use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

//
Route::middleware('auth:sanctum')->group(function(){
    //
    Route::get('/profile',function (Request $request){
        return new UserResource($request->user());
    });
    //
    Route::post('/logout',[AuthController::class,'logout']);
    //
    Route::get('/users/{user}/followers',[UserController::class,'followers']);
    Route::get('/users/{user}/following',[UserController::class,'following']);
    Route::post('/users/{user}/follow',[UserController::class,'follow']);
    Route::get('/users/{id}',[UserController::class,'show']);
    Route::put('/users/{id}',[UserController::class,'update']);
    //
    Route::middleware('admin')->group(function(){
        Route::delete('/users/{id}',[UserController::class,'destroy']);
        Route::get('/users',[UserController::class,'index']);
        Route::post('/users',[UserController::class,'store']);
    });
    //
    Route::apiResource('posts',PostController::class);
    Route::get('posts/{post}/likes',[LikesController::class,'likedUsers']);
    Route::post('posts/{post}/like',[LikesController::class,'like']);
    Route::get('posts/{post}/reposts',[RepostController::class,'repostsUsers']);
    Route::post('posts/{post}/repost',[RepostController::class,'repost']);
    Route::get('posts/{post}/saves',[SaveController::class,'saves']);
    Route::post('posts/{post}/save',[SaveController::class,'save']);
    //
    Route::get('/posts/{post}/comments',[CommentController::class,'index']);
    Route::get('comments/{comment}',[CommentController::class,'show']);
    Route::post('/posts/{post}/comments',[CommentController::class,'store']);
    Route::put('/posts/{post}/comments/{comment}',[CommentController::class,'update']);
    Route::delete('/posts/{post}/comments/{comment}',[CommentController::class,'destroy']);
    //
    Route::get('/posts/{post}/comments/{comment}/replies', [ReplyController::class, 'index']);
    Route::post('/posts/{post}/comments/{comment}/replies', [ReplyController::class, 'store']);
    Route::get('/replies/{reply}', [ReplyController::class, 'show']);
    Route::put('/replies/{reply}', [ReplyController::class, 'update']);
    Route::delete('/replies/{reply}', [ReplyController::class, 'destroy']);
    //
    Route::get('/feed',[FeedController::class,'index']);
});