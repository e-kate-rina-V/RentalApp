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

        $overlappingReservations = Reservation::where('ad_id', $validated['ad_id'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('arrival_date', [$validated['arrival_date'], $validated['depart_date']])
                    ->orWhereBetween('depart_date', [$validated['arrival_date'], $validated['depart_date']])
                    ->orWhere(function ($query) use ($validated) {
                        $query->where('arrival_date', '<=', $validated['arrival_date'])
                            ->where('depart_date', '>=', $validated['depart_date']);
                    });
            })
            ->exists();

        if ($overlappingReservations) {
            return response()->json(['error' => 'The selected dates are unavailable'], 422);
        }

        try {
            $reservation = Reservation::create($validated);

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

    public function getUnavailableDates($adId): JsonResponse
    {
        try {
            $reservations = Reservation::where('ad_id', $adId)
                ->select('arrival_date', 'depart_date')
                ->get();

            return response()->json($reservations);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch unavailable dates',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
