<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Http\Request;

class AdminAdController extends Controller
{
    public function index()
    {
        $ads = Ad::with('user')->paginate(10);
        return view('admin.ads.index', compact('ads'));
    }

    public function create()
    {
        // $users = User::all(); 
        // return view('admin.ads.create', compact('users'));
    }

    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'title' => 'required|string|max:255',
        //     'prem_type' => 'required|string',
        //     'accom_type' => 'required|string',
        //     'guest_count' => 'required|integer|min:1',
        //     'description' => 'required|string',
        //     'price' => 'required|numeric|min:0',
        //     'user_id' => 'required|exists:users,id',
        // ]);

        // Ad::create($validated);

        // return redirect()->route('admin.ads.index')->with('success', 'Объявление успешно создано!');
    }

    public function edit(Ad $ad)
    {
        $users = User::all();

        dd(route('admin.ads.update', $ad->id));
         
        // return view('admin.ads.edit', compact('ad', 'users'));
    }

    public function update(Request $request, Ad $ad)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'prem_type' => 'required|string',
            'accom_type' => 'required|string',
            'guest_count' => 'required|integer|min:1',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
        ]);

        $ad->update($validated);

        return redirect()->route('admin.ads.index')->with('success', 'Объявление успешно обновлено!');
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();
        return redirect()->route('admin.ads.index')->with('success', 'Объявление успешно удалено!');
    }
}
