<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validateUser = Validator::make($request->all(), [
            'name' => "required|string|max:255",
            'email' => "required|string|unique:users,email",
            'password' => "required|string|min:8|confirmed",
        ]);

        if ($validateUser->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validateUser->errors()
            ],);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'token' => $user->createToken('API Token')->plainTextToken
        ],);
    }

    public function login(Request $request)
    {
        $validateUser = Validator::make($request->all(), [
            'email' => "required|string|email",
            'password' => "required|string",
        ]);

        if ($validateUser->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validateUser->errors()
            ],);
        }

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Credentials not match',
            ],);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'token' => $user->createToken('API Token')->plainTextToken
        ],);
    }
}
