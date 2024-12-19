<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Http\Request;

use App\Mail\ReservationConfirmed;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    public function createReservation(CreateReservationRequest $request): JsonResponse
    {
        $validated = $request->validated();

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

        $reservation = Reservation::create($validated);

        Mail::to(auth()->user()->email)->send(new ReservationConfirmed($reservation));

        Log::info('Mail sent successfully to: ' . auth()->user()->email);

        return response()->json([
            'message' => 'Reservation created successfully',
            'reservation' => new ReservationResource($reservation),
        ], 201);
    }

    public function getUnavailableDates($adId): JsonResponse
    {
        $reservations = Reservation::where('ad_id', $adId)
            ->select('arrival_date', 'depart_date')
            ->get();

        if ($reservations->isEmpty()) {
            return response()->json(['message' => 'No unavailable dates found'], 404);
        }

        return response()->json($reservations);
    }
}
