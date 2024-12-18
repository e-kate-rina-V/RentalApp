<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminAdUpdateRequest;
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
        $users = User::getList();

        return view('admin.ads.edit', compact('ad', 'users'));
    }

    public function update(AdminAdUpdateRequest $request, Ad $ad)
    {
        $ad->update($request->validated());

        return redirect()->route('ads.index')->with('success', 'Оголошення успішно оновлено!');
    }

    public function destroy(Ad $ad)
    {
        $ad->delete();

        return redirect()->route('ads.index')->with('success', 'Оголошення успішно видалено!');
    }
}
