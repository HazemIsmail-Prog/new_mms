<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (auth()->attempt($credentials)) {
            $user = User::where('username', $request->username)->first();

            return new UserResource($user);
        }

        return response([
            'error' => true,
            'message' => 'Invalid Credentials!',
        ], 401);
    }

    public function test()
    {
        $users = User::all();

        return response([
            'data' => UserResource::collection($users),
            'error' => 0,
            'message' => 'Success',
        ]);
    }
}
