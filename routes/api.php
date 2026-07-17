<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

//
Route::middleware('auth:sanctum')->group(function(){
    //
    Route::get('/logout',[AuthController::class,'logout']);
    //
    Route::get('/profile',function (Request $request){
        return $request->user();
    });
    //
    Route::put('/users/{id}',[UserController::class,'update']);
    Route::get('/users/{id}',[UserController::class,'show']);
    //
    Route::middleware('admin')->group(function(){
        Route::delete('/users/{id}',[UserController::class,'destroy']);
        Route::get('/users',[UserController::class,'index']);
        Route::post('/users',[UserController::class,'store']);
    });
});