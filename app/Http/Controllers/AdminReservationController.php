<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;

class AdminReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('user', 'ad')->paginate(10); 
        return view('admin.reservations.index', compact('reservations'));
    }

    public function create()
    {
        // $ads = Ad::all();
        // $users = User::all();
        // return view('admin.reservations.create', compact('ads', 'users'));
    }

    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'ad_id' => 'required|exists:ads,id',
        //     'user_id' => 'required|exists:users,id',
        //     'start_date' => 'required|date',
        //     'end_date' => 'required|date',
        // ]);

        // Reservation::create($validated);

        // return redirect()->route('admin.reservations.index')->with('success', 'Резервация успешно создана!');
    }

    public function edit(Reservation $reservation)
    {
        $ads = Ad::all();
        $users = User::all();
        return view('admin.reservations.edit', compact('reservation', 'ads', 'users'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'ad_id' => 'required|exists:ads,id',
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $reservation->update($validated);

        return redirect()->route('admin.reservations.index')->with('success', 'Резервация успешно обновлена!');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('admin.reservations.index')->with('success', 'Резервация успешно удалена!');
    }
   
}
