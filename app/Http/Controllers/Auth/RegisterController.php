<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = new User();
        
        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
        ]);

        $user->assignRole($request->role);
        $user->save();


        $verificationUrl = URL::signedRoute('verification.verify', [
            'id' => $user->getKey(),
            'hash' => sha1($user->email),
        ]);

        Mail::to($user->email)->send(new EmailVerification($verificationUrl));

        return response()->json([
            'message' => 'Registration successful. Verification email sent.',
            'user' => $user,
        ], 201);
    }


    use RegistersUsers;

    protected string $redirectTo = '/home';


    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
