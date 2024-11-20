<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        try {
            $validated = Validator::make($input, [
                'name' => 'required|string|min:2|max:20',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'string', 'min:8', 'confirmed',  Password::defaults()],
                'role' => 'required|in:renter,landlord',
            ], [
                'name.required' => 'The "name" field is required.',
                'email.required' => 'The "email" field is required.',
                'email.unique' => 'Email already registered.',
                'password.required' => 'The "password" field is required.',
                'password.confirmed' => 'The passwords do not match.',
            ])->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors(),
            ], 422);
        }

        return User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);
    }
}
