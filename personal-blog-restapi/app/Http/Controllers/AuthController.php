<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
           'email' => 'required|email',
           'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if(!Auth::attempt($credentials))
        {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }
}
