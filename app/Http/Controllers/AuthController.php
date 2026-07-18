<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(UserRequest $request){

        $userInfo = $request->validated();

        $user = User::create([
            'name' => $userInfo['name'],
            'email' => $userInfo['email'],
            'password'=> Hash::make($userInfo['password']),
            'role' => $userInfo['role'] ?? 'user'
        ]);

        return response()->json([
            'user' => new UserResource($user),
        ]);
    }

    public function login(Request $request){
        $userInfo = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','min:8','max:255'],
        ]);

        $user = User::where('email',$userInfo['email'])->first();

        if(!$user || !Hash::check($userInfo['password'],$user->password)){
            return response()->json([
                'message' => 'The credentials you provided do not match our records.'
            ],401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token
        ],200);
    }

    public function logout(Request $request){
        
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged Out Successfully'
        ]);
    }
}