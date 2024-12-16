<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminReservationUpdateRequest;
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

    public function edit(Reservation $reservation)
    {
        $ads = Ad::getList();
        $users = User::getList();

        return view('admin.reservations.edit', compact('reservation', 'ads', 'users'));
    }

    public function update(AdminReservationUpdateRequest $request, Reservation $reservation)
    {
        $reservation->update([
            'ad_id' => $request->ad_id,
            'user_email' => $request->user_email,
            'user_id' => $request->user_id,
            'arrival_date' => $request->arrival_date,
            'depart_date' => $request->depart_date,
            'total_cost' => $request->total_cost,
        ]);

        return redirect()->route('reservations.index')->with('success', 'Бронювання успішно оновлено!');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'Бронювання успішно видалене!');
    }
}
