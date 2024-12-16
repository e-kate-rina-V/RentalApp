<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReviewRequest;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function createReview(CreateReviewRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $userId = auth()->id();

        $review = new Review();
        $review->fill([
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

        $review->save();

        return response()->json(['message' => 'Отзыв успешно отправлен', 'review' => $review], 201);
    }

    public function showReviews(int $adId): JsonResponse
    {
        $reviews = Review::where('ad_id', $adId)->get();

        if ($reviews->isEmpty()) {
            return response()->json(['message' => 'Отзывов для этого объявления не найдено'], 404);
        }

        return response()->json($reviews, 200);
    }
}
