<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

use App\Mail\ReservationConfirmed;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'arrival_date' => 'required|date',
            'depart_date' => 'required|date|after:arrival_date',
            'nights_num' => 'required|integer|min:1',
            'guestAdultCount' => 'required|integer|min:1',
            'guestChildrenCount' => 'nullable|integer|min:0',
            'guestBabyCount' => 'nullable|integer|min:0',
            'guestPets' => 'nullable|integer|min:0',
            'ad_id' => 'required|exists:ads,id',
            'total_cost' => 'required|numeric|min:0',
        ]);

        $validated['user_id'] = auth()->id();

        $validated['status'] = 'confirmed';

        try {
            $reservation = Reservation::with(['user', 'ad'])->create($validated);

            Mail::to(auth()->user()->email)->send(new ReservationConfirmed($reservation));

            Log::info('Mail sent successfully to: ' . auth()->user()->email);

            return response()->json([
                'message' => 'Reservation created successfully',
                'reservation' => $reservation,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating reservation: ' . $e->getMessage());

            return response()->json([
                'error' => 'Failed to create reservation',
            ], 500);
        }
    }
}
