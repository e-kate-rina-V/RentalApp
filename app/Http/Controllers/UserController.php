<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser(Request $request): JsonResponse
    {
        $user = auth()->user();

        return response()->json($user);
    }

    public function showUser($user_id): JsonResponse
    {
        $user = User::find($user_id);

        if ($user) {
            return response()->json($user);
        }

        return response()->json(['message' => 'User not found'], 404);
    }
}

