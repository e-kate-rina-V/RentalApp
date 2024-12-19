<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    protected ReviewService $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function createReview(CreateReviewRequest $request): JsonResponse
    {
        $userId = auth()->id();

        $data = $this->reviewService->prepareReviewData($request, $userId);

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

        return response()->json(ReviewResource::collection($reviews));
    }
}
