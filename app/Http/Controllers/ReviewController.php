<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'adId' => 'required|integer|exists:ads,id',
            'ratings.cleanliness' => 'required|integer|min:0|max:5',
            'ratings.staffWork' => 'required|integer|min:0|max:5',
            'ratings.location' => 'required|integer|min:0|max:5',
            'ratings.valueForMoney' => 'required|integer|min:0|max:5',
            'reviews.positive' => 'nullable|string|max:500',
            'reviews.negative' => 'nullable|string|max:500',
            'reviews.comment' => 'nullable|string|max:1000',
            'averageRating' => 'required|numeric|min:0|max:5',
        ]);

        $userId = auth()->id();

        $review = Review::create([
            'user_id' => $userId,
            'ad_id' => $validated['adId'],
            'cleanliness' => $validated['ratings']['cleanliness'],
            'staff_work' => $validated['ratings']['staffWork'],
            'location' => $validated['ratings']['location'],
            'value_for_money' => $validated['ratings']['valueForMoney'],
            'positive' => $validated['reviews']['positive'] ?? null,
            'negative' => $validated['reviews']['negative'] ?? null,
            'comment' => $validated['reviews']['comment'] ?? null,
            'average_rating' => $validated['averageRating'],
        ]);
        return response()->json(['message' => 'Review submitted successfully', 'review' => $review], 201);
    }

    public function show(Request $request, int $adId): JsonResponse
    {
        $reviews = Review::where('ad_id', $adId)->get();

        if ($reviews->isEmpty()) {
            return response()->json(['message' => 'No reviews found for this ad'], 404);
        }

        return response()->json($reviews, 200);
    }
}
