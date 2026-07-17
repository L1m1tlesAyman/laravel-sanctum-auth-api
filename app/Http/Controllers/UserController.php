<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return response()->json([
            'users' => UserResource::collection($users)
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $userInfo = $request->validate([
            'name' => ['required','min:5','max:255'],
            'email' => ['required','email','unique:users,email'],
            'password' => ['required','min:8','max:255']
        ]);

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
    public function update(Request $request, string $id)
    {
        //
        $user = User::findOrFail($id);

        $userInfo = $request->validate([
            'name' => ['required','min:5','max:255'],
            'email' => ['required','email','unique:users,email,'.$user->id],
            'password' => ['required','min:8','max:255']
        ]);

        $user->name = $userInfo['name'];
        $user->email = $userInfo['email'];
        $user->password = Hash::make($userInfo['password']);

        $user->save();

        return response()->json([
            'updated_user' => new UserResource($user)
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return response()->json([
            'message' => 'User Deleted Successflly'
        ],204);
    }
}
