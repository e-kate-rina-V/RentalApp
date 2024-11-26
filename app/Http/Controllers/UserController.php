<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // public function register(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //         'role' => 'required|in:renter,landlord',
    //     ]);

    //     $user = User::create([
    //         'name' => $validated['name'],
    //         'email' => $validated['email'],
    //         'password' => Hash::make($validated['password']),
    //         'role' => $validated['role'],
    //     ]);

    //     $token = $user->createToken('API Token')->plainTextToken;

    //     return response()->json([
    //         'message' => 'User registered successfully',
    //         'user' => $user,
    //         'token' => $token,
    //     ], 201);
    // }

    // public function login(Request $request)
    // {
    //     Log::info('Login request received', $request->all());

    //     $validateUser = Validator::make($request->all(), [
    //         'email' => "required|string|email",
    //         'password' => "required|string",
    //     ]);

    //     if ($validateUser->fails()) {
    //         return response()->json([
    //             'message' => 'Validation failed',
    //             'errors' => $validateUser->errors()
    //         ], 422);
    //     }

    //     if (!auth()->attempt($request->only('email', 'password'))) {
    //         return response()->json([
    //             'message' => 'Invalid credentials',
    //         ], 401);
    //     }

    //     $user = User::where('email', $request->email)->first();

    //     $user->tokens()->delete();

    //     $token = $user->createToken('API Token')->plainTextToken;

    //     Log::info('Generated new token:', ['token' => $token]);

    //     return response()->json([
    //         'user' => [
    //             'id' => $user->id,
    //             'name' => $user->name,
    //             'email' => $user->email,
    //             'role' => $user->role,
    //         ],
    //         'token' => $token,
    //     ], 200);
    // }

    public function getUser(Request $request)
    {
       $user = auth()->user();

       return response()->json($user);
    }
}
