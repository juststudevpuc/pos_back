<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255|min:3",
            "email" => "required|email|unique:users,email",
            "password" => "required|string|min:3|confirmed",
            "role" => "required|string|max:255|min:3",
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role" => $request->role,
        ]);

        return response()->json([
            "user" => $user,
            "message" => "CREATED USER SUCCESSFULLY"
        ], 201);
    }
    public function login(Request $request)
    {

        $request->validate([
            "email" => "required|email",
            "password" => "required|string|min:3"
        ]);

        $user = User::where("email", $request->email)->first();

        if (!$user) {
            return response()->json([
                "message" => "User is not found ",

            ], 404);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                "message" => "Incorrect password ",

            ], 404);
        }
        $tokenResult = $user->createToken("authtoken");
        $token = $tokenResult->plainTextToken;

        $cookie = cookie("auth_token", $token, 60 * 24 * 7, "/", null, false, true, false, "Strict");

        return response()->json([
            "user" => $user,
            "token" => $token,
            "message" => "User is logged in SUCCESSFULLY"
        ], 200)->withCookie($cookie);
    }
    public function logout(Request $request)
    {
        $user = $request->user()->currentAccessToken()->delete();
        $cookie = Cookie::forget("auth_token");

        return response()->json([
            "user" => $user,
            "message" => "User is Log Out SUCCESSFULLY"
        ], 201)->withCookie($cookie);
    }
    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            "user" => $user,
            "message" => "Get user Successfully"
        ], 200);
    }
}
