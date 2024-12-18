<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function createReview(CreateReviewRequest $request): JsonResponse
    {
        $userId = auth()->id();

        $data = [
            'user_id' => $userId,
            'ad_id' => $request->input('adId'),
            'cleanliness' => $request->input('ratings.cleanliness'),
            'staff_work' => $request->input('ratings.staffWork'),
            'location' => $request->input('ratings.location'),
            'value_for_money' => $request->input('ratings.valueForMoney'),
            'positive' => $request->input('reviews.positive'),
            'negative' => $request->input('reviews.negative'),
            'comment' => $request->input('reviews.comment'),
            'average_rating' => $request->input('averageRating'),
        ];

        $review = new Review();
        $review->fill(array_filter($data, fn($value) => $value !== null));
        $review->save();

        return response()->json(['message' => 'Відгук успішно надіслано', 'review' => new ReviewResource($review)], 201);
    }


    public function showReviews(int $adId): JsonResponse
    {
        $reviews = Review::where('ad_id', $adId)->get();

        if ($reviews->isEmpty()) {
            return response()->json(['message' => 'Відгуки для цього оголошення відсутні'], 404);
        }

        return response()->json(ReviewResource::collection($reviews), 200);
    }
}
