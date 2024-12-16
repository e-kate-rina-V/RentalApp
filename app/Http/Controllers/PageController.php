<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function getUser()
    {
        if (auth()->check()) {
            return response()->json(auth()->user());
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function home()
    {
        return view('mainpage');
    }

    public function adminLogin()
    {
        return view('auth.login');
    }
}
