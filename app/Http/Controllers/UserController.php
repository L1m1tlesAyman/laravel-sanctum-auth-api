<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function follow(Request $request , User $user){
        //
        if((int)$user->id === (int)$request->user()->id){
            return response()->json([
                'message' => 'You cannot follow yourself.'
            ],422);
        }
        $user = $request->user()->following()->toggle($user->id);

        return response()->json([
            'follow' => !empty($user['attached'])
        ]);
    }

    public function followers(User $user){
        //
        $followers = $user->load('followers');
        return response()->json([
            'followers' => UserResource::collection($followers->followers)
        ]);
    }

    public function following(User $user){
        //
        $followers = $user->load('following');
        return response()->json([
            'following' => UserResource::collection($followers->following)
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::all();

        return response()->json([
            'users' => UserResource::collection($users)
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        //
        $userInfo = $request->validated();

        $user = User::create([
            'name' => $userInfo['name'],
            'email' => $userInfo['email'],
            'password'=> Hash::make($userInfo['password'])
        ]);

        return response()->json([
            'user' => new UserResource($user)
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::findOrFail($id);

        return response()->json([
            'user' => new UserResource($user)
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        //
        $user = User::findOrFail($id);
        if((int)$request->user()->id !== (int)$id && $request->user()->role !== 'admin'){
            return response()->json([
                'message' => 'You do not have permission to update this profile.'
            ],403);
        }

        $userInfo = $request->validated();
        
        if(empty($userInfo['password'])){
            unset($userInfo['password']);
        }else{
            $userInfo['password'] = Hash::make($userInfo['password']);
        }

        $user->update($userInfo);

        return response()->json([
            'updated_user' => new UserResource($user)
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request , string $id)
    {
        if((int)$request->user()->id !== (int)$id && $request->user()->role !== 'admin'){
            return response()->json([
                'message' => 'You do not have permission to Delete this profile.'
            ],403);
        }
        $user = User::findOrFail($id);
        $user->delete();
        
        return response()->json([
            'message' => 'User Deleted Successfully'
        ],200);
    }
}
