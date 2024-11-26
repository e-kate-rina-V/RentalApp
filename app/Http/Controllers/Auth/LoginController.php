<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Валидация входных данных
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Если есть ошибки валидации
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Пытаемся аутентифицировать пользователя
        if (Auth::attempt($request->only('email', 'password'))) {
            // Если аутентификация прошла успешно
            return response()->json([
                'message' => 'Login successful',
                'user' => Auth::user()
            ]);
        }

        // Если аутентификация не удалась
        return response()->json(['error' => 'Invalid credentials'], 401);
    }


    public function logout(Request $request)
    {
        Auth::logout();  
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
