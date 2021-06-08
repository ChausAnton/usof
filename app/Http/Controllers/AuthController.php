<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validated =  $request->validate([
            'login'=> 'required|string|unique:users,login',
            'real_name'=> 'required|string',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|min:4',
            'role' => 'in:admin,user'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response([
            'message' => 'User registered. Please log in',
            'user' => $user
        ]);
    }

    public function Login(Request $request)
    {
        $credentials = $request->only(['login', 'password']);
        if(($token = JWTAuth::attempt($credentials))) {
            $user = JWTAuth::user();
            $user->token = $token;
            $user->save();
            return response([
                'message' => 'Logged in',
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
                'user' => $user
            ]);
        }
        
    }

    public function Logout()
    {
        try {
            $user = auth()->user();
            if($user) {
                JWTAuth::invalidate(JWTAuth::getToken());
                $user->token = '';
                $user->save();
            }
            return $user;
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response(['error' => $e->getMessage()], 401);
        }
    }
}
