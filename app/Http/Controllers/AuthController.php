<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
//            'user_type' => 'required|in:worker', // sadəcə icazə verilənlər
        ]);


        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => 'worker',
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }



    public function login(Request $request)
{

    // Əgər validation uğurludursa, davam et
    $user = User::where('email', $request->email)
                ->where('user_type', $request->user_type)
                ->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'error' => 'Email, şifrə və ya istifadəçi tipi yanlışdır.'
        ], 401);
    }

    $token = JWTAuth::fromUser($user);

    return response()->json([
        'user' => $user,
        'token' => $token,
    ]);
}



}
