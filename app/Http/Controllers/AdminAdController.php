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

    public function edit(Ad $ad)
    {
        $users = User::all();

        return view('admin.ads.edit', compact('ad', 'users'));
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
            'user_email' => 'required|exists:users,email',
        ]);

        $ad->update($validated);

        return redirect()->route('ads.index')->with('success', 'Оголошення успішно оновлено!');
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();
        return redirect()->route('ads.index')->with('success', 'Оголошення успішно видалено!');
    }
}
