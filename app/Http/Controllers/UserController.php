<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        // dd(Auth::user());

        // return view('users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userArr = [
            [
                'name' => 'Bob J',
                'email' => 'bobj@gmail.com',
                'password' => 'nacd',
                'role' => 'landlord',
            ],
            [
                'name' => 'John N',
                'email' => 'johnn@outlock.com',
                'password' => 'bgddx',
                'role' => 'renter',
            ],
            [
                'name' => 'Mary B',
                'email' => 'maryb@outlock.com',
                'password' => 'hbicn',
                'role' => 'renter',
            ],
            [
                'name' => 'David Y',
                'email' => 'davidy@gmail.com',
                'password' => 'indon',
                'role' => 'landlord',
            ],
            [
                'name' => 'Brain Z',
                'email' => 'brainz@yahoo.com',
                'password' => 'kmdpcxn',
                'role' => 'renter',
            ],
        ];
        foreach ($userArr as $item) {
            User::create($item);
        }
        dd('created');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:renter,landlord'
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']);
        $user->role = $validatedData['role'];
        $user->save();

        return response()->json(['message' => 'User created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Request $request)
    {
        // return Storage::download('test.txt', 'palmo.txt');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
