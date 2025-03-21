<?php

namespace App\Http\Controllers;

use App\Services\ApiResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {
        //validate request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //login attempt
        $email = $request->input('email');
        $password = $request->input('password');
        $attempt = auth()->attempt([
            'email' => $email,
            'password' => $password
        ]);

        if(!$attempt) {
            return ApiResponse::unauthorized();
        }

        //authenticate user
        $user = auth()->user();
        //token's expiration time is config in the sanctum
        //$token = $user->createToken($user->name)->plainTextToken;
        //set the expiration time to 30 minutes
        $token = $user->createToken($user->name, ['*'], now()->addMinutes(30))->plainTextToken;

        //return the access token fro the api requests
        return ApiResponse::success(
            [
                'user' => $user->name,
                'email' => $user->email,
                'token' => $token
            ]
        );



    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return ApiResponse::success('Logout with success');
    }
}
